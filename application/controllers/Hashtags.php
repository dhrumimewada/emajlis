<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hashtags extends CI_Controller {

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
                $this->load->view('header',$method);
                $this->load->view('sidebar',$method);
            }
			
		}
	}

	public function index(){
		$this->load->view('hashtags/hashtags');
		$this->load->view('footer');
	}

	public function add(){
		$validation_rules = array(
					
					array('field' => 'tag_name', 'label' => 'hashtag name', 'rules' => 'trim|required|min_length[2]|max_length[30]|is_unique[hashtag.tag_name]'),
					array('field' => 'newsfeed_url', 'label' => 'newfeed url', 'rules' => 'trim|required|valid_url'),
					array('field' => 'description', 'label' => 'description', 'rules' => 'trim')
				);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE){
			$data['tag_name'] = str_replace(' ', '',ucwords($this->input->post('tag_name')));
			$data['newsfeed_url'] = $this->input->post('newsfeed_url');
			$data['description'] = $this->input->post('description');
		    $this->db->insert('hashtag',$data);
		    $this->session->set_flashdata('message', 'Hashtag added successfully.');
		 	redirect('hashtags');
		}
		else
		{
			$this->load->view('hashtags/add');
			$this->load->view('footer');
		}
	}

	public function isexists_hashtag($hashtag_name = NULL, $id = NULL) {
		$this->db->select('id');
		if (isset($id) && !is_null($id)) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('tag_name', $hashtag_name);
		$this->db->from('hashtag');
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			$this->form_validation->set_message('isexists_hashtag', 'This hashtag name already exists.');
			return False;
		} else {
			return True;
		}
	}

	public function edit($id = ''){

		$validation_rules = array(
					
					array('field' => 'tag_name', 'label' => 'hashtag name', 'rules' => 'trim|required|min_length[2]|max_length[30]|callback_isexists_hashtag[' . $this->input->post('id') . ']'),
					array('field' => 'newsfeed_url', 'label' => 'newfeed url', 'rules' => 'trim|required|valid_url'),
					array('field' => 'description', 'label' => 'description', 'rules' => 'trim')
				);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE){
			//echo '<pre>'; print_r($_POST); exit;
			$data['tag_name'] = ucfirst($this->input->post('tag_name'));
			$data['newsfeed_url'] = $this->input->post('newsfeed_url');
			$data['description'] = $this->input->post('description');

     		$this->db->update('hashtag',$data,array('id' => $this->input->post('id')));
     		$this->session->set_flashdata('message', 'Hashtag updated successfully.');
			redirect('hashtags');
		}else{
			$data['hashtag'] = $this->admin_Model->get_single_record('hashtag',$id)->row();
			if(!empty($data['hashtag']))
			{
				$this->load->view('hashtags/edit',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('hashtags');
			}
			
		}
		
	}
}
