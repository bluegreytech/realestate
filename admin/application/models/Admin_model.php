<?php

class Admin_model extends CI_Model
 {
	function insertdata()
	{		
			$FullName=$this->input->post('FullName');
			$EmailAddress=$this->input->post('EmailAddress');
			$Addresses=$this->input->post('Addresses');
			$ProfileImage=$this->input->post('ProfileImage');
			$AdminContact=$this->input->post('AdminContact');
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'FullName'=>$FullName,
			'EmailAddress'=>$EmailAddress,
			'Addresses'=>$Addresses, 
			'ProfileImage'=>$ProfileImage,
			'AdminContact'=>$AdminContact, 
			'IsActive'=>$IsActive,
			'CreatedOn'=>date('Y-m-d')
			);
			$res=$this->db->insert('tbladmin',$data);	
			return $res;
	}

	function getadmin(){
		$r=$this->db->select('*')
					->from('tbladmin')
					->get();
		$res = $r->result();
		return $res;

	}

	function getdata($id){
		$this->db->select("*");
		$this->db->from("tbladmin");
		$this->db->where("AdminId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function updatedata(){
		$id=$this->input->post('AdminId');
		$data=array(
			'AdminId'=>$this->input->post('AdminId'),
			'FullName'=>$this->input->post('FullName'),
			'EmailAddress'=>$this->input->post('EmailAddress'),
			'Addresses'=>$this->input->post('Addresses'),
			'ProfileImage'=>$this->input->post('ProfileImage'),
			'AdminContact'=>$this->input->post('AdminContact'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("AdminId",$id);
		$this->db->update('tbladmin',$data);		
		return 1;
	}

}
