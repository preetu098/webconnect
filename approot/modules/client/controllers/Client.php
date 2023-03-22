<?php
defined('BASEPATH') or exit('No direct script access allowed');
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Client extends MY_Controller
{
    public function __construct()
    {
        Parent::__construct();
        $this->load->model('employeeModel');
    }

    public function index()
    {
        $data = [];
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));

            //$data = $this->qm->single("ri_clients_tbl","*", "username= '".$username."' && password='".$password."' && cid = '".$cid."'");
            $data = $this->qm->single("ri_clients_tbl", "*", "username= '" . $username . "' && password='" . $password . "'");

            //$session['']
            if ($data->cid > 0) {
                $this->session->set_userdata('cid', $data->cid);
                $this->session->set_userdata('cname', $data->cname);

                if (!empty($this->session->userdata('cid'))) {

                    $where = array('cid' => $data->cid);

                    $upd = $this->qm->update('ri_clients_tbl', ['last_login' => date('Y-m-d H:i:s')], $where);

                    redirect("client/dashboard");
                } else {
                    $this->session->set_flashdata('error', 'Due to technical problem, you are unable to login');
                    redirect("client/index/");
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid User ID or Password');
                redirect("client/index/");
            }
        }
        // $data['cid'] = $cid;

        $this->load->view('client/index', $data);
    }

    public function forgetpass()
    {
        //print_r($_POST);
        if ($this->input->post()) {
            $chek = $this->qm->single("ri_clients_tbl", "*", array('username' => $this->input->post('username'), 'email' => $this->input->post('regname')));
            //print_r($chek);die;
            if ($chek->cid) {
                $message = "Hello " . $chek->cname . ",";

                $message .= "<p>There was a recent request to change the password of your account for the Portal Wellconnect account associated with " . $chek->email . ".</p>";

                $message .= "<p>No changes have been made to your account yet.</p>";

                $message .= "<p>You can reset your password by clicking the link below:</p>";

                $message .= "<a href='" . base_url('client/chngpass/' . $chek->cid) . "'>Reset Password</a>";

                $message .= "<p>If you did not request a new password, please ignore this mail.</p>";

                $message .= "<p>Yours,</p>";

                $message .= "<p>The Wellconnect Team</p>";

                //send_smtp_mail("manoj2karn@gmail.com", $chek->email, "Change Password for wellconnect portal", $message);
                send_smtp_mail("wellconnect@riskbirbal.com", $chek->email, "Change Password for wellconnect portal", $message);
                echo "<script>alert('Password reset link is sent at your registered email, Please change your password from there!');window.location='" . base_url('client/index') . "';</script>";
            } else {
                echo "<script>alert('Please check the username and Registered Email, The data provided is not matching');window.location='" . base_url('client/forgetpass') . "';</script>";
            }
        }

        $this->load->view('client/forgetpass', $data);
    }

    public function chngpass($cid)
    {
        if ($this->input->post()) {
            if ($this->input->post('reenterpass') == $this->input->post('pass')) {
                $this->qm->update("ri_clients_tbl", array('password' => md5($this->input->post('pass'))), array('cid' => $cid));
                echo "<script>alert('Password changed successfully, Please login to continue!!');window.location='" . base_url('client/') . "'</script>";
            } else {
                echo "<script>alert('Password and Confirm password is not matching, Please try again');window.location='" . base_url('client/chngpass/' . $cid) . "'</script>";
            }
        }
        $this->load->view('client/resetpass', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata('cid');
        redirect('client/index/');
    }

    public function profile()
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {

            $data['cid'] = $this->session->userdata('cid');
            $data['mainContent'] = "client/profile";
            $this->load->view('cpanel', $data);
        }
    }

    public function dashboard($pid = null)
    {
        
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            $data['result'] = $this->qm->all("ri_clientpolicy_tbl", "*", array('cid' => $cid));
            $data['mainContent'] = "client/dashboard";
            $this->load->view('cpanel', $data);
            $cid = $this->session->userdata('cid');

            $data['cid'] = $cid;
            if ($pid != null) {
                $data['pid'] = $pid;
            }

            if ($this->input->post()) {
                $check = $this->input->post('eid');
                if (!empty($check)) {
                    for ($x = 0; $x < count($check); $x++) {
                        if ($this->input->post('approve') == '1') {
                            $this->qm->update("ri_employee_tbl", array('status' => '2', 'hr_approval_date' => date('Y-m-d H:i:s')), array('eid' => $check[$x]));
                        } else {
                            $empData = $this->qm->single('ri_employee_tbl', '*', ['eid' => $check[$x]]);
                            if ($empData->mode == 'New Addition' || $empData->mode == 'New Registration') {
                                $this->qm->update("ri_employee_tbl", array('status' => '4', 'hr_approval_date' => date('Y-m-d H:i:s')), array('eid' => $check[$x]));
                            } else {
                                $this->employeeModel->revertEmployeeVersion($check[$x], 'emp');
                            }
                        }
                    }
                }
                $checkDid = $this->input->post('did');
                if (!empty($checkDid)) {
                    for ($x = 0; $x < count($checkDid); $x++) {
                        if ($this->input->post('approve') == '1') {
                            $this->qm->update("ri_dependent_tbl", array('status' => '2', 'hr_approval_date' => date('Y-m-d H:i:s')), array('did' => $checkDid[$x]));
                        } else {
                            $empData = $this->qm->single('ri_dependent_tbl', '*', ['did' => $checkDid[$x]]);
                            if ($empData->mode == 'New Addition' || $empData->mode == 'New Registration') {
                                $this->qm->update("ri_dependent_tbl", array('status' => '4', 'hr_approval_date' => date('Y-m-d H:i:s')), array('did' => $checkDid[$x]));
                            } else {
                                $this->employeeModel->revertEmployeeVersion($checkDid[$x], 'dep');
                            }
                        }
                    }
                }

                if (empty($pid)) {
                    $pid = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid))->id;
                }
                if ($this->input->post('approve') == '1') {
                    redirect("client/endorsement/$pid");
                }
            }

            
        }
    }

    public function dashboard1($cid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {

            $data['cid'] = $this->session->userdata('cid');

            $data['mainContent'] = "client/dashboard_123";
            $this->load->view('cpanel', $data);
        }
    }

    public function policies($cid, $pid = null)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {

            $data['cid'] = $this->session->userdata('cid');
            if ($pid != null) {
                $data['pid'] = $pid;
            }

            $data['mainContent'] = "client/policies";
            $this->load->view('cpanel', $data);
        }
    }

    public function managepolicies($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {

            $data['cid'] = $this->session->userdata('cid');
            $data['pid'] = $pid;

            $data['mainContent'] = "client/managepolicies";
            $this->load->view('cpanel', $data);
        }
    }

    public function employees($pid, $def = '10')
    {

        /*$cond = array('cid'=>$cid,'pid'=>$pid);
        if($this->input->post())
        {
            if(!empty($this->input->post('empid')))
            {
                $cond['emp_id']=$this->input->post('empid');
            }
             if(!empty($this->input->post('emp_name')))
            {
                $cond['emp_name']=$this->input->post('emp_name');
            }
        }*/
        $cid = $this->session->userdata('cid');

        $cond = " cid='$cid' && pid='$pid' && status=1";

        if (!empty($this->input->post('empid'))) {
            $findemp = explode(",", $this->input->post('empid'));
            $test .= " && (";
            for ($x = 0; $x < count($findemp); $x++) {
                $test .= " emp_id='$findemp[$x]' || ";
            }
            $cond .= substr($test, 0, -3);
            $cond .= ")";
        }

        if (!empty($this->input->post('emp_name'))) {
            $cond .= " && emp_name like '%" . $this->input->post('emp_name') . "%' ";
        }

        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {

            $this->load->library("pagination");
            $emp = $this->qm->all('ri_employee_tbl', '*', $cond);
            $data['cid'] = $cid;
            $data['pid'] = $pid;

            $config = array();
            $config["base_url"] = base_url('client/employees/' . $pid . '/' . $def);
            $config["total_rows"] = count($emp);
            $config["per_page"] = 10;

            $this->pagination->initialize($config);

            $page = ($def > 10) ? $def : 0;

            $data["links"] = $this->pagination->create_links();

            //$data['emp'] = $this->authors_model->get_authors($config["per_page"], $page);
            $data['emp'] = $this->qm->all('ri_employee_tbl', '*', $cond, '', 'both', '', '', 'ASC', $config["per_page"], $page);

            $data['mainContent'] = "client/employees";
            $this->load->view('cpanel', $data);
        }
    }

    public function uploademployee($pid)
    {
        $cid = $this->session->userdata('cid');
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['mainContent'] = "client/uploademployee";
            $this->load->view('cpanel', $data);
        }
    }

    public function addemployee($pid, $eid = null)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            if (!empty($eid)) {
                $empRec = $this->qm->single('ri_employee_tbl', "*", ['eid' => $eid]);
                if ($empRec && ($empRec->mode == 'Correction' || $empRec->mode == 'Deletion' || $empRec->mode == 'Insert')) {
                    redirect(base_url() . 'client/updself/' . $pid . '/' . $eid);
                }
            }
            $data['cid'] = $this->session->userdata('cid');
            $data['pid'] = $pid;
            if ($eid != null) {
                $data['eid'] = $eid;
            }
            $data['mainContent'] = "client/addemployee";
            $this->load->view('cpanel', $data);
        }
    }

    public function addemp($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }

        $cid = $this->session->userdata('cid');
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $eid = $this->input->post('eid');
        $annualPremium = 0;
        $totalPremium = 0;

        $existingEmp = $this->qm->all('ri_employee_tbl', '*', array('eid' => $eid));
        $check = count($existingEmp);

        $clientPolicyDate = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
        $endorsmentCalculations = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
        
        // TODO
        // $newAge = $this->getAge($post['dob']);

        if ($check == 0) {
            $suminsurede = $post['sum_insured'];
            $doj =  $post['doj'];
            // Days
            $datediff = $this->getPremiumDays($doj, $clientPolicyDate->edate);
            // sumInsured data
            $suminsuredId = $this->getPolicySuminsuredData($suminsurede, $cid, $pid);
            // age band data
            $agebandId = $this->getPolicyAgebandData($post['age'], $cid, $pid);
            // annual premium data
            $annualPremium = $this->getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid);
            if ($endorsmentCalculations->basis_of_calculation == "short_period_scale") {
                // Get Short Period Scales
                $shortPeriodScales = $this->getShortPeriodScalesData($datediff, $cid, $pid);
                $totalPremium = $this->shortPeriodScaleData($shortPeriodScales, $annualPremium);
            } else if ($endorsmentCalculations->basis_of_calculation == "pro_rata_basis") {
                // Get pro rata basis
                $totalPremium = $this->proRataBasisData($datediff, $clientPolicyDate->sdate, $clientPolicyDate->edate, $annualPremium);
            }

            $post['covered_days'] = $datediff;
            $post['annual_premium'] = $annualPremium;
            $post['premium'] = $totalPremium;

            $ins = $this->employeeModel->addEmployee($post);
            if ($ins) {
                $this->session->set_flashdata('success', 'Added Successfully');
                redirect('client/addemployee/' . $pid . '/' . $ins);
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('client/addemployee/' . $pid);
            }
        } else {
            $suminsurede = $existingEmp[0]->sum_insured;
            $doj = $existingEmp[0]->doj;
            // Days
            $datediff = $this->getPremiumDays($doj, $clientPolicyDate->edate);
            // sumInsured data
            $suminsuredId = $this->getPolicySuminsuredData($suminsurede, $cid, $pid);
            // age band data
            $agebandId = $this->getPolicyAgebandData($post['age'], $cid, $pid);
            // annual premium data
            $annualPremium = $this->getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid);
            if ($endorsmentCalculations->basis_of_calculation == "short_period_scale") {
                // Get Short Period Scales
                $shortPeriodScales = $this->getShortPeriodScalesData($datediff, $cid, $pid);
                $totalPremium = $this->shortPeriodScaleData($shortPeriodScales, $annualPremium);
            } else if ($endorsmentCalculations->basis_of_calculation == "pro_rata_basis") {
                // Get pro rata basis
                $totalPremium = $this->proRataBasisData($datediff, $clientPolicyDate->sdate, $clientPolicyDate->edate, $annualPremium);
            }
            $post['covered_days'] = $datediff;
            $post['annual_premium'] = $annualPremium;
            $post['premium'] = $totalPremium;
            $post['previous_premium'] = $existingEmp[0]->premium;
            $this->employeeModel->addEmployeeVersion($existingEmp[0], 'emp');
            $upd = $this->employeeModel->updateEmployee($post);
            if ($upd) {
                $this->session->set_flashdata('success', 'Updated Successfully');
                redirect('client/addemployee/' . $pid . '/' . $eid);
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('client/addemployee/' . $pid . '/' . $eid);
            }
        }
    }

    public function adddep($pid, $eid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }

        $cid = $this->session->userdata('cid');
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['eid'] = $eid;
        $did = $this->input->post('did');

        $existingDep = $this->qm->all('ri_dependent_tbl', '*', array('did' => $did));
        $check = count($existingDep);

        if ($check == 0) {
            $ins = $this->employeeModel->addDependent($eid, $post);
            if ($ins) {
                $this->session->set_flashdata('success', 'Added Successfully');
                redirect('client/addemployee/' . $pid . '/' . $eid);
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('client/addemployee/' . $pid . '/' . $eid);
            }
        } else {
            $this->employeeModel->addEmployeeVersion($existingDep[0], 'dep');
            $upd = $this->employeeModel->updateDependent($eid, $post);
            if ($upd) {
                $this->session->set_flashdata('success', 'Updated Successfully');
                redirect('client/addemployee/' . $pid . '/' . $eid);
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('client/addemployee/' . $pid . '/' . $eid);
            }
        }
    }

    public function updprofile()
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');
        $post = $this->input->post();
        if (!empty($_FILES['image']['name'])) {

            $data =  $this->qm->upload('./external/uploads/', 'image');
        } else {
            $cl = $this->qm->all('ri_clients_tbl', '*', array('cid' => $cid));
            foreach ($cl as $cl);

            $data = $cl->image;
        }

        $post['image'] = $data;

        $where = array(
            'cid' => $cid,
        );

        $upd = $this->qm->update('ri_clients_tbl', $post, $where);
        if ($upd) {

            $this->session->set_flashdata('upd', 'Updated Successfully');
            redirect('client/profile/');
        } else {
            $this->session->set_flashdata('upde', 'Updation Failed');
            redirect('client/profile/');
        }
    }

    public function chnpass($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');
        $opass = md5($this->input->post('opass'));
        $newpass = $this->input->post('npass');
        $cpass = $this->input->post('cpass');


        if ($newpass == $cpass) {


            $check = $this->qm->all("ri_clients_tbl", "*", array('password' => $opass));

            if ($check) {

                $npass = md5($newpass);
                $data = array(
                    'password' => $npass,
                );
                if ($pid != null) {
                    $data['pid'] = $pid;
                }
                $where = array(
                    'cid' => $cid,
                );
                $upd = $this->qm->update("ri_clients_tbl", $data, $where);

                if ($upd) {

                    $this->session->set_flashdata('chnpass', 'Updated Successfully');
                    redirect('client/profile/');
                } else {
                    $this->session->set_flashdata('echnpass', 'Updation Failed');
                    redirect('client/profile/');
                }
            }
        } else {
            $this->session->set_flashdata('notequal', 'New Password and Confirm Password Is No Equal');
            redirect('client/profile/');
        }
    }

    public function uploademp($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');

        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['efile']['name']) && in_array($_FILES['efile']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['efile']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['efile']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $duplicateEmpIds = [];

            if (!empty($sheetData)) {
                //$test =array();

                // client policy date (Start End)
                $clientPolicyDate = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
                // endorsment calculation
                $endorsmentCalculations = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));

                //employees
                $startUpload = false;
                for ($i = 0; $i < count($sheetData); $i++) {

                    if ($sheetData[$i][0] == 'Emp Id') {
                        $startUpload = true;
                        continue;
                    }

                    if (!$startUpload) {
                        continue;
                    }

                    $emp_id = $sheetData[$i][0];
                    $emp_name = $sheetData[$i][1];
                    $name = $sheetData[$i][2];
                    $email = $sheetData[$i][3];
                    $mobile = $sheetData[$i][4];
                    $relation = $sheetData[$i][5];
                    $gender = $sheetData[$i][7];
                    $wedd_date = $sheetData[$i][8];
                    $dob = $sheetData[$i][9];
                    $age = $sheetData[$i][10];
                    $suminsurede = $sheetData[$i][12];
                    $reason = $sheetData[$i][14];
                    $doj = $sheetData[$i][13];
                    $mode = 'New Addition';
                    $status = 3;
                    $annualPremium = 0;
                    $totalPremium = 0;
                    // TODO
                    // $newAge = $this->getAge($dob);

                    // Days
                    $datediff = $this->getPremiumDays($doj, $clientPolicyDate->edate);
                    // sumInsured data
                    $suminsuredId = $this->getPolicySuminsuredData($suminsurede, $cid, $pid);
                    // age band data
                    $agebandId = $this->getPolicyAgebandData($age, $cid, $pid);
                    // annual premium data
                    $annualPremium = $this->getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid);
                    if ($endorsmentCalculations->basis_of_calculation == "short_period_scale") {
                        // Get Short Period Scales
                        $shortPeriodScales = $this->getShortPeriodScalesData($datediff, $cid, $pid);
                        $totalPremium = $this->shortPeriodScaleData($shortPeriodScales, $annualPremium);
                    } else if ($endorsmentCalculations->basis_of_calculation == "pro_rata_basis") {
                        // Get pro rata basis
                        $totalPremium = $this->proRataBasisData($datediff, $clientPolicyDate->sdate, $clientPolicyDate->edate, $annualPremium);
                    }

                    if (($relation) == "Self") {
                        $cPolicy = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid));

                        $username = (!empty($cPolicy)) ? $cPolicy->ccode . '-' . $emp_id : $emp_id;
                        $password = $username;

                        $dataa = array(
                            'cid' => $cid,
                            'pid' => $pid,
                            'client_code' => (!empty($cPolicy)) ? $cPolicy->ccode : '',
                            'client_name' => (!empty($cPolicy)) ? $cPolicy->cname : '',
                            'data_type' => '',
                            'emp_id' => $emp_id,
                            'username' => $username,
                            'password' => $password,
                            'emp_name' => $emp_name,
                            'name' => $emp_name,
                            'email' => $email,
                            'mobile' => $mobile,
                            'relation' => $relation,
                            'sum_insured' => $suminsurede,
                            'doj' => (!empty($doj)) ? date("Y-m-d", strtotime($doj)) : NULL,
                            'gender' => $gender,
                            'wedd_date' => date("Y-m-d", strtotime($wedd_date)),
                            'dob' => date("Y-m-d", strtotime($dob)),
                            'age' => $age,
                            'premium' => $totalPremium,
                            'annual_premium' => $annualPremium,
                            'covered_days' => $datediff,
                            'reson' => $reason,
                            'mode' => $mode,
                            'status' => $status,
                        );

                        $dup = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'emp_id' => $emp_id, 'relation' => $relation));
                        if (count($dup) > 0) {
                            continue;
                        }
                        $ins = $this->qm->insert('ri_employee_tbl', $dataa);
                    }
                }

                //dependents
                $startUpload = false;
                for ($i = 0; $i < count($sheetData); $i++) {

                    if ($sheetData[$i][0] == 'Emp Id') {
                        $startUpload = true;
                        continue;
                    }

                    if (!$startUpload) {
                        continue;
                    }

                    if ($sheetData[$i][5] == 'Kid0' || $sheetData[$i][5] == 'Kid1' || $sheetData[$i][5] == 'Kid2' || $sheetData[$i][5] == 'Kid3') {
                        $sheetData[$i][5] == 'Kid';
                    }
                    $emp_id = $sheetData[$i][0];
                    $emp_name = $sheetData[$i][1];
                    $name = $sheetData[$i][2];
                    $email = $sheetData[$i][3];
                    $mobile = $sheetData[$i][4];
                    $relation = $sheetData[$i][5];
                    $kidnumber = $sheetData[$i][6];
                    $gender = $sheetData[$i][7];
                    $wedd_date = $sheetData[$i][8];
                    $dob = $sheetData[$i][9];
                    $age = $sheetData[$i][10];
                    $reason = $sheetData[$i][14];
                    $suminsurede = $sheetData[$i][12];
                    $doj = $sheetData[$i][13];
                    $mode = 'New Addition';
                    $status = 3;

                    if (($relation) != "Self") {
                        $ctt = $this->qm->single("ri_employee_tbl", "*", array('emp_id' => $emp_id, 'relation' => 'Self', 'cid' => $cid, 'pid' => $pid));

                        if ($ctt) {

                            $ddadta = array(
                                'cid' => $cid,
                                'pid' => $pid,
                                'eid' => ($ctt) ? $ctt->eid : NULL,
                                'emp_id' => $emp_id,
                                'reltype' => $relation,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $mobile,
                                'gender' => $gender,
                                'dob' => date("Y-m-d", strtotime($dob)),
                                'age' => $age,
                                'wedd_date' => date("Y-m-d", strtotime($wedd_date)),
                                'status' => '3', //new member status
                                'mode' => $mode,
                                'reson' => $reason,
                                'updated_on' => date('Y-m-d')
                            );

                            if ($relation != 'Kid') {
                                $dup = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'reltype' => $relation));
                                if (count($dup) > 0) {
                                    continue;
                                }
                            } else {
                                updateKidIndex($cid, $pid, $ctt->eid, $relation);
                                $dup = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'rel_index' => $kidnumber, 'reltype' => $relation));
                                if (count($dup) > 0) {
                                    continue;
                                }
                            }

                            $ins = $this->qm->insert('ri_dependent_tbl', $ddadta);
                            if ($relation == 'Kid') {
                                updateKidIndex($cid, $pid, $ctt->eid, $relation);
                            }
                        }
                    }
                }

                redirect('client/employees/' . $pid . '');
            } else {
                redirect('client/uploademployee/' . $pid . '');
            }
        }
    }

    public function updateupload($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['efile']['name']) && in_array($_FILES['efile']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['efile']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['efile']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            if (!empty($sheetData)) {

                $clientPolicyDate = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
                $endorsmentCalculations = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
                //employees
                $startUpload = false;
                for ($i = 0; $i < count($sheetData); $i++) {

                    if ($sheetData[$i][0] == 'Policy No') {
                        $startUpload = true;
                        continue;
                    }

                    if (!$startUpload) {
                        continue;
                    }

                    $data_type = $this->input->post('data_type');

                    $policy_num = $sheetData[$i][0];
                    $emp_id = $sheetData[$i][1];
                    $emp_name = $sheetData[$i][2];
                    $dependent_name = $sheetData[$i][3];
                    $relation = $sheetData[$i][4];
                    $rel_index = $sheetData[$i][5];
                    $gender = $sheetData[$i][6];
                    $dob = $sheetData[$i][7];
                    $age = $sheetData[$i][8];
                    $corrected_emp = $sheetData[$i][9];
                    $corrected_dependent_name = $sheetData[$i][10];
                    $corrected_relation = $sheetData[$i][11];
                    $corrected_gender = $sheetData[$i][12];
                    $corrected_dob = $sheetData[$i][13];
                    $corrected_age = $sheetData[$i][14];
                    $reason = $sheetData[$i][15];
                    $mode = 'Correction';
                    $status = 3;
                    $annualPremium = 0;
                    $totalPremium = 0;

                    // TODO
                    // $newAge = $this->getAge($corrected_dob);
                    // Get employee old data
                    $updateEmployeeData = $this->qm->single("ri_employee_tbl", "*", array('emp_id' => $emp_id, 'cid' => $cid, 'pid' => $pid));
                    if (empty($updateEmployeeData))
                        continue;
                    $suminsurede = $updateEmployeeData->sum_insured;
                    $doj = $updateEmployeeData->doj;

                    // Days
                    $datediff = $this->getPremiumDays($doj, $clientPolicyDate->edate);
                    // sumInsured data
                    $suminsuredId = $this->getPolicySuminsuredData($suminsurede, $cid, $pid);
                    // age band data
                    $agebandId = $this->getPolicyAgebandData($corrected_age, $cid, $pid);
                    // annual premium data
                    $annualPremium = $this->getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid);
                    if ($endorsmentCalculations->basis_of_calculation == "short_period_scale") {
                        // Get Short Period Scales
                        $shortPeriodScales = $this->getShortPeriodScalesData($datediff, $cid, $pid);
                        $totalPremium = $this->shortPeriodScaleData($shortPeriodScales, $annualPremium);
                    } else if ($endorsmentCalculations->basis_of_calculation == "pro_rata_basis") {
                        // Get pro rata basis
                        $totalPremium = $this->proRataBasisData($datediff, $clientPolicyDate->sdate, $clientPolicyDate->edate, $annualPremium);
                    }


                    if ($relation == "Self"  && $corrected_relation == 'Self') {
                        $check = $this->qm->all('ri_employee_tbl', '*', array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id));

                        if ($check > 0) {
                            $dataa = array(
                                'data_type' => $data_type,
                                'emp_name' => $corrected_emp,
                                'name' => $corrected_emp,
                                // 'relation' => $corrected_relation,
                                // 'emp_id' => $emp_id,
                                'gender' => $corrected_gender,
                                'dob' => date("Y-m-d", strtotime($corrected_dob)),
                                'age' => $age,
                                'premium' => $totalPremium,
                                'annual_premium' => $annualPremium,
                                'covered_days' => $datediff,
                                'previous_premium' => $updateEmployeeData->premium,
                                'reson' => $reason,
                                'mode' => $mode,
                                'status' => $status,
                            );

                            $this->employeeModel->addEmployeeVersion($check[0], 'emp');

                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id);
                            $this->qm->update('ri_employee_tbl', $dataa, $where);
                        }
                    }
                }

                //dependents
                $startUpload = false;
                for ($i = 0; $i < count($sheetData); $i++) {

                    if ($sheetData[$i][0] == 'Policy No') {
                        $startUpload = true;
                        continue;
                    }

                    if (!$startUpload) {
                        continue;
                    }

                    if ($sheetData[$i][4] == 'Kid0' || $sheetData[$i][4] == 'Kid1' || $sheetData[$i][4] == 'Kid2' || $sheetData[$i][4] == 'Kid3') {
                        $sheetData[$i][4] == 'Kid';
                    }

                    $data_type = $this->input->post('data_type');

                    $policy_num = $sheetData[$i][0];
                    $emp_id = $sheetData[$i][1];
                    $emp_name = $sheetData[$i][2];
                    $dependent_name = $sheetData[$i][3];
                    $relation = $sheetData[$i][4];
                    $rel_index = $sheetData[$i][5];
                    $gender = $sheetData[$i][6];
                    $dob = $sheetData[$i][7];
                    $age = $sheetData[$i][8];
                    $corrected_emp = $sheetData[$i][9];
                    $corrected_dependent_name = $sheetData[$i][10];
                    $corrected_relation = $sheetData[$i][11];
                    $corrected_gender = $sheetData[$i][12];
                    $corrected_dob = $sheetData[$i][13];
                    $corrected_age = $sheetData[$i][14];
                    $reason = $sheetData[$i][15];
                    $mode = 'Correction';
                    $status = 3;

                    if ($relation != "Self" && $corrected_relation != 'Self') {

                        $ctt = $this->qm->single("ri_employee_tbl", "*", array('emp_id' => $emp_id, 'cid' => $cid, 'pid' => $pid));

                        if ($ctt) {
                            $ddadta = array(
                                'name' => $corrected_dependent_name,
                                'reltype' => $corrected_relation,
                                // 'emp_id' => $emp_id,
                                'gender' => $corrected_gender,
                                'dob' => date("Y-m-d", strtotime($corrected_dob)),
                                'age' => $corrected_age,
                                'reson' => $reason,
                                'mode' => $mode,
                                'status' => $status,
                                'updated_on' => date('Y-m-d')
                            );

                            if ($relation != 'Kid') {
                                $dup = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'emp_id' => $emp_id, 'reltype' => $relation));
                                if (count($dup) > 0) {
                                    $this->employeeModel->addEmployeeVersion($dup[0], 'dep');
                                    $this->qm->update('ri_dependent_tbl', $ddadta, array('cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'reltype' => $relation));
                                    if ($corrected_relation == 'Kid') {
                                        updateKidIndex($cid, $pid, $ctt->eid, $relation);
                                    }
                                }
                            } else {
                                updateKidIndex($cid, $pid, $ctt->eid, $relation);

                                $dup = $this->qm->all('ri_dependent_tbl', '*', array('rel_index' => $rel_index, 'cid' => $cid, 'pid' => $pid, 'emp_id' => $emp_id, 'reltype' => $relation));

                                if (count($dup) > 0) {
                                    $this->employeeModel->addEmployeeVersion($dup[0], 'dep');
                                    $this->qm->update('ri_dependent_tbl', $ddadta, array('rel_index' => $rel_index, 'cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'reltype' => $relation));
                                }
                            }
                        }
                    }
                }
                redirect('client/employees/' . $pid . '');
            } else {
                redirect('client/uploademployee/' . $pid . '');
            }
        }
    }

    public function matchColoumn($arr, $rel_index)
    {
        $arr['rel_index'] = $rel_index;

        $data = $this->qm->single("ri_dependent_tbl", "*", array('emp_id' => $arr['emp_id'], 'reltype' => 'Kid', 'cid' => $arr['cid'], 'pid' => $arr['pid'], 'rel_index' => $rel_index));

        if ($data->rel_index == $arr['rel_index'] && $data->emp_id == $arr['emp_id'] && $data->card == $arr['card'] && $data->reltype == $arr['reltype'] && $data->name == $arr['name'] && $data->email == $arr['email'] && $data->phone == $arr['phone'] && $data->dob == $arr['dob'] && $data->gender == $arr['gender'] && $data->age == $arr['age'] && $data->wedd_date == $arr['wedd_date']  && $data->status == $arr['status'] && $data->mode == $arr['mode'] && $data->dol == $arr['dol'] && $data->reson == $arr['reson'] && $data->updated_on == $arr['updated_on']) {
            return TRUE . ', ';
        } else {
            return FALSE;
        }
    }

    public function deleteemp($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['efile']['name']) && in_array($_FILES['efile']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['efile']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['efile']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            if (!empty($sheetData)) {
                // client policy date (Start End)
                $clientPolicyDate = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
                // endorsment calculation
                $endorsmentCalculations = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));

                $startUpload = false;
                for ($i = 0; $i < count($sheetData); $i++) {

                    if ($sheetData[$i][0] == 'Emp Id') {
                        $startUpload = true;
                        continue;
                    }

                    if (!$startUpload) {
                        continue;
                    }

                    if ($sheetData[$i][3] == 'Kid0' || $sheetData[$i][3] == 'Kid1' || $sheetData[$i][3] == 'Kid2' || $sheetData[$i][3] == 'Kid3') {
                        $sheetData[$i][3] == 'Kid';
                    }

                    $data_type = $this->input->post('data_type');

                    $emp_id = $sheetData[$i][0];
                    $emp_name = $sheetData[$i][1];
                    $dependent_name = $sheetData[$i][2];
                    $relation = $sheetData[$i][3];
                    $rel_index = $sheetData[$i][4];
                    $policiy_num = $sheetData[$i][5];
                    $dol = $sheetData[$i][6];
                    $reason = $sheetData[$i][7];
                    $mode = 'Deletion';
                    $status = 3;
                    $annualPremium = 0;
                    $totalPremium = 0;

                    // Days
                    $datediff = $this->getPremiumDays($dol, $clientPolicyDate->sdate);

                    // Get employee old data
                    $updateEmployeeData = $this->qm->single("ri_employee_tbl", "*", array('emp_id' => $emp_id, 'cid' => $cid, 'pid' => $pid));
                    if (empty($updateEmployeeData))
                        continue;
                    $suminsurede = $updateEmployeeData->sum_insured;
                    $age = $updateEmployeeData->age;
                    $previous_premium = $updateEmployeeData->premium;
                    // sumInsured data
                    $suminsuredId = $this->getPolicySuminsuredData($suminsurede, $cid, $pid);
                    // age band data
                    $agebandId = $this->getPolicyAgebandData($age, $cid, $pid);
                    // annual premium data
                    $annualPremium = $this->getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid);
                    if ($endorsmentCalculations->basis_of_calculation == "short_period_scale") {
                        // Get Short Period Scales
                        $shortPeriodScales = $this->getShortPeriodScalesData($datediff, $cid, $pid);
                        // Leave short Period ScaleData
                        $totalPremium = $this->shortPeriodScaleData($shortPeriodScales, $annualPremium);
                    } else if ($endorsmentCalculations->basis_of_calculation == "pro_rata_basis") {
                        // Leave pro rata basis
                        $totalPremium = $this->proRataBasisData($datediff, $clientPolicyDate->sdate, $clientPolicyDate->edate, $annualPremium);
                    }

                    // $dataa
                    // ri_employee_tbl
                    // ri_dependent_tbl
                    $ri_employee_tbl = array(
                        'dol' => (!empty($dol)) ? date("Y-m-d", strtotime($this->dateFormat($dol))) : date('Y-m-d'),
                        'previous_premium' => $previous_premium,
                        'premium' => $totalPremium,
                        'reson' => $reason,
                        'mode' => $mode,
                        'status' => $status,
                    );

                    $ri_dependent_tbl = array(
                        'dol' => (!empty($dol)) ? date("Y-m-d", strtotime($this->dateFormat($dol))) : date('Y-m-d'),
                        'reson' => $reason,
                        'mode' => $mode,
                        'status' => $status,
                    );

                    if ($relation == "Self") {
                        $check = $this->qm->all('ri_employee_tbl', '*', array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id));
                        if (count($check) > 0) {
                            // delete employee
                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id);
                            $this->qm->update('ri_employee_tbl', $ri_employee_tbl, $where);

                            // add employee in ri_employee_updates_tbl
                            $this->employeeModel->addEmployeeVersion($check[0], 'emp');

                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id);
                            $depRecs = $this->qm->all('ri_dependent_tbl', '*', $where);

                            foreach ($depRecs as $dr) {
                                // add dependent in ri_employee_updates_tbl
                                $this->employeeModel->addEmployeeVersion($dr, 'dep');
                            }
                            // delete dependent
                            $this->qm->update('ri_dependent_tbl', $ri_dependent_tbl, $where);
                        }
                    } else {
                        if ($relation != "Kid") {
                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id, 'reltype' => $relation);
                            $check = $this->qm->all('ri_dependent_tbl', '*', $where);
                            if (count($check) > 0) {
                                $this->qm->update('ri_dependent_tbl', $ri_dependent_tbl, $where);
                                $this->employeeModel->addEmployeeVersion($check[0], 'dep');
                            }
                        } else {
                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id, 'reltype' => $relation, 'rel_index' => $rel_index);
                            $check = $this->qm->all('ri_dependent_tbl', '*', $where);
                            if (count($check) > 0) {
                                $this->qm->update('ri_dependent_tbl', $ri_dependent_tbl, $where);
                                foreach ($check as $dr) {
                                    // // delete dependent
                                    $this->employeeModel->addEmployeeVersion($dr, 'dep');
                                }
                            }
                        }
                    }
                }
                redirect('client/employees/' . $pid . '');
            } else {
                redirect('client/uploademployee/' . $pid . '');
            }
        }
    }

    public function uploadmember($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['efile']['name']) && in_array($_FILES['efile']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['efile']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['efile']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // echo "<pre>";
            //    print_r($sheetData);
            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $cid = $cid;
                    $pid = $pid;
                    $emp_id = $sheetData[$i][0];
                    $reltype = $sheetData[$i][1];
                    $name = $sheetData[$i][2];
                    $email = $sheetData[$i][3];
                    $phone = $sheetData[$i][4];
                    $gender = $sheetData[$i][5];
                    $dob = $sheetData[$i][6];
                    $age = $sheetData[$i][7];
                    $wedd_date = $sheetData[$i][8];
                    $status = 1;
                    $updated_on = date('Y-m-d');

                    $sel = $this->qm->all('ri_employee_tbl', '*', array('emp_id' => $emp_id));
                    foreach ($sel as $sel) {
                        $eid = $sel->eid;
                    }

                    $data = array(
                        'cid' => $cid,
                        'pid' => $pid,
                        'eid' => $eid,
                        'emp_id' => $emp_id,
                        'reltype' => $reltype,
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'gender' => $gender,
                        'dob' => date("Y-m-d", strtotime($dob)),
                        'age' => $age,
                        'wedd_date' => date("Y-m-d", strtotime($wedd_date)),
                        'status' => $status,
                        'updated_on' => $updated_on,

                    );

                    $ins = $this->qm->insert('ri_dependent_tbl', $data);
                }
                redirect('client/employees/' . $pid . '');
            } else {
                redirect('client/uploademployee/' . $pid . '');
            }
        }
    }

    public function updatemember($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');

        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['efile']['name']) && in_array($_FILES['efile']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['efile']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['efile']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // echo "<pre>";
            //    print_r($sheetData);
            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $cid = $cid;
                    $pid = $pid;
                    $emp_id = $sheetData[$i][0];
                    $reltype = $sheetData[$i][1];
                    $name = $sheetData[$i][2];
                    $email = $sheetData[$i][3];
                    $phone = $sheetData[$i][4];
                    $gender = $sheetData[$i][5];
                    $dob = $sheetData[$i][6];
                    $age = $sheetData[$i][7];
                    $wedd_date = $sheetData[$i][8];
                    $status = 1;
                    $updated_on = date('Y-m-d');

                    $sel = $this->qm->all('ri_employee_tbl', '*', array('emp_id' => $emp_id));
                    foreach ($sel as $sel) {
                        $eid = $sel->eid;
                    }

                    $data = array(
                        'cid' => $cid,
                        'pid' => $pid,
                        'eid' => $eid,
                        'emp_id' => $emp_id,
                        'reltype' => $reltype,
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'gender' => $gender,
                        'dob' => date("Y-m-d", strtotime($dob)),
                        'age' => $age,
                        'wedd_date' => date("Y-m-d", strtotime($wedd_date)),
                        'status' => $status,
                        'updated_on' => $updated_on,

                    );

                    $upd = $this->qm->update('ri_dependent_tbl', $data);
                }
                redirect('client/employees/' . $pid . '');
            } else {
                redirect('client/uploademployee/' . $pid . '');
            }
        }
    }

    public function deletemember($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');

        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['efile']['name']) && in_array($_FILES['efile']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['efile']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['efile']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            // echo "<pre>";
            //    print_r($sheetData);
            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $cid = $cid;
                    $pid = $pid;
                    $emp_id = $sheetData[$i][0];
                    $reltype = $sheetData[$i][1];
                    $name = $sheetData[$i][2];
                    $email = $sheetData[$i][3];
                    $phone = $sheetData[$i][4];
                    $gender = $sheetData[$i][5];
                    $dob = $sheetData[$i][6];
                    $age = $sheetData[$i][7];
                    $wedd_date = $sheetData[$i][8];
                    $status = 0;
                    $updated_on = date('Y-m-d');

                    // $sel = $this->qm->all('ri_employee_tbl','*',array('emp_id'=>$emp_id));
                    // foreach ($sel as $sel) {
                    //     $eid = $sel->eid;
                    // }

                    // $data= array(
                    //     'cid' => $cid,
                    //     'pid' => $pid,
                    //     'eid' => $eid,
                    //     'emp_id' => $emp_id,
                    //     'reltype' => $reltype,
                    //     'name' => $name,
                    //     'email' => $email,
                    //     'phone' => $phone,
                    //     'gender' => $gender,
                    //     'dob' => date("Y-m-d", strtotime($dob)),
                    //     'age' => $age,
                    //     'wedd_date' =>date("Y-m-d", strtotime($wedd_date)),
                    //     'status' => $status,
                    //     'updated_on' => $updated_on,

                    // );

                    $where = array('emp_id' => $emp_id);

                    $upd = $this->qm->delete('ri_dependent_tbl', $where);
                }
                redirect('client/employees/' . $pid . '');
            } else {
                redirect('client/uploademployee/' . $pid . '');
            }
        }
    }

    public function downloademp($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        }
        $cid = $cid = $this->session->userdata('cid');

        $users = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid));
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Policy No');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('B1', 'Policy Start Date');
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('C1', 'Policy End Date');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('D1', 'Corporate Name');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('E1', 'Card');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('F1', 'Emp Id');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('G1', 'Employee Name');
        $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('H1', 'Email');
        $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('H1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('I1', 'Phone');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('J1', 'Relation');
        $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('J1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('K1', 'Gender');
        $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('K1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('L1', 'DOB');
        $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('L1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('M1', 'Age');
        $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('M1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('N1', 'Sum Insured');
        $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('N1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('O1', 'DOJ[Date of Joining]');
        $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('O1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('P1', 'DOL[Date of Leaving]');
        $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('P1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('Q1', 'Created On');
        $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('R1', 'Deleted On');
        $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('R1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('S1', 'Wedd.Date');
        $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('S1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('T1', 'Mode');
        $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('T1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('U1', 'Status');
        $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('U1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $rows = 2;

        foreach ($users as $val) {

            $pol = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid));

            $sheet->setCellValue('A' . $rows, $pol->policy_num);
            $sheet->setCellValue('B' . $rows, getDMYDate($pol->sdate));
            $sheet->setCellValue('C' . $rows, getDMYDate($pol->edate));
            $sheet->setCellValue('D' . $rows, $pol->cname);

            $sheet->setCellValue('E' . $rows, $val->card);
            $sheet->setCellValue('F' . $rows, $val->emp_id);
            $sheet->setCellValue('G' . $rows, $val->name);
            $sheet->setCellValue('H' . $rows, $val->email);
            $sheet->setCellValue('I' . $rows, $val->phone);
            $sheet->setCellValue('J' . $rows, $val->relation);
            $sheet->setCellValue('K' . $rows, $val->gender);
            $sheet->setCellValue('L' . $rows, getDMYDate($val->dob, false));
            $sheet->setCellValue('M' . $rows, $val->age);
            $sheet->setCellValue('N' . $rows, $val->sum_insured);
            $sheet->setCellValue('O' . $rows, getDMYDate($val->doj, false));
            $sheet->setCellValue('P' . $rows, '');
            $sheet->setCellValue('Q' . $rows, getDMYDate($val->created_on, false));
            $sheet->setCellValue('R' . $rows, '');
            $sheet->setCellValue('S' . $rows, getDMYDate($val->wedd_date, false));
            $sheet->setCellValue('T' . $rows, $val->mode);
            $sheet->setCellValue('U' . $rows, $val->status);
            $rows++;
        }

        $cnt = count($users) + 5;

        $users1 = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid));



        $sheet->setCellValue('A' . $cnt, 'Emp. Id');

        $spreadsheet->getActiveSheet()->getStyle('A' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('A' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('B' . $cnt, 'Rel. Type');

        $spreadsheet->getActiveSheet()->getStyle('B' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('B' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('C' . $cnt, 'Name');

        $spreadsheet->getActiveSheet()->getStyle('C' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('C' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('D' . $cnt, 'Email');

        $spreadsheet->getActiveSheet()->getStyle('D' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('D' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('E' . $cnt, 'Phone');

        $spreadsheet->getActiveSheet()->getStyle('E' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('E' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('F' . $cnt, 'Gender');

        $spreadsheet->getActiveSheet()->getStyle('F' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('F' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('G' . $cnt, 'DOB');

        $spreadsheet->getActiveSheet()->getStyle('G' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('G' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('H' . $cnt, 'Age');

        $spreadsheet->getActiveSheet()->getStyle('H' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('H' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('I' . $cnt, 'Wedd.Date');

        $spreadsheet->getActiveSheet()->getStyle('I' . $cnt)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('I' . $cnt)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $rows = $cnt + 1;

        foreach ($users1 as $val1) {

            $sheet->setCellValue('A' . $rows, $val1->emp_id);
            $sheet->setCellValue('B' . $rows, $val1->reltype);
            $sheet->setCellValue('C' . $rows, $val1->name);
            $sheet->setCellValue('D' . $rows, $val1->email);
            $sheet->setCellValue('E' . $rows, $val1->phone);

            $sheet->setCellValue('F' . $rows, $val1->gender);
            $sheet->setCellValue('G' . $rows, getDMYDate($val1->dob, false));
            $sheet->setCellValue('H' . $rows, $val1->age);
            $sheet->setCellValue('I' . $rows, getDMYDate($val1->wedd_date, false));

            $rows++;
        }






        $fileName = $val->client_code . 'employee_export.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save("external/uploads/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url() . "external/uploads/" . $fileName);
    }

    public function endorsement($pid, $def = 0)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            $data['cid'] = $cid = $this->session->userdata('cid');
            $data['pid'] = $pid;

            $cond = " cid='$cid' && pid='$pid' && status=2";

            if (!empty($emp_search = $this->input->post('emp_search'))) {
                $cond .= " && (name = '" . $emp_search . "' ";
                $cond .= " OR emp_id = '" . $emp_search . "' ";
                $cond .= " OR emp_id in (" . $emp_search . ") ";
                $cond .= " OR mode = '" . $emp_search . "') ";
            }

            $data['res'] = $this->qm->all('ri_employee_tbl', '*', $cond, '', 'both', '', '', 'ASC');
            $data['resDep'] = $this->qm->all("ri_dependent_tbl", "*", $cond, '', 'both', '', '', 'ASC');

            $data['mainContent'] = "client/endorsement";
            $this->load->view('cpanel', $data);
        }
    }

    public function contactus($pid = null)
    {

        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            $cid = $this->session->userdata('cid');
            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['mainContent'] = "client/contact-us";
            $this->load->view('cpanel', $data);
        }
    }

    public function velueadded($pid = null)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            $cid = $this->session->userdata('cid');
            $data['cid'] = $cid;
            $data['pid'] = $pid;

            if ($this->input->post()) {
                $hr = $this->qm->single("ri_clients_tbl", "*", array('cid' => $cid));
                if ($this->input->post('function') == 'fitness') {
                    //print_r($_POST);
                    $subject = "Request Fitness Session";
                    $message = "Hello,";

                    $message .= "<p>" . $this->input->post('name') . ". has requested for fitness session.</p>";

                    $message .= "<p>Details are as follow</p>";

                    $message .= "<p>Name: " . $this->input->post('name') . "</p>";
                    $message .= "<p>Email: " . $this->input->post('email') . "</p>";
                    $message .= "<p>Mobile No: " . $this->input->post('mobileno') . "</p>";

                    $message .= "Activity : " . $this->input->post('activity');
                    $message .= "Session : " . $this->input->post('sessiontype');
                    $emp = $this->input->post('noemployee');
                    $city = $this->input->post('city');
                    if (isset($emp)) {
                        for ($x = 0; $x < count($emp); $x++) {
                            $message .= "<p>" . ($x + 1) . " No of employee: " . $emp[$x] . " | Location: " . $city[$x] . "</p>";
                        }
                    }

                    $message .= "<p>Yours,</p>";
                    $message .= "<p>" . $this->input->post('name') . "</p>";
                    //send_smtp_mail("manoj2karn@gmail.com", $chek->email, "Change Password for wellconnect portal", $message);
                    send_smtp_mail($this->input->post('email'), $hr->wemail, $subject, $message);
                    send_smtp_mail($this->input->post('email'), $hr->email, $subject, $message);
                    echo "<script>alert('Thanks for the request, Our team will contact you shortly!');window.location='" . base_url('client/velueadded') . "';</script>";
                } else {
                    print_r($_POST);
                    die;
                    $subject = "Onsite Blood Drives, Dental And Eye Checkups";
                    $message = "Hello,";

                    $message .= "<p>" . $this->input->post('name') . ". has requested for fitness session.</p>";

                    $message .= "<p>Details are as follow</p>";

                    $message .= "<p>Name: " . $this->input->post('name') . "</p>";
                    $message .= "<p>Email: " . $this->input->post('email') . "</p>";
                    $message .= "<p>Mobile No: " . $this->input->post('mobile') . "</p>";

                    $message .= "Camp Type : " . $this->input->post('camptype') . "<br>";
                    $message .= "City : " . $this->input->post('city') . "<br>";
                    $message .= "No of Employee : " . $this->input->post('noemployee') . "<br>";
                    $message .= "Address of Camp : " . $this->input->post('address') . "<br>";

                    $message .= "<p>Yours,</p>";
                    $message .= "<p>" . $this->input->post('name') . "</p>";
                    //send_smtp_mail("manoj2karn@gmail.com", $chek->email, "Change Password for wellconnect portal", $message);
                    send_smtp_mail($this->input->post('email'), $hr->wemail, $subject, $message);
                    send_smtp_mail($this->input->post('email'), $hr->email, $subject, $message);
                    echo "<script>alert('Thanks for the Onsite Blood Drives, Dental And Eye Checkups request, Our team will contact you shortly!');window.location='" . base_url('client/velueadded') . "';</script>";
                }
            }




            $data['mainContent'] = "client/velue-added";
            $this->load->view('cpanel', $data);
        }
    }

    public function checkval($eid, $pid)
    {
        $cid = $this->session->userdata('cid');
        $test = $this->qm->all("ri_employee_tbl", "*", array('emp_id' => $eid, 'pid' => $pid, 'cid' => $cid));
        if (count($test) > 0) {
            echo "<p class='text-danger'>* This Employee ID is already exists in the Policy.</p>";
        } else {
            echo "<p class='text-success'></p>";
        }
    }

    public function deleteemployee($pid, $eid, $type, $dol)
    {
        $reson = $this->input->get('reson');
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');
        //echo $doj;
        if ($type == 'Self') {
            $prevRec = $this->qm->single('ri_employee_tbl', '*', ['eid' => $eid]);
            if ($prevRec) {
                $this->qm->update("ri_employee_tbl", array('status' => '3', 'mode' => 'Deletion', 'dol' => $dol, 'reson' => $reson), array('eid' => $eid));
                $this->employeeModel->addEmployeeVersion($prevRec, 'emp');
            }
            $depRecs = $this->qm->all('ri_dependent_tbl', '*', ['eid' => $eid]);
            foreach ($depRecs as $dr) {
                $this->qm->update("ri_dependent_tbl", array('status' => '3', 'mode' => 'Deletion', 'dol' => $dol, 'reson' => $reson), array('did' => $dr->did));
                $this->employeeModel->addEmployeeVersion($dr, 'dep');
            }
        }

        redirect("client/employees/" . $pid);
    }

    public function deletedep($pid, $did)
    {
        $dol = $this->input->get('dol');
        $reson = $this->input->get('reson');
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');
        $prevRec = $this->qm->single('ri_dependent_tbl', '*', ['did' => $did]);
        if ($prevRec) {
            $this->employeeModel->addEmployeeVersion($prevRec, 'dep');
            $this->qm->update("ri_dependent_tbl", array('status' => '3', 'mode' => 'Deletion', 'dol' => $dol, 'reson' => $reson), array('did' => $did));
            $this->employeeModel->addEmployeeVersion($prevRec, 'dep');
        }
        redirect("client/employees/" . $pid);
    }

    public function updself($pid, $eid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');
        if ($this->input->post()) {
            $post = $this->input->post();
            $post['cid'] = $cid;
            $post['pid'] = $pid;
            $post['eid'] = $eid;
            $annualPremium = 0;
            $totalPremium = 0;
            $existingEmp = $this->qm->all('ri_employee_tbl', '*', array('eid' => $eid));

            $clientPolicyDate = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
            $endorsmentCalculations = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));

            // TODO
            // $newAge = $this->getAge($post['dob']);

            $suminsurede = $existingEmp[0]->sum_insured;
            $doj =  $existingEmp[0]->doj;
            // Days
            $datediff = $this->getPremiumDays($doj, $clientPolicyDate->edate);
            // sumInsured data
            $suminsuredId = $this->getPolicySuminsuredData($suminsurede, $cid, $pid);
            // age band data
            $agebandId = $this->getPolicyAgebandData($post['age'], $cid, $pid);
            // annual premium data
            $annualPremium = $this->getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid);

            if ($endorsmentCalculations->basis_of_calculation == "short_period_scale") {
                // Get Short Period Scales
                $shortPeriodScales = $this->getShortPeriodScalesData($datediff, $cid, $pid);
                $totalPremium = $this->shortPeriodScaleData($shortPeriodScales, $annualPremium);
            } else if ($endorsmentCalculations->basis_of_calculation == "pro_rata_basis") {
                // Get pro rata basis
                $totalPremium = $this->proRataBasisData($datediff, $clientPolicyDate->sdate, $clientPolicyDate->edate, $annualPremium);
            }

            $post['covered_days'] = $datediff;
            $post['annual_premium'] = $annualPremium;
            $post['premium'] = $totalPremium;
            $post['previous_premium'] = $existingEmp[0]->premium;
            $post['emp_id'] = $existingEmp[0]->emp_id;
            $this->employeeModel->addEmployeeVersion($existingEmp[0], 'emp');
            $upd = $this->employeeModel->updateEmployee($post);
            $this->session->set_flashdata('success', 'Updated Successfully');
            redirect('client/updself/' . $pid . '/' . $eid . '');
        }

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/self_edit";
        $this->load->view('cpanel', $data);
    }

    public function downloadend($pid, $stat = 2)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $users = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'status' => $stat));


        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Policy No');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('B1', 'Policy Start Date');
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('C1', 'Policy End Date');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('D1', 'Corporate Name');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('E1', 'Card');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('F1', 'Emp Id');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('G1', 'Employee Name');
        $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('H1', 'Email');
        $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('H1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('I1', 'Phone');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('J1', 'Relation');
        $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('J1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('K1', 'Gender');
        $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('K1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('L1', 'DOB');
        $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('L1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('M1', 'Age');
        $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('M1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('N1', 'Sum Insured');
        $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('N1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('O1', 'DOJ[Date of Joining]');
        $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('O1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('P1', 'DOL[Date of Leaving]');
        $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('P1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('Q1', 'Created On');
        $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('R1', 'Deleted On');
        $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('R1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('S1', 'Wedd.Date');
        $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('S1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('T1', 'Mode');
        $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('T1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('U1', 'Status Code');
        $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('U1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('V1', 'Status');
        $spreadsheet->getActiveSheet()->getStyle('V1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('V1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $rows = 2;
        $sheet->setCellValue('W1', 'Reason');
        $spreadsheet->getActiveSheet()->getStyle('W1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('W1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $rows = 2;

        $sheet->setCellValue('X1', 'Hr Approval Date');
        $spreadsheet->getActiveSheet()->getStyle('X1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('X1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('Y1', 'Updated On');
        $spreadsheet->getActiveSheet()->getStyle('Y1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('Y1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $pol = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));

        foreach ($users as $val) {

            //$pol = $this->qm->single("ri_clientpolicy_tbl","cname,policy_num,sdate,edate,created_on",array('cid'=>$cid));


            $sheet->setCellValue('A' . $rows, $pol->policy_num);
            $sheet->setCellValue('B' . $rows, getDMYDate($pol->sdate));
            $sheet->setCellValue('C' . $rows, getDMYDate($pol->edate));
            $sheet->setCellValue('D' . $rows, $pol->cname);

            $sheet->setCellValue('E' . $rows, $val->card);
            $sheet->setCellValue('F' . $rows, $val->emp_id);
            $sheet->setCellValue('G' . $rows, $val->name);
            $sheet->setCellValue('H' . $rows, $val->email);
            $sheet->setCellValue('I' . $rows, $val->phone);
            $sheet->setCellValue('J' . $rows, $val->relation);
            $sheet->setCellValue('K' . $rows, $val->gender);
            $sheet->setCellValue('L' . $rows, getDMYDate($val->dob, false));
            $sheet->setCellValue('M' . $rows, $val->age);
            $sheet->setCellValue('N' . $rows, $val->sum_insured);
            $sheet->setCellValue('O' . $rows, getDMYDate($val->doj, false));
            $sheet->setCellValue('P' . $rows, getDMYDate($val->dol, false));
            $sheet->setCellValue('Q' . $rows, getDMYDate($val->created_on, false));
            $sheet->setCellValue('R' . $rows, '');
            $sheet->setCellValue('S' . $rows, getDMYDate($val->wedd_date, false));
            $sheet->setCellValue('T' . $rows, $val->mode);
            $sheet->setCellValue('U' . $rows, $val->status);
            $sheet->setCellValue('V' . $rows, getStatusMap($val->status));
            $sheet->setCellValue('W' . $rows, $val->reson);
            $sheet->setCellValue('X' . $rows, getDMYDate($val->hr_approval_date, false));
            $sheet->setCellValue('Y' . $rows, getDMYDate($val->updated_on, false));
            $rows++;
        }

        $dependents = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'status' => $stat));

        foreach ($dependents as $valDep) {

            $sheet->setCellValue('A' . $rows, $pol->policy_num);
            $sheet->setCellValue('B' . $rows, getDMYDate($pol->sdate));
            $sheet->setCellValue('C' . $rows, getDMYDate($pol->edate));
            $sheet->setCellValue('D' . $rows, $pol->cname);
            $sheet->setCellValue('E' . $rows, $valDep->card);
            $sheet->setCellValue('F' . $rows, $valDep->emp_id);
            $sheet->setCellValue('G' . $rows, $valDep->name);
            $sheet->setCellValue('H' . $rows, $valDep->email);
            $sheet->setCellValue('I' . $rows, $valDep->phone);
            $sheet->setCellValue('J' . $rows, $valDep->reltype);
            $sheet->setCellValue('K' . $rows, $valDep->gender);
            $sheet->setCellValue('L' . $rows, getDMYDate($valDep->dob, false));
            $sheet->setCellValue('M' . $rows, $valDep->age);
            $sheet->setCellValue('N' . $rows, '');
            $sheet->setCellValue('O' . $rows, getDMYDate($valDep->doj, false));
            $sheet->setCellValue('P' . $rows, getDMYDate($valDep->dol, false));
            $sheet->setCellValue('Q' . $rows, getDMYDate($val->created_on, false));
            $sheet->setCellValue('R' . $rows, '');
            $sheet->setCellValue('S' . $rows, (!empty($valDep->wedd_date)) ? getDMYDate($valDep->wedd_date, false) : '');
            $sheet->setCellValue('T' . $rows, $valDep->mode);
            $sheet->setCellValue('U' . $rows, $valDep->status);
            $sheet->setCellValue('V' . $rows, getStatusMap($val->status));
            $sheet->setCellValue('W' . $rows, $valDep->reson);
            $sheet->setCellValue('X' . $rows, getDMYDate($valDep->hr_approval_date, false));
            $sheet->setCellValue('Y' . $rows, getDMYDate($valDep->updated_on, false));
            $rows++;
        }

        $fileName = $val->client_code . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save("external/uploads/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url() . "external/uploads/" . $fileName);
    }

    public function focusedclaim($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        //$data['eid'] = $eid;
        $data['mainContent'] = "client/focusedclaim";
        $this->load->view('cpanel', $data);
    }

    public function approveall($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $this->qm->update("ri_employee_tbl", array('status' => '2', 'mode' => 'Pending for Approval'), array('cid' => $cid, 'pid' => $pid, 'status' => '3'));
        echo "<script>alert('All employee and dependants records has been processed');window.location='" . base_url('client/dashboard/' . $pid) . "'</script>";
    }

    //for testing purpose only
    public function filesget($policy)
    {
        $pol = $this->qm->single2("ad_policy", "*", array('policy_no' => $policy));
        $end = $this->qm->all2("ad_policy_endorsement", "*", array('policy_id' => $pol->policy_id));
        //print_r($end);
        foreach ($end as $end) {
            $test = $this->qm->get_end_files($end->endorsement_id);
            //print_r($test);
        }
        //print_r($test);
        //echo "https://riskbirbal.com/assets/files/policy/".$test->file_name;
    }

    public function faq($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/faq";
        $this->load->view('cpanel', $data);
    }

    public function cashless($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/cashless";
        $this->load->view('cpanel', $data);
    }

    public function completechecklist($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/completechecklist";
        $this->load->view('cpanel', $data);
    }

    public function reimbursement($pid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/reimbursement";
        $this->load->view('cpanel', $data);
    }

    public function fg()
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');
        $data['cid'] = $cid;

        // $data['mainContent'] = "client/forgetpass";
        $this->load->view('client/forgetpass', $data);
    }

    public function inviteemployees()
    {
        if (isset($_FILES['excel_upload']) && !empty($_FILES['excel_upload'])) {

            // Set preference 
            $uploadConfig['upload_path'] = './external/uploads/employee_invitation/';
            $uploadConfig['allowed_types'] = 'xlsx';
            $uploadConfig['max_width'] = 0;
            $uploadConfig['max_height'] = 0;
            $uploadConfig['max_size'] = 0;
            $uploadConfig['overwrite'] = TRUE;
            $this->load->library('upload', $uploadConfig);
            $this->load->library('queues');

            $targetPath = FCPATH . 'external/uploads/employee_invitation/' . str_replace(' ', '_', $_FILES['excel_upload']['name']);

            $this->upload->initialize($uploadConfig);

            // File upload
            if ($this->upload->do_upload('excel_upload')) {

                $cid = $this->input->post('cid');
                $pid = $this->input->post('pid');
                if (empty($pid)) {
                    $policyRec = $this->qm->all("ri_clientpolicy_tbl", "*", array('cid' => $cid));
                    foreach ($policyRec as $rec) {
                        $pid = $rec->id;
                    }
                }

                // Get data about the file
                $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadSheet = $Reader->load($targetPath);
                $excelSheet = $spreadSheet->getActiveSheet();
                $spreadSheetAry = $excelSheet->toArray();
                $hrMessage = (isset($_REQUEST['hr_message'])) ? $_REQUEST['hr_message'] : '';
                $registerUrl = base_url() . 'employee/register/' . $cid . '/' . $pid;
                $empData = [];

                for ($i = 1; $i < count($spreadSheetAry); $i++) {

                    $data = [
                        'emp_id' => (isset($spreadSheetAry[$i][1])) ? $spreadSheetAry[$i][1] : '',
                        'emp_name' => (isset($spreadSheetAry[$i][2])) ? $spreadSheetAry[$i][2] : '',
                        'emp_email' => (isset($spreadSheetAry[$i][3])) ? $spreadSheetAry[$i][3] : '',
                        'emp_sum_insured' => (isset($spreadSheetAry[$i][4])) ? $spreadSheetAry[$i][4] : '',
                        'hr_message' => $hrMessage,
                        'register_url' => $registerUrl,
                        'status' => 'pending'
                    ];

                    $empData[] = $data;
                }

                $queueBatch = $this->queues->addToQueue($empData, 'employee_invitation');

                echo json_encode([
                    'success' => true,
                    'batch_id' => $queueBatch,
                    'redirecturl' => base_url() . 'client/empinvitationlist'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'redirecturl' => ''
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'redirecturl' => ''
            ]);
        }
    }

    public function empinvitationlist()
    {
        $batchId = $this->input->get('batchid');
        $batchData = $this->db->where('batch', $batchId)->get('emp_invite_history')->row();
        $batchEmails = $this->db->where('batch', $batchId)->get('queues')->result();
        $data['mainContent'] = "client/empinvitationlist";
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            $data['cid'] = $this->session->userdata('cid');
        }
        $data['batchData'] = $batchData;
        $data['batchEmails'] = $batchEmails;
        $this->load->view('cpanel', $data);
    }

    public function downloadinvitationreport()
    {
        $filename = "invitation_email_list.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $heading = false;
        if (isset($_SESSION['export_email_list']) && !empty($_SESSION['export_email_list']))
            foreach ($_SESSION['export_email_list'] as $row) {
                if (!$heading) {
                    // display field/column names as a first row
                    echo implode("\t", array_keys($row)) . "\n";
                    $heading = true;
                }
                echo implode("\t", array_values($row)) . "\n";
            }
        exit;
    }

    public function getemployeeinvitestatus()
    {
        $this->load->library('queues');
        $batchId = $this->input->get('batch_id');
        $batchDetails = $this->queues->getEmpInviteStats($batchId);
        echo json_encode([
            'success' => true,
            'batch_details' => $batchDetails
        ]);
        exit;
    }

    public function callqueue()
    {
        $this->load->library('queues');
        $this->queues->processQueue('employee_invitation');
    }

    public function invitationhistory()
    {
        $cid = $this->session->userdata('cid');
        $batchData = $this->db->where('cid', $cid)->order_by('id', 'desc')->get('emp_invite_history')->result();
        $data['mainContent'] = "client/invitehistory";
        if (empty($this->session->userdata('cid'))) {
            redirect("client/index/");
        } else {
            $data['cid'] = $this->session->userdata('cid');
        }
        $data['batchData'] = $batchData;
        $this->load->view('cpanel', $data);
    }

    public function confidential($pid = null)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "client/confidential";
        $this->load->view('cpanel', $data);
    }

    //to add spouse
    public function updspouse($pid, $eid)
    {

        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/spouse_edit";
        $this->load->view('cpanel', $data);
    }

    public function updmother($pid, $eid)
    {

        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/mother_edit";
        $this->load->view('cpanel', $data);
    }

    public function updfather($pid, $eid)
    {

        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/father_edit";
        $this->load->view('cpanel', $data);
    }

    public function updfatherinlaw($pid, $eid)
    {

        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/fatherinlaw_edit";
        $this->load->view('cpanel', $data);
    }

    public function updmotherinlaw($pid, $eid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/motherinlaw_edit";
        $this->load->view('cpanel', $data);
    }

    public function addkid($pid, $eid)
    {
        if (empty($this->session->userdata('cid'))) {
            redirect('client/index/');
        }
        $cid = $this->session->userdata('cid');

        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['eid'] = $eid;
        $data['mainContent'] = "client/kid_edit";
        $this->load->view('cpanel', $data);
    }

    // Get Days ( premium date)
    public function getPremiumDays($date1, $date2)
    {
        // convert date format dd/mm/yyyy to dd-mm-yyy
        $date1 = str_replace('/', '-', $date1);
        $date2 = str_replace('/', '-', $date2);
        $datediff = strtotime($date2) > strtotime($date1) ? strtotime($date2) - strtotime($date1) : strtotime($date1) - strtotime($date2);
        // return total date
        return round($datediff / (60 * 60 * 24)) + 1;
    }

    // Get Premium Start End Total Days
    public function getPremiumStartEndTotalDays($sdate, $edate)
    {
        $datediff = strtotime($edate) - strtotime($sdate);
        // return total date
        return round($datediff / (60 * 60 * 24));
    }

    // Short Period Scale Endorsment Calculations
    public function shortPeriodScaleData($premiumCollected, $premium)
    {
        return round($premiumCollected / 100 * $premium);
    }

    // Pro Rata Basis Endorsment Calculations
    public function proRataBasisData($datediff, $sdate, $edate, $premium)
    {
        $date = $this->getPremiumStartEndTotalDays($sdate, $edate);
        return round($premium / $date * $datediff);
    }

    // Get annual premium
    public function getPolicySuminsuredData($suminsured, $cid, $pid)
    {
        $data = $this->qm->single("policy_suminsureds", "*", array('suminsured' => $suminsured, 'cid' => $cid, 'pid' => $pid));
        if (empty($data)) {
            return 0;
        } else {
            return $data->id;
        }
    }

    // Get policy agebands
    public function getPolicyAgebandData($age, $cid, $pid)
    {
        if (empty($age))
            $age = 0;
        $data = $this->qm->single("policy_agebands", "*", array('min_age <=' => $age, 'max_age >=' => $age, 'cid' => $cid, 'pid' => $pid));
        if (empty($data)) {
            return 0;
        } else {
            return $data->id;
        }
    }

    // Get policy premium
    public function getPolicyPremiumData($suminsuredId, $agebandId, $cid,  $pid)
    {
        $data = $this->qm->single("policy_premium", "*", array('suminsured_id' => $suminsuredId, 'ageband_id' => $agebandId, 'cid' => $cid, 'pid' => $pid));
        // if $data == NULL then throw Error
        if (empty($data)) {
            return 0;
        } else {
            return $data->premium;
        }
    }

    // Get short period scales
    public function getShortPeriodScalesData($datediff, $cid, $pid)
    {
        // Get upto days
        $data = $this->qm->single("short_period_scales", "*", array('upto_days > ' => $datediff, 'cid' => $cid, 'pid' => $pid));
        // if $datediff > upto_days (then get last upto_day)
        if ($data == NULL) {
            $data = $this->qm->getDays("short_period_scales", "*", array('upto_days <= ' => $datediff, 'cid' => $cid, 'pid' => $pid), 'upto_days', 'DESC', 1);
        }
        if (empty($data)) {
            return 0;
        } else {
            return $data->premium_collected;
        }
    }

    // Date formet (convert date format dd/mm/yyyy to dd-mm-yyy)
    public function dateFormat($date)
    {
        // convert date format dd/mm/yyyy to dd-mm-yyy
        return str_replace('/', '-', $date);
    }

    // Get Employee age (pass DOB)
    public function getAge($dob)
    {
        $dob = $this->dateFormat($dob);
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dob), date_create($today));
        $year = $diff->format('%y');
        $month = $diff->format('%m');
        return $month <= 6 ? $year : $year + 1;
    }
}
