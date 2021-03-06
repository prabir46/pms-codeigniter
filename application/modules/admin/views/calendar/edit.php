<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure'); ?>');
    }
</script>
<style>
    .chosen-container{width:100% !important}
    .block{display:block !important}
</style>
<?php
//echo '<pre>'; print_r($_GET);
//echo '<pre>'; print_r($_POST);die;

$contacts = $this->patient_model->get_patients_by_doctor();
$contact = $this->contact_model->get_contact_by_doctor();
$clinics =  $this->doctor_model->get_clinic_by_doctor();
$hospitals = $this->hospital_model->get_hospital_by_doctor();
$college = $this->medical_college_model->get_medical_college_by_doctor();
$consultant_copy = $this->consultant_model->get_consultant_by_consultant();
$consultant ="";
$patient_id = '';
$motive = '';
$is_paid = '';
$id="";
$followup="";
$treatment_Advised = $this->treatment_advised_model->get_case_history_by_doctor();
$sms = $this->sms_management_model->get_list();
function js2PhpTime($jsdate) {
    if (preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches) == 1) {
        $ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
        //echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
    } else if (preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches) == 1) {
        $ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
        //echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
    }
    return $ret;
}

function php2JsTime($phpDate) {
    //echo $phpDate;
    //return "/Date(" . $phpDate*1000 . ")/";
    return date("m/d/Y H:i", $phpDate);
}

function php2MySqlTime($phpDate) {
    return date("Y-m-d H:i:s", $phpDate);
}

function mySql2PhpTime($sqlDate) {
    $arr = date_parse($sqlDate);
    return mktime($arr["hour"], $arr["minute"], $arr["second"], $arr["month"], $arr["day"], $arr["year"]);
}

function getCalendarByRange($id) {
    try {
        $sql = "select * from `jqcalendar` where `id` = " . $id;
        $handle = mysql_query($sql);
        //echo $sql;
        $row = mysql_fetch_object($handle);
    } catch (Exception $e) {
        
    }
    return $row;
}

if ($_GET["type_id"] == 1) {
    $event = $this->to_do_list_model->get_list_by_id($_GET["id"]);
    $subject = $event->title;
    $id = $event->id;
    $consultant = '';
    $color = 1;
    $starttime = $event->date;
    $endtime = date("Y-m-d H:i:s", strtotime($event->date . '+ 30 minute'));
    $allday = 0;
    $location = "";
    $description = "";
    $whom = '';
    $patient_id = '';
    $contact_id = '';
    $other = '';
    $motive = '';
    $is_paid = '';
}

if ($_GET["type_id"] == 2) {
    $event = $this->appointment_model->get_appointment_by_id($_GET["id"]);
    $subject = $event->title;
    $id = $event->id;
    $consultant = $event->consultant;
    $color = $event->Color;
    $starttime = date("Y-m-d H:i:s", strtotime($event->date));
    $endtime = date("Y-m-d H:i:s", strtotime($event->date . '+ 30 minute'));
    $allday = 0;
    $location = "";
    $description = "";
    $whom = $event->whom;
    $patient_id = $event->patient_id;
    $contact_id = $event->contact_id;
    $other = $event->other;
    $motive = $event->motive;
    $is_paid = $event->is_paid;
}
if ($_GET["type_id"] == 5) {
    if (isset($_GET["id"])) {
        $event = getCalendarByRange($_GET["id"]);
        $subject = $event->Subject;
        $id = $event->Id;
        $consultant = '';
        $color = $event->Color;
        $starttime = $event->StartTime;
        $endtime = $event->EndTime;
        $allday = $event->IsAllDayEvent;
        $location = $event->Location;
        $description = $event->Description;
        $whom = '';
        $patient_id = '';
        $contact_id = '';
        $other = '';
        $motive = '';
        $is_paid = '';
    }
}
?>
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script> 
<link href="<?php echo base_url('assets/wd/') ?>/css/colorselect.css" rel="stylesheet" />   
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.colorselect.js" type="text/javascript"></script>   
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.validate.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/') ?>/datepicker_lang_US.js" type="text/javascript"></script>        
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.datepicker.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.dropdown.js" type="text/javascript"></script>     

<link href="<?php echo base_url('assets/wd/') ?>/css/main.css" rel="stylesheet" type="text/css" />       
<link href="<?php echo base_url('assets/wd/') ?>/css/dp.css" rel="stylesheet" />    

<?php /* <link href="<?php echo base_url('assets/')?>/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('assets/wd/')?>/css/main.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('assets/wd/')?>/css/dp.css" rel="stylesheet" />
  <link href="<?php echo base_url('assets/wd/')?>/css/dropdown.css" rel="stylesheet" />


  <script src="//code.jquery.com/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script src="<?php echo base_url('assets/js/')?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/wd/js/')?>/Common.js" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/wd/js/')?>/jquery.form.js" type="text/javascript"></script>



 */ ?>
<style>
    .chosen-container{width:60% !important} 
    #divcalendarcolor{z-index:10000000000000000000000000000000 !important}
</style>    
<script type="text/javascript">
    $(function () {
        $('.chzn').chosen({search_contains: true});
    });
    if (!DateAdd || typeof (DateDiff) != "function") {
        var DateAdd = function (interval, number, idate) {
            number = parseInt(number);
            var date;
            if (typeof (idate) == "string") {
                date = idate.split(/\D/);
                eval("var date = new Date(" + date.join(",") + ")");
            }
            if (typeof (idate) == "object") {
                date = new Date(idate.toString());
            }
            switch (interval) {
                case "y":
                    date.setFullYear(date.getFullYear() + number);
                    break;
                case "m":
                    date.setMonth(date.getMonth() + number);
                    break;
                case "d":
                    date.setDate(date.getDate() + number);
                    break;
                case "w":
                    date.setDate(date.getDate() + 7 * number);
                    break;
                case "h":
                    date.setHours(date.getHours() + number);
                    break;
                case "n":
                    date.setMinutes(date.getMinutes() + number);
                    break;
                case "s":
                    date.setSeconds(date.getSeconds() + number);
                    break;
                case "l":
                    date.setMilliseconds(date.getMilliseconds() + number);
                    break;
            }
            return date;
        }
    }
    function getHM(date)
    {
        var hour = date.getHours();
        var minute = date.getMinutes();
        var ret = (hour > 9 ? hour : "0" + hour) + ":" + (minute > 9 ? minute : "0" + minute);
        return ret;
    }
    $(document).ready(function () {
        var DATA_FEED_URL = "<?php echo site_url('admin/datafeed') ?>";
        var arrT = [];
        var tt = "{0}:{1}";

// changed the range from a full twenty four hours to from the hours 9a to 9p if (i >= 9 && i <= 21)
        var check = $("#IsAllDayEvent").click(function (e) {
            if (this.checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
            }
            else {
                var d = new Date();
                var p = 60 - d.getMinutes();
                if (p > 30)
                    p = p - 30;
                d = DateAdd("n", p, d);
                $("#stparttime").val(getHM(d)).show();
                $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
            }
        });
        if (check[0].checked) {
            $("#stparttime").val("00:00").hide();
            $("#etparttime").val("00:00").hide();
        }
        $("#Savebtn").click(function () {
            $("#calendar_event_form").submit();
        });
        $("#Closebtn").click(function () {
            CloseModelWindow();
        });
        $("#Deletebtn").click(function () {
            if (confirm("Are you sure to remove this event")) {
                id = $(".hidden_id").val();
                type_id = $(".hidden_type_id").val();
                var param = [{"name": "id", value: id}, {"name": "type_id", value: type_id}];
                $.post(DATA_FEED_URL + "?method=remove",
                        param,
                        function (data) {
                            if (data.IsSuccess) {
                                alert(data.Msg);
                                CloseModelWindow(null, true);
                            }
                            else {
                                alert("Error occurs.\r\n" + data.Msg);
                            }
                        }
                , "json");
            }
        });
        $(document).ready(function () {
            $("#stpartdate,#etpartdate").datetimepicker({format: 'd/m/Y', timepicker: false, });
            var cv = $("#colorvalue").val();
            if (cv == "")
            {
                cv = "-1";
            }
            $("#calendarcolor").colorselect({title: "Color", index: cv, hiddenid: "colorvalue"});
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function () {
                    return true;
                },
                dataType: "json",
                success: function (data) {
                    alert(data.Msg);
                    if (data.IsSuccess) {
                        CloseModelWindow(null, true);
                    }
                }
            };

            $.validator.addMethod("date", function (value, element) {
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year, month, day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
            $.validator.addMethod("time", function (value, element) {
                return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
            }, "Invalid time format");
            $.validator.addMethod("safe", function (value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, "$<> not allowed");
            $("#calendar_event_form").validate({
                submitHandler: function (form) {
                    $("#calendar_event_form").ajaxSubmit(options);
                },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function (error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
                var pos = target.position();
                var height = target.height();
                var newpos = {left: pos.left, top: pos.top + height + 2}
                var form = $("#calendar_event_form");
                error.appendTo(form).css(newpos);
            }
        });
    });
</script>      

<?php
@$start = explode(' ', $_GET['start']);
@$end = explode(' ', $_GET['end']);
$followup = $_GET['followup'];
//echo '<pre>'; print_r($_GET);die;
?>        



<form action="<?php echo site_url('admin/datafeed') ?>?method=adddetails<?php echo (!empty($event)) ? "&id=" . $id . "&type_id=" . $_GET['type_id'] : ""; ?>" class="fform" id="calendar_event_form" method="post">                 
    <input type="hidden" name="hidden_id" class="hidden_id" value="<?php echo $id; ?>" />
    <input type="hidden" name="hidden_type_id" class="hidden_type_id" value="<?php echo $_GET['type_id']; ?>" />
    <label style="display:none;">                    
        <span>                        *Subject:              
        </span>                    
        <textarea class="required safe" id="Subject" name="Subject" style="width:60%;" ><?php echo (!empty($event)) ? $subject : "" ?></textarea>
        <input id="colorvalue" name="colorvalue" type="hidden" value="<?php echo (!empty($event)) ? $color : "1" ?>" />                
    </label>                 
    <label style="display:none;">                    
        <span >Color:</span>                    
        <div id="calendarcolor" class="containtdiv" title="Color"></div>
    </label>                 
    <br />
 


    <div class="row">
        <div class="control-group col-md-8">
            <label for="name" style="clear:both;">*<?php echo lang('consultant'); ?></label>
            <div class="controls">
                <select name="consultant" class="form-control chzn consultant_id " onchange="color_change(this)" required="required">
                     <option id="" value="1">Select Consultant </option>
                    <?php
                    foreach ($consultant_copy as $new) {
                        $sel = "";
                        if ($consultant == $new->id)
                            $sel = "selected='selected'";
                        echo '<option  id="' . $new->Color . '" value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>	
    </div>              

    <div >

        <label>                    
            <span>*Time:
            </span>     
        </label>               
        <div>  
            <?php
            if (!empty($event)) {

                $sarr = explode(" ", php2JsTime(mySql2PhpTime($starttime)));
                $earr = explode(" ", php2JsTime(mySql2PhpTime($endtime)));
                $etime = explode(":", $earr[1]);
                $stime = explode(":", $sarr[1]);
                $hour_diff = $etime[0] - $stime[0];
                $minute_diff = $etime[1] - $stime[1];
                echo "<script type='text/javascript'>console.log('" . $hour_diff . ":" . $minute_diff . "')</script>";
            }
            ?>    <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate"  type="text" value="<?php echo (!empty($event)) ? $sarr[0] : @$start[0]; ?>" />           
            <input MaxLength="5" class="required time" id="stparttime" name="stparttime"  style="width:60px;"   type="text" value="<?php echo (!empty($event)) ? $sarr[1] : @$start[1]; ?>" />
            <br /><br />
            <label>
                <span>
                    *Slot
                </span>
            </label>
            <div>
                <select name="slot" class="form-control chzn slot_id" id="slot" required>
                    <option value="">Select Slot</option>
                    <option value="15">15 minutes</option>
                    <option value="30">30 minutes</option>
                    <option value="45">45 minutes</option>
                    <option value="60">1 hour</option>
                    <option value="90">1 hour 30 minutes</option>
                    <option value="120">2 hours</option>
                    <option value="150">2 hours 30 minutes</option>

                </select>
            </div>
            <br/>

   <!--<input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" type="text" value="<?php echo (!empty($event)) ? $earr[0] : @$end[0]; ?>" />                       
   <input MaxLength="5" class="required time" id="etparttime" name="etparttime" style="width:60px;" type="text" value="<?php echo (!empty($event)) ? $earr[1] : @$end[1]; ?>" /> -->                                           
            <label class="checkp"> 
                <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1" <?php
                if (!empty($event) && $allday != 0) {
                    echo "checked";
                }
                ?>/>          All Day Event                      
            </label>                    
        </div>                  



        <div class="row"  style="display:none;">	
            <div class="control-group col-md-8">
                <label class="control-label" for="schedule_category">Schedule Category:</label>
                <div class="controls">
                    <select name="schedule_category" class="schedule_category form-control chzn">

                        <option value="2" selected="selected" >Appointment</option>

                    </select>
                </div>
            </div>	
        </div>              

        <div >		
            <div class="control-group">
                <div class="row">
                    <div class="col-md-8">

                        <input type="hidden" name="whom" class="form-control whom" value="1">

                    </div>

                </div>
            </div>



            <div class="control-group patient">
                <div class="row">
                    <div class="col-md-8">
                        <label for="name" style="clear:both;"><?php echo lang('patient'); ?> <a class="btn btn-default" href="javascript:void(0);" onclick="openAddPatient();"><i class="fa fa-plus"></i> <?php echo 'Add Patient' ?> </a></label>
                        <select name="patient_id" id="patientField" class="form-control chzn patient_id " onchange="patient(this)" required>
                            <option value="">--<?php echo lang('select_patient'); ?>--</option>
                            <?php
                            foreach ($contacts as $new) {
                                $sel = "";
                                if ($patient_id == $new->id)
                                    $sel = "selected='selected'";
                                echo '<option id="' . $new->name . '" value="' . $new->id . '" ' . $sel . '>' . $new->name . ',' . $new->username . ',' . $new->email . ',' . $new->contact . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>
            </div>
<div class="control-group clinic">
                <div class="row">
                    <div class="col-md-8">
                        <label for="name" style="clear:both;">Clinic</label>
                        <select name="clinic_id" id="clinicField" class="form-control chzn clinic_id " onchange="clinic(this)" required>
                            <option value="">--select clinic--</option>
                            <?php
                            foreach ($clinics as $new) {
                                $sel = "";
                                if ($clinic_id == $new->clinic_id)
                                    $sel = "selected='selected'";
                                    echo '<option id="' . $new->clinic_name . '" value="' . $new->clinic_id . '" ' . $sel . '>' . $new->clinic_id . ',' . $new->clinic_name . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>
            </div>

            <!--<div class="control-group consultation_charge">
                <div class="row">
                    <div class="col-md-8">
                        <label for="name" style="clear:both;">Consultation fees</label>
                        <input type="text" name="consultation_charge">
                    </div>

                </div>
            </div>-->

            <div class="control-group motive">
                <div class="row">
                    <div class="col-md-8">
                        <label for="name" style="clear:both;"><b><?php echo ('Reason') ?></b></label>
                        <select name="motive" id="adviseField"  class="form-control chzn treatment_advised_id" required>
                            <option value="">--<?php echo lang('treatment_advised'); ?>--</option>

                            <?php
                            foreach ($treatment_Advised as $new) {
                                $sel = "";
                                if ($motive == $new->name)
                                    $sel = "selected='selected'";
                                echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                            }
                            ?>
                        </select>
                <!--<textarea name="motive" class="form-control motive" style="width:60%"><?php
                        if ($followup == '') {
                            echo @$motive;
                        } else {
                            
                        }
                        ?> </textarea> -->
                    </div>
                </div>
            </div>

            <div class="control-group paid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="name" style="clear:both;">
                                    Send Message
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label style="clear:both;"><b>Language</b></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="checkbox" name="is_paid" value="1" class="is_paid" checked="checked" <?php echo (@$is_paid == 1) ? 'checked="checked"' : ''; ?> />
                            </div>
                            <div class="col-md-2">
                                <?php foreach ($sms as $new) { ?>
                                    <?php if ($new['type'] == 'instant') { ?>                        
                                        <select name="lang" class="form-control chzn">
                                            <option value="english" <?php if ($new['lang'] == 'english') echo 'selected="selected"'; ?> >English</option>
                                            <option value="hindi" <?php if ($new['lang'] == 'hindi') echo 'selected="selected"'; ?> >Hindi</option>
                                            <option value="bengali" <?php if ($new['lang'] == 'bengali') echo 'selected="selected"'; ?> >Bengali</option>
                                            <option value="telugu" <?php if ($new['lang'] == 'telugu') echo 'selected="selected"'; ?> >Telugu</option>
                                            <option value="marathi" <?php if ($new['lang'] == 'marathi') echo 'selected="selected"'; ?> >Marathi</option>
                                        </select>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>



            </div>		

            <div id="show_hospital">
                <div class="control-group hospital">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="name" style="clear:both;"><?php echo lang('hospital'); ?></label>
                            <select name="hospital_id" class="form-control chzn patient_id ">
                                <option value="">--Select Hospital--</option>
                                <?php
                                foreach ($hospitals as $new) {
                                    $sel = "";
                                    //if($patient_id==$new->id) $sel = "selected='selected'";
                                    echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div id="show_college">
                <div class="control-group college">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="name" style="clear:both;">Medical College</label>
                            <select name="college_id" class="form-control chzn patient_id ">
                                <option value="">--Select Medical College--</option>
                                <?php
                                foreach ($college as $new) {
                                    $sel = "";
                                    //if($patient_id==$new->id) $sel = "selected='selected'";
                                    echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <?php /* 			

              <label>
              <span>                        Location:
              </span>
              <input MaxLength="200" id="Location" name="Location" style="width:95%;" type="text" value="<?php echo (!empty($event))?$location:""; ?>" />
              </label>
              <label>
              <span>                        Remark:
              </span>
              <textarea cols="20" id="Description" name="Description" rows="2" style="width:95%; height:70px">
              <?php echo (!empty($event))?$description:""; ?>
              </textarea>
              </label>
              <input id="timezone" name="timezone" type="hidden" value="" />
             */ ?>
            </form>         
        </div>         
    </div>
    <style>
        #divcalendarcolor{
            display:none;
        }
    </style>
    <script>
        function patient(ddlFruits) {
            selectedText = ddlFruits.options[ddlFruits.selectedIndex].id;
            document.getElementById("Subject").value = selectedText;
        }
        function color_change(ddlFruits) {
            
            

            selectedText = ddlFruits.options[ddlFruits.selectedIndex].id;
            if(selectedText===null || selectedText==="")
            {
                alert("Please select valid consultant");
            }
            document.getElementById("colorvalue").value = selectedText;
        }
        $("#show_appointment").hide();
        $("#show_hospital").hide()
        $("#show_college").hide()
        $(".patient").hide();
        $(".detail").hide();
        $(".paid").hide();
        $(".contact").hide();
        $(".other").hide();
        setTimeout(function () {
            vch = $('.whom').val();
            //alert(vch);
            if (vch == 1) {

                $("#show_appointment").show();
                $(".patient").show();
                $(".paid").show();
                //$(".contact").hide();
                $(".other").hide();
                $(".detail").hide();
            }

            if (vch == 2) {
                $("#show_appointment").show();
                $(".contact").show();
                $(".patient").hide();
                $(".paid").hide();
                $(".other").hide();
                $(".detail").hide();
            }
            if (vch == 3) {
                $("#show_appointment").show();
                //$(".contact").hide();
                $(".patient").hide();
                $(".paid").hide();
                $(".other").show();
                $(".show").hide();
            }
        }, 100);
		
		function openAddPatient()
		{
			$('.ui-dialog-titlebar-close').click();
			$(".contact").show();
			$('#add').modal('show');
		}
    </script>
