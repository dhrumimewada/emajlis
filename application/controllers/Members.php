<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$router =& load_class('Router', 'core');
		$method['function'] = $router->fetch_method();
		if($method['function'] != 'login' && $method['function'] != 'register_email_exists')
		{
			if (!$this->session->userdata('admin'))
            {
                redirect('login');
            }
            else
            {
                $session['session'] = $this->session->userdata('admin');
                $member_query = $this->db->query('SELECT * FROM member');
				$data['total_members'] = $member_query->num_rows();
                $this->load->view('header',$method);
                $this->load->view('sidebar');
            }
			
		}
	}

	public function index()
	{
		$data['datatable'] =true;
		$this->load->view('members/members',$data);
		$this->load->view('footer');
	}

	public function add(){


		$validation_rules = array(
					
					array('field' => 'fullname', 'label' => 'full name', 'rules' => 'trim|required|min_length[3]|max_length[30]'),
					array('field' => 'email', 'label' => 'email', 'rules' => 'trim|required|max_length[225]|valid_email|is_unique[member.email]'),
					array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required|min_length[6]'),
					array('field' => 'confirmpassword', 'label' => 'confirm password', 'rules' => 'trim|required|matches[password]'),
					array('field' => 'lat', 'label' => 'address', 'rules' => 'trim|required'),
					array('field' => 'goal_description', 'label' => 'goal description', 'rules' => 'trim'),
					array('field' => 'linkedin_link', 'label' => 'linkedin link', 'rules' => 'trim|valid_url'),
					array('field' => 'twitter_link', 'label' => 'twitter link', 'rules' => 'trim|valid_url'),
					array('field' => 'instagram_link', 'label' => 'instagram link', 'rules' => 'trim|valid_url'),
					array('field' => 'website_link', 'label' => 'website link', 'rules' => 'trim|valid_url')
				);

		$this->form_validation->set_rules($validation_rules);
		
		if($this->form_validation->run() != FALSE){
			$this->db->trans_start();

			$file_upload = true;

			if (isset($_FILES['image']) && !empty($_FILES['image']) && strlen($_FILES['image']['name']) > 0) {

				$config['upload_path'] = FCPATH . $this->config->item("profile_path");
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = false;
				$config['file_name'] = 'member' . '_' . time();
				$config['file_ext_tolower'] = true;
				// $config['max_size'] = '1024';
				// $config['min_width'] = '300';
				// $config['max_width'] = '300';
				// $config['min_height'] = '120';
				// $config['max_height'] = '120';

				$this->load->library('upload');
				$this->upload->initialize($config, true);

				if (!$this->upload->do_upload('image')) {
					$file_upload = false;
					$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
					redirect('members');
				} else {
					$file_upload_data = $this->upload->data();
					$data['image'] = $file_upload_data['file_name'];
				}

			}
			
			if($file_upload){
				// echo "<pre>";
				// print_r($_POST);
				// exit;
				
				$data['fullname'] = ucwords($this->input->post('fullname'));
				$data['email'] = $this->input->post('email');
				$data['password'] = md5($this->input->post('password'));
				$data['address'] = $this->input->post('address');
				$data['lat'] = $this->input->post('lat');
				$data['lang'] = $this->input->post('lang');
				$data['goal_description'] = $this->input->post('goal_description');
				if($this->input->post('current_organization'))
				{
					$data['current_organization'] = $this->input->post('current_organization');
				}
				else
				{
					$data['current_organization'] = '';
				}
				// $data['current_organization'] = '';
				// $data['jobtitle'] = '';
				$data['jobtitle'] = $this->input->post('occupation');
				if(!is_null($this->input->post('gender'))){
					$data['gender'] = $this->input->post('gender');
				}
				// echo "<pre>";
				// print_r($data); exit;
				$this->db->insert('member',$data);
				$insert_id = $this->db->insert_id();
				$this->db->trans_complete();
			}else{
				$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
				redirect('members');
			}
			

			if($insert_id){
				$this->db->trans_start();
				$extrainfo = array( 
                    'member_id' => $insert_id,
                    'linkedin_link' => $this->input->post('linkedin_link'),
                    'twitter_link' => $this->input->post('twitter_link'),
                    'instagram_link' => $this->input->post('instagram_link'),
                    'website_link' => $this->input->post('website_link')
                );
                $this->db->insert('member_extrainfo', $extrainfo);

                if(($this->input->post('lookingfor'))){
	                foreach ($this->input->post('lookingfor') as $key => $value) {
	                	$member_goal = array( 
		                    'member_id' => $insert_id,
		                    'name' => $value
		                );
		                $this->db->insert('member_goal', $member_goal);
	                }
                }

                if(($this->input->post('industry'))){
                	foreach ($this->input->post('industry') as $key => $value) {
	                	$member_industry = array( 
		                    'member_id' => $insert_id,
		                    'industry_id' => $value
		                );
		                $this->db->insert('member_industry', $member_industry);
	                }
                }
                
                if(($this->input->post('interests'))){
                	foreach ($this->input->post('interests') as $key => $value) {
	                	$interests = array( 
		                    'member_id' => $insert_id,
		                    'hashtag_id' => $value
		                );
		                $this->db->insert('member_interests', $interests);
	                }
                }
                
                if(($this->input->post('meeting_preference'))){
            		foreach ($this->input->post('meeting_preference') as $key => $value) {
	                	$meeting_preference = array( 
		                    'member_id' => $insert_id,
		                    'meeting_preference_id' => $value
		                );
		                $this->db->insert('member_meeting_preferences', $meeting_preference);
	                }
                }

                if($this->input->post('position')){
                	$prev_organization = array();
                	foreach ($this->input->post('position') as $key => $value) {
						$prev_organization['member_id'] =  $insert_id;
						$prev_organization['designation'] = $_POST['position'][$key];
						$prev_organization['organization_name'] = $_POST['organization'][$key];
						$this->db->insert('previous_organization',$prev_organization);
					}
                }
 
                if($this->input->post('degree')){
                	$educations = array();
                	foreach ($this->input->post('degree') as $key => $value) {
						$educations['member_id'] =  $insert_id;
						$educations['degree'] = $_POST['degree'][$key];
						$educations['school'] = $_POST['school'][$key];
						$this->db->insert('education',$educations);
					}
                }
				
                $this->db->trans_complete();

                $template_path = BASE_URL().'email_template/welcome.php';
				$to = array($this->input->post('email'));
				$subject = "Emajlis - Welcome";

				$send_mail = sendmail($to, $subject, $template_path);
			}

			

			// print_r($this->db->insert_id());
			// exit;

			if ($this->db->trans_status() === FALSE) {
			    # Something went wrong.
			    $this->db->trans_rollback();
			    $this->session->set_flashdata('message', 'Error into adding member.');
				redirect('members');
			} 
			else {
			    # Everything is Perfect. 
			    # Committing data to the database.
			    $this->db->trans_commit();
			    $this->session->set_flashdata('message', 'Member added successfully.');
				redirect('members');
			}

			
		}
		else
		{
			$data['hashtag'] = $this->admin_Model->get_all_record('hashtag')->result_array();
			$data['looking_for'] = $this->admin_Model->get_all_record('looking_for')->result_array();
			$data['meeting_preference'] = $this->admin_Model->get_all_record('meeting_preferences')->result_array();
			$data['industry'] = $this->admin_Model->get_all_record('industry')->result_array();
			// echo "<pre>";
			// print_r($data['meeting_preference']);
			// exit;
			$this->load->view('members/add',$data);
			$this->load->view('footer');
		}
	}

	public function edit($id = ''){

		$validation_rules = array(
					
					array('field' => 'fullname', 'label' => 'full name', 'rules' => 'trim|required|min_length[3]|max_length[30]'),
					array('field' => 'lat', 'label' => 'address', 'rules' => 'trim|required'),
					array('field' => 'goal_description', 'label' => 'goal description', 'rules' => 'trim'),
					array('field' => 'linkedin_link', 'label' => 'linkedin link', 'rules' => 'trim|valid_url'),
					array('field' => 'twitter_link', 'label' => 'twitter link', 'rules' => 'trim|valid_url'),
					array('field' => 'instagram_link', 'label' => 'instagram link', 'rules' => 'trim|valid_url'),
					array('field' => 'website_link', 'label' => 'website link', 'rules' => 'trim|valid_url')
				);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE)
		{
			$this->db->trans_start();

			$file_upload = true;

			if (isset($_FILES['image']) && !empty($_FILES['image']) && strlen($_FILES['image']['name']) > 0) {

				$config['upload_path'] = FCPATH . $this->config->item("profile_path");
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = false;
				$config['file_name'] = 'member' . '_' . time();
				$config['file_ext_tolower'] = true;

				$this->load->library('upload');
				$this->upload->initialize($config, true);

				if (!$this->upload->do_upload('image')) {
					$file_upload = false;
					$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
					redirect('members');
				} else {
					$file_upload_data = $this->upload->data();
					$data['image'] = $file_upload_data['file_name'];

					//remove old image from folder
					$this->db->select('image');
					$this->db->where('id', $this->input->post('id'));
					$this->db->from('member');
					$sql_query = $this->db->get();
					if ($sql_query->num_rows() > 0) {
						$return_data = $sql_query->row();
						$profile_picture_old = $return_data->image;

						if (isset($profile_picture_old) && !empty($profile_picture_old)) {
							if (file_exists(FCPATH . $this->config->item("profile_path") . $profile_picture_old)) {
								unlink(FCPATH . $this->config->item("profile_path") .  $profile_picture_old);
							}
						}
					}

				}

			}

			$data['fullname'] = ucwords($this->input->post('fullname'));
			$data['address'] = $this->input->post('address');
			$data['lat'] = $this->input->post('lat');
			$data['lang'] = $this->input->post('lang');
			$data['goal_description'] = $this->input->post('goal_description');
			if(!is_null($this->input->post('gender'))){
				$data['gender'] = $this->input->post('gender');
			}

			if($this->input->post('current_organization'))
			{
				$data['current_organization'] = $this->input->post('current_organization');
			}
			else
			{
				$data['current_organization'] = '';
			}
			$data['jobtitle'] = $this->input->post('occupation');
			
			$this->db->where('id',$this->input->post('id'));

			if($this->db->update('member',$data)){

				$extrainfo = array( 
                    'linkedin_link' => $this->input->post('linkedin_link'),
                    'twitter_link' => $this->input->post('twitter_link'),
                    'instagram_link' => $this->input->post('instagram_link'),
                    'website_link' => $this->input->post('website_link')
                );
                $this->db->where('member_id',$this->input->post('id'));
                $this->db->update('member_extrainfo', $extrainfo);

				$this->db->where('member_id',$this->input->post('id'));
				$this->db->delete('member_goal');
				if($this->input->post('lookingfor')){
					foreach ($this->input->post('lookingfor') as $key => $value) {
	                	$member_goal = array( 
		                    'member_id' => $this->input->post('id'),
		                    'name' => $value
		                );
		                $this->db->insert('member_goal', $member_goal);
	                }
				}
                

                $this->db->where('member_id',$this->input->post('id'));
				$this->db->delete('member_industry');
				if($this->input->post('industry')){
					foreach ($this->input->post('industry') as $key => $value) {
	                	$member_industry = array( 
		                    'member_id' => $this->input->post('id'),
		                    'industry_id' => $value
		                );
		                $this->db->insert('member_industry', $member_industry);
	                }
				}
                

                $this->db->where('member_id',$this->input->post('id'));
				$this->db->delete('member_interests');
				if($this->input->post('interests')){
					foreach ($this->input->post('interests') as $key => $value) {
	                	$interests = array( 
		                    'member_id' => $this->input->post('id'),
		                    'hashtag_id' => $value
		                );
		                $this->db->insert('member_interests', $interests);
	                }
				}
                


				$this->db->where('member_id',$this->input->post('id'));
				$this->db->delete('member_meeting_preferences');
				if($this->input->post('meeting_preference')){
					foreach ($this->input->post('meeting_preference') as $key => $value) {
	                	$meeting_preference = array( 
		                    'member_id' => $this->input->post('id'),
		                    'meeting_preference_id' => $value
		                );
		                $this->db->insert('member_meeting_preferences', $meeting_preference);
	                }
				}

				$this->db->where('member_id',$this->input->post('id'));
				$this->db->delete('education');
				if($this->input->post('degree')){
					foreach ($this->input->post('degree') as $key => $value) {
		                $educations['member_id'] =  $this->input->post('id');
						$educations['degree'] = $_POST['degree'][$key];
						$educations['school'] = $_POST['school'][$key];
						$this->db->insert('education',$educations);
	                }
				}

				$this->db->where('member_id',$this->input->post('id'));
				$this->db->delete('previous_organization');
				if($this->input->post('position')){
					foreach ($this->input->post('position') as $key => $value) {
		                $prev_organization['member_id'] =  $this->input->post('id');
						$prev_organization['designation'] = $_POST['position'][$key];
						$prev_organization['organization_name'] = $_POST['organization'][$key];
						$this->db->insert('previous_organization',$prev_organization);
	                }
				}
                
                
                $this->db->trans_complete();
			}

			if ($this->db->trans_status() === FALSE) {
			    # Something went wrong.
			    $this->db->trans_rollback();
			    $this->session->set_flashdata('message', 'Error into updating member.');
				redirect('members');
			} 
			else {
			    # Everything is Perfect. 
			    # Committing data to the database.
			    $this->db->trans_commit();
			    $this->session->set_flashdata('message', 'Member updated successfully.');
				redirect('members');
			}

		}
		else
		{
			$data['member'] = $this->admin_Model->get_single_record('member',$id)->row();
			
			if(!empty($data['member']))
			{
				$data['hashtag'] = $this->admin_Model->get_all_record('hashtag')->result_array();
				$data['looking_for'] = $this->admin_Model->get_all_record('looking_for')->result_array();
				$data['meeting_preference'] = $this->admin_Model->get_all_record('meeting_preferences')->result_array();
				$data['industry'] = $this->admin_Model->get_all_record('industry')->result_array();

				$where = array('member_id' => $id);
				$data['member_info'] = $this->admin_Model->get_where('member_extrainfo',$where)->row();
				$data['member_education'] = $this->admin_Model->get_where('education',$where)->result_array();
				$data['member_previous_organization'] = $this->admin_Model->get_where('previous_organization',$where)->result_array();
				$data['member_industry'] = $this->admin_Model->get_where('member_industry',$where)->result_array();
				$data['member_hashtag'] = $this->admin_Model->get_where('member_interests',$where)->result_array();
				$data['member_goal'] = $this->admin_Model->get_where('member_goal',$where)->result_array();
				$data['member_meeting_preference'] = $this->admin_Model->get_where('member_meeting_preferences',$where)->result_array();
				// echo "<pre>";
				// //print_r(in_array(9,array_column($data['member_meeting_preference'], 'id')));
				//print_r($data);
				//exit;

				$this->load->view('members/edit',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('members');
			}
		}
		
	}

}
