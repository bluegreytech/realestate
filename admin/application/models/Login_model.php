<?php

class Login_model extends CI_Model
 {
		function login_where($table,$where)
		{
			$r = $this->db->get_where($table,$where);
			$res = $r->row();
			return $res;
		}
		function updateProfile(){

		// 	echo "<pre>";print_r($_POST);
		// 	$data = array(
		// 	//'Email' => $this->input->post('EmailAddress'),
		// 	'FullName' => $this->input->post('FullName'),			
		// 	'AdminContact' => $this->input->post('AdminContact'),
		// 	'Isactive' => $this->input->post('Isactive'),			
		// 	);	
		// //print_r($data); die;	
		// $this->db->where('AdminId',get_authenticateadminID());
		// $this->db->update('tbladmin',$data);


	    $user_image='';
      //$image_settings=image_setting();
      if(isset($_FILES['profile_image']) &&  $_FILES['profile_image']['name']!='')
      {
        $this->load->library('upload');
        $rand=rand(0,100000); 

        $_FILES['userfile']['name']     =   $_FILES['profile_image']['name'];
        $_FILES['userfile']['type']     =   $_FILES['profile_image']['type'];
        $_FILES['userfile']['tmp_name'] =   $_FILES['profile_image']['tmp_name'];
        $_FILES['userfile']['error']    =   $_FILES['profile_image']['error'];
        $_FILES['userfile']['size']     =   $_FILES['profile_image']['size'];   
        $config['file_name'] = $rand.'Admin';      
        $config['upload_path'] = base_path().'upload/admin_orig/';      
        $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
        $this->upload->initialize($config);

        if (!$this->upload->do_upload())
        {
        $error =  $this->upload->display_errors();
      	echo "<pre>"; print_r($error);die; 
        }        

        $picture = $this->upload->data();       
        $this->load->library('image_lib');       
        $this->image_lib->clear();       

        $gd_var='gd2';
        $this->image_lib->initialize(array(
        'image_library' => $gd_var,
        'source_image' => base_path().'upload/admin_orig/'.$picture['file_name'],
        'new_image' => base_path().'upload/admin/'.$picture['file_name'],
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
        $this->input->post('prev_user_image');
        if($this->input->post('pre_profile_image')!='')
        {
        if(file_exists(base_path().'upload/admin/'.$this->input->post('pre_profile_image')))
        {
        $link=base_path().'upload/admin/'.$this->input->post('pre_profile_image');
        unlink($link);
        }

        if(file_exists(base_path().'upload/admin_orig/'.$this->input->post('pre_profile_image')))
        {
        $link2=base_path().'upload/admin_orig/'.$this->input->post('pre_profile_image');
        unlink($link2);
        }
        }
      }else{
        if($this->input->post('pre_profile_image')!='')
        {
        $user_image=$this->input->post('pre_profile_image');
        }
      }
        //$full_name=trim($this->input->post('full_name'));
        $data = array(
		'EmailAddress' =>trim($this->input->post('EmailAddress')),
		'FullName' =>trim($this->input->post('full_name')),			
		'AdminContact' => trim($this->input->post('AdminContact')),
		'Isactive' => trim($this->input->post('IsActive')),	      
        'ProfileImage'=>$user_image,
        );  
          $this->db->where('AdminId',$this->session->userdata('AdminId'));
          $this->db->update('tbladmin',$data);
       
		}

}
