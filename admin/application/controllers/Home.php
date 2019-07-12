<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('Login_model');
      
    }

	public function dashboard()
	{
		if(!check_admin_authentication()){ 
			echo "hjhj";die;
			redirect(base_url());
		}
		$this->load->view('dashboard');
	}

	public function profile($msg='')
    {  //echo "fdsf";die;
            
		if(!check_admin_authentication())
		{
		redirect('login');
		}
                
		$data = array();
		//echo "<pre>";print_r($_POST);die;
        $this->load->library('form_validation');
		$this->form_validation->set_rules('EmailAddress', 'Email', 'required|valid_email|callback_adminmail_check');
		$this->form_validation->set_rules('full_name', 'Full Name', 'required');
		$this->form_validation->set_rules('AdminContact', 'Contact', 'required');
		$this->form_validation->set_rules('EmailAddress', 'Email', 'required');		
		
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
			$data["EmailAddress"] 	= $oneAdmin->EmailAddress;
			$data["full_name"] = $oneAdmin->FullName;				
			$data["contact"]      = $oneAdmin->AdminContact;			
           	$data['ProfileImage']=$oneAdmin->ProfileImage;
           	$data['IsActive']=$oneAdmin->IsActive;
			
			}
		}else{
			//echo "else fdf";die;
            $this->session->set_flashdata('successmsg', 'Profile has been updated successfully');				
			$res=$this->Login_model->updateProfile();
			redirect('home/profile/');
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
   
   public function logout()
	{
		
			$this->session->sess_destroy();
			redirect('Login');
	

	}   
	
	public function Forgotpassword()
	{
		if($_POST){
				if($this->input->post('UserId')==''){
							
					$result=$this->Login_model->forgotpass_check();	
					if($result)
					{
						$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
						redirect('User/Userlist');
					}
				}
				else
				{
					$chk_mail=$this->Login_model->forgotpass_check();
					if($chk_mail==0)
					{
						$this->session->set_flashdata('success', 'Record has been Updated Succesfully1!');
						
					}
					elseif($chk_mail==2)
					{	$redirect=site_url('Login');
						$this->session->set_flashdata('success', 'Record has been Updated Succesfully2!');
					}elseif($chk_mail==3)
					{   
						$redirect=site_url('Login');
						$this->session->set_flashdata('success','User Login successfullyuuuuuuu3');		  
					}
					else
					{			echo "111114444";die;		
						$forget=FORGET_SUCCESS;
						$redirect=site_url('Login');
					}
				}
			}	
		$this->load->view('common/ForgotPassword');
	}


	function Resetpassword($code='')
	{
		
		$AdminId=$this->Login_model->checkResetCode($code);
		//print_r($AdminId);die;
	
		$data = array();
		
		 if($AdminId!='')
		 { echo "<pre>";print_r($_POST);}
		 die;
			if($_POST)
			{
				//echo "<pre>";print_r($_POST); die;
				if($this->input->post('AdminId') != '')
				{
						$up=$this->Login_model->updatePassword();
						if($up>0)
						{
							$redirect=site_url('Home/Login');
						
						}		
					}
				}
			
		//}
		$data['AdminId']=$AdminId;
		$data['code']=$code;
		$this->load->view('common/ResestPassword',$data);
	}
		
	
	
}
