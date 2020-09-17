<?php 
include_once("Da_jon_reserve_car_detail.php");
class M_jon_reserve_car_detail extends Da_jon_reserve_car_detail {
function get_driver(){
	$sql="SELECT * FROM $this->hrdb.hr_person
	LEFT JOIN $this->hrdb.hr_prefix ON ps_pf_id = pf_id
	LEFT JOIN $this->hrdb.hr_position ON ps_pos_id = pos_id
	LEFT JOIN $this->hrdb.hr_adline_position ON pos_alp_id = alp_id
	LEFT JOIN $this->hrdb.hr_admin ON ps_admin_id = admin_id
	WHERE alp_id=391";
	$query = $this->jongsdb->query($sql);
	return $query;
	// echo($sql);die;
}
// แสดงรายละเอียดของ ข้อมูลยานพาหนะ
function get_data_car(){
	$sql = "SELECT *
	FROM $this->eqsdb.eqs_equipments
	WHERE eqs_fmst_id=3";
	$query = $this->jongsdb->query($sql);
	return $query;		
}
// แสดงรายละเอียดของ หน้าจัดการข้อมูลยานพาหนะ
function get_data_reserve_car(){ 
	$sql = "SELECT * FROM jon_reserve_car
	LEFT JOIN $this->hrdb.hr_person ON hr_person.ps_id = rsc_ps_id
	LEFT JOIN $this->hrdb.hr_prefix ON hr_person.ps_pf_id = pf_id
	WHERE rsc_rscst_id = 1 AND rsc_active='Y'";
	// pre ($sql);	
	$query = $this->jongsdb->query($sql);
	return $query;	
}
}?>

<!-- rsc_id,hr_prefix.pf_name,hr_person.ps_fname,hr_person.ps_lname,rsc_place,rsc_title,rsc_start_date,rsc_end_date -->