<?php

class Standard_model extends CI_Model
 {
	function insertdata()
	{
		$Standard=$this->input->post('Standard');
		$IsActive=$this->input->post('IsActive');	
		$data=array(
		'Standard'=>$Standard, 
		'IsActive'=>$IsActive,
		'CreatedBy'=>1
		);
		$res=$this->db->insert('tblstandard',$data);	
		return $res;

	}
	function select_standard()
    {
        $this->db->select('*');
		$this->db->from('tblstandard');
		$r = $this->db->get();
		$res = $r->result();
		return $res;
	}
	function delete_data($table,$where)
	{
		$result=$this->db->delete('tblstandard',$where);
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
		$this->db->where('StandardId',$data['StandardId']);
		$res=$this->db->update($table);
		return $res;
	}
	function getstandard(){
		$this->db->select('*');
		$this->db->from('tblstandard');
		$r = $this->db->get();
		$res = $r->result();
		return $res;

	}
	function getdata($id){
		$this->db->select("*");
		$this->db->from("tblstandard");
		$this->db->where("StandardId",$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function updatedata(){
		$id=$this->input->post('StandardId');
		$data=array('Standard'=>$this->input->post('Standard'),
			'IsActive'=>$this->input->post('IsActive'),
			  );
	    $this->db->where("StandardId",$id);
		$this->db->update('tblstandard',$data);		
		//echo $this->db->last_query();die;
		return 1;
	}
	
}
