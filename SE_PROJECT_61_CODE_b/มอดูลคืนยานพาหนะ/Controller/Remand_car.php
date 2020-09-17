<!-- 
controllers for Remand_car
 -->
 

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/JONGS_Controller.php");
class Remand_car extends  JONGS_Controller {
	public function __construct(){
		parent::__construct();
		
	}
	
	function index(){ //show pang v_remand_car_home
		$data['arr'] = array();
		$this->load->model($this->config->item('jongs_m').'M_jon_reserve_car','rsv_car_home');
		$rsv_car_home = $this->rsv_car_home;
		$data['recar_car_status']=$rsv_car_home->get_reserve_car();
		$data['recar_car_status_app']=$rsv_car_home->get_reserve_car_state_appro();
		$data['recar_car_status_notapp']=$rsv_car_home->get_reserve_car_state_notappro();
		// $data['recar_car_status_use']=$rsv_car_home->get_reserve_car_state_using();
		$data['recar_car_status_re']=$rsv_car_home->get_reserve_car_state_remand();
		$data['recar_car_search']=$rsv_car_home->search_reserve_car();

		$this->output($this->jongs_v.'v_reserve_car',$data);
	}	
	
	public function remand_car($id){ //show pang v_remand_car
		$this->load->model($this->config->item('jongs_v')."M_remand_car","mrc");
		//echo $this->config->item('jongs_v')."Jongs_model"; die;
		$data['data_remand_car_header'] = $this->mrc->get_all_data_remand_car($id)->row();  //แสดงส่วนของข้อมูลบุคคล ใบคือรถ
		$data['get_jon_reserve_car_guest'] = $this->mrc->get_jon_reserve_car_guest_pck_jongsdb($id); // แสดงส่วนของวิยากรที่ไปรับ
		$data['get_jon_reserve_car_detail'] = $this->mrc->get_jon_reserve_car_detail_pck_jongsdb($id); // แสดงตารางรถที่ขอใช้
		$this->output($this->jongs_v.'v_remand_car',$data);
	}
	
	function update_remand_car (){
		$this->load->model($this->config->item('jongs_v')."M_remand_car","mrc");
		$rsc_id = $this->input->post('rsc_id');
		$rsc_rscst_id = 9; // 9 คือ สถานะการ คืนรถ 
	//แปรงค่าวันที่ให้ลงdatabaseได้ Reserve_car_data
		$rsc_end_date = $this->input->post('rsc_end_date');
		$rsc_end_time = $this->input->post('rsc_end_time');
		$array_rsc_end = explode("/", $rsc_end_date);
		$rsc_end_ndate = $array_rsc_end[2]-'543'."-".$array_rsc_end[1]."-".$array_rsc_end[0];
		
		$this->mrc->rsc_id = $rsc_id;
		$this->mrc->rsc_rscst_id = $rsc_rscst_id;
		$this->mrc->rsc_end_date = $rsc_end_ndate." ".$rsc_end_time.":00";
		$this->mrc->jon_reserve_car_update();

		$rscd_rsc_id = $this->input->post('rscd_rsc_id');
		$rscd_eqs_id = $this->input->post('rscd_eqs_id');
		$rscd_note = $this->input->post('rscd_note');
		// pre($rscd_note);die;

		$this->mrc->rscd_rsc_id = $rscd_rsc_id;

	for($i=0;$i<count($rscd_eqs_id);$i++){
		$this->mrc->rscd_eqs_id = $rscd_eqs_id[$i];
		$this->mrc->rscd_note = $rscd_note[$i];
		$this->mrc->jon_reserve_car_detail_update();
	}
		redirect($this->config->item('jongs_v')."Remand_car");
	}
}
?>