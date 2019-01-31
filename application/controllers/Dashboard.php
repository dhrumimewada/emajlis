<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_Model');

		$router =& load_class('Router', 'core');
		$method['function'] = $router->fetch_method();	
			if (!$this->session->userdata('admin'))
            {
                redirect('login');
            }
            else
            {
                $session['session'] = $this->session->userdata('admin');
                $this->load->view('header',$method);
                $this->load->view('sidebar',$method);
                $this->load->view('footer',$method);
            }
	}

	public function index()
	{
		$data['recent_member_list'] = $recent_member_list = $this->db->query('select * from member where deleted_at IS NULL order by id desc limit 5')->result_array();
		$this->load->view('dashboard',$data);
	}
}
