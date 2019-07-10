<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminuser extends CI_Controller {

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

	public function Adminadd()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
				$data=array();
				$data['AdminId']=$this->input->post('AdminId');
				$data['FullName']=$this->input->post('FullName');
				$data['EmailAddress']=$this->input->post('EmailAddress');
				$data['Addresses']=$this->input->post('Addresses');
				$data['ProfileImage']=$this->input->post('ProfileImage');
				$data['AdminContact']=$this->input->post('AdminContact');
				$data['IsActive']=$this->input->post('IsActive');
				if($_POST){
					if($this->input->post('AdminId')==''){
								
						$result=$this->Admin_model->insertdata();	
						if($result)
						{
							$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
							redirect('Adminuser/Adminlist');
						}
					}
					else
					{
						$result=$this->Admin_model->updatedata();
						if($result)
						{
							$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
							redirect('Adminuser/Adminlist');
						} 

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
