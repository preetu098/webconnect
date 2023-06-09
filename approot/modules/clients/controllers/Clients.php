<?php
defined('BASEPATH') or exit('No direct script access allowed');
require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Clients extends MY_Controller
{
    public function index()
    {

        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['mainContent'] = "/index";
            $this->load->view('panel', $data);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('aid');
        redirect('login/index');
    }

    public function setting()
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {


            $this->load->view('clients/profile');
        }
    }

    public function addclient()
    {
        $post = $this->input->post();
        $post['username'] = $this->input->post('ccode');
        $post['password'] = md5($this->input->post('ccode'));

        if (!empty($_FILES['image']['name'])) {

            $dat = $this->qm->upload('./external/uploads/', 'image');

            $post['image'] = $dat;
        }

        $client = $this->qm->insert('ri_clients_tbl', $post);
        if ($client) {

            $this->session->set_flashdata('success', 'Client Add Successfully');
            redirect('clients/index');
        } else {
            $this->session->set_flashdata('error', 'Client Addition Failed');
            redirect('clients/index');
        }
    }

    public function editclient()
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['mainContent'] = "clients/editclient";
            $this->load->view('panel', $data);
        }
    }

    public function clientform($cid)
    {
        $get = $this->qm->all('ri_clients_tbl', '*', array('cid' => $cid));
        foreach ($get as $get) {
            echo '
			  <form method="POST" action="' . base_url('clients/updateclient/') . '' . $get->cid . '" enctype="multipart/form-data">
                                 <div class="row">
			<div class="mb-3 col-md-6">
			<h2>Client Name :' . $get->cname . '</h2>
			</div>
			<div class="mb-3 col-md-6">
			<h2>Client code :' . $get->ccode . '</h2>
			</div>
			<div class="mb-3 col-md-6">
               <label class="form-label">Mobile</label>
                <input type="text" name="phone" value="' . $get->phone . '" maxlength="10" class="form-control">
            </div>
            <div class="mb-3 col-md-6">
               <label class="form-label">Email</label>
               <input type="email" name="email" value="' . $get->email . '" class="form-control" >
            </div>
            <div class="mb-3 col-md-6">
            	<div class="row">
            		<div class="col-md-8">
		               <label class="form-label">Company Logo</label>
		               <input type="file" name="image" class="form-control" >
           			</div> 
           			<div class="col-md-4" style="display: grid;">
		               <label class="form-label">Logo</label>
		               <img src="' . base_url('external/uploads/') . '' . $get->image . '" style="width:100px;">
           			</div> 
           		</div> 
            </div> 
            <div class="mb-3 col-md-6">
               <label class="form-label">Status</label>
                <select class="form-control" name="status">
                  <option value="1" ' . (($get->status == 1) ? 'selected' : '') . '>Active</option>
                  <option value="0" ' . (($get->status == 0) ? 'selected' : '') . '>Inactive</option>
               </select>
            </div>
             <div class="col-md-4 mb-3">
             <label class="form-label">Tech Support Name</label>
             <input type="text" name="tname" class="form-control"  value="' . $get->tname . '" >
             
           </div>
         
            <div class="col-md-4 mb-3">
             <label class="form-label">Tech Support Mobile</label>
             <input type="text" name="tphone" maxlength="10" class="form-control"  value="' . $get->tphone . '">
             
           </div>
            <div class="col-md-4 mb-3">
             <label class="form-label">Tech Support Email</label>
             <input type="email" name="temail" class="form-control"  value="' . $get->temail . '">
             
           </div>
           <div class="col-md-4 mb-3">
             <label class="form-label">Functional Support Name</label>
             <input type="text" name="fname" class="form-control"  value="' . $get->fname . '">
            
           </div>
         
            <div class="col-md-4 mb-3">
             <label class="form-label">Functional Support Mobile</label>
             <input type="text" name="fphone" maxlength="10" class="form-control"  value="' . $get->fphone . '">
            
           </div>
            <div class="col-md-4 mb-3">
             <label class="form-label">Functional Support Email</label>
             <input type="email" name="femail" class="form-control"  value="' . $get->femail . '">
             
           </div>
           <input type="hidden" name="img" value="' . $get->image . '">
           <div class="mb-3 col-md-3">
              <button type="submit" class="btn btn-primary">Update Client</button>
            </div>
            </div>
            </form>
            ';
        }
    }

    public function updateclient($cid)
    {

        if (!empty($_FILES['image']['name'])) {
            $dat = $this->qm->upload('./external/uploads/', 'image');
        } else {
            $dat = $this->input->post('img');
        }
        $post = array(
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'status' => $this->input->post('status'),
            'tname' => $this->input->post('tname'),
            'tphone' => $this->input->post('tphone'),
            'temail' => $this->input->post('temail'),
            'fname' => $this->input->post('fname'),
            'fphone' => $this->input->post('fphone'),
            'femail' => $this->input->post('femail'),
            'image' => $dat,

        );


        $where = 'cid = "' . $cid . '"';

        $updcl = $this->qm->update('ri_clients_tbl', $post, $where);

        if ($updcl) {

            $this->session->set_flashdata('success', 'Client Updated Successfully');
            redirect('clients/editclient/');
        } else {
            $this->session->set_flashdata('error', 'Updation Failed');
            redirect('clients/editclient/');
        }
    }

    public function clientpolicies()
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['mainContent'] = "clients/clientpolicies";
            $this->load->view('panel', $data);
        }
    }

    public function policy()
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['mainContent'] = "clients/policy";
            $this->load->view('panel', $data);
        }
    }

    public function getpolicy($typ)
    {
        if ($typ == 5283) {

            // echo "<option>Select Value</option>";
            //  echo "<option value='5283'>All</option>";
            echo '<label>Policy Number </label>';
            echo '<select class="form-select form-control" name="policy_num" id="num">';
            echo "<option>Select Value</option>";


            echo '<option value="5283" selected>Data Collection</option>';

            echo '</select>';
        } else {

            $decode = $this->qm->all("ad_policy", "*", array('policy_type_id' => $typ));
            //print_r($decode);

            echo '<label>Policy Number </label>';
            echo '<select class="form-select form-control" name="policy_num" id="num">';
            echo "<option>Select Value</option>";
            foreach ($decode as $type) {
                if ($typ == $type->policy_type_id) {
                    echo "<option value='$type->policy_no'>" . $type->policy_no . "</option>";
                }
            }
            echo '</select>';
        }
    }

    public function addpolicy()
    {
        $cname = $this->input->post('cname');
        $get = explode('|', $cname);
        $img = $this->qm->upload('./external/uploads/', 'iimage');
        $data = array(
            'cid' => $get[0],
            'cname' => $get[1],
            'ccode' => $get[2],
            'iimage' => $img,
            'policy_type' => $this->input->post('policy_type'),
            'policy_num' => $this->input->post('policy_num'),
            'suminsured' => $this->input->post('suminsured'),
            'servicing' => $this->input->post('servicing'),
            'sdate' => $this->input->post('sdate'),
            'edate' => $this->input->post('edate'),
            'status' => $this->input->post('status'),
            'tpa' => $this->input->post('tpa'),
            'created_on' => date('Y-m-d'),
        );
        $ins = $this->qm->insert('ri_clientpolicy_tbl', $data);
        if ($ins) {
            $this->session->set_flashdata('success', 'Policy Added Successfully');
            redirect('clients/clientpolicies/');
        } else {
            $this->session->set_flashdata('error', 'Policy Addition Failed');
            redirect('clients/policy/');
        }
    }

    public function clientdetail($cid, $pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['mainContent'] = "clients/clientdetail";
            $this->load->view('panel', $data);
        }
    }

    public function message($cid, $pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {

            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $this->load->view('clients/message', $data);
        }
    }

    public function addmsg($cid, $pid)
    {
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;

        $ins = $this->qm->insert('welcomemsg_tbl', $post);
        if ($ins) {
            $this->session->set_flashdata('success', 'Message Added Successfully');
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        } else {
            $this->session->set_flashdata('error', 'Message Addition Failed');
            redirect('clients/addmsg/' . $cid . '/' . $pid . '');
        }
    }

    public function editmessage($id, $cid, $pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['id'] = $id;
            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $this->load->view('clients/editmessage', $data);
        }
    }

    public function updmsg($id, $cid, $pid)
    {
        $data = array(
            'type' => $this->input->post('type'),
            'msg' => $this->input->post('msg'),
        );
        $where = array('id' => $id);

        $upd = $this->qm->update('welcomemsg_tbl', $data, $where);
        if ($upd) {

            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function addrelation($cid, $pid)
    {
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;

        $ins = $this->qm->insert('fm_relation_tbl', $post);
        if ($ins) {

            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function addrelationmetrix($cid, $pid)
    {
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;

        $ins = $this->qm->insert('fm_escalationmetrix_tbl', $post);
        if ($ins) {

            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function addrelationmetrixnext($cid, $pid)
    {
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;

        $ins = $this->qm->insert('fm_escalationmetrix_next_tbl', $post);
        if ($ins) {

            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function addmetrix($cid, $pid)
    {
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;

        $ins = $this->qm->insert('fm_escalationmetrix_entry_tbl', $post);
        if ($ins) {

            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function updrelationmetrix($id, $cid, $pid)
    {
        $post = $this->input->post();
        $where = "id = '" . $id . "'";
        $upd = $this->qm->update('fm_escalationmetrix_tbl', $post, $where);
        if ($upd) {
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function updrelation($id, $cid, $pid)
    {
        $post = $this->input->post();
        $where = "id = '" . $id . "'";
        $upd = $this->qm->update('fm_relation_tbl', $post, $where);
        if ($upd) {
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function updclaimsummary($cid, $pid)
    {
        $post = $this->input->post();

        $where = "id = '" . $pid . "' and cid = '" . $cid . "'";

        $upd = $this->qm->update('ri_clientpolicy_tbl', $post, $where);

        if ($upd) {
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '?t=csum');
        }
    }

    public function endorsmentCalculation($cid, $pid)
    {
        $data = [];
        $post = $this->input->post();
        $where = "pid = '" . $pid . "' and cid = '" . $cid . "'";
        $postdata['pid'] = $pid;
        $postdata['cid'] = $cid;
        $postdata['created_by'] = $cid;
        $postdata['modified_by'] = $cid;
        $postdata['status'] = $post['status'];
        $data['endorscalc'] = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
        if ($post['tab'] == 'basis_calc_tab') {
            $po['sdate'] = $post['sdate'];
            $po['edate'] = $post['edate'];
            // $po['status'] = $post['status'];
            $postdata['basis_of_calculation'] = $post['basis_of_calculation'];
            $postdata['backdation_days'] = $post['backdation_days'];
            $upclientpolicy = $this->qm->update('ri_clientpolicy_tbl', $po, ['id' => $pid, 'cid' => $cid]);
        }
        if ($post['tab'] == 'gst_tab') {
            $postdata['gst'] = $post['gst'];
            $postdata['gst_rate'] = $post['gst_rate'];
        }
        if (!empty($data['endorscalc'])) {
            $up = $this->qm->update('endorsment_calculations', $postdata, $where);
            $this->saveCalculations($cid, $pic);
        } else {
            $in = $this->qm->insert('endorsment_calculations', $postdata);
            $this->saveCalculations($cid, $pic);
        }

        redirect("clients/endorsement/$cid/$pid", $data);
    }
    public function saveCalculations($cid, $pid){
        try {
            $postdata=[];
            $endorsment_calculations_info = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
            $endorsment_calculations_info = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
            $policy_info = $this->qm->single("ad_policy", "*", array('policy_id' => $pid));
            $policy_premium_info = $this->qm->single("policy_premium", "*", array('cid' => $cid, 'pid' => $pid));
            $empl = $this->qm->getAll('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'mode' => "New Addition"));

            foreach ($empl  as $emp) {
                $date_of_joining = date("Y-m-d", strtotime($emp->doj));
                $date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                $diffDays = $this->dateDifference($date_of_joining, $date_of_policy_expire);
                $EED = $this->dateDifference($date_of_joining, date("Y-m-d"));
                $diffDays = abs($diffDays) + 1;
                $pro_date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                $pro_date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                $pro_diffDays = $this->dateDifference($pro_date_of_policy_start, $pro_date_of_policy_expire);
                $pro_diffDays = abs($pro_diffDays) + 1;
                $pro_rata = (($policy_premium_info->premium / $pro_diffDays) * $diffDays);
                if ($endorsment_calculations_info->gst == 1) {
                    $gst_premium = $policy_premium_info->premium * ($endorsment_calculations_info->gst_rate / 100);
                    $short_gst_premium = $gst_premium + $policy_premium_info->premium;
                    $pro_gst_premium = $pro_rata * ($endorsment_calculations_info->gst_rate / 100);
                    $pro_rata_gst_premium = $pro_gst_premium + $pro_rata;
                }
                $policy_premium_info->premium;
                // $diffDays=30;scdcc
                if ($diffDays <= 7) {
                    $premium = $policy_premium_info->premium * (10 / 100);
                    $short_peroid_rate = '10%';
                }
                if ($diffDays <= 30) {
                    $premium = $policy_premium_info->premium * (25 / 100);
                    $short_peroid_rate = '25%';
                }
                if ($diffDays <= 60) {
                    $premium = $policy_premium_info->premium * (35 / 100);
                    $short_peroid_rate = '35%';
                }
                if ($diffDays <= 90) {
                    $premium = $policy_premium_info->premium * (50 / 100);
                    $short_peroid_rate = '50%';
                }
                if ($diffDays <= 120) {
                    $premium = $policy_premium_info->premium * (60 / 100);
                    $short_peroid_rate = '60%';
                }
                if ($diffDays <= 180) {
                    $premium = $policy_premium_info->premium * (75 / 100);
                    $short_peroid_rate = '75%';
                }
                if ($diffDays <= 240 || $diffDays >= 240) {
                    $premium = $policy_premium_info->premium * (100 / 100);
                    $short_peroid_rate = '100%';
                }
                $postdata['eed_cal'] = $EED >= 43 ? 43 : $EED;
                $postdata['premium_cal'] = $policy_premium_info->premium;
                $postdata['days_coverage_cal'] = $diffDays;
                if ($endorsment_calculations_info->basis_of_calculation == "pro_rata_basis") {
                    $postdata['pro_rata_premium_cal'] = $pro_rata ? (int)$pro_rata : 0;
                    $postdata['gst_cal'] = $pro_gst_premium ? (int) $pro_gst_premium : 0;
                    $postdata['pro_rata_premium_gst_cal'] = $pro_rata_gst_premium ? (int) $pro_rata_gst_premium : 0;

                    $postdata['short_period_rate_cal'] = 0;
                    $postdata['short_period_premium_cal'] = 0;
                    $postdata['short_period_premium_gst_cal'] = 0;
                } else {
                    $postdata['short_period_rate_cal'] = $short_peroid_rate ? $short_peroid_rate : 0;
                    $postdata['short_period_premium_cal'] = $premium ? $premium : 0;
                    $postdata['gst_cal'] = $gst_premium ? $gst_premium : 0;
                    $postdata['short_period_premium_gst_cal'] = $short_gst_premium ? $short_gst_premium : 0;
                    $postdata['pro_rata_premium_cal'] = 0;
                    $postdata['pro_rata_premium_gst_cal'] = 0;
                }
                $where = array('pid' => $pid, 'cid' => $cid, 'eid' => $emp->eid);
                $update = $this->qm->update('ri_employee_tbl', $postdata, $where);
            }
        } catch (\Exception $e) {
        }
    }
    public  function dateDifference($start_date, $end_date)
    {
        $start_array = date_parse($start_date);
        $end_array = date_parse($end_date);
        $start_date = GregorianToJD($start_array["month"], $start_array["day"], $start_array["year"]) . "</br>";
        $end_date = GregorianToJD($end_array["month"], $end_array["day"], $end_array["year"]);
        return round(($end_date - $start_date), 0);
    }




    public function endorsmentCalculationMethod($cid, $pid)
    {

        $data = [];
        $post = $this->input->post();
        $where = "pid = '" . $pid . "' and cid = '" . $cid . "'";
        $postdata['pid'] = $pid;
        $postdata['cid'] = $cid;
        $postdata['created_by'] = $cid;
        $postdata['modified_by'] = $cid;
        $postdata['status'] = $post['status'];
        $data['endorscalc'] = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
        $postdata['calculation_method'] = $post['calculation_method'];
        if (!empty($data['endorscalc'])) {
            $up = $this->qm->update('endorsment_calculations', $postdata, $where);
        } else {
            $in = $this->qm->insert('endorsment_calculations', $postdata);
        }
        redirect("clients/endorsement/$cid/$pid", $data);
    }


    public function updclaimtracking($cid, $pid)
    {
        $post = $this->input->post();

        $where = "id = '" . $pid . "' and cid = '" . $cid . "'";

        $upd = $this->qm->update('ri_clientpolicy_tbl', $post, $where);

        if ($upd) {
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '?t=ctrack');
        }
    }

    public function getform($val, $cid, $pid)
    {
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        if ($val == 1) {

            $this->load->view('clients/addppt', $data);
        } else if ($val == 2) {
            $this->load->view('clients/ppt', $data);
        } else if ($val == 3) {
            $this->load->view('clients/addfaq', $data);
        } else if ($val == 4) {
            $this->load->view('clients/faq', $data);
        } else if ($val == 5) {
            $this->load->view('clients/banner', $data);
        } else if ($val == 8) {
            $this->load->view('clients/adddoc', $data);
        } else if ($val == 9) {
            $this->load->view('clients/clientdocumnet', $data);
        } else if ($val == 10) {
            $data['policy_data'] = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
            $this->load->view('clients/claimsummary', $data);
        } else if ($val == 11) {
            $data['policy_data'] = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
            $this->load->view('clients/claimtracking', $data);
        } else if ($val == 12) {
            $data['policy_data'] = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
            // $data['endorscalc'] = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
            // $this->load->view('clients/endorscalc', $data);
        } else {
            echo "Some Error Occurred";
        }
    }

    public function shortperiodscale($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/shortperiodscale";
        $this->load->view('panel', $data);
    }

    public function policyagebands($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/policy_agebands";
        $this->load->view('panel', $data);
    }

    public function policypremium($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/policy_premium";
        $this->load->view('panel', $data);
    }

    public function policysuminsurds($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/policy_suminsurd";
        $this->load->view('panel', $data);
    }

    public function addPolicyAgeband($cid, $pid)
    {
        $data = [];
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['created_by'] = $cid;
        $post['modified_by'] = $cid;

        $arrdata = [];
        $min_age = $post['min_age'];
        $max_age = $post['max_age'];
        if (!empty($max_age) && !empty($min_age)) :
            for ($min_age = $min_age; $min_age <= $max_age; $min_age++) {
                $arrdata[] = $min_age;
            }
        endif;

        $existingData = [];
        $agebnds = $this->qm->all('policy_agebands', "*", array('cid' => $cid, 'pid' => $pid));
        if (!empty($agebnds)) :
            foreach ($agebnds as $key => $val) {
                $existingData[] = $val->min_age;
                $existingData[] = $val->max_age;
            }
        endif;
        $overapData = array_intersect($arrdata, $existingData);
        print_r($overapData);
        // die;
        if (!empty($overapData)) {
            $this->session->set_flashdata('error', 'Data is Overlaping!');
        } else {
            $ad = $this->qm->insert("policy_agebands", $post);
            if ($ad) {
                $this->session->set_flashdata('success', 'Added Successfully');
            }
            $this->session->set_flashdata('error', 'Somthing went wrong!');
        }

        redirect('clients/policyagebands/' . $cid . '/' . $pid . '');
    }

    public function updPolicyAgeband($cid, $pid, $id)
    {
        $data = [];
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['modified_by'] = $cid;

        $arrdata = [];
        $min_age = $post['min_age'];
        $max_age = $post['max_age'];
        if (!empty($max_age) && !empty($min_age)) :
            for ($min_age = $min_age; $min_age <= $max_age; $min_age++) {
                $arrdata[] = $min_age;
            }
        endif;

        $existingData = [];
        $agebnds = $this->qm->all('policy_agebands', "*", array('cid' => $cid, 'pid' => $pid));
        if (!empty($agebnds)) :
            foreach ($agebnds as $key => $val) {
                if ($val->id == $id) {
                    continue;
                }
                $existingData[] = $val->min_age;
                $existingData[] = $val->max_age;
            }
        endif;
        $overapData = array_intersect($arrdata, $existingData);

        if (!empty($overapData)) {
            $this->session->set_flashdata('error', 'Data is Overlaping!');
        } else {
            $ad = $this->qm->insert("policy_agebands", $post);
            if ($ad) {
                $this->session->set_flashdata('success', 'Added Successfully');
            }
            $this->session->set_flashdata('error', 'Somthing went wrong!');
        }

        $where = array('pid' => $pid, 'cid' => $cid, 'id' => $id);
        $upd = $this->qm->update('policy_agebands', $post, $where);
        if ($upd) {
            $this->session->set_flashdata('success', 'Updated Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policyagebands/' . $cid . '/' . $pid . '');
    }

    public function deletePolicyAgeband($cid, $pid, $id)
    {
        $del = $this->qm->delete('policy_agebands', array('cid' => $cid, 'id' => $id));

        if ($del) {
            $this->session->set_flashdata('success', 'Deleted Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policyagebands/' . $cid . '/' . $pid . '');
    }

    public function addsuminsurds($cid, $pid)
    {
        $data = [];
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['created_by'] = $cid;
        $post['modified_by'] = $cid;

        $ad = $this->qm->insert("policy_suminsureds", $post);
        if ($ad) {
            $this->session->set_flashdata('success', 'Added Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policysuminsurds/' . $cid . '/' . $pid . '');
    }

    public function updsuminsured($cid, $pid, $id)
    {
        $data = [];
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['modified_by'] = $cid;

        $where = array('pid' => $pid, 'cid' => $cid, 'id' => $id);
        $upd = $this->qm->update('policy_suminsureds', $post, $where);
        if ($upd) {
            $this->session->set_flashdata('success', 'Updated Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policysuminsurds/' . $cid . '/' . $pid . '');
    }

    public function deletesuminsured($cid, $pid, $id)
    {
        $del = $this->qm->delete('policy_suminsureds', array('cid' => $cid, 'id' => $id));

        if ($del) {
            $this->session->set_flashdata('success', 'Deleted Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policysuminsurds/' . $cid . '/' . $pid . '');
    }

    public function addpremium($cid, $pid)
    {
        $data = [];
        $fpost = $this->input->post();
        $spost['cid'] = $cid;
        $spost['pid'] = $pid;
        $spost['created_by'] = $cid;
        $spost['modified_by'] = $cid;
        $spost['suminsured_id'] = $fpost['suminsureds'];
        $spost['ageband_id'] = $fpost['ageband'];
        $spost['premium'] = $fpost['premium'];

        $ad = $this->qm->insert("policy_premium", $spost);
        if ($ad) {
            $this->session->set_flashdata('success', 'Added Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policypremium/' . $cid . '/' . $pid . '');
    }

    public function updpremium($cid, $pid, $id)
    {
        $data = [];
        $post = $this->input->post();
        $fpost = $this->input->post();
        $spost['cid'] = $cid;
        $spost['pid'] = $pid;
        $spost['created_by'] = $cid;
        $spost['modified_by'] = $cid;
        $spost['suminsured_id'] = $fpost['suminsureds'];
        $spost['ageband_id'] = $fpost['ageband'];
        $spost['premium'] = $fpost['premium'];

        $where = array('pid' => $pid, 'cid' => $cid, 'id' => $id);
        $upd = $this->qm->update('policy_premium', $spost, $where);
        if ($upd) {
            $this->session->set_flashdata('success', 'Updated Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policypremium/' . $cid . '/' . $pid . '');
    }

    public function deletepremium($cid, $pid, $id)
    {
        $del = $this->qm->delete('policy_premium', array('cid' => $cid, 'id' => $id));

        if ($del) {
            $this->session->set_flashdata('success', 'Deleted Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/policypremium/' . $cid . '/' . $pid . '');
    }

    public function addShortperiodscale($cid, $pid)
    {
        $data = [];
        $post = $this->input->post();

        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['upto_days'] = $cid;
        $post['premium_collected'] = $pid;
        $post['created_on'] = $cid;
        $post['modified_on'] = $cid;

        $ad = $this->qm->insert("short_period_scales", $post);
        if ($ad) {
            $this->session->set_flashdata('success', 'Added Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/shortperiodscale/' . $cid . '/' . $pid . '');
    }
    public function endorsement($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/endorsement";
        $this->load->view('panel', $data);
    }
    public function template_master()
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/template_master";
        $this->load->view('panel', $data);
    }


    public function create_template_master($cid, $policy_type, $endor_type)
    {


        if (!empty($cid) &&  !empty($policy_type) && !empty($endor_type)) {
            $data = [];
            $data['cid'] = $cid;
            $data['policy_type'] = $policy_type;
            $data['endor_type'] = $endor_type;
            $data['mainContent'] = "clients/create_template_master";
            $this->load->view('panel', $data);
        } else {
            redirect("clients/template_master/");
        }
    }
    public function template_format_lists()
    {

        $data = [];
        // $data['cid'] = $cid;
        // $data['policy_type'] = $policy_type;
        // $data['endor_type'] = $endor_type;
        $data['mainContent'] = "clients/template_list";
        $this->load->view('panel', $data);
    }

    public function delete_template($endor_type, $policy_type_id)
    {

        if (!empty($endor_type) && !empty($policy_type_id)) {
            $templates = $this->qm->all('template_format', '*', array('policy_type_id' => $policy_type_id, 'endor_type' => $endor_type));
            foreach ($templates as $item) {
                $this->qm->delete("template_format", array('id' => $item->id));
            }
            $this->session->set_flashdata('success', 'Template Deleted Successfully');
        }
        redirect("clients/template_format_lists/");
    }
    public function single_delete_template($id)
    {
        if (!empty($id)) {
            $this->qm->delete("template_format", array('id' => $id));
            $this->session->set_flashdata('success', 'Template Deleted Successfully');
        }
        redirect("clients/template_format_lists/");
    }



    public function edit_template_format($policy_typ, $endor_type)
    {

        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['policy_typ'] = $policy_typ;
            $data['endor_type'] = $endor_type;
            $data['mainContent'] = "clients/edit_format_template";
            $this->load->view('panel', $data);
        }
    }
    public function update_format($policy_typ, $endor_type)

    {

        try {
            $post = $this->input->post();
            $id =  $this->input->post('id');
            $heading_name =  $this->input->post('heading_name');
            $mapped_field =  $this->input->post('mapped_field');
            $font_style =  $this->input->post('font_style');
            $font_color =  $this->input->post('font_color');
            $font_size =  $this->input->post('font_size');
            $cell_fill_col =  $this->input->post('cell_fill_col');
            $modific =  $this->input->post('modific');

            for ($i = 0; $i < count($id); $i++) {
                $data = array(
                    'heading_name' => $heading_name[$i],
                    'map_with' => $mapped_field[$i],
                    'font_style' => $font_style[$i],
                    'font_color' => $font_color[$i],
                    'font_size' => $font_size[$i],
                    'cell_fill_col' => $cell_fill_col[$i],
                    'modification' => $modific[$i]
                );
                $this->db->where('id', $id[$i]);
                $this->db->update('template_format', $data);
            }
            $this->session->set_flashdata('success', 'Updated Successfully');
        } catch (\Exception $e) {
            die($e);
            $this->session->set_flashdata('error', 'Somthing went wrong!');
        }

        redirect('clients/edit_template_format/' . $policy_typ . '/' . $endor_type);
    }
    public function template_manager($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/template_manager";
        $this->load->view('panel', $data);
    }


    public function create_master()
    {
        $post = $this->input->post();
        $data = [];
        $data['cname'] = $this->input->post('cname');
        $cid = $this->input->post('cname');
        $policy_type = $this->input->post('policy_type');
        $endor_type  = $this->input->post('endorsement_type');
        $data['policy_type'] = $this->input->post('policy_type');
        $data['endorsement_type'] = $this->input->post('endorsement_type');
        $data['mainContent'] = "clients/create_template_master";
        redirect('clients/create_template_master/' . $cid . '/' . $policy_type . '/' . $endor_type);
    }

    public function endorsement_process($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/endorsement_process";
        $this->load->view('panel', $data);
    }
    public function endorsement_deletion($cid, $pid)
    {
        $data = [];
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $data['mainContent'] = "clients/endorsement_deletion";
        $this->load->view('panel', $data);
    }
    public function download_template_excel()
    {
        $post = $this->input->post();
        $companyId =  $this->input->post('companyId');
        $cid =  $this->input->post('cid');
        $pid =  $this->input->post('pid');
        $format = explode("-", $this->input->post('format'));
        $policy_type_id = $format[0];
        $endor_type = $format[1];
        $companyFormat = $this->qm->all('template_format', '*', array('policy_type_id' => $policy_type_id, 'cid' => $companyId, "endor_type" => $endor_type));
        $emp = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid, "mode" => "New Addition"));
        $this->qm->excel($companyFormat, $emp, $pid);
    }
    public function add_template_master()
    {
        $post = $this->input->post();
        $cid =  $this->input->post('cid');
        $c_name =  $this->input->post('c_name');
        $policy_type_id =  $this->input->post('policy_type_id');
        $policy_type_name =  $this->input->post('policy_type_name');
        $endor_type =  $this->input->post('endor_type');
        $heading_name =  $this->input->post('heading_name');
        $mapped_field =  $this->input->post('mapped_field');
        $font_style =  $this->input->post('font_style');
        $font_color =  $this->input->post('font_color');
        $font_size =  $this->input->post('font_size');
        $cell_fill_color =  $this->input->post('cell_fill_color');
        $modific =  $this->input->post('modific');
        foreach ($heading_name as $index => $heading) {

            $data['cid'] = $cid;
            $data['c_name'] = $c_name;
            $data['policy_type_id'] = $policy_type_id;
            $data['policy_type_name'] = $policy_type_name;
            $data['endor_type'] = $endor_type;
            $data['heading_name'] = $heading;
            $data['map_with'] = $mapped_field[0];
            $data['font_style'] = $font_style[0];
            $data['font_color'] = $font_color[0];
            $data['font_size'] = $font_size[0];
            $data['cell_fill_col'] = $cell_fill_color[0];
            $data['modification'] = $modific[0];
            $client = $this->qm->insert('template_format', $data);
        }
        // redirect('clients/create_template_master/' . $cid);
        redirect('clients/create_template_master/' . $cid . '/' . $policy_type_id . '/' . $endor_type);
    }
    public function updShortperiodscale($cid, $pid, $id)
    {
        $data = [];
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['upto_days'] = $cid;
        $post['premium_collected'] = $pid;
        $post['modified_on'] = $cid;

        $where = array('pid' => $pid, 'cid' => $cid, 'id' => $id);
        $upd = $this->qm->update('short_period_scales', $post, $where);
        if ($upd) {
            $this->session->set_flashdata('success', 'Updated Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/shortperiodscale/' . $cid . '/' . $pid . '');
    }

    public function deletePeriodScale($cid, $pid, $id)
    {
        $del = $this->qm->delete('short_period_scales', array('cid' => $cid, 'id' => $id));

        if ($del) {
            $this->session->set_flashdata('success', 'Client Deleted Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/shortperiodscale/' . $cid . '/' . $pid . '');
    }

    public function addppt($cid, $pid)
    {
        if (!empty($_FILES['ppt']['name']) && count($_FILES['ppt']['name']) > 0) {
            $filesCount = count($_FILES['ppt']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['ppt']['name'][$i];
                $_FILES['file']['type'] = $_FILES['ppt']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['ppt']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['ppt']['error'][$i];
                $_FILES['file']['size'] = $_FILES['ppt']['size'][$i];

                // File upload configuration 

                $uploadPath = './external/uploads/policy_ppt/' . $cid . '_' . $pid;
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, TRUE);
                }
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['encrypt_name'] = TRUE;

                // Load and initialize upload library 
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server 
                if ($this->upload->do_upload('file')) {
                    // Uploaded file data 
                    $fileData = $this->upload->data();
                    //print_r($fileData);
                    $uploadData[$i]['ppt'] = 'policy_ppt/' . $cid . '_' . $pid . '/' . $fileData['orig_name'];
                    //$uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");
                    //$post['ppt']=$fileData['orig_name'];
                    $post['ppt'] = 'policy_ppt/' . $cid . '_' . $pid . '/' . $fileData['file_name'];
                    $post['cid'] = $cid;
                    $post['pid'] = $pid;
                    $post['ppt_name'] = $this->input->post('ppt_name');
                    $pp = $this->qm->insert("upload_ppt_ri", $post);
                }
            }
        }

        $this->session->set_flashdata('success', 'Added Successfully');
        redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
    }

    public function addfaq($cid, $pid)
    {
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;

        $ins = $this->qm->insert("ri_faq_tbl", $post);
        if ($ins) {
            $this->session->set_flashdata('success', 'Added Successfully');
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        } else {
            $this->session->set_flashdata('error', 'Some Error Occurred');
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function editfaq($cid, $pid)
    {
        $post = $this->input->post();
        $where = "id = '" . $id . "'";

        $upd = $this->qm->update('ri_faq_tbl', $post, $where);

        if ($upd) {

            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function addbanner($cid, $pid)
    {
        if (!empty($_FILES['banner_img']['name'])) {
            $post = $this->input->post();
            $data = $this->qm->upload('./external/uploads/', 'banner_img');

            $post['banner_img'] = $data;
            $post['cid'] = $cid;
            $post['pid'] = $pid;

            $ins = $this->qm->insert('ri_banner_tbl', $post);
            if ($ins) {
                $this->session->set_flashdata('success', 'Added Successfully');
                redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
            }
        }
    }

    public function employees($cid, $pid, $def = '20')
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {

            $cond = array('cid' => $cid, 'pid' => $pid);

            if ($this->input->post()) {
                if (!empty($this->input->post('empid'))) {
                    $cond['emp_id'] = $this->input->post('empid');
                }
                if (!empty($this->input->post('emp_name'))) {
                    $cond['emp_name'] = $this->input->post('emp_name');
                }
            }
            $this->load->library("pagination");

            $emp = $this->qm->all('ri_employee_tbl', '*', $cond);


            $data['cid'] = $cid;
            $data['pid'] = $pid;

            $config = array();
            $config["base_url"] = base_url('clients/employees/' . $cid . '/' . $pid . '/' . $def);
            $config["total_rows"] = count($emp);
            $config["per_page"] = 20;

            $this->pagination->initialize($config);

            $page = ($def > 20) ? $def : 0;

            $data["links"] = $this->pagination->create_links();

            //$data['emp'] = $this->authors_model->get_authors($config["per_page"], $page);
            $data['emp'] = $this->qm->all('ri_employee_tbl', '*', $cond, '', 'both', '', '', 'ASC', $config["per_page"], $page);

            $data['mainContent'] = "clients/employees";
            $this->load->view('panel', $data);
        }
    }

    public function uploademployee($cid, $pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['mainContent'] = "clients/uploademployee";
            $this->load->view('panel', $data);
        }
    }

    public function addemployee($cid, $pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['mainContent'] = "clients/addemployee";
            $this->load->view('panel', $data);
        }
    }

    public function addemp($cid, $pid)
    {

        if (!empty($_FILES['card']['name'])) {
            // client policy date (Start End)
            $clientPolicyDate = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
            // endorsment calculation
            $endorsmentCalculations = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
            $post = $this->input->post();
            // print_r($post);
            $data = $this->qm->upload('./external/uploads/', 'card');
            $post['card'] = $data;
            $post['cid'] = $cid;
            $post['pid'] = $pid;
            $post['data_type'] = 0;
            $post['mode'] = 'Insert';
            $post['status'] = 1;
            $post['doj'] = date("Y-m-d");
            $datediff = $this->getPremiumDays(date("Y-m-d"), $clientPolicyDate->edate);
            $post['covered_days'] = $datediff;
            $annualPremium = 0;
            $totalPremium = 0;
            // sumInsured data //TODO
            $suminsuredId = $this->getPolicySuminsuredData($post['sum_insured'], $cid, $pid);
            // TODO
            // $newAge = $this->getAge($post['dob']);

            // age band data
            $agebandId = $this->getPolicyAgebandData($post['dob'], $cid, $pid);
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

            $post['annual_premium'] = $annualPremium;

            $post['premium'] = $totalPremium;

            $ins = $this->qm->insert('ri_employee_tbl', $post);
            if ($ins) {
                $this->session->set_flashdata('success', 'Added Successfully');
                redirect('clients/employees/' . $cid . '/' . $pid . '');
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('clients/addemployee/' . $cid . '/' . $pid . '');
            }
        } else {
            // echo "error";
            // die;
            $this->session->set_flashdata('error', 'Please Upload Card');
            redirect('clients/addemployee/' . $cid . '/' . $pid . '');
        }
    }

    public function adddocu($cid, $pid)
    {
        $post = $this->input->post();
        if ($this->input->post('doc_cate') == 1) {

            $link = $this->input->post('docu_link');
        } else {

            $link = $this->qm->upload('./external/uploads/', 'docu_link');
        }

        $post['docu_link'] = $link;
        $post['cid'] = $cid;
        $post['pid'] = $pid;

        $ins = $this->qm->insert('client_doc_tbl', $post);
        if ($ins) {
            $this->session->set_flashdata('success', 'Added Successfully');
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        } else {
            $this->session->set_flashdata('error', 'Some Error Occurred');
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }
    }

    public function editpolicy($pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {

            $data['pid'] = $pid;
            $data['mainContent'] = "clients/editpolicy";
            $this->load->view('panel', $data);
        }
    }
    public function endorsement_format_download($cid, $pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {

            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['mainContent'] = "clients/endorsement_format_download";
            $this->load->view('panel', $data);
        }
    }
    public function updpolicy($pid)
    {
        $post = $this->input->post();
        $img = $this->qm->upload('./external/uploads/', 'iimage');
        if (!empty($img)) {
            $post['iimage'] = $img;
        }
        $where = 'id="' . $pid . '"';

        $upd = $this->qm->update('ri_clientpolicy_tbl', $post, $where);
        if ($upd) {
            redirect('clients/clientpolicies');
        }
    }

    public function uploademp($cid, $pid)
    {
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $policyRelKid = $this->qm->single("fm_relation_tbl", "*", array('cid' => $cid, 'pid' => $pid, 'reltype' => 'Kid'));

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
                    //$policy_num = $sheetData[$i][11];
                    $suminsurede = $sheetData[$i][12];
                    $reason = $sheetData[$i][14];
                    $doj = $sheetData[$i][13];
                    $card = $sheetData[$i][15];
                    $annualPremium = 0;
                    $totalPremium = 0;
                    // Get age TODO
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

                    $mode = 'Insert';
                    $status = 1;

                    if (($relation) == "Self" || ($relation) == "self") {
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
                            'card' => $card,
                            'relation' => $relation,
                            'sum_insured' => $suminsurede,
                            // 'policy_num'=>$policy_num,
                            'doj' => (!empty($doj)) ? date("Y-m-d", strtotime($this->dateFormat($doj))) : NULL,
                            'gender' => $gender,
                            'wedd_date' => date("Y-m-d", strtotime($wedd_date)),
                            'dob' => date("Y-m-d", strtotime($this->dateFormat($dob))),
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
                    //$policy_num = $sheetData[$i][11];
                    $suminsurede = $sheetData[$i][12];
                    $doj = $sheetData[$i][13];
                    $card = $sheetData[$i][15];
                    $mode = 'Insert';
                    $status = 1;
                    // TODO $newAge = $this->getAge($dob);
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
                                'card' => $card,
                                'phone' => $mobile,
                                'gender' => $gender,
                                'dob' => date("Y-m-d", strtotime($dob)),
                                'age' => $age,
                                'wedd_date' => date("Y-m-d", strtotime($wedd_date)),
                                'status' => '1',
                                //new member status
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

                redirect('clients/employees/' . $cid . '/' . $pid . '');
            } else {
                redirect('clients/uploademployee/' . $cid . '/' . $pid . '');
            }
        }
    }



    public function download_endorsement($cid, $pid)
    {

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $cond = " cid='$cid' && pid='$pid' ";
        $data = [];

        $data['company_id'] = $this->input->post('cname');
        $data['policy_type'] = $this->input->post('policy_type');
        $data['endorsement_type'] = $this->input->post('endorsement_type');

        $endorsement__template_info = $this->qm->single("template_master", "*", array('company_id' => $data['company_id'], 'policy_type' => $data['policy_type'], 'endorsement_type' => $data['endorsement_type']));
        $template_rules = $this->qm->single("template_rules", "*", array('company_id' => $data['company_id'], 'policy_type' => $data['policy_type'], 'endorsement_type' => $data['endorsement_type']));


        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        foreach (range('A', 'U') as $letra) {
            $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
        }

        switch ($template_rules->A1) {
            case 'A1':
                $sheet->setCellValue('A1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('A1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('A1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('A1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('A1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('A1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('A1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('A1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('A1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('A1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('A1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('A1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('A1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('A1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('A1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('A1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('A1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('A1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('A1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('A1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('A1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('A1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('A1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->B1) {
            case 'A1':
                $sheet->setCellValue('B1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('B1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('B1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('B1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('B1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('B1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('B1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('B1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('B1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('B1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('B1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('B1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('B1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('B1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('B1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('B1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('B1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('B1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('B1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('B1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('B1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('B1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('B1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->C1) {
            case 'A1':
                $sheet->setCellValue('C1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('C1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('C1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('C1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('C1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('C1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('C1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('C1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('C1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('C1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('C1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('C1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('C1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('C1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('C1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('C1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('C1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('C1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('C1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('C1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('C1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('C1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('C1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->D1) {
            case 'A1':
                $sheet->setCellValue('D1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('D1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('D1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('D1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('D1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('D1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('D1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('D1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('D1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('D1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('D1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('D1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('D1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('D1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('D1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('D1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('D1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('D1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('D1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('D1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('D1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('D1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('D1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->E1) {
            case 'A1':
                $sheet->setCellValue('E1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('E1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('E1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('E1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('E1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('E1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('E1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('E1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('E1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('E1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('E1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('E1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('E1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('E1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('E1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('E1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('E1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('E1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('E1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('E1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('E1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('E1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('E1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->F1) {
            case 'A1':
                $sheet->setCellValue('F1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('F1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('F1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('F1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('F1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('F1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('F1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('F1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('F1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('F1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('F1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('F1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('F1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('F1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('F1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('F1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('F1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('F1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('F1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('F1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('F1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('F1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('F1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->G1) {
            case 'A1':
                $sheet->setCellValue('G1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('G1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('G1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('G1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('G1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('G1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('G1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('G1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('G1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('G1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('G1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('G1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('G1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('G1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('G1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('G1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('G1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('G1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('G1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('G1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('G1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('G1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('G1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->H1) {
            case 'A1':
                $sheet->setCellValue('H1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('H1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('H1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('H1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('H1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('H1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('H1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('H1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('H1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('H1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('H1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('H1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('H1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('H1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('H1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('H1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('H1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('H1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('H1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('H1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('H1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('H1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('H1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->I1) {
            case 'A1':
                $sheet->setCellValue('I1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('I1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('I1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('I1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('I1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('I1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('I1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('I1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('I1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('I1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('I1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('I1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('I1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('I1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('I1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('I1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('I1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('I1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('I1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('I1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('I1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('I1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('I1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->J1) {
            case 'A1':
                $sheet->setCellValue('J1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('J1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('J1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('J1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('J1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('J1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('J1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('J1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('J1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('J1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('J1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('J1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('J1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('J1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('J1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('J1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('J1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('J1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('J1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('J1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('J1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('J1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('J1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->K1) {
            case 'A1':
                $sheet->setCellValue('K1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('K1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('K1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('K1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('K1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('K1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('K1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('K1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('K1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('K1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('K1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('K1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('K1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('K1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('K1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('K1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('K1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('K1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('K1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('K1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('K1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('K1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('K1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->L1) {
            case 'A1':
                $sheet->setCellValue('L1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('L1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('L1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('L1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('L1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('L1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('L1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('L1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('L1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('L1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('L1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('L1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('L1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('L1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('L1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('L1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('L1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('L1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('L1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('L1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('L1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('L1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('L1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->M1) {
            case 'A1':
                $sheet->setCellValue('M1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('M1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('M1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('M1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('M1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('M1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('M1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('M1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('M1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('M1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('M1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('M1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('M1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('M1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('M1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('M1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('M1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('M1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('M1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('M1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('M1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('M1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('M1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->N1) {
            case 'A1':
                $sheet->setCellValue('N1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('N1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('N1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('N1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('N1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('N1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('N1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('N1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('N1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('N1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('N1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('N1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('N1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('N1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('N1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('N1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('N1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('N1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('N1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('N1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('N1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('N1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->O1) {
            case 'A1':
                $sheet->setCellValue('O1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('O1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('O1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('O1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('O1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('O1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('O1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('O1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('O1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('O1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('O1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('O1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('O1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('O1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('N1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('N1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('O1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('O1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('O1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('O1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('O1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('O1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('O1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('O1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->P1) {
            case 'A1':
                $sheet->setCellValue('P1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('P1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('P1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('P1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('P1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('P1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('P1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('P1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('P1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('P1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('P1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('P1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('P1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('P1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('P1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('P1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('P1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('P1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('P1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('P1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('P1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('P1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('P1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->Q1) {
            case 'A1':
                $sheet->setCellValue('Q1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('Q1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('Q1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('Q1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('Q1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('Q1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('Q1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->R1) {
            case 'A1':
                $sheet->setCellValue('R1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('R1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('R1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('R1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('R1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('R1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('R1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('R1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('R1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('R1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('R1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('R1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('R1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('R1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('R1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('R1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('R1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('R1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('R1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('R1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('R1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('R1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('R1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->S1) {
            case 'A1':
                $sheet->setCellValue('S1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('S1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('S1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('S1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('S1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('S1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('S1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('S1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('S1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('S1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('S1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('S1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('S1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('S1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('S1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('S1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('S1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('S1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('S1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('S1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('S1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('S1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('S1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }

        switch ($template_rules->T1) {
            case 'A1':
                $sheet->setCellValue('T1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('T1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('T1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('T1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('T1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('T1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('T1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('T1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('T1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('T1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('T1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('T1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('T1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('T1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('T1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('T1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('T1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('T1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('T1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('T1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('T1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('T1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('T1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }


        switch ($template_rules->U1) {
            case 'A1':
                $sheet->setCellValue('U1', $endorsement__template_info->S_No);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'B1':
                $sheet->setCellValue('U1', $endorsement__template_info->Policy_No);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'C1':
                $sheet->setCellValue('U1', $endorsement__template_info->mode);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'D1':
                $sheet->setCellValue('U1', $endorsement__template_info->Employee_no);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'E1':
                $sheet->setCellValue('U1', $endorsement__template_info->Insured_Name);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'F1':
                $sheet->setCellValue('U1', $endorsement__template_info->Relationship_type);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'G1':
                $sheet->setCellValue('U1', $endorsement__template_info->Date_of_Birth);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'H1':
                $sheet->setCellValue('U1', $endorsement__template_info->Age);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'I1':
                $sheet->setCellValue('U1', $endorsement__template_info->Sum_Insured);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'J1':
                $sheet->setCellValue('U1', $endorsement__template_info->Date_of_Joining);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;


            case 'K1':
                $sheet->setCellValue('U1', $endorsement__template_info->Date_of_Leaving);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'L1':
                $sheet->setCellValue('U1', $endorsement__template_info->Date_of_Marriage);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'M1':
                $sheet->setCellValue('U1', $endorsement__template_info->Remarks_for_Corrections);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'N1':
                $sheet->setCellValue('U1', $endorsement__template_info->First_Name);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'O1':
                $sheet->setCellValue('U1', $endorsement__template_info->Last_Name);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'P1':
                $sheet->setCellValue('U1', $endorsement__template_info->Mobile_No);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'Q1':
                $sheet->setCellValue('U1', $endorsement__template_info->Email);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'R1':
                $sheet->setCellValue('U1', $endorsement__template_info->Endorsement_Effective_Date);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'S1':
                $sheet->setCellValue('U1', $endorsement__template_info->Premium_including_GST);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'T1':
                $sheet->setCellValue('U1', $endorsement__template_info->Wrong_DETAILS);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            case 'U1':
                $sheet->setCellValue('U1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                break;

            default:
                $sheet->setCellValue('U1', $endorsement__template_info->salary);
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
                $spreadsheet->getActiveSheet()->getStyle('U1')->getFont('Arial')->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
        }



        $endorsment_calculations_info = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
        $policy_info = $this->qm->single("ad_policy", "*", array('policy_id' => $pid));
        $policy_premium_info = $this->qm->single("policy_premium", "*", array('cid' => $cid, 'pid' => $pid));
        function dateDifference($start_date, $end_date)
        {
            $start_array = date_parse($start_date);
            $end_array = date_parse($end_date);
            $start_date = GregorianToJD($start_array["month"], $start_array["day"], $start_array["year"]) . "</br>";
            $end_date = GregorianToJD($end_array["month"], $end_array["day"], $end_array["year"]);
            return round(($end_date - $start_date), 0);
        }
        $emp = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid));

        if ($data['endorsement_type'] == "addition_deletion") {

            $rows = 0;
            foreach ($emp as $emp) {


                if ($emp->mode == "New Addition" || $emp->mode == "Deletion") {

                    $date_of_joining = date("Y-m-d", strtotime($emp->doj));
                    $date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                    $diffDays = dateDifference($date_of_joining, $date_of_policy_expire);
                    $EED = dateDifference($date_of_joining, date("Y-m-d"));
                    $diffDays = abs($diffDays) + 1;

                    $pro_date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                    $pro_date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                    $pro_diffDays = dateDifference($pro_date_of_policy_start, $pro_date_of_policy_expire);

                    $pro_diffDays = abs($pro_diffDays) + 1;
                    $pro_rata = (($policy_premium_info->premium / $pro_diffDays) * $diffDays);


                    if ($endorsment_calculations_info->gst == 1) {
                        $gst_premium = $policy_premium_info->premium * ($endorsment_calculations_info->gst_rate / 100);
                        $short_gst_premium = $gst_premium + $policy_premium_info->premium;
                        $pro_gst_premium = $pro_rata * ($endorsment_calculations_info->gst_rate / 100);
                        $pro_rata_gst_premium = $pro_gst_premium + $pro_rata;
                    }
                    $policy_premium_info->premium;

                    // $diffDays=30;
                    if ($diffDays <= 7) {
                        $premium = $policy_premium_info->premium * (10 / 100);
                        $short_peroid_rate = '10%';
                    }
                    if ($diffDays <= 30) {
                        $premium = $policy_premium_info->premium * (25 / 100);
                        $short_peroid_rate = '25%';
                    }
                    if ($diffDays <= 60) {
                        $premium = $policy_premium_info->premium * (35 / 100);
                        $short_peroid_rate = '35%';
                    }
                    if ($diffDays <= 90) {
                        $premium = $policy_premium_info->premium * (50 / 100);
                        $short_peroid_rate = '50%';
                    }
                    if ($diffDays <= 120) {
                        $premium = $policy_premium_info->premium * (60 / 100);
                        $short_peroid_rate = '60%';
                    }
                    if ($diffDays <= 180) {
                        $premium = $policy_premium_info->premium * (75 / 100);
                        $short_peroid_rate = '75%';
                    }
                    if ($diffDays <= 240 || $diffDays >= 240) {
                        $premium = $policy_premium_info->premium * (100 / 100);
                        $short_peroid_rate = '100%';
                    }

                    $date_of_leaving = date("Y-m-d", strtotime($emp->dol));
                    $date_of_leaving = '2023-04-07';
                    $date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                    $diffDays = dateDifference($date_of_leaving, $date_of_policy_start);

                    $diffDays = abs($diffDays) + 1;
                    $pro_date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                    $pro_date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                    $pro_diffDays = dateDifference($pro_date_of_policy_start, $pro_date_of_policy_expire);

                    $pro_diffDays = abs($pro_diffDays) + 1;
                    $pro_rata = (($policy_premium_info->premium / $pro_diffDays) * $diffDays);

                    $EED = dateDifference($date_of_leaving, date("Y-m-d"));


                    // $diffDays=30;
                    if ($diffDays <= 7) {
                        $premium = $policy_premium_info->premium * (90 / 100);
                        $short_peroid_rate = '90%';
                    }
                    if (($diffDays <= 30 || $diffDays < 30) && $diffDays > 7) {
                        $premium = $policy_premium_info->premium * (75 / 100);
                        $short_peroid_rate = '75%';
                    }
                    if (($diffDays <= 60 || $diffDays < 60) && $diffDays > 30) {
                        $premium = $policy_premium_info->premium * (65 / 100);
                        $short_peroid_rate = '65%';
                    }
                    if (($diffDays == 90 || $diffDays < 90) && $diffDays > 60) {
                        $premium = $policy_premium_info->premium * (50 / 100);
                        $short_peroid_rate = '50%';
                    }
                    if (($diffDays == 120 || $diffDays < 120) && $diffDays > 90) {
                        $premium = $policy_premium_info->premium * (40 / 100);
                        $short_peroid_rate = '40%';
                    }
                    if (($diffDays == 180 || $diffDays < 180) && $diffDays > 120) {
                        $premium = $policy_premium_info->premium * (25 / 100);
                        $short_peroid_rate = '25%';
                    }
                    if (($diffDays == 240 || $diffDays < 240) && $diffDays > 180) {
                        $premium = $policy_premium_info->premium * (15 / 100);
                        $short_peroid_rate = '15%';
                    }

                    if ($endorsment_calculations_info->gst == 1) {
                        $gst_premium = $policy_premium_info->premium * ($endorsment_calculations_info->gst_rate / 100);
                        $short_gst_premium = $gst_premium + $premium;
                        $pro_gst_premium = $pro_rata * ($endorsment_calculations_info->gst_rate / 100);
                        $pro_rata_gst_premium = $pro_gst_premium + $pro_rata;
                    }
                    switch ($template_rules->A1) {
                        case 'A1':
                            $sheet->setCellValue('A' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('A' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('A' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('A' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('A' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('A' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('A' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('A' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('A' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('A' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('A' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('A' . $rows, $rows);
                    }

                    switch ($template_rules->B1) {
                        case 'A1':
                            $sheet->setCellValue('B' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('B' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('B' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('B' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('B' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('B' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('B' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('B' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('B' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('B' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('B' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('B' . $rows, $policy_info->policy_no);
                    }

                    switch ($template_rules->C1) {
                        case 'A1':
                            $sheet->setCellValue('C' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('C' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('C' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('C' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('C' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('C' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('C' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('C' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('C' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('C' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('C' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('C' . $rows, $emp->mode);
                    }
                    switch ($template_rules->D1) {
                        case 'A1':
                            $sheet->setCellValue('D' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('D' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('D' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('D' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('D' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('D' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('D' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('D' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('D' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('D' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('D' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('D' . $rows, $emp->emp_id);
                    }
                    switch ($template_rules->E1) {
                        case 'A1':
                            $sheet->setCellValue('E' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('E' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('E' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('E' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('E' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('E' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('E' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('E' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('E' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                    }

                    switch ($template_rules->F1) {
                        case 'A1':
                            $sheet->setCellValue('F' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('F' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('F' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('F' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('F' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('F' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('F' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('F' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('F' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('F' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('F' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('F' . $rows, $emp->relation);
                    }

                    switch ($template_rules->G1) {
                        case 'A1':
                            $sheet->setCellValue('G' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('G' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('G' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('G' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('G' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('G' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('G' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('G' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('G' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('G' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('G' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dob)));
                    }


                    switch ($template_rules->H1) {
                        case 'A1':
                            $sheet->setCellValue('H' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('H' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('H' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('H' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('H' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('H' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('H' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('H' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('H' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('H' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('H' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('H' . $rows, $emp->age);
                    }


                    switch ($template_rules->I1) {
                        case 'A1':
                            $sheet->setCellValue('I' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('I' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('I' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('I' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('I' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('I' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('I' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('I' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('I' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('I' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('I' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                    }

                    switch ($template_rules->J1) {
                        case 'A1':
                            $sheet->setCellValue('J' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('J' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('J' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('J' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('J' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('J' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('J' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('J' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('J' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('J' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('J' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->doj)));
                    }


                    switch ($template_rules->K1) {
                        case 'A1':
                            $sheet->setCellValue('K' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('K' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('K' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('K' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('K' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('K' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('K' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('K' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('K' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('K' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('K' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dol)));
                    }


                    switch ($template_rules->L1) {
                        case 'A1':
                            $sheet->setCellValue('L' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('L' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('L' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('L' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('L' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('L' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('L' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('L' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('L' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('L' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('L' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                    }


                    switch ($template_rules->M1) {
                        case 'A1':
                            $sheet->setCellValue('M' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('M' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('M' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('M' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('M' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('M' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('M' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('M' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('M' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                    }

                    switch ($template_rules->N1) {
                        case 'A1':
                            $sheet->setCellValue('N' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('N' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('N' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('N' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('N' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('N' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('N' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('N' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('N' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('N' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('N' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                    }

                    switch ($template_rules->O1) {
                        case 'A1':
                            $sheet->setCellValue('O' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('O' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('O' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('O' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('O' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('O' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('O' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('O' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('O' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('O' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('O' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('O' . $rows, $emp->age);
                    }

                    switch ($template_rules->P1) {
                        case 'A1':
                            $sheet->setCellValue('P' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('P' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('P' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('P' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('P' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('P' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('P' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('P' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('P' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('P' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('P' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('P' . $rows, $emp->mobile);
                    }

                    switch ($template_rules->Q1) {
                        case 'A1':
                            $sheet->setCellValue('Q' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('Q' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('Q' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('Q' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('Q' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('Q' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('Q' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('Q' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('Q' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('Q' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('Q' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('Q' . $rows, $emp->email);
                    }

                    switch ($template_rules->R1) {
                        case 'A1':
                            $sheet->setCellValue('R' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('R' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('R' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('R' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('R' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('R' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('R' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('R' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('R' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('R' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('R' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                    }

                    switch ($template_rules->S1) {
                        case 'A1':
                            $sheet->setCellValue('S' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('S' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('S' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('S' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('S' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('S' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('S' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('S' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('S' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('S' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('S' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('S' . $rows, $premium);
                    }

                    switch ($template_rules->T1) {
                        case 'A1':
                            $sheet->setCellValue('T' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('T' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('T' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('T' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('T' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('T' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('T' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('T' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('T' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('T' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('T' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                    }

                    switch ($template_rules->U1) {
                        case 'A1':
                            $sheet->setCellValue('U' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('U' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('U' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('U' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('U' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('U' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('U' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('U' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('U' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('U' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('U' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                    }
                }
                $rows++;
            }
        }
        if ($data['endorsement_type'] == "addition") {
            $rows = 0;
            foreach ($emp as $emp) {

                if ($emp->mode == "New Addition") {


                    $date_of_joining = date("Y-m-d", strtotime($emp->doj));
                    $date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                    $diffDays = dateDifference($date_of_joining, $date_of_policy_expire);
                    $EED = dateDifference($date_of_joining, date("Y-m-d"));
                    $diffDays = abs($diffDays) + 1;

                    $pro_date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                    $pro_date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                    $pro_diffDays = dateDifference($pro_date_of_policy_start, $pro_date_of_policy_expire);

                    $pro_diffDays = abs($pro_diffDays) + 1;
                    $pro_rata = (($policy_premium_info->premium / $pro_diffDays) * $diffDays);


                    if ($endorsment_calculations_info->gst == 1) {
                        $gst_premium = $policy_premium_info->premium * ($endorsment_calculations_info->gst_rate / 100);
                        $short_gst_premium = $gst_premium + $policy_premium_info->premium;
                        $pro_gst_premium = $pro_rata * ($endorsment_calculations_info->gst_rate / 100);
                        $pro_rata_gst_premium = $pro_gst_premium + $pro_rata;
                    }
                    $policy_premium_info->premium;

                    // $diffDays=30;
                    if ($diffDays <= 7) {
                        $premium = $policy_premium_info->premium * (10 / 100);
                        $short_peroid_rate = '10%';
                    }
                    if ($diffDays <= 30) {
                        $premium = $policy_premium_info->premium * (25 / 100);
                        $short_peroid_rate = '25%';
                    }
                    if ($diffDays <= 60) {
                        $premium = $policy_premium_info->premium * (35 / 100);
                        $short_peroid_rate = '35%';
                    }
                    if ($diffDays <= 90) {
                        $premium = $policy_premium_info->premium * (50 / 100);
                        $short_peroid_rate = '50%';
                    }
                    if ($diffDays <= 120) {
                        $premium = $policy_premium_info->premium * (60 / 100);
                        $short_peroid_rate = '60%';
                    }
                    if ($diffDays <= 180) {
                        $premium = $policy_premium_info->premium * (75 / 100);
                        $short_peroid_rate = '75%';
                    }
                    if ($diffDays <= 240 || $diffDays >= 240) {
                        $premium = $policy_premium_info->premium * (100 / 100);
                        $short_peroid_rate = '100%';
                    }

                    $rows = 2;


                    switch ($template_rules->A1) {
                        case 'A1':
                            $sheet->setCellValue('A' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('A' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('A' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('A' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('A' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('A' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('A' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('A' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('A' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('A' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('A' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('A' . $rows, $rows);
                    }

                    switch ($template_rules->B1) {
                        case 'A1':
                            $sheet->setCellValue('B' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('B' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('B' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('B' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('B' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('B' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('B' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('B' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('B' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('B' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('B' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('B' . $rows, $policy_info->policy_no);
                    }

                    switch ($template_rules->C1) {
                        case 'A1':
                            $sheet->setCellValue('C' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('C' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('C' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('C' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('C' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('C' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('C' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('C' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('C' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('C' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('C' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('C' . $rows, $emp->mode);
                    }
                    switch ($template_rules->D1) {
                        case 'A1':
                            $sheet->setCellValue('D' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('D' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('D' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('D' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('D' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('D' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('D' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('D' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('D' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('D' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('D' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('D' . $rows, $emp->emp_id);
                    }
                    switch ($template_rules->E1) {
                        case 'A1':
                            $sheet->setCellValue('E' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('E' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('E' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('E' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('E' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('E' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('E' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('E' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('E' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                    }

                    switch ($template_rules->F1) {
                        case 'A1':
                            $sheet->setCellValue('F' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('F' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('F' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('F' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('F' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('F' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('F' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('F' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('F' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('F' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('F' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('F' . $rows, $emp->relation);
                    }

                    switch ($template_rules->G1) {
                        case 'A1':
                            $sheet->setCellValue('G' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('G' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('G' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('G' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('G' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('G' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('G' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('G' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('G' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('G' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('G' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dob)));
                    }


                    switch ($template_rules->H1) {
                        case 'A1':
                            $sheet->setCellValue('H' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('H' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('H' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('H' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('H' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('H' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('H' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('H' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('H' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('H' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('H' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('H' . $rows, $emp->age);
                    }


                    switch ($template_rules->I1) {
                        case 'A1':
                            $sheet->setCellValue('I' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('I' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('I' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('I' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('I' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('I' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('I' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('I' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('I' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('I' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('I' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                    }

                    switch ($template_rules->J1) {
                        case 'A1':
                            $sheet->setCellValue('J' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('J' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('J' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('J' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('J' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('J' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('J' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('J' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('J' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('J' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('J' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->doj)));
                    }


                    switch ($template_rules->K1) {
                        case 'A1':
                            $sheet->setCellValue('K' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('K' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('K' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('K' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('K' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('K' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('K' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('K' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('K' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('K' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('K' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dol)));
                    }


                    switch ($template_rules->L1) {
                        case 'A1':
                            $sheet->setCellValue('L' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('L' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('L' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('L' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('L' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('L' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('L' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('L' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('L' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('L' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('L' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                    }


                    switch ($template_rules->M1) {
                        case 'A1':
                            $sheet->setCellValue('M' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('M' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('M' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('M' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('M' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('M' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('M' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('M' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('M' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                    }

                    switch ($template_rules->N1) {
                        case 'A1':
                            $sheet->setCellValue('N' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('N' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('N' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('N' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('N' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('N' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('N' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('N' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('N' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('N' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('N' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                    }

                    switch ($template_rules->O1) {
                        case 'A1':
                            $sheet->setCellValue('O' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('O' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('O' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('O' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('O' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('O' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('O' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('O' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('O' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('O' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('O' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('O' . $rows, $emp->age);
                    }

                    switch ($template_rules->P1) {
                        case 'A1':
                            $sheet->setCellValue('P' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('P' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('P' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('P' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('P' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('P' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('P' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('P' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('P' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('P' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('P' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('P' . $rows, $emp->mobile);
                    }

                    switch ($template_rules->Q1) {
                        case 'A1':
                            $sheet->setCellValue('Q' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('Q' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('Q' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('Q' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('Q' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('Q' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('Q' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('Q' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('Q' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('Q' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('Q' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('Q' . $rows, $emp->email);
                    }

                    switch ($template_rules->R1) {
                        case 'A1':
                            $sheet->setCellValue('R' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('R' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('R' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('R' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('R' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('R' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('R' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('R' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('R' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('R' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('R' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                    }

                    switch ($template_rules->S1) {
                        case 'A1':
                            $sheet->setCellValue('S' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('S' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('S' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('S' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('S' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('S' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('S' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('S' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('S' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('S' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('S' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('S' . $rows, $premium);
                    }

                    switch ($template_rules->T1) {
                        case 'A1':
                            $sheet->setCellValue('T' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('T' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('T' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('T' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('T' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('T' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('T' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('T' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('T' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('T' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('T' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                    }

                    switch ($template_rules->U1) {
                        case 'A1':
                            $sheet->setCellValue('U' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('U' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('U' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('U' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('U' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('U' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('U' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('U' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('U' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('U' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('U' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                    }
                }
                $rows++;
            }
        }

        if ($data['endorsement_type'] == "deletion") {
            $rows = 0;
            foreach ($emp as $emp) {
                // echo "<pre>";
                // print_r($emp->doj);
                // echo "</pre>";
                if ($emp->mode == "Deletion") {

                    $date_of_leaving = date("Y-m-d", strtotime($emp->dol));
                    $date_of_leaving = '2023-04-07';
                    $date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                    $diffDays = dateDifference($date_of_leaving, $date_of_policy_start);

                    $diffDays = abs($diffDays) + 1;
                    $pro_date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                    $pro_date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                    $pro_diffDays = dateDifference($pro_date_of_policy_start, $pro_date_of_policy_expire);

                    $pro_diffDays = abs($pro_diffDays) + 1;
                    $pro_rata = (($policy_premium_info->premium / $pro_diffDays) * $diffDays);

                    $EED = dateDifference($date_of_leaving, date("Y-m-d"));


                    // $diffDays=30;
                    if ($diffDays <= 7) {
                        $premium = $policy_premium_info->premium * (90 / 100);
                        $short_peroid_rate = '90%';
                    }
                    if (($diffDays <= 30 || $diffDays < 30) && $diffDays > 7) {
                        $premium = $policy_premium_info->premium * (75 / 100);
                        $short_peroid_rate = '75%';
                    }
                    if (($diffDays <= 60 || $diffDays < 60) && $diffDays > 30) {
                        $premium = $policy_premium_info->premium * (65 / 100);
                        $short_peroid_rate = '65%';
                    }
                    if (($diffDays == 90 || $diffDays < 90) && $diffDays > 60) {
                        $premium = $policy_premium_info->premium * (50 / 100);
                        $short_peroid_rate = '50%';
                    }
                    if (($diffDays == 120 || $diffDays < 120) && $diffDays > 90) {
                        $premium = $policy_premium_info->premium * (40 / 100);
                        $short_peroid_rate = '40%';
                    }
                    if (($diffDays == 180 || $diffDays < 180) && $diffDays > 120) {
                        $premium = $policy_premium_info->premium * (25 / 100);
                        $short_peroid_rate = '25%';
                    }
                    if (($diffDays == 240 || $diffDays < 240) && $diffDays > 180) {
                        $premium = $policy_premium_info->premium * (15 / 100);
                        $short_peroid_rate = '15%';
                    }

                    if ($endorsment_calculations_info->gst == 1) {
                        $gst_premium = $policy_premium_info->premium * ($endorsment_calculations_info->gst_rate / 100);
                        $short_gst_premium = $gst_premium + $premium;
                        $pro_gst_premium = $pro_rata * ($endorsment_calculations_info->gst_rate / 100);
                        $pro_rata_gst_premium = $pro_gst_premium + $pro_rata;
                    }

                    $rows = 2;
                    switch ($template_rules->A1) {
                        case 'A1':
                            $sheet->setCellValue('A' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('A' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('A' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('A' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('A' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('A' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('A' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('A' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('A' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('A' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('A' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('A' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('A' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('A' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('A' . $rows, $rows);
                    }

                    switch ($template_rules->B1) {
                        case 'A1':
                            $sheet->setCellValue('B' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('B' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('B' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('B' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('B' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('B' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('B' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('B' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('B' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('B' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('B' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('B' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('B' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('B' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('B' . $rows, $policy_info->policy_no);
                    }

                    switch ($template_rules->C1) {
                        case 'A1':
                            $sheet->setCellValue('C' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('C' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('C' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('C' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('C' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('C' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('C' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('C' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('C' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('C' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('C' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('C' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('C' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('C' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('C' . $rows, $emp->mode);
                    }
                    switch ($template_rules->D1) {
                        case 'A1':
                            $sheet->setCellValue('D' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('D' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('D' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('D' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('D' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('D' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('D' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('D' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('D' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('D' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('D' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('D' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('D' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('D' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('D' . $rows, $emp->emp_id);
                    }
                    switch ($template_rules->E1) {
                        case 'A1':
                            $sheet->setCellValue('E' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('E' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('E' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('E' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('E' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('E' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('E' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('E' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('E' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('E' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('E' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('E' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('E' . $rows, $emp->client_name);
                    }

                    switch ($template_rules->F1) {
                        case 'A1':
                            $sheet->setCellValue('F' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('F' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('F' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('F' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('F' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('F' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('F' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('F' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('F' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('F' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('F' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('F' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('F' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('F' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('F' . $rows, $emp->relation);
                    }

                    switch ($template_rules->G1) {
                        case 'A1':
                            $sheet->setCellValue('G' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('G' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('G' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('G' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('G' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('G' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('G' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('G' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('G' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('G' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('G' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('G' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('G' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('G' . $rows, date("d-m-Y", strtotime($emp->dob)));
                    }


                    switch ($template_rules->H1) {
                        case 'A1':
                            $sheet->setCellValue('H' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('H' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('H' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('H' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('H' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('H' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('H' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('H' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('H' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('H' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('H' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('H' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('H' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('H' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('H' . $rows, $emp->age);
                    }


                    switch ($template_rules->I1) {
                        case 'A1':
                            $sheet->setCellValue('I' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('I' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('I' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('I' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('I' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('I' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('I' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('I' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('I' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('I' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('I' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('I' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('I' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('I' . $rows, $emp->sum_insured);
                    }

                    switch ($template_rules->J1) {
                        case 'A1':
                            $sheet->setCellValue('J' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('J' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('J' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('J' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('J' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('J' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('J' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('J' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('J' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('J' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('J' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('J' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('J' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('J' . $rows, date("d-m-Y", strtotime($emp->doj)));
                    }


                    switch ($template_rules->K1) {
                        case 'A1':
                            $sheet->setCellValue('K' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('K' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('K' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('K' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('K' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('K' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('K' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('K' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('K' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('K' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('K' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('K' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('K' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('K' . $rows, date("d-m-Y", strtotime($emp->dol)));
                    }


                    switch ($template_rules->L1) {
                        case 'A1':
                            $sheet->setCellValue('L' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('L' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('L' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('L' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('L' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('L' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('L' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('L' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('L' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('L' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('L' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('L' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('L' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('L' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                    }


                    switch ($template_rules->M1) {
                        case 'A1':
                            $sheet->setCellValue('M' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('M' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('M' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('M' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('M' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('M' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('M' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('M' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('M' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('M' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('M' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('M' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('M' . $rows, $emp->client_name);
                    }

                    switch ($template_rules->N1) {
                        case 'A1':
                            $sheet->setCellValue('N' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('N' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('N' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('N' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('N' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('N' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('N' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('N' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('N' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('N' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('N' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('N' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('N' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('N' . $rows, $emp->emp_name);
                    }

                    switch ($template_rules->O1) {
                        case 'A1':
                            $sheet->setCellValue('O' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('O' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('O' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('O' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('O' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('O' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('O' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('O' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('O' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('O' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('O' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('O' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('O' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('O' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('O' . $rows, $emp->age);
                    }

                    switch ($template_rules->P1) {
                        case 'A1':
                            $sheet->setCellValue('P' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('P' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('P' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('P' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('P' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('P' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('P' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('P' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('P' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('P' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('P' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('P' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('P' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('P' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('P' . $rows, $emp->mobile);
                    }

                    switch ($template_rules->Q1) {
                        case 'A1':
                            $sheet->setCellValue('Q' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('Q' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('Q' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('Q' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('Q' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('Q' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('Q' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('Q' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('Q' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('Q' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('Q' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('Q' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('Q' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('Q' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('Q' . $rows, $emp->email);
                    }

                    switch ($template_rules->R1) {
                        case 'A1':
                            $sheet->setCellValue('R' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('R' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('R' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('R' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('R' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('R' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('R' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('R' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('R' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('R' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('R' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('R' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('R' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('R' . $rows, $emp->emp_name);
                    }

                    switch ($template_rules->S1) {
                        case 'A1':
                            $sheet->setCellValue('S' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('S' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('S' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('S' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('S' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('S' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('S' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('S' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('S' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('S' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('S' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('S' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('S' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('S' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('S' . $rows, $premium);
                    }

                    switch ($template_rules->T1) {
                        case 'A1':
                            $sheet->setCellValue('T' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('T' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('T' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('T' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('T' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('T' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('T' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('T' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('T' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('T' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('T' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('T' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('T' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('T' . $rows, $emp->sum_insured);
                    }

                    switch ($template_rules->U1) {
                        case 'A1':
                            $sheet->setCellValue('U' . $rows, $rows);
                            break;

                        case 'B1':
                            $sheet->setCellValue('U' . $rows, $policy_info->policy_no);
                            break;

                        case 'C1':
                            $sheet->setCellValue('U' . $rows, $emp->mode);
                            break;

                        case 'D1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_id);
                            break;

                        case 'E1':
                            $sheet->setCellValue('U' . $rows, $emp->client_name);
                            break;

                        case 'F1':
                            $sheet->setCellValue('U' . $rows, $emp->relation);
                            break;

                        case 'G1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->dob)));
                            break;

                        case 'H1':
                            $sheet->setCellValue('U' . $rows, $emp->age);
                            break;

                        case 'I1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        case 'J1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->doj)));
                            break;


                        case 'K1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->dol)));
                            break;

                        case 'L1':
                            $sheet->setCellValue('U' . $rows, date("d-m-Y", strtotime($emp->wedd_date)));
                            break;

                        case 'M1':
                            $sheet->setCellValue('U' . $rows, $emp->client_name);
                            break;

                        case 'N1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_name);
                            break;

                        case 'O1':
                            $sheet->setCellValue('U' . $rows, $emp->age);
                            break;

                        case 'P1':
                            $sheet->setCellValue('U' . $rows, $emp->mobile);
                            break;

                        case 'Q1':
                            $sheet->setCellValue('U' . $rows, $emp->email);
                            break;

                        case 'R1':
                            $sheet->setCellValue('U' . $rows, $emp->emp_name);
                            break;

                        case 'S1':
                            $sheet->setCellValue('U' . $rows, $premium);
                            break;

                        case 'T1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        case 'U1':
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                            break;

                        default:
                            $sheet->setCellValue('U' . $rows, $emp->sum_insured);
                    }
                }
                $rows++;
            }
        }
        // die;
        $fileName = 'endorsement_export.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save("external/uploads/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url() . "external/uploads/" . $fileName);
    }



    public function uploadTemplateFormat()
    {
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

                $post = $this->input->post();

                for ($i = 0; $i < count($sheetData); $i++) {
                    $data = [];
                    $data['id'] = $sheetData[$i][0];
                    $data['S_No'] = $sheetData[$i][1];
                    $data['Policy_No'] = $sheetData[$i][2];
                    $data['mode'] = $sheetData[$i][3];
                    $data['Employee_no'] = $sheetData[$i][4];
                    $data['Insured_Name'] = $sheetData[$i][5];
                    $data['Relationship_type'] = $sheetData[$i][6];
                    $data['Date_of_Birth'] = $sheetData[$i][7];
                    $data['Age'] = $sheetData[$i][8];
                    $data['Sum_Insured'] = $sheetData[$i][9];
                    $data['Date_of_Joining'] = $sheetData[$i][10];
                    $data['Date_of_Leaving'] = $sheetData[$i][11];
                    $data['Date_of_Marriage'] = $sheetData[$i][12];
                    $data['Remarks_for_Corrections'] = $sheetData[$i][13];
                    $data['First_Name'] = $sheetData[$i][14];
                    $data['Last_Name'] = $sheetData[$i][15];
                    $data['Mobile_No'] = $sheetData[$i][16];
                    $data['Email'] = $sheetData[$i][17];
                    $data['Endorsement_Effective_Date'] = $sheetData[$i][18];
                    $data['Premium_including_GST'] = $sheetData[$i][19];
                    $data['Wrong_DETAILS'] = $sheetData[$i][20];
                    $data['salary'] = $sheetData[$i][21];
                    $data['company_id'] = $this->input->post('company_id');
                    $data['policy_type'] = $this->input->post('policy_type');
                    $data['endorsement_type'] = $this->input->post('endorsement_type');
                    // print_r($data);
                    // die;
                    $ins = $this->qm->insert('template_master', $data);
                    redirect('clients/template_master');
                }
            } else {
                redirect('clients/template_master');
            }
        }
    }

    public function manualTemplateFormat()
    {


        $post = $this->input->post();

        $data = [];
        $data['S_No'] = $this->input->post('A1');
        $data['Policy_No'] = $this->input->post('B1');
        $data['mode'] = $this->input->post('C1');
        $data['Employee_no'] = $this->input->post('D1');
        $data['Insured_Name'] = $this->input->post('E1');
        $data['Relationship_type'] = $this->input->post('F1');
        $data['Date_of_Birth'] = $this->input->post('G1');
        $data['Age'] = $this->input->post('H1');
        $data['Sum_Insured'] = $this->input->post('I1');
        $data['Date_of_Joining'] = $this->input->post('J1');
        $data['Date_of_Leaving'] = $this->input->post('K1');
        $data['Date_of_Marriage'] = $this->input->post('L1');
        $data['Remarks_for_Corrections'] = $this->input->post('M1');
        $data['First_Name'] = $this->input->post('N1');
        $data['Last_Name'] = $this->input->post('O1');
        $data['Mobile_No'] = $this->input->post('P1');
        $data['Email'] = $this->input->post('Q1');
        $data['Endorsement_Effective_Date'] = $this->input->post('R1');
        $data['Premium_including_GST'] = $this->input->post('S1');
        $data['Wrong_DETAILS'] = $this->input->post('T1');
        $data['salary'] = $this->input->post('U1');
        $data['company_id'] = $this->input->post('company_id');
        $data['policy_type'] = $this->input->post('policy_type');
        $data['endorsement_type'] = $this->input->post('endorsement_type');


        $ins = $this->qm->insert('template_master', $data);

        redirect('clients/template_master');
    }

    public function editemployee($cid, $pid, $eid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {

            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['eid'] = $eid;
            $data['mainContent'] = "clients/editemployee";
            $this->load->view('panel', $data);
        }
    }

    public function updateupload($cid, $pid)
    {
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $policyRelKid = $this->qm->single("fm_relation_tbl", "*", array('cid' => $cid, 'pid' => $pid, 'reltype' => 'Kid'));

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
                $dataArr = [];

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
                    $card = $sheetData[$i][16];
                    $onlycard = (isset($sheetData[$i][17]) && $sheetData[$i][17] == 1) ? true : false;
                    $mode = 'Update';
                    $status = 1;
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

                    if ($relation == "Self") {
                        $check = $this->qm->all('ri_employee_tbl', '*', array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id));
                        // echo $pid . " - " . $cid . " - " . $emp_id,
                        // die;
                        if ($check > 0) {
                            $dataa = array(
                                'data_type' => $data_type,
                                'emp_name' => $corrected_emp,
                                'name' => $corrected_emp,
                                // 'relation' => $corrected_relation,
                                // 'emp_id' => $emp_id,
                                'gender' => $corrected_gender,
                                'dob' => date("Y-m-d", strtotime($this->dateFormat($corrected_age))),
                                'age' => $corrected_age,
                                'premium' => $totalPremium,
                                'annual_premium' => $annualPremium,
                                'covered_days' => $datediff,
                                'previous_premium' => $updateEmployeeData->premium,
                                'reson' => $reason,
                                'card' => $card,
                                'mode' => $mode,
                                'status' => $status,
                            );

                            if ($onlycard) {
                                $dataa = array(
                                    'card' => $card
                                );
                            }

                            if (($corrected_relation == 'Self' && !$onlycard) || $onlycard) {
                                $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id);
                                $this->qm->update('ri_employee_tbl', $dataa, $where);
                            }
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
                    $card = $sheetData[$i][16];
                    $onlycard = (isset($sheetData[$i][17]) && $sheetData[$i][17] == 1) ? true : false;
                    $mode = 'Update';
                    $status = 1;
                    // TODO
                    // $newAge = $this->getAge($corrected_dob);

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
                                'card' => $card,
                                'reson' => $reason,
                                'mode' => $mode,
                                'status' => $status,
                                'updated_on' => date('Y-m-d')
                            );

                            if ($onlycard) {
                                $dataa = array(
                                    'card' => $card
                                );
                            }

                            if ($relation != 'Kid') {
                                $dup = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'emp_id' => $emp_id, 'reltype' => $relation));
                                if (count($dup) > 0) {
                                    $this->qm->update('ri_dependent_tbl', $ddadta, array('cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'reltype' => $relation));
                                    if ($corrected_relation == 'Kid') {
                                        updateKidIndex($cid, $pid, $ctt->eid, $relation);
                                    }
                                }
                            } else {
                                updateKidIndex($cid, $pid, $ctt->eid, $relation);

                                $dup = $this->qm->all('ri_dependent_tbl', '*', array('rel_index' => $rel_index, 'cid' => $cid, 'pid' => $pid, 'emp_id' => $emp_id, 'reltype' => $relation));

                                if (count($dup) > 0) {
                                    $this->qm->update('ri_dependent_tbl', $ddadta, array('rel_index' => $rel_index, 'cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'reltype' => $relation));
                                }
                            }
                        }
                    }
                }
                redirect('clients/employees/' . $cid . '/' . $pid . '');
            } else {
                redirect('clients/uploademployee/' . $cid . '/' . $pid . '');
            }
        }
    }

    public function deleteemp($cid, $pid)
    {
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
                    $status = 0;
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
                    $premium = $updateEmployeeData->premium;
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

                    // ri_employee_tbl
                    // ri_dependent_tbl
                    $ri_employee_tbl = array(
                        'dol' => (!empty($dol)) ? date("Y-m-d", strtotime($this->dateFormat($dol))) : date('Y-m-d'),
                        'previous_premium' => $premium,
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
                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id);
                            $this->qm->update('ri_employee_tbl', $ri_employee_tbl, $where);
                            $this->qm->update('ri_dependent_tbl', $ri_dependent_tbl, $where);
                        }
                    } else {
                        if ($relation != "Kid") {
                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id, 'reltype' => $relation);
                            $check = $this->qm->all('ri_dependent_tbl', '*', $where);
                            if (count($check) > 0) {
                                $this->qm->update('ri_dependent_tbl', $ri_dependent_tbl, $where);
                            }
                        } else {
                            $where = array('pid' => $pid, 'cid' => $cid, 'emp_id' => $emp_id, 'reltype' => $relation, 'rel_index' => $rel_index);
                            $check = $this->qm->all('ri_dependent_tbl', '*', $where);
                            if (count($check) > 0) {
                                $this->qm->update('ri_dependent_tbl', $ri_dependent_tbl, $where);
                            }
                        }
                    }
                }
                redirect('clients/employees/' . $cid . '/' . $pid . '');
            } else {
                redirect('clients/uploademployee/' . $cid . '/' . $pid . '');
            }
        }
    }

    public function uploadmember1($cid, $pid)
    {
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
                    $card = $sheetData[$i][1];
                    $reltype = $sheetData[$i][2];
                    $name = $sheetData[$i][3];
                    $email = $sheetData[$i][4];
                    $phone = $sheetData[$i][5];
                    $gender = $sheetData[$i][6];
                    $dob = $sheetData[$i][7];
                    $age = $sheetData[$i][8];
                    $wedd_date = $sheetData[$i][9];
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
                        'card' => $card,
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
                redirect('clients/employees/' . $cid . '/' . $pid . '');
            } else {
                redirect('clients/uploademployee/' . $cid . '/' . $pid . '');
            }
        }
    }

    public function updatemember($cid, $pid)
    {
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
            //  echo "<pre>";
            //     print_r($sheetData);
            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $cid = $cid;
                    $pid = $pid;
                    $emp_id = $sheetData[$i][5];
                    $name = $sheetData[$i][6];
                    $reltype = $sheetData[$i][9];
                    $email = $sheetData[$i][7];
                    $phone = $sheetData[$i][8];
                    $gender = $sheetData[$i][23];
                    $dob = $sheetData[$i][11];
                    $age = $sheetData[$i][12];
                    $wedd_date = $sheetData[$i][18];
                    $rel_index = $sheetData[$i][10];
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

                    if ($reltype != 'Kid') {
                        $dup = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'emp_id' => $emp_id, 'reltype' => $reltype));
                        if (count($dup) > 0) {
                            continue;
                        }
                    }
                    $upd22 = $this->qm->update('ri_dependent_tbl', $data, array('rel_index' => $rel_index, 'cid' => $cid, $pid => $pid, 'eid' => $eid));

                    // $upd = $this->qm->update('ri_dependent_tbl',$data,);
                    //$upd = $this->qm->update('ri_dependent_tbl',$data,array('cid'=>$cid,$pid=>$pid,'eid'=>$eid));

                }
                redirect('clients/employees/' . $cid . '/' . $pid . '');
            } else {
                redirect('clients/uploademployee/' . $cid . '/' . $pid . '');
            }
        }
    }

    public function manageclients()
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['mainContent'] = "clients/manageclients";
            $this->load->view('panel', $data);
        }
    }

    public function deleteCleint($cid)
    {
        if (!empty($cid)) {
            $tables = array('ri_clientpolicy_tbl', 'client_doc_tbl', 'emp_invite_history', 'fm_escalationmetrix_entry_tbl', 'fm_escalationmetrix_tbl', 'fm_relation_tbl', 'ri_banner_tbl', 'ri_clients_tbl', 'ri_dependent_tbl', 'ri_faq_tbl', 'upload_ppt_ri', 'welcomemsg_tbl');
            $this->db->where('cid', $cid);
            $this->qm->delete($tables, array('cid' => $cid));

            $this->session->set_flashdata('success', 'Client Deleted Successfully');
        }
        redirect("clients/manageclients/");
    }

    public function inactive_employees($cid, $pid)
    {
        if (empty($this->session->userdata('aid'))) {
            redirect('login/index');
        } else {
            $data['cid'] = $cid;
            $data['pid'] = $pid;
            $data['mainContent'] = "clients/inactive_employees";
            $this->load->view('panel', $data);
        }
    }

    public function updateemp($cid, $pid, $eid)
    {
        $clientPolicyDate = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
        $endorsmentCalculations = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));

        $post = $this->input->post();

        // TODO
        // $newAge = $this->getAge($post['dob']);

        $post['mode'] = 'Update';

        if ($post['relation'] == 'Self' || $post['relation'] == 'self') {
            // Get employee old data
            $updateEmployeeData = $this->qm->single("ri_employee_tbl", "*", array('eid' => $eid, 'cid' => $cid, 'pid' => $pid));
            $suminsurede = $updateEmployeeData->sum_insured;
            $doj = $updateEmployeeData->doj;

            // Days
            $datediff = $this->getPremiumDays($doj, $clientPolicyDate->edate);
            // sumInsured data
            $suminsuredId = $this->getPolicySuminsuredData($suminsurede, $cid, $pid);
            // age band data
            $agebandId = $this->getPolicyAgebandData($post['age'], $cid, $pid);
            // annual premium data
            $annualPremium = $this->getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid);
            if ($annualPremium != NULL) {
                if ($endorsmentCalculations->basis_of_calculation == "short_period_scale") {
                    // Get Short Period Scales
                    $shortPeriodScales = $this->getShortPeriodScalesData($datediff, $cid, $pid);
                    $totalPremium = $this->shortPeriodScaleData($shortPeriodScales, $annualPremium);
                } else {
                    // Get pro rata basis
                    $totalPremium = $this->proRataBasisData($datediff, $clientPolicyDate->sdate, $clientPolicyDate->edate, $annualPremium);
                }
            }

            $post['annual_premium'] = $annualPremium;
            $post['premium'] = $totalPremium;
            $post['covered_days'] = $datediff;
            $post['previous_premium'] = $updateEmployeeData->premium;
            $where = array('eid' => $eid);
            $upd = $this->qm->update('ri_employee_tbl', $post, $where);
        }

        if ($post['relation'] != 'Self' || $post['relation'] != 'self') {
            $ctt = $this->qm->single("ri_employee_tbl", "*", array('eid' => $eid, 'cid' => $cid, 'pid' => $pid));
            if ($ctt) {
                $ddadta = array(
                    'name' => $post['name'],
                    'email' => $post['email'],
                    'phone' => $post['mobile'],
                    'reltype' => $post['relation'],
                    'gender' => $post['gender'],
                    'dob' => $post['dob'],
                    'age' => $post['age'],
                    'mode' => $post['mode'],
                    'status' => 1,
                    'wedd_date' => $post['wedd_date'],
                    'updated_on' => date('Y-m-d')
                );

                if ($post['relation'] != 'Kid') {
                    $dup = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => $post['relation']));
                    if (count($dup) > 0) {
                        $upd = $this->qm->update('ri_dependent_tbl', $ddadta, array('cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'reltype' => $post['relation']));
                        if ($post['relation'] == 'Kid') {
                            updateKidIndex($cid, $pid, $ctt->eid, $post['relation']);
                        }
                    }
                } else {
                    updateKidIndex($cid, $pid, $ctt->eid, $post['relation']);
                    $dup = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => $post['relation']));
                    if (count($dup) > 0) {
                        $upd = $this->qm->update('ri_dependent_tbl', $ddadta, array('cid' => $cid, 'pid' => $pid, 'eid' => $ctt->eid, 'reltype' => $post['relation']));
                    }
                }
            }
        }

        if ($upd) {
            redirect('clients/employees/' . $cid . '/' . $pid . '');
        } else {
            redirect('clients/editemployee/' . $cid . '/' . $pid . '/' . $eid . '');
        }
    }

    public function deletemember($cid, $pid)
    {
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
                redirect('clients/employees/' . $cid . '/' . $pid . '');
            } else {
                redirect('clients/uploademployee/' . $cid . '/' . $pid . '');
            }
        }
    }

    public function downloademp($cid, $pid)
    {

        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $cond = " cid='$cid' && pid='$pid' ";
        $test = '';

        if (!empty($this->input->get('empid'))) {
            $findemp = explode(",", $this->input->get('empid'));
            $test .= " && (";
            for ($x = 0; $x < count($findemp); $x++) {
                $test .= " emp_id='$findemp[$x]' || ";
            }
            $cond .= substr($test, 0, -3);
            $cond .= ")";
        }

        if (!empty($this->input->get('emp_name'))) {
            $cond .= " && emp_name like '%" . $this->input->get('emp_name') . "' ";
        }

        $users = $this->qm->all('ri_employee_tbl', '*', $cond);


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
        $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

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

        $sheet->setCellValue('K1', 'Kid Number');
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

        $sheet->setCellValue('W1', 'Reason');
        $spreadsheet->getActiveSheet()->getStyle('W1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('W1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('X1', 'Gender');
        $spreadsheet->getActiveSheet()->getStyle('X1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('X1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('Y1', 'Card Uploaded');
        $spreadsheet->getActiveSheet()->getStyle('Y1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('Y1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        // Add new Columns
        // $sheet->setCellValue('Z1', 'Policy No');
        // $spreadsheet->getActiveSheet()->getStyle('Z1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        // $spreadsheet->getActiveSheet()->getStyle('Z1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AA1', 'Previous Employee Name');
        $spreadsheet->getActiveSheet()->getStyle('AA1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AA1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AB1', 'Previous Email');
        $spreadsheet->getActiveSheet()->getStyle('AB1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AB1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AC1', 'Previous Phone');
        $spreadsheet->getActiveSheet()->getStyle('AC1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AC1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AD1', 'Previous Relation');
        $spreadsheet->getActiveSheet()->getStyle('AD1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AD1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AE1', 'Previous Kid Number');
        $spreadsheet->getActiveSheet()->getStyle('AE1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AE1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AF1', 'Previous DOB');
        $spreadsheet->getActiveSheet()->getStyle('AF1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AF1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AG1', 'Previous Age');
        $spreadsheet->getActiveSheet()->getStyle('AG1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AG1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AH1', 'Previous DOj');
        $spreadsheet->getActiveSheet()->getStyle('AH1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AH1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AI1', 'Previous DOL');
        $spreadsheet->getActiveSheet()->getStyle('AI1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AI1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AJ1', 'Previous Created On');
        $spreadsheet->getActiveSheet()->getStyle('AJ1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AJ1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AK1', 'Previous Deleted On');
        $spreadsheet->getActiveSheet()->getStyle('AK1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AK1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AL1', 'Previous Wedd.Date');
        $spreadsheet->getActiveSheet()->getStyle('AL1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AL1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AM1', 'Previous Mode');
        $spreadsheet->getActiveSheet()->getStyle('AM1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AM1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AN1', 'Previous Status Code');
        $spreadsheet->getActiveSheet()->getStyle('AN1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AN1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AO1', 'Previous Status');
        $spreadsheet->getActiveSheet()->getStyle('AO1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AO1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AP1', 'Previous Reason');
        $spreadsheet->getActiveSheet()->getStyle('AP1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AP1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('AQ1', 'Previous Gender');
        $spreadsheet->getActiveSheet()->getStyle('AQ1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('AQ1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);


        $rows = 2;

        foreach ($users as $val) {

            $pol = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));

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
            $sheet->setCellValue('K' . $rows, '');
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
            $sheet->setCellValue('X' . $rows, $val->gender);
            $sheet->setCellValue('Y' . $rows, (!empty($val->card) && file_exists(FCPATH . 'external/uploads/policy_cards/' . $cid . '_' . $pid . '/' . $val->card . '.pdf')) ? 'Yes' : 'No');

            $employeeUpdatesTbl = $this->qm->all('ri_employee_updates_tbl', '*', array('type' => 'emp', 'tbl_id' => $val->eid));
            if (count($employeeUpdatesTbl) > 0) {
                $empUpdale = json_decode($employeeUpdatesTbl[0]->data);
                // $sheet->setCellValue('Z' . $rows, "");
                $sheet->setCellValue('AA' . $rows, $empUpdale->name);
                $sheet->setCellValue('AB' . $rows, $empUpdale->email);
                $sheet->setCellValue('AC' . $rows, $empUpdale->mobile);
                $sheet->setCellValue('AD' . $rows, $empUpdale->relation);
                $sheet->setCellValue('AE' . $rows, "");
                $sheet->setCellValue('AF' . $rows, getDMYDate($empUpdale->dob, false));
                $sheet->setCellValue('AG' . $rows, $empUpdale->age);
                $sheet->setCellValue('AH' . $rows, getDMYDate($empUpdale->doj, false));
                $sheet->setCellValue('AI' . $rows, getDMYDate($empUpdale->dol, false));
                $sheet->setCellValue('AJ' . $rows, getDMYDate($empUpdale->created_on, false));
                $sheet->setCellValue('AK' . $rows, "");
                $sheet->setCellValue('AL' . $rows, getDMYDate($empUpdale->wedd_date));
                $sheet->setCellValue('AM' . $rows, $empUpdale->mode);
                $sheet->setCellValue('AN' . $rows, $empUpdale->status);
                $sheet->setCellValue('AO' . $rows, getStatusMap($empUpdale->status));
                $sheet->setCellValue('AP' . $rows, $empUpdale->reson);
                $sheet->setCellValue('AQ' . $rows, $empUpdale->gender);
            } else {
                $sheet->setCellValue('AA' . $rows, '');
                $sheet->setCellValue('AB' . $rows, '');
                $sheet->setCellValue('AC' . $rows, '');
                $sheet->setCellValue('AD' . $rows, '');
                $sheet->setCellValue('AE' . $rows, "");
                $sheet->setCellValue('AF' . $rows, '');
                $sheet->setCellValue('AG' . $rows, '');
                $sheet->setCellValue('AH' . $rows, '');
                $sheet->setCellValue('AI' . $rows, '');
                $sheet->setCellValue('AJ' . $rows, '');
                $sheet->setCellValue('AK' . $rows, "");
                $sheet->setCellValue('AL' . $rows, '');
                $sheet->setCellValue('AM' . $rows, '');
                $sheet->setCellValue('AN' . $rows, '');
                $sheet->setCellValue('AO' . $rows, '');
                $sheet->setCellValue('AP' . $rows, '');
                $sheet->setCellValue('AQ' . $rows, '');
            }

            $rows++;

            $dependsData = $this->qm->all('ri_dependent_tbl', '*', array('eid' => $val->eid));

            foreach ($dependsData as $dval) {
                if ($dval->reltype == 'Kid') {
                    updateKidIndex($cid, $pid, $val->eid, $dval->reltype);
                }
            }

            $dependents = $this->qm->all('ri_dependent_tbl', '*', array('eid' => $val->eid));

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
                $sheet->setCellValue('K' . $rows, $valDep->rel_index);
                $sheet->setCellValue('L' . $rows, getDMYDate($valDep->dob, false));
                $sheet->setCellValue('M' . $rows, $valDep->age);
                $sheet->setCellValue('N' . $rows, '');
                $sheet->setCellValue('O' . $rows, getDMYDate($valDep->doj, false));
                $sheet->setCellValue('P' . $rows, getDMYDate($valDep->dol, false));
                $sheet->setCellValue('Q' . $rows, getDMYDate($valDep->created_on, false));
                $sheet->setCellValue('R' . $rows, '');
                $sheet->setCellValue('S' . $rows, (!empty($valDep->wedd_date)) ? getDMYDate($valDep->wedd_date, false) : '');
                $sheet->setCellValue('T' . $rows, $valDep->mode);
                $sheet->setCellValue('U' . $rows, $valDep->status);
                $sheet->setCellValue('V' . $rows, getStatusMap($valDep->status));
                $sheet->setCellValue('W' . $rows, $valDep->reson);
                $sheet->setCellValue('X' . $rows, $valDep->gender);
                $sheet->setCellValue('Y' . $rows, (!empty($valDep->card) && file_exists(FCPATH . 'external/uploads/policy_cards/' . $cid . '_' . $pid . '/' . $valDep->card . '.pdf')) ? 'Yes' : 'No');

                $employeeUpdatesTbl_dep = $this->qm->all('ri_employee_updates_tbl', '*', array('type' => 'dep', 'tbl_id' => $valDep->did));

                if (count($employeeUpdatesTbl_dep) > 0) {
                    $empUpdale_dep = json_decode($employeeUpdatesTbl_dep[0]->data);
                    $sheet->setCellValue('AA' . $rows, $empUpdale_dep->name);
                    $sheet->setCellValue('AB' . $rows, $empUpdale_dep->email);
                    $sheet->setCellValue('AC' . $rows, $empUpdale_dep->mobile);
                    $sheet->setCellValue('AD' . $rows, $empUpdale_dep->reltype);
                    $sheet->setCellValue('AE' . $rows, $empUpdale_dep->rel_index);
                    $sheet->setCellValue('AF' . $rows, getDMYDate($empUpdale_dep->dob, false));
                    $sheet->setCellValue('AG' . $rows, $empUpdale_dep->age);
                    $sheet->setCellValue('AH' . $rows, "");
                    $sheet->setCellValue('AI' . $rows, getDMYDate($empUpdale_dep->dol, false));
                    $sheet->setCellValue('AJ' . $rows, getDMYDate($empUpdale_dep->created_on, false));
                    $sheet->setCellValue('AK' . $rows, "");
                    $sheet->setCellValue('AL' . $rows, getDMYDate($empUpdale_dep->wedd_date));
                    $sheet->setCellValue('AM' . $rows, $empUpdale_dep->mode);
                    $sheet->setCellValue('AN' . $rows, $empUpdale_dep->status);
                    $sheet->setCellValue('AO' . $rows, getStatusMap($empUpdale_dep->status));
                    $sheet->setCellValue('AP' . $rows, $empUpdale_dep->reson);
                    $sheet->setCellValue('AQ' . $rows, $empUpdale_dep->gender);
                } else {
                    $sheet->setCellValue('AA' . $rows, '');
                    $sheet->setCellValue('AB' . $rows, '');
                    $sheet->setCellValue('AC' . $rows, '');
                    $sheet->setCellValue('AD' . $rows, '');
                    $sheet->setCellValue('AE' . $rows, '');
                    $sheet->setCellValue('AF' . $rows, '');
                    $sheet->setCellValue('AG' . $rows, '');
                    $sheet->setCellValue('AH' . $rows, "");
                    $sheet->setCellValue('AI' . $rows, '');
                    $sheet->setCellValue('AJ' . $rows, '');
                    $sheet->setCellValue('AK' . $rows, "");
                    $sheet->setCellValue('AL' . $rows, '');
                    $sheet->setCellValue('AM' . $rows, '');
                    $sheet->setCellValue('AN' . $rows, '');
                    $sheet->setCellValue('AO' . $rows, '');
                    $sheet->setCellValue('AP' . $rows, '');
                    $sheet->setCellValue('AQ' . $rows, '');
                }
                $rows++;
            }
        }

        $fileName = $val->client_code . 'employee_export.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save("external/uploads/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url() . "external/uploads/" . $fileName);
    }

    public function empexcel($cid, $pid)
    {
        $users = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid));

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Card');
        // $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('B1', 'Emp. Id');
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('C1', 'Emp. Name');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('D1', 'Name');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('E1', 'Email');
        $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('F1', 'Phone');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('G1', 'Relation');
        $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('H1', 'Gender');
        $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('H1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('I1', 'Wedd.Date');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('J1', 'DOB');
        $spreadsheet->getActiveSheet()->getStyle('J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('J1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('K1', 'Age');
        $spreadsheet->getActiveSheet()->getStyle('K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('K1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $rows = 2;

        foreach ($users as $val) {
            $sheet->setCellValue('A' . $rows, $val->card);
            $sheet->setCellValue('B' . $rows, $val->emp_id);
            $sheet->setCellValue('C' . $rows, $val->emp_name);
            $sheet->setCellValue('D' . $rows, $val->name);
            $sheet->setCellValue('E' . $rows, $val->email);
            $sheet->setCellValue('F' . $rows, $val->phone);
            $sheet->setCellValue('G' . $rows, $val->relation);
            $sheet->setCellValue('H' . $rows, $val->gender);
            $sheet->setCellValue('I' . $rows, $val->wedd_date);
            $sheet->setCellValue('J' . $rows, $val->dob);
            $sheet->setCellValue('K' . $rows, $val->age);
            $rows++;
        }





        $fileName = $val->client_code . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save("external/uploads/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url() . "external/uploads/" . $fileName);
    }

    //join($table, $columnArr, $dataArr, $joinType='INNER', $where=NULL, $searchArr=array(),$searchType='both', $groupBy = '', $orderColumn = '', $orderBy = 'ASC', $limit = NULL, $offset = 0, $resultType = null) {   

    public function depexcel($cid, $pid)
    {
        $users = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid));


        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Emp. Id');

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('B1', 'Rel. Type');

        $spreadsheet->getActiveSheet()->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('C1', 'Name');

        $spreadsheet->getActiveSheet()->getStyle('C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('D1', 'Email');

        $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('E1', 'Phone');

        $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->setCellValue('F1', 'Gender');

        $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('G1', 'DOB');

        $spreadsheet->getActiveSheet()->getStyle('G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('H1', 'Age');

        $spreadsheet->getActiveSheet()->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('H1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->setCellValue('I1', 'Wedd.Date');

        $spreadsheet->getActiveSheet()->getStyle('I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
        $spreadsheet->getActiveSheet()->getStyle('I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $rows = 2;

        foreach ($users as $val) {

            $sheet->setCellValue('A' . $rows, $val->emp_id);
            $sheet->setCellValue('B' . $rows, $val->reltype);
            $sheet->setCellValue('C' . $rows, $val->name);
            $sheet->setCellValue('D' . $rows, $val->email);
            $sheet->setCellValue('E' . $rows, $val->phone);

            $sheet->setCellValue('F' . $rows, $val->gender);
            $sheet->setCellValue('G' . $rows, $val->dob);
            $sheet->setCellValue('H' . $rows, $val->age);
            $sheet->setCellValue('I' . $rows, $val->wedd_date);

            $rows++;
        }
        $cl = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid));
        foreach ($cl as $cl);
        $fileName = $cl->client_code . '-dependent.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save("external/uploads/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url() . "external/uploads/" . $fileName);
    }

    public function uplcard($cid, $pid)
    {
        $this->load->library('upload');
        $image = array();
        $ImageCount = count($_FILES['card']['name']);
        for ($i = 0; $i < $ImageCount; $i++) {

            $response = [
                'status' => false,
                'message' => 'Unable to upload card'
            ];

            $_FILES['file']['name'] = $_FILES['card']['name'][$i];
            $_FILES['file']['type'] = $_FILES['card']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['card']['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES['card']['error'][$i];
            $_FILES['file']['size'] = $_FILES['card']['size'][$i];

            // File upload configuration
            $uploadPath = './external/uploads/policy_cards/' . $cid . '_' . $pid;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, TRUE);
            }
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|pdf|gif|zip';
            $config['max_size'] = '900000000000000';
            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                // Uploaded file data
                $imageData = $this->upload->data();
                if ($imageData['file_ext'] == '.zip') {
                    $zip = new ZipArchive;
                    if ($zip->open($imageData['full_path']) === TRUE) {
                        $zip->extractTo(FCPATH . $uploadPath);
                        $zip->close();
                        unlink($imageData['full_path']);
                    }
                    // $params = array('success' => 'Extracted successfully!');
                }
                $uploadImgData[$i]['card'] = $imageData['file_name'];
                $response['status'] = true;
                $response['message'] = 'Card uploaded';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function multiupload($name, $cid, $pid, $post)
    {

        $this->load->library('upload');
        $image = array();
        $ImageCount = count($_FILES[$name]['name']);
        for ($i = 0; $i < $ImageCount; $i++) {
            $_FILES['file']['name'] = $_FILES[$name]['name'][$i];
            $_FILES['file']['type'] = $_FILES[$name]['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES[$name]['tmp_name'][$i];
            // $_FILES['file']['error']      = $_FILES[$name]['error'][$i];
            //$_FILES['file']['size']       = $_FILES[$name]['size'][$i];

            // File upload configuration
            $uploadPath = './external/uploads/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|pdf|gif';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                // Uploaded file data
                $imageData = $this->upload->data();
                $uploadImgData[$i]['card'] = $imageData['file_name'];

                $post['ppt'] = $post;
                $post['cid'] = $cid;
                $post['pid'] = $pid;
                $pp = $this->qm->insert("upload_ppt_ri", $post);
            }
        }

        if ($pp) {
            $this->session->set_flashdata('success', 'Added Successfully');
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        } else {
            $this->session->set_flashdata('error', 'Some Error Occurred');
            redirect('clients/clientdetail/' . $cid . '/' . $pid . '');
        }



        // redirect('clients/employees/'.$cid.'/'.$pid.'');
    }

    public function test()
    {
        $data = json_decode(file_get_contents('https://crm.riskbirbal.com/admin/api/api/index_get/?tb=pol&show=pol1001'), true);
        print_r($data);
    }

    public function focusedclaim()
    {
        $data['mainContent'] = "clients/focusedclaim";
        $this->load->view('panel', $data);
    }

    public function cashless()
    {
        $data['mainContent'] = "clients/cashless";
        $this->load->view('panel', $data);
    }

    public function reimbursement()
    {
        $data['mainContent'] = "clients/reimbursement";
        $this->load->view('panel', $data);
    }

    public function completechecklist()
    {
        $data['mainContent'] = "clients/completechecklist";
        $this->load->view('panel', $data);
    }

    public function clientsfaq()
    {
        $data['mainContent'] = "clients/clientsfaq";
        $this->load->view('panel', $data);
    }

    public function confidential()
    {
        $data['mainContent'] = "clients/confidential";
        $this->load->view('panel', $data);
    }

    public function deleteemployee($cid, $pid, $eid, $type)
    {

        /*if($type=='Self')
        {
        $this->qm->update("ri_employee_tbl",array('status'=>'0','mode'=>'Deletion'),array('eid'=>$eid));
        $this->qm->update("ri_dependent_tbl",array('status'=>'0','mode'=>'Deletion'),array('eid'=>$eid,'cid'=>$cid,'pid'=>$pid));
        }*/
        if ($type == 'Self' || $type == 'self') {
            $this->qm->delete("ri_employee_tbl", array('eid' => $eid, 'cid' => $cid, 'pid' => $pid));
            $this->qm->delete("ri_dependent_tbl", array('eid' => $eid, 'cid' => $cid, 'pid' => $pid));
        }

        redirect("clients/employees/" . $cid . "/" . $pid);
    }

    public function uploadmember($cid, $pid)
    {

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
            //print_r($sheetData);
            if (!empty($sheetData)) {
                for ($i = 1; $i < count($sheetData); $i++) {
                    $pro_id = $sheetData[$i][0];
                    $cat_id = $sheetData[$i][1];
                    $cat = $sheetData[$i][2];
                    $tags = $sheetData[$i][3];
                    $scat_id = $sheetData[$i][4];
                    $sscat_id = $sheetData[$i][5];
                    $brand_id = $sheetData[$i][6];
                    $pro_name = $sheetData[$i][7];
                    $sku = $sheetData[$i][8];
                    $pro_url = $sheetData[$i][9];
                    $pro_image = $sheetData[$i][10];
                    $pro_actual_price = $sheetData[$i][11];
                    $pro_discounted_price = $sheetData[$i][12];
                    $vendor_price = $sheetData[$i][13];
                    $min_order = $sheetData[$i][14];
                    $max_order = $sheetData[$i][15];
                    $jump_value = $sheetData[$i][16];
                    $variable_price = $sheetData[$i][17];
                    $qty = $sheetData[$i][18];
                    $length = $sheetData[$i][19];
                    $width = $sheetData[$i][20];
                    $height = $sheetData[$i][21];
                    $weight = $sheetData[$i][22];
                    $deal_of_day = $sheetData[$i][23];
                    $best_selling = $sheetData[$i][24];
                    $pro_featured = $sheetData[$i][25];
                    $is_taxable = $sheetData[$i][26];
                    $pro_short_description = $sheetData[$i][27];
                    $pro_description = $sheetData[$i][27];
                    $aditionalinfo = $sheetData[$i][29];
                    $storepolicy = $sheetData[$i][30];
                    $status = $sheetData[$i][31];
                    $created_on = date('Y-m-d H:i');

                    /*$data= array(
                    'cid' => $cid,
                    'pid' => $pid,
                    'eid' => $eid,
                    'emp_id' => $emp_id,
                    'card' => $card,
                    'reltype' => $reltype,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'gender' => $gender,
                    'dob' => date("Y-m-d", strtotime($dob)),
                    'age' => $age,
                    'wedd_date' =>date("Y-m-d",strtotime($wedd_date)), 
                    'status' => $status,
                    'updated_on' => $updated_on,
                    );*/
                    $data = array(
                        'pro_id' => $pro_id,
                        'cat_id' => $cat_id,
                        'cat' => $cat,
                        'tags' => $tags,
                        'scat_id' => $scat_id,
                        'sscat_id' => $sscat_id,
                        'brand_id' => $brand_id,
                        'pro_name' => $pro_name,
                        'sku' => $sku,
                        'pro_url' => $pro_url,
                        'pro_image' => $pro_image,
                        'pro_actual_price' => $pro_actual_price,
                        'pro_discounted_price' => $pro_discounted_price,
                        'vendor_price' => $vendor_price,
                        'min_order' => $min_order,
                        'max_order' => $max_order,
                        'jump_value' => $jump_value,
                        'variable_price' => $variable_price,
                        'qty' => $qty,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'weight' => $weight,
                        'deal_of_day' => $deal_of_day,
                        'best_selling' => $best_selling,
                        'pro_featured' => $pro_featured,
                        'is_taxable' => $is_taxable,
                        'pro_short_description' => $pro_short_description,
                        'pro_description' => $pro_description,
                        'aditionalinfo' => $aditionalinfo,
                        'storepolicy' => $storepolicy,
                        'status' => '1',
                        'created_on' => date('Y-m-d H:i'),
                    );

                    $ins = $this->qm->insert('akt_product_tbl', $data);

                    echo "success";
                }
                print_r('');
                //redirect('clients/employees/'.$cid.'/'.$pid.'');
                echo "success";
            } else {
                redirect('clients/uploademployee/' . $cid . '/' . $pid . '');
            }
        }
    }

    public function pptdel($cid, $pid)
    {
        $id = $this->input->post('id');
        $dataDelete = $this->qm->delete("upload_ppt_ri", array('id' => $id, 'cid' => $cid, 'pid' => $pid));
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $this->load->view('clients/ppt', $data);
    }

    public function pptdelAll($cid, $pid)
    {
        $dataDelete = $this->qm->delete("upload_ppt_ri", array('cid' => $cid, 'pid' => $pid));
        $data['cid'] = $cid;
        $data['pid'] = $pid;
        $this->load->view('clients/ppt', $data);
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
    public function getPolicyPremiumData($suminsuredId, $agebandId, $cid, $pid)
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

    // Delete Client Policies
    public function deleteClientPolicies($id, $cid)
    {
        if (!empty($cid) && !empty($id)) {
            $this->qm->delete("ri_clientpolicy_tbl", array('id' => $id, 'cid' => $cid));
            $this->qm->delete("ri_employee_tbl", array('pid' => $id, 'cid' => $cid));
            $this->qm->delete("ri_dependent_tbl", array('pid' => $id, 'cid' => $cid));
            // $this->qm->delete("emp_invite_history", array('cid' => $cid));
            // $this->qm->delete("ri_clients_tbl", array('cid' => $cid));
            // $tables = array('client_doc_tbl', 'fm_escalationmetrix_entry_tbl', 'fm_escalationmetrix_tbl', 'fm_relation_tbl', 'ri_banner_tbl', 'ri_dependent_tbl','ri_employee_tbl', 'ri_faq_tbl', 'upload_ppt_ri', 'welcomemsg_tbl');
            // $this->qm->where('pid', $id);
            // $this->qm->where('cid', $cid);
            // $this->qm->delete($tables, array('cid' => $cid));

            $this->session->set_flashdata('success', 'Client Deleted Successfully');
        }
        redirect("clients/clientpolicies/");
    }
    public function RulesTemplateFormat()
    {
        $post = $this->input->post();

        $data = [];

        $data['cname'] = $this->input->post('company_id');
        $data['policy_type'] = $this->input->post('policy_type');
        $data['endorsement_type'] = $this->input->post('endorsement_type');
        $data['A1'] = $this->input->post('A1');
        $data['B1'] = $this->input->post('B1');
        $data['C1'] = $this->input->post('C1');
        $data['D1'] = $this->input->post('D1');
        $data['E1'] = $this->input->post('E1');
        $data['F1'] = $this->input->post('F1');
        $data['G1'] = $this->input->post('G1');
        $data['H1'] = $this->input->post('H1');
        $data['I1'] = $this->input->post('I1');
        $data['J1'] = $this->input->post('J1');
        $data['K1'] = $this->input->post('K1');
        $data['L1'] = $this->input->post('L1');
        $data['M1'] = $this->input->post('M1');
        $data['N1'] = $this->input->post('N1');
        $data['O1'] = $this->input->post('O1');
        $data['P1'] = $this->input->post('P1');
        $data['Q1'] = $this->input->post('Q1');
        $data['R1'] = $this->input->post('R1');
        $data['S1'] = $this->input->post('S1');
        $data['T1'] = $this->input->post('T1');
        $data['U1'] = $this->input->post('U1');


        $ad = $this->qm->insert("template_rules", $post);
        if ($ad) {
            $this->session->set_flashdata('success', 'Added Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/template_master/');
    }
    public function downloadCard()
    {
        $file_exists = file_exists(FCPATH . 'external/uploads/policy_cards/' . $_GET['cid'] . '_' . $_GET['pid'] . '/' . $_GET['cardid'] . '.pdf') ? 1 : 0;
        if (!$file_exists) {
            $fileName = $_GET['cardid'] . ".pdf";
            $file_location = 'external/uploads/create_new_policy_cards/' . $_GET['cid'] . '_' . $_GET['pid'] . '/';
            if (!is_dir($file_location)) {
                mkdir($file_location, 0777, TRUE);
            }
            $cardData['a'] = base_url() . $file_location . $fileName;
            $cardData['employee'] = $this->qm->all('ri_employee_tbl', '*', array('cid' => $_GET['cid'], 'pid' => $_GET['pid'], 'emp_id' => $_GET['emp_id']))[0];
            $cardData['dependent'] = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $_GET['cid'], 'pid' => $_GET['pid'], 'emp_id' => $_GET['emp_id']));
            $this->load->view('employeeCard', $cardData);
            $html = $this->output->get_output();
            $this->load->library('pdf');
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            // A4, landscape, portrait
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            file_put_contents($file_location . $fileName, $pdf);
        } else {
            $data['a'] = base_url() . 'external/uploads/policy_cards/' . $_GET['cid'] . '_' . $_GET['pid'] . '/' . $_GET['cardid'] . '.pdf';
            $data['employee'] = $this->qm->all('ri_employee_tbl', '*', array('cid' => $_GET['cid'], 'pid' => $_GET['pid'], 'emp_id' => $_GET['emp_id']))[0];
            $data['dependent'] = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $_GET['cid'], 'pid' => $_GET['pid'], 'emp_id' => $_GET['emp_id']));
            $this->load->view('employeeCard', $data);
        }
    }
}
