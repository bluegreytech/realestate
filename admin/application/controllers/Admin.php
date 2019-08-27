<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('admin_model');
      
    }

	function Adminlist()
	{	
		//echo "dsd ";
		if(!check_admin_authentication()){ 
			//echo "hghgfh";die;
			redirect(base_url());
		}else{	
		//echo "else dfdf";die;	
			$data['activeTab']="Adminlist";	
			$data['adminData']=$this->admin_model->getadmin();
			$this->load->view('Admin/AdminList',$data);
		}
	}

	public function AddAdmin()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
			 	$data=array();		
		
			$this->load->library("form_validation");
			$this->form_validation->set_rules('FullName', 'Full Name', 'required');			
			
			$this->form_validation->set_rules('AdminContact', 'AdminContact', 'required');
			if($this->input->post("AdminId")=="")
			{	
				$this->form_validation->set_rules('EmailAddress', 'EmailAddress', 'required|valid_email|callback_adminmail_check');
				$this->form_validation->set_rules('password', 'Password', 'required|matches[cpassword]|min_length[8]');
				$this->form_validation->set_rules('cpassword', 'Password Confirm', 'required|min_length[8]');
			}
			$this->form_validation->set_rules('status', 'Status', '');
			
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
				//echo "<pre>";print_r($data["error"]);die;
			}else{
				$data["error"] = "";
			}
            $data['redirect_page']='AdminList';
			$data['AdminId']=$this->input->post('AdminId');
			$data['FullName']=$this->input->post('FullName');
			$data['Password']=$this->input->post('password');
			$data['EmailAddress']=$this->input->post('EmailAddress');
			$data['Address']=$this->input->post('Address');
			$data['ProfileImage']=$this->input->post('ProfileImage');
			$data['AdminContact']=$this->input->post('AdminContact');
			$data['IsActive']=$this->input->post('IsActive');
            $data["pre_profile_image"] = $this->input->post('ProfileImage');
			
			}
			else
			{
				if($this->input->post("AdminId")!="")
			{	
				$this->admin_model->admin_update();
				$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
				redirect('admin/AdminList');
				
			}
			else
			{ // echo "dsfdf";die;
				$this->admin_model->admin_insert();
				$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
				redirect('admin/AdminList');
			
			}
				
			}
			$data['activeTab']="AddAdmin";
			$this->load->view('Admin/AdminAdd',$data);
				
	}
	
	function Editadmin($AdminId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$data=array();
			$result=$this->admin_model->getdata($AdminId);	
			$data['redirect_page']='AdminList';
			$data['AdminId']=$result['AdminId'];
			$data['FullName']=$result['FullName'];	
			$data['EmailAddress']=$result['EmailAddress'];	
			$data['Address']=$result['Address'];
			$data['ProfileImage']=$result['ProfileImage'];	
			$data['AdminContact']=$result['AdminContact'];
			$data['IsActive']=$result['IsActive'];
			$data['activeTab']="Editadmin";			
			$this->load->view('Admin/AdminAdd',$data);	
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

	function adminmail_check($EmailAddress)
    {

		$query = $this->db->query("select EmailAddress from ".$this->db->dbprefix('tbladmin')." where EmailAddress = '$EmailAddress' and AdminId!='".$this->input->post('AdminId')."'");

		if($query->num_rows() == 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('adminmail_check', 'Email address is already exist.');
			return FALSE;
		}
    }

    function email_check() {
		$query = $this->db->query("select EmailAddress from " . $this->db->dbprefix('tbladmin') . " where EmailAddress= '".$this->input->post('email')."'");
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
			echo 1;die;
		} else {
			echo 0;die;
		}
	}
     
    
}
