<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure');?>');
}
</script>
<style>
.chosen-container{width:100% !important
}
@media print{
   .invoice{width:100% !important;
   display:block !important;
   }
   .bd{border:1px solid #f4f4f4 !important}
}
</style>
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active"><?php echo lang('payment');?></li>
        </ol>
</section>

<section class="content">
<?php 
if($err!=''){
echo '<script>alert("'.$err.'");</script>';
}
	$admin = $this->session->userdata('admin');
	if($admin['user_role']==1 || $admin['user_role']==3){
?>
  	  	 <div class="row no-print" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add') ." ". lang('payment');?></a>
                </div>
            </div>    
        </div>	
<?php } ?>		
        
  	  	<div class="row no-print">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('payment');?></h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive no-print" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="display:none">#</th>
								<th><?php echo lang('invoice_number');?></th>
							
								<th><?php echo lang('name');?></th>
								
								<th><?php echo lang('amount');?></th>
								<th width="30%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($payments)):?>
                        <tbody>
                            <?php $i=1;foreach ($payments as $new){?>
                                <tr class="gc_row">
                                    <td style="display:none"><?php echo $i;?></td>
									 <td><?php echo $new->invoice?></td>
									
                                    <td><?php echo $new->patient?></td>
                                    <td><?php echo $new->amount?></td>
									
								    <td width="30%" style="">
                                        <div class="btn-group">
										  <a class="btn btn-default" style="display:none;margin-left:10px;"  href="#invoice<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/payment/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
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





<?php if(isset($payments)):?>
<?php $i=1;
foreach ($payments as $new){
$details = $this->invoice_model->get_detail($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="invoice<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="invoicelabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="invoicelabel"><?php echo lang('invoice');?></h4>
      </div>
      <div class="modal-body">
	  <div id="mydiv" >
      					<section class="content invoice" >
                     
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
												
												<b><?php echo lang('payment_mode') ?>:</b> <?php echo $details->mode ?><br/>
												
												<?php if($details->balance>0){?>
												<b><?php echo lang('balance')?>:</b> <?php echo $details->balance;?>
												<?php } ?>
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
									<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="55%" align="left"><b>Entry</b></td>
                                            <td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="20%"><b>Date</b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="20%"><b>Price</b></td>
										</tr>
                                             <?php 
                        	 error_reporting(0);
											  $d = json_decode($details->treatment_Advised_id);
											  	  $ins1 = json_decode($details->dates);
												   $bal = json_decode($details->balance);
											 if(is_array($d)){
														$i=1;
														echo "Total Amount : ". $details->amount." INR";
														foreach($d as $key => $new){ 
														if(!empty($d[$key]))
															
														
														  ?>
										<tr >
											 <td width="5%" style="border-right:1px solid #CCCCCC" ><?php echo $i; ?></td>
                                             
											 <td width="55%" style="border-right:1px solid #CCCCCC"><?php 
											
														
														if(!empty($d[$key])){
															echo $d[$key];
														
														$i++; 
													}else{
														echo $d;
														
													}
											?></td>
                                             <td width="20%" style="border-right:1px solid #CCCCCC"  ><?php 
												
														if(!empty($ins1[$key])){
															echo $ins1[$key];
														
														
													}else{
														echo $ins1[$key];
														}
													
											  ?></td>
											 <td width="20%" style="border-right:1px solid #CCCCCC"  ><?php 
														if(!empty($bal[$key])){
															echo $bal[$key];
														
														 
													}else{
														echo $bal[$key];
														} ?></td>
											
										</tr>
                                          <?php }
													}else{
														echo $d;
														
													}  ?>
									</table>
                                     <?php echo "Pending  Amount : ".$details->pending; ?>
								</td>
							</tr>
                          
						</table>
                      
					 <?php $admin = $this->session->userdata('admin');
					 if($admin['user_role']==2){ ?>
					 <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="printData<?php echo $new->id?>()" ><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php }else{?>	
				
                    <!-- this row will not appear when printing -->
                    <div class="row no-print" style="padding-top:10px;">
                        <div class="col-xs-12">
                            <button class="btn btn-default no-print" onclick="printData<?php echo $new->id?>()" ><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php } ?>	
					
					
					
                </section><!-- /.content -->
	  	</div>
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






<?php if(isset($payments)):?>
<?php $i=1;
foreach ($payments as $new){
$payment = $this->prescription_model->get_payment_by_id($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('update');?> <?php echo lang('fees')?></h4>
      </div>
      <div class="modal-body">
			 <div id="err_edit<?php echo $new->id?>">  
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
			
			<form method="post" action="<?php echo site_url('admin/payment/edit_payment1/'.$payment->id)?>" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $payment->id;?>" />
		              <div class="form-group" style="margin-top:20px;"> 
							 <legend><?php echo lang('add_payment_detail')?></legend>  
					    </div>
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('patient')?></b>
								</div>
								<div class="col-md-4">
                                    <select name="patient_id" class="form-control chzn patient_id">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($pateints as $new) {
													$sel = "";
													if($payment->patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->username.','.$new->contact.'</option>';
												}
												
											?>
									</select>
                                </div>
                            </div>
                        </div>
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
                                    <input type="text" name="amount"  value="<?php echo $payment->amount; ?>" id="amount"  class="form-control amount" readonly/>
									
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
					foreach($treatment_Advised_id as $key => $val){
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
                                    <input type="text" name="balance" value="<?php echo $balance; ?>"  id="balancex" class="form-control balance " />
									
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
			if($new->id==$payment->payment_mode_id) $sel = "selected='selected'";
			echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
											
					}
										
										?>
									</select>
                                </div>
                            </div>
                        </div>
						 <div class="box-footer">
                        <button type="submit" class="btn btn-primary "><?php echo lang('update')?></button>
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

<!-- Add Payment-->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('payment');?></h4>
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
      				   <!-- form start -->
                       <input type="text" readonly="readonly" id="err" style="display:none;" />
				<form method="post" action="<?php echo site_url('admin/payment/add_payment/'.@$p_id)?>" enctype="multipart/form-data" id="">
			 
			        <div class="box-body">
                      <div class="form-group" style="margin-top:20px;"> 
							 <legend><?php echo lang('add_payment_detail')?></legend>  
					    </div>
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('patient')?></b>
								</div>
								<div class="col-md-4">
                                    <select name="patient_id" onchange="ajx(this.value)" class="form-control chzn patient patient_id " <?php echo (!empty($p_id))?'disabled':'';?>  >
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($pateints as $new) {
													$sel = "";
													if($p_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->username.','.$new->contact.'</option>';
												}
												
											?>
									</select>
                                </div>
                            </div>
                        </div>
						<div class="form-group" style="margin-top:20px;display:none;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="invoice_no" value="<?php echo $i_no;?>" readonly="readonly"  class="form-control invoice_no" />
									
                                </div>
                            </div>
                        </div>
                         <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('totalamount')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="amount" value="" id="amountz"  class="form-control amount" />
									
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
					
					   
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amnt')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="balance" value=""  id="balancex" class="form-control balance " />
									
                                </div>
                            </div>
                        </div>
						
						
						  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('date')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="date" class="form-control datepicker date " />
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                        	<div class="row">
								<div class="col-md-offset-2" style="padding-left:12px;">
										
								</div>
							</div>
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




<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<?php if(!empty($p_id)){?>
<script>
var total1;
var total='';
var idxx='';
var total1x;
$(function() {
	$('#add').modal();
});
</script>

<?php } ?>

<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('.chzn').chosen({search_contains:true});
});


function PrintContent()
{
var DocumentContainer = document.getElementById('mydiv');
var WindowObject = window.open("", "PrintWindow",
"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
WindowObject.document.writeln(DocumentContainer.innerHTML);
WindowObject.document.close();
WindowObject.focus();
WindowObject.print();
WindowObject.close();
}
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function ajx(patient)
{




   $.ajax({ url: "<?php echo base_url().'admin/payment/checkz_payment/'; ?>",
                data: "&patient_id="+patient,
                type: "POST",
                success: function(data){
if(data!=''){
                document.getElementById("amountz").value=data;
document.getElementById("amountz").readOnly = true;
			}else{
document.getElementById("amountz").value='';
document.getElementById("amountz").readOnly = false;
}
                }
        });
	
	

}
    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252"><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body  style="width:100%">');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

$( "#add_form" ).submit(function( event ) {
	var form = $(this).closest('form');
	patient_id = $(form ).find('.patient_id').val();
	invoice_no = $(form ).find('.invoice_no').val();
	amount= $(form ).find('.amount').val();
	payment_mode_id = $(form ).find('.payment_mode_id').val();
	
	payment_for = $(form ).find('.payment_for').val();
	
	call_loader_ajax();
	$.ajax({
		url: '<?php echo base_url('admin/payment/add_payment/') ?>',
		type:'POST',
		data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,payment_for:payment_for},
		success:function(result){
			  if(result==1)
				{
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					 $('#add').modal('hide');
					 window.close();
					 location.reload(); 
				}
				else
				{
					$("#overlay").hide();
					$('#err').html(result);
				}
		  
		 }
	  });
	
	event.preventDefault();
});



$( ".update" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	patient_id = $(form ).find('.patient_id').val();
	invoice_no = $(form ).find('.invoice_no').val();
	amount= $(form ).find('.amount').val();
	payment_mode_id = $(form ).find('.payment_mode_id').val();
	date = $(form ).find('.date').val();
	payment_for = $(form ).find('.payment_for').val();
	balance = $(form ).find('.balance').val();
	//alert(amount);return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo base_url('admin/payment/edit_payment1') ?>/' + id,
		type:'POST',
		data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date,payment_for:payment_for,balance:balance},
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					
					$('#edit'+id).modal('hide');
					window.close(); 
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

</script>
<script>
var x=1;
 
$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap2"); //Fields wrapper
    var add_button      = $(".add_field_button2"); //Add button ID
    
    x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
			
            $(wrapper).append('</br> <div class="row"><div class="form-group" style="margin-top:20px;"><div class="row"><div class="col-md-3"><b><?php echo lang('treatment_advised')?></b></div><div class="col-md-4"> <select name="treatment_Advised_id[]" class="form-control chzn"><option value="">--<?php echo lang('treatment_advised');?>--</option><?php foreach($treatment_Advised as $new) {$sel = "";if(set_select('treatment_Advised_id', $new->name)) $sel = "selected='selected'";echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';}?></select></div></div></div><div class="form-group" style="margin-top:20px;"><div class="row"> <div class="col-md-3"><b><?php echo lang('balance')?></b></div><div class="col-md-4"><input type="text" name="balance[]" value="" id="balance"  class="form-control balance" /> </div> </div></div><div class="form-group"><div class="row"> <div class="col-md-3"><b><?php echo lang('date')?></b></div><div class="col-md-4"> <input type="date" name="date[]" class="form-control datepicker1 date " /></div></div></div><a href="#" class="remove_field1 btn btn-danger"><?php echo lang('remove'); ?></a></div>'); $('.chzn').chosen({search_contains:true}); } });
    
    $(wrapper).on("click",".remove_field1", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});

</script>
