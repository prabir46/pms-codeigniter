<link href="<?php echo base_url('assets/js/lightbox/simplelightbox.min.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/js/lightbox/demo.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
.chosen-container{width:100% !important}
#month-chart > svg {width: 100% !important;}
.error{
    color: #FF0000;
}
</style>
<?php $admin = $this->session->userdata('admin');?>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo $patient->name?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
      
        <li class="active"><?php echo $patient->name?></li>
    </ol>
</section>


<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                   
                </div><!-- /.box-header -->
                <!-- form start -->
			       <div class="box-body">
                       
			          <div class="row">
                        <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="<?php echo (empty($tab))?'active':'';?>"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?php echo $patient->name?></a></li>
                                    <li class="<?php echo ($tab=="medication_history")?'active':'';?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Medication History</a></li>
									 <li class="<?php echo ($tab=="payment_history")?'active':'';?>"><a href="#tab_3" data-toggle="tab" aria-expanded="false">Payment History</a></li>
									  <li class="<?php echo ($tab=="appointment")?'active':'';?>"><a href="#tab_4" data-toggle="tab" aria-expanded="false">Appointments</a></li>
                                   	 <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false" style="display:none">Reports</a></li>
									  <li class="<?php echo ($tab=="message")?'active':'';?>"><a href="#tab_6" data-toggle="tab" aria-expanded="false">Message</a></li>
									  <li class="<?php echo ($tab=="notes")?'active':'';?>"><a href="#tab_7" data-toggle="tab" aria-expanded="false">Notes</a></li>
									  <li class="<?php echo ($tab=="images")?'active':'';?>"><a href="#tab_8" data-toggle="tab" aria-expanded="false">Images</a></li>

<li class="<?php echo ($tab=="treatment_plan")?'active':'';?>"><a href="#tab_9" data-toggle="tab" aria-expanded="false">Treatment Plan</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane <?php echo (empty($tab))?'active':'';?>" id="tab_1">
                                    	<!--graph code start  -->
										
                            <!-- solid sales graph -->
                            <div class="box-body">
								
                               <div class="box-header ">
                                    <h3 class="box-title">View Patient</h3>
									
                                  <a class="btn btn-primary"  style="float:right; color:#FFFFFF" href="#edit_patient<?php echo $patient->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
								 </div>
                              
							    <table class="table table-bordered table-striped dataTable" >
									<tr>
										<th width="30%"><?php echo lang('name')?></th>
										<td><?php echo $patient->name?></td>
									</tr>
									<tr>
										<th><?php echo lang('address')?></th>
										<td><?php echo $patient->address?></td>
									</tr>
									<tr>
										<th><?php echo lang('gender')?></th>
										<td><?php echo $patient->gender?></td>
									</tr>
									<tr>
										<th>Age</th>
										<td><?php echo date("Y")-$patient->dob?></td>
									</tr>
									<tr>
										<th><?php echo lang('phone')?></th>
										<td><?php echo $patient->contact?></td>
									</tr>
									<tr>
										<th><?php echo lang('email')?></th>
										<td><?php echo $patient->email?></td>
									</tr>
									<tr>
										<th><?php echo lang('username')?></th>
										<td><?php echo $patient->username?></td>
									</tr>
									<tr>
										<th><?php echo lang('blood_type')?></th>
										<td><?php foreach($groups as $new) {
													$sel = "";
													if($new->id==$patient->blood_group_id){
													echo	$new->name;
													}
												}
												
											?></td>
									</tr>
<tr>
										<th><?php echo 'OPD No.'?></th>
										<td><?php echo $patient->group?></td>
									</tr>
									
					<?php 
					$CI = get_instance();
						if($fields){
							foreach($fields as $doc){
							$output = '';
							if($doc->field_type==1) //testbox
							{
						?>
							<tr>
						            <th><?php echo $doc->name; ?></th>
									<td>	
										<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();?>		
							<?php echo @$result->reply; ?>
									</td>
							</tr>		
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<tr>
						            <th><?php echo $doc->name; ?></th>
									<td>	
								<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."'  ")->row();?>	
										<?php 
										$values = array();
										foreach($values as $key=>$val) {
											$sel='';
											if($val==$result->reply) echo $val;
										}
							?>			<?php echo @$result->reply; ?>
								</td>
                        </tr>	
						<?php	}	
								if($doc->field_type==3) //radio buttons
							{
								$values = explode(",", $doc->values);
					?>	<tr>
						            <th><?php echo $doc->name; ?></th>
									<td>		
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= $val;
								}else{
									$x='';
								}
							}
							?>			
						
						<?php echo $x;?>
 							<?php 			}
							?>			
							</td>
						</tr>	
						<?php }
						if($doc->field_type==4) //checkbox
							{
								$values = explode(",", $doc->values);
					?><tr>
						            <th><?php echo $doc->name; ?></th>
									<td>	
								<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= $val;
								}else{
									$x='';
								}
							}
							?>	
										
										<?php echo $x;?>
 							<?php 			}
							?>			
								</td>
						</tr>		
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
                             <tr>
						            <th><?php echo $doc->name; ?></th>
									<td>	
									<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."'")->row();?>	
									<?php echo @$result->reply;?>
								</td>
							</tr>	
							
						
						
					<?php 
								}	
							}
						}
					?>
								</table>
								
               
						
                        
						
						
						

                                </div><!-- /.box-body -->
                        

										<!--graph code end -->
									</div><!-- /.tab-pane -->
                                    <div class="tab-pane <?php echo ($tab=="medication_history")?'active':'';?>" id="tab_2">
                                         <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Medication History</h3>
									
									<a href="#add_prescription" data-toggle="modal" class="btn btn-default" style="float:right"> <i class="fa fa-plus"></i> Add Prescription</a>
                                </div>
								
                                <div class="box-body border-radius-none">
                                   <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="display:none"></th>
								<th><?php echo lang('date');?></th>
								<th width="20%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($prescriptions)):?>
                        <tbody>
                            <?php $i=1;foreach ($prescriptions as $new){?>
                                <tr class="gc_row">
									<td style="display:none"></td>
                                    <td><?php echo date("d/m/Y", strtotime($new->date_time));?></td>
                        		    <td width="45%">
                                        <div class="btn-group pull-right">
                                        <?php $admin = $this->session->userdata('admin');
										if($admin['user_role']==1){?>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#reports<?php echo $new->id?>" data-toggle="modal" > <i class="fa fa-file"></i> <?php echo lang('reports');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#myModal<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view');?> <?php echo lang('prescription')?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#edit_prescription<?php echo $new->id; ?>" data-toggle="modal"  ><i class="fa fa-edit"></i> <?php echo lang('edit');?> </a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/prescription/delete/'.$new->id.'/'.$patient->id); ?>" onclick="return confirm('Are You Sure')"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
								<?php }else{ ?>
								 <a class="btn btn-primary" style="margin-left:10px;"  href="#report<?php echo $new->id; ?>" data-toggle="modal"> <i class="fa fa-file"></i> <?php echo lang('reports');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#myModal<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view');?> <?php echo lang('prescription')?></a>
										 
								<?php } ?>		 
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                                    </div><!-- /.tab-pane -->
									
									 <div class="tab-pane <?php echo ($tab=="payment_history")?'active':'';?>" id="tab_3">
                                       <!-- solid sales graph -->
                                <div class="box-header">
                                    <h3 class="box-title">Payment History</h3>
                                    <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add_inv" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add') ." ". lang('payment');?></a>
                </div>
                                </div>
                                <div class="box-body border-radius-none">
                               	
							   	<table id="example2" class="table table-bordered table-striped table-mailbox">
                        <thead>
						<?php $totL='';$pen=0;$totL1='';$tlsam=0;$amts=0;$tid='';$pra=0; ?>
                               	<?php $i=1;foreach ($fees_all as $new){?>

<?php 
if($pra==0){
$amts=json_decode($new->balance);
$tid=$new->id;
$pra++;
}
$pen1=$new->status;
if($pen1!=0){
$totL1= $new->amount;
 $pen=$new->status;
}
$sts=$new->status;
$tttlam=$new->amount;
if($sts==0){
$totL=$totL+$tttlam;
}
if($sts!=0){
$tlsam=$new->amount;

}
//$totL= $new->amount?>
<?php } ?>
<?php
if(1==2){

}else{
$totL=0;
$totL=$totL+$tlsam;
echo "<p style='color:#3c8dbc;font-size: 19px; font-weight: 600;'>Total Amount = ".$totL." <a href='#amout".$patient->id."' style='color:#68bc3c;' data-toggle='modal'>Update</a></p>"; 
}
 ?>
                            <tr>
                               <td style="display:none">#</td>
								<th><?php echo lang('date')?></th>
								<th><?php echo lang('invoice_number')?></th>
								<th><?php echo lang('amount')?></th>
								<th><?php echo lang('payment_mode')?></th>
								<th width="10%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($fees_all)):?>
                        <tbody>
                            <?php $i=1;foreach ($fees_all as $new){?>
                                <tr class="gc_row">
									<td style="display:none"><?php echo $i; ?></td>
									<td><?php echo json_decode($new->dates) ?></td>
									<td><?php echo $new->invoice ?></td>
								    <td><?php echo json_decode($new->balance);?>
									<?php 
$bal= json_decode($new->balance);
 $bal1=($bal1)+($bal);?>
									</td>
									<td><?php echo $new->mode?></td>
									
                                    <td width="30%">
										 <a class="btn btn-default" style="margin-left:20px;" href="#invoice<?php echo $new->id; ?>"  data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice')?></a>
										 <a class="btn btn-primary" style="margin-left:10px;"  href="#edit_invoice<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
										 <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/payment/delete_payment/'.$new->id.'/'.$this->uri->segment(4)); ?>" onclick="return confirm('Are You Sure')"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
                                        
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
<?php 

if($totL==''){

}else{

echo "<p style='color:red;font-size: 19px; font-weight: 600;'>Pending Amount = ".$pen."</p>"; 
}
 ?>
                                </div><!-- /.box-body -->
                                    </div><!-- /.tab-pane -->
									
									 <div class="tab-pane <?php echo ($tab=="appointment")?'active':'';?>" id="tab_4">
                                       <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Appointments</h3>
                               
							    	<div class="btn-group pull-right" style="padding:10px;">
										<a class="btn btn-default" href="#add_appointment" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
									</div>
								</div>
                                <div class="box-body">
                                     <table id="example4" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                               	<th style="display:none"></th>
							    <th><?php echo lang('date');?></th>
								<th><?php echo lang('motive');?></th>
								<th><?php echo lang('notes');?></th>
								<th><?php echo lang('status');?></th>
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
									$close ='<a href="'.site_url('admin/appointments/close_record/'.$new->id.'/'.$patient->id).'" class="btn btn-info"> <i class="fa fa-times"></i>  Close</a>';
								}
							?>
                                <tr class="gc_row">
									<td style="display:none"></td>
                                   <td><?php echo date("d/m/Y h:i:s a", strtotime($new->date))?></td>
                            	   <td><?php echo $new->motive?></td>
								   <td><?php echo substr($new->notes, 0,50)?></td>
								   <td><?php echo $close?></td>
								   <td width="25%">
                                        <div class="btn-group">
										 <a class="btn btn-default" href="#view_appointment<?php echo @$new->id; ?>" data-toggle="modal" ><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
										 <a class="btn btn-primary" href="#edit_appointment<?php echo @$new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/appointments/delete/'.$new->id.'/'.$patient->id); ?>" onclick="return confirm('are you sure')"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
    
                        <?php endif;?>
                    </table>
					
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                                    </div><!-- /.tab-pane -->
									
									
									  <div class="tab-pane" id="tab_5">
                                         <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Reports</h3>
                                </div>
                                <div class="box-body border-radius-none">
                                   <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								 <th><?php echo lang('type');?></th>
								<th><?php echo lang('remark');?></th>
								<th><?php echo lang('from');?></th>
								<th><?php echo lang('to');?></th>
								<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                        
                      
                        <tbody>
                            <?php $i=1;foreach ($reports as $prescription){
							//if($prescription)
							?>
                                <tr class="gc_row">
                                    <td><?php echo date("d/m/y h:i", strtotime($prescription->date_time))?></td>
                                    <td><?php echo $prescription->type?></td>
									<td><?php echo $prescription->remark?></td>
									 <td><?php echo $prescription->from_user?></td>
									  <td><?php echo $prescription->to_user?></td>
								    <td width="20%">
                                        <div class="btn-group">
								
									<?php if(!empty($prescription->file)){?>	
                                         <a href="<?php echo base_url('assets/uploads/files/'.$prescription->file)?>" class="btn btn-default"  download>Download</a>
                                     <?php }else{?>
									 	<a href="#" class="btn btn-default" style="width:85px;">N/A</a>
									 <?php  } ?>  
									     <a class="btn btn-danger" style="margin-left:10px;" href="<?php echo site_url('admin/prescription/delete_report/'.$prescription->id); ?>" onclick="return confirm('Are You Sure')"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;} ?>
                        </tbody>
                       
                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                                    </div><!-- /.tab-pane -->
									
		<?php //============================================================================================== ?>


<div class="tab-pane <?php echo ($tab=="treatment_plan")?'active':'';?>" id="tab_9">
                                       <!-- solid sales graph -->
                                <div class="box-header">
                                    <h3 class="box-title">Treatment Plan</h3>
                                    <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add_inv1" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add') ." ". 'Treatment Plan';?></a>
                </div>
                                </div>
                                <div class="box-body border-radius-none">
                               	
							   	<table id="example2" class="table table-bordered table-striped table-mailbox">
                        <thead>
						
                               	


                            <tr>
                               <td >SR.NO.</td>
								<th>Tooth No.</th>
								<th>Treatment Done</th>
								
								<th width="10%"></th>
                            </tr>
                        </thead>
                        
                        
                        <tbody>
                            <?php 

$i=1;foreach ($tooth_list as $new){?>
                                <tr class="gc_row">
									<td ><?php echo $i; ?></td>
									<td><?php
$th=json_decode($new->tooth);
print_r($th[0]); ?></td>
									<td><?php 
$th1=json_decode($new->treatment_Advised_id);
print_r($th1[0]); ?></td>
								   
									
                                    <td width="30%">
										
										 <a class="btn btn-primary" style="margin-left:10px;"  href="#edit_invoice<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
										 <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/payment/delete_tooth/'.$new->id.'/'.$this->uri->segment(4)); ?>" onclick="return confirm('Are You Sure')"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
                                        
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                       
                    </table>

                                </div><!-- /.box-body -->
                                    </div><!-- /.tab-pane -->

<?php //============================================================================================== ?>						
									
									
									
									  <div class="tab-pane <?php echo ($tab=="message")?'active':'';?>" id="tab_6">
                                         <div class="box box-solid">
											<div class="box-header">
												<h3 class="box-title">Messages</h3>
											</div>
											
											<?php echo form_open_multipart('admin/message/send/'.$patient->id); ?>
															   <input type="hidden"  name="id" value="<?php echo $patient->id;?>" />    
																	<div class="box-body">
																 <div class="form-group">
																		<div class="row">
																			<div class="col-md-12">
																				<label for="name" style="clear:both;"><?php echo lang('message');?></label>
																				<textarea name="message"class="form-control redactor message"></textarea>
																			</div>
																		</div>
																	</div>
																</div><!-- /.box-body -->
												
														<div class="box-footer">
																	<button type="submit" class="btn btn-primary update_message">Submit</button>
																</div>    
											<div class="box-body border-radius-none">
											<?php 
											$this->message_model->message_is_view_by_admin($patient->id);
											$patient	 = $this->message_model->get_patient_by_id($patient->id);
											$messages 	 = $this->message_model->get_message_by_id_order_by($patient->id);
												
											?>
																 
													<div id="err_edit_msg">  
													<?php if(validation_errors()){?>
													<div class="alert alert-danger alert-dismissable">
																							<i class="fa fa-ban"></i>
																							<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
																							<b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
																						</div>
													
													<?php  } ?>  
														</div>   <!-- Chat box -->
																		<div class="box box-success">
																			<div class="box-header">
																				<i class="fa fa-comments-o"></i>
																				<h3 class="box-title"><?php echo lang('message');?> <?php echo lang('to');?> <?php echo $patient->name; ?></h3>
																				<div class="box-tools pull-right" data-toggle="tooltip" title="Status">
																					
																				</div>
																			</div>
																			<div class="box-body chat" id="chat-box">
																				<!-- chat item -->
																	 <table class="table table-bordered dataTable" >
																			
																		<?php if(isset($messages)):?>		
																		 <?php $i=1;foreach ($messages as $new){?>		
																			
																			 	<tr>
																					<td>
																						<div class="item">
																				<?php 
																					if(empty($new->image)){
																				?>
																					<img src="<?php echo base_url('assets/uploads/images/avatar5.png')?>" alt="user image" class="online"/>
																				<?php }else{ ?>
																				 <img src="<?php echo base_url('assets/uploads/images/'.$new->image)?>" alt="user image" class="online"/>
																				<?php }?>	
																					<div class="col-xs-12"> <a href="<?php echo site_url('admin/message/delete/'.$new->id.'/'.$patient->id) ?>" onclick="return confirm('are you sure?')" class="btn btn-danger" style="float:right"><i class="fa fa-times"></i></a></div>
																					<p class="message" style="padding-top:12px;">
																					  
																						<a href="#" class="name">
																							
																							
																					<?php if($new->from_id== $admin['id']){
																					
																					?>     
																						
																					<span style="color:#FF0000">	 <?php echo $new->from_user ?></span> 
																					<small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date("d/m/y h:i a", strtotime($new->date_time)); ?> </small>
																				<?php }else	{ echo $new->from_user ;?>
																				<small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date("d/m/y h:i a", strtotime($new->date_time)); ?> </small><br />
																				<?php }?>	
												
																						</a>
																						 <?php echo $new->message ?> 
																					</p>
																					
																				</div><!-- /.item -->
																					
																					</td>
																				</tr>
																				
																	   <?php $i++;}?>
																	<?php endif;?> 
																			 </table>
																				 
																			</div><!-- /.chat -->
																		   
																		</div><!-- /.box (chat box) -->
												<!-- form start -->
													
															
																   	
													   
											</form>
		
													
											</div><!-- /.box-body -->
										</div><!-- /.box -->
                                    </div><!-- /.tab-pane -->
									
									
									
									
									
									
									  <div class="tab-pane <?php echo ($tab=="notes")?'active':'';?>" id="tab_7">
                                         <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Notes</h3>
									<div id="err_note"></div>
                                </div>
                                <div class="box-body border-radius-none" >
                                  
								   <form method="post" id="add_note">
					
				
                       <div class="form-group">
                        	<div class="row">
                                <div class="col-md-12">
                                    <label for="name" style="clear:both;"><?php echo lang('description');?></label>
									<textarea name="notes"class="form-control notes redactor1"><?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>
                        </div>
						
						
						
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
			</form>
								   
								   
								   
								   <table id="example5" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number');?></th>
								<th><?php echo lang('date');?></th>
								<th><?php echo lang('notes');?></th>
								<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($notes)):?>
                        <tbody>
                            <?php $i=1;foreach ($notes as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo date("d/m/Y h:i:a", strtotime($new->datetime))?></td>
									<td><?php echo substr($new->notes, 0 ,200)?></td>
									
                                    <td width="27%">
                                        <div class="btn-group">
                                          <a class="btn btn-default"   href="#view_notes<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
										  <a class="btn btn-primary" style="margin-left:12px;" href="#edit_notes<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/notes/delete/'.$new->id.'/'.$patient->id); ?>" onclick="return confirm('Are You Sure')" ><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
					
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                                    </div><!-- /.tab-pane -->
									<div class="tab-pane <?php echo ($tab=="images")?'active':'';?>" id="tab_8">
										<form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/patients/pimages')?>">
											<input type="hidden" name="id" value="<?php echo $patient->id?>" />
											<input type="hidden" name="doctor_id" value="<?php echo $patient->doctor_id?>" />			
											<div class="form-group" style="padding-top:30px;">
												<div class="row">
													<div class="col-md-4">
														<input  type="text" name="title" value="" class="form-control" placeholder="Title" />
													</div>
													<div class="col-md-4">
														<input  type="file" name="img" value="" class="form-control" required />
													</div>
													<div class="col-md-4">
														<input type="submit" name="save" value="Save" class="btn btn-primary" />
													</div>
												</div>
											</div>
										<div class="icontainer">	
											<div class="gallery">	
														<?php if(!empty($images)){
															foreach($images as $new){
														?>
														<a href="<?php echo base_url('uploads/wysiwyg/images/'.$new->file_name)?>"><img src="<?php echo base_url('uploads/wysiwyg/thumbnails/'.$new->file_name)?>" alt="" title="<?php echo $new->title?>"  width="205" height="1
														" /></a>
														<?php	 } 
															}
														?>
														
														
														
											</div>
										</div>
										</form>
									</div>
                                </div><!-- /.tab-content -->
                            </div><!-- nav-tabs-custom -->
                        </div><!-- /.col -->

                  </div>
					  
					  
						
                    </div><!-- /.box-body -->
    
             </form>
            </div><!-- /.box -->
        </div>
     </div>
</section>  




<div class="modal fade" id="amout<?php echo $patient->id; ?>" tabindex="-1" role="dialog" aria-labelledby="reportlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       
      </div>
      <div class="modal-body">
<form method="post" class="theform<?php echo $pre->id;?>" action="<?php echo site_url('admin/prescription/amout/')?>" enctype="multipart/form-data" >	
	<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('totalamount');?></label>
								</div>	
								
								<div class="col-md-6">
									<input type="text" name="amout1" class="form-control amout1" /><input type="text" name="amout2" style="display:none;" class="form-control amout2"  value="<?php echo $amts; ?>"/>
			<input type="text" value="<?php echo $tid; ?>" name="p_idz" class="form-control p_idz" style="display:none;" />
								</div>	
                            </div>
                        </div>

<div class="box-footer">
                       <input type="submit" name="updatez" id="updatez" value="<?php echo lang('save');?>" class="btn btn-primary updatez" />
                    </div>
						
		</form>		</div>		
			<div class="modal-footer">
	  	  
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>	 



<?php if(isset($prescriptions)):?>
<?php $i=1;
foreach ($prescriptions as $pre){?>
<!-- Modal -->

<div class="modal fade" id="reports<?php echo $pre->id?>" tabindex="-1" role="dialog" aria-labelledby="reportlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="reportlabel"><?php echo lang('view_diagonsis_report');?></h4>
      </div>
      <div class="modal-body">
<form method="post" class="theform<?php echo $pre->id;?>" action="<?php echo site_url('admin/prescription/reports/'.$pre->id.'/'.$patient->id)?>" enctype="multipart/form-data" >						
						<input type="hidden" name="p_id" value="<?php echo $pre->id?>" />								
        				<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('type');?></label>
								</div>	
								
								<div class="col-md-6">
									<select name="type_id" class="form-control chzn">
											<option value="">--<?php echo lang('select_report') ?>--</option>
											<?php foreach($tests as $new) {
													$sel = "";
													
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
									</select>
								</div>	
                            </div>
                        </div>
				
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('upload_file');?></label>
								</div>	
								
								<div class="col-md-6">
									<input type="file" name="file" class="form-control" />
								</div>	
                            </div>
                        </div>
						
				
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('remark');?></label>
								</div>	
								<div class="col-md-6">
									<textarea name="remark" class="form-control" required="required"></textarea>
                                </div>
                            </div>
                        </div>
						
						 
		
						
						
					<div class="box-footer">
                       <input type="submit" name="save" id="save" value="<?php echo lang('save');?>" class="btn btn-primary" />
                    </div>
						
		</form>				
				 
					  <?php $reports 	 = $this->prescription_model->get_reports_by_id($pre->id);
						if(isset($reports)):?>	
						<table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								 <th><?php echo lang('type');?></th>
								<th><?php echo lang('remark');?></th>
								<th><?php echo lang('from');?></th>
								<th><?php echo lang('to');?></th>
								<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                        
                      
                        <tbody>
                            <?php $i=1;foreach ($reports as $prescription){
							//if($prescription)
							?>
                                <tr class="gc_row">
                                    <td><?php echo date("d/m/y h:i", strtotime($prescription->date_time))?></td>
                                    <td><?php echo $prescription->type?></td>
									<td><?php echo $prescription->remark?></td>
									 <td><?php echo $prescription->from_user?></td>
									  <td><?php echo $prescription->to_user?></td>
								    <td width="20%">
                                        <div class="btn-group">
								<a href="https://docs.google.com/viewerng/viewer?url=<?php echo base_url('assets/uploads/files/'.$prescription->file)?>" target="_blank" style="width:85px;" class="btn btn-primary" > View</a>
								
									<?php if(!empty($prescription->file)){?>	
                                         <a href="<?php echo base_url('assets/uploads/files/'.$prescription->file)?>" class="btn btn-default"  download>Download</a>
                                     <?php }else{?>
									 	<a href="#" class="btn btn-default" style="width:85px;">N/A</a>
									 <?php  } ?>  
									     <a class="btn btn-danger" href="<?php echo site_url('admin/prescription/delete_report/'.$prescription->id.'/'.$patient->id); ?>" onclick="return confirm('Are You Sure')" style="width:85px;"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;} ?>
                        </tbody>
                       
                    </table>
					 <?php endif;?>
		                             
            
      </div>
      <div class="modal-footer">
	  	  <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/prescription/reports/'.$pre->id)?>" > <i class="fa fa-file"></i> <?php echo lang('reports');?></a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
  <?php $i++;}?>
<?php endif;?>


<?php if(isset($prescriptions)):?>
<?php $i=1;
foreach ($prescriptions as $pre){?>

<script>
var check=false;
$(document).ready( function() {
	$('.theform<?php echo $pre->id;?>').submit(function(e) {
    	
			if(check==false){
			event.preventDefault();
			call_loader();
				setTimeout(function(){	
					check = true;
					$( ".theform<?php echo $pre->id;?>" ).submit();
					
				}, 2000);
		  }

	});
	
});

</script>
  <?php $i++;}?>
<?php endif;?>


<!-- Modal -->
<div class="modal fade" id="add_appointment" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
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
         	<form method="post" id="add_app">
                       <input type="hidden" name="whom" class="whom"  value="1"/>
						
										<input type="hidden" name="patient_id" class="patient_id" value="<?php echo $patient->id?>" />
                    	 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
									<textarea name="motive" class="form-control motive"><?php echo set_value('motive'); ?></textarea>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
									<input type="text" name="date_time" value="<?php echo set_value('date_time'); ?>" class="form-control datepicker date_time datepicker_appointment">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
									<textarea name="notes" class="form-control notes"> <?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    
									<input type="checkbox" name="is_paid" value="1" class="is_paid" /> <label for="name" style="clear:both;"><?php echo 'Send Message'?></label>
					            </div>
                            </div>
                        </div>
						
				
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="ok" value="ok"><?php echo lang('save');?></button>
                    </div>
						  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>		


<?php if(isset($fees_all)):?>
<?php $i=1;
foreach ($fees_all as $new){
$payment = $this->prescription_model->get_payment_by_id($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="edit_invoice<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('update');?> <?php echo lang('fees')?></h4>
      </div>
      <div class="modal-body">
			 <div id="err_inv<?php echo $new->id?>">  
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
			<?php //echo '<pre>'; print_r($pateints);?>
			<form method="post" action="<?php echo site_url('admin/payment/edit_payment/'.$payment->id)?>" enctype="multipart/form-data" onsubmit="return validateForm()">
			<input type="hidden" name="id" value="<?php echo $payment->id;?>" />
		              <div class="form-group" style="margin-top:20px;"> 
							 <legend><?php echo lang('add_payment_detail')?></legend>  
					    </div>
									
									<input type="hidden" name="patient_id" class="patient_id" value="<?php echo $payment->patient_id?>" />
                        <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="invoice_no" value="<?php echo $payment->invoice;?>" readonly="readonly"  class="form-control invoice_no" />
									
                                </div>
                            </div>
                        </div>
					  <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('totalamount')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="amount"  value="<?php echo $payment->amount; ?>" id="amountc"  class="form-control amount" readonly/>
					<input type="text" name="vv"  value="<?php echo $bal1; ?>" id="ac"  class="form-control" style="display:none;"/>				
                                </div>
                            </div>
                        </div>
                          <div class="form-group" style="margin-top:20px;display:none;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_for')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="payment_for" value="" class="form-control payment_for" />
									
                                </div>
                            </div>
                        </div>
                        	<?php //#############################################################div_strat#########################################################################?>	<div class="form-group input_fields_wrap2">
                        <?php    $treatment_Advised_id =json_decode($payment->treatment_Advised_id);
						$balance= json_decode($payment->balance);
						
						$dates	= json_decode($payment->dates);
						if(!empty($treatment_Advised_id[0])){
$kj=0;
					foreach($treatment_Advised_id as $key => $val){
$kj++;
					?>	
                            <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('treatment_advised')?></b>
								</div>
								<div class="col-md-4">
                                   <select name="treatment_Advised_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('treatment_advised');?>--</option>
                                              
												<?php foreach($treatment_Advised as $new) {
														$sel = "";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									
                                </div>
                            </div>
                        </div>
					
					  
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amnt')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="balance" onchange="amnts1(this.value,this.id)"onkeydown="amnts2(this.value,this.id)"onkeyup="amnts2(this.value,this.id)" value="<?php echo $balance; ?>"  id="balancexc<?php echo $payment->invoice; ?>" class="form-control balance " />
									
                                </div>
                            </div>
                        </div>
						
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('date')?></b>
								</div>
								<div class="col-md-4">
                                
								<input type="text" name="date" value="<?php echo $dates; ?>" class="form-control datepicker date " />
																
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        	<div class="row">
								<div class="col-md-offset-2" style="padding-left:12px;">
										
								</div>
							</div>
                            <?php }} ?>
						</div>
			<?php //#############################################################div_end#########################################################################?>	   
						  <div class="form-group" >
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_mode')?></b>
								</div>
								<div class="col-md-4">
                                   <select name="payment_mode_id" class="form-control payment payment_mode_id" >
										<option value="">--<?php echo lang('select')?> <?php echo lang('payment_mode')?> --</option>
										<?php foreach($payment_modes as $new) {
											$sel = "";
											echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
										}
										
										?>
									</select>
                                </div>
                            </div>
                        </div>
						 <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('update')?></button>
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


<script>
var pratul=0;
var pratulji=0;
function validateForm() {

 pratul1=pratul;
var pratulji1=pratulji;
if(Number(pratulji1)<Number(pratul1)){
alert('Amount limit high');

return false;
}
}
function amnts2(amntsx,id){
pratul=amntsx;
pratulji=document.getElementById("amountc").value;
}
function amnts1(amntsx,id){

amountz=document.getElementById("amountc").value;
hid=document.getElementById("ac").value;

ttotl=(+hid)+(+amntsx);
if(amountz<amntsx){
alert('Amount limit high');
document.getElementById(id).value=0;
return false;
}
else{

}
}
</script>

<!-- Add Payment-->
<div class="modal fade" id="add_inv" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('payment');?></h4>
      </div>
      <div class="modal-body">
	   <div id="err_inv">  
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
      				   <!-- form start -->
<input type="text" readonly="readonly" id="err" style="display:none;" />
				<form method="post" action="<?php echo site_url('admin/payment/add_payment/'.@$id)?>" enctype="multipart/form-data" id="">
			
			        				<input type="hidden"  name="patient_id" class="patient_id"  value="<?php echo $patient->id?>" />
                        <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="invoice_no" value="<?php echo $i_no;?>" readonly="readonly"  class="form-control invoice_no" /><input type="text" name="rd" value="patients" style="display:none;" />
									
                                </div>
                            </div>
                        </div>
					  <div class="form-group" style="margin-top:20px;display:none;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_for')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="payment_for" value="" class="form-control payment_for" />
									
                                </div>
                            </div>
                        </div>
  <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('totalamount')?></b>
								</div>
								<div class="col-md-4">
<?php if($pen==0){ ?>
                 <input type="text" name="amount" value="" id="amountz"  class="form-control amount" />
<?php }else{ ?>
                      <input type="text" name="amount" value="<?php echo $pen; ?>" id="amountz"  class="form-control amount" readonly/>              
<?php } ?>
									
                                </div>
                            </div>
                        </div>
						<?php //##################################################################################### ?>
<div class="form-group input_fields_wrap2">
                            <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('treatment_advised')?></b>
								</div>
								<div class="col-md-4">
                                   <select name="treatment_Advised_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('treatment_advised');?>--</option>
                                              
												<?php foreach($treatment_Advised as $new) {
														$sel = "";
														if(set_select('treatment_Advised_id', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									
                                </div>
                            </div>
                        </div>
						</div>
<?php //##################################################################################### ?>
					    <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amount')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="balance" onchange="amnt(this.value)" value="" id="amountx" class="form-control balance" />
					  <input type="text" name="x"  value="<?php echo $bal1; ?>" id="hid" class="form-control " style="display:none;" />				
                                </div>
                            </div>
                        </div>
						  <div class="form-group" >
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_mode')?></b>
								</div>
								<div class="col-md-4">
                                   <select name="payment_mode_id" class="form-control payment payment_mode_id" >
										<option value="">--<?php echo lang('select')?> <?php echo lang('payment_mode')?> --</option>
										<?php foreach($payment_modes as $new) {
											$sel = "";
											echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
										}
										
										?>
									</select>
                                </div>
                            </div>
                        </div>
						
						  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('date')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="date" value="" class="form-control payment_date date" />
                                </div>
                            </div>
                        </div>
					   
						
            
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
			</form>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

<?php //================================================================================================?>

<div class="modal fade" id="add_inv1" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog dd">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo 'Treatment Plan';?></h4>
      </div>
      <div class="modal-body">
	   <div id="err_inv">  
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
      				   <!-- form start -->
<input type="text" readonly="readonly" id="err" style="display:none;" />
				<form method="post" action="<?php echo site_url('admin/payment/add_tooth/'.@$id)?>" enctype="multipart/form-data" id="">
			
			        				<input type="hidden"  name="patient_id" class="patient_id"  value="<?php echo $patient->id?>" />
                       
				
  
						<?php //##################################################################################### ?>
<div class="form-group input_fields_wrap2">
                            <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('treatment_advised')?></b>
								</div>
								<div class="col-md-4">

                                   <select name="treatment_Advised_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('treatment_advised');?>--</option>
                                              
												<?php foreach($treatment_Advised as $new) {
														$sel = "";
														if(set_select('treatment_Advised_id', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									<input type="text" name="tooth[]" id="toot" style="display:none;" />
                                </div>
                            </div>
                        </div>
						</div>
<?php //##################################################################################### ?>
					
							  <div class="form-group">
                        	<div class="row">
								<div class="col-md-3">
                     
                                </div>
			<div class="col-md-8">
                     <h3>Permanent Tooth</h3>
                                </div>
                            </div>
                        </div>
						
						  <div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/18.png" alt="18" class="img-circle" alt="User Image" id="18" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/17.png" class="img-circle" alt="User Image" id="17" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/16.png" class="img-circle" alt="User Image" id="16" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/15.png" class="img-circle" alt="User Image" id="15" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/14.png" class="img-circle" alt="User Image" id="14" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/13.png" class="img-circle" alt="User Image" id="13" onclick="javascripts(this.id);">
                                </div>



                            </div>
                        </div>
<?php //##################################################################################### ?>
<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/12.png" class="img-circle" alt="User Image" id="12" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/11.png" class="img-circle" alt="User Image" id="11" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/21.png" class="img-circle" alt="User Image" id="21" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/22.png" class="img-circle" alt="User Image" id="22" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/23.png" class="img-circle" alt="User Image" id="23" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/24.png" class="img-circle" alt="User Image" id="24" onclick="javascripts(this.id);">
                                </div>



                            </div>
                        </div>
<?php //##################################################################################### ?>
<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/25.png" class="img-circle" alt="User Image" id="25" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/26.png" class="img-circle" alt="User Image" id="26" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/27.png" class="img-circle" alt="User Image" id="27" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/28.png" class="img-circle" alt="User Image" id="28" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/48.png" class="img-circle" alt="User Image" id="48" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/47.png" class="img-circle" alt="User Image" id="47" onclick="javascripts(this.id);">
                                </div>



                            </div>
                        </div>
<?php //##################################################################################### ?>
<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/46.png" class="img-circle" alt="User Image" id="46" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/45.png" class="img-circle" alt="User Image" id="45" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/44.png" class="img-circle" alt="User Image" id="44" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/43.png" class="img-circle" alt="User Image" id="43" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/42.png" class="img-circle" alt="User Image" id="42" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/41.png" class="img-circle" alt="User Image" id="41" onclick="javascripts(this.id);">
                                </div>



                            </div>
                        </div>
<?php //##################################################################################### ?>
				<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/31.png" class="img-circle" alt="User Image" id="31" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/32.png" class="img-circle" alt="User Image" id="32" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/33.png" class="img-circle" alt="User Image" id="33" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/34.png" class="img-circle" alt="User Image" id="34" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/35.png" class="img-circle" alt="User Image" id="35" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/36.png" class="img-circle" alt="User Image" id="36" onclick="javascripts(this.id);">
                                </div>



                            </div>
                        </div>
<?php //##################################################################################### ?>
<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/37.png" class="img-circle" alt="User Image" id="37" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/38.png" class="img-circle" alt="User Image" id="38" onclick="javascripts(this.id);">
                                </div>





                            </div>
                        </div>	   
<?php //##################################################################################### ?>
								  <div class="form-group">
                        	<div class="row">
								<div class="col-md-3">
                     
                                </div>
			<div class="col-md-8">
                     <h3>Child Tooth</h3>
                                </div>
                            </div>
                        </div>	
<?php //##################################################################################### ?>
<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/a.png" class="img-circle" alt="User Image" id="55" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/b.png" class="img-circle" alt="User Image" id="54" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/c.png" class="img-circle" alt="User Image" id="53" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/d.png" class="img-circle" alt="User Image" id="52" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/e.png" class="img-circle" alt="User Image" id="51" onclick="javascripts(this.id);">
                                </div>





                            </div>
                        </div>
<?php //##################################################################################### ?>
<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/f.png" class="img-circle" alt="User Image" id="61" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/g.png" class="img-circle" alt="User Image" id="62" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2" >
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/h.png" class="img-circle" alt="User Image" id="63" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/i.png" class="img-circle" alt="User Image" id="64" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/j.png" class="img-circle" alt="User Image" id="65" onclick="javascripts(this.id);">
                                </div>





                            </div>
                        </div>
<?php //##################################################################################### ?>

<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/k.png" class="img-circle" alt="User Image" id="85" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/l.png" class="img-circle" alt="User Image" id="84" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/m.png" class="img-circle" alt="User Image" id="83" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/n.png" class="img-circle" alt="User Image" id="82" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/o.png" class="img-circle" alt="User Image" id="81" onclick="javascripts(this.id);">
                                </div>





                            </div>
                        </div>
<?php //##################################################################################### ?>
<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/p.png" class="img-circle" alt="User Image" id="71" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/q.png" class="img-circle" alt="User Image" id="72" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/r.png" class="img-circle" alt="User Image" id="73" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/s.png" class="img-circle" alt="User Image" id="74" onclick="javascripts(this.id);">
                                </div>

<div class="col-md-2">
                                    <img src="http://doctori8.com/doctor/assets/img/teeth-img/t.png" class="img-circle" alt="User Image" id="75" onclick="javascripts(this.id);">
                                </div>





                            </div>
                        </div>
<?php //##################################################################################### ?>


            <?php //===============================================================================?>
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
			</form>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

<?php //===============================================================================================?>

<script>
tooth=[];
function javascripts(id){

var index = tooth.indexOf(id);
if (index > -1) {
    tooth.splice(index, 1);
}else{
tooth.push(id);
}
document.getElementById("toot").value=tooth;
}
function amnt(amnts){
amountz=document.getElementById("amountz").value;
hid=document.getElementById("hid").value;
ttotl=amnts;
if(amountz<ttotl){
alert('Amount limit high');
document.getElementById("amountx").value='';
}

}
</script>



<?php if(isset($appointments)):?>
<?php $i=1;
foreach ($appointments as $apps){

$app = $this->appointment_model->get_appointment_by_doctor_id($apps->id);
//echo '<pre>'; print_r($app);die;
?>
<!-- Modal -->
<div class="modal fade" id="edit_appointment<?php echo $apps->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
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
            			<input type="hidden" name="whom" class="whom" value="1" />
						
						 
										<input type="hidden" name="patient_id" class="patient_id" value="<?php echo $patient->id?>" />
                         
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
									<input type="text" name="date_time" value="<?php echo $app->date; ?>" class="form-control datepicker date_time datepicker_appointment">
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
                                    <label for="name" style="clear:both;">Is Paid</label>
									<input type="checkbox" name="is_paid" class="is_paid" <?php echo ($app->is_paid==1)?'checked="checked"':'';?> value="1" />
					            </div>
                            </div>
                        </div>
						
						
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary update_appointment" name="ok" value="ok"><?php echo lang('save');?></button>
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
<div class="modal fade" id="view_appointment<?php echo $apps->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
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
                                    <label for="name" style="clear:both;">Is Paid</label>
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




<?php if(isset($notes)):?>
<?php $i=1;
foreach ($notes as $list){?>
<!-- Modal -->
<div class="modal fade" id="edit_notes<?php echo $list->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('notes')?></h4>
      </div>
      <div class="modal-body">
	  <div id="err_notes<?php echo $list->id?>">  
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
			<form method="post" action="<?php echo site_url('admin/notes/edit/'.$list->id)?>">
				<input type="hidden" name="id" value="<?php echo $list->id ?>" />
				    <div class="box-body">
                        
										<input type="hidden" name="patient_id" class="patient_id" value="<?php echo $patient->id ?>"  />
			
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-12">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
									<textarea name="notes"class="form-control notes redactor" ><?php echo $list->notes?></textarea>
                                </div>
                            </div>
                        </div>
						
                    </div><!-- /.box-body -->
    
					<div class="box-footer">
                        <button type="submit" class="btn btn-primary update_notes"><?php echo lang('save');?></button>
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








<?php if(isset($notes)):?>
<?php $i=1;
foreach ($notes as $list){?>
<!-- Modal -->
<div class="modal fade" id="view_notes<?php echo $list->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="viewlabel"><?php echo lang('view');?> Notes</h4>
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
						
				
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-12">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
										<p><?php echo $list->notes?></p>
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
<div class="modal fade" id="app_edit<?php echo $apps->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
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
                                    <label for="name" style="clear:both;"> <?php echo lang('title');?></label>
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
<div class="modal fade" id="app_view<?php echo $apps->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
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
                                    <label for="name" style="clear:both;"> <?php echo lang('title');?></label>
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
									<?php 
									
									foreach($contacts as $new) {
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


<?php if(isset($fees_all)):?>
<?php $i=1;
foreach ($fees_all as $new){
$details = $this->invoice_model->get_detail($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="invoice<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="invoicelabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="invoicelabel"><?php echo lang('invoice');?></h4>
      </div>
      <div class="modal-body">
	  	
      					<section class="content invoice">
                      
			<table width="100%" border="0"  id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											<td align="left"><?php if(@$setting->image!=""){?>
											<img src="<?php echo base_url('assets/uploads/images/'.@$setting->image)?>"  height="70" width="80" />

										<?php }else{?>
										<img src="<?php echo base_url('assets/img/doctor_logo.png/')?>"  height="70" width="80" />
											<?php } ?>	</td>
											<td align="right">
												<b><?php echo lang('invoice_number')?> #<?php echo $details->invoice ?></b><br />
												<b>Payment Date:</b> <?php echo $details->dates;?><br />
												<b><?php echo lang('payment_mode') ?>:</b> <?php echo $details->mode ?><br/>
												<b>Issue Date:</b> <?php echo date('d/m/Y')?><br />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
										<tr>
											<td align="left">Payment To<br />
												 <strong><?php echo @$setting->name ?></strong><br>
										   <?php echo @$setting->address ?><br>
											<?php echo lang('phone') ?>: <?php echo @$setting->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo @$setting->email ?>		
											
											</td>
											<td align="right" colspan="2">Bill To<br />
											
											<strong><?php echo $details->patient ?></strong><br>
											<?php echo $details->address ?><br>
											<?php echo lang('phone') ?>: <?php echo $details->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo $details->email ?>
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr >
								<th align="left" style="padding-top:10px;">Invoice Entries</th>
							</tr>
							<tr>  
								<td>
                                    <?php //echo "<p style='color:#3c8dbc;font-size: 19px; font-weight: 600;'>Total Amount = ".$totL." </p>"; ?>
									<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="75%" align="left"><b>Treatment Advised</b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="15%"><b>Price</b></td>
										</tr>
										<tr >
											 <td width="10%" style="border-right:1px solid #CCCCCC" >1</td>
											 <td width="75%" style="border-right:1px solid #CCCCCC"><?php echo $string = preg_replace('/[^A-Za-z0-9\-]/', '', $details->treatment_Advised_id);  ?></td>
											 <td width="15%" ><?php echo json_decode($details->balance); ?></td>
											
										</tr>
									</table>
                                       
								</td>
							</tr>
						</table>

			<?php $admin = $this->session->userdata('admin');
					 if($admin['user_role']==2){ ?>
					 <div class="row no-print" style="padding-top:20px;">
                        <div class="col-xs-12">
                            <button class="btn btn-default"onclick="printData<?php echo $new->id?>()"><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php }else{?>	
				
                    <!-- this row will not appear when printing -->
                    <div class="row no-print" style="padding-top:20px;">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="printData<?php echo $new->id?>()"><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php } ?>	
					
					
					
                </section><!-- /.content -->
	  
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default no-print" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>
<script>
function printData<?php echo $new->id?>()
{
   var divToPrint=document.getElementById("print_inv<?php echo $new->id?>");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>
  <?php $i++;}?>
<?php endif;?>





<?php if(isset($prescriptions)):?>
<?php $i=1;foreach ($prescriptions as $prescription){
?>

<!-- Modal -->
<div class="modal fade" id="myModal<?php echo $prescription->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:96%;"  >
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('view');?> <?php echo lang('prescription');?> </h4>
      </div>
      <div class="modal-body"  >
			<table width="100%" border="0" id="printTable<?php echo $prescription->id ?>"  class="pt" style="padding-bottom:0px; height:100%;" >
						<thead>
						<tr>
							<td>
								<table width="100%" style="border-bottom:1px solid;">
									<tr>
										<td style="line-height:110%">
											<?php echo @$template->header;?>											
										</td>
										
									</tr>
								</table>
							</td>
						</tr>
						</thead>
						<tbody>	
						<tr>
							<td >
								<table width="100%">
									<tr>
										<td width="40%"><b><?php echo lang('name')?></b> : <?php echo substr($prescription->patient,0,20)?></td>
										<td width="18%"><b><?php echo lang('age')?></b> : <?php echo date("Y")-$prescription->dob?> Years</td>
										<td ><b><?php echo lang('sex')?></b> : <?php echo $prescription->gender?></td>
										<td ><b><?php echo lang('id')?></b> : <?php echo $prescription->prescription_id?></td>
										<td ><b><?php echo lang('date')?></b> : <?php echo date("d-m-y", strtotime($prescription->date_time))?></td>
									</tr>
								</table>	
							</td>
						</tr>
					
						<tr height="100%">
							<td valign="top">
								<table width="100%" border="0">
									<tr>
										<td width="51%" valign="top">
											<table width="80%" border="0">
												<tr>
														<td width="100%">
															<table border="0" >
																<tr>
																	<td><b>Medical History</b></td>
																</tr>
																<?php $c = json_decode($prescription->case_history_id);
																
																if(is_array($c)){
																	foreach($c as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$c.'</td></tr>';
																}
																?>
																<tr>
																	<td><?php echo $prescription->case_history ?></td>
																</tr>
															</table>
														</td>
												</tr>
                                                
												<?php //###########################################################Chiff Complaint################################################################################# ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>CHIEF COMPLAINT</b></td>
															</tr>
															<?php $d = json_decode($prescription->chiff_Complaint_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->chiff_Complaint_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
     
      <?php //#########################################################durg allergy################################################################################### ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>DRUG ALLERGY</b></td>
															</tr>
															<?php $d = json_decode($prescription->drug_Allergy_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->drug_Allergy_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
     
  
           <?php //##########################################################Extra oral exm################################################################################## ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>EXTRA ORAL EXM.</b></td>
															</tr>
															<?php $d = json_decode($prescription->extra_Oral_Exm_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->extra_Oral_Exm_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
 <?php //#############################################################inter oral Exm############################################################################### ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>INTRA ORAL EXM.</b></td>
															</tr>
															<?php $d = json_decode($prescription->intra_Oral_Exm_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->intra_Oral_Exm_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
												
											</table>
										</td>
										<td valign="top">
											<table border="0" width="100%" >
												<tr>
													<td><p><span style="font-size:26px"><b>R</span ><sub style="font-size:18px">x</b></sub></p></td>
												</tr>
												<?php $d = json_decode($prescription->medicines);
													  $ins = json_decode($prescription->medicine_instruction);
													if(is_array($d)){
														$i=1;
														foreach($d as $key => $new){
														if(!empty($d[$key]))
															echo '<tr><td style="padding-left:18px;">'.$i.'. '.$d[$key] .'<td></tr>';
															echo '<tr><td><p style="padding-left:32px;"><small>'.@$ins[$key] .'</small></p><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td style="padding-left:18px;">'.$i.' '.$d.'<td></tr>';
														echo '<tr><td><p style="padding-left:32px;"><small>'.$ins.'</small></p><td></tr>';
													}	
													?>
												<tr>
                                              <tr>
													<td width="51%">
																<?php 
													$d = json_decode($prescription->tests);
													//echo '<pre>'; print_r($d);'</pre>';
													if(!empty($d[0])){?>
																	<table border="0" width="100%">
																		<tr>
																			<td><b><?php echo lang('test')?></b></td>
																		</tr>
																		<?php 
																			  $ins = json_decode($prescription->test_instructions);
																			if(is_array($d)){
																				$i=1;
																				foreach($d as $key => $new){
																				
																					echo '<tr><td>'.$i.'. '.$d[$key] .'<td></tr>';
																				if(!empty($ins[$key])){	
																					echo '<tr><td><p style="padding-left:14px;"><small>('.$ins[$key] .')</small></p><td></tr>';
																				}
																				 $i++;}
																			}else{
																				echo '<tr><td>'.$i.' '.$d.'<td></tr>';
																				echo '<tr><td><p style="padding-left:14px;"><small>( '.$ins.' )</small></p><td></tr>';
																			}	
																			?>
																	</table>	
															<?php } ?>		
																</td>
												</tr>
                                                 <?php //#############################################################Treatment Advised############################################################################### ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>Treatment Advised</b></td>
															</tr>
															
															<tr>
																<td><?php
																 $d = json_decode($prescription->treatment_Advised_id);
																  $ins1 = json_decode($prescription->treatment_Advised_instruction);
													if(is_array($d)){
														$i=1;
														foreach($d as $key => $new){
														if(!empty($d[$key]))
															echo '<tr><td style="padding-left:18px;">'.$i.'. '.$d[$key] .'<td></tr>';
															echo '<tr><td><p style="padding-left:32px;"><small>'.@$ins1[$key] .'</small></p><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td style="padding-left:18px;">'.$i.' '.$d.'<td></tr>';
														echo '<tr><td><p style="padding-left:32px;"><small>'.$ins.'</small></p><td></tr>';
													}
																?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
  
     
													<td>
														<?php if(!empty($prescription->remark)){?>
																<table width="100%" border="0">
																	<tr>
																		<td><b><?php echo lang('remark')?></b></td>
																	</tr>
																	<tr>
																		<td><?php echo $prescription->remark ?></td>
																	</tr>
																</table>
														<?php } ?>		
														</td>	
												</tr>	
											</table>	
										</td>
									</tr>
											
								</table>
							</td>
						</tr>
						
					</tbody>
                   
					<tfoot>	
						<tr>	
							<td style="border-top:1px solid;" class="aligncenter">

								<?php echo @$template->footer;?>
							</td>
						</tr>
					</tfoot>	
						
					</table>
       	

			
			<div class="form-group no-print">		
    			 <div class="row no-print">
                        <div class="col-sm-4 pull-right">
		             <a href="#"class="btn btn-default yes-print no-print" id="print_p"  onclick="printData<?php echo $prescription->id ?>();" style="margin-right: 5px;"><i class="fa fa-print"></i> <?php echo lang('print') ?>
					 <a href="<?php echo site_url('admin/prescription/pdf/'.$prescription->id)?>" id="pdf" class="btn btn-primary  no-print" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
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
 <script>
    function printData<?php echo $prescription->id ?>()
{
   var divToPrint=document.getElementById("printTable<?php echo $prescription->id ?>");
   document.getElementById("print_p").style.display = 'none';
   document.getElementById("pdf").style.display = 'none';
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('.yes-print').on('click',function(){
printData<?php echo $prescription->id ?>();
})
</script> 
 
  <?php $i++;}?>
<?php endif;?>








<?php $patient = $this->patient_model->get_patient_by_id($patient->id);
?>
<!-- Modal -->
<div class="modal fade" id="edit_patient<?php echo $patient->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('patient')?></h4>
      </div>
      <div class="modal-body">
	  
	    <div id="err_edit">  
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
			
			<form method="post" action="<?php echo site_url('admin/patients/edit/'.$patient->id)?>" id="edit" enctype="multipart/form-data">
                       <input type="hidden" name="id" value="<?php echo $patient->id; ?>" />
					    <div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" value="<?php echo $patient->name?>" class="form-control name">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
									<textarea name="address"  class="form-control address"><?php echo $patient->address?></textarea>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<input type="radio"  name="gender" class="gender" <?php echo $chk = ($patient->gender=="Male") ? 'checked="checked"': ''; ?>value="Male" /> <?php echo lang('male')?>
									<input type="radio" name="gender" class="gender" <?php echo $chk = ($patient->gender=="Female") ? 'checked="checked"': ''; ?> value="Female" /> <?php echo lang('female')?>
                                </div>
                            </div>
                        </div>
					
					
			   			 <div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="dob" style="clear:both;">Age</label>
									<input type="text" name="dob" value="<?php echo date("Y")-$patient->dob?>"class="form-control dob">
									
                                </div>
                            </div>
                        </div>
				
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
									<input type="text" name="contact" value="<?php echo $patient->contact?>" class="form-control contact">
                                </div>
                            </div>
                        </div>
						
						
						
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" value="<?php echo $patient->email?>" class="form-control email">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="username" style="clear:both;"><?php echo lang('username')?></label>
									<input type="text" name="username"  value="<?php echo $patient->username?>" class="form-control username" id="username">
                                	<label id="username-error" class="error" ></label>
								</div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="password" style="clear:both;"><?php echo lang('password')?></label>
									<input type="password" name="password" value="" class="form-control password">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="password" style="clear:both;"><?php echo lang('confirm')?> <?php echo lang('password')?></label>
									<input type="password" name="confirm" value="" class="form-control confirm">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control blood_id">
											<option value="">--<?php echo lang('select_blood_type');?>--</option>
											<?php
												$groups = $this->patient_model->get_blood_group();
											 foreach($groups as $new) {
													$sel = "";
													if($new->id==$patient->blood_group_id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
                                </div>
                            </div>
                        </div>
               
               			<?php 
					$CI = get_instance();
						if($fields){
							foreach($fields as $doc){
							$output = '';
							if($doc->field_type==1) //testbox
							{
						?>
						<div class="form-group">
                              <div class="row">
							  
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();?>		
							<input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" value="<?php echo @$result->reply; ?>"/>
								</div>
                            </div>
                        </div>
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();?>	
							<select name="reply[<?php echo $doc->id ?>]" class="form-control">
							<?php	
										foreach($values as $key=>$val) {
											$sel='';
											if($val==$result->reply) $sel = "selected='selected'";
											echo '<option value="'.$val.'" '.$sel.'>'.$val.'</option>';
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
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>			
						
						<input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" <?php echo $x;?> />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
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
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>	
										
										<input type="checkbox" name="reply[<?php echo $doc->id ?>]"  <?php echo $x;?> value="<?php echo $val;?>" class="form-control" />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
									<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."'")->row();?>	
										<textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ><?php echo @$result->reply;?></textarea>
								</div>
                            </div>
                        </div>
							
						
						
					<?php 
								}	
							}
						}
					?>	
						
						
						
						
							
			
	   <div class="box-footer">
                        <button type="submit" class="btn btn-primary update" name="update"><?php echo lang('update')?></button>
                    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>




<?php if(isset($prescriptions)):?>
<?php $i=1;foreach ($prescriptions as $new){
$prescription = $this->prescription_model->get_prescription_by_id($new->id);
//echo '<pre>';print_r($medicines);die;
$date = new DateTime($prescription->dob);
 							$now = new DateTime();
 						$interval = $now->diff($date);
?>
<!-- Modal -->
<div class="modal fade" id="edit_prescription<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:96%;"  >
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editLabel"><?php echo lang('edit');?> <?php echo lang('prescription');?> </h4>
      </div>
      <div class="modal-body">
		<div id="#err_pre<?php echo $new->id?>">			
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
							
            	<form method="post" action="<?php echo site_url('admin/prescription/edit/'.$new->id.'/'.$patient->id)?>" enctype="multipart/form-data" id="edit_form">
			          <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> Prescription Id</label>
								</div>	
								<div class="col-md-3">
									<input type="text" name="prescription_id" value="<?php echo $prescription->prescription_id ?>" readonly="readonly"  class="form-control prescription_id"/>
                                </div>
								<div class="col-md-3">
									<input type="text" name="date_time" class="form-control datepicker" placeholder="Date" value="<?php echo $prescription->date_time;?>">
                                </div>
						    </div>
                        </div>
					  
					  
									<input type="hidden" name="id" value="<?php echo $new->id;?>" />		
									<input type="hidden" name="patient_id" id="patient_id" class="patient_id" value="<?php echo $patient->id?>"  />
						
						<div class="row">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;">Case History</label>
													</div>	
													<div class="col-md-8">
														
														<select name="case_history_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
																<option value="">--Select Option--</option>
																<?php foreach($case_historys as $new) {
																		$sel = "";
																		$sel = (in_array($new->name,json_decode($prescription->case_history_id)))?'selected': '';
																		echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="case_history"class="form-control case_history"><?php echo strip_tags($prescription->case_history);?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	
                        	
                        </div>

						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> O/E</label>
								</div>	
								<div class="col-md-4">
									<select name="disease_id[]" class="form-control chzn disease_id" multiple="multiple">
											<?php foreach($diseases as $new) {
													$sel = "";
													$sel = (in_array($new->name,json_decode($prescription->disease)))?'selected': '';
													echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
									</select>
                                </div>
								 <div class="col-md-4">
                                    
									<textarea name="oe_description"class="form-control oe_description"><?php echo strip_tags(@$prescription->oe_description);?></textarea>
                                </div>
                            </div>
                        </div>
						
						
					<?php
						$medicine1 = json_decode($prescription->medicines);
						$medi_ins1= json_decode($prescription->medicine_instruction);
						
						$tests1	= json_decode($prescription->tests);
						$tests_ins1 = json_decode($prescription->test_instructions);
					//echo '<pre>'; print_r();
					//echo '</pre>';
					if(!empty($medicine1[0])){
					foreach($medicine1 as $key => $val){
					 ?>	
						
						<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								
								<div class="col-md-4" >
									
												<select name="medicine_id[]" class="form-control chzn medicine_id" id="medicine_id"style="width:100%">
												<option value="">--<?php echo lang('select_medicine');?>--</option>
												<?php foreach($medicines as $new) {
														$sel = " ";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										
												
										</select>
								</div>
                                
								<div class="col-md-4">
									<select name="instruction[]" class="form-control chzn instruction">
												<option value="">--<?php echo $medi_ins1[@$key] ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														if($new->name==$medi_ins1[$key]) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								<div class="col-md-2">
										<a href="#" class="delete_activity btn btn-danger"><?php echo lang('remove'); ?></a> 
								</div>
								
                            </div>
                        </div>
					<?php }
					}
					 ?>	
						
						
						
						
						
						
						
						<div class="form-group input_fields_wrap">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="medicine_id[]" class="form-control chzn medicine_id" id="medicine_id">
												<option value="">--<?php echo lang('select_medicine');?>--</option>
												<?php foreach($medicines as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="instruction[]" class="form-control chzn instruction">
												<option value="">--<?php echo lang('medicine_instruction'); ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								<div class="col-md-2">
										<button class="add_field_button btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
								
                            </div>
                        </div>
					
					
					
					
					
					<?php 
					if(!empty($tests1[0])){
					 foreach($tests1 as $key => $val){
					 ?>	
						
						<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
									
												<select name="report_id[]" class="form-control chzn report_id">
												
												<?php foreach($tests as $new){
														$sel = " ";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										
												
										</select>
									</div>	
                                </div>
                                
								<div class="col-md-4">
									<select name="test_instruction[]" class="form-control chzn test_instruction">
												
												<?php foreach($test_ins as $new) {
														$sel = "";
														if($new->name==$tests_ins1[$key]) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								<div class="col-md-2">
										<a href="#" class="delete_activity btn btn-danger"><?php echo lang('remove'); ?></a> 
								</div>
								
                            </div>
                        </div>
					<?php } 
						}
					?>
						
						
						
						<div class="form-group input_fields_wrap1">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="report_id[]" class="form-control chzn report_id">
												<option value="">--<?php echo lang('select_medical_test');?>--</option>
												<?php foreach($tests as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="test_instruction[]" class="form-control chzn test_instruction">
												<option value="">--<?php echo lang('medical_test_instruction'); ?>--</option>
												<?php foreach($test_ins as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								
								</div>
								<div class="col-md-2">
										<button class="add_field_button1 btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
								
                            </div>
                        </div>
					
					
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('remark');?></label>
								</div>	
								<div class="col-md-8">
								<textarea name="remark" class="form-control redactor remark"  ><?php echo @$prescription->remark;?></textarea>
                                </div>
                            </div>
                        </div>
						
						
						
							
				  <div class="box-footer">
                        <button type="submit" class="btn btn-primary update_prescription"><?php echo lang('update');?></button>
                    </div>
			</form>				

	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
  <?php $i++;}?>
<?php endif;?>




<div class="modal fade" id="add_prescription" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog " style="width:96%;"  >
    <div class="modal-content " >
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editLabel"><?php echo lang('add');?> <?php echo lang('prescription');?> </h4>
      </div>
      <div class="modal-body ht" >
				<form method="post"	 id="add_prescription_form">	
			        <div class="box-body">
              	<div id="#err_add_pre">			
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
		          
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> Prescription Id</label>
								</div>	
								<div class="col-md-4">
									<input type="text" name="prescription_id" value="<?php echo $pre_id;?>"  readonly="readonly" class="form-control"/>
                                </div>
								<div class="col-md-4">
									<input type="text" name="date_time" class="form-control datepicker" placeholder="Date" value="">
								</div>
                            </div>
						    </div>
                        </div>
						
								<input type="hidden" name="patient_id" value="<?php echo $patient->id ?>"  class="patient_id"/>	
								
						
						
						<div class="row" style="display:none;">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;">Case History</label>
													</div>	
													<div class="col-md-8">
														
														<select name="case_history_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
																<?php foreach($case_historys as $new) {
																			$sel = "";
																			$sel = set_select('case_history_id', $new->name, FALSE);
																			echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="case_history"class="form-control case_history"><?php echo set_value('case_history'); ?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	
                        	
                        </div>
						
						<div class="form-group" style="display:none;">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> O/E</label>
								</div>	
								<div class="col-md-4">
								
									<select name="disease_id[]" class="form-control chzn disease_id" multiple="multiple" data-placeholder="Select O/E">
											<?php foreach($diseases as $new) {
													$sel = "";
													$sel = set_select('disease_id', $new->name, FALSE);
													echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
											
											
									</select>
									
										
                                </div>
								<div class="col-md-4">
									<textarea name="oe_description" class="form-control oe_description" placeholder="O/E"><?php echo set_value('oe_description'); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
	 	<?php //################################################################################################################### ?>
						
							<div class="row">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;">CHIEF COMPLAINT</label>
													</div>	
													<div class="col-md-8">
														
														<select name="chiff_Complaint_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
                                                       
																<?php foreach($chiff_Complaints as $new) {
																			$sel = "";
																			$sel = set_select('chiff_Complaint_id', $new->name, FALSE);
																			echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="chiff_Complaint_history"class="form-control "><?php echo set_value('chiff_Complaint'); ?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	
                        	
                        </div>
                        
                        <div class="row">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;">MEDICAL HISTORY</label>
													</div>	
													<div class="col-md-8">
														
														<select name="medical_History_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
																<?php foreach($medical_History as $new) {
																			$sel = "";
																			$sel = set_select('medical_History_id', $new->name, FALSE);
																			echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="medical_History_history"class="form-control "><?php echo set_value('medical_History'); ?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	
                        	
                        </div>
                        <div class="row">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;">DRUG ALLERGY</label>
													</div>	
													<div class="col-md-8">
														
														<select name="drug_Allergy_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
																<?php foreach($drug_Allergy as $new) {
																			$sel = "";
																			$sel = set_select('drug_Allergy_id', $new->name, FALSE);
																			echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="drug_Allergy_history"class="form-control "><?php echo set_value('drug_Allergy'); ?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	

                        	
                        </div>
                        <div class="row">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;">EXTRA ORAL EXM.</label>
													</div>	
													<div class="col-md-8">
														
														<select name="extra_Oral_Exm_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
																<?php foreach($extra_Oral_Exm as $new) {
																			$sel = "";
																			$sel = set_select('extra_Oral_Exm_id', $new->name, FALSE);
																			echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="extra_Oral_Exm_history"class="form-control "><?php echo set_value('extra_Oral_Exm'); ?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	
                        	
                        </div>
                        
                            
                               <div class="row">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;">INTRA ORAL EXM.</label>
													</div>	
													<div class="col-md-8">
														
														<select name="intra_Oral_Exm_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
																<?php foreach($intra_Oral_Exm as $new) {
																			$sel = "";
																			$sel = set_select('intra_Oral_Exm_id', $new->name, FALSE);
																			echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="intra_Oral_Exm_history"class="form-control "><?php echo set_value('intra_Oral_Exm'); ?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	
                        	
                        </div>
                        
						<div class="form-group input_fields_wrap2">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('treatment_advised');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="treatment_Advised_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('treatment_advised');?>--</option>
                                          
												<?php foreach($treatment_Advised as $new) {
														$sel = "";
														if(set_select('treatment_Advised_id', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="treatment_Advised_instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('treatment_Advised_instruction'); ?>--</option>
												<?php foreach($treatment_Advised_ins as $new) {
														$sel = "";
														if(set_select('test_instruction', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								
								</div>
								
                            </div>
                        </div>
					
						<div class="form-group">
                        	<div class="row">
								<div class="col-md-offset-2" style="padding-left:12px;">
										<button class="add_field_button2 btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
							</div>
						</div>	
                          <section id="medi_div">		
			<?php if(empty($_POST['medicine_id'])){ ?>
				<div class="form-group input_fields_wrap">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								<div class="col-md-4" >
									<div>
										<select name="medicine_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('select_medicine');?>--</option>
												<?php foreach($medicines as $new) {
														$sel = "";
														$sel = set_select('medicine_id', $new->name, FALSE);
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('medicine_instruction'); ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														if(set_select('instruction', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								
								
                            </div>
                        </div>
				<?php } ?>
					
				<?php if(!empty($_POST['medicine_id'])){ ?>		
						<div class="form-group ">
                        	<div class="row  ">
							
					<div class="col-md-6" >
							
					<?php	$i=1;	foreach($_POST['medicine_id'] as $key => $val){
					?>						
					
							<div class="row delete<?php echo $i;?>" >
									<div class="col-md-4"><?php echo ($i>0)?'<label>Medicine</label>':''; ?></div>
										<div class="col-md-8" >
									
												<select name="medicine_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('select_medicine');?>--</option>
												<?php foreach($medicines as $new) {
														$sel = " ";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										
												
										</select>
										</div>
                                </div>
                    <?php $i++;}?>
				</div>	
				<div class="col-md-6">
					<?php $i=1;foreach($_POST['instruction'] as $key => $val){?>
								<div class="row delete<?php echo $i;?>">
									<div class="col-md-8 " >
									<select name="instruction[]" class="form-control chzn">
												<option value="">--<?php echo $_POST['instruction'][$key] ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
									<div class="col-md-4">
										<a href="#medi_div" class="btn btn-danger" onclick="$('.delete<?php echo $i;?>').remove();"><?php echo lang('remove'); ?></a> 
									</div>
								</div>
								
								
                       
					<?php $i++; }?>	
					 </div>
				</div>
				
				<div class="form-group input_fields_wrap">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								<div class="col-md-4" >
									<div>
										<select name="medicine_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('select_medicine');?>--</option>
												<?php foreach($medicines as $new) {
														$sel = "";
														$sel = set_select('medicine_id', $new->name, FALSE);
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('medicine_instruction'); ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														if(set_select('instruction', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								
								
                            </div>
                        </div>
				<?php }?>
				
				
						
						<div class="form-group">
                        	<div class="row">
								<div class="col-md-offset-2" style="padding-left:12px;">
										<button class="add_field_button btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
							</div>
						</div>		
	</section>
	<section id="test_div">					
				
				<?php if(empty($_POST['report_id'])){ ?>
						<div class="form-group input_fields_wrap1">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="report_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('select_medical_test');?>--</option>
												<?php foreach($tests as $new) {
														$sel = "";
														if(set_select('report_id', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="test_instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('medical_test_instruction'); ?>--</option>
												<?php foreach($test_ins as $new) {
														$sel = "";
														if(set_select('test_instruction', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								
								</div>
								
                            </div>
                        </div>
					<?php } ?>
					
				<?php if(!empty($_POST['report_id'])){ ?>		
						<div class="form-group ">
                        	<div class="row  ">
							
					<div class="col-md-6" >
					
					<?php	$i=1;	foreach($_POST['report_id'] as $key => $val){
					?>						
					
							<div class="row delete_test<?php echo $i;?>" >
									<div class="col-md-4"><?php echo ($i>0)?'<label>Medicine</label>':''; ?></div>
										<div class="col-md-8" >
									
												<select name="report_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('select_medical_test');?>--</option>
												<?php foreach($tests as $new) {
														$sel = "";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
											</select>
										</div>
                                </div>
                    <?php $i++;}?>
				</div>	
				<div class="col-md-6">
					<?php $i=1;foreach($_POST['test_instruction'] as $key => $val){?>
								<div class="row delete_test<?php echo $i;?>">
									<div class="col-md-8 " >
									<select name="test_instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('medical_test_instruction'); ?>--</option>
												<?php foreach($test_ins as $new) {
														$sel = "";
														if($val== $new->name) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
									<div class="col-md-4">
										<a href="#test_div" class="btn btn-danger" onclick="$('.delete_test<?php echo $i;?>').remove();"><?php echo lang('remove'); ?></a> 
									</div>
								</div>
								
								
                       
					<?php $i++; }?>	
					 </div>
				</div>
				
			
						
						<div class="form-group input_fields_wrap1">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="report_id[]" class="form-control chzn">
												<option value="">--<?php echo lang('select_medical_test');?>--</option>
												<?php foreach($tests as $new) {
														$sel = "";
														if(set_select('report_id', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="test_instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('medical_test_instruction'); ?>--</option>
												<?php foreach($test_ins as $new) {
														$sel = "";
														if(set_select('test_instruction', $new->name)) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								
								</div>
								
                            </div>
                        </div>
				<?php } ?>		
						<div class="form-group">
                        	<div class="row">
								<div class="col-md-offset-2" style="padding-left:12px;">
										<button class="add_field_button1 btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
							</div>
						</div>		
	</section>				
						<?php //################################################################################################################### ?>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('remark');?></label>
								</div>	
								<div class="col-md-8">
								<textarea name="remark" class="form-control redactor remark"><?php echo set_value('remark'); ?></textarea>
                                </div>
                            </div>
                        </div>
						
		</div>
      <div class="modal-footer">
     	<input type="submit" name="ok" class="btn btn-primary"  value="Save" />
	 	   <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>
	  </div>
    </div>
  </div>
</div>

</form>






<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/lightbox/simple-lightbox.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/redactor.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script type="text/javascript">

$(function(){
		var $gallery = $('.gallery a').simpleLightbox();
		
		$gallery.on('show.simplelightbox', function(){
			console.log('Requested for showing');
		})
		.on('shown.simplelightbox', function(){
			console.log('Shown');
		})
		.on('close.simplelightbox', function(){
			console.log('Requested for closing');
		})
		.on('closed.simplelightbox', function(){
			console.log('Closed');
		})
		.on('change.simplelightbox', function(){
			console.log('Requested for change');
		})
		.on('next.simplelightbox', function(){
			console.log('Requested for next');
		})
		.on('prev.simplelightbox', function(){
			console.log('Requested for prev');
		})
		.on('nextImageLoaded.simplelightbox', function(){
			console.log('Next image loaded');
		})
		.on('prevImageLoaded.simplelightbox', function(){
			console.log('Prev image loaded');
		})
		.on('changed.simplelightbox', function(){
			console.log('Image changed');
		})
		.on('nextDone.simplelightbox', function(){
			console.log('Image changed to next');
		})
		.on('prevDone.simplelightbox', function(){
			console.log('Image changed to prev');
		})
		.on('error.simplelightbox', function(e){
			console.log('No image found, go to the next/prev');
			console.log(e);
		});
	});
$(function() {
	$('#example1').dataTable({
	});
	$('#example2').dataTable({
	});
	$('#example3').dataTable({
	});
	$('#example4').dataTable({
	});
	$('#example5').dataTable({
	});
	$(".chzn").chosen();
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
		url: '<?php echo site_url('admin/patients/edit') ?>/' + id,
		type:'POST',
		//data:{name:name,gender:gender,blood_id:blood_id,dob:dob,email:email,password:password,confirm:conf,contact:contact,address:address},
		data:$(form).serialize(),
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					//location.reload();
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id)?>";
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_edit').html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
	
	
});


$( ".update_message" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	message = $(form ).find('.message').val();
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/message/send') ?>/' + id,
		type:'POST',
		data:{message:message},
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					//location.reload();
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/message')?>";
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_edit_msg').html(result);
				}
		  
		  $(".chzn").chosen();
		 }
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
		url: '<?php echo site_url('admin/appointments/add/') ?>',
		type:'POST',
		data:{title:title,whom:whom,patient_id:patient_id,contact_id:contact_id,other:other,date_time:date_time,motive:motive,notes:notes,is_paid:is_paid},
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					 $('#add').modal('hide');
					 window.close();
					 window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/appointment')?>";
					 //location.reload(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err').html(result);
				}
		  
		 }
	  });
	
	event.preventDefault();
});



$( ".update_notes" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	patient_id = $(form ).find('.patient_id').val();
	notes = $(form ).find('.notes').val();
	
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/notes/edit') ?>/' + id,
		type:'POST',
		data:{patient_id:patient_id,notes:notes},
	
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/notes')?>";
					//location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_notes'+id).html(result);
				}
		  
		 }
	  });
	
	
});

$( "#add_inv_form" ).submit(function( event ) {
	var form = $(this).closest('form');
	patient_id = $(form ).find('.patient_id').val();
	invoice_no = $(form ).find('.invoice_no').val();
	amount= $(form ).find('.amount').val();
	payment_mode_id = $(form ).find('.payment_mode_id').val();
	payment_for = $(form ).find('.payment_for').val();
	date = $(form ).find('.date').val();
	call_loader_ajax();
	//alert(patient_id); return false;
	$.ajax({
		url: '<?php echo site_url('admin/payment/add_payment/') ?>',
		type:'POST',
		data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date,payment_for:payment_for},
		success:function(result){
			  if(result==1)
				{
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					 $('#add_inv').modal('hide');
					 window.close();
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/payment_history')?>";
					// location.reload(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_inv').html(result);
				}
		  
		 }
	  });
	
	event.preventDefault();
});



$( ".update_invoice" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	patient_id = $(form ).find('.patient_id').val();
	invoice_no = $(form ).find('.invoice_no').val();
	amount= $(form ).find('.amount').val();
	payment_mode_id = $(form ).find('.payment_mode_id').val();
	payment_for = $(form ).find('.payment_for').val();
	date = $(form ).find('.date').val();
	//alert(amount);return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/payment/edit_payment') ?>/' + id,
		type:'POST',
		data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date,payment_for:payment_for},
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/payment_history')?>";
					//location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_inv'+id).html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
});



$( ".updatez" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	
	var form = $(this).closest('form');
	
	patient_id = $(form ).find('.p_idz').val();
	//alert(patient_id);
	amount= $(form ).find('.amout1').val();
	amounts= $(form ).find('.amout2').val();
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/prescription/amout/') ?>/',
		type:'POST',
		data:{patient_id:patient_id,amount:amount,amounts:amounts},
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id)?>";
					//location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_inv'+id).html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
});



$( ".update_appointment" ).click(function( event ) {
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
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/appointment')?>";
					//location.reload();
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


$( "#add_note" ).submit(function( event ) {
	patient_id = '<?php echo $patient->id; ?>';
	notes = $('.notes').val();
	call_loader_ajax();	
	$.ajax({
		url: '<?php echo base_url('admin/notes/add/') ?>',
		type:'POST',
		data:{patient_id:patient_id,notes:notes},
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					 $('#add').modal('hide');
					 window.close();
					 window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/notes')?>";
					 //location.reload(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_note').html(result);
				}
		  
		 }
	  });
	
	event.preventDefault();
});



$( "#add_prescription_form" ).submit(function( event ) {
	call_loader_ajax();
	//alert(patient_id); return false;
	$.ajax({
		url: '<?php echo base_url('admin/prescription/add_prescription/') ?>',
		type:'POST',
		data:$(this).closest('#add_prescription_form').serialize(),
		success:function(result){
			  if(result==1)
				{
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/medication_history')?>"; 
					 //location.reload(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_add_pre').html(result);
				}
		  
		 }
	  });
	
	event.preventDefault();
});





$(".patient").show();
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

$(document).on('focusout', '.datepicker_appointment', function(){
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
					$('.datepicker').val(' ');
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



$( ".update_prescription" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	var form = $(this).closest('form');
	
	id = $(form ).find('input[name=id]').val();
	<?php /*
	patient_id = $(form ).find('.patient_id').val();
	date_time = $(form ).find('input[name=date_time]').val();
	case_history = $(form ).find('.case_history').val();
	case_history_id = $(form ).find('.case_history_id').val();
	disease_id = $(form ).find('.disease_id').val();
	instruction = $(form ).find('.instruction').val();
	test_instruction = $(form ).find('.test_instruction').val();
	remark = $(form ).find('.remark').val();
	medicine_id = $(form ).find('.medicine_id').val();
	oe_description = $(form ).find('.oe_description').val();
	
	report_id = $(form ).find('.report_id').val();
	data = 	$('#edit').serializeArray();
	
		alert(medicine_id);return false;
	*/ ?>
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/prescription/edit_prescription') ?>/' + id,
		type:'POST',
		data:$(this).closest('#edit_form').serialize(),
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					window.location = "<?php echo site_url('admin/patients/view/'.$patient->id.'/medication_history')?>";
					//location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").remove();
					$('#err_pre'+id).html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
	
	
});

</script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script>
 $(function() {
 	 $(".redactor").wysihtml5({
	 "link": false, //Button to insert a link. Default true
	"image": false, //Button to insert an image. Default true,
	 });
 }); 
 $('.redactor1').redactor({
			  // formatting: ['p', 'blockquote', 'h2','img'],
            minHeight: 200,
            imageUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_image');?>',
            fileUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_file');?>',
            imageGetJson: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/get_images');?>',
            imageUploadErrorCallback: function(json)
            {
                alert(json.error);
            },
            fileUploadErrorCallback: function(json)
            {
                alert(json.error);
            }
      });
 //jQuery('.datepicker').datetimepicker({disabledDates: ['01.09.2015','02.09.2015','03.01.2014','04.01.2014','05.01.2014','06.01.2014'], formatDate:'d.m.Y'});
 jQuery('.datepicker').datetimepicker({
 lang:'en',
 //disabledDates: ['2015-09-01','2015-09-02','2015-09-03'],
 format:'Y-m-d H:i:00', 
 timepicker:true,
});

jQuery('.payment_date').datetimepicker({
 lang:'en',
 //disabledDates: ['2015-09-01','2015-09-02','2015-09-03'],
 format:'Y-m-d', 
 timepicker:false,
});

function call_loader(){
	
	if($('#overlay').length == 0 ){
		var over = '<div id="overlay">' +
						'<img  style="padding-top:300px; padding-left:500px;"id="loading" src="<?php echo base_url('assets/img/green-ajax-loader.gif')?>"></div>';
		
		$(over).appendTo('body');
	}
}



$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('</br><div class="row"><div class="col-md-2"></div><div class="col-md-4"><select name="medicine_id[]" class="form-control chzn"><option value="">--<?php echo lang('select_medicine');?>--</option><?php foreach($medicines as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><div class="col-md-4"><select name="instruction[]" class="form-control chzn"><option value="">--<?php echo lang('medicine_instruction'); ?>--</option><?php foreach($medicine_ins as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><a href="#" class="remove_field btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box
			$('.chzn').chosen({search_contains:true});
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});




$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap1"); //Fields wrapper
    var add_button      = $(".add_field_button1"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed

            x++; //text box increment
            $(wrapper).append('</br><div class="row"><div class="col-md-2"></div><div class="col-md-4"><select name="report_id[]" class="form-control chzn"><option value="">--<?php echo lang('select_medical_test');?>--</option><?php foreach($tests as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><div class="col-md-4"><select name="test_instruction[]" class="form-control chzn"><option value="">--<?php echo lang('medical_test_instruction'); ?>--</option><?php foreach($test_ins as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><a href="#" class="remove_field1 btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box
			$('.chzn').chosen({search_contains:true});
        }
    });
    
    $(wrapper).on("click",".remove_field1", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap2"); //Fields wrapper
    var add_button      = $(".add_field_button2"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('</br><div class="row"><div class="col-md-2"></div><div class="col-md-4"><select name="treatment_Advised_id[]" class="form-control chzn"><option value="">--<?php echo lang('Treatment_Advised');?>--</option><?php foreach($treatment_Advised_tests as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><div class="col-md-4"><select name="treatment_Advised_instruction[]" class="form-control chzn"><option value="">--<?php echo lang('treatment_Advised_instruction'); ?>--</option><?php foreach($treatment_Advised_ins as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><a href="#" class="remove_field1 btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box
			$('.chzn').chosen({search_contains:true});
        }
    });
    
    $(wrapper).on("click",".remove_field1", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
$("#username").on('blur',function() {   
    var val = $('#username').val();
    var id  = <?php echo $patient->id?>; 
	 if(val){
	 	call_loader();
	 	$.ajax({
		url: '<?php echo site_url('admin/patients/check_username') ?>',
		type:'POST',
		data:{username:val,id:id},
		success:function(result){
		  if(result==1){
		  	 $("#overlay").remove();
		  	$('#username').val('<?php echo $patient->username?>');
			$('#username').focus();
			$('#username-error').show();
			$('#username-error').html('This Username Is Exists Try Again..');
			
		  }else{
		  	$('#username-error').hide();
		  }
		  $("#overlay").remove();
		}
	  });
	 }     
}); 
</script>