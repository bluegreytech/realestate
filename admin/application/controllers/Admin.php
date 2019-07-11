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

			$data['page_name']="list_admin";
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
			$this->template->set_master_template($theme ."/template.php");
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
            $data["admin_role"] = $this->input->post('admin_role');
            $data["site_id"] = $this->input->post('site_id');
            $data["first_name"] = $this->input->post('first_name');
			$data["last_name"] = $this->input->post('last_name');
			$data["email"] = $this->input->post('email');
			$data["password"] = $this->input->post('password');
			$data["cpassword"]=$this->input->post('cpassword');
            $data["status"] = $this->input->post('status');
            $data["pre_profile_image"] = $this->input->post('profile_image');
			//$data["site_setting"] = site_setting();
			             
			$data["admin_id"]=$this->input->post("admin_id");
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			//$data["admin_type"]='1';
			
			$data["redirect_page"]=$redirect_page;
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]=$redirect_page;
			$data["offset"] = $offset;
            $data["limit"]=$limit;
           // $data["sites"]=$this->site_model->get_total_site('result', $limit, $offset);
            $data["adminRights"] = $this->adminRights;		

            
            
            $this->template->write('pageTitle',$pageTitle,TRUE);
            $this->template->write('metaDescription',$metaDescription,TRUE);
            $this->template->write('metaKeyword',$metaKeyword,TRUE);
    
    
            $this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
            $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
            if((isset($this->adminRights->admin) && $this->adminRights->admin->add==1) || checkSuperAdmin()){
			$this->template->write_view('center',$theme .'/layout/admin/add_admin',$data,TRUE);
			}else{
				$this->template->write_view('center',$theme .'/layout/noRights/noRights',$data,TRUE);
			}
             $this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			
			$this->template->render();
			}
			else
			{
				if($this->input->post("admin_id")!="")
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
			 $limit=$this->input->post("limit");
		     $offset=$this->input->post("offset");
			 if($limit == 0)
			{
				$limit = 20;
			}
			else
			{
				$limit = $limit;
			}
			$redirect_page = $this->input->post('redirect_page');
			$option = $this->input->post('option');
			$keyword = $this->input->post('keyword');
			//$admin_type=$this->session->userdata('admin_type');
			//$admin_type=$admin_type['admin_type'];
			//echo $admin_type;
			//print_r($admin_type);
			
			if($redirect_page == 'list_admin')
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
                        }
			else
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
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
