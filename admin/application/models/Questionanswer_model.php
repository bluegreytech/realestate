<?php

class Questionanswer_model extends CI_Model
 {

	function insertdata()
	{	
		//	$QuestionAnswerId=$this->input->post('QuestionAnswerId');
			$QuestionId=$this->input->post('QuestionId');
			$QuestionAnswer=$this->input->post('QuestionAnswer');	
			$QuestionAnswerRateId=$this->input->post('QuestionAnswerRateId');	
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'QuestionId'=>$QuestionId,
			'QuestionAnswer'=>$QuestionAnswer, 
			'QuestionAnswerRateId'=>$QuestionAnswerRateId, 
			'IsActive'=>$IsActive,
			'CreatedBy'=>1
			);
			// prin_r($data);
			// die;
			$res=$this->db->insert('tblquestionanswer',$data);	
			return $res;
	}
	
	function getquestion(){
		$this->db->select('*');
		$this->db->from('tblquestion');
		$r = $this->db->get();
		$res = $r->result();
		return $res;
	}

	function getquestionrate(){
		$this->db->select('*');
		$this->db->from('tblquestionanswerrate');
		$r = $this->db->get();
		$res = $r->result();
		return $res;
	}
	
	function getquestionanswer(){
		$r=$this->db->select('t1.QuestionAnswerId,t1.QuestionId,t1.QuestionAnswer,t1.QuestionAnswerRateId,t1.IsActive,t2.QuestionName,t3.AnswerRate')
					->from('tblquestionanswer as t1')
					->join('tblquestion as t2', 't1.QuestionId = t2.QuestionId', 'LEFT')
					->join('tblquestionanswerrate as t3', 't1.QuestionAnswerRateId = t3.QuestionAnswerRateId', 'LEFT')
					->get();
		$res = $r->result();
		return $res;
	}
	
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblquestionanswer");
		$this->db->where("QuestionAnswerId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function updatedata(){
		$id=$this->input->post('QuestionAnswerId');
		$data=array(
			'QuestionId'=>$this->input->post('QuestionId'),
			'QuestionAnswer'=>$this->input->post('QuestionAnswer'),
			'QuestionAnswerRateId'=>$this->input->post('QuestionAnswerRateId'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("QuestionAnswerId",$id);
		$this->db->update('tblquestionanswer',$data);		
		return 1;
	}


		
	
}
