<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_Model');
		$this->load->model('voucher_Model');

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
		$this->load->view('vouchers/vouchers');
		$this->load->view('footer');
	}

	public function add()
	{
		$validation_rules = array(
					array('field' => 'vender', 'label' => 'vender partner', 'rules' => 'trim|required'),
					array('field' => 'voucher_code', 'label' => 'voucher code', 'rules' => 'trim|required|min_length[3]|max_length[50]'),
					array('field' => 'voucher_type', 'label' => 'voucher type', 'rules' => 'trim|required'),
					array('field' => 'voucher_amount', 'label' => 'voucher amount', 'rules' => 'trim|required'),
					array('field' => 'voucher_description', 'label' => 'voucher description', 'rules' => 'trim|required')
				);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE)
		{
			$data['voucher_code'] = $this->input->post('voucher_code');
			$data['vendor_id'] = $this->input->post('vender');
			$data['voucher_type'] = $this->input->post('voucher_type');
			$data['voucher_amount'] = $this->input->post('voucher_amount');
			$data['voucher_description'] = $this->input->post('voucher_description');
			
			$this->db->insert('vendor_partner_vouchers',$data);
			$this->session->set_flashdata('message', 'Voucher added successfully.');
			redirect('vouchers');
		}
		else
		{
			$data['vendor_partners'] = $this->voucher_Model->get_avail_vender();
			$this->load->view('vouchers/add',$data);
			$this->load->view('footer');
		}
	}

	public function test()
	{
		$data = $this->voucher_Model->get_avail_vender();
		echo '<pre>';
		print_r($data);
		exit;
	}

	public function edit($id = '')
	{
		$validation_rules = array(
					array('field' => 'vender', 'label' => 'vender partner', 'rules' => 'trim|required'),
					array('field' => 'voucher_code', 'label' => 'voucher code', 'rules' => 'trim|required|min_length[3]|max_length[50]'),
					array('field' => 'voucher_type', 'label' => 'voucher type', 'rules' => 'trim|required'),
					array('field' => 'voucher_amount', 'label' => 'voucher amount', 'rules' => 'trim|required'),
					array('field' => 'voucher_description', 'label' => 'voucher description', 'rules' => 'trim|required')
				);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE)
		{	
			$data['voucher_code'] = $this->input->post('voucher_code');
			$data['vendor_id'] = $this->input->post('vender');
			$data['voucher_type'] = $this->input->post('voucher_type');
			$data['voucher_amount'] = $this->input->post('voucher_amount');
			$data['voucher_description'] = $this->input->post('voucher_description');

     		$this->db->update('vendor_partner_vouchers',$data,array('id' => $this->input->post('id')));
     		$this->session->set_flashdata('message', 'Voucher updated successfully.');
			redirect('vouchers');
		}
		else
		{
			$data['voucher'] = $this->voucher_Model->get_voucher_detail($id);
			// echo "<pre>";
			// print_r($data['voucher']->vendor_id);
			// exit;
			$data['vendor_partners'] = $this->voucher_Model->get_avail_vender($data['voucher']->vendor_id);
			if(!empty($data))
			{
				$this->load->view('vouchers/edit',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('vouchers');
			}
		}
		
	}

}
