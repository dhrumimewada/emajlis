<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin_Model');
	}

	public function fetch_rss_feeds(){
		if($this->db->truncate('newsfeed')){
			$hashtags = $this->admin_Model->get_all_record('hashtag')->result_array();
			foreach ($hashtags as $key => $hashtag) {       
				if($hashtag['newsfeed_url'] != ''){

					$feed = simplexml_load_file($hashtag['newsfeed_url']);
					$namespaces = $feed->getNamespaces(true);

	            	foreach ($feed->channel->item as $key => $value){
	            		$desc=$value->description=htmlspecialchars(trim($value->description));
	            		if($desc == ''){
	            			continue;
	            		}
	            		$image = $value->children($namespaces['media'])->thumbnail[5]->attributes();
						$image_link = $image['url'];

						$title = trim((string) $value->title);
						$link  = trim((string) $value->link); 

	            		$title=$value->title;
		                
		                $link=$value->link;
		                $pub=date("Y-m-d H:i:s", strtotime($value->pubDate));


		                $data = array( 
		                    'hashtag_id'=>$hashtag['id'],
		                    'title'=>$title,
		                    'description'=>$desc,
		                    'link'=>$link,
		                    'image_link'=>$image_link,
		                    'fetch_date'=>$pub          
		                );  
		                
		                if($this->db->insert('newsfeed', $data)){
		                	echo "Success.";
		                }else{
		                	echo "Fail insertion.";
		                }
	            	}
				}
			}
			return TRUE;
		}else{
			echo "Fail for empty newsfeed table";
			return FALSE;
		}
	}

	public function send_feed_push_notifications(){
		$this->db->select('device_token,device_type');
		$this->db->where('status', '1');
		$this->db->where('device_token !=', '');
		$this->db->where('device_type !=', '');
		$this->db->where('id', '107');
		$this->db->from('member');
        $sql_query = $this->db->get();
        if ($sql_query->num_rows() > 0){
        	$member_data = $sql_query->result_array();

        	$push_message = "Checkout new newsfeeds";
        	$push_title = "Emjalis Newsfeed";
        	$push_data = array('message' => $push_message);
        	$message_type = "daily_newsfeed";
        	$fcmFields = array(
                    'priority' => 'high',
                    'to' => '',
                    'sound' => 'default',
                    'data' => array( 
                        "title"=> $push_title,
                        "body"=> $push_data,
                        "type"=> $message_type,
                        )
                    );

        	$fcm_key = $this->config->item('fcm_key');
            define('API_ACCESS_KEY', $fcm_key);
        	$headers = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json');
        	echo "<pre>";
        	foreach ($member_data as $key => $value) {
        		
        		$fcmFields['to'] = $value['device_token'];

        		$ch = curl_init();
	            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	            curl_setopt( $ch,CURLOPT_POST, true );
	            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
	            $result = curl_exec($ch );
	            curl_close( $ch );
	            print_r($fcmFields);
	            print_r($result);
	            // print_r("send");

        	}
        }
	}
}
