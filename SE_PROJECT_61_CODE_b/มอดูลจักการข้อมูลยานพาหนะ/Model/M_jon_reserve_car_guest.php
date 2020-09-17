<?php 
include_once("Da_jon_reserve_car_guest.php");
class M_jon_reserve_car_guest extends Da_jon_reserve_car_guest {
    function __construct() {
        parent::__construct();

    }
    function get_reserve_car_guest($rscg_id){
    $sql="SELECT * FROM jon_reserve_car_guest WHERE rscg_rsc_id = '".$rscg_id."'";

 	$query = $this->jongsdb->query($sql);
	return $query;	   
    }   
}?>