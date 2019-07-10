<?php

class Rate_model extends CI_Model
 {
	function insertdata()
	{
		$AnswerRate=$this->input->post('AnswerRate');
		$IsActive=$this->input->post('IsActive');	
		$data=array(
		'AnswerRate'=>$AnswerRate, 
		'IsActive'=>$IsActive,
		'CreatedBy'=>1
		);
		$res=$this->db->insert('tblquestionanswerrate',$data);	
		return $res;

	}
	function select_standard()
    {
        $this->db->select('*');
		$this->db->from('tblquestionanswerrate');
		$r = $this->db->get();
		$res = $r->result();
		return $res;
	}
	function delete_data($table,$where)
	{
		$result=$this->db->delete('tblquestionanswerrate',$where);
		return $result;
		
	}
	function sel($table,$where)
	{
		$r = $this->db->get_where($table,$where);
		$res = $r->result();
		return $res;
	}
	function update_data($table,$data)
	{
		$this->db->set($data);
		$this->db->where('QuestionAnswerRateId',$data['QuestionAnswerRateId']);
		$res=$this->db->update($table);
		return $res;
	}
	function getstandard(){
		$this->db->select('*');
		$this->db->from('tblquestionanswerrate');
		$r = $this->db->get();
		$res = $r->result();
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
		$id=$this->input->post('QuestionAnswerRateId');
		$data=array('AnswerRate'=>$this->input->post('AnswerRate'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("QuestionAnswerRateId",$id);
		$this->db->update('tblquestionanswerrate',$data);		
		return 1;
	}
	
}
