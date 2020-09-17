<!-- 
    Nuttakit Pangngom 58160659 
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
<?php
 if($data_remand_car_header == null){  
    echo "ไม่พบข้อมูล";
 }else {
?>
<form id="submit_data_id" method="POST" action="<?php echo site_url($this->jongs_v."Remand_car/update_remand_car"); ?>"><!--เปิดฟอร์ม-->
<input type="hidden" name="rsc_id" value="<?php echo $data_remand_car_header->rsc_id;?>">
<div class="col-md-12"> <!-start div 1-->
    <div class="panel panel-default">
        <div class="panel-heading panel_heading_iserl"> 
            <!-- // ดู Class เป็นหลัก -->
            <h2>คืนยานพาหนะ</h2>
        </div><!--end panel_headin-->
        <div class="panel-body"><!--star content-->
            <div align="center">
                <h3><b>ใบคืนยานพาหนะ</b></h3>
            </div><br>  
            <div class="col-md-12 mb-3 " align="right">
                <span><b>วันที่ : </b><?php echo DateThai($data_remand_car_header->rsc_date_create);?><b> เวลา : </b><?php echo Time_Fn($data_remand_car_header->rsc_date_create);?></span>
            </div><br>
            <div class="col-md-12" >&nbsp;</div>
            <div class="col-md-12"> <!--แสดง รายละเอียดส่วนหัว-->
                    <table class="table table-striped table-bordered table_iserl" aria-hidden="true">	
						<tbody>
							<tr>
								<td style="width:15%; text-align:center; font-weight: bold;">ข้าพเจ้า : </td>
								<td style="width:25%"><?php echo $data_remand_car_header->pf_name." ".$data_remand_car_header->ps_fname." ".$data_remand_car_header->ps_lname;?></td>
								<td style="width:10%; text-align:center; font-weight: bold;">ตำแหน่ง : </td>
								<td style="width:15%"><?php echo $data_remand_car_header->alp_name;?></td>
								<td style="width:15%; text-align:center; font-weight: bold;">สังกัดหน่วยงานย่อย : </td>
								<td style="width:23%"><?php echo $data_remand_car_header->alp_name_abrr;?></td>
							</tr>
							<tr>
								<td  colspan="2" style="width:15%; text-align:center; font-weight: bold;">เพื่อไปราชการ / จัดประชุม / ประชุม.อบรม.สัมมนา / นิเทศ ที่ : </td>
								<td colspan="2" ><?php echo $data_remand_car_header->rsc_place;?></td>
                                <td style="width:10%; text-align:center; font-weight: bold;">จำนวนผู้โดยสาร : </td>
                                <td style="width:40%"><?php echo $data_remand_car_header->rsc_companion;?> คน</td>
							</tr>
                            <tr>
                                <td style="width:15%; text-align:center; font-weight: bold;" colspan="2">เพื่อ (จัดประชุม / ประชุม.อบรม.สัมมนา / นิเทศ ฯลฯ) : </td>
                                <td style="width:23%" colspan="4" ><?php echo $data_remand_car_header->rsct_name;?></td>
							</tr>
							<tr>
                                <td style="width:15%; text-align:center; font-weight: bold;">เรื่อง / วิชา : </td>
                                <td colspan="2" style="width:35%;"><?php echo $data_remand_car_header->rsc_title;?></td>
                                <td style="width:15%; text-align:center; font-weight: bold;">ระหว่างวันที่ : </td>
                                <td colspan="2" style="width:35%;">
                                    <?php echo DateThai($data_remand_car_header->rsc_start_date);?>   
                                    <b>ถึง</b>
                                    <?php echo DateThai($data_remand_car_header->rsc_end_date);?>   
                                </td>
							</tr>
                            <?php
                            if ($get_jon_reserve_car_guest->result()  == null) {
                            ?>
                            <tr>
                                <td style="width:15%; text-align:left; font-weight: bold;">ออกเดินทางวันที่ : </td>
                                <td>
                                    <input type="text" class="form-control datepicker" id="id_rscar_start_date" name="rscar_start_date" placeholder="วันที่เริ่มต้น" data-date-format="dd/mm/yyyy" data-date-language="th-th" value="<?php echo DateNum($data_remand_car_header->rsc_start_date);?>" disabled>
                                </td>
                                <td>
                                    <input type="text" class="form-control mask time1" data-inputmask="'mask':'99.99'" placeholder="เวลา" name="" value="<?php echo Time_Fn($data_remand_car_header->rsc_start_date);?>" disabled>
                                </td>
                                <td style="width:15%; text-align:center; font-weight: bold;">ถึงวันที่<span class="required"> *</span></td>
                                <td>
                                    <input type="text" class="form-control datepicker" id="id_rscar_end_date" name="rsc_end_date" placeholder="วันที่สิ้นสุด" data-date-format="dd/mm/yyyy" data-date-language="th-th" value="<?php echo DateNum($data_remand_car_header->rsc_end_date);?>" validate>
                                </td>
                                <td>
                                    <input type="text" class="form-control mask time1" data-inputmask="'mask':'99.99'" placeholder="เวลา" name="rsc_end_time" value="<?php echo Time_Fn($data_remand_car_header->rsc_end_date);?>" validate>
                                </td>
                            </tr>			
            <?php
            }
            ?>				
            <?php
            if ($get_jon_reserve_car_guest->result()  != null) {
            ?>
                    <?php
                        $index = 1;
                        foreach ($get_jon_reserve_car_guest ->result() as $value) {
                    ?>
                            <tr>
                                <td style="width:15%; text-align:center; font-weight: bold;"> ชื่อวิทยากรที่รับ : </td>
                                <td colspan="2" style="width:35%;">
                                    <?php echo $value->rscg_pf_name;?>
                                    <?php echo $value->rscg_fname;?>
                                    <?php echo $value->rscg_lname;?>
                                </td> 
                                <td style="width:15%; text-align:center; font-weight: bold;">โทรศัพท์ : </td>
                                <td colspan="2"><?php echo $value->rscg_tel ?></td>
                            </tr>
                            <tr>
                                    <td style="text-align:center; font-weight: bold;">สถานที่รับวิทยากร : </td>
                                    <td colspan="2"><?php echo $value->rscg_place;?></td>
                                    <td style="width:15%; text-align:center; font-weight: bold;">ระยะเวลารับวิทยากร : </td>
                                    <td colspan="2">
                                        <?php echo DateThai($value->rsc_guest_receive_date);?>
                                        <b>ถึง</b>                            
                                        <?php echo DateThai($value->rsc_guest_send_date);?>
                                    </td>
                            </tr>
                    <?php
                    $index++;
                    }
                    ?>
            <?php
            }
            ?>
            <?php
                if ($get_jon_reserve_car_guest->result() != null) {
            ?>
                            <tr>
                                    <td style="width:15%; text-align:left; font-weight: bold;">ออกเดินทางวันที่ : </td>
                                    <td >
                                        <input type="text" class="form-control datepicker" id="id_rscar_start_date" name="rscar_start_date" placeholder="วันที่เริ่มต้น" data-date-format="dd/mm/yyyy" data-date-language="th-th" value="<?php echo DateNum($data_remand_car_header->rsc_start_date);?>" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control mask time1" data-inputmask="'mask':'99.99'" placeholder="เวลา" name="" value="<?php echo Time_Fn($data_remand_car_header->rsc_start_date);?>" disabled>
                                    </td>
                                    <td style="width:15%; text-align:center; font-weight: bold;">ถึงวันที่<span class="required"> *</span></td>
                                    <td>
                                        <input type="text" class="form-control datepicker" id="id_rscar_end_date" name="rsc_end_date" placeholder="วันที่สิ้นสุด" data-date-format="dd/mm/yyyy" data-date-language="th-th" value="<?php echo DateNum($data_remand_car_header->rsc_end_date);?>" validate>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control mask time1" data-inputmask="'mask':'99.99'" placeholder="เวลา" name="rsc_end_time" value="<?php echo Time_Fn($data_remand_car_header->rsc_end_date);?>" validate>
                                    </td>
                            </tr>			
            <?php
            }
            ?>
                    </tbody>
                </table>
            </div> <!--ปิด แสดงสรายละเอียดส่วนหัว-->
            <?php
                if ($get_jon_reserve_car_detail->result() != null) {
            ?>
            <div class="col-md-12"> <!--แสดงรายละเอียดการข้อใช้รถ-->
            <span><b>รายละเอียดพาหนะและคนขับ</b></span><br>
            <div class="col-md-12" style="height:12px"></div>
                <table  class="table table-striped table-bordered table_iserl no-footer table-hover">   
                    <thead> 
                        <tr>
                            <th rowspan="2">รูป</th>
                            <th rowspan="2">ประเภทรถ / หมายเลขทะเบียนรถ</th>
                            <th rowspan="2">พนักงานขับรถ</th>
                            <th rowspan="2">ผลการพิจารณา</th>
                            <th rowspan="2">เหตุผล/รายละเอียด</th>
                        </tr>	
                    </thead> 
                    <tbody>
                    <?php
                        foreach ($get_jon_reserve_car_detail ->result() as $value) {               
                    ?>
                        <tr>
                        <?php if($value->img_path_car_detail == ''){ ?>
							<td align="center" style="width:15%;" >
                                <img src="<?php echo base_url("application/views/".$this->config->item('jongs_v')."nopicture.png"); ?>" style = "width: 100px; height: 100px;">
                            </td>
						<?php }else{ ?>	
							<td align="center" style="width:15%;" ><img src="<?php echo site_url($this->config->item('eqs_folder')."GetIcon?type=image&image=".$value->img_path_car_detail); ?>" style="width:100%;" ></td>
						<?php } ?>
                            <td width="30%"><?php echo $value->eqs_name_car_detail;?></td>
                        <?php if($value->rsc_driver == "Y"){ ?>
                            <td>
                                <?php echo $value->pf_name_car_detail;?>  
                                <?php echo $value->ps_fname_car_detail;?>
                                <?php echo $value->ps_lname_car_detail;?>
                            </td>
                        <?php }else if($value->rsc_driver == "N" ){  ?>
                            <td>ไม่มีการขอใช้คนขับ  </td>
                        <?php } ?> 
                            <td align="center"><?php echo $value->rscst_name;?></td>
                            <td align="center">
                                <input type="hidden" name="rscd_rsc_id" value="<?php echo $value->rscd_rsc_id_car_detail;?>">
                                <input type="hidden" name="rscd_eqs_id[]" value="<?php echo $value->rscd_eqs_id;?>">
                                <textarea style="width: 100%;" name="rscd_note[]" placeholder="กรุณากรอกรายละเอียด"></textarea>
                            </td>
                        </tr>  
                    <?php
                        } // close foreach
                    ?>
                    </tbody>
                </table>
                <a>*** หมายเหตุ (ขอใช้)</a>
            </div> <!--ปิด แสดงรายละเอียดการข้อใช้รถ-->
            <?php
                }// ปิดเงือนไข แสดงตารางรถ
            ?>
            </form>
            <div class="col-md-12"> <!--ส่วนกานดำเนิน-->
                <div class="col-md-4">
                    <!-- <button class="btn btn-danger btn_iserl tooltips" type="submit"  title="คลิกปุ่มเพื่อบันทึกข้อมูล" onclick="goBack()"><span>ยกเลิก</span></button> -->
                    <input class="btn btn-danger btn_iserl tooltips" type="button" value="ยกเลิก" onclick="goBack()"/>
                    <!-- <button class="btn btn-danger btn_iserl tooltips" type ="submit" title="คลิกปุ่มเพื่อบันทึกข้อมูล" onclick="back_home()"><span>ยกเลิก</span></button><button class="btn btn-danger btn_iserl tooltips" type ="submit" title="คลิกปุ่มเพื่อบันทึกข้อมูล" onclick="back_home()"><span>ยกเลิก</span></button><button class="btn btn-danger btn_iserl tooltips" type ="submit" title="คลิกปุ่มเพื่อบันทึกข้อมูล" onclick="back_home()"><span>ยกเลิก</span></button> -->
                </div>    
                <div class="col-md-8" align="right">
                    <button class="btn btn-success btn_iserl tooltips" title="คลิกปุ่มเพื่อบันทึกข้อมูล" type="submit" onclick="submit_data()"><span>บันทึก</span></button>
                </div>     
            </div> <!--ปิด ส่วนกานดำเนิน-->
            <div class="col-md-12" style="height:12px"></div>
        </div><!-- End star content -->
    </div>
</div> <!--End div 1-->

<?php
 } //End tag No data (การแสดงในกรณีไม่มีข้อมูล)
?>

<script type="text/javascript">
	$(document).ready(function(){// function date
		$("div.data_contact").hide();
		$('input[type="radio"]').click(function(){
			var demovalue = $(this).val(); 
			$("div.data_contact").hide();
			$("#contact"+demovalue).show();
		});
		$('.datepicker').datepicker();
		$('.timepicker').timepicker();
	});
</script> <!-- End function date -->
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js"></script> <!-- function time -->
<script type="text/javascript" src="<?php echo base_url();?>assets/demo/demo-mask.js"></script>	<!-- function time -->
<script type="text/javascript" src="<?php echo base_url();?>js/tqf/summernote/dist/js/bootstrap-datepicker.th.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>js/tqf/summernote/dist/js/bootstrap-datepicker-thai.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/summernote/dist/summernote.js"></script> <!-- summernote -->

<script>

    function submit_data(){// ฟังก์ชัน บันทึกการทำรายการ
				$('#submit_data_id').submit();
	}

    function goBack(){// ฟังก์ขัน กลับไปหน้าหลัก
			window.history.back()
            // window.location.replace("../Reserve_car ");
	}
</script>