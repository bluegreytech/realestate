<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('broadcast_model');
      
    }

	function Broadcastlist()
	{	
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{		
			$data['result']=$this->broadcast_model->getbroadcast();
			$this->load->view('broadcast/broadcast_list',$data);
		}
	}

	public function add_broadcast()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
			
			$data=array();	
			$this->load->library("form_validation");
			$this->form_validation->set_rules('broadcastitle', 'Broadcast title', 'required');			
			$this->form_validation->set_rules('broadcastdesc', 'Broadcast Description', 'required');
			$this->form_validation->set_rules('IsActive', 'IsActive', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
				//echo "<pre>";print_r($data["error"]);die;
			}else{
				$data["error"] = "";
			}
         		$data['redirect_page']='broadcastlist';
				$data['broadcastid']=$this->input->post('broadcastid');
				$data['broadcastitle']=$this->input->post('broadcastitle');
				$data['broadcastdesc']=$this->input->post('broadcastdesc');
				$data['broadcastimage']=$this->input->post('broadcastimage');
				$data['IsActive']=$this->input->post('IsActive');
			
			}
			else
			{
				if($this->input->post("broadcastid")!="")
			{
			  echo "fddgfd";die;	
				$this->broadcast_model->broadcast_update();
				$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
				redirect('broadcast/broadcastlist');
				
			}
			else
			{  //echo "<pre>";print_r($_FILES);die;
				$this->broadcast_model->broadcast_insert();
				$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
				redirect('broadcast/broadcastlist');
			
			}
				
			}
			$this->load->view('broadcast/add_broadcast',$data);
				
	}
	
	function edit_broadcast($broadcastId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}
			$data=array();
			$result=$this->project_model->getdata($ProjectId);	
			$data['redirect_page']='projectlist';
			$data['ProjectId']=$result['ProjectId'];
			$data['ProjectTitle']=$result['ProjectTitle'];	
			$data['Projectsdesc']=$result['Projectsdesc'];
			$data['Projectldesc']=$result['Projectldesc'];		
		
			$data['ProjectImage']=$result['ProjectImage'];	
			$data['Projectlogo']=$result['Projectlogo'];
			$data['Project_brochure']=$result['Project_brochure'];	
			$data['ProjectStatus']=$result['ProjectStatus'];
			$data['IsActive']=$result['IsActive'];	
			//echo "<pre>";print_r($data);die;		
			$this->load->view('Project/ProjectAdd',$data);	
		
	}

	function updatedata($broadcastId){
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

	function delete_broadcast(){
		//echo "gfgfd" ;die;
		//echo $id=$this->input->post('id'); die;
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}
			$data= array('Is_deleted' =>'1');
			$id=$this->input->post('id');
			$this->db->where("ProjectId",$id);			
			$res=$this->db->update('tblprojects',$data);
			//echo $this->db->last_query();die;
			echo json_encode($res);
			die;
		
	}
    
}
