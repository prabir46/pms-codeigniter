<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<style>
.chosen-container{width:100% !important}
</style>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure');?>');
}
</script>
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Notes</li>
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
                    <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new');?></a>
                </div>
            </div>    
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Notes</h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number');?></th>
								<th><?php echo lang('date');?></th>
								<th><?php echo lang('patient');?></th>
								<th><?php echo lang('notes');?></th>
								<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($lists)):?>
                        <tbody>
                            <?php $i=1;foreach ($lists as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo date("d/m/Y h:i:a", strtotime($new->datetime))?></td>
									<td><?php echo $new->patient?></td>
									<td><?php echo $new->notes?></td>
									
                                    <td width="27%">
                                        <div class="btn-group">
                                          <a class="btn btn-default"   href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
										  <a class="btn btn-primary" style="margin-left:12px;" href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/notes/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
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



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> Notes</h4>
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
			<form method="post" id="add">
					<div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									<select name="patient_id" class="form-control chzn patient_id">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($patients as $new) {
													$sel = "";
													if($list->patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
                            </div>
                        </div>

				
				
                       <div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('description');?></label>
									<textarea name="notes"class="form-control notes redactor"><?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>
                        </div>
						
						
						
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
					
				
	  </div><!-- /.box-body -->
    
					
     		
				
				     
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>








<?php if(isset($lists)):?>
<?php $i=1;
foreach ($lists as $list){?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $list->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('notes')?></h4>
      </div>
      <div class="modal-body">
	  <div id="err_edit<?php echo $list->id?>">  
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
                        
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									<select name="patient_id" class="form-control chzn patient_id">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($patients as $new) {
													$sel = "";
													if($list->patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
					
                                </div>
                            </div>
                        </div>

						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
									<textarea name="notes"class="form-control notes redactor" ><?php echo $list->notes?></textarea>
                                </div>
                            </div>
                        </div>
						
                    </div><!-- /.box-body -->
    
					<div class="box-footer">
                        <button type="submit" class="btn btn-primary update"><?php echo lang('save');?></button>
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








<?php if(isset($lists)):?>
<?php $i=1;
foreach ($lists as $list){?>
<!-- Modal -->
<div class="modal fade" id="view<?php echo $list->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
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
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									</div>	
								<div class="col-md-3">
									<?php echo $list->patient?>
					
                                </div>
                            </div>
                        </div>
						
				
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
									</div>	
								<div class="col-md-3">
									<?php echo $list->notes?>
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
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/redactor.min.js')?>"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('.chzn').chosen();
	 $('.redactor').redactor({
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
});

$( "#add" ).submit(function( event ) {
	patient_id = $('.patient_id').val();
	notes = $('.notes').val();
	call_loader_ajax();	
	$.ajax({
		url: '<?php echo site_url('admin/notes/add/') ?>',
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
					location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").hide();
					$('#err_edit'+id).html(result);
				}
		  
		 }
	  });
	
	
});

</script>
