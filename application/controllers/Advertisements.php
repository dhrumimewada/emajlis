<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisements extends CI_Controller {

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
		$this->load->view('advertisements/advertisements');
		$this->load->view('footer');
	}

	public function add()
	{
		$validation_rules = array(
					
					array('field' => 'title', 'label' => 'advertisement title', 'rules' => 'trim|required|min_length[3]|max_length[50]|is_unique[advertise.title]'),
					array('field' => 'url', 'label' => 'url', 'rules' => 'trim|required|valid_url'),
					array('field' => 'description', 'label' => 'description', 'rules' => 'trim')
				);

		$this->form_validation->set_rules($validation_rules);

		if($this->form_validation->run() != FALSE)
		{

			$file_upload = true;

			if (isset($_FILES['image']) && !empty($_FILES['image']) && strlen($_FILES['image']['name']) > 0) {

				$config['upload_path'] = FCPATH . $this->config->item("advertisement_path");
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = false;
				$config['file_name'] = 'advertisement' . '_' . time();
				$config['file_ext_tolower'] = true;
				// $config['max_size'] = '1024';
				// $config['min_width'] = '300';
				// $config['max_width'] = '300';
				// $config['min_height'] = '120';
				// $config['max_height'] = '120';

				$this->load->library('upload');
				$this->upload->initialize($config, true);

				if (!$this->upload->do_upload('image')) {
					$file_upload = false;
					$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
					redirect('advertisements');
				} else {
					$file_upload_data = $this->upload->data();
					$data['image'] = $file_upload_data['file_name'];
				}

			}

			if($file_upload){

				$data['title'] = $this->input->post('title');
				$data['description'] = $this->input->post('description');
				$data['url'] = $this->input->post('url');
				$data['impression_count'] = '0';
			
				$this->db->insert('advertise',$data);
				$this->session->set_flashdata('message', 'Advertise added successfully.');
				redirect('advertisements');

			}else{
				$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
				redirect('advertisements');
			}
			
		}
		else
		{
			$this->load->view('advertisements/add');
			$this->load->view('footer');
		}
	}

	public function isexists_advertisement($advertisement_name = NULL, $id = NULL) {
		$this->db->select('id');
		if (isset($id) && !is_null($id)) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('title', $advertisement_name);
		$this->db->from('advertise');
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			$this->form_validation->set_message('isexists_advertisement', 'This advertise title already exists.');
			return False;
		} else {
			return True;
		}
	}

	public function edit($id = '')
	{
		$validation_rules = array(
					
					array('field' => 'title', 'label' => 'advertise title', 'rules' => 'trim|required|min_length[3]|max_length[50]|callback_isexists_advertisement[' . $this->input->post('id') . ']'),
					array('field' => 'url', 'label' => 'url', 'rules' => 'trim|required|valid_url'),
					array('field' => 'description', 'label' => 'description', 'rules' => 'trim')
				);

		$this->form_validation->set_rules($validation_rules);
		if($this->form_validation->run() != FALSE)
		{	
			$file_upload = true;

			if (isset($_FILES['image']) && !empty($_FILES['image']) && strlen($_FILES['image']['name']) > 0) {

				$config['upload_path'] = FCPATH . $this->config->item("advertisement_path");
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = false;
				$config['file_name'] = 'advertisement' . '_' . time();
				$config['file_ext_tolower'] = true;
				// $config['max_size'] = '1024';
				// $config['min_width'] = '300';
				// $config['max_width'] = '300';
				// $config['min_height'] = '120';
				// $config['max_height'] = '120';

				$this->load->library('upload');
				$this->upload->initialize($config, true);

				if (!$this->upload->do_upload('image')) {
					$file_upload = false;
					$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
					redirect('advertisements');
				} else {

					$file_upload_data = $this->upload->data();
					$data['image'] = $file_upload_data['file_name'];

					//remove old image from folder
					$this->db->select('image');
					$this->db->where('id', $this->input->post('id'));
					$this->db->from('advertise');
					$sql_query = $this->db->get();
					if ($sql_query->num_rows() > 0) {
						$return_data = $sql_query->row();
						$profile_picture_old = $return_data->image;

						if (isset($profile_picture_old) && !empty($profile_picture_old)) {
							if (file_exists(FCPATH . $this->config->item("advertisement_path") . $profile_picture_old)) {
								unlink(FCPATH . $this->config->item("advertisement_path") .  $profile_picture_old);
							}
						}
					}
				}

			}

			if($file_upload){
				$data['title'] = $this->input->post('title');
				$data['description'] = $this->input->post('description');
				$data['url'] = $this->input->post('url');
	
	     		$this->db->update('advertise',$data,array('id' => $this->input->post('id')));
	     		$this->session->set_flashdata('message', 'Advertise updated successfully.');
				redirect('advertisements');
			}else{
				$this->session->set_flashdata('message', ucfirst($this->upload->display_errors()));
				redirect('advertisements');
			}
			
		}
		else
		{
			$data['advertise'] = $this->admin_Model->get_single_record('advertise',$id)->row();
			if(!empty($data['advertise']))
			{
				$this->load->view('advertisements/edit',$data);
				$this->load->view('footer');
			}
			else
			{
				redirect('advertisements');
			}
		}
		
	}

	public function imageUpload($imageName)
	{
  		if(!is_dir('assets/images/advertisements/'))
  		{
   			mkdir('assets/images/advertisements/', 0777,true);   
   			chmod('assets/images/advertisements/', 0777);
  		}
        $config['upload_path']   = 'assets/images/advertisements/';
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
            $return['path']   = 'assets/images/advertisements/'.$file_name;
        }
        return $return;
    }
}
