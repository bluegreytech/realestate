<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('login_model');
      
    }
	function index()
    {
		$this->load->library("form_validation");
		$this->form_validation->set_rules('EmailAddress', 'Username', 'required|valid_email');
		$this->form_validation->set_rules('Password', 'Password', 'required');
		$data['EmailAddress']=$this->input->post('EmailAddress');
		$data['Password']=$this->input->post('Password');
                
        if($this->form_validation->run() == FALSE){
			if(validation_errors())
			{
				echo json_encode(array("status"=>"error","msg"=>validation_errors()));
			}
			
		}else
		{
               
            $login =$this->login_model->check_login();
            
		 //echo $login;die;
		if($login == '1')
		{
			 //echo site_url();
         	$this->session->set_flashdata('success','Admin Login successfully');
			redirect('home/dashboard');
             
		}
		elseif($login == '2')
		{
                   
          $this->session->set_flashdata('success','Admin Login successfully');
			redirect('home/dashboard');
			
		}
        elseif($login == '3')
		{
				$this->session->set_flashdata('error','Your account is Inactive. Please contact Administrator!');
           
		}
		else{
				$this->session->set_flashdata('error','Enter valid email and password');
                
		}
        }
		
			// if($this->input->post('logins'))
			// {   
			// 	//echo "fdfds";die;
			// 		$EmailAddress = $this->input->post('EmailAddress');
			// 		$Password = md5($this->input->post('Password'));
					
			// 		$where = array(
			// 		"EmailAddress"=>$EmailAddress,
			// 		"Password"=>$Password,
				
			// 		);
			// 		$log = $this->Login_model->login_where('tbladmin',$where); 
				
			// 		$cnt = count($log);
			// 		if($cnt>0)
			// 		{
			// 			$datasession= array(
			// 					'EmailAddress'=> $log->EmailAddress,
			// 					'AdminId'=> $log->AdminId,
			// 					'FullName'=> $log->FullName,
			// 					'IsActive'=>$log->IsActive,
			// 					'ProfileImage'=>$log->ProfileImage,
							    
			// 				);
			// 			//echo "<pre>";print_r($datasession);die;
			// 			$this->session->set_userdata($datasession);
			// 			$this->session->set_flashdata('success','User Login successfully');
			// 			redirect('home/dashboard');
			// 		}
			// 		else
			// 		{
			// 			$this->session->set_userdata($datasession);
			// 			$this->session->set_flashdata('error', 'Invalid Username Or Password');
			// 			redirect('Login');	
			// 		} 
			// 	}
				$this->load->view('common/login');
			
    }
	
	public function logout()
	{
		
			$this->session->sess_destroy();
			redirect('Login');
	

	}

	public function dashboard()
	{
		$this->load->view('dashboard');
	}

	

	function adminmail_check($email)
	{  //echo $email; die;

		$query = $this->db->query("select Email from ".$this->db->dbprefix('tbluser')." where Email = '$email' and UserId!='".get_authenticateadminID()."'");

		if($query->num_rows() == 0)
		{
		return TRUE;
		}
		else
		{
		$this->form_validation->set_message('adminmail_check', 'There is an existing account associated with this Email');
		return FALSE;
		}
	}
      
}
