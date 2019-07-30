<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('user_model');
      
    }

	function Userlist()
	{	
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{		
			$data['result']=$this->user_model->getuser();
			//echo "<pre>";print_r($data);die;
			$data['redirect_page']="userlist";
			$this->load->view('User/UserList',$data);
		}
	}

	public function Useradd()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
				$data=array();
				$this->load->library("form_validation");
			$this->form_validation->set_rules('FullName', 'Full Name', 'required');			
			
			$this->form_validation->set_rules('UserContact', 'Mobileno', 'required');
			
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
				//echo "<pre>";print_r($data["error"]);die;
			}else{
				$data["error"] = "";
			}
           	$data['redirect_page']="userlist";
			$data['UserId']=$this->input->post('UserId');
			$data['FullName']=$this->input->post('FullName');
			$data['EmailAddress']=$this->input->post('EmailAddress');
			$data['Addresses']=$this->input->post('Addresses');
			$data['ProfileImage']=$this->input->post('ProfileImage');
			$data['UserContact']=$this->input->post('UserContact');
			$data['IsActive']=$this->input->post('IsActive');
			$data["pre_profile_image"] = $this->input->post('ProfileImage');
			
			}
			else
			{
				if($this->input->post("UserId")!="")
			{	
				//echo "dsfdf";die;
				$this->user_model->user_update();
				$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
				redirect('User/Userlist');
				
			}
			else
			{ //echo "dsfdf";die;
				$this->user_model->user_insert();
				$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
				redirect('User/Userlist');
			
			}
				
			}
			$this->load->view('User/UserAdd',$data);
			
				
	}
	
	function Edituser($UsersId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$data=array();
			$result=$this->user_model->getdata($UsersId);	
			$data['UserId']=$result['UsersId'];
			$data['FullName']=$result['FullName'];	
			$data['EmailAddress']=$result['EmailAddress'];	
			$data['Addresses']=$result['Addresses'];
			$data['ProfileImage']=$result['ProfileImage'];	
			$data['UserContact']=$result['UserContact'];
			$data['IsActive']=$result['IsActive'];	
			$data['redirect_page']="userlist";		
			$this->load->view('User/UserAdd',$data);	
		}
	}

	function updatedata($UserId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
		$result=$this->user_model->updatedata($UserId);	
    	if($result=='1'){
		  $this->session->set_flashdata('success', 'Record has been updated Succesfully!');
		 	redirect('User/Userlist');	
			}
			redirect('User/Userlist');
		}
	}

	function deletedata(){
		//echo "jhjh";die;
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}
			$data= array('Is_deleted' =>'1');
			$id=$this->input->post('id');
			$this->db->where("UsersId",$id);
			$res=$this->db->update('tbluser',$data);
			//echo $this->db->last_query();die;
			echo json_encode($res);
			die;
		
	}

	 function usermail_check($EmailAddress)
       {

         $query = $this->db->query("select EmailAddress from ".$this->db->dbprefix('tbluser')." where EmailAddress = '$EmailAddress' and UsersId!='".$this->input->post('UsersId')."'");

               if($query->num_rows() == 0)
               {
                       return TRUE;
               }
               else
               {
                 $this->form_validation->set_message('usermail_check', 'Email address is already exist.');
                  return FALSE;
               }
       }


    
}
