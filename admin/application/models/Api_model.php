<?php
class Api_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	

	/*
	 * Function: EmailUnique
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: Boolean return 
	*/
	function EmailUnique()
	{
		$str = $this->input->post('email');
		if($this->input->post('user_id')!='')
		{
			$query = $this->db->query("select EmailAddress from ".$this->db->dbprefix('tbluser')." where EmailAddress = '$str' and user_id!='".$this->input->post('user_id')."'");
		}else{
			$query = $this->db->query("select EmailAddress from ".$this->db->dbprefix('tbluser')." where EmailAddress = '$str'");
		}

		if($query->num_rows()>0){
			return FALSE;
		} else {
			return TRUE;
		}
	}


	/*
	 * Function: EmailUnique_api
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: array return if found email
	*/
	function EmailUnique_api()
	{
		$str = $this->input->post('email');
		if($this->input->post('email')!='')
		{
			$query = $this->db->query("select * from ".$this->db->dbprefix('user')." where email = '$str'");
		} 
		if($query->num_rows()>0){

			$row_arr = $query->result_array();
			return $row_arr[0];
		} else {
			return TRUE;
		}
	}
  

	function user_status()
	{
		$mobileno = $this->input->post('mobileno'); 
		$query 			= $this->db->get_where("tbluser",array("UserContact"=>$mobileno));
		$res 			= $query->row();
		
		if($query->num_rows() > 0)
		{
			if($res->IsActive == 'Inactive')
			{
					$data['status'] = 'fail';
					$data['result']	= array('inactive' =>'0');
					$data['error']  = 'Your account is inactive. Please contact administrator!';
					return $data;
			   
			}elseif($res->IsActive == 'Active'){			
					$data['status'] = 'success';
					$data['result']	=array('active' =>'1');
					$data['message']= 'Your account is active. Please login!';	
					return $data;

			}
		}else{
				$data['status'] = 'fail';			
				$data['error']  = 'Invalid Mobile number Please enter Valid number !';
				return $data;
		}
	}


	/*
	 * Function: UsernameUnique
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: Boolean return 
	*/
	function MobileUnique()
	{
		$str = $this->input->post('mobileno');
		if($this->input->post('UserId')!='')
		{
			$query = $this->db->query("select UserContact from ".$this->db->dbprefix('tbluser')." where UserContact = '$str' and UserId!='".$this->input->post('register_id')."'");
		}else{
			$query = $this->db->query("select UserContact from ".$this->db->dbprefix('tbluser')." where UserContact = '$str'");
		}
        //echo $this->db->last_query();die;
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	/*
	 * Function: register()
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: void return 
	*/
	function register(){
       // $headers = apache_request_headers();
		$length = 10;
		//$unhcr_no=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
		$data 		 		 = array();
		$confirm_code		 = md5(uniqid(rand()));
		$user_image			 = '';
	
		$data = array(
			'FullName'   	  => $this->input->post('full_name'),
			'EmailAddress' 	  => $this->input->post('email'),
			'UserContact' 	  => $this->input->post('mobileno'),
			'DateofBirth' 	  => $this->input->post('dob'),
			//'Address' 	 	  => $this->input->post('Address'),
			'Project_name' 	  => $this->input->post('project_name'),
			'House_no' 	 	  => $this->input->post('house_no'),		
			'UserPassword'	  =>trim(md5($this->input->post('password'))),
			'IsActive'		  =>'Inactive',
			'CreatedOn'=>date('Y-m-d')			
			);
	  
		$user_id= insert_record_api('tbluser',$data); 
		$user_detail = get_one_record('tbluser','UsersId',$user_id);
	
		$data = array(
			'user_id'	 => trim($user_detail->UsersId),
			'full_name'  => trim($user_detail->FullName),
			'email' 	 => trim($user_detail->EmailAddress),
			'phone' 	 => trim($user_detail->UserContact),
			'dob'		 => trim($user_detail->DateofBirth),
			'Project_name'=>trim($user_detail->Project_name),
			'House_no'	 => trim($user_detail->House_no),
			//'address'	 => trim($user_detail->Address),			
			);	
       
		return $data;
	}


	/*
	 * Function: change_password()
	 * Author: Binny
	 * Date: 19/6/2017
	 * return @void
	*/
	function change_password($user_id,$oldpassword){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id',$user_id);
		$this->db->where('password',$oldpassword);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			//echo 
			return 1;
		}
		else {
			return 0;
		}
	}
	function updateUserPassword()
	{

		$data = array(
						'UserPassword' => md5(trim($this->input->post('password')))			
					);		
		$query=$this->db->where(array('UsersId'=> $this->input->post('user_id'),'UserPassword'=>md5(trim($this->input->post('old_password')))))->get_where('tbluser');
		
		if($query->num_rows()>0){			
		$this->db->where(
			array('UsersId'=>$this->input->post('user_id'),
			'UserPassword'=>md5(trim($this->input->post('old_password')))
			
				)
		);
		$this->db->update('tbluser',$data);
		return true;
		}else{
		return false;
		}
	}
	
	/*
	 * Function: get_profile()
	 * Author: Binnyresend
	 * Date: 20/11/2017
	 * return array
	*/
	function get_profile($user_id){
		$query = $this->db->select('*')->from('tbluser')->where('UsersId',$user_id)->get();
		if($query->num_rows()>0){
			$user_detail = $query->row();
			$data = array(
				'full_name' 	    => trim($user_detail->FullName),
				'email' 			=> trim($user_detail->EmailAddress),				
				'phone'			    => trim($user_detail->UserContact),
				'profile_image'		=> trim($user_detail->ProfileImage),
				'user_id'			=> trim($user_detail->UsersId),
				);		
			return $data;
		}else{
			return array();
		}
		
	}

	function set_user_status(){
     $user_id=$this->input->post('user_id');
		//$password1 	  = md5($password);	
		$query  	  = $this->db->get_where("tbluser",array("UsersId"=>$user_id));
		$res 		  = $query->row();
		//print_r($res);die;
		if($user_id){ 

			if($query->num_rows() > 0)
			{
				$ud=array('IsActive'=>$this->input->post('status'));
				$this->db->where('UsersId',$res->UsersId);
				$this->db->update('tbluser',$ud);
	            $data['message'] = "Your status change successfully";
	            $data['status']  = 'success';
	            return $data;
	       
	    	}else{
	    		$data['status'] = 'fail';
	        	$data['error']  = 'Something went wrong, please try again';
	        	return $data;
	    	}
    	}else{
	    		$data['status'] = 'fail';
	        	$data['error']  = 'Something went wrong, please try again';
	        	return $data;
	    	}

	}

	
	/*
	 * Function: Reset_password
	 * Author: Binny
	 * Date: 17/11/2017
	 * Input: code , new password 
	 * Output: Change password and fire email
	*/
	function reset_password($mobileno,$password)
	{
		//$headers = apache_request_headers();
		//echo "<pre> fdfd"; $forget_password_code; die;
		$password1 	  = md5($password);	
		$query  	  = $this->db->get_where("tbluser",array("UserContact"=>$mobileno));
		$res 		  = $query->row();
		//print_r($res);die;
		if($query->num_rows() > 0)
		{
			$ud=array('UserPassword'=>$password1);
			$this->db->where('UsersId',$res->UsersId);
			$this->db->update('tbluser',$ud);
            $data['message'] = "Your password has been reset successfully";
            $data['status']  = 'success';
            return $data;


        }else{
        	$data['status'] = 'fail';
        	$data['error']  = 'Please enter valid activation code';
        	return $data;
        }

    }
    
    
	

	


	/*
	 * Function: user_edit_basic_api
	 * Author: Binny
	 * Date: 19/6/2017
	 * Input: post array
	 * Output: array return
	*/
	function user_edit_profile_api()
	{
		//print_r($_POST);die;

		//$site_setting  = site_setting();	
		$this->load->library('upload');
		$user_id 	   = trim($this->input->post('user_id')); 
		$user_image    = '';
		//$image_setting = image_setting();
		//echo "<pre>";print_r($image_setting);die;

		if(@$_FILES['profile_image']['name']!='' && $_FILES['profile_image']['name']!='')
		{
			$this->load->library('upload');
			$rand=rand(0,100000); 

			$_FILES['userfile']['name']     =   $_FILES['profile_image']['name'];
			$_FILES['userfile']['type']     =   $_FILES['profile_image']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['profile_image']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['profile_image']['error'];
			$_FILES['userfile']['size']     =   $_FILES['profile_image']['size'];

			$config['file_name']   	   = $rand.'user';			
			$config['upload_path']     = base_path().'upload/user_orig/';
			$config['allowed_types']   = '*';
            //$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp'; 
			$this->upload->initialize($config); 
			if (!$this->upload->do_upload())
			{
				echo $error =  $this->upload->display_errors(); die;
			} 			   
			$picture = $this->upload->data();

			$this->load->library('image_lib');
			$this->image_lib->clear();	   	
			$gd_var='gd2';	

			$this->image_lib->clear();
			$this->image_lib->initialize(array(
				'image_library'  => $gd_var,
				'source_image'   => base_path().'upload/user_orig/'.$picture['file_name'],
				'new_image' 	 => base_path().'upload/user/'.$picture['file_name'],
				'maintain_ratio' => TRUE,
				'quality'  		 => '100%',
				'width' 		 => 440,
				'height' 		 => 440,
				'master_dim' 	 => 'width',
				));
			
			if(!$this->image_lib->resize())
			{
				echo $error = $this->image_lib->display_errors();die;
			}

			$user_image=$picture['file_name'];
			$this->input->post('pre_profile_image');			

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
			// $user_image= $data["profile_image"];	

		} else {
        if($this->input->post('pre_profile_image')!='')
        {
          $user_image=$this->input->post('pre_profile_image');
        }
      }			

		$fullname = trim($this->input->post('full_name'));
		$phone 	  = trim($this->input->post('mobileno'));
		
		 $data=array(		 
			'FullName'=>trim($this->input->post('full_name')),
			'UserContact'=>trim($this->input->post('mobileno')),
			'EmailAddress'=>trim($this->input->post('email')),
			'DateofBirth'=>trim($this->input->post('dob')),
			//'Address'=>trim($this->input->post('address')),
			'Project_name'=>trim($this->input->post('project_name')),
			'House_no'=>trim($this->input->post('house_no')),			
			'ProfileImage'=>$user_image,
		 );
		
		 //echo "<pre>";print_r($data);die;

		 $this->db->where('UsersId',$user_id);
		 $this->db->update('tbluser',$data);
         // echo $this->db->last_query();die;
		
		return $data;
 
	}


	/*
	 * Function: check_user_id
	 * Author: Binny
	 * Date: 21/11/2017
	 * Input: id
	 * Output: array return 
	*/
	function check_user_id($id) {
		$query = $this->db->get_where('tbluser',array('UsersId'=>$id));
		return $query->num_rows();
	}

	/*
	 * Function: forgot_password
	 * Author: Binny
	 * Date: 21/11/2017
	 * Input: email
	 * Output: array return 
	*/
	function forgot_password($mobileno)
	{

		//$headers = apache_request_headers();  	
		$rnd 			= randomCode();
		//$site_setting   = site_setting();
		$query 			= $this->db->get_where("tbluser",array("UserContact"=>$mobileno));
		$res 			= $query->row();		
		if($query->num_rows() > 0)
		{
			if($res->IsActive == 'Inactive')
			{	
			  		
				$data['status'] = 'fail';
				$data['error']  = 'Your account is inactive. Please contact administrator!';	
				return $data;
				
			}
			else{				
				$ud=array('ResetPasswordCode'=>$rnd);				
				$this->db->where('UsersId',$res->UsersId);
				$this->db->update('tbluser',$ud);
	            $data['message'] = "Check your email for the reset password";
				$data['status']  = 'success';
				/*echo "<pre>";
				print_r($data);exit;*/
				return $data;
			}
		}
		else
		{
				$data['status'] = 'fail';
				$data['error']  = 'Please enter registered Mobile Number';
				return $data;
		}
	}


	/*
	 * Function: check_user_activation 
	 * Author: Binny
	 * Date: 23/11/2017
	 * Input:post uid,email_verification_code
	 * Output: INT 
	*/
	function check_user_activation($uid=0,$email_verification_code='')
	{
		$query = $this->db->query("SELECT * FROM  ".$this->db->dbprefix('user')." where email_verification_code='".$email_verification_code."' and user_id = '".$uid."' and verify_email = '0'");
	    //echo $this->db->last_query();exit;
		if($query->num_rows()>0)
		{
			$data = array('verify_email'=>'1','status'=>'0');
			$this->db->where('user_id',$uid);
			$this->db->update('user',$data);
			return 1;
		}
		else 
		{
			return 0;
		}  
	}

	/*
	 * Function: check_api_login 
	 * Author: Binny
	 * Date: 23/11/2017
	 * Input: post array
	 * Output: array 
	*/
	function check_api_login()
	{
       
		//print_r(md5($this->input->post('password')));
		//$email 	  = $this->input->post('email');
		$mobileno = $this->input->post('mobileno');		
		$password = $this->input->post('password');		
		$data 	  = array();

		$query = $this->db->get_where('tbluser',array('UserContact'=>$mobileno,'UserPassword'=>md5($password)));
		//echo $this->db->last_query();die;
		if($query->num_rows() == 1)
		{			
			$user = $query->row_array();
			

			if($user['IsActive']=='Active')
			{
				$data['status'] ='success';	
				$data['result'] = array(
					'email' 		=> trim($user['EmailAddress']),
					'full_name' 	=> trim($user['FullName']),				
					'mobileno'		=> trim($user['UserContact']),
					'dob'			=> trim($user['DateofBirth']),
					'Address'		=> trim($user['Address']),
					'project_name'	=> trim($user['Project_name']),
					'House_no'	=> trim($user['House_no']),					
					'user_id'		=> trim($user["UsersId"]),
					);
				return $data;		
			}
			else if($user['IsActive']=='Inactive'){
				$data['status'] ='fail';
				$data['error']  ='Your account is inactive. Please contact administrator!';
				return $data;
			}
		}
		else
		{
			$data['status'] = 'fail';
			$data['error']  = 'Invalid Mobile Number or Password';
			return $data;
		}
	}
	

	function get_all_project(){
		
		$data= array();
		$this->db->select('ProjectId,ProjectTitle,Project_brochure,Projectlogo,ProjectStatus');
		$this->db->from('tblprojects');	
		$this->db->order_by('ProjectId','asc');
		$query=$this->db->get();
		
		return $query->result_array();

	}	

	function get_single_project($project_id)
	{
		$planlayout=array();
		$galleryimg=array();
		$specdata=array();
		$this->db->select('*');
		$this->db->from('tblplanlayout');
		$this->db->where('project_id',$project_id);	
		$this->db->order_by('planlayout_id','asc');
		$query=$this->db->get();

		$this->db->select('*');
		$this->db->from('tblprojects');
		$this->db->where('ProjectId',$project_id);	
		$this->db->order_by('ProjectId','asc');
		$query1=$this->db->get();

		$this->db->select('*');
		$this->db->from('tblgallery');
		$this->db->where('project_id',$project_id);	
		$this->db->order_by('gallery_id','asc');
		$query2=$this->db->get();

		$this->db->select('*');
		$this->db->from('tblspecification');
		$this->db->where('project_id',$project_id);	
		$this->db->order_by('specification_id','asc');
		$query3=$this->db->get();

		
		//echo $this->db->last_query();die;
		
		foreach ($query->result_array() as $row) {
			array_push($planlayout,array('planlayoutimage'=>$row['planlayout_image']));
			
		}
		foreach ($query2->result_array() as $row) {
			array_push($galleryimg,array('galleryimage'=>$row['gallery_image']));
			
		}
		foreach ($query3->result_array() as $row) {
			array_push($specdata,array('spectitle'=>$row['spectitle'],
				'specdesc'=>$row['specdesc'],
				'logo_image'=>$row['logo_image'],
			));
		}

		if($query->num_rows()>0){		
				$project_detail = $query1->row();
				
	 			
				$data = array(
					'ProjectId' 	    => trim($project_detail->ProjectId),
					'ProjectTitle' 		=> trim($project_detail->ProjectTitle),				
					'Projectsdesc'		=> trim($project_detail->Projectsdesc),
					'Projectlogo'		=> trim($project_detail->Projectlogo),
					'ProjectImage'		=> trim($project_detail->ProjectImage),
					'Projectldesc'		=> trim($project_detail->Projectldesc),
					'Project_brochure'	=> trim($project_detail->Project_brochure),
					'Project_status'	=> trim($project_detail->ProjectStatus),
					'Project_planlayout'=>$planlayout,
					'Project_galleryimage'=>$galleryimg,
					'Project_specification'=>$specdata

					
					);	
					//echo "<pre>";print_r($data);die;	
				return $data;
			}else{
				return array();
			}
		
			
	}
	function userrefer_api(){
		//echo "hghgh";die;
 		//echo $this->input->post('property');die;
		$data = array(
			'user_id'     => $this->input->post('user_id'),
			'name'   	  => $this->input->post('name'),
			'email' 	  => $this->input->post('email'),
			'mobileno' 	  => $this->input->post('mobileno'),
			'property' 	  => $this->input->post('property'),
			'status'	  =>'Refered',
			'create_date'=>date('Y-m-d')			
			);
		$user_id= insert_record_api('tblrefer',$data);
		return true;
	}

}



?>