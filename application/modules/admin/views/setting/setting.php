<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo lang('general_settings')?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
      
        <li class="active"><?php echo lang('general_settings')?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
<?php 
	if(validation_errors()){
?>
<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                        <b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
                                    </div>

<?php  } ?>  
	   	
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                   
                </div><!-- /.box-header -->
                <!-- form start -->
				
			
				<form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/settings/')?>"
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('company_name')?></b>
								</div>
								<div class="col-md-4">
                                    
									<input type="text" name="name" value="<?php echo @$settings->name;?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('logo')?></b>
								</div>
								<div class="col-md-4">
                                    
									<input type="file" name="img" value="" class="form-control">
                                </div>
								<div class="col-md-4">
								<?php 
								if(@$settings->image != 0 || !empty($settings->image)){
								?>
								<img src="<?php echo base_url('assets/uploads/images/'.@$settings->image); ?>" width="140" height="100" />
								<?php
								}
								?>
								</div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('address')?></b>
								</div>
								<div class="col-md-4">
                                    
									<textarea name="address" class="form-control"><?php echo @$settings->address;?></textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('phone')?></b>
								</div>
								<div class="col-md-4">
                                    
									<input type="text" name="contact" value="<?php echo @$settings->contact;?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('email')?></b>
								</div>
								<div class="col-md-4">
                                    
									<input type="text" name="email" value="<?php echo @$settings->email;?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-4">
                                    
									<input type="text" name="invoice" value="<?php echo @$settings->invoice;?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo "Username"?></b>
                                </div>
                                <div class="col-md-4">

                                    <input type="text" name="username" value="<?php echo @$settings->username;?>" class="form-control">
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b>Session Time (Hours)</b>
								</div>
								<div class="col-md-4">
                                    
									<input type="number" name="session_hours" value="<?php echo @$settings->session_hours;?>" min="1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b>Map Location Link</b>
								</div>
								<div class="col-md-4">                                    
									<input type="text" name="map_location" value="<?php echo @$settings->map_location;?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        	<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo "Signature";?></b>
								</div>
								<div class="col-md-4">
                                    
									<input type="file" name="img1" value="" class="form-control">
                                </div>
								<div class="col-md-4">
								<?php 
								if(@$settings->image1 != 0 || !empty($settings->image1)){
								?>
								<img src="<?php echo base_url('assets/uploads/images/'.@$settings->image1); ?>" width="140" height="100" />
								<?php
								}
								?>
								</div>
                            </div>
                        </div>
                        
						<?php if($admin['user_role']=='Admin'){?>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('db_restore')?></b>
								</div>
								<div class="col-md-4">
                                    
									<input type="file" name="db" value="" class="form-control">
                                </div>
							</div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('db_backup')?></b>
								</div>
								<div class="col-md-4">
                                 <a href="<?php echo site_url('admin/settings/export') ?>" class="btn btn-primary"><?php echo lang('download')?></a>
                                </div>
                            </div>
                        </div>
						<?php } ?>


					   			
                       <div class="box-footer" style="padding-left:25%">
							<button  type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
						</div>
						
                    </div><!-- /.box-body -->
    
                   
             </form>
            </div><!-- /.box -->
        </div>
     </div>
</section>  



<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Client</h4>
      </div>
      <div class="modal-body">
			<form method="post" action="<?php echo base_url('admin/clients/add') ?>">
			         <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;">Name</label>
									<input type="text" name="name" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="gender" style="clear:both;">Gender</label>
									<input type="radio" name="gender" value="Male" /> Male
									<input type="radio" name="gender" value="Female" /> Female
                                </div>
                            </div>
                        </div>
               
			   			 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="dob" style="clear:both;">Date Of Birth</label>
									<input type="text" name="dob"  class="form-control datepicker">
									
                                </div>
                            </div>
                        </div>
						
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="email" style="clear:both;">Email</label>
									<input type="text" name="email" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="username" style="clear:both;">Username</label>
									<input type="text" name="username" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="password" style="clear:both;">Password</label>
									<input type="password" name="password" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="password" style="clear:both;">Confirm Password</label>
									<input type="password" name="confirm" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;">Contact No.</label>
									<input type="text" name="contact" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;">Address</label>
									<textarea name="address"  class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
             </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});

$(function() {
	//bootstrap WYSIHTML5 - text editor
	$(".txtarea").wysihtml5();
});

 $(function() {
    $( ".datepicker" ).pickmeup({
    format  : 'Y-m-d'
});
  });
</script>