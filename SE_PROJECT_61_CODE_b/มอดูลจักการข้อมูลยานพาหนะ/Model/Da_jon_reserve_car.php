<?php
include_once('application/models/jongs/Jongs_model.php');
class Da_jon_reserve_car extends Jongs_model{
        public $rsc_id;
        public $rsc_code;
        public $rsc_date;        
        public $rsc_ps_id;
        public $rsc_rscst_id; //สถานะการขอใช้รถ
        public $rsc_rscs_id;  //สถานะการเดินทาง
        public $rsc_rsct_id; //ประเภทการขอใช้รถ
        public $rsc_place; //สถานที่
        public $rsc_pv_id; //จังหวัด
        public $rsc_title;  //จุดประสงค์
        public $rsc_companion; //จำนวนคนเดินทาง
        public $rsc_note; 
        public $rsc_guest; //สถานะการรับวิทยากร
        public $rsc_guest_receive_date; 
        public $rsc_guest_send_date;
        public $rsc_start_date; //เริ่มต้นการขอใช้รถ
        public $rsc_end_date; //สิ้นสุดการขอใช้รถ
        public $rsc_driver; //ความต้องการเอาพนักงานขับรถ
        public $rsc_active;
        public $rsc_user_create;
        public $rsc_date_create;
        public $rsc_user_update;
        public $rsc_date_update;
	function __construct() {
		parent::__construct();

    }
    function insert_jon_reserve_car(){
        $sql=" INSERT INTO jon_reserve_car(rsc_id, 
        rsc_code, 
        rsc_date, 
        rsc_ps_id, 
        rsc_rscst_id, 
        rsc_rscs_id, 
        rsc_rsct_id, 
        rsc_place, 
        rsc_pv_id, 
        rsc_title, 
        rsc_companion, 
        rsc_note, 
        rsc_guest, 
        rsc_guest_receive_date, 
        rsc_guest_send_date, 
        rsc_start_date, 
        rsc_end_date, 
        rsc_driver, 
        rsc_active, 
        rsc_user_create, 
        rsc_date_create, 
        rsc_user_update, 
        rsc_date_update) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; //23
        $this->db_jongs->query($sql , array($this->rsc_id, $this->rsc_code, $this->rsc_date, $this->rsc_ps_id, '1', $this->rsc_rscs_id, $this->rsc_rsct_id, $this->rsc_place ,$this->rsc_pv_id, $this->rsc_title, $this->rsc_companion, $this->rsc_note, $this->rsc_guest, $this->rsc_guest_receive_date, $this->rsc_guest_send_date, $this->rsc_start_date, $this->rsc_end_date, $this->rsc_driver, $this->rsc_active, $this->rsc_user_create, $this->rsc_date_create, $this->rsc_user_update, $this->rsc_date_update));
    }
    function update_jon_reserve_car(){
        $sql=" UPDATE jon_reserve_car
                SET rsc_id=?, 
                rsc_code=?, 
                rsc_date=?, 
                rsc_ps_id=?, 
                rsc_rscst_id=?, 
                rsc_rscs_id=?, 
                rsc_rsct_id=?, 
                rsc_place=?,
                rsc_pv_id=?, 
                rsc_title=?, 
                rsc_companion=?, 
                rsc_note=?, 
                rsc_guest=?, 
                rsc_guest_receive_date=?, 
                rsc_guest_send_date=?, 
                rsc_start_date=?, 
                rsc_end_date=?, 
                rsc_driver=?, 
                rsc_active=?, 
                rsc_user_create=?, 
                rsc_date_create=?, 
                rsc_user_update=?, 
                rsc_date_update=?
                where rsc_id=?";
        $this->db_jongs->query($sql , array($this->rsc_id, $this->rsc_code, $this->rsc_date, $this->rsc_ps_id, $this->rsc_rscst_id, $this->rsc_rscs_id, $this->rsc_rsct_id, $this->rsc_place ,$this->rsc_pv_id, $this->rsc_title, $this->rsc_companion, $this->rsc_note, $this->rsc_guest, $this->rsc_guest_receive_date, $this->rsc_guest_send_date, $this->rsc_start_date, $this->rsc_end_date, $this->rsc_driver, $this->rsc_active, $this->rsc_user_create, $this->rsc_date_create, $this->rsc_user_update, $this->rsc_date_update,$this->rsc_id));
    }

    function get_by_key($withSetAttributeValue=FALSE) { 
        $sql = "SELECT * 
                FROM ".$this->db_jongs.".hr_person 
                WHERE ps_id=?";
        $query = $this->jongs->query($sql, array($this->ps_id));
        if ( $withSetAttributeValue ) {
            $this->row2attribute( $query->row() );
        } else {
            return $query ;
        }
    }

	function update_eqs_reserve_car_status(){// ปรับสถานะของการขอพาหนะ
		$sql = "UPDATE $this->pck_jongsdb.jon_reserve_car SET jon_reserve_car.rsc_rscst_id = 2 , jon_reserve_car.rsc_user_update = ? , jon_reserve_car.rsc_date_update = ?
                WHERE jon_reserve_car.rsc_id = ?";
        $query = $this->db_jongs->query($sql,array($this->session->userdata('UsPsCode'),date("Y-m-d h:i:s"),$this->rsc_id));
        echo($sql);
	}
}
?>