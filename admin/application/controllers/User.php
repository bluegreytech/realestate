<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('User_model');
      
    }

	function Userlist()
	{	
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{		
			$data['adminData']=$this->User_model->getuser();
			$this->load->view('User/UserList',$data);
		}
	}

	public function Useradd()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
				$data=array();
				$data['UserId']=$this->input->post('UserId');
				$data['FullName']=$this->input->post('FullName');
				$data['EmailAddress']=$this->input->post('EmailAddress');
				$data['Addresses']=$this->input->post('Addresses');
				$data['ProfileImage']=$this->input->post('ProfileImage');
				$data['UserContact']=$this->input->post('UserContact');
				$data['IsActive']=$this->input->post('IsActive');
				if($_POST){
					if($this->input->post('UserId')==''){
								
						$result=$this->User_model->insertdata();	
						if($result)
						{
							$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
							redirect('User/Userlist');
						}
					}
					else
					{
						$result=$this->User_model->updatedata();
						if($result)
						{
							$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
							redirect('User/Userlist');
						} 

					}
			}
			$this->load->view('User/UserAdd',$data);
				
	}
	
	function Edituser($UserId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$data=array();
			$result=$this->User_model->getdata($UserId);	
			$data['UserId']=$result['UserId'];
			$data['FullName']=$result['FullName'];	
			$data['EmailAddress']=$result['EmailAddress'];	
			$data['Addresses']=$result['Addresses'];
			$data['ProfileImage']=$result['ProfileImage'];	
			$data['UserContact']=$result['UserContact'];
			$data['IsActive']=$result['IsActive'];			
			$this->load->view('User/UserAdd',$data);	
		}
	}

	function updatedata($UserId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
		$result=$this->User_model->updatedata($UserId);	
    	if($result=='1'){
		  $this->session->set_flashdata('success', 'Record has been updated Succesfully!');
		 	redirect('User/Userlist');	
			}
			redirect('User/Userlist');
		}
	}

	function deletedata(){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$id=$this->input->post('id');
			$this->db->where("UserId",$id);
			$res=$this->db->delete('tbluser');
			echo json_encode($res);
			die;
		}
	}

    
}
