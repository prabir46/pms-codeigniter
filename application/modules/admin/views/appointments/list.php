<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure');?>');
}
</script>
<style>
.chosen-container{width:100% !important}
.block{display:block !important}
</style>


<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active"><?php echo lang('appointments');?></li>
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
	   
  	  	 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <!--<a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>-->
                </div>
            </div>    
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('appointment_schedule');?></h3>                                    
                </div><!-- /.box-header -->
				
				
				 <div class="box-body table-responsive" style="margin-top:40px;">
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								
								<th><?php echo lang('with_whom');?></th>
								<th>Detail</th>
								<th><?php echo lang('motive');?></th>
								<th><?php echo lang('notes');?></th>
								<th><?php echo lang('status');?></th>
								<th>Close</th>
								<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($appointments)):?>
                        <tbody>
                            <?php $i=1;foreach ($appointments as $new){
								$with="";
								if($new->whom==1){
									$with=$new->patient;
								}
								if($new->whom==2){
									$with=$new->contact;
								}
								if($new->whom==3){
									$with=$new->other;
								}	
								
								if($new->status==0){
									$val ='<a href="'.site_url('admin/appointments/approve/'.$new->id).'/1" class="btn btn-danger">'.lang('approve').'</a>';
								}else{
									$val ='<a href="'.site_url('admin/appointments/approve/'.$new->id).'/0" class="btn btn-success">Approved</a>';
								}
								
								if($new->is_closed==1){
									$close ="<b>Closed</b>";
								}else{
									$close ='<a href="'.site_url('admin/appointments/close_record/'.$new->id).'" class="btn btn-info"> <i class="fa fa-times"></i>  Close</a>';
								}
							?>
                                <tr class="gc_row">
                                   <td><?php echo date("d/m/Y h:i:s a", strtotime($new->date))?></td>
                                   <td><?php echo $with;?></td>
								   <td><?php echo $new->title?></td>
								   <td><?php echo $new->motive?></td>
								   <td><?php echo substr($new->notes, 0,50)?></td>
								   <td><?php echo $val?></td>
								   <td><?php echo $close?></td>
								   <td width="25%">
                                        <div class="btn-group">
										 <a class="btn btn-default" href="#view<?php echo @$new->id; ?>" data-toggle="modal" ><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
										 <a class="btn btn-primary" href="#edit<?php echo @$new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/appointments/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
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





<?php if(isset($appointments)):?>
<?php $i=1;
foreach ($appointments as $apps){

$app = $this->appointment_model->get_appointment_by_doctor_id($apps->id);
//echo '<pre>'; print_r($app);die;
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $apps->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('appointment')?></h4>
      </div>
      <div class="modal-body">
	   <div id="err_edit<?php echo $apps->id?>">  
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
    		<form method="post">	
                    <input type="hidden" name="id" value="<?php echo $apps->id?>" />
					<div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"> <?php echo lang('detail')?></label>
									<input type="text" name="title" value="<?php echo $app->title; ?>" class="form-control title">
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
									   <select name="whom" class="form-control chzn whom" >
											<option value="0">--<?php echo lang('with_whom');?>--</option>
											<option value="1" <?php echo ($app->whom==1)?'selected="selected"':'';?> ><?php echo lang('patient');?></option>
											<option value="2" <?php echo ($app->whom==2)?'selected="selected"':'';?>><?php echo lang('contact');?></option>
											<option value="3" <?php echo ($app->whom==3)?'selected="selected"':'';?>><?php echo lang('other');?></option>
										
										</select>
                                </div>
							
                            </div>
                        </div>
						
						 <div class="form-group patient <?php echo ($app->whom==1)? 'block':''?>">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									   <select name="patient_id" class="form-control chzn patient_id">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($contacts as $new) {
													$sel = "";
													if($app->patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="form-group contact <?php echo ($app->whom==2)? 'block':''?>">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('contact');?></label>
									   <select name="contact_id" class="form-control chzn contact_id">
											<option value="">--<?php echo lang('select_contact');?>--</option>
											<?php foreach($contact as $new) {
													$sel = "";
													if($app->contact_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="form-group other <?php echo ($app->whom==3)? 'block':''?>">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('other');?></label>
									  <input type="text" name="other" class="form-control other_text" value="<?php echo $app->other?>" />
                                </div>
							
                            </div>
                        </div>

						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
									<textarea name="motive" class="form-control motive"><?php echo $app->motive; ?></textarea>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
									<input type="text" name="date_time" value="<?php echo $app->date; ?>" class="form-control datetimepicker date_time">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
									<textarea name="notes" class="form-control notes"> <?php echo $app->notes; ?></textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('is_paid')?></label>
									<input type="checkbox" name="is_paid" class="is_paid" <?php echo ($app->is_paid==1)?'checked="checked"':'';?> value="1" />
					            </div>
                            </div>
                        </div>
						
						
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary update" name="ok" value="ok"><?php echo lang('save');?></button>
                    </div>
				</div>	
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>
 <?php $i++;}?>
<?php endif;?>


<?php if(isset($appointments)):?>
<?php $i=1;
foreach ($appointments as $apps){

$app = $this->appointment_model->get_appointment_by_doctor_id($apps->id);
//echo '<pre>'; print_r($app);die;
?>
<!-- Modal -->
<div class="modal fade" id="view<?php echo $apps->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="viewlabel"><?php echo lang('view');?> <?php echo lang('appointment')?></h4>
      </div>
      <div class="modal-body">
	 
           		    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('detail')?></label>
								</div>
								<div class="col-md-4">
									<?php echo $app->title; ?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
							 <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
								</div>	
								
								<div class="col-md-4">
									<?php foreach($contacts as $new) {
													$sel = "";
													if($app->patient_id==$new->id&&$app->whom==1) echo $new->name;
												}
											?>
									
									<?php foreach($contact as $new) {
													$sel = "";
													if($app->contact_id==$new->id&&$app->whom==2) echo $new->name;
												}
											?>
											
									<?php echo ($app->whom==3)? $app->other:'';?>		
								
								   		(<?php echo ($app->whom==1)?lang('patient'):'';?> 
										<?php echo ($app->whom==2)? lang('contact'):'';?>
										<?php echo ($app->whom==3)? lang('other'):'';?>)
										
                                </div>
								
                            </div>
                        </div>
						
						
						
						

						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $app->motive; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $app->date; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
								</div>
								<div class="col-md-4">
									 <?php echo $app->notes; ?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('is_paid')?></label>
								</div>	
								<div class="col-md-4">
									<?php echo ($app->is_paid==1)?'Yes':'No';?> 
					            </div>
                            </div>
                        </div>
				
				</div>	
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

 <?php $i++;}?>
<?php endif;?>



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('add');?> <?php echo lang('appointment')?></h4>
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
          <form class="fform" id="add_app" method="post">                 
              <input type="hidden" name="hidden_id" class="hidden_id" value="<?php echo @$id; ?>" />
              <input type="hidden" name="hidden_type_id" class="hidden_type_id" value="<?php echo $_GET['type_id']; ?>" />
              <label style="display:none;">                    
                  <span>                        *Subject:              
                  </span>                    
                  <textarea class="required safe" id="Subject" name="Subject" style="width:60%;" ></textarea>
                  <input id="colorvalue" name="colorvalue" type="hidden" value="1" />                
              </label>                 
              <label style="display:none;">                    
                  <span >Color:</span>                    
                  <div id="calendarcolor" class="containtdiv" title="Color"></div>
              </label>                 
              <br />

              <div class="row">
                  <div class="control-group col-md-8">
                      <label for="name" style="clear:both;"><?php echo lang('consultant'); ?></label>
                      <?php $consultant_copy = $this->consultant_model->get_consultant_by_consultant(); ?>
                      <?php $treatment_Advised = $this->treatment_advised_model->get_case_history_by_doctor(); ?>
                      <div class="controls">
                          <select name="consultant" class="form-control chzn consultant_id " onchange="color_change(this)">
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

              <div class="row">
                  <div class="col-md-12">
                      <label for="name" style="clear:both;">*Time</label><br/>
                      <input MaxLength="10" class="required datepicker form-control" id="stpartdate" name="stpartdate"  type="text" value="" style="display:inline-block;width:160px"/>
                      <input MaxLength="5" class="form-control" id="stparttime" name="stparttime"  style="width:160px;display:inline-block"   type="text" value="" />

                      <script>
                      $(document).ready(function (){
                         $("#stpartdate").datetimepicker({format:'m/d/Y',timepicker:false,});
                         $("#stparttime").datetimepicker({format:'H:i',datepicker:false,});
                      });
                      </script>
                      <br /><br />
                      <label>
                          <span>
                              *Slot
                          </span>
                      </label>
                      <div style="width:200px">
                          <select name="slot" class="form-control chzn" id="slot">
                              <option value="15">15 minutes</option>
                              <option value="30">30 minutes</option>
                              <option value="60">1 hour</option>
                              <option value="90">1 hour 30 minutes</option>
                              <option value="120">2 hours</option>
                          </select>
                      </div>
                  </div>
                  <br/>

   <!--<input MaxLength="10" class="required date datepicker" id="etpartdate" name="etpartdate" type="text" value="" />                       
   <input MaxLength="5" class="required time" id="etparttime" name="etparttime" style="width:60px;" type="text" value="<?php echo (!empty($event)) ? $earr[1] : @$end[1]; ?>" /> -->                                           
                  <label class="checkp"> 
                      <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1" <?php if (!empty($event) && $allday != 0) {
                                  echo "checked";
                              } ?>/>          All Day Event                      
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
                              <label for="name" style="clear:both;"><?php echo lang('with_whom'); ?></label>
                              <select name="whom" class="form-control chzn whom" >
                                  <option value="0">--<?php echo lang('with_whom'); ?>--</option>
                                  <option value="1" <?php echo (@$whom == 1) ? 'selected="selected"' : ''; ?> ><?php echo lang('patient'); ?></option>
                                  <option value="2" <?php echo (@$whom == 2) ? 'selected="selected"' : ''; ?>><?php echo lang('contact'); ?></option>
                                  <option value="3" <?php echo (@$whom == 3) ? 'selected="selected"' : ''; ?>><?php echo lang('other'); ?></option>

                              </select>
                          </div>

                      </div>
                  </div>



                  <div class="control-group patient">
                      <div class="row">
                          <div class="col-md-8">
                              <label for="name" style="clear:both;"><?php echo lang('patient'); ?></label>
                              <select name="patient_id" class="form-control chzn patient_id " onchange="patient(this)">
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

                  <div class="control-group contact" >
                      <div class="row">
                          <div class="col-md-8">
                              <label for="name" style="clear:both;"><?php echo lang('contact'); ?></label>
                              <select name="contact_id" class="form-control chzn contact_id">
                                  <option value="">--<?php echo lang('select_contact'); ?>--</option>
<?php
foreach ($contact as $new) {
    $sel = "";
    if ($contact_id == $new->id)
        $sel = "selected='selected'";
    echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . ',' . $new->email . ',' . $new->contact . '</option>';
}
?>
                              </select>
                          </div>

                      </div>
                  </div>

                  <div class="control-group other" >
                      <div class="row">
                          <div class="col-md-8">
                              <label for="name" style="clear:both;"><?php echo lang('other'); ?></label>
                              <input type="text" name="other" class="form-control other_text" style="width:60%" value="<?php echo @$other; ?>"/>
                          </div>

                      </div>
                  </div>
                  <div class="control-group motive">
                      <div class="row">
                          <div class="col-md-8">
                              <label for="name" style="clear:both;"><b><?php echo ('Reason') ?></b></label>
                              <select name="motive" class="form-control chzn">
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
                      <!--<textarea name="motive" class="form-control motive" style="width:60%"><?php if ($followup == '') {
    echo @$motive;
} else {
    
} ?> </textarea> -->
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
              <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="ok" value="ok"><?php echo lang('save'); ?></button>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
		</form>

</div>         
    </div>
<style>
#divcalendarcolor{
display:none;
}
</style>
<script>
function patient(ddlFruits){
selectedText = ddlFruits.options[ddlFruits.selectedIndex].id;
document.getElementById("Subject").value=selectedText;
}
function color_change(ddlFruits){

selectedText = ddlFruits.options[ddlFruits.selectedIndex].id;
document.getElementById("colorvalue").value=selectedText;
}
$("#show_appointment").hide();
$("#show_hospital").hide()
$("#show_college").hide()
$(".patient").hide();
$(".detail").hide();
$(".paid").hide();
$(".contact").hide();
$(".other").hide();
$(document).on('change', '.whom', function(){
  vch = $(this).val();
  $( "div" ).removeClass( "block" );
	 
	if(vch==1){
		$(".patient").show();
		$(".paid").show();
		$(".contact").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	
	if(vch==2){
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	if(vch==3){
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
		$(".show").hide();
	}

});
setTimeout(function(){ 
vch = $('.whom').val();
//alert(vch);
if(vch==1){
		
		$("#show_appointment").show();
		$(".patient").show();
		$(".paid").show();
		$(".contact").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	
	if(vch==2){
		$("#show_appointment").show();
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	if(vch==3){
		$("#show_appointment").show();
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
		$(".show").hide();
	}
 }, 100);
</script>

<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('.chzn').chosen();
	$('#example1').dataTable({
	"aaSorting": [[0, 'desc']]
	});
});


$( "#add_app" ).submit(function( event ) {
	//title 		= $('input[name=title]').val();
	var form = $(this).closest('form');
	title = $(form ).find('.title').val();
	whom 		= $(form ).find('.whom').val();
	patient_id 	= $(form ).find('.patient_id').val();
	contact_id 	= $(form ).find('.contact_id').val();
	other	   	= $(form ).find('.other_text').val();
	date_time	= $(form ).find('.date_time').val();
	notes 		= $(form ).find('.notes').val();
	motive 		= $(form ).find('.motive').val();
	is_paid 		= $(form ).find('.is_paid:checked').val();
	//alert(is_paid); return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/datafeed?method=adddetails') ?>',
		type:'POST',
		data:$("#add_app").serialize(),
		dataType:"json",
		success:function(data){
		     alert(data.Msg);
                     $("#overlay").remove();
                     $("#add_appointment").modal('toggle');
		 }
	  });
	
	event.preventDefault();
});


$( ".update" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	title = $(form ).find('.title').val();
	whom = $(form ).find('.whom').val();
	patient_id = $(form ).find('.patient_id').val();
	contact_id = $(form ).find('.contact_id').val();
	other	   = $(form ).find('.other_text').val();
	date_time = $(form ).find('.date_time').val();
	notes = $(form ).find('.notes').val();
	motive = $(form ).find('.motive').val();
	is_paid 		= $(form ).find('.is_paid:checked').val();
//	alert(date_time);return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/appointments/edit_appointment') ?>/' + id,
		type:'POST',
		data:{title:title,whom:whom,patient_id:patient_id,contact_id:contact_id,other:other,date_time:date_time,motive:motive,notes:notes,is_paid:is_paid},
		
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
					$("#overlay").remove();
					$('#err_edit'+id).html(result);
				}
		  
		 }
	  });
	
	
});


$(document).on('focusout', '.datetimepicker', function(){
  vch = $(this).val();
  
  call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/appointments/check_datetime') ?>',
		type:'POST',
		data:{datetime:vch},
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					$("#overlay").remove();
					$('.datetimepicker').val(' ');
					alert("This Date Time Is Not Available"); 
					 //window.close(); 
				}
				else
				{
					$("#overlay").remove();
					//$('#err_edit'+id).html(result);
				}
		  
		 }
	  });
});


 jQuery('.datetimepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'January','February','March','April',
    'May','June','July','August',
    'September','October','November','December',
   ],
   dayOfWeek:[
    "Sun.", "Mon", "Tue", "Wed", 
    "Thu", "Fri", "Sat",
   ]
  }
 },
 timepicker:true,
 format:'y-m-d H:i:00'
});
$(".patient").hide();
$(".contact").hide();
$(".other").hide();
$(document).on('change', '.whom', function(){
  vch = $(this).val();
  $( "div" ).removeClass( "block" );
	//alert(vch);  
	if(vch==1){
		$(".patient").show();
		$(".contact").hide();
		$(".other").hide();
	}
	
	if(vch==2){
		$(".contact").show();
		$(".patient").hide();
		$(".other").hide();
	}
	if(vch==3){
		$(".contact").hide();
		$(".patient").hide();
		$(".other").show();
	}

});
</script>