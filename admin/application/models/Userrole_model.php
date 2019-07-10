<?php

class Userrole_model extends CI_Model
 {
	 //done
	function insertdata()
	{
		$RoleName=$this->input->post('RoleName');
		$IsActive=$this->input->post('IsActive');	
		$data=array(
		'RoleName'=>$RoleName, 
		'IsActive'=>$IsActive,
		'CreatedBy'=>1
		);
		$res=$this->db->insert('tbluserrole',$data);	
		return $res;

	}
	
	//done
	function getuserrole(){
		$this->db->select('*');
		$this->db->from('tbluserrole');
		$r = $this->db->get();
		$res = $r->result();
		return $res;

	}
	//done
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tbluserrole");
		$this->db->where("RoleId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}
//done
	function updatedata($id){
		$id=$this->input->post('RoleId');
		$data=array('RoleName'=>$this->input->post('RoleName'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("RoleId",$id);
		$this->db->update('tbluserrole',$data);		
		return 1;
	}
	
}
