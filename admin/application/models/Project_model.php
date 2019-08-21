<?php

class Project_model extends CI_Model
 {
	function project_insert()
	{	
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
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/projectimage/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/projectimage/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_profile_image')!='')
				{
					$project_image=$this->input->post('pre_profile_image');
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
			 $project_logo=$picture['file_name'];

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
			'ProjectTitle'=>trim($this->input->post('ProjectTitle')),			
			'Projectsdesc'=>trim($this->input->post('Projectsdesc')),
			'Projectldesc'=>trim($this->input->post('Projectldesc')),
			'Project_lat'=>trim($this->input->post('project_lat')),
			'Project_long'=>trim($this->input->post('project_long')),
			'ProjectImage'=>$project_image,
			'Projectlogo'=>$project_logo,
			'Project_brochure'=>$project_brochure,
			'Projectstatus'=>$this->input->post('Projectstatus'),		
			'IsActive' =>$this->input->post('IsActive'),			
			'CreatedOn'=>date('Y-m-d')		
			);
		  // echo "<pre>";print_r($data);die;	
                    
            $res=$this->db->insert('tblprojects',$data);	
			return $res;
	}

	function getproject(){
		$r=$this->db->select('*')
					->from('tblprojects')->where('Is_deleted','0')
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
			 $project_logo=$picture['file_name'];

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
			'Projectldesc' => trim($this->input->post('Projectldesc')),
			'Project_lat'=>trim($this->input->post('project_lat')),
			'Project_long'=>trim($this->input->post('project_long')),
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

	function getgallery(){
		$this->db->select('*');
		$this->db->from('tblgallery');
		$this->db->where('Is_deleted','0');
		$r=$this->db->get();
		$res = $r->result();
		return $res;
	}
	function getgallerydata($id){
		$this->db->select('*');
		$this->db->from('tblgallery');
		$this->db->where('Is_deleted','0');
		$this->db->where("gallery_id",$id);
		$query=$this->db->get();
		return $query->row_array();
	}


	function gallery_insert(){
		//echo "<pre>";print_r($_POST);die;
		
         	$gallery_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['GalleryImages']) &&  $_FILES['GalleryImages']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['GalleryImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['GalleryImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['GalleryImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['GalleryImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['GalleryImages']['size'];
   
			$config['file_name'] = $rand.'GalleryImages';			
			$config['upload_path'] = base_path().'upload/galleryimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);die;		
			$gallery_image=$picture['file_name'];
			if($this->input->post('pre_gallery_image')!='')
				{
					if(file_exists(base_path().'upload/galleryimage/'.$this->input->post('pre_gallery_image')))
					{
						$link=base_path().'upload/galleryimage/'.$this->input->post('pre_gallery_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_gallery_image')!='')
				{
					$gallery_image=$this->input->post('pre_gallery_image');
				}
	    }
   
		
			//project logo upload end //

		
          
            $data = array(					
			'project_id' => trim($this->input->post('project_id')),
			'gallery_image'=>$gallery_image,		
			'IsActive' => $this->input->post('IsActive'),			
			'created_date'=>date('Y-m-d  H:i:s')		
			);
		   //echo "<pre>";print_r($data);die;	
          
	    
		$res=$this->db->insert('tblgallery',$data);		
		return $res;
	}
	function gallery_update(){
		//echo "<pre>";print_r($_POST);die;
		$id=$this->input->post('GalleryId');
         	$gallery_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['GalleryImages']) &&  $_FILES['GalleryImages']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['GalleryImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['GalleryImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['GalleryImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['GalleryImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['GalleryImages']['size'];
   
			$config['file_name'] = $rand.'GalleryImages';			
			$config['upload_path'] = base_path().'upload/galleryimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);die;		
			$gallery_image=$picture['file_name'];
			if($this->input->post('pre_gallery_image')!='')
				{
					if(file_exists(base_path().'upload/galleryimage/'.$this->input->post('pre_gallery_image')))
					{
						$link=base_path().'upload/galleryimage/'.$this->input->post('pre_gallery_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_gallery_image')!='')
				{
					$gallery_image=$this->input->post('pre_gallery_image');
				}
	    }
   
		
			//project logo upload end //

		
          
            $data = array(					
			'project_id' => trim($this->input->post('project_id')),
			'gallery_image'=>$gallery_image,		
			'IsActive' => $this->input->post('IsActive'),			
			'updated_date'=>date('Y-m-d  H:i:s')		
			);
		   //echo "<pre>";print_r($data);die;	
          
	    $this->db->where("gallery_id",$id);
		$res=$this->db->update('tblgallery',$data);		
		return $res;
	}

	function getplanlayout(){
		$this->db->select('*');
		$this->db->from('tblplanlayout');
		$this->db->where('Is_deleted','0');
		$r=$this->db->get();
		$res = $r->result();
		return $res;
	}
	function getplanlayoutdata($id){
		$this->db->select('*');
		$this->db->from('tblplanlayout');
		$this->db->where('Is_deleted','0');
		$this->db->where("planlayout_id",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function planlayout_insert(){
		//echo "<pre>";print_r($_POST);die;
		
         	$planlayout_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['PlanlayoutImages']) &&  $_FILES['PlanlayoutImages']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['PlanlayoutImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['PlanlayoutImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['PlanlayoutImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['PlanlayoutImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['PlanlayoutImages']['size'];
   
			$config['file_name'] = $rand.'PlanlayoutImages';			
			$config['upload_path'] = base_path().'upload/galleryimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);die;		
			$planlayout_image=$picture['file_name'];
			if($this->input->post('pre_planlayout_image')!='')
				{
					if(file_exists(base_path().'upload/galleryimage/'.$this->input->post('pre_planlayout_image')))
					{
						$link=base_path().'upload/galleryimage/'.$this->input->post('pre_planlayout_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_planlayout_image')!='')
				{
					$planlayout_image=$this->input->post('pre_planlayout_image');
				}
	    }
   
		
			//project logo upload end //

		
          
            $data = array(					
			'project_id' => trim($this->input->post('project_id')),
			'planlayout_image'=>$planlayout_image,		
			'IsActive' => $this->input->post('IsActive'),			
			'created_date'=>date('Y-m-d  H:i:s')		
			);
		  // echo "<pre>";print_r($data);die;	
          
	    
		$res=$this->db->insert('tblplanlayout',$data);		
		return $res;
	}
	function planlayout_update(){
		//echo "<pre>";print_r($_POST);die;
		$id=$this->input->post('PlanlayoutId');
         	$planlayout_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['PlanlayoutImages']) &&  $_FILES['PlanlayoutImages']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['PlanlayoutImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['PlanlayoutImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['PlanlayoutImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['PlanlayoutImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['PlanlayoutImages']['size'];
   
			$config['file_name'] = $rand.'PlanlayoutImages';			
			$config['upload_path'] = base_path().'upload/galleryimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);die;		
			$planlayout_image=$picture['file_name'];
			if($this->input->post('pre_planlayout_image')!='')
				{
					if(file_exists(base_path().'upload/galleryimage/'.$this->input->post('pre_planlayout_image')))
					{
						$link=base_path().'upload/galleryimage/'.$this->input->post('pre_planlayout_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_planlayout_image')!='')
				{
					$planlayout_image=$this->input->post('pre_planlayout_image');
				}
	    }
			//project logo upload end //

            $data = array(					
			'project_id' => trim($this->input->post('project_id')),
			'planlayout_image'=>$planlayout_image,		
			'IsActive' => $this->input->post('IsActive'),			
			'updated_date'=>date('Y-m-d H:i:s')		
			);
		 //  echo "<pre>";print_r($data);die;	
          
	    $this->db->where("planlayout_id",$id);
		$res=$this->db->update('tblplanlayout',$data);		
		return $res;
	}
    

    function getspecification(){
		$this->db->select('*');
		$this->db->from('tblspecification');
		$this->db->where('Is_deleted','0');
		$r=$this->db->get();
		$res = $r->result();
		return $res;
	}
	function getspecificationdata($id){
		$this->db->select('*');
		$this->db->from('tblspecification');
		$this->db->where('Is_deleted','0');
		$this->db->where("specification_id",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function specification_insert(){
		//echo "<pre>";print_r($_POST);die;
		
         	$logo_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['LogoImages']) &&  $_FILES['LogoImages']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['LogoImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['LogoImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['LogoImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['LogoImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['LogoImages']['size'];
   
			$config['file_name'] = $rand.'SpecificationLogo';			
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
			$logo_image=$picture['file_name'];
			if($this->input->post('pre_logo_image')!='')
				{
					if(file_exists(base_path().'upload/projectlogo/'.$this->input->post('pre_logo_image')))
					{
						$link=base_path().'upload/projectlogo/'.$this->input->post('pre_logo_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_logo_image')!='')
				{
					$logo_image=$this->input->post('pre_logo_image');
				}
	    }
   
		
			//project logo upload end //

          
            $data = array(					
			'project_id' => trim($this->input->post('project_id')),
			'spectitle' => trim($this->input->post('spectitle')),
			'specdesc' => trim($this->input->post('specdesc')),
			'logo_image'=>$logo_image,		
			'IsActive' => $this->input->post('IsActive'),			
			'created_date'=>date('Y-m-d  H:i:s')		
			);
		  // echo "<pre>";print_r($data);die;	
          
	    
		$res=$this->db->insert('tblspecification',$data);		
		return $res;
	}
	function specification_update(){
		//echo "<pre>";print_r($_POST);die;
		$id=$this->input->post('SpecificationId');
         	$planlayout_image='';
         	//$image_settings=image_setting();
		if(isset($_FILES['LogoImages']) &&  $_FILES['LogoImages']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['LogoImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['LogoImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['LogoImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['LogoImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['LogoImages']['size'];
   
			$config['file_name'] = $rand.'LogoImages';			
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
			$logo_image=$picture['file_name'];
			if($this->input->post('pre_logo_image')!='')
				{
					if(file_exists(base_path().'upload/projectlogo/'.$this->input->post('pre_logo_image')))
					{
						$link=base_path().'upload/projectlogo/'.$this->input->post('pre_logo_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_logo_image')!='')
				{
					$logo_image=$this->input->post('pre_logo_image');
				}
	    }
			//project logo upload end //

            $data = array(					
			'project_id' => trim($this->input->post('project_id')),
			'spectitle'  => trim($this->input->post('spectitle')),
			'specdesc' 	 => trim($this->input->post('specdesc')),
			'logo_image' => $logo_image,		
			'IsActive'   => $this->input->post('IsActive'),			
			'updated_date'=>date('Y-m-d H:i:s')		
			);
		 //  echo "<pre>";print_r($data);die;	
          
	    $this->db->where("specification_id",$id);
		$res=$this->db->update('tblspecification',$data);		
		return $res;
	}
   

   function getprojectslider(){
		$this->db->select('*');
		$this->db->from('tblproject_slider');
		$this->db->where('Is_deleted','0');
		$r=$this->db->get();
		$res = $r->result();
		return $res;
	}
	function getprojectsliderdata($id){
		$this->db->select('*');
		$this->db->from('tblproject_slider');
		$this->db->where('Is_deleted','0');
		$this->db->where("projectslider_id",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

    function projectslider_insert(){
		//echo "<pre>";print_r($_FILES['ProjectsliderImages']['name']);die;
		
         	$projectslider_image='';
         	$picture=array();
         	//$image_settings=image_setting();
         
		if(isset($_FILES['ProjectsliderImages']) &&  $_FILES['ProjectsliderImages']['name']!='')
        {
			$this->load->library('upload');
			$rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['ProjectsliderImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['ProjectsliderImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['ProjectsliderImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['ProjectsliderImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['ProjectsliderImages']['size'];
   
			$config['file_name'] = $rand.'ProjectsliderImages';			
			$config['upload_path'] = base_path().'upload/projectimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);		
		    $projectslider_image=$picture['file_name'];
			if($this->input->post('pre_projectslider_image')!='')
				{
					if(file_exists(base_path().'upload/projectimage/'.$this->input->post('pre_projectslider_image')))
					{
						$link=base_path().'upload/projectimage/'.$this->input->post('pre_projectslider_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_projectslider_image')!='')
				{
					$projectslider_image=$this->input->post('pre_projectslider_image');
				}
	    }
		$data = array(					
		'project_id' => trim($this->input->post('project_id')),
		'projectslider_img'=>$projectslider_image,		
		'IsActive' => $this->input->post('IsActive'),			
		'created_date'=>date('Y-m-d  H:i:s')		
		);
		   
		$res=$this->db->insert('tblproject_slider',$data);

	
   
		return $res;	
			//project logo upload end //

	}
	function projectslider_update(){
		//echo "<pre>";print_r($_POST);die;
		$id=$this->input->post('projectslider_id');
      	$projectslider_image='';
         	$picture=array();
         	//$image_settings=image_setting();
         	 $cpt = count($_FILES['ProjectsliderImages']['name']);
   
		if(isset($_FILES['ProjectsliderImages']) &&  $_FILES['ProjectsliderImages']['name']!='')
        {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
			$_FILES['userfile']['name']     =   $_FILES['ProjectsliderImages']['name'];
			$_FILES['userfile']['type']     =   $_FILES['ProjectsliderImages']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['ProjectsliderImages']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['ProjectsliderImages']['error'];
			$_FILES['userfile']['size']     =   $_FILES['ProjectsliderImages']['size'];
   
			$config['file_name'] = $rand.'ProjectsliderImages';			
			$config['upload_path'] = base_path().'upload/projectimage/';		
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo "<pre>";print_r($error);
			  } 
			$picture = $this->upload->data();	
			//echo "<pre>";print_r($picture);		
		    $projectslider_image=$picture['file_name'];
			if($this->input->post('pre_projectslider_image')!='')
				{
					if(file_exists(base_path().'upload/projectimage/'.$this->input->post('pre_projectslider_image')))
					{
						$link=base_path().'upload/projectimage/'.$this->input->post('pre_projectslider_image');
						unlink($link);
					}
				}
			} else {
				if($this->input->post('pre_projectslider_image')!='')
				{
					$projectslider_image=$this->input->post('pre_projectslider_image');
				}
	    }
	      $data = array(					
			'project_id' => trim($this->input->post('project_id')),
			'projectslider_img'=>$projectslider_image,		
			'IsActive' => $this->input->post('IsActive'),			
			'created_date'=>date('Y-m-d  H:i:s')		
			);
		   
		
		 $this->db->where("projectslider_id",$id);
		$res=$this->db->update('tblproject_slider',$data);
   
	return $res;	

	}

	       
	
}
