<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Doctori8 Practice Management System| Log in</title>
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
    
    
    <!-- jQuery 2.0.2 -->
    <script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header no-print">
            <img src="<?php echo base_url('assets/uploads/images/logoheader.jpg');?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <!--<?php echo 'Doctori8';?>--> 
            </a>
    <body class="bg-black">
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
        <div class="form-box" id="login-box">
	
            <div class="header"><?php echo 'Welcome'?></div>
            <form action="<?php echo site_url('admin/login/login')?>" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="<?php echo 'Your Email/Username'?>"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="<?php echo lang('password')?>"/>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> <?php echo lang('remember_me')?>
						<input type="hidden" value="admin/admin" name="redirect">
						<input type="hidden" value="submitted" name="submitted">
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn bg-olive btn-block"><?php echo lang('sign_in')?></button>
			
                    <span><a href="<?php echo site_url('forgot/forgot_password')?>"><?php echo lang('i_forgot_my_password')?></a></span>
					<span class="pull-right"><a href="<?php echo site_url('admin/register')?>"><?php echo lang('')?></a></span>
<a href="<?php echo site_url('admin/login/joinus');?>" style="margin-top:20px" class="btn bg-olive btn-block">Interested? Join us here!</a>

                </div>
            </form>

           
        </div>

       
    </body>
	     <script src="<?php echo base_url('assets/js/jquery-ui-1.10.3.min.js')?>" type="text/javascript"></script>
	        <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>" type="text/javascript"></script>

</html>
