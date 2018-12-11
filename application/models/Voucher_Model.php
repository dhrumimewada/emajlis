<?php

class Voucher_Model extends CI_Model
{	
	public function __construct() {
		parent::__construct();
	}

	public function get_voucher_detail($id = NULL){
		$return_data = array();
		$sql_select = array("t1.*", "t2.name");
		$this->db->select($sql_select);
		if (isset($id) && !is_null($id)) {
			$this->db->where('t1.id', $id);
		}
		$this->db->from('vendor_partner_vouchers t1');
		$this->db->join('vendor_partners t2', 't1.vendor_id = t2.id', "left join");
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0) {
			if (isset($id) && !is_null($id)){
				$return_data = $sql_query->row();
			}else{
				$return_data = $sql_query->result_array();
			}
			
		}
		return $return_data;
	}

	public function get_avail_vender($vender_id = NULL){
		$return_data = array();

		$sql_select = array("t1.id");
		$this->db->select($sql_select);
		$this->db->from('vendor_partners t1');
		$this->db->join('vendor_partner_vouchers t2', 't2.vendor_id = t1.id', "left join");
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0){
			$result_array = $sql_query->result_array();
			$assigned_venders = array_unique($result_array, SORT_REGULAR);
			$assigned_venders = array_column($assigned_venders, 'id');
		}

		$this->db->select('name,id');
		$this->db->from('vendor_partners');
		if (count($assigned_venders) != 0 && !empty($assigned_venders)){
			$this->db->where_not_in('id', $assigned_venders);
		}
		$sql_query = $this->db->get();
		if ($sql_query->num_rows() > 0){
			$return_data = $sql_query->result_array();
		}

		if (isset($vender_id) && !is_null($vender_id)){
			$this->db->select('name,id');
			$this->db->from('vendor_partners');
			$this->db->where('id', $vender_id);
			$sql_query = $this->db->get();
			if ($sql_query->num_rows() > 0){
				array_push($return_data, (array)$sql_query->row());
			}
		}
		return $return_data;
	}
}

?>
