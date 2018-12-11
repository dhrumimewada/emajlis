<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('admin'))
    {
        redirect('login');
    }
            
	}

	public function users_list(){
		// Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $users_list = $this->admin_Model->get_all_record('member');
          
          $data = array();
          $count = '1';

          foreach($users_list->result() as $user_list) {

              $where = array('member_id' =>$user_list->id);
              $member_hashtag = $this->admin_Model->get_where('member_interests',$where)->result_array();
              $hashtags = '';
              if(!empty($member_hashtag)){

              foreach ($member_hashtag as $key => $value) {
                  $where = array('id' =>$value['hashtag_id']);
                  $hashtags_arry = $this->admin_Model->get_where('hashtag',$where)->row();
                  $hashtags .= '<span class="label label-primary mr-1">#'.$hashtags_arry->tag_name.'</span>';
                }
              }
               
               if(($user_list->image != '') &&  (file_exists($this->config->item("profile_path").$user_list->image))){
                  $path = base_url().$this->config->item("profile_path").$user_list->image;
               }
               else{
                  $path = base_url().$this->config->item("profile_path").'member-noimg.png';
               }

               $user_image = '<img src="'.$path.'" style="width:50px;height:50px;">';

               $action_data = '<a href="'.base_url().'members/edit/'.$user_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$user_list->id'".','."'member'".','."'member'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

               $data[] = array(
                    $user_list->id,
                    $count,
                    $user_list->fullname,
                    $user_list->email,
                   // $user_image,
                    $hashtags,
                    $action_data
               );

               $count++;

          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $users_list->num_rows(),
                 "recordsFiltered" => $users_list->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
	}

  public function hashtags_list(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $hashtags_list = $this->admin_Model->get_all_record('hashtag');
         
          $data = array();

          foreach($hashtags_list->result() as $key => $hashtag_list) {
            $more_content = (strlen($hashtag_list->description) > 70) ? "....." : "";
               $action_data = '<a href="'.base_url().'hashtags/edit/'.$hashtag_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$hashtag_list->id'".','."'hashtag'".','."'hashtag'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';  
               $data[] = array(
                    $hashtag_list->id,
                    $key+1,
                    "#".$hashtag_list->tag_name,
                    '<div class="more">'.substr($hashtag_list->description,0,70).$more_content.'</div>',
                    $hashtag_list->newsfeed_url,
                    $action_data
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $hashtags_list->num_rows(),
                 "recordsFiltered" => $hashtags_list->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function industry_list(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $looking_for_lists = $this->admin_Model->get_all_record('looking_for');
          $data = array();

          foreach($looking_for_lists->result() as $key => $looking_for_list) {
            $more_content = (strlen($looking_for_list->description) > 100) ? "....." : "";
               $action_data = '<a href="'.base_url().'industry-looking-for/edit/'.$looking_for_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$looking_for_list->id'".','."'looking_for'".','."'goal'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>'; 
              
               $data[] = array(
                    $looking_for_list->id,
                    $key+1,
                    $looking_for_list->name,
                    '<div class="more">'.substr($looking_for_list->description,0,70).$more_content.'</div>',
                    $action_data
               );
          }
          
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $looking_for_lists->num_rows(),
                 "recordsFiltered" => $looking_for_lists->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function industry(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $industry_lists = $this->admin_Model->get_all_record('industry');
          $data = array();

          foreach($industry_lists->result() as $key => $industry_list) {
               $action_data = '<a href="'.base_url().'industry/edit/'.$industry_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$industry_list->id'".','."'industry'".','."'industry'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>'; 
              
               $data[] = array(
                    $industry_list->id,
                    $key+1,
                    ucfirst($industry_list->name),
                    $action_data
               );
          }
          
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $industry_lists->num_rows(),
                 "recordsFiltered" => $industry_lists->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function meeting_preference_list(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $meeting_preference_lists = $this->admin_Model->get_all_record('meeting_preferences');
          $data = array();

          foreach($meeting_preference_lists->result() as $key => $meeting_preference_list) {
               $action_data = '<a href="'.base_url().'meeting-preference/edit/'.$meeting_preference_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$meeting_preference_list->id'".','."'meeting_preferences'".','."'meeting preference'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>'; 
              
               $data[] = array(
                    $meeting_preference_list->id,
                    $key+1,
                    ucfirst($meeting_preference_list->preference_type),
                    $action_data
               );
          }
          
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $meeting_preference_lists->num_rows(),
                 "recordsFiltered" => $meeting_preference_lists->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function vendor_partner_list(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $vendor_partners_list = $this->admin_Model->get_all_record('vendor_partners');
         
          $data = array();

          foreach($vendor_partners_list->result() as $key => $vendor_partner_list) {
               

               $action_data = '<a href="'.base_url().'vendor-partners/edit/'.$vendor_partner_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$vendor_partner_list->id'".','."'vendor_partners'".','."'vendor partner'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

               $data[] = array(
                    $vendor_partner_list->id,
                    $key+1,
                    $vendor_partner_list->name,
                    $vendor_partner_list->email,
                    $vendor_partner_list->mobile,
                    $action_data
               );

          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $vendor_partners_list->num_rows(),
                 "recordsFiltered" => $vendor_partners_list->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function voucher_list(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $vouchers_list = $this->admin_Model->get_all_record('vendor_partner_vouchers');
         
          $data = array();

          foreach($vouchers_list->result() as $key => $voucher_list) {
               
              $vouchers_vender = $this->admin_Model->get_single_record('vendor_partners',$voucher_list->vendor_id)->row();

               $action_data = '<a href="'.base_url().'vouchers/edit/'.$voucher_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$voucher_list->id'".','."'vendor_partner_vouchers'".','."'voucher'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

               if($voucher_list->voucher_type == "0"){
                  $voucher_amount = 'AED';
               }else{
                  $voucher_amount = "%";
               }

               $data[] = array(
                    $voucher_list->id,
                    $key+1,
                    $vouchers_vender->name,
                    $voucher_list->voucher_code,
                    $voucher_list->voucher_amount." ".$voucher_amount,
                    $action_data
               );

          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $vouchers_list->num_rows(),
                 "recordsFiltered" => $vouchers_list->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function advertisement_list(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $advertisements_list = $this->admin_Model->get_all_record('advertise');
         
          $data = array();

          foreach($advertisements_list->result() as $key => $advertisement_list) {
               
               $action_data = '<a href="'.base_url().'advertisements/edit/'.$advertisement_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$advertisement_list->id'".','."'advertise'".','."'advertisement'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

               $data[] = array(
                    $advertisement_list->id,
                    $key+1,
                    $advertisement_list->title,
                    $advertisement_list->url,
                    $advertisement_list->impression_count,
                    $action_data
               );

          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $advertisements_list->num_rows(),
                 "recordsFiltered" => $advertisements_list->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function recent_hashtags(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $recent_hashtags_list = $this->db->query('select * from hashtag order by id desc limit 5');
          $data = array();

          foreach($recent_hashtags_list->result() as $key => $recent_hashtag_list) {
            $more_content = (strlen($recent_hashtag_list->description) > 60) ? "....." : "";

               $action_data = '<a href="'.base_url().'hashtags/edit/'.$recent_hashtag_list->id.'" class="table-action-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="md md-edit"></i></a><a href="javascript:delete_single_record('."'$recent_hashtag_list->id'".','."'hashtag'".','."'hashtag'".');" class="table-action-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="md md-close"></i></a>'; 
              
               $data[] = array(
                    "#".$recent_hashtag_list->tag_name,
                    '<div class="more">'.substr($recent_hashtag_list->description,0,60).$more_content.'</div>',
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $recent_hashtags_list->num_rows(),
                 "recordsFiltered" => $recent_hashtags_list->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function admins_list(){
    // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $admins_list = $this->admin_Model->get_all_record('admin');
         
          $data = array();

          foreach($admins_list->result() as $key => $admin_list) {

               $action_data = '<a href="'.base_url().'admins/edit/'.$admin_list->id.'" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a href="javascript:delete_single_record('."'$admin_list->id'".','."'admin'".','."'admin'".');" class="on-default remove-row danger-alert" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';  
               $data[] = array(
                    $admin_list->id,
                    $key+1,
                    $admin_list->username,
                    $admin_list->email,
                    $action_data
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $admins_list->num_rows(),
                 "recordsFiltered" => $admins_list->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
  }

  public function delete($table = '',$id = '')
  {
    $this->db->delete($table, array( 'id' => $id ));
    echo 1;
  }
}
