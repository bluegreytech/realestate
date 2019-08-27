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
			$data['activeTab']="broadcastlist";	
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
			$data['activeTab']="add_broadcast";	
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
			 // echo "fddgfd";die;	
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
			$data['activeTab']="edit_broadcast";	
			$result=$this->broadcast_model->getdata($broadcastId);	
			//echo "<pre>";print_r($result);die;
			$data['redirect_page']='broadcastlist';
			$data['broadcastid']=$result['broadcast_id'];
			$data['broadcastitle']=$result['broadcast_title'];	
			$data['broadcastdesc']=$result['broadcast_desc'];
			$data['broadcastimage']=$result['broadcast_image'];
			$data['IsActive']=$result['IsActive'];	
			//echo "<pre>";print_r($data);die;		
			$this->load->view('broadcast/add_broadcast',$data);	
		
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

	function broadcast_delete(){
		
		$id=$this->input->post('id');		
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}
		if($this->input->post('broadcastimage')!='')
			{
				if(file_exists(base_path().'upload/broadcastimage/'.$this->input->post('broadcastimage')))
				{
					$link=base_path().'upload/broadcastimage/'.$this->input->post('broadcastimage');
					unlink($link);
				}
			}
			$data= array('Is_deleted' =>'1');
			$id=$this->input->post('id');
			$this->db->where("broadcast_id",$id);			
			$res=$this->db->update('tblbroadcast',$data);
			//echo $this->db->last_query();die;
			echo json_encode($res);
			die;
		
	}
    
}
