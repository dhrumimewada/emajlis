<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
		
	}

	public function appsetting()
	{

		if($this->input->post())
		{
			$password = $this->db->get_where('authorization',array('passwordfor'=>'app_setting'))->row();
			if($password->password == md5($_POST['password']))
			{
				$android['version'] = $_POST['Android'];
				$android['updated_status'] = 0;
				if(isset($_POST['AndroidCheckbox']))
				{
					$android['updated_status'] = 1;
				}
				$this->db->update('app_settings',$android,array('name' => 'Android'));

				$IOS['version'] = $_POST['IOS'];
				$IOS['updated_status'] = 0;
				if(isset($_POST['IOSCheckbox']))
				{
					$IOS['updated_status'] = 1;
				}
				$this->db->update('app_settings',$IOS,array('name' => 'IOS'));

				$MaintenanceMode['updated_status'] = 0;
				if(isset($_POST['maintenancemodecheckbox']))
				{	
					$MaintenanceMode['updated_status'] = 1;
				}				
				$this->db->update('app_settings',$MaintenanceMode,array('name' => 'MaintenanceMode'));
				$this->session->set_flashdata('message', 'App Setting updated successfully');
			}
			else
			{
				$this->session->set_flashdata('message', 'Authontication Password Incorrect');
				//redirect('setting/appSetting');
			}
		}
		$data['appsetting'] = $this->db->query('select * from app_settings LIMIT 2')->result();
		$data['maintenancemode'] = $this->db->get_where('app_settings',array('name'=>'MaintenanceMode'))->row();
		$this->load->view('settings/settings',$data);
		$this->load->view('footer');
	}



}
