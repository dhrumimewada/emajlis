<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$validation_rules = array(
					array('field' => 'email', 'label' => 'email', 'rules' => 'trim|required|max_length[225]|valid_email'),
					array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required')
				);

		$this->form_validation->set_rules($validation_rules);
    
		if($this->form_validation->run() != FALSE){
			$data = $this->admin_Model->login();

			if($data == true){
				redirect('dashboard');
			}else{
				$this->session->set_flashdata('message', 'Invalid email address or password.');
               	redirect('/');
			}			
		}else{  	
            $this->load->view('login');
        }
	}

	public function logout()
    {
        $this->session->unset_userdata('admin');
        redirect('login');
    }

    public function isvalid_token($token = NULL) {
		$this->db->select('id');
		$this->db->where('remember_token', $token);
		$this->db->from('member');
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			return True;
		} else {
			$this->form_validation->set_message('isvalid_token', 'This token does not exists.');
			return False;
		}
	}

    public function reset_password($remember_token = NULL){

    	$validation_rules = array(
					array('field' => 'password', 'label' => 'new password', 'rules' => 'trim|required|min_length[6]|max_length[50]'),
					array('field' => 'c_password', 'label' => 'confirm password', 'rules' => 'trim|required|matches[password]'),
					array('field' => 'remember_token', 'label' => 'token', 'rules' => 'trim|required|callback_isvalid_token[]')
				);

		$this->form_validation->set_rules($validation_rules);
		if($this->form_validation->run() != FALSE){
			$data['password'] = md5($this->input->post('password'));
			$data['remember_token'] = "";
     		$this->db->where('remember_token',$this->input->post('remember_token'));
     		$this->db->update('member',$data);
     		$this->session->set_flashdata('message', 'Password reset successfully.');
			redirect('success_msg');
		}else{
			$data['remember_token'] = $remember_token;
			$this->load->view('reset_password',$data);
		}	
    }

    public function success_reset_password(){
    	$this->load->view('success_reset_password');
    }
}
