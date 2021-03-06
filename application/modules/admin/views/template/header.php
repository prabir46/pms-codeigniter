<?php
error_reporting(0);
$CI = get_instance();
$CI->load->model('setting_model');
$CI->load->model('notification_model');
$CI->load->model('message_model');
$CI->load->model('language_model');
$CI->load->model('prescription_model');

$admin = $this->session->userdata('admin');
$access = $admin['user_role'];
$setting   = $CI->setting_model->get_setting();
$user   = $CI->setting_model->get_user();
$client_setting   = $CI->setting_model->get_notification_setting_client();
$notification  = $CI->notification_model->get_setting();
$to_do_alert   = $CI->setting_model->get_to_do_alert();
$appointment_alert   = $CI->setting_model->get_appointment_alert();
$lab_alert   = $CI->setting_model->get_lab_alert();
$admin_messages = $this->message_model->get_message_count_by_id();
$langs = $this->language_model->get_all();
$reports = $this->prescription_model->get_reports_notification();
$fees = $this->prescription_model->get_fees_due();
$appointment_alert_patient   = $CI->setting_model->get_appointment_alert_patient();
$lab_alert_patient   = $CI->setting_model->get_lab_alert_patient();
$template  = $CI->notification_model->get_template();
//echo '<pre>'; print_r($appointment_alert);die;
// $this->session->sess_expiration = '5';

 // set time if empty and user is logged in if($userLoggedIn){ $_SESSION['time'] = time(); } 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />

    <title><?php echo @$setting->name;?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php echo base_url('assets/css/ionicons.min.css')?>" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo base_url('assets/css/morris/morris.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/pickmeup.min.css')?>" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="<?php echo base_url('assets/css/AdminLTE.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/redactor.css')?>" rel="stylesheet" type="text/css" />

    <!-- jQuery 2.0.2 -->
    <script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/js/typeahead.js')?>"></script>
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }

        .modal{ overflow-y:hidden !important }

        .navbar-right{background-color: #4c8cc8 !important}
        .modal-body{
            height: 450px !important;
            overflow-y: auto !important;
        }

        @media print
        {
            .no-print
            {
                display: none !important;
            }
            table{border:2px solid #999999 !important;}
        }

        li.searchpatient {
            margin-top: 8px;
            margin-right:15px;
            margin-left: 10px;
            width: 370px;
        }
        @media screen
        {
            .no-print
            {
                display:block !important;
            }
        }

        #overlay {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            right: 0;
            background: #ffffff;
            opacity: 0.7;
            filter: alpha(opacity=80);
            -moz-opacity: 0.6;
            z-index: 9999000000000;
        }
        li.searchpatient {
            position: relative;
        }

        #resultdata {
            float: left;
            width: 227px;
            position: absolute;
            background: #fff;
            height: 147px;
            overflow: hidden;
            overflow-y: scroll;
            font-size: 16px;
            font-family: Times New Roman;
        }

        #resultdata ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        #resultdata ul li {
            padding: 5px;
            border-bottom: 1px solid #ccc;
        }

        #resultdata ul li:hover {
            background: #f5f5f5;
            cursor: pointer;
        }

        #resultdata ul li a {
            color: #333;
            display: block;
            text-decoration: none;
        }
        #resultdata {
            display:none;
        }
        #searchPatient{
            width: 55%;
            float: left;
            margin-right: 9px;
        }
    </style>
    <script>
        function call_loader_ajax(){

            if($('#overlay').length == 0 ){
                var over = '<div id="overlay">' +
                    '<img  style="padding-top:350px; padding-left:50%;"id="loading" src="<?php echo base_url('assets/img/ajax-loader2.gif')?>"></div>';

                $(over).appendTo('body');
            }
        }


    </script>
    <script type="text/javascript">
             var IDLE_TIMEOUT = 3600; //seconds
                var _idleSecondsCounter = 0;
                document.onclick = function() {
                _idleSecondsCounter = 0;
                };
                document.onmousemove = function() {
                _idleSecondsCounter = 0;
                };
                document.onkeypress = function() {
                _idleSecondsCounter = 0;
                };
                window.setInterval(CheckIdleTime, 1000);

                function CheckIdleTime() {
                _idleSecondsCounter++;
                var oPanel = document.getElementById("SecondsUntilExpire");
                if (oPanel)
                oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
                if (_idleSecondsCounter >= IDLE_TIMEOUT) {
                //alert("Time expired!");
                document.location.href = "login/logout";
                }
                }
        </script>
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5996a3f81b1bed47ceb0546c/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
<head>
    <meta charset="utf-8" />
<body class="skin-blue">
<!-- header logo: style can be found in header.less -->

<header class="header no-print">
    <!--<a href="<?php echo site_url('admin/dashboard');?>" class="logo">-->
    <!-- Add the class icon to your logo image or logo icon to add the margining -->
    <img src="<?php echo base_url('assets/uploads/images/logoheader.png')?>" class="logo"/>
    <!--<?php echo @$setting->name;?>-->
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"><?php echo lang('toggle_navigation'); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <?php /*
					    <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <?php echo lang('language') ?>
                                <span class="label label-success"></span>                            </a>
                            <ul class="dropdown-menu">
                          	 <li>
						            <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
						
						
						
						
						
						
										 <li><!-- start message -->
                                            <a href='<?php echo site_url('admin/languages/switch_language/'); ?>/english/<?php echo $first.'/'.$second.'/'.$third.'/'.$fourth?>'>
                                                <div class="pull-left">
                                                    <img src="<?php echo base_url('assets/img/eng.png')?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                   ENGLISH
                                                   
                                                </h4>
                                      
                                            </a>
                                        </li><!-- end message -->
									<?php foreach ($langs as $new){ ?>
                                       
										<li><!-- start message -->
                                            <a href='<?php echo site_url('admin/languages/switch_language/'.$new->name.'/'.$first.'/'.$second.'/'.$third.'/'.$fourth); ?>'>
                                                <div class="pull-left">
                                                    <img src="<?php echo base_url('assets/uploads/images/'.$new->flag)?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    <?php echo ucwords($new->name)?>
                                                   
                                                </h4>
                                       
                                            </a>
                                        </li><!-- end message -->
										 <?php } ?>        
										
                                        
                                    </ul>
                                </li>
                                
                            </ul>
                      </li>
					  <?php */ ?>



                <?php if($access==1 || $access==3){?>

                    <li class="searchpatient">
                        <input type="text" style="width:218px;" class="form-control" id="searchPatient" placeholder="Search Patient by Name or Mobile">


                        <div id="resultdata" style="margin-top:10%; z-index:1;"></div>

                    </li>

                    <!--  Appo Alert Startprtul-->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo 'Lab Order'; ?>




                            <?php
                            if(!empty($lab_alert))
                            {
                                echo '<span class="label label-danger">'.count($lab_alert).'</span>';
                            }
                            ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo count($lab_alert) ?>  <?php echo 'Lab Order comming in next'; ?> <?php echo $notification->lab_alert;?> <?php echo lang('days')?>.</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php
                                    foreach ($lab_alert as $new){
                                        $with="";

                                        $with = $new->name;

                                        $url = '<a href="'.site_url('admin/lab_management').'" style="color:#666666">';




                                        if(($new->is_paid==1)){
                                            $st = '<i class="fa fa-check-circle text-green"></i>';
                                        }else{
                                            $st = '<i class="fa fa-times-circle text-red"></i>';
                                        }

                                        echo'	<li>
                                            	'.$url.'
                                                '.$st.' 
											'.$with.' On '.date("d/m/Y h:i:a", strtotime($new->dates)).'</a>
                                       </li>
									';
                                    }
                                    ?>


                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?php echo site_url('admin/lab_management') ?>"><?php echo lang('view_all') ?> </a>
                            </li>
                        </ul>
                    </li>

                    <!--  Appo Alert Start-->
                    <li class="dropdown tasks-menu">
                        <a href="javascript:void(0);" class="dropdown-toggle" onClick="send_sms();"><!--data-toggle="dropdown"-->
                            <?php echo lang('message'); ?>
                            <?php
                            if(!empty($admin_messages))
                            {
                                echo '<span class="label label-danger">'.count($admin_messages).'</span>';
                            }
                            ?>
                        </a>
                        <?php /*?><ul class="dropdown-menu">
                            <!-- inner menu: contains the actual data -->
                            <li>     
                            	<!--<ul class="menu">
								<?php
                                foreach ($admin_messages as $new){
                                    echo'	<li>
                                        <a href="'.site_url('admin/message').'" style="color:#666666">
                                            <i class="fa fa-chevron-circle-right"></i> '.$new->from_user.' On '.date("d/m/Y h:i:a", strtotime($new->date_time)).'</a>
                                   </li>
                                ';
                                }
                                ?>
                                </ul>-->
                                
                            </li>
                            <li class="footer">
                                <a href="<?php echo site_url('admin/message') ?>"><?php echo lang('view_all') ?> </a>
                            </li>
                        </ul><?php */?>
                    </li>
                    <!-- Appo Alert End -->



                    <!--  Appo Alert Startprtul-->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo lang('appointments'); ?>




                            <?php
                            if(!empty($appointment_alert))
                            {
                                echo '<span class="label label-danger">'.count($appointment_alert).'</span>';
                            }
                            ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo count($appointment_alert) ?>  <?php echo lang('appointment_comming_in_next'); ?> <?php echo $notification->appointment_alert;?> <?php echo lang('days')?>.</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php
                                    foreach ($appointment_alert as $new){
                                        $with="";
                                        if(($new->whom==1)){
                                            $with = $new->name;

                                            $url = '<a href="'.site_url('admin/patients/view/'.$new->patient_id).'/appointment" style="color:#666666">';

                                        }
                                        if(($new->whom==2)){
                                            $with = $new->contact;
                                            $url = '<a href="'.site_url('admin/appointments/view_appointment/'.$new->id).'" style="color:#666666">';

                                        }
                                        if(($new->whom==3)){
                                            $with = $new->other;
                                            $url = '<a href="'.site_url('admin/appointments/view_appointment/'.$new->id).'" style="color:#666666">';
                                        }

                                        if(($new->is_paid==1)){
                                            $st = '<i class="fa fa-check-circle text-green"></i>';
                                        }else{
                                            $st = '<i class="fa fa-times-circle text-red"></i>';
                                        }

                                        echo'	<li>
                                            	'.$url.'
                                                '.$st.' 
											'.$with.' On '.date("d/m/Y h:i:a", strtotime($new->date)).'</a>
                                       </li>
									';
                                    }
                                    ?>


                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?php echo site_url('admin/appointments') ?>"><?php echo lang('view_all') ?> </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Appo Alert End -->



                    <!--  To Do Alert End-->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo lang('to_do'); ?>




                            <?php
                            if(!empty($to_do_alert))
                            {
                                echo '<span class="label label-danger">'.count($to_do_alert).'</span>';
                            }
                            ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo count($to_do_alert) ?> <?php echo lang('to_do_comming_in_next'); ?> <?php echo $notification->to_do_alert;?> <?php echo lang('days')?></li>

                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php
                                    foreach ($to_do_alert as $new){
                                        echo'	<li>
                                            <a href="'.site_url('admin/to_do_list/view_to_do/'.$new->id).'" style="color:#666666">
                                                <i class="fa fa-tasks"></i>  '.$new->title.' On '.$new->date.'</a>
                                       </li>
									';
                                    }
                                    ?>


                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?php echo site_url('admin/to_do_list');?>"><?php echo lang('view_all');?> </a>
                            </li>
                        </ul>
                    </li>
                    <!-- To Do Alert End -->




                <?php } //admin DOctor end?>




                <?php if($access==2){?>

                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo lang('message'); ?>




                            <?php
                            if(!empty($admin_messages))
                            {
                                echo '<span class="label label-danger">'.count($admin_messages).'</span>';
                            }
                            ?>

                        </a>
                        <ul class="dropdown-menu">
                            <!-- inner menu: contains the actual data -->
                            <li>     <ul class="menu">
                                    <?php
                                    foreach ($admin_messages as $new){
                                        echo'	<li>
                                            <a href="'.site_url('admin/message/send_message/'.$admin['id']).'" style="color:#666666">
                                                <i class="fa fa-chevron-circle-right"></i> '.$new->from_user.' On '.date("d/m/Y h:i:a", strtotime($new->date_time)).'</a>
                                       </li>
									';
                                    }
                                    ?>


                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?php echo site_url('admin/message/send_message/'.$admin['id']) ?>"><?php echo lang('view_all') ?> </a>
                            </li>
                        </ul>
                    </li>



                    <!--  Appo Alert Start-->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo lang('appointments'); ?>
                            <?php
                            if(!empty($appointment_alert_patient))
                            {
                                echo '<span class="label label-danger">'.count($appointment_alert_patient).'</span>';
                            }
                            ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo count($appointment_alert_patient) ?>  <?php echo lang('appointment_comming_in_next'); ?> <?php echo $notification->appointment_alert;?> <?php echo lang('days')?>.</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php
                                    foreach ($appointment_alert_patient as $new){
                                        echo'	<li>
                                            <a href="'.site_url('admin/book_appointment/view_appointment/'.$new->id).'" style="color:#666666">
                                                <i class="fa fa-chevron-circle-right"></i>  On '.date("d/m/Y h:i:a", strtotime($new->date)).'</a>
                                       </li>
									';
                                    }
                                    ?>


                                </ul>
                            </li>
                            <li class="footer">
                                <a href="<?php echo site_url('admin/book_appointment') ?>"><?php echo lang('view_all') ?> </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Appo Alert End -->





                <?php } ?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <!--<span><?php echo $user->name ?> <i class="caret"></i></span>-->
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <?php
                            if(!empty($user->image)){
                                ?>
                                <img src="<?php echo base_url('assets/uploads/images/'.$user->image);?>"class="img-circle" alt="User Image" />
                                <?php
                            }else{
                                ?>
                                <img src="<?php echo base_url('assets/uploads/images/avatar5.png');?>"class="img-circle" alt="User Image" />
                                <?php
                            }
                            ?>

                            <p>
                                <?php echo $admin['name'] ?>

                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo site_url('admin/account'); ?>" class="btn btn-default btn-flat"><?php echo lang('profile');?></a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo site_url('admin/login/logout'); ?>" class="btn btn-default btn-flat"><?php echo lang('sign') ." ". lang('out');?></a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>




<div class="wrapper row-offcanvas row-offcanvas-left ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel no-print">
                <div class="pull-left image">
                    <?php
                    if(!empty($admin['image'])){
                        ?>
                        <img src="<?php echo base_url('assets/uploads/images/'.$admin['image']);?>"class="img-circle" alt="User Image" />
                        <?php
                    }else{
                        ?>
                        <img src="<?php echo base_url('assets/uploads/images/avatar5.png');?>"class="img-circle" alt="User Image" />
                        <?php
                    }
                    ?>
                </div>
                <div class="pull-left info">
                    <p><?php echo lang('hello');?>, <?php echo lang('doctor') ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo lang('online');?></a>
                </div>
            </div>
            <!-- search form -->

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="<?php echo($this->uri->segment(2)=='dashboard' || $this->uri->segment(2)=='')?'active':'';?>">
                    <a href="<?php echo site_url('admin/dashboard');?>">
                        <i class="fa fa-dashboard"></i> <span>Home</span>
                    </a>
                </li>
                <?php $access = $admin['user_role'];
                if($access=="Admin"){
                    ?>
                    <li class="<?php echo($this->uri->segment(2)=='doctors')?'active':'';?>">
                        <a href="<?php echo site_url('admin/doctors');?>">
                            <i class="fa fa-stethoscope"></i> <span><?php echo lang('doctors');?></span>
                        </a>
                    </li>
					<li class="<?php echo($this->uri->segment(2)=='clinics')?'active':'';?>">
                        <a href="<?php echo site_url('admin/clinics');?>">
                            <i class="fa fa-stethoscope"></i> <span>Clinics</span>
                        </a>
                    </li>
                    
                    <li style="display:none;" class="<?php echo($this->uri->segment(2)=='doctor_payment')?'active':'';?>">
                        <a href="<?php echo site_url('admin/doctor_payment');?>">
                            <i class="fa fa-credit-card"></i> <span><?php echo lang('payment');?></span>
                        </a>
                    </li>

                    <li class="<?php echo($this->uri->segment(2)=='custom_fields')?'active':'';?>">
                        <a href="<?php echo site_url('admin/custom_fields');?>">
                            <i class="fa fa-columns"></i> <span><?php echo lang('custom_fields')?></span>
                        </a>
                    </li>
                    <li class="<?php echo($this->uri->segment(2)=='settings')?'active':'';?>">
                        <a href="<?php echo site_url('admin/settings');?>">
                            <i class="fa fa-cog"></i> <span><?php echo lang('settings');?></span>
                        </a>
                    </li>



                <?php }if($access==1){?>

                    <li class="<?php echo($this->uri->segment(2)=='patients')?'active':'';?>">
                        <a href="<?php echo site_url('admin/patients');?>">
                            <i class="fa fa-group"></i> <span><?php echo lang('patients');?></span>
                        </a>
                    </li>
                    <li  style="display:none;"  class="<?php echo($this->uri->segment(2)=='payment')?'active':'';?>">
                        <a href="<?php echo site_url('admin/payment');?>">
                            <i class="fa fa-credit-card"></i> <span><?php echo lang('payment');?></span>
                        </a>
                    </li>

                    <!--<li class="<?php echo($this->uri->segment(2)=='prescription')?'active':'';?>">
                            <a href="<?php echo site_url('admin/prescription');?>">
                                <i class="fa fa-medkit"></i> <span><?php echo lang('prescription');?></span> 
                            </a>
                        </li>-->
                    <li style="" class="<?php echo($this->uri->segment(2)=='Lab Management')?'active':'';?>">
                        <a href="<?php echo site_url('admin/lab_management');?>">
                            <i class="fa fa-group"></i> <span><?php echo lang('lab_management');?></span>
                        </a>
                    </li>
                    <li  style="" class="<?php echo($this->uri->segment(2)=='calendar')?'active':'';?>">
                    <a href="<?php echo site_url('admin/calendar');?>">
                        <i class="fa fa-calendar"></i> <span> Calendar</span>
                    </a>
                    </li>


                    <!--<li class="<?php echo($this->uri->segment(2)=='message')?'active':'';?>">
                            <a href="<?php echo site_url('admin/message');?>">
                                <i class="fa fa-envelope"></i> <span><?php echo lang('message');?> </span>
							
								<small class="badge pull-right bg-red"><?php echo count($admin_messages) ?></small>
							
							</a>
                        </li>-->

                    <li  style="" class="<?php echo($this->uri->segment(2)=='to_do_list')?'active':'';?>">
                        <a href="<?php echo site_url('admin/to_do_list');?>">
                            <i class="fa fa-bars"></i> <span><?php echo lang('to_do_list');?></span>
                            <small class="badge pull-right bg-red"><?php echo count($to_do_alert) ?></small>
                        </a>
                    </li>

                    <!--<li class="<?php echo($this->uri->segment(2)=='notes')?'active':'';?>">
                            <a href="<?php echo site_url('admin/notes');?>">
                                <i class="fa fa-file-text"></i> <span><?php echo lang('notes');?></span>
								
                            </a>
                        </li>-->
                    <li class="<?php echo($this->uri->segment(2)=='contacts')?'active':'';?>">
                        <a href="<?php echo site_url('admin/contacts');?>">
                            <i class="fa fa-newspaper-o"></i> <span><?php echo lang('contacts')?></span>
                        </a>
                    </li>

                    <li class="<?php echo($this->uri->segment(2)=='appointments')?'active':'';?>">
                        <a href="<?php echo site_url('admin/appointments');?>">
                            <i class="fa fa-thumb-tack"></i> <span><?php echo lang('appointments')?></span>
                            <small class="badge pull-right bg-red"><?php echo count($appointment_alert) ?></small>
                        </a>
                    </li>


                    <!--<li class="treeview <?php echo($this->uri->segment(2)=='hospital'|| $this->uri->segment(3)=='view_monthly_schedule' || $this->uri->segment(2)=='languages')?'active':'';?>">
                            <a href="#">
                                  <i class="fa fa-h-square"></i> <span><?php echo lang('hospitals')?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/hospital/view_all');?>">
										<i class="fa fa-h-square"></i> <span><?php echo lang('hospital')?></span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/hospital/select_hospital');?>">
										<i class="fa fa-plus"></i> <span><?php echo lang('add_hospital_routine')?></span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/hospital/select_hospital/view');?>">
										<i class="fa fa-clock-o"></i> <span><?php echo lang('hospital_routine')?></span>
									</a>
								</li>

                            </ul>
                        </li>-->

                    <!--<li class="treeview <?php echo($this->uri->segment(2)=='medical_college'|| $this->uri->segment(3)=='view_monthly_schedule' || $this->uri->segment(2)=='languages')?'active':'';?>">
                            <a href="#">
                                  <i class="fa fa-maxcdn"></i> <span><?php echo lang('medical_college')?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

								  <li class="<?php echo($this->uri->segment(2)=='medical_college')?'active':'';?>">
										<a href="<?php echo site_url('admin/medical_college');?>">
											<i class="fa fa-maxcdn"></i> <span><?php echo lang('medical_college')?></span>
										</a>
									</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/medical_college/select_medical_college');?>">
										<i class="fa fa-plus"></i> <span><?php echo lang('add_medical_college_routine')?></span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/medical_college/select_medical_college/view');?>">
										<i class="fa fa-clock-o"></i> <span><?php echo lang('medical_college_routine')?></span>
									</a>
								</li>

                            </ul>
                        </li>-->


                    <li class="<?php echo($this->uri->segment(2)=='appointments')?'active':'';?>">


                        </a>
                    </li>
                    <li class="treeview <?php echo($this->uri->segment(2)=='inventory_management' || $this->uri->segment(2)=='inventory_management_order' )?'active':'';?>">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span><?php echo lang('inventory_management') ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo($this->uri->segment(2)=='Stock')?'active':'';?>">
                                <a href="<?php echo site_url('admin/inventory_management');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo "Stock";?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='Order')?'active':'';?>">
                                <a href="<?php echo site_url('admin/inventory_management_order');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo "Order";?></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li style=""  class="<?php echo($this->uri->segment(2)=='reports')?'active':'';?>">
                        <a href="<?php echo site_url('admin/reports');?>">
                            <i class="fa fa-line-chart"></i> <span><?php echo lang('reports');?></span>
                        </a>
                    </li>
                    
                     <li style=""  class="<?php echo($this->uri->segment(2) == 'expenses') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/expenses'); ?>">
                                        <i class="fa fa-shopping-cart"></i> <span>Expenses</span>
                                    </a>
                                </li>    
                                 <li style=""  class="<?php echo($this->uri->segment(2) == 'videos') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/videos'); ?>">
                                        <i class="fa fa-shopping-cart"></i> <span>Videos</span>
                                    </a>
                                </li>    

                    <?php /*
						<li class="treeview <?php echo($this->uri->segment(2)=='schedule'|| $this->uri->segment(3)=='view_monthly_schedule' || $this->uri->segment(2)=='languages')?'active':'';?>">
                            <a href="#">
                                 <i class="fa fa-clock-o"></i> <span><?php echo lang('schedules')?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

								<li class="<?php echo($this->uri->segment(2)=='schedule')?'active':'';?>">
									<a href="<?php echo site_url('admin/schedule');?>">
										 <i class="fa fa-angle-double-right"></i> <span><?php echo lang('manage_schedule');?> </span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(3)=='view_schedule')?'active':'';?>">
									<a href="<?php echo site_url('admin/schedule/view_schedule');?>">
										 <i class="fa fa-angle-double-right"></i> <span><?php echo lang('weekly_schedule');?> </span>
									</a>
								</li>

								<li class="<?php echo($this->uri->segment(3)=='view_monthly_schedule')?'active':'';?>">
									<a href="<?php echo site_url('admin/schedule/view_monthly_schedule');?>">
										 <i class="fa fa-angle-double-right"></i> <span><?php echo lang('monthly_schedule');?> </span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(3)=='view_specific_schedule')?'active':'';?>">
									<a href="<?php echo site_url('admin/schedule/view_specific_schedule');?>">
										 <i class="fa fa-angle-double-right"></i> <span><?php echo lang('specific_schedule');?> </span>
									</a>
								</li>

                            </ul>
                        </li>
						*/ ?>

                    <li class="treeview <?php echo($this->uri->segment(2)=='manufacturing_company' || $this->uri->segment(2)=='medical_test' || $this->uri->segment(2)=='medicine' || $this->uri->segment(2)=='medicine_category' || $this->uri->segment(2)=='disease' || $this->uri->segment(2)=='case_history' || $this->uri->segment(2)=='location' || $this->uri->segment(2)=='payment_mode')?'active':'';?>">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span><?php echo lang('settings') ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo($this->uri->segment(2)=='consultant')?'active':'';?>">
                                <a href="<?php echo site_url('admin/consultant');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('consultant')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='medicine')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medicine');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine')?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='medicine_category')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medicine_category');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine_category')?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='supplier')?'active':'';?>">
                                <a href="<?php echo site_url('admin/supplier');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('supplier')?></span>
                                </a>
                            </li>

                            <!--<li   style="" class="<?php echo($this->uri->segment(2)=='disease')?'active':'';?>">
                            <a href="<?php echo site_url('admin/disease');?>">
                                <i class="fa fa-angle-double-right"></i> <span>O/E</span>
                            </a>
                        </li>-->

                            <!--<li  style="" class="<?php echo($this->uri->segment(2)=='case_history')?'active':'';?>">
                            <a href="<?php echo site_url('admin/case_history');?>">
                                <i class="fa fa-angle-double-right"></i> <span>Case History</span>
                            </a>
                        </li>-->

                            <li class="<?php echo($this->uri->segment(2)=='manufacturing_company')?'active':'';?>">
                                <a href="<?php echo site_url('admin/manufacturing_company');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('manufacturing_company')?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='medical_test')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medical_test');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medical_test')?></span>
                                </a>
                            </li>



                            <li  style="display:none;" class="<?php echo($this->uri->segment(2)=='payment_mode')?'active':'';?>">
                                <a href="<?php echo site_url('admin/payment_mode');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('payment_mode')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='instruction')?'active':'';?>">
                                <a href="<?php echo site_url('admin/instruction');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('instruction')?></span>
                                </a>
                            </li>
                            <?php //##################################################################################################################################  ?>
                            <li class="<?php echo($this->uri->segment(2)=='chiff_Complaint')?'active':'';?>">
                                <a href="<?php echo site_url('admin/chiff_Complaint');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('chiff_Complaint')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='medical_history')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medical_history');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medical_history')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='drug_allergy')?'active':'';?>">
                                <a href="<?php echo site_url('admin/drug_allergy');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('drug_allergy')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='drug_allergy')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medicine_template');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo "Medicine Template";?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='extra_oral_exm')?'active':'';?>">
                                <a href="<?php echo site_url('admin/extra_oral_exm');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo "O/E";?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='intra_oral_exm')?'active':'';?>">
                                <a href="<?php echo site_url('admin/intra_oral_exm');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo "Diagnosis";?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='treatment_advised')?'active':'';?>">
                                <a href="<?php echo site_url('admin/treatment_advised');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('treatment_advised')?></span>
                                </a>
                            </li>
                            <li  style="" class="<?php echo($this->uri->segment(2)=='lab')?'active':'';?>">
                                <a href="<?php echo site_url('admin/lab');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('lab')?></span>
                                </a>
                            </li>
                            <!--<li  style="" class="<?php echo($this->uri->segment(2)=='lab_work')?'active':'';?>">
                            <a href="<?php echo site_url('admin/lab_work');?>">
                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('lab_work')?></span>
                            </a>
                        </li>-->

                        </ul>
                    </li>
                    <li class="treeview <?php echo($this->uri->segment(2)=='settings'|| $this->uri->segment(2)=='notification' || $this->uri->segment(2)=='assistant_payment' ||$this->uri->segment(2)=='assistants' || $this->uri->segment(2)=='languages')?'active':'';?>">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span><?php echo lang('administrative');?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo($this->uri->segment(2)=='assistants')?'active':'';?>">
                                <a href="<?php echo site_url('admin/assistants');?>">
                                    <i class="fa fa-user"></i> <span> <?php echo lang('assistants');?></span>
                                </a>
                            </li>


                            <li  class="<?php echo($this->uri->segment(2)=='assistants')?'active':'';?>">
                                <a href="<?php echo site_url('admin/assistant_payment');?>">
                                    <i class="fa fa-credit-card"></i> <span> Assistant Payment</span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='template')?'active':'';?>">
                                <a href="<?php echo site_url('admin/template');?>">
                                    <i class="fa fa-cogs"></i> <span> <?php echo lang('manage_prescription');?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='manage_invoice')?'active':'';?>">
                                <a href="<?php echo site_url('admin/manage_invoice');?>">
                                    <i class="fa fa-cogs"></i> <span> <?php echo 'Manage Invoice';?></span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-folder"></i> <span>SMS Management</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">

                                    <li class="<?php echo($this->uri->segment(3)=='sms_management')?'active':'';?>">
                                        <a href="<?php echo site_url('admin/settings/sms_management');?>">
                                            <i class="fa fa-envelope"></i> <span>SMS Settings</span>
                                        </a>
                                    </li>

                                    <?php /*?><li class="<?php echo($this->uri->segment(3)=='delivery_reports')?'active':'';?>">
                                        <a href="<?php echo site_url('admin/settings/delivery_reports');?>">
                                            <i class="fa fa-envelope"></i> <span>Delivery Reports</span>
                                        </a>
                                    </li><?php */?>
                                </ul>
                            </li>



                            <li class="<?php echo($this->uri->segment(2)=='settings' && $this->uri->segment(3)=='')?'active':'';?>">
                                <a href="<?php echo site_url('admin/settings');?>">
                                    <i class="fa fa-cogs"></i> <span><?php echo lang('general');?> <?php echo lang('settings');?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='notification')?'active':'';?>">
                                <a href="<?php echo site_url('admin/notification');?>">
                                    <i class="fa fa-bell"></i> <span><?php echo lang('notification');?> <?php echo lang('settings');?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(3)=='canned_messages')?'active':'';?>">
                                <a href="<?php echo site_url('admin/settings/canned_messages');?>">
                                    <i class="fa fa-envelope"></i> <span><?php echo lang('canned_messages');?></span>
                                </a>
                            </li>

                        </ul>
                    </li>





                    <?php
                }
                if($access==2){
                    ?>

                    <li class="<?php echo($this->uri->segment(2)=='my_prescription')?'active':'';?>">
                        <a href="<?php echo site_url('admin/my_prescription');?>">
                            <i class="fa fa-file"></i> <span><?php echo lang('my_prescription');?></span>
                        </a>
                    </li>

                    <li class="<?php echo($this->uri->segment(3)=='send_message')?'active':'';?>">
                        <a href="<?php echo site_url('admin/message/send_message/'.$admin['id']);?>">
                            <i class="fa fa-envelope"></i> <span><?php echo lang('message');?> </span><small class="badge pull-right bg-red"><?php echo count($admin_messages) ?></small>
                        </a>
                    </li>
                    <li class="<?php echo($this->uri->segment(2)=='book_appointment')?'active':'';?>">
                        <a href="<?php echo site_url('admin/book_appointment');?>">
                            <i class="fa fa-thumb-tack"></i> <span><?php echo lang('appointments')?></span>

                        </a>
                    </li>


                    <li class="treeview <?php echo($this->uri->segment(2)=='settings'|| $this->uri->segment(2)=='notification')?'active':'';?>">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span><?php echo lang('administrative');?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo($this->uri->segment(2)=='notification')?'active':'';?>">
                                <a href="<?php echo site_url('admin/notification');?>">
                                    <i class="fa fa-bell"></i> <span><?php echo lang('notification');?> <?php echo lang('settings');?></span>
                                </a>
                            </li>

                        </ul>
                    </li>




                    <?php
                }if($access==3){
                    ?>
                    <li class="<?php echo($this->uri->segment(2)=='patients')?'active':'';?>">
                        <a href="<?php echo site_url('admin/patients/patient');?>">
                            <i class="fa fa-group"></i> <span><?php echo lang('patients');?></span>
                        </a>
                    </li>
                    <li   style="display:none;"class="<?php echo($this->uri->segment(2)=='payment')?'active':'';?>">
                        <a href="<?php echo site_url('admin/payment');?>">
                            <i class="fa fa-group"></i> <span><?php echo lang('payment');?></span>
                        </a>
                    </li>

                    <!--<li class="<?php echo($this->uri->segment(2)=='prescription')?'active':'';?>">
                            <a href="<?php echo site_url('admin/prescription/assistant_prescription');?>">
                                <i class="fa fa-medkit"></i> <span><?php echo lang('prescription');?></span> 
                            </a>
                        </li>-->
                    <li  style="" class="<?php echo($this->uri->segment(2)=='Lab Management')?'active':'';?>">
                        <a href="<?php echo site_url('admin/lab_management');?>">
                            <i class="fa fa-group"></i> <span><?php echo lang('lab_management');?></span>
                        </a>
                    </li>
                    <li  style="" class="<?php echo($this->uri->segment(2)=='calendar')?'active':'';?>">
                    <a href="<?php echo site_url('admin/calendar');?>">
                        <i class="fa fa-calendar"></i> <span> Calendar</span>
                    </a>
                    </li>
                     <li style=""  class="<?php echo($this->uri->segment(2) == 'expenses') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/expenses'); ?>">
                                        <i class="fa fa-shopping-cart"></i> <span>Expenses</span>
                                    </a>
                                </li> 
                                 <li style=""  class="<?php echo($this->uri->segment(2) == 'videos') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/videos'); ?>">
                                        <i class="fa fa-shopping-cart"></i> <span>Videos</span>
                                    </a>
                                </li>    

                    <li  style=""class="<?php echo($this->uri->segment(2)=='to_do_list')?'active':'';?>">
                        <a href="<?php echo site_url('admin/to_do_list');?>">
                            <i class="fa fa-bars"></i> <span><?php echo lang('to_do_list');?></span>

                        </a>
                    </li>
                    <!--<li class="<?php echo($this->uri->segment(2)=='notes')?'active':'';?>">
                            <a href="<?php echo site_url('admin/notes');?>">
                                <i class="fa fa-file-text"></i> <span><?php echo lang('notes');?></span>
								
                            </a>
                        </li>-->
                    <li class="<?php echo($this->uri->segment(2)=='contacts')?'active':'';?>">
                        <a href="<?php echo site_url('admin/contacts');?>">
                            <i class="fa fa-newspaper-o"></i> <span><?php echo lang('contacts')?></span>
                        </a>
                    </li>

                    <!--<li class="<?php echo($this->uri->segment(2)=='appointments')?'active':'';?>">
                            <a href="<?php echo site_url('admin/appointments');?>">
                                <i class="fa fa-thumb-tack"></i> <span><?php echo lang('appointments')?></span>
							</a>
                        </li>-->

                    <li style="" class="<?php echo($this->uri->segment(2)=='Inventory Management')?'active':'';?>">
                        <a href="<?php echo site_url('admin/inventory_management');?>">
                            <i class="fa fa-group"></i> <span><?php echo lang('inventory_management');?></span>
                        </a>
                    </li>

                    <!--<li style=""  class="<?php echo($this->uri->segment(2)=='reports')?'active':'';?>">
											<a href="<?php echo site_url('admin/reports');?>">
												<i class="fa fa-line-chart"></i> <span><?php echo lang('reports');?></span>
											</a>
                        </li>-->
                    <!--<li class="treeview <?php echo($this->uri->segment(2)=='hospital'|| $this->uri->segment(3)=='view_monthly_schedule' || $this->uri->segment(2)=='languages')?'active':'';?>">
                            <a href="#">
                                  <i class="fa fa-h-square"></i> <span><?php echo lang('hospitals')?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                        			
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/hospital/view_all');?>">
										<i class="fa fa-h-square"></i> <span><?php echo lang('hospital')?></span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/hospital/select_hospital');?>">
										<i class="fa fa-plus"></i> <span><?php echo lang('add_hospital_routine')?></span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/hospital/select_hospital/view');?>">
										<i class="fa fa-clock-o"></i> <span><?php echo lang('hospital_routine')?></span>
									</a>
								</li>
							
                            </ul>
                        </li>-->

                    <!--<li class="treeview <?php echo($this->uri->segment(2)=='medical_college'|| $this->uri->segment(3)=='view_monthly_schedule' || $this->uri->segment(2)=='languages')?'active':'';?>">
                            <a href="#">
                                  <i class="fa fa-maxcdn"></i> <span><?php echo lang('medical_college')?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                        			
								  <li class="<?php echo($this->uri->segment(2)=='medical_college')?'active':'';?>">
										<a href="<?php echo site_url('admin/medical_college');?>">
											<i class="fa fa-maxcdn"></i> <span><?php echo lang('medical_college')?></span>
										</a>
									</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/medical_college/select_medical_college');?>">
										<i class="fa fa-plus"></i> <span><?php echo lang('add_medical_college_routine')?></span>
									</a>
								</li>
								<li class="<?php echo($this->uri->segment(2)=='hospital')?'active':'';?>">
									<a href="<?php echo site_url('admin/medical_college/select_medical_college/view');?>">
										<i class="fa fa-clock-o"></i> <span><?php echo lang('medical_college_routine')?></span>
									</a>
								</li>
							
                            </ul>
                        </li>-->
                    <li class="treeview <?php echo($this->uri->segment(2)=='manufacturing_company' || $this->uri->segment(2)=='medical_test' || $this->uri->segment(2)=='medicine' || $this->uri->segment(2)=='medicine_category' || $this->uri->segment(2)=='supplier' || $this->uri->segment(2)=='case_history'  || $this->uri->segment(2)=='disease' || $this->uri->segment(2)=='location' || $this->uri->segment(2)=='payment_mode')?'active':'';?>">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span><?php echo lang('settings') ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li style="display:none;" class="<?php echo($this->uri->segment(2)=='consultant')?'active':'';?>">
                                <a href="<?php echo site_url('admin/consultant');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('consultant')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='medicine')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medicine');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine')?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='medicine_category')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medicine_category');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine_category')?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='supplier')?'active':'';?>">
                                <a href="<?php echo site_url('admin/supplier');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('supplier')?></span>
                                </a>
                            </li>

                            <!--<li   style="" class="<?php echo($this->uri->segment(2)=='disease')?'active':'';?>">
                            <a href="<?php echo site_url('admin/disease');?>">
                                <i class="fa fa-angle-double-right"></i> <span>O/E</span>
                            </a>
                        </li>-->

                            <!--<li  style="" class="<?php echo($this->uri->segment(2)=='case_history')?'active':'';?>">
                            <a href="<?php echo site_url('admin/case_history');?>">
                                <i class="fa fa-angle-double-right"></i> <span>Case History</span>
                            </a>
                        </li>-->

                            <li class="<?php echo($this->uri->segment(2)=='manufacturing_company')?'active':'';?>">
                                <a href="<?php echo site_url('admin/manufacturing_company');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('manufacturing_company')?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='medical_test')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medical_test');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medical_test')?></span>
                                </a>
                            </li>



                            <li  style="display:none;" class="<?php echo($this->uri->segment(2)=='payment_mode')?'active':'';?>">
                                <a href="<?php echo site_url('admin/payment_mode');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('payment_mode')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='instruction')?'active':'';?>">
                                <a href="<?php echo site_url('admin/instruction');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('instruction')?></span>
                                </a>
                            </li>
                            <?php //##################################################################################################################################  ?>
                            <li class="<?php echo($this->uri->segment(2)=='chiff_Complaint')?'active':'';?>">
                                <a href="<?php echo site_url('admin/chiff_Complaint');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('chiff_Complaint')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='medical_history')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medical_history');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medical_history')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='medical_history')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medical_history');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medical_history')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='medical_history')?'active':'';?>">
                                <a href="<?php echo site_url('admin/medicine_template');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo "Medcine Template";?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='extra_oral_exm')?'active':'';?>">
                                <a href="<?php echo site_url('admin/extra_oral_exm');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('extra_oral_exm')?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2)=='intra_oral_exm')?'active':'';?>">
                                <a href="<?php echo site_url('admin/intra_oral_exm');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('intra_oral_exm')?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2)=='treatment_advised')?'active':'';?>">
                                <a href="<?php echo site_url('admin/treatment_advised');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('treatment_advised')?></span>
                                </a>
                            </li>
                            <li  style="" class="<?php echo($this->uri->segment(2)=='lab')?'active':'';?>">
                                <a href="<?php echo site_url('admin/lab');?>">
                                    <i class="fa fa-angle-double-right"></i> <span><?php echo lang('lab')?></span>
                                </a>
                            </li>
                            <!--<li  style="" class="<?php echo($this->uri->segment(2)=='lab_work')?'active':'';?>">
                            <a href="<?php echo site_url('admin/lab_work');?>">
                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('lab_work')?></span>
                            </a>
                        </li>-->

                        </ul>
                    </li>


                <?php } ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    
    <div class="modal fade" id="send_sms_popup" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
        <div class="modal-dialog dd">
            <div class="modal-content ff">
                <div class="modal-header">
    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addlabel"> Send SMS</h4>
                </div>
                <div class="modal-body" style="height:200px !important;">
                	<div id="errSms" style="display:none;">
                      <div class="alert alert-danger">                 
                        <b>Alert!</b>
                        <p id="errSmsMsg"></p>
                      </div>
                    </div>
                    <div id="succSms" style="display:none;">
                      <div class="alert alert-success">  
                        <p id="succSmsMsg"></p>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="name" style="clear:both;"> Number</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="sms_mobile_number" value="" class="form-control" id="sms_mobile_number"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="name" style="clear:both;"> Message</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="sms_mobile_message" class="form-control" id="sms_mobile_message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="name" style="clear:both;"> Map Location</label>
                            </div>
                            <div class="col-md-8">
                                <input type="checkbox" name="send_map" id="send_map" value="1"> Attached in message
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <img id="smsLoading" src="<?php echo base_url('assets/img/ajax-loader2.gif')?>" style="display:none;">
                	<button type="button" class="btn btn-default" id="btnSendSms">Send SMS</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="cancel_appointment_popup" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true" style="z-index:9999;">
        <div class="modal-dialog dd">
            <div class="modal-content ff">
                <div class="modal-header">
    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addlabel"> Cancel Appointment </h4>
                </div>
                <div class="modal-body" style="height:150px !important;">
                	<div id="errApp" style="display:none;">
                      <div class="alert alert-danger">                 
                        <b>Alert!</b>
                        <p id="errAppMsg"></p>
                      </div>
                    </div>
                    <div id="succApp" style="display:none;">
                      <div class="alert alert-success">  
                        <p id="succAppMsg"></p>
                      </div>
                    </div>
                	<p>Appointment Cancel By</p>
                    <input type="hidden" name="appointment_cancel_id" id="appointment_cancel_id" value="" class="form-control"/>
                	<button type="button" class="btn btn-default" id="cancelAppointDoctor" onClick="cancel_appt('doctor');">Doctor</button>
                    <button type="button" class="btn btn-default" id="cancelAppointPatient" onClick="cancel_appt('patient');">Patient</button>
                    <img id="AppLoading" src="<?php echo base_url('assets/img/ajax-loader2.gif')?>" style="display:none;">
                </div>
            </div>
        </div>
    </div>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">

        <?php

        if($this->session->flashdata('message'))
            $message = $this->session->flashdata('message');
        if($this->session->flashdata('error'))
            $error  = $this->session->flashdata('error');
        ?>

        <?php if(!empty($error) || !empty($message)){ ?>
            <div class="container" style="margin-top:20px;">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissable col-md-11">
                        <i class="fa fa-ban"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-info alert-dismissable col-md-11">
                        <i class="fa fa-info"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php }?>

        <script>
            $(document).ready(function () {
                $('#searchPatient').typeahead({

                    // if($("#searchmobile"). prop("checked") == true){
                    //alert("Checkbox is checked." );
                    //}
                    source: function (query, result) {
                        var check = $.trim($("#searchPatient").val());
						
						if(check != '') {							
							if (!isNaN(parseInt(check))) {
								var searchmob=1;
							}
							$.ajax({
								url: "<?php echo base_url('admin/patients/search_patient') ?>",
								data: 'query=' + query+'&searchmob='+searchmob,
								type: "POST",
								success: function (data) {									
									if($.trim(data) != '')
									{
										//console.log(data);
										$("#resultdata").show();
										$("#resultdata").html(data);
									}
									else
									{
										$("#resultdata").html('');
										$("#resultdata").hide();
									}	
								}
							});
						}
						else
						{							
							$("#resultdata").html('');
							$("#resultdata").hide();
						}
                    }
                });
            });
			function send_sms() {
				$("#send_sms_popup").modal('show');
				$("#sms_mobile_number").val('');
				$("#sms_mobile_message").val('');
				
				$("#errSms").hide();
				$("#errSmsMsg").html('');								  
				
				$("#succSms").hide();
				$("#succSmsMsg").html('');
			}
			function cancel_appointment_function() {
				var appointment_cancel_id = jQuery('#bbit-cs-id').val();
				$("#cancel_appointment_popup").modal('show');
				$("#errApp").hide();
				$("#errAppMsg").html('');								  
				
				$("#succApp").hide();
				$("#succAppMsg").html('');
				$("#appointment_cancel_id").val(appointment_cancel_id);
			}
			function cancel_appt(cancelBy) {
				var appointment_cancel_id = jQuery('#bbit-cs-id').val();
				$("#AppLoading").show();	
				$.ajax({
					url: '<?php echo base_url('admin/patients/appoint_cancel') ?>',
					type: 'POST',
					data: {appointment_cancel_id: appointment_cancel_id,cancelBy:cancelBy},
					success: function (result) {
						var res = $.parseJSON(result);	 
						if (res.status == 'success') {
							$("#errApp").hide();
							$("#errAppMsg").html('');								  
							
							$("#succApp").show();
							$("#succAppMsg").html(res.message);
							$("#AppLoading").hide();
							
							setTimeout(function() { 
								$("#cancel_appointment_popup").modal('hide'); 
								window.location = "<?php echo site_url('admin/calendar') ?>";
								//location.reload();
							}, 3000);
						}
						else{
							$("#AppLoading").hide();
							$("#errApp").show();
							$("#errAppMsg").html(res.message);
						}
					}
				});
				//$("#appointment_cancel_id").val(appointment_cancel_id);
			}
			$(document).on("click",'#btnSendSms',function () {	
				$("#smsLoading").show();	
				var error = '';			
				var sms_mobile_number = $.trim($("#sms_mobile_number").val());
				var sms_mobile_message = $.trim($("#sms_mobile_message").val());
				
				if(sms_mobile_number == '')
				{
					error = error+'Please enter mobile number to send SMS.<br>';
				}
				if(sms_mobile_message == '')
				{
					error = error+'Please enter SMS text.<br>';
				}
				if(error != '')
				{
					$("#errSms").show();
					$("#errSmsMsg").html(error);
					$("#smsLoading").hide();
				}
				else
				{
					var sendMap = 0;
					if($('#send_map').is(":checked"))
					{
						sendMap = 1;
					}
					
					$.ajax({
						  url: '<?php echo base_url('admin/patients/send_header_sms') ?>',
						  type: 'POST',
						  data: {sms_mobile_number: sms_mobile_number,sms_mobile_message: sms_mobile_message, sendMap: sendMap},
						  success: function (result) {
							  var res = $.parseJSON(result);	 
							  if (res.status == 'success') {
								  $("#errSms").hide();
								  $("#errSmsMsg").html('');								  
								  
								  $("#succSms").show();
								  $("#succSmsMsg").html(res.message);
								  $("#smsLoading").hide();
								  
								  setTimeout(function() { $("#send_sms_popup").modal('hide'); }, 3000);
							  }
							  else{
								  $("#smsLoading").hide();
								  $("#errSms").show();
								  $("#errSmsMsg").html(res.message);
							  }
						  }
					  });	
				}
				
			});
        </script>