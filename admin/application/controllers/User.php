<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
      	parent::__construct();
		$this->load->model('user_model');
      
    }

	function Userlist()
	{	
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{		
			$data['result']=$this->user_model->getuser();
			//echo "<pre>";print_r($data);die;
			$data['redirect_page']="userlist";
			$this->load->view('User/UserList',$data);
		}
	}

	public function Useradd()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
				$data=array();
				$this->load->library("form_validation");
			$this->form_validation->set_rules('FullName', 'Full Name', 'required');			
			
			$this->form_validation->set_rules('UserContact', 'Mobileno', 'required');
			
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
				//echo "<pre>";print_r($data["error"]);die;
			}else{
				$data["error"] = "";
			}
           	$data['redirect_page']="userlist";
			$data['UserId']=$this->input->post('UserId');
			$data['FullName']=$this->input->post('FullName');
			$data['EmailAddress']=$this->input->post('EmailAddress');
			$data['Addresses']=$this->input->post('Addresses');
			$data['ProfileImage']=$this->input->post('ProfileImage');
			$data['UserContact']=$this->input->post('UserContact');
			$data['IsActive']=$this->input->post('IsActive');
			$data["pre_profile_image"] = $this->input->post('ProfileImage');
			
			}
			else
			{
				if($this->input->post("UserId")!="")
			{	
				//echo "dsfdf";die;
				$this->user_model->user_update();
				$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
				redirect('User/Userlist');
				
			}
			else
			{ //echo "dsfdf";die;
				$this->user_model->user_insert();
				$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
				redirect('User/Userlist');
			
			}
				
			}
			$this->load->view('User/UserAdd',$data);	
	}
	
	function Edituser($UsersId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$data=array();
			$result=$this->user_model->getdata($UsersId);	
			$data['UserId']=$result['UsersId'];
			$data['FullName']=$result['FullName'];	
			$data['EmailAddress']=$result['EmailAddress'];	
			$data['Address']=$result['Address'];
			$data['ProfileImage']=$result['ProfileImage'];	
			$data['UserContact']=$result['UserContact'];
			$data['IsActive']=$result['IsActive'];	
			$data['redirect_page']="userlist";		
			$this->load->view('User/UserAdd',$data);	
		}
	}

	function updatedata($UserId){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
		$result=$this->user_model->updatedata($UserId);	
    	if($result=='1'){
		  $this->session->set_flashdata('success', 'Record has been updated Succesfully!');
		 	redirect('User/Userlist');	
			}
			redirect('User/Userlist');
		}
	}

	function deletedata(){
		//echo "jhjh";die;
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}
			$data= array('Is_deleted' =>'1');
			$id=$this->input->post('id');
			$this->db->where("UsersId",$id);
			$res=$this->db->update('tbluser',$data);
			//echo $this->db->last_query();die;
			echo json_encode($res);
			die;
		
	}

	function usermail_check($EmailAddress)
	{

	$query = $this->db->query("select EmailAddress from ".$this->db->dbprefix('tbluser')." where EmailAddress = '$EmailAddress' and UsersId!='".$this->input->post('UsersId')."'");

	if($query->num_rows() == 0)
	{
	return TRUE;
	}
	else
	{
	$this->form_validation->set_message('usermail_check', 'Email address is already exist.');
	return FALSE;
	}
	}

   function Userrefer_list()
	{	
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{		
			$data['result']=$this->user_model->get_userefer();
			//echo "<pre>";print_r($data);die;
			$data['redirect_page']="userreferlist";
			$this->load->view('User/UserRefer_list',$data);
		}
	}

	function Edituser_refer($refer_id){
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}else{
			$data=array();
			$result=$this->user_model->getreferdata($refer_id);	
			//echo "<pre>";print_r($result);die;
			
			$data['refer_id']=$result['refer_id'];
			$data['UsersId']=$result['UsersId'];
			$data['FullName']=$result['FullName'];	
			$data['EmailAddress']=$result['EmailAddress'];	
			$data['Address']=$result['Address'];			
			$data['UserContact']=$result['UserContact'];
			$data['name']=$result['name'];	
			$data['mobileno']=$result['mobileno'];	
			$data['email']=$result['email'];			
			$data['property']=$result['property'];
			$data['status']=$result['status'];	
			$data['redirect_page']="Userrefer_list";		
			$this->load->view('User/UserReferAdd',$data);	
		}
	}

	function deletereferdata(){
		//echo "jhjh";die;
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}
			$data= array('Is_deleted' =>'1');
			$id=$this->input->post('id');
			$this->db->where("refer_id",$id);
			$res=$this->db->update('tblrefer',$data);
			//echo $this->db->last_query();die;
			echo json_encode($res);
			die;
		
	}
	public function UserReferAdd()
	{      
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
				$data=array();
				$this->load->library("form_validation");
			$this->form_validation->set_rules('status', 'Status', 'required');			
			
			
			
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
				//echo "<pre>";print_r($data["error"]);die;
			}else{
				$data["error"] = "";
			}
           	$data['redirect_page']="userlist";
			$data['refer_id']=$this->input->post('refer_id');
			
			
			}
			else
			{
				if($this->input->post("refer_id")!="")
			{	
				//echo "dsfdf";die;
				$this->user_model->userrefer_update();
				$this->session->set_flashdata('success', 'Record has been Updated Succesfully!');
				redirect('User/Userrefer_list');
				
			}
			else
			{ //echo "dsfdf";die;
				$this->user_model->user_insert();
				$this->session->set_flashdata('success', 'Record has been Inserted Succesfully!');
				redirect('User/Userrefer_list');
			
			}
				
			}
			$this->load->view('User/UserReferAdd',$data);	
			
				
	}

	function loyalty_point($user_id){
        
		if(!check_admin_authentication()){ 
			redirect(base_url());
		}   
		    $data=array();
			$userpoints=$this->user_model->getdata($user_id);
			$data['result']=$this->user_model->getuserhistorydata($user_id);
		//echo "<pre>";print_r($result);die;
			$data['referral_point']=$userpoints['referral_point'];
			$data['closing_point']=$userpoints['closing_point'];
			$data['redeem_point']=$userpoints['redeem_point'];
			$data['UsersId']=$userpoints['UsersId'];



			$this->load->view('User/UserPoints',$data);
			
	}

	function redeem_pointsdata(){
		//echo "jhjh";die;
			$id=$this->input->post('id');
     	if(!check_admin_authentication()){ 
			redirect(base_url());
		}
		$closingpoint=$this->input->post('closing_point');
		$referral_point=$this->input->post('referral_point');
		$redeem_point=$closingpoint + $referral_point; 
	
			$data= array('closing_point' =>"0",
				'referral_point' =>"0",
				'redeem_point' =>$redeem_point,

			);
		
			$this->db->where("UsersId",$id);
			$res=$this->db->update('tbluser',$data);

            $data1= array('redeem_point' =>$redeem_point,
            	'user_id'=>$this->input->post('id'),
            	"redeem_type"=>"redeem",
            	'comment'=>$this->input->post('comments')
            	);

			$res=$this->db->insert('tbluser_redeempoints',$data1);

			//	echo $this->db->last_query();die;
			echo json_encode($res);
			die;
		
	}

	function done_pointsdata(){
	// echo $cmd=$this->input->post('comments');
			$id=$this->input->post('id');
			$data1= array('redeem_point' =>$this->input->post('redeem_point'),
            	'user_id'=>$this->input->post('id'),
            	"redeem_type"=>"done",
            	'refer_id'=>'0',
            	'comment'=>$this->input->post('comments')
            	);
			//echo "<pre>";print_r($data1);die;

			$res=$this->db->insert('tbluser_redeempoints',$data1);
			$data= array(
				'redeem_point' =>"0",
				//'refer_id'=>'0',
			);
		
			$this->db->where("UsersId",$id);
			$res=$this->db->update('tbluser',$data);
			echo json_encode($res);
			die;
	}

   function wishuser_bday(){
   		$result=$this->user_model->getbdayuser();
   		$data =array();
   		$message='Nyalkaran Group we wish you a happy birthday'; 
   		if($result){
   			foreach ($result as $row) {
   				$data[]=$row->UserContact;
			}
	    	$mobileno= implode(', ', $data);
			$checkmsg = file_get_contents('http://msg.desireinfotech.in/rest/services/sendSMS/sendGroupSms?AUTH_KEY=204644373ece9946d7c65769e75c65ac&message='.urlencode($message).'&senderId=NKGRUP&routeId=1&mobileNos='.urlencode($mobileno).'&smsContentType=english"');
   		}
   }
    
}
