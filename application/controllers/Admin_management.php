<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_management extends CI_Controller {

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

	public function index()
	{
		$this->load->view('admin_management/index');
		$this->load->view('footer');
	}

	public function post()
	{
		$validation_rules = array(
					
			array('field' => 'username', 'label' => 'full name', 'rules' => 'trim|required|min_length[2]|max_length[30]'),
			array('field' => 'email', 'label' => 'email', 'rules' => 'trim|required|max_length[225]|valid_email|is_unique[admin.email]'),
			array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required|min_length[6]'),
			array('field' => 'c_password', 'label' => 'confirm password', 'rules' => 'trim|required|matches[password]')
		);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE)
		{
			$data['username'] = ucwords($this->input->post('username'));
			$data['email'] = $this->input->post('email');
			$data['password'] = md5($this->input->post('password'));
		    $this->db->insert('admin',$data);
		    $this->session->set_flashdata('message', 'Admin added successfully.');
		 	redirect('admins');
		}
		else
		{
			$this->load->view('admin_management/post');
			$this->load->view('footer');
		}
	}

	// public function isexists_hashtag($hashtag_name = NULL, $id = NULL) {
	// 	$this->db->select('id');
	// 	if (isset($id) && !is_null($id)) {
	// 		$this->db->where('id !=', $id);
	// 	}
	// 	$this->db->where('tag_name', $hashtag_name);
	// 	$this->db->from('hashtag');
	// 	$sql_query = $this->db->get();
	// 	if ($sql_query->num_rows() > 0) {
	// 		$this->form_validation->set_message('isexists_hashtag', 'This hashtag name already exists.');
	// 		return False;
	// 	} else {
	// 		return True;
	// 	}
	// }

	public function put($id = '')
	{

		$validation_rules = array(
			array('field' => 'username', 'label' => 'full name', 'rules' => 'trim|required|min_length[2]|max_length[30]')
		);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE)
		{
			$data['username'] = ucwords($this->input->post('username'));
		    $this->db->update('admin',$data,array('id' => $this->input->post('id')));
		    $this->session->set_flashdata('message', 'Admin updated successfully.');
		 	redirect('admins');

		}
		else
		{
			$data['admin'] = $this->admin_Model->get_single_record('admin',$id)->row();
			if(!empty($data['admin'])){
				$this->load->view('admin_management/put',$data);
				$this->load->view('footer');
			}
			else{
				redirect('admins');
			}
			
		}
		
	}
}
