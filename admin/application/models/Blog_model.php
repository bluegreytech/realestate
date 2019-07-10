<?php

class Blog_model extends CI_Model
 {


	// 	public function insertdata()
	// 	{
	// 		if($this->input->post('upload') != NULL )
	// 		{ 
	// 			$data = array(); 
	// 			if(!empty($_FILES['UserImage']['name']))
	// 			{ 
	// 					// Set preference 
	// 					$config['upload_path'] = 'uploads/'; 
	// 					$config['allowed_types'] = 'jpg|jpeg|png|gif'; 
	// 					$config['max_size'] = '100'; // max_size in kb 
	// 					$config['file_name'] = $_FILES['UserImage']['name']; 
					
	// 					$this->load->library('upload',$config); 
	// 					if($this->upload->do_upload('UserImage'))
	// 					{ 
	// 							$uploadData = $this->upload->data(); 
	// 							$filename = $uploadData['file_name']; 
	// 							$data['response'] = 'successfully uploaded '.$filename; 
	// 					}
	// 					else
	// 					{ 
	// 						echo "failed 1111"; 
	// 					} 
	// 			}
	// 			else
	// 			{ 
	// 				echo "failed 2222"; 
	// 			}  
	// 	 }
	// 	 else
	// 	 {
	// 	  		$this->load->view('user_view'); 
	// 	 } 
	// }
	   
	
	function insertdata()
	{	


			$BlogId=$this->input->post('BlogId');
			$FirstName=$this->input->post('FirstName');

			$UserImage=$this->input->post('UserImage');
			$config['upload_path']="./UserImage";
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['max_size'] = '1000000'; 
			$this->upload->initialize($config);  
			$this->upload->do_upload('UserImage');
			$ss = $this->upload->data();
			$userImage =$ss['file_name'];


			$BlogTitle=$this->input->post('BlogTitle');
			$BlogImage=$this->input->post('BlogImage');	

			$config['upload_path']="./BlogImage";
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['max_size'] = '1000000'; 
			$this->upload->initialize($config);  
			$this->upload->do_upload('BlogImage');
			$s = $this->upload->data();
			$blogImage =$s['file_name'];

			// $random1 = substr(number_format(time() * rand(),0,'',''),0,10);
			$BlogDescription=$this->input->post('BlogDescription');
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'FirstName'=>$FirstName,
			'UserImage'=>$userImage,
			'BlogTitle'=>$BlogTitle,
			'BlogImage'=>$blogImage, 
			'BlogDescription'=>$BlogDescription,
			'IsActive'=>$IsActive,
			'CreatedBy'=>1
			);
			// print_r($data);
			// die;
			$res=$this->db->insert('tblblogs',$data);	
			return $res;
	}
	

	
	function getblog(){
		$r=$this->db->select('*')
					->from('tblblogs')
					->get();
		$res = $r->result();
		return $res;

	}
	
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblblogs");
		$this->db->where("BlogId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function updatedata(){
		$id=$this->input->post('BlogId');
		$data=array(
			'FirstName'=>$this->input->post('FirstName'),
			'UserImage'=>$this->input->post('UserImage'),
			'BlogTitle'=>$this->input->post('BlogTitle'),
			'BlogImage'=>$this->input->post('BlogImage'),
			'BlogDescription'=>$this->input->post('BlogDescription'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("BlogId",$id);
		$this->db->update('tblblogs',$data);		
		return 1;
	}


		

}
