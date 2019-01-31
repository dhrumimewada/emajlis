<?php
require APPPATH . '/libraries/REST_Controller.php';
error_reporting(1);
class Rest_api extends REST_Controller{
    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');  
        $this->load->model('Admin_model');
    }

    public function init_get($app_version = '',$type = ''){

        $postFields['app_version'] = $app_version;        
        $postFields['type'] = $type;               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost)){

            $MaintenanceMode = (array)$this->db->get_where('app_settings',array('name' => 'MaintenanceMode'))->row();
            $AppVersion = (array)$this->db->get_where('app_settings',array('name' => $type))->row();
            //$response['data'] = $AppVersion;
            $current_version = (Int)str_replace('.', '',$AppVersion['version']);
            $app_version = (Int)str_replace('.', '', $app_version);

            if($MaintenanceMode['updated_status'] == 1){
                $response['status'] = false;
                $response['update'] = false;
                $response['maintenance'] = true;
                $response['message'] = 'Server under maintenance, please try again after some time';
            }
            else if($app_version < $current_version && $AppVersion['updated_status'] == 0){
                $response['status'] = true;
                $response['update'] = false;
                $response['message'] = 'Emajlis app new version available';
            }
            else if($app_version < $current_version && $AppVersion['updated_status'] == 1){
                $response['status'] = false;
                $response['update'] = true;
                $response['message'] = 'Emajlis app new version available, please upgrade your application';
            }
            else{
                $response['status'] = true;
            }

        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }

        $this->response($response);
    }
    
    public function otp_verified_post(){

        $postFields['member_id'] = $_POST['member_id'];                 
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            
            }else{
                $data = array(
                    'otp_verified' => 1
                     );
                $this->db->where('id',$_POST['member_id']);
                if($this->db->update('member',$data)){

                    $to =  array($user['email']);
                    $subject = $this->config->item('header').' - Welcome';

                    $path = BASE_URL().'email_template/welcome.php';
                    $template = file_get_contents($path);
                    $template = $this->create_email_template2($template);
                    $mail = $this->send_mail2($to,$subject,$template);

                    $response['mail'] = $mail;
                    $response['status'] = true;
                    $response['profile'] = $user;
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }
                
            }
            
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }

        
        $this->response($response);
    }

    public function send_mail2($to,$subject,$message){

        $from = '"Emajlis" <excellentwebworld@admin.com>';

        $config['protocol'] = $this->config->item("protocol");
        $config['smtp_host'] = $this->config->item("smtp_host");
        $config['smtp_port'] = $this->config->item("smtp_port");
        $config['smtp_user'] = $this->config->item("smtp_user");
        $config['smtp_pass'] = $this->config->item("smtp_pass");
        $config['charset'] = $this->config->item("charset");
        $config['mailtype'] = $this->config->item("mailtype");
        $config['wordwrap'] = TRUE;

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject); 
        $this->email->message($message);
        if($this->email->send()){
            return TRUE;
        }else{
            return FALSE;
        }
        //echo $this->email->print_debugger();exit;
    }

    public function create_email_template2($template){
       $base_url = BASE_URL();
       $template = str_replace('##SITEURL##', $base_url, $template);
       // $template = str_replace('##SITENAME##', $this->config->item('site_name'), $template);
       // $template = str_replace('##SITEEMAIL##', $this->config->item('site_email'), $template);
       // $template = str_replace('##COPYRIGHTS##', $this->config->item('copyrights'), $template);
       // $template = str_replace('##EMAILTEMPLATELOGO##', $this->config->item('email_template_logo'), $template);
       return $template;
    }

    public function login_post(){
        // $response['post'] = $_POST;
        // $response['json'] = file_get_contents('php://input');
        $postFields['email'] = $_POST['email'];        
        $postFields['password'] = $_POST['password']; 
        $postFields['device_token'] = $_POST['device_token']; 
        $postFields['device_type'] = $_POST['device_type'];
        $postFields['lat'] = $_POST['lat'];
        $postFields['lang'] = $_POST['lang'];                
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('email' => $_POST['email'],'password' => md5($_POST['password']),'status' => 1,'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'The email/password that you have entered is incorrect';
            
            }else{

            	if($user['otp_verified'] == 0){
	            	$digits = 4;
	                $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
	                $from = '"Emajlis" <excellentwebworld@admin.com>';
	                $to =  array($_POST['email']);
	                $subject = "Emajlis Login - OTP";
	                $message = "Hello ".$user['fullname'].",<br><br>"; 
	                $message .= "Your OTP is <h2>".$otp."</h2><br>"; 
	                
	                $message .= "<br><br>Thanks<br>"."\n"; 
	                $message .= "Emajlis Team"."\n"; 
	 
	                $config['protocol'] = $this->config->item("protocol");
	                $config['smtp_host'] = $this->config->item("smtp_host");
	                $config['smtp_port'] = $this->config->item("smtp_port");
	                $config['smtp_user'] = $this->config->item("smtp_user");
	                $config['smtp_pass'] = $this->config->item("smtp_pass");
	                $config['charset'] = $this->config->item("charset");
	                $config['mailtype'] = $this->config->item("mailtype");
	                $config['wordwrap'] = TRUE;

                    $subject = $this->config->item('site_name').' - OTP verification';
                    $path = BASE_URL().'email_template/otp.html';
                    $template = file_get_contents($path); 


                    $template = str_replace('##OTP##', $otp, $template);
                    $template = $this->create_email_template($template); 

	                $this->load->library('email', $config);
	                $this->email->initialize($config);
	                $this->email->set_newline("\r\n");
	                $this->email->from($from);
	                $this->email->to($to);
	                $this->email->subject($subject);
	                $this->email->message($template); 

	                if($this->email->send()){
	                	// update otp in DB
	                	$data = array('otp' => $otp	);
	                	$this->db->where('id', $user['id']);
	                	$this->db->update('member', $data);

	                	$response['status'] = true;
                    	$response['email_verified'] = false;
                    	$response['opt_mail_send'] = true;
                    	$response['otp'] = $otp;
                    	$response['profile'] = $user;

	                }else{

	                	$response['status'] = false;
                    	$response['profile'] = 'Error into sending OTP mail';

	                }
            	}else{

                    // 
            		$response['status'] = true;
	                $response['profile'] = $user;
	                $response['email_verified'] = true;

            	}

                $response['interests_added'] = TRUE;
                $where = array('member_id' => $user['id']);
                $interests = $this->db->get_where('member_interests',$where)->result_array();

                if(empty($interests)){
                    $response['interests_added'] = FALSE;
                }


                $data = array(
                    'device_type' => $_POST['device_type'],
                    'device_token' => $_POST['device_token'],
                    'lat' => $_POST['lat'],
                    'lang' => $_POST['lang']
                     );
                $this->db->where('id',$user['id']);
                $this->db->update('member',$data);

            }
            
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }

        
        $this->response($response);
    }

    public function resend_otp_post(){
        $postFields['email'] = $_POST['email'];                 
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost)){
            $where = array('email' => $_POST['email'], 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();

            if(empty($user)){

                $response['status'] = false;
                $response['message'] = 'User not found';

            }else{

                $digits = 4;
                $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
                $from = '"Emajlis" <excellentwebworld@admin.com>';
                $to =  array($_POST['email']);
                $subject = "Emajlis - OTP";
                $message = "Hello ".$user['fullname'].",<br><br>"; 
                $message .= "Your OTP is <h2>".$otp."</h2><br>"; 
                
                $message .= "<br><br>Thanks<br>"."\n"; 
                $message .= "Emajlis Team"."\n"; 
 
                $config['protocol'] = $this->config->item("protocol");
                $config['smtp_host'] = $this->config->item("smtp_host");
                $config['smtp_port'] = $this->config->item("smtp_port");
                $config['smtp_user'] = $this->config->item("smtp_user");
                $config['smtp_pass'] = $this->config->item("smtp_pass");
                $config['charset'] = $this->config->item("charset");
                $config['mailtype'] = $this->config->item("mailtype");
                $config['wordwrap'] = TRUE;

                $subject = $this->config->item('site_name').' - OTP verification';
                $path = BASE_URL().'email_template/otp.html';
                $template = file_get_contents($path); 


                $template = str_replace('##OTP##', $otp, $template);
                $template = $this->create_email_template($template); 

                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($template); 

                if($this->email->send()){
                    $data = array('otp' => $otp );
                    $this->db->where('id', $user['id']);
                    $this->db->update('member', $data);

                    $response['status'] = true;
                    $response['opt_mail_send'] = true;
                    $response['otp'] = $otp;
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Error into sending mail. Try again later';
                }
                
            }
        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function register_post(){
        // $response['post'] = $_POST;
        // $response['json'] = file_get_contents('php://input');
        $postFields['fullname'] = $_POST['fullname'];        
        $postFields['email'] = $_POST['email'];        
        $postFields['password'] = $_POST['password']; 
        $postFields['device_token'] = $_POST['device_token']; 
        $postFields['device_type'] = $_POST['device_type'];
        $postFields['phone_no'] = $_POST['phone_no'];  
        $postFields['gender'] = $_POST['gender'];  
        $postFields['lat'] = $_POST['lat'];
        $postFields['lang'] = $_POST['lang'];        

        $errorPost = $this->ValidatePostFields($postFields);  
        if(empty($errorPost)){

            $where = array('email' => $_POST['email'], 'deleted_at' => NULL);
            $user_exists = (array)$this->db->get_where('member',$where)->row();

            if(empty($user_exists)){

                $social_user_exists = array();
                if(isset($_POST['social_id']) && $_POST['social_id'] != "" && isset($_POST['social_type']) && $_POST['social_type'] != "0" && !is_null($_POST['social_id']) && !is_null($_POST['social_type'])){
                    $where = array('social_id' => $_POST['social_id'], 'social_type' => $_POST['social_type']);
                    $social_user_exists = (array)$this->db->get_where('member_extrainfo',$where)->row();
                }

                // echo "<pre>";
                // print_r($social_user_exists);
                // exit;

                if(empty($social_user_exists)){
                    $google_api_key = $this->config->item("google_api_key");
                    $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$_POST['lat'].','.$_POST['lang'].'&key='.$google_api_key);
                    $output = json_decode($geocodeFromLatLong);
                    $status = $output->status;

                    //Get address from json data
                    $address = ($status=="OK")?$output->results[1]->formatted_address:'';
                    // print_r($address);
                    // exit;

                    $user = array( 
                        'fullname' => ucwords($_POST['fullname']), 
                        'email'=> $_POST['email'], 
                        'password' => md5($_POST['password']),
                        'device_token'=> $_POST['device_token'], 
                        'device_type'=> $_POST['device_type'], 
                        'phone_no'=> $_POST['phone_no'],
                        'gender'=> $_POST['gender'],
                        'lat'=> $_POST['lat'],
                        'lang'=> $_POST['lang'],
                        'address'=> $address
                    );
                   
                    $this->db->insert('member', $user);
                    $insert_id = $this->db->insert_id();

                    if($insert_id){
                        $user = array( 
                            'member_id' => $insert_id
                        );
                        if(isset($_POST['linkedin_link']) && $_POST['linkedin_link'] != ""){
                            $user['linkedin_link'] = $_POST['linkedin_link'];
                        }
                        if(isset($_POST['social_id']) && $_POST['social_id'] != "" && isset($_POST['social_type']) && $_POST['social_type'] != "0" && !is_null($_POST['social_id']) && !is_null($_POST['social_type'])){
                            $user['social_id'] = $_POST['social_id'];
                            $user['social_type'] = $_POST['social_type'];
                        }

                        $this->db->insert('member_extrainfo', $user);

                        $where = array('id' => $insert_id);
                        $user_data = (array)$this->db->get_where('member',$where)->row();

                        $user_data['id'] = (string)$user_data['id'];
                        $user_data['phone_no'] = (string)$user_data['phone_no'];

                                 

                        $digits = 4;
		                $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
		                $from = '"Emajlis" <excellentwebworld@admin.com>';
		                $to =  array($_POST['email']);
		                $subject = "Emajlis - OTP";
		                $message = "Hello ".$user_data['fullname'].",<br><br>"; 
		                $message .= "Your OTP is <h2>".$otp."</h2><br>"; 
		                
		                $message .= "<br>Thanks<br>"."\n"; 
		                $message .= "Emajlis Team"."\n"; 
		 
		                $config['protocol'] = $this->config->item("protocol");
		                $config['smtp_host'] = $this->config->item("smtp_host");
		                $config['smtp_port'] = $this->config->item("smtp_port");
		                $config['smtp_user'] = $this->config->item("smtp_user");
		                $config['smtp_pass'] = $this->config->item("smtp_pass");
		                $config['charset'] = $this->config->item("charset");
		                $config['mailtype'] = $this->config->item("mailtype");
		                $config['wordwrap'] = TRUE;

                        $subject = $this->config->item('site_name').' - OTP verification';
                        $path = BASE_URL().'email_template/otp.html';
                        $template = file_get_contents($path); 


                        $template = str_replace('##OTP##', $otp, $template);
                        $template = $this->create_email_template($template); 
                       // $this->send_mail($email,$subject,$template);

		                $this->load->library('email', $config);
		                $this->email->initialize($config);
		                $this->email->set_newline("\r\n");
		                $this->email->from($from);
		                $this->email->to($to);
		                $this->email->subject($subject);
                        //$this->email->message($message); 
		                $this->email->message($template); 
		                if($this->email->send()){
		                	// update otp in DB
		                	$data = array('otp' => $otp	);
		                	$this->db->where('id', $insert_id);
		                	$this->db->update('member', $data);

		                	$response['status'] = true;
                        	$response['profile'] = $user_data;
                        	$response['otp'] = $otp;
		                }else{

		                	$response['status'] = false;
                        	$response['profile'] = 'Error into sending mail. please try again later';

		                }

                    }else{
                        $response['status'] = false;
                        $response['profile'] = 'Error into register. please try again later';
                    }

                }else{
                        $response['status'] = false;
                        $response['profile'] = 'This linkedin account already used buy another account.';
                }

            }else{
                $response['status'] = false;
                $response['message'] = 'Email id is already in use';
            }
        }else{
            $response['status'] = false;
            $response['message'] = $errorPost; 
        }

        $this->response($response);
    }

    public function send_mail($to,$subject,$message){
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = $this->config->item('smtp_user');
        $config['smtp_pass'] = $this->config->item('smtp_pass');
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        $this->email->from($this->config->item('from'),$this->config->item('header'));
        //$to = array('developer.eww@gmail.com');
        $this->email->to($to);
        // $this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
        $this->email->subject($subject);
        $this->email->message($message);
        //$this->email->attach('http://example.com/filename.pdf');
        //$this->email->attach('/path/to/photo3.jpg');
        $this->email->send();
        echo $this->email->print_debugger();
        exit;
    }

    public function create_email_template($template){
       $base_url = BASE_URL();
       $template = str_replace('##SITEURL##', $base_url, $template);
       $template = str_replace('##SITENAME##', $this->config->item('site_name'), $template);
       $template = str_replace('##SITEEMAIL##', $this->config->item('site_email'), $template);
       $template = str_replace('##COPYRIGHTS##', $this->config->item('copyrights'), $template);
       $template = str_replace('##EMAILTEMPLATELOGO##', $this->config->item('email_template_logo'), $template);
       return $template;
    }

    public function interest_get(){
        $hashtag = (array)$this->db->get('hashtag')->result_array();
        if(empty($hashtag)){
            $response['status'] = false;
            $response['message'] = 'No any interest field found';
        
        }else{
            $response['status'] = true;
            $response['interest'] = $hashtag;
        }
        $this->response($response);
    }

    public function save_interest_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['interest'] = $_POST['interest'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'], 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            
            }else{
                $where = array('member_id' => $_POST['member_id']);
                $this->db->delete('member_interests',$where);

                $interests_data = explode(',',$_POST['interest']);
                foreach ($interests_data as $key => $value) {
                    $data = array('member_id' => intval($_POST['member_id']), 'hashtag_id' => intval($value));
                    $this->db->insert('member_interests', $data);
                }
                $response['status'] = true;
                $response['message'] = 'Hashtag saved';
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function change_password_post(){
        $postFields['current_password'] = $_POST['current_password'];        
        $postFields['new_password'] = $_POST['new_password']; 
        $postFields['confirm_new_password'] = $_POST['confirm_new_password']; 
        $postFields['member_id'] = $_POST['member_id']; 

        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'deleted_at' => NULL, 'password' => md5($_POST['current_password']));
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'Your current password is incorrect';
            }else{
                $data = array('password' => md5($_POST['new_password']) );
                $this->db->where('id',$_POST['member_id']);
                if($this->db->update('member',$data)){
                    $response['status'] = true;
                    $response['message'] = 'Password changed successfully';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }
                
            }
            
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function forgot_password_post(){
        $postFields['email'] = $_POST['email']; 

        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('email' => $_POST['email'],'status' => '1', 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            }else{
                $link = base_url()."reset-password/".md5($user['id']);
                //$from = "excellentwebworld@admin.com";
                $from = '"Emajlis" <excellentwebworld@admin.com>';
                $to =  array($this->input->post("email"));
                $subject = "Reset your emajlis password";
                $message = "Hello ".$user['fullname'].",<br><br>"; 
                $message .= "We heard that you lost your Emajlis password, But do not worry! <br>"; 
                $message .= "You can use this "; 
                $message .= '<a href="'.$link.'">Link</a> ';
                $message .= "to reset your password.";
                $message .= "<br><br>Thanks<br>"."\n"; 
                $message .= "Emajlis Team"."\n"; 
 
                $config['protocol'] = $this->config->item("protocol");
                $config['smtp_host'] = $this->config->item("smtp_host");
                $config['smtp_port'] = $this->config->item("smtp_port");
                $config['smtp_user'] = $this->config->item("smtp_user");
                $config['smtp_pass'] = $this->config->item("smtp_pass");
                $config['charset'] = $this->config->item("charset");
                $config['mailtype'] = $this->config->item("mailtype");
                $config['wordwrap'] = TRUE;

                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from($from);
                $this->email->to($to);
                $this->email->subject($subject);
                $this->email->message($message);
                if($this->email->send()){

                    $data = array('remember_token' => md5($user['id']) );
                    $this->db->where('email',$_POST['email']);
                    $this->db->update('member',$data);

                    $response['status'] = true;
                    $response['message'] = 'Reset password link sent to your email address';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Error into sending mail';
                }
            }
            
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function myprofile_post(){

        $postFields['member_id'] = $_POST['member_id']; 

        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost)){

            $user = array();
            $sql_select = array("t1.*", "t2.social_id", "t2.social_type", "t2.linkedin_link" , "t2.twitter_link", "t2.instagram_link", "t2.website_link");
            $this->db->select($sql_select);
            $this->db->where("t1.status", 1);
            $this->db->where("t1.deleted_at", NULL);
            $this->db->where("t1.id", $_POST['member_id']);
            $this->db->from('member t1');
            $this->db->join('member_extrainfo t2', 't1.id = t2.member_id', "left join");
            $sql_query = $this->db->get();
            if ($sql_query->num_rows() > 0) {
                $user = $sql_query->row();
            }

            $previous_organization = array();
            $this->db->select('*');
            $this->db->where("member_id", $_POST['member_id']);
            $this->db->from('previous_organization');
            $sql_query = $this->db->get();
            if ($sql_query->num_rows() > 0) {
                $previous_organization = $sql_query->result_array();
            }

            $education = array();
            $this->db->select('*');
            $this->db->where("member_id", $_POST['member_id']);
            $this->db->from('education');
            $sql_query = $this->db->get();
            if ($sql_query->num_rows() > 0) {
                $education = $sql_query->result_array();
            }

            $member_interests = array();
            $sql_select = array("t1.member_id", "t2.*");
            $this->db->select($sql_select);
            $this->db->where("t1.member_id", $_POST['member_id']);
            $this->db->from('member_interests t1');
            $this->db->join('hashtag t2', 't1.hashtag_id = t2.id', "left join");
            $sql_query = $this->db->get();
            if ($sql_query->num_rows() > 0) {
                $member_interests = $sql_query->result_array();
            }

            $user_goal = array();
            $this->db->select('*');
            $this->db->where("member_id", $_POST['member_id']);
            $this->db->from('member_goal');
            $sql_query = $this->db->get();
            if ($sql_query->num_rows() > 0) {
                $user_goal = $sql_query->result_array();
            }

            $favorite_ways_meeting = array();
            $sql_select = array("t2.*");
            $this->db->select($sql_select);
            $this->db->where("t1.member_id", $_POST['member_id']);
            $this->db->from('member_meeting_preferences t1');
            $this->db->join('meeting_preferences t2', 't1.meeting_preference_id = t2.id', "left join");
            $sql_query = $this->db->get();
            if ($sql_query->num_rows() > 0) {
                $favorite_ways_meeting = $sql_query->result_array();
            }

            $industry = array();
            $sql_select = array("t2.*");
            $this->db->select($sql_select);
            $this->db->where("t1.member_id", $_POST['member_id']);
            $this->db->from('member_industry t1');
            $this->db->join('industry t2', 't1.industry_id = t2.id', "left join");
            $sql_query = $this->db->get();
            if ($sql_query->num_rows() > 0) {
                $industry = $sql_query->result_array();
            }

            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            }else{
                $response['status'] = true;
                $response['profile'] = $user;
                $response['education'] = $education;
                $response['previous_organization'] = $previous_organization;
                $response['member_interests'] = $member_interests;
                $response['goal'] = $user_goal;
                $response['favorite_ways_meeting'] = $favorite_ways_meeting;
                $response['industry'] = $industry;
            }
        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }

        $this->response($response);
    }

    public function save_name_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['fullname'] = $_POST['fullname'];               
        $postFields['gender'] = $_POST['gender'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1', 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            }else{
                $data = array('fullname' => $_POST['fullname'], 'gender' => $_POST['gender']);
                $this->db->where('id',$_POST['member_id']);
                if($this->db->update('member',$data)){
                    $response['status'] = true;
                    $response['message'] = 'Name updated';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                } 
            }  
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function location_preference_get(){
        $meeting_preferences = (array)$this->db->get('meeting_preferences')->result_array();
        if(empty($meeting_preferences)){
            $response['status'] = false;
            $response['message'] = 'No any favorite places found';
        
        }else{
            foreach ($meeting_preferences as $key => $value) {
                if($value['image_name'] == ''){
                    $meeting_preferences[$key]['image_name'] = 'default.png';
                }
            }
            $response['status'] = true;
            $response['all_favorite_ways'] = $meeting_preferences;
        }
        $this->response($response);
    }

    public function save_location_preference_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['favorite_ways_to_meet'] = $_POST['favorite_ways_to_meet'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $where = array('member_id' => $_POST['member_id']);
                $this->db->delete('member_meeting_preferences',$where);

                $favorite_data = explode(',',$_POST['favorite_ways_to_meet']);
                foreach ($favorite_data as $key => $value) {
                    $data = array('member_id' => intval($_POST['member_id']), 'meeting_preference_id' => intval($value));
                    $this->db->insert('member_meeting_preferences', $data);
                }

                $response['status'] = true;
                $response['message'] = 'Favorite ways to meet saved';
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function industry_get(){
        $industry = (array)$this->db->get('industry')->result_array();
        if(empty($industry)){
            $response['status'] = false;
            $response['message'] = 'No any industry found';
        
        }else{
            foreach ($industry as $key => $value) {
                $industry[$key]['id'] = (string)$value['id'];
            }
            $response['status'] = true;
            $response['industry'] = $industry;
        }
        $this->response($response);
    }

    public function save_industry_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['industry'] = $_POST['industry'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $where = array('member_id' => $_POST['member_id']);
                $this->db->delete('member_industry',$where);

                $industry_data = explode(',',$_POST['industry']);
                foreach ($industry_data as $key => $value) {
                    $data = array('member_id' => intval($_POST['member_id']), 'industry_id' => intval($value));
                    $this->db->insert('member_industry', $data);
                }

                $response['status'] = true;
                $response['message'] = 'Industry saved';
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function prev_organization_post(){
        $postFields['member_id'] = $_POST['member_id']; 
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = $this->db->get_where('member',$where)->result_array();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';  
            }else{
                $where = array('member_id' => intval($_POST['member_id']));
                $previous_organization = $this->db->get_where('previous_organization',$where)->result_array();
                $response['status'] = true;
                $response['previous_organization'] = $previous_organization;
            }

        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function goal_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost)){
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $goal = array();
                $goal_array = array();
                $this->db->select('name');
                $this->db->from('looking_for');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0){
                    $goal = $sql_query->result_array();
                    foreach ($goal as $key => $value) {
                        array_push($goal_array,$value);
                    }
                }


                $this->db->select('name');
                $this->db->where('member_id',intval($_POST['member_id']));
                $this->db->from('member_goal');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0){
                    $user_goals = $sql_query->result_array();
                    foreach ($user_goals as $key => $value) {
                       if(!in_array($value['name'], array_column($goal_array, 'name')))
                       {
                            array_push($goal_array,$value);
                       }
                    }
                }

                if(empty($goal_array)){
                    $response['status'] = false;
                    $response['message'] = 'No any goal found';
                
                }else{
                    $response['status'] = true;
                    $response['goal'] = $goal_array;
                }
            }

        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);


        
        if(empty($goal)){
            $response['status'] = false;
            $response['message'] = 'No any goal found';
        
        }else{
            $response['status'] = true;
            $response['goal'] = $goal;
        }
        $this->response($response);
    }

    public function save_goal_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['goal'] = $_POST['goal'];               
        // $postFields['goal_description'] = $_POST['goal_description'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $where = array('member_id' => $_POST['member_id']);
                $this->db->delete('member_goal',$where);

                $goal_data = explode(',',$_POST['goal']);
                foreach ($goal_data as $key => $value) {
                    $data = array('member_id' => intval($_POST['member_id']), 'name' => $value);
                    $this->db->insert('member_goal', $data);
                }

                if(isset($_POST['goal_description']) && $_POST['goal_description'] != ''){
                    $data_desc = array('goal_description' => $_POST['goal_description']);
                    $this->db->where('id',$_POST['member_id']);
                    $this->db->update('member',$data_desc);
                }

                $response['status'] = true;
                $response['message'] = 'Goal saved';
               
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function add_prev_organization_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['organization_name'] = $_POST['organization_name'];               
        $postFields['designation'] = $_POST['designation'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1', 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            }else{
                $data = array('member_id' => $_POST['member_id'], 'organization_name' => $_POST['organization_name'],'designation' => $_POST['designation']);
                if($this->db->insert('previous_organization',$data)){
                    $response['status'] = true;
                    $response['message'] = 'Previous organization added';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                } 
            }  
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function save_prev_organization_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['organization_id'] = $_POST['organization_id'];        
        $postFields['organization_name'] = $_POST['organization_name'];               
        $postFields['designation'] = $_POST['designation'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1', 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            }else{


                $data = array('organization_name' => $_POST['organization_name'],'designation' => $_POST['designation']);
                $this->db->where('member_id',$_POST['member_id']);
                $this->db->where('id',$_POST['organization_id']);
                if($this->db->update('previous_organization',$data)){
                    $response['status'] = true;
                    $response['message'] = 'Previous organization saved';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                } 
            }  
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function delete_prev_organization_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['organization_id'] = $_POST['organization_id'];                           
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1', 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';
            }else{

                $this->db->where('member_id',$_POST['member_id']);
                $this->db->where('id',$_POST['organization_id']);
                if($this->db->delete('previous_organization')){
                    $response['status'] = true;
                    $response['message'] = 'Previous organization deleted';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                } 
            }  
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function member_education_post(){
        $postFields['member_id'] = $_POST['member_id']; 
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{

                $where = array('member_id' => intval($_POST['member_id']));
                $education = $this->db->get_where('education',$where)->result_array();
                    $response['status'] = true;
                    $response['education'] = $education;

            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function add_education_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['degree'] = $_POST['degree'];               
        $postFields['school'] = $_POST['school'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1', 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';
            }else{
                $data = array('member_id' => $_POST['member_id'], 'degree' => $_POST['degree'],'school' => $_POST['school']);
                if($this->db->insert('education',$data)){
                    $response['status'] = true;
                    $response['message'] = 'Education added';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                } 
            }  
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function save_education_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['education_id'] = $_POST['education_id'];               
        $postFields['degree'] = $_POST['degree'];               
        $postFields['school'] = $_POST['school'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{
                $data = array('degree' => $_POST['degree'], 'school' => $_POST['school']);
                $this->db->where('member_id', $_POST['member_id']);
                $this->db->where('id', $_POST['education_id']);
                if($this->db->update('education', $data)){
                    $response['status'] = true;
                    $response['message'] = 'Education saved';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function delete_education_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['education_id'] = $_POST['education_id'];                           
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1', 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';
            }else{

                $this->db->where('member_id',$_POST['member_id']);
                $this->db->where('id',$_POST['education_id']);
                if($this->db->delete('education')){
                    $response['status'] = true;
                    $response['message'] = 'Education deleted';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                } 
            }  
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function save_link_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['type'] = $_POST['type'];               
        $postFields['link'] = $_POST['link'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{
                
                $data = array($_POST['type'] => $_POST['link']);
                $this->db->where('member_id', $_POST['member_id']);
                if($this->db->update('member_extrainfo', $data)){
                    $response['status'] = true;
                    $response['message'] = ucfirst(str_replace('_', ' ',$_POST['type'])). ' saved';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }

            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function delete_link_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['type'] = $_POST['type'];                           
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{
                
                $data = array($_POST['type'] => "");
                $this->db->where('member_id', $_POST['member_id']);
                if($this->db->update('member_extrainfo', $data)){
                    $response['status'] = true;
                    $response['message'] = ucfirst(str_replace('_', ' ',$_POST['type'])). ' deleted';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }

            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function save_profile_picture_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['image'] = $_FILES['image'];      

        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                if (isset($_FILES['image']) && !empty($_FILES['image']) && strlen($_FILES['image']['name']) > 0) {

                    //save new image in folder
                    $config['upload_path'] = FCPATH . $this->config->item("profile_path");
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['encrypt_name'] = false;
                    $config['file_name'] = 'member' . '_' . time();
                    $config['file_ext_tolower'] = true;

                    $this->load->library('upload');
                    $this->upload->initialize($config, true);

                    if (!$this->upload->do_upload('image')) {
                        $response['status'] = false;
                        $response['message'] = $this->upload->display_errors();
                    } else {

                        $image_data = $this->upload->data();

                        //remove old image from user folder
                        $this->db->select('image');
                        $this->db->where('id', intval($_POST['member_id']));
                        $this->db->from('member');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $return_data = $sql_query->row();
                            $image_old = $return_data->image;

                            if (isset($image_old) && !empty($image_old)) {
                                if (file_exists(FCPATH . $this->config->item("profile_path") . "/" . $image_old)) {
                                    unlink(FCPATH . $this->config->item("profile_path") . "/" . $image_old);
                                }
                            }
                        }

                        //update image in database
                        $data = array('image' => $image_data['file_name']);
                        $this->db->where('id', $_POST['member_id']);
                        $this->db->update('member', $data);

                        $response['status'] = true;
                        $response['message'] = 'Profile picture changed';
                    }
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }

            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function save_email_post(){
        $postFields['member_id'] = $_POST['member_id']; 
        $postFields['email'] = $_POST['email'];       

        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{

                //check if new email is already use by another member or not
                $not_in = array($_POST['member_id']);
                $this->db->where('email', $_POST['email']);
                $this->db->where_not_in('id', $not_in);
                $this->db->from('member');
                $sql_query = $this->db->get();

                if ($sql_query->num_rows() > 0) {
                    $response['status'] = false;
                    $response['message'] = 'email is already exists';
                }else{

                    $data = array('email' => $_POST['email']);
                    $this->db->where('id', $_POST['member_id']);
                    if($this->db->update('member', $data)){
                        $response['status'] = true;
                        $response['message'] = 'Email address changed';
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'Server encountered an error. please try again';
                    }
                } 
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function save_current_organization_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['current_occupation'] = $_POST['current_occupation'];               
        $postFields['current_organization'] = $_POST['current_organization'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{
                
                $data = array('jobtitle' => $_POST['current_occupation'], 'current_organization' => $_POST['current_organization']);
                $this->db->where('id', $_POST['member_id']);
                if($this->db->update('member', $data)){
                    $response['status'] = true;
                    $response['message'] = 'Organization saved';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function save_contact_preferences_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['type'] = $_POST['type'];               
        $postFields['status'] = $_POST['status'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{
                
                $data = array($_POST['type'] => $_POST['status']);
                $this->db->where('id', $_POST['member_id']);
                if($this->db->update('member', $data)){
                    $response['status'] = true;
                    $response['message'] = 'Contact preference saved';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function add_remove_friend_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['friend_id'] = $_POST['friend_id'];                          
        $postFields['friendship_status'] = $_POST['friendship_status'];                          
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $current_member = (array)$this->db->get_where('member',$where)->row();
            if(empty($current_member)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{

                $where = array('id' => intval($_POST['friend_id']), 'deleted_at' => NULL);
                $user = (array)$this->db->get_where('member',$where)->row();
                if(empty($user)){
                    $response['status'] = false;
                    $response['message'] = 'user not found';   
                }else{

                    $where = array('member_id' => intval($_POST['member_id']), 'friend_id' =>intval($_POST['friend_id']));
                    $friendship_exists = (array)$this->db->get_where('friends',$where)->row();
                    if(empty($friendship_exists)){

                        // sender to recievcer friendship
                        $data = array(
                            'member_id' => $_POST['member_id'], 
                            'friend_id' => $_POST['friend_id'], 
                            'friendship_status' => $_POST['friendship_status']
                        );

                        $this->db->insert('friends', $data);

                        // reciever to sender friendship
                        $data = array(
                            'member_id' => $_POST['friend_id'], 
                            'friend_id' => $_POST['member_id'], 
                            'friendship_status' => $_POST['friendship_status']
                        );

                        $this->db->insert('friends', $data);

                    }else{
                        $f_data = array('friendship_status' => $_POST['friendship_status']);
                        $this->db->where('member_id', $_POST['member_id']);
                        $this->db->where('friend_id', $_POST['friend_id']);
                        $this->db->update('friends', $f_data);
                    }
                    $response['status'] = true;
                }
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function add_remove_friend_new_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['friend_id'] = $_POST['friend_id'];                          
        $postFields['friendship_status'] = $_POST['friendship_status'];                          
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $current_member = (array)$this->db->get_where('member',$where)->row();
            if(empty($current_member)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{

                $where = array('id' => intval($_POST['friend_id']), 'deleted_at' => NULL);
                $user = (array)$this->db->get_where('member',$where)->row();
                if(empty($user)){
                    $response['status'] = false;
                    $response['message'] = 'user not found';   
                }else{

                    $where = array('member_id' => intval($_POST['member_id']), 'friend_id' =>intval($_POST['friend_id']));
                    $friendship_exists = (array)$this->db->get_where('friends',$where)->row();
                    if(empty($friendship_exists)){
                        //add new friendship

                        // if first match - send mail - start
                        $this->db->select('friend_id');

                        //$this->db->group_start();
                        $this->db->where("member_id", $_POST['member_id']);
                        //$this->db->or_where("friend_id", $_POST['member_id']);
                        //$this->db->group_end();

                        $this->db->where("friendship_status", 1);
                        $this->db->where("matched", 1);
                        $this->db->from('friends');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0){
                            $response['first_connection'] = false;
                        }else{
                            $response['first_connection'] = true;
                        }
                        // if first match - send mail - end

                        // sender to recievcer friendship
                        $data = array(
                            'member_id' => $_POST['member_id'], 
                            'friend_id' => $_POST['friend_id'], 
                            'friendship_status' => $_POST['friendship_status']
                        );

                        $this->db->select('friend_id');
                        $this->db->where("friend_id", $_POST['member_id']);
                        $this->db->where("member_id", $_POST['friend_id']);
                        $this->db->where("friendship_status", 1);
                        $this->db->from('friends');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0){

                            $f_data = array('matched' => 1);
                            $this->db->where('friend_id', $_POST['member_id']);
                            $this->db->where('member_id', $_POST['friend_id']);
                            $this->db->where('friendship_status', 1);
                            $this->db->update('friends', $f_data);

                            $data['matched'] = '1';
                            $response['both_matched'] = true;
                        }else{
                            $response['both_matched'] = false;
                        }

                        $this->db->insert('friends', $data);

                    }else{
                        // exists means having friedship means remove friedship status 0
                        $f_data = array('friendship_status' => $_POST['friendship_status']);
                        $this->db->where('member_id', $_POST['member_id']);
                        $this->db->where('friend_id', $_POST['friend_id']);
                        $this->db->update('friends', $f_data);
                    }

                    $this->db->select('*');
                    $this->db->where("id", $_POST['friend_id']);
                    $this->db->from('member');
                    $sql_query = $this->db->get();

                    if($response['both_matched'] == TRUE){

                        if ($sql_query->num_rows() > 0){

                            // Send mail to friend - both connected - Start
                            $friend_data = $sql_query->row();

                            if($friend_data->gender == '0'){
                                $header_text = 'He';
                                $img_url = base_url(). '/assets/images/default/default_male.png';
                            }else{
                                $header_text = 'She';
                                $img_url = base_url(). '/assets/images/default/default_female.png';
                            }

                            if (isset($friend_data->image) && ($friend_data->image != '')){
                                if (file_exists($this->config->item("profile_path") .$friend_data->friend_data)){
                                    $img_url = base_url(). $this->config->item("profile_path").$friend_data->image;
                                }
                            }

                            $to =  array($friend_data->email);
                            $subject = $friend_data->fullname.' - Via Emajlis';

                            $path = BASE_URL().'email_template/want_to_meet.php';
                            $template = file_get_contents($path);
                            $template = str_replace('##FRIENDNAME##', $friend_data->fullname, $template);
                            $template = str_replace('##IMAGEURL##',$img_url, $template);
                            $template = str_replace('##FRIENDOCCUPATION##', ucwords($friend_data->jobtitle), $template);
                            
                            $template = str_replace('##HEADERTEXT##', $header_text.' wants to meet you too!', $template);
                            $template = $this->create_email_template2($template);
                            $mail = $this->send_mail2($to,$subject,$template);
                            if($mail == 1){
                                $response['mail_msg'] = 'Mail successfully sent to friend';
                            }
                            
                        }
                        // Send mail to friend - both connected - End
                    }
                    if($response['first_connection'] == TRUE){

                        // Send mail to member - first connected - Start
                        if ($sql_query->num_rows() > 0){

                            $friend_data = $sql_query->row();

                            if($friend_data->gender == '0'){
                                $img_url = base_url(). '/assets/images/default/default_male.png';
                            }else{
                                $img_url = base_url(). '/assets/images/default/default_female.png';
                            }

                            if (isset($friend_data->image) && ($friend_data->image != '')){
                                if (file_exists($this->config->item("profile_path") .$friend_data->friend_data)){
                                    $img_url = base_url(). $this->config->item("profile_path").$friend_data->image;
                                }
                            }

                            $to =  array($current_member['email']);
                            $subject = 'Congrats '.$current_member['fullname'].', You got your first match!';

                            $path = BASE_URL().'email_template/want_to_meet.php';
                            $template = file_get_contents($path);
                            $template = str_replace('##FRIENDNAME##', $friend_data->fullname, $template);
                            $template = str_replace('##IMAGEURL##',$img_url, $template);
                            $template = str_replace('##FRIENDOCCUPATION##', ucwords($friend_data->jobtitle), $template);
                            
                            $template = str_replace('##HEADERTEXT##', 'Your First Match!', $template);
                            $template = $this->create_email_template2($template);
                            $mail = $this->send_mail2($to,$subject,$template);
                            if($mail == 1){
                                $response['mail_msg'] = 'Mail successfully sent to member';
                            }
                            
                        }
                    }
                    $response['status'] = true;
                }
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function my_matches_post(){
        $postFields['member_id'] = $_POST['member_id'];                    
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{
                $where = array('member_id' => intval($_POST['member_id']), 'friendship_status' => 1);
                $matches = $this->db->get_where('friends',$where)->result_array();

                $this->db->select('*');
                $this->db->where("member_id", $_POST['member_id']);
                $this->db->where("friendship_status", 1);
                $this->db->from('friends');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0){
                    $matches_users = $sql_query->result_array();

                    $matches_chat_detail = array();

                    $this->db->select('id,fullname,jobtitle,image');
                    $this->db->where_in("id", array_column($matches_users, 'friend_id'));
                    $this->db->from('member');
                    $sql_query = $this->db->get();
                    $member_detail = $sql_query->result_array();
                    
                    foreach ($matches_users as $key => $value) {
                        $this->db->select('sender_id,receiver_id,message, created_date');

                        $this->db->group_start();
                            $this->db->where("sender_id",$_POST['member_id']);
                            $this->db->where("receiver_id",$value['friend_id']);
                        $this->db->group_end();

                        $this->db->or_group_start();
                            $this->db->where("sender_id",$value['friend_id']);
                            $this->db->where("receiver_id",$_POST['member_id']);
                        $this->db->group_end();

                        $this->db->limit(1);
                        $this->db->order_by('created_date','desc');
                        $this->db->from('chat');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0){
                            $chat_detail = $sql_query->result_array();
                            array_push($matches_chat_detail,$chat_detail);
                        }
                    }

                    $chat_data = array();
                    if(is_array($matches_chat_detail) && !empty($matches_chat_detail)){
                        foreach ($matches_chat_detail as $key => $value) {
                            
                            foreach ($member_detail as $key1 => $value1) {
                                if(($value1['id'] == $value[0]['sender_id']) || ($value1['id'] == $value[0]['receiver_id'])){
                                    $member_detail[$key1]['last_message'] = base64_decode($value[0]['message']);
                                    $member_detail[$key1]['last_message_date'] = $value[0]['created_date'];
                                }
                            }
                        }
                    }
                    

                    $response['matched_detail'] = $member_detail;
                    $response['status'] = true;
                    // $response['chat_detail'] = $matches_chat_detail;
                    // $response['chat_data'] = $chat_data;
                }else{
                    $response['status'] = true;
                    $response['matched_detail'] = array();
                }

            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function my_matches_new_post(){
        $postFields['member_id'] = $_POST['member_id'];                    
        $postFields['tab_name'] = $_POST['tab_name'];                    
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{
                $where = array('member_id' => intval($_POST['member_id']), 'friendship_status' => 1);
                $matches = $this->db->get_where('friends',$where)->result_array();

                $this->db->select('*');
                $this->db->where("member_id", $_POST['member_id']);
                $this->db->where("friendship_status", 1);
                $this->db->where("matched", 1);
                $this->db->from('friends');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0){
                    $matches_users = $sql_query->result_array();
                    $matches_chat_detail = array();

                    $this->db->select('id,fullname,jobtitle,image');
                    $this->db->where_in("id",  array_column($matches_users, 'friend_id'));
                    $this->db->from('member');
                    $sql_query = $this->db->get();
                    $member_detail = $sql_query->result_array();

                    foreach ($member_detail as $key => $value) {

                        $this->db->select('sender_id,receiver_id,message, created_date');

                        $this->db->group_start();
                            $this->db->where("sender_id",$_POST['member_id']);
                            $this->db->where("receiver_id",$value['id']);
                        $this->db->group_end();

                        $this->db->or_group_start();
                            $this->db->where("sender_id",$value['id']);
                            $this->db->where("receiver_id",$_POST['member_id']);
                        $this->db->group_end();

                        $this->db->limit(1);
                        $this->db->order_by('created_date','desc');
                        $this->db->from('chat');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0){
                            $chat_detail = $sql_query->result_array();
                            $member_detail[$key]['last_message'] = base64_decode($chat_detail[0]['message']);
                            $member_detail[$key]['last_message_date'] = $chat_detail[0]['created_date'];

                            if($_POST['tab_name'] == 'sayhello'){
                                unset($member_detail[$key]);
                            }
                        }else{

                            $this->db->select('created_at');
                            $this->db->where("member_id", $_POST['member_id']);
                            $this->db->where("friend_id", $value['id']);
                            $this->db->from('friends');
                            $sql_query = $this->db->get();
                            if ($sql_query->num_rows() > 0){
                                $friendship_created_detail = $sql_query->row();
                                $member_detail[$key]['last_message_date'] = $friendship_created_detail->created_at;
                            }

                            if($_POST['tab_name'] == 'conversation'){
                                unset($member_detail[$key]);
                            }
                            
                        }
                    }

                    $member_detail = array_values($member_detail);
                    
                    $response['matched_detail'] = $member_detail;
                    $response['status'] = true;
                }else{
                    
                    $response['status'] = true;
                    $response['matched_detail'] = array();
                }

            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function discover_post(){
        $postFields['member_id'] = $_POST['member_id'];  
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $matched = array();

                $friend_list = array();
                $this->db->select('friend_id');
                $this->db->where("member_id", $_POST['member_id']);
                $this->db->from('friends');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $friend_array = $sql_query->result_array();
                    foreach ($friend_array as $key => $value) {
                        array_push($friend_list,$value['friend_id']);
                    }
                }

                // get goal macthed members
                $goal_matched_members = array();
                $goal_list = array();
                $this->db->select('name');
                $this->db->where("member_id", $_POST['member_id']);
                $this->db->from('member_goal');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $result_array = $sql_query->result_array();

                    $like = '';
                    foreach ($result_array as $key => $value) {
                        array_push($goal_list,$value['name']);
                        $like .= "name like '%".$value['name']."%' OR ";
                    }
                    $like = rtrim($like,' OR');
                    $like = "where ".$like;
                }


                if(is_array($goal_list) && !empty($goal_list)){ 
                    $sql_query = $this->db->query("select member_id from member_goal ".$like);
                    if ($sql_query->num_rows() > 0) {
                        $user_goal_matches = $sql_query->result_array();
                        foreach ($user_goal_matches as $key => $value) {
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id']) && (!in_array($value['member_id'], $friend_list)))
                            {
                                array_push($matched,$value['member_id']);
                            }
                        }
                    }
                }
                

                // get hashtag macthed members
                $member_hashtag = array();
                $this->db->select('hashtag_id');
                $this->db->where('member_id',intval($_POST['member_id']));
                $this->db->from('member_interests');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $member_hashtags = $sql_query->result_array();
                    foreach ($member_hashtags as $key => $value) {
                       array_push($member_hashtag,$value['hashtag_id']);
                    }
                }



                if(is_array($member_hashtag) && !empty($member_hashtag)){
                    $this->db->select('member_id'); 
                    $this->db->where_in('hashtag_id',$member_hashtag); 
                    $this->db->from('member_interests'); 
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $user_hashtag_matches = $sql_query->result_array();
                        foreach ($user_hashtag_matches as $key => $value) {
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id']) && (!in_array($value['member_id'], $friend_list))){
                                array_push($matched,$value['member_id']);
                            }
                        }
                    }
                }
                

                // get industry macthed members

                $member_industry = array();
                $this->db->select('industry_id');
                $this->db->where('member_id',intval($_POST['member_id']));
                $this->db->from('member_industry');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $member_industrys = $sql_query->result_array();
                    foreach ($member_industrys as $key => $value) {
                       array_push($member_industry,$value['industry_id']);
                    }
                }
                if(is_array($member_industry) && !empty($member_industry)){
                    $this->db->select('member_id'); 
                    $this->db->where_in('industry_id',$member_industry); 
                    $this->db->from('member_industry'); 
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $user_industry_matches = $sql_query->result_array();
                        foreach ($user_industry_matches as $key => $value) {
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id']) && (!in_array($value['member_id'], $friend_list))){
                                array_push($matched,$value['member_id']);
                            }
                        }
                    }
                }
                

                // get location prefrences macthed members
                $member_location_preference = array();
                $this->db->select('meeting_preference_id');
                $this->db->where('member_id',intval($_POST['member_id']));
                $this->db->from('member_meeting_preferences');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $member_location_preferences = $sql_query->result_array();
                    foreach ($member_location_preferences as $key => $value) {
                       array_push($member_location_preference,$value['meeting_preference_id']);
                    }
                }

                if(is_array($member_location_preference) && !empty($member_location_preference)){
                    $this->db->select('member_id'); 
                    $this->db->where_in('meeting_preference_id',$member_location_preference); 
                    $this->db->from('member_meeting_preferences'); 
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $user_location_preference_matches = $sql_query->result_array();
                        foreach ($user_location_preference_matches as $key => $value) {
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id']) && (!in_array($value['member_id'], $friend_list))){
                                array_push($matched,$value['member_id']);
                            }
                        }
                    }
                }
                //echo "<pre>";
                // get prev organization macthed members
                $previous_organizations = array();
                $previous_organization_matches = array();
                $this->db->select('organization_name, designation');
                $this->db->where('member_id',intval($_POST['member_id']));
                $this->db->from('previous_organization');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $previous_organizations = $sql_query->result_array();
                    foreach ($previous_organizations as $key => $organization) {
                        $this->db->select('member_id'); 
                        $this->db->like('organization_name', $organization['organization_name']);
                        $this->db->from('previous_organization'); 
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0){
                            $previous_organization_matches = $sql_query->result_array();
                            foreach ($previous_organization_matches as $key => $value) {
                                if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id']) && (!in_array($value['member_id'], $friend_list))){
                                    array_push($matched,$value['member_id']);
                                }
                            }
                        }
                    }
                }

                // get current organization macthed members
                $organization = array();
                $organization_matches = array();
                $this->db->select('current_organization');
                $this->db->where('id',intval($_POST['member_id']));
                $this->db->from('member');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $organization = $sql_query->row();
                    if($organization->current_organization != ''){
                        $this->db->select('id'); 
                        $this->db->like('current_organization', $organization->current_organization);
                        $this->db->from('member'); 
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0){
                            $organization_matches = $sql_query->result_array();
                            foreach ($organization_matches as $key => $value) {
                                if ((!in_array($value['id'], $matched)) && ($_POST['member_id'] != $value['id']) && (!in_array($value['member_id'], $friend_list))){
                                    array_push($matched,$value['id']);
                                }
                            }
                        }
                    }
                }


                $education = array();
                $education_matches = array();
                $this->db->select('*');
                $this->db->where('member_id',intval($_POST['member_id']));
                $this->db->from('education');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $educations = $sql_query->result_array();
                    foreach ($educations as $key => $organization) {
                        $this->db->select('member_id'); 
                        $this->db->like('degree', $organization['degree']);
                        $this->db->or_like('school', $organization['school']);
                        $this->db->from('education'); 
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0){
                            $education_matches = $sql_query->result_array();
                            foreach ($education_matches as $key => $value) {
                                if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id']) && (!in_array($value['member_id'], $friend_list))){
                                    array_push($matched,$value['member_id']);
                                }
                            }
                        }
                    }
                }



                $profile_array = array();
                $profile_array2 = array();
                if(is_array($matched) && !empty($matched)){
                    foreach ($matched as $value)
                    {
                        $user = array();
                        $sql_select = array("t1.*","t2.social_id", "t2.social_type","t2.linkedin_link" , "t2.twitter_link", "t2.instagram_link", "t2.website_link", "t2.about_goal");
                        $this->db->select($sql_select);
                        $this->db->where("t1.status", 1);
                        $this->db->where("t1.id", $value);
                        $this->db->where("t1.deleted_at", NULL);
                        $this->db->from('member t1');
                        $this->db->join('member_extrainfo t2', 't1.id = t2.member_id', "left join");
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $user = (array)$sql_query->row();
                        }

                        $member_interests = array();
                        $sql_select = array("t1.member_id", "t2.*");
                        $this->db->select($sql_select);
                        $this->db->where("t1.member_id", $value);
                        $this->db->from('member_interests t1');
                        $this->db->join('hashtag t2', 't1.hashtag_id = t2.id', "left join");
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $member_interests = $sql_query->result_array();
                        }

                        $user_goal = array();
                        $this->db->select('*');
                        $this->db->where("member_id", $value);
                        $this->db->from('member_goal');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $user_goal = $sql_query->result_array();
                        }

                        $industry = array();
                        $sql_select = array("t2.*");
                        $this->db->select($sql_select);
                        $this->db->where("t1.member_id", $value);
                        $this->db->from('member_industry t1');
                        $this->db->join('industry t2', 't1.industry_id = t2.id', "left join");
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $industry = $sql_query->result_array();
                        }

                        $favorite_ways_meeting = array();
                        $sql_select = array("t2.*");
                        $this->db->select($sql_select);
                        $this->db->where("t1.member_id", $value);
                        $this->db->from('member_meeting_preferences t1');
                        $this->db->join('meeting_preferences t2', 't1.meeting_preference_id = t2.id', "left join");
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $favorite_ways_meeting = $sql_query->result_array();
                        }

                        $previous_organization = array();
                        $this->db->select('*');
                        $this->db->where("member_id", $value);
                        $this->db->from('previous_organization');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $previous_organization = $sql_query->result_array();
                        }

                        $education = array();
                        $this->db->select('*');
                        $this->db->where("member_id", $value);
                        $this->db->from('education');
                        $sql_query = $this->db->get();
                        if ($sql_query->num_rows() > 0) {
                            $education = $sql_query->result_array();
                        }

                        if(!empty($user)){
                            $profile_array['user_info'] = $user;
                            $profile_array['previous_organization'] = $previous_organization;
                            $profile_array['education'] = $education;
                            $profile_array['user_hashtags'] = $member_interests;
                            $profile_array['user_goal'] = $user_goal;
                            $profile_array['favorite_ways_meeting'] = $favorite_ways_meeting;
                            $profile_array['industry'] = $industry; 
                            array_push($profile_array2,$profile_array);
                        }
                        
                    }
                }
                
                 $response['matched_profiles'] = $profile_array2;
                 // $response['matched'] = $matched;

            }
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);   
    }

    public function discover_new_post(){
        $postFields['member_id'] = $_POST['member_id'];  
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $matched = array();

                // get friend/not-friends of member -> Dont add those in discover
                $friend_list = array();
                $this->db->select('friend_id');
                $this->db->where("member_id", $_POST['member_id']);
                $this->db->from('friends');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $friend_array = $sql_query->result_array();
                    $friend_list = array_column($friend_array, 'friend_id');
                }

                $this->db->select('id');
                $this->db->where("deleted_at", NULL);
                $this->db->where("status", 1);
                if(!empty($friend_list)){
                    $this->db->where_not_in("id", $friend_list);
                }
                $this->db->where("id !=", $_POST['member_id']);
                $this->db->from('member');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0){
                    $all_members = $sql_query->result_array();

                    // Get member Goals
                    $goal_list = array();
                    $this->db->select('name');
                    $this->db->where("member_id", $_POST['member_id']);
                    $this->db->from('member_goal');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $result_array = $sql_query->result_array();

                        $like = '';
                        foreach ($result_array as $key => $value) {
                            array_push($goal_list,$value['name']);
                            $like .= "name like '%".$value['name']."%' OR ";
                        }
                        $like = rtrim($like,' OR');
                    }

                    // get hashtag of member
                    $member_hashtags = array();
                    $this->db->select('hashtag_id');
                    $this->db->where('member_id',intval($_POST['member_id']));
                    $this->db->from('member_interests');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $member_hashtags = $sql_query->result_array();
                    }

                    // get fav location of member
                    $member_location_preferences = array();
                    $this->db->select('meeting_preference_id');
                    $this->db->where('member_id',intval($_POST['member_id']));
                    $this->db->from('member_meeting_preferences');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $member_location_preferences = $sql_query->result_array();
                    }

                    //get industries of member
                    $member_industry = array();
                    $this->db->select('industry_id');
                    $this->db->where('member_id',intval($_POST['member_id']));
                    $this->db->from('member_industry');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $member_industries = $sql_query->result_array();
                    }

                    // Get member prev organizations
                    $previous_organization_list = array();
                    $this->db->select('organization_name');
                    $this->db->where("member_id", $_POST['member_id']);
                    $this->db->from('previous_organization');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $result_array = $sql_query->result_array();

                        $like_organization = '';
                        foreach ($result_array as $key => $value) {
                            array_push($previous_organization_list,$value['organization_name']);
                            $like_organization .= "organization_name like '%".$value['organization_name']."%' OR ";
                        }
                        $like_organization = rtrim($like_organization,' OR');
                    }

                    // Get member designation
                    $designation_list = array();
                    $this->db->select('designation');
                    $this->db->where("member_id", $_POST['member_id']);
                    $this->db->from('previous_organization');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $result_array = $sql_query->result_array();

                        $like_designation = '';
                        foreach ($result_array as $key => $value) {
                            array_push($designation_list,$value['designation']);
                            $like_designation .= "designation like '%".$value['designation']."%' OR ";
                        }
                        $like_designation = rtrim($like_designation,' OR');
                    }

                    // Get member degree
                    $degree_list = array();
                    $this->db->select('degree');
                    $this->db->where("member_id", $_POST['member_id']);
                    $this->db->from('education');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $result_array = $sql_query->result_array();

                        $like_degree = '';
                        foreach ($result_array as $key => $value) {
                            array_push($degree_list,$value['degree']);
                            $like_degree .= "degree like '%".$value['degree']."%' OR ";
                        }
                        $like_degree = rtrim($like_degree,' OR');
                    }

                    // Get member school/institule
                    $school_list = array();
                    $this->db->select('school');
                    $this->db->where("member_id", $_POST['member_id']);
                    $this->db->from('education');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {

                        $result_array = $sql_query->result_array();
                        $like_school = '';
                        foreach ($result_array as $key => $value) {
                            array_push($school_list,$value['school']);
                            $like_school .= "school like '%".$value['school']."%' OR ";
                        }
                        $like_school = rtrim($like_school,' OR');
                    }

                    $score = array();

                    foreach ($all_members as $key => $value) {

                        $all_members[$key]['score'] = 0;

                        // Goal Score
                        if(is_array($goal_list) && !empty($goal_list)){ 
                            $sql_query = $this->db->query("select * from member_goal where (".$like.") AND member_id = ".$value['id']);
                            if ($sql_query->num_rows() > 0){
                                $goal_matches = $sql_query->result_array();
                                $goal_score = count($goal_matches);
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($goal_matches);
                                $score[$value['id']] = $score[$value['id']] + count($goal_matches);
                            }
                        }

                        // Hashtag Score
                        if(is_array($member_hashtags) && !empty($member_hashtags)){
                            $this->db->select('member_id'); 
                            $this->db->where_in('hashtag_id',array_column($member_hashtags, 'hashtag_id'));
                            $this->db->where('member_id',$value['id']);
                            $this->db->from('member_interests'); 
                            $sql_query = $this->db->get();
                            if ($sql_query->num_rows() > 0) {
                                $hashtag_matches = $sql_query->result_array();
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($hashtag_matches);
                                $score[$value['id']] = $score[$value['id']] + count($hashtag_matches);
                            }
                        }

                        // Fav location Score
                        if(is_array($member_location_preferences) && !empty($member_location_preferences)){
                            $this->db->select('member_id'); 
                            $this->db->where_in('meeting_preference_id',array_column($member_location_preferences, 'meeting_preference_id'));
                            $this->db->where('member_id',$value['id']);
                            $this->db->from('member_meeting_preferences'); 
                            $sql_query = $this->db->get();
                            if ($sql_query->num_rows() > 0) {
                                $meeting_preferences_matches = $sql_query->result_array();
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($meeting_preferences_matches);
                                $score[$value['id']] = $score[$value['id']] + count($meeting_preferences_matches);
                            }
                        }

                        //industry score
                        if(is_array($member_industries) && !empty($member_industries)){
                            $this->db->select('member_id'); 
                            $this->db->where_in('industry_id',array_column($member_industries, 'industry_id')); 
                            $this->db->where('member_id',$value['id']);
                            $this->db->from('member_industry'); 
                            $sql_query = $this->db->get();
                            if ($sql_query->num_rows() > 0) {
                                $industry_matches = $sql_query->result_array();
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($industry_matches);
                                $score[$value['id']] = $score[$value['id']] + count($industry_matches);
                            }
                        }

                        //current organization score
                        if(isset($user['current_organization']) && $user['current_organization'] != ''){
                            $this->db->select('id'); 
                            $this->db->like('current_organization', $user['current_organization']);
                            $this->db->where('id',$value['id']);
                            $this->db->from('member'); 
                            $sql_query = $this->db->get();
                            if ($sql_query->num_rows() > 0) {
                                $all_members[$key]['score'] = $all_members[$key]['score'] + 1;
                                $score[$value['id']] = $score[$value['id']] + 1;
                            }
                        }

                        //current job title score
                        if(isset($user['jobtitle']) && $user['jobtitle'] != ''){
                            $this->db->select('id'); 
                            $this->db->like('jobtitle', $user['jobtitle']);
                            $this->db->where('id',$value['id']);
                            $this->db->from('member'); 
                            $sql_query = $this->db->get();
                            if ($sql_query->num_rows() > 0) {
                                $all_members[$key]['score'] = $all_members[$key]['score'] + 1;
                                $score[$value['id']] = $score[$value['id']] + 1;
                            }
                        }

                        // prev organizations Score
                        if(is_array($previous_organization_list) && !empty($previous_organization_list)){ 
                            $sql_query = $this->db->query("select * from previous_organization where (".$like_organization.") AND member_id = ".$value['id']);
                            if ($sql_query->num_rows() > 0){
                                $organization_matches = $sql_query->result_array();
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($organization_matches);
                                $score[$value['id']] = $score[$value['id']] + count($organization_matches);
                            }
                        }

                        // designation Score
                        if(is_array($designation_list) && !empty($designation_list)){ 
                            $sql_query = $this->db->query("select * from previous_organization where (".$like_designation.") AND member_id = ".$value['id']);
                            if ($sql_query->num_rows() > 0){
                                $designation_matches = $sql_query->result_array();
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($designation_matches);
                                $score[$value['id']] = $score[$value['id']] + count($designation_matches);
                            }
                        }

                        // degree Score
                        if(is_array($degree_list) && !empty($degree_list)){ 
                            $sql_query = $this->db->query("select * from education where (".$like_degree.") AND member_id = ".$value['id']);
                            if ($sql_query->num_rows() > 0){
                                $degree_matches = $sql_query->result_array();
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($degree_matches);
                                $score[$value['id']] = $score[$value['id']] + count($degree_matches);
                            }
                        }

                        // school/institule Score
                        if(is_array($school_list) && !empty($school_list)){
                            $sql_query = $this->db->query("select * from education where (".$like_school.") AND member_id = ".$value['id']);
                            if ($sql_query->num_rows() > 0){
                                $school_matches = $sql_query->result_array();
                                $all_members[$key]['score'] = $all_members[$key]['score'] + count($school_matches);
                                $score[$value['id']] = $score[$value['id']] + count($school_matches);
                            }
                        }

                    }
                }

            }
            arsort($score);
            $profile_array = array();
            $profile_array2 = array();

            foreach ($score as $key => $value) {
                
                $member_data = array();
                $sql_select = array("t1.*","t2.social_id", "t2.social_type","t2.linkedin_link" , "t2.twitter_link", "t2.instagram_link", "t2.website_link", "t2.about_goal");
                $this->db->select($sql_select);
                $this->db->where("t1.status", 1);
                $this->db->where("t1.id", $key);
                $this->db->where("t1.deleted_at", NULL);
                $this->db->from('member t1');
                $this->db->join('member_extrainfo t2', 't1.id = t2.member_id', "left join");
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $member_data = (array)$sql_query->row();
                }

                $member_interests = array();
                $sql_select = array("t1.member_id", "t2.*");
                $this->db->select($sql_select);
                $this->db->where("t1.member_id", $key);
                $this->db->from('member_interests t1');
                $this->db->join('hashtag t2', 't1.hashtag_id = t2.id', "left join");
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $member_interests = $sql_query->result_array();
                }

                $user_goal = array();
                $this->db->select('*');
                $this->db->where("member_id", $key);
                $this->db->from('member_goal');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $user_goal = $sql_query->result_array();
                }

                $industry = array();
                $sql_select = array("t2.*");
                $this->db->select($sql_select);
                $this->db->where("t1.member_id", $key);
                $this->db->from('member_industry t1');
                $this->db->join('industry t2', 't1.industry_id = t2.id', "left join");
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $industry = $sql_query->result_array();
                }

                $favorite_ways_meeting = array();
                $sql_select = array("t2.*");
                $this->db->select($sql_select);
                $this->db->where("t1.member_id", $key);
                $this->db->from('member_meeting_preferences t1');
                $this->db->join('meeting_preferences t2', 't1.meeting_preference_id = t2.id', "left join");
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $favorite_ways_meeting = $sql_query->result_array();
                }

                $previous_organization = array();
                $this->db->select('*');
                $this->db->where("member_id", $key);
                $this->db->from('previous_organization');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $previous_organization = $sql_query->result_array();
                }

                $education = array();
                $this->db->select('*');
                $this->db->where("member_id", $key);
                $this->db->from('education');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $education = $sql_query->result_array();
                }

                if(!empty($member_data)){
                    $profile_array['user_info'] = $member_data;
                    $profile_array['previous_organization'] = $previous_organization;
                    $profile_array['education'] = $education;
                    $profile_array['user_hashtags'] = $member_interests;
                    $profile_array['user_goal'] = $user_goal;
                    $profile_array['favorite_ways_meeting'] = $favorite_ways_meeting;
                    $profile_array['industry'] = $industry; 
                    array_push($profile_array2,$profile_array);
                }

            }
            $response['matched_profiles'] = $profile_array2;
        }
        else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }

        $this->response($response);   
    }

    public function linkedin_login_post(){
        $postFields['social_id'] = $_POST['social_id'];  
        $postFields['social_type'] = $_POST['social_type'];  
        $postFields['device_token'] = $_POST['device_token']; 
        $postFields['device_type'] = $_POST['device_type'];
        $postFields['lat'] = $_POST['lat'];
        $postFields['lang'] = $_POST['lang'];    
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){

            $where = array('social_id' => $_POST['social_id'],'social_type' => intval($_POST['social_type']));
            $user_exists = $this->db->get_where('member_extrainfo',$where)->row();

            if(empty($user_exists)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{
                $data = array('lat' => $_POST['lat'], 'lang' => $_POST['lang']);
                $this->db->where('id',intval($user_exists->member_id));
                $this->db->update('member',$data);

                $where = array('id' => intval($user_exists->member_id));
                $user = (array)$this->db->get_where('member',$where)->row();
                $response['status'] = true;
                $response['profile'] = $user;
            }
        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function search_post(){   
        
        $hashtag = $_POST['hashtags']; 
        $goal = explode(',',$_POST['goals']); 
        $industry = $_POST['industry']; 
        $meeting_pref = $_POST['favorite_ways_meeting']; 

        if(!empty($hashtag) || !empty($_POST['goals']) || !empty($industry) || !empty($meeting_pref)){
            $matched = array();

            if(!empty($hashtag)){
                $this->db->select('member_id'); 
                $this->db->where_in('hashtag_id',$hashtag); 
                $this->db->from('member_interests'); 
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $user_hashtag_matches = $sql_query->result_array();
                    foreach ($user_hashtag_matches as $key => $value) {
                        array_push($matched,$value['member_id']);
                    }
                }
            }

            if(!empty($_POST['goals'])){
               
                $like = '';
                foreach ($goal as $key => $value) {
                    $like .= "name like '%".$value."%' OR ";
                }
                $like = rtrim($like,' OR');
                $like = "where ".$like;
                $sql_query = $this->db->query("select member_id from member_goal ".$like); 
                if ($sql_query->num_rows() > 0) {
                    $user_goal_matches = $sql_query->result_array();
                    foreach ($user_goal_matches as $key => $value) {
                        if (!in_array($value['member_id'], $matched)){
                            array_push($matched,$value['member_id']);
                        }
                    }
                }
            }

            if(!empty($industry)){
                $this->db->select('member_id'); 
                $this->db->where_in('industry_id',$industry); 
                $this->db->from('member_industry'); 
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $user_industry_matches = $sql_query->result_array();
                    foreach ($user_industry_matches as $key => $value) {
                        if (!in_array($value['member_id'], $matched)){
                            array_push($matched,$value['member_id']);
                        }
                    }
                }
            }

            if(!empty($meeting_pref)){
                $this->db->select('member_id'); 
                $this->db->where_in('meeting_preference_id',$meeting_pref); 
                $this->db->from('member_meeting_preferences'); 
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $user_meeting_preferences_matches = $sql_query->result_array();
                    foreach ($user_meeting_preferences_matches as $key => $value) {
                        if (!in_array($value['member_id'], $matched)){
                            array_push($matched,$value['member_id']);
                        }
                    }
                }
            }

            $profile_array = array();
            $profile_array2 = array();

            if(is_array($matched) && !empty($matched)){
                 foreach ($matched as $key => $value){

                    $user = array();
                    $sql_select = array("t1.*", "t2.*");
                    $this->db->select($sql_select);
                    $this->db->where("t1.status", 1);
                    $this->db->where("t1.deleted_at", NULL);
                    $this->db->where("t1.id", $value);
                    $this->db->from('member t1');
                    $this->db->join('member_extrainfo t2', 't1.id = t2.member_id', "left join");
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $user = (array)$sql_query->row();
                    }

                    $member_interests = array();
                    $sql_select = array("t1.member_id", "t2.*");
                    $this->db->select($sql_select);
                    $this->db->where("t1.member_id", $value);
                    $this->db->from('member_interests t1');
                    $this->db->join('hashtag t2', 't1.hashtag_id = t2.id', "left join");
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $member_interests = $sql_query->result_array();
                    }

                    $user_goal = array();
                    $this->db->select('*');
                    $this->db->where("member_id", $value);
                    $this->db->from('member_goal');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $user_goal = $sql_query->result_array();
                    }

                    $industry = array();
                    $sql_select = array("t2.*");
                    $this->db->select($sql_select);
                    $this->db->where("t1.member_id", $value);
                    $this->db->from('member_industry t1');
                    $this->db->join('industry t2', 't1.industry_id = t2.id', "left join");
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $industry = $sql_query->result_array();
                    }

                    $favorite_ways_meeting = array();
                    $sql_select = array("t2.*");
                    $this->db->select($sql_select);
                    $this->db->where("t1.member_id", $value);
                    $this->db->from('member_meeting_preferences t1');
                    $this->db->join('meeting_preferences t2', 't1.meeting_preference_id = t2.id', "left join");
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $favorite_ways_meeting = $sql_query->result_array();
                    }

                    $previous_organization = array();
                    $this->db->select('*');
                    $this->db->where("member_id", $value);
                    $this->db->from('previous_organization');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $previous_organization = $sql_query->result_array();
                    }

                    $education = array();
                    $this->db->select('*');
                    $this->db->where("member_id", $value);
                    $this->db->from('education');
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $education = $sql_query->result_array();
                    }

                    if(!empty($user)){
                        $profile_array['user_info'] = $user;
                        $profile_array['education'] = $education;
                        $profile_array['previous_organization'] = $previous_organization;
                        $profile_array['user_hashtags'] = $member_interests;
                        $profile_array['user_goal'] = $user_goal;
                        $profile_array['favorite_ways_meeting'] = $favorite_ways_meeting;
                        $profile_array['industry'] = $industry;
                        array_push($profile_array2,$profile_array);
                    }

                 }
            }

            $response['filter_search'] = $profile_array2;

        }else{
            $response['status'] = false;
            $response['message'] = 'At least one value is required';   
        }

        // $response['hashtag'] = $hashtag;
        // $response['goal'] = $goal;
        // $response['industry'] = $industry;
        // $response['meeting_pref'] = $meeting_pref;

        $this->response($response);   
    }

    public function rss_feed_post(){
        $postFields['member_id'] = $_POST['member_id'];
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){

            $where = array('id' => intval($_POST['member_id']));
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{


                $feeds = array();

                $sql_select = array("t2.*");
                $this->db->select($sql_select);
                $this->db->where("t1.member_id", $_POST['member_id']);
                $this->db->from('member_interests t1');
                $this->db->join('newsfeed t2', 't1.hashtag_id = t2.hashtag_id', "left join");
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $feeds = $sql_query->result_array();
                }

                foreach ($feeds as $key => $value) {
                    $feeds[$key]['description'] = html_entity_decode($value['description']);
                    $feeds[$key]['image'] = html_entity_decode($value['image_link']);
                }  
                $response['status'] = true;
                $response['rss_feed'] = $feeds;

            }

        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function delete_member_post(){
        $postFields['member_id'] = $_POST['member_id'];
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['member_id']));
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{
                $data = array('deleted_at' => date('Y-m-d H:i:s'));
                $this->db->where('id',$_POST['member_id']);
                if($this->db->update('member', $data)){
                    $this->db->delete('member_extrainfo', array( 'member_id' => $_POST['member_id'] ));
                    $response['status'] = true;
                    $response['message'] = 'Account deleted';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                } 
            }
        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }


    public function send_push($sender_name = '', $sender_id = '', $sender_img = '', $user_id = '',$user_type = '',$push_title = '',$push_message = '',$message_type = '', $msg_id = '', $receiver_id = ''){
        if($user_id != '' && $user_type != ''){

            $this->db->select(array('device_type','device_token'));
            $row = (array)$this->db->get_where($user_type,array('id' => $user_id))->row();

            $key = $this->config->item('fcm_key');
            define('API_ACCESS_KEY', $key);
            $token = $row['device_token']; 

            

            if($row['device_type'] == 'IOS' || $row['device_type'] == 'ios'){

                $push_data = array('message_id' => $msg_id, 'message' => $push_message,'sender_id' => $sender_id ,'sender_name' => $sender_name,'receiver_id' => $receiver_id, 'sender_img' => $sender_img);

                $fcmFields = array(
                    'priority' => 'high',
                    'to' => $token,
                    'sound' => 'default',
                    'notification' => array( 
                        "title"=> $push_title,
                        "body"=> $push_message,
                         "data"=> $push_data,
                        "type"=> $message_type,
                        )
                    );

            }else{

                $push_data = array('message' => $push_message,'sender_id' => $sender_id ,'sender_name' => $sender_name, 'sender_img' => $sender_img);

                $fcmFields = array(
                    'priority' => 'high',
                    'to' => $token,
                    'sound' => 'default',
                    'data' => array( 
                        "title"=> $push_title,
                        "body"=> $push_data,
                        "type"=> $message_type,
                        )
                    );
            }

            $headers = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json');
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            //echo $fcmFields . "\n\n";
            return $result;

        }

    }

    public function testtest_post(){
        //print_r('sdcvsdvc');
        $this->send_push('27','member','dhrumi test','This is the test push notification from dhrumi','test_msg');
    }

    public function send_message_post(){
        $postFields['sender_user'] = $_POST['sender_user'];
        $postFields['receiver_user'] = $_POST['receiver_user'];
        $postFields['message'] = $_POST['message'];
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['sender_user']),  'deleted_at' => NULL);
            $sender_user = (array)$this->db->get_where('member',$where)->row();
            if(empty($sender_user)){
                $response['status'] = false;
                $response['message'] = 'Sender user not found';   
            }else{
                $where = array('id' => intval($_POST['receiver_user']),  'deleted_at' => NULL);
                $receiver_user = (array)$this->db->get_where('member',$where)->row();
                if(empty($receiver_user)){
                    $response['status'] = false;
                    $response['message'] = 'Receiver user not found';
                }else{
                    $data = array(
                                'sender_id' => $_POST['sender_user'],
                                'receiver_id' => $_POST['receiver_user'],
                                'message' => base64_encode($_POST['message'])
                                );
                    if($this->db->insert('chat', $data)){
                        $insert_id = $this->db->insert_id();
                        //Send notification 
                        $date = date('Y-m-d H:i:s');
                        $title = "New message from ".$sender_user['fullname'];
                        $sender_img= ($sender_user['image'] == "")?"":$this->config->item("profile_path").$sender_user['image'];

                        $msg_status = $this->send_push($sender_user['fullname'], $_POST['sender_user'], $sender_img, $_POST['receiver_user'],'member',$title,$_POST['message'],'chat',$insert_id, $_POST['receiver_user']);
                        $status = json_decode($msg_status);
                        $return_array = array(
                            'sender_user' => $_POST['sender_user'], 
                            'receiver_user' => $_POST['receiver_user'],
                            'message' => $_POST['message'],
                            'created_date' => $date
                        );

                        if($status->success == 0){
                            $response['message'] = 'Server encountered an error because can not fetch device';
                            $response['status'] = false;
                        }else{
                            $response['message'] = 'Message sent';
                            $response['status'] = true;
                            $response['message_data'] = $return_array;
                            //$response['test_data'] = $msg_status;
                        }
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'Server encountered an error. please try again';
                    }
                }

            }
        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function fetch_messages_post(){
        $postFields['sender_user'] = $_POST['member1'];
        $postFields['receiver_user'] = $_POST['member2'];

        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){

            $this->db->select('*');

            $this->db->group_start();
                $this->db->where('sender_id', $_POST['member1']);
                $this->db->where('receiver_id', $_POST['member2']);
            $this->db->group_end();

            $this->db->or_group_start();
                $this->db->where('receiver_id', $_POST['member1']);
                $this->db->where('sender_id', $_POST['member2']);
            $this->db->group_end();

            $limit = 50; // messages per page
            if(isset($_POST['page_number']) && $_POST['page_number'] != "" && $_POST['page_number'] != "1"){
                $start = $limit * ($_POST['page_number'] - 1);
                $this->db->limit($limit, $start);
            }else{
                $this->db->limit($limit);
            }

            $this->db->order_by("id", "desc");
            $this->db->from('chat');
            $sql_query = $this->db->get();

            if ($sql_query->num_rows() > 0){       

                $chat_data = $sql_query->result_array();
                foreach ($chat_data as $key => $value) {
                    $chat_data[$key]['message'] = base64_decode($value['message']);
                }

                $response['status'] = true;
                $response['chat'] = $chat_data;
            }else{
                $response['status'] = true;
                $response['message'] = 'No chat history found';
            }

        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function advertise_get(){
        $advertise = (array)$this->db->get('advertise')->result_array();
        if(empty($advertise)){
            $response['status'] = false;
            $response['message'] = 'No any advertise found';
        
        }else{
            $response['status'] = true;
            $response['advertise'] = $advertise;
        }
        $this->response($response);
    }

    public function add_impression_post(){
        $postFields['advertise'] = $_POST['advertise_id'];
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['advertise_id']));
            $advertise = (array)$this->db->get_where('advertise',$where)->row();
            if(empty($advertise)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{
                $data = array('impression_count' => $advertise['impression_count']+1);
                $this->db->where('id',$_POST['advertise_id']);
                if($this->db->update('advertise',$data)){
                    $response['status'] = true;
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }
            }

        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

    public function logout_post(){
        
        $postFields['member_id'] = $_POST['member_id'];

        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['member_id']), 'deleted_at' => NULL);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{
                $data = array('device_token' => '');
                $this->db->where('id',$_POST['member_id']);
                if($this->db->update('member',$data)){
                    $response['status'] = true;
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Server encountered an error. please try again';
                }
            }

        }else{
            $response['status'] = false;
            $response['message'] = $errorPost;
        }
        $this->response($response);
    }

     public function ValidatePostFields($postFields){
        $error = array();        
        foreach ($postFields as $field => $value){            
            if(!isset($field) || $value == '' || is_null($value)){                
                $error[]= ucfirst(str_replace('_', ' ',$field)) ." field is required";             
            }        
        }    
        return $error;   
    }

}