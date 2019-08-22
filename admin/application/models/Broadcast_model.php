<?php

class Broadcast_model extends CI_Model
 {
	function broadcast_insert()
	{	
		$broadcast_image='';
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
			$broadcast_image=$picture['file_name'];
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
					$broadcast_image=$this->input->post('pre_broadcast_image');
				}
		}
           
            $data = array(
			'broadcast_title'=>trim($this->input->post('broadcastitle')),			
			'broadcast_desc'=>trim($this->input->post('broadcastdesc')),
			'broadcast_image'=>$broadcast_image,
			'IsActive' =>$this->input->post('IsActive'),			
			'created_date'=>date('Y-m-d h:i:s')		
			);
		 	 //echo "<pre>";print_r($data);die;	
                    
            $res=$this->db->insert('tblbroadcast',$data);	
            if($res){
            	$user_id=array();
            	$datauser=get_all_records('tbluser');
            	foreach ($datauser as $row) {
            		//echo "<pre>";print_r($row->UsersId);
            		$user_id=$row->UsersId;
            	
            
            	$broadcasttitle=$this->input->post('broadcastitle');
            	$broadcastdesc=$this->input->post('broadcastdesc');
            	$broadcastimage=$this->input->post('BroadcastImage');
            	
                $type='Broadcast Message';
            	$title = $broadcasttitle; 
                $message = $broadcastdesc;
                $broadcastimage=$broadcast_image; 
               // $message = "Your ".$service_name." booking for ".date("d/m/Y",strtotime($get_booking_info['booking_date']))." ".date('h:i A',strtotime($get_booking_info['starting_time']))." has been cancelled";
            
            	sendPushNotificationAndroid($type,$title,$message,$user_id,$broadcastimage);
            	}
            }
			return $res;
	}

	function getbroadcast(){
		$this->db->select('*');
		$this->db->from('tblbroadcast');
		$this->db->where('Is_deleted','0');
		$this->db->order_by('broadcast_id','desc');
		$query=$this->db->get();
		$res = $query->result();
		return $res;
	}

	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblbroadcast");
		$this->db->where("Is_deleted",'0');
		$this->db->where("broadcast_id",$id);
		$this->db->order_by('broadcast_id','desc');
		$query=$this->db->get();
		return $query->row_array();
	}

	function broadcast_update(){
		
		$id=$this->input->post('broadcastid');
        $broadcast_image='';
         
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
					$broadcast_image=$this->input->post('pre_broadcast_image');
				}
	    }
             $data = array(
			'broadcast_title'=>trim($this->input->post('broadcastitle')),			
			'broadcast_desc'=>trim($this->input->post('broadcastdesc')),
			'broadcast_image'=>$broadcast_image,
			'IsActive' =>$this->input->post('IsActive'),
			);
		
          
	    $this->db->where("broadcast_id",$id);
		$res=$this->db->update('tblbroadcast',$data);		
		return $res;
	}

	

}
