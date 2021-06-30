<link href="<?php echo base_url('assets/') ?>/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/wd/') ?>/css/dailog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/wd/') ?>/css/calendar.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url('assets/wd/') ?>/css/dp.css" rel="stylesheet" type="text/css" />   
<link href="<?php echo base_url('assets/wd/') ?>/css/alert.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url('assets/wd/') ?>/css/main.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url('assets/wd/') ?>/css/colorselect.css" rel="stylesheet" />   
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.colorselect.js" type="text/javascript"></script>   
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.validate.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/') ?>/datepicker_lang_US.js" type="text/javascript"></script>        
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.datepicker.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.dropdown.js" type="text/javascript"></script>     
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/wd/') ?>/css/main.css" rel="stylesheet" type="text/css" />       
<link href="<?php echo base_url('assets/wd/') ?>/css/dp.css" rel="stylesheet" />    
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script type="application/javascript">
var redirectUrl = "<?php echo site_url('admin/patients/view');?>";
</script>
<?php
$consultant = $this->consultant_model->get_consultant_by_consultant();
?>
<style>
    body{overflow-y: hidden !important;
         height:100% !important}
    .bbit-window{padding-top:100px !important} 
    .bbit-window-plain{padding-top:100px !important}
    .color-box {
        display: inline-block;
        width: 15px;
        height: 15px;
        border: solid 1px #555555;
        vertical-align: top;
        margin-top: 2px;
        margin-left: 5px;
    }
    *:not(.col-md-6), *::before, *::after {
        box-sizing: content-box;
    }
    .ui-dialog{z-index:1000000 !important}
    .xdsoft_datetimepicker{z-index:2147483647112121 !important}
</style>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
<script src="<?php echo base_url('assets/js/') ?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/wd/js/') ?>/Common.js" type="text/javascript"></script>    
<script src="<?php echo base_url('assets/wd/js/') ?>/datepicker_lang_US.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.alert.js" type="text/javascript"></script>    
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
<script src="<?php echo base_url('assets/wd/js/') ?>/wdCalendar_lang_US.js" type="text/javascript"></script>    
<script src="<?php echo base_url('assets/wd/js/') ?>/jquery.calendar.js" type="text/javascript"></script>   
<style>
    .chosen-container{width:100% !important}
   
</style>
<script type="text/javascript">
    $(document).ready(function () {		
        setInterval(function () {
            $("#gridcontainer").reload();
        }, 1000 * 60 * 2);
        $('.xdsoft_noselect').hide();
        $('#calendar_event_popup').on('dialogclose', function (event) {

            $('.xdsoft_noselect').hide();
        });
        $('#calendar_event_popup_follow').on('dialogclose', function (event) {

            $('.xdsoft_noselect').hide();
        });
        $('#calendar_event_popup_add').on('dialogclose', function (event) {
            $('.xdsoft_noselect').hide();
        });

        var view = "week";
        var timeformat = 1;
<?php if (!empty($_GET['timeformat'])) { ?>
            var timeformat = <?php echo $_GET['timeformat'] ?>;
<?php } ?>
        var DATA_FEED_URL = "<?php echo site_url('admin/datafeed') ?>";
        var op = {
            view: view,
            theme: 3,
            showday: new Date(),
            EditCmdhandler: Edit,
            AddFollowUpCmdhandler: AddFollowup,
            DeleteCmdhandler: Delete,
            ViewCmdhandler: View,
            onWeekOrMonthToDay: wtd,
            onBeforeRequestData: cal_beforerequest,
            onAfterRequestData: cal_afterrequest,
            onRequestDataError: cal_onerror,
            autoload: true,
            url: DATA_FEED_URL + "?method=list&timeformat=" + timeformat,
            quickAddUrl: DATA_FEED_URL + "?method=add",
            quickUpdateUrl: DATA_FEED_URL + "?method=update",
            quickDeleteUrl: DATA_FEED_URL + "?method=remove"
        };

        var $dv = $("#calhead");
        var _MH = document.documentElement.clientHeight;
        var dvH = $dv.height() + 2;
        op.height = _MH - dvH + 30;
        op.eventItems = [];

        //var $dv = $("#calhead");
        //var _MH = document.documentElement.clientHeight;
        //var dvH = 100;
        //op.height = 800;
        //op.eventItems =[];



        var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
        if (p && p.datestrshow) {

            $("#txtdatetimeshow").text(p.datestrshow);
        }
        $("#caltoolbar").noSelect();

        $("#hdtxtshow").datepicker({picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn: function (r) {
                var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            }
        });
        function cal_beforerequest(type)
        {

            var t = "Loading data...";
            switch (type)
            {
                case 1:
                    t = "Loading data...";
                    break;
                case 2:
                case 3:
                case 4:
                    t = "The request is being processed ...";
                    break;
            }
            $("#errorpannel").hide();
            $("#loadingpannel").html(t).show();
        }
        function cal_afterrequest(type)
        {
            switch (type)
            {
                case 1:
                    $("#loadingpannel").hide();
                    break;
                case 2:
                case 3:
                case 4:
                    $("#loadingpannel").html("Success!");
                    window.setTimeout(function () {
                        $("#loadingpannel").hide();
                    }, 2000);
                    break;
            }

        }
        function cal_onerror(type, data)
        {
            $("#errorpannel").show();
        }
        function Edit(data)
        {
            //console.log(data[3]);
            eurl = "<?php echo site_url('admin/calendar/edit_form') ?>?id={0}&start={2}&end={3}&isallday={4}&title={1}&type_id={10}";
            //$('#edit').modal('show');
            if (data)
            {

                calendar_id = data[0];
                calendar_data = data;

                $('#calendar_event_popup').dialog('open');
                call_loader_ajax();
                $('#stparttime').val(moment().format('h:mm'));
                /*var url = StrFormat(eurl,data);
                 OpenModelWindow(url,{ width: 600, height: 400, caption:"Manage  The Calendar",onclose:function(){
                 $("#gridcontainer").reload();
                 }});*/
            }
        }
        function AddFollowup(data)
        {
            //console.log(data[3]);
            eurl = "<?php echo site_url('admin/calendar/edit_form') ?>?id={0}&start={2}&end={3}&isallday={4}&title={1}&type_id={10}";
            //$('#edit').modal('show');
            if (data)
            {

                calendar_id = data[0];
                calendar_data = data;

                $('#calendar_event_popup_follow').dialog('open');
                call_loader_ajax();
                /*var url = StrFormat(eurl,data);
                 OpenModelWindow(url,{ width: 600, height: 400, caption:"Manage  The Calendar",onclose:function(){
                 $("#gridcontainer").reload();
                 }});*/
            }
        }
        function View(data)
        {
            //window.location = "<?php echo site_url('admin/patients/view/') ?>";
            var str = "";
            $.each(data, function (i, item) {
                str += "[" + i + "]: " + item + "\n";
            });
            window.location = "<?php echo site_url('admin/patients/view') ?>/" + data[9];
            //alert(str);               
        }

        function Delete(data, callback)
        {
            //console.log(data[10]);
            //console.log(callback);
            $.alerts.okButton = "Ok";
            $.alerts.cancelButton = "Cancel";
            //hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});

            hiConfirm("Are You Sure to Delete this Event", 'Confirm', function (r) {
                r && delete_data(data);
            });

        }

        function delete_data(data) {
            $.ajax({
                url: '<?php echo base_url('admin/calendar/delete_event') ?>',
                type: 'POST',
                data: {type_id: data[10], id: data[0], },
                success: function (result) {
                    //alert(result);return false;
                    location.reload();
                }
            });
        }
        function wtd(p)
        {

            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar div.fcurrent").each(function () {
                $(this).removeClass("fcurrent");
            })
            $("#showdaybtn").addClass("fcurrent");
        }
        //to show day view
        $("#showdaybtn").click(function (e) {
            //alert('');
            //document.location.href="#day";
            $("#caltoolbar div.fcurrent").each(function () {
                $(this).removeClass("fcurrent");
            })
            $(this).addClass("fcurrent");
            var p = $("#gridcontainer").swtichView("day").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });

        setTimeout(function () {
            $(this).addClass("fcurrent");
            var p = $("#gridcontainer").swtichView("week").BcalGetOp();
            // console.log(p);
            //console.log(p.datestrshow);
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }

        }, 2000);

        //to show week view
        $("#showweekbtn").click(function (e) {
            //document.location.href="#week";
            $("#caltoolbar div.fcurrent").each(function () {
                $(this).removeClass("fcurrent");
            })
            $(this).addClass("fcurrent");
            var p = $("#gridcontainer").swtichView("week").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }

        });
        //to show month view
        $("#showmonthbtn").click(function (e) {
            //document.location.href="#month";
            $("#caltoolbar div.fcurrent").each(function () {
                $(this).removeClass("fcurrent");
            })
            $(this).addClass("fcurrent");
            var p = $("#gridcontainer").swtichView("month").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });

        $("#showreflashbtn").click(function (e) {
            $("#gridcontainer").reload();
        });


        //Add a new event
        $("#faddbtn").click(function (e) {

            calendar_id = 0;
            calendar_data = [];
            $('#calendar_event_popup_add').dialog('open');
            call_loader_ajax();
            //var url ="http://demo2.ultimateclientmanager.com/?m=calendar&p=calendar_admin_edit&display_mode=iframe";
            //OpenModelWindow(url,{ width: 500, height: 400, caption: 'Create New Calendar Event'});
        });
        //go to today
        $("#showtodaybtn").click(function (e) {
            var p = $("#gridcontainer").gotoDate().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }


        });
        //previous date range
        $("#sfprevbtn").click(function (e) {
            var p = $("#gridcontainer").previousRange().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }

        });
        //next date range
        $("#sfnextbtn").click(function (e) {
            var p = $("#gridcontainer").nextRange().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });

    });
    $("#dte").datetimepicker();
</script>    	

<div id="calendar_event_popup" title="New Appointment">
    <div id="calendar_event_popup_inner"></div>
</div>
<div id="calendar_event_popup_follow" title="Add Follow Up">
    <div id="calendar_event_popup_inner_follow"></div>
</div>	
<div id="calendar_event_popup_add" title="New Appointment">
    <div id="calendar_event_popup_inner_add"></div>
</div>	


<section class="content-header">
    <h1>
        <?php echo $page_title; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo 'Add Patient' ?> </a></li>

    </ol>
</section>

<section class="content">
    <form>
        <!--<div class="row" style="margin-bottom:10px;">
           <div class="col-md-12">
               <div class="btn-group pull-right">
                  <select name="timeformat" class="form-control " onchange="this.form.submit()">
                                                                                               <option value="1" <?php echo (@$_GET['timeformat'] == 1) ? 'selected="selected"' : ''; ?>  >24HR</option>
                                                                                               <option value="2"<?php echo (@$_GET['timeformat'] == 2) ? 'selected="selected"' : ''; ?> >12HR</option>
                                 </select>
                        
                               </div>
           </div>    
       </div>	-->
    </form>		
    <div class="row  col-md-8" > 	
        <div class="box box-primary" >

            <div id="calhead" style="padding-left:1px;padding-right:1px;">          
                <!--<div class="cHead"><div class="ftitle">My Calendar</div>-->
                <!--<div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>-->
                <!--<div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>-->
            </div>          

            <div id="caltoolbar" class="ctoolbar">
                <div id="faddbtn" class="fbutton">
                  <!--<div><span title='Click to Create New Event' class="addcal">
  
                  New Event                
                  </span></div>-->
                </div>
                <div class="btnseparator"></div>
                <!--  <div id="showtodaybtn" class="fbutton">
                     <div><span title='Click to back to today ' class="showtoday">
                     Today</span></div>
                 </div>
                   <div class="btnseparator"></div>
                -->
                <div id="showdaybtn" class="fbutton">
                    <div><span title='Day' class="showdayview">Today</span></div>
                </div>
                <div  id="showweekbtn" class="fbutton fcurrent">
                    <div><span title='Week' class="showweekview">Week</span></div>
                </div>
                <div  id="showmonthbtn" class="fbutton">
                    <div><span title='Month' class="showmonthview">Month</span></div>

                </div>
                <div class="btnseparator"></div>
                <div  id="showreflashbtn" class="fbutton">
                    <div><span title='Refresh view' class="showdayflash">Refresh</span></div>
                </div>
                <div class="btnseparator"></div>
                <div id="sfprevbtn" title="Prev"  class="fbutton">
                    <span class="fprev"></span>

                </div>
                <div id="sfnextbtn" title="Next" class="fbutton">
                    <span class="fnext"></span>
                </div>
                <div class="fshowdatep fbutton">
                    <div>
                        <input type="hidden" name="txtshow" id="hdtxtshow" />
                        <span id="txtdatetimeshow" class="datetimepicker">Loading</span>

                    </div>
                </div>

                <div class="clear"></div>
            </div>


        </div>
        <div style="padding:1px; " style="max-height:900px;">

            <div class="t1 chromeColor">
                &nbsp;</div>
            <div class="t2 chromeColor">
                &nbsp;</div>
            <div id="dvCalMain" class="calmain printborder" >
                <div id="gridcontainer" style="overflow-y: visible;">
                </div>
            </div>
            <div class="t2 chromeColor">

                &nbsp;</div>
            <div class="t1 chromeColor">
                &nbsp;
            </div>   
        </div>

    </div>
    <div class="col-md-3">
        <link href="<?php echo base_url('assets/css/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .custom,
            .custom div,
            .custom span {
                border-color: rgb(0, 115, 183);
                background-color: rgb(0, 115, 183);

                color: white;           /* text color */
            }
            .fc-event-time {
                display:none !important;
            }

            .custom1,
            .custom1 div,
            .custom1 span {
                border-color: rgb(245, 105, 84);
                background-color: rgb(245, 105, 84);
                color: white;           /* text color */
            }


            /*counter metrics*/
            .counter p.count {
                font-size: 28px;
                font-weight: bold;
                line-height: 40px;
            }
            .counter {
                width: 25%;
                float: left;
                display: inline-block;
                text-align: center;
            }
            .counter.yellow p.count {
                color: #FF6600;
            }
            .counter.red p.count {
                color: #FC0000;
            }
            .counter.green p.count {
                color: #68A500;
            }
            .counter.blue p.count {
                color: #0094DE;
            }
            .counter p.info {
                font-size: 11px;
                color: #555;
                height: 22px;
                line-height: 22px;
                border-top: 1px solid #E3E3E3;
                -webkit-border-bottom-right-radius: 5px;
                -webkit-border-bottom-left-radius: 5px;
                -moz-border-radius-bottomright: 5px;
                -moz-border-radius-bottomleft: 5px;
                border-bottom-right-radius: 5px;
                border-bottom-left-radius: 5px;
            }
            .counter a.counter_block {
                cursor: pointer;
                //filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdfdfd', endColorstr='#f0f0f0');
                //background: -webkit-gradient(linear, left top, left bottom, from(#fdfdfd), to(#f0f0f0));
                //background: -moz-linear-gradient(top, #fdfdfd, #f0f0f0);
                //background-image: -o-linear-gradient(top, #fdfdfd, #f0f0f0);
                //background-repeat: repeat-x;
            }

            .counter .counter_block {
                margin-left: 5px;
                margin-right: 5px;
                border-radius: 5px;
                display: block;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
                //background-color: #F9F9F9;
                text-decoration: none;
                border: 1px solid #d7d6d6;
                color: #333;
            }

            #tracker_count_summary {
                margin-left: -3px;
            }

            .bottommargin_5 {
                margin-bottom: 5px;
            }
            .nextstatelink {
                //outline: 1px solid #efefef;
                font-size: 11px;
                padding: 0px 2px;
                margin-right: 2px;
                margin-top: 2px;
                float: right;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
            }

            .nextstatelink {
                background-color: #fff;
            }
            .tracker_eachpatient_content .btn {
                margin: 0px;
            }
            .btn.no-hover-transition:hover {
                transition: none;
                background-image: none;
            }   

            .nextstatelink {
                font-weight: normal;
            }
            .yellow {
                font-weight: bold !important;
            }
            .red {
                color: #f65b5b !important;
                font-weight: bold !important;
            }
            .green {
                color: #608d15 !important;
                font-weight: bold !important;
            }
            .blue {
                color: blue !important;
                font-weight: bold !important;
            }
        </style>
        <div class="row">	
            <section class="col-lg-12 connectedSortable ui-sortable">	
                <div class="box box-primary ">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title"><?php echo lang('todays_appointments'); ?></h3>
                    </div><!-- /.box-header -->

                    <div class="box-header ui-sortable-handle" style="cursor: move;margin-top: 20px;">
                        <div id="tracker_count_summary" class="bottommargin_5">
                            <div class="counter yellow">
                                <a class="counter_block">
                                    <p class="count ng-binding">
                                        <?php
                                        if (isset($metrics['scheduled'])) {
                                            echo $metrics['scheduled'];
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </p>
                                    <p class="info">Scheduled</p>
                                </a>
                            </div>
                            <div  class="counter red">
                                <a class="counter_block">
                                    <p class="count ng-binding">
                                        <?php
                                        if (isset($metrics['waiting'])) {
                                            echo $metrics['waiting'];
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </p>
                                    <p class="info">Waiting</p>
                                </a>
                            </div>
                            <div class="counter green">
                                <a class="counter_block">
                                    <p class="count ng-binding">
                                        <?php
                                        if (isset($metrics['engaged'])) {
                                            echo $metrics['engaged'];
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </p>
                                    <p class="info">Engaged</p>
                                </a>
                            </div>
                            <div  class="counter blue">
                                <a class="counter_block">
                                    <p class="count ng-binding">
                                        <?php
                                        if (isset($metrics['checked_out'])) {
                                            echo $metrics['checked_out'];
                                        } else {
                                            echo "0";
                                        }
                                        ?>
                                    </p>
                                    <p class="info">Checked out</p>
                                </a>
                            </div>
                            <div class="clearleft"></div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-tools pull-right"> </div>
                    <div class="controls" style="margin: 0 13px;">

                        <select name="select_consultant" class="select_consultant form-control chzn" style="width: 75%;height: 31%;    margin-top: 20px;">

                            <option value="">Select Consultant</option>
                            <?php foreach ($consultant as $new) { ?>
                                <option value="<?php echo $new->id; ?>"><?php echo $new->name; ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="box-body">
                        <ul class="todo-list ui-sortable" id="select_consult">
                            <?php

                            function sort_appointments($a, $b) {
                                $atime = strtotime($a->date);
                                $btime = strtotime($b->date);
                                if ($atime == $btime)
                                    return 0;
                                else if ($atime < $btime)
                                    return -1;
                                else
                                    return 1;
                            }

                            if (isset($appointmentspr)):
                                usort($appointmentspr, sort_appointments);
                                ?>        
                                <?php
                                $i = 1;
                                foreach ($appointmentspr as $new) {
                                    $with = "";
                                    if (($new->whom == 1)) {
                                        $with = $new->name;
                                    }
                                    if (($new->whom == 2)) {
                                        $with = $new->contact;
                                    }
                                    if (($new->whom == 3)) {
                                        $with = $new->other;
                                    }
                                    ?>
                                    <li style="background:#<?php echo $new->Color; ?>;">
                                        <!-- drag handle -->
                                        <span class="handle ui-sortable-handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                        <!-- todo text -->
                                        <span class="text">
                                            <a href="<?php echo site_url('admin/appointments/view_appointment/' . $new->id); ?>"><?php echo date("h:i:a", strtotime($new->date)) . " - " . $with; ?> </a>
                                        </span>
                                        <!-- Emphasis label -->

                                        <!-- General tools such as edit or delete-->

                                        <?php if ($new->status_flag == 0) { ?>
                                            <a  href="<?php echo site_url('admin/appointments/approved/' . $new->id . '/1'); ?>" class="btn no-hover-transition nextstatelink red">
                                                Check In
                                            </a>
                                        <?php } if ($new->status_flag == 1) { ?>
                                            <a  href="<?php echo site_url('admin/appointments/approved/' . $new->id . '/2'); ?>" class="btn no-hover-transition nextstatelink green">
                                                Engage
                                            </a>
                                        <?php } if ($new->status_flag == 2) { ?>
                                            <a href="<?php echo site_url('admin/appointments/approved/' . $new->id . '/3'); ?>" class="btn no-hover-transition nextstatelink blue">
                                                Check Out
                                            </a>
                                        <?php } ?>


                                        <div class="tools">
                                            <i class="fa fa-eye"></i>

                                        </div>
                                    </li>
                                    <?php
                                    $i++;
                                }
                                ?>
                            <?php endif; ?>	
                        </ul>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix no-border">
                       <!--<button class="btn btn-default pull-right"><a href="<?php echo site_url('admin/appointments'); ?>"><i class="fa fa-plus"></i> <?php echo lang('view_all'); ?></a></button>-->
                    </div>
                </div>		
            </section>



            <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
            <script src="<?php echo base_url('assets/js/plugins/morris/morris.min.js') ?>" type="text/javascript"></script>
            <!-- Sparkline -->
            <script src="<?php echo base_url('assets/js/plugins/sparkline/jquery.sparkline.min.js') ?>" type="text/javascript"></script>
            <!-- jvectormap -->
            <script src="<?php echo base_url('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>" type="text/javascript"></script>
            <!-- fullCalendar -->
            <script src="<?php echo base_url('assets/js/moment.min.js') ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/fullcalendar.min.js') ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/plugins/datepicker/bootstrap-datepicker.js') ?>" type="text/javascript"></script>

            <!-- jQuery Knob Chart -->
            <script src="<?php echo base_url('assets/js/plugins/jqueryKnob/jquery.knob.js') ?>" type="text/javascript"></script>
            <!-- daterangepicker -->
            <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
            <script src="<?php //echo base_url('assets/js/AdminLTE/dashboard.js')                                    ?>" type="text/javascript"></script>  
            <script src="<?php echo base_url('assets/js/raphael-min.js') ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/morris.min.js') ?>" type="text/javascript"></script>

            <script>
    var appiont_data = $("#select_consult").html();
    $(".select_consultant").change(function () {
        var select_val = $(this).val();

        if (select_val == '') {
            $("#select_consult").html(appiont_data);
        } else {
            $("#select_consult").html('No Appointments');
            var dataString = 'consultant_id=' + select_val;
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('admin/calendar/consultant_appoint_data') ?>?select_consult=' + select_val,
                data: dataString,
                dataType: "html",
                success: function (d) {
                    $('#select_consult').html(d);
                    // ucm.init_interface();
                }
            });
        }

    });
    $(function () {
        $("#calendar").datepicker().datepicker("setDate", "0");    // Here the current date is set
        $('#txtdatetimeshow').datetimepicker({timepicker: false, format: 'Y-m-d', autoclose: true});
        $('#txtdatetimeshow').on('change', function (e) {
            console.log(e.currentTarget.value);
            var r = moment(e.currentTarget.value).toDate();
            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });

    });

    var line = new Morris.Line({
        element: 'p-chart',
        resize: true,
        data: [
            {patients: '<?php echo (empty($date6->count)) ? 0 : $date6->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-6 days")); ?>'},
            {patients: '<?php echo (empty($date5->count)) ? 0 : $date5->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-5 days")); ?>'},
            {patients: '<?php echo (empty($date4->count)) ? 0 : $date4->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-4 days")); ?>'},
            {patients: '<?php echo (empty($date3->count)) ? 0 : $date3->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-3 days")); ?>'},
            {patients: '<?php echo (empty($date2->count)) ? 0 : $date2->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-2 days")); ?>'},
            {patients: '<?php echo (empty($date1->count)) ? 0 : $date1->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-1 days")); ?>'},
            {patients: '<?php echo (empty($date->count)) ? 0 : $date->count; ?>', date: '<?php echo date('Y-m-d'); ?>'},
        ],
        xkey: 'date',
        ykeys: ['patients'],
        labels: ['Patients'],
        lineColors: ['#3c8dbc'],
        hideHover: 'auto',
        parseTime: false,
        xLabelAngle: 45,
    });

            </script>
           <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:600px">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('patient') ?></h4>
            </div>
            <div class="modal-body">
                <div id="err">  
                    <?php
                    if (validation_errors()) {
                        ?>
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                            <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
                        </div>

                    <?php } ?>  
                </div>
                <form method="post" action="<?php echo site_url('admin/patients/add/') ?>" id="add_form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                    <input type="text" name="name" value="<?php echo set_value('name') ?>" class="form-control name">
                                </div>
                               <!-- <div class="col-md-6">
                                    <label for="date" style="clear:both">Date of Creation</label>
                                    <input type="text" id="dte" name="date" class="form-control datetimepicker" />
                                </div> -->
                                 <div class="col-md-6">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                    <br/><input type="radio" name="gender" class="gender"value="Male" <?php echo (set_value('gender') == "Male") ? 'checked="checked"' : ''; ?>  /> <?php echo lang('male') ?>
                                    <input type="radio" name="gender" class="gender" value="Female"  <?php echo (set_value('gender') == "Female") ? 'checked="checked"' : ''; ?>/> <?php echo lang('female') ?>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <!--<div class="col-md-6">-->
                                <!--    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>-->
                                <!--    <textarea name="address"  class="form-control address"><?php echo set_value('address') ?></textarea>-->
                                <!--</div>-->
                                 <div class="col-md-6">
                                    <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                    <input type="text" name="email" value="<?php echo set_value('email') ?>" class="form-control email">
                                </div>
                                <div class="col-md-6">
                                    <label for="medicalhistory" style="clear:both">Medical History</label>
                                    <select name="medical_History[]" class="form-control chzn" multiple="multiple">
                                        <?php
                                        foreach ($medical_history as $new) {
                                            echo '<option>' . $new->name . '</option>';
                                        }
                                        ?>
                                    </select>                                  
                                </div> 
                            </div>
                        </div>
                        
            <div class="inputs" id="hidden">
                        <div class="form-group">
                            <div class="row">
                               
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="dob" style="clear:both;">Age</label>
                                    <input type="text" name="dob" value="<?php echo set_value('dob') ?>" class="form-control dob" >

                                </div>
                                <!-- <div class="col-md-2">-->
                                   
                                <!--    <input type="hidden" name="dob1" value="<?php echo set_value('dob') ?>" class="form-control dob" style="width:90px">-->

                                <!--</div>-->
                                <!-- <div class="col-md-2">-->
                                   
                                <!--    <input type="hidden" name="dob2" value="<?php echo set_value('dob') ?>" class="form-control dob" style="width:90px">-->

                                <!--</div>-->
                                <div class="col-md-6">
                                    <label for="referredby" style="clear:both">Referred By</label>
                                    <input type="text" name="referredby" class="form-control" />                               
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                    <input type="text" name="contact" value="<?php echo set_value('contact') ?>" class="form-control contact">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                    <textarea name="address"  class="form-control address"><?php echo set_value('address') ?></textarea>
                                </div>
                                <!--<div class="col-md-6">-->
                                <!--    <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>-->
                                <!--    <input type="text" name="contact1" value="<?php echo set_value('contact') ?>" class="form-control contact">-->
                                <!--</div>-->
                                <!--<div class="col-md-6">-->
                                <!--    <label for="aadhar" style="clear:both">Aadhar</label>-->
                                <!--    <input type="text" name="aadhar" class="form-control" />                               -->
                                <!--</div>-->
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <div class="row">-->
                               
                        <!--        <div class="col-md-6">-->
                        <!--            <label for="insurance" style="clear:both">Name of Insurance (If any)</label>-->
                        <!--            <input type="text" name="insurance" class="form-control" />                               -->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->


                   <!--     <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type'); ?></label>
                                    <select name="blood_id" class="form-control chzn blood_id">
                                        // <option value="">--<?php echo lang('select_blood_type'); ?>--</option>
                                        // <?php
                                        // foreach ($groups as $new) {
                                        //     $sel = "";
                                        //     if (set_select('blood_id', $new->id))
                                        //         $sel = "selected='selected'";
                                        //     echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                        // }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="group" style="clear:oth">Group</label>
                                    <input type="text" name="group" class="form-control" size="50" />                               
                                </div>
                            </div>
                        </div>  -->






                  <!--      <?php
                        if ($fields) {
                            foreach ($fields as $doc) {
                                $output = '';
                                if ($doc->field_type == 1) { //testbox
                                    ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                <input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" id="req_doc" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($doc->field_type == 2) { //dropdown list
                                    $values = explode(",", $doc->values);
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                <select name="reply[<?php echo $doc->id ?>]" class="form-control">
                                                    <?php
                                                    foreach ($values as $key => $val) {
                                                        echo '<option value="' . $val . '">' . $val . '</option>';
                                                    }
                                                    ?>			
                                                </select>	
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($doc->field_type == 3) { //radio buttons
                                    $values = explode(",", $doc->values);
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

                                                <?php foreach ($values as $key => $val) { ?>

                                                    <input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" />	<?php echo $val; ?> &nbsp; &nbsp; &nbsp; &nbsp;
                                                <?php }
                                                ?>			
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                if ($doc->field_type == 4) { //checkbox
                                    $values = explode(",", $doc->values);
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

                                                <?php foreach ($values as $key => $val) { ?>

                                                    <input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" class="form-control" />	<?php echo $val; ?>&nbsp; &nbsp; &nbsp; &nbsp;
                                                <?php }
                                                ?>			
                                            </div>
                                        </div>
                                    </div>
                                <?php } if ($doc->field_type == 5) { //Textarea
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                <textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
                                                ></div>
                                        </div>
                                    </div>



                                    <?php
                                }
                            }
                        }
                        ?>	 -->

                        <button type="submit" class="btn btn-primary" ><?php echo lang('save') ?></button>

                    </div><!-- /.box-body -->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
            </div>
        </div>
    </div>
</div>




            <!--<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content ff">
                  <div class="modal-header">
                                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('patient') ?></h4>
                  </div>
                  <div class="modal-body">
                       <div id="err">  
            <?php
            if (validation_errors()) {
                ?>
                                                                                                                                                                            <div class="alert alert-danger alert-dismissable">
                                                                                                                                                                                                                                                            <i class="fa fa-ban"></i>
                                                                                                                                                                                                                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                                                                                                                                                                                                                                            <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                            
            <?php } ?>  
                                    </div>
                                                    <form method="post" action="<?php echo site_url('admin/patients/add/') ?>" id="add_form" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                            <div class="row">
                                            <div class="col-md-6">
                                                <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                                                                    <input type="text" name="name" value="<?php echo set_value('name') ?>" class="form-control name">
                                            </div>
                                        </div>
                                    </div>
                                                             <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                                                                    <textarea name="address"  class="form-control address"><?php echo set_value('address') ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                                                    
                                                            <div class="form-group">
                                            <div class="row">
                                            <div class="col-md-6">
                                                <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                                                                    <input type="radio" name="gender" class="gender"value="Male" <?php echo (set_value('gender') == "Male") ? 'checked="checked"' : ''; ?>  /> <?php echo lang('male') ?>
                                                                                    <input type="radio" name="gender" class="gender" value="Female"  <?php echo (set_value('gender') == "Female") ? 'checked="checked"' : ''; ?>/> <?php echo lang('female') ?>
                                            </div>
                                        </div>
                                    </div>
                                                            
                                                                     <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <label for="dob" style="clear:both;">Age</label>
                                                                                    <input type="text" name="dob" value="<?php echo set_value('dob') ?>" class="form-control dob">
                                                                                    
                                                                                    </div>
                                                                            </div>
                                                                    </div>
                                                             <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                                                                    <input type="text" id="contact"  name="contact" value="<?php echo set_value('contact') ?>" class="form-control ">
                                            </div>
                                        </div>
                                    </div>
                                                            <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                                                                    <input type="text" name="email" value="<?php echo set_value('email') ?>" class="form-control email">
                                            </div>
                                        </div>
                                    </div>
                                                            
            <?php $groups = $this->patient_model->get_blood_group(); ?>
                                                            <div class="form-group">
                                            <div class="row">
                                            <div class="col-md-6">
                                                <label for="name" style="clear:both;"><?php echo lang('blood_type'); ?></label>
                                                                                       <select name="blood_id" id="blood_id" class="form-control  ">
                                                                                                    <option value="">--<?php echo lang('select_blood_type'); ?>--</option>
            <?php
            foreach ($groups as $new) {
                $sel = "";

                echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
            }
            ?>
                                                                                            </select>
                                            </div>
                                        </div>
                                    </div>
                           
                                                    
                                                            
                                    
                                                            <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <label for="password" style="clear:both;"><?php echo lang('password') ?></label>
                                                                                    <input type="password" name="password" value="" class="form-control password">
                                            </div>
                                        </div>
                                    </div>
                                                            
                                                            <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <label for="password" style="clear:both;"><?php echo lang('confirm') ?> <?php echo lang('password') ?></label>
                                                                                    <input type="password" name="confirm" value="" class="form-control confirm">
                                            </div>
                                        </div>
                                    </div>
                    <div class="form-group">
                                          <div class="row">
                                            <div class="col-md-6">
                                                <label  style="clear:both;"><?php echo 'Group' ?> </label>
                                                                                    <input type="text" name="group" value="" class="form-control group">
                                            </div>
                                        </div>
                                    </div>
                                            
                                                            
                                                            
                                                            
                                                            
            <?php
            if ($fields) {
                foreach ($fields as $doc) {
                    $output = '';
                    if ($doc->field_type == 1) { //testbox
                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" id="req_doc" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                        <?php
                    }
                    if ($doc->field_type == 2) { //dropdown list
                        $values = explode(",", $doc->values);
                        ?>	<div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <select name="reply[<?php echo $doc->id ?>]" class="form-control">
                        <?php
                        foreach ($values as $key => $val) {
                            echo '<option value="' . $val . '">' . $val . '</option>';
                        }
                        ?>			
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </select>	
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                        <?php
                    }
                    if ($doc->field_type == 3) { //radio buttons
                        $values = explode(",", $doc->values);
                        ?>	<div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                                                                                                                                                                                    
                        <?php foreach ($values as $key => $val) { ?>
                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" />	<?php echo $val; ?> &nbsp; &nbsp; &nbsp; &nbsp;
                        <?php }
                        ?>			
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                    
                        <?php
                    }
                    if ($doc->field_type == 4) { //checkbox
                        $values = explode(",", $doc->values);
                        ?>	<div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                                                                                                                                                                                    
                        <?php foreach ($values as $key => $val) { ?>
                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" class="form-control" />	<?php echo $val; ?>&nbsp; &nbsp; &nbsp; &nbsp;
                        <?php }
                        ?>			
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                    <?php } if ($doc->field_type == 5) { //Textarea
                        ?>	<div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                    
                                                                                                                                                                                                                    
                                                                                                                                                                                                                    
                        <?php
                    }
                }
            }
            ?>	
                             
                                    <button type="submit" class="btn btn-primary" ><?php echo lang('save') ?></button>
                             
                                </div>
                
                        </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                  </div>
                </div>
              </div>
            </div>-->

            <script>
                // scripts to open the modal window for our event editing:
                $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
                    options.async = true;
                });

                var calendar_id = 0; // currently editing calendar event id?
                var calendar_data = []; // currently editing calendar event id?
                $(function () {
                    $("#calendar_event_popup").dialog({
                        autoOpen: false,
                        height: 600,
                        width: 500,
                        modal: true,
                        buttons: {
                            'Save': function () {
                                 if($('#calendar_event_form').valid() 
                                        && document.getElementsByClassName('consultant_id')[0].value != ''
                                        && document.getElementsByClassName('patient_id')[0].value != ''
                                          && document.getElementsByClassName('treatment_advised_id')[0].value != ''
                                          && document.getElementsByClassName('slot_id')[0].value != ''
                                        ) {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo site_url('admin/datafeed') ?>?method=adddetails&id=' + calendar_data[0] + '&type_id=' + calendar_data[10],
                                    data: $('#calendar_event_form').serialize(),
                                    dataType: 'html',
                                    success: function (d) {
                                        // refresh the calender with these new changes
                                       // message = JSON.parse(d);
                                       // alert(message.Msg);

                                        $("#calendar_event_popup").dialog('close');
                                        $("#gridcontainer").reload();
                                    },
                                    error: function (header, status, error) {
                                        console.log('ajax answer post returned error ' + header + ' ' + status + ' ' + error);
                                    }
                                });
                                        }else{
                                 alert("All fields are required");
                                    return false;
                                }
                            },
                            'Cancel': function () {
                                $('.xdsoft_noselect').hide();
                                $(this).dialog('close');

                            }
                        },
                        open: function () {

                            var calendar_data_for_post = {};
                            if (typeof calendar_data[0] != 'undefined') {
                                calendar_data_for_post['calendar_id'] = calendar_data[0];
                            }
                            if (typeof calendar_data[1] != 'undefined') {
                                calendar_data_for_post['title'] = calendar_data[1];
                            }
                            if (typeof calendar_data[2] != 'undefined') {
                                console.log(calendar_data[2]);
                                if (calendar_data[2].toString().split(' ')[1] == '00:00') {
                                    var time = moment().format('hh:mm');
                                    var date = moment(calendar_data[2].toString().split(' ')[0]).format('D/MM/YYYY');
                                    var date_time = date + ' ' + time;
                                    calendar_data[2] = date_time;
                                    calendar_data_for_post['start_date_time'] = date_time
                                }
                                else
                                {
                                    calendar_data_for_post['start_date_time'] = calendar_data[2];
                                }

                            }
                            if (typeof calendar_data[3] != 'undefined') {
                                calendar_data_for_post['end_date_time'] = calendar_data[3];
                            }
                            if (typeof calendar_data[4] != 'undefined') {
                                calendar_data_for_post['is_all_day'] = calendar_data[4];
                            }
                            $('#stparttime').val(moment().format('h:mm'));
                            $.ajax({
                                type: "POST",
                                //   url: '<?php echo site_url('admin/calendar/edit_form') ?>?id={0}&start={2}&end={3}&isallday={4}&title={1}&type_id={10}',
                                url: '<?php echo site_url('admin/calendar/edit_form') ?>?id=' + calendar_data[0] + '&start=' + calendar_data[2] + '&end=' + calendar_data[3] + '&isallday=' + calendar_data[4] + '&title=' + calendar_data[1] + '&type_id=' + calendar_data[10],
                                data: calendar_data_for_post,
                                dataType: "html",
                                success: function (d) {
                                    $("#overlay").remove();
                                    $('#calendar_event_popup_inner').html(d);
                                    // ucm.init_interface();
                                }
                            });
                        },
                        close: function () {
                            $('#calendar_event_popup_inner').html('');

                        }
                    });

                });

                $(function () {
                    $("#calendar_event_popup_follow").dialog({
                        autoOpen: false,
                        height: 600,
                        width: 500,
                        modal: true,
                        buttons: {
                            'Save ': function () {
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo site_url('admin/datafeed') ?>?method=adddetails&id=' + calendar_data[0] + '&type_id=' + calendar_data[10] + '&add_follow=add_follow_up',
                                    data: $('#calendar_event_form').serialize(),
                                    dataType: 'html',
                                    success: function (d) {
                                        // refresh the calender with these new changes
                                       // message = JSON.parse(d);
                                        //alert(message.Msg);

                                        $("#calendar_event_popup_follow").dialog('close');
                                        $("#gridcontainer").reload();
                                    },
                                    error: function (header, status, error) {
                                        console.log('ajax answer post returned error ' + header + ' ' + status + ' ' + error);
                                    }
                                });
                            },
                            'Cancel': function () {
                                $('.xdsoft_noselect').hide();
                                $(this).dialog('close');

                            }
                        },
                        open: function () {
                            console.log(calendar_data[2]);
                            var calendar_data_for_post = {};
                            if (typeof calendar_data[0] != 'undefined') {
                                calendar_data_for_post['calendar_id'] = calendar_data[0];
                            }
                            if (typeof calendar_data[1] != 'undefined') {
                                calendar_data_for_post['title'] = calendar_data[1];
                            }
                            if (typeof calendar_data[2] != 'undefined') {
                                calendar_data_for_post['start_date_time'] = calendar_data[2];
                                console.log(calendar_data[2]);
                            }
                            if (typeof calendar_data[3] != 'undefined') {
                                calendar_data_for_post['end_date_time'] = calendar_data[3];
                            }
                            if (typeof calendar_data[4] != 'undefined') {
                                calendar_data_for_post['is_all_day'] = calendar_data[4];
                            }
                            $.ajax({
                                type: "POST",
                                //   url: '<?php echo site_url('admin/calendar/edit_form') ?>?id={0}&start={2}&end={3}&isallday={4}&title={1}&type_id={10}',
                                url: '<?php echo site_url('admin/calendar/edit_form') ?>?id=' + calendar_data[0] + '&followup=add_follow&start=' + calendar_data[2] + '&end=' + calendar_data[3] + '&isallday=' + calendar_data[4] + '&title=' + calendar_data[1] + '&type_id=' + calendar_data[10],
                                data: calendar_data_for_post,
                                dataType: "html",
                                success: function (d) {
                                    $("#overlay").remove();
                                    $('#calendar_event_popup_inner_follow').html(d);
                                    // ucm.init_interface();
                                }
                            });
                        },
                        close: function () {
                            $('#calendar_event_popup_inner_follow').html('');

                        }
                    });

                });




                $(function () {

                    $("#calendar_event_popup_add").dialog({
                        autoOpen: false,
                        height: 600,
                        width: 500,
                        modal: true,
                        buttons: {
                            'Save ': function () {

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo site_url('admin/datafeed') ?>?method=add_form',
                                    data: $('#calendar_event_form').serialize(),
                                    dataType: 'html',
                                    success: function (d) {

                                        // refresh the calender with these new changes
                                        $("#calendar_event_popup_add").dialog('close');
                                        $("#gridcontainer").reload();
                                        //console.log(d.Msg);
                                       // message = JSON.parse(d);
                                       // alert(message.Msg);
                                    },
                                    error: function (header, status, error) {
                                        console.log('ajax answer post returned error ' + header + ' ' + status + ' ' + error);
                                    }
                                });
                            },
                            'Cancel': function () {
                                $('.xdsoft_noselect').hide();
                                $(this).dialog('close');

                            }
                        },
                        open: function () {
                            var calendar_data_for_post = {};
                            if (typeof calendar_data[0] != 'undefined') {
                                calendar_data_for_post['calendar_id'] = calendar_data[0];
                            }
                            if (typeof calendar_data[1] != 'undefined') {
                                calendar_data_for_post['title'] = calendar_data[1];
                            }
                            if (typeof calendar_data[2] != 'undefined') {
                                console.log(calendar_data[2]);


                                calendar_data_for_post['start_date_time'] = calendar_data[2];

                            }
                            if (typeof calendar_data[3] != 'undefined') {
                                calendar_data_for_post['end_date_time'] = calendar_data[3];
                            }
                            if (typeof calendar_data[4] != 'undefined') {
                                calendar_data_for_post['is_all_day'] = calendar_data[4];
                            }
                            $.ajax({
                                type: "POST",
                                //   url: '<?php echo site_url('admin/calendar/add_form') ?>?id={0}&start={2}&end={3}&isallday={4}&title={1}&type_id={10}',
                                url: '<?php echo site_url('admin/calendar/add_form') ?>?id=' + calendar_data[0] + '&start=' + calendar_data[2] + '&end=' + calendar_data[3] + '&isallday=' + calendar_data[4] + '&title=' + calendar_data[1] + '&type_id=' + calendar_data[10],
                                data: calendar_data_for_post,
                                dataType: "html",
                                success: function (d) {

                                    $("#overlay").remove();
                                    $('#calendar_event_popup_inner_add').html(d);
                                    // ucm.init_interface();
                                }
                            });
                        },
                        close: function () {
                            $('#calendar_event_popup_inner_add').html('');

                        }
                    });

                });

            </script>
            <script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
            <script type="text/javascript">
                $("#add_form").submit(function (event) {
                    name = $('.name').val();
                    gender = $('input:radio[name=gender]:checked').val();
                    blood_id = $('#blood_id').val();
                    dob = $('.dob').val();
                    //username = $('.username_u').val();
                    email = $('.email').val();
                    password = $('.password').val();
                    conf = $('.confirm').val();
                    contact = $('#contact').val();
                      contact1 = $('#contact1').val();
                    address = $('.address').val();
                    group = $('.group').val();
                    //alert(blood_id);return false;

                    call_loader_ajax();
                    $.ajax({
                        url: '<?php echo base_url('admin/patients/add') ?>',
                        type: 'POST',
                        //data:{name:name,gender:gender,blood_id:blood_id,dob:dob,email:email,password:password,confirm:conf,contact:contact,address:address,group:group},
                        data: $('#add_form').serialize(),
                        success: function (result) {
                            //alert(result);return false;
                            if (result == 1)
                            {
                                //alert("value=0");
                                //$('#myModal').fadeOut(500);
                                location.reload();
                                $('#add').modal('hide');
                                window.close();
                            }
                            else
                            {
                                $("#overlay").hide();
                                $('#err').html(result);
                            }

                            $(".chzn").chosen();
                        }
                    });

                    event.preventDefault();
                });
            </script>
<!--<script>$(function()-->
<!--{-->
<!--  $(".js-example-basic-multiple").select2();-->
<!--});</script>-->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/scroller/1.4.3/js/dataTables.scroller.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>-->
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<!--<script src="https://code.jquery.com/jquery-1.11.3.js"></script> --->
<script>
    $(document).ready(function(){
        $("#boxchecked").click(function (){
            if ($("#boxchecked").prop("checked")){
                $("#hidden").hide();
            }else{
                $("#hidden").show();
            }              
        });
    });
</script>
<script type="text/javascript">
                    // $("#add_form").submit(function (event) {
                    //     name = $('.name').val();
                    //     gender = $('input:radio[name=gender]:checked').val();
                    //     blood_id = $('.blood_id').val();
                    //     dob = $('.dob').val();
                    //      dob1 = $('.dob1').val();
                    //       dob2 = $('.dob2').val();
                    //     //username = $('.username_u').val();
                    //     email = $('.email').val();
                    //     password = $('.password').val();
                    //     conf = $('.confirm').val();
                    //     contact = $('.contact').val();
                    //     address = $('.address').val();
                    //     group = $('.group').val();
                    //     //alert(blood_id);return false;

                    //     call_loader_ajax();
                    //     $.ajax({
                    //         url: '<?php echo base_url('admin/patients/add') ?>',
                    //         type: 'POST',
                    //         //data:{name:name,gender:gender,blood_id:blood_id,dob:dob,dob1:dob1,dob2:dob2,email:email,password:password,confirm:conf,contact:contact,address:address,group:group},
                    //         data: $('#add_form').serialize(),
                    //         success: function (result) {
                    //             //alert(result);return false;
                    //             if (result == 1)
                    //             {
                    //                 //alert("value=0");
                    //                 //$('#myModal').fadeOut(500);
                    //                 location.reload();
                    //                 $('#add').modal('hide');
                    //                 window.close();
                    //             } else
                    //             {
                    //                 $("#overlay").hide();
                    //                 $('#err').html(result);
                    //             }

                    //             $(".chzn").chosen();
                    //         }
                    //     });

                    //     event.preventDefault();
                    // });

                    $(".update").click(function (event) {
                        event.preventDefault();
//$(this).closest("form").submit();	
                        var form = $(this).closest('form');
                        id = $(form).find('input[name=id]').val();
                        name = $(form).find('input[name=name]').val();
                        gender = $('input:radio[name=gender]:checked').val();
                        blood_id = $(form).find('.blood_id').val();
                        dob = $(form).find('input[name=dob]').val();
                        //username = $(form ).find('input[name=username]').val();
                        email = $(form).find('input[name=email]').val();
                        password = $(form).find('input[name=password]').val();
                        conf = $(form).find('input[name=confirm]').val();
                        contact = $(form).find('input[name=contact]').val();
                        contact1 = $(form).find('input[name=contact1]').val();
                        address = $(form).find('.address').val();
                        //alert(blood_id);return false;
                        call_loader_ajax();
                        $.ajax({
                            url: '<?php echo base_url('admin/patients/edit') ?>/' + id,
                            type: 'POST',
                            data: {name: name, gender: gender, blood_id: blood_id, dob: dob, email: email, password: password, confirm: conf, contact: contact, contact1: contact1, address: address},
                            success: function (result) {
                                //alert(result);return false;
                                if (result == 1)
                                {
                                    location.reload();
                                    // $('#edit'+id).modal('hide');
                                    //window.close(); 
                                } else
                                {
                                    $("#overlay").hide();
                                    $('#err_edit' + id).html(result);
                                }

                                $(".chzn").chosen();
                            }
                        });


                    });



                    $(document).ready(function () {
                        /*$( '#example1' ).dataTable( {
                         "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                         // Bold the grade for all 'A' grade browsers
                         if ( aData[4] == "A" )
                         {
                         $('td:eq(4)', nRow).html( '<b>A</b>' );
                         }
                         }
                         } );*/

//                        $('#example1').DataTable({
//                            deferRender: true,
//                            scrollY: 600,
//                            scrollCollapse: true,
//                            scroller: true
//                        });
                        $('#example1').DataTable({
                            "paging": true,
                            "processing": true, //Feature control the processing indicator.
                            "serverSide": true, //Feature control DataTables' server-side processing mode.
                            "order": [], //Initial no order.

                            // Load data for the table's content from an Ajax source
                            "ajax": {
                                "url": "<?php echo site_url('admin/patients/ajax_list') ?>",
                                "type": "POST"
                            },
                            //Set column definition initialisation properties.
                            "columnDefs": [
                                {
                                    //"targets": [0], //first column / numbering column
                                    "orderable": false, //set not orderable
                                },
                            ],
                        });
                    });

                    $(function () {
                        $(".chzn").chosen({search_contains: true});
                    });
                    jQuery('.datepicker').datetimepicker({
                        lang: 'en',
                        i18n: {
                            de: {
                                months: [
                                    'Januar', 'Februar', 'M�rz', 'April',
                                    'Mai', 'Juni', 'Juli', 'August',
                                    'September', 'Oktober', 'November', 'Dezember',
                                ],
                                dayOfWeek: [
                                    "So.", "Mo", "Di", "Mi",
                                    "Do", "Fr", "Sa.",
                                ]
                            }
                        },
                        timepicker: false,
                        format: 'Y-m-d'
                    });

                    jQuery('.datetimepicker').datetimepicker({
                        lang: 'en',
                        i18n: {
                            de: {
                                months: [
                                    'Januar', 'Februar', 'M�rz', 'April',
                                    'Mai', 'Juni', 'Juli', 'August',
                                    'September', 'Oktober', 'November', 'Dezember',
                                ],
                                dayOfWeek: [
                                    "So.", "Mo", "Di", "Mi",
                                    "Do", "Fr", "Sa.",
                                ]
                            }
                        },
                        timepicker: false,
                        format: 'Y-m-d'
                    });

                    $(document).on('change', '#patient_id', function () {
                        vch = $(this).val();

                        call_loader_ajax();

                        $.ajax({
                            url: '<?php echo base_url('admin/patients/get_patient') ?>',
                            type: 'POST',
                            data: {id: vch},
                            success: function (result) {
                                //alert(result);return false;

                                $('#result').html(result);
                                $(".chzn").chosen({search_contains: true});
                                //$('#example1').dataTable({});
                                $var = '<?php echo site_url('admin/patients/ajax_list') ?>';
                                $('#example1').DataTable({
                                    "paging": true,
                                    "processing": true, //Feature control the processing indicator.
                                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                                    "order": [], //Initial no order.

                                    // Load data for the table's content from an Ajax source
                                    "ajax": {
                                        "url": $var,
                                        "type": "POST"
                                    },
                                    //Set column definition initialisation properties.

                                    "columnDefs": [
                                        {
                                            "targets": [0], //first column / numbering column
                                            "orderable": false, //set not orderable
                                        },
                                    ],
                                });

                                $("#overlay").hide();

                            }
                        });
                    });
</script>

<script>
    $("#example1 tbody td").on('click', function () {
        var id = $(this).attr('id');
        document.location.href = "<?php echo site_url('admin/patients/view/') ?>/" + id;
    });

</script>

