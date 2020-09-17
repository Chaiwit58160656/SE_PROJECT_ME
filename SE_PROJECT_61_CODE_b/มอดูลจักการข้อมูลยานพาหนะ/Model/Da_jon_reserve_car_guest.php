<?php
  /*
    Jeena Atitada
    */
include_once('application/models/jongs/Jongs_model.php');
class Da_jon_reserve_car_guest extends Jongs_model{
    
    public $rscg_id;
    public $rscg_pf_id; 
    public $rscg_fname;
    public $rscg_lname;
    public $rscg_place;
    public $rscg_tel;
    public $rcg_rsc_id;
    function __construct() {
        parent::__construct();

    }

    function insert_jon_reserve_car_guest(){
    $sql="INSERT INTO jon_reserve_car_guest(rscg_id, rscg_pf_id, rscg_fname, rscg_lname, rscg_place, rscg_tel, rscg_rsc_id)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $this->db_jongs->query($sql, array($this->rscg_id, $this->rscg_pf_id, $this->rscg_fname, $this->rscg_lname, $this->rscg_place, $this->rscg_tel, $this->rscg_rsc_id));
    }
    function insert_jon_reserve_car_guest2(){
    $sql="INSERT INTO jon_reserve_car_guest(rscg_id, rscg_pf_id, rscg_fname, rscg_lname, rscg_place, rscg_tel, rscg_rsc_id)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $this->db_jongs->query($sql, array(NULL, $this->rscg_pf_id, $this->rscg_fname, $this->rscg_lname, $this->rscg_place, $this->rscg_tel, $this->rscg_id));
    }    
    function update_jon_reserve_car_guest(){
        $sql="UPDATE jon_reserve_car_guest
                SET  rscg_pf_id=?, rscg_fname=?, rscg_lname=?, rscg_place=?, rscg_tel=? 
                WHERE rscg_rsc_id=? ";
        $this->db_jongs->query($sql, array($this->rscg_pf_id, $this->rscg_fname, $this->rscg_lname, $this->rscg_place, $this->rscg_tel, $this->rscg_id));

    }
    function delete_jon_reserve_car_guest(){
        $sql = "DELETE FROM jon_reserve_car_guest
                WHERE rscg_id=?";
        $this->db_jongs->query($sql, array($this->rscg_id));
    }
}
?>