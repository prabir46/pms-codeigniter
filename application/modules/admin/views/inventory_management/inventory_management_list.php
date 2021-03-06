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
            <li class="active"><?php echo lang('inventory_management');?></li>
        </ol>
</section>

<section class="content">
<?php 
	$admin = $this->session->userdata('admin');
	if($admin['user_role']==1 || $admin['user_role']==3){
?>
  	  	 <div class="row no-print" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('lab_add'); ?></a>
                </div>
            </div>    
        </div>	
<?php } ?>		
        
  	  	<div class="row no-print">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('inventory_management');?></h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive no-print" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th >SR.NO.</th>
							<th><?php echo lang('name');?></th>
								<th><?php echo lang('quantity');?></th>
								<th><?php echo 'Purchased Date';?></th>
								
								<th><?php echo lang('supplier'); ?></th>
								
								<th width="30%"></th>
                            </tr>
                        </thead>
                        
                        
                        <tbody>
                       
                            <?php $i=1;foreach ($tests as $new){?>
                                <tr class="gc_row">
                                    <td ><?php echo $i;?></td>
									 
					<td><?php echo $new->name; ?></td>	
		
                                    <td><?php echo $new->quantity ?></td>
                                    <td><?php echo $new->dates ?></td>
									

<td><?php
$con=mysqli_connect("localhost","doctori8_prod","doctori8_prod123","dbdoctori8");
$sid=$new->supplier;
$sql = mysqli_query($con, "SELECT name From supplier where id='$sid'");
$row = mysqli_num_rows($sql);
while ($row = mysqli_fetch_array($sql)){
echo $row['name'];
}
?></td>

								    <td width="30%">
                                        <div class="btn-group">
										  <a class="btn btn-default" style="margin-left:10px; display:none;"  href="#invoice<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/inventory_management/edit/'.$new->id); ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/inventory_management/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                     
                    </table>
					
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>





<?php //#########################################################################?>

<?php foreach ($tests as $new){?>
<div class="modal fade" id="Appointment<?php echo $new->patient_id; ?>" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
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
		            <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"> <?php echo lang('detail')?></label>
									<input type="text" name="title" value="<?php echo set_value('title'); ?>" class="form-control title">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
									   <select name="whom" class="form-control chzn whom" >
							
											<option value="1"><?php echo lang('patient');?></option>
							
										
										</select>
                                </div>
							
                            </div>
                        </div>
						
						 <div class="form-group patient">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									   <select name="patient_id" class="form-control chzn patient_id">
								
											 <?php foreach($pateints as $new1) {	
if($new->patient_id==$new1->id){ 
													$sel = "";
													 $sel = "selected='selected'";
													echo '<option value="'.$new1->id.'" '.$sel.'>'.$new1->name.'</option>';
}											
}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						
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
									<input type="text" name="date_time" value="<?php echo set_value('date_time'); ?>" class="form-control datetimepicker date_time">
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
                                    <label for="name" style="clear:both;"><?php echo lang('is_paid')?></label>
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

</div><?php } ?>
<script></script>
<?php //###############################################################################?>

<!-- Add Payment-->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('lab_add');?> </h4>
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
				<form method="post" action="<?php echo site_url('admin/inventory_management/add/')?>" enctype="multipart/form-data" id="add_form">
			
			        <div class="box-body">
                      <div class="form-group" style="margin-top:20px;"> 
							 <legend><?php echo lang('inventory_management')?></legend>  
					    </div>
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('name')?></b>
								</div>
								<div class="col-md-4">
                                <input type="text" name="name" value="" class="form-control name" />
                                    
                                </div>
                            </div>
                        </div>
						
                         <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('quantity')?></b>
								</div>
								<div class="col-md-4">
                                   <input type="text" name="quantity" value="" class="form-control quantity" />
                                </div>
                            </div>
                        </div>
                        
                        
						
						  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('price')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="price" value="" class="form-control price" />
                                </div>
                            </div>
                        </div>


  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('supplier')?></b>
								</div>
								<div class="col-md-4">
                                    <select name="supplier" class="form-control chzn patient supplier "  >
											
<?php foreach($name as $new) {
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
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
</div>
								<div class="col-md-4">
	<input type="text" name="dates" value="<?php echo set_value('date_time'); ?>" class="form-control datetimepicker">
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
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                    </div>
								<div class="col-md-4">
							<input type="text" class="form-control reply" name="reply[<?php echo $doc->id ?>]" />
								</div> </div>
                            </div>
                        </div>
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                    </div>
								<div class="col-md-4">
							<select name="reply[<?php echo $doc->id ?>]" class="form-control">
							<?php	
										foreach($values as $key=>$val) {
											echo '<option value="'.$val.'">'.$val.'</option>';
										}
							?>			
							</select>	
								</div> </div>
                            </div>
                        </div>
						<?php	}	
								if($doc->field_type==3) //radio buttons
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                    </div>
								<div class="col-md-4">
							
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div> </div>
                            </div>
                        </div>
						
						<?php }
						if($doc->field_type==4) //checkbox
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							</div>
								<div class="col-md-4">
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" class="form-control" />	<?php echo $val;?>&nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div> </div>
                            </div>
                        </div>
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                    </div>
								<div class="col-md-4">
										<textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
								></div>
                            </div>
                        </div>
							 </div>
						
						
					<?php 
								}	
							}
						}
					?>	
            
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
	name = $(form ).find('.name').val();
	quantity = $(form ).find('.quantity').val();
	price= $(form ).find('.price').val();
	supplier = $(form ).find('.supplier').val();
	dates =$(form ).find('.datetimepicker').val();
	
	call_loader_ajax();
	$.ajax({
		url: '<?php echo base_url('admin/inventory_management/add/') ?>',
		type:'POST',
		data:{name:name,quantity:quantity,price:price,supplier:supplier,dates:dates},
		success:function(result){
	
			  if(result==1)
				{
				
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					 $('#add').modal('hide');
					 window.close();
					
					 window.location="<?php echo base_url('admin/inventory_management/') ?>";
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
		url: '<?php echo base_url('admin/payment/edit_payment') ?>/' + id,
		type:'POST',
		data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date,payment_for:payment_for,balance:balance},
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


$( "#add_app" ).submit(function( event ) {
	//title 		= $('input[name=title]').val();
	var form = $(this).closest('form');
	title = $(form ).find('.title').val();
	whom 		= $(form ).find('.whom').val();
	patient_id 	= $(form ).find('.patient_id').val();
	contact_id 	= '';
	other	   	= '';
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
					 location.reload(); 
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

 jQuery('.datepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'Januar','Februar','M?rz','April',
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




</script>
  