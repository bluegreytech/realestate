<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// --------------------------------------------------------------------

	/**
	 * Site Base Path
	 *
	 * @access	public
	 * @param	string	the Base Path string
	 * @return	string
	 */
	function base_path()
	{		
		$CI =& get_instance();
		return $base_path = $CI->config->slash_item('base_path');		
	}
	
	
	// --------------------------------------------------------------------

	/**
	 * Site Front Url
	 *
	 * @access	public
	 * @param	string	the Front Url string
	 * @return	string
	 */
	function front_base_url()
	{		
		$CI =& get_instance();
		return $base_path = $CI->config->slash_item('base_url_site');		
	}
	
	// --------------------------------------------------------------------

	/**
	 * Site Front ActiveTemplate
	 *
	 * @access	public
	 * @param	string	current theme folder name
	 * @return	string
	 */
	/* function get_rights($rights_name)
	{
		return true;
		$CI =& get_instance();
		$right_detail = $CI->db->get_where("rights",array('rights_name'=>trim($rights_name)));
		
		if($right_detail->num_rows()>0)
			{
			
				$right_result=$right_detail->row();
				$rights_id=$right_result->rights_id;

			$query=$CI->db->get_where("rights_assign",array('rights_id'=>$rights_id,'admin_id'=>$CI->session->userdata('admin_id')));
			
			if($query->num_rows()>0)
			{
				$result=$query->row();
				
				if($result->rights_set=='1' || $result->rights_set==1)
				{
					return 1;
				}
				else
				{
					return 0;
				}					
			}
			else
			{
				return 0;
			}	
		}
		else
		{
			return 0;		
		}
	
	}*/
	
	function getThemeName()
	{
		
		$default_theme_name='default';
		
		$CI =& get_instance();
		$query = $CI->db->get_where("template_manager",array('active_template'=>1 ,'is_admin_template'=>1));
		$row = $query->row();
		//echo "<pre>dfd ";print_r($row);die;
		$theme_name=trim($row->template_name);
		
		if(is_dir(APPPATH.'views/'.$theme_name))
		{
			return $theme_name;
		}
		else
		{
			return $default_theme_name;	
		}
		
	}

	
	// --------------------------------------------------------------------

	/**
	 * Check user login
	 *
	 * @return	boolen
	 */
	 
	function check_admin_authentication()
	{		
		$CI =& get_instance();
		
                
                if($CI->session->userdata('AdminId')!='')
                {
                    //check user active
                    $a_data = get_one_admin($CI->session->userdata('AdminId'));

                    if($a_data->IsActive == 'Active'){
                     return true;
                    }
                    else{
                        redirect('login/logout');
                    }
                }
                else
                {
                        return false;
                }
	
	}
    
	function get_one_admin($id)
	{
		$CI =& get_instance();
		$query = $CI->db->get_where('tbladmin',array('AdminId'=>$id));
		return $query->row();
	}	
	// --------------------------------------------------------------------

	/**
	 * get login user id
	 *
	 * @return	integer
	 */
	function get_authenticateadminID()
	{		
		$CI =& get_instance();
		return $CI->session->userdata('AdminId');
	}
	
	
	
	function checkSuperAdmin()
	{
		$CI =& get_instance();
		
			if($CI->session->userdata('admin_type')=='1')
			{
				return true;
			}
			else
			{
				return false;
			}
	}
	
	function get_first_day_of_week($date) 
	{
		 $day_of_week = date('N', strtotime($date)); 
		 $week_first_day = date('Y-m-d', strtotime($date . " - " . ($day_of_week - 1) . " days")); 
		 return $week_first_day;
	}

	
	function get_last_day_of_week($date)
	{
		 $day_of_week = date('N', strtotime($date)); 
		 $week_last_day = date('Y-m-d', strtotime($date . " + " . (7 - $day_of_week) . " days"));   
    	 return $week_last_day;
	}
	
	/************************************************report end****************************/
	
	/** send email
	 * @return	integer
	 */
	 
	function email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str)
	{
	
	   //echo $email_address_from;
	  // echo $email_address_reply;
	   //echo	$email_to;	
	  // echo $email_subject;	
	  // echo $str;

		$CI =& get_instance();
		$query = $CI->db->get_where("email_setting",array('email_setting_id'=>1));
		$email_set=$query->row();
		 			
									
		$CI->load->library(array('email'));
			
		///////====smtp====
		
		if($email_set->mailer=='mail')
		{
			// 	$config = Array(
			// 'protocol' => 'smtp',
			// 'smtp_host' => 'ssl://smtp.gmail.com',
			// 'smtp_port' => 465,
			// 'smtp_user' => 'jignesh.php.cbc@gmail.com',
			// 'smtp_pass' => 'jignesh@123',
			// 'mailtype'  => 'html', 
			// 'charset'   => 'iso-8859-1'
			// );
			$config['protocol']='smtp';  
			$config['smtp_host'] = trim("smtp.sendgrid.net");
            $config['smtp_port']=trim(465);  
            $config['smtp_user'] = trim("php.sanket@spaculus.info");
            $config['smtp_pass'] = trim("sanket@123");
		
			// $config['protocol']='smtp';  
			// $config['smtp_host']=trim($email_set->smtp_host);  
			// $config['smtp_port']=trim($email_set->smtp_port);  
			// $config['smtp_timeout']='30';  
			// $config['smtp_user']=trim($email_set->smtp_email);  
			// $config['smtp_pass']=trim($email_set->smtp_password);  
					
		}
		
		/////=====sendmail======
		
		elseif(	$email_set->mailer=='sendmail')
		{	

		
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = trim($email_set->sendmail_path);
			
		}
		 
		 
		/////=====php mail default======
		
		else
		{
			//echo "hello";die;
		 
		}
			
			
		$config['wordwrap'] = TRUE;	
		$config['mailtype'] = 'html';
		$config['crlf'] = "\n\n";
		$config['newline'] = "\r\n";
		
		$CI->email->initialize($config);
		 
		$CI->email->from($email_address_from,"Project Stand Up");
		$CI->email->reply_to($email_address_reply);
		$CI->email->to($email_to);
		$CI->email->subject($email_subject);
		$CI->email->message($str);
		$CI->email->send();
		// if($CI->email->send()){
		// 	//echo $CI->email->prin
		//    echo "send";
		// }else{
		// 		echo $CI->email->print_debugger();
		// }
	   //echo "<pre>"; print_r($CI->email->send()); die;

	}

	/**
	 * generate random code
	 *
	 * @return	string
	 */
	
	function randomCode()
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); 
		
		for ($i = 0; $i < 5; $i++) {
		$n = rand(0, strlen($alphabet)-1); //use strlen instead of count
		$pass[$i] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
	
	function randomnumericCODE()
	{
		$alphabet = "0123456789";
		$pass = array(); 
		
		for ($i = 0; $i < 5; $i++) {
		$n = rand(0, strlen($alphabet)-1); //use strlen instead of count
		$pass[$i] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	/**
	 * generate random code
	 *
	 * @return	string
	 */
	
	function randomCodeNew()
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
		$number = "0123456789";
		$pass = array(); 
		$q=rand(1,strlen($alphabet)-1);
		$pass[0] = $alphabet[$q];
		for ($i = 1; $i < 6; $i++) {
		$n = rand(0, strlen($number)-1); //use strlen instead of count
		$pass[$i] = $number[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
	/*** load site setting
	*  return single record array
	**/
	
	function site_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("site_setting");
		return $query->row();
	
	}
	function contact_us()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("contactus");
		return $query->row();
	
	}
	
	
	function membership_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("membership_setting");
		return $query->row();
	
	}
        
        function meta_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("meta_setting");
		return $query->row();
	
	}
	
	function paypal_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("sss_payment_setting");
		return $query->row();
	
	}
	
	function seo_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("Seosetting");
		return $query->row();
	
	}
	
	function image_setting()
	{	
	
		$CI =& get_instance();
		$query = $CI->db->get("image_setting");
		return $query->row();
	
	}
		
	function get_admin_name($id){
	
		$CI =& get_instance();
			$CI->db->select('first_name,last_name');
			$CI->db->where('admin_id',$id);
			$query=$CI->db->get('admin');
			if($query->num_rows()>0){
			return  ucwords($query->row()->first_name.' '.$query->row()->last_name);
		}else{
			return '';
		}
			
		
	}
	
	/*** get user name
	*  return string username
	**/
	
	function get_user_name($id){
	$CI =& get_instance();
		
			$CI->db->select('first_name,last_name,profile_image');
			$CI->db->where('user_id',$id);
			$query=$CI->db->get('user');
			if($query->num_rows()>0){
			return  $query->row();
		}else{
			return '';
		}
			
		
	}
		
	/****  create seo friendly url 
	* var string $text
	**/ 	  
  
  	function clean_url($text) 
	{ 
	
		$text=strtolower($text); 
		$code_entities_match = array( '&quot;' ,'!' ,'@' ,'#' ,'$' ,'%' ,'^' ,'&' ,'*' ,'(' ,')' ,'+' ,'{' ,'}' ,'|' ,':' ,'"' ,'<' ,'>' ,'?' ,'[' ,']' ,'' ,';' ,"'" ,',' ,'.' ,'_' ,'/' ,'*' ,'+' ,'~' ,'`' ,'=' ,' ' ,'---' ,'--','--','�'); 
		$code_entities_replace = array('' ,'-' ,'-' ,'' ,'' ,'' ,'-' ,'-' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-' ,'' ,'-' ,'-' ,'' ,'' ,'' ,'' ,'' ,'-' ,'-' ,'-','-'); 
		$text = str_replace($code_entities_match, $code_entities_replace, $text); 
		return $text; 
	} 
	function get_all_records($table)
	{
	 	$CI =& get_instance();
		//$query = $CI->db->get($table);
		$query = $CI->db->get_where($table,array('status'=>'Active'));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return 0;
		}
	}


	function getDuration($date)
	{
	
		$CI =& get_instance();

		$curdate = date('Y-m-d H:i:s');
		/*echo 'curdate'.$curdate.'<br>';
		echo 'date'.$date;die;*/
		
		$diff = abs(strtotime($date) - strtotime($curdate));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 )/ (60*60));
		$mins = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ (60));
		
		$ago = '';
		if($years != 0){ if($years > 1) {$ago = $years.' years';} else { $ago = $years.' year';}}
		elseif($months != 0){ if($months > 1) {$ago = $months.' months';} else { $ago = $months.' month';}}
		elseif($days != 0) { if($days > 1) {$ago = $days.' days';} else { $ago = $days.' day';}}
		elseif($hours != 0){ if($hours > 1) {$ago = $hours.' hours';} else { $ago = $hours.' hour';}}
		else{ if($mins > 1) {$ago = $mins.' minutes';} else { $ago = $mins.' minute';}}
		return $ago.' ago';
	}

	function get_all_countries()
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("country_code");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function getActiveCountry()
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("country_code",array('status'=>'Active'));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	function resize($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
	{
	    $info = @getimagesize($source_image);
	    $imgtype = image_type_to_mime_type($info[2]);

	    #assuming the mime type is correct
	    switch ($imgtype) {
	        case 'image/jpeg':
	            $source = imagecreatefromjpeg($source_image);
	            break;
	        case 'image/gif':
	            $source = imagecreatefromgif($source_image);
	            break;
	        case 'image/png':
	            $source = imagecreatefrompng($source_image);
	            break;
	        default:
	            die('Invalid image type.');
	    }

	    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
	    $src_w = imagesx($source);
	    $src_h = imagesy($source);


	    #Do some math to figure out which way we'll need to crop the image
	    #to get it proportional to the new size, then crop or adjust as needed

	    $x_ratio = $tn_w / $src_w;
	    $y_ratio = $tn_h / $src_h;

	    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
	        $new_w = $src_w;
	        $new_h = $src_h;
	    } elseif (($x_ratio * $src_h) < $tn_h) {
	        $new_h = ceil($x_ratio * $src_h);
	        $new_w = $tn_w;
	    } else {
	        $new_w = ceil($y_ratio * $src_w);
	        $new_h = $tn_h;
	    }

	    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
	    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
	    $final = imagecreatetruecolor($tn_w, $tn_h);
	    $backgroundColor = imagecolorallocate($final, 255, 255, 255);
	   //$backgroundColor = imagecolorallocate($final, 255, 255, 255);
	    imagefill($final, 0, 0, $backgroundColor);
	    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
	    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

	    #if we need to add a watermark
	    if ($wmsource) {
	        #find out what type of image the watermark is
	        $info    = getimagesize($wmsource);
	        $imgtype = image_type_to_mime_type($info[2]);

	        #assuming the mime type is correct
	        switch ($imgtype) {
	            case 'image/jpeg':
	                $watermark = imagecreatefromjpeg($wmsource);
	                break;
	            case 'image/gif':
	                $watermark = imagecreatefromgif($wmsource);
	                break;
	            case 'image/png':
	                $watermark = imagecreatefrompng($wmsource);
	                break;
	            default:
	                die('Invalid watermark type.');
	        }

	        #if we're adding a watermark, figure out the size of the watermark
	        #and then place the watermark image on the bottom right of the image
	        $wm_w = imagesx($watermark);
	        $wm_h = imagesy($watermark);
	        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

	    }
	    if (imagejpeg($final, $destination, $quality)) {
	        return true;
	    }
	    return false;
		
	}     
	
	function getOneAdmin($admin_id=0)
	{
		$CI =& get_instance();
		$query=$CI->db->get_where('admin',array('admin_id'=>$admin_id));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}else{
			return '';
		}
	}
	
	
	function getadminRights()
	{
		$CI =& get_instance();
		$CI->db->select('r.rights_name,ra.*');
		$CI->db->from('rights_assign ra');
		$CI->db->join('rights r','ra.rights_id=r.rights_id');
		$CI->db->where('ra.admin_id',get_authenticateadminID());
		$query=$CI->db->get();
		$r=array();
		if($query->num_rows() > 0)
		{
			$r=array();
			foreach ($query->result() as $value) {
				$r[trim($value->rights_name)]=$value;
			}
			return $r;
		}else{
			return $r;
		}
	}

	
	function pr($x='')
	{
		echo '<pre>';
		print_r($x);
		echo '</pre>';
	}
	
	/* Function for get lattitude and longitude of location */
	function getCoordinatesFromAddress($addr='',$city='',$state='',$country='' )
	{
		//$sQuery=$addr.'+'.$city.'+'.$state.'+'.$country;
		
		//$sURL = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false';
		$sQuery=$addr.'+'.$city;
		$sURL = '//maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false&region='.$country;
		
		$sData = file_get_contents($sURL);
		$data=json_decode($sData);
		$result=$data->results;
		
		
		if(isset($result[0]->geometry->location) && $result[0]->geometry->location!='')
		{
			$res=array('lat'=>$result[0]->geometry->location->lat,'lng'=>$result[0]->geometry->location->lng);
			return $res;
		}
		else
		{
			$res=array('lat'=>'','lng'=>'');
			return $res;
		}

	}
	
	function validate_image($image = NULL)
	{
        $file_name      =   $image['name'];
        $allowed_ext    =   array('jpg', 'jpeg', 'png', 'gif', 'bmp');
        $ext                =   strtolower(end(explode('.', $file_name)));
        $allowed_file_types =   array('image/jpeg','image/jpg','image/gif','image/png');
        $file_type              =   $image['type'];
        if(!in_array($ext, $allowed_ext) && !in_array($file_type, $allowed_file_types)) {
            
            return '<span>This file type is not allowed</span>';
        }else{
        	return '';
        }
    }
	
	/* Sate And City Code */
	function get_all_state_by_country_id($id=0)
		{
		$CI =& get_instance();
		$CI->db->where(array('status'=>'active','country_id'=>$id));
		$CI->db->order_by('state_name','asc');
		$query = $CI->db->get('state_master');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}else{
			return '';
		}
		}
	function get_all_city_by_state_id($id=0)
	{
		$CI =& get_instance();
		$CI->db->where(array('status'=>'active','state_id'=>$id));
		$CI->db->order_by('city_name','asc');
		$query = $CI->db->get('city_master');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}else{
			return '';
		}
	}
	 
        /* commom function for all module */
         //get all record count
    function get_total_count($table,$where='')
	{
		$CI =& get_instance();
		if($where != ''){ $CI->db->where($where);}
		$query=$CI->db->get($table);
		// echo $CI->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}else{ return 0; }
    }
        
        //get all record
    function get_result($limit,$offset,$table,$where='')
    { 
		$CI =& get_instance();
		if($where != ''){ $CI->db->where($where);}
		$CI->db->order_by('admin_id','desc');
		$query= $CI->db->get($table,$limit,$offset);
		//echo $CI->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{ return ''; }
    }
	function get_result_cu($limit,$offset,$table,$where='')
    { 
		$CI =& get_instance();
		if($where != ''){ $CI->db->where($where);}
		//  $CI->db->order_by('admin_id','desc');
		$query= $CI->db->get($table,$limit,$offset);
		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{ return ''; }
    }
		
	function get_result1($limit,$offset,$table,$where='')
	{ 
		$CI =& get_instance();
		if($where != ''){ $CI->db->where($where);}
		$CI->db->order_by('EmailTemplate_id','desc');
		$query= $CI->db->get($table,$limit,$offset);
		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{ return ''; }
	}
	function get_result2($limit,$offset,$table,$where='')
	{ 
		$CI =& get_instance();
		if($where != ''){ $CI->db->where($where);}
		$CI->db->order_by('pages_id','desc');
		$query= $CI->db->get($table,$limit,$offset);
		//echo $CI->db->last_query();die;
		if($query->num_rows()>0)
		{
		return $query->result();
		}else{ return ''; }
	}
        
    //get one record
    function get_one_record($table,$primaryfield,$id)
	{	
		$CI =& get_instance();
		$query = $CI->db->get_where($table,array($primaryfield=>$id));
		//echo $CI->db->last_query();die;
		return $query->row();
	}
		
		
        //check id exist
	function check_IdExit($table,$id,$val,$where='',$sp_table='')
	{

		$CI =& get_instance();
		if($where != ''){ $CI->db->where($where);}		        
		$query = $CI->db->get_where($table,array($id=>$val));
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
        
	  // Insert into table
	function insert_record($table,$data)
	{
	    $CI =& get_instance();
	    return $CI->db->insert($table, $data);
	}
	 function insert_record_api($table,$data)
	{
	    $CI =& get_instance();
	    $CI->db->insert($table, $data);
	   // //echo $CI->db->last_query();die; 
		return $CI->db->insert_id();
	}

	//update record
	 function update_record($table,$data,$primaryfield,$id)
	{
	    $CI =& get_instance();
	    $CI->db->where($primaryfield, $id);
	    $q = $CI->db->update($table, $data);
		//echo $CI->db->last_query();die;
	    return $q;
	}

	//delete record
	function delete_record($table,$primaryfield,$id)
	{
	    $CI =& get_instance();
	    $CI->db->where($primaryfield,$id);
	    $CI->db->delete($table);
	}
		
		
	function get_all_active_country()
	{
	 	$CI =& get_instance();
		$CI->db->order_by('country_name', 'asc');
		$query = $CI->db->get_where("country_master",array('status'=>'active'));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return 0;
		}
	}
	 
	
	 
	 
	 
	function get_all_active_categories()
	{
	 	$CI =& get_instance();
		$CI->db->order_by('category_name', 'asc');
		$query = $CI->db->get("category");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return 0;
		}
	}
        
	function get_category_name($id)
	{
		$CI =& get_instance();
		$query = $CI->db->select('category_name')->from('category')->where('category_id',$id)->get();
		return $query->row()->category_name;
	}
	
	function get_country_iso($country)
	{
		$CI =& get_instance();
		$query = $CI->db->select('country_iso')->from('country_master')->where('country_name',$country)->get();
		if($query->num_rows()>0){
			return $query->row()->country_iso;
		} else {
			return 0;
		}
	}

	function all_active_usertypes()
	{
		$CI =& get_instance();		
		$query = $CI->db->get_where("user_types",array('status'=>'Active'));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function getFarmClubName($farm_club_id)
	{
		$CI =& get_instance();		
		$query = $CI->db->select('farmClub_name')->from('farmClubs')->where('farmClub_id',$farm_club_id)->get();
		if($query->num_rows()>0){
			return $query->row()->farmClub_name;
		} else {
			return 0;
		}
	}
	/* end commom function for all module */
	function getMainRightsID($id)
	{
		$CI =& get_instance();

		$CI->db->select("*");
		$CI->db->from("rights_assign");
		$CI->db->where("admin_id",$id);
		$query = $CI->db->get();	
		$num = $query->num_rows();
		
		
		if($num > 0)
		{
			return $query->row_array();
		}
		else
		{
			return array();
		}
	}

	/* End of file custom_helper.php */
	/* Location: ./system/application/helpers/custom_helper.php */
	/*print_r function */
	function _p($data){

		echo "<pre>";
		print_r($data);
		echo "<pre>";
		
	}
	
	function get_result_page($limit,$offset,$table,$where='')
    { 
        	//echo "hello";die();
            $CI =& get_instance();
            if($where != ''){ $CI->db->where($where);}
            $query=$CI->db->get($table,$limit,$offset);
		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{ return ''; }
	 }

 	function get_champion_info($tablename,$fieldname,$id)
	{
		$CI =& get_instance();		
		$CI->db->select('*');
		$CI->db->from($tablename);
		$CI->db->where($fieldname,$id);
		$query = $CI->db->get();
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return '';
		}
		
	}
	
	function get_user_info($tablename,$fieldname,$id)
	{
		$CI =& get_instance();		
		$CI->db->select('*');
		$CI->db->from($tablename);
		$CI->db->where($fieldname,$id);
		$query = $CI->db->get();
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return '';
		}
		
	}
	function get_service_info($tablename,$fieldname,$id)
	{
		$CI =& get_instance();		
		$CI->db->select('*');
		$CI->db->from($tablename);
		$CI->db->where($fieldname,$id);
		$query = $CI->db->get();
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return '';
		}
		
	}

	function get_devices_info($tablename,$fieldname,$id)
	{
		$CI =& get_instance();		
		$CI->db->select('*');
		$CI->db->from($tablename);
		$CI->db->where($fieldname,$id);
		$query = $CI->db->get();
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return '';
		}
		
	}
	function get_booking_info($tablename,$fieldname,$id)
	{
		$CI =& get_instance();		
		$CI->db->select('*');
		$CI->db->from($tablename);
		$CI->db->where($fieldname,$id);
		$query = $CI->db->get();
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return '';
		}
		
	}
	
	function get_group_info($tablename,$fieldname,$id)
	{
		$CI =& get_instance();		
		$CI->db->select('*');
		$CI->db->from($tablename);
		$CI->db->where($fieldname,$id);
		$query = $CI->db->get();
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return '';
		}
		
	}
	
	function sendPushNotificationAndroid($type,$title,$message,$id,$booking_id='')
	{
				//	echo $message;die;
				$CI=& get_instance();
				$site_setting = site_setting();

				//print_r($id); die;
				// foreach($id  as $user_id) {
				//echo "<pre>";print_r($user_id);
		       	$select_user = $CI->db->query('SELECT * FROM '.$CI->db->dbprefix('device_master').' WHERE `device_type` =  "android" AND `login_status` =  "1" AND user_id='.$id.' GROUP BY `device_id`');	
           
	      		 //  echo "<pre>";print_r($CI->db->last_query()); die;

				if($select_user->num_rows() > 0)
				{
					$select_user = $select_user->result_array();
					//echo "<pre>";print_r($select_user); die;
				

					if(!empty($select_user)){
						foreach($select_user as $su)
						{ 
		                     // $su 
						  //echo "<pre>";print_r($select_user); die;
							// $select_setting = $CI->db->query('SELECT * FROM '.$CI->db->dbprefix('user_notifications_settings').' WHERE '.$su['user_id'].'');
							// if($select_setting->num_rows() > 0)
							// {
								//$send_notification=false;
								//$select_setting = $select_setting->row();
								// if($select_setting->notification==1)
								// {
									// $send_notification=true;	
									// if($send_notification)
									// {
									
					                  // $api_key = $site_setting->android_push_notification_token;
									// 	$singleID = $su['token_id'];
									// 	$notification = array(
									// 	'body' => $message,
									// 	'title' => $title,
									// 	'click_action' => 'com.app.projectstandup.signup.SignUpRequestSent
									// ',
									// 'vibrate' => 1,
									//'sound' => "default"
									// );
																	
									// $data = array(
									//'type' => $type,								
									//);
																	
									//$fcmFields = array(
									//'to' => $singleID,
									// 'priority' => 'high',
									// 'notification' => $notification,
									// 'data' => $data
									// );
						       //	echo $su['token_id'];die;
					                    $to = $su['token_id']; 
									// print_r($to);
										$api_key = $site_setting->android_push_notification_token;
										
										$registrationIds = array($to);
										$msg = array
										(
										'message' => $message,
										'title' => $title,
										'type' => $type,
										'vibrate' => 1,
										'sound' => 1,
										 'data'=>array("booking_id" => $booking_id,	
										  ) 
										// you can also add images, additionalData
										);
					                   //echo "<pre>";print_r($msg);
										$fields = array
										(
										'registration_ids' => $registrationIds,
										'data' => $msg,
										//'time_to_live' => '86400'
										);
					                   // echo "<pre>";print_r($fields);
										
										$headers = array
										(
											'Authorization: key=' . $api_key,
											'Content-Type: application/json'
										);
										$ch = curl_init();
										curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send'); //$site_setting->android_push_notification_url
										curl_setopt( $ch,CURLOPT_POST, true );
										curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
										curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
										curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
										curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
										$result = curl_exec($ch );
										//echo "<pre>";print_r($result); 
										curl_close( $ch );
									//}
								//}
							//}
						 }
						}
						//die;
						return true;
					}
					else
					{
						return false;
					}  	
	     // }
	      //die;
	}
	function sendPushNotificationIOS($type,$title,$message,$id,$booking_id='')
	{
		$CI=& get_instance();	

		$site_setting = site_setting();	
		//$select_user = $CI->db->query('SELECT * FROM '.$CI->db->dbprefix('device_master').' WHERE `device_type` =  "ios" AND `login_status` =  "1" AND user_id='.$id.' GROUP BY `device_id`');	

		$select_user = $CI->db->query('SELECT * FROM '.$CI->db->dbprefix('device_master').' WHERE `device_type` =  "ios" AND `login_status` = "1"  AND user_id='.$id.' GROUP BY `device_id`');

		if($select_user->num_rows() > 0)
		{
			$select_user = $select_user->result_array();
		
			if(!empty($select_user))
			{
				foreach($select_user as $su)
				{	
					if($send_notification)
					{
						$to = $su['token_id'];

						$to = str_replace(array("<",">"," "),'',$to);
					
						$ctx = stream_context_create();
						
						$passphrase = '123456';
						$pem_file = 'PnB_Live_ck.pem';
						$stream = 'ssl://gateway.push.apple.com:2195';
						
						
						stream_context_set_option($ctx, 'ssl', 'local_cert', base_path()."ipa/$pem_file");
						stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
						
						$fp = stream_socket_client(
								$stream, $err,
								$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
						
						
						if (!$fp)
							exit("Failed to connect: $err $errstr" . PHP_EOL);
						
						$sound =  'default'; //'push_sound.wav';
							
						$body['aps'] = array(
								'alert' => $message,
								'type' => $type,
								'sound' => $sound,
								'data'=>array("booking_id" => $booking_id,	
								  ) 
								);
								
						$body['title'] = $title;								
						
						$payload = json_encode($body);
						
						$msg = chr(0) . pack('n', 32) . pack('H*', $to) . pack('n', strlen($payload)) . $payload;
						
						$result = fwrite($fp, $msg, strlen($msg));						
						fclose($fp);
					}
				}
				return true;
			}else{
				return false;
			}
		}
	}
	function get_all_active_services()
	{
		//echo "hello";die;
		$CI =& get_instance();		
		$CI->db->order_by('services_id', 'asc');
		$query = $CI->db->get_where("services",array('status'=>'active'));
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	function get_all_active_champion()
	{
		//echo "hello";die;
		$CI =& get_instance();		
		$CI->db->order_by('chmp_id', 'asc');
		$query = $CI->db->get_where("champion",array('status'=>'active'));
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	function get_all_languages()
	{
		//echo "hello";die;
		$CI =& get_instance();		
		$CI->db->order_by('id', 'asc');
		$query = $CI->db->get_where("translate_lan");
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}

	function get_all_cities()
	{
		//echo "hello";die;
		$CI =& get_instance();		
		$CI->db->order_by('cities_id', 'asc');
		$query = $CI->db->get_where("cities");
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}

	function get_page_by_slug($slug=null,$id=0)
	{
		$CI =& get_instance();
		$query=$CI->db->get_where('pages',array('slug'=>$slug));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return '';

	}

	function booking_valid($monday){
		$CI =& get_instance();
		$query=$CI->db->get_where('booking_control');
		if($query->num_rows() > 0)
		{
			$days='';
			// echo "<pre>";print_r($query->row());die;
              $result=$query->row();

			switch ($monday) {
				case "Monday":
					$days=$result->bk_mon;
				break;
				case "Tuesday":
					$days=$result->bk_tue;
				break;
				case "Wednesday":
					$days=$result->bk_wed;
				break;
				case "Thursday":
					$days=$result->bk_thu;
				break;
				case "Friday":
					$days=$result->bk_fri;
				break;
				case "Saturday":
					$days=$result->bk_sat;
				break;
				case "Sunday":
					$days=$result->bk_sun;
				break;
	        
   		    }
           return $days;
		}
		//eturn '';

	}


	function booking_duration(){
		$CI =& get_instance();
		$query=$CI->db->get_where('booking_control');
		if($query->num_rows() > 0)
		{
			//$days='';
			// echo "<pre>";print_r($query->row());die;
             return $result=$query->row();
		}
		return '';

	}

	function get_all_problemtype()
	{
		//echo "hello";die;
		$CI =& get_instance();		
		$CI->db->order_by('ptype_id', 'asc');
		$query = $CI->db->get_where("problem_type");
		//echo $CI->db->last_query();die;
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}


?>