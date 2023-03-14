<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
//$Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
class Login extends MY_Controller 
{

	public function index()
	{
		if($this->input->post())
            {
             
             $email = $this->input->post('email');
             $password = md5($this->input->post('password'));

             $data = $this->qm->single("ri_admin_tbl","*", "email= '".$email."' && password='".$password."'"); 
             if($data->aid > 0 )
                {
                    $this->session->set_userdata('aid',$data->aid);
                    $this->session->set_userdata('name',$data->name);
                    
                    if(!empty($this->session->userdata('aid')))
                    {
                        redirect("dashboard");
                    }else{
                        $this->session->set_flashdata('error', 'Due to technical problem, you are unable to login');
                        redirect("login/index");
                    }
                }
                else{
                    $this->session->set_flashdata('error', 'Invalid User ID and Password');
                    redirect("login/index");
                }

            }
	$this->load->view('login/index');
	}

    public function updpass()
    {
        $opass = md5($this->input->post('opass'));
        $newpass = $this->input->post('npass');
        $cpass = $this->input->post('cpass');


        if($newpass == $cpass){
            

            $check = $this->qm->all("ri_admin_tbl","*",array('password'=>$opass));
             
            if($check){
                $npass = md5($newpass);

                $data = array(
                    'password'=>$npass,
                );

                $where = array(
                    'aid'=>1,
                );
                $upd = $this->qm->update("ri_admin_tbl",$data,$where);
               
                if($upd){

                            $this->session->set_flashdata('chnpass', 'Updated Successfully');
                            redirect('clients/setting/');

                        }
                        else{
                            $this->session->set_flashdata('echnpass', 'Updation Failed');
                            redirect('clients/setting/');
                        }
           }
        }
        else{
            $this->session->set_flashdata('notequal', 'New Password and Confirm Password Is No Equal');
            redirect('clients/setting/');
        }
    }
}
?>