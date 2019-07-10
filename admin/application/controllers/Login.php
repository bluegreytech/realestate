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
					"email"=>$EmailAddress,
					"password"=>$Password,
				
					);
					$log = $this->Login_model->login_where('tbladmin',$where); 
				
					$cnt = count($log);
					if($cnt>0)
					{
						$datasession= array(
								'email'=> $log->email,
								'admin_id'=> $log->admin_id,
								'fullname'=> $log->fullname,
								'status'=>$log->status,
							    
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

	public function profile($msg='')
    {
            
		if(!check_admin_authentication())
		{
		redirect('login');
		}
                
		$data = array();
		//echo "<pre>";print_r($_POST);die;
        $this->load->library('form_validation');
		$this->form_validation->set_rules('EmailAddress', 'Email', 'required|valid_email|callback_adminmail_check');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');		
		
		if($this->form_validation->run() == FALSE){	
		
			if(validation_errors())
			{
				$data["error"] = validation_errors();
				//echo "<pre>";print_r($data);die;
			}else{
				$data["error"] = "";
			}
			if($_POST){			
				$data["EmailAddress"] = $this->input->post('EmailAddress');
				$data["first_name"]   = $this->input->post('first_name');
				$data["last_name"]    = $this->input->post('last_name');
				$data["phone"]        = $this->input->post('phone');
				$data["gender"]       = $this->input->post('gender');
                //$data['pre_profile_image']=$this->input->post('pre_profile_image');
			
			}else{
			$oneAdmin=get_one_admin(get_authenticateadminID());
			//print_r($oneAdmin);die;
			$data["EmailAddress"] 		= $oneAdmin->Email;
			$data["first_name"] = $oneAdmin->FirstName;
			$data["last_name"]  = $oneAdmin->LastName;	
			$data["gender"]     = $oneAdmin->Gender;		
			$data["phone"]      = $oneAdmin->Phone;			
            //$data['pre_profile_image']=$oneAdmin->profile_image;
			
			}
		}else{
			//echo "else fdf";die;
            $this->session->set_flashdata('successmsg', 'Profile has been updated successfully');				
			$res=$this->Login_model->updateProfile();
			redirect('Login/profile/');
		}
		$data['msg'] = $msg; //login success message
		$offset = 0;
		 $limit =10;

        $this->load->view('common/profile',$data);    
            
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
