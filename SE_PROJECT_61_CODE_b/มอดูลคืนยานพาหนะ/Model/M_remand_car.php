<?php
include_once("Da_remand_car.php");
class M_remand_car extends Da_remand_car {
	function __construct() {
        parent::__construct();
	}
	function get_all_data_remand_car($id){
		$sql  ="SELECT rsc_id, rsc_date_create, pf_name,ps_fname, ps_lname, alp_name, alp_name_abrr, rsc_place, rsc_companion, rsct_name, rsc_title, rsc_start_date, rsc_end_date FROM pck_hrdb.hr_person hr_person
				LEFT JOIN pck_hrdb.hr_prefix hr_prefix ON hr_person.ps_pf_id = hr_prefix.pf_id
				LEFT JOIN pck_hrdb.hr_department hr_department ON hr_person.ps_dept_id = hr_department.dept_id
				LEFT JOIN pck_hrdb.hr_position hr_position ON hr_person.ps_pos_id = hr_position.pos_id
				LEFT JOIN pck_hrdb.hr_adline_position hr_adline_position ON hr_position.pos_alp_id = hr_adline_position.alp_id
				LEFT JOIN pck_jongsdb.jon_reserve_car jon_reserve_car ON hr_person.ps_id = jon_reserve_car.rsc_ps_id
				LEFT JOIN pck_jongsdb.jon_reserve_car_detail jon_reserve_car_detail ON jon_reserve_car.rsc_id = jon_reserve_car_detail.rscd_rsc_id
				LEFT JOIN pck_jongsdb.jon_reserve_car_type jon_reserve_car_type ON jon_reserve_car.rsc_rsct_id = jon_reserve_car_type.rsct_id
				WHERE jon_reserve_car.rsc_id = ?";
		$query = $this->jongsdb->query($sql,array($id));
		return $query;
	}//close function get_all_data_remand_car

	function get_jon_reserve_car_guest_pck_jongsdb($id){
		$sql = "SELECT rscg_id, rscg_rsc_id, pf_name as rscg_pf_name, rscg_fname, rscg_lname, rscg_tel, rscg_place, rsc_guest_receive_date, rsc_guest_send_date  FROM pck_jongsdb.jon_reserve_car_guest 
				LEFT JOIN pck_hrdb.hr_prefix hr_prefix ON hr_prefix.pf_id = jon_reserve_car_guest.rscg_pf_id
				LEFT JOIN pck_jongsdb.jon_reserve_car jon_reserve_car ON jon_reserve_car_guest.rscg_rsc_id = jon_reserve_car.rsc_id
			    WHERE jon_reserve_car_guest.rscg_rsc_id = ?";
		$query = $this->jongsdb->query($sql,array($id));
		return $query;
	}// showe table : jon_reserve_car_guest on database : pck_jongsdb  แสดงรายชื่่อพนักงานขับรถ

	function get_jon_reserve_car_detail_pck_jongsdb($id){
		$sql = "SELECT  rscd_id as rscd_id_car_detail, rscd_rsc_id as rscd_rsc_id_car_detail,eqs_name as eqs_name_car_detail, rscd_eqs_id, pf_name as pf_name_car_detail, ps_fname as ps_fname_car_detail, ps_lname as ps_lname_car_detail,img_path as img_path_car_detail, rscst_name, rsc_driver FROM pck_jongsdb.jon_reserve_car_detail jon_reserve_car_detail
				LEFT JOIN pck_eqsdb.eqs_equipments eqs_equipments on eqs_equipments.eqs_id=jon_reserve_car_detail.rscd_eqs_id 
				LEFT JOIN pck_hrdb.hr_person hr_person on hr_person.ps_id=jon_reserve_car_detail.rscd_ps_id
				LEFT JOIN pck_hrdb.hr_prefix hr_prefix ON hr_person.ps_pf_id = hr_prefix.pf_id 
				LEFT JOIN pck_eqsdb.eqs_image eqs_image on eqs_image.img_eqs_id = eqs_equipments.eqs_id
				LEFT JOIN pck_jongsdb.jon_reserve_car jon_reserve_car ON jon_reserve_car_detail.rscd_rsc_id =jon_reserve_car.rsc_id 
				LEFT JOIN pck_jongsdb.jon_reserve_car_state jon_reserve_car_state ON jon_reserve_car.rsc_rscst_id=jon_reserve_car_state.rscst_id
			   	WHERE jon_reserve_car_detail.rscd_rsc_id = ?";
		$query = $this->jongsdb->query($sql,array($id));
		return $query;
	}// show table jon_reserve_car_detail

}//end class M_remand_car

?>
