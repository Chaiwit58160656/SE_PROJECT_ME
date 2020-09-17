<?php
include_once("Da_jon_reserve_car.php");
class M_jon_reserve_car extends Da_jon_reserve_car{
	function get_reserve_car(){
		$sql ="SELECT rsc_id,rsc_code,rsc_date,rsc_title,eqs_name,rscst_id,rscst_name,rsc_place,img_path,rsc_start_date,rsc_end_date,rscst_id,count(eqs_name) as count_eqs
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
		LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
		LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
		WHERE (rsc_rscst_id = 1 OR rsc_rscst_id = 2) AND rsc_active='Y'
		GROUP BY rsc_id
		ORDER BY rsc_date DESC";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	function get_reserve_car_state_appro(){
		$sql ="SELECT rsc_id,rsc_code,rsc_date,rsc_title,eqs_name,rscst_id,rscst_name,rsc_place,img_path,rsc_start_date,rsc_end_date,count(eqs_name) as count_eqs
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
		LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
		LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
		WHERE rsc_rscst_id = 3 AND rsc_active='Y'
		GROUP BY rsc_id
		ORDER BY rsc_date DESC";
		$query = $this->jongsdb->query($sql);
		return $query;
	}

	function get_reserve_car_state_notappro(){
		$sql ="SELECT rsc_id,rsc_code,rsc_date,rsc_title,eqs_name,rscst_id,rscst_name,rsc_place,img_path,rsc_start_date,rsc_end_date,rscst_id
		,count(eqs_name) as count_eqs
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
		LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
		LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
		WHERE rsc_rscst_id = 4 AND rsc_active='Y'
		GROUP BY rsc_id
		ORDER BY rsc_date DESC";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	// function get_reserve_car_state_using(){
	// 	$sql ="SELECT rsc_id,rsc_code,rsc_date,rsc_title,eqs_name,rscst_id,rscst_name,rsc_place,img_path
	// 	FROM jon_reserve_car
	// 	LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
	// 	LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
	// 	LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
	// 	LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
	// 	WHERE rsc_rscst_id = 5 AND rsc_active='Y'
	// 	ORDER BY rsc_date DESC";
	// 	$query = $this->jongsdb->query($sql);
	// 	return $query;
	// }
	function get_reserve_car_state_remand(){
		$sql ="SELECT rsc_id,rsc_code,rsc_date,rsc_title,eqs_name,rscst_id,rscst_name,rsc_place,img_path,rsc_start_date,rsc_end_date,
		count(eqs_name) as count_eqs,rscst_id
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
		LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
		LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
		WHERE rsc_rscst_id = 9 AND rsc_active='Y'
		GROUP BY rsc_id
		ORDER BY rsc_date DESC";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	function search_reserve_car(){
		$sql ="SELECT rsc_id,rsc_code,rsc_date,rsc_title,eqs_name,rscst_id,rscst_name,rsc_place,img_path
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
		LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
		LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
		WHERE rsc_rscst_id=1 AND rsc_active='Y'";
		$query = $this->jongsdb->query($sql);
		return $query;
		
	}
	function get_reserve_car_name($rsc_id){
		$sql="SELECT rsc_id,eqs_name,img_path,rscd_rsc_id,CONCAT(pf_name,ps_fname,' ',ps_lname) as driver_name 
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
		LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id
		LEFT JOIN $this->hrdb.hr_person ON rscd_ps_id = ps_id 
		LEFT JOIN $this->hrdb.hr_prefix pf ON ps_pf_id = pf_id 
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
		LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
		WHERE rsc_active='Y'
		AND rsc_id = $rsc_id";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	// function get_resreve_car_data($sdate,$edate){
	// 	$sql = "SELECT * 
	// 	FROM `jon_reserve_car_detail` 
	// 	LEFT JOIN jon_reserve_car ON rsc_id = rscd_rsc_id 
	// 	LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_id = rscd_eqs_id 
	// 	LEFT JOIN $this->hrdb.hr_person ON rscd_ps_id = ps_id 
	// 	WHERE rsc_date BETWEEN '$sdate' AND '$edate'";
	// 	$query = $this->jongsdb->query($sql);
	// 	return $query;
	// }
	function get_resreve_car_data($sdate,$edate){
		$sql ="SELECT *
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_state ON rscst_id = rsc_rscst_id
		LEFT JOIN jon_reserve_car_detail ON rscd_id = rsc_id
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_equipments.eqs_id = jon_reserve_car_detail.rscd_eqs_id
		LEFT JOIN $this->eqsdb.eqs_image ON eqs_image.img_eqs_id = jon_reserve_car_detail.rscd_eqs_id
		WHERE rsc_date BETWEEN '$sdate' AND '$edate'";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
//----form----
	function get_all_person(){
		$sql= "SELECT * 
		FROM ".$this->hrdb.".hr_person
		LEFT JOIN ".$this->hrdb.".hr_prefix ON ps_pf_id = pf_id
		LEFT JOIN ". $this->hrdb.".hr_position ON ps_pos_id = pos_id
		LEFT JOIN ". $this->hrdb.".hr_adline_position ON pos_alp_id = alp_id
		LEFT JOIN  ".$this->hrdb.".hr_admin ON ps_admin_id = admin_id";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	function get_car_type($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY ";
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
		FROM jon_reserve_car_type
		$orderBy";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	function get_car_status($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY ";
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
		FROM jon_reserve_car_status
		$orderBy";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	function get_province(){
		$sql="SELECT *
		FROM $this->hrdb.hr_province";
		$query = $this->jongsdb->query($sql);
		return $query;
		
	}
	function get_prefix(){
		$sql="SELECT pf_id,pf_name,pf_name_abbr
		FROM $this->hrdb.hr_prefix";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	function get_all(){
		$sql="SELECT rsc_code
		FROM jon_reserve_car";
		$query = $this->jongsdb->query($sql);
		return $query;
	}

	function get_max_rsc_code(){
		$sql="SELECT MAX(rsc_code) as maxid FROM jon_reserve_car";
		$query = $this->jongsdb->query($sql);
		return $query;
	}
	function get_last_rsc_id(){
		$sql="SELECT MAX(rsc_id) as last_id FROM jon_reserve_car";
		$query = $this->jongsdb->query($sql);
		return $query;
	}

	function get_resereve_car_by_id($rsc_id){
		$sql="SELECT *  FROM `jon_reserve_car` 
			LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
			LEFT JOIN jon_reserve_car_guest ON rsc_id = rscg_rsc_id 
			LEFT JOIN jon_reserve_car_status ON rsc_rscs_id = rscs_id 
			LEFT JOIN $this->hrdb.hr_person ON rsc_ps_id = ps_id 
			LEFT JOIN $this->hrdb.hr_prefix pf ON ps_pf_id = pf_id 
			LEFT JOIN $this->hrdb.hr_position ON ps_pos_id = pos_id 
			LEFT JOIN $this->hrdb.hr_adline_position ON pos_alp_id = alp_id 
			LEFT JOIN $this->hrdb.hr_admin ON ps_admin_id = admin_id 
			LEFT JOIN $this->hrdb.hr_department ON dept_id = ps_dept_id 
			LEFT JOIN $this->hrdb.hr_province ON rsc_pv_id = pv_id 
			LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_id = rscd_eqs_id 
			LEFT JOIN (select pf_name as gs_pf_name,rscg_fname as gs_rscg_fname,rscg_lname as gs_rscg_lname,rscg_place as gs_rscg_place,rscg_tel as gs_rscg_tel,rscg_rsc_id as gs_rscg_rsc_id,pf_id as gs_pf_id  from jon_reserve_car_guest inner join pck_hrdb.hr_prefix on rscg_pf_id = pf_id)  guest on guest.gs_rscg_rsc_id = rsc_id
			WHERE rsc_active ='Y' AND rsc_id ='$rsc_id'
			GROUP BY rsc_id";
		$query = $this->jongsdb->query($sql);
		return $query;
	}

	function get_detail_by_rsc_id($rsc_id){
		$sql = "SELECT rsc_id,rsc_code,rsc_date,rscst_name,rsc_place,rscs_name,rsct_name,rsc_title,rsc_companion,rsc_note,rsc_guest,rsc_driver,eqs_name,pf_name,ps_fname,ps_lname,alp_name,dept_name,pv_name,rsc_start_date,rsc_end_date,rsc_guest_receive_date,rsc_guest_send_date,gs_pf_name,gs_rscg_fname,gs_rscg_lname,gs_rscg_place,gs_rscg_tel,dr_ps_fname,dr_ps_lname,rscd_ps_id
		FROM jon_reserve_car
		LEFT JOIN jon_reserve_car_detail ON rsc_id = rscd_rsc_id 
		LEFT JOIN jon_reserve_car_guest ON rsc_id = rscg_rsc_id 
		LEFT JOIN jon_reserve_car_status ON rsc_rscs_id = rscs_id
        LEFT JOIN jon_reserve_car_state ON rsc_rscst_id = rscst_id
        LEFT JOIN jon_reserve_car_type ON rsc_rsct_id = rsct_id
		LEFT JOIN $this->eqsdb.eqs_equipments ON eqs_id = rscd_eqs_id
		LEFT JOIN $this->hrdb.hr_person ON rsc_ps_id = ps_id 
		LEFT JOIN $this->hrdb.hr_prefix pf ON ps_pf_id = pf_id 
		LEFT JOIN $this->hrdb.hr_position ON ps_pos_id = pos_id 
		LEFT JOIN $this->hrdb.hr_adline_position ON pos_alp_id = alp_id 
		LEFT JOIN $this->hrdb.hr_admin ON ps_admin_id = admin_id 
		LEFT JOIN $this->hrdb.hr_province ON rsc_pv_id = pv_id 
		LEFT JOIN $this->hrdb.hr_department ON dept_id = ps_dept_id
		LEFT JOIN (select pf_name as gs_pf_name,rscg_fname as gs_rscg_fname,rscg_lname as gs_rscg_lname,rscg_place as gs_rscg_place,rscg_tel as gs_rscg_tel,rscg_rsc_id as gs_rscg_rsc_id,pf_id as gs_pf_id  
           			FROM jon_reserve_car_guest 
           			INNER JOIN pck_hrdb.hr_prefix on rscg_pf_id = pf_id)  guest on guest.gs_rscg_rsc_id = rsc_id
		LEFT JOIN (SELECT ps_fname as dr_ps_fname,ps_lname as dr_ps_lname,rscd_rsc_id as dr_rscd_rsc_id
          			FROM jon_reserve_car_detail
          			INNER JOIN  pck_hrdb.hr_person ON rscd_ps_id = ps_id) driver on driver.dr_rscd_rsc_id = rsc_id
		WHERE rsc_active ='Y' AND rsc_id = $rsc_id";


		$query = $this->jongsdb->query($sql);
		return $query;
	}
	    function delete_jon_reserve_car($rsc_id){
        $sql = "UPDATE jon_reserve_car
                SET rsc_active='N'
                WHERE rsc_id='$rsc_id'";
        $this->db_jongs->query($sql);
    }
	
}
?> 