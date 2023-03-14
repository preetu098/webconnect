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
            $data['mainContent'] = "clients/index";
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

            $dat =  $this->qm->upload('./external/uploads/', 'image');

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
            $dat =  $this->qm->upload('./external/uploads/', 'image');
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

            $decode = $this->qm->all2("ad_policy", "*", array('policy_type_id' => $typ));
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
        $img =  $this->qm->upload('./external/uploads/', 'iimage');
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
        } else {
            $in = $this->qm->insert('endorsment_calculations', $postdata);
        }

        redirect("clients/clientdetail/$cid/$pid", $data);
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
            $data['endorscalc'] = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
            $this->load->view('clients/endorscalc', $data);
        } else {
            echo  "Some Error Occurred";
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
        $post['created_on'] = $cid;
        $post['modified_on'] = $cid;

        $ad = $this->qm->insert("short_period_scales", $post);
        if ($ad) {
            $this->session->set_flashdata('success', 'Added Successfully');
        }
        $this->session->set_flashdata('error', 'Somthing went wrong!');
        redirect('clients/shortperiodscale/' . $cid . '/' . $pid . '');
    }

    public function updShortperiodscale($cid, $pid, $id)
    {
        $data = [];
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
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
                $_FILES['file']['name']     = $_FILES['ppt']['name'][$i];
                $_FILES['file']['type']     = $_FILES['ppt']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['ppt']['tmp_name'][$i];
                $_FILES['file']['error']     = $_FILES['ppt']['error'][$i];
                $_FILES['file']['size']     = $_FILES['ppt']['size'][$i];

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
            $data =  $this->qm->upload('./external/uploads/', 'banner_img');

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
            $data =  $this->qm->upload('./external/uploads/', 'card');
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

            $link =  $this->qm->upload('./external/uploads/', 'docu_link');
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

    public function updpolicy($pid)
    {
        $post = $this->input->post();
        $img =  $this->qm->upload('./external/uploads/', 'iimage');
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
                                'status' => '1', //new member status
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
                                'dob' => date("Y-m-d", strtotime($this->dateFormat($corrected_age))),
                                'age' => $age,
                                'premium' => $totalPremium,
                                'annual_premium' => $annualPremium,
                                'covered_days' => $datediff,
                                'previous_premium' => $updateEmployeeData->premium,
                                'reson' => $reason,
                                'card' => $card,
                                'mode' => $mode,
                                'status' => $status,
                            );

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
                    $card = $sheetData[$i][16];
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

            $_FILES['file']['name']       = $_FILES['card']['name'][$i];
            $_FILES['file']['type']       = $_FILES['card']['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES['card']['tmp_name'][$i];
            $_FILES['file']['error']      = $_FILES['card']['error'][$i];
            $_FILES['file']['size']       = $_FILES['card']['size'][$i];

            // File upload configuration
            $uploadPath = './external/uploads/policy_cards/' . $cid . '_' . $pid;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, TRUE);
            }
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|pdf|gif';
            $config['max_size']    = '900000000000000';
            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                // Uploaded file data
                $imageData = $this->upload->data();
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
            $_FILES['file']['name']       = $_FILES[$name]['name'][$i];
            $_FILES['file']['type']       = $_FILES[$name]['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES[$name]['tmp_name'][$i];
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
