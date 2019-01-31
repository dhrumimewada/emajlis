<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin_Model');
	}

	public function test()
	{
		$feed = simplexml_load_file("http://feeds.bbci.co.uk/news/health/rss.xml");
		$namespaces = $feed->getNamespaces(true);

		echo "<pre>"; 
		foreach ($feed->channel->item as $key => $value){
			$title = trim((string) $value->title);
			$link  = trim((string) $value->link); 
			$desc=$value->description=htmlspecialchars(trim($value->description));
			$pub=date("Y-m-d H:i:s", strtotime($value->pubDate));

			$image = $value->children($namespaces['media'])->thumbnail[0]->attributes();
			$image_link = (array)$image['url'];

			// foreach($image as $key1 => $value1) {
			//     print_r((array)$value1);
			// }

			$data = array( 
		                    'title'=>$title,
		                    'description'=>$desc,
		                    'link'=>$link,
		                    'image_link'=>$image_link[0],
		                    'fetch_date'=>$pub          
		                );  

			print_r($data);
		}
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
	            		$image = $value->children($namespaces['media'])->thumbnail->attributes();
						$image_link = (array)$image['url'];

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
		                    'image_link'=>$image_link[0],
		                    'fetch_date'=>$pub          
		                );  
		                // echo "<pre>"; 
		                // print_r($data);
		                // exit;
		                
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
		//$this->db->where('id', '107');
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

	public function send_sayhello_push_notifications(){
		$memberss = array('463','462','461','460');
		$this->db->select('id,device_token,device_type,fullname');
		//$this->db->where('status', '1');
		// $this->db->where('device_token !=', '');
		// $this->db->where('device_type !=', '');
		$this->db->where_in('id', $memberss);
		$this->db->from('member');
        $sql_query = $this->db->get();
        if ($sql_query->num_rows() > 0){
        	$member_data = $sql_query->result_array();

        	$this->db->select('member_id,friend_id');
			$this->db->where('friendship_status', '1');
			$this->db->where('matched', '1');
			$this->db->where_in('member_id', array_column($member_data, 'id'));
			$this->db->from('friends');
			$sql_query = $this->db->get();
			$friends_data = array();
			if ($sql_query->num_rows() > 0){
				$friends_data = $sql_query->result_array();
				$send_notification_users = array();
				$waiting_friends = array();

				foreach ($friends_data as $key => $value) {

					$this->db->select('id');
					$this->db->group_start();
	                    $this->db->where("sender_id",$value['member_id']);
	                    $this->db->where("receiver_id",$value['friend_id']);
	                $this->db->group_end();

	                $this->db->or_group_start();
                        $this->db->where("sender_id",$value['friend_id']);
                        $this->db->where("receiver_id",$value['member_id']);
                    $this->db->group_end();

                    $this->db->limit(1);
                    $this->db->from('chat');
                    $sql_query = $this->db->get();

					if ($sql_query->num_rows() > 0){
						
					}else{
						$waiting_friends[$value['member_id']][] = $value['friend_id'];
					}
				}


			}else{
				echo "No any data found";
			}

			echo "<pre>";
			$query = $this->db->last_query();
        	// print_r($member_data);
        	print_r($waiting_friends);
        	// print_r($send_notification_users);
        	//print_r($Not_chat_data_all);
        	exit;

        	//$push_message = "Checkout new newsfeeds";
        	$push_title = "Emjalis Newsfeed";
        	//$push_data = array('message' => $push_message);
        	$push_data = array('message' => '');
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
        	
        	foreach ($waiting_friends as $key => $value) {

        		$this->db->select('device_token,device_type');
				$this->db->where('id', $key);
				$this->db->from('member');
				$sql_query = $this->db->get();
				if ($sql_query->num_rows() > 0){
					$member_device_data = $sql_query->row();

					$fcmFields['to'] = $member_device_data->device_token;

					$total_waiting_friends = count($waiting_friends[$key]);
					if($total_waiting_friends > 1){
						$fcmFields['data']['body']['message'] = $total_waiting_friends." people are waiting for your message";
					}else{
						$fcmFields['data']['body']['message'] = "Someone waiting for your message";
					}

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

				}else{
					echo "Device token not found";
				}

        		
        	}
        }else{
        	echo "No any member found";
        }
	}
}
