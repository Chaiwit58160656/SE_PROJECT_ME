
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/JONGS_Controller.php");
class Reserve_car extends  JONGS_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	function index(){
		$data['arr'] = array();
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_home');
		$rsv_car_home = $this->rsv_car_home;
		$data['recar_car_status']=$rsv_car_home->get_reserve_car();
		$data['recar_car_status_app']=$rsv_car_home->get_reserve_car_state_appro();
		//pre($data['recar_car_status']->result());
		$data['recar_car_status_notapp']=$rsv_car_home->get_reserve_car_state_notappro();
		$data['recar_car_status_re']=$rsv_car_home->get_reserve_car_state_remand();
		$data['recar_car_search']=$rsv_car_home->search_reserve_car();
		//$data['recar_name_car']=$rsv_car_home->get_reserve_car_name();
		// pre($data['recar_car_status_re']->result());
		// pre($data['recar_name_car']->result());
		
	

		$this->output($this->jongs_v.'v_reserve_car',$data);
	}
	function show_report(){
		$data['arr'] = array();
		$this->output_fancy($this->jongs_v.'v_reserve_car',$data);	
	}

	function show_car_datail(){
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_home');
		$rsc_id =  $this->input->post('rsc_id');
		$data = $this->rsv_car_home->get_reserve_car_name($rsc_id)->result();
		echo json_encode($data);


	}


	function Reserve_car_form(){
		$data['arr'] = array();
		 $this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_form');
		 $rsv_car_form = $this->rsv_car_form;
		 $data['recar_name']= $rsv_car_form->get_all_person();
		 $data['recar_type']= $rsv_car_form->get_car_type();
		 $data['recar_status']= $rsv_car_form->get_car_status();
		 $data['recar_province']= $rsv_car_form->get_province();
		 $data['prefix_guest']= $rsv_car_form->get_prefix();

		 // $this->data["rev_person"] = 
		 // $get_person = $this->rsv_car->get_person();
		 // pre($get_person);
		$this->output($this->jongs_v.'v_reserve_car_form',$data);
	}
/* start function Reserve_car_driver ฟังก์ชั่น ของหน้าจัดการข้อมูลยานพาหนะ*/
	function Reserve_car_driver(){ // function showe data on table แสดงข้อมูลในตาราง
		$data['arr'] = array();
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car_detail','rsv_car_driver');
		 $rsv_car_driver = $this->rsv_car_driver;
		 $data['name_driver']= $rsv_car_driver->get_driver();
		 $data['data_car']= $rsv_car_driver->get_data_car();
		 $data['data_table']= $rsv_car_driver->get_data_reserve_car();
		 
		$this->output($this->jongs_v.'v_reserve_car_driver',$data);
	}

	function add_driver_car(){ // ฟังก์ชัน เลือกพาหนะและคนขับ
		
		$rscd_rsc_id = $this->input->post('rscar_id');
		$rscd_eqs_id = $this->input->post('rscard_eqs_id');
		$rscd_ps_id = $this->input->post('rscard_ps_id');
		
		// pre($rscd_rsc_id);
		// pre($rscd_eqs_id);
		// pre($rscd_ps_id);die;
		$this->load->model($this->config->item('jongs_v')."M_jon_reserve_car","mrc");
		$this->load->model($this->config->item('jongs_v')."M_jon_reserve_car_detail","mrc_d");

		for($i=0;$i<count($rscd_eqs_id);$i++){
			$this->mrc_d->rscd_rsc_id = $rscd_rsc_id;
			$this->mrc_d->rscd_eqs_id = $rscd_eqs_id[$i];
			$this->mrc_d->rscd_ps_id = $rscd_ps_id[$i];
			$this->mrc_d->insert_car_driver_detail();
		}
		
		$this->mrc->rsc_id = $rscd_rsc_id;
		$this->mrc->update_eqs_reserve_car_status();
		redirect($this->config->item('jongs_v')."Reserve_car/Reserve_car_driver");
	}

	function add_car(){ // ฟังก์ชัน เลือกพาหนะ

		$rscd_rsc_id = $this->input->post('rscar_id');
		$rscd_eqs_id = $this->input->post('rscard_eqs_id');
		
		// pre($rscd_rsc_id);
		// pre($rscd_eqs_id);

		$this->load->model($this->config->item('jongs_v')."M_jon_reserve_car","mrc");
		$this->load->model($this->config->item('jongs_v')."M_jon_reserve_car_detail","mrc_d");

		for($i=0;$i<count($rscd_eqs_id);$i++){
			$this->mrc_d->rscd_rsc_id = $rscd_rsc_id;
			$this->mrc_d->rscd_eqs_id = $rscd_eqs_id[$i];
			$this->mrc_d->insert_car_detail();
		}
		
		$this->mrc->rsc_id = $rscd_rsc_id;
		$this->mrc->update_eqs_reserve_car_status();
		redirect($this->config->item('jongs_v')."Reserve_car/Reserve_car_driver");
	}
/* End function Reserve_car_driver ฟังก์ชั่น ของหน้าจัดการข้อมูลยานพาหนะ */

	/*insert reserve car form to database*/
	function insert_reserve_car(){
		$rsc_date = $this->input->post('rsc_date');
		$rsc_ps_id = $this->input->post('rsc_ps_id');
		$rsc_rscst_id = $this->input->post('rsc_rscst_id');
		$rsc_rscs_id = $this->input->post('rsc_rscs_id');
		$rsc_rsct_id = $this->input->post('rsc_rsct_id');
		$rsc_place = $this->input->post('rsc_place');
		$rsc_pv_id = $this->input->post('rsc_pv_id');
		$rsc_title = $this->input->post('rsc_title');
		$rsc_companion = $this->input->post('rsc_companion');
		$rsc_note = $this->input->post('rsc_note');
		$rsc_start_date = $this->input->post('rsc_start_date');
		$rsc_end_date = $this->input->post('rsc_end_date');
		$rsc_driver = $this->input->post('rsc_driver');

		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_form');
		$rsc_guest = $this->input->post('rsc_guest');
		$rscg_pf_id = $this->input->post('rscg_pf_id');
		$rscg_fname = $this->input->post('rscg_fname');
		$rscg_lname = $this->input->post('rscg_lname');
		$rscg_place = $this->input->post('rscg_place');
		$rscg_tel = $this->input->post('rscg_tel');
		$rsc_guest_receive_date = $this->input->post('rsc_guest_receive_date');
		$rsc_guest_send_date = $this->input->post('rsc_guest_send_date');

		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car_guest','inrsv_car');
		$inrsv_car = $this->inrsv_car;
		// $this->load->model($this->config->item('jongs_m').'M_reserve_car_form','inrsv_guest');
		// $inrsv_guest = $this->inrsv_guest;

		$arr_rsc_date = explode("/", $rsc_date);
		$rsc_ndate = $arr_rsc_date[2]."-".$arr_rsc_date[1]."-".$arr_rsc_date[0];
		$arr_rsc_datetime = explode("/", $rsc_date);
		$rsc_ndatetime = $arr_rsc_datetime[2]."-".$arr_rsc_datetime[1]."-".$arr_rsc_datetime[0]." ".$this->input->post('rsc_time').":00";
		$max_rsc_code = $this->rsv_car_form->get_max_rsc_code()->row();

		
		$this->rsv_car_form->rsc_ps_id = $rsc_ps_id;
		$this->rsv_car_form->rsc_code = $max_rsc_code->maxid+1;
		$this->rsv_car_form->rsc_date = $rsc_ndate;
		$this->rsv_car_form->rsc_date_create = $rsc_ndatetime;
		$this->rsv_car_form->rsc_rscs_id = $rsc_rscs_id;
		$this->rsv_car_form->rsc_rsct_id = $rsc_rsct_id;
		$this->rsv_car_form->rsc_place = $rsc_place;
		$this->rsv_car_form->rsc_pv_id = $rsc_pv_id;
		$this->rsv_car_form->rsc_title = $rsc_title;
		$this->rsv_car_form->rsc_companion = $rsc_companion;
		$this->rsv_car_form->rsc_note = $rsc_note;
		//แปรงค่าวันที่ให้ลงdatabaseได้ Reserve_car_data
		
		$arr_rsc_star = explode("/", $rsc_start_date);
		$arr_rsc_end = explode("/", $rsc_end_date);
		
		$rsc_star_ndate = $arr_rsc_star[2]-'543'."-".$arr_rsc_star[1]."-".$arr_rsc_star[0];
		$rsc_end_ndate = $arr_rsc_end[2]-'543'."-".$arr_rsc_end[1]."-".$arr_rsc_end[0];
		$this->rsv_car_form->rsc_start_date = $rsc_star_ndate." ".$this->input->post('rsc_start_time').":00";
		$this->rsv_car_form->rsc_end_date = $rsc_end_ndate." ".$this->input->post('rsc_end_time').":00";

		$this->rsv_car_form->rsc_active = 'Y';
		$this->rsv_car_form->rsc_driver = $rsc_driver;

		//แปรงค่าวันที่ให้ลงdatabaseได้ 
		if($rsc_guest_receive_date !=''){
		$arr_rscg_star = explode("/", $rsc_guest_receive_date);
		$arr_rscg_end = explode("/", $rsc_guest_send_date);
		$rscg_star_ndate = $arr_rscg_star[2]-'543'."-".$arr_rscg_star[1]."-".$arr_rscg_star[0];
		$rscg_end_ndate = $arr_rscg_end[2]-'543'."-".$arr_rscg_end[1]."-".$arr_rscg_end[0];
		$this->rsv_car_form->rsc_guest_receive_date = $rscg_star_ndate." ".$this->input->post('rsc_guest_start_time').":00";
		$this->rsv_car_form->rsc_guest_send_date = $rscg_end_ndate." ".$this->input->post('rsc_guest_send_time').":00";
		}
		if($rsc_guest != 'Y'){
			$rsc_guest = 'N';
		}
		
		$this->rsv_car_form->rsc_guest = $rsc_guest;

		$this->rsv_car_form->insert_jon_reserve_car();
		$last_id = $this->rsv_car_form->get_last_rsc_id()->row();

		if($rsc_guest =='Y'){
			$this->inrsv_car->rscg_pf_id = $rscg_pf_id;
			$this->inrsv_car->rscg_fname = $rscg_fname;
			$this->inrsv_car->rscg_lname = $rscg_lname;
			$this->inrsv_car->rscg_place = $rscg_place;
			$this->inrsv_car->rscg_tel = $rscg_tel;
			$this->inrsv_car->rscg_rsc_id = $last_id->last_id;
			$this->inrsv_car->insert_jon_reserve_car_guest();
		}else{
			$this->inrsv_car->rsc_guest = 'N';

		}
		// $rs_rsv_car_form = $this->rsv_car_form->get_all();
		

		//$this->rsv_car_form->rsc_code = $id_gen;
		
		
		redirect($this->config->item('jongs_c')."Reserve_car/");
	}
	function Edit_reserve_car(){

		$rsc_id = $this->input->post('hd_rsc_id');
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','jongs_rsv');
		$edit_rscar = $this->jongs_rsv->get_resereve_car_by_id($rsc_id)->result();
		 
		$data['edit_rscar'] = $edit_rscar;
		//pre($data['edit_rscar']);die;

		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_form');
		 $rsv_car_form = $this->rsv_car_form;
		 $data['recar_name']= $rsv_car_form->get_all_person();
		 $data['recar_type']= $rsv_car_form->get_car_type();
		 $data['recar_status']= $rsv_car_form->get_car_status();
		 $data['recar_province']= $rsv_car_form->get_province();
		 $data['prefix_guest']= $rsv_car_form->get_prefix();
		$this->output($this->jongs_v.'v_edit_reserve_car',$data);
	}
	function update_reserve_car(){

		$rsc_id = $this->input->post('rsc_id');
		$rsc_code = $this->input->post('rsc_code');
		$rsc_date = $this->input->post('rsc_date');
		$rsc_time_update = $this->input->post('rsc_time_update');
		$rsc_date_create = $this->input->post('rsc_date_create');
		$rsc_ps_id = $this->input->post('rsc_ps_id');
		$rsc_rscst_id = $this->input->post('rsc_rscst_id');
		$rsc_rscs_id = $this->input->post('rsc_rscs_id');
		$rsc_rsct_id = $this->input->post('rsc_rsct_id');
		$rsc_place = $this->input->post('rsc_place');
		$rsc_pv_id = $this->input->post('rsc_pv_id');
		$rsc_title = $this->input->post('rsc_title');
		$rsc_companion = $this->input->post('rsc_companion');
		$rsc_note = $this->input->post('rsc_note');
		$rsc_start_date = $this->input->post('rsc_start_date');
		$rsc_end_date = $this->input->post('rsc_end_date');
		$rsc_driver = $this->input->post('rsc_driver');

		$rsc_guest = $this->input->post('rsc_guest');
		$rscg_id = $this->input->post('rscg_id');
		$rscg_pf_id = $this->input->post('rscg_pf_id');
		$rscg_fname = $this->input->post('rscg_fname');
		$rscg_lname = $this->input->post('rscg_lname');
		$rscg_place = $this->input->post('rscg_place');
		$rscg_rsc_id = $this->input->post('rscg_rsc_id');
		$rscg_tel = $this->input->post('rscg_tel');
		$rsc_guest_receive_date = $this->input->post('rsc_guest_receive_date');
		$rsc_guest_send_date = $this->input->post('rsc_guest_send_date');
		$rsc_date_update = $this->input->post('rsc_date_update');

		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_update');
		$rsv_car_update = $this->rsv_car_update;
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car_guest','uprsv_car');
		$uprsv_car = $this->uprsv_car;

		
		$this->rsv_car_update->rsc_id = $rsc_id;
		$this->rsv_car_update->rsc_ps_id = $rsc_ps_id; 
		$this->rsv_car_update->rsc_code = $rsc_code; 
		$this->rsv_car_update->rsc_date = $rsc_date; 
		$this->rsv_car_update->rsc_date_create = $rsc_date_create;
		$this->rsv_car_update->rsc_rscst_id = $rsc_rscst_id;
		$this->rsv_car_update->rsc_rscs_id = $rsc_rscs_id;
		$this->rsv_car_update->rsc_rsct_id = $rsc_rsct_id;
		$this->rsv_car_update->rsc_place = $rsc_place;
		$this->rsv_car_update->rsc_pv_id = $rsc_pv_id;
		$this->rsv_car_update->rsc_title = $rsc_title;
		$this->rsv_car_update->rsc_companion = $rsc_companion;
		$this->rsv_car_update->rsc_note = $rsc_note;
		$this->rsv_car_update->rsc_active = 'Y';
		$this->rsv_car_update->rsc_driver = $rsc_driver;
		$this->rsv_car_update->rsc_user_create = $this->session->userdata('UsPsCode');
		$this->rsv_car_update->rsc_user_update = $this->session->userdata('UsPsCode');
		
		
		//แปรงค่าวันที่ให้ลงdatabaseได้ Reserve_car_data
		
		//วันที่เริ่มต้น-วันที่สิ้นสุด
		$arr_rsc_star = explode("/", $rsc_start_date);
		$arr_rsc_end = explode("/", $rsc_end_date);
		$rsc_star_ndate = $arr_rsc_star[2]-'543'."-".$arr_rsc_star[1]."-".$arr_rsc_star[0];
		$rsc_end_ndate = $arr_rsc_end[2]-'543'."-".$arr_rsc_end[1]."-".$arr_rsc_end[0];
		$this->rsv_car_update->rsc_start_date = $rsc_star_ndate." ".$this->input->post('rsc_start_time').":00";
		$this->rsv_car_update->rsc_end_date = $rsc_end_ndate." ".$this->input->post('rsc_end_time').":00";

		//วันรับวิทยากร
		if($rsc_guest_receive_date !=''){
		$arr_rscg_star = explode("/", $rsc_guest_receive_date);
		$arr_rscg_end = explode("/", $rsc_guest_send_date);
		$rscg_star_ndate = $arr_rscg_star[2]-'543'."-".$arr_rscg_star[1]."-".$arr_rscg_star[0];
		$rscg_end_ndate = $arr_rscg_end[2]-'543'."-".$arr_rscg_end[1]."-".$arr_rscg_end[0];
		$this->rsv_car_update->rsc_guest_receive_date = $rscg_star_ndate." ".$this->input->post('rsc_guest_receive_time');
		$this->rsv_car_update->rsc_guest_send_date = $rscg_end_ndate." ".$this->input->post('rsc_guest_send_time');
		}
		//วันที่อัพเดท rsc_date_update
		$arr_date_update = explode("/", $rsc_date_update);
		$rsc_date_nupdate = $arr_date_update[2]."-".$arr_date_update[1]."-".$arr_date_update[0];
		$this->rsv_car_update->rsc_date_update = $rsc_date_nupdate." ".$this->input->post('rsc_time_update').":00";
		
		if($rsc_guest != 'Y'){
			$rsc_guest = 'N';
		}
		$this->rsv_car_update->rsc_guest = $rsc_guest;

		$this->rsv_car_update->update_jon_reserve_car();
		// $last_id = $this->rsv_car_form->get_last_rsc_id()->row();
		// pre($data['rsc_guest']);die;
		// pre($rscg_id);die;
		if($rsc_guest =='Y'){
			
			$this->uprsv_car->rscg_id = $rscg_id;
			$this->uprsv_car->rscg_pf_id = $rscg_pf_id;
			$this->uprsv_car->rscg_fname = $rscg_fname;
			$this->uprsv_car->rscg_lname = $rscg_lname;
			$this->uprsv_car->rscg_place = $rscg_place;
			$this->uprsv_car->rscg_tel = $rscg_tel;
			// $this->uprsv_car->rscg_rsc_id = $last_id->last_id;
			$this->uprsv_car->rscg_rsc_id = $rscg_rsc_id;
// echo $this->uprsv_car->rscg_rsc_id; die;
			$get_check_guest = $this->uprsv_car->get_reserve_car_guest($rscg_id)->result_array();

			if(count($get_check_guest) > 0){
			$this->uprsv_car->update_jon_reserve_car_guest();
			} else {
			$this->uprsv_car->insert_jon_reserve_car_guest2();	
			}
			
		}else{
			$this->rsv_car_update->rsc_guest = 'N';

		}
		$this->rsv_car_update->update_jon_reserve_car();
		 // pre($get_check_guest); die;
		redirect($this->config->item('jongs_c')."Reserve_car/");
	}

	function search_Reserve_car(){
		$date_start  = $this->input->post("date_start");
		$date_end = $this->input->post("date_end");

		$rsc_sdate = explode("/", $date_start);
		$rsc_nsdate = $rsc_sdate[2]."-".$rsc_sdate[0]."-".$rsc_sdate[1];
		$rsc_edate = explode("/", $date_end);
		$rsc_nedate = $rsc_edate[2]."-".$rsc_edate[0]."-".$rsc_edate[1];
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_home');
		$rsv_car_home = $this->rsv_car_home;
		$data = $rsv_car_home->get_resreve_car_data($rsc_nsdate,$rsc_nedate)->result();
		
		echo json_encode($data);
	}

	function get_data_detail_by_rsc_id($rsc_id){
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_form');
		$rsc_id = $rsc_id;
		$data['get_detail'] = $this->rsv_car_form->get_detail_by_rsc_id($rsc_id)->result_array();
		

		$this->output_fancy($this->config->item('jongs_v').'v_reserve_car_show',$data);

	
		// foreach ($data as $key => $value) {
		// 	$rsc_date = fullDateTH3($value->rsc_date);
		// 	$rsc_startdate = explode(' ', $value->rsc_start_date);
		// 	// $rsc_start_new_date = fullDateTH3($rsc_startdate[0]);
		// 	 // $rsc_start_ntime = $rsc_startdate[1];
		// 	$rsc_enddate = explode(' ', $value->rsc_end_date);
		// 	// $rsc_end_new_date = fullDateTH3($rsc_enddate[0]); 
		// 	// echo  $rsc_start_new_date;
		// 	if($value->rsc_guest_receive_date != NULL){
		// 	$rsc_startdate_guest =explode(' ', $value->rsc_guest_receive_date);
		// 	$rsc_enddate_guest = explode(' ', $value->rsc_guest_send_date);
		// 	$full_date_startdate_guest = fullDateTH3($rsc_startdate_guest[0]);
		// 	$full_time_rsc_startdate_guest = $rsc_startdate_guest[1];
		// 	$full_rsc_end_date_guest = fullDateTH3($rsc_enddate_guest[0]);
		// 	$full_rsc_end_time_guest = $rsc_enddate_guest[1];
		// 	}else{
		// 	$full_date_startdate_guest = "";
		// 	$full_time_rsc_startdate_guest = "";
		// 	$full_rsc_end_date_guest = "";
		// 	$full_rsc_end_time_guest = "";
		// 	}
			
		// 	$data_rsc = array('rsc_id' => $value->rsc_id, 
		// 					  'rsc_code' =>$value->rsc_code,
		// 					  'rsc_date' =>$rsc_date,
		// 					  'rsc_start_date' => fullDateTH3($rsc_startdate[0]),
		// 					  'rsc_starttime_date' => $rsc_startdate[1],
		// 					  'rsc_end_date' => fullDateTH3($rsc_enddate[0]),
		// 					  'rsc_endtime_date' => $rsc_enddate[1],
		// 					  'rsc_star_date_guest' =>  $full_date_startdate_guest,
		// 					  'rsc_star_time_guest' => $full_time_rsc_startdate_guest,
		// 					  'rsc_end_date_guest' => $full_rsc_end_date_guest,
		// 					  'rsc_end_time_guest' => $full_rsc_end_time_guest,
		// 					  'rscst_name' => $value->rscst_name,
		// 					  'rsc_place' => $value->rsc_place,
		// 					  'rscs_name' => $value->rscs_name,
		// 					  'rsct_name' => $value->rsct_name,
		// 					  'rsc_title' => $value->rsc_title,
		// 					  'rsc_companion' => $value->rsc_companion,
		// 					  'rsc_note' => $value->rsc_note,
		// 					  'eqs_name' => $value->eqs_name,
		// 					  'pf_name' => $value->pf_name,
		// 					  'ps_fname' => $value->ps_fname,
		// 					  'ps_lname' => $value->ps_lname,
		// 					  'alp_name' => $value->alp_name,
		// 					  'dept_name' => $value->dept_name,
		// 					  'pv_name' => $value->pv_name,
		// 					  'gs_pf_name'=>$value->gs_pf_name,
		// 					  'gs_rscg_fname'=>$value->gs_rscg_fname,
		// 					  'gs_rscg_lname'=>$value->gs_rscg_lname,
		// 					  'gs_rscg_place'=>$value->gs_rscg_place,
		// 					  'gs_rscg_tel'=>$value->gs_rscg_tel,
		// 					  'dr_ps_fname'=>$value->dr_ps_fname,
		// 					  'dr_ps_lname'=>$value->dr_ps_lname,
		// 					  'rsc_guest' => $value->rsc_guest
		// 					); 
		// 	// pre($rsc_guest_receive_date);
		// }
		// echo json_encode($rsc_guest_receive_date);
		 // echo json_encode($data_rsc);
		

	}

	function delect_rsc(){
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_form');
		$rsc_id = $this->input->post('rsc_id');

		$this->rsv_car_form->delete_jon_reserve_car($rsc_id);
		$data = 'success';
		echo json_encode($data);
	}

	// function modal_reserve_data(){
	// 	$modal_reserve_data = $this->

	// }		
}
?>