<?php

include_once("Da_eqs_room.php");

class M_eqs_room extends Da_eqs_room {

	function get_all($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
				FROM ".$this->eqs_db.".eqs_room 
				$orderBy";
		$query = $this->eqs->query($sql);
		return $query;
	}
	
	function get_all_room(){
		$sql = "SELECT * 
				FROM ".$this->eqs_db.".eqs_room ";
		$query = $this->eqs->query($sql);
		return $query;
	}
	
	function get_options($optional='y') {
		$qry = $this->get_all();
		if ($optional=='y') $opt[''] = '-----เลือก-----';
		foreach ($qry->result() as $row) {
			$opt[$row->rm_id] = $row->rm_name;
		}
		return $opt;
	}
	
	function get_options_room($optional='y') {
		$qry = $this->get_all_room();
		if ($optional=='y') $opt[''] = '--เลือก--';
		foreach ($qry->result() as $row) {
			$opt[$row->rm_id] = $row->rm_name;
		}
		return $opt;
	}
	
	function rsflow_room($tp='',$bd_id){
		$sql = "SELECT bd.bd_id ,rm.rm_id, rm.rm_name, rm.rm_capacity, rm.rm_area, rm.rm_bd_id , dept.dept_name
				FROM ".$this->eqs_db.".eqs_room AS rm 
				LEFT JOIN ".$this->eqs_db.".eqs_building AS bd ON bd.bd_id = rm.rm_bd_id
				LEFT JOIN ".$this->hr.".hr_department AS dept ON dept.dept_id = rm_dpid
				WHERE bd.bd_id = ?";
		$query = $this->eqs->query($sql,array($bd_id));
		return $query;
	}
	
	 function rsflow_building_room($tp='',$bd_id,$psd_dp_id){
		$sql = "SELECT rm.* , bdt.* , st.*, eqs.* , bd.*
				FROM ".$this->eqs_db.".eqs_building AS bd
                LEFT JOIN ".$this->eqs_db.".eqs_room AS rm ON rm.rm_bd_id = bd.bd_id
                LEFT JOIN ".$this->eqs_db.".eqs_building_type AS bdt ON bdt.bdtype_id = rm.rm_bdtype_id
                LEFT JOIN ".$this->eqs_db.".eqs_status AS st ON st.status_id = rm.rm_status_id
				LEFT JOIN ".$this->eqs_db.".eqs_equipments AS eqs ON eqs.eqs_id = bd.bd_eqs_id
				WHERE eqs.eqs_dpId = '$psd_dp_id'
                AND eqs_active = 'Y' 
                AND rm_bd_id ='$bd_id'
				ORDER BY rm_floor,rm_no,rm_name"; 
		$query = $this->eqs->query($sql,array($bd_id,$psd_dp_id));
		// echo $this->eqs->last_query();die;
		return $query;
	}
	
	function get_room_by_bd_id($bd_id){
		$sql = "SELECT * 
				FROM ".$this->eqs_db.".eqs_room 
				WHERE rm_bd_id = '$bd_id'
				";
		$query = $this->eqs->query($sql);
		return $query;
	}
	
		function get_use_room_by_bd_id($bd_id){
		$sql = "SELECT COUNT(rm_id) AS count_total_room
				FROM ".$this->eqs_db.".eqs_room 
				WHERE rm_bd_id = '$bd_id'
				";
		$query = $this->eqs->query($sql);
		return $query;
	}
	
	function get_check_room($bd_id){
		$sql = "SELECT bd_amount_room 
				FROM ".$this->eqs_db.".eqs_building 
				WHERE bd_id = '$bd_id'
				";
		$query = $this->eqs->query($sql);
		return $query;
	}
	
	function get_check_room_by_bd_id($bd_id){
		$sql = "SELECT COUNT(rm_id) AS count_room
				FROM ".$this->eqs_db.".eqs_room 
				WHERE rm_bd_id = '$bd_id'
				";
		$query = $this->eqs->query($sql);
		return $query;
	}
   /* *********************
    * Chain Chaiwat
	* 2017/10/04
	* Get room from eqs_id
	* ใช้ในไฟล์ Edit_equipment
	* *********************/
	function get_room_by_eqs_id($eqs_id){
		$sql = "SELECT eqs_room.*,bdtype_name,status_name 
				FROM ".$this->eqs_db.".eqs_equipments
					LEFT JOIN ".$this->eqs_db.".eqs_building
						ON eqs_id =  bd_eqs_id
					LEFT JOIN ".$this->eqs_db.".eqs_room
						ON bd_id =  rm_bd_id
					LEFT JOIN ".$this->eqs_db.".eqs_building_type
						ON rm_bdtype_id =  bdtype_id
					LEFT JOIN ".$this->eqs_db.".eqs_status
						ON rm_status_id =  status_id
				WHERE eqs_id = '$eqs_id'
				";
		$query = $this->eqs->query($sql);
		return $query;
	}
	
} // end class M_eqs_room
?>