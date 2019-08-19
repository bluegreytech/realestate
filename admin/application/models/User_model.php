<?php

class User_model extends CI_Model
 {
	function user_insert()
	{		
		$user_image='';
         //$image_settings=image_setting();
		  if(isset($_FILES['ProfileImage']) &&  $_FILES['ProfileImage']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['ProfileImage']['name'];
			$_FILES['userfile']['type']     =   $_FILES['ProfileImage']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['ProfileImage']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['ProfileImage']['error'];
			$_FILES['userfile']['size']     =   $_FILES['ProfileImage']['size'];
   
			$config['file_name'] = $rand.'Admin';			
			$config['upload_path'] = base_path().'upload/user_orig/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
           	  $picture = $this->upload->data();	   
              $this->load->library('image_lib');		   
              $this->image_lib->clear();
			  $gd_var='gd2';

              $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/user_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/user/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 300,
				'height' => 300
			 ));
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$user_image=$picture['file_name'];		
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/user/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_orig/'.$this->input->post('pre_profile_image')))
					{
						$link2=base_path().'upload/user_orig/'.$this->input->post('pre_profile_image');
						unlink($link2);
					}
				}
			} else {
				if($this->input->post('pre_profile_image')!='')
				{
					$user_image=$this->input->post('pre_profile_image');
				}
			}
           
           
            $data = array(
			'EmailAddress' => trim($this->input->post('EmailAddress')),		
			'FullName' => trim($this->input->post('FullName')),
			'ProfileImage'=>$user_image,
			'Address'=>$this->input->post('Address'), 
			'UserContact'=>$this->input->post('UserContact'), 		
			'IsActive' => $this->input->post('IsActive'),			
			'CreatedOn'=>date('Y-m-d')		
			);
			//echo "<pre>";print_r($data);die;	
                    
            $res=$this->db->insert('tbluser',$data);	
			return $res;
			
	}

	function getuser(){
		$this->db->select('*');
		$this->db->from('tbluser');
		$this->db->where('Is_deleted','0');
		$query=$this->db->get();
		$res = $query->result();
		return $res;
	}
		function getbdayuser(){
			//today b
			// $query=$this->db->query("SELECT *, 
			// 	IF(DAY(DateofBirth)=DAY(NOW()) AND MONTH(DateofBirth)=MONTH(NOW()), 'Today',
			// 	IF(DAY(DateofBirth) =DAY(ADDDATE(NOW(),-1)) AND MONTH(DateofBirth)=MONTH(ADDDATE(NOW(),-1)), 'Yesterday', 
			// 	IF(DAY(DateofBirth) =DAY(ADDDATE(NOW(),+1)) AND MONTH(DateofBirth)=MONTH(ADDDATE(NOW(),+1)), 'Tomorrow', 'Future') 

			// 	) )as dob FROM tbluser");
			//echo $this->db->last_query();die;

		$today=date('m-d');
		$this->db->select('*');
		$this->db->from('tbluser');
		$this->db->where('Is_deleted','0');
		$this->db->like('DateofBirth',$today);
		$query=$this->db->get();
		$res = $query->result();

		

		return $res;
	}
	
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tbluser");
		$this->db->where("Is_deleted",'0');
		$this->db->where("UsersId",$id);
		$query=$this->db->get();	return $query->row_array();
	
	}

	function user_update(){

		$user_image='';
         //$image_settings=image_setting();
		  if(isset($_FILES['ProfileImage']) &&  $_FILES['ProfileImage']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['ProfileImage']['name'];
			$_FILES['userfile']['type']     =   $_FILES['ProfileImage']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['ProfileImage']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['ProfileImage']['error'];
			$_FILES['userfile']['size']     =   $_FILES['ProfileImage']['size'];
   
			$config['file_name'] = $rand.'Admin';			
			$config['upload_path'] = base_path().'upload/user_orig/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
           	  $picture = $this->upload->data();	   
              $this->load->library('image_lib');		   
              $this->image_lib->clear();
			  $gd_var='gd2';

              $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/user_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/user/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 300,
				'height' => 300
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$user_image=$picture['file_name'];
		
			
		
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/user/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_orig/'.$this->input->post('pre_profile_image')))
					{
						$link2=base_path().'upload/user_orig/'.$this->input->post('pre_profile_image');
						unlink($link2);
					}
				}
			} else {
				if($this->input->post('pre_profile_image')!='')
				{
					$user_image=$this->input->post('pre_profile_image');
				}
			}
			
                    
		$id=$this->input->post('UserId');
		$data=array(			
			'FullName'=>$this->input->post('FullName'),
			'EmailAddress'=>$this->input->post('EmailAddress'),
			'Address'=>$this->input->post('Address'),
			'ProfileImage'=>$this->input->post('ProfileImage'),
			'UserContact'=>$this->input->post('UserContact'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
		//echo "<pre>";print_r($data);die;	
	    $this->db->where("UsersId",$id);
		$this->db->update('tbluser',$data);		
		
	}
	function get_userefer(){
		$this->db->select('*');
		$this->db->from('tblrefer ru');
		$this->db->join('tbluser us','ru.user_id=us.UsersId','left');
		$this->db->where('ru.Is_deleted','0');
		$query=$this->db->get();
		//echo $this->db->last_query();die;
		$res = $query->result();
		return $res;
	}
	function getuserhistorydata($user_id){
		$this->db->select('*');
		$this->db->from('tbluser_redeempoints ru');
		$this->db->join('tblrefer rf','ru.refer_id=rf.refer_id','left');
		//$this->db->where('ru.Is_deleted','0');
		$this->db->where('ru.user_id',$user_id);
		$query=$this->db->get();
		//echo $this->db->last_query();die;
		$res = $query->result();
		return $res;
	}

	
		
	function getreferdata($id){
		$this->db->select('*');
		$this->db->from('tblrefer ru');
		$this->db->join('tbluser us','ru.user_id=us.UsersId','left');
		$this->db->where('ru.Is_deleted','0');
		$this->db->where("ru.refer_id",$id);
		$query=$this->db->get();
		//echo $this->db->last_query();die;
		return $query->row_array();
	}
	function userrefer_update(){
		$id=$this->input->post('refer_id');
		$user_id=$this->input->post('UsersId');
		$userdata=get_one_record('tbluser','UsersId',$user_id);
      	//echo "<pre>";print_r($userdata->FullName);die;

        $data1=array(	
			'redeem_point'=>$this->input->post('closing_points'),
			'redeem_type'=>"closed",
			'comment'=>$this->input->post('comments'),
			'user_id'=>$user_id,
			'refer_id'=>$id
		);		
		$this->db->insert('tbluser_redeempoints',$data1);

		$userdata=array(	
			'closing_point'=>$this->input->post('closing_points'),
		);
		$this->db->where("UsersId",$user_id);
		$this->db->update('tbluser',$userdata);

		$data=array(
			'comments'=>$this->input->post('comments'),
			'status'=>$this->input->post('status'),
		);
		//echo "<pre>";print_r($data);die;	
		$this->db->where("refer_id",$id);
		$this->db->update('tblrefer',$data);		
	}
	

}
