<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//echo APPPATH.'libraries/REST_Controller.php'; die;
require_once(APPPATH.'libraries/REST_Controller.php');
class Api extends REST_Controller 
{
    //Construct All File
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		
	}
	/*
	 * Function: test
	 * Author: Binny
	 * Date: 15/11/2017
	 * Desc: Check Rest API.
	*/
	function test_post(){
	  	//echo "hello";	
		$temp = $this->input->post('temp');
		$data['outputs'] = "Yep";
		$data['inputs']  = $temp;
		$this->response($data ,200);
	}

  

	/*
	 * Function: login
	 * Author: Binny
	 * Date: 23/11/2017
	 * Desc: Check normal register from Rest API.
	*/
function login_post()
{    	
	
	$result = $this->api_model->check_api_login();
	$this->response($result ,200);
}

function get_user_status_post()
{    	
    // print_r($_POST);
	$result = $this->api_model->user_status();	

	 $this->response($result ,200);
}

	/*
	 * Function: register
	 * Author: Upeksha
	 * Date: 19/6/2017
	 * Desc: Check normal register from Rest API.
	*/	
	function register_post()
	{
		//$headers = apache_request_headers();  	
		//print_r($_POST); die;
		$data 	= array();
		$check1 = $this->api_model->EmailUnique();
		$check2 = $this->api_model->MobileUnique();

		if($check1==FALSE) {
			$data['status']='fail';	 
			$data['error'] ='This Email Address is already registered with Nyalkaran Group.';
			$this->response($data ,200);
		}
		else if($check2==FALSE ){	
		
			$data['status']='fail';	 
		    $data['error'] ='This Mobile Number is already registered with Nyalkaran Group.';
			$this->response($data ,200);
		}	
		
		$register = $this->api_model->register();
		if($register){	
			$data['status']  = 'success';
			$data['result']  = $register;
			$data['message'] = 'Your account is created successfully. Please check for confirmation email in your INBOX or SPAMBOX to activate your Nyalkaran Group account.';
		}
		
		$this->response($data, 200);
	}


    /*
	 * Function: forgot_password
	 * Author: Binny
	 * Date: 17/11/2017
	 * Desc: Forgot password
	*/
    function forgot_password_post()
    {
    	$mobileno = $this->input->post('mobileno');
    	//echo $email;die;
    	$data  = $this->api_model->forgot_password($mobileno);
    	$this->response($data ,200);
    }

	/*
	 * Function: reset_password()
	 * Author: Binny
	 * Date: 17/11/2017
	 * Desc:Reset password after check unique code
	*/
	function reset_password_post()
	{
		$mobileno = $this->input->post('mobile_no');
		$password = $this->input->post('password');
		$data 	  = $this->api_model->reset_password($mobileno,$password);
		$this->response($data ,200);
	}

	/*
	 * Function: get_http_response_code
	 * Author: Binny
	 * Date: 16/11/2017
	 * Input: url
	 * Desc: string
	*/
	function get_http_response_code($url) 
	{
		$headers = get_headers($url);
		return substr($headers[0], 9, 3);
	}


	/*
	 * Function: get_profile
	 * Author: Binny
	 * Date: 16/11/2017
	 * Input: user_id
	 * Desc: returns user's data
	*/
	function get_profile_post(){
		
		$user = $this->api_model->get_profile($this->input->post('user_id'));
		if(!empty($user)){
		
			$data['status'] = 'success';
			$data['result'] = $user;
		} else {
			$data['status'] = 'fail';
			$data['error']  = 'No record found';
		}
		$this->response($data, 200);
	}

	function get_single_project_post(){
		//echo "vvv";die;
		
		$result = $this->api_model->get_single_project($this->input->post('project_id'));
		if(!empty($result)){
		
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
		}
		$this->response($data, 200);
	}


	
	/*
	 * Function: project_list
	 * Author: Binny
	 * Date: 20/11/2017
	 * Desc: list of services
	*/
	function project_list_get(){
		
	
		$result =$this->api_model->get_all_project();
		
		
		if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		}else{
			
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			
		}
		$this->response($data, 200);
	}

	/*
	 * Function: user_edit_profile_post
	 * Author: Binny
	 * Date: 19/11/2017
	 * Desc: edit user profile
	*/
	function user_edit_profile_post()
	{
			 // print_r($_FILES);die;	
		$num 		  = $this->api_model->check_user_id($this->input->post('user_id'));
		$user_id 	  = trim($this->input->post('user_id'));
		
		//echo $address;die;
		$new_fullname = trim($this->input->post('full_name')); 			
		if($num > 0) {
			$data = $this->api_model->user_edit_profile_api();
			$result['status']  = "success";
			$result['result']  = $data;
			$this->response($result ,200);
		}
  	}

	/*
	 * Function: set_user_status_post
	 * Author: Binny
	 * Date: 17/11/2017
	 * Desc: Creates or updates user Stauts
	*/
	
	function set_user_status_post() 
	{		
		$result =$this->api_model->set_user_status();	
		$this->response($result ,200);	
	}

	function set_userrefer_status_post() 
	{		//echo "fdgf";die;
		$result =$this->api_model->set_userrefer_status();	
		$this->response($result ,200);	
	}
	
	
	function change_password_post(){
			
			$result=$this->api_model->updateUserPassword();
		  	if($result==true){
					$data['status']  = 'success';
			        $data['message'] = 'Your password change successfully.';
			}else{
					$data['status']  = 'fail';					
					$data['error'] = 'Please enter valid old password.';
			
			}
			$this->response($data, 200);
	}

	function user_refer_post(){
		//echo "fdfd";die;
			$check1 = $this->api_model->ReferEmailUnique();
			$check2 = $this->api_model->ReferMobileUnique();

			if($check1==FALSE) {
			$data['status']='fail';	 
			$data['error'] ='This Email Address is already registered with Nyalkaran Group.';
			$this->response($data ,200);
			}
			else if($check2==FALSE ) {	
		
			$data['status']='fail';	 
		    $data['error'] ='This Mobile Number is already registered with Nyalkaran Group.';
			$this->response($data ,200);
		}
			$result=$this->api_model->userrefer_api();
		  	if($result==true){
					$data['status']  = 'success';
					$data['result']=$result;
			        $data['message'] = 'User refer has been send successfully.';
			}else{
					$data['status']  = 'fail';					
					$data['error'] = 'Record Not Inserted.';
			
			}
			$this->response($data, 200);
	}
	/*
	 * Function: register_device
	 * Author: binny
	 * Date: 20/11/2017
	 * Input: user_id, device_id, token_id, device_type
	 * Desc: returns void
	*/
	function register_device_post(){
		//echo "hghg";die;
	 //   //	$headers = apache_request_headers();  	
		$data = array();
		$data['user_id'] 	 = $this->input->post('user_id');
		$data['device_id']   = $this->input->post('device_id');
		$data['token_id']    = $this->input->post('token_id');
		$data['device_type'] = strtoupper($this->input->post('device_type')); 
		$data['login_status']='1';
		if(!empty($data['device_id']) && !empty($data['token_id'])){
			$device_master = $this->db->select('*')->from('tbldevice_master')->where(array('user_id' =>  $data['user_id'], 'device_id' => $data['device_id']))->get()->row_array();	
			if(!empty($device_master)){
				$this->db->where(array('user_id' => $data['user_id'],
				 'device_id' => $data['device_id']));	
				$this->db->update('tbldevice_master',$data);
			}else{
				$data['created_on'] =  date('Y-m-d h:i:s');
				$this->db->insert('tbldevice_master',$data);
			}
			$data1['status'] = 'success';
			
		} else {
			$data1['status'] = 'fail';
			$data1['result'] = array();
			$data1['error']  = 'Invalid input parameters.';
			
		}
		$this->response($data1, 200);
	}


	/*
	 * Function: unregister_device
	 * Author: Binny
	 * Date: 20/11/2017
	 * Input: user_id, device_id, token_id, device_type
	 * Desc: returns void
	*/
	function unregister_device_post(){	  		

		$user_id   = $this->input->post('user_id');
		$device_id = $this->input->post('device_id');
		$data=array('device_id'=>$device_id,
			'login_status'=>'1',
			'user_id' => $user_id);
		//echo "<pre>";print_r($data);die;
	   $this->db->delete('tbldevice_master',$data);
	   
	     	$data['status'] = 'success';
		     $this->response($data, 200);
		
	}	
	function push_notification_android_post(){
		
		$user_id=$this->input->post('user_id');
		$type=$this->input->post('type');
		$title=$this->input->post('title');
		$message=$this->input->post('message');
		
       
		// $title = $title;
		sendPushNotificationAndroid($type,$title,$message,$user_id);
		
	}
	function broadcast_notification_list_get(){
		
		//$user_id=$this->input->post('user_id');
		
		$result = $this->api_model->get_broadcast_notification();
		if(!empty($result)){
		
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
		}
		$this->response($data, 200);
       
		
	}

	function referral_point_post(){
     
     	$user_id=$this->input->post('user_id');
     	$result = $this->api_model->get_referral_point($user_id);
		if(!empty($result)){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
		}
		$this->response($data, 200);

	}
	function single_user_referal_post(){     
		//echo "bbghngh";die;
     	$user_id=$this->input->post('user_id');
     	$result = $this->api_model->get_userreferral_point($user_id);
		if(!empty($result)){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
		}
		$this->response($data, 200);

	}
	function userall_points_post(){     
		//echo "hgfhgf";die;
     	$user_id=$this->input->post('user_id');
     	$result = $this->api_model->getuserhistorydata($user_id);
		if(!empty($result)){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
		}
		$this->response($data, 200);

	}

	function app_version_post(){
		//echo "hghg";die;
     	$result = $this->api_model->app_version_api();
		if(!empty($result)){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
		}
		$this->response($data, 200);

	}
	function version_list_get(){
		
	
		$result =$this->api_model->get_appversion();
				
		if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		}else{
			
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			
		}
		$this->response($data, 200);
	}

	function termscondition_page_get(){
		
		$result=get_page_by_slug('termcondition');
		
		if($result){
			$data['status'] = 'success';
			$data['result'] = array(
				               'page_id'=>$result->page_id,
				               'PageTitle'=>$result->PageTitle,
				               'PageDescription'=>$result->PageDescription
								);
		}else{
			
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			
		}
		$this->response($data, 200);
	}

	

}//Class


?>
