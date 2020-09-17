<?php $row = (isset($qu_ed)) ? $qu_ed->row() : null;?>
<script language="javascript">
$(document).ready(function(){
    $("#fmst_id").select2();
    $(".bd_type_id").select2();
    $("#deptId").select2();
    $("#eqs_bgt_id").select2();
    $("#eqs_mt_id").select2();
    $("#status").select2();
	$('#datepicker_1').datepicker();

	get_eqs_code();
});
function checkSale(){
  if($('#status').val() == 'S'){
    $('#dateSale').show();
    $('#datepicker_1').datepicker();
  }else{
    $('#dateSale').hide();
  }
}
function editClick(bd_id){
	document.getElementById("bd_id").value = bd_id;
	document.getElementById("form_insert_building").action = 'building_room';
	document.getElementById("form_insert_building").submit();
    $("#deptId").select2();
}

function delClick(bd_id,bd_eqs_id){
    bootbox.confirm({
    title: "<div class='modal-header panel_modal_iserl'>ยืนยันการลบข้อมูล</div>",
      message: "<div style='text-align:center;'>คุณต้องการลบข้อมูลใช่หรือไม่ ?</div>",


    buttons: {
        confirm: {
            label: 'ยืนยัน',
            className: 'btn btn-success btn_iserl tooltips <?php echo $this->config->item('cls_success') ?>', /*fern*/ 
            attribute:"คลิกปุ่มเพื่อยืนยัน"
            
        },
        cancel: {
            label: 'ยกเลิก',
            className: 'btn btn-danger btn_iserl tooltips <?php echo $this->config->item('cls_danger') ?> pull-left', /*fern*/  
        }
    },
    callback: function(result){
        if(result){
       document.getElementById("bd_eqs_id").value = bd_eqs_id;

            document.getElementById("form_insert_building").action = 'building_room/delete_Building';
            document.getElementById("form_insert_building").submit();
      }
    }
  });
$(".modal-header").css({"padding": "0px"});
$(".bootbox-close-button").css({"padding-right": "20px", "padding-top": "20px"});
$(".panel_modal_iserl").css({"padding": "20px"}); 
$("#deptId").select2();
}


function clearFrom(dType,bd_id){
	document.getElementById("form_insert_building").action = 'building_room';
	document.getElementById("form_insert_building").submit();
    $("#deptId").select2();
}

function addRoom(tagid , bd_id){
	$.ajax({
	  type: "POST",
	  url: "<?php echo site_url($this->config->item('eqs_folder')."building_room/createRoom")?>",
	  data: {bd_id: bd_id }
	})
	.done(function( msg ) {
        if(msg==0){
    bootbox.alert({
     title: "<div class='modal-header panel_modal_iserl'>เพิ่มข้อมูลห้อง</div>",
      message: "<div>ไม่สามารถเพิ่มข้อมูลห้องได้ เนื่องจากอาคารมีห้องครบแล้ว</div>",
      buttons: {
        ok: {
            label: 'ตกลง',
            className: 'btn btn-success btn_iserl tooltips" <?php echo $this->config->item('cls_success') ?> ',
                
        }
      }
    });
    $(".modal-header").css({"padding": "0px"});
$(".bootbox-close-button").css({"padding-right": "20px", "padding-top": "20px"});
$(".panel_modal_iserl").css({"padding": "20px"});
        }else{
        $("#"+tagid+bd_id).show();
        $("#"+tagid+bd_id).html(msg);
        }
	});
}

function editRoom(dType_R,rm_id,rm_name,rm_no,rm_floor,rm_capacity,rm_area,rm_fmst_id,rm_bd_id,rm_bdtype_id,rm_status_id){
	$.ajax({
	  type: "POST",
	  url: "<?php echo site_url($this->config->item('eqs_folder')."building_room/editRoom")?>",
	  data: { dType: dType_R, rm_id: rm_id , rm_name: rm_name, rm_no: rm_no, rm_floor: rm_floor, rm_capacity: rm_capacity, rm_area: rm_area, rm_fmst_id: rm_fmst_id, rm_bd_id: rm_bd_id, rm_bdtype_id: rm_bdtype_id, rm_status_id: rm_status_id}
	})
	.done(function( msg ) {
		$("#"+dType_R+rm_id).html(msg);
	});
}

function delRoom(rm_id){
        bootbox.confirm({
    title: "<div class='modal-header panel_modal_iserl'>ยืนยันการลบข้อมูล</div>",
      message: "<div style='text-align:center;'>คุณต้องการลบข้อมูลใช่หรือไม่ ?</div>",


    buttons: {
        confirm: {
            label: 'ยืนยัน',
            className: 'btn btn-success btn_iserl tooltips <?php echo $this->config->item('cls_success') ?>', /*fern*/ 
            attribute:"คลิกปุ่มเพื่อยืนยัน"
            
        },
        cancel: {
            label: 'ยกเลิก',
            className: 'btn btn-danger btn_iserl tooltips <?php echo $this->config->item('cls_danger') ?> pull-left', /*fern*/  
        }
    },
    callback: function(result){
        if(result){
      document.getElementById('rm_id').value = rm_id;
            document.getElementById("form_insert_building").action = 'building_room/delete_Room';
            document.getElementById("form_insert_building").submit();
      }
    }
  });
$(".modal-header").css({"padding": "0px"});
$(".bootbox-close-button").css({"padding-right": "20px", "padding-top": "20px"});
$(".panel_modal_iserl").css({"padding": "20px"}); 
}

//----------------------------------------------------------------
function addRow() {
    var div = document.createElement('div');

    div.className = 'row';

    div.innerHTML = '<input type="text" name="name" value="" />\
        <input type="text" name="value" value="" />\
        <input type="button" value="-" onclick="removeRow(this)">';

     document.getElementById('content').appendChild(div);
}

function removeRow(input) {
    document.getElementById('content').removeChild( input.parentNode );
}
function editroombuilding() {
    var method = document.getElementById('method').value;
    var rm_id = document.getElementById('edit_rm_id').value;
	var rm_name = document.getElementById('edit_rm_name').value;
	var rm_no = document.getElementById('edit_rm_no').value;
	var rm_floor = document.getElementById('edit_rm_floor').value;
	var rm_capacity = document.getElementById('edit_rm_capacity').value;
    var rm_area = document.getElementById('edit_rm_area').value;
	var rm_fmst_id = document.getElementById('edit_rm_fmst_id').value;
	var rm_bd_id = document.getElementById('edit_rm_bd_id').value;
    var rm_bdtype_id = document.getElementById('edit_rm_bdtype_id').value;
    var rm_status_id = document.getElementById('edit_rm_status_id').value;
	// alert(rm_bdtype_id);
	post("<?php echo site_url("/".$this->config->item('eqs_folder')."building_room/saveBuilding");?>", {rm_id:rm_id, method:method, rm_name:rm_name, rm_no:rm_no, rm_floor:rm_floor, rm_capacity:rm_capacity, rm_area:rm_area, rm_fmst_id:rm_fmst_id, rm_bd_id:rm_bd_id, rm_bdtype_id:rm_bdtype_id, rm_status_id:rm_status_id});
}
function get_eqs_code(){
  //num_start

	var eqs_code = document.getElementById('eqs_code_old').value;
	var check = "<?php echo (isset($row->eqs_code_old)) ? $row->eqs_code_old : 0;?>";
	if(check != eqs_code){
	  if(eqs_code.replace(/\s+/, "") != ""){
		$.post("<?php echo site_url($this->config->item("eqs_folder")."Insert_eqs/get_eqs_code"); ?>", {eqs_code_old: eqs_code}, function(result){
		  //console.log(result);
		  if(result[0].count_eqs_code != 0){
			//bootbox.alert("หมายครุภัณฑ์นี้มีอยู่แล้วในระบบ");
			$('#div_eqs_code').addClass("has-error");
			document.getElementById('alert_eqs_code').innerHTML = 'หมายเลขครุภัณฑ์ '+eqs_code+' มีอยู่แล้วในระบบ';
			document.getElementById('alert_eqs_code').style.color = 'rgb(221, 25, 29)';
			document.getElementById('btnSubmit').disabled = true;

		  }else{
			$('#div_eqs_code').removeClass("has-error");
			document.getElementById('alert_eqs_code').innerHTML = 'สามารถใช้หมายเลขครุภัณฑ์นี้ได้';
			document.getElementById('alert_eqs_code').style.color = 'rgb(124, 179, 66)';
			document.getElementById('btnSubmit').disabled = false;
		  }
		},"json");
	  }else{
		$('#div_eqs_code').removeClass("has-error");
		document.getElementById('alert_eqs_code').innerHTML = '';
		document.getElementById('btnSubmit').disabled = false;
	  }
  }else{
		$('#div_eqs_code').removeClass("has-error");
		document.getElementById('alert_eqs_code').innerHTML = 'สามารถใช้หมายเลขครุภัณฑ์นี้ได้';
		document.getElementById('alert_eqs_code').style.color = 'rgb(124, 179, 66)';
		document.getElementById('btnSubmit').disabled = false;
  }
}
//------------------------------------------------------------------
</script>

<div class="row"><!-- เพิ่มข้อมูลอาคาร -->
    <div class="col-md-12">
		<div class="panel panel-info" data-widget='{"draggable": "false"}'>
      <div class="panel-heading panel_heading_iserl"> <!-- fern -->
                <h2><?php echo $tb_name;?></h2>
                <div data-actions-container="" data-action-collapse='{"target": ".panel-body"}' style="float:right"></div>
      </div>
			<div class="panel-body" <?php echo (isset($row->eqs_fmst_id)) ? '' : 'style="display: none;"'; ?>>
            <?php echo form_open(site_url("/".$this->config->item('eqs_folder')."building_room/saveBuilding"),array('id' => 'form_insert_building' , 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));?>

                <div class="row">
        					<div class="form-group">
                                <label class="col-sm-4 control-label">ประเภทครุภัณฑ์ <font color='red'><b>*</b></font></label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('fmst_id',$op_bdtype,(isset($row->eqs_fmst_id)) ? $row->eqs_fmst_id : '', "style='width:100% !important' id='fmst_id' onchange=\"get_fmnd(this.value,'fmrd_fmnd_id','fmrd_id')\" validate");?>
                                </div>
        					</div>
                </div>

                <div class="row">
        					<div class="form-group">
                                <label class="col-sm-4 control-label">ชื่ออาคาร <font color='red'><b>*</b></font></label>
                                <div class="col-sm-4">
        						<input type="text" id="eqs_name" name="eqs_name" class="form-control" placeholder="ชื่ออาคาร" value="<?php echo (isset($row->eqs_name)) ? $row->eqs_name : "";?>" validate/>
                                </div>
                  </div>
                </div>

               <div class="row">
        					<div class="form-group">
                                <label class="col-sm-4 control-label">ชื่อย่ออาคาร</label>
                                <div class="col-sm-4">
        						<input type="text" id="bd_name_abbr" name="bd_name_abbr" class="form-control" placeholder="ชื่อย่ออาคาร" value="<?php echo (isset($row->bd_name_abbr)) ? $row->bd_name_abbr : "";?>" />
                                </div>
                  </div>
                </div>

                <div class="row">
        					<div class="form-group">
                                <label class="col-sm-4 control-label">พื้นที่ใช้สอยทั้งหมด (ตรว.)<font color='red'><b>*</b></font></label>
                                <div class="col-sm-4">
        						<input type="text" id="bd_area" name="bd_area" class="form-control" placeholder="ตารางวา" value="<?php echo (isset($row->bd_area)) ? $row->bd_area : "";?>" validate/>
                                </div>
                  </div>
                </div>

                <?php /*
                <div id="content">
                <div class="row">
					<div class="form-group">
                        <label class="col-sm-4 control-label">ประเภทอาคาร <font color='red'><b>*</b></font></label>
                        <div class="col-sm-4">
                            <?php echo form_dropdown('bd_type_id',$op_bdtype_name,(isset($row->bdtype_id)) ? $row->bdtype_id : '', "style='width:100% !important' id='bd_type_id' class='bd_type_id' ");?>
                            <?php // bd_type ?>
                        </div>
                    </div>
                </div>
                </div>

                <div class="row">
					<div class="form-group">
                        <label class="col-sm-4 control-label">พื้นที่ใช้สอยของอาคาร</label>
                        <div class="col-sm-4">
						<input type="text" id="bdd_area" name="bdd_area" class="form-control" placeholder="ตารางวา" value="<?php echo (isset($row->bdd_area)) ? $row->bdd_area : "";?>" />
                        </div>
                    </div>
                </div>

                */ ?>

                <div class="row">
        					<div class="form-group">
                                <label class="col-sm-4 control-label">จำนวนชั้น <font color='red'><b>*</b></font></label>
                                <div class="col-sm-4">
        						<input type="text" id="bd_amount_floor" name="bd_amount_floor" class="form-control" placeholder="จำนวนชั้น" value="<?php echo (isset($row->bd_amount_floor)) ? $row->bd_amount_floor : "";?>" validate/>
                                </div>
                  </div>
                </div>

                <div class="row">
					<div class="form-group">
                        <label class="col-sm-4 control-label">จำนวนห้อง <font color='red'><b>*</b></font></label>
                        <div class="col-sm-4">
						<input type="text" id="bd_amount_room" name="bd_amount_room" class="form-control" placeholder="จำนวนห้อง" value="<?php echo (isset($row->bd_amount_room)) ? $row->bd_amount_room : "";?>" validate/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group" id = "div_eqs_code">
                        <label class="col-sm-4 control-label">หมายเลขครุภัณฑ์ <font color='red'><b>*</b></font></label>
                        <div class="col-sm-3">
                           <span id="ele_code"><input type="text" id="eqs_code_old" name="eqs_code_old" class="form-control" original-title="หมายเลขครุภัณฑ์" placeholder="หมายเลขครุภัณฑ์" value="<?php echo (isset($row->eqs_code_old)) ? $row->eqs_code_old : "";?>" onchange="get_eqs_code()" validate/></span>
                           <?php /*<span id="num_start"><input " type="text" id="num_start" name="num_start" class="form-control" original-title="เลขเริ่มต้น" placeholder="เลขเริ่มต้น" style="width:35%;" value="<?php echo (isset($row->num_start)) ? $row->num_start : "";?>"/></span> */ ?>
                        </div>
                        <div class="col-sm-5">
                            <p id = "alert_eqs_code"></p>
                        </div>
                    </div>
                </div>
				
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">เลขที่สินทรัพย์(GFMIS)</label>
                        <div class="col-sm-3">
							<span id="ele_code">
								<input type="text" id="eqs_gf" name="eqs_gf" class="form-control" original-title="เลขที่สินทรัพย์(GFMIS)" placeholder="เลขที่สินทรัพย์(GFMIS)" value="<?php echo (isset($row->eqs_gf)) ? $row->eqs_gf : "";?>" />
							</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-4 control-label">ราคา <font color='red'><b>*</b></font></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="eqs_price" name="eqs_price" placeholder="ราคา" value="<?php echo (isset($row->eqs_price)) ? $row->eqs_price : "" ;?>" validate>
                        </div>
                        <div class="col-sm-2">
                            <p>บาท</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                         <label class="col-sm-4 control-label">ประเภทเงิน <font color='red'><b>*</b></font></label>
                         <div class="col-sm-3">
                             <?php echo form_dropdown('eqs_bgt_id', $op_bgt,(isset($row->eqs_bg_id)) ? $row->eqs_bg_id : '', "style='width:100% !important' id='eqs_bgt_id' validate");?>
                         </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">วิธีการได้มา  <font color='red'><b>*</b></font></label>
                        <div class="col-sm-3">
                            <select id='eqs_mt_id' name='eqs_mt_id' style='width:100% !important' validate>
                                <option id='eqs_mt_id' name='eqs_mt_id' value=''>--เลือก--</option>
                                <?php
                                    // foreach ($headGroup->result() as $key => $value) {
                                    //     $eee = "";
                                    //
                                    //     if(isset($row->eqs_mt_id)){
                                    //         if($row->eqs_mt_id == $value->mt_id){
                                    //             $eee .= "selected";
                                    //         }
                                    //     }
                                    //     echo "<option value='$value->mt_id' ".$eee.">".$value->mt_name."</option>";
                                    //     foreach ($mtChild[$value->mt_id] as $key2 => $value2) {
                                    //     $ggg = "";
                                    //         if(isset($row->eqs_mt_id)){
                                    //         if($row->eqs_mt_id == $value2->mt_id){
                                    //             $ggg .= "selected";
                                    //         }
                                    //     }
                                    //         echo "<option value='$value2->mt_id' ".$ggg.">&nbsp&nbsp".$value2->mt_name."</option>";
                                    //     }
                                    // }
                                ?>
                                <?php foreach ($op_mt->result() as $key => $value) { ?>
                                        <option value="<?php echo $value->id ?>" <?php echo (isset($row->eqs_mt_id) && $row->eqs_mt_id==$value->id)?"selected":""; ?>><?php if($value->main_name != NULL){echo "$value->main_name/";} echo $value->sub_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">วันที่จัดซื้อ </label>
                        <div class="col-sm-3" id="div_calendar">
                            <input type="text" class="form-control" id="datepicker" name ="eqs_buydate"  data-date-format="dd/mm/yyyy" data-date-language="th-th" name="calendar" placeholder="ปฏิทิน" value="<?php echo (isset($row->eqs_buydate)?splitDateDb3($row->eqs_buydate,"/"):$temp);?>" validate>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">วันที่หมดอายุ </label>
                        <div class="col-sm-3" id="div_calendar">
                            <input type="text" class="form-control" id="datepicker-range" name ="eqs_expiredate"  data-date-format="dd/mm/yyyy" data-date-language="th-th" name="calendar" placeholder="ปฏิทิน" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">ปีหมดอายุ </label>
                        <div class="col-sm-1">
                            <input type="text" id="eqs_expireyear" name="eqs_expireyear" class="form-control" original-title="ปี" placeholder="ปี"  value="<?php echo (isset($row->eqs_expireyear)) ? $row->eqs_expireyear : "";?>"/>
                        </div>
                        <div class="col-sm-2">
                            <p>ปี</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">สถานะการใช้งาน <font color='red'><b>*</b></font></label>
                        <div class="col-md-2">
                          <?php if(isset($row->eqs_status) && $row->eqs_status == 'RP'){ ?>  ส่งซ่อม <input type="hidden" value="RP" name = "eqs_status"> <?php } else{ ?>
                          <select onchange="checkSale();" style="width: 100%" name = "eqs_status" id="status" validate>
                            <?php
                              foreach ($qu_eqs_status->result() as $value) {
                                if($value->status_key != 'RP'){?>
                              <option value="<?php echo $value->status_key; ?>" <?php if(isset($row->eqs_status) && ($value->status_key == $row->eqs_status)){echo " selected ";} ?> ><?php echo $value->status_name; ?></option>
                            <?php
                          }} ?>
                          </select>
                          <?php } ?>
                        </div>
                        <div style="display:none;" id = "dateSale">
                        <label class="col-sm-1 control-label">วันที่จำหน่าย</label>
                        <div class="col-sm-2">
                          <div class="input-group date" id="datepicker_1"  data-date-format="dd/mm/yyyy" data-date-language="th-th" >
                              <span class="input-group-addon"><i class="ti ti-calendar"></i></span>
                              <input type="text" class="form-control" value="<?php if(isset($row->eqs_distribute_date) && $row->eqs_distribute_date != "0000-00-00"){ echo splitDateDb3($row->eqs_distribute_date,'/'); } else{ echo getNowDateBuddish(); } ?>" id = 'saledate' name = 'eqs_distribute_date'>
                          </div>
                        </div>
                       </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">รายละเอียดเพิ่มเติม </label>
                        <div class="col-sm-5">
                        <textarea class="form-control" id="eqs_detail" name='eqs_detail' style='resize:none; width:100%; height:100px;' placeholder='รายละเอียดเพิ่มเติม'><?php echo (isset($row->eqs_detail)) ? $row->eqs_detail : "";?></textarea>
                       </div>
                    </div>
                </div>

                <div class="row">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">รูปภาพ </label>
                    <div class="col-sm-3">
                      <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;"></div>
                        <div>
                          <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                          <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="img_name" id="img_name"></span>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="btn-toolbar">
                            <input class="<?php echo $this->config->item('cls_clear'); ?> btn btn-inverse btn_iserl tooltips pull-left" title="คลิกปุ่มเพื่อเคลียร์ข้อมูล"  type="reset" id="btnClear" name="btnClear" value="เคลียร์"> <!-- fern -->
                            <input class="btn btn-danger btn_iserl tooltips pull-left" title="คลิกปุ่มเพื่อยกเลิกข้อมูล" href="<?php echo site_url($this->config->item('eqs_folder')."building_room")?>" type="submit" value="ยกเลิก"/><!-- fern --> 
                            <input class="<?php echo $this->config->item('cls_save'); ?> btn btn-success btn_iserl tooltips pull-right" title="คลิกปุ่มเพื่อบันทึกข้อมูล" type="submit" id="btnSubmit" name="btnSubmit" value="บันทึก" onclick="return validate_form('form_insert_building');" disabled/> <!-- fern -->
                            <input type="hidden" id="eqs_id" name="eqs_id" value="<?php echo (isset($row->eqs_id)) ? $row->eqs_id : "";?>" />
                            <input type="hidden" id="eqs_gf" name="eqs_gf" value="<?php echo (isset($row->eqs_gf)) ? $row->eqs_gf : "";?>" />
                            <input type="hidden" id="bd_id" name="bd_id" value="<?php echo (isset($row->bd_id)) ? $row->bd_id : "";?>" />
                            <input type="hidden" id="bdd_bdtype_id" name="bdd_bdtype_id" value="" />
                            <input type="hidden" id="rm_id" name="rm_id" value="" />
                            <input type="hidden" id="bd_eqs_id" name="bd_eqs_id" value="<?php echo (isset($row->bd_eqs_id)) ? $row->bd_eqs_id : "";?>" />
                        </div>
                    </div>
                </div>
            <?php form_close();?>
			</div>
		</div>
	</div>
</div><!-- END เพิ่มข้อมูลอาคาร -->


<div class="row"> <!-- Start ตารางแสดงเพิ่มข้อมูลอาคาร -->
    <div class="col-md-12">
      <div class="panel panel-default" data-widget='{"draggable": "false"}'>
			<div class="panel-heading panel_heading_iserl"> <!-- fern -->
            <?php if(!isset($flg_print)){?>
                <h2>ตารางแสดง<?php echo $tb_name;?></h2>
            <?php } ?>
            <div class="tooltips panel_tap_iserl" data-actions-container="" data-action-collapse='{"target": ".panel-body"}'></div>
            </div>
		 <div class="panel-body">
			<table class="table table-striped table-bordered table_iserl no-footer table-hover"> <!-- fern -->

				<thead>
					<tr style="width:100%;">
						<?php foreach ($col_name as $key => $value) { ?>
							<?php if($value == "ชื่ออาคาร"){ ?>
								<th style="width:20%;"><center><b><?php echo $value;?></b></center></th>
							<?php }else if($value == "ชื่อย่ออาคาร"){	?>
								<th style="width:15%;"><center><b><?php echo $value;?></b></center></th>
							<?php }else if($value == "พื้นที่ใช้สอย"){	?>
								<th style="width:10%;"><center><b><?php echo $value;?></b></center></th>
							<?php }else if($value == "จำนวนชั้น"){	?>
								<th colspan="2" style="width:20%;"><center><b><?php echo $value;?></b></center></th>
							<?php }else if($value == "จำนวนห้อง"){	?>
								<th style="width:15%;"><center><b><?php echo $value;?></b></center></th>
							<?php }else if($value == "ดำเนินการ"){	?>
								<th colspan="2" style="width:20%;"><center><b><?php echo $value;?></b></center></th>
							<?php }	?>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
				<?php
						$num_rows = 0;
						$i = 1;
					if (isset($qu_all) && ($qu_all->num_rows() > 0)) {
						$num_rows = $qu_all->num_rows();
						foreach ($qu_all->result() as $rowall) {
				?>
					<tr style="width:100%; background-color:#f2f2f2;" class="tr_building">
						<td style="width:20%;" onclick='$(".room_<?php echo $i; ?>").toggle(200);'><b><?php echo $rowall->eqs_name;?></b></td>
            <td style="width:15%;" onclick='$(".room_<?php echo $i; ?>").toggle(200);'><b><?php echo $rowall->bd_name_abbr;?></b></td>
						<td  align= "right"  style="width:10%;" onclick='$(".room_<?php echo $i; ?>").toggle(200);'><b><?php echo $rowall->bd_area;?></b></td>
            <td colspan="2" align= "right" style="width:20%;" onclick='$(".room_<?php echo $i; ?>").toggle(200);'><b><?php echo $rowall->bd_amount_floor;?></b></td>
						<td  align= "right" style="width:15%;" onclick='$(".room_<?php echo $i; ?>").toggle(200);'><b><?php echo $rowall->bd_amount_room;?></b></td>
						<td colspan="2" style="width:20%;"><center>
              <button type="button" onclick="addRoom('model','<?php echo $rowall->bd_id?>')"   class="btn btn-social btn-google btn_check_iserl tooltips fa fa-plus" title="คลิกปุ่มเพื่อเพิ่มข้อมูล"></button> <!-- fern -->
              <button type="button" onclick="editClick('<?php echo $rowall->bd_id;?>')"   class="btn btn-orange btn_check_iserl tooltips ti ti-pencil" title="คลิกปุ่มเพื่อแก้ไขข้อมูล"></button> <!-- fern -->
              <button type="button" onclick="delClick('<?php echo $rowall->bd_id;?>','<?php echo $rowall->bd_eqs_id;?>')" class="btn btn-danger btn_check_iserl tooltips ti ti-close" title="คลิกปุ่มเพื่อลบข้อมูล"></button></center> <!-- fern -->
            </td>
          </tr>
				<?php
						$rs_bd = $rm->rsflow_building_room('model_sub',$rowall->bd_id,$psd_dp_id);
							if($rs_bd->num_rows() > 0){
								foreach ($rs_bd->result() as $r) {
					?>
						<tr id='model_sub<?php echo $r->rm_id ?>' class="room_<?php echo $i; ?>" style="display:none; width:100%;">

							<td style="background-color:#ffffff;width:20%;">ชื่อห้อง :  <?php echo $r->rm_name;?></td>

							<?php if($r->rm_no ==""){ ?>
							<td style="background-color:#ffffff;width:15%;">หมายเลขห้อง :  - </td>
							<?php }else{ ?>
                            <td style="background-color:#ffffff;width:15%;">หมายเลขห้อง : <?php echo $r->rm_no;?></td>
							<?php }	?>

							<?php if($r->rm_floor ==0){ ?>
							<td style="background-color:#ffffff;width:10%;">ชั้นที่ : ไม่ได้ระบุ</td>
							<?php }else{ ?>
							<td style="background-color:#ffffff;width:10%;">ชั้นที่ : <?php echo $r->rm_floor;?></td>
							<?php }	?>

							<?php if($r->rm_capacity ==0){ ?>
							<td style="background-color:#ffffff;width:9%;">ความจุห้อง : ไม่ได้ระบุ</td>
							<?php }else{ ?>
							<td style="background-color:#ffffff;width:9%;">ความจุห้อง : <?php echo $r->rm_capacity;?> คน</td>
							<?php }	?>

							<?php if($r->rm_area ==0){ ?>
							<td style="background-color:#ffffff;width:11%;">พื้นที่ห้อง (ตรว.) : ไม่ได้ระบุ</td>
							<?php }else{ ?>
							<td style="background-color:#ffffff;width:11%;">พื้นที่ห้อง (ตรว.) : <?php echo $r->rm_area;?> ตรว.</td>
							<?php }	?>

							<?php if($r->bdtype_name ==""){ ?>
							<td style="background-color:#ffffff;width:15%;">ประเภท :  ไม่ได้ระบุ </td>
							<?php }else{ ?>
							<td style="background-color:#ffffff;width:15%;">ประเภท : <?php echo $r->bdtype_name;?></td>
							<?php }	?>

							<?php if($r->rm_status_id ==0){ ?>
							<td style="background-color:#ffffff;width:10%;">สถานะ : <br> ไม่ได้ระบุ </td>
							<?php }else{ ?>
							<td style="background-color:#ffffff;width:10%;">สถานะ : <br><?php echo $r->status_name;?></td>
							<?php }	?>

                            <td style="background-color:#ffffff;text-align:center;;width:10%;" class="tdAction">

                            <button type="button" onclick="editRoom('model_sub','<?php echo $r->rm_id;?>','<?php echo $r->rm_name;?>','<?php echo $r->rm_no;?>','<?php echo $r->rm_floor;?>','<?php echo $r->rm_capacity;?>','<?php echo $r->rm_area;?>','<?php echo $r->rm_fmst_id;?>','<?php echo $r->rm_bd_id;?>','<?php echo $r->rm_bdtype_id;?>','<?php echo $r->rm_status_id;?>')" class="btn btn-orange-alt btn_check_iserl tooltips ti ti-pencil" title="คลิกปุ่มเพื่อแก้ไขข้อมูล"></button> <!-- fern -->
							<button type="button" onclick="delRoom('<?php echo $r->rm_id;?>')" class="btn btn-danger-alt btn_check_iserl tooltips ti ti-close" title="คลิกปุ่มเพื่อลบข้อมูล"></button></center> <!-- fern -->
							</td>

                            <?php /*
                            <td style="background-color:#ffffff;text-align:center;" class="tdAction"><span onclick="editModel('model','<?php echo $r->bd2id?>')"><a><i class="fa fa-edit" title="แก้ไข"></i></a></span></td>
                            <td style="background-color:#ffffff;text-align:center;" class="tdAction"><span onClick="delModel('<?php echo $r->bd2id;?>')"><a><i class="fa fa-trash" title="ลบ"></i></a></span></td>
                            */?>

                        </tr>
					<?php		}
							}
						echo "<tr><td colspan='8' id='model".$rowall->bd_id."' style='background-color:#ffffff; display:none;' ></td></tr>"; /*fern*/
            $i++;
							}
						}
				?>
        </div>
				</tbody>
			</table>

        </form>
		</div>
		</div>
	</div>
	<!-- Start ตารางแสดงเพิ่มข้อมูลอาคาร -->
</div>
