<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__)."/JONGS_Controller.php");
class Reserve_car_driver extends  JONGS_Controller {
	public function __construct(){
		parent::__construct();
		
	}
    
    public function insert_data_reserve_car_driver(){
        $arr[] = $this->input->post('val_car[]');
        pre($arr);
    }
}
?>