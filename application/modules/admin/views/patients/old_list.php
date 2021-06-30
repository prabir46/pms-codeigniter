<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('Are You Sure');
}
</script>
<style>
.chosen-container{width:100% !important}
</style>
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list')?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active"><?php echo lang('patients')?></li>
        </ol>
</section>

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
<?php /*
		 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="">
                    <div class="col-xs-4">
						<select name="filter" id="patient_id" class="form-control chzn">
							<option value="0">--<?php echo lang('filter')?>--</option>
										<?php foreach($patients as $new) {
											$sel = "";
											echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.', '.$new->username.', '.$new->contact.'</option>';
										}
										
										?>
						</select>
					</div>
				
					
                </div>
            </div>    
        </div>	
*/ ?>


  	  	 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add" onclick="{$('td.xdsoft_today').trigger('click.xdsoft');}" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new')?> </a>
					<a class="btn btn-danger" style="margin-left:12px;" href="<?php echo site_url('admin/patients/export/'); ?>"><i class="fa fa-download"></i> <?php echo lang('export')?></a>
                </div>
            </div>    
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('patients')?></h3>                                    
                </div><!-- /.box-header -->
				
				<div class="col-xs-6"  style="float:right">
				<form method="post">
						<div class="col-xs-5">
							<input type="text" name="search" value="<?php echo @$_POST['search']?>" placeholder="Search" class="form-control" required="required" />
						</div>
						<div class="col-xs-5">
							<select name="filter_id" class="form-control" >
								<option value="">--Filter--</option>
								<option value="name" <?php echo (@$_POST['filter_id']=="name")?'selected="selected"':'';?> >Name</option>
								<option value="address" <?php echo (@$_POST['filter_id']=="address")?'selected="selected"':'';?>>Address</option>
								<option value="gender" <?php echo (@$_POST['filter_id']=="gender")?'selected="selected"':'';?>>Gender</option>
								<option value="dob" <?php echo (@$_POST['filter_id']=="dob")?'selected="selected"':'';?>>Age</option>
								<option value="contact" <?php echo (@$_POST['filter_id']=="contact")?'selected="selected"':'';?>>Telephone Number5</option>
								<option value="email" <?php echo (@$_POST['filter_id']=="email")?'selected="selected"':'';?>>Email</option>
								<option value="username" <?php echo (@$_POST['filter_id']=="username")?'selected="selected"':'';?>>Username</option>
<option value="group" <?php echo (@$_POST['filter_id']=="group")?'selected="selected"':'';?>>Group</option>
							</select>
						</div>
						<div class="col-xs-2">
							<input type="submit" name="ok" value="Search" class="btn btn-default" />
						</div>
				</form>		
				</div>
				
                <div class="box-body table-responsive" style="margin-top:40px;" id="result">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number')?></th>
								<th><?php echo lang('name')?></th>
								<th><?php echo lang('address')?></th>
								<th><?php echo lang('gender')?></th>
								<th><?php echo lang('age')?></th>
                                <th><?php echo lang('phone')?></th>
								<th><?php echo lang('email')?></th>
								<th><?php echo lang('username')?></th>
								<th width="35%" style="display:none"><?php echo lang('action')?></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($patients)):?>
                        <tbody style="cursor:pointer">
                            <?php $i=1;foreach ($patients as $new){?>
							
                                <tr class="gc_row">
                                    <td id="<?php echo $new->id?>"><?php echo $i?></td>
                                    <td id="<?php echo $new->id?>"><?php echo ucwords($new->name)?></td>
                                    <td id="<?php echo $new->id?>"><?php echo $new->address ?></td>
									<td id="<?php echo $new->id?>"><?php echo $new->gender ?></td>
									<td id="<?php echo $new->id?>"><?php echo date('Y') - $new->dob ?></td>
									<td id="<?php echo $new->id?>"><?php echo $new->contact ?></td>
									<td id="<?php echo $new->id?>"><?php echo $new->email ?></td>
									<td id="<?php echo $new->id?>"><?php echo $new->username ?></td>
                                    <td width="35%" style="display:none">
                                        <div class="btn-group">
                                          <a class="btn btn-default"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view')?></a>
										  <a class="btn btn-primary"  style="margin-left:12px;" href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/patients/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
                                        </div>
                                   
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
												Action <span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-default pull-right" role="menu">
												
												<li>
													<a href="<?php echo site_url('admin/patients/payment_history/'.$new->id); ?>">
														<i class="entypo-eye"></i>
														<?php echo lang('payment_history')?>                               </a>
												</li>
												<li class="divider"></li>
												<li>
													<a href="<?php echo site_url('admin/patients/medication_history/'.$new->id); ?>">
														<i class="entypo-eye"></i>
														<?php echo lang('medication_history')?> </a>                        </a>
												</li>
												
												
												
											</ul>
										</div>
                </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
					
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>

<!--<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('patient')?></h4>
      </div>
      <div class="modal-body">
	   <div id="err">  
				<?php 
			if(validation_errors()){
		?>
		<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
											</div>
		
		<?php  } ?>  
			</div>
					<form method="post" action="<?php echo site_url('admin/patients/add/')?>" id="add_form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" value="<?php echo set_value('name')?>" class="form-control name">
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
									<textarea name="address"  class="form-control address"><?php echo set_value('address')?></textarea>
                                </div>
                            </div>
                        </div>
							
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<input type="radio" name="gender" class="gender"value="Male" <?php echo (set_value('gender')=="Male")?'checked="checked"':'';?>  /> <?php echo lang('male')?>
									<input type="radio" name="gender" class="gender" value="Female"  <?php echo (set_value('gender')=="Female")?'checked="checked"':'';?>/> <?php echo lang('female')?>
                                </div>
                            </div>
                        </div>
						
							 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="dob" style="clear:both;">Age</label>
									<input type="text" name="dob" value="<?php echo set_value('dob')?>" class="form-control dob">
									
									</div>
								</div>
							</div>
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
									<input type="text" name="contact" value="<?php echo set_value('contact')?>" class="form-control contact">
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" value="<?php echo set_value('email')?>" class="form-control email">
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control chzn blood_id">
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
               
			   		
						
                        
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="password" style="clear:both;"><?php echo lang('password')?></label>
									<input type="password" name="password" value="" class="form-control password">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="password" style="clear:both;"><?php echo lang('confirm')?> <?php echo lang('password')?></label>
									<input type="password" name="confirm" value="" class="form-control confirm">
                                </div>
                            </div>
                        </div>
	<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label  style="clear:both;"><?php echo 'Group'?> </label>
									<input type="text" name="group" value="" class="form-control group">
                                </div>
                            </div>
                        </div>
				
						
						
						
						
						<?php 
						if($fields){
							foreach($fields as $doc){
							$output = '';
							if($doc->field_type==1) //testbox
							{
						?>
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							<input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" id="req_doc" />
								</div>
                            </div>
                        </div>
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							<select name="reply[<?php echo $doc->id ?>]" class="form-control">
							<?php	
										foreach($values as $key=>$val) {
											echo '<option value="'.$val.'">'.$val.'</option>';
										}
							?>			
							</select>	
								</div>
                            </div>
                        </div>
						<?php	}	
								if($doc->field_type==3) //radio buttons
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
						
						<?php }
						if($doc->field_type==4) //checkbox
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" class="form-control" />	<?php echo $val;?>&nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
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
                 
                        <button type="submit" class="btn btn-primary" ><?php echo lang('save')?></button>
                 
                    </div>
    
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>-->

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:1200px">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('patient')?></h4>
      </div>
      <div class="modal-body">
	   <div id="err">  
				<?php 
			if(validation_errors()){
		?>
		<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
											</div>
		
		<?php  } ?>  
			</div>
					<form method="post" action="<?php echo site_url('admin/patients/add/')?>" id="add_form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" value="<?php echo set_value('name')?>" class="form-control name">
                                </div>
                                <div class="col-md-6">
                                  <label for="date" style="clear:both">Date of Creation</label>
                                                                        <input type="text" id="dte" name="date" class="form-control datetimepicker" />
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
									<textarea name="address"  class="form-control address"><?php echo set_value('address')?></textarea>
                                </div>
                                <div class="col-md-6">
                                  <label for="medicalhistory" style="clear:both">Medical History</label>
                                                                         <select name="medical_History[]" class="form-control chzn" multiple="multiple">
<?php 
foreach($medical_history as $new){
echo '<option>'.$new->name.'</option>';
}
?>
</select>                                  
                                </div> 
                            </div>
                        </div>
							
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<br/><input type="radio" name="gender" class="gender"value="Male" <?php echo (set_value('gender')=="Male")?'checked="checked"':'';?>  /> <?php echo lang('male')?>
									<input type="radio" name="gender" class="gender" value="Female"  <?php echo (set_value('gender')=="Female")?'checked="checked"':'';?>/> <?php echo lang('female')?>
                                </div> 
                            </div>
                        </div>
						
							 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="dob" style="clear:both;">Age</label>
									<input type="text" name="dob" value="<?php echo set_value('dob')?>" class="form-control dob" style="width:90px">
									
									</div>
                                <div class="col-md-6">
                                  <label for="referredby" style="clear:both">Referred By</label>
                                                                         <input type="text" name="referredby" class="form-control" />                               
                                </div>
								</div>
							</div>
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
									<input type="text" name="contact" value="<?php echo set_value('contact')?>" class="form-control contact">
                                </div>
                                <div class="col-md-6">
                                  <label for="aadhar" style="clear:both">Aadhar</label>
                                                                         <input type="text" name="aadhar" class="form-control" />                               
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" value="<?php echo set_value('email')?>" class="form-control email">
                                </div>
                                <div class="col-md-6">
                                  <label for="insurance" style="clear:both">Name of Insurance (If any)</label>
                                                                         <input type="text" name="insurance" class="form-control" />                               
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control chzn blood_id">
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
           
				
						
						
						
						
						<?php 
						if($fields){
							foreach($fields as $doc){
							$output = '';
							if($doc->field_type==1) //testbox
							{
						?>
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							<input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" id="req_doc" />
								</div>
                            </div>
                        </div>
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							<select name="reply[<?php echo $doc->id ?>]" class="form-control">
							<?php	
										foreach($values as $key=>$val) {
											echo '<option value="'.$val.'">'.$val.'</option>';
										}
							?>			
							</select>	
								</div>
                            </div>
                        </div>
						<?php	}	
								if($doc->field_type==3) //radio buttons
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
						
						<?php }
						if($doc->field_type==4) //checkbox
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" class="form-control" />	<?php echo $val;?>&nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
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
                 
                        <button type="submit" class="btn btn-primary" ><?php echo lang('save')?></button>
                 
                    </div><!-- /.box-body -->
    
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>





<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/scroller/1.4.3/js/dataTables.scroller.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>-->
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$( "#add_form" ).submit(function( event ) {
	name 		= $('.name').val();
	gender 		= $('input:radio[name=gender]:checked').val();
	blood_id = $('.blood_id').val();
	dob = $('.dob').val();
	//username = $('.username_u').val();
	email = $('.email').val();
	password = $('.password').val();
	conf = $('.confirm').val();
	contact = $('.contact').val();
	address = $('.address').val();
group= $('.group').val();
	//alert(blood_id);return false;
	
	call_loader_ajax();
	$.ajax({
		url: '<?php echo base_url('admin/patients/add') ?>',
		type:'POST',
		//data:{name:name,gender:gender,blood_id:blood_id,dob:dob,email:email,password:password,confirm:conf,contact:contact,address:address,group:group},
		data:$('#add_form').serialize(),
		success:function(result){
		//alert(result);return false;
			  if(result==1)
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

$( ".update" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	name = $(form ).find('input[name=name]').val();
	gender = $('input:radio[name=gender]:checked').val();
	blood_id = $(form ).find('.blood_id').val();
	dob = $(form ).find('input[name=dob]').val();
	//username = $(form ).find('input[name=username]').val();
	email = $(form ).find('input[name=email]').val();
	password = $(form ).find('input[name=password]').val();
	conf = $(form ).find('input[name=confirm]').val();
	contact = $(form ).find('input[name=contact]').val();
	address = $(form ).find('.address').val();
	//alert(blood_id);return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo base_url('admin/patients/edit') ?>/' + id,
		type:'POST',
		data:{name:name,gender:gender,blood_id:blood_id,dob:dob,email:email,password:password,confirm:conf,contact:contact,address:address},
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").hide();
					$('#err_edit'+id).html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
	
	
});



$(document).ready( function() {
  /*$( '#example1' ).dataTable( {
   "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
     // Bold the grade for all 'A' grade browsers
     if ( aData[4] == "A" )
     {
       $('td:eq(4)', nRow).html( '<b>A</b>' );
     }
   }
 } );*/

   $('#example1').DataTable( {
            deferRender:    true,
            scrollY:        600,
            scrollCollapse: true,
            scroller:       true
        } );

 } );

$(function() {
	$(".chzn").chosen({search_contains:true});
});
jQuery('.datepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'Januar','Februar','März','April',
    'Mai','Juni','Juli','August',
    'September','Oktober','November','Dezember',
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

jQuery('.datetimepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'Januar','Februar','März','April',
    'Mai','Juni','Juli','August',
    'September','Oktober','November','Dezember',
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

$(document).on('change', '#patient_id', function(){
  vch = $(this).val();
  
  call_loader_ajax();
 	  
  $.ajax({
    url: '<?php echo base_url('admin/patients/get_patient') ?>',
    type:'POST',
    data:{id:vch},
    success:function(result){
      //alert(result);return false;
	  
	  $('#result').html(result);
	  $(".chzn").chosen({search_contains:true});
	  $('#example1').dataTable({});
	  $("#overlay").hide();
		
	 }
  });
});
</script>

<script>
$("#example1 tbody td").on('click',function() {   
    var id = $(this).attr('id');
    document.location.href = "<?php echo site_url('admin/patients/view/')?>/" + id;       
}); 

</script>
