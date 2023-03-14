<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee extends MY_Controller 
{

	public function __construct() {
		Parent::__construct();
		$this->load->model('employeeModel');
	}

	public function register($cid,$pid)
	{
		$data['cid'] = $cid;       
		$data['pid'] = $pid;       
	    $this->load->view('employee/register',$data);
	}
    
    
    	public function forgetpass()
	{
        /*$data['cid'] = $cid;       
		$data['pid'] = $pid;
        $data['eid'] = $eid;*/
	    //print_r($_POST);
	    if($this->input->post())
	    {
	        $chek = $this->qm->single("ri_employee_tbl","*",array('username'=>$this->input->post('username'),'email'=>$this->input->post('regname')));
	        //print_r($chek);die;
	        if($chek->cid)
	        {
	            $message="Hello ".$chek->emp_name.",";
                $message.="<p>There was recently a request to change the password on your account, if you requested this password change for the Portal Wellconnect account associated with ".$chek->email.".</p>";
                //$message.="<p>No changes have been made to your account yet.</p>";
                $message.="<p>You can reset your password by clicking the link below:</p>";
                $message.="<a href='".base_url('employee/chngpass/'.$chek->cid.'/'.$pid.'/'.$eid)."'>Reset Password</a>";
                $message.="<p>If you did not request a new password, please ignore this mail.</p>";
                $message.="<p>Yours,</p>";
                $message.="<p>The Wellconnect Team</p>";

	            //send_smtp_mail("manoj2karn@gmail.com", $chek->email, "Change Password for wellconnect portal", $message);
	            send_smtp_mail($chek->email,"wellconnect@riskbirbal.com", "Change Password for wellconnect portal", $message);
	            echo "<script>alert('Password reset link is sent at your registered email, Please change your password from there!');window.location='".base_url('employee/index')."';</script>";
	        }else{
	            echo "<script>alert('Please check the username and Registered Email, The data provided is not matching');window.location='".base_url('employee/forgetpass')."';</script>";
	        }
	    }
	    
	    $this->load->view('employee/forgetpass',$data);
	}
	
	
	
	public function chngpass($cid,$pid,$eid)
	{
     $data['cid'] = $cid;       
		$data['pid'] = $pid;
        $data['eid'] = $eid;
	    if($this->input->post())
	    {
	        if($this->input->post('reenterpass')==$this->input->post('pass'))
	        {
	            $this->qm->update("ri_employee_tbl",array('password'=>$this->input->post('pass'),array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid)));
	            echo "<script>alert('Password changed successfully, Please login to continue!!');window.location='".base_url('employee')."'</script>";
	        }else{
	            echo "<script>alert('Password and Re enter password is not matching, Please try again');window.location='".base_url('employee/chngpass/'.$cid)."'</script>";
	        }
	    }
	    $this->load->view('client/resetpass',$data);
	}

	public function reg($cid,$pid)
	{
		$pot = $this->input->post();
	    
	    extract($pot);
	    
	    $post = array(
	        'cid'=>$cid,
            'pid'=>$pid,
            'data_type' => 1,
            'emp_id' => $emp_id,
            'username' => $username,
            'password' => $password,
            'emp_name' => $name,
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'relation' => 'Self'
	    );
	
        $oldEntry = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'emp_id'=>$emp_id));
        
        if(count($oldEntry) > 0) {
            $this->session->set_flashdata('err', 'Employee ID already registered');
            redirect('/employee/register/'.$cid.'/'.$pid.'');
            exit;
        }

		$ins = $this->employeeModel->addEmployee($post);

		if($ins){
        	redirect('employee/login');
		}
		else{
			redirect('employee/register'.$cid.'/'.$pid.'');
		}
	}

	/*public function login($cid,$pid,$eid)
	{	
	  $data['cid'] = $cid;       
		$data['pid'] = $pid;
        $data['eid'] = $eid;
		$this->load->view('employee/login');
	}*/
	
	public function login()
	{
	  
		$this->load->view('employee/login');
	}

	public function log()
	{	
	
             $emp_id =$this->input->post('emp_id');
             $username = $this->input->post('username');
             $password = $this->input->post('password');
             $status = 0;
            
             $data = $this->qm->single("ri_employee_tbl","*", "username= '".$username."' && password='".$password."' && emp_id='".$emp_id."' && status !='".$status."'"); 
            
             if($data->eid > 0 )
                {
                    $this->session->set_userdata('eid',$data->eid);
                    $this->session->set_userdata('name',$data->name);
                    $this->session->set_userdata('cid',$data->cid);
                    $this->session->set_userdata('pid',$data->pid);
                    
                    
                    $cid = $this->session->userdata('cid');
                    $pid = $this->session->userdata('pid');
                    $eid = $this->session->userdata('eid');
                    
                    
                    if(!empty($this->session->userdata('eid')))
                    {
                        redirect("employee/dashboard/".$cid.'/'.$pid.'/'.$eid."");
                    }else{
                        $this->session->set_flashdata('error', 'Due to technical problem, you are unable to login');
                      redirect("employee/login/");
                    }
                }else{
                    $this->session->set_flashdata('error', 'Invalid User ID and Password');
                    redirect("employee/login/");
                }

            
	}


	public function loggedin($cid,$pid,$eid,$user,$pass)
	{	
	
           
             $status = 0;
            
             $data = $this->qm->single("ri_employee_tbl","*", "username= '".$user."' && password='".$pass."' && cid = '".$cid."' && pid = '".$pid."' && eid = '".$eid."' && status !='".$status."'"); 
            
             if($data->eid > 0 )
                {
                    $this->session->set_userdata('pid',$data->pid);
                    $this->session->set_userdata('cid',$data->cid);
                    $this->session->set_userdata('eid',$data->eid);
                    $this->session->set_userdata('name',$data->name);
                    
                    if(!empty($this->session->userdata('eid')))
                    {
                        redirect("employee/dashboard/".$cid.'/'.$pid.'/'.$eid."");
                    }else{
                        $this->session->set_flashdata('error', 'Due to technical problem, you are unable to login');
                      redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
                    }
                }
                else{
                    $this->session->set_flashdata('error', 'Invalid User ID and Password');
                   redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
                }
 
	}
public function logout($cid,$pid,$eid)
    {
        $this->session->unset_userdata('cid');
        redirect('employee/login');
    }
    
	public function dashboard($cid,$pid,$eid,$edit=null)
	{
		if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
           {
              redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");

           }
           else{ 
             
              $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
              $where['employee_id'] = $eid;
              
              if($edit!=null)
              {
                  $data['edit'] = $edit;
              }
              $res = $this->qm->single('emp_images', '*',$where);
              if(!empty($res)){
                $data['image'] = $res->image;
              }
              
              
              
           $data['mainContent'] = "employee/dashboard";
        $this->load->view('epanel',$data);
        }
	}
	
		public function viewmedicalcard($cid,$pid,$eid,$edit=null)
	{
			if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
           {
              redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");

           }
           else{ 
             
              $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
              if($edit!=null)
              {
                  $data['edit'] = $edit; 
              }
              
               $res = $this->qm->single('emp_images', '*',array('employee_id'=>$eid));
              if(!empty($res)){
                $data['image'] = $res->image;
              }
              
              
           $data['mainContent'] = "employee/viewcard";
        $this->load->view('epanel',$data);
        }
	}
	
	public function profile($cid,$pid,$eid)
	{
		if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
           {
              redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");
           }
           else{
              $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
              
              $res = $this->qm->single('emp_images', '*',array('employee_id'=>$eid));
			  
              if(!empty($res)){
                $data['image'] = $res->image;
              }
              
            $data['mainContent'] = "employee/view-detail";
            $this->load->view('epanel',$data);
        }
	}

	public function updme($cid,$pid,$eid)
	{
		$post = $this->input->post();
		if(!empty($_FILES['pimage']['name'])){
		$data =  $this->qm->upload('./external/uploads/','pimage');
		}	
		else{
			$uemp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
	        foreach ($uemp as $uemp);

	        $data = $uemp->pimage;
		}
		$post['pimage'] = $data;
		$post['emp_name'] = $this->input->post('name');
		$where = array(
			'cid'=>$cid,
			'pid'=>$pid,
			'eid'=>$eid,
					);
		
		$upd =$this->qm->update('ri_employee_tbl',$post,$where);
		if($upd){

			$this->session->set_flashdata('upd', 'Updated Successfully');
            redirect('employee/profile/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('upde', 'Updation Failed');
            redirect('employee/profile/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		

	}
	
	
	public function updself($cid,$pid,$eid)
	{
	    if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    if($this->input->post())
	    {
			$post = $this->input->post();
			$post['eid'] = $eid;
			$post['pid'] = $pid;
			$post['cid'] = $cid;
			$upd = $this->employeeModel->updateEmployee($post);
			if($upd){
				$this->session->set_flashdata('succes', 'Updated Successfully');
				redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
			}else{
				$this->session->set_flashdata('err', 'Updation Failed');
				redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
			}
	    }
	    
	    $data['cid'] = $cid;     
		$data['pid'] = $pid;     
		$data['eid'] = $eid; 
	    $data['mainContent'] = "employee/self_edit";
        $this->load->view('epanel',$data);
	}

	public function updpass($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
		$opass = $this->input->post('opass');
        $newpass = $this->input->post('npass');
        $cpass = $this->input->post('cpass');


        if($newpass == $cpass){
            

            $check = $this->qm->all("ri_employee_tbl","*",array('password'=>$opass));
             
            if($check){
            

                $data = array(
                    'password'=>$newpass,
                );

                $where = array(
                    'eid'=>$eid,
                );
                $upd = $this->qm->update("ri_employee_tbl",$data,$where);
               
                if($upd){

							$this->session->set_flashdata('chnpass', 'Updated Successfully');
				            redirect('employee/profile/'.$cid.'/'.$pid.'/'.$eid.'');

						}
						else{
							$this->session->set_flashdata('echnpass', 'Updation Failed');
				            redirect('employee/profile/'.$cid.'/'.$pid.'/'.$eid.'');
						}
            }
        }
        else{
        	$this->session->set_flashdata('notequal', 'New Password and Confirm Password Is No Equal');
			redirect('employee/profile/'.$cid.'/'.$pid.'/'.$eid.'');
        }
	}

	public function dependents($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
		if(empty($this->session->userdata('eid')))
           {
              redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");

           }
           else{ 
             
              $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid;     
              
           $data['mainContent'] = "employee/dependents";
		   
        $this->load->view('epanel',$data);
    }
	}

	public function updspouse($cid,$pid,$eid)
	{
	    if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    if($this->input->post()){
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Spouse';
        $post['mode'] = 'New Addition';
		$post['status'] = 3; //New member Addition
		$post['updated_on'] = date('Y-m-d');

		

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);


		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$post['mode'] = 'Correction';
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		
	    }
	    $empRec = $this->qm->all('ri_employee_tbl','*',array('eid'=>$eid));
	     $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
              $data['emp_id'] = (count($empRec) > 0) ? $empRec[0]->emp_id : '';
	     $data['mainContent'] = "employee/spouse_edit";
        $this->load->view('epanel',$data);
	}
	public function motherinlaw($cid,$pid,$eid)
	{
	    
	    if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    if($this->input->post()){
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Mother In Law';
		$post['mode'] = 'New Addition';
		$post['status'] = '3'; //New member addition.
		$post['updated_on'] = date('Y-m-d');

		

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);


		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	    }
		$data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
			  $empRec = $this->qm->all('ri_employee_tbl','*',array('eid'=>$eid));
              $data['emp_id'] = (count($empRec) > 0) ? $empRec[0]->emp_id : '';
	     $data['mainContent'] = "employee/motherinlaw_edit";
        $this->load->view('epanel',$data);
	}
	public function mother($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    if($this->input->post()){
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Mother';
		$post['mode'] = 'New Addition';
		$post['status'] = '3'; //New member addition.
		$post['updated_on'] = date('Y-m-d');

		

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);


		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	    }
	    $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
			  $empRec = $this->qm->all('ri_employee_tbl','*',array('eid'=>$eid));
              $data['emp_id'] = (count($empRec) > 0) ? $empRec[0]->emp_id : '';
	     $data['mainContent'] = "employee/mother_edit";
        $this->load->view('epanel',$data);
	}
	public function fatherinlaw($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    if($this->input->post()){
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Father In Law';
		$post['mode'] = 'New Addition';
		$post['status'] = '3'; //New member addition.
		$post['updated_on'] = date('Y-m-d');

		

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);


		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}
		$data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
			  $empRec = $this->qm->all('ri_employee_tbl','*',array('eid'=>$eid));
              $data['emp_id'] = (count($empRec) > 0) ? $empRec[0]->emp_id : '';
	     $data['mainContent'] = "employee/fatherinlaw_edit";
        $this->load->view('epanel',$data);
	}

	public function father($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    if($this->input->post()){
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Father';
		$post['mode'] = 'New Addition';
		$post['status'] = '3'; //New member addition.
		$post['updated_on'] = date('Y-m-d');

		

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);


		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	    }
	     $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
			  $empRec = $this->qm->all('ri_employee_tbl','*',array('eid'=>$eid));
              $data['emp_id'] = (count($empRec) > 0) ? $empRec[0]->emp_id : '';
	     $data['mainContent'] = "employee/father_edit";
        $this->load->view('epanel',$data);
	}

	public function addkid($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    if($this->input->post()){
		$post = $this->input->post();
		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Kid';
        $post['mode'] = 'New Addition';
		$post['status'] = 3;
		$post['updated_on'] = date('Y-m-d');

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);

		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
		    $post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('employee/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}

	 $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
              $empRec = $this->qm->all('ri_employee_tbl','*',array('eid'=>$eid));
              $data['emp_id'] = (count($empRec) > 0) ? $empRec[0]->emp_id : '';
              $data['did'] = (!empty($this->input->get('did'))) ? $this->input->get('did') : 0;
	     $data['mainContent'] = "employee/kid_edit";
        $this->load->view('epanel',$data);
	}
	
	
	
	
	public function myupdates($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid;
	    $data['mainContent'] = "employee/myupdates";
        $this->load->view('epanel',$data);
	}
	
	public function value($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid;
	    $data['mainContent'] = "employee/value";
        $this->load->view('epanel',$data);
	}
	
	public function contactus($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
	    $data['mainContent'] = "employee/contact-us";
        $this->load->view('epanel',$data);
	}
	
	
	public function test()
	{
	    $newdb = $this->qm->newdb123("ad_crm_account");
	    print_r($newdb);
	}
	
	public function employeeviewcard($cid,$pid,$eid)
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	     $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
	    $data['mainContent'] = "employee/employeeviewcard";
        $this->load->view('epanel',$data);
	}
	
	
	public function focusedclaim($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        $data['mainContent'] = "employee/focusedclaim";
        $this->load->view('epanel',$data);
    }
    
    
    public function faq($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
         $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        $data['mainContent'] = "employee/faq";
        $this->load->view('epanel',$data);
    }
    public function cashless($cid,$pid,$eid)
    { 
        if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
         $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        $data['mainContent'] = "employee/cashless";
        $this->load->view('epanel',$data);
    }
    
    public function completechecklist($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
         $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        $data['mainContent'] = "employee/completechecklist";
        $this->load->view('epanel',$data);
    }
    public function reimbursement($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
         $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        $data['mainContent'] = "employee/reimbursement";
        $this->load->view('epanel',$data);
    }
    
    public function delspouse($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        //$data['mainContent'] = "employee/reimbursement";
        //$this->load->view('epanel',$data);
        $this->qm->update("ri_dependent_tbl",array("status"=>'3','mode'=>"Deletion"),array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Spouse'));
        	$this->session->set_flashdata('success', 'Deleted Successfully Successfully');
        
        redirect("employee/profile/".$cid.'/'.$pid.'/'.$eid);
    }
    
     public function delkid($cid,$pid,$eid,$reltype)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        //$data['mainContent'] = "employee/reimbursement";
        //$this->load->view('epanel',$data);
        $did = (!empty($this->input->get('did'))) ? $this->input->get('did') : 0;
        $this->qm->update("ri_dependent_tbl",array("status"=>'3','mode'=>"Deletion"),array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did));
        	$this->session->set_flashdata('success', 'Deleted Successfully Successfully');
        
        redirect("employee/profile/".$cid.'/'.$pid.'/'.$eid);
    }
    
    
     public function delmother($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        //$data['mainContent'] = "employee/reimbursement";
        //$this->load->view('epanel',$data);
        $this->qm->update("ri_dependent_tbl",array("status"=>'3','mode'=>"Deletion"),array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Mother'));
        	$this->session->set_flashdata('success', 'Deleted Successfully Successfully');
        redirect("employee/profile/".$cid.'/'.$pid.'/'.$eid);
    }
    
     public function delfather($cid,$pid,$eid)
    {
          if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        //$data['mainContent'] = "employee/reimbursement";
        //$this->load->view('epanel',$data);
        $this->qm->update("ri_dependent_tbl",array("status"=>'3','mode'=>"Deletion"),array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Father'));
        	$this->session->set_flashdata('success', 'Deleted Successfully Successfully');
        redirect("employee/profile/".$cid.'/'.$pid.'/'.$eid);
    }
    
    
    
     public function delfatherinlaw($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        //$data['mainContent'] = "employee/reimbursement";
        //$this->load->view('epanel',$data);
        $this->qm->update("ri_dependent_tbl",array("status"=>'3','mode'=>"Deletion"),array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Father In Law'));
        	$this->session->set_flashdata('success', 'Deleted Successfully Successfully');
        redirect("employee/profile/".$cid.'/'.$pid.'/'.$eid);
    }
    
	public function deletedep($cid, $pid, $eid, $did)
    {
        $dol = $this->input->get('dol');
        $reson = $this->input->get('reson');
		$prevRec = $this->qm->single('ri_dependent_tbl','*',['did' => $did]);
        if($prevRec) {
            $this->qm->update("ri_dependent_tbl", array('status' => '3', 'mode' => 'Deletion', 'dol' => $dol, 'reson' => $reson), array('did' => $did));
            $this->employeeModel->addEmployeeVersion($prevRec, 'dep');
        }
		$this->session->set_flashdata('success', 'Deletion request placed successfully');
        redirect("employee/dependents/".$cid.'/'.$pid.'/'.$eid);
    }
    
     public function delmotherinlaw($cid,$pid,$eid)
    {
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
        //$data['mainContent'] = "employee/reimbursement";
        //$this->load->view('epanel',$data);
        $this->qm->update("ri_dependent_tbl",array("status"=>'3','mode'=>"Deletion"),array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Mother In Law'));
        	$this->session->set_flashdata('success', 'Deleted Successfully Successfully');
        redirect("employee/profile/".$cid.'/'.$pid.'/'.$eid);
    }
    
    
    public function empUploadImage()
	{
	     if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
	    
	    //print_r($_FILES['image']['name']);
        $post = $this->input->post();
        if(empty($_FILES['image']['name']))
        {
            $this->session->set_flashdata('error', 'Please choose a profile image');
            redirect("employee/dashboard/".$post['cid'].'/'.$post['pid'].'/'.$post['eid']."");
        }

		if(empty($this->session->userdata('eid')))
        {
            redirect("employee/dashboard/".$post['cid'].'/'.$post['pid'].'/'.$post['eid']."");
        }
        else{
            $data['company_id'] = $post['cid'];
            $data['policy_id'] = $post['pid'];
            $data['employee_id'] = $post['eid'];

            if (!empty($_FILES['image']['name'])) {
                $path = './external/uploads/employee_images/';
                $dat =  $this->qm->upload($path, 'image');

                $data['image'] = $path.$dat;
                $where['employee_id'] = $post['eid'];

                $dd = $this->qm->single('emp_images', $data['employee_id'],$where);
                if(!empty($dd)){
                    $emp = $this->qm->update('emp_images', $data, $where);
                }else{
                    $this->qm->delete("emp_images",array('employee_id'=>$post['eid']));
                    $emp = $this->qm->insert('emp_images', $data);
                }

                if ($emp) {
                    $this->session->set_flashdata('success', 'Profile Image Uploaded Successfully');
                    redirect("employee/dashboard/".$post['cid'].'/'.$post['pid'].'/'.$post['eid']."");
                } else {
                    $this->session->set_flashdata('error', 'Profile Image Upload Failed');
                    redirect("employee/dashboard/".$post['cid'].'/'.$post['pid'].'/'.$post['eid']."");
                }
            }else{
                $this->session->set_flashdata('error', 'Please choose a profile image');
                redirect("employee/dashboard/".$post['cid'].'/'.$post['pid'].'/'.$post['eid']."");
            }
        }
	}
    
    
    public function confidential($cid,$pid,$eid)
    {
        
         if(empty($this->session->userdata('eid')) && $this->session->userdata('eid')!=$eid)
	    {
	         redirect("employee/login/".$cid.'/'.$pid.'/'.$eid."");
	    }
        $data['cid'] = $cid;     
        $data['pid'] = $pid;     
        $data['eid'] = $eid;
       $data['mainContent'] = "employee/confidential";
        $this->load->view('epanel',$data);
    }

	public function adddep($cid, $pid, $eid)
    {
        $post = $this->input->post();
        $post['cid'] = $cid;
        $post['pid'] = $pid;
        $post['eid'] = $eid;

        $did = $this->input->post('did');
		
        $existingDep = $this->qm->all('ri_dependent_tbl', '*', array('did' => $did));
        $check = count($existingDep);
                 
        if($check == 0){
            $ins = $this->employeeModel->addDependent($eid, $post);
            if ($ins) {
                $this->session->set_flashdata('success', 'Added Successfully');
                redirect('employee/dependents/' . $cid.'/'.$pid.'/'.$eid);
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('employee/dependents/' . $cid.'/'.$pid.'/'.$eid);
            }
        }else{
            $upd = $this->employeeModel->updateDependent($eid, $post);
            if ($upd) {
                $this->session->set_flashdata('success', 'Updated Successfully');
                redirect('employee/dependents/' . $cid.'/'.$pid.'/'.$eid);
            } else {
                $this->session->set_flashdata('error', 'Some Error Occurred');
                redirect('employee/dependents/' . $cid.'/'.$pid.'/'.$eid);
            }
        }
    }
	
	
}

?>