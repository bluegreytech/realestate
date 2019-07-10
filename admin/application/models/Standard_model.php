<?php

class Standard_model extends CI_Model
 {
 	
	function getstandard(){
		$this->db->select('*');
		$this->db->from('tblstandard');
		$r = $this->db->get();
		$res = $r->result();
		return $res;

	}
	function insertdata()
	{
		$Standard=$this->input->post('Standard');
		$IsActive=$this->input->post('IsActive');
		$streamid=$this->input->post('streamid');
		$data=array(
		'streamid'=>$streamid,
		'Standard'=>$Standard, 
		'IsActive'=>$IsActive,
		'CreatedBy'=>1
		);
		$res=$this->db->insert('tblstandard',$data);	
		return $res;

	}
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblquestionanswerrate");
		$this->db->where("QuestionAnswerRateId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}
	function updatedata(){
		$id=$this->input->post('StandardId');
		$data=array('Standard'=>$this->input->post('Standard'),
			'IsActive'=>$this->input->post('IsActive'),
			"streamid"=>$this->input->post('streamid'),
			  );
	    $this->db->where("StandardId",$id);
		$this->db->update('tblstandard',$data);		
		//echo $this->db->last_query();die;
		return 1;
	}
	
	

	
	
}
