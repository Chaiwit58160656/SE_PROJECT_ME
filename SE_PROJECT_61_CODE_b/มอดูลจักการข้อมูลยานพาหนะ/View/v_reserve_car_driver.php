<!-- 
	Nuttakit pangngom 58160659
 -->

<!-- ฟังก์ชัน-->
<?php
    function Time_Fn($strDate)// ฟังก์ชันแปลง วันที่ เดือน พศ ชัวโมง นาที
	{
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		return "$strHour:$strMinute";
    }
    function DateNum($strDate)// ฟังก์ชันแปลง วันที่ เดือน พศ 
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("m",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        
		return $strDay."/".$strMonth."/".$strYear;
    }
	function DateThai($strDate)// ฟังก์ชันแปลง วันที่ เดือน พศ 
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
    }
    function DatetimeThai($strDate)// ฟังก์ชันแปลง วันที่ เดือน พศ ชัวโมง นาที
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear $strHour:$strMinute";
	}
?><!-- จบฟังก์ชัน-->
<div class="panel panel-default"> 
		<div class="panel-heading panel_table_iserl">
			<h2>จัดการข้อมูลยานพาหนะ</h2>
		</div>
		<div class="panel-body">	
			<table class="table table-striped table-bordered table_iserl no-footer table-hover">
				<thead> 
					<tr>
						<th>ลำดับ</th>
						<th>ชื่อ-นามสกุล</th>
						<th>รายละเอียด</th>
						<th>วันที่เริ่มต้น</th>
						<th>วันที่สิ้นสุด</th>
						<th>ดำเนินการ</th>
					</tr>	
				</thead> 
			<tbody>
				<?php $index=1; foreach($data_table->result() as $dttable) {?>
				<tr>								
					<td style="text-align: center;"><?php echo $index++; ?></td>
					<td width="25%">
						<?php echo $dttable->pf_name.$dttable->ps_fname." ".$dttable->ps_lname;?>
					</td>
					<td> 
						<b>จุดประสงค์:</b> <?php echo $dttable->rsc_title?><br>
						<b>สถานที่:</b> <?php echo $dttable->rsc_place;?>
					</td>
					<td>
						<center>
						<!-- <option value="<?php echo $dttable->rsc_id;?>"><?php 

						$arr_rsc_date = explode(" ", $dttable->rsc_start_date);
						$rsc_date = $arr_rsc_date[0];
						$arr_rsc_ndate = explode("-", $rsc_date);
						$rsc_ndate = $arr_rsc_ndate[2]."/".$arr_rsc_ndate[1]."/".$arr_rsc_ndate[0];
						echo $rsc_ndate;

						?> </option> -->
						<?php echo DateThai($dttable->rsc_start_date);?>
						</center>
					</td>
					<td>
						<center>
						<!-- <option value="<?php echo $dttable->rsc_id;?>"><?php 
						$arr_rsc_edate = explode(" ", $dttable->rsc_end_date);
						$rsc_edate = $arr_rsc_edate[0];
						$arr_rsc_nedate = explode("-", $rsc_edate);
						$rsc_nedate = $arr_rsc_nedate[2]."/".$arr_rsc_nedate[1]."/".$arr_rsc_nedate[0];
						echo $rsc_nedate;
						?> </option> -->
						<?php echo DateThai	($dttable->rsc_end_date);?>
						</center>
					</td>
					<td align="center"> 
						<?php if($dttable->rsc_driver == 'Y'){?>
							<a><i class="btn btn-social btn-google btn_check_iserl tooltips fa fa-plus choose_driver" id="choose<?php echo $dttable->rsc_id ?>" data-id="<?php echo $dttable->rsc_id ?>" data-toggle="modal" data-target="#myModal"></i><br></a>
						<?php }else if($dttable->rsc_driver == 'N'){?>
							<a><i class="btn btn-social btn-google btn_check_iserl tooltips fa fa-plus choose_driver" id="choose<?php echo $dttable->rsc_id ?>" data-id="<?php echo $dttable->rsc_id ?>"  data-toggle="modal" data-target="#myModal2"></i><br></a>
						<?php } ?>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
	<div class="col-md-12"> <!--ส่วนกานดำเนิน-->
		<input class="btn btn-danger btn_iserl tooltips" type="button" value="ยกเลิก" onclick="goBack()"/>
    </div>    
	<div class="col-md-12" style="height:12px"></div>
</div><!--End panel home-->


<!-- Modal Use the car and driver -->
<div class="modal fade bs-example-modal-lg" id="myModal" style='background-color: #0000004d;' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%; height: 60%;">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading panel_modal_iserl">
                    <h2>เลือกยานพาหนะ</h2>
                    <button type="button" class="btn btn-inverse btn_iserl tooltips pull-right" 
                    data-dismiss="modal" title="คลิกปุ่มเพื่อปิดหน้าต่าง"><span>ปิด</span></button>
                </div> 
                <div class="modal-body" style="border:0px;">
					<div class="form-group">
						<div class="row">
							<div class="form-group" align="center">
								<div class="col-md-5">
									<label ><b>ยานพาหนะ</b></label>
									<select  id="car_type" name="car_type">
										<option value="0">กรุณาเลือก</option>
										<?php foreach($data_car->result() as $dtcar) {?>
											<option value="<?php echo $dtcar->eqs_id;?>"><?php echo $dtcar->eqs_name;?></option>
										<?php }?>
									</select>
								</div>
								<div class="col-md-5">
									<label ><b>คนขับ</b></label>
									<select class='driver' id="drive" name="drive">
										<option value="0">กรุณาเลือก</option>
										<?php foreach($name_driver->result() as $ndri) {?>
											<option value="<?php echo $ndri->ps_id;?>"><?php echo $ndri->pf_name.$ndri->ps_fname." ".$ndri->ps_lname;?></option>
										<?php }?>
									</select>
								</div>
								<div class= "padding_add">
									<button class="btn btn-social btn-google btn_iserl tooltips fa fa-plus" title="คลิกปุ่มเพื่อเพิ่มข้อมูล" id="add_car_driver" ><span> เพิ่มข้อมูล</span></button> 
									<input type="hidden" name="rscar_id" id="rscar_id" value="">
								</div>
							</div>
							<form id="frm_modal_driver_car" method="POST" action="<?php echo site_url($this->jongs_v."Reserve_car/add_driver_car"); ?>"><!--เปิดฟอร์ม-->
								<input type="hidden" name="rscar_id" id="rscar_id" value="">
								<table id="thtable" class="table table-bordered" cellspacing="0" role="grid" aria-describedby="example_info">
									<thead>
										<tr class="myclass">
											<th style="width:15%;" >ลำดับ</th>
											<th>ยานพาหนะ</th>
											<th>คนขับ</th>
											<th>ดำเนินการ</th>
										</tr>
									</thead>
									<tbody id="select_car">
										<tr></tr>
									</tbody>
								</table>
							</form>
						</div>	
					</div>
                </div><!--close content-->
   				<div class="modal-footer">
						<button class="btn btn-danger btn_iserl tooltips pull-left" data-dismiss="modal" title="คลิกปุ่มเพื่อยกเลิกข้อมูล" ><span>ยกเลิก</span></button>
						<button class="btn btn-success btn_iserl tooltips" type ="submit" title="คลิกปุ่มเพื่อบันทึกข้อมูล" onclick="add_car_driver()"><span>บันทึก</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Use the car and driver -->

<!-- Modal Use the car  -->
<div class="modal fade bs-example-modal-lg" id="myModal2" style='background-color: #0000004d;' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%; height: 60%;">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading panel_modal_iserl">
                    <h2>เลือกยานพาหนะ</h2>
                    <button type="button" class="btn btn-inverse btn_iserl tooltips pull-right" 
                    data-dismiss="modal" title="คลิกปุ่มเพื่อปิดหน้าต่าง"><span>ปิด</span></button>
                </div> 
                <div class="modal-body" style="border:0px;">
					<div class="form-group">
						<div class="row">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-3 control-label offset-sm-9" align="right"><b>ยานพาหนะ</b></label>
									<div class="col-md-6">
										<select  id="car_type2" name="car_type2">
											<option value="0">กรุณาเลือก</option>
											<?php foreach($data_car->result() as $dtcar) {?>
												<option value="<?php echo $dtcar->eqs_id;?>"><?php echo $dtcar->eqs_name;?></option>
											<?php }?>	
										</select>
									</div>
									<button class="btn btn-social btn-google btn_iserl tooltips fa fa-plus" title="คลิกปุ่มเพื่อเพิ่มข้อมูล" id="add_driver2" ><span> เพิ่มข้อมูล</span></button>
								</div>
							</div>
							<form id="frm_modal_car" method="POST" action="<?php echo site_url($this->jongs_v."Reserve_car/add_car"); ?>"><!--เปิดฟอร์ม-->
								<input type="hidden" name="rscar_id" id="rscar_id" value="">
								<table  class="table table-bordered" cellspacing="0" role="grid" aria-describedby="example_info">
									<thead>
										<tr class="myclass">
											<th style="width:15%;" >ลำดับ</th>
											<th>ยานพาหนะ</th>
											<th>เครื่องมือ</th>
										</tr>
									</thead>
									<tbody id="select_car2">
										<tr></tr>
									</tbody>
								</table>
							</form><!--ปิดฟอร์ม-->
						</div>	
					</div>
                </div><!--close content-->
   				<div class="modal-footer">
						<button class="btn btn-danger btn_iserl tooltips pull-left" data-dismiss="modal" title="คลิกปุ่มเพื่อยกเลิกข้อมูล" ><span>ยกเลิก</span></button>
						<button class="btn btn-success btn_iserl tooltips" type ="submit" title="คลิกปุ่มเพื่อบันทึกข้อมูล" onclick="add_car()"><span>บันทึก</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Modal Use the car  -->

<script>
 $(document).ready(function(){
		$("#inlineradioxx").click(function(){
			$('.aradio').iCheck('check');
		});
		$("#inlineradio2").click(function(){
			$('.bradio').iCheck('check');
		});
	});
//function : modal Modal Use the car and driver
$(document).ready(function(){
		var str = "";
		var str2 ="";
		var count = 1;
		var eqs_id;
		var ps_id;
		$("#car_type").select2({width: '80%'});
		$("#drive").select2({width: '80%'});
		
		$("#car_type").change(function() {
			$( "#car_type option:selected" ).each(function() {
				str = $( this ).text();
				console.log(str);
				eqs_id = $( this ).val();
				console.log(eqs_id);
			});
		});
		$("#drive").change(function() {
			$( "#drive option:selected" ).each(function() {
				str2 = $( this ).text();
				console.log(str2);
				ps_id = $( this ).val();
				console.log(ps_id);
			});
		});
		
		$("#add_car_driver").click(function(){
			var eqs = document.getElementsByName('rscard_eqs_id[]');
			var ps = document.getElementsByName('rscard_ps_id[]');
			var i=0;
			var check_eqs = false;
			var check_ps = false;
			if(eqs_id == null || eqs_id == 0){
				alert('กรุณาเลือกยานพาหนะ');
			}else if(ps_id == null || ps_id == 0){
				alert('กรุณาเลือกคนขับ');
			}else {
				for(i=0;i<eqs.length;i++){
					if(eqs[i].value == eqs_id){
						alert('ซ้ำ : กรุณาเลือกยานพาหนะใหม่');
						check_eqs = true;
					}
				}
				for(i=0;i<ps.length;i++){
					if(ps[i].value == ps_id){
						alert('ซ้ำ : กรุณาเลือกคนขับใหม่');
						check_ps = true;
					}
				}
				if(!check_eqs && !check_ps){
					$('#select_car tr:last').after('<tr class="total_add_car_driver"><td align="center" style="width:10%;"><span class="sn"></span></td><td style="width:50%;">'+str+'</td><td style="width:25%;">'+str2+'</td><td align="center" style="width:15%;"><a href="#" class="btn btn-danger btn_check_iserl tooltips ti ti-close <?php echo $this->config->item('cls_delete'); ?>" onclick="doRemoveItem(this);"></a></td><input type="hidden" id="rscard_eqs_id_'+eqs_id+'" name="rscard_eqs_id[]" value="'+eqs_id+'"><input type="hidden" id="rscard_ps_id_'+ps_id+'" name="rscard_ps_id[]" value="'+ps_id+'"></tr>');
					count++;
				}
				$('#select_car tr').each(function(index) {// Number index
					//   alert(index);
					$(this).find('span.sn').html(index);
				});
			}
		});
	});
//End function : modal Modal Use the car and driver

//function : modal Modal Use the car
$(document).ready(function(){
		var str = "";
		var eqs_id;
		var count = 1;
		$("#car_type2").select2({width: '100%'});
		$("#car_type2").change(function() {
			$( "#car_type2 option:selected" ).each(function() {
				str = $( this ).text() + "<br>";
				console.log(str);
				eqs_id = $( this ).val();
				console.log(eqs_id);
			});
		});
		$("#add_driver2").click(function(){
			var eqs = document.getElementsByName('rscard_eqs_id[]');
			var check_eqs = false;
			if (eqs_id == null || eqs_id == 0) {
				alert('กรุณาเลือกพาหนะ');
			} else {
				for(i=0;i<eqs.length;i++){
					if(eqs[i].value == eqs_id){
						alert('ซ้ำ : กรุณาเลือกยานพาหนะใหม่');
						check_eqs = true;
					}
				}
				if(!check_eqs){
					$('#select_car2 tr:last').after('<tr class="total_add_car"><td align="center" style="width:10%;"><span class="sn2"></span></td><td style="width:50%;">'+str+'</td><td align="center" style="width:15%;"><a href="#" class="btn btn-danger btn_check_iserl tooltips ti ti-close <?php echo $this->config->item('cls_delete'); ?>"onclick="doRemoveItem2(this);"></a></td><input type="hidden" id="rscard_eqs_id_'+eqs_id+'" name="rscard_eqs_id[]" value="'+eqs_id+'"></tr>');
					count++;
				}
				$('#select_car2 tr').each(function(index) {// Number index
					//   alert(index);
					$(this).find('span.sn2').html(index);
				});
			}
		});
	});
//End function : modal Modal Use the car 

$('.modal-dialog').css('width', '80%');
	$('.modal-dialog').css('height', '80%');
	$('.choose_driver').click(function(){
		$('#select_car').html("<tr></tr>");
		$('#select_car2').html("<tr></tr>");
		var Id = $(this).data('id');
		$(".modal-body #rscar_id").val(Id);
	});
	
	function doRemoveItem2(obj){    
		if($('#select_car2  tr').size() > 1){     
			if(confirm('คุณต้องการลบแถวนี้?')){ $(obj).parent().parent().remove();   
				// count--;
				}else{     
				alert('ไม่อนุญาตให้ลบแถวที่เหลือนี้ได้');
			}
		} 
		$('#select_car2 tr').each(function(index) {// Number index
				//   alert(index);
				$(this).find('span.sn2').html(index);
		});
	}
	
	function doRemoveItem(obj){    
		if($('#select_car  tr').size() > 1){     
			if(confirm('คุณต้องการลบแถวนี้?')){ $(obj).parent().parent().remove();   
				}else{     
				alert('ไม่อนุญาตให้ลบแถวที่เหลือนี้ได้');
			}
		}
		$('#select_car tr').each(function(index) {// Number index
				//   alert(index);
				$(this).find('span.sn').html(index);
		}); 
	}
	
	function cancel_rscar(rscar_id){ //ยกเลิกรายการแจ้งขอใช้
		bootbox.confirm({
			message: "ต้องการยืนยันยกเลิกรายการแจ้งขอใช้ยานพาหนะใช่หรือไม่",
			buttons: {
				confirm: {
					label: 'ยืนยัน',
					className: '<?php echo $this->config->item('cls_confirm');?> btn'
				},
				cancel: {
					label: 'ยกเลิก',
					className: '<?php echo $this->config->item('cls_cancel');?> btn'
				}
			},
			callback: function (result) {
				if(result){
					$.post("<?php echo site_url($this->config->item("eqs_folder").$this->config->item('rs_car_folder')."Reserve_car/cancel_rscar"); ?>", {'rscar_id': rscar_id});
					
					window.location.replace(""); //รีเฟรสหน้าเมื่อผู้ใช้กดบันทึก
					
				}
			}
		});
	}
	
	function print_item(rscar_id){
		window.open("Reserve_car/print/"+rscar_id);
	}
	
	function edit(rscar_id){
		window.location.replace("Reserve_car/edit_reserve_car/"+rscar_id);
	}
	
	function approve_submit(){
		$('#approve_form').submit();
	}
	
	function add_car(){
		var count_add = $('.total_add_car').length
			if(count_add != 0){
			$('#frm_modal_car').submit();
		}else {
			alert('กรุณา : เพิ่มข้อมูล');
		}	
	}
	
	function add_car_driver(){
		var count_add = $('.total_add_car_driver').length
			if(count_add != 0){
				$('#frm_modal_driver_car').submit();
			}else{
				alert('กรุณา : เพิ่มข้อมูล');
			}	
	}
	function goBack(){
		window.location.replace("../Reserve_car ");
	}
	
</script>