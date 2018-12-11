<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_profile extends CI_Controller {

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

	public function admin_profile(){

		$validation_rules = array(
					
					array('field' => 'username', 'label' => 'full name', 'rules' => 'trim|required|min_length[2]|max_length[30]')
				);

		$this->form_validation->set_rules($validation_rules);
		if($this->form_validation->run() != FALSE){

			$data['username'] = ucfirst($this->input->post('username'));

     		$this->db->where('id',intval($this->input->post('id')));
     		$this->db->update('admin',$data);
     		$this->session->set_flashdata('message', 'Profile updated successfully.');
			redirect('dashboard');

		}else{

			$session_data= $this->session->userdata('admin');
			$data['profile'] = $this->admin_Model->get_single_record('admin',$session_data['id'])->row();
			$this->load->view('admin/profile', $data);
			$this->load->view('footer');

		}
		
	}

	public function checkpw($str) {
		$session_data= $this->session->userdata('admin');

		$this->db->select('password');
		$this->db->where('id',$session_data['id']);
		$this->db->from('admin');
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			$data = $sql_query->row();
			if (md5($str) !== $data->password){
				$this->form_validation->set_message('checkpw', 'The current password is incorrect');
				return FALSE;
			}else{
				return TRUE;
			}
		} 
	}

	public function admin_change_password(){

		$validation_rules = array(
					array('field' => 'password', 'label' => 'current password', 'rules' => 'trim|required|callback_checkpw'),
					array('field' => 'new_password', 'label' => 'new password', 'rules' => 'trim|required|min_length[6]|max_length[50]'),
					array('field' => 'c_password', 'label' => 'confirm new password', 'rules' => 'trim|required|matches[new_password]')
				);

		$this->form_validation->set_rules($validation_rules);
		if($this->form_validation->run() != FALSE){

			$session_data= $this->session->userdata('admin');
			$data['password'] = md5($this->input->post('new_password'));
     		$this->db->where('id',$session_data['id']);
     		$this->db->update('admin',$data);
     		$this->session->set_flashdata('message', 'Password updated successfully.');
			redirect('dashboard');

		}else{
			
			$this->load->view('admin/change_password');
			$this->load->view('footer');
		}
	}

}
