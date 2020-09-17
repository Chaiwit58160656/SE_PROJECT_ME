<?php
/*
 * M_eqs_equipments
 * Model for Manage about eqs_equipments Table.
 * Copyright (c) 2559. Information System Engineering Research Laboratory.
 * @Author Chain_Chaiwat
 * @Create Date 2559-08-05
 */
include_once("Da_eqs_equipments.php");

class M_eqs_equipments extends Da_eqs_equipments {

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
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
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE eqs_active = 'Y'
				$orderBy";
		$query = $this->eqs->query($sql);
		return $query;
	}

	/*
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----เลือก-----' by default.
	 * if you do not need the first list of select list is '-----เลือก-----', please pass $optional parameter to other values.
	 * you can delete this function if it not necessary.
	 */
	function get_options($optional='y') {
		$qry = $this->get_all();
		if ($optional=='y') $opt[''] = '-----เลือก-----';
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}

	// add your functions here
	
	
	function get_eqs_date(){
        $sql = "SELECT eqs_name, eqs_buydate, eqs_expireyear, eqs_price,eqs_code_old,
					eqs_price/eqs_expireyear as price_per_year
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE eqs_active = 'Y' AND eqs_price>0
				ORDER BY eqs_buydate DESC			
				";
		$query = $this->eqs->query($sql);
		// echo $this->eqs->last_query();
		// die; 
		return $query;
	}
/*
* removeComma
* @input: value number that has comma
* @output: remove comma from number for process
* @author: Jiranun
* @Create Date: 2559-06-18
* @using : removeComma(2,000) or removeComma(number)--> number has comma
*/
	/*
    * get_eqs_amount_by_dp_id
    * @input: eqs_dpId
    * @output: ค่าของครุภัณฑ์ทั้งหมด (amount)
    * @author: Chaiwat Rojjarroenviwat
    * @Create Date: 2559-08-08
    * @using : ฟังก์ชันสำหรับ return ค่าของครุภัณฑ์ทั้งหมด ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_amount_by_dp_id(){
		$sql = "SELECT COUNT(eqs_id) as amount
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE eqs_dpId=?
					AND eqs_active = 'Y'
					AND eqs_status != 'S'
                ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		// echo $this->eqs->last_query();die;
		return $query->row()->amount;
	}

    /*
    * get_eqs_borrow_by_dp_id
    * @input: eqs_dpId
    * @output: ค่าของครุภัณฑ์ที่ยืม (borrow)
    * @author: Chaiwat Rojjarroenviwat
    * @Create Date: 2559-08-08
    * @using : ฟังก์ชันสำหรับ return ค่าของครุภัณฑ์ที่ยืม ตาม eqs_dpId ที่ส่งมา
    */
	function get_eqs_borrow_by_dp_id(){
        $sql = "SELECT COUNT(eqs_id) as borrow
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE eqs_dpId=?
                AND eqs_status='B'
                AND eqs_active = 'Y' ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query->row()->borrow;
	}

	
	
	
	
    /*
    * get_eqs_repair_by_dp_id
    * @input: eqs_dpId
    * @output: ค่าของครุภัณฑ์ที่ชำรุด (repair)
    * @author: Chaiwat Rojjarroenviwat
    * @Create Date: 2017/06/23
    * @using : ฟังก์ชันสำหรับ return ค่าของครุภัณฑ์ที่ชำรุด ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_repair_by_dp_id(){
		$sql = "SELECT COUNT(eqs_id) as repair
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE eqs_dpId=?
                AND eqs_status='RP'
                AND eqs_active = 'Y'
                ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query->row()->repair;
	}

    /*
    * get_eqs_defective_by_dp_id
    * @input: eqs_dpId
    * @output: ค่าของครุภัณฑ์ที่ชำรุด (defective)
    * @author: Chaiwat Rojjarroenviwat
    * @Create Date: 2559-08-08
    * @using : ฟังก์ชันสำหรับ return ค่าของครุภัณฑ์ที่ชำรุด ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_defective_by_dp_id(){
		$sql = "SELECT COUNT(eqs_id) as defective
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE eqs_dpId=?
                AND eqs_status='R'
                AND eqs_active = 'Y'
                ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query->row()->defective;
	}

    /*
    * get_eqs_distribute_by_dp_id
    * @input: eqs_dpId
    * @output: ค่าของครุภัณฑ์ที่จำหน่าย (distribute)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-08
    * @using : ฟังก์ชันสำหรับ return ค่าของครุภัณฑ์ที่จำหน่าย ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_distribute_by_dp_id(){
		$sql = "SELECT COUNT(eqs_id) as distribute
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE eqs_dpId=?
                AND eqs_status='S'
                AND eqs_active = 'Y' ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query->row()->distribute;
	}

    /*
    * get_eqs_expire_by_dp_id
    * @input: eqs_dpId
    * @output: ค่าของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี (expire)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-08
    * @using : ฟังก์ชันสำหรับ return ค่าของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี  ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_expire_by_dp_id($amount_year=2){
		$sql = "SELECT COUNT(eqs_id) as expire
				FROM ".$this->eqs_db.".eqs_equipments
				WHERE date(eqs_expiredate)>=curdate()
					AND eqs_dpId=?
					AND date(eqs_expiredate)<=date_add(curdate(),interval $amount_year year)
					AND eqs_active = 'Y'
					AND	eqs_status != 'S'";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query->row()->expire;
	}

    /*
    * get_eqs_expire
    * @input: eqs_dpId
    * @output: ค่าของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี (expire)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-08
    * @using : ฟังก์ชันสำหรับ return ค่าของครุภัณฑ์ที่จะหมดอายุภายใน 2 ปี  ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_expire($amount_year=2){
		$sql = "SELECT eqs_id,fmst_name, eqs_name, eqs_code_old, eqs_price, eqs_buydate, eqs_expiredate, eqs_status, eqs_detail, bg_name
				FROM ".$this->eqs_db.".eqs_equipments
					LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id
					LEFT JOIN ".$this->eqs_db.".eqs_budgettype ON eqs_bg_id = bg_id
				WHERE date(eqs_expiredate)>=curdate()
					AND eqs_dpId=?
					AND date(eqs_expiredate)<=date_add(curdate(),interval $amount_year year)
					AND eqs_active = 'Y'
					AND	eqs_status != 'S'";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		// echo $this->eqs->last_query();die;
		return $query;
	}

    /*
    * get_eqs_by_dp_id
    * @input: eqs_dpId
    * @output: ชื่อและจำนวนของครุภัณฑ์ประเภทต่างๆ
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-09
    * @using : ฟังก์ชันสำหรับ return ชื่อและจำนวนของครุภัณฑ์ประเภทต่างๆ  ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_total_by_dp_id(){
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id , fmst_name ,fmst_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
				AND eqs_status !='S'
				GROUP BY eqs_fmst_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_by_year
    * @input: eqs_dpId , fmst_id , year
    * @output: จำนวนของครุภัณฑ์
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-10
    * @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ ตาม eqs_dpId , fmst_id(ประเภทของครุภัณฑ์) และ year(ปี) ที่ส่งมา
    */
    function get_eqs_by_year($fmst_id, $year){
        /* $sql = "SELECT COUNT(eqs_id) as count_eqs_id
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=? AND eqs_buydate LIKE '".$year."-%' AND eqs_fmst_id = '".$fmst_id."'
                AND eqs_active = 'Y'
                ORDER BY eqs_buydate"; */
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=? AND (eqs_buydate BETWEEN '".($year-1)."-10-01' AND '".$year."-09-30') AND eqs_fmst_id = '".$fmst_id."'
                AND eqs_active = 'Y'
                ORDER BY eqs_buydate";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}
	/*
	* get_eqs_by_date
	* @input: eqs_dpId , fmst_id , year
	* @output: จำนวนของครุภัณฑ์
	* @author: Kiattisak Pongthawornpinyo , Prince Pongsakorn
	* @Edit Date: 2560-08-03
	* @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ ตาม eqs_dpId , fmst_id(ประเภทของครุภัณฑ์) และ year(ปี) ที่ส่งมา
	*/
	function get_eqs_by_date($fmst_id, $sYear , $eYear){
					/* $sql = "SELECT COUNT(eqs_id) as count_eqs_id
									FROM ".$this->eqs_db.".eqs_equipments a
						INNER JOIN ".$this->eqs_db.".eqs_format_st b
							ON a.eqs_fmst_id = b.fmst_id
									WHERE eqs_dpId=? AND eqs_buydate LIKE '".$year."-%' AND eqs_fmst_id = '".$fmst_id."'
									AND eqs_active = 'Y'
									ORDER BY eqs_buydate"; */
			$sql = "SELECT COUNT(eqs_id) as count_eqs_id
									FROM ".$this->eqs_db.".eqs_equipments eqs
						INNER JOIN ".$this->eqs_db.".eqs_format_st fmst
							ON eqs.eqs_fmst_id = fmst.fmst_id
									WHERE eqs_dpId=? AND (eqs_buydate BETWEEN '$sYear' AND '$eYear') AND eqs_fmst_id = $fmst_id
									AND eqs_active = 'Y'
									ORDER BY eqs_buydate";
			$query = $this->eqs->query($sql,array($this->eqs_dpId));
			return $query;
		}
    /*
    * get_eqs_by_year_detail
    * @input: eqs_dpId , fmst_id , year
    * @output: จำนวนของครุภัณฑ์
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-10
    * @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ ตาม eqs_dpId , fmst_id(ประเภทของครุภัณฑ์) และ year(ปี) ที่ส่งมา
    */
    function get_eqs_by_year_detail($year){
        /* $sql = "SELECT *
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=? AND eqs_buydate LIKE '".$year."-%'
                AND eqs_active = 'Y'
                ORDER BY eqs_buydate"; */
		$sql = "SELECT *
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=? AND (eqs_buydate BETWEEN '".($year-1)."-10-01' AND '".$year."-09-30')
                AND eqs_active = 'Y'
                ORDER BY eqs_buydate";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_fmst_by_dpId
    * @input: eqs_dpId
    * @output: เลขที่ระบุประเภทของครุภัณฑ์  และ ชื่อประเภทของครุภัณฑ์
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-10
    * @using : ฟังก์ชันสำหรับ return เลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)และ ชื่อประเภทของครุภัณฑ์ (fmst_name)ตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_fmst_by_dpId(){
		$sql = "SELECT DISTINCT(fmst_id), fmst_name ,fmst_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                GROUP BY eqs_fmst_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}
			/*
			* get_eqs_fmst_by_dpId_year
			* @input: eqs_dpId
			* @output: เลขที่ระบุประเภทของครุภัณฑ์  และ ชื่อประเภทของครุภัณฑ์
			* @author: Kiattisak Pongthawornpinyo , Prince Pongsakorn
			* @Edit Date: 2560-08-03
			* @using : ฟังก์ชันสำหรับ return เลขที่ระบุประเภทของครุภัณฑ์ (fmst_id)และ ชื่อประเภทของครุภัณฑ์ (fmst_name)ตาม eqs_dpId ที่ส่งมา
			*/
			function get_eqs_fmst_by_dpId_year($sYear,$eYear){
			$sql = "SELECT DISTINCT(fmst_id), fmst_name ,fmst_abbr
									FROM $this->eqs_db.eqs_equipments eqs
						INNER JOIN $this->eqs_db.eqs_format_st fmst
							ON eqs.eqs_fmst_id = fmst.fmst_id
									WHERE eqs_dpId=?
									AND eqs_active = 'Y'
									AND fmst_id IN ( SELECT eqs_fmst_id FROM $this->eqs_db.eqs_format_st WHERE eqs_buydate BETWEEN '$sYear' AND '$eYear' )
									GROUP BY eqs_fmst_id";
			$query = $this->eqs->query($sql,array($this->eqs_dpId));
			return $query;
		}
    /*
    * get_eqs_status_ready
    * @input: eqs_dpId , id
    * @output: จำนวนของครุภัณฑ์ที่อยู่ในสถานะพร้อมใช้งาน (Y)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-15
    * @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ที่อยู่ในสถานะพร้อมใช้งาน (Y) ตาม id(ใช้ระบุประเภทของครุภัณฑ์) และ eqs_dpId ที่ส่งมา
    */
    function get_eqs_status_ready($id){
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id
                FROM ".$this->eqs_db.".eqs_equipments
                WHERE eqs_dpId=?
                AND eqs_status='Y'
                AND eqs_active = 'Y'
                AND eqs_fmst_id='".$id."'";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_status_repair
    * @input: eqs_dpId , id
    * @output: จำนวนของครุภัณฑ์ที่อยู่ในสถานะชำรุด (R)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-15
    * @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ที่อยู่ในสถานะชำรุด (R) ตาม id(ใช้ระบุประเภทของครุภัณฑ์) และ eqs_dpId ที่ส่งมา
    */
    function get_eqs_status_repair($id){
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id
                FROM ".$this->eqs_db.".eqs_equipments
                WHERE eqs_dpId=?
                AND eqs_status='R'
                AND eqs_active = 'Y'
                AND eqs_fmst_id='".$id."'";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_status_distribute
    * @input: eqs_dpId , id
    * @output: จำนวนของครุภัณฑ์ที่อยู่ในสถานะจำหน่าย (S)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-15
    * @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ที่อยู่ในสถานะจำหน่าย  (S) ตาม id(ใช้ระบุประเภทของครุภัณฑ์) และ eqs_dpId ที่ส่งมา
    */
    function get_eqs_status_distribute($id){
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id
                FROM ".$this->eqs_db.".eqs_equipments
                WHERE eqs_dpId=?
                AND eqs_status='S'
                AND eqs_active = 'Y'
                AND eqs_fmst_id='".$id."'";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_status_no_ready
    * @input: eqs_dpId , id
    * @output: จำนวนของครุภัณฑ์ที่อยู่ในสถานะไม่ได้ใช้งาน (N)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-15
    * @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ที่อยู่ในสถานะไม่ได้ใช้งาน (N) ตาม id(ใช้ระบุประเภทของครุภัณฑ์) และ eqs_dpId ที่ส่งมา
    */
    function get_eqs_status_no_ready($id){
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id
                FROM ".$this->eqs_db.".eqs_equipments
                WHERE eqs_dpId=?
                AND eqs_status='N'
                AND eqs_active = 'Y'
                AND eqs_fmst_id='".$id."'";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_status_borrow
    * @input: eqs_dpId , id
    * @output: จำนวนของครุภัณฑ์ที่อยู่ในสถานะถูกยืม (B)
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-15
    * @using : ฟังก์ชันสำหรับ return จำนวนของครุภัณฑ์ที่อยู่ในสถานะถูกยืม (B) ตาม id(ใช้ระบุประเภทของครุภัณฑ์) และ eqs_dpId ที่ส่งมา
    */
    function get_eqs_status_borrow($id){
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id
                FROM ".$this->eqs_db.".eqs_equipments
                WHERE eqs_dpId=?
                AND eqs_status='B'
                AND eqs_active = 'Y'
                AND eqs_fmst_id='".$id."'";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_expire_graph_by_dp_id
    * @input: eqs_dpId , fmst_id , c_year
    * @output: ชื่อประเภทของครุภัณฑ์ และ จำนวนของครุภัณฑ์ที่จะหมดอายุตามปีที่ส่งมา
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-22
    * @using : ฟังก์ชันสำหรับ return ชื่อประเภทของครุภัณฑ์ และ จำนวนของครุภัณฑ์ที่จะหมดอายุย้อนหลังตามปี (c_year)ตามชนิดของครุภัณฑ์ (fmst_id)และตาม eqs_dpId ที่ส่งมา ซึ่งถ้า c_year = 2 คือ เลือกมาเฉพาะครุภัณฑ์ที่จะหมดอายุภายใน2ปี
    */
    function get_eqs_expire_graph_by_dp_id($fmst_id,$c_year){
		$sql = "SELECT fmst_name,COUNT(eqs_id) as expire ,fmst_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN eqs_format_st b ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=?
                    AND fmst_id = '".$fmst_id."'
                    AND eqs_active = 'Y'
					AND	eqs_status != 'S'
                    AND date(eqs_expiredate)>=curdate()
                    AND date(eqs_expiredate)<=date_add(curdate(),interval ".$c_year." year)";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_fmst_expire_by_dpId
    * @input: eqs_dpId , c_year
    * @output: เลขที่ระบุประเภทของครุภัณฑ์ และ ชื่อประเภทของครุภัณฑ์
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-22
    * @using : ฟังก์ชันสำหรับ return เลขที่ระบุประเภทของครุภัณฑ์ (fmst_id) และ ชื่อประเภทของครุภัณฑ์ (fmst_name)ย้อนหลังตามปี (c_year)และตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_fmst_expire_by_dpId($c_year){
		$sql = "SELECT DISTINCT(fmst_id), fmst_name ,fmst_abbr
                FROM  ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=?
				AND	eqs_status != 'S'
                AND eqs_active = 'Y'
                AND date(eqs_expiredate)>=curdate()
                AND date(eqs_expiredate)<=date_add(curdate(),interval ".$c_year." year)";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_item_expire_by_dp_id
    * @input: eqs_dpId , fmst_id , c_year
    * @output: ชื่อของครุภัณฑ์ , เลขครุภัณฑ์ , วันที่ซื้อ , วันหมดอายุ
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-23
    * @using : ฟังก์ชันสำหรับ return ชื่อของครุภัณฑ์ , เลขครุภัณฑ์ , วันที่ซื้อ , วันหมดอายุ โดยย้อนหลังตามปี (c_year)ตามชนิดของครุภัณฑ์ (fmst_id)และตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_item_expire_by_dp_id($fmst_id,$c_year){
		$sql = "SELECT eqs_id,eqs_name,eqs_code_old,eqs_buydate,eqs_expiredate
                FROM ".$this->eqs_db.".eqs_equipments
                WHERE eqs_dpId=?
                    AND eqs_fmst_id = '".$fmst_id."'
					AND	eqs_status != 'S'
                    AND eqs_active = 'Y'
                    AND date(eqs_expiredate)>=curdate()
                    AND date(eqs_expiredate)<=date_add(curdate(),interval ".$c_year." year)";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    /*
    * get_eqs_item_table
    * @input: eqs_dpId , fmst_id
    * @output: ชื่อของครุภัณฑ์ , เลขครุภัณฑ์ , ราคา , วันที่ซื้อ , วันหมดอายุ , สถานะ
    * @author: Kiattisak Pongthawornpinyo
    * @Create Date: 2559-08-23
    * @using : ฟังก์ชันสำหรับ return ชื่อของครุภัณฑ์ , เลขครุภัณฑ์ , ราคา , วันที่ซื้อ , วันหมดอายุ , สถานะ ตามชนิดของครุภัณฑ์ (fmst_id)และตาม eqs_dpId ที่ส่งมา
    */
    function get_eqs_item_table($fmst_id){
		$sql = "SELECT eqs_id,eqs_name,eqs_code_old,eqs_price,eqs_buydate,eqs_expiredate,eqs_status,eqs_detail
                FROM ".$this->eqs_db.".eqs_equipments
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
				AND eqs_status != 'S'
                AND eqs_fmst_id = '".$fmst_id."' ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    function get_all_equipment($psd_dp_id) {	// using in function insertEquipment/insertEquipments
			$sql = "SELECT *
					FROM ".$this->eqs_db.".eqs_equipments a
					LEFT JOIN ".$this->eqs_db.".eqs_format_st b ON b.fmst_id	= a.eqs_fmst_id
					LEFT JOIN ".$this->eqs_db.".eqs_format_nd c  ON c.fmnd_id	= a.eqs_fmnd_id
					LEFT JOIN ".$this->eqs_db.".eqs_format_rd d ON d.fmrd_id	= a.eqs_fmrd_id
					WHERE eqs_dpId=?
                    AND eqs_active = 'Y'
					ORDER BY `eqs_date_create` DESC";
			$query = $this->eqs->query($sql,array($psd_dp_id));

            // echo $this->eqs->last_query($sql,array($psd_dp_id));
            // die;
			return $query;
		}//end of function get_all_equipment

      function get_all_equipment_import($psd_dp_id) {	// using in function insertEquipment/importExcel
			$sql = "SELECT eqs_id, fmst_name, fmnd_name, fmrd_name, eqs_name, eqs_code, eqs_code_old, eqs_buydate, eqs_expiredate, eqs_status
					FROM ".$this->eqs_db.".eqs_equipments
					LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id
					LEFT JOIN ".$this->eqs_db.".eqs_format_nd ON fmnd_id	= eqs_fmnd_id
					LEFT JOIN ".$this->eqs_db.".eqs_format_rd ON fmrd_id	= eqs_fmrd_id
					WHERE eqs_dpId=?
                    AND eqs_active = 'Y'
					ORDER BY `eqs_equipments`.`eqs_date_create` DESC
					";
			$query = $this->eqs->query($sql,array($psd_dp_id));
			return $query;
		}//end of function get_all_equipment_import

        function get_fmst_id($i=''){
			$sql = "SELECT fmst.fmst_id
					FROM ".$this->eqs_db.".eqs_format_st AS fmst
					WHERE fmst.fmst_name = '$i'";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->fmst_id;
				} else {
					return NULL;
				}
		}

		function get_fmnd_id($i='',$j=''){
			$sql = "SELECT fmnd.fmnd_id
					FROM ".$this->eqs_db.".eqs_format_nd AS fmnd
					WHERE fmnd.fmnd_fmst_id = '$i' AND fmnd.fmnd_name = '$j'";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->fmnd_id;
				} else {
					return NULL;
				}
		}

		function get_fmrd_id($i='',$j=''){
			$sql = "SELECT fmrd.fmrd_id
					FROM ".$this->eqs_db.".eqs_format_rd AS fmrd
					WHERE fmrd.fmrd_fmnd_id = '$i' AND fmrd.fmrd_name = '$j'";
			$query = $this->eqs->query($sql);

			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->fmrd_id;
				} else {
					return NULL;
				}
		}

		function get_mt_id($i='') {
			$sql = "SELECT mt_id
					FROM ".$this->eqs_db.".eqs_method
					WHERE mt_name LIKE '%$i%' AND mt_mt_id	= '0'";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->mt_id;
				} else {
					return NULL;
				}
		}

		function get_mt_sub_id($i='',$j='') {
			$sql = "SELECT mt_id
					FROM ".$this->eqs_db.".eqs_method
					WHERE mt_mt_id	= '$i' AND mt_name LIKE '%$j%'";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->mt_id;
				} else {
					return NULL;
				}
		}

		function get_deptId($i='',$j='') {
			$sql = "SELECT dept.dept_id
					FROM ".$this->hr.".hr_department AS dept
					WHERE dept.dept_name LIKE '$i' ";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->dept_id;
				} else {
					return NULL;
				}
		}

		function get_brand_id($i='',$j='') {
			$sql = "SELECT bm_id
					FROM ".$this->eqs_db.".eqs_brand_model
					WHERE bm_level = '0' AND bm_name = '$i' AND bm_dpId= '$j'";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->bm_id;
				} else {
					return NULL;
				}
		}

		function get_model_id($i='',$j='',$k='') {
			$sql = "SELECT bm_id
					FROM ".$this->eqs_db.".eqs_brand_model
					WHERE bm_level = '1' AND bm_parent_id = '$i' AND bm_name = '$j' AND bm_dpId= '$k'";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->bm_id;
				} else {
					return NULL;
				}
		}

		function get_bd_id($i='',$j=''){
			$sql = "SELECT bd.bd_id
					FROM ".$this->eqs_db.".eqs_building AS bd
					LEFT JOIN ".$this->eqs_db.".eqs_equipments AS eqs ON bd.bd_eqs_id = eqs.eqs_id
					WHERE eqs_name LIKE '$i' AND eqs.eqs_dpId = '$j'
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->bd_id;
				} else {
					return NULL;
				}

		}

		function get_rm_id($i='',$j='',$k=''){
			$sql = "SELECT rm_id
					FROM ".$this->eqs_db.".eqs_room
					LEFT JOIN ".$this->eqs_db.".eqs_building 	 ON bd_id	= rm_bd_id
					LEFT JOIN ".$this->eqs_db.".eqs_equipments ON	eqs_id	= bd_eqs_id
					WHERE rm_bd_id = '$i' AND rm_name = '$j' AND eqs_dpId	= '$k'
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->rm_id;
				} else {
					return NULL;
				}
		}

		function get_rm_id_by_rm_no($i='',$j='',$k=''){
			$sql = "SELECT rm_id
					FROM ".$this->eqs_db.".eqs_room
					LEFT JOIN ".$this->eqs_db.".eqs_building 	 ON bd_id	= rm_bd_id
					LEFT JOIN ".$this->eqs_db.".eqs_equipments ON	eqs_id	= bd_eqs_id
					WHERE rm_bd_id = '$i' AND rm_no = '$j' AND eqs_dpId	= '$k'
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql);
			if ($query->num_rows() != 0) {
					$this->row2attribute( $query->row() );
					return $this->rm_id;
				} else {
					return NULL;
				}
		}

		function get_vd_id($eqs_vd='',$eqs_dpId=''){
			$sql = "SELECT vd_id
					FROM ".$this->eqs_db.".eqs_vender
					WHERE vd_name = ? AND vd_dpId = ? ";
			$query = $this->eqs->query($sql,array($eqs_vd,$eqs_dpId));
			if ($query->num_rows() != 0) {
				$this->row2attribute( $query->row() );
				return $this->vd_id;
			} else {
				return NULL;
			}
		}

		function get_max_unit($fmst='',$fmnd='',$fmrd='',$eqs_dpId=''){
			$sql = "SELECT MAX(eqs_unit) AS 'unit'
					FROM ".$this->eqs_db.".eqs_equipments
					WHERE eqs_fmst_id =	?
                    AND eqs_fmnd_id = ?
                    AND eqs_fmrd_id = ?
                    AND eqs_dpId = ?
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array($fmst,$fmnd,$fmrd,$eqs_dpId));
			return $query;
		}

        function get_dpId($i='') {
		$sql = "SELECT dpID
				FROM ".$this->ums.".umdepartment
				WHERE dpName LIKE '$i' ";
		$query = $this->eqs->query($sql);
		if ($query->num_rows() != 0) {
				$this->row2attribute( $query->row() );
				return $this->dpID;
			} else {
				return NULL;
			}
        }

        function chk_budgettype($bg_name=''){
			$sql = "SELECT *
					FROM ".$this->eqs_db.".eqs_budgettype
					WHERE bg_name = ? ";
			$query = $this->eqs->query($sql,array($bg_name));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_method($mt_id='',$mt_mt_id=''){
			$sql = "SELECT *
					FROM ".$this->eqs_db.".eqs_method
					WHERE mt_id = ? AND mt_mt_id = ? ";
			$query = $this->eqs->query($sql,array($mt_mt_id,$mt_id));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_code_($fmst_id='',$fmnd_id='',$eqs_code='',$dpId=''){
			$sql = "SELECT *
					FROM ".$this->eqs_db.".eqs_equipments
					WHERE eqs_fmst_id = ?
                    AND eqs_fmnd_id = ?
                    AND eqs_code = ?
                    AND eqs_dpId = ?
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array($fmst_id,$fmnd_id,$eqs_code,$dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_eqs_code($eqs_code_old=''){
			$sql = "SELECT *
					FROM ".$this->eqs_db.".eqs_equipments
					WHERE eqs_code_old = ?
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array($eqs_code_old));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_brand($eqs_brand='',$eqs_dpId=''){
			$sql = "SELECT bm_id
					FROM ".$this->eqs_db.".eqs_brand_model
					WHERE bm_level = '0' AND bm_name = ? AND bm_dpId= ?";
			$query = $this->eqs->query($sql,array($eqs_brand,$eqs_dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_model($eqs_brand='',$eqs_model='',$eqs_dpId=''){
			$sql = "SELECT bm_id
					FROM ".$this->eqs_db.".eqs_brand_model
					WHERE bm_level = '1' AND bm_parent_id = ? AND bm_name = ? AND bm_dpId = ?";
			$query = $this->eqs->query($sql,array($eqs_brand,$eqs_model,$eqs_dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_building($bd_name='',$eqs_dpId=''){
			$sql = "SELECT bd.bd_id
					FROM ".$this->eqs_db.".eqs_equipments AS eqs
					LEFT JOIN ".$this->eqs_db.".eqs_building AS bd ON bd.bd_eqs_id = eqs.eqs_id
					WHERE eqs.eqs_name = ?
                    AND eqs.eqs_dpId = ?
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array($bd_name,$eqs_dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_room($eqs_bd_id='',$rm_name='',$eqs_dpId=''){
			$sql = "SELECT rm_id
					FROM ".$this->eqs_db.".eqs_room
					LEFT JOIN ".$this->eqs_db.".eqs_building 	 ON bd_id	= rm_bd_id
					LEFT JOIN ".$this->eqs_db.".eqs_equipments ON	eqs_id	= bd_eqs_id
					WHERE rm_bd_id = ?
                    AND rm_name = ?
                    AND eqs_dpId = ?
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array($eqs_bd_id,$rm_name,$eqs_dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		function chk_room_no($eqs_bd_id='',$rm_no='',$eqs_dpId=''){
			$sql = "SELECT rm_id
					FROM ".$this->eqs_db.".eqs_room
					LEFT JOIN ".$this->eqs_db.".eqs_building 	 ON bd_id	= rm_bd_id
					LEFT JOIN ".$this->eqs_db.".eqs_equipments ON	eqs_id	= bd_eqs_id
					WHERE rm_bd_id = ?
                    AND rm_no = ?
                    AND eqs_dpId = ?
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array($eqs_bd_id,$rm_no,$eqs_dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_vender($eqs_vd='',$eqs_dpId=''){
			$sql = "SELECT vd_id
					FROM ".$this->eqs_db.".eqs_vender
					WHERE vd_name = ? AND vd_dpId = ? ";
			$query = $this->eqs->query($sql,array($eqs_vd,$eqs_dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_fmnd_db($fmst='',$fmnd=''){
			$sql = "SELECT fmnd_id
					FROM ".$this->eqs_db.".eqs_format_nd
					WHERE fmnd_fmst_id = ? AND fmnd_name = ?";
			$query = $this->eqs->query($sql,array($fmst,$fmnd));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		function chk_fmrd_db($fmnd='',$fmrd=''){
			$sql = "SELECT fmrd_id
					FROM ".$this->eqs_db.".eqs_format_rd
					WHERE fmrd_fmnd_id = ? AND fmrd_name = ?";
			$query = $this->eqs->query($sql,array($fmnd,$fmrd));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}


		function chk_eqs_db($fmst='',$fmnd='',$fmrd='',$eqs_dpId=''){
			$sql = "SELECT *
					FROM ".$this->eqs_db.".eqs_equipments
					WHERE eqs_fmst_id =	?
                    AND eqs_fmnd_id = ?
                    AND eqs_fmrd_id = ?
                    AND eqs_dpId = ?
                    AND eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array($fmst,$fmnd,$fmrd,$eqs_dpId));
			if($query->num_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}

// ===============================================================================================
// == Create By CHAIN 2015/04/16 =================================================================
// ===============================================================================================
		function get_all_equipment_groupType($psd_dp_id) {
			$sql = "SELECT COUNT(eqs_fmst_id) AS countfmst_id , fmst_name, fmst_abbr
					FROM ".$this->eqs_db.".eqs_equipments
						LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_nd ON fmnd_id	= eqs_fmnd_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_rd ON fmrd_id	= eqs_fmrd_id
					WHERE eqs_dpId=?
                    AND eqs_active = 'Y'
					GROUP BY eqs_fmst_id";
			$query = $this->eqs->query($sql,array($psd_dp_id));
			// pre1($query->result());die;
			return $query;
		}//end of function get_all_equipment_groupType

		function get_all_equipment_universal() {
			$sql = "SELECT *
					FROM ".$this->eqs_db.".eqs_equipments
					LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id
					LEFT JOIN ".$this->eqs_db.".eqs_format_nd ON fmnd_id	= eqs_fmnd_id
					LEFT JOIN ".$this->eqs_db.".eqs_format_rd ON fmrd_id	= eqs_fmrd_id
                    WHERE eqs_active = 'Y' ";
			$query = $this->eqs->query($sql,array());
			return $query;
		}//end of function get_all_equipment_universal

        function get_select_equipment($dpId,$fmst_id,$fmnd_id,$start_date,$end_date) {	// using in function insertEquipment/insertEquipments
			$fmst = "";
			$fmnd = "";
			if($fmst_id!=""){
				$fmst = "&& eqs_fmst_id = '".$fmst_id."'";
			}
			if($fmnd_id!=""){
				$fmnd = "&& eqs_fmnd_id = '".$fmnd_id."'";
			}
            $sql = "SELECT *
                        FROM ".$this->eqs_db.".eqs_equipments
                        LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id
                        LEFT JOIN ".$this->eqs_db.".eqs_format_nd ON fmnd_id	= eqs_fmnd_id
                        LEFT JOIN ".$this->eqs_db.".eqs_format_rd ON fmrd_id	= eqs_fmrd_id
                        WHERE eqs_dpId= '$dpId' $fmst $fmnd && eqs_buydate BETWEEN '$start_date' AND '$end_date'
                        AND eqs_active = 'Y' ";
            $query = $this->eqs->query($sql);
			// echo $this->eqs->last_query();die;
            return $query;
            }//end of function get_select_equipment
        function get_select_equipment_groupType($dpId,$fmst_id,$fmnd_id,$start_date,$end_date) {
			$fmst = "";
			$fmnd = "";
			if($fmst_id!=""){
				$fmst = "&& eqs_fmst_id = '".$fmst_id."'";
			}
			if($fmnd_id!=""){
				$fmnd = "&& eqs_fmnd_id = '".$fmnd_id."'";
			}
            $sql = "SELECT *,COUNT(eqs_fmst_id) AS countfmst_id , fmst_name, fmst_abbr
                    FROM ".$this->eqs_db.".eqs_equipments
                        LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id
                        LEFT JOIN ".$this->eqs_db.".eqs_format_nd ON fmnd_id	= eqs_fmnd_id
                        LEFT JOIN ".$this->eqs_db.".eqs_format_rd ON fmrd_id	= eqs_fmrd_id
                    WHERE eqs_dpId= '$dpId' $fmst $fmnd  && eqs_buydate BETWEEN '$start_date' AND '$end_date'
                    AND eqs_active = 'Y'
                    GROUP BY eqs_fmst_id";
            $query = $this->eqs->query($sql);
        // pre1($query->result());die;
        return $query;
	}//end of function get_select_equipment_groupType
// ===============================================================================================
	function get_bg_id($i='') {
		$sql = "SELECT bg_id
				FROM ".$this->eqs_db.".eqs_budgettype
				WHERE bg_name LIKE '%$i%'";
		$query = $this->eqs->query($sql);
		if ($query->num_rows() != 0) {
				$this->row2attribute( $query->row() );
				return $this->bg_id;
			} else {
				return NULL;
			}
	}
// ===============================================================================================
	function set_active($active='Y') {
		$sql = "UPDATE ".$this->eqs_db.".eqs_equipments
                SET eqs_active = '$active'
                WHERE eqs_equipments.eqs_id = ?;";
		$query = $this->eqs->query($sql,array($this->eqs_id));
	}

     function get_amount_eqs_building_by_dp_id(){
		$sql = "SELECT COUNT(eqs_id) as amount
				FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN ".$this->eqs_db.".eqs_building b
						ON a.eqs_id = b.bd_eqs_id
				WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
				AND eqs_status !='S'
                ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		// echo $this->eqs->last_query();die;
		return $query->row()->amount;
	}

	// get_eqs_building_by_dp_id
	// Chain Chaiwat
	// Modify 2017-01-13
    function get_eqs_building_by_dp_id(){
		$sql = "SELECT fmst_id, fmst_name, eqs_id, eqs_name, eqs_code_old, eqs_price, eqs_buydate, eqs_expiredate, eqs_status, eqs_distribute_date
				FROM ".$this->eqs_db.".eqs_equipments eqs
                    INNER JOIN ".$this->eqs_db.".eqs_building b
						ON eqs.eqs_id = b.bd_eqs_id
					INNER JOIN ".$this->eqs_db.".eqs_format_st fmst
						ON eqs.eqs_fmst_id = fmst.fmst_id
				WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
				AND eqs_status !='S'
                ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		// echo $this->eqs->last_query();die;
		return $query;
	}

    function get_eqs_building_total_by_dp_id(){
		$sql = "SELECT COUNT(eqs_id) as count_eqs_id , fmst_name ,fmst_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                    INNER JOIN ".$this->eqs_db.".eqs_building c
						ON a.eqs_id = c.bd_eqs_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND eqs_status != 'S'
                AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
				GROUP BY eqs_fmst_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    function get_eqs_fmst_building_by_dpId(){
		$sql = "SELECT DISTINCT(fmst_id), fmst_name ,fmst_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                    INNER JOIN ".$this->eqs_db.".eqs_building c
						ON a.eqs_id = c.bd_eqs_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND eqs_status != 'S'
                AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
                GROUP BY eqs_fmst_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    function get_eqs_building_item_table($fmst_id){
		$sql = "SELECT bd_id,eqs_id,eqs_name,eqs_code_old,eqs_price,bd_area,eqs_buydate,eqs_expiredate,eqs_status,eqs_detail
                FROM ".$this->eqs_db.".eqs_equipments a
                INNER JOIN ".$this->eqs_db.".eqs_building b
						ON a.eqs_id = b.bd_eqs_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND eqs_status != 'S'
                AND eqs_fmst_id = '".$fmst_id."' ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    function get_eqs_building_total_by_dp_id_2(){
		$sql = "SELECT COUNT(bdd_bd_id) as count_bdd_bd_id , bd_name_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN ".$this->eqs_db.".eqs_format_st b
                        ON a.eqs_fmst_id = b.fmst_id
                    INNER JOIN ".$this->eqs_db.".eqs_building c
                        ON a.eqs_id = c.bd_eqs_id
                    INNER JOIN ".$this->eqs_db.".eqs_building_detail d
                        ON c.bd_id = d.bdd_bd_id
                    INNER JOIN ".$this->eqs_db.".eqs_building_type e
                        ON d.bdd_bdtype_id = e.bdtype_id
                    WHERE eqs_dpId=?
                    AND eqs_active = 'Y'
                    AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
                    GROUP BY bdd_bd_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    function get_eqs_fmst_building_by_dpId_2(){
		$sql = "SELECT DISTINCT(bd_id), bd_name_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN ".$this->eqs_db.".eqs_format_st b
                        ON a.eqs_fmst_id = b.fmst_id
                    INNER JOIN ".$this->eqs_db.".eqs_building c
                        ON a.eqs_id = c.bd_eqs_id
                    INNER JOIN ".$this->eqs_db.".eqs_building_detail d
                        ON c.bd_id = d.bdd_bd_id
                    INNER JOIN ".$this->eqs_db.".eqs_building_type e
                        ON d.bdd_bdtype_id = e.bdtype_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
                GROUP BY bdd_bd_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    function get_eqs_building_item_table_2($bd_id){
		$sql = "SELECT eqs_name,eqs_code_old,eqs_price,bdtype_name,bdd_area,eqs_buydate,eqs_expiredate,eqs_status
                FROM ".$this->eqs_db.".eqs_equipments a
                INNER JOIN ".$this->eqs_db.".eqs_building c
                        ON a.eqs_id = c.bd_eqs_id
                INNER JOIN ".$this->eqs_db.".eqs_building_detail d
                        ON c.bd_id = d.bdd_bd_id
                INNER JOIN ".$this->eqs_db.".eqs_building_type e
                        ON d.bdd_bdtype_id = e.bdtype_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND bd_id = '".$bd_id."' ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

	function get_eqs_building_total_by_dp_id_3(){
		$sql = "SELECT COUNT(bdd_bdtype_id) as count_bdd_bdtype_id , bdtype_name
				FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
					INNER JOIN ".$this->eqs_db.".eqs_building c
						ON a.eqs_id = c.bd_eqs_id
					INNER JOIN ".$this->eqs_db.".eqs_building_detail d
						ON c.bd_id = d.bdd_bd_id
					INNER JOIN ".$this->eqs_db.".eqs_building_type e
						ON d.bdd_bdtype_id = e.bdtype_id
					WHERE eqs_dpId=?
					AND eqs_active = 'Y'
					AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
					GROUP BY bdd_bdtype_id
                    ORDER BY bdd_bdtype_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

	function get_eqs_fmst_building_by_dpId_3(){
		$sql = "SELECT DISTINCT(bdd_bdtype_id) AS bdd_bdtype_id, bdtype_name
                FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN ".$this->eqs_db.".eqs_format_st b
                        ON a.eqs_fmst_id = b.fmst_id
                    INNER JOIN ".$this->eqs_db.".eqs_building c
                        ON a.eqs_id = c.bd_eqs_id
                    INNER JOIN ".$this->eqs_db.".eqs_building_detail d
                        ON c.bd_id = d.bdd_bd_id
                    INNER JOIN ".$this->eqs_db.".eqs_building_type e
                        ON d.bdd_bdtype_id = e.bdtype_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND(eqs_fmst_id = '23' OR eqs_fmst_id = '24' OR eqs_fmst_id = '25'OR eqs_fmst_id = '26')
                ORDER BY bdd_bdtype_id";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

    function get_eqs_building_item_table_3($bdd_bdtype_id ){
		$sql = "SELECT eqs_name,eqs_code_old,eqs_price,bdtype_name,bdd_area,eqs_buydate,eqs_expiredate,eqs_status ,eqs_detail
                FROM ".$this->eqs_db.".eqs_equipments a
                INNER JOIN ".$this->eqs_db.".eqs_building c
                        ON a.eqs_id = c.bd_eqs_id
                INNER JOIN ".$this->eqs_db.".eqs_building_detail d
                        ON c.bd_id = d.bdd_bd_id
                INNER JOIN ".$this->eqs_db.".eqs_building_type e
                        ON d.bdd_bdtype_id = e.bdtype_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y'
                AND bdd_bdtype_id  = '".$bdd_bdtype_id ."' ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}

	function get_all_eqs_by_status() {	// using in function insertEquipment/insertEquipments
		$status="";
		$select_dis_date = "";
		if($this->eqs_status=="all"){
			// $status=""; //Chain Comment 2018-07-03
			$status=" AND eqs_status!='S' "; //Chain Add 2018-07-03
		}else if($this->eqs_status!=""){
			if($this->eqs_status == "S"){
				$select_dis_date = ", eqs_distribute_date ";
			}
			$status="AND eqs_status = '{$this->eqs_status}'";
		}
		$sql = "SELECT eqs_id,fmst_name, eqs_name, eqs_code_old, eqs_buydate, eqs_price , eqs_detail ".$select_dis_date."
				FROM ".$this->eqs_db.".eqs_equipments a
				LEFT JOIN ".$this->eqs_db.".eqs_format_st b ON b.fmst_id	= a.eqs_fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_nd c  ON c.fmnd_id	= a.eqs_fmnd_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_rd d ON d.fmrd_id	= a.eqs_fmrd_id
				WHERE eqs_dpId=? $status AND eqs_active = 'Y'
				ORDER BY  b.fmst_name ,eqs_buydate DESC, eqs_name";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));

		// echo $this->eqs->last_query();
		// die;
		return $query;
	}//end of function get_all_equipment

	//=== CHAIN Create 2017/01/31 ===========================================
    function get_year_eqs(){
		// $sql = "SELECT YEAR(eqs_buydate) AS year_eqs
				// FROM ".$this->eqs_db.".`eqs_equipments`
				// WHERE eqs_dpId=?
				// GROUP BY YEAR(eqs_buydate)";
		$sql = "SELECT YEAR(DATE_ADD(eqs_buydate,INTERVAL 3 MONTH)) AS year_eqs
				FROM ".$this->eqs_db.".`eqs_equipments`
				WHERE eqs_dpId=? AND eqs_active = 'Y'
				GROUP BY YEAR(DATE_ADD(eqs_buydate,INTERVAL 3 MONTH));";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		return $query;
	}
	//=======================================================================
	//=== CHAIN Create 2017/02/08 ===========================================
	//=== $type => 0 Get all amount end_of_life =============================
	//=== ======== 1 Get any field end_of_life ==============================
	//=== ======== 2 Get all amount end_of_life By fmst_id ==================
	//=======================================================================
     function get_all_eqs_end_of_life($type=0,$fmst_id=0){
		$select = " * ";
		$from = "";
		$groupby = "";
		$where = "";
		$orderby = "";
		if($type==0){ //Get all amount end_of_life
			$select = " COUNT(eqs_id) AS amount";
		}else if($type==1){ //Get any field end_of_life
			$select = " eqs_id,fmst_name, eqs_name, eqs_code_old, eqs_buydate, eqs_expiredate, eqs_price, eqs_status, eqs_detail";
			$from = " LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id";
			if($fmst_id!=0){
				$where = " AND eqs_fmst_id = ".$fmst_id;
			}
			$orderby = "ORDER BY eqs_buydate DESC, eqs_name";
		}else if($type==2){ //Get all amount end_of_life By fmst_id
			$select = " COUNT(eqs_id) AS amount, eqs_fmst_id, fmst_name, fmst_abbr";
			$from = " LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id";
			$groupby = "GROUP BY eqs_fmst_id";
		}else if($type==3){ //Get all amount end_of_life By fmst_id
			$select = " eqs_id,fmst_name, eqs_name, eqs_code_old, eqs_buydate, eqs_expiredate, eqs_price, eqs_status";
			$from = " LEFT JOIN ".$this->eqs_db.".eqs_format_st ON fmst_id	= eqs_fmst_id";
			$orderby = "ORDER BY eqs_buydate DESC, eqs_name";
		}
		$sql = "SELECT $select
				FROM ".$this->eqs_db.".eqs_equipments $from
				WHERE eqs_dpId=? AND eqs_active = 'Y' AND eqs_status != 'S' AND DATEDIFF(CURDATE(),`eqs_expiredate`) > 0 $where
				$groupby
				$orderby ;";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		// echo $this->eqs->last_query();die;
		return $query;
	}
	//----------CODE BY MOD---------------------
	function get_eqs_by_eqs_id(){
        $sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				WHERE eqs_id=? ";
		$query = $this->eqs->query($sql,array($this->eqs_id));
		// print_r($this->eqs->last_query());
		return $query;
	}
	function get_UsDpId_id(){
        $sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				WHERE eqs_id=? ";
		$query = $this->eqs->query($sql,array($this->eqs_id));
		// print_r($this->eqs->last_query());
		return $query;
	}
	function get_eqs_by_eqs_id_detail(){
        $sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
				ON eq.eqs_brand_id = bm.bm_id
				LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
				ON eq.eqs_bg_id = bg.bg_id
				LEFT JOIN ".$this->eqs_db.".eqs_method as mt
				ON eq.eqs_mt_id = mt.mt_id
				LEFT JOIN ".$this->eqs_db.".eqs_building as bd
				ON eq.eqs_bd_id = bd.bd_id
				LEFT JOIN ".$this->eqs_db.".eqs_room as rm
				ON eq.eqs_rm_id = rm.rm_id
				LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
				ON eq.eqs_vd_id = vd.vd_id
				LEFT JOIN ".$this->hr.".hr_department as dp
				ON eq.eqs_deptId = dp.dept_id
				LEFT JOIN ".$this->eqs_db.".eqs_image as img ON img.img_eqs_id	= eq.eqs_id
				WHERE eq.eqs_id=? ";
		$query = $this->eqs->query($sql,array($this->eqs_id));
		return $query;
	}
	function get_data_smart_search($psd_dp_id=NULL, $fmst_id=NULL, $eqs_code_old=NULL, $eqs_name=NULL, $eqs_exp_Sdate=NULL, $eqs_exp_Edate=NULL, $mt_id=NULL, $bg_id=NULL,
	$eqs_Sbuy=NULL, $eqs_Ebuy=NULL, $eqs_status_y=NULL, $eqs_status_n=NULL, $eqs_status_s=NULL, $eqs_status_r=NULL, $eqs_status_b=NULL, $eqs_distribute_date=NULL,
	$fyear=NULL, $fc_year=NULL, $fdate_start=NULL, $fdate_end=NULL, $ex_year=NULL, $ex_Cyear=NULL, $ex_Sdate=NULL, $ex_Edate=NULL, $eqs_expire=NULL){
		if($fmst_id != NULL){
			$fmst_id = " AND eq.eqs_fmst_id IN (".implode(',',$fmst_id).")";
		}else{
			$fmst_id="";
		}
		// echo $this->ex_year;die;
		if($eqs_code_old != NULL){
			$eqs_code_old = " AND eq.eqs_code_old LIKE '%$eqs_code_old%'";
		}else{
			$eqs_code_old = "";
		}
		if($eqs_name != NULL){
			$eqs_name = " AND eq.eqs_name LIKE '%$eqs_name%'";
		}else{
			$eqs_name = "";
		}
		$eqs_expireyear = "";
		if($eqs_exp_Sdate != NULL && $eqs_exp_Edate != NULL){
			$eqs_expireyear = " AND eq.eqs_expireyear >= '$eqs_exp_Sdate' AND eq.eqs_expireyear <= '$eqs_exp_Edate'";
		}else if($eqs_exp_Sdate != NULL && $eqs_exp_Edate == NULL){
			$eqs_expireyear = " AND eq.eqs_expireyear >= '$eqs_exp_Sdate'";
		}else if($eqs_exp_Sdate == NULL && $eqs_exp_Edate != NULL){
			$eqs_expireyear = " AND eq.eqs_expireyear <= '$eqs_exp_Edate'";
		}
		if($mt_id != NULL){
			$mt_id = " AND eq.eqs_mt_id IN (".implode(',',$mt_id).")";
		}else{
			$mt_id="";
		}
		if($bg_id != NULL){
			$bg_id = " AND eq.eqs_bg_id IN (".implode(',',$bg_id).")";
		}else{
			$bg_id="";
		}
		$eqs_price = "";
		if($eqs_Sbuy != NULL && $eqs_Ebuy != NULL){
			$eqs_price = " AND eq.eqs_price >= '$eqs_Sbuy' AND eq.eqs_price <= '$eqs_Ebuy'";
		}else if($eqs_Sbuy != NULL && $eqs_Ebuy == NULL){
			$eqs_price = " AND eq.eqs_price >= '$eqs_Sbuy'";
		}else if($eqs_Sbuy == NULL && $eqs_Ebuy != NULL){
			$eqs_price = " AND eq.eqs_price <= '$eqs_Ebuy'";
		}

		if($eqs_status_y != NULL){
			$eqs_status_y = " AND eq.eqs_status = 'Y'";
		}else{
			$eqs_status_y = "";
		}
		if($eqs_status_n != NULL){
			$eqs_status_n = " AND eq.eqs_status = 'N'";
		}else{
			$eqs_status_n = "";
		}
		if($eqs_status_s != NULL){
			$eqs_status_s = " AND eq.eqs_status = 'S'";
		}else{
			$eqs_status_s = "";
		}
		if($eqs_status_r != NULL){
			$eqs_status_r = " AND eq.eqs_status = 'R'";
		}else{
			$eqs_status_r = "";
		}
		if($eqs_status_b != NULL){
			$eqs_status_b = " AND eq.eqs_status = 'B'";
		}else{
			$eqs_status_b = "";
		}
		if($eqs_distribute_date != NULL){
			$eqs_distribute_date = " AND eq.eqs_distribute_date = '$eqs_distribute_date'";
		}else{
			$eqs_distribute_date = "";
		}
		//-----------------------------
		//ปีงบประมาณ
		$f_year_1 = $fyear-544 ."09-31";
		$f_year_2 = $fyear-543 ."09-31";
		if($fyear != NULL){
			$fyear = " AND eq.eqs_buydate >=  '$f_year_1' AND eq.eqs_buydate < '$f_year_2'";
		}else{
			$fyear = "";
		}
		if($fc_year != NULL){
			$fc_year = $fc_year-543;
			// echo $fc_year;die;
			$fc_year = " AND YEAR(eq.eqs_buydate) = '$fc_year'";
		}else{
			$fc_year = "";
		}
		if($fdate_start != NULL){
			$fdate_start = $fdate_start-543;
			// echo $fdate_start;die;
			$fdate_start = " AND YEAR(eq.eqs_buydate) >= '$fdate_start'";
		}else{
			$fdate_start = "";
		}
		if($fdate_end != NULL){
			$fdate_end = $fdate_end-543;
			// echo $fdate_start;die;
			$fdate_end = " AND YEAR(eq.eqs_buydate) <= '$fdate_end'";
		}else{
			$fdate_end = "";
		}
		//-----------------------------
		//-----------------------------
		//ปีงบประมาณ
		$ex_year_1 = $ex_year-544 ."09-31";
		$ex_year_2 = $ex_year-543 ."09-31";
		if($ex_year != NULL){
			$ex_year = " AND eq.eqs_expiredate >=  '$ex_year' AND eq.eqs_expiredate < '$ex_year'";
		}else{
			$ex_year = "";
		}
		if($ex_Cyear != NULL){
			$ex_Cyear = $ex_Cyear-543;
			// echo $fc_year;die;
			$ex_Cyear = " AND YEAR(eq.eqs_expiredate) = '$ex_Cyear'";
		}else{
			$ex_Cyear = "";
		}
		if($ex_Sdate != NULL){
			$ex_Sdate = $ex_Sdate-543;
			// echo $fdate_start;die;
			$ex_Sdate = " AND YEAR(eq.eqs_expiredate) >= '$ex_Sdate'";
		}else{
			$ex_Sdate = "";
		}
		if($ex_Edate != NULL){
			$ex_Edate = $ex_Edate-543;
			// echo $fdate_start;die;
			$ex_Edate = " AND YEAR(eq.eqs_expiredate) <= '$ex_Edate'";
		}else{
			$ex_Edate = "";
		}
		//-----------------------------
		if($eqs_expire != NULL){
			$eqs_expire = " AND eq.eqs_expiredate < '$eqs_expire'";
		}else{
			$eqs_expire = "";
		}
		// echo $eqs_expire;die;
		// $ex_year=NULL, $ex_Cyear=NULL, $ex_Sdate=NULL, $ex_Edate=NULL, $eqs_expire=NULL
        $sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_method as mt
				ON eq.eqs_mt_id = mt.mt_id
				LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
				ON eq.eqs_brand_id = bm.bm_id
				LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
				ON eq.eqs_bg_id = bg.bg_id
				LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
				ON eq.eqs_vd_id = vd.vd_id
				WHERE eq.eqs_id != 0 AND eq.eqs_active='Y' ".$fmst_id.$eqs_code_old.$eqs_name.$eqs_expireyear.$mt_id.$bg_id.$eqs_price.$eqs_status_y.$eqs_status_n.$eqs_status_s.$eqs_status_r.$eqs_status_b.$eqs_distribute_date.$fyear.$fc_year.$fdate_start.$fdate_end.$ex_year.$ex_Cyear.$ex_Sdate.$ex_Edate.$eqs_expire;
		$query = $this->eqs->query($sql/*,array($psd_dp_id)*/);
		// echo $this->eqs->last_query();die;
		return $query;
	}
	function get_all_exportExcel(){
		// echo $this->start_date."=>".$this->end_date;die;
		if($this->start_date != NULL && $this->end_date!=NULL){
			if($this->fmst_id != 0){
				$sql = "SELECT *
						FROM ".$this->eqs_db.".eqs_equipments as eq
						LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
						ON eq.eqs_fmst_id = fm.fmst_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
						ON eq.eqs_fmnd_id = nd.fmnd_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
						ON eq.eqs_fmrd_id = rd.fmrd_id
						LEFT JOIN ".$this->eqs_db.".eqs_method as mt
						ON eq.eqs_mt_id = mt.mt_id
						LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
						ON eq.eqs_brand_id = bm.bm_id
						LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
						ON eq.eqs_bg_id = bg.bg_id
						LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
						ON eq.eqs_vd_id = vd.vd_id
						WHERE eq.eqs_dpId=? AND eqs_fmst_id=? AND eqs_buydate >= ? AND eqs_buydate <= ?";
				$query = $this->eqs->query($sql,array($this->psd_dp_id, $this->fmst_id, $this->start_date, $this->end_date));
			}else{
				$sql = "SELECT *
						FROM ".$this->eqs_db.".eqs_equipments as eq
						LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
						ON eq.eqs_fmst_id = fm.fmst_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
						ON eq.eqs_fmnd_id = nd.fmnd_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
						ON eq.eqs_fmrd_id = rd.fmrd_id
						LEFT JOIN ".$this->eqs_db.".eqs_method as mt
						ON eq.eqs_mt_id = mt.mt_id
						LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
						ON eq.eqs_brand_id = bm.bm_id
						LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
						ON eq.eqs_bg_id = bg.bg_id
						LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
						ON eq.eqs_vd_id = vd.vd_id
						WHERE eq.eqs_dpId=? AND eqs_buydate >= ? AND eqs_buydate <= ?";
				$query = $this->eqs->query($sql,array($this->psd_dp_id, $this->start_date, $this->end_date));
				// echo $this->eqs->last_query();die;
			}
		}else{
			if($this->fmst_id != 0){
				$sql = "SELECT *
						FROM ".$this->eqs_db.".eqs_equipments as eq
						LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
						ON eq.eqs_fmst_id = fm.fmst_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
						ON eq.eqs_fmnd_id = nd.fmnd_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
						ON eq.eqs_fmrd_id = rd.fmrd_id
						LEFT JOIN ".$this->eqs_db.".eqs_method as mt
						ON eq.eqs_mt_id = mt.mt_id
						LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
						ON eq.eqs_brand_id = bm.bm_id
						LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
						ON eq.eqs_bg_id = bg.bg_id
						LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
						ON eq.eqs_vd_id = vd.vd_id
						WHERE eq.eqs_dpId=? AND eqs_fmst_id=?";
				$query = $this->eqs->query($sql,array($this->psd_dp_id, $this->fmst_id));
			}else{
				$sql = "SELECT *
						FROM ".$this->eqs_db.".eqs_equipments as eq
						LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
						ON eq.eqs_fmst_id = fm.fmst_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
						ON eq.eqs_fmnd_id = nd.fmnd_id
						LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
						ON eq.eqs_fmrd_id = rd.fmrd_id
						LEFT JOIN ".$this->eqs_db.".eqs_method as mt
						ON eq.eqs_mt_id = mt.mt_id
						LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
						ON eq.eqs_brand_id = bm.bm_id
						LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
						ON eq.eqs_bg_id = bg.bg_id
						LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
						ON eq.eqs_vd_id = vd.vd_id
						WHERE eq.eqs_dpId=?";
				$query = $this->eqs->query($sql,array($this->psd_dp_id));
				// echo $this->eqs->last_query();die;
			}
		}
		return $query;
	}
	function get_all_exportExcel_depreciation(){
		if($this->fmst_id == 0 && $this->fmnd_id == 0){
			$sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
				ON eq.eqs_fmnd_id = nd.fmnd_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
				ON eq.eqs_fmrd_id = rd.fmrd_id
				LEFT JOIN ".$this->eqs_db.".eqs_method as mt
				ON eq.eqs_mt_id = mt.mt_id
				LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
				ON eq.eqs_brand_id = bm.bm_id
				LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
				ON eq.eqs_bg_id = bg.bg_id
				LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
				ON eq.eqs_vd_id = vd.vd_id
				WHERE YEAR(eqs_buydate) >= ? AND YEAR(eqs_buydate) <= ?";
			$query = $this->eqs->query($sql,array($this->start_year, $this->end_year));
		}else if($this->fmst_id == 0){
			$sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
				ON eq.eqs_fmnd_id = nd.fmnd_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
				ON eq.eqs_fmrd_id = rd.fmrd_id
				LEFT JOIN ".$this->eqs_db.".eqs_method as mt
				ON eq.eqs_mt_id = mt.mt_id
				LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
				ON eq.eqs_brand_id = bm.bm_id
				LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
				ON eq.eqs_bg_id = bg.bg_id
				LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
				ON eq.eqs_vd_id = vd.vd_id
				WHERE eqs_fmnd_id=? AND YEAR(eqs_buydate) >= ? AND YEAR(eqs_buydate) <= ?";
			$query = $this->eqs->query($sql,array($this->fmnd_id, $this->start_year, $this->end_year));
		}else if($this->fmnd_id == 0){
			$sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
				ON eq.eqs_fmnd_id = nd.fmnd_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
				ON eq.eqs_fmrd_id = rd.fmrd_id
				LEFT JOIN ".$this->eqs_db.".eqs_method as mt
				ON eq.eqs_mt_id = mt.mt_id
				LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
				ON eq.eqs_brand_id = bm.bm_id
				LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
				ON eq.eqs_bg_id = bg.bg_id
				LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
				ON eq.eqs_vd_id = vd.vd_id
				WHERE eqs_fmst_id=? AND YEAR(eqs_buydate) >= ? AND YEAR(eqs_buydate) <= ?";
			$query = $this->eqs->query($sql,array($this->fmst_id, $this->start_year, $this->end_year));
		}else{
			$sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
				ON eq.eqs_fmnd_id = nd.fmnd_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
				ON eq.eqs_fmrd_id = rd.fmrd_id
				LEFT JOIN ".$this->eqs_db.".eqs_method as mt
				ON eq.eqs_mt_id = mt.mt_id
				LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
				ON eq.eqs_brand_id = bm.bm_id
				LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
				ON eq.eqs_bg_id = bg.bg_id
				LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
				ON eq.eqs_vd_id = vd.vd_id
				WHERE eqs_fmst_id=? AND eqs_fmnd_id=? AND YEAR(eqs_buydate) >= ? AND YEAR(eqs_buydate) <= ?";
			$query = $this->eqs->query($sql,array($this->fmst_id, $this->fmnd_id, $this->start_year, $this->end_year));
		}
		// echo $this->eqs->last_query();die;
		return $query;
	}
	function get_all_exportExcel_depreciation1(){
		$depreciate_year = $this->start_year."-09-31";
		$depreciate = $this->start_year - 1;
		$depreciate_year1 = $depreciate."-09-31";
		//$this->fmst_id, $this->mt_id, $this->bg_id
		// echo $depreciate_year."=>".$depreciate_year1."<br>";
		$fmst_id = "";
		if($this->fmst_id != 0){
			$fmst_id = " AND eqs_fmst_id= '$this->fmst_id'";
		}
		$mt_id = "";
		if($this->mt_id != 0){
			$mt_id = " AND eqs_mt_id= '$this->mt_id'";
		}
		$bg_id = "";
		if($this->bg_id != 0){
			$bg_id = " AND eqs_bg_id= '$this->bg_id'";
		}
		$sql = "SELECT *
				FROM ".$this->eqs_db.".eqs_equipments as eq
				LEFT JOIN ".$this->eqs_db.".eqs_format_st as fm
				ON eq.eqs_fmst_id = fm.fmst_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_nd as nd
				ON eq.eqs_fmnd_id = nd.fmnd_id
				LEFT JOIN ".$this->eqs_db.".eqs_format_rd as rd
				ON eq.eqs_fmrd_id = rd.fmrd_id
				LEFT JOIN ".$this->eqs_db.".eqs_method as mt
				ON eq.eqs_mt_id = mt.mt_id
				LEFT JOIN ".$this->eqs_db.".eqs_brand_model as bm
				ON eq.eqs_brand_id = bm.bm_id
				LEFT JOIN ".$this->eqs_db.".eqs_budgettype as bg
				ON eq.eqs_bg_id = bg.bg_id
				LEFT JOIN ".$this->eqs_db.".eqs_vender as vd
				ON eq.eqs_vd_id = vd.vd_id
				WHERE eqs_buydate < ? AND eqs_buydate > ? AND eqs_price >5000".$fmst_id.$mt_id.$bg_id;
			$query = $this->eqs->query($sql,array($depreciate_year, $depreciate_year1));

		return $query;
	}
	function get_all_equipment_groupType_for_smart_search($psd_dp_id=NULL,$fmst_id=NULL) {
		if($fmst_id != NULL){
			$fmst_id = " AND fmst_id IN (".implode(',',$fmst_id).")";
		}else{
			$fmst_id="";
		}

		$sql = "SELECT COUNT(eqs_id) as count_eqs_id , fmst_name ,fmst_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
					INNER JOIN ".$this->eqs_db.".eqs_format_st b
						ON a.eqs_fmst_id = b.fmst_id
                WHERE eqs_dpId=?
                AND eqs_active = 'Y' AND eqs_id != 0 AND eqs_price >5000".$fmst_id."
				GROUP BY eqs_fmst_id";
		$query = $this->eqs->query($sql,array($psd_dp_id));
		return $query;
	}
	function get_by_bd(){
		// ถ้้าระบุ rm_id
		if($this->eqs_rm_id != 0 && $this->eqs_bd_id != 0){
			$sql = "SELECT eqs_id,fmst_name,eqs_code_old,eqs_name,eqs_buydate,eqs_price,eqs_status,bd_name_abbr,rm_name
					FROM $this->eqs_db.eqs_equipments
					LEFT JOIN $this->eqs_db.eqs_building ON eqs_building.bd_id = eqs_equipments.eqs_bd_id
					LEFT JOIN $this->eqs_db.eqs_room ON eqs_room.rm_id = eqs_equipments.eqs_rm_id
					LEFT JOIN $this->eqs_db.eqs_format_st ON eqs_format_st.fmst_id = eqs_equipments.eqs_fmst_id
					WHERE eqs_bd_id=? AND eqs_rm_id=?  AND eqs_active = 'Y'
					ORDER BY eqs_room.rm_no,eqs_equipments.eqs_code_old";
			return $this->eqs->query($sql,array($this->eqs_bd_id,$this->eqs_rm_id));
		}
		// ไม่ได้ระบุ rm_id
		else if($this->eqs_bd_id != 0 && $this->eqs_rm_id == 0){
			$sql = "SELECT eqs_id,fmst_name,eqs_code_old,eqs_name,eqs_buydate,eqs_price,eqs_status,bd_name_abbr,rm_name
					FROM $this->eqs_db.eqs_equipments
					LEFT JOIN $this->eqs_db.eqs_building ON eqs_building.bd_id = eqs_equipments.eqs_bd_id
					LEFT JOIN $this->eqs_db.eqs_room ON eqs_room.rm_id = eqs_equipments.eqs_rm_id
					LEFT JOIN $this->eqs_db.eqs_format_st ON eqs_format_st.fmst_id = eqs_equipments.eqs_fmst_id
					WHERE eqs_bd_id=?  AND eqs_active = 'Y'
					ORDER BY eqs_room.rm_no,eqs_equipments.eqs_code_old";
			return $this->eqs->query($sql,array($this->eqs_bd_id));
		}
		else{
			$sql = "SELECT eqs_id,fmst_name,eqs_code_old,eqs_name,eqs_buydate,eqs_price,eqs_status,bd_name_abbr,rm_name
					FROM $this->eqs_db.eqs_equipments
					LEFT JOIN $this->eqs_db.eqs_building ON eqs_building.bd_id = eqs_equipments.eqs_bd_id
					LEFT JOIN $this->eqs_db.eqs_room ON eqs_room.rm_id = eqs_equipments.eqs_rm_id
					LEFT JOIN $this->eqs_db.eqs_format_st ON eqs_format_st.fmst_id = eqs_equipments.eqs_fmst_id
					WHERE eqs_active = 'Y'
					ORDER BY eqs_room.rm_no,eqs_equipments.eqs_code_old";
			return $this->eqs->query($sql,array($this->eqs_bd_id));
		}
		//return $query ;
	}
	function get_num_start($eqs_code){

		$sql = "SELECT IFNULL((SELECT eqs_code_old
				FROM $this->eqs_db.eqs_equipments
				WHERE eqs_code_old LIKE \"$eqs_code/%\"
				ORDER BY eqs_equipments.eqs_id DESC LIMIT 1),'0000/0') AS eqs_code_no";
		return $this->eqs->query($sql);

	}
	function get_count_eqs(){
		$sql = "SELECT COUNT(eqs_code_old) as count_eqs_code
                FROM $this->eqs_db.eqs_equipments
								WHERE eqs_equipments.eqs_code_old = ?";

		return $this->eqs->query($sql,array($this->eqs_code_old));
	}
	function get_sum_repair_eqs(){
		$sql = "SELECT IFNULL(SUM(repd_price),'0') as sum_repd_price
                FROM $this->eqs_db.eqs_equipments
								LEFT JOIN $this->eqs_db.eqs_repair_detail ON eqs_repair_detail.repd_eqs_id = eqs_equipments.eqs_id
								WHERE eqs_equipments.eqs_code_old = ?";
		return $this->eqs->query($sql,array($this->eqs_code_old));
	}
	function get_eqs_code_serach(){
		$sql = "SELECT eqs_code_old,eqs_id,eqs_name
				FROM $this->eqs_db.eqs_equipments
				WHERE eqs_code_old LIKE '%$this->eqs_code_old%' AND eqs_status != 'RP' AND eqs_active = 'Y'
				ORDER BY eqs_code_old LIMIT 10";
		return $this->eqs->query($sql);
	}
	function get_eqs_status(){
		$sql = "SELECT *
				FROM $this->eqs_db.eqs_status";
		return $this->eqs->query($sql);
	}
	function get_eqs_code_serach_by_filter(){
		$where = "";
		if($this->eqs_status != ""){
			$where .= " AND eqs_status = '$this->eqs_status' ";
		  if($this->eqs_status == 'S'){
			$where .= " AND eqs_distribute_date = '$this->eqs_distribute_date' ";
		  }
		}
		$eqs_code ="";
		if($this->eqs_code_old_start != "" && $this->eqs_code_old_end !=""){
			$eqs_code .=" AND (eqs_code_old BETWEEN '$this->eqs_code_old_start' AND '$this->eqs_code_old_end')";
		}else if($this->eqs_code_old_start != ""){
			$eqs_code .=" AND eqs_code_old LIKE '$this->eqs_code_old_start%' ";
		}else if($this->eqs_code_old_end != ""){
			$eqs_code .=" AND eqs_code_old LIKE '$this->eqs_code_old_end%' ";
		}
		$this->eqs_name != ""? $where .= " AND eqs_name LIKE '$this->eqs_name' ":"";
		// $this->eqs_code_old != ""? $where .= " AND eqs_code_old LIKE '$this->eqs_code_old%' ":"";
		$this->eqs_fmst_id != ""? $where .= " AND eqs_fmst_id = '$this->eqs_fmst_id' ":"";
		$this->eqs_bd_id != ""? $where .= " AND eqs_bd_id = '$this->eqs_bd_id' ":"";
		$this->eqs_rm_id != ""? $where .= " AND eqs_rm_id = '$this->eqs_rm_id' ":"";
		$this->eqs_deptId != ""? $where .= " AND eqs_deptId = '$this->eqs_deptId' ":"";
		$this->eqs_mt_id != ""? $where .= " AND eqs_mt_id = '$this->eqs_mt_id' ":"";
		$this->eqs_bg_id != ""? $where .= " AND eqs_bgt_id = '$this->eqs_bg_id' ":"";
		$this->eqs_brand_id != ""? $where .= " AND eqs_brand_id = '$this->eqs_brand_id' ":"";
		$this->eqs_model_id != ""? $where .= " AND eqs_model_id = '$this->eqs_model_id' ":"";
		$this->eqs_vd_id != ""? $where .= " AND eqs_vd_id = '$this->eqs_vd_id' ":"";
		$this->eqs_gf != ""? $where .= " AND eqs_gf LIKE '$this->eqs_gf' ":"";

		$sql = "SELECT eqs_code_old , eqs_id FROM $this->eqs_db.eqs_equipments
		WHERE 1 $where $eqs_code AND eqs_status != 'RP' AND eqs_active = 'Y'";
		
		$query = $this->eqs->query($sql);
		// echo $this->eqs->last_query();die;
		return $query;
	}
	//=======================================================================
	//Get data equipment last create date ข้อมูลที่เพิ่มล่าสุด
	function get_eqs_last_create_date(){
		$sql = "SELECT *
				FROM $this->eqs_db.eqs_equipments 
				WHERE eqs_active='Y' 
					AND eqs_date_create = (
						SELECT MAX(`eqs_date_create`) 
						FROM $this->eqs_db.`eqs_equipments`
						WHERE eqs_active='Y'
						)
				ORDER BY eqs_id
                ";
		$query = $this->eqs->query($sql);
		return $query;
	}
	//Get data equipment last create date ข้อมูลที่ซื้อล่าสุด
	function get_eqs_last_buy_date(){
		$sql = "SELECT *
				FROM $this->eqs_db.eqs_equipments 
				WHERE eqs_active='Y' 
					AND eqs_buydate = (
						SELECT MAX(`eqs_buydate`) 
						FROM $this->eqs_db.`eqs_equipments`
						WHERE eqs_active='Y'
						)
				ORDER BY eqs_id
                ";
		$query = $this->eqs->query($sql);
		return $query;
	}
	//Get data equipment last distribute_date ข้อมูลที่จำหน่ายวันลาสุด
	function get_eqs_last_distribute_date(){
		$sql = "SELECT *
				FROM $this->eqs_db.eqs_equipments 
				WHERE eqs_active='Y' AND eqs_status = 'S'
					AND eqs_distribute_date = (
						SELECT MAX(`eqs_distribute_date`) 
						FROM $this->eqs_db.`eqs_equipments`
						WHERE eqs_active='Y' AND eqs_status = 'S'
						)
				ORDER BY eqs_id
                ";
		$query = $this->eqs->query($sql);
		return $query;
	}

    // Get data equipment type 3 
    function get_eqs_fmst_id3($eqs_fmst_id){
        $sql = "SELECT * 
                FROM $this->eqs_db.eqs_equipments 
                WHERE eqs_fmst_id='$eqs_fmst_id' AND eqs_active='Y'";
        $query = $this->eqs->query($sql);
        return $query;
    }
	
	// Chain Create 2018-07-03
    // ดึงข้อมูลประเภทครุภัณฑ์แบ่งตามเกณฑ์ และ GF 
	//eqs_in_criteria => ครุภัณฑ์ที่อยู่ในระบบ GF ซื้อตั้งแต่ปีงบ 2548 ขึ้นไป ราคามากกว่า 5000
	//eqs_below_criteria => ครุภัณฑ์ที่ไม่อยู่ในระบบ GF ซื้อตั้งแต่ปีงบ 2548 ขึ้นไป ราคามากกว่า 5000
	//eqs_in_criteria_old => 
	//eqs_below_criteria_old => 
    function get_eqs_by_fmst_on_gf_criteria(){
        $sql = "SELECT fmst_id, fmst_name, fmst_abbr, COUNT(*) AS eqs_total,
					COUNT(IF((eqs_gf != '') AND eqs_buydate>='2004-10-01',eqs_id,null)) AS eqs_in_criteria,
					COUNT(IF((eqs_gf = '' OR eqs_gf IS NULL) AND eqs_buydate>='2004-10-01',eqs_id,null)) AS eqs_below_criteria,
					COUNT(IF(eqs_price>=5000 AND eqs_buydate<'2004-10-01',eqs_id,null)) AS eqs_in_criteria_old,
					COUNT(IF(eqs_price<5000 AND eqs_buydate<'2004-10-01',eqs_id,null)) AS eqs_below_criteria_old
				FROM $this->eqs_db.`eqs_equipments` 
					INNER JOIN $this->eqs_db.eqs_format_st
						ON eqs_fmst_id = fmst_id
				WHERE eqs_active = 'Y' AND eqs_status != 'S'
				GROUP BY fmst_id";
        $query = $this->eqs->query($sql);
        return $query;
    }

    function get_bd_name_abbr_room_by_dpId(){
        //$sql = "SELECT DISTINCT(bd_id), bd_name_abbr
        //        FROM ".$this->eqs_db.".eqs_room a
        //            INNER JOIN ".$this->eqs_db.".eqs_building b
        //                ON a.rm_bd_id = b.bd_id
        //        WHERE eqs_dpId=?
        //        AND rm_status_id = 1
        //        GROUP BY rm_bd_id";
        //$query = $this->eqs->query($sql,array($this->eqs_dpId));
        //return $query;

        $sql = "SELECT DISTINCT(bd_id), bd_name_abbr, rm_floor, rm_no
                FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN ".$this->eqs_db.".eqs_building b
                        ON a.eqs_id = b.bd_eqs_id
                    INNER JOIN ".$this->eqs_db.".eqs_room c
                        ON c.rm_bd_id = b.bd_id
                WHERE eqs_dpId=?
                AND rm_status_id = 1
                GROUP BY rm_bd_id
				ORDER BY rm_no
				";
                // AND rm_status_id = 1 <<< ถ้าต้องการใส่เงื่อนไข
        $query = $this->eqs->query($sql,array($this->eqs_dpId));
        return $query;
    }

    function get_eqs_room_total_by_dp_id(){
        //$sql = "SELECT COUNT(rm_id) as count_eqs_id , bd_name_abbr
        //        FROM ".$this->eqs_db.".eqs_room a
        //            INNER JOIN ".$this->eqs_db.".eqs_building b
        //                ON a.rm_bd_id = b.bd_id
        //        WHERE eqs_dpId=?
        //        AND rm_status_id = 1
        //        
        //        GROUP BY rm_bd_id";
        //$query = $this->eqs->query($sql,array($this->eqs_dpId));
        //return $query;

        $sql = "SELECT COUNT(rm_id) as count_eqs_id , bd_name_abbr
                FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN ".$this->eqs_db.".eqs_building b
                        ON a.eqs_id = b.bd_eqs_id
                    INNER JOIN ".$this->eqs_db.".eqs_room c
                        ON c.rm_bd_id = b.bd_id
                WHERE eqs_dpId=?
                AND rm_status_id = 1
                GROUP BY rm_bd_id
				ORDER BY rm_no";
        $query = $this->eqs->query($sql,array($this->eqs_dpId));
        return $query;
    }

    function get_eqs_room_table($fmst_id){
        $sql = "SELECT rm_id,rm_name,rm_no,rm_floor,rm_capacity,rm_area,rm_bd_id,status_name,bdtype_name
                FROM ".$this->eqs_db.".eqs_equipments a
                    INNER JOIN ".$this->eqs_db.".eqs_building b
                        ON a.eqs_id = b.bd_eqs_id
                    INNER JOIN ".$this->eqs_db.".eqs_room c
                        ON c.rm_bd_id = b.bd_id
                    INNER JOIN ".$this->eqs_db.".eqs_status d
                        ON c.rm_status_id = d.status_id
                    INNER JOIN ".$this->eqs_db.".eqs_building_type e
                        ON c.rm_bdtype_id = e.bdtype_id
                WHERE eqs_dpId=?
                AND rm_status_id = 1
                AND rm_bd_id = '".$fmst_id."' 
				ORDER BY rm_no";
        $query = $this->eqs->query($sql,array($this->eqs_dpId));
        return $query;

        //$sql = "SELECT eqs_id,eqs_name,eqs_code_old,eqs_price,eqs_buydate,eqs_expiredate,eqs_status,eqs_detail
        //        FROM ".$this->eqs_db.".eqs_equipments
        //        WHERE eqs_dpId=?
        //        AND eqs_active = 'Y'
        //        AND eqs_status != 'S'
        //        AND eqs_fmst_id = '".$fmst_id."' ";
        //$query = $this->eqs->query($sql,array($this->eqs_dpId));
        //return $query;
    }
	//นับจำนวนครุภัณฑ์
	function get_count_eqs_in_room($room_id){
		$sql = "SELECT COUNT(eqs_code_old) as amount
				FROM ".$this->eqs_db.".eqs_equipments a
				INNER JOIN ".$this->eqs_db.".eqs_room c
                        ON c.rm_id = a.eqs_rm_id
				WHERE eqs_dpId=?
					AND eqs_rm_id = '".$room_id."' 
					AND eqs_status != 'S'
					AND eqs_active != 'N'
                ";
		$query = $this->eqs->query($sql,array($this->eqs_dpId));
		// echo $this->eqs->last_query();die;
		return $query->row()->amount;
	}

} // end class M_eqs_equipments

?>
