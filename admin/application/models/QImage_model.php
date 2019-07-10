<?php

class QImage_model extends CI_Model
 {
	
	function insertdata()
	{	
		//	$QuestionImageId=$this->input->post('QuestionImageId'),
			$AssesmentTypeId=$this->input->post('AssesmentTypeId');
			$QuestionImageType=$this->input->post('QuestionImageType');
			$QuestionImageName=$this->input->post('QuestionImageName');	
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'AssesmentTypeId'=>$AssesmentTypeId,
			'QuestionImageType'=>$QuestionImageType,
			'QuestionImageName'=>$QuestionImageName, 
			'IsActive'=>$IsActive,
			'CreatedBy'=>1
			);
			$res=$this->db->insert('tblquestionpicture',$data);	
			return $res;
	}
	
	function getstream(){
		$this->db->select('*');
		$this->db->from('tblstreamtype');
		$r = $this->db->get();
		$res = $r->result();
		return $res;
	}
	
	function getpro(){
		$this->db->select('*');
		$this->db->from('tblprogramtype');
		$r = $this->db->get();
		$res = $r->result();
		return $res;
	}

	function getassesment(){
		$r=$this->db->select('t3.QuestionImageId,t3.StreamTypeId,t3.ProgramId,t3.AssesmentName,t3.IsActive,t1.ProgramName,t2.StreamName')
					->from('tblquestionpicture as t3')
					->join('tblprogramtype as t1', 't3.ProgramId = t1.ProgramId', 'LEFT')
					->join('tblstreamtype as t2', 't3.StreamTypeId = t2.StreamTypeId', 'LEFT')
					->get();
		$res = $r->result();
		return $res;

	}
	
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblquestionpicture");
		$this->db->where("QuestionImageId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function updatedata(){
		$id=$this->input->post('QuestionImageId');
		$data=array(
			'QuestionImageId'=>$this->input->post('QuestionImageId'),
			'AssesmentTypeId'=>$this->input->post('AssesmentTypeId'),
			'QuestionImageType'=>$this->input->post('QuestionImageType'),
			'QuestionImageName'=>$this->input->post('QuestionImageName'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("QuestionImageId",$id);
		$this->db->update('tblquestionpicture',$data);		
		return 1;
	}

}
