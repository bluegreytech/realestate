<?php

class Program_model extends CI_Model
 {
	//
	function insertdata()
	{	
			$ProgramId=$this->input->post('ProgramId');
			$StreamTypeId=$this->input->post('StreamTypeId');
			$ProgramName=$this->input->post('ProgramName');
			$ProgramDescription=$this->input->post('ProgramDescription');
			$ProgramPrice=$this->input->post('ProgramPrice');
			
			//$ProgramImage=$this->input->post('ProgramImage');
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'StreamTypeId'=>$StreamTypeId,
			'ProgramName'=>$ProgramName, 
			'ProgramDescription'=>$ProgramDescription,
			'IsActive'=>$IsActive,
			'CreatedBy'=>1
			);
			$res=$this->db->insert('tblprogramtype',$data);	
			return $res;
	}
	
	//
	function getstream(){
		$this->db->select('*');
		$this->db->from('tblstreamtype');
		$r = $this->db->get();
		$res = $r->result();
		return $res;

	}
	//
	function getprogram(){
		$r=$this->db->select('t1.ProgramId,t1.ProgramName,t1.ProgramDescription,t1.ProgramPrice,t1.ProgramImage,t1.IsActive,t2.StreamTypeId,t2.StreamName')
					->from('tblprogramtype as t1')
					->join('tblstreamtype as t2', 't1.StreamTypeId = t2.StreamTypeId', 'LEFT')
					->get();
		$res = $r->result();
		return $res;

	}
	//
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblprogramtype");
		$this->db->where("ProgramId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}
	//
	function updatedata(){
		$id=$this->input->post('ProgramId');
		$data=array(
			'StreamTypeId'=>$this->input->post('StreamTypeId'),
			'ProgramName'=>$this->input->post('ProgramName'),
			'ProgramDescription'=>$this->input->post('ProgramDescription'),
			'ProgramPrice'=>$this->input->post('ProgramPrice'),
			//'ProgramImage'=>$this->input->post('ProgramImage'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("ProgramId",$id);
		$this->db->update('tblprogramtype',$data);		
		return 1;
	}

}
