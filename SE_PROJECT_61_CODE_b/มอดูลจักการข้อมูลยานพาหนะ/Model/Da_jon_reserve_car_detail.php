<?php
/*
    Jeena Atitada
    Nuttakit Pangngom 
*/
include_once('application/models/jongs/Jongs_model.php');
class Da_jon_reserve_car_detail extends Jongs_model{
    
    public $rscd_id;
    public $rscd_rsc_id;
    public $rscd_eqs_id;
    public $rscd_note;
    public $rscd_ps_id;
    public $rscd_update_ps_id;
    public $rscd_update_date;

    function __construct() {
        parent::__construct();

    }
	    function insert_jon_reserve_car_detail(){
	        $sql="INSERT INTO jon_reserve_car_detail(rscd_id, rscd_rsc_id, rscd_eqs_id, rscd_note)
	        VALUES = (?, ?, ?, ?)";
	        $this->db_jongs->query($sql, array($this->rscd_id, $this->rscd_rsc_id, $this->rscd_eqs_id, $this->rscd_note));
	    }
	    function update_jon_reserve_car_detail(){
	        $sql="UPDATE jon_reserve_car_detail
	        SET rscd_id=?, rscd_rsc_id=?, rscd_eqs_id=?, rscd_note=?";
	        $this->db_jongs->query($sql, array($this->rscd_id, $this->rscd_rsc_id, $this->rscd_eqs_id, $this->rscd_note));
	    }
	     function delete_jon_reserve_car_detail(){
	        $sql = "DELETE FROM jon_reserve_car_detail
	                WHERE rscd_id=?";
	        $this->db_jongs->query($sql, array($this->rscd_id));
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

    function insert_car_driver_detail() { // บันทึก ยานพาหนะและคนขับที่ขอใช้ jon_reserve_car_detail
		$sql = "INSERT INTO jon_reserve_car_detail(rscd_rsc_id, rscd_eqs_id, rscd_ps_id, rscd_update_ps_id, rscd_update_date)
				VALUES(?, ?, ?, ?, ?)";
		$this->db_jongs->query($sql, array($this->rscd_rsc_id, $this->rscd_eqs_id, $this->rscd_ps_id, $this->session->userdata('UsPsCode'), date("Y-m-d h:i:s")));
    }
    
    function insert_car_detail() { // บันทึก ยานพาหนะที่ขอใช้ jon_reserve_car_detail
		$sql = "INSERT INTO jon_reserve_car_detail(rscd_rsc_id, rscd_eqs_id, rscd_update_ps_id, rscd_update_date)
				VALUES(?, ?, ?, ?)";
		$this->db_jongs->query($sql, array($this->rscd_rsc_id, $this->rscd_eqs_id, $this->session->userdata('UsPsCode'), date("Y-m-d h:i:s")));
	}
}
?>