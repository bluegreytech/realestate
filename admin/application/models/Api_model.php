<?php
class Api_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	

	/*
	 * Function: EmailUnique
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: Boolean return 
	*/
	function EmailUnique()
	{
		$str = $this->input->post('email');
		if($this->input->post('user_id')!='')
		{
			$query = $this->db->query("select EmailAddress from ".$this->db->dbprefix('tbluser')." where EmailAddress = '$str' and user_id!='".$this->input->post('user_id')."'");
		}else{
			$query = $this->db->query("select EmailAddress from ".$this->db->dbprefix('tbluser')." where EmailAddress = '$str'");
		}

		if($query->num_rows()>0){
			return FALSE;
		} else {
			return TRUE;
		}
	}


	/*
	 * Function: EmailUnique_api
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: array return if found email
	*/
function EmailUnique_api()
{
	$str = $this->input->post('email');
	if($this->input->post('email')!='')
	{
		$query = $this->db->query("select * from ".$this->db->dbprefix('user')." where email = '$str'");
	} 
	if($query->num_rows()>0){

		$row_arr = $query->result_array();
		return $row_arr[0];
	} else {
		return TRUE;
	}
}
  

function user_status()
{
	 $mobileno = $this->input->post('mobileno'); 
	$query 			= $this->db->get_where("tbluser",array("UserContact"=>$mobileno));
	$res 			= $query->row();
	
	if($query->num_rows() > 0)
	{
		if($res->IsActive == 'Inactive')
		{
				$data['status'] = 'fail';
				$data['result']= array('inactive' =>'0');
				$data['error']  = 'Your account is inactive. Please contact administrator!';
				return $data;
		   
		}elseif($res->IsActive == 'Active'){			
				$data['status'] = 'success';
				$data['result']=array('active' =>'1');
				$data['message']  = 'Your account is active. Please login!';	
				return $data;

		}
	}else{
			$data['status'] = 'fail';			
			$data['error']  = 'Invalid Mobile number Please enter Valid number !';
			return $data;
	}
}


function champion_list(){
	$user_id=$this->input->post('user_id');

	if($this->input->post('user_id')!='')
		{
			$query = $this->db->query("select user_id from ".$this->db->dbprefix('user')." where  user_id='".$this->input->post('user_id')."'");
			//echo "<pre>";print_r($query);die;
			if(count($query->result())>0){
				$this->db->select('*');
				$this->db->from('champion as ch');	
				$this->db->order_by('chmp_id','asc');
				$query=$this->db->get();	
				$championdata=$query->result_array();	
				$data=array(); 

			foreach($championdata as $row) {             
					$ratingdata=array();
					$this->db->select('* ,avg(rating) as totalrating');
					$this->db->from('review_rating');
					$this->db->where('champion_id',$row['chmp_id']);
					$this->db->where('admin_approval','1');
					$this->db->order_by('review_id','desc');
					$this->db->group_by('champion_id');
					$ratingresult = $this->db->get();				

			foreach ($ratingresult->result_array() as $ratingrow) {

				array_push($ratingdata,array('totalrating' =>$ratingrow['totalrating']
				) );
			}

				array_push($data,array(
					'first_name'=>$row['first_name'],
					'last_name'=>$row['last_name'],
					'email'=>$row['email'],
					'phone'=>$row['phone'],
					'dob'=>$row['dob'],
					'skills'=>$row['skills'],
					'profile_image'=>$row['profile_image'],
					'address'=>$row['address'],
					'review_rating'=>$ratingdata
					)
				);	
			}
			//die;
			return  $data;
		} else {
			$data['error'] = "You are not authorized";
			$data['status']  = 'fail';
			/*echo "<pre>";
			print_r($data);exit;*/
			return $data;
		}
		}
		die;

}

function emergency_number(){
	$this->db->select('*');
	$this->db->from('site_setting');			
	$query=$this->db->get();
		if($query->num_rows()>0){
			$emegency_detail = $query->row();
			$data = array(				
				'emergency_phone' => trim($emegency_detail->emergency_phone),
				);		
			return $data;
		} else {
			return array();
		}	

}

 function get_upcoming_booking_by_user_post()
{
	$headers = apache_request_headers();
	$user_id = $this->input->post('user_id');
	$data    = array();
	$limit 	 = $this->input->post('limit');
	$offset  = $this->input->post('offset');
	$user_id = trim($this->input->post('user_id'));
	
   
	$this->db->select('*, bk.status as bkstatus');
	$this->db->from('booking  bk');
	$this->db->join('services as sr','sr.services_id=bk.service_id');
	$this->db->where('bk.user_id',$user_id); 
    $this->db->where('bk.status!=','Complete'); 
	$this->db->where('bk.status!=','Cancelled');
	//$this->db->where('bk.booking_date >=', date('y-m-d')); 
	$this->db->order_by('bk.booking_date','Desc');
	$this->db->limit($limit, $offset);	
	$result = $this->db->get();	
   //echo $this->db->last_query();die;
	foreach($result->result_array() as $row){
		$chmpdata=array();
		 $chmpid=unserialize($row['assign_champion_id']);
			if($chmpid!=''){
				foreach($chmpid as $chmp_id){					
				$reschmp = get_champion_info('champion', 'chmp_id',$chmp_id);
                 array_push($chmpdata,array(
                 	'first_name'=>$reschmp['first_name'],
                 	'last_name'=>$reschmp['last_name'],
                 	'email'=>$reschmp['email'],
                 	'profile_image'=>$reschmp['profile_image']
                 ));                
				}
			}		
		if($row['service_id']==1){
				if($headers['Accept-Language']=='en'){
					array_push($data,array(
						'user_id'=>$row['user_id'],
						'service_id'=>$row['service_id'],
						'service_name'=>$row['service_name'],
						'booking_date'=>$row['booking_date'],
						'starting_time'=>$row['starting_time'],
						'end_time'=>$row['end_time'],
						'number_of_hour'=>$row['number_of_hour'],
						'additional_preferences'=>$row['additional_preferences'],
						'status'=>$row['bkstatus'],
						'booking_id'=>$row['booking_id'],
						'champion'=>$chmpdata
						)
					);

				}elseif($headers['Accept-Language']=='ar') {
					array_push($data,array(
						'user_id'=>$row['user_id'],
						'service_id'=>$row['service_id'],
						'service_name'=>$row['service_name_ar'],
						'booking_date'=>$row['booking_date'],
						'starting_time'=>$row['starting_time'],
						'end_time'=>$row['end_time'],
						'number_of_hour'=>$row['number_of_hour'],
						'additional_preferences'=>$row['additional_preferences'],
						'status'=>$row['bkstatus'],
						'booking_id'=>$row['booking_id'],
						'champion'=>$chmpdata
						)
					);

				}elseif($headers['Accept-Language']=='so') {
					 array_push($data,array(
						'user_id'=>$row['user_id'],
						'service_id'=>$row['service_id'],
						'service_name'=>$row['service_name_so'],
						'booking_date'=>$row['booking_date'],
						'starting_time'=>$row['starting_time'],
						'end_time'=>$row['end_time'],
						'number_of_hour'=>$row['number_of_hour'],
						'additional_preferences'=>$row['additional_preferences'],
						'status'=>$row['bkstatus'],
						'booking_id'=>$row['booking_id'],
						'champion'=>$chmpdata
						)
					);

				}
				//die;
				
			
             
		}elseif($row['service_id']==2){
			if($headers['Accept-Language']=='en'){
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'cleaning_task'=>$row['cleaning_task'],
				'additional_comment'=>$row['additional_comment'],
				'status'=>$row['bkstatus'],
			   	'booking_id'=>$row['booking_id'],
			    'champion'=>$chmpdata
				));

			}elseif($headers['Accept-Language']=='ar') {
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name_ar'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'cleaning_task'=>$row['cleaning_task'],
				'additional_comment'=>$row['additional_comment'],
				'status'=>$row['bkstatus'],
			   	'booking_id'=>$row['booking_id'],
			    'champion'=>$chmpdata
				));
			}elseif($headers['Accept-Language']=='so') {
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name_so'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'cleaning_task'=>$row['cleaning_task'],
				'additional_comment'=>$row['additional_comment'],
				'status'=>$row['bkstatus'],
			   	'booking_id'=>$row['booking_id'],
			    'champion'=>$chmpdata
				));
			}
		}elseif($row['service_id']==3){
			if($headers['Accept-Language']=='en'){
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'number_of_children'=>$row['number_of_children'],
				'location'=>$row['location'],					
				'childcare_requirment'=>$row['childcare_requirment'],
				'status'=>$row['bkstatus'],
				'booking_id'=>$row['booking_id'],
				'champion'=>$chmpdata
				)
				);
			}elseif($headers['Accept-Language']=='ar') {
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name_ar'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'number_of_children'=>$row['number_of_children'],
				'location'=>$row['location'],					
				'childcare_requirment'=>$row['childcare_requirment'],
				'status'=>$row['bkstatus'],
				'booking_id'=>$row['booking_id'],
				'champion'=>$chmpdata
				)
				);

			}elseif($headers['Accept-Language']=='so') {
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name_so'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'number_of_children'=>$row['number_of_children'],
				'location'=>$row['location'],					
				'childcare_requirment'=>$row['childcare_requirment'],
				'status'=>$row['bkstatus'],
				'booking_id'=>$row['booking_id'],
				 'champion'=>$chmpdata
				)
				);

			}	
			
			
		}
		elseif($row['service_id']==4){
			if($headers['Accept-Language']=='en'){
				 array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'translate_from'=>$row['translate_from'],
				'translate_to'=>$row['translate_to'],
				'meet_at_location'=>$row['meet_at_location'],
				'status'=>$row['bkstatus'],
				'booking_id'=>$row['booking_id'],
				 'champion'=>$chmpdata
				));

			}elseif($headers['Accept-Language']=='ar'){
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name_ar'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'translate_from'=>$row['translate_from'],
				'translate_to'=>$row['translate_to'],
				'meet_at_location'=>$row['meet_at_location'],
				'status'=>$row['bkstatus'],
				'booking_id'=>$row['booking_id'],
				'champion'=>$chmpdata
				));

			}elseif($headers['Accept-Language']=='so'){
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name_so'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'translate_from'=>$row['translate_from'],
				'translate_to'=>$row['translate_to'],
				'meet_at_location'=>$row['meet_at_location'],
				'status'=>$row['bkstatus'],
				'booking_id'=>$row['booking_id'],
				'champion'=>$chmpdata
				));
			}		
			
		}
		//$i++; 
          
	}
	  //die;
	  return $data; 
    
}

function get_upcoming_booking_notification_by_user_post()
{
	$headers = apache_request_headers();
	$user_id = $this->input->post('user_id');
	$data    = array();
	$limit 	 = $this->input->post('limit');
	$offset  = $this->input->post('offset');
	$user_id = trim($this->input->post('user_id'));
	$this->db->select('*, bk.status as bkstatus,nt.create_date as ntcreatedt');
	$this->db->from('booking  bk');
	$this->db->join('services as sr','sr.services_id=bk.service_id');
    $this->db->join('bk_notification as nt','bk.booking_id=nt.booking_id','left');
	$this->db->where('bk.user_id',$user_id); 
	//$this->db->where('nt.user_id',$user_id);
	//$this->db->group_by('bk.booking_id');
   // $this->db->where('bk.status=','Allocated'); 
    $this->db->where('nt.bkstatus=','Allocated'); 
    $this->db->where('bk.notification_read=','1');

	//$this->db->where('bk.booking_date >=', date('y-m-d')); 
	$this->db->order_by('nt.bknotification_id','Desc');
	$this->db->limit($limit, $offset);
	
	$result = $this->db->get();	
 	 	//echo $this->db->last_query();die;	
	//$data   = $result->result_array();
  	 // $i=0;
	$msgdata=array();
	if(!empty($result)){
		foreach($result->result_array() as $row){
		array_push($data,array('notification_id'=>$row['bknotification_id'],
		'msg'=>$row['message'],		
		'starting_time'=>$row['ntcreatedt'],
		'service_id'=>$row['service_id'],
		));

		}

	 }else{	 		
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
	//die;
	  return $data; 
 
}
function get_broadcast_notification_by_user_post()
{
	$headers = apache_request_headers();
	$user_id = $this->input->post('user_id');
	$data    = array();
	$limit 	 = $this->input->post('limit');
	$offset  = $this->input->post('offset');
	$user_id = trim($this->input->post('user_id'));
	$this->db->select('*,group_name, nt.create_date as ntcreate');      
	$this->db->from('notification as nt');      
	$this->db->join('booking as bk','bk.booking_id = nt.booking_id','left');    
    $this->db->join('group gp','gp.group_id = nt.group_id','left');
	$this->db->order_by('nt.notification_id','desc');
	$this->db->where('nt.user_id',$user_id);
	//$this->db->where('bk.booking_date >=', date('y-m-d')); 
	$this->db->limit($limit, $offset);
	
	$result = $this->db->get();	
	//echo $this->db->last_query();die;	
	//$data   = $result->result_array();
	//echo "<pre>";print_r($result->result_array());die;
	
	 if(!empty($result->result_array())){
	 	//echo "hgh";die;
		foreach($result->result_array() as $row){
		array_push($data,array('notification_id'=>$row['notification_id'],
		'msg'=>$row['message'],
		'group_name'=>$row['group_name'],
		'starting_time'=>$row['ntcreate'],
		'service_id'=>$row['service_id'],
		));

		}

	 }
	 // else{	 	
	 // //echo "else fgfg";die;	
  //  		if($headers['Accept-Language']=='en' || $headers['Accept-Language']==''){
		// 		$data['status'] = 'fail';
		// 		$data['error']  = 'No record found';
  //             //	return $data; 
		// 	}elseif ($headers['Accept-Language']=='ar') {
		// 		$data['status'] = 'fail';
		// 		$data['error']  = 'لا توجد سجلات'; 
		// 		//return $data; 
		// 	}elseif ($headers['Accept-Language']=='so'){
		// 		$data['status'] = 'fail';
		// 		$data['error']  = 'lama hayo rikoodhkaga';
		// 		//return $data; 
		// 	}
  
	 // }
	  
 	// echo "<pre>";print_r($data);die;
	
	 return $data; 
 
}


function get_past_booking_by_user_post()
{
		$headers = apache_request_headers();
		$user_id = $this->input->post('user_id');
		$data    = array();
		$limit 	 = $this->input->post('limit');
		$offset  = $this->input->post('offset');
		$user_id = trim($this->input->post('user_id'));
		$this->db->select('*,bk.status as bkstatus');
		$this->db->from('booking  as bk');
       	$this->db->join('services as sr','sr.services_id=bk.service_id');       
		$this->db->where('bk.user_id',$user_id); 
		$this->db->where('bk.status=','Complete');
		$this->db->order_by('bk.booking_date','Desc');	   
		$this->db->limit($limit, $offset);		
		$result = $this->db->get();	
	
	    foreach($result->result_array() as $row){
			$chmpdata=array();
			$ratingdata=array();
			$chmpid=unserialize($row['assign_champion_id']);
				if($chmpid!=''){
					foreach($chmpid as $chmp_id){					
					$reschmp = get_champion_info('champion', 'chmp_id',$chmp_id);
                     array_push($chmpdata,array(
                     	'first_name'=>$reschmp['first_name'],
                     	'last_name'=>$reschmp['last_name'],
                     	'email'=>$reschmp['email'],
                     	'profile_image'=>$reschmp['profile_image']                     	
                     ));                    
					}
				}

				$this->db->select('*');
				$this->db->from('review_rating');
				$this->db->where('booking_id',$row['booking_id']);
				$this->db->group_by('rating'); 
				$ratingresult = $this->db->get();
				//echo $this->db->last_query();
				//echo "<pre>";print_r($ratingresult);
				foreach ($ratingresult->result() as $ratingrow) {
					array_push($ratingdata,array('rating' =>$ratingrow->rating
					           )
				);
				}
				//echo"<pre>";print_r($ratingdata);
			//die;
			
			if($row['service_id']==1){
				    if($headers['Accept-Language']=='en'){
						array_push($data,array(
						'user_id'=>$row['user_id'],
						'service_id'=>$row['service_id'],
						'service_name'=>$row['service_name'],
						'booking_date'=>$row['booking_date'],
						'starting_time'=>$row['starting_time'],
						'end_time'=>$row['end_time'],
						'number_of_hour'=>$row['number_of_hour'],
						'additional_preferences'=>$row['additional_preferences'],
						'status'=>$row['bkstatus'],
						'booking_id'=>$row['booking_id'],
						'review_rating'=>$ratingdata,
						'champion'=>$chmpdata,					
						));

				    }elseif($headers['Accept-Language']=='ar'){
						array_push($data,array(
						'user_id'=>$row['user_id'],
						'service_id'=>$row['service_id'],
						'service_name'=>$row['service_name_ar'],
						'booking_date'=>$row['booking_date'],
						'starting_time'=>$row['starting_time'],
						'end_time'=>$row['end_time'],
						'number_of_hour'=>$row['number_of_hour'],
						'additional_preferences'=>$row['additional_preferences'],
						'status'=>$row['bkstatus'],
						'booking_id'=>$row['booking_id'],
						'review_rating'=>$ratingdata,
						'champion'=>$chmpdata,					
						));

				    }elseif($headers['Accept-Language']=='so'){
						array_push($data,array(
						'user_id'=>$row['user_id'],
						'service_id'=>$row['service_id'],
						'service_name'=>$row['service_name_so'],
						'booking_date'=>$row['booking_date'],
						'starting_time'=>$row['starting_time'],
						'end_time'=>$row['end_time'],
						'number_of_hour'=>$row['number_of_hour'],
						'additional_preferences'=>$row['additional_preferences'],
						'status'=>$row['bkstatus'],
						'booking_id'=>$row['booking_id'],
						'review_rating'=>$ratingdata,
						'champion'=>$chmpdata,					
						));
				    }	
					//die;
					
				
                 
			}elseif($row['service_id']==2){
			    if($headers['Accept-Language']=='en'){
			    	array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'cleaning_task'=>$row['cleaning_task'],
					'additional_comment'=>$row['additional_comment'],
					'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					'review_rating'=>$ratingdata,
					'champion'=>$chmpdata
				));
			    }elseif($headers['Accept-Language']=='ar') {
			    	array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name_ar'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'cleaning_task'=>$row['cleaning_task'],
					'additional_comment'=>$row['additional_comment'],
					'status'=>$row['bkstatus'],
				   'booking_id'=>$row['booking_id'],
				   'review_rating'=>$ratingdata,
				    'champion'=>$chmpdata
				));
			    	
			    }elseif($headers['Accept-Language']=='so') {
			    	array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name_so'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'cleaning_task'=>$row['cleaning_task'],
					'additional_comment'=>$row['additional_comment'],
					'status'=>$row['bkstatus'],
				   'booking_id'=>$row['booking_id'],
				   'review_rating'=>$ratingdata,
				    'champion'=>$chmpdata
				));
               
			    }	
				
			
				
			}elseif($row['service_id']==3){
				if($headers['Accept-Language']=='en'){
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'number_of_children'=>$row['number_of_children'],
					'location'=>$row['location'],					
					'childcare_requirment'=>$row['childcare_requirment'],
					'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					'review_rating'=>$ratingdata,
					'champion'=>$chmpdata
					));

				}elseif($headers['Accept-Language']=='ar') {
				array_push( $data, array(
				'user_id'=>$row['user_id'],
				'service_id'=>$row['service_id'],
				'service_name'=>$row['service_name_ar'],
				'booking_date'=>$row['booking_date'],
				'starting_time'=>$row['starting_time'],
				'end_time'=>$row['end_time'],
				'number_of_hour'=>$row['number_of_hour'],
				'number_of_children'=>$row['number_of_children'],
				'location'=>$row['location'],					
				'childcare_requirment'=>$row['childcare_requirment'],
				'status'=>$row['bkstatus'],
				'booking_id'=>$row['booking_id'],
				'review_rating'=>$ratingdata,
				'champion'=>$chmpdata
				));

				}elseif($headers['Accept-Language']=='so') {
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name_so'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'number_of_children'=>$row['number_of_children'],
					'location'=>$row['location'],					
					'childcare_requirment'=>$row['childcare_requirment'],
					'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					'review_rating'=>$ratingdata,
					'champion'=>$chmpdata
					));

				}
				
				
			}
			elseif($row['service_id']==4){
				if($headers['Accept-Language']=='en'){
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'translate_from'=>$row['translate_from'],
					'translate_to'=>$row['translate_to'],
					'meet_at_location'=>$row['meet_at_location'],
					'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					'review_rating'=>$ratingdata,
					'champion'=>$chmpdata
				));

				}elseif($headers['Accept-Language']=='ar') {
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name_ar'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'translate_from'=>$row['translate_from'],
					'translate_to'=>$row['translate_to'],
					'meet_at_location'=>$row['meet_at_location'],
					'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					'review_rating'=>$ratingdata,
					'champion'=>$chmpdata
				));
				}elseif($headers['Accept-Language']=='so') {
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					'service_name'=>$row['service_name_so'],
					'booking_date'=>$row['booking_date'],
					'starting_time'=>$row['starting_time'],
					'end_time'=>$row['end_time'],
					'number_of_hour'=>$row['number_of_hour'],
					'translate_from'=>$row['translate_from'],
					'translate_to'=>$row['translate_to'],
					'meet_at_location'=>$row['meet_at_location'],
					'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					'review_rating'=>$ratingdata,
					'champion'=>$chmpdata
				));
				}
			}
		}
		//die;
		return $data; 
}



function get_past_booking_notification_by_user_post()
{
    $headers = apache_request_headers();
	$user_id = $this->input->post('user_id');
	$data    = array();
	$limit 	 = $this->input->post('limit');
	$offset  = $this->input->post('offset');
	$user_id = trim($this->input->post('user_id'));

	$this->db->select('*, bk.status as bkstatus,nt.create_date as ntcreatedt');
	$this->db->from('booking as bk');
   	$this->db->join('services as sr','sr.services_id=bk.service_id');
   	$this->db->join('bk_notification as nt','bk.user_id=nt.user_id','left');
	$this->db->where('bk.user_id',$user_id); 
    //$this->db->where('bk.status=','Cancelled');
    $this->db->where('nt.bkstatus=','Cancelled'); 
	//$this->db->where('bk.status!=','Allocated');
	//$this->db->where('bk.status!=','In Progress'); 
	
	//$this->db->where('bk.status!=','Cancelled');
	$this->db->group_by('nt.booking_id');  
	//$this->db->where('nt.create_date BETWEEN DATE_SUB(NOW(), INTERVAL 14 DAY) AND NOW()');
	$this->db->where('bk.create_date > DATE_SUB(NOW(), INTERVAL 2 WEEK)');
	$this->db->order_by('nt.bknotification_id','Desc');

	//$this->db->where('bk.booking_date =', date('Y-m-d', strtotime("-14 day")));
	$this->db->limit($limit, $offset);	
	$result = $this->db->get();	
	//echo $this->db->last_query();die;
 
	$msgdata=array();
     foreach($result->result_array() as $row){
		$chmpdata=array();
		 $chmpid=unserialize($row['assign_champion_id']);
			if($chmpid!=''){
				foreach($chmpid as $chmp_id){					
				$reschmp = get_champion_info('champion', 'chmp_id',$chmp_id);

                array_push($chmpdata,array(
                 	'first_name'=>$reschmp['first_name'],
                 	'last_name'=>$reschmp['last_name'],
                 	'email'=>$reschmp['email'],
                 	'profile_image'=>$reschmp['profile_image']

                 ));
                
				}
			}

		if($headers['Accept-Language']=='en'){
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					// 'service_name'=>$row['service_name'],
					// 'booking_date'=>$row['booking_date'],
					// 'starting_time'=>$row['starting_time'],
					// 'end_time'=>$row['end_time'],
					// 'number_of_hour'=>$row['number_of_hour'],
					// 'translate_from'=>$row['translate_from'],
					// 'translate_to'=>$row['translate_to'],
					// 'meet_at_location'=>$row['meet_at_location'],
					// 'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					//'champion'=>$chmpdata,
					'msg'=>$row['message'],
					'starting_time'=>$row['ntcreatedt']

					));
				}elseif($headers['Accept-Language']=='ar'){
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					// 'service_name'=>$row['service_name_ar'],
					// 'booking_date'=>$row['booking_date'],
					// 'starting_time'=>$row['starting_time'],
					// 'end_time'=>$row['end_time'],
					// 'number_of_hour'=>$row['number_of_hour'],
					// 'translate_from'=>$row['translate_from'],
					// 'translate_to'=>$row['translate_to'],
					// 'meet_at_location'=>$row['meet_at_location'],
					// 'status'=>$row['bkstatus'],
					 'booking_id'=>$row['booking_id'],
					// 'champion'=>$chmpdata,
					'msg'=>$row['message'],
					'starting_time'=>$row['ntcreatedt']
					));
				}elseif($headers['Accept-Language']=='so'){
					array_push( $data, array(
					'user_id'=>$row['user_id'],
					'service_id'=>$row['service_id'],
					// 'service_name'=>$row['service_name_so'],
					// 'booking_date'=>$row['booking_date'],
					// 'starting_time'=>$row['starting_time'],
					// 'end_time'=>$row['end_time'],
					// 'number_of_hour'=>$row['number_of_hour'],
					// 'translate_from'=>$row['translate_from'],
					// 'translate_to'=>$row['translate_to'],
					// 'meet_at_location'=>$row['meet_at_location'],
					// 'status'=>$row['bkstatus'],
					'booking_id'=>$row['booking_id'],
					//'champion'=>$chmpdata,
					'msg'=>$row['message'],
					'starting_time'=>$row['ntcreatedt']
					));
				}	
		
		// if($row['service_id']==1){			

		// 	if($row['bkstatus']=='Allocated'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your champion have been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="لقد تم تأكيد بطلك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Horyaalkaaga wa la xaqiijiyey";
		// 		}
				

		// 	}else if($row['bkstatus']=='Requested'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your booking has been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم تأكيد حجزك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Dalabkaaga wa la xaqiijiyey";
		// 		}
			

		// 	}else if($row['bkstatus']=='In Progress'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your booking is In Progress";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="حجزك قيد المعالجة";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Dalabkaaga hawshiisa wa lagu guda jira";
		// 		}

				
		// 	}else if($row['bkstatus']=='Complete'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been complete";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="اكتملت خدمة ".$row['service_name_ar']." الخاصة بك";
                       

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaaga  wa la  dhamaystiray";

		// 		}
				

		// 	}else if($row['bkstatus']=='Cancelled'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been Cancelled";
		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم إلغاء خدمة ".$row['service_name_ar']." الخاصة بك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaga wa la joojiyey";
		// 		}
              
		// 	}
			   
		// 	    if($headers['Accept-Language']=='en'){
		// 			array_push($data,array(
		// 			'user_id'=>$row['user_id'],
		// 			'service_id'=>$row['service_id'],
		// 			'service_name'=>$row['service_name'],
		// 			'booking_date'=>$row['booking_date'],
		// 			'starting_time'=>$row['starting_time'],
		// 			'end_time'=>$row['end_time'],
		// 			'number_of_hour'=>$row['number_of_hour'],
		// 			'additional_preferences'=>$row['additional_preferences'],
		// 			'status'=>$row['bkstatus'],
		// 			'booking_id'=>$row['booking_id'],
		// 			'champion'=>$chmpdata,
		// 			'msg'=>	$row['message'],
		// 			'msg_datetime'=>$row['ntcreatedt']			
		// 			));

		// 	    }elseif($headers['Accept-Language']=='ar'){
		// 	    	array_push($data,array(
		// 			'user_id'=>$row['user_id'],
		// 			'service_id'=>$row['service_id'],
		// 			'service_name'=>$row['service_name_ar'],
		// 			'booking_date'=>$row['booking_date'],
		// 			'starting_time'=>$row['starting_time'],
		// 			'end_time'=>$row['end_time'],
		// 			'number_of_hour'=>$row['number_of_hour'],
		// 			'additional_preferences'=>$row['additional_preferences'],
		// 			'status'=>$row['bkstatus'],
		// 			'booking_id'=>$row['booking_id'],
		// 			'champion'=>$chmpdata,
		// 			'msg'=>$msgdata,
		// 			'msg_datetime'=>$row['ntcreatedt']				
		// 			));

		// 	    }elseif($headers['Accept-Language']=='so'){
		// 	    	array_push($data,array(
		// 			'user_id'=>$row['user_id'],
		// 			'service_id'=>$row['service_id'],
		// 			'service_name'=>$row['service_name_so'],
		// 			'booking_date'=>$row['booking_date'],
		// 			'starting_time'=>$row['starting_time'],
		// 			'end_time'=>$row['end_time'],
		// 			'number_of_hour'=>$row['number_of_hour'],
		// 			'additional_preferences'=>$row['additional_preferences'],
		// 			'status'=>$row['bkstatus'],
		// 			'booking_id'=>$row['booking_id'],
		// 			'champion'=>$chmpdata,
		// 			'msg'=>$msgdata,
		// 			'msg_datetime'=>$row['ntcreatedt']				
		// 			));
		// 	    }
		// 		//die;
				
			
             
		// }elseif($row['service_id']==2){
		// 	if($row['bkstatus']=='Allocated'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your champion have been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="لقد تم تأكيد بطلك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Horyaalkaaga wa la xaqiijiyey";
		// 		}
				

		// 	}else if($row['bkstatus']=='Requested'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your booking has been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم تأكيد حجزك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Dalabkaaga wa la xaqiijiyey";
		// 		}
			

		// 	}else if($row['bkstatus']=='In Progress'){
		// 		if($headers['Accept-Language']=='en'){
		// 		$msgdata="Your booking is In Progress";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 		$msgdata="حجزك قيد المعالجة";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 		$msgdata="Dalabkaaga hawshiisa wa lagu guda jira";
		// 		}		

				
		// 	}else if($row['bkstatus']=='Complete'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been completed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="اكتملت خدمة ".$row['service_name_ar']." الخاصة بك";
                       

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaaga  wa la  dhamaystiray";

		// 		}			

		// 	}else if($row['bkstatus']=='Cancelled'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been Cancelled";
		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم إلغاء خدمة ".$row['service_name_ar']." الخاصة بك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaga wa la joojiyey";
		// 		}
              
		// 	}
			
		//     if($headers['Accept-Language']=='en'){
		//     	array_push( $data, array(
		// 		'user_id'=>$row['user_id'],
		// 		'service_id'=>$row['service_id'],
		// 		'service_name'=>$row['service_name'],
		// 		'booking_date'=>$row['booking_date'],
		// 		'starting_time'=>$row['starting_time'],
		// 		'end_time'=>$row['end_time'],
		// 		'number_of_hour'=>$row['number_of_hour'],
		// 		'cleaning_task'=>$row['cleaning_task'],
		// 		'additional_comment'=>$row['additional_comment'],
		// 		'status'=>$row['bkstatus'],
		// 	   	'booking_id'=>$row['booking_id'],
		// 	    'champion'=>$chmpdata,
		// 	    'msg'=>$msgdata,
		// 	    'msg_datetime'=>$row['ntcreatedt']
		// 		));
		//     }elseif($headers['Accept-Language']=='ar'){
		//     	array_push( $data, array(
		// 		'user_id'=>$row['user_id'],
		// 		'service_id'=>$row['service_id'],
		// 		'service_name'=>$row['service_name_ar'],
		// 		'booking_date'=>$row['booking_date'],
		// 		'starting_time'=>$row['starting_time'],
		// 		'end_time'=>$row['end_time'],
		// 		'number_of_hour'=>$row['number_of_hour'],
		// 		'cleaning_task'=>$row['cleaning_task'],
		// 		'additional_comment'=>$row['additional_comment'],
		// 		'status'=>$row['bkstatus'],
		// 	   	'booking_id'=>$row['booking_id'],
		// 	    'champion'=>$chmpdata,
		// 	    'msg'=>$msgdata,
		// 	    'msg_datetime'=>$row['ntcreatedt']
		// 		));
		//     }elseif($headers['Accept-Language']=='so'){
		//     	array_push( $data, array(
		// 		'user_id'=>$row['user_id'],
		// 		'service_id'=>$row['service_id'],
		// 		'service_name'=>$row['service_name_so'],
		// 		'booking_date'=>$row['booking_date'],
		// 		'starting_time'=>$row['starting_time'],
		// 		'end_time'=>$row['end_time'],
		// 		'number_of_hour'=>$row['number_of_hour'],
		// 		'cleaning_task'=>$row['cleaning_task'],
		// 		'additional_comment'=>$row['additional_comment'],
		// 		'status'=>$row['bkstatus'],
		// 	   	'booking_id'=>$row['booking_id'],
		// 	    'champion'=>$chmpdata,
		// 	    'msg'=>$msgdata,
		// 	    'msg_datetime'=>$row['ntcreatedt']
		// 		));
		//     }	
		
			
		// }elseif($row['service_id']==3){
		// 	if($row['bkstatus']=='Allocated'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your champion have been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="لقد تم تأكيد بطلك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Horyaalkaaga wa la xaqiijiyey";
		// 		}
				

		// 	}else if($row['bkstatus']=='Requested'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your booking has been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم تأكيد حجزك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Dalabkaaga wa la xaqiijiyey";
		// 		}
			

		// 	}else if($row['bkstatus']=='In Progress'){
		// 		if($headers['Accept-Language']=='en'){
		// 		$msgdata="Your booking is In Progress";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 		$msgdata="حجزك قيد المعالجة";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 		$msgdata="Dalabkaaga hawshiisa wa lagu guda jira";
		// 		}		

				
		// 	}else if($row['bkstatus']=='Complete'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been completed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="اكتملت خدمة ".$row['service_name_ar']." الخاصة بك";
                       

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaaga  wa la  dhamaystiray";

		// 		}
				

		// 	}else if($row['bkstatus']=='Cancelled'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been Cancelled";
		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم إلغاء خدمة ".$row['service_name_ar']." الخاصة بك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaga wa la joojiyey";
		// 		}
              
		// 	}
		// 		if($headers['Accept-Language']=='en'){
		// 			array_push( $data, array(
		// 			'user_id'=>$row['user_id'],
		// 			'service_id'=>$row['service_id'],
		// 			'service_name'=>$row['service_name'],
		// 			'booking_date'=>$row['booking_date'],
		// 			'starting_time'=>$row['starting_time'],
		// 			'end_time'=>$row['end_time'],
		// 			'number_of_hour'=>$row['number_of_hour'],
		// 			'number_of_children'=>$row['number_of_children'],
		// 			'location'=>$row['location'],					
		// 			'childcare_requirment'=>$row['childcare_requirment'],
		// 			'status'=>$row['bkstatus'],
		// 			'booking_id'=>$row['booking_id'],
		// 			'champion'=>$chmpdata,
		// 			'msg'=>$msgdata,
		// 			'msg_datetime'=>$row['ntcreatedt']
		// 			));

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			array_push( $data, array(
		// 			'user_id'=>$row['user_id'],
		// 			'service_id'=>$row['service_id'],
		// 			'service_name'=>$row['service_name_ar'],
		// 			'booking_date'=>$row['booking_date'],
		// 			'starting_time'=>$row['starting_time'],
		// 			'end_time'=>$row['end_time'],
		// 			'number_of_hour'=>$row['number_of_hour'],
		// 			'number_of_children'=>$row['number_of_children'],
		// 			'location'=>$row['location'],					
		// 			'childcare_requirment'=>$row['childcare_requirment'],
		// 			'status'=>$row['bkstatus'],
		// 			'booking_id'=>$row['booking_id'],
		// 			'champion'=>$chmpdata,
		// 			'msg'=>$msgdata,
		// 			'msg_datetime'=>$row['ntcreatedt']
		// 			));
		// 		}elseif($headers['Accept-Language']=='so'){
		// 			array_push( $data, array(
		// 			'user_id'=>$row['user_id'],
		// 			'service_id'=>$row['service_id'],
		// 			'service_name'=>$row['service_name_so'],
		// 			'booking_date'=>$row['booking_date'],
		// 			'starting_time'=>$row['starting_time'],
		// 			'end_time'=>$row['end_time'],
		// 			'number_of_hour'=>$row['number_of_hour'],
		// 			'number_of_children'=>$row['number_of_children'],
		// 			'location'=>$row['location'],					
		// 			'childcare_requirment'=>$row['childcare_requirment'],
		// 			'status'=>$row['bkstatus'],
		// 			'booking_id'=>$row['booking_id'],
		// 			'champion'=>$chmpdata,
		// 			'msg'=>$msgdata,
		// 			'msg_datetime'=>$row['ntcreatedt']
		// 			));
		// 		}

			
			
		// }
		// elseif($row['service_id']==4){
		// 	if($row['bkstatus']=='Allocated'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your champion have been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="لقد تم تأكيد بطلك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Horyaalkaaga wa la xaqiijiyey";
		// 		}
				

		// 	}else if($row['bkstatus']=='Requested'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your booking has been confirmed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم تأكيد حجزك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Dalabkaaga wa la xaqiijiyey";
		// 		}
			

		// 	}else if($row['bkstatus']=='In Progress'){
		// 		if($headers['Accept-Language']=='en'){
		// 		$msgdata="Your booking is In Progress";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 		$msgdata="حجزك قيد المعالجة";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 		$msgdata="Dalabkaaga hawshiisa wa lagu guda jira";
		// 		}		

				
		// 	}else if($row['bkstatus']=='Complete'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been completed";

		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="اكتملت خدمة ".$row['service_name_ar']." الخاصة بك";
                       

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaaga  wa la  dhamaystiray";
		// 		}				

		// 	}else if($row['bkstatus']=='Cancelled'){
		// 		if($headers['Accept-Language']=='en'){
		// 			$msgdata="Your ".$row['service_name']." service has been Cancelled";
		// 		}elseif($headers['Accept-Language']=='ar'){
		// 			$msgdata="تم إلغاء خدمة ".$row['service_name_ar']." الخاصة بك";

		// 		}elseif($headers['Accept-Language']=='so'){
		// 			$msgdata="Adeeg ".$row['service_name_so']." gaga wa la joojiyey";
		// 		}
              
		// 	}
				
		// }		
	 }
	//die;
	  return $data; 
}




function resend_request()
{
	//echo "hello";die;
	$headers = apache_request_headers();  
	$admin=get_all_records('admin');
	$useremail = $this->input->post('email');
	$query = $this->db->get_where("user",array("email"=>$useremail));
	$res = $query->row();	
	
  	 $data1 = array('resend_request' => '1');	
      if($useremail!=''){
	        foreach ($admin as  $row) {
				$admin_id=$row->admin_id;		

				//if($headers['Accept-Language']=='en'){
				$email_template 	 = $this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='resend request send by user'");
				// }elseif($headers['Accept-Language']=='ar') {
				// 	//echo "ar language"; die;
				// $email_template 	 = $this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='resend request send by user ar'");

				// }elseif($headers['Accept-Language']=='so'){
				// 	//echo "so language"; die;
				// $email_template 	 = $this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='resend request send by user so'");
				// }
				
				$site_setting   	 = site_setting();		
				$email_temp 		 = $email_template->row();			
				$email_address_from  = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject		 = $email_temp->subject;
				$email_message		 = $email_temp->message;			        
				$user_name	=$row->first_name.' '. $row->last_name;
				//echo $user_name;
				$email 		= $row->email;	
		        $user_email=$useremail;
				$year 		     = date('Y');
				$email_to 		 = $email;
				$login_link		 = site_url('home');
				//$activate_status   = $get_user_info['status'];
				$base_url 		 = base_url().getThemeName().'/';
				$image_url		 = base_url();
				
				$email_subject	 = str_replace('{break}','<br/>',$email_subject);		
				$email_message	 = str_replace('{break}','<br/>',$email_message);
			    $email_message	 = str_replace('{user_email}',$user_email,$email_message);
				$email_message	 = str_replace('{username}',$user_name,$email_message);
				$email_message	 = str_replace('{email}',$email,$email_message);	
				$email_message	 = str_replace('{base-url}',$base_url,$email_message);
				$email_message	 = str_replace('{site_url}',base_url(),$email_message);
				$email_message	 = str_replace('{site_name}',$site_setting->site_name,$email_message);
				$email_message	 = str_replace('{image_url}',$image_url,$email_message);
				$email_message	 = str_replace('{year}',$year,$email_message);
				$str 			 = $email_message;
		       //print_r($str);die;
				email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);	
			}

			if($query->num_rows()>0){
			
				$this->db->where(array('user_id'=>$res->user_id));
				$result=$this->db->update('user',$data1);
				return $result;
				// echo $qu; die;
				 //return true;
				//}else{
				///	return false;
			}

      } else{

      	if($headers['Accept-Language']=='en'){
      	$data['error'] = "Please fill your email address";
		$data['status']  = 'fail';
	    }elseif($headers['Accept-Language']=='ar') {
		$data['error'] = "الرجاء إدخال عنوان بريدك الإلكتروني";
		$data['status']  = 'fail';

	    }elseif($headers['Accept-Language']=='so'){
		$data['error'] = "Fadlan gali ciwaanka emailkaaga";
		$data['status']  = 'fail';

	    }
		/*echo "<pre>";
		print_r($data);exit;*/
		return $data;


      }
	
	
}

	/*
	 * Function: UsernameUnique
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: Boolean return 
	*/
	function MobileUnique()
	{
		$str = $this->input->post('mobileno');
		if($this->input->post('UserId')!='')
		{
			$query = $this->db->query("select UserContact from ".$this->db->dbprefix('tbluser')." where UserContact = '$str' and UserId!='".$this->input->post('register_id')."'");
		}else{
			$query = $this->db->query("select UserContact from ".$this->db->dbprefix('tbluser')." where UserContact = '$str'");
		}
        //echo $this->db->last_query();die;
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	/*
	 * Function: register()
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: void return 
	*/
	function register(){
       // $headers = apache_request_headers();
		$length = 10;
		//$unhcr_no=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
		$data 		 		 = array();
		$confirm_code		 = md5(uniqid(rand()));
		$user_image			 = '';
	
		$data = array(
			'FullName'   	  => $this->input->post('full_name'),
			'EmailAddress' 	  => $this->input->post('email'),
			'UserContact' 	  => $this->input->post('mobileno'),		
			'UserPassword'	  =>trim(md5($this->input->post('password')))			
			);

	    // echo"<pre> hghg";print_r($data);die;
		$user_id= insert_record_api('tbluser',$data); 
		$user_detail = get_one_record('tbluser','UsersId',$user_id);
		//echo"<pre> hghg";print_r($user_detail);die;
		$data = array(
			'full_name'			=> trim($user_detail->FullName),
			'email' 			=> trim($user_detail->EmailAddress),
			'phone' 			=> trim($user_detail->UserContact),
			'user_id'			=> trim($user_detail->UsersId),
			);		

           ///echo "<pre>";print_r($data);die;
		//send email to User                
		
		return $data;
	
	}


	/*
	 * Function: change_password()
	 * Author: Binny
	 * Date: 19/6/2017
	 * return @void
	*/
	function change_password($user_id,$oldpassword){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id',$user_id);
		$this->db->where('password',$oldpassword);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			//echo 
			return 1;
		}
		else {
			return 0;
		}
	}
	function updateUserPassword()
	{

		$data = array(
						'UserPassword' => md5(trim($this->input->post('password')))			
					);		
		$query=$this->db->where(array('UsersId'=> $this->input->post('user_id'),'UserPassword'=>md5(trim($this->input->post('old_password')))))->get_where('tbluser');
		
		if($query->num_rows()>0){			
		$this->db->where(
			array('UsersId'=>$this->input->post('user_id'),
			'UserPassword'=>md5(trim($this->input->post('old_password')))
			
				)
		);
		$this->db->update('tbluser',$data);
		return true;
		}else{
		return false;
		}
	}
	

	/*
	 * Function: get_profile()
	 * Author: Binnyresend
	 * Date: 20/11/2017
	 * return array
	*/
	function get_profile($user_id){
		$query = $this->db->select('*')->from('tbluser')->where('UsersId',$user_id)->get();
		if($query->num_rows()>0){
			$user_detail = $query->row();
			$data = array(
				'full_name' 	    => trim($user_detail->FullName),
				'email' 			=> trim($user_detail->EmailAddress),				
				'phone'			    => trim($user_detail->UserContact),
				'profile_image'		=> trim($user_detail->ProfileImage),
				'user_id'			=> trim($user_detail->UsersId),
				);		
			return $data;
		}else{
			return array();
		}
		
	}
	
	
	/*
	 * Function: Reset_password
	 * Author: Binny
	 * Date: 17/11/2017
	 * Input: code , new password 
	 * Output: Change password and fire email
	*/
	function reset_password($forget_password_code,$password)
	{
		//$headers = apache_request_headers();
		//echo "<pre> fdfd"; $forget_password_code; die;
		$password1 	  = md5($password);	
	
		$query  	  = $this->db->get_where("tbluser",array("ResetPasswordCode"=>$forget_password_code));
		$res 		  = $query->row();

		//print_r($res);die;
		if($query->num_rows() > 0)
		{
			
			$ud=array('UserPassword'=>$password1, 'ResetPasswordCode'=>"");
			$this->db->where('UsersId',$res->UsersId);
			$this->db->update('tbluser',$ud);
           
            $data['message'] = "Your password has been reset successfully";
            $data['status']  = 'success';		  
          
            return $data;


        }else{
        	$data['status'] = 'fail';
        	$data['error']  = 'Please enter valid activation code';
        	return $data;
        }

    }
    
    
	/*
	 * Function: save_social_data
	 * Author: Binny
	 * Date: 19/11/2017
	 * Input: post array
	 * Output: Int return 
	*/
	function save_social_data($data)
	{
		$rand = rand('1111','9999');	
		$data_insert["name"] 			= $data['full_name'];
		$data_insert["gender"] 			= $data['gender'];
		$data_insert["dob"]		 		= $data['dob'];
		$data_insert["email"] 			= $data['email'];
		$data_insert["status"]    		= '0';
		$data_insert["country"] 		= $data['country'];
		$data_insert["city"] 			= $data['city'];
		$data_insert["state"] 			= $data['state'];
		if($data['type'] =="facebook"){
			$data_insert['fb_id'] 		= $data['fb_id'];
			$data_insert['profile_img'] = $data['fb_img'];
		}
		if($data['type'] =="google"){
			$data_insert['google_id'] 	= $data['google_id'];
			$data_insert['profile_img'] = $data['google_img'];
		}
		//$user_password 				  = $data['full_name'] .'@'.$rand;  
		//$data_insert["user_type"] 	  = $data['user_type'];
		//$data_insert['expires_date_ms'] = round(microtime(true) * 1000);		
		//$data_insert["age"]			  = $data['age'];
		//$data_insert["latitude"]        = $data['latitude'];
		//$data_insert["longitude"]  	  = $data['longitude'];
		//$data_insert['sign_up_date']	  = date('Y-m-d H:i:s');
		//$data_insert['sign_up_ip'] 	  = $_SERVER['REMOTE_ADDR'];	
		//$data_insert['domain_name']	  = $_SERVER['SERVER_NAME'];
		//$data_insert['password'] 		  = md5($user_password);
		//$data_insert['domain_id'] 	  = GetDomainId();
		//$data_insert['date_modified']	  = date('Y-m-d H:i:s');
		//$data_insert['profile_image']   = $data['fb_img'];
		//$data_insert["verify_email"] 	  = "1";
		
		//echo '<pre>'; print_r($data_insert); die;		
		$this->db->insert('user',$data_insert);
		//$uid = mysql_insert_id();
		$uid = $this->db->insert_id();
		//echo $this->db->last_query(); die;
		
		$data1 = array(	'user_id' 			=> $uid,
						$data['type'].'_id' => $data['type'].'_id',//$data['fb_id'],
						'email' 			=> $data_insert["email"],
						'full_name' 		=> $data_insert['name'],
						//'user_type'=>$data_insert['user_type'],
						);	
		$this->session->set_userdata($data1);
		
	    /*$usl=array(
					'user_id'		 =>	$uid,
					'login_date_time'=>	date('Y-m-d H:i:s'),
					'login_ip'		 =>	$_SERVER['REMOTE_ADDR'],
					'login_status'	 =>	'online'
					);
					$this->db->insert('user_login',$usl); */
					
					$data = array('user_id' =>	$uid, 
						'email' 	=>	$data_insert["email"],
						"full_name" =>	$data_insert['name']
		            //"user_type"		 => $data_insert['user_type'],
		            //'login_history_id' => $this->db->insert_id() ,
						);

					$this->session->set_userdata($data);	

		//==== Mail Send ====//
					$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='social sign up'");
					$email_temp 		 = $email_template->row();				

					$email_address_from	 = $email_temp->from_address;
					$email_address_reply = $email_temp->reply_address;

					$email_subject		 = $email_temp->subject;				
					$email_message		 = $email_temp->message;

					$site_setting 		 = site_setting();
		$email 				 = $data_insert["email"];//$this->input->post('email');
		$name 				 = $data_insert["name"];
		$year 				 = date('Y');
		$login_link 		 = "<a href='".site_url('home')."'>here</a>"; 
		//$data_pass 		 = base64_encode($uid."1@1".$confirm_code);
		//$password 		 = $user_password;//$this->input->post('password');
		//$activation_link 	 = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
		//$login_link 		 = "<a href='".site_url('home/index/'. base64_encode('login'))."'>here</a>";

		$email_message		 = str_replace('{break}','<br/>',$email_message);
		$email_message		 = str_replace('{name}',$name,$email_message);
		$email_message		 = str_replace('{password}','',$email_message);
		$email_message		 = str_replace('{email}',$email,$email_message);
		$email_message		 = str_replace('{year}',$year,$email_message);
		$email_message		 = str_replace('{site_name}',$site_setting->site_name,$email_message);
		//$email_message	 = str_replace('{password}',$password,$email_message);
		//$email_message	 = str_replace('{activation_link}',$activation_link,$email_message);
		//$email_message	 = str_replace('{login_link}',$login_link,$email_message);
        //$email_message=str_replace('{base_theme_url}',base_url().getThemeName(),$email_message);
		
		$email_to =$email;
		
		$str=$email_message;
		//==== custom_helper email function ====//
		//print_r($str); die; 					
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str); 
		return $uid;	
	}


	/*
	 * Function: get_user_by_fb_uid
	 * Author: Binny
	 * Date: 19/6/2017
	 * Input: fb_id,email
	 * Output: array return 
	*/
	function get_user_by_fb_uid($fb_id = 0,$email='') 
	{

	   	//returns the facebook user as an array.
		$sql = " SELECT * FROM ".$this->db->dbprefix('user')." WHERE fb_id ='".$fb_id."'";
		
		if($email != ''){
			//$sql = " SELECT * FROM ".$this->db->dbprefix('users')." WHERE (fb_id ='".$fb_id."' or email='".$email."')";
			$sql = " SELECT * FROM ".$this->db->dbprefix('user')." WHERE fb_id ='".$fb_id."' and email='".$email."'";
		}
		
		$usr_qry = $this->db->query($sql);
		
		if($usr_qry->num_rows() > 0) 
		{ 
			//yes, a user exists
			$user = $usr_qry->row();
			/*if($user->fb_id == 0){
				$data2 = array(					
						'fb_id' => $fb_id,
						'date_modified' => date('Y-m-d H:i:s') 	
				);
						
				$this->db->where('email', $email);
				$this->db->update('users', $data2);				
			}*/

			$data = array('user_id' => $user->user_id, 
				'email' 		 	=> $user->email,					      
				"full_name" 		=> $user->name,
				'fb_id' 			=> $user->fb_id,
				);
			$this->session->set_userdata($data);

			return $user;
		} else {
	   		// no user exists
			return false;
		}

	}


	/*
	 * Function: user_edit_basic_api
	 * Author: Binny
	 * Date: 19/6/2017
	 * Input: post array
	 * Output: array return
	*/
	function user_edit_profile_api()
	{
		//print_r($_POST);die;

		//$site_setting  = site_setting();	
		$this->load->library('upload');
		$user_id 	   = trim($this->input->post('user_id')); 
		$user_image    = '';
		//$image_setting = image_setting();
		//echo "<pre>";print_r($image_setting);die;

		if(@$_FILES['profile_image']['name']!='' && $_FILES['profile_image']['name']!='')
		{
			$this->load->library('upload');
			$rand=rand(0,100000); 

			$_FILES['userfile']['name']     =   $_FILES['profile_image']['name'];
			$_FILES['userfile']['type']     =   $_FILES['profile_image']['type'];
			$_FILES['userfile']['tmp_name'] =   $_FILES['profile_image']['tmp_name'];
			$_FILES['userfile']['error']    =   $_FILES['profile_image']['error'];
			$_FILES['userfile']['size']     =   $_FILES['profile_image']['size'];

			$config['file_name']   	   = $rand.'user';			
			$config['upload_path']     = base_path().'upload/user_orig/';
			$config['allowed_types']   = '*';
            //$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp'; 
			$this->upload->initialize($config); 
			if (!$this->upload->do_upload())
			{
				echo $error =  $this->upload->display_errors(); die;
			} 			   
			$picture = $this->upload->data();

			$this->load->library('image_lib');
			$this->image_lib->clear();	   	
			$gd_var='gd2';	

			$this->image_lib->clear();
			$this->image_lib->initialize(array(
				'image_library'  => $gd_var,
				'source_image'   => base_path().'upload/user_orig/'.$picture['file_name'],
				'new_image' 	 => base_path().'upload/user/'.$picture['file_name'],
				'maintain_ratio' => TRUE,
				'quality'  		 => '100%',
				'width' 		 => 440,
				'height' 		 => 440,
				'master_dim' 	 => 'width',
				));
			
			if(!$this->image_lib->resize())
			{
				echo $error = $this->image_lib->display_errors();die;
			}

			$user_image=$picture['file_name'];
			$this->input->post('pre_profile_image');			

			if($this->input->post('pre_profile_image')!='')
			{
				if(file_exists(base_path().'upload/user/'.$this->input->post('pre_profile_image')))
				{
					$link=base_path().'upload/user/'.$this->input->post('pre_profile_image');
					unlink($link);
				}
				
				if(file_exists(base_path().'upload/user_orig/'.$this->input->post('pre_profile_image')))
				{
					$link2=base_path().'upload/user_orig/'.$this->input->post('pre_profile_image');
					unlink($link2);
				}
			}
			// $user_image= $data["profile_image"];	

		} else {
        if($this->input->post('pre_profile_image')!='')
        {
          $user_image=$this->input->post('pre_profile_image');
        }
      }			

		$fullname = trim($this->input->post('full_name'));
		$phone 	  = trim($this->input->post('mobileno'));
		
		 $data=array(		 
			'FullName'=>trim($this->input->post('full_name')),
			'UserContact'=>trim($this->input->post('mobileno')),
			'EmailAddress'=>trim($this->input->post('email')),			
			'ProfileImage'=>$user_image,
		 );
		
		 //echo "<pre>";print_r($data);die;

		 $this->db->where('UsersId',$user_id);
		 $this->db->update('tbluser',$data);
         // echo $this->db->last_query();die;
		
		return $data;
 
	}


	/*
	 * Function: check_user_id
	 * Author: Binny
	 * Date: 21/11/2017
	 * Input: id
	 * Output: array return 
	*/
	function check_user_id($id) {
		$query = $this->db->get_where('tbluser',array('UsersId'=>$id));
		return $query->num_rows();
	}


	/*
	 * Function: get_highlites
	 * Author: Binny
	 * Date: 19/6/2017
	 * Input: id
	 * Output: limit,offset
	 * Desc: get all experiences
	*/	
	function get_highlites($limit,$offset)    
	{ 	
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$radius = $this->input->post('radius');
		$radius = (($radius == '')?500:$radius);
		$user_id = $this->input->post('user_id');
		$table = "sss_experience_master";
		//pr($radius );die;
		if($user_id != NULL && is_numeric($user_id))
		{
		//	$where="user_id != ".$user_id."";
			$where="user_id != ".$user_id." and is_deleted != '1' and status !='1' ";

			if ($latitude !="" AND $longitude !="" ) {
			$where .=" AND (3959 * ACOS( COS( RADIANS(".$latitude.") ) * COS( RADIANS(latitude ) ) * COS( RADIANS(longitude  ) - RADIANS(".$longitude.") ) + SIN( RADIANS(".$latitude.") ) * SIN( RADIANS(latitude ) ) ) )  <= $radius";	
			}
			
			
			$this->db->order_by('experience_id', 'DESC');
			if(($limit != "" && is_numeric($limit)) && ($offset != "" && is_numeric($offset)) )
			{
				$query=$this->db->get_where($table,$where,$limit,$offset);			
			}
			else{
				$query=$this->db->get_where($table,$where);
			}
		}
		else
		{
			if(($limit != "" && is_numeric($limit)) && ($offset != "" && is_numeric($offset)) )
			{
				$query=$this->db->get($table,$limit,$offset);
			}
			else{
				$query=$this->db->get($table);
			}
		}

		
		
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}else
		{ 
			return 0; 
		}
	}


	/*
	 * Function: get_highlites
	 * Author: Binny
	 * Date: 19/6/2017
	 * Input: id
	 * Output: limit,offset
	 * Desc: get all experiences
	*/	
	

	function insert_report_problem(){
			
		$headers = apache_request_headers(); 
		$user_id 		= trim($this->input->post('user_id'));		
		$problem_date = trim($this->input->post('problem_date'));
		$type_of_problem  =trim($this->input->post('type_of_problem'));
		$explain_problem  = trim($this->input->post('explain_problem'));
		
		 	$ins=array(
			'user_id' => $user_id,		
			'problem_date' => $problem_date,
			'type_of_problem'=>$type_of_problem,
			'explain_problem'=>$explain_problem,
			'status'=> 'active'	
			);
		    //echo "<pre>";print_r($ins); die;
			$this->db->insert('sss_report_problem',$ins);
		
		  
		$id = $this->db->insert_id();
             
		if($id){
            $admin_one  = get_one_record('admin','admin_type','1');
				// echo "<pre>";print_r($admin_one);die;
			$get_user_info = get_user_info('user', 'user_id',$user_id);
			 $report_problem_detail  = get_one_record('report_problem','report_problem_id',$id);
			 $site_setting = site_setting();
					//echo "<pre>";print_r($site_setting); die;

					if($headers['Accept-Language']=='en'){
					$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='report problem by user'");

					}elseif($headers['Accept-Language']=='ar'){
						
					$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='report problem by user ar'");

					}elseif($headers['Accept-Language']=='so'){
						//echo"fdf";die;
					$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='report problem by user so'");
					}
				  	
					$email_temp=$email_template->row();					
					$email_address_from=$email_temp->from_address;
					$email_address_reply=$email_temp->reply_address;
					$email_subject=$site_setting->site_name;
					$email_subject=$email_temp->subject;
					$email_message=$email_temp->message;

                    $admin_name=$admin_one->first_name.' '.$admin_one->last_name;
					$user_name=$get_user_info['full_name'];	

					$problem_date = $report_problem_detail->problem_date;
					$typeofproblem=$report_problem_detail->type_of_problem;
					$probelms=$report_problem_detail->explain_problem;					
					$year = date('Y');					
					$email = $admin_one->email;              
					$email_to =$email;
					

					//$base_url='<h4>Project Stand Up</h4>';
					$image_url=base_url();
					$email_message=str_replace('{break}','<br/>',$email_message);
					$email_message=str_replace('{adminname}',$admin_name,$email_message);
					$email_message=str_replace('{username}',$user_name,$email_message);
					$email_message=str_replace('{email}',$email,$email_message);
					$email_message=str_replace('{problemdate}',$problem_date,$email_message);    
					$email_message=str_replace('{typeofproblem}',$typeofproblem,$email_message);  
					$email_message=str_replace('{problems}',$probelms,$email_message);                                
					//$email_message=str_replace('{base-url}',$base_url,$email_message);
					$email_message=str_replace('{site_url}',base_url(),$email_message);
					$email_message=str_replace('{site_name}',$site_setting->site_name,$email_message);
					$email_message=str_replace('{image_url}',$image_url,$email_message);
					$email_message=str_replace('{year}',$year,$email_message);
					
					$str=$email_message;
					//print_r($str); die;
					email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				
			$data['result']= array(
				"report_problem_id"	 => $id,
				'user_id'	     => $user_id,
				'problem_date'=>$report_problem_detail->problem_date,
				'type_of_problem'=>$report_problem_detail->type_of_problem,
				'explain_problem'=>$report_problem_detail->explain_problem,
				);

			$data['status'] = 'success';
			return $data;
		}
		else{
			if($headers['Accept-Language']=='en'){
			$data['status'] = 'fail';
			$data['error']  = 'Record has been not inserted.';

			}elseif($headers['Accept-Language']=='ar'){
			$data['status'] = 'fail';
			$data['error']  = 'Insert not successfull. ar language';

			}elseif($headers['Accept-Language']=='so'){
			$data['status'] = 'fail';
			$data['error']  = 'Insert not successfull. so language';
			}

		}
	}
    



    function user_langauge_setting(){
			
		$headers = apache_request_headers(); 
		$user_id = trim($this->input->post('user_id'));		
		
		
		 	$updatedata=array(
			'user_id' => $user_id,		
			'user_lan'=>$headers['Accept-Language'],
			);
		    //echo "<pre>";print_r($ins); die;
			$this->db->where('user_id',$this->input->post('user_id'));
			$res=$this->db->update('user',$updatedata);
			 
             
		if($res=='1'){
			 if($headers['Accept-Language']=='en'){
			$data['status'] = 'success';
			$data['message']  = 'Language has been update successfull.';
 
			}elseif($headers['Accept-Language']=='ar'){
			$data['status'] = 'success';
			$data['message']  = 'تم تحديث اللغة بنجاح';

			}elseif($headers['Accept-Language']=='so'){
			$data['status'] = 'success';
			$data['message']  = 'Waxa lagu guulaystay cusbooneysiinta luuqada';
			}
		}else{
			if($headers['Accept-Language']=='en'){
				$data['status'] = 'fail';
				$data['error']  = 'Language has been not updated.';

			}elseif($headers['Accept-Language']=='ar'){
				$data['status'] = 'fail';
				$data['error']  = 'لم يتم تحديث اللغة';

			}elseif($headers['Accept-Language']=='so'){
				$data['status'] = 'fail';
				$data['error']  = 'Luuqad laguma cusbooneysiin';
			}

		}
		return $data;
	}

	



/*
 * Function: forgot_password
 * Author: Binny
 * Date: 21/11/2017
 * Input: email
 * Output: array return 
*/
function forgot_password($mobileno)
{

	//$headers = apache_request_headers();  	
	$rnd 			= randomCode();
	//$site_setting   = site_setting();
	$query 			= $this->db->get_where("tbluser",array("UserContact"=>$mobileno));
	$res 			= $query->row();		
	if($query->num_rows() > 0)
	{
		if($res->IsActive == 'Inactive')
		{	
		  		
			$data['status'] = 'fail';
			$data['error']  = 'Your account is inactive. Please contact administrator!';	
			return $data;
			
		}
		else{				
			$ud=array('ResetPasswordCode'=>$rnd);				
			$this->db->where('UsersId',$res->UsersId);
			$this->db->update('tbluser',$ud);
            $data['message'] = "Check your email for the reset password";
			$data['status']  = 'success';
			/*echo "<pre>";
			print_r($data);exit;*/
			return $data;
		}
	}
	else
	{
			$data['status'] = 'fail';
			$data['error']  = 'Please enter registered Mobile Number';
			return $data;
	}
}




/*
 * Function: send_message 
 * Author: Binny
 * Date: 22/11/2017
 * Input: post array
 * Output: array 
*/
function send_message() 
{
	$from_user_id  = $this->input->post('from_user_id');
	$to_user_id    = $this->input->post('to_user_id');
	$message 	   = $this->input->post('message');
	$experience_id = $this->input->post('experience_id');

	$user_details_1 =  get_one_record('user','user_id',$from_user_id);

	$ins=array(
		'from_user_id' => $from_user_id,
		'to_user_id'   => $to_user_id,
		'experience_id'=> $experience_id,
		'message'	   => $message,
		);				
	$this->db->insert('sss_message',$ins);
	$id = $this->db->insert_id();

	if($id)
	{

		/**/

				//**************************
				//Push Notification START
				//**************************

		$notification_object = $this->db->select('*')->from('device_master')->where('user_id',$to_user_id)->get()->result_array();
		
		if(!empty($notification_object)){
			$alert_msg = "Message from ".$user_details_1->name;
			$message = $message;
			foreach($notification_object as $n){

				/*if($n['device_type'] == 'ANDROID'){
					$title = 'Barter Experience';
					$id = 'experience_id#' .$experience_id;
					$type = 'messageHost';
					sendPushNotificationAndroid($to_user_id,$n['device_id'], $type, $title, $message,"");
				}*/

				if($n['device_type'] == 'IOS'){

					$title = 'Experience Message';
					
					$type = 'messageHost';
					$user_name = get_one_user($from_user_id)->name;
					sendMsgPushNotificationIos_msg($to_user_id,$n['device_id'], $type, $title, $message,$from_user_id,$experience_id,$user_name,$alert_msg);
				}

			}
		}
		/**/

		$data['result']= array(
			"chat_id"		=> $id,
			"from_user_id"	=> $from_user_id,
			"to_user_id"	=> $to_user_id,
			"message"		=> $message,
			'experience_id' => $experience_id,
			"msg_date_time"	=> date('Y-m-d H:i:s')
			);

		$data['status'] = 'success';
		return $data;
	}
	else{
		$data['status'] = 'fail';
		$data['error']  = 'Insert not successfull.';
	}
}
/*
 * Function: get_api_chat_history 
 * Author: Binny
 * Date: 22/11/2017
 * Input: post array
 * Output: array 
*/
function get_api_chat_history() 
{
	$from_user_id = $this->input->post('from_user_id');
	$to_user_id   = $this->input->post('to_user_id');

	$limit  = $this->input->post('limit');
	$offset = $this->input->post('offset');

	if($limit!= '' && $offset!='') {
		$limit = "LIMIT $offset,$limit";
	} else {
		$limit = '';
	}		

	$query=$this->db->query("SELECT * FROM (SELECT * FROM  `sss_message` m WHERE (m.`from_user_id` = $from_user_id OR  m.`to_user_id` ='$from_user_id' ) AND (m.`from_user_id` ='$to_user_id' OR  m.`to_user_id` ='$to_user_id' )  ORDER BY m.`msg_date_time` ASC)r Where r.deleted_by = 0 ORDER BY `r`.`message_id` ASC $limit");	
	$num = $query->num_rows();
	
	if($num > 0) {
		$result['result'] = $query->result_array();
		$result['status'] = "success";
	} else {
		$result['status'] = "fail";
		$result['error']  = "No Record Found";
	}
	return $result;
}


/*
 * Function: check_user_activation 
 * Author: Binny
 * Date: 23/11/2017
 * Input:post uid,email_verification_code
 * Output: INT 
*/
function check_user_activation($uid=0,$email_verification_code='')
{
	$query = $this->db->query("SELECT * FROM  ".$this->db->dbprefix('user')." where email_verification_code='".$email_verification_code."' and user_id = '".$uid."' and verify_email = '0'");
    //echo $this->db->last_query();exit;
	if($query->num_rows()>0)
	{
		$data = array('verify_email'=>'1','status'=>'0');
		$this->db->where('user_id',$uid);
		$this->db->update('user',$data);
		return 1;
	}
	else 
	{
		return 0;
	}  
}


	/*
	 * Function: add_review 
	 * Author: Binny
	 * Date: 23/11/2018
	 * Input:post array
	 * Output: array 
	*/
	


	
	
	/*
	 * Function: check_api_login 
	 * Author: Binny
	 * Date: 23/11/2017
	 * Input: post array
	 * Output: array 
	*/
	function check_api_login()
	{
       
		//print_r(md5($this->input->post('password')));
		//$email 	  = $this->input->post('email');
		$mobileno = $this->input->post('mobileno');		
		$password = $this->input->post('password');		
		$data 	  = array();

		$query = $this->db->get_where('tbluser',array('UserContact'=>$mobileno,'UserPassword'=>md5($password)));
		//echo $this->db->last_query();die;
		if($query->num_rows() == 1)
		{			
			$user = $query->row_array();
			//echo "<pre>";print_r($headers['Accept-Language']);die;
			//$updata=array('user_lan'=>$headers['Accept-Language']);
			// $this->db->where('UserId',$user["UserId"]);
			// $this->db->update('tbluser',$updata);
			//echo "<pre>";print_r($user);die;

			if($user['IsActive']=='Active')
			{
				$data['status'] ='success';	
				$data['result'] = array(
					'email' 		=> trim($user['EmailAddress']),
					'full_name' 	=> trim($user['FullName']),				
					'mobileno'		=> trim($user['UserContact']),
					'user_id'		=> trim($user["UsersId"]),
					);
				return $data;		
			}
			else if($user['IsActive']=='Inactive'){
				$data['status'] ='fail';
				$data['error']  ='Your account is inactive. Please contact administrator!';
				return $data;
			}
			
		}
		else
		{
			$data['status'] = 'fail';
			$data['error']  = 'Invalid Mobile Number or Password';
			return $data;
			
			
		}
	}
	

	/*
	 * Function: user_experience_rating 
	 * Author: Binny
	 * Date: 23/11/2017
	 * Input: user_id
	 * Output: array 
	*/
	function user_experience_rating($user_id)
	{		
		$data=array();
    	//$user_id  = trim($this->input->post('user_id'));
		$query =  $this->db->query("SELECT round(AVG(r.`review_rating`)) as experience_rating
			FROM  `sss_experience_review` as r 
			JOIN sss_experience_master  e 
			ON r.experience_id = e.experience_id
			WHERE r.`given_user_id` ='".$user_id."'"
			);
		/****************** get experience rating of HOST only **************************************/
    	/*$query =  $this->db->query("SELECT round(AVG(r.`review_rating`)) as experience_rating
									FROM  `sss_experience_review` as r 
									JOIN sss_experience_master  e 
									ON r.experience_id = e.experience_id
									WHERE r.`given_user_id` ='".$user_id."'
									AND r.`given_user_id` = e.user_id"
									);*/
									/*******************************************************************************************/

									$data = $query->result_array();
									if($data[0]['experience_rating'] == NULL)
									{
										$data[0]['experience_rating'] = '0';
									}
									return $data;
								}


	/*
	 * Function: experience_avg_rating 
	 * Author: Binny
	 * Date: 23/11/2017
	 * Input: experience_id
	 * Output: array 
	*/
	function experience_avg_rating($experience_id)
	{
		$experience_detail = get_one_record('experience_master','experience_id',$experience_id);
		$data=array();
		//$user_id  = trim($this->input->post('user_id'));
		$query =  $this->db->query("SELECT round(AVG(r.`review_rating`)) as experience_avg_rating
			FROM  `sss_experience_review` as r 
			JOIN sss_experience_master  e 
			ON r.experience_id = e.experience_id
			WHERE r.`user_id` !='".$experience_detail->user_id."'
			AND r.experience_id ='".$experience_detail->experience_id."'");

		$data = $query->result_array();
		if($data[0]['experience_avg_rating'] == NULL)
		{
			$data[0]['experience_avg_rating'] = '0';
		}
		return $data;
	}
	
	function is_experience_has_booking($id)
	{
		$experience_detail = get_one_record('payment_history','experience_id',$id);
		if(empty($experience_detail))
		{
			return true;
		}else{
			return false;
		}
	}

	function check_booked_experience($user_id,$experience_id){
		
		$this->db->select('*');	
		$this->db->from('sss_experience_joinee');	
		$this->db->where('user_id =',$user_id); 
		$this->db->where('experience_id =',$experience_id); 
		$result_1 = $this->db->get()->result_array();	
		
		return $result_1;		

	}

	function check_booked_request($barter_given_user_id,$experience_id){
		
		$this->db->select('*');	
		$this->db->from('sss_barter_notification');
		$this->db->where('barter_given_user_id =',$barter_given_user_id);
		$this->db->where('barter_experience_id =',$experience_id);
		$result_1 = $this->db->get()->result_array();
		return $result_1;		

	}

	
	function send_push_status() {
		$user_id = $this->input->post('user_id');	
		$push_status = $this->input->post('push_status');		
		
		$data['push_send'] = $push_status;
		$this->db->where('user_id',$this->input->post('user_id'));
		$a = $this->db->update('user',$data);

		$data['status'] = "success";
		$data['msg'] = "push send status changed successfully";
		return $data;
	}

	function add_notification($experience_id,$user_id,$given_user_id,$is_read){

		$data = array(
			'barter_experience_id' => $experience_id,
			'barter_user_id' 	   => $user_id,
			'barter_given_user_id' => $given_user_id,
			'barter_status' 	   => $is_read,
			);
		
		$is_insert= insert_record('barter_notification',$data);
		return $is_insert;

	}

function get_all_servies(){
	$headers = apache_request_headers();	
	$data= array();
	$this->db->select('*');
	$this->db->from('services');	
	$this->db->order_by('services_id','asc');
	$query=$this->db->get();
	//echo $this->db->last_query();die;	

	foreach ($query->result_array() as $row) {
		if($headers['Accept-Language']=='en'){        	
			array_push($data, array('services_id' =>$row['services_id'],
			'service_name'=>$row['service_name']
			));				
		}else if($headers['Accept-Language']=='ar'){
			array_push($data, array('services_id' =>$row['services_id'],
			'service_name'=>$row['service_name_ar']
			));
		}
		else if($headers['Accept-Language']=='so'){
			array_push($data, array('services_id' =>$row['services_id'],
			'service_name'=>$row['service_name_so']
			));
		}else{
			array_push($data, array('services_id' =>$row['services_id'],
			'service_name'=>$row['service_name']
			));
		}
	}
	return $data;
}	
	
}	
?>