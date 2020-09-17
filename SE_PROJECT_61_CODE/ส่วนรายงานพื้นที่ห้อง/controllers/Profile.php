<?php
/*
	โปรไฟล์ของครุภัณฑ์
	Class : Information
	Create By : Chaiwat Rojjarroenviwat
	Date : 2017/08/22
*/
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require_once(dirname(__FILE__).'/EQS_Profile_Controller.php');
	class Profile extends EQS_Profile_Controller {


		public function javascript(){
			parent::javascript();
			// $this->load->view($this->config->item('eqs_folder').$this->config->item('rs_car_folder').'v_javascript');
  			// $this->load->view($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder').'v_javascript');
		}
		public function index(){
			$data["simple_variable"] = "Chaiwat @ Iserl";
			$this->output($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."v_profile",$data);
		}
		public function output_profile($v,$data){
			$this->javascript();
			$this->load->view($v,$data);
		}
		public function profile_show($eqs_id,$fmst_id = NULL, $mt_id = NULL, $bg_id = NULL){
			$this->load->model($this->config->item('eqs_folder').'M_eqs_format_st','fmst');
			$fmst = $this->fmst;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_format_nd','fmnd');
			$fmnd = $this->fmnd;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_format_rd','fmrd');
			$fmrd = $this->fmrd;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_brand_model','bm');
			$bm = $this->bm;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_budgettype','bgt');
			$bgt = $this->bgt;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_method','mt');
			$mt = $this->mt;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
			$bd = $this->bd;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_room','rm');
			$rm = $this->rm;
		// $this->load->model($this->config->item('eqs_folder').'M_person','ps');
		// $ps = $this->ps;
			$this->load->model($this->config->item('eqs_folder').'M_department','dept');
			$dept = $this->dept;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_vender','vd');
			$vd = $this->vd;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_equipments','eqs');
			$eqs = $this->eqs;
			$this->load->model($this->config->item('eqs_folder').'M_eqs_depreciation','dpct');
			$dpct = $this->dpct;
			$this->load->model($this->config->item('eqs_folder').$this->config->item('htf_folder')."M_eqs_repair_detail","repd");
			$repd = $this->repd;
			$this->load->model($this->config->item('eqs_folder').$this->config->item('htf_folder')."M_eqs_repair","rep");
			$rep = $this->rep;

			$this->load->model($this->config->item('eqs_folder').'M_eqs_image','img');
			$img = $this->img;

			$this->load->model('UMS/M_umdepartment','udpm');
			$udpm = $this->udpm;
			$this->load->model('hr/M_hr_department','de');
			$de = $this->de;
			$this->data['tb_name']  = "ข้อมูลครุภัณฑ์";

			if($eqs_id){
				$eqs->eqs_id = $eqs_id;
				$row = $eqs->get_eqs_by_eqs_id_detail()->row_array();
				$bm->eqs_model_id = $row['eqs_model_id'];
				$bm_id = $bm->get_model_id()->row_array();
				$this->data['model_name'] = $bm_id['bm_name'];
				$qu_ed = $eqs->get_eqs_by_eqs_id_detail();
				$this->data['qu_ed']	= $qu_ed;

				$img->img_eqs_id = $eqs_id;
				$this->data['imag_person'] = $img->get_picture();

				// foreach ($this->data['imag_person']->result() as $row) {
				// 	echo $row->img_path;
				// 	echo "<br>";
				// }
				
				// die;

				$repd->eqs_id = $eqs_id;
				$this->data['qu_history_detail'] = $repd->get_repair_detail_by_eqs_code();
				$this->fmst_id = $fmst_id;
			// $this->fmnd_id = $fmnd_id;
				$this->mt_id = $mt_id;
				$this->bg_id = $bg_id;
				$this->start_year = $eqs->eqs_buydate;
				$this->end_year = date('d-m-Y');
				$this->data['qu_all'] = $eqs->get_all_exportExcel_depreciation1();

				/* if($qu_ed->row()->eqs_fmst_id == 3){
					$this->load->model($this->config->item('eqs_folder').$this->config->item('rs_car_folder')."M_eqs_reserve_car_detail","prof");
					$rs_car = $this->prof->get_car_by_id($eqs_id);
					$rs_car_dt = $this->prof->get_reserve_car_by_id($eqs_id);
				
					$this->data['rs_car_dt'] = $rs_car_dt;
					$this->data['is_car'] = true;
					//echo "รถ";
				} */
				if($qu_ed->row()->eqs_fmst_id == 23 || $qu_ed->row()->eqs_fmst_id == 24 || $qu_ed->row()->eqs_fmst_id == 25 || $qu_ed->row()->eqs_fmst_id == 26){
					$this->load->model($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."M_eqs_profile","prof");
					$rs_room = $this->prof->get_room_by_bd_id($eqs_id);
					$this->data['rs_room'] = $rs_room;
					$this->data['is_room'] = true;
				}
				

			}

		// $this->output($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."v_profile",$this->data);
			$this->output_profile($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."v_profile",$this->data);
		}
		public function get_profile_detail(){
			$this->load->model($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."M_eqs_profile","prof");
			$key = $this->input->post('key');
			$value = $this->input->post('value');
			$prof = $this->prof->profile_detail($key,$value)->result();
			echo json_encode($prof);
		}


	function data_table(){
			$this->load->model($this->config->item('eqs_folder').'M_eqs_equipments','eqs');
			$eqs = $this->eqs;			
			$qu_ed = $eqs->get_eqs_by_eqs_id_detail();
			$this->data['qu_ed'] = $qu_ed;
			$data['field'] = $this->input->post();
		// print_r($this->input->post());
		// echo "</pre>";die;
		
		$data['flag'] = $this->input->post('flag');
		if($this->input->post('flag')!='0'){
			$data['key'] = $this->input->post('eqs_name');
			$data['value'] = $this->input->post('eqs_buydate');
		}else{
			foreach($this->input->post() as $key => $value){ //	ระวังการโพสต์ค่า value สุดท้าย by P'Chain
				$data['key'] = $key;
				$data['value'] = $value;
			}
		}
		pre($data);
		$data['title'] = $this->input->post('title');
		$this->output($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."v_DataTable",$data);
	}
	
	function loadTable($key="",$value="",$flag=""){ //เอาค่า key value ไปหาใน db ต่อ
		$this->load->model($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."M_eqs_equipments_datatable","eqs");

		$this->eqs->key = ($this->input->post('key'))?$this->input->post('key'):$key;
		$this->eqs->value = ($this->input->post('value'))?$this->input->post('value'):$value;
		$this->eqs->flag = ($this->input->post('flag'))?$this->input->post('flag'):'0';
		// echo $this->eqs->key."|".$this->eqs->value."|".$this->eqs->flag;die;
		$fetch_data = $this->eqs->get_datatable();
		$data = array();
		$i = $this->input->post('start');
		foreach ($fetch_data as $key => $value) {
			$sub_data = array();
			$sub_data[] = '<center><div onclick = eqs_show_detail("'.$value->eqs_id.'")> '.++$i.' </div></center>';
			$sub_data[] = '<div onclick = eqs_show_detail("'.$value->eqs_id.'") > '.$value->fmst_name.' </div>';
			$sub_data[] = '<div onclick = eqs_show_detail("'.$value->eqs_id.'") class="pull-left"> '.$value->eqs_name.' </div>';
			$sub_data[] = '<center><div onclick = eqs_show_detail("'.$value->eqs_id.'")> '.$value->eqs_code_old.' </div></center>';
			$sub_data[] = '<div align="right" onclick = eqs_show_detail("'.$value->eqs_id.'")> '.number_format($value->eqs_price).' </div>';
			$sub_data[] = '<div align="center" onclick = eqs_show_detail("'.$value->eqs_id.'")> '.abbreDate2($value->eqs_buydate).' </div>';
			$sub_data[] = '<div align="center"onclick = eqs_show_detail("'.$value->eqs_id.'")> '.abbreDate2($value->eqs_expiredate).' </div>';
			$sub_data[] = '<center><div onclick = eqs_show_detail("'.$value->eqs_id.'")> '.$value->status_name.' </div></center>';
			$sub_data[] = '';
			
			$data[] = $sub_data;
		}

		$output = array(
			"draw"                => intval($_POST["draw"]),
			"recordsTotal"        => $this->eqs->get_all_data(),
			"recordsFiltered"     => $this->eqs->get_Filtered(),
			"data" 								=> $data,
			"post"								=> $this->input->post(),
			"make_search"					=> $this->eqs->make_search_2()
			);

		echo json_encode($output);
	}
	
	function show_room_details($value,$id_room){ //$value = 'rm_id' และ  $id_room = หมายเลขห้อง
		$this->load->model($this->config->item('eqs_folder').'M_eqs_equipments','eqs');
		$eqs = $this->eqs;
		$this->load->model($this->config->item('eqs_folder').'M_eqs_room','rm');
		$rm = $this->rm;		
		$qu_ed = $eqs->get_eqs_by_eqs_id_detail();
		$this->data['qu_ed'] = $qu_ed;
		$rm->rm_id = $id_room;
		$rm_show = $rm->get_by_key(); //ใช้getชื่อและหมายเลยของห้อง  rm_id,rm_name
		
		$data['flag'] = '0';//$value;
		if($this->input->post('flag')!='0'){
			$data['key'] = $value;
			$data['value'] = $rm_show->row()->rm_id;
		}
		
		//pre($data);
		// die;
		$data['title'] = $rm_show->row()->rm_name;
		$this->output($this->config->item('eqs_folder').$this->config->item('eqs_profile_folder')."v_DataTable",$data);
	}
}
?>
