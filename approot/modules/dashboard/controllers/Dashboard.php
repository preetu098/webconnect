<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Controller 
{

	 public function index()
    {
        
       if(empty($this->session->userdata('aid')))
           {
              redirect('login/index');
           }
           else{             
        $data['mainContent'] = "dashboard/index";
        $this->load->view('panel',$data);
    }

    }
}
?>