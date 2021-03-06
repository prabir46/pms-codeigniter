<?php
	$this->load->view('register/header');
	$doctor_id = @trim($_GET['id']);
?>
<style>
.error{
    color: #FF0000;
}
</style>
<section class="content">
	<?php 
	if(validation_errors()){
?>
<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                        <b><?php echo lang('alert');?>!</b><?php echo validation_errors(); ?>
                                    </div>

<?php  } ?>


        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('register')?></h3>                                    
                </div><!-- /.box-header -->
				
				<form method="post">
                <div class="box-body">
                 		 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" value="<?php echo set_value('name')?>" class="form-control name" required>
                                </div>
                            </div>
                        </div>
						 	
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<input type="radio" name="gender" class="gender"value="Male" <?php echo (set_value('gender')=="Male")?'checked="checked"':'';?> required  /> <?php echo lang('male')?>
									<input type="radio" name="gender" class="gender" value="Female"  <?php echo (set_value('gender')=="Female")?'checked="checked"':'';?> required/> <?php echo lang('female')?>
                                </div>
                            </div>
                        </div>
						
							 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="dob" style="clear:both;">Age</label>
									<input type="text" name="dob" value="<?php echo set_value('dob')?>" class="form-control dob" required>
									
									</div>
								</div>
							</div>
						 <!--<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('username')?></label>
									<input type="text" name="username" value="<?php echo set_value('username')?>" class="form-control username" id="username" required>
                                	<label id="username-error" class="error" ></label>
								</div>
                            </div>
                        </div>-->
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" value="<?php echo set_value('email')?>" class="form-control email" required>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
									<input type="text" name="contact" value="<?php echo set_value('contact')?>" class="form-control contact" required>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                            <label for="contact" style="clear:both;"><?php echo 'Alternet no.';?></label>
                            <input type="text" name="contact1" value="<?php echo set_value('contact1')?>" class="form-control contact" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                            <label for="contact" style="clear:both;"><?php echo 'Aadhar Id.';?></label>
                            <input type="text" name="aadhar" value="<?php echo set_value('aadhar')?>" class="form-control contact" required>
                          </div>
                        </div>
                      </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control chzn blood_id" >
											<option value="">--<?php echo lang('select_blood_type');?>--</option>
											<?php foreach($groups as $new) {
													$sel = "";
													if(set_select('blood_id', $new->id)) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
                                </div>
                            </div>
                        </div>
               
			   		
						
                        
						<!--<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="password" style="clear:both;"><?php echo lang('password')?></label>
									<input type="password" name="password" value="" class="form-control password" required>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="password" style="clear:both;"><?php echo lang('confirm')?> <?php echo lang('password')?></label>
									<input type="password" name="confirm" value="" class="form-control confirm" required>
                                </div>
                            </div>
                        </div>-->
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
									<textarea name="address"  class="form-control address" required><?php echo set_value('address')?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo 'Medical History'?></label>
									<textarea name="medical_History"  class="form-control address" required><?php echo set_value('medical_History')?></textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="doctor_id" style="clear:both;"><?php echo lang('doctor')?></label>
                                    <?php
									//echo '<pre>'; print_r($doctors); echo '</pre>';
									?>
									<select name="doctor_id" id="doctor_id" class="form-control" required>
											<option value="">--<?php echo lang('select')?> <?php echo lang('doctor')?>--</option>
											<?php foreach($doctors as $new){
												if($doctor_id == $new->id){
												?>
												<option selected="selected" value="<?php echo $new->id?>"><?php echo $new->name?></option>
											<?php } else {
												?>
												<option value="<?php echo $new->id?>"><?php echo $new->name?></option>
											<?php
												} } ?>
									</select>	
							    </div>
                            </div>
                        </div>
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo 'Any contact with Covid-19 patient in last 15 days'?></label>
									 <input type="radio" name="contact_with_covid_patient" value="yes" class="form-control"> Yes &nbsp; <input type="radio" name="contact_with_covid_patient" value="no" class="form-control" checked="checked"> No
                                </div>
                            </div>
                        </div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
						</div>
                </div><!-- /.box-body -->
				</form>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script>
function call_loader(){
	
	if($('#overlay').length == 0 ){
		var over = '<div id="overlay">' +
						'<img  style="padding-top:300px; padding-left:500px;"id="loading" src="<?php echo base_url('assets/img/green-ajax-loader.gif')?>"></div>';
		
		$(over).appendTo('body');
	}
}
$("#username").on('blur',function() {   
    var val = $('#username').val();
	 if(val){
	 	call_loader();
	 	$.ajax({
		url: '<?php echo site_url('admin/register/check_username') ?>',
		type:'POST',
		data:{username:val,id:0},
		success:function(result){
		  if(result==1){
		  	 $("#overlay").remove();
		  	$('#username').val('');
			$('#username').focus();
			$('#username-error').show();
			$('#username-error').html('This Username Is Exists Try Again..');
			
		  }else{
		  	$('#username-error').hide();
		  }
		  $("#overlay").remove();
		}
	  });
	 }else{
	 	 $("#overlay").remove();
		 $('#username').val('');
		$('#username-error').html("Username Field Can't Be Empty");
	 }     
}); 
</script>
<?php
	$this->load->view('register/footer');
?>