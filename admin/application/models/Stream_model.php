<?php

class Stream_model extends CI_Model
 {
	
	function insertdata()
	{
		$StreamName=$this->input->post('StreamName');
		$IsActive=$this->input->post('IsActive');	
		$data=array(
		'StreamName'=>$StreamName, 
		'IsActive'=>$IsActive,
		'CreatedBy'=>1
		);
		$res=$this->db->insert('tblstreamtype',$data);	
		return $res;

	}

	function getstream(){
		$this->db->select('*');
		$this->db->from('tblstreamtype');
		$r = $this->db->get();
		$res = $r->result();
		return $res;

	}
	
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblstreamtype");
		$this->db->where("StreamTypeId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function updatedata(){
		$id=$this->input->post('StreamTypeId');
		$data=array('StreamName'=>$this->input->post('StreamName'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("StreamTypeId",$id);
		$this->db->update('tblstreamtype',$data);		
		//echo $this->db->last_query();die;
		return 1;
	}

	
	
}
