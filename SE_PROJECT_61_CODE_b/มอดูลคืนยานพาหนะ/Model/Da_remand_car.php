<?php
include_once('application/models/jongs/Jongs_model.php');
class Da_remand_car extends Jongs_model{

  public $rsc_id;
  public $rsc_end_date;
  public $rsc_rscst_id;

  public $rscd_rsc_id;
  public $rscd_note;

	function __construct() {
		parent::__construct();
    }
  
  function jon_reserve_car_update(){ //  อัปเดทตารางรถที่ใบขอใช้รถ
    $sql = "UPDATE pck_jongsdb.jon_reserve_car SET rsc_end_date = ?, rsc_rscst_id =? 
            WHERE rsc_id = ?";
    $this->jongsdb->query($sql,array($this->rsc_end_date,$this->rsc_rscst_id,$this->rsc_id));
  }

  function jon_reserve_car_detail_update(){ // อัปเดทตารางรถที่ขอใช้งาน
      $sql = "UPDATE pck_jongsdb.jon_reserve_car_detail SET rscd_note = ?
              WHERE rscd_rsc_id = ? AND rscd_eqs_id = ?";
    $this->jongsdb->query($sql,array($this->rscd_note, $this->rscd_rsc_id, $this->rscd_eqs_id));
  }
  
}
?>