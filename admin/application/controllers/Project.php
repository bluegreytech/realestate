<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('Project_model');
      
    }

	function Projectlist()
	{	
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{		
			$data['adminData']=$this->Project_model->getuser();
			$this->load->view('Project/Projectlist',$data);
		}
	}

	public function Projectadd()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
				$data=array();
				$data['ProjectId']=$this->input->post('ProjectId');
				$data['ProjectTitle']=$this->input->post('ProjectTitle');
				$data['ProjectDescription']=$this->input->post('ProjectDescription');
				$data['Price']=$this->input->post('Price');
				$data['ProjectImage']=$this->input->post('ProjectImage');
				$data['ProjectStatus']=$this->input->post('ProjectStatus');
				$data['IsActive']=$this->input->post('IsActive');
				if($_POST){
					if($this->input->post('ProjectId')==''){
								
						$result=$this->Project_model->insertdata();	
						if($result)
						{
							$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
							redirect('Project/Projectlist');
						}
					}
					else
					{
						$result=$this->Project_model->updatedata();
						if($result)
						{
							$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
							redirect('Project/Projectlist');
						} 

					}
			}
			$this->load->view('Project/ProjectAdd',$data);
				
	}
	
	function Editproject($ProjectId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$data=array();
			$result=$this->Project_model->getdata($ProjectId);	
			$data['ProjectId']=$result['ProjectId'];
			$data['ProjectTitle']=$result['ProjectTitle'];	
			$data['ProjectDescription']=$result['ProjectDescription'];	
			$data['Price']=$result['Price'];
			$data['ProjectImage']=$result['ProjectImage'];	
			$data['ProjectStatus']=$result['ProjectStatus'];
			$data['IsActive']=$result['IsActive'];			
			$this->load->view('Project/ProjectAdd',$data);	
		}
	}

	function updatedata($ProjectId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
		$result=$this->Project_model->updatedata($ProjectId);	
    	if($result=='1'){
		  $this->session->set_flashdata('success', 'Record has been updated Succesfully!');
		 	redirect('Project/Projectlist');	
			}
			redirect('Project/Projectlist');
		}
	}

	function deletedata(){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$id=$this->input->post('id');
			$this->db->where("ProjectId",$id);
			$res=$this->db->delete('tblprojects');
			echo json_encode($res);
			die;
		}
	}

    
}
