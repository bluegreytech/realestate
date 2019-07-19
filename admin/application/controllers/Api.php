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
	 * Function: test
	 * Author: Binny
	 * Date: 15/11/2017
	 * Desc: Check Rest API.
	*/
    function test2_post(){
    	$temp = $this->input->post('user_id');
    	$ex   = $this->api_model->user_experience_rating();
    	$data['inputs'] = $temp;
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
	//echo "<pre>";print_r(phpinfo());die;
    // print_r($_POST);
	$result = $this->api_model->check_api_login();

    //echo "<pre>";print_r($result);die;
	$this->response($result ,200);
}

function get_user_status_post()
{    	
    // print_r($_POST);
	$result = $this->api_model->user_status();		

	 $this->response($result ,200);
}
function get_upcoming_booking_by_user_post()
{   
	$headers = apache_request_headers();
	$result = $this->api_model->get_upcoming_booking_by_user_post();
		
     	if($result){
		$data['status'] = 'success';
		$data['result'] = $result;
		}else{
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}			
		}
	$this->response($data, 200);
	 
}
function get_past_booking_by_user_post()
{    	
	
	$headers = apache_request_headers();
	$result = $this->api_model->get_past_booking_by_user_post();
		
     	if($result){
		$data['status'] = 'success';
		$data['result'] = $result;
		} else {
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
		}
	$this->response($data, 200);
	 
}
function get_broadcast_notification_by_user_post()
{    	
	 // print_r($_POST);
	$headers = apache_request_headers();
	$result = $this->api_model->get_broadcast_notification_by_user_post();
		
 	if($result){
	$data['status'] = 'success';
	$data['result'] = $result;
	} else {
		if($headers['Accept-Language']=='en' || $headers['Accept-Language']==''){
			$data['status'] = 'fail';
			$data['error']  = 'No record found';
		}elseif ($headers['Accept-Language']=='ar') {
			$data['status'] = 'fail';
			$data['error']  = 'لا توجد سجلات'; 
		}elseif ($headers['Accept-Language']=='so'){
			$data['status'] = 'fail';
			$data['error']  = 'lama hayo rikoodhkaga';
		}
	}
	$this->response($data, 200);
	 
}

function get_upcoming_booking_notification_by_user_post()
	{    	
	 	// print_r($_POST);
	 	//$data=array();
		$headers = apache_request_headers();
		$result = $this->api_model->get_upcoming_booking_notification_by_user_post();
 		//echo "<pre>";print_r($result);die;
        if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}	
		}
		$this->response($data, 200);
		 
	}

function get_past_booking_notification_by_user_post()
	{    	
	 
		$headers = apache_request_headers();
		$result = $this->api_model->get_past_booking_notification_by_user_post();
 		
        if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
		}
		$this->response($data, 200);
		 
	}



function resend_request_post()
{    
	$headers = apache_request_headers();  	
	$result = $this->api_model->resend_request();
	//echo "<pre>";print_r($result);die;
	if($result==1){
		if($headers['Accept-Language']=='en'){
		$data['status']  = 'success';
		//$data['result']  = $register;
		$data['message'] = 'Request has been sent successfully.';

		}elseif ($headers['Accept-Language']=='ar') {
			$data['status']  = 'success';
		//$data['result']  = $register;
		$data['message'] = 'تم إرسال الطلب بنجاح';
		}elseif ($headers['Accept-Language']=='so'){
			$data['status']  = 'success';
			//$data['result']  = $register;
			$data['message'] = 'Codsugaagi wa la diray';
		}			
		
	}else{
		if($headers['Accept-Language']=='en'){
			$data['status']  = 'fail';					
			$data['error'] = 'Something went wrong, please try again';

		}elseif ($headers['Accept-Language']=='ar') {
			$data['status']  = 'fail';					
			$data['error'] = 'حدث خطأ ما. الرجاء إعادة المحاولة ';
		}elseif ($headers['Accept-Language']=='so'){
			$data['status']  = 'fail';					
			$data['error'] = 'Waxba qaldamay, fadlan mar kale isku day';
		}
	}
	 $this->response($data ,200);
}
	/*
	 * Function: register
	 * Author: Upeksha
	 * Date: 19/6/2017
	 * Desc: Check normal register from Rest API.
	*/	
	function register_post()
	{
		$headers = apache_request_headers();  	
		//print_r($_POST); die;
		$data 	= array();
		$check1 = $this->api_model->EmailUnique();
		$check2 = $this->api_model->MobileUnique();

		if($check1==FALSE) {
			$data['status']='fail';	 
			//$data['error'] ='This Email Number is already registered with Real estate.';
			$this->response($data ,200);
		}
		else if($check2==FALSE ) {	
		
			$data['status']='fail';	 
			//$data['error'] ='This Mobile Number is already registered with Real estate.';
			$this->response($data ,200);
		}	
		
		$register = $this->api_model->register();
		if($register){	
			$data['status']  = 'success';
			$data['result']  = $register;
			//$data['message'] = 'Your account is created successfully. Please check for confirmation email in your INBOX or SPAMBOX to activate your Realestate  account.';
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
		$forget_password_code = $this->input->post('forget_password_code');
		$password = $this->input->post('password');
		$data 	  = $this->api_model->reset_password($forget_password_code,$password);
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
			//$user['ratings'] = $this->user_model->get_user_ratings($this->input->post('user_id'));
			$data['status'] = 'success';
			$data['result'] = $user;
		} else {
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
		}
		$this->response($data, 200);
	}


	/*
	 * Function: register_device
	 * Author: Binny
	 * Date: 20/11/2017
	 * Input: user_id, device_id, token_id, device_type
	 * Desc: returns void
	*/
	function register_device_post(){
	   //	$headers = apache_request_headers();  	
		$data = array();
		$data['user_id'] 	 = $this->input->post('user_id');
		$data['device_id']   = $this->input->post('device_id');
		$data['token_id']    = $this->input->post('token_id');
		$data['device_type'] = strtoupper($this->input->post('device_type')); 
		$data['login_status']='1';
		if(!empty($data['device_id']) && !empty($data['token_id'])){
			$device_master = $this->db->select('*')->from('device_master')->where(array('user_id' => $data['user_id'], 'device_id' => $data['device_id']))->get()->row_array();	
			if(!empty($device_master)){
				$this->db->where(array('user_id' => $data['user_id'],
				 'device_id' => $data['device_id']));	
				$this->db->update('device_master',$data);
			}else{
				$data['created_on'] =  date('Y-m-d h:i:s');
				$this->db->insert('device_master',$data);
			}
			$data1['status'] = 'success';
			
		} else {

			//if($headers['Accept-Language']=='en'){
			$data1['status'] = 'fail';
			$data1['result'] = array();
			$data1['error']  = 'Invalid input parameters.';

			// }elseif ($headers['Accept-Language']=='ar') {
			// $data1['status'] = 'fail';
			// $data1['result'] = array();
			// $data1['error']  = 'Invalid input parameters.';
			// }elseif ($headers['Accept-Language']=='so'){
			// $data1['status'] = 'fail';
			// $data1['result'] = array();
			// $data1['error']  = 'Invalid input parameters.';
			// }
			
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
	   // $data['login_status']='0';
		$data=array('device_id'=>$device_id,
			'login_status'=>'1',
			'user_id' => $user_id);
		//echo "<pre>";print_r($data);die;
	   $this->db->delete('device_master',$data);
	    //echo $this->db->last_query(); die;
	    //echo "<pre>";print_r($result);
	   
	     	$data['status'] = 'success';
		     $this->response($data, 200);	
	   
		
	}	

	function notification_read_post(){	  		

		$notification_read   = $this->input->post('notification_read');
		$booking_id   = $this->input->post('booking_id');
		
	   // $data['login_status']='0';
            $data= array('notification_read' =>'0');
		   $this->db->where('booking_id',$booking_id);
				$query=$this->db->update('booking',$data);
		//$this->db->update('booking',array('booking_id' => $booking_id));
		$data['status'] = 'success';
		$this->response($data, 200);	
	}	
	


	/*
	 * Function: language_list
	 * Author: Binny
	 * Date: 20/11/2017
	 * Desc: list of language
	*/
	function language_list_get(){
		$headers = apache_request_headers();  	
		$result = get_all_languages();
		//echo "<pre>";print_r($result);die;
		if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
			
		}
		$this->response($data, 200);
	}

	function cities_list_get(){
		$headers = apache_request_headers();  
		$result = get_all_cities();
		//echo "<pre>";print_r($result);die;
		if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		} else {
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
		}
		$this->response($data, 200);
	}
	function problem_type_list_get(){
		$headers = apache_request_headers();  
		$result = get_all_problemtype();
			//echo "<pre>";print_r($result);die;
		$resdata=array();
	    foreach ($result as $row) {
	    	if($headers['Accept-Language']=='en'){
				array_push($resdata,array('ptype_id'=>$row['ptype_id'],
					'ptype_name'=>$row['ptype_name'],
				));
			}elseif ($headers['Accept-Language']=='ar') {
				array_push($resdata,array('ptype_id'=>$row['ptype_id'],
				'ptype_name'=>$row['ptype_name_ar'],
				));

			}elseif ($headers['Accept-Language']=='so') {
				array_push($resdata,array('ptype_id'=>$row['ptype_id'],
				'ptype_name'=>$row['ptype_name_so'],
				));

			}
	    
	    }
		//die;

		if(!empty($result)){
			$data['status'] = 'success';
			$data['result'] = $resdata;
		} else {
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
		}
		$this->response($data, 200);
	}

	

	
	/*
	 * Function: services_list
	 * Author: Binny
	 * Date: 20/11/2017
	 * Desc: list of services
	*/
	function services_list_get(){
		
		//echo header_list();
		
      	//$headers = apache_request_headers();  
		$result =$this->api_model->get_all_servies();
		 //echo "<pre>";print_r($result);die;
  		 //       die;
		//$result = get_all_active_services();
		
		if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		}else{
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
		}
		$this->response($data, 200);
	}
	/*
	 * Function: champion_list
	 * Author: Binny
	 * Date: 20/11/2017
	 * Desc: list of Champion
	*/
	function champion_list_post(){
		$headers = apache_request_headers();  
		$result = $this->api_model->champion_list();
		//echo "<pre>";print_r($result);die;
		if($result){
			$data['status'] = 'success';
			$data['result'] = $result;
		}else{
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
		}
		$this->response($data, 200);
	}
 
   	/*
	 * Function: contact_list
	 * Author: Binny
	 * Date: 20/11/2017
	 * Desc: list of contact
	 */
	 function contact_list_get(){
	 	$headers = apache_request_headers();  
		$result = contact_us();
		//echo "<pre>";print_r($result->phone_no);die;
		if($result){
			$data['status'] = 'success';
			$data['result'] = array(
				               'phone_no'=>$result->phone_no,
				               'address'=>$result->address,
				               'contact_email'=>$result->contact_email
								);
		} else {
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'No record found';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'لا توجد سجلات'; 
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'lama hayo rikoodhkaga';
			}
		}
		$this->response($data, 200);
	}
	


	function about_page_en_get(){
			//echo "hello";die;
			$data='';
			$theme = getThemeName();
			$slug   = $this->input->post('slug');
			$data['result']=get_page_by_slug('about_project_stand_up_en');	       
			echo $this->load->view($theme .'/layout/pages/aboutus',$data,TRUE);
			die;
	}
	function about_page_ar_get(){
			//echo "hello";die;
			$data='';
			$theme = getThemeName();
			$slug   = $this->input->post('slug');
			$data['result']=get_page_by_slug('about_project_stand_up_ar');	       
			echo $this->load->view($theme .'/layout/pages/aboutus',$data,TRUE);
			die;
	}

	function about_page_so_get(){
			//echo "hello";die;
			$data='';
			$theme = getThemeName();
			$slug   = $this->input->post('slug');
			$data['result']=get_page_by_slug('about_project_stand_up_so');	       
			echo $this->load->view($theme .'/layout/pages/aboutus',$data,TRUE);
			die;
	}
  
  /*
	 * Function: push notification
	 * Author: Binny
	 * Date: 29/10/2018
	 * Desc: push notification android
	*/

	function push_notification_android_post(){
		
		$user_id=$this->input->post('user_id');
		$type=$this->input->post('type');
		$title=$this->input->post('title');
		$message=$this->input->post('message');
		
       
		// $title = $title;
		sendPushNotificationAndroid($type,$title,$message,$user_id);
		
	}

      /*
	 * Function: fb_register
	 * Author: Binny
	 * Date: 29/10/2018
	 * Desc: push notification ios
	*/
	function push_notification_ios_get(){
		$title = 'New project work job added';
		$message = 'Test Push IOS';
		//$id = 'job_id#' . $id;
		$type = 'new_job';
		$device_id = 'EFB7D7A5-5321-4B7A-8B9B-B69489A2B5F9';
		sendPushNotificationIOS('1',$device_id, $type, $title, $message,'');
	}


	/*
	 * Function: fb_register
	 * Author: Binny
	 * Date: 20/11/2017
	 * Desc: facebook register
	*/
	function fb_register_post()
	{
		$full_name  	= trim($this->input->post('full_name'));
		$fb_id 			= trim($this->input->post('fb_id'));
		$gender 		= trim($this->input->post('gender'));
		$dob 			= trim($this->input->post('dob'));
		$email 			= trim($this->input->post('email'));
		$fb_img 		= "";
		$country 		= trim($this->input->post('country'));
		$state 			= trim($this->input->post('state'));
		$city 			= trim($this->input->post('city'));
  	 	// $fb_img 		= $this->input->post('fb_img');
  		// $latitude	= $this->input->post('latitude');
  		// $longitude 	= $this->input->post('longitude');
		// $device_id 	= $this->input->post('device_id');
		// $unique_code = uniqid().$device_id;
		if($fb_id =="" || $fb_id ==NULL )
		{
			$data = array(
				'status'=>'fail',
				'error'=> "Facebook id required."
				);		
			$this->response($data ,200);
		}

  		//$usr = $this->api_model->get_user_by_fb_uid($fb_id,$email);
		$usr = $this->api_model->get_user_by_fb_uid($fb_id);

		if(!empty($usr)) 
		{
			$data = array();
			$sql  = " SELECT * FROM ".$this->db->dbprefix('user')." WHERE email ='".$email."' and user_id !='".$usr->user_id."'";
			$usr_qry = $this->db->query($sql);
			/*if($usr_qry->num_rows() > 0) 
			{ 
				$data['result'] = array(); 
				$data['status']='fail';	 
				$data['error'] ='This email address is already registered with Splorego.'; 
				$this->response($data ,200);
			}*/
			if($usr_qry->num_rows() > 0) 
			{ 
				$data['result'] = $usr_qry->result_array(); 
				$data['status'] = 'success';	 
				//$data['error'] ='This email address is already registered with Splorego.'; 
				$this->response($data ,200);
			}

			$base_path 		= base_path();
			$image_settings = image_setting();
			if($this->get_http_response_code('https://graph.facebook.com/'.$fb_id.'/picture?width=1500&height=1500') != "200")
			{

				$img = file_get_contents(base_path()."upload/no_image/user@3x.png");
			}else{
				$img = file_get_contents('https://graph.facebook.com/'.$fb_id.'/picture?width=1500&height=1500');
			}
			// $img = file_get_contents('https://graph.facebook.com/'.$fb_id.'/picture?width=1500&height=1500');
			$file = base_path()."upload/user_orig/".$fb_id.".jpg";

			file_put_contents($file, $img);
			$fb_img= $fb_id.'.jpg';
			$config['upload_path']   	= $base_path.'upload/user_orig/';
			$config['allowed_types'] 	= 'jpg|jpeg|gif|png|bmp';
			//$config['max_size']	 	= '100';// in KB
			$this->load->library('upload', $config);
			$config['source_image'] 	= $this->upload->upload_path.$fb_img;
			$config['new_image'] 		= base_path()."upload/user/";
			$config['thumb_marker'] 	= "";
			$config['create_thumb'] 	= TRUE;
			$config['width'] 			= 120;
			$config['height'] 			= 120;
			//$config['maintain_ratio'] = $image_settings['u_ratio'];
			$this->load->library('image_lib', $config);
			$gd_var='gd2';
			if(!$this->image_lib->resize()){
				echo $error = $this->image_lib->display_errors();
				die;				
			}	

			resize(base_path().'upload/user_orig/'.$fb_img,base_path().'upload/user_150_150/'.$fb_img,150,150);
			resize(base_path().'upload/user_orig/'.$fb_img,base_path().'upload/user_400_500/'.$fb_img,400,500);


			$data['fb_id'] 		 = $fb_id;
			$data['name']  		 = $full_name;
			// $data['gender']   = $gender;
			// $data['dob'] 	 = $dob;
			$data['email'] 		 = $email;
			$data['profile_img'] = $fb_img;
			// $data['latitude'] = $latitude;
			// $data['longitude']= $longitude;
			// $data['city'] 	 = $city;
			// $data['state']    = $state;
			// $data['country']  = $country;
			//$data['type']      = 'facebook';
			
			if($full_name !='' && $full_name != NULL){
				$data["name"] = $full_name;	
			}

		


			$this->db->where('fb_id', $fb_id);
			$a = $this->db->update('user',$data);

			$query = $this->db->get_where('user',array('fb_id'=>$fb_id));
  			// echo $query->num_rows();
  			// 		die;
			if($query->num_rows() == 1)
			{	
				$user = $query->row_array();  				
  				//$user_type		= $user['user_type'];
				$user_id 			= $user['user_id'];
				$fb_id 	 			= $user['fb_id'];
				$status  			= $user['status'];
				$full_name 			= $user['name'];
				$email 				= $user['email'];
				$gender 			= $user['gender'];
				$dob 				= $user['dob'];
				$image 				= $user['profile_img'];
				$experience_rating	= trim($user['experience_rating']);			

				if($status=='0')
				{

					$data1['result'] = array(
						'user_id' 	 		 => $user_id,
						'email' 	 		 => $email,
						'profile_image' 	 => $image,
						'gender'			 => $gender,
						'fb_id'				 => $fb_id,
						'name'				 => $full_name,
						'dob'				 => $dob,
						'experience_rating'	 => $experience_rating,		
						'city' 	 			 => $user['city'],
						'state'   			 => $user['state'],
						'country' 			 => $user['country'],
  						//'user_type'		 => $user_type,
  						// 'expires_date_ms' => $user['expires_date_ms'],	
						'push_send'		 => $user['push_send'],	
  						// 'plan_type' 		 => $user['plan_type'],
						// 'amount' 		 => $user['amount'],
						// 'user_type' 		 => $user['user_type'],	
						// 'code' 			 => $user['code'],
						// 'latitude'		 => $user['latitude'],
						// 'longitude' 		 => $user['longitude'],
						//'age' => $age,							
						//'status'=>'success'
						);
					$data1['status'] ='success';			
					/* $data_device  = array(
					'user_id' 		 => $user_id,
					'device_name'	 =>$device_id,
					// 'unique_code' => $unique_code,
					'created_on'     => date('Y-m-d H:i:s')
					);
					$this->db->insert('device_master',$data_device);*/				
					$this->response($data1,200);
				}
				else {

					$data['result'] = array();
					$data['status'] ='fail';
					$data['error']  ='Your account is inactive. Please contact administrator!';		
					$this->response($data,200);

				}
				/*else{
					$data['result'] = array();	
					$data['status'] = 'fail';
					$data['error']  = 'user not found';
					$this->response($data,200);
				}	*/
			}
			else
			{			
				$data['result'] = array();	
				$data['status'] ='fail';
				$data['error']  ='user not found';
				$this->response($data,200);
			}
		}  
		else {
			$check1 = $this->api_model->EmailUnique();
			if($check1==FALSE  ) 
			{
				$check1 = $this->api_model->EmailUnique_api();
				$data['result'] = $check1; 
				$data['status'] ='success';	 
				//$data['error'] ='This email address is already registered with Splorego.'; 

				/*$data['result'] = array(); 
				$data['status']='fail';	 
				$data['error'] ='This email address is already registered with Splorego.'; */
				$this->response($data ,200);
			}	
			
			$data      = array();
			$user_name = $this->input->post('user_name'); 
			//$lname = $this->input->post('last_name');
			//$fullname = $fb_usr["name"];
			$pwd    = ''; 
			$fb_img = '';
			$base_path 		= base_path();
			$image_settings = image_setting();
			//$img = file_get_contents('https://graph.facebook.com/'.$fb_id.'/picture?type=large');
			if($this->get_http_response_code('https://graph.facebook.com/'.$fb_id.'/picture?type=large') != "200")
			{
				$img = file_get_contents(base_path()."upload/no_image/user@3x.png");
			}else{
				$img = file_get_contents('https://graph.facebook.com/'.$fb_id.'/picture?type=large');
			}
			$file = base_path()."upload/user_orig/".$fb_id.".jpg";

			file_put_contents($file, $img);
			$fb_img= $fb_id.'.jpg';
			$config['upload_path']   = $base_path.'upload/user_orig/';
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
			//$config['max_size']	= '100';// in KB
			$this->load->library('upload', $config);
			$config['source_image']  = $this->upload->upload_path.$fb_img;
			$config['new_image'] 	 = base_path()."upload/user/";
			$config['thumb_marker']  = "";
			$config['create_thumb']  = TRUE;
			$config['width'] 		 = 120;
			$config['height'] 		 = 120;
			$this->load->library('image_lib', $config);
			$gd_var='gd2';
			if(!$this->image_lib->resize()){
				echo $error = $this->image_lib->display_errors();
				die;				
			}	

			resize(base_path().'upload/user_orig/'.$fb_img,base_path().'upload/user_150_150/'.$fb_img,150,150);
			resize(base_path().'upload/user_orig/'.$fb_img,base_path().'upload/user_400_500/'.$fb_img,400,500);

			$fb_values  = array (                    
				'fb_id' => $fb_id,
				'fb_img'=>$fb_img,
				'email' =>$email,
				'type'  =>'facebook'
				// 'full_name'  => $full_name,
				// 'gender' 	=> $gender,
				// 'dob' 		=> $dob,
				// 'latitude'	=> $latitude,
				// 'longitude'	=> $longitude,
				// 'country'	=> $country,
				// 'state'		=> $state,
				// 'city'		=> $city,
				);
			if($full_name !='' && $full_name != NULL){
				$fb_values["full_name"] = $full_name;	
			}else{
				$fb_values["full_name"] = "";	
			}

			if($gender !='' && $gender != NULL){
				$fb_values["gender"] = $gender;	
			}
			else{
				$fb_values["gender"] = "";	
			}
			if($dob !='' && $dob != NULL){
				$fb_values["dob"] = $dob;	
			}
			else{
				$fb_values["dob"] = "";	
			}
			//$fb_values["password"] = md5($pass);
			if($country !='' && $country != NULL){
				$fb_values["country"] = $country;	
			}
			else{
				$fb_values["country"] = "";
			}

			if($state !='' && $state != NULL){
				$fb_values["state"] = $state;	
			}
			else{
				$fb_values["state"] = "";
			}
			if($city!='' && $city != NULL){
				$fb_values["city"] = $city;	
			}
			else{
				$fb_values["city"] = "";
			}

			
			$user_id = $this->api_model->save_social_data($fb_values);
			$data['result'] = array(
				'user_id' 			=> $user_id,
				'name' 				=> $full_name,
				'email' 			=> $email,
				'profile_image' 	=> $fb_img,
				'dob'				=> $dob,
				'gender'			=> $gender,
				'fb_id'				=> $fb_id,
				'experience_rating'	=>"0",
				'country'			=> $country,
				'city'				=> $city,						 
				'state'				=> $state,						 
				// 'latitude' 		=> $latitude,
				// 'longitude'		=> $longitude,
				);
			$data['status'] ='success';	

			$this->response($data,200);
		} 
	}
	
	// function get_highlights_post()
	// {
	// 	$limit        = $this->input->post('limit');
	// 	$offset 	  = $this->input->post('offset');
	// 	$result 	  = $this->api_model->get_highlites($limit , $offset);	
	// 	$result_count = $this->api_model->get_highlites($limit="" , $offset="");
	// 	if(!empty($result)) {		
	// 		$data = array(
	// 			'status'	  =>'success',
	// 			'total_record'=>count($result_count),
	// 			'result'	  => $result
	// 			);

	// 		$this->response($data ,200);	
	// 	} else {
	// 		$data = array(
	// 			'status' =>'fail',
	// 			'error'=> "No experience found."
	// 			);
	// 		$this->response($data ,200);
	// 	}
	// }

	/*
	 * Function: user_edit_basic_post
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
			// if($new_email !=NULL && $new_email !="")
			// {
			// 	$sql = " SELECT * FROM ".$this->db->dbprefix('user')." WHERE user_id !='".$user_id."' and email ='".$new_email."'";
			// 	$usr_qry = $this->db->query($sql);
			// 	if($usr_qry->num_rows() > 0) 
			// 	{ 
			// 		$data['result'] = array(); 
			// 		$data['status'] = 'fail';	 
			// 		$data['error']  = 'This email address is already registered with PSU.'; 
			// 		$this->response($data ,200);
			// 	}

			// }	
			$data = $this->api_model->user_edit_profile_api();
			$result['status']  = "success";
			$result['result']  = $data;
			$this->response($result ,200);	

		}
  	}

	/*
	 * Function: add_experience
	 * Author: Binny
	 * Date: 17/11/2017
	 * Desc: Creates or updates experience
	*/
	function add_booking_post() 
	{		
		$result =$this->api_model->insert_booking();	
		$this->response($result ,200);	
	}
	function booking_cancel_post() 
	{		
		$result =$this->api_model->cancel_booking();	
		$this->response($result ,200);	
	}
	function start_booking_post() 
	{		
		$result =$this->api_model->inprogress_booking();	
		$this->response($result ,200);	
	}
   function complete_booking_post() 
	{		
		$result =$this->api_model->complete_booking();	
		$this->response($result ,200);	
	}
	function emergency_number_get() 
	{		
		$result =$this->api_model->emergency_number();	
		$this->response($result ,200);	
	}
	function add_report_problem_post() 
	{		
		$result =$this->api_model->insert_report_problem();	
		$this->response($result ,200);	
	}
	function langauge_setting_post() 
	{		
		$result =$this->api_model->user_langauge_setting();	
		$this->response($result ,200);	
	}
	


	/*
	 * Function: user_join_experiance
	 * Author: Binny
	 * Date: 17/11/2017
	 * Desc: User joins an experience
	*/
	function user_join_experiance_post()
	{
		$result =$this->api_model->user_join_experiance();	
		$this->response($result ,200);	
	}



    /*
	 * Function: add_review
	 * Author: Binny
	 * Date: 22/11/2018
	 * Input: user_id,given_user_id,experience_id,review_rating
	 * Desc: returns added data	 
	*/
    function add_review_post()
    {
    	  $headers = apache_request_headers();
    	$user_details = $this->api_model->check_user_id($this->input->post('user_id'));
    	
    	$booking_detail  = get_one_record('booking','booking_id',$this->input->post("booking_id"));
    	if(($user_details > 0 )  && !empty($booking_detail)  )
    	{
    		$data = $this->api_model->add_review();			

    	} else {    		
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'Invalid input.';
			}elseif ($headers['Accept-Language']=='ar') {
				$data['status'] = 'fail';
				$data['error']  = 'Invalid input.';
			}elseif ($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'Invalid input.';
			}
    	}
    	$this->response($data, 200);
    }



	function push_send_status_post() {
        $headers = apache_request_headers();
		$num = $this->api_model->check_user_id($this->input->post('user_id'));	
           $data= array();
		if($num > 0) {			
			$data = $this->api_model->send_push_status();
			$this->response($data ,200);
		} else {
				// $data = array(
				// 	'status'=>'fail',
				// 	'message'=> "user id doesn't exists"
				// 	);
			 	if($headers['Accept-Language']=='en'){
					$data['status']  = 'fail';					
					$data['error'] = "user id doesn't exists";
				}elseif ($headers['Accept-Language']=='ar') {
					$data['status']  = 'fail';					
					$data['error'] = "user id doesn't exists ar language";
				}elseif ($headers['Accept-Language']=='so'){
					$data['status']  = 'fail';					
					$data['error'] = "user id doesn't exists so language";
				}
			$this->response($data ,200);
		}
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

}//Class
?>
