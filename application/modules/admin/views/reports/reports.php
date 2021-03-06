<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row {
	margin-bottom:10px;
}
#month-chart > svg {
	width: 100% !important;
}
</style>
<!-- Content Header (Page header) -->
<?php
$consultant = $this->consultant_model->get_consultant_by_consultant();
$treatment=$this->treatment_advised_model->get_medical_test_by_doctor();
?>
<section class="content-header">
<h1><?php echo lang('reports'); ?> </h1>
<ol class="breadcrumb">
  <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
  <li class="active"><?php echo lang('reports'); ?></li>
</ol>
</section>
<section class="content">
  <div class="row"> 
    <!-- left column -->
    <div class="col-md-12"> 
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header"> </div>
        <!-- /.box-header --> 
        <!-- form start -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12"> 
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_5" data-toggle="tab" aria-expanded="false"><?php echo lang('by') . " " . 'Date to Date'; ?></a></li>
                  <li><a href="#tab_1" data-toggle="tab" aria-expanded="false">By Month</a></li>
                  <li><a href="#tab_3" data-toggle="tab" aria-expanded="false">By Financial Year</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane " id="tab_1">
                    <div class="box box-success">
                      <div class="box-header">
                        <div class="box-header"> <br/>
                          <form method="post" action="<?php echo site_url('admin/reports/month/') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="col-md-12">
                                    <label for="name" style="clear:both;">Month </label>
                                    <input type="month" class="form-control month" name="month" />
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Consultant </label>
                                  <div class="controls">
                                    <select name="consultant" class="consultant form-control ">
                                      <option value="">Select Consultant</option>
                                      <?php foreach ($consultant as $new) { ?>
                                      <option value="<?php echo $new->id; ?>"><?php echo $new->name; ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Treatment Advise </label>
                                  <div class="controls">
                                    <select name="select_treatment1" class="select_treatment1 form-control" >
                                      <option value="">Select Treatment</option>
                                      <?php foreach ($treatment as $new){ ?>
                                      <option value="<?php echo $new->name; ?>"><?php echo  $new->name; ?></option>
                                      <?php }  ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4" style="margin-left: 16px;">
                                  <label for="name" style="clear:both;">Groups </label>
                                  <div class="controls">
                                    <select name="select_group1" class="select_group1 form-control" >
                                      <option value="">Select Group</option>
                                      <?php 
									  $query = $this->db->query("SELECT DISTINCT users.group from users;");
									  foreach ($query->result() as $new){ ?>
                                      <option value="<?php echo $new->group; ?>"><?php echo  $new->group; ?></option>
                                      <?php }  ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4" style="margin-top: 23px;">
                                  <label for="name"></label>
                                  <button class="update_monthly_report btn btn-success"  type="submit" ><?php echo 'Search'; ?> </button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div id="data_report1" class="box-header"></div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="tab_2">
                    <div class="box box-solid bg-teal-gradient">
                      <div class="box-header"> <i class="fa fa-th"></i>
                        <h3 class="box-title">Earning Graph</h3>
                        <div class="box-tools pull-right">
                          <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                      <div class="box-body border-radius-none">
                        <div class="chart" id="month-chart" style="height: 250px;"></div>
                      </div>
                      <!-- /.box-body --> 
                    </div>
                    <!-- /.box --> 
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="tab_3">
                    <div class="box box-success">
                      <div class="box-header">
                        <div class="box-header"> <br/>
                          <form method="post" action="<?php echo site_url('admin/reports/year/') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Year </label>
                                  <div class="controls">
                                    <select name="year" class="form-control year">
                                      <?php 
   for($i = date('Y') ; $i >= 2010; $i--){
      echo "<option value='".$i."'>$i-".($i+1)."</option>";
   }
?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Consultant </label>
                                  <div class="controls">
                                    <select name="select_consultant2" class="select_consultant2 form-control ">
                                      <option value="">Select Consultant</option>
                                      <?php foreach ($consultant as $new) { ?>
                                      <option value="<?php echo $new->id; ?>"><?php echo $new->name; ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Treatment Advise </label>
                                  <div class="controls">
                                    <select name="select_treatment2" class="select_treatment2 form-control " >
                                      <option value="">Select Treatment</option>
                                      <?php foreach ($treatment as $new){ ?>
                                      <option value="<?php echo $new->name; ?>"><?php echo  $new->name; ?></option>
                                      <?php }  ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Groups </label>
                                  <div class="controls">
                                    <select name="select_group" class="select_group2 form-control " >
                                      <option value="">Select Group</option>
                                      <?php 
                                                                            $query = $this->db->query("SELECT DISTINCT users.group from users;");
                                                                            foreach ($query->result() as $new){ ?>
                                      <option value="<?php echo $new->group; ?>"><?php echo  $new->group; ?></option>
                                      <?php }  ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;"></label>
                                  <div class="controls">
                                    <button class="update_yearly_report btn btn-success"  type="submit" ><?php echo 'Search'; ?> </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div id="data_report3" class="box-header"></div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="tab_4">
                    <div class="box box-success">
                      <div class="box-header">
                        <h3 class="box-title">Bar Chart</h3>
                      </div>
                      <div class="box-body chart-responsive">
                        <div class="chart" id="bar-chart" style="height: 300px;"></div>
                      </div>
                      <!-- /.box-body --> 
                    </div>
                    <!-- /.box --> 
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane active" id="tab_5">
                    <div class="box box-success">
                      <div class="box-header">
                        <div class="box-header"> <br/>
                          <form method="post" action="<?php echo site_url('admin/reports/dates/') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                  <?php 
								  $now = new DateTime();
								  $now->setTimezone(new DateTimezone('Asia/Kolkata'));
								  $today = $now->format('Y-m-d');
								  ?>
                                  <div class="col-md-4">
                                    <label for="name" style="clear:both;">From </label>
                                    <input type="text" name="date1" value="<?php echo $today; ?>" class="form-control datepicker date1 " />
                                    <br />
                                    <label for="name" style="clear:both;">Discount </label>
                                    </br>
                                    <input name="paid"  class="show_discount"  type="checkbox">
                                  </div>
                                  <div class="col-md-4">
                                    <label for="name" style="clear:both;">To </label>
                                    <input type="text" name="date2" class="form-control datepicker date2 " value="<?php echo $today; ?>" />
                                  </div>
                                  <div class="col-md-4">
                                    <label for="name" style="clear:both;">Pending </label>
                                    </br>
                                    <input name="paid"  class="check_class"  type="checkbox">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Consultant </label>
                                  <div class="controls">
                                    <select name="select_consultant" class="select_consultant form-control chzn">
                                      <option value="">Select Consultant</option>
                                      <?php foreach ($consultant as $new) { ?>
                                      <option value="<?php echo $new->id; ?>"><?php echo $new->name; ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Treatment Advise </label>
                                  <div class="controls">
                                    <select name="select_treatment" class="select_treatment form-control chzn" >
                                      <option value="">Select Treatment</option>
                                      <?php foreach ($treatment as $new){ ?>
                                      <option value="<?php echo $new->name; ?>"><?php echo  $new->name; ?></option>
                                      <?php }  ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;">Groups </label>
                                  <div class="controls">
                                    <select name="select_group" class="select_group form-control chzn" >
                                      <option value="">Select Group</option>
                                      <?php 
                                                                            $query = $this->db->query("SELECT DISTINCT users.group from users;");
                                                                            foreach ($query->result() as $new){ ?>
                                      <option value="<?php echo $new->group; ?>"><?php echo  $new->group; ?></option>
                                      <?php }  ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="name" style="clear:both;"></label>
                                  <div class="controls">
                                    <button class="update_report btn btn-success"  type="submit" id="submitonrefresh" ><?php echo 'Search'; ?> </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div id="data_report5" class="box-header"></div>
                    </div>
                  </div>
                  <!-- /.tab-pane --> 
                  
                </div>
                <!-- /.tab-content --> 
              </div>
              <!-- nav-tabs-custom --> 
            </div>
            <!-- /.col --> 
            
          </div>
        </div>
        <!-- /.box-body --> 
        
      </div>
      <!-- /.box --> 
    </div>
  </div>
</section>
<?php
$graph_arr = array();
foreach ($months as $ind => $month) {
    $graph_arr[$ind]['date'] = $month->date;
    $graph_arr[$ind]['amount'] = $month->amount;
}
$week_arr = array();
foreach ($weeks as $ind => $week) {
    $week_arr[$ind]['date'] = $week->date;
    $week_arr[$ind]['amount'] = $week->amount;
}

$year_arr = array();
foreach ($years as $ind => $year) {
    $year_arr[$ind]['date'] = date('Y', strtotime($year->date));
    $year_arr[$ind]['amount'] = $year->amount;
}


$client_arr = array();
foreach ($clients as $ind => $client) {
    $client_arr[$ind]['name'] = $client->name;
    $client_arr[$ind]['amount'] = $client->amount;
}

//echo '<pre>'; print_r($week_data);die;
?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script> 
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/js/raphael-min.js') ?>" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/js/morris.min.js') ?>" type="text/javascript"></script> 
<!-- Include Date Range Picker --> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script type="text/javascript">

$(document).ready(function(){
    $("#submitonrefresh").trigger('click'); 
});

function printIncome()
{
 
   var divToPrint=document.getElementById("example1");
   newWin= window.open("");
    divToPrint1=document.getElementById("exa1");
   newWin.document.write(divToPrint1.outerHTML);
   newWin.document.write("<b>Income</b>");
   newWin.document.write(divToPrint.outerHTML);
 
   divToPrint=document.getElementById("example2");
   newWin.document.write(divToPrint.outerHTML);
   divToPrint=document.getElementById("example3");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
            $(document).ready(function() {
    $(window).load(function() {
    $(".icheckbox_minimal .iCheck-helper").click(function () {
    if ($("#pd").prop("checked") == true){
    $('.date1').attr('disabled', '');
            $('.date2').attr('disabled', '');
    } else{
    $('.date1').removeAttr('disabled');
            $('.date2').removeAttr('disabled');
    }
    });
    });
    });
            $(".update_report").click(function(event) {
    event.preventDefault();
//$(this).closest("form").submit();	

            var form = $(this).closest('form');
            ///$(".myCheckBox").checked(true);
            date1 = $(form).find('.date1').val();
            date2 = $(form).find('.date2').val();
            //paid = $('.check_class').val();
            //console.log(checkvalue);
            select_consultant = $(form).find('.select_consultant').val();
                select_treatment = $(form).find('.select_treatment').val();
                select_group = $(form).find('.select_group').val();
    if ($(form).find('.check_class').prop('checked') == true){
    paid = 1;
    } else {
    paid = 0;
    }
	
	if ($(form).find('.show_discount').prop('checked') == true){
    	discount = 'yes';
    } else {
    	discount = 'no';
    }
	
	
    $.ajax({
    url: '<?php echo base_url('admin/reports/dates/') ?>',
            type:'POST',
            data:{date1:date1, date2:date2, paid:paid, select_consultant:select_consultant,select_treatment:select_treatment,select_group:select_group,discount:discount},
            success:function(result){

            //location.reload();
            // $('#edit'+id).modal('hide');
            //window.close(); 
            document.getElementById("data_report5").innerHTML = '<table id="example1" width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>Sr.No.</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left"><b>Patient</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b>Gender</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>Contact</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="15%" align="left"><b>Doctor</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="15%" align="left" id="blns1"><b>Received Amount</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left"><b>Pending Amount</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%" align="left"><b>Treatment Advise</b></td></tr>' + result;
                    if (paid == 1){
            $('#blns1').html('Pending Amount');
            } else{
            $('#blns1').html('Received Amount');
            }
            $(".chzn").chosen();
            }
    });
    });
            $(".update_monthly_report").click(function(event) {
    event.preventDefault();
//$(this).closest("form").submit();	

            var form = $(this).closest('form');
            var month = $(form).find('.month').val();
             var select_group = $(form).find('.select_group1').val();
            var select_treatment = $(form).find('.select_treatment1').val();
            var consultant = $(form).find('.consultant').val();
    
            
            $.ajax({
            url: '<?php echo base_url('admin/reports/month/') ?>',
                    type:'POST',
                    data:{month: month, consultant: consultant,select_group:select_group,select_treatment:select_treatment},
                    success:function(result){

                
                    document.getElementById("data_report1").innerHTML = '<table id="example1" width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>Sr.No.</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left"><b>Patient</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b>Gender</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>Contact</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="15%" align="left"><b>Doctor</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="15%" align="left" id="blns"><b>Received Amount</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left"><b>Pending Amount</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%" align="left"><b>Treatment Advise</b></td></tr>' + result;
                    //         if (paid == 1){
                    // $('#blns').html('Pending Amount');
                    // } else{
                    // $('#blns').html('Received Amount');
                    // }
                    $(".chzn").chosen();
                    }
            });
    });

$(".update_yearly_report").click(function(event) {
    event.preventDefault();
//$(this).closest("form").submit();	

            var form = $(this).closest('form');
            var year= $(form).find('.year').val();
            var consultant = $(form).find('.select_consultant2').val();
            var select_group = $(form).find('.select_group2').val();
            var select_treatment = $(form).find('.select_treatment2').val();
            $.ajax({
            url: '<?php echo base_url('admin/reports/year/') ?>',
                    type:'POST',
                    data:{year: year, consultant: consultant,select_group:select_group,select_treatment:select_treatment},
                    success:function(result){
 
                    document.getElementById("data_report3").innerHTML = '<table id="example1" width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>Sr.No.</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left"><b>Patient</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b>Gender</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>Contact</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="15%" align="left"><b>Doctor</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="15%" align="left" id="blns"><b>Received Amount</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left"><b>Pending Amount</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%" align="left"><b>Treatment Advise</b></td></tr>' + result;
                           
                    $(".chzn").chosen();
                    }
            });
    });
            $(function() {

            $('.chzn').chosen();
                    /* Morris.js Charts */
                    // Sales chart

                    var line = new Morris.Line({
                    element: 'line-chart',
                            resize: true,
                            data: [
<?php $i = 30;
foreach ($date as $key => $val) {
    ?>
                                {amount: '<?php echo (empty($val->amount) || $val->amount == 0) ? 0 : $val->amount ?>', date: '<?php echo (!empty($val->date)) ? $val->date : date('d M', strtotime("- " . $i . " days")); ?>'},
    <?php $i--;
}
?>],
                            xkey: 'date',
                            ykeys: ['amount'],
                            labels: ['Amount'],
                            lineColors: ['#efefef'],
                            lineWidth: 2,
                            parseTime:false,
                            hideHover: 'auto',
                            gridTextColor: "#fff",
                            gridStrokeWidth: 0.4,
                            pointSize: 4,
                            pointStrokeColors: ["#efefef"],
                            gridLineColor: "#efefef",
                            gridTextFamily: "Open Sans",
                            gridTextSize: 10
                    });
                    var month_line = new Morris.Line({
                    element: 'month-chart',
                            resize: true,
                            data: [
<?php
$i = 7;
foreach ($week_data as $key => $val) {

    $cur_date = (!empty($key)) ? $key : $key;
    ?>
                                {amount: '<?php echo (empty($val->amount) || $val->amount == 0) ? 0 : $val->amount ?>', day: '<?php echo date("D", strtotime($key)); ?>'},
    <?php $i--;
}
?>],
                            xkey: 'day',
                            ykeys: ['amount'],
                            labels: ['Amount'],
                            lineColors: ['#efefef'],
                            lineWidth: 2,
                            hideHover: 'auto',
                            gridTextColor: "#fff",
                            gridStrokeWidth: 0.4,
                            parseTime:false,
                            pointSize: 4,
                            pointStrokeColors: ["#efefef"],
                            gridLineColor: "#efefef",
                            gridTextFamily: "Open Sans",
                            gridTextSize: 10
                    });
                    $(document).on('click', 'a[href=#tab_2]', function(){

            month_line.redraw();
            });
                    $(document).on('click', 'a[href=#tab_1]', function(){

            line.redraw();
            });
                    $(document).on('click', 'a[href=#tab_3]', function(){

            year_line.redraw();
            });
                    var year_line = new Morris.Bar({
                    element: 'year-chart',
                            resize: true,
                            data: <?php echo json_encode($year_arr); ?>,
                            barColors: ['#00a65a'],
                            xkey: 'date',
                            ykeys: ['amount'],
                            labels: ['Amount'],
                            hideHover: 'auto'
                    })

                    var bar = new Morris.Bar({
                    element: 'bar-chart',
                            resize: true,
                            data: <?php echo json_encode($client_arr); ?>,
                            barColors: ['#00a65a'],
                            xkey: 'name',
                            ykeys: ['amount'],
                            labels: ['Amount'],
                            hideHover: 'auto',
                            axes: 'y'
                    });
            });
            jQuery('.datepicker').datetimepicker({
    lang:'en',
            i18n:{
            de:{
            months:[
                    'Januar', 'Februar', 'M???rz', 'April',
                    'Mai', 'Juni', 'Juli', 'August',
                    'September', 'Oktober', 'November', 'Dezember',
            ],
                    dayOfWeek:[
                            "So.", "Mo", "Di", "Mi",
                            "Do", "Fr", "Sa.",
                    ]
            }
            },
            timepicker:false,
            format:'Y-m-d'
    });

           $('.month-picker').datetimepicker({
    lang:'en',
            i18n:{
            de:{
            months:[
                    'Januar', 'Februar', 'M???rz', 'April',
                    'Mai', 'Juni', 'Juli', 'August',
                    'September', 'Oktober', 'November', 'Dezember',
            ],
                    dayOfWeek:[
                            "So.", "Mo", "Di", "Mi",
                            "Do", "Fr", "Sa.",
                    ]
            }
            },
            datepicker: false,
            timepicker:false,
            format:'m/Y'
    });
            $(document).ready(function(){
    var date_input = $('input[name="date"]'); //our date input has the name "date"
            var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
            date_input.datepicker({
            format: 'mm/dd/yyyy',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
            })
    })
            function pr(id){
            	//document.location.href = "<?php echo site_url('admin/patients/view/') ?>/" + id;
				window.open("<?php echo site_url('admin/patients/view/') ?>/" + id);
            }
</script>