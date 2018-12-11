<?php

	class Admin_Model extends CI_Model
	{
	
		public function login()
		{
			$email = $_POST['email'];
			$password = md5($_POST['password']);

			$query = $this->db->get_where('admin',array('email'=>$email,'password'=>$password));

			if($query->num_rows() == 1)
			{
				$row = $query->row();
				
				$data = array('id'=>$row->id,'admin'=>$row->email,'username'=>$row->username,'role'=>$row->role);

				$this->session->userdata('admin');
				$this->session->set_userdata('admin',$data);
				return true;
			}
		}

		public function row_counter($table)
		{
			$row = $this->db->get($table);
			$row_counter = $row->num_rows();
			return $row_counter;
		}

		public function get_all_record($table)
		{
			//$this->db->order_by('id', 'asc');

			$row = $this->db->get($table);
			return $row;
		}

		public function delete_record($table, $id)
		{
			$this->db->delete($table, array( 'id' => $id ));
		}

		public function get_single_record($table, $id)
		{
			$query = $this->db->get_where($table, array( 'id' => $id ));
			return $query;
		}

		public function get_single_record1($table,$where)
		{
			$query = $this->db->get_where($table,$where);
			$data = $query->row();
			return $data;
		}

		public function get_where($table, $where)
		{
			$query = $this->db->get_where($table, $where);
			return $query;
		}

		public function update_row($table, $data, $where)
		{
			$this->db->where($where);
			return $this->db->update($table, $data);
		}

		public function insert_data($table, $data)
		{
			return $this->db->insert($table, $data);
		}
	}

?>
