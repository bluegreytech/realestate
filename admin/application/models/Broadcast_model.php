<?php

class Broadcast_model extends CI_Model
 {
	function broadcast_insert()
	{	
		 	$project_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['BroadcastImage']) &&  $_FILES['BroadcastImage']['name']!='')
		{
			$this->load->library('upload');
			$rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['BroadcastImage']['name'];
			$_FILES['userfile']['type']     =   $_FILES['BroadcastImage']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['BroadcastImage']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['BroadcastImage']['error'];
			$_FILES['userfile']['size']     =   $_FILES['BroadcastImage']['size'];
   
			$config['file_name'] = $rand.'BroadcastImage';			
			$config['upload_path'] = base_path().'upload/broadcastimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);die;		
			$project_image=$picture['file_name'];
			if($this->input->post('pre_broadcast_image')!='')
				{
					if(file_exists(base_path().'upload/broadcastimage/'.$this->input->post('pre_broadcast_image')))
					{
						$link=base_path().'upload/broadcastimage/'.$this->input->post('pre_broadcast_image');
						unlink($link);
					}
				}
		} else {
				if($this->input->post('pre_broadcast_image')!='')
				{
					$project_image=$this->input->post('pre_broadcast_image');
				}
		}
           
            $data = array(
			'boadcast_title'=>trim($this->input->post('ProjectTitle')),			
			'boadcast_desc'=>trim($this->input->post('boadcast_desc')),
			'ProjectImage'=>$project_image,
			'IsActive' =>$this->input->post('IsActive'),			
			'created_date'=>date('Y-m-d')		
			);
		   echo "<pre>";print_r($data);die;	
                    
            $res=$this->db->insert('tblbroadcast',$data);	
			return $res;
	}

	function getbroadcast(){
		$r=$this->db->select('*')
					->from('tblbroadcast')->where('Is_deleted','0')
					->get();
		$res = $r->result();
		return $res;

	}

	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblprojects");
		$this->db->where("Is_deleted",'0');
		$this->db->where("ProjectId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function project_update(){
		//echo "<pre>";print_r($_POST);die;
		$id=$this->input->post('ProjectId');
         	$project_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['ProjectImage']) &&  $_FILES['ProjectImage']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['ProjectImage']['name'];
			$_FILES['userfile']['type']     =   $_FILES['ProjectImage']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['ProjectImage']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['ProjectImage']['error'];
			$_FILES['userfile']['size']     =   $_FILES['ProjectImage']['size'];
   
			$config['file_name'] = $rand.'Projectimage';			
			$config['upload_path'] = base_path().'upload/projectimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);die;		
			$project_image=$picture['file_name'];
			if($this->input->post('pre_project_image')!='')
				{
					if(file_exists(base_path().'upload/projectimage/'.$this->input->post('pre_project_image')))
					{
						$link=base_path().'upload/projectimage/'.$this->input->post('pre_project_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_project_image')!='')
				{
					$project_image=$this->input->post('pre_project_image');
				}
	    }
   
			//project logo upload start//
			$project_logo='';
        	 //$image_settings=image_setting();
		if(isset($_FILES['Projectlogo']) &&  $_FILES['Projectlogo']['name']!='')
        {
			$this->load->library('upload');
			$rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['Projectlogo']['name'];
			$_FILES['userfile']['type']     =   $_FILES['Projectlogo']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['Projectlogo']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['Projectlogo']['error'];
			$_FILES['userfile']['size']     =   $_FILES['Projectlogo']['size'];
   
			$config['file_name'] = $rand.'Projectlogo';			
			$config['upload_path'] = base_path().'upload/projectlogo/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);die;		
			echo $project_logo=$picture['file_name'];

			if($this->input->post('pre_project_logo')!='')
				{
					if(file_exists(base_path().'upload/projectlogo/'.$this->input->post('pre_project_logo')))
					{
						$link=base_path().'upload/projectlogo/'.$this->input->post('pre_project_logo');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_project_logo')!='')
				{
					$project_logo=$this->input->post('pre_project_logo');
				}
	    } 
			//project logo upload end //

			//project brochure upload start//
			$project_brochure='';
        	 //$image_settings=image_setting();
		if(isset($_FILES['Projectbrochure']) &&  $_FILES['Projectbrochure']['name']!='')
        {
			$this->load->library('upload');
			$rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['Projectbrochure']['name'];
			$_FILES['userfile']['type']     =   $_FILES['Projectbrochure']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['Projectbrochure']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['Projectbrochure']['error'];
			$_FILES['userfile']['size']     =   $_FILES['Projectbrochure']['size'];
   
			$config['file_name'] = $rand.'Projectbrochure';			
			$config['upload_path'] = base_path().'upload/projectbrochure/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();			
			$project_brochure=$picture['file_name'];
			if($this->input->post('pre_project_brochure')!='')
				{
					if(file_exists(base_path().'upload/projectbrochure/'.$this->input->post('pre_project_brochure')))
					{
						$link=base_path().'upload/projectbrochure/'.$this->input->post('pre_project_brochure');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_project_brochure')!='')
				{
					$project_brochure=$this->input->post('pre_project_brochure');
				}
		} 
			//project logo upload end //

          
            $data = array(
			'ProjectTitle' => trim($this->input->post('ProjectTitle')),			
			'Projectsdesc' => trim($this->input->post('Projectsdesc')),
			'ProjectImage'=>$project_image,
			'Projectlogo'=>$project_logo,
			'Project_brochure'=>$project_brochure,
			'Projectstatus'=>$this->input->post('Projectstatus'),		
			'IsActive' => $this->input->post('IsActive'),			
			'CreatedOn'=>date('Y-m-d')		
			);
		  // echo "<pre>";print_r($data);die;	
          
	    $this->db->where("ProjectId",$id);
		$res=$this->db->update('tblprojects',$data);		
		return $res;
	}

	

}
