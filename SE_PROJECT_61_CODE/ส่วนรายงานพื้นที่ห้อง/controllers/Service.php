<?php
//================================================================
//-- Chain Chaiwat -----------------------------------------------
//-- Create 2016/08/08 -------------------------------------------
//================================================================
header('Access-Control-Allow-Origin: *');
// include('EQS_Controller.php');
class Service extends CI_Controller {

	var $data = array();
	public $data_list_color = array("#929797","#85b6b6","#94da5e","#7a6391","#fceb02","#d1909c","#e2664c","#205b6c","#FF5C5C","#fec5b9", "#8b8da0","#9a784a","#b1bcce","#88c69c","#ACE1AF","#893F45","#CD5C5C","#E25822","#E5AA70",

	"#929797","#85b6b6","#94da5e","#7a6391","#fceb02","#d1909c","#e2664c","#205b6c","#FF5C5C","#fec5b9", "#8b8da0","#9a784a","#b1bcce","#88c69c","#ACE1AF","#893F45","#CD5C5C","#E25822","#E5AA70");
	public $head_panel_main = "#002073"; //สีของ header หลัก
	public $head_panel_lv1 	= "#009986"; //สีของ header ที่อยู่ใน panel หลัก
	public $head_panel_lv2 	= "#93f3a7"; //สีของ header ที่อยู่ใน panel รอง

	public function __construct(){
		parent::__construct();
		// $this->session->set_userdata('UsDpID', '2');
	}
//======================================================================
//=== Group Box ========================================================
//======================================================================
	function eqs_box_all(){ // แสดงกล่องจำนวนครุภัณฑ์ทั้งหมด
		$this->get_eqs_total();
		$this->get_eqs_borrow_total();
		$this->get_eqs_defective_total();
		$this->get_eqs_repair_total();
		$this->get_eqs_distribute_total();
		$this->get_eqs_expire_total();
		$this->get_eqs_building_total();
		//$this->gen_eqs_room_type();
		if($this->session->userdata('UsDpID')==1){
			$this->get_eqs_purchase();
		}
		echo json_encode($this->data);
	}
	//== Begin Equipment Total  ==================================
	//-- Chain Chaiwat 2016/08/08 --------------------------------
	//-- eqs_total   : JSON Encode Data Equipment Total ----------
	//-- Return type : json --------------------------------------
	function eqs_total(){ //
		$this->get_eqs_total();
		echo json_encode($this->data);
	}
	//-- Get data Eqiupment total --------------------------------
	//-- get_eqs_total : array -----------------------------------
	//-- Return Type   : array -----------------------------------
	function get_eqs_total(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $eqs_equipment_total = $this->eqs->get_eqs_amount_by_dp_id(); //total equipments
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => $this->config->item('eqs_call').'ทั้งหมด',
								'tile_body' => number_format($eqs_equipment_total),
								'tile_icon' => "ti ti-package",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "#ffd800",
								'tile_footer' => "หน่วย",
								'is_expand' => ($eqs_equipment_total>0)?array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_by_status") ,
													'param' => 'all', 'iframe'=>1 ,
													'header' => '<b>รายการ'.$this->config->item('eqs_call').'ทั้งหมด</b>'
												):'false'
						);
		return $this->data;
	}
	//== End Equipment Total =====================================

	/*
    * eqs_borrow_total
    * @input: ข้อมูลทั้งหมดของครุภัณฑ์ที่ยืม
    * @output: ค่าที่ของครุภัณฑ์ที่ยืม ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	function eqs_borrow_total(){
		$this->get_eqs_borrow_total();
		echo json_encode($this->data);
	}
    /*
    * get_eqs_borrow_total
    * @input: ค่าต่างๆของครุภัณฑ์ที่ยืม
    * @output: ข้อมูลทั้งหมดของครุภัณฑ์ที่ยืม
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	function get_eqs_borrow_total(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $eqs_equipment_borrow = $this->eqs->get_eqs_borrow_by_dp_id(); //borrow equipments
		if($eqs_equipment_borrow!=0){
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => $this->config->item('eqs_call').'ที่ยืม',
								'tile_body' => number_format($eqs_equipment_borrow),
								'tile_icon' => "ti ti-hand-point-right",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "#009dff",
								'tile_footer' => "หน่วย",
								'is_expand' => ($eqs_equipment_borrow>0)?array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_by_status") ,
													'param' => 'B' , 'iframe'=>1,
													'header' => '<b>รายการ'.$this->config->item('eqs_call').'ที่ยืม</b>'
												):'false'

						);
		}
		return $this->data;
	}
	/*
    * eqs_defective_total
    * @input: ข้อมูลทั้งหมดของครุภัณฑ์ที่ชำรุด
    * @output: ค่าที่ของครุภัณฑ์ที่ชำรุด ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2017/06/23
    */
	function eqs_defective_total(){
		$this->get_eqs_defective_total();
		echo json_encode($this->data);
	}
    /*
    * get_eqs_defective_total
    * @input: ค่าต่างๆของครุภัณฑ์ที่ชำรุด
    * @output: ข้อมูลทั้งหมดของครุภัณฑ์ที่ชำรุด
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2017/06/23
    */
	function get_eqs_defective_total(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $eqs_equipment_defective = $this->eqs->get_eqs_defective_by_dp_id(); //defective equipments
		if($eqs_equipment_defective!=0){
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => $this->config->item('eqs_call').'ที่ชำรุด',
								'tile_body' => number_format($eqs_equipment_defective),
								'tile_icon' => "ti ti-hummer",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "#a7a4a4",
								'tile_footer' => "หน่วย",
								'is_expand' => ($eqs_equipment_defective>0)?array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_by_status") ,
													'param' => 'R' , 'iframe'=>1,
													'header' => '<b>รายการ'.$this->config->item('eqs_call').'ที่ชำรุด</b>'
												):'false'
						);
		}
		return $this->data;
	}
	/*
    * eqs_repair_total
    * @input: ข้อมูลทั้งหมดของครุภัณฑ์ที่ชำรุด
    * @output: ค่าที่ของครุภัณฑ์ที่ชำรุด ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	function eqs_repair_total(){
		$this->get_eqs_repair_total();
		echo json_encode($this->data);
	}
    /*
    * get_eqs_repair_total
    * @input: ค่าต่างๆของครุภัณฑ์ที่ชำรุด
    * @output: ข้อมูลทั้งหมดของครุภัณฑ์ที่ชำรุด
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	function get_eqs_repair_total(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $eqs_equipment_repair = $this->eqs->get_eqs_repair_by_dp_id(); //repair equipments
		if($eqs_equipment_repair!=0){
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => $this->config->item('eqs_call').'ที่ส่งซ่อม',
								'tile_body' => number_format($eqs_equipment_repair),
								'tile_icon' => "fa fa-wrench",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "#2f778e",
								'tile_footer' => "หน่วย",
								'is_expand' => ($eqs_equipment_repair>0)?array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_by_status") ,
													'param' => 'RP' , 'iframe'=>1,
													'header' => '<b>รายการ'.$this->config->item('eqs_call').'ที่ส่งซ่อม</b>'
												):'false'
						);
		}
		return $this->data;
	}
	/*
    * eqs_distribute_total
    * @input: ข้อมูลทั้งหมดของครุภัณฑ์ที่จำหน่าย
    * @output: ค่าที่ของครุภัณฑ์ที่จำหน่าย ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
    function eqs_distribute_total(){
		$this->get_eqs_distribute_total();
		echo json_encode($this->data);
	}
    /*
    * get_eqs_distribute_total
    * @input: ค่าต่างๆของครุภัณฑ์ที่จำหน่าย
    * @output: ข้อมูลทั้งหมดของครุภัณฑ์ที่จำหน่าย
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	function get_eqs_distribute_total(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $eqs_equipment_distribute = $this->eqs->get_eqs_distribute_by_dp_id(); //distribute equipments
		if($eqs_equipment_distribute!=0){
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => $this->config->item('eqs_call').'ที่จำหน่าย',
								'tile_body' => number_format($eqs_equipment_distribute),
								'tile_icon' => "ti ti-shopping-cart-full",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "#8c8b4e",
								'tile_footer' => "หน่วย",
								'is_expand' => ($eqs_equipment_distribute>0)?array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_by_status") ,
													'param' => 'S' , 'iframe'=>1,
													'header' => '<b>รายการ'.$this->config->item('eqs_call').'ที่จำหน่าย</b>'
												):'false'
						);
		}
		return $this->data;
	}
	/*
    * eqs_expire_total
    * @input: ข้อมูลทั้งหมดของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี
    * @output: ค่าที่ของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	function eqs_expire_total(){
		$this->get_eqs_expire_total();
		echo json_encode($this->data);
	}
    /*
    * get_eqs_expire_total
    * @input: ค่าต่างๆของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี
    * @output: ข้อมูลทั้งหมดของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	function get_eqs_expire_total(){
		$amount_year=$this->config->item('eqs_year_range');
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $eqs_equipment_expire = $this->eqs->get_eqs_expire_by_dp_id($amount_year); //distribute equipments
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => $this->config->item('eqs_call').'ที่จะหมดอายุภายใน '.$amount_year.' ปี',
								// 'tile_body' => $eqs_equipment_distribute,
								'tile_body' => number_format($eqs_equipment_expire),
								'tile_icon' => "ti ti-stats-down",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "#801313",
								'tile_footer' => "หน่วย" ,
								'is_expand' => ($eqs_equipment_expire>0)?array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_expire_total") ,
													'param' => $amount_year , 'iframe'=>1,
													'header' => '<b>'.$this->config->item('eqs_call').'ที่จะหมดอายุภายใน '.$amount_year.' ปี</b>'
												):'false'
						);
		return $this->data;
	}
   /*
    * eqs_building_total
    * @input: จำนวนสิ่งก่อสร้างทั้งหมด
    * @output: จำนวนสิ่งก่อสร้างทั้งหมด ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2560-01-09
    */
	function eqs_building_total(){
		$this->get_eqs_building_total();
		echo json_encode($this->data);
	}
    /*
    * get_eqs_building_total
    * @input: จำนวนสิ่งก่อสร้างทั้งหมด
    * @output: จำนวนสิ่งก่อสร้างทั้งหมด
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2560-01-09
    */
	function get_eqs_building_total(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = $this->session->userdata('UsDpID');

		$eqs_building_total = $this->eqs->get_amount_eqs_building_by_dp_id();
		if($eqs_building_total!=0){
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => $this->config->item('eqs_call').'สิ่งก่อสร้าง',
								// 'tile_body' => $eqs_equipment_distribute,
								'tile_body' => number_format($eqs_building_total),
								'tile_icon' => "ti ti-home",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "rgba(0, 101, 87, 0.34)",
								'tile_footer' => "หน่วย",
								'is_expand' => ($eqs_building_total>0)?array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_building") ,
													'param' => 'building' , 'iframe'=>1,
													'header' => '<b>รายการ'.$this->config->item('eqs_call').'สิ่งก่อสร้าง</b>'
												):'false'
						);
		}
		return $this->data;
	}

   /*
    * eqs_eqs_purchase
    * @input: การจัดซื้อจัดจ้าง FIX ให้ วพบ.เพชรบุรีใช้เท่านั้น
    * @output: การจัดซื้อจัดจ้าง ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2560-03-26
    */
	function eqs_eqs_purchase(){
		$this->get_eqs_purchase();
		echo json_encode($this->data);
	}
    /*
    * get_eqs_purchase
    * @input: การจัดซื้อจัดจ้าง FIX ให้ วพบ.เพชรบุรีใช้เท่านั้น
    * @output: การจัดซื้อจัดจ้าง
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2560-03-26
    */
	function get_eqs_purchase(){
		$this->data[] = array(  'widget_style' => 'tile-card',
								'pn_hd_color' => 'blue',
								'pn_size' => '3',
								'tile_heading' => 'การจัดซื้อจัดจ้าง',
								// 'tile_body' => $eqs_equipment_distribute,
								'tile_body' => "17",
								'tile_icon' => "ti ti-stats-down",
								'tile_bgcolor' => "white",
								'tile_icocolor' => "rgba(0, 101, 87, 0.34)",
								'tile_footer' => "ปีงบประมาณ 2559",
								'is_expand' => array(
													'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_purchase") ,
													'param' => 'purchase' , 'iframe'=>1,
													'header' => '<b>รายการจัดซื้อจัดจ้าง</b>'
												)
						);
		return $this->data;
	}

//== End Group Box =====================================================


//======================================================================
//=== Group Graph ======================================================
//======================================================================
	/*
    * gen_chart_eqs_total กราฟจำนวนครุภัณฑ์ทั้งหมด
    * @input: ค่าของข้อมูลในตาราง และ ค่าของแท่งกราฟ (แกนy)
    * @output: ค่าของข้อมูลในตาราง และ ค่าของแท่งกราฟ ที่แปลงด้วยการ json_encode
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-17
    * @using : นำค่าต่างๆ เช่น name,number,price มาใส่ data แล้วแปลงเป็น json_encode
    */
	function gen_chart_eqs_total(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
		$rs_fmst = $this->eqs->get_eqs_fmst_by_dpId();
        // gen_name ใช้เก็บชื่อของประเภทครุภัณฑ์ต่างๆ , count_num ใช้นับจำนวนประเภทของครุภัณฑ์ทั้งหมด
        $gen_name = array();
		$data_gen = array();
		$rs_eqs_total_by_fmst = $this->eqs->get_eqs_total_by_dp_id();
        $count_num=0;
		foreach($rs_eqs_total_by_fmst->result() as $row){
			$gen_name[] = $row->fmst_name;
            $count_num++;

			$data_gen[] = array( "name" => $row->fmst_abbr, "data"=>array((int)$row->count_eqs_id),'color'=>$this->data_list_color[$count_num]);
		}

		//==========================================================
		//==========================================================
		//==========================================================


		// foreach($rs_eqs_total_by_fmst->result() as $row){

		// }
		/* $data_gen = "[";
				$i=0;
                foreach($rs_eqs_total_by_fmst->result() as $row){
                    $i++;
                }

                $j=1;
                $k=0;

                foreach($rs_eqs_total_by_fmst->result() as $row){
                $data_gen .= " { " ;
                $data_gen .= "'name':";
                $data_gen .= " ' " ;
                $data_gen .= $row->fmst_abbr;
                $data_gen .= " ' " ;

                $data_gen .= " ,'data': [" ;
                $data_gen .= $row->count_eqs_id;
                $data_gen .= " ] " ; */
                /* $data_gen .= " events : {
							click : function(){
								var category = this.name;
								DataTableModal1.fnClearTable();
								$.each(dataModal1[this.index],function(){
									var temp = [];
									temp.push(this.name);
									temp.push(this.number);
									temp.push(this.price);
									temp.push(this.date);
									temp.push(this.expDate);
									temp.push(this.status);
									DataTableModal1.fnAddData(temp,false);
								});
								DataTableModal1.fnDraw();
								$('#modal_all_tools_of_year #DataTable2 .panel-heading h2').text('รายงานครุภัณฑ์ประเภท'+ category +'ทั้งหมด');
								$('#modal_all_tools_of_year .modal-title').html('<strong>รายงานครุภัณฑ์ประเภท'+ category +'ทั้งหมด</strong>');
								$('#modal_all_tools_of_year').modal();
							}
						}"; */
                       /*  $data_gen .=" } ";
                        if($i != $j){
                        $data_gen .= ",";
                        }
                        $j++;
                        $k++;
                 }
				 $data_gen .= "]"; */
		//==========================================================

		//====== gen_datatable ใช้เก็บค่าของข้อมูลในตาราง ==================================
        $id=0;
        foreach($rs_fmst->result() as $row){
            $fmst_id[$id] = $row->fmst_id;
            // gen_data_item ใช้เก็บค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,price,date,expDate,status เป็น arrays
            $gen_data_item = array();
            $rs_item_table = $this->eqs->get_eqs_item_table($fmst_id[$id]);
                foreach($rs_item_table->result() as $row){
                    $gen_data_item[] = array('name'=>"<a target='_blank' href='".site_url($this->config->item("eqs_folder")."profile/profile/profile_show/".$row->eqs_id)."'>".$row->eqs_name."</a>",'number'=>$row->eqs_code_old,'price'=>number_format($row->eqs_price,2),'date'=>splitDateDb3($row->eqs_buydate,"/"),'expDate'=>splitDateDb3($row->eqs_expiredate,"/"),'status'=>eqs_get_status($row->eqs_status),'detail'=>$row->eqs_detail);
                }
            $gen_datatable[$id] = $gen_data_item;
            $id++;
        }
        //====== gen_datatable เก็บค่าของข้อมูลในตาราง END =============================

        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy) =================================
        $id=0;
        foreach($rs_eqs_total_by_fmst->result() as $row){
            // data_chart ใช้เก็บค่าจำนวนของครุภัณฑ์
            $data_chart[$id] = $row->count_eqs_id;
            $id++;
        }
        for($id=0;$id<$count_num;$id++){
            // chart_data ใช้เก็บค่า id และ ค่าแกนyของกราฟ โดยเก็บเป็น arrays
            $chart_data[] = array("id"=>$id,"y"=>(int)$data_chart[$id]);
        }
        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy)END ==============================
        $data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => $this->head_panel_main,
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => '[AMS2] จำนวน'.$this->config->item('eqs_call').'ทั้งหมด',
			'pn_size' => '12',
			'xaxis_tile' => 'จำนวน',
			'chart_unit' => 'ชิ้น',
			'chart_type' => 'eqs_sp1',
			'chart_data' => array( "dataModal1" => $gen_datatable , "data" => $data_gen),
			'chart_cate' => $gen_name,
			'is_expand' => array(
								'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_chart_total") ,
								'param' => 'chart_total' , 'iframe'=>1,
								'header' => '<b>รายงานสรุปจำนวน'.$this->config->item('eqs_call').'</b>'
							)
        );

        /* $data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => 'rgb(27, 118, 159)',
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => 'จำนวนครุภัณฑ์ทั้งหมด',
			'pn_size' => '12',
			'xaxis_tile' => 'ประเภท',
			'chart_unit' => 'ชิ้น',
			'chart_type' => 'ch_tbz',
			'chart_data' => array( "dataModel" => $gen_datatable , "data" => $data_gen, "table_head" => array('ชื่อ','เลขครุภัณฑ์','ราคา','วันที่ซื้อ', 'วันที่หมดอายุ', 'สถานะ', 'หมายเหตุ')),
			'chart_cate' => $gen_name,
			'is_expand' => "false"
        ); */
		echo json_encode($data);
	}

	/*
    * gen_chart_eqs_by_year กราฟจำนวนครุภัณฑ์ทั้งหมด จำแนกประเภทครุภัณฑ์ รายปี
    * @input: ชื่อครุภัณฑ์ , จำนวนครุภัณฑ์ , ปีที่ใช้ทั้งหมด
    * @output: ค่าของชื่อครุภัณฑ์ , จำนวนครุภัณฑ์ , ปีที่ใช้ทั้งหมด ที่แปลงด้วยการ json_encode
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-18
    * @using : นำค่าต่างๆมาใส่ data แล้วแปลงเป็น json_encode โดยสามารถกำหนดได้ว่าจะเอาย้อนหลังกี่ปี โดยกำหนดที่ count_year ซึ่งในตอนนี้ย้อนหลัง10ปี
    */
	// EDIT 2017/01/31
	function gen_chart_eqs_by_year(){
		$this->gen_chart_eqs_by_year_detail();
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
		$get_year_eqs = $this->eqs->get_year_eqs()->result();
		$details = array();
		$year = 0;
		foreach(array_reverse($get_year_eqs) as $row){
			$details[] = array('name'=>$row->year_eqs+543, 'param'=>$row->year_eqs);
			if($year==0){
				$year = $row->year_eqs;
			}else if($year < $row->year_eqs){
				$year = $row->year_eqs;
			}
		}
		$data[] = array(
						'widget_style'=>'great-card',
						'pn_hd_color'=>	$this->head_panel_main,
						'pn_hd_text_color'=>'#fff',
						'pn_color'=>'#fcf9ed',
						'pn_size'=>12,
						'pn_hd_text'=>'[AMS3] ค้นหาจำนวน'.$this->config->item('eqs_call').'ตามปีงบประมาณ',
						'inner_card'=>$this->data,
						're_great' => array('path' => site_url($this->config->item('eqs_folder')."Service/gen_chart_eqs_by_year_view"),
								'details'=>$details,'default'=>$year
						)
					);
		echo json_encode($data);
	}
	function gen_chart_eqs_by_year_view(){
		$this->gen_chart_eqs_by_year_detail();
		echo json_encode($this->data);
	}
	function gen_chart_eqs_by_year_detail($count_year=3){
        $this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
		$rs_fmst = $this->eqs->get_eqs_fmst_by_dpId();
        // gen_year ใช้เก็บค่าปีต่างๆ เป็น arrays
        $gen_year = array();
        // gen_name ใช้เก็บค่าชื่อของครุภัณฑ์ (name)และข้อมูลของครุภัณฑ์ (data) โดยเก็บเป็น arrays
        $gen_name = array();
		//------------------------------------------------------------
		//---- GET YEAR ----------------------------------------------
		//------------------------------------------------------------
		$get_year_eqs = $this->eqs->get_year_eqs()->result();
		$details = array();
		$year = date('Y');
		foreach($get_year_eqs as $row){
			$details[] = array('name'=>$row->year_eqs+543, 'param'=>$row->year_eqs);
			$year = $row->year_eqs;
		}
		//------------------------------------------------------------
		$current_year = $year;
		if($this->input->post('parameter')){
			$current_year = $this->input->post('parameter');
		}
		// echo $current_year;
		$year = $current_year-$count_year+1;
        for($i=0; $i<$count_year; $i++){
            $gen_year[] = strval($year+543);
            $year++;
        }
        $num_fmst = $rs_fmst->num_rows();
		$ii = 1;
        foreach($rs_fmst->result() as $row){
            $year = $current_year-$count_year+1;
            // gen_data ใช้เก็บค่าของจำนวนครุภัณฑ์โดยจำแนกตามประเภทของครุภัณฑ์
			$gen_data = array();
                for($i=0; $i<$count_year; $i++){
                    $rs_eqs_year = $this->eqs->get_eqs_by_year($row->fmst_id, $year);
                    $year++;
                    $gen_data[] = ((int)$rs_eqs_year->row()->count_eqs_id>0?(int)$rs_eqs_year->row()->count_eqs_id:null);
                }
			$gen_name[] = array('name'=>$row->fmst_abbr,'data'=>$gen_data,'color'=>$this->data_list_color[$ii++]);
        }
		$this->data[] = array(  'widget_style' => 'chart-card',
							'pn_hd_color' => $this->head_panel_lv1,
							'pn_hd_text_color' => '#FFFFFF',
							'pn_hd_text' => '[AMS3-G1] จำนวน'.$this->config->item('eqs_call').'ทั้งหมด จำแนกประเภท'.$this->config->item('eqs_call').' รายปี '.(($current_year+543)-($count_year-1)).' - '.($current_year+543),
							'pn_size' => '12',
							'chart_type' => 'ch2',
							'chart_unit' => 'หน่วย',
							'chart_sub_type' => '',
							'chart_data' => $gen_name,
                            'chart_cate' => $gen_year ,
							'is_expand' => array(
												'link' => site_url($this->config->item('eqs_folder')."Service_popup/eqs_by_year") ,
												'param' => $count_year."|".$current_year , 'iframe'=>1,
												'header' => '<b>รายการ'.$this->config->item('eqs_call').'ทั้งหมด จำแนกรายปีงบประมาณ</b>'
											)
						);
	}

	/*
    * gen_chart_eqs_status จำนวนครุภัณฑ์ทั้งหมด จำแนกประเภทครุภัณฑ์และสถานะ
    * @input: ค่าต่างๆของครุภัณฑ์ตามสถานะต่างๆโดยประกอบไปด้วย สถานะ ใช้งานได้ , ชำรุด , จำหน่าย , ไม่ได้ใช้งาน , ถูกยืม
    * @output: ค่าต่างๆของครุภัณฑ์ ที่แปลงด้วยการ json_encode
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-19
    * @using : นำค่าต่างๆมาใส่ data แล้วแปลงเป็น json_encode โดยแบ่งตามประเภทและสถานะของครุภัณฑ์
    */
	function gen_chart_eqs_status(){
        $this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
		$rs_fmst = $this->eqs->get_eqs_fmst_by_dpId();
        // gen_name ใช้เก็บชื่อของประเภทครุภัณฑ์ต่างๆ
        $gen_name = array();
        foreach($rs_fmst->result() as $row){
            $gen_name[] = $row->fmst_abbr;
        }

        //====== Equipments Ready to use  "Y" ===============================
        // gen_data ใช้เก็บค่าของจำนวนครุภัณฑ์โดยจำแนกตามประเภทของครุภัณฑ์
        $gen_data = array();
        $i=1;
        foreach($rs_fmst->result() as $row){
           // arr_fmst_id ใช้เก็บเลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)
           $arr_fmst_id[$i] = $row->fmst_id;
           $i++;
        }
        for($id=1;$id<$i;$id++){
           $rs_status_ready = $this->eqs->get_eqs_status_ready($arr_fmst_id[$id]);
           $data["rs_status_ready"] = $rs_status_ready;
               foreach($rs_status_ready->result() as $row){
                   $gen_data[] = (int)$row->count_eqs_id;
               }
        }
        // gen_ready ใช้เก็บสถานะของครุภัณฑ์ (ใช้งานได้) และข้อมูลของครุภัณฑ์ที่มีสถานะพร้อมใช้งาน โดยเก็บเป็น arrays
        $gen_ready = array('name'=>'ใช้งานได้','data'=>$gen_data);
        //====== Equipments Ready to use "Y" END ============================

        //====== Equipments Repair  "R" =====================================
        // gen_data ใช้เก็บค่าของจำนวนครุภัณฑ์โดยจำแนกตามประเภทของครุภัณฑ์
        $gen_data = array();
        $i=1;
        foreach($rs_fmst->result() as $row){
           // arr_fmst_id ใช้เก็บเลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)
           $arr_fmst_id[$i] = $row->fmst_id;
           $i++;
        }
        for($id=1;$id<$i;$id++){
           $rs_status_repair = $this->eqs->get_eqs_status_repair($arr_fmst_id[$id]);
           $data["rs_status_repair"] = $rs_status_repair;
               foreach($rs_status_repair->result() as $row){
                   $gen_data[] = (int)$row->count_eqs_id;
               }
        }
        // gen_repair ใช้เก็บสถานะของครุภัณฑ์ (ชำรุด) และข้อมูลของครุภัณฑ์ที่มีสถานะชำรุด โดยเก็บเป็น arrays
        $gen_repair = array('name'=>'ชำรุด','data'=>$gen_data);
        //====== Equipments Repair "R END" ===================================

        //====== Equipments Sell  "S" ========================================
        // gen_data ใช้เก็บค่าของจำนวนครุภัณฑ์โดยจำแนกตามประเภทของครุภัณฑ์
        $gen_data = array();
        $i=1;
        foreach($rs_fmst->result() as $row){
           // arr_fmst_id ใช้เก็บเลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)
           $arr_fmst_id[$i] = $row->fmst_id;
           $i++;
        }
        for($id=1;$id<$i;$id++){
           $rs_status_distribute = $this->eqs->get_eqs_status_distribute($arr_fmst_id[$id]);
           $data["rs_status_distribute"] = $rs_status_distribute;
               foreach($rs_status_distribute->result() as $row){
                   $gen_data[] = (int)$row->count_eqs_id;
               }
        }
        // gen_sell ใช้เก็บสถานะของครุภัณฑ์ (จำหน่าย) และข้อมูลของครุภัณฑ์ที่มีสถานะจำหน่าย โดยเก็บเป็น arrays
        $gen_sell = array('name'=>'จำหน่าย','data'=>$gen_data);
        //====== Equipments Sell  "S" END" ====================================

        //====== Equipments Not Ready to use "N" ==============================
        // gen_data ใช้เก็บค่าของจำนวนครุภัณฑ์โดยจำแนกตามประเภทของครุภัณฑ์
        $gen_data = array();
        $i=1;
        foreach($rs_fmst->result() as $row){
           // arr_fmst_id ใช้เก็บเลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)
           $arr_fmst_id[$i] = $row->fmst_id;
           $i++;
        }
        for($id=1;$id<$i;$id++){
           $rs_status_no_ready = $this->eqs->get_eqs_status_no_ready($arr_fmst_id[$id]);
           $data["rs_status_no_ready"] = $rs_status_no_ready;
               foreach($rs_status_no_ready->result() as $row){
                   $gen_data[] = (int)$row->count_eqs_id;
               }
        }
        // gen_not_ready ใช้เก็บสถานะของครุภัณฑ์ (ไม่ได้ใช้งาน) และข้อมูลของครุภัณฑ์ที่มีสถานะไม่ได้ใช้งาน โดยเก็บเป็น arrays
        $gen_not_ready = array('name'=>'ไม่ได้ใช้งาน','data'=>$gen_data);
        //====== Equipments Not Ready to use "N" END ===========================

        //====== Equipments Borrow "B" =========================================
        // gen_data ใช้เก็บค่าของจำนวนครุภัณฑ์โดยจำแนกตามประเภทของครุภัณฑ์
        $gen_data = array();
        $i=1;
        foreach($rs_fmst->result() as $row){
           // arr_fmst_id ใช้เก็บเลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)
           $arr_fmst_id[$i] = $row->fmst_id;
           $i++;
        }
        for($id=1;$id<$i;$id++){
           $rs_status_borrow = $this->eqs->get_eqs_status_borrow($arr_fmst_id[$id]);
           $data["rs_status_borrow"] = $rs_status_borrow;
               foreach($rs_status_borrow->result() as $row){
                   $gen_data[] = (int)$row->count_eqs_id;
               }
        }
        // gen_borrow ใช้เก็บสถานะของครุภัณฑ์ (ถูกยืม) และข้อมูลของครุภัณฑ์ที่มีสถานะถูกยืม โดยเก็บเป็น arrays
        $gen_borrow = array('name'=>'ถูกยืม','data'=>$gen_data);
        //====== Equipments Not Borrow "B" END ==================================

        // gen_status ใช้เก็บค่าของครุภัณฑ์ตามสถานะต่างๆทั้งหมด โดยเก็บเป็น arrays
        $gen_status[] = $gen_ready;
        $gen_status[] = $gen_repair;
        $gen_status[] = $gen_sell;
        $gen_status[] = $gen_not_ready;
        $gen_status[] = $gen_borrow;
        $data[] = array('widget_style' => 'chart-card',
                       'pn_hd_color' => $this->head_panel_main,
                       'pn_hd_text_color' => '#FFFFFF',
                       'pn_hd_text' => '[AMS4] จำนวน'.$this->config->item('eqs_call').'ทั้งหมด จำแนกประเภท'.$this->config->item('eqs_call').'และสถานะ',
                       'pn_size' => '12',
                       'chart_type' => 'ch2',
					   'chart_unit' => 'หน่วย',
                       'chart_sub_type' => 'stack',
                       'chart_data' => $gen_status,
                       'chart_cate' => $gen_name,
                       'is_expand' => "false"
        );
	    echo json_encode($data);
	}

	/*
    * gen_chart_eqs_expire กราฟจำนวนครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี จำแนกตามประเภท
    * @input: ค่าต่างๆของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี
    * @output: ค่าต่างๆของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี ที่แปลงด้วยการ json_encode
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-22
    * @using : นำค่าต่างๆมาใส่ data แล้วแปลงเป็น json_encode โดยแบ่งตามประเภทของครุภัณฑ์
    */
	function gen_chart_eqs_expire(){
		$c_year=$this->config->item('eqs_year_range');
        $this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
        $this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $rs_fmst = $this->eqs->get_eqs_fmst_expire_by_dpId($c_year);
        // gen_data ใช้เก็บค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย id,name,ค่าแกน y โดยเก็บเป็น arrays
        $gen_data = array();
        // gen_datatable ใช้เก็บค่าของข้อมูลในตาราง เป็น arrays
        $gen_datatable = array();
        // gen_year ใช้เก็บค่าปีต่างๆ เป็น arrays
        $gen_year = array();
        $year = date("Y");
        for($i=0; $i<$c_year; $i++){
            $gen_year[] = strval($year);
            $year--;
        }
		$i=0;
		foreach($rs_fmst->result() as $row){
			// arr_fmst_id ใช้เก็บเลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)
			$arr_fmst_id[$i] = $row->fmst_id;
			// gen_data_item ใช้เก็บค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,buyDate,expDate เป็น arrays
			$gen_data_item = array();
			$rs_expire_graph = $this->eqs->get_eqs_expire_graph_by_dp_id($arr_fmst_id[$i],$c_year);
			$rs_expire_item = $this->eqs->get_eqs_item_expire_by_dp_id($arr_fmst_id[$i],$c_year);
				foreach($rs_expire_graph->result() as $row){
					$gen_data[] = array('id'=>(int)$i,'name'=>$row->fmst_abbr,'y'=>(int)$row->expire,'color'=>$this->data_list_color[$i]);
				}
				foreach($rs_expire_item->result() as $row){
					$gen_data_item[] = array('name'=>$row->eqs_name,'number'=>$row->eqs_code_old,'buyDate'=>splitDateDb3($row->eqs_buydate,"/"),'expDate'=>splitDateDb3($row->eqs_expiredate,"/"));
				}
			$gen_datatable[] = $gen_data_item;
			$i++;
		}
        $data[] = array(  'widget_style' => 'special-card',
			'pn_hd_color' => $this->head_panel_main,
			'pn_hd_text_color' => '#fff',
			'eqs_year_range' => $c_year,
			'pn_hd_text' => '[AMS5-G1] กราฟจำนวน'.$this->config->item('eqs_call').'ที่จะหมดอายุภายใน '.$c_year.' ปี จำแนกตามประเภท',
			'pn_size' => '6',
			'chart_type' => 'eqs_sp2',
			'chart_cate' => $gen_year,
			'chart_dataTable' => $gen_datatable,
			'chart_data' => $gen_data,
			'is_expand' => "false"
        );
        echo json_encode($data);
	}

	/*
    * gen_chart_eqs_end_of_life จำนวนครุภัณฑ์ที่หมดอายุการใช้งานจำแนกตามประเภท
    * @input: -
    * @output: ค่าต่างๆของครุภัณฑ์ ที่แปลงด้วยการ json_encode
    * @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2560-02-03
    * @using : นำค่าต่างๆมาใส่ data แล้วแปลงเป็น json_encode โดยแบ่งตามประเภทของครุภัณฑ์ที่หมดอายุการใช้งาน
    */
	function gen_chart_eqs_end_of_life(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
        $this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
        $get_eqs_EOL = $this->eqs->get_all_eqs_end_of_life(2);

		$gen_datatable = $chart_data = $chart_cate  = array();

		//====== gen_datatable ใช้เก็บค่าของข้อมูลในตาราง ==================================
        $id=0;
        foreach($get_eqs_EOL->result() as $row){
            $fmst_id[$id] = $row->eqs_fmst_id;
            // gen_data_item ใช้เก็บค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,price,date,expDate,status เป็น arrays
            $gen_data_item = array();
            $rs_item_table = $this->eqs->get_all_eqs_end_of_life(1,$fmst_id[$id]);
			// echo "<pre>";print_r($rs_item_table->result());echo "</pre>";
                foreach($rs_item_table->result() as $row2){
                    $gen_data_item[] = array('name'=>"<a target='_blank' href='".site_url($this->config->item("eqs_folder")."profile/profile/profile_show/".$row2->eqs_id)."'>".$row2->eqs_name."</a>",'number'=>$row2->eqs_code_old,'price'=>number_format($row2->eqs_price,2),'date'=>splitDateDb3($row2->eqs_buydate,"/"),'expDate'=>splitDateDb3($row2->eqs_expiredate,"/"),'status'=>eqs_get_status($row2->eqs_status),'detail'=>$row2->eqs_detail);
                }
            $gen_datatable[$id] = $gen_data_item;
            $id++;
        }
		$i=1;
		foreach($get_eqs_EOL->result() as $row){
			$chart_data[] = array("name"=>$row->fmst_abbr ,"data"=>array((int)$row->amount),'color'=>$this->data_list_color[$i++]);
		}

		$data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => $this->head_panel_main,
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => '[AMS6] จำนวน'.$this->config->item('eqs_call').'ที่หมดอายุการใช้งานจำแนกตามประเภท',
			'pn_size' => '12',
			'chart_type' => 'eqs_sp1',
			'chart_data' => array( "dataModal1" => $gen_datatable , "data" => $chart_data),
			// 'chart_cate' => $gen_name,
			'is_expand' => "false"
        );
		echo json_encode($data);
	}

	/*
    * gen_chart_eqs_building_all จำนวนสิ่งก่อสร้างทั้งหมดจำแนกตามประเภทสิ่งก่อสร้าง
    * @input: -
    * @output: ค่าต่างๆของครุภัณฑ์ ที่แปลงด้วยการ json_encode
    * @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2560-03-09
    */
	function gen_chart_eqs_building_all(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
		$rs_fmst = $this->eqs->get_eqs_fmst_building_by_dpId();
        // gen_name ใช้เก็บชื่อของประเภทครุภัณฑ์ต่างๆ , count_num ใช้นับจำนวนประเภทของครุภัณฑ์ทั้งหมด

        $gen_name_title = $gen_name = array();
		$data_gen = array();
		$gen_datatable = array();

		$rs_eqs_total_by_fmst = $this->eqs->get_eqs_building_total_by_dp_id();
        $count_num=0;
		foreach($rs_eqs_total_by_fmst->result() as $row){
			$gen_name[] = $row->fmst_name;
			$gen_name_title[] = "ตารางรายการข้อมูล".$this->config->item('eqs_call')."ประเภท".$row->fmst_name;
            $count_num++;

			$data_gen[] = array( "name" => $row->fmst_abbr, "data"=>array((int)$row->count_eqs_id),'color'=>$this->data_list_color[$count_num++]);
		}

		//==========================================================

		//====== gen_datatable ใช้เก็บค่าของข้อมูลในตาราง ==================================
        $id=0;
        foreach($rs_fmst->result() as $row){
            $fmst_id[$id] = $row->fmst_id;
            // gen_data_item ใช้เก็บค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,price,date,expDate,status เป็น arrays
            $gen_data_item = array();
            $rs_item_table = $this->eqs->get_eqs_building_item_table($fmst_id[$id]);
                foreach($rs_item_table->result() as $row){
                    $gen_data_item[] = array('name'=>"<a target='_blank' href='".site_url($this->config->item("eqs_folder")."profile/profile/profile_show/".$row->eqs_id)."'>".$row->eqs_name."</a>",'number'=>$row->eqs_code_old,'price'=>number_format($row->eqs_price,2),'bd_area'=>number_format($row->bd_area,2),'date'=>splitDateDb3($row->eqs_buydate,"/"),'expDate'=>splitDateDb3($row->eqs_expiredate,"/"),'status'=>eqs_get_status($row->eqs_status));
                }
            $gen_datatable[$id] = $gen_data_item;
            $id++;
        }
        //====== gen_datatable เก็บค่าของข้อมูลในตาราง END =============================

        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy) =================================
       /*  $id=0;
        foreach($rs_eqs_total_by_fmst->result() as $row){
            // data_chart ใช้เก็บค่าจำนวนของครุภัณฑ์
            $data_chart[$id] = $row->count_eqs_id;
            $id++;
        }
        for($id=0;$id<$count_num;$id++){
            // chart_data ใช้เก็บค่า id และ ค่าแกนyของกราฟ โดยเก็บเป็น arrays
            $chart_data[] = array("id"=>$id,"y"=>(int)$data_chart[$id]);
        }   */
        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy)END ==============================

        /* $data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => 'rgb(27, 118, 159)',
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => 'จำนวนสิ่งก่อสร้างทั้งหมดจำแนกตามประเภทสิ่งก่อสร้าง',
			'pn_size' => '12',
			'chart_type' => 'eqs_sp1',
			'chart_data' => array( "dataModal1" => $gen_datatable , "data" => $data_gen),
			'chart_cate' => $gen_name,
			'is_expand' => "false"
        ); */
		$data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => $this->head_panel_main,
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => '[AMS7] จำนวนสิ่งก่อสร้างทั้งหมดจำแนกตามประเภทสิ่งก่อสร้าง',
			'pn_size' => '12',
			'xaxis_tile' => 'ประเภท',
			'chart_unit' => 'หน่วย',
			'chart_type' => 'ch_tbz',
			'chart_data' => array( "dataModel" => $gen_datatable , "data" => $data_gen, "table_head" => array('ชื่อ'.$this->config->item('eqs_call'),'เลข'.$this->config->item('eqs_call'),'ราคา','พื้นที่ใช้สอย(ตรม.)','วันที่ซื้อ','วันที่หมดอายุ','สถานะ'), "chart_cate_label"=>$gen_name_title),
			'chart_cate' => $gen_name,
			'is_expand' => "false"
        );
		echo json_encode($data);
	}

	/*
    * gen_chart_eqs_building_by_type จำนวนสิ่งก่อสร้างทั้งหมดจำแนกตามประเภทการใช้สอย
    * @input: -
    * @output: ค่าต่างๆของครุภัณฑ์ ที่แปลงด้วยการ json_encode
    * @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2560-03-09
    */
	function gen_chart_eqs_building_by_type(){
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
		$rs_fmst = $this->eqs->get_eqs_fmst_building_by_dpId_3();
        // gen_name ใช้เก็บชื่อของประเภทครุภัณฑ์ต่างๆ , count_num ใช้นับจำนวนประเภทของครุภัณฑ์ทั้งหมด
        $gen_name_title = $gen_name = array();
		$data_gen = array();
		$gen_datatable = array();
		$rs_eqs_total_by_fmst = $this->eqs->get_eqs_building_total_by_dp_id_3();
        $count_num=0;
		foreach($rs_eqs_total_by_fmst->result() as $row){
			$gen_name[] = $row->bdtype_name;
			$gen_name_title[] = "ตารางรายการพื้นที่ใช้สอยประเภท".$row->bdtype_name;
            $count_num++;

			$data_gen[] = array( "name" => $row->bdtype_name, "data"=>array((int)$row->count_bdd_bdtype_id));
		}

		// pre($data_gen);die;
		//==========================================================

		//====== gen_datatable ใช้เก็บค่าของข้อมูลในตาราง ==================================
        $id=0;
        foreach($rs_fmst->result() as $row){
            $bdd_bdtype_id[$id] = $row->bdd_bdtype_id;
            // gen_data_item ใช้เก็บค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,price,date,expDate,status เป็น arrays
            $gen_data_item = array();
            $rs_item_table = $this->eqs->get_eqs_building_item_table_3($bdd_bdtype_id[$id]);
                foreach($rs_item_table->result() as $row){

                    $gen_data_item[] = array('name'=>$row->eqs_name,'number'=>$row->eqs_code_old,'price'=>number_format($row->eqs_price,2),'bdtype_name'=>$row->bdtype_name,'bdd_area'=>$row->bdd_area,'date'=>splitDateDb3($row->eqs_buydate,"/"),'expDate'=>splitDateDb3($row->eqs_expiredate,"/"),'status'=>eqs_get_status($row->eqs_status));
                }
            $gen_datatable[$id] = $gen_data_item;
            $id++;
        }

        //====== gen_datatable เก็บค่าของข้อมูลในตาราง END =============================

        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy) =================================
       /*  $id=0;
        foreach($rs_eqs_total_by_fmst->result() as $row){
            // data_chart ใช้เก็บค่าจำนวนของครุภัณฑ์
            $data_chart[$id] = $row->count_bdd_bdtype_id;
            $id++;
        }
        for($id=0;$id<$count_num;$id++){
            // chart_data ใช้เก็บค่า id และ ค่าแกนyของกราฟ โดยเก็บเป็น arrays
            $chart_data[] = array("id"=>$id,"y"=>(int)$data_chart[$id]);
        }   */
        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy)END ==============================

        /* $data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => 'rgb(27, 118, 159)',
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => 'จำนวนสิ่งก่อสร้างทั้งหมดจำแนกตามประเภทการใช้สอย',
			'pn_size' => '12',
			'chart_type' => 'eqs_sp1',
			'chart_data' => array( "dataModal1" => $gen_datatable , "data" => $data_gen),
			'chart_cate' => $gen_name,
			'is_expand' => "false"
        ); */
        $data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => $this->head_panel_main,
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => '[AMS8] จำนวนสิ่งก่อสร้างทั้งหมดจำแนกตามประเภทการใช้สอย',
			'pn_size' => '12',
			'xaxis_tile' => 'ประเภท',
			'chart_unit' => 'หน่วย',
			'chart_type' => 'ch_tbz',
			'chart_data' => array( "dataModel" => $gen_datatable , "data" => $data_gen, "table_head" => array('ชื่อครุภัณฑ์','เลขครุภัณฑ์','ราคา','ชื่อประเภทการใช้สอย','พื้นที่ใช้สอย(ตรม.)','วันที่ซื้อ','วันที่หมดอายุ','สถานะ'), "chart_cate_label"=>$gen_name_title),
			'chart_cate' => $gen_name,
			'is_expand' => "false"
        );
		echo json_encode($data);
	}
//=== END Group Graph ==================================================
	/*
    * gen_table_building_type 
    * @input: -
    * @output: ค่าต่างๆของครุภัณฑ์ ที่แปลงด้วยการ json_encode
    * @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2561-08-06
    */
	function gen_table_building_type(){
		$this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
		$bd = $this->bd;
		
		$get_building_type = $bd->get_count_building_type(); 
		
		$arr_th = array(
						array(
						  'th' => 
							array(
							  array(
								'attr' => 'style="text-align:center;background-color:#0275d8;"',
								'text' => 'ลำดับ'
							  ),
							  array(
								'attr' => 'style="text-align:center;background-color:#0275d8;"',
								'text' => 'ประเภทใช้สอย'
							  ),
							  array(
								'attr' => 'style="text-align:center;background-color:#0275d8;"',
								'text' => 'จำนวนห้อง'
							  ),
							  array(
								'attr' => 'style="text-align:center;background-color:#0275d8;"',
								'text' => 'ความจุทั้งหมด'
							  )
							),
						  'thr_attr' => 'class="success"'
						)
					);
		$arr_td = array();
		$i = 1;
		foreach($get_building_type->result() as $row){
			$arr_td[] = array(
					  'param' => '',
					  'td' => 
						array(
						  array(
							'attr' => '','text' => $i++
						  ),
						  array(
							'attr' => "onclick='post(\"".site_url($this->config->item('eqs_folder')."Building_type/bdtype_show_detail")."\",{bdtype_id:".$row->bdtype_id.",bdtype_name:".$row->bdtype_name."},\"_blank\")'",'text' => $row->bdtype_name
						  ),
						  array(
							'attr' => '','text' => $row->rm_count
						  ),
						  array(
							'attr' => '','text' => (isset($row->sum_capacity)?$row->sum_capacity:0)
						  )
						),
					  'tr_attr' => ''
					);
		}
		$table_data = array( 'thr' => $arr_th, 'tr' => $arr_td);
		$data[] = array(    'widget_style' => 'table-card',
						'pn_hd_color' => $this->head_panel_main,
						'pn_hd_text_color' => 'white',
						'pn_size' => '12',
						'pn_hd_text' => '[AMS9] ข้อมูลประเภทการใช้สอย',
						'table_type' => 'basic-npad',
						'table_data' => $table_data
		);
		echo json_encode($data);
	}
	
	/*
    * gen_graph_top_building_type 
    * @input: -
    * @output: ค่าต่างๆของครุภัณฑ์ ที่แปลงด้วยการ json_encode
    * @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2561-08-06
    */
	function gen_graph_top_building_type(){
		$this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
		$bd = $this->bd;
		
		$get_building_type = $bd->get_count_building_type("rm_count DESC,sum_capacity DESC","10"); 
		$arr_bdtype = array();
		$i=0;
		foreach($get_building_type->result() as $row){
			$arr_bdtype[] = array('name' => $row->bdtype_name, 'y' => (int)$row->rm_count, 'color' => $this->data_list_color[$i++], 'list' => ""/* ,'visible'=>false */);
		}
		
		$data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => $this->head_panel_main,
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => '[AMS9] ข้อมูลประเภทการใช้สอย',
			'pn_size' => '12',
			'chart_unit' => 'ห้อง',
			'chart_type' => 'ch1',
			'tooltip' => array( 
				'headerFormat'=>'<span style="font-size: 18px">{point.key}</span><br>',
				'pointFormat'=>'<span style="font-size: 18px">จำนวน {point.y} ห้อง</span>' 
			), // headerFormat คือรูปแบบและ ข้อความที่ต้องการแสดงในหัวข้อความ tooltip pointFormat คือรูปแบบและ ข้อความที่ใช้แสดงในส่วนของค่าของข้อมูลแต่ละอัน {point.key}แทนชื่อ series และ {point.y}ค่าของค่ามูล
			'chart_data' => $arr_bdtype,
			'is_expand' => array('link' => 'getStd' , 'param' => 'xxxx')
		);
		echo json_encode($data);
	}
	/*
    * gen_table_building_type 
    * @input: -
    * @output: ค่าต่างๆของครุภัณฑ์ ที่แปลงด้วยการ json_encode
    * @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2561-08-06
    */
	/*
    * eqs_distribute_total
    * @input: ข้อมูลทั้งหมดของครุภัณฑ์ที่จำหน่าย
    * @output: ค่าที่ของครุภัณฑ์ที่จำหน่าย ที่แปลงด้วยการ json_encode
	* @author: Chaiwat Rojjarroenviwat (Chain)
    * @Create Date: 2016/08/08
    */
	
	function gen_eqs_room_type(){
		
		$this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
		$this->eqs->eqs_dpId = ($this->session->userdata('UsDpID'))?$this->session->userdata('UsDpID'):1;
		$rs_fmst = $this->eqs->get_bd_name_abbr_room_by_dpId();
        // gen_name ใช้เก็บชื่อของอาคาร , count_num ใช้นับจำนวนประเภทของครุภัณฑ์ทั้งหมด
        $gen_name_title = $gen_name = array();
        $gen_name = array();
		$data_gen = array();
		$rs_eqs_total_by_fmst = $this->eqs->get_eqs_room_total_by_dp_id();
        $count_num=0;
		foreach($rs_eqs_total_by_fmst->result() as $row){
			$gen_name[] = $row->bd_name_abbr;
			$gen_name_title[] = "ตารางรายการข้อมูลห้องภายใน".$row->bd_name_abbr;
            $count_num++;

			$data_gen[] = array( "name" => $row->bd_name_abbr, "data"=>array((int)$row->count_eqs_id),'color'=>$this->data_list_color[$count_num]);
		}

		//====== gen_datatable ใช้เก็บค่าของข้อมูลในตาราง ==================================
      	$id=0;
        foreach($rs_fmst->result() as $row){
            $bdd_bdtype_id[$id] = $row->bd_id;
            // gen_data_item ใช้เก็บค่าต่างๆของห้องโดยประกอบไปด้วย name,number,floor,capacity,area,type,status เป็น arrays
            $gen_data_item = array();
            $rs_item_table = $this->eqs->get_eqs_room_table($bdd_bdtype_id[$id]);
			$i=0;
                foreach($rs_item_table->result() as $row){
					$id_room[$i] = $row->rm_id;
					//$count_eqs = จำนวนครุภัณฑ์ในแต่ละห้อง
					$count_eqs = $this->eqs->get_count_eqs_in_room($id_room[$i]);
					
					
					// href จะส่งค่า 'rm_id' และ  หมายเลขห้อง เข้าฟังก์ชันshow_room_details ในไฟล์ Profile
					$gen_data_item[] = array('name'=>"<a target='_blank' href='".site_url($this->config->item("eqs_folder")."profile/Profile/show_room_details/rm_id/".$row->rm_id)."'>".$row->rm_name."</a>",'number'=>"<center>".$row->rm_no."</center>",'rm_floor'=>"<center>".$row->rm_floor."</center>",'count'=>"<center>".$count_eqs."</center>",'rm_capacity'=>"<center>".$row->rm_capacity."</center>",'rm_area'=>"<center>".$row->rm_area."</center>",'bdtype_name'=>$row->bdtype_name,'status_name'=>$row->status_name);

                }
            $gen_datatable[$id] = $gen_data_item;
            $id++;
        }
        //====== gen_datatable เก็บค่าของข้อมูลในตาราง END =============================

        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy) =================================
        $id=0;
        foreach($rs_eqs_total_by_fmst->result() as $row){
            // data_chart ใช้เก็บค่าจำนวนของครุภัณฑ์
            $data_chart[$id] = $row->count_eqs_id;
            $id++;
        }
        for($id=0;$id<$count_num;$id++){
            // chart_data ใช้เก็บค่า id และ ค่าแกนyของกราฟ โดยเก็บเป็น arrays
            $chart_data[] = array("id"=>$id,"y"=>(int)$data_chart[$id]);
        }
        //====== chart_data เก็บค่าของแท่งกราฟ (แกนy)END ==============================
        $data[] = array(  'widget_style' => 'chart-card',
			'pn_hd_color' => $this->head_panel_main,
			'pn_hd_text_color' => 'white',
			'pn_hd_text' => '[AMS10] จำนวนพื้นที่ใช้สอยในแต่ละอาคาร ',
			'pn_size' => '12',
			'xaxis_tile' => 'อาคาร',
			'chart_unit' => 'ห้อง',
			'chart_type' => 'ch_tbz',
			//chart_data = ชื่อของหัวตาราง
			'chart_data' => array( "dataModel" => $gen_datatable , "data" => $data_gen, "table_head" => array('ชื่อห้อง','หมายเลขห้อง','ชั้น','จำนวนครุภัณฑ์','ความจุ (คน)','พื้นที่ห้อง (ตรว.)','ประเภท','สถานะ'), "chart_cate_label"=>$gen_name_title),
			'chart_cate' => $gen_name,
			'is_expand' => "false"
        );
		echo json_encode($data);
	}
}
?>
