<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css');?>" rel="stylesheet" type="text/css" />
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
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Expenses</li>
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
                    <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> Add</a>
                </div>
            </div>    
        </div>	
<?php } ?>		
        
  	  	<div class="row no-print">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Expenses</h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive no-print" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                                               <th >S. No.</th>
							        <th>Details</th>
								<th>Amount</th>
                                                                <th>Date</th>
								
                                 <!--<th>Total</th>-->
								
								<th width="30%"></th>
                                <th width="30%"></th>
                            </tr>
                        </thead>
                        
                        
                        <tbody>
                            
                            <?php $i=1;foreach ($all_expenses as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i;?></td>
									
									<td><?php echo $new->details; ?></td>	
												
									<td><?php echo $new->amount; ?></td>
                        
									
									<td><?php echo $new->date; ?></td>
								    <td width="30%">
                                        <div class="btn-group">
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/expenses/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> Delete </a>
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <div class="btn-group">
                                            <a class="btn btn-primary"  style="margin-left:12px;" href="<?php echo site_url('admin/expenses/edit/'.$new->id);?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
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

<!-- Add Payment-->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel">Add Expense</h4>
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
				<form method="post" action="<?php echo site_url('admin/expenses/add/');?>" enctype="multipart/form-data" id="add_form">
			
			        <div class="box-body">
                      
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b>Date</b>
								</div>
								<div class="col-md-4">
<input type="text" name="date" class="form-control datetimepicker" value=""/>
                                 </div>
                            </div>
                        </div>
						
                         <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b>Amount</b>
								</div>
								<div class="col-md-4">
<input type="text" name="amount" class="form-control" />
                                </div>
                            </div>
                        </div>
                        
                          <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b>Details</b>
								</div>
								<div class="col-md-4">
<input type="text" name="details" class="form-control" />
                                </div>
                            </div>
                        </div>
						
					   
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary">Save</button>
                    </div>
			</form>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
      </div>
    </div>
  </div>
</div>
<?php if(isset($all_expenses)):?>
<?php $i=1;
foreach ($all_expenses as $new){?>

    <div class="modal fade" id="view<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">



                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="viewlabel"><?php echo lang('view');?> Pharmacy</h4>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-3">

                                <label for="name" style="clear:both;"><?php echo lang('name')?></label>

                            </div>

                            <div class="col-md-4">



                            </div>

                        </div>

                    </div>





                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-3">

                                <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>

                            </div>

                            <div class="col-md-4">


                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-3">

                                <label for="dob" style="clear:both;"><?php echo lang('date_of_birth')?></label>



                            </div>

                            <div class="col-md-4">




                            </div>

                        </div>

                    </div>



                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-3">

                                <label for="email" style="clear:both;"><?php echo lang('email')?></label>

                            </div>

                            <div class="col-md-4">




                            </div>

                        </div>

                    </div>



                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-3">

                                <label for="username" style="clear:both;"><?php echo lang('username')?></label>

                            </div>

                            <div class="col-md-4">


                            </div>

                        </div>

                    </div>









                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-3">

                                <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>

                            </div>

                            <div class="col-md-4">


                            </div>

                        </div>

                    </div>



                    <div class="form-group">

                        <div class="row">

                            <div class="col-md-3">

                                <label for="contact" style="clear:both;"><?php echo lang('address')?></label>

                            </div>

                            <div class="col-md-4">

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


<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('.chzn').chosen({search_contains:true});
});


$( "#add_form" ).submit(function( event ) {

	call_loader_ajax();
	$.ajax({
		url: '<?php echo base_url('admin/expenses/add/') ?>',
		type:'POST',
		data:$("#add_form").serialize(),
		success:function(result){
	
			  if(result==1)
				{
				
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					 $('#add').modal('hide');
					 window.close();
					
					 window.location="<?php echo base_url('admin/expenses/');?>";
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

 jQuery('.datepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'Januar','Februar','M�rz','April',
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
 format:'Y-m-d H:i:00'
});

</script>
  