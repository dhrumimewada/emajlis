<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Industry extends CI_Controller {

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
		$this->load->view('industry/index');
		$this->load->view('footer');
	}

	public function add()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|min_length[3]|max_length[50]|is_unique[industry.name]');
		if($this->form_validation->run() != FALSE)
		{
			$data['name'] = $this->input->post('name');

		    $this->db->insert('industry',$data);
		    $this->session->set_flashdata('message', 'Industry added successfully.');
		 	redirect('industry');
		}
		else
		{
			$this->load->view('industry/add');
			$this->load->view('footer');
		}
	}

	public function edit($id = '')
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|min_length[3]|max_length[50]|callback_isexists_industry[' . $this->input->post('id') . ']');
		if($this->form_validation->run() != FALSE)
		{
			$data['name'] = $this->input->post('name');
     		$this->db->update('industry',$data,array('id' => $this->input->post('id')));
     		$this->session->set_flashdata('message', 'Industry updated successfully.');
			redirect('industry');
		}
		else
		{
			$data['industry'] = $this->admin_Model->get_single_record('industry',$id)->row();
			if(!empty($data['industry']))
			{
				$this->load->view('industry/edit',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('industry');
			}
		}
		
	}

	public function isexists_industry($industry_name = NULL, $id = NULL) {
		$this->db->select('id');
		if (isset($id) && !is_null($id)) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('name', $industry_name);
		$this->db->from('industry');
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			$this->form_validation->set_message('isexists_industry', 'This industry name already exists.');
			return False;
		} else {
			return True;
		}
	}
}
