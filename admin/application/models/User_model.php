<?php

class User_model extends CI_Model
 {
	function insertdata()
	{		
			$FullName=$this->input->post('FullName');
			$EmailAddress=$this->input->post('EmailAddress');
			$Addresses=$this->input->post('Addresses');
			$ProfileImage=$this->input->post('ProfileImage');
			$UserContact=$this->input->post('UserContact');
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'FullName'=>$FullName,
			'EmailAddress'=>$EmailAddress,
			'Addresses'=>$Addresses, 
			'ProfileImage'=>$ProfileImage,
			'UserContact'=>$UserContact, 
			'IsActive'=>$IsActive,
			'CreatedOn'=>date('Y-m-d')
			);
			$res=$this->db->insert('tbluser',$data);	
			return $res;
	}

	function getuser(){
		$r=$this->db->select('*')
					->from('tbluser')
					->get();
		$res = $r->result();
		return $res;

	}

	function getdata($id){
		$this->db->select("*");
		$this->db->from("tbluser");
		$this->db->where("UserId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function updatedata(){
		$id=$this->input->post('UserId');
		$data=array(
			'UserId'=>$this->input->post('UserId'),
			'FullName'=>$this->input->post('FullName'),
			'EmailAddress'=>$this->input->post('EmailAddress'),
			'Addresses'=>$this->input->post('Addresses'),
			'ProfileImage'=>$this->input->post('ProfileImage'),
			'UserContact'=>$this->input->post('UserContact'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("UserId",$id);
		$this->db->update('tbluser',$data);		
		return 1;
	}

}
