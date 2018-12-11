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
            $where = array('email' => $_POST['email'],'password' => md5($_POST['password']),'status' => 1);
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'The email/password that you have entered is incorrect';
            
            }else{
                $data = array(
                    'device_type' => $_POST['device_type'],
                    'device_token' => $_POST['device_token'],
                    'lat' => $_POST['lat'],
                    'lang' => $_POST['lang']
                     );
                $this->db->where('id',$user['id']);
                if($this->db->update('member',$data)){
                    $response['status'] = true;
                    $response['profile'] = $user;
                }else{
                    $response['status'] = false;
                    $response['message'] = 'Error into updating device token';
                }
                
            }
            
        }
        else{
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
        $postFields['lat'] = $_POST['lat'];
        $postFields['lang'] = $_POST['lang'];        

        $errorPost = $this->ValidatePostFields($postFields);  
        if(empty($errorPost)){

            $where = array('email' => $_POST['email']);
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
                        'fullname' => $_POST['fullname'], 
                        'email'=> $_POST['email'], 
                        'password' => md5($_POST['password']),
                        'device_token'=> $_POST['device_token'], 
                        'device_type'=> $_POST['device_type'], 
                        'phone_no'=> $_POST['phone_no'],
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

                        $response['status'] = true;
                        $response['profile'] = $user_data;

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
            $where = array('id' => $_POST['member_id']);
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
            $where = array('id' => $_POST['member_id'],'password' => md5($_POST['current_password']));
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
            $where = array('email' => $_POST['email'],'status' => '1');
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';
            }else{

                //$from = "excellentwebworld@admin.com";
                $from = '"Emajlis" <excellentwebworld@admin.com>';
                $to = $this->input->post("email");
                $subject = "Reset your emajlis password";
                $message = "Hi,"."\n\n"; 
                $message .= "We heard that you lost your Emajlis password. Sorry about that!"."\n\n"; 
                $message .= "But do not worry! You can use the following link to reset your password:"."\n\n"; 
                $link = base_url()."reset-password/".md5($user['id']);
                $message .= "$link";
                $message .= "\n\n"."Thanks"."\n"; 
                $message .= "Emajlis team"."\n"; 
 
                $config['protocol'] = $this->config->item("protocol");
                $config['smtp_host'] = $this->config->item("smtp_host");
                $config['smtp_port'] = $this->config->item("smtp_port");
                $config['smtp_user'] = $this->config->item("smtp_user");
                $config['smtp_pass'] = $this->config->item("smtp_pass");
                $config['charset'] = $this->config->item("charset");
                $config['mailtype'] = $this->config->item("mailtype");

                $this->load->library('email', $config);
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

    public function myprofile_old_post(){

        $postFields['member_id'] = $_POST['member_id']; 

        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost)){
            $user = array();
            $sql_select = array("t1.*", "t2.social_id", "t2.social_type", "t2.education", "t2.linkedin_link" , "t2.twitter_link", "t2.instagram_link", "t2.website_link", "t2.about_goal");
            //$sql_select = array("t1.*", "t2.social_id", "t2.social_type");
            $this->db->select($sql_select);
            $this->db->where("t1.status", 1);
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
            $sql_select = array("t2.*");
            $this->db->select($sql_select);
            $this->db->where("t1.member_id", $_POST['member_id']);
            $this->db->from('member_goal t1');
            $this->db->join('looking_for t2', 't1.lookingfor_id = t2.id', "left join");
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
                $response['message'] = 'user not found';
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

    public function myprofile_post(){

        $postFields['member_id'] = $_POST['member_id']; 

        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost)){
            $user = array();
            $sql_select = array("t1.*", "t2.social_id", "t2.social_type", "t2.linkedin_link" , "t2.twitter_link", "t2.instagram_link", "t2.website_link");
            $this->db->select($sql_select);
            $this->db->where("t1.status", 1);
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
            $sql_select = array("t2.*");
            $this->db->select($sql_select);
            $this->db->where("t1.member_id", $_POST['member_id']);
            $this->db->from('member_goal t1');
            $this->db->join('looking_for t2', 't1.lookingfor_id = t2.id', "left join");
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
            $where = array('id' => $_POST['member_id'],'status' => '1');
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => intval($_POST['member_id']));
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

    public function goal_get(){
        $goal = (array)$this->db->get('looking_for')->result_array();
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
        $postFields['goal_description'] = $_POST['goal_description'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']));
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $where = array('member_id' => $_POST['member_id']);
                $this->db->delete('member_goal',$where);

                $goal_data = explode(',',$_POST['goal']);
                foreach ($goal_data as $key => $value) {
                    $data = array('member_id' => intval($_POST['member_id']), 'lookingfor_id' => intval($value));
                    $this->db->insert('member_goal', $data);
                }

                $data_desc = array('goal_description' => $_POST['goal_description']);
                $this->db->where('id',$_POST['member_id']);
                if($this->db->update('member',$data_desc)){
                    $response['status'] = true;
                    $response['message'] = 'Goal saved';
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

    public function add_prev_organization_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['organization_name'] = $_POST['organization_name'];               
        $postFields['designation'] = $_POST['designation'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1');
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
            $where = array('id' => $_POST['member_id'],'status' => '1');
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
            $where = array('id' => $_POST['member_id'],'status' => '1');
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
            $where = array('id' => intval($_POST['member_id']));
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

    public function save_education_old_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['education'] = $_POST['education'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']));
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{
           
                $data = array('education' => $_POST['education']);
                $this->db->where('member_id', $_POST['member_id']);
                if($this->db->update('member_extrainfo', $data)){
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

    public function add_education_post(){
        $postFields['member_id'] = $_POST['member_id'];        
        $postFields['degree'] = $_POST['degree'];               
        $postFields['school'] = $_POST['school'];               
        $errorPost = $this->ValidatePostFields($postFields);

        if(empty($errorPost))
        {
            $where = array('id' => $_POST['member_id'],'status' => '1');
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => $_POST['member_id'],'status' => '1');
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => intval($_POST['member_id']));
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
            $where = array('id' => intval($_POST['member_id']));
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

    public function discover_post(){
        $postFields['member_id'] = $_POST['member_id'];    
        if(empty($errorPost))
        {
            $where = array('id' => intval($_POST['member_id']));
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'User not found';   
            }else{

                $matched = array();

                // get goal macthed members
                $goal_matched_members = array();
                $goal_list = array();
                $this->db->select('lookingfor_id');
                $this->db->where("member_id", $_POST['member_id']);
                $this->db->from('member_goal');
                $sql_query = $this->db->get();
                if ($sql_query->num_rows() > 0) {
                    $result_array = $sql_query->result_array();
                    foreach ($result_array as $key => $value) {
                        array_push($goal_list,$value['lookingfor_id']);
                    }
                }

                if(is_array($goal_list) && !empty($goal_list)){
                    $this->db->select('member_id'); 
                    $this->db->where_in('lookingfor_id',$goal_list); 
                    $this->db->from('member_goal'); 
                    $sql_query = $this->db->get();
                    if ($sql_query->num_rows() > 0) {
                        $user_goal_matches = $sql_query->result_array();
                        foreach ($user_goal_matches as $key => $value) {
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id'])){
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
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id'])){
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
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id'])){
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
                            if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id'])){
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
                                if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id'])){
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
                                if ((!in_array($value['id'], $matched)) && ($_POST['member_id'] != $value['id'])){
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
                                if ((!in_array($value['member_id'], $matched)) && ($_POST['member_id'] != $value['member_id'])){
                                    array_push($matched,$value['member_id']);
                                }
                            }
                        }
                    }
                }



                $profile_array = array();
                if(is_array($matched) && !empty($matched)){
                    foreach ($matched as $key => $value) {
                        $user = array();
                        $sql_select = array("t1.*","t2.social_id", "t2.social_type","t2.linkedin_link" , "t2.twitter_link", "t2.instagram_link", "t2.website_link", "t2.about_goal");
                        $this->db->select($sql_select);
                        $this->db->where("t1.status", 1);
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
                        $sql_select = array("t2.*");
                        $this->db->select($sql_select);
                        $this->db->where("t1.member_id", $value);
                        $this->db->from('member_goal t1');
                        $this->db->join('looking_for t2', 't1.lookingfor_id = t2.id', "left join");
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

                        $profile_array[$key]['user_info'] = $user;
                        $profile_array[$key]['previous_organization'] = $previous_organization;
                        $profile_array[$key]['education'] = $education;
                        $profile_array[$key]['user_hashtags'] = $member_interests;
                        $profile_array[$key]['user_goal'] = $user_goal;
                        $profile_array[$key]['favorite_ways_meeting'] = $favorite_ways_meeting;
                        $profile_array[$key]['industry'] = $industry;
                    }
                }
                
                $response['matched_profiles'] = $profile_array;

            }
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
        $goal = $_POST['goals']; 
        $industry = $_POST['industry']; 
        $meeting_pref = $_POST['favorite_ways_meeting']; 

        if(!empty($hashtag) || !empty($goal) || !empty($industry) || !empty($meeting_pref)){
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

            if(!empty($goal)){
                $this->db->select('member_id'); 
                $this->db->where_in('lookingfor_id',$goal); 
                $this->db->from('member_goal'); 
                $sql_query = $this->db->get();
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

            if(is_array($matched) && !empty($matched)){
                 foreach ($matched as $key => $value){

                    $user = array();
                    $sql_select = array("t1.*", "t2.*");
                    $this->db->select($sql_select);
                    $this->db->where("t1.status", 1);
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
                    $sql_select = array("t2.*");
                    $this->db->select($sql_select);
                    $this->db->where("t1.member_id", $value);
                    $this->db->from('member_goal t1');
                    $this->db->join('looking_for t2', 't1.lookingfor_id = t2.id', "left join");
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

                    $profile_array[$key]['user_info'] = $user;
                    $profile_array[$key]['previous_organization'] = $previous_organization;
                    $profile_array[$key]['user_hashtags'] = $member_interests;
                    $profile_array[$key]['user_goal'] = $user_goal;
                    $profile_array[$key]['favorite_ways_meeting'] = $favorite_ways_meeting;
                    $profile_array[$key]['industry'] = $industry;

                 }
            }

            $response['filter_search'] = $profile_array;

        }else{
            $response['status'] = false;
            $response['message'] = 'At least one value is required';   
        }

        $this->response($response);   
    }

    public function rss_feed_post($postFields){
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

    public function delete_member_post($postFields){
        $postFields['member_id'] = $_POST['member_id'];
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['member_id']));
            $user = (array)$this->db->get_where('member',$where)->row();
            if(empty($user)){
                $response['status'] = false;
                $response['message'] = 'user not found';   
            }else{
                $this->db->where('id',$_POST['member_id']);
                if($this->db->delete('member')){
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


    public function send_push($sender_name = '', $sender_id = '', $sender_img = '', $user_id = '',$user_type = '',$push_title = '',$push_message = '',$message_type = ''){
        if($user_id != '' && $user_type != ''){

            $this->db->select(array('device_type','device_token'));
            $row = (array)$this->db->get_where($user_type,array('id' => $user_id))->row();

            $key = $this->config->item('fcm_key');
            define('API_ACCESS_KEY', $key);
            $token = $row['device_token']; 

            $push_data = array('message' => $push_message,'sender_id' => $sender_id ,'sender_name' => $sender_name, 'sender_img' => $sender_img);

            if($row['device_type'] == 1){
                $fcmFields = array(
                    'priority' => 'high',
                    'to' => $token,
                    'sound' => 'default',
                    'notification' => array( 
                        "title"=> $push_title,
                        "body"=> $push_data,
                        "type"=> $message_type,
                        )
                    );

            }else{
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
            //echo $result . "\n\n";
        }

    }

    public function testtest_post(){
        //print_r('sdcvsdvc');
        $this->send_push('27','member','dhrumi test','This is the test push notification from dhrumi','test_msg');
    }

    public function send_message_post($postFields){
        $postFields['sender_user'] = $_POST['sender_user'];
        $postFields['receiver_user'] = $_POST['receiver_user'];
        $postFields['message'] = $_POST['message'];
        $errorPost = $this->ValidatePostFields($postFields);
        if(empty($errorPost)){
            $where = array('id' => intval($_POST['sender_user']));
            $sender_user = (array)$this->db->get_where('member',$where)->row();
            if(empty($sender_user)){
                $response['status'] = false;
                $response['message'] = 'Sender user not found';   
            }else{
                $where = array('id' => intval($_POST['receiver_user']));
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
                        //Send notification 
                        $title = "New message from ".$sender_user['fullname'];
                        $sender_img= ($sender_user['image'] == "")?"":$this->config->item("profile_path").$sender_user['image'];
                        $this->send_push($sender_user['fullname'], $_POST['sender_user'], $sender_img, $_POST['receiver_user'],'member',$title,$_POST['message'],'chat');

                        $response['status'] = true;
                        $response['message'] = 'Message sent';
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

    public function fetch_messages_post($postFields){
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