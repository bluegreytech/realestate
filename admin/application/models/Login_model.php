<?php

class Login_model extends CI_Model
 {
		function login_where($table,$where)
		{
			$r = $this->db->get_where($table,$where);
			$res = $r->row();
			return $res;
		}
		function updateProfile(){
			$data = array(
			//'Email' => $this->input->post('EmailAddress'),
			'FirstName' => $this->input->post('first_name'),
			'LastName' => $this->input->post('last_name'),
			'Phone' => $this->input->post('phone'),
			'Gender' => $this->input->post('gender'),			
			);	
		//print_r($data); die;	
		$this->db->where('UserId',get_authenticateadminID());
		$this->db->update('tbluser',$data);
		}

}
