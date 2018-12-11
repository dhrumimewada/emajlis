<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_partners extends CI_Controller {

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

		$this->load->view('vendor_partners/vendor_partners');
		$this->load->view('footer');
	}

	public function add()
	{
		$validation_rules = array(
					array('field' => 'name', 'label' => 'name', 'rules' => 'trim|required|min_length[3]|max_length[30]'),
					array('field' => 'email', 'label' => 'email', 'rules' => 'trim|required|max_length[225]|valid_email|is_unique[vendor_partners.email]'),
					array('field' => 'mobile', 'label' => 'contact number', 'rules' => 'trim|required|numeric|min_length[10]|max_length[15]|greater_than[0]'),
					array('field' => 'category', 'label' => 'category', 'rules' => 'trim|required'),
					array('field' => 'lat', 'label' => 'address', 'rules' => 'trim|required'),
					array('field' => 'address', 'label' => 'address', 'rules' => 'trim|required')
				);

		$this->form_validation->set_rules($validation_rules);
		
		if($this->form_validation->run() != FALSE)
		{
			//echo '<pre>'; print_r($_POST); exit;
			$data['name'] = $this->input->post('name');
			$data['email'] = $this->input->post('email');
			$data['mobile'] = $this->input->post('mobile');
			$data['category_id'] = $this->input->post('category');
			$data['address'] = $this->input->post('address');
			$data['lat'] = $this->input->post('lat');
			$data['lang'] = $this->input->post('lang');
			$data['created_date'] = date('Y-m-d H:i:s');

			$this->db->insert('vendor_partners',$data);
			$this->session->set_flashdata('message', 'Vendor partner added successfully.');
			redirect('vendor-partners');
		}
		else
		{
			$data['vendor_category'] = $this->admin_Model->get_all_record('vender_category')->result_array();
			$this->load->view('vendor_partners/add',$data);
			$this->load->view('footer');
		}
	}

	public function edit($id = '')
	{
		if($id != '' && $id > 0)
		{
			$validation_rules = array(
					array('field' => 'name', 'label' => 'name', 'rules' => 'trim|required|min_length[3]|max_length[30]'),
					array('field' => 'mobile', 'label' => 'contact number', 'rules' => 'trim|required|numeric|min_length[10]|max_length[15]|greater_than[0]'),
					array('field' => 'category', 'label' => 'category', 'rules' => 'trim|required'),
					array('field' => 'lat', 'label' => 'address', 'rules' => 'trim|required'),
					array('field' => 'address', 'label' => 'address', 'rules' => 'trim|required')
				);

		$this->form_validation->set_rules($validation_rules);
			if($this->form_validation->run() != FALSE)
			{	
				$data['name'] = $this->input->post('name');
				$data['address'] = $this->input->post('address');
				$data['lat'] = $this->input->post('lat');
				$data['lang'] = $this->input->post('lang');
				$data['category_id'] = $this->input->post('category');
				$data['mobile'] = $this->input->post('mobile');
				$data['created_date'] = date('Y-m-d H:i:s');

	     		$this->db->update('vendor_partners',$data,array('id' => $this->input->post('id')));
	     		$this->session->set_flashdata('message', 'Vendor partner updated successfully.');
				redirect('vendor-partners');
			}
			else
			{
				$data['vendor_category'] = $this->admin_Model->get_all_record('vender_category')->result_array();
				$data['vendor_partners'] = $this->admin_Model->get_single_record('vendor_partners',$id)->row();
				if(!empty($data['vendor_partners']))
				{
					$this->load->view('vendor_partners/edit',$data);
					$this->load->view('footer');
				}
				else
				{
					redirect('vendor-partners');
				}
			}
		}
		else
		{
			redirect('vendor-partners');
		}
		
		
	}

	public function imageUpload($imageName)
	{
  		if(!is_dir('assets/images/vendor_partners/'))
  		{
   			mkdir('assets/images/vendor_partners/', 0777,true);   
   			chmod('assets/images/vendor_partners/', 0777);
  		}
        $config['upload_path']   = 'assets/images/vendor_partners/';
        $config['allowed_types'] = '*';
        $config['max_size']      = 20240;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($imageName)) 
        {
            $error            = $this->upload->display_errors();
            $return['status'] = 0;
            $return['error']  = $error;
        } 
        else 
        {
            $upload_data      = $this->upload->data();
            $file_name        = $upload_data['file_name'];
            $return['status'] = 1;
            $return['path']   = 'assets/images/vendor_partners/'.$file_name;
        }
        return $return;
    }
}
