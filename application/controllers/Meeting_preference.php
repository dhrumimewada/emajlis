<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting_preference extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_Model');

		$router =& load_class('Router', 'core');
		$method['function'] = $router->fetch_method();
		if($method['function'] != 'login')
		{
			if (!$this->session->userdata('admin'))
            {
                redirect('login');
            }
            else
            {
                $session['session'] = $this->session->userdata('admin');
                $this->load->view('header',$method);
                $this->load->view('sidebar',$method);
            }
			
		}
	}

	public function index()
	{
		$this->load->view('meeting_preference/index');
		$this->load->view('footer');
	}

	public function add()
	{
		$this->form_validation->set_rules('preference_type', 'meeting preference', 'trim|required|min_length[3]|max_length[50]|is_unique[meeting_preferences.preference_type]');
		if($this->form_validation->run() != FALSE)
		{
			$file_upload = true;
			if (isset($_FILES['image']) && !empty($_FILES['image']) && strlen($_FILES['image']['name']) > 0) {

				$config['upload_path'] = FCPATH . $this->config->item("meeting_pref_path");
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = false;
				$config['file_name'] = 'meeting_pref' . '_' . time();
				$config['file_ext_tolower'] = true;
				// $config['max_size'] = '1024';
				// $config['min_width'] = '300';
				 //$config['max_width'] = '48';
				// $config['min_height'] = '120';
				 //$config['max_height'] = '48';

				$this->load->library('upload');
				$this->upload->initialize($config, true);

				if (!$this->upload->do_upload('image')) {
					$file_upload = false;
					$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
					redirect('meeting_preference');
				} else {
					$file_upload_data = $this->upload->data();
					$data['image_name'] = $file_upload_data['file_name'];
				}

			}
			if($file_upload){
				$data['preference_type'] = ucfirst($this->input->post('preference_type'));
			    $this->db->insert('meeting_preferences',$data);
			    $this->session->set_flashdata('message', 'Meeting preference added successfully.');
			 	redirect('meeting_preference');
			}else{
				$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
				redirect('meeting_preference');
			}
			
		}
		else
		{
			$this->load->view('meeting_preference/add');
			$this->load->view('footer');
		}
	}

	public function edit($id = '')
	{
		$this->form_validation->set_rules('preference_type', 'meeting preference', 'trim|required|min_length[3]|max_length[50]|callback_isexists_meeting_preference[' . $this->input->post('id') . ']');
		if($this->form_validation->run() != FALSE)
		{
			$file_upload = true;
			// echo "<pre>";
			// print_r($_POST);
			// print_r($_FILES);
			// exit;
			if (isset($_FILES['image']) && !empty($_FILES['image']) && strlen($_FILES['image']['name']) > 0) {

				$config['upload_path'] = FCPATH . $this->config->item("meeting_pref_path");
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = false;
				$config['file_name'] = 'meeting_pref' . '_' . time();
				$config['file_ext_tolower'] = true;
				// $config['max_size'] = '1024';
				// $config['min_width'] = '300';
				 //$config['max_width'] = '48';
				// $config['min_height'] = '120';
				 //$config['max_height'] = '48';

				$this->load->library('upload');
				$this->upload->initialize($config, true);

				if (!$this->upload->do_upload('image')) {
					$file_upload = false;
					$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
					redirect('meeting_preference');
				} else {
					$file_upload_data = $this->upload->data();
					$data['image_name'] = $file_upload_data['file_name'];
				}

			}
			if($file_upload){
				$data['preference_type'] = $this->input->post('preference_type');
	     		$this->db->update('meeting_preferences',$data,array('id' => $this->input->post('id')));
	     		$this->session->set_flashdata('message', 'meeting_preference updated successfully.');
				redirect('meeting_preference');
			}else{
				$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
				redirect('meeting_preference');
			}
			
		}
		else
		{
			$data['meeting_preference'] = $this->admin_Model->get_single_record('meeting_preferences',$id)->row();
			if(!empty($data['meeting_preference']))
			{
				$this->load->view('meeting_preference/edit',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('meeting_preference');
			}
		}
		
	}

	public function isexists_meeting_preference($meeting_preference_name = NULL, $id = NULL) {
		$this->db->select('id');
		$this->db->where('id !=', $id);
		$this->db->where('preference_type', $meeting_preference_name);
		$this->db->from('meeting_preferences');
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			$this->form_validation->set_message('isexists_meeting_preference', 'This meeting preference name already exists.');
			return False;
		} else {
			return True;
		}
	}
}
