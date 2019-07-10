<?php

class Project_model extends CI_Model
 {
	function insertdata()
	{		
			$ProjectTitle=$this->input->post('ProjectTitle');
			$ProjectDescription=$this->input->post('ProjectDescription');
			$Price=$this->input->post('Price');
			$ProjectImage=$this->input->post('ProjectImage');
			$ProjectStatus=$this->input->post('ProjectStatus');
			$IsActive=$this->input->post('IsActive');
			$data=array( 
			'ProjectTitle'=>$ProjectTitle,
			'ProjectDescription'=>$ProjectDescription,
			'Price'=>$Price, 
			'ProjectImage'=>$ProjectImage,
			'ProjectStatus'=>$ProjectStatus, 
			'IsActive'=>$IsActive,
			'CreatedOn'=>date('Y-m-d')
			);
			$res=$this->db->insert('tblprojects',$data);	
			return $res;
	}

	function getuser(){
		$r=$this->db->select('*')
					->from('tblprojects')
					->get();
		$res = $r->result();
		return $res;

	}

	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblprojects");
		$this->db->where("ProjectId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function updatedata(){
		$id=$this->input->post('ProjectId');
		$data=array(
			'ProjectId'=>$this->input->post('ProjectId'),
			'ProjectTitle'=>$this->input->post('ProjectTitle'),
			'ProjectDescription'=>$this->input->post('ProjectDescription'),
			'Price'=>$this->input->post('Price'),
			'ProjectImage'=>$this->input->post('ProjectImage'),
			'ProjectStatus'=>$this->input->post('ProjectStatus'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("ProjectId",$id);
		$this->db->update('tblprojects',$data);		
		return 1;
	}

}
