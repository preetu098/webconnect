<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller 
{

	public function register($cid,$pid)
	{
		$data['cid'] = $cid;       
		$data['pid'] = $pid;       
	// $this->load->view('user/register',$data);
	redirect('employee/register/'.$cid.'/'.$pid);
	}

// 	public function reg($cid,$pid)
// 	{
// 		$post = $this->input->post();
	
		
	
		
// 		$post['cid']=$cid;
//         $post['pid']=$pid;
// 		$post['data_type'] = 0;
// 		$post['mode'] = 'New Registration';
// 		$post['status'] = 2;

// 		$ins = $this->qm->insert('ri_employee_tbl',$post);
// 		if($ins){

// 			redirect('user/login/'.$cid.'/'.$pid.'/'.$ins.'');
// 		}
// 		else{
// 			redirect('user/register'.$cid.'/'.$pid.'');
// 		}

// 	}
	public function reg($cid,$pid)
	{
		$pot = $this->input->post();
	    
	    extract($pot);
	    
	    $post = array(
	        'cid' =>$cid,
	        'pid'=>$pid,
	        'emp_id' => $emp_id,
	        'name' => $name,
	        'username'=> $username,
	        'email'=>$email,
	        'mobile' => $mobile,
	        'password'=>$password,
	        'data_type' => 0,
	        'mode' => 'New Registration',
	        'status' => 2,
	        );
	

		$ins = $this->qm->insert('ri_employee_tbl',$post);
		if($ins){
    
        
        // $data['cid'] = $cid;
        // $data['pid'] = $pid;
        // $data['eid'] = $ins;

       // $this->load->view('user/login', $data);
        redirect('employee/login');
      
		    //	redirect('user/login/'.$cid.'/'.$pid.'/'.$ins.'');
		}
		else{
			redirect('employee/register'.$cid.'/'.$pid.'');
		}

	}
	public function login()
	{	
		
		$this->load->view('user/login');
	}
// 	public function login($cid,$pid,$eid)
// 	{	
// 		if($this->input->post())
//             {
             
//              $username = $this->input->post('username');
//              $password = $this->input->post('password');
//              $status = 0;
            
//              $data = $this->qm->single("ri_employee_tbl","*", "username= '".$username."' && password='".$password."' && cid = '".$cid."' && pid = '".$pid."' && eid = '".$eid."' && status !='".$status."'"); 
            
//              if($data->eid > 0 )
//                 {
//                     $this->session->set_userdata('eid',$data->eid);
//                     $this->session->set_userdata('name',$data->name);
                    
//                     if(!empty($this->session->userdata('eid')))
//                     {
//                         redirect("user/dashboard/".$cid.'/'.$pid.'/'.$eid."");
//                     }else{
//                         $this->session->set_flashdata('error', 'Due to technical problem, you are unable to login');
//                       redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");
//                     }
//                 }
//                 else{
//                     $this->session->set_flashdata('error', 'Invalid User ID and Password');
//                   redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");
//                 }

//             }
// 		$data['cid']= $cid;
// 		$data['pid']= $pid;
// 		$data['eid']= $eid;
// 		$this->load->view('user/login',$data);
// 	}
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
                }
                else{
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
                    $this->session->set_userdata('eid',$data->eid);
                    $this->session->set_userdata('name',$data->name);
                    
                    if(!empty($this->session->userdata('eid')))
                    {
                        redirect("user/dashboard/".$cid.'/'.$pid.'/'.$eid."");
                    }else{
                        $this->session->set_flashdata('error', 'Due to technical problem, you are unable to login');
                      redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");
                    }
                }
                else{
                    $this->session->set_flashdata('error', 'Invalid User ID and Password');
                   redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");
                }
 
	}
public function logout($cid,$pid,$eid)
    {
        $this->session->unset_userdata('cid');
        redirect('user/login');
    }
	public function dashboard($cid,$pid,$eid,$edit=null)
	{
		if(empty($this->session->userdata('eid')))
           {
              redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");

           }
           else{ 
             
              $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid; 
              if($edit!=null)
              {
                  $data['edit'] = $edit; 
              }
              
           $data['mainContent'] = "user/dashboard";
        $this->load->view('upanel',$data);
    }
	}
	public function profile($cid,$pid,$eid)
	{
		if(empty($this->session->userdata('eid')))
           {
              redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");

           }
           else{ 
             
              $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid;     
              
           $data['mainContent'] = "user/profile";
        $this->load->view('upanel',$data);
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
            redirect('user/profile/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('upde', 'Updation Failed');
            redirect('user/profile/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		

	}
	public function updself($cid,$pid,$eid)
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

			$this->session->set_flashdata('succes', 'Updated Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		

	}

	public function updpass($cid,$pid,$eid)
	{
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
				            redirect('user/profile/'.$cid.'/'.$pid.'/'.$eid.'');

						}
						else{
							$this->session->set_flashdata('echnpass', 'Updation Failed');
				            redirect('user/profile/'.$cid.'/'.$pid.'/'.$eid.'');
						}
            }
        }
        else{
        	$this->session->set_flashdata('notequal', 'New Password and Confirm Password Is No Equal');
			redirect('user/profile/'.$cid.'/'.$pid.'/'.$eid.'');
        }
	}

	public function dependents($cid,$pid,$eid)
	{
		if(empty($this->session->userdata('eid')))
           {
              redirect("user/login/".$cid.'/'.$pid.'/'.$eid."");

           }
           else{ 
             
              $data['cid'] = $cid;     
              $data['pid'] = $pid;     
              $data['eid'] = $eid;     
              
           $data['mainContent'] = "user/dependents";
        $this->load->view('upanel',$data);
    }
	}

	public function updspouse($cid,$pid,$eid)
	{
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Spouse';

		$post['status'] = 1;
		$post['updated_on'] = date('Y-m-d');

		

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);


		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}
	public function motherinlaw($cid,$pid,$eid)
	{
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Mother In Law';
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
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}
	public function mother($cid,$pid,$eid)
	{
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Mother';
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
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}
	public function fatherinlaw($cid,$pid,$eid)
	{
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Father In Law';
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
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}

	public function father($cid,$pid,$eid)
	{
		$post = $this->input->post();

		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = 'Father';
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
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$post['mode'] = 'Correction';
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}

	public function addkid($cid,$pid,$eid,$rel)
	{
		$post = $this->input->post();
		$post['cid'] = $cid;
		$post['pid'] = $pid;
		$post['eid'] = $eid;
		$post['reltype'] = $rel;

		$post['status'] = 1;
		$post['updated_on'] = date('Y-m-d');

		$did = $this->input->post('did');
		$check = $this->qm->all('ri_dependent_tbl','*',array('did'=>$did));
		$ch = count($check);

		if($ch == 0){

			$ins = $this->qm->insert('ri_dependent_tbl',$post);
			if($ins){

			$this->session->set_flashdata('succes', 'Addedd Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Addition Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
		else{
			$where = array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'did'=>$did);
			$upd = $this->qm->update('ri_dependent_tbl',$post,$where);
			if($upd){

			$this->session->set_flashdata('succes', 'Update Successfully');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');

		}
		else{
			$this->session->set_flashdata('err', 'Updation Failed');
            redirect('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'');
		}
		}
	}
}

?>