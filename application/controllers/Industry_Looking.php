<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Industry_Looking extends CI_Controller {

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
		$this->load->view('industry_looking/industry_looking');
		$this->load->view('footer');
	}

	public function add()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|min_length[3]|max_length[50]|is_unique[looking_for.name]');

		if($this->form_validation->run() != FALSE)
		{
			$data['name'] = $this->input->post('name');
			$data['description'] = $this->input->post('description');
		    $this->db->insert('looking_for',$data);
		    $this->session->set_flashdata('message', 'Goal added successfully.');
		 	redirect('industry-looking-for');
		}
		else
		{
			$this->load->view('industry_looking/add');
			$this->load->view('footer');
		}
	}

	public function edit($id = '')
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|min_length[3]|max_length[50]|callback_isexists_goal[' . $this->input->post('id') . ']');

		if($this->form_validation->run() != FALSE)
		{
			$data['name'] = $this->input->post('name');
			$data['description'] = $this->input->post('description');
     		$this->db->update('looking_for',$data,array('id' => $this->input->post('id')));
     		$this->session->set_flashdata('message', 'Goal updated successfully.');
			redirect('industry-looking-for');
		}
		else
		{
			$data['industry_looking'] = $this->admin_Model->get_single_record('looking_for',$id)->row();
			if(!empty($data['industry_looking']))
			{
				$this->load->view('industry_looking/edit',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('industry-looking-for');
			}
		}
		
	}

	public function isexists_goal($goal_name = NULL, $id = NULL) {
		$this->db->select('id');
		if (isset($id) && !is_null($id)) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('name', $goal_name);
		$this->db->from('looking_for');
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			$this->form_validation->set_message('isexists_goal', 'This goal name already exists.');
			return False;
		} else {
			return True;
		}
	}
}
