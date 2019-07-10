<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('Login_model');
      
    }
	function index()
    {
		
		
			if($this->input->post('logins'))
			{   
					$EmailAddress = $this->input->post('EmailAddress');
					$Password = md5($this->input->post('Password'));
					
					$where = array(
					"EmailAddress"=>$EmailAddress,
					"Password"=>$Password,
				
					);
					$log = $this->Login_model->login_where('tbladmin',$where); 
				
					$cnt = count($log);
					if($cnt>0)
					{
						$datasession= array(
								'EmailAddress'=> $log->EmailAddress,
								'AdminId'=> $log->AdminId,
								'FullName'=> $log->FullName,
								'IsActive'=>$log->IsActive,
								'ProfileImage'=>$log->ProfileImage,
							    
							);
						//echo "<pre>";print_r($datasession);die;
						$this->session->set_userdata($datasession);
						$this->session->set_flashdata('success','User Login successfully');
						redirect('home/dashboard');
					}
					else
					{
						$this->session->set_userdata($datasession);
						$this->session->set_flashdata('error', 'Invalid Username Or Password');
						redirect('Login');	
					} 
				}
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
