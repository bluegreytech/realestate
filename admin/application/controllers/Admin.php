<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('Admin_model');
      
    }

	function Adminlist()
	{	
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{		
			$data['adminData']=$this->Admin_model->getadmin();
			$this->load->view('Admin/AdminList',$data);
		}
	}

	public function AddAdmin()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
			 	$data=array();
			// 	$data['AdminId']=$this->input->post('AdminId');
			// 	$data['FullName']=$this->input->post('FullName');
			// 	$data['EmailAddress']=$this->input->post('EmailAddress');
			// 	$data['Addresses']=$this->input->post('Addresses');
			// 	$data['ProfileImage']=$this->input->post('ProfileImage');
			// 	$data['AdminContact']=$this->input->post('AdminContact');
			// 	$data['IsActive']=$this->input->post('IsActive');
			// 	if($_POST){
			// 		if($this->input->post('AdminId')==''){
								
			// 			$result=$this->Admin_model->insertdata();	
			// 			if($result)
			// 			{
			// 				$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
			// 				redirect('Admin/Adminlist');
			// 			}
			// 		}
			// 		else
			// 		{
			// 			$result=$this->Admin_model->updatedata();
			// 			if($result)
			// 			{
			// 				$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
			// 				redirect('Admin/Adminlist');
			// 			} 

			// 		}
			// }

		
			$this->load->library("form_validation");
			$this->form_validation->set_rules('FullName', 'Full Name', 'required');			
			$this->form_validation->set_rules('EmailAddress', 'EmailAddress', 'required|valid_email|callback_adminmail_check');
			$this->form_validation->set_rules('AdminContact', 'AdminContact', 'required');
			if($this->input->post("AdminId")=="")
			{	
				$this->form_validation->set_rules('password', 'Password', 'required|matches[cpassword]|min_length[8]');
				$this->form_validation->set_rules('cpassword', 'Password Confirm', 'required|min_length[8]');
			}
			$this->form_validation->set_rules('status', 'Status', '');
			
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
           
			$data['AdminId']=$this->input->post('AdminId');
			$data['FullName']=$this->input->post('FullName');
			$data['Password']=$this->input->post('password');
			$data['EmailAddress']=$this->input->post('EmailAddress');
			$data['Addresses']=$this->input->post('Addresses');
			$data['ProfileImage']=$this->input->post('ProfileImage');
			$data['AdminContact']=$this->input->post('AdminContact');
			$data['IsActive']=$this->input->post('IsActive');
            $data["pre_profile_image"] = $this->input->post('ProfileImage');
			//$data["site_setting"] = site_setting();
			
			}
			else
			{
				if($this->input->post("AdminId")!="")
			{	
				$this->admin_model->admin_update();
				$this->session->set_flashdata('msg', 'update');
				$msg = "update";
			}
			else
			{
				$this->admin_model->admin_insert();
				$this->session->set_flashdata('msg', 'insert');
				$msg = "insert";
			}
				
			}
			$this->load->view('Admin/AdminAdd',$data);
				
	}
	
	function Editadmin($AdminId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$data=array();
			$result=$this->Admin_model->getdata($AdminId);	
			$data['AdminId']=$result['AdminId'];
			$data['FullName']=$result['FullName'];	
			$data['EmailAddress']=$result['EmailAddress'];	
			$data['Addresses']=$result['Addresses'];
			$data['ProfileImage']=$result['ProfileImage'];	
			$data['AdminContact']=$result['AdminContact'];
			$data['IsActive']=$result['IsActive'];			
			$this->load->view('Admin/AdminAdd',$data);	
		}
	}

	function updatedata($AdminId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
		$result=$this->Admin_model->updatedata($AdminId);	
    	if($result=='1'){
		  $this->session->set_flashdata('success', 'Record has been updated Succesfully!');
		 	redirect('Adminuser/Adminlist');	
			}
			redirect('Adminuser/Adminlist');
		}
	}

	function deletedata(){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$id=$this->input->post('id');
			$this->db->where("AdminId",$id);
			$res=$this->db->delete('tbladmin');
			echo json_encode($res);
			die;
		}
	}

    
}
