<?php
include('EQS_Controller.php');
class building_room extends EQS_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
    $this->load->model($this->config->item('eqs_folder').'M_eqs_format_st','fmst');
	$fmst = $this->fmst;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_format_nd','fmnd');
	$fmnd = $this->fmnd;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_format_rd','fmrd');
	$fmrd = $this->fmrd;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_brand_model','bm');
	$bm = $this->bm;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_budgettype','bgt');
	$bgt = $this->bgt;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_method','mt');
	$mt = $this->mt;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
	$bd = $this->bd;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_room','rm');
	$rm = $this->rm;
	// $this->load->model($this->config->item('eqs_folder').'M_person','ps');
	// $ps = $this->ps;
	$this->load->model($this->config->item('eqs_folder').'M_department','dept');
	$dept = $this->dept;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_vender','vd');
	$vd = $this->vd;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_equipments','eqs');
	$eqs = $this->eqs;

    // $ps->ps_id  = $this->session->userdata('UsPsCode');
    // $ps->get_by_key(true);
    $this->data['bd'] 		= $bd;
    //$this->data['qu_all_bd'] = $bd->get_all_building($this->session->userdata('UsDpID'));
    $this->data['psd_dp_id']		=	$psd_dp_id 	=  	$this->session->userdata('UsDpID');
    $this->data['tb_name'] 	= 'เพิ่มข้อมูลอาคาร';
	$this->data['col_name'] = array("ชื่ออาคาร", "ชื่อย่ออาคาร", "พื้นที่ใช้สอย", "จำนวนชั้น", "จำนวนห้อง", "ดำเนินการ");

    //$this->data['qu_all']	=  $eqs->get_all_equipment($psd_dp_id);
    $this->data['qu_all'] = $bd->get_all_building_new2($psd_dp_id);
	$this->data['op_bdtype']	=	$bd->get_options_fmstTypeBd();
	$this->data['rm'] 	  = $rm;


    $this->data['op_bdtype_name']	=	$bd->get_options_TypeBd();

		$this->data['temp']		=  getNowDateBuddishTH("/");
		$this->data['op_fmst']	=  $fmst->get_options('y','');
		$this->data['op_fmnd']	=  $fmnd->get_options('y','');
		$this->data['op_fmrd']	=  $fmrd->get_options('y','');
		$this->data['op_brand']	=  $bm->get_options_parent('y',$psd_dp_id);		//parent
		$this->data['op_model']	=  $bm->get_options_model('y',$psd_dp_id);		//sub
		$this->data['op_bgt']	=  $bgt->get_options();
		$this->data['op_mt']	=  $mt->get_all_method();
		$this->data['qu_eqs_status'] = $eqs->get_eqs_status();
		//$this->data['op_mt']	=  $mt->get_options_parent();				//parent
		//$this->data['op_mt2']	=  $mt->get_options_sub();					//sub
		$this->data['op_bd']	=  $bd->get_options_building('y',$psd_dp_id);	//parent
		$this->data['op_rm']	=  $rm->get_options_room();				 	//sub
		$this->data['op_vd']	=  $vd->get_options_vender('y',$psd_dp_id);
		$this->data['op_dept']  =  $dept->get_optionsByGroup($psd_dp_id,$dept->getdept_groupByFlag('Y',$psd_dp_id),'0');
		$this->data['headGroup'] = $mt->getMtGroup();
		foreach ($this->data['headGroup']->result() as $key => $value) {
			$this->data['mtChild'][$value->mt_id] = $mt->getMtChild($value->mt_id)->result();
		}

		$eqs_id 	=   $this->input->post('eqs_id');
		if($eqs_id){
			$eqs->eqs_id = $eqs_id;
			$this->data['qu_ed']	= $eqs->get_by_key();
		}


        $bd_id = $this->input->post('bd_id');
			if($bd_id){
				$bd->bd_id = $bd_id;
				$this->data['qu_ed'] = $bd->get_by_key();
			}
		// $this->data['tb_name'] 	= 'ข้อมูลอาคาร';
		// $this->data['col_name'] = array("ชื่ออาคาร", "ประเภทอาคาร", "ห้อง", "รองรับคนได้", "หน่วยงานที่รับผิดชอบ", "เพิ่มข้อมูลห้อง", "แก้ไข", "ลบ");
			// $ps->ps_id  = $this->session->userdata('UsPsCode');
			// $ps->get_by_key(true);
			// $psd_dp_id	=	$ps->psd_dp_id;
		// $this->data['qu_all'] = $bd->get_all_building($psd_dp_id);
		// $this->data['op_bdtype']	=	$bd->get_options_fmstTypeBd();
		// $this->data['rm'] 	  = $rm;

		// $bd_id = $this->input->post('bd_id');
			// if($bd_id){
				// $bd->bd_id = $bd_id;
				// $this->data['qu_ed'] = $bd->get_by_key();
			// }
		$this->output($this->config->item('eqs_folder').'v_EQS_building_room',$this->data);

    }

    function saveBuilding(){
        $this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
        $bd = $this->bd;
        $this->load->model($this->config->item('eqs_folder').'M_eqs_room','rm');
        $rm = $this->rm;

        $this->load->model($this->config->item('eqs_folder').'M_eqs_equipments','eqs');
        $eqs = $this->eqs;
		$this->load->model($this->config->item('eqs_folder').'M_eqs_image','img');
		$img = $this->img;
        // $this->load->model($this->config->item('eqs_folder').'M_person','ps');
        // $ps = $this->ps;
        $eqs->eqs->trans_begin();
		// $ps->ps_id  = $this->session->userdata('UsPsCode');
		// $ps->get_by_key(true);
		$eqs_dpId 		=   $this->session->userdata('UsDpID');
		$eqs_id 		=   $this->input->post('eqs_id');

		$bd_id 		    = 	$this->input->post('bd_id');
        $bd_eqs_id 	    = 	$this->input->post('bd_eqs_id');


        if($this->input->post('btnSubmit')){
        //insert&update Building
        $fmst_id	 =	$this->input->post('fmst_id');
        $fmnd_id	 =	'';
        $fmrd_id	 =	'';

        $eqs->eqs_amount 	= 	1;
        $eqs->eqs_name 		= 	$this->input->post('eqs_name');
        $eqs->eqs_fmst_id 	= 	$fmst_id;
        $eqs->eqs_fmnd_id 	= 	0;
        $eqs->eqs_fmrd_id 	= 	0;
        $eqs->eqs_fmrd_temp =   '';
        $eqs->eqs_unit		=   1;
        $eqs->eqs_code 		= 	'';

        $eqs->eqs_code_old	= 	$this->input->post('eqs_code_old');
        $eqs->eqs_gf		= 	$this->input->post('eqs_gf');

        $eqs->eqs_brand_id 	= 	0;
        $eqs->eqs_model_id 	= 	0;
        $eqs->eqs_price 	= 	$this->input->post('eqs_price');
        $eqs->eqs_bg_id 	= 	$this->input->post('eqs_bgt_id');
        $eqs->eqs_mt_id		= 	$this->input->post('eqs_mt_id');
        $eqs->eqs_buydate = $eqs_buydate = 	splitDateForm3($this->input->post('eqs_buydate'));

        list($syy ,$smm , $sdd) = preg_split("[/|-]", $eqs_buydate);

        if($this->input->post('eqs_expiredate') == '' && $this->input->post('eqs_expireyear') != '' ){
            $year 		= $this->input->post('eqs_expireyear');
            $year_exp 	= $syy + $year;
            $eqs_expiredate 		= $year_exp."-".$smm."-".$sdd;
            $eqs->eqs_expiredate	= $eqs_expiredate;
            $eqs->eqs_expireyear	= $year;
            // echo"aaaaaaaa";
            // die;

        }else if($this->input->post('eqs_expiredate') != '' && $this->input->post('eqs_expireyear') == ''){
            $eqs_expiredate 		= splitDateForm3($this->input->post('eqs_expiredate'));
            list($eyy ,$emm , $edd) = preg_split("[/|-]", $eqs_expiredate);
            $year_exp 	= $eyy - $syy;
            $eqs->eqs_expiredate    = $eqs_expiredate;
            $eqs->eqs_expireyear	= $year_exp;
            // echo"bbbbbbbbb";
            // die;
        }else if($this->input->post('eqs_expiredate') != '' && $this->input->post('eqs_expireyear') != ''){
            $eqs->eqs_expiredate		= 	splitDateForm3($this->input->post('eqs_expiredate'));
            $eqs->eqs_expireyear		= 	$this->input->post('eqs_expireyear');
            // echo"ccccccccc";
            // die;
        }else if($this->input->post('eqs_expiredate') == '' && $this->input->post('eqs_expireyear') == '' ){

            $this->load->model($this->config->item('eqs_folder').'M_eqs_format_st','fmst');
            $fmst = $this->fmst;
            $fmst->fmst_id = $this->input->post('fmst_id');
            $fmst->get_by_key(TRUE);
            $year 		= $fmst->fmst_year;
            $year_exp 	= $syy + $year;
            $eqs_expiredate 		= $year_exp."-".$smm."-".$sdd;
            $eqs->eqs_expiredate	= $eqs_expiredate;
            $eqs->eqs_expireyear	= $year;

            // echo"ddddddddd";
            // die;
        }

        $eqs->eqs_dpId 		=  	$eqs_dpId;
        $eqs->eqs_deptId 	= 	0;
        $eqs->eqs_bd_id     = 	0;
        $eqs->eqs_rm_id 	= 	0;
        $eqs->eqs_vd_id 	= 	0;
        $eqs->eqs_status 	= 	$this->input->post('eqs_status');
        $eqs->eqs_distribute_date	= '0000-00-00';
        if($eqs->eqs_status == 'S'){
          $eqs->eqs_distribute_date = splitDateForm1($this->input->post('eqs_distribute_date'));
        }
				$eqs->eqs_detail 		= 	$this->input->post('eqs_detail');
        $eqs->eqs_active     	= 	'Y';
        $eqs->eqs_user_create 	=   $this->session->userdata('UsPsCode');
        $eqs->eqs_date_create   =   date("Y-m-d H:i:s");
        $eqs->eqs_user_update 	=   $this->session->userdata('UsPsCode');
        $eqs->eqs_date_update   =   date("Y-m-d H:i:s");

        $bd->bd_eqs_id 	        = 	$eqs_id;
        $bd->bd_name_abbr 	    = 	$this->input->post('bd_name_abbr');
        $bd->bd_amount_room 	= 	$this->input->post('bd_amount_room');
        $bd->bd_amount_floor 	= 	$this->input->post('bd_amount_floor');
        $bd->bd_area 	        = 	$this->input->post('bd_area');

		if($bd_eqs_id){
				$eqs->eqs_id 	= $bd_eqs_id;
				$bd->bd_id	  	= $bd_id;
				$eqs->update();
				$bd->update_building();
				
				$config['upload_path']= $this->config->item('eqs_upload_folder').$this->config->item('eqs_image_folder');
				$config['allowed_types']='*';
				//$cofig['max_size']='1000';
				//$cofig['max_width']='1024';
				//$cofig['max_height']= '768';

				$extension = explode(".", $_FILES['img_name']['name']);;
				$file_name = date("Ymd_His")."-".$eqs->eqs_fmst_id."-".$eqs->last_insert_id."-".md5($eqs->eqs_name).".".end($extension);
				$config['file_name']= $file_name;
				$img_path = $file_name;

				// echo "รอบที่".$i."  last_insert_id-->".$eqs->last_insert_id;
				// echo "<br>";
				// echo "รอบที่".$i."  file_name-->".$file_name;
				// echo "<br>";
				//die;
				$this->load->library('upload',$config);
				$this->upload->overwrite = true;
				if(!$this->upload->do_upload('img_name'))
				{
					$error = array('error'=>$this->upload->display_errors());
					// var_dump($error);
				}
				else
				{
					$data = array('upload_data'=>$this->upload->data());
					// echo "<pre>";
					// print_r($data);
					// echo "</pre>";
					// die;
					$this->img->img_name	=	$_FILES['img_name']['name'];
					$this->img->img_path	=	$data['upload_data']['file_name'];
					// $this->img->img_path	=	$img_path;
					$this->img->img_eqs_id	=	$bd_eqs_id;
					$img->insert();
				}
		}else{

			if($eqs->chk_eqs_code($eqs->eqs_code_old)){
				echo "<script>bootbox.alert('หมายเลขครุภัณฑ์ ".$eqs->eqs_code_old." มีอยู่แล้วในระบบ');</script>";
				// redirect($this->config->item('eqs_folder').'Insert_eqs/import_excel', 'refresh');
			}else{

				$eqs->insert();
				$eqs_bd_id		= $eqs->last_insert_id;
				$bd->bd_eqs_id  = $eqs_bd_id;
				$bd->insert_building();

				$config['upload_path']= $this->config->item('eqs_upload_folder').$this->config->item('eqs_image_folder');
				$config['allowed_types']='*';
				//$cofig['max_size']='1000';
				//$cofig['max_width']='1024';
				//$cofig['max_height']= '768';

				$extension = explode(".", $_FILES['img_name']['name']);;
				$file_name = date("Ymd_His")."-".$eqs->eqs_fmst_id."-".$eqs->last_insert_id."-".md5($eqs->eqs_name).".".end($extension);
				$config['file_name']= $file_name;
				$img_path = $file_name;

				// echo "รอบที่".$i."  last_insert_id-->".$eqs->last_insert_id;
				// echo "<br>";
				// echo "รอบที่".$i."  file_name-->".$file_name;
				// echo "<br>";
				//die;
				$this->load->library('upload',$config);
				$this->upload->overwrite = true;
				if(!$this->upload->do_upload('img_name'))
				{
					$error = array('error'=>$this->upload->display_errors());
					// var_dump($error);
				}
				else
				{
					$data = array('upload_data'=>$this->upload->data());
					// echo "<pre>";
					// print_r($data);
					// echo "</pre>";
					// die;
					$this->img->img_name	=	$_FILES['img_name']['name'];
					$this->img->img_path	=	$data['upload_data']['file_name'];
					// $this->img->img_path	=	$img_path;
					$this->img->img_eqs_id	=	$eqs->last_insert_id;
					$img->insert();
				}
			}

		}
		

        if($eqs->eqs->trans_status() === FALSE){
            $eqs->eqs->trans_rollback();
            // echo "trans_rollback";die;
        }else{
            $eqs->eqs->trans_commit();
            // echo "trans_commit";die;
        }
		redirect($this->config->item('eqs_folder').'building_room');
    }else{
     //insert&update Room

            // $bd2id		    =	trim($this->input->post('bd2id'));
            $bd_id	        	=	trim($this->input->post('bd_id'));
            $rm_id	        	=	trim($this->input->post('rm_id'));
			$rm_name	   		=	trim($this->input->post('rm_name'));
            // $bdd_bd_id	    =	trim($this->input->post('bdd_bd_id'));
            $rm_no	   			=	trim($this->input->post('rm_no'));
            $rm_floor	    	=	trim($this->input->post('rm_floor'));
            $rm_capacity	    =	trim($this->input->post('rm_capacity'));
            $rm_area	    	=	trim($this->input->post('rm_area'));
            $rm_fmst_id	    	=	trim($this->input->post('rm_fmst_id'));
            $rm_bd_id	    	=	trim($this->input->post('rm_bd_id'));
            $rm_bdtype_id	    =	trim($this->input->post('rm_bdtype_id'));
            $rm_status_id	    =	trim($this->input->post('rm_status_id'));
            $rm_dpid 			= 	$this->session->userdata('UsDpID');

    // echo "$bd2id# $bd_id# $bdd_area# $bdd_bd_id# $bd_type_id";die;
            if($this->input->post('method')=="edit"){
				// echo"eiei";
				// die;
				$rm->rm_id       	 = $rm_id;
                $rm->rm_name   	 	 = $rm_name;
                $rm->rm_no   		 = $rm_no;
                $rm->rm_floor        = $rm_floor;
                $rm->rm_capacity     = $rm_capacity;
                $rm->rm_area     	 = $rm_area;
                $rm->rm_dpid     	 = $rm_dpid;
                // $rm->rm_fmst_id      = $rm_fmst_id;
                $rm->rm_fmst_id      = 0;
				$rm->rm_bd_id     	 = $rm_bd_id;
                $rm->rm_bdtype_id    = $rm_bdtype_id;
                $rm->rm_status_id    = $rm_status_id;
				$rm->update_room_detail();

			}else if($this->input->post('method')=="add"){
				// echo"ttttttttt";
				// die;

                $rm->rm_name   	 	 = $rm_name;
                $rm->rm_no   		 = $rm_no;
                $rm->rm_floor        = $rm_floor;
                $rm->rm_capacity     = $rm_capacity;
                $rm->rm_area         = $rm_area;
                $rm->rm_dpid     	 = $rm_dpid;
                // $rm->rm_fmst_id      = $rm_fmst_id;
                $rm->rm_fmst_id      = 0;
				$rm->rm_bd_id     	 = $bd_id;
                $rm->rm_bdtype_id    = $rm_bdtype_id;
                $rm->rm_status_id    = $rm_status_id;

				// echo $rm->rm_name;
				// echo "<br>";
				// echo $rm->rm_no;
				// echo "<br>";
				// echo $rm->rm_floor;
				// echo "<br>";
				// echo $rm->rm_capacity;
				// echo "<br>";
				// echo $rm->rm_dpid;
				// echo "<br>";
				// echo $rm->rm_fmst_id;
				// echo "<br>";
				// echo $rm->rm_bd_id;
				// echo "<br>";
				// echo $rm->rm_bdtype_id;
				// die;

				$rm->insert_room_detail();
			}
			// var_dump($this->input->post('saveBO'));die;
			redirect($this->config->item('eqs_folder').'building_room');

    }
    }

    function createRoom(){
		$this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
		$bd = $this->bd;
		$this->load->model($this->config->item('eqs_folder').'M_eqs_room','rm');
		$rm = $this->rm;
		header ('Content-type: text/html; charset=utf-8');

		$bd_id = $this->input->post('bd_id');

		$check_type_bd	= $bd->get_options_TypeBd();

		$op_bdtype	=	$bd->get_options_fmstTypeBd();

		$check_status_bd = $bd->get_options_StatusBd();

		$check_room	= $rm->get_check_room($bd_id);

		$check_room_by_bd_id	= $rm->get_check_room_by_bd_id($bd_id);

		$count_total_room_by_bd_id  = $check_room_by_bd_id->row()->count_room;
		$count_total_room = $check_room->row()->bd_amount_room;


		if($count_total_room == $count_total_room_by_bd_id){
			echo "<script>alert('มีห้องครบแล้ว');</script>";
		}
		else{
		// print_r($check_type_bd->num_rows());die;

			echo"<br>";
			echo "<form action='".site_url($this->config->item('eqs_folder')."building_room/saveBuilding")."' method='post' id='form_building'>";

			echo "<div class='form-group'>";

				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
						echo "<label class='pull-right'><strong>เพิ่มห้อง</strong></label>";
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   echo"<br>";

				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
								echo "<label class='pull-right'><strong>ชื่อห้อง</strong> <font color='red'><b>*</b></font></label>";
							echo "</div>";
							echo "<div class='col-xs-3'>";
								echo "<input type='text' id='rm_name' name='rm_name' class='form-control' placeholder='ชื่อห้อง' validate /> ";
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   echo"<br>";

				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
								echo "<label class='pull-right'><strong>หมายเลขห้อง</strong></label>";
							echo "</div>";
							echo "<div class='col-xs-3'>";
								echo "<input type='text' id='rm_no' name='rm_no' class='form-control' placeholder='หมายเลขห้อง' /> ";
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   echo"<br>";

				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
								echo "<label class='pull-right'><strong>ชั้นที่</strong></label>";
							echo "</div>";
							echo "<div class='col-xs-3'>";
								echo "<input type='text' id='rm_floor' name='rm_floor' class='form-control' placeholder='ชั้นที่' /> ";
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   echo"<br>";

				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
								echo "<label class='pull-right'><strong>ความจุห้อง/คน</strong></label>";
							echo "</div>";
							echo "<div class='col-xs-3'>";
								echo "<input type='text' id='rm_capacity' name='rm_capacity' class='form-control' placeholder='ความจุห้อง/คน' /> ";
								echo "<input type='hidden' id='bd_id' name='bd_id' class='form-control' value='".$bd_id."'/> ";
								echo "<input type='hidden' id='method' name='method' class='form-control' value='add'/> ";
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   echo"<br>";
				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
								echo "<label class='pull-right'><strong>พื้นที่ห้อง (ตรว.)</strong></label>";
							echo "</div>";
							echo "<div class='col-xs-3'>";
								echo "<input type='text' id='rm_area' name='rm_area' class='form-control' placeholder='พื้นที่ห้อง (ตรว.)' /> ";
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   echo"<br>";
				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
								echo "<label class='pull-right'><strong>ประเภทการใช้สอย</strong></label>";
							echo "</div>";
							echo "<div class='col-xs-3'>";
								echo form_dropdown('rm_bdtype_id', $check_type_bd, '', "style='width:100% !important' class='form-control' id='rm_bdtype_id'");
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   echo"<br>";
				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-xs-5'>";
								echo "<label class='pull-right'><strong>สถานะ</strong></label>";
							echo "</div>";
							echo "<div class='col-xs-3'>";
								echo form_dropdown('rm_status_id', $check_status_bd, '', "style='width:100% !important' class='form-control' id='rm_status_id'");
							echo "</div>";
						echo "</div>";
				   echo "</div>";

				   // echo"<br>";

				   // echo "<div class='row'>";
						// echo "<div class='form-group'>";
							// echo "<div class='col-xs-2'>";
								// echo "<label class='pull-right'><strong>ประเภทครุภัณฑ์</strong></label>";
							// echo "</div>";
							// echo "<div class='col-xs-3'>";
								// echo form_dropdown('rm_fmst_id',$op_bdtype, '', "style='width:100% !important' class='form-control' id='rm_fmst_id'");
							// echo "</div>";
						// echo "</div>";
				   // echo "</div>";

				   echo"<br>";

				   echo"<br>";

				   echo "<div class='row'>";
						echo "<div class='form-group'>";
							echo "<div class='col-sm-12'>";
								echo"<input class='btn btn-danger btn_iserl tooltips pull-left' type='button'  value='ยกเลิก' onClick=\"clearFrom('model','$bd_id')\" />";
							
								echo"<input class='btn btn-success btn_iserl tooltips pull-right' type='submit' id='saveBO2' name='saveBO2' value='บันทึก'  onclick='return validate_form(\"form_building\")'/>";
							echo "</div>";
					echo "</div>";
				   echo "</div>";
			echo "</div>";
			echo "</form>";
		}

    }

    function editRoom(){
	$this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
	$bd = $this->bd;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_room','rm');
	$rm = $this->rm;

    $rm_id = $this->input->post("rm_id");
	$rm_name = $this->input->post("rm_name");
	$rm_no = $this->input->post("rm_no");
	$rm_floor = $this->input->post("rm_floor");
	$rm_capacity = $this->input->post("rm_capacity");
	$rm_area = $this->input->post("rm_area");
	$rm_fmst_id = $this->input->post("rm_fmst_id");
	$rm_bd_id = $this->input->post("rm_bd_id");
	$rm_bdtype_id = $this->input->post("rm_bdtype_id");
	$rm_status_id = $this->input->post("rm_status_id");

	$op_bdtype_name	=	$bd->get_options_TypeBd();
	$op_status_name = $bd->get_options_StatusBd();

	$dType = $this->input->post("dType");

        header ('Content-type: text/html; charset=utf-8');

		// echo "<form action='".site_url($this->config->item('eqs_folder')."Building/saveBuilding")."' method='post'>";

		// echo "<td>";
		// echo "แก้ไขห้อง";
		// echo "</td>";

		echo "<input type='hidden' id='edit_rm_id' name='rm_id' class='form-control' value='".$rm_id."'/> ";
		echo "<input type='hidden' id='edit_rm_fmst_id' name='rm_fmst_id' class='form-control' value='".$rm_fmst_id."'/> ";
		echo "<input type='hidden' id='edit_rm_bd_id' name='rm_bd_id' class='form-control' value='".$rm_bd_id."'/> ";
		echo "<input type='hidden' id='method' name='method' class='form-control' value='edit'/> ";

		echo"<td>";
		echo "<b>ชื่อห้อง</b>";
		echo "<input type='text' id='edit_rm_name' name='rm_name' class='form-control' placeholder='ชื่อห้อง'  title='ชื่อห้อง' value='".$rm_name."'/> ";
		echo"</td>";

		echo"<td>";
		echo "<b>หมายเลขห้อง</b>";
		echo "<input type='text' id='edit_rm_no' name='rm_no' class='form-control' placeholder='หมายเลขห้อง'  title='หมายเลขห้อง'  value='".$rm_no."'/> ";
		echo"</td>";

		echo"<td>";
		echo "<b>ชั้นที่</b>";
		echo "<input type='text' id='edit_rm_floor' name='rm_floor' class='form-control' placeholder='ชั้นที่'  title='ชั้นที่'  value='".$rm_floor."'/> ";
		echo"</td>";

		echo"<td>";
		echo "<b>ความจุห้อง</b>";
		echo "<input type='text' id='edit_rm_capacity' name='rm_capacity' class='form-control' placeholder='ความจุห้อง' title='ความจุห้อง'  value='".$rm_capacity."'/> ";
		echo"</td>";

		echo"<td>";
		echo "<b>พื้นที่ห้อง (ตรว.)</b>";
		echo "<input type='text' id='edit_rm_area' name='rm_area' class='form-control' placeholder='พื้นที่ห้อง (ตรว.)' title='พื้นที่ห้อง (ตรว.)'  value='".$rm_area."'/> ";
		echo"</td>";

		echo"<td>";
		echo"<b>ประเภทอาคาร </b>";
		echo form_dropdown('rm_bdtype_id', $op_bdtype_name, (isset($rm_bdtype_id)) ? $rm_bdtype_id : '', "style='width:100% !important' class='form-control' id='edit_rm_bdtype_id' ");
		echo"</td>";

		echo"<td>";
		echo"<b>สถานะ </b>";
		echo form_dropdown('rm_status_id', $op_status_name, (isset($rm_status_id)) ? $rm_status_id : '', "style='width:100% !important' class='form-control' id='edit_rm_status_id' ");
		echo"</td>";

		// echo "<td style='background-color:#ffffff;text-align:center;' class='tdAction'>";
		// echo"<input class='btn btn-inverse' type='button'  value='ยกเลิก' onClick=\"clearFrom('model','$rm_id')\" />";
		// echo"&nbsp;";
		// echo"<input class='btn btn-success' type='submit' id='saveBO' name='saveBO' value='บันทึก'  onclick='edittypebuilding();'  />";
		// echo "</td>";

		echo"<td>";
		echo"<center>";
		echo"<br>";
		echo"<a class='btn btn-success-alt btn_check_iserl tooltips ti ti-check' title='คลิกปุ่มเพื่อบันทึกข้อมูล' type='submit' id='saveBO' name='saveBO' onclick='editroombuilding();'  > </a>";
		echo"&nbsp;";
		echo"<a class='btn btn-danger-alt tooltips ti ti-close' title='คลิกปุ่มเพื่อยกเลิกข้อมูล' type='button'  onClick=\"clearFrom('model','$rm_id')\"></a>";
		echo"</center>";
		echo"</td>";

    }

    function delete_Building(){
	$this->load->model($this->config->item('eqs_folder').'M_eqs_building','bd');
	$bd = $this->bd;
	$this->load->model($this->config->item('eqs_folder').'M_eqs_equipments','eqs');
	$eqs = $this->eqs;
		$bd->bd_id 			= trim($this->input->post('bd_id'));
		$eqs->eqs_id		= trim($this->input->post('bd_eqs_id'));
		$bd->delete_room();
		$eqs->set_active('N');
		// $eqs->delete();
	redirect($this->config->item('eqs_folder').'building_room');
    }

	function delete_Room(){
	$this->load->model($this->config->item('eqs_folder').'M_eqs_room','rm');
	$rm = $this->rm;
		$rm_id = trim($this->input->post('rm_id'));
		$rm->rm_id = $rm_id;
		$rm->delete();
	redirect($this->config->item('eqs_folder').'building_room');
    }

    function report_building(){
    $this->load->model($this->config->item('eqs_folder')."M_eqs_equipments","eqs");
    $this->eqs->eqs_dpId = $this->session->userdata('UsDpID');

    $eqs_building_total = $this->eqs->get_amount_eqs_building_by_dp_id();

    $data["eqs_building_total"] = $eqs_building_total;


    $testg = $this->eqs->get_eqs_building_total_by_dp_id();
		// print_r($testg);die;
        $data["testg"] = $testg;

    $rs_fmst = $this->eqs->get_eqs_fmst_building_by_dpId();

     $gen_data_item_t = "";
        $id=0;
        foreach($rs_fmst->result() as $row){
            $fmst_id[$id] = $row->fmst_id;
            // gen_data_item_t ใช้เก็บคำและค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,price,date,expDate,status
            //$gen_data_item = array();
            $rs_item_table = $this->eqs->get_eqs_building_item_table($fmst_id[$id]);
                $gen_data_item_t .= "[";
                foreach($rs_item_table->result() as $row){
                    //$gen_data_item[]  = array('name'=>$row->eqs_name,'number'=>$row->eqs_code_old,'price'=>number_format($row->eqs_price),'date'=>splitDateDb3($row->eqs_buydate),'expDate'=>splitDateDb3($row->eqs_expiredate),'status'=>eqs_get_status($row->eqs_status));
                    $gen_data_item_t .= "{name:";
                    $gen_data_item_t .= "'".$row->eqs_name."'";
                    $gen_data_item_t .= ",number:";
                    $gen_data_item_t .= "'".$row->eqs_code_old."'";
                    $gen_data_item_t .= ",price:";
                    $gen_data_item_t .= "'".number_format($row->eqs_price, 2)."'";
                    $gen_data_item_t .= ",area:";
                    $gen_data_item_t .= "'".$row->bd_area."'";
                    $gen_data_item_t .= ",date:";
                    $gen_data_item_t .= "'".splitDateDb3($row->eqs_buydate,"/")."'";
                    $gen_data_item_t .= ",expDate:";
                    $gen_data_item_t .= "'".splitDateDb3($row->eqs_expiredate,"/")."'";
                    $gen_data_item_t .= ",status:";
                    // $gen_data_item_t .= "'".$row->eqs_status."'";
                    $status = "";
                    if($row->eqs_status == "Y"){
                    $status = 'ใช้งานได้';
                    }
                    else if($row->eqs_status == "R"){
                    $status = 'ชำรุด';
                    }
                    else if($row->eqs_status == "S"){
                    $status = 'จำหน่าย';
                    }
                    else if($row->eqs_status == "B"){
                    $status = 'ถูกยืม';
                    }
                    else if($row->eqs_status == "N"){
                    $status = 'ไม่ได้ใช้งาน';
                    }
                    $gen_data_item_t .= "'".$status."'";

                    $gen_data_item_t .= "}";
                    $gen_data_item_t .= ",";
                }
                    $gen_data_item_t .= "]";
                    $gen_data_item_t .= ",";
            //$gen_datatable[$id] = $gen_data_item;
            $id++;
        }
        $data['gen_data_item_t'] = $gen_data_item_t;






        $testg2 = $this->eqs->get_eqs_building_total_by_dp_id_2();
		// print_r($testg2);die;
        $data["testg2"] = $testg2;

    $rs_fmst2 = $this->eqs->get_eqs_fmst_building_by_dpId_2();

     $gen_data_item_t2 = "";
        $id=0;
        foreach($rs_fmst2->result() as $row){
            $bd_id[$id] = $row->bd_id;
            // gen_data_item_t2 ใช้เก็บคำและค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,price,date,expDate,status
            //$gen_data_item = array();
            $rs_item_table2 = $this->eqs->get_eqs_building_item_table_2($bd_id[$id]);
                $gen_data_item_t2 .= "[";
                foreach($rs_item_table2->result() as $row){
                    //$gen_data_item[]  = array('name'=>$row->eqs_name,'number'=>$row->eqs_code_old,'price'=>number_format($row->eqs_price),'date'=>splitDateDb3($row->eqs_buydate),'expDate'=>splitDateDb3($row->eqs_expiredate),'status'=>eqs_get_status($row->eqs_status));
                    $gen_data_item_t2 .= "{name:";
                    $gen_data_item_t2 .= "'".$row->eqs_name."'";
                    $gen_data_item_t2 .= ",number:";
                    $gen_data_item_t2 .= "'".$row->eqs_code_old."'";
                    $gen_data_item_t2 .= ",price:";
                    $gen_data_item_t2 .= "'".number_format($row->eqs_price, 2)."'";
                    $gen_data_item_t2 .= ",bdtype_name:";
                    $gen_data_item_t2 .= "'".$row->bdtype_name."'";
                    $gen_data_item_t2 .= ",area:";
                    $gen_data_item_t2 .= "'".$row->bdd_area."'";
                    $gen_data_item_t2 .= ",date:";
                    $gen_data_item_t2 .= "'".splitDateDb3($row->eqs_buydate,"/")."'";
                    $gen_data_item_t2 .= ",expDate:";
                    $gen_data_item_t2 .= "'".splitDateDb3($row->eqs_expiredate,"/")."'";
                    $gen_data_item_t2 .= ",status:";
                    // $gen_data_item_t2 .= "'".$row->eqs_status."'";
                    $status = "";
                    if($row->eqs_status == "Y"){
                    $status = 'ใช้งานได้';
                    }
                    else if($row->eqs_status == "R"){
                    $status = 'ชำรุด';
                    }
                    else if($row->eqs_status == "S"){
                    $status = 'จำหน่าย';
                    }
                    else if($row->eqs_status == "B"){
                    $status = 'ถูกยืม';
                    }
                    else if($row->eqs_status == "N"){
                    $status = 'ไม่ได้ใช้งาน';
                    }
                    $gen_data_item_t2 .= "'".$status."'";

                    $gen_data_item_t2 .= "}";
                    $gen_data_item_t2 .= ",";
                }
                    $gen_data_item_t2 .= "]";
                    $gen_data_item_t2 .= ",";
            //$gen_datatable[$id] = $gen_data_item;
            $id++;
        }
        $data['gen_data_item_t2'] = $gen_data_item_t2;



		$testg3 = $this->eqs->get_eqs_building_total_by_dp_id_3();
		// print_r($testg2);die;
        $data["testg3"] = $testg3;

    $rs_fmst3 = $this->eqs->get_eqs_fmst_building_by_dpId_3();

     $gen_data_item_t3 = "";
        $id=0;
        foreach($rs_fmst3->result() as $row){
            $bdtype_name[$id] = $row->bdtype_name;
            // gen_data_item_t2 ใช้เก็บคำและค่าต่างๆของครุภัณฑ์โดยประกอบไปด้วย name,number,price,date,expDate,status
            //$gen_data_item = array();
            $rs_item_table3 = $this->eqs->get_eqs_building_item_table_3($bdtype_name[$id]);
                $gen_data_item_t3 .= "[";
                foreach($rs_item_table3->result() as $row){
                    //$gen_data_item[]  = array('name'=>$row->eqs_name,'number'=>$row->eqs_code_old,'price'=>number_format($row->eqs_price),'date'=>splitDateDb3($row->eqs_buydate),'expDate'=>splitDateDb3($row->eqs_expiredate),'status'=>eqs_get_status($row->eqs_status));
                    $gen_data_item_t3 .= "{name:";
                    $gen_data_item_t3 .= "'".$row->eqs_name."'";
                    $gen_data_item_t3 .= ",number:";
                    $gen_data_item_t3 .= "'".$row->eqs_code_old."'";
                    $gen_data_item_t3 .= ",price:";
                    $gen_data_item_t3 .= "'".number_format($row->eqs_price, 2)."'";
                    $gen_data_item_t3 .= ",bdtype_name:";
                    $gen_data_item_t3 .= "'".$row->bdtype_name."'";
                    $gen_data_item_t3 .= ",area:";
                    $gen_data_item_t3 .= "'".$row->bdd_area."'";
                    $gen_data_item_t3 .= ",date:";
                    $gen_data_item_t3 .= "'".splitDateDb3($row->eqs_buydate,"/")."'";
                    $gen_data_item_t3 .= ",expDate:";
                    $gen_data_item_t3 .= "'".splitDateDb3($row->eqs_expiredate,"/")."'";
                    $gen_data_item_t3 .= ",status:";
                    // $gen_data_item_t2 .= "'".$row->eqs_status."'";
                    $status = "";
                    if($row->eqs_status == "Y"){
                    $status = 'ใช้งานได้';
                    }
                    else if($row->eqs_status == "R"){
                    $status = 'ชำรุด';
                    }
                    else if($row->eqs_status == "S"){
                    $status = 'จำหน่าย';
                    }
                    else if($row->eqs_status == "B"){
                    $status = 'ถูกยืม';
                    }
                    else if($row->eqs_status == "N"){
                    $status = 'ไม่ได้ใช้งาน';
                    }
                    $gen_data_item_t3 .= "'".$status."'";

                    $gen_data_item_t3 .= "}";
                    $gen_data_item_t3 .= ",";
                }
                    $gen_data_item_t3 .= "]";
                    $gen_data_item_t3 .= ",";
            //$gen_datatable[$id] = $gen_data_item;
            $id++;
        }
        $data['gen_data_item_t3'] = $gen_data_item_t3;

	$this->output($this->config->item('eqs_folder').'v_report_building',$data);
    }

    function createBuilding($dType,$bd_id){
		$this->load->model($this->config->item('eqs_folder').'M_department','dept');
		$dept = $this->dept;
		// $this->load->model($this->config->item('eqs_folder').'M_person','ps');
		// $ps = $this->ps;
			// $ps->ps_id  	= $this->session->userdata('UsPsCode');
			// $ps->get_by_key(true);
			// $psd_dp_id	 = $ps->psd_dp_id;
			$psd_dp_id	 = $this->session->userdata('UsDpID');
			$op_dept = $dept->get_optionsByGroup($psd_dp_id,$dept->getDeptGroupByFlag('Y',$psd_dp_id),'0');

        header ('Content-type: text/html; charset=utf-8');
        echo"<div class='form-horizontal'>";
            echo"<div class='row'>";
                echo"<div class='form-group'>";
                echo"<label class='col-sm-3 control-label'>เพิ่มข้อมูลห้อง</label>";
                    echo"<div class='col-sm-4'>";
                        echo"<input type='text' id='rm_name' name='rm_name' class='form-control' />";
                    echo"</div>";
                echo"</div>";
            echo"</div>";

            echo"<div class='row'>";
                echo"<div class='form-group'>";
                    echo"<label for='focusedinput' class='col-sm-3 control-label'>ขนาดความจุห้อง</label>";
                    echo"<div class='col-sm-2'>";
                        echo"<input type='text' id='rm_capacity' name='rm_capacity' class='form-control' />";
                    echo"</div>";
                    echo"<div class='col-sm-2'>";
                        echo"<p>คน</p>";
                    echo"</div>";
                echo"</div>";
            echo"</div>";

            echo "<div class='row'>";
                echo"<div class='form-group'>";
                echo"<label class='col-sm-3 control-label'>หน่วยงานที่รับผิดชอบ </label>";
                    echo"<div class='col-sm-4'>";
                        echo form_dropdown('deptId', $op_dept, '', "style='width:100% !important' id='deptId'");
                    echo"</div>";
                echo"</div>";
            echo"</div>";

            echo"<div class='row'>";
                echo"<div class='col-sm-12'>";
                    echo"<div class='btn-toolbar'>";
                        echo"<input type='hidden' id='bd_id' name='bd_id' value='$bd_id' />";
                        echo"<input class='btn btn-inverse' type='button' value='ยกเลิก' onClick=\"clearFrom('room','$bd_id')\" />";
                        echo"<input class='btn btn-success' type='submit' id='saveB' name='saveB' value='บันทึก' />";
                    echo"</div>";
                echo"</div>";
            echo"</div>";
        echo"</div>";

    }

}
