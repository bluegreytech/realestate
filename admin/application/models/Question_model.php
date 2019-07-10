<?php

class Question_model extends CI_Model
 {

	function insertdata()
	{	
			$QuestionId=$this->input->post('QuestionId');
			$AssesmentTypeId=$this->input->post('AssesmentTypeId');
			$QuestionName=$this->input->post('QuestionName');	
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'AssesmentTypeId'=>$AssesmentTypeId,
			'QuestionName'=>$QuestionName, 
			'IsActive'=>$IsActive,
			'CreatedBy'=>1
			);
			$res=$this->db->insert('tblquestion',$data);	
			return $res;
	}
	
	
	function getassesment(){
		$this->db->select('*');
		$this->db->from('tblassesmenttype');
		$r = $this->db->get();
		$res = $r->result();
		return $res;

	}
	
	function getquestion(){
		$r=$this->db->select('t1.QuestionId,t1.AssesmentTypeId,t1.QuestionName,t1.IsActive,t2.AssesmentName')
					->from('tblquestion as t1')
					->join('tblassesmenttype as t2', 't1.AssesmentTypeId = t2.AssesmentTypeId', 'LEFT')
					->get();
		$res = $r->result();
		return $res;
	}
	
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblquestion");
		$this->db->where("QuestionId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function updatedata(){
		$id=$this->input->post('QuestionId');
		$data=array(
			'AssesmentTypeId'=>$this->input->post('AssesmentTypeId'),
			'QuestionName'=>$this->input->post('QuestionName'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("QuestionId",$id);
		$this->db->update('tblquestion',$data);		
		return 1;
	}


		
	
}
