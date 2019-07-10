<?php

class Assesment_model extends CI_Model
 {
	
	function insertdata()
	{	
		
			$StreamTypeId=$this->input->post('StreamTypeId');
			$ProgramId=$this->input->post('ProgramId');
			$AssesmentName=$this->input->post('AssesmentName');
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'StreamTypeId'=>$StreamTypeId,
			'ProgramId'=>$ProgramId,
			'AssesmentName'=>$AssesmentName, 
			'IsActive'=>$IsActive,
			'CreatedBy'=>1
			);
			$res=$this->db->insert('tblassesmenttype',$data);	
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
		$r=$this->db->select('t3.AssesmentTypeId,t3.StreamTypeId,t3.ProgramId,t3.AssesmentName,t3.IsActive,t1.ProgramName,t2.StreamName')
					->from('tblassesmenttype as t3')
					->join('tblprogramtype as t1', 't3.ProgramId = t1.ProgramId', 'LEFT')
					->join('tblstreamtype as t2', 't3.StreamTypeId = t2.StreamTypeId', 'LEFT')
					->get();
		$res = $r->result();
		return $res;

	}
	
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblassesmenttype");
		$this->db->where("AssesmentTypeId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function updatedata(){
		$id=$this->input->post('AssesmentTypeId');
		$data=array(
			'AssesmentTypeId'=>$this->input->post('AssesmentTypeId'),
			'StreamTypeId'=>$this->input->post('StreamTypeId'),
			'ProgramId'=>$this->input->post('ProgramId'),
			'AssesmentName'=>$this->input->post('AssesmentName'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("AssesmentTypeId",$id);
		$this->db->update('tblassesmenttype',$data);		
		return 1;
	}

}
