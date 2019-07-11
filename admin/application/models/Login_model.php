<?php

class Login_model extends CI_Model
 {
    function checkResetCode($code='')
    {
      $query=$this->db->get_where('tbladmin',array('PasswordResetCode'=>$code));
     
      if($query->num_rows()>0)
      {
        return $query->row()->AdminId; 
      
      }else{
        return '';
      }
    }

    function updatePassword()
    {
        $code=$this->input->post('code');
        $query=$this->db->get_where('tbladmin',array('PasswordResetCode'=>$code));
        if($query->num_rows()>0)
        {
          $data=array('Password'=>md5(trim($this->input->post('Password'))),'PasswordResetCode'=>'');
            $this->db->where(array('AdminId'=>$this->input->post('AdminId'),'PasswordResetCode'=>trim($this->input->post('code'))));
           // print_r($data);die;
            $d=$this->db->update('tbladmin',$data);
            return $d;
          
        }else
        {
          return '';
        }
      }

    function forgotpass_check()
    {
         $EmailAddress=$this->input->post('EmailAddress'); 
         $query = $this->db->get_where('tbladmin',array('EmailAddress'=>$EmailAddress));
         if($query->num_rows()>0)
         {
            $row = $query->row();
            $admin_status=$row->IsActive;
            if($admin_status =='Inactive')
            {
              return "3"; 
            }
            else if($admin_status =='Active')
            {
                if(!empty($row) && $row->EmailAddress!="")
                {
                    $rpass= randomCode();
                    $passdata=array(
                      'PasswordResetCode'=>$rpass
                    );
                    $this->db->where('AdminId',$row->AdminId);
                    $this->db->update('tbladmin',$passdata);            
                  
                    $config['protocol']  = 'smtp';
                    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                    $config['smtp_port'] = '465';
                    $config['smtp_user']='bluegreyindia@gmail.com';
                    $config['smtp_pass']='Test@123'; 
                    $config['charset']='utf-8';
                    $config['newline']="\r\n";
                    $config['mailtype'] = 'html';	
                    $body = base_url().'Home/Resetpassword/'.$rpass;
                    //$body = str_replace(BASE_URL.'/user/edit/'.$rpass);						
                    $this->email->initialize($config);
                    $this->email->from('bluegreyindia@gmail.com', 'Admin');
                    $this->email->to($EmailAddress);		
                    $this->email->subject('FG Password');
                    $this->email->message($body);
                    if($this->email->send())
                    {
                      return '1';
                    
                    }
                             
                }
                else
                {
                  return '0';
                }
            }
        }
        else
        {
          return 2;
        }

    }

		function login_where($table,$where)
		{
			$r = $this->db->get_where($table,$where);
			$res = $r->row();
			return $res;
		}
		function updateProfile(){

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
