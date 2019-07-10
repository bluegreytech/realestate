<?php

class Usersession_model extends CI_Model
 {
	function insertdata()
	{
		$StandardId=$this->input->post('StandardId');
		$streamid=$this->input->post('streamid');
		$UserId=$this->input->post('UserId');		
		$location=$this->input->post('location');
		$timeing=$this->input->post('timeing');		
		$IsActive=$this->input->post('IsActive');	
	
		$data=array(
		'Usersession_name'=>$this->input->post('nousersession'),
		'standard_id'=>$StandardId, 
		'stream_id'=>$streamid, 
		'user_id'=>$UserId,
		'StartDate'=>date('Y-m-d',strtotime($timeing)),
		'location'=>$location, 
		'timeing'=>date('H:i A',strtotime($timeing)),
		'IsActive'=>$IsActive,
		'status'=>'Pending',
		'CreatedOn'=>date('Y-m-d'),
		);
		//echo "<pre>";print_r($data);die;
		$res=$this->db->insert('tblusersession',$data);	
		return $res;

	}
	
	
	function getusersession(){
		$this->db->select('*');
		$this->db->from('tblusersession ss');
		$this->db->join('tbluser as us','us.UserId=ss.user_id');
		$query = $this->db->get();
		$res = $query->result();
		return $res;

	}
	function get_single_usersession($UserSessionId){
		$this->db->select('*');
		$this->db->from('tblusersession');
	  	$this->db->where('UserSessionId',$UserSessionId);
		$query = $this->db->get();
		$res = $query->row_array();
		return $res;
	}

	function updatedata(){
		$UserSessionId=$this->input->post('UserSessionId');
		$StandardId=$this->input->post('StandardId');
		$streamid=$this->input->post('streamid');
		$UserId=$this->input->post('UserId');		
		$location=$this->input->post('location');
	    $timeing= $this->input->post('timeing');	
		//echo $StartDate=  date('Y-m-d',strtotime($this->input->post('timeing')));		
		$IsActive=$this->input->post('IsActive');	
	     
		$data=array(
		'Usersession_name'=>$this->input->post('nousersession'),
		'standard_id'=>$StandardId, 
		'stream_id'=>$streamid, 
		'user_id'=>$UserId,
		'StartDate'=>date('Y-m-d',strtotime($timeing)),
		'location'=>$location, 
		'timeing'=>date('H:i A',strtotime($timeing)),
		'IsActive'=>$IsActive,
		'status'=>$this->input->post('workingstatus'),
		'CreatedOn'=>date('Y-m-d'),
		);
		//echo "<pre>";print_r($data);die;
	    $this->db->where("UserSessionId",$UserSessionId);
		$this->db->update('tblusersession',$data);		
		//echo $this->db->last_query();die;
		return 1;
	}
	
}
