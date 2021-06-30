<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('Are You Sure You Want Delete This Clinics');
}
</script>
<section class="content-header">
<h1> <?php echo $page_title; ?> <small><?php echo lang('list')?></small> </h1>
<ol class="breadcrumb">
  <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
  <li class="active">Clinics</li>
</ol>
</section>
<section class="content">
  <div class="row" style="margin-bottom:10px;">
    <div class="col-xs-12">
      <div class="btn-group pull-right"> <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new')?> </a> 
        
        <!--<a  style="margin-left:12px;"class="btn btn-danger" href="<?php echo site_url('admin/clinics/export/'); ?>"><i class="fa fa-download"></i> <?php echo lang('export')?> </a>--> 
        
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Clinics</h3>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body table-responsive" style="margin-top:40px;">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>Clinic Name</th>
                <th>Clinic address line 1</th>
                <th>Clinic address line 2</th>
                <th>Clinic Owner</th>
                <th>Phone Number</th>
                <th width="20%"><?php echo lang('action')?></th>
              </tr>
            </thead>
            <?php if(isset($clinics)):?>
            <tbody>
              <?php $i=1;foreach ($clinics as $new){?>
              <tr class="gc_row">
                <td><?php echo $i?></td>
                <td><?php echo ucwords($new->clinic_name);?></td>
                <td><?php echo $new->clinic_address_line_1; ?></td>
                <td><?php echo $new->clinic_address_line_2; ?></td>
                <td><?php echo ucwords($new->clinic_owner)?></td>
                <td><?php echo ucwords($new->clinic_phone_number)?></td>
                <td nowrap="nowrap" width="30%"><div class="btn-group"> <a class="btn btn-default" style="margin-left:7px;" href="#view<?php echo $new->clinic_id ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view')?></a> <a class="btn btn-primary"  style="margin-left:7px;" href="#edit<?php echo $new->clinic_id ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a> <a class="btn btn-danger" style="margin-left:7px;" href="<?php echo site_url('admin/clinics/deleteClinic/'.$new->clinic_id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a> </div></td>
              </tr>
              <?php $i++;}?>
            </tbody>
            <?php endif;?>
          </table>
        </div>
        <!-- /.box-body --> 
      </div>
      <!-- /.box --> 
    </div>
  </div>
</section>
<?php if(isset($clinics)):?>
<?php $i=1;
foreach ($clinics as $new){
$clinic_details 	= 	$this->doctor_model->get_clinic_by_id($new->clinic_id);

?>
<!-- Modal -->
<div class="modal fade" id="view<?php echo $new->clinic_id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="viewlabel"><?php echo lang('edit');?> <?php echo lang('patient')?></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <?php
			  foreach($clinic_details as $key => $value){
				  
				  $doNotShow = array('clinic_id','clinic_speciality_id','clinic_owner_id','clinic_invoice','clinic_latitude','clinic_longitude','is_deactivated','clinic_timezone','clinic_created_at');
				  if(!in_array($key,$doNotShow)){
				  ?>
          <div class="row">
            <div class="col-md-4">
              <label for="name" style="clear:both;"><?php echo ucwords(str_replace("_"," ",$key));?></label>
            </div>
            <div class="col-md-8">
              <?php 
					   if($key == 'clinic_image_url')
					   	echo '<img src="'.$value.'">';
					   else
					   	echo $value;					   
					   ?>
            </div>
          </div>
          <?php
				  }
			  }
			  ?>
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
<?php if(isset($clinics)):?>
<?php $i=1;
foreach ($clinics as $new){
$clinic_details 	= 	$this->doctor_model->get_clinic_by_id($new->clinic_id);
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new->clinic_id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content ff">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> Clinic</h4>
</div>
<div class="modal-body">
<div id="err_edit<?php echo $new->clinic_id?>">
  <?php 
			if(validation_errors()){
		?>
  <div class="alert alert-danger alert-dismissable"> <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
    <b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?> </div>
  <?php  } ?>
</div>
<form method="post">
  <input type="hidden" name="id" value="<?php echo $new->clinic_id; ?>" />
  <div class="box-body">
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic Name</label>
          <input type="text" name="clinic_name" value="<?php echo $clinic_details->clinic_name?>" class="form-control name">
        </div>
      </div>
    </div>    
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="contact" style="clear:both;">Clinic address line 1</label>
          <textarea name="clinic_address_line_1"  class="form-control name clinic_address_line_1"><?php echo $clinic_details->clinic_address_line_1?></textarea>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="contact" style="clear:both;">Clinic address line 2</label>
          <textarea name="clinic_address_line_2"  class="form-control name clinic_address_line_2"><?php echo $clinic_details->clinic_address_line_2?></textarea>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic City</label>
          <input type="text" name="clinic_city" value="<?php echo $clinic_details->clinic_city?>" class="form-control name">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic State</label>
          <input type="text" name="clinic_state" value="<?php echo $clinic_details->clinic_state?>" class="form-control name">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic Pincode</label>
          <input type="text" name="clinic_pincode" value="<?php echo $clinic_details->clinic_pincode?>" class="form-control name">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic Landmark</label>
          <input type="text" name="clinic_landmark" value="<?php echo $clinic_details->clinic_landmark?>" class="form-control name">
        </div>
      </div>
    </div>
    
     <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic phone number</label>
          <input type="text" name="clinic_phone_number" value="<?php echo $clinic_details->clinic_phone_number?>" class="form-control name">
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic Owner</label>          
          <?php 
		  $CI = get_instance();
		  $result = $CI->db->query("SELECT id,name FROM users WHERE user_role=1 ORDER BY name ASC;")->result();
		  ?>
          <select name="clinic_owner_id" class="form-control name clinic_owner_id">
          <?php
		  foreach ($result as $doc){
			  if($clinic_details->clinic_owner_id == $doc->id)
			  	echo '<option selected="selected" data-name="'.$doc->name.'" value="'.$doc->id.'">'.$doc->name.' ('.$doc->id.')</option>';
			  else
			  	echo '<option value="'.$doc->id.'" data-name="'.$doc->name.'">'.$doc->name.' ('.$doc->id.')</option>';
		  }
		  ?>          
         </select>
         <input type="hidden" id="clinic_owner" name="clinic_owner" value="<?php echo $clinic_details->clinic_owner?>" class="form-control name">
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic email</label>
          <input type="text" name="clinic_email" value="<?php echo $clinic_details->clinic_email?>" class="form-control name">
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic open time</label>
          <input type="text" name="clinic_open_time" value="<?php echo $clinic_details->clinic_open_time?>" class="form-control name">
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <div class="row">
        <div class="col-md-8">
          <label for="name" style="clear:both;">Clinic close time</label>
          <input type="text" name="clinic_close_time" value="<?php echo $clinic_details->clinic_close_time?>" class="form-control name">
        </div>
      </div>
    </div>
    
   
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary update" name="update"><?php echo lang('update')?></button>
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
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content ff">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> Clinic</h4>
    </div>
    <div class="modal-body">
      <div id="err">
        <?php 
			if(validation_errors()){
		?>
        <div class="alert alert-danger alert-dismissable"> <i class="fa fa-ban"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
          <b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?> </div>
        <?php  } ?>
      </div>
      <form method="post" id="add_form" >
        <div class="box-body">
          
          <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic Name</label>
                  <input type="text" name="clinic_name" value="" class="form-control name">
                </div>
              </div>
            </div>    
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="contact" style="clear:both;">Clinic address line 1</label>
                  <textarea name="clinic_address_line_1"  class="form-control name clinic_address_line_1"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="contact" style="clear:both;">Clinic address line 2</label>
                  <textarea name="clinic_address_line_2"  class="form-control name clinic_address_line_2"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic City</label>
                  <input type="text" name="clinic_city" value="" class="form-control name">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic State</label>
                  <input type="text" name="clinic_state" value="" class="form-control name">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic Pincode</label>
                  <input type="text" name="clinic_pincode" value="" class="form-control name">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic Landmark</label>
                  <input type="text" name="clinic_landmark" value="" class="form-control name">
                </div>
              </div>
            </div>
            
             <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic phone number</label>
                  <input type="text" name="clinic_phone_number" value="" class="form-control name">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic Owner</label>          
                  <?php 
                  $CI = get_instance();
                  //$result = $CI->db->query("SELECT id,username,name FROM doctor WHERE 1=1 ORDER BY name ASC;")->result();
				  $result = $CI->db->query("SELECT id,name FROM users WHERE user_role=1 ORDER BY name ASC;")->result();
                  ?>
                  <select name="clinic_owner_id1" class="form-control name clinic_owner_id1">
                  <?php
                  foreach ($result as $doc){
                      echo '<option value="'.$doc->id.'" data-name="'.$doc->name.'">'.$doc->name.' ('.$doc->id.')</option>';
                  }
                  ?>          
                 </select>
                 <input type="hidden" id="clinic_owner1" name="clinic_owner1" value="" class="form-control name">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic email</label>
                  <input type="text" name="clinic_email" value="" class="form-control name">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic open time</label>
                  <input type="text" name="clinic_open_time" value="" class="form-control name">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="row">
                <div class="col-md-8">
                  <label for="name" style="clear:both;">Clinic close time</label>
                  <input type="text" name="clinic_close_time" value="" class="form-control name">
                </div>
              </div>
            </div>
    
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script> 
<script type="text/javascript">
$( "#add_form" ).submit(function( event ) {
	var form = $(this).closest('form');
	clinic_name = $(form ).find('input[name=clinic_name]').val();
	
	clinic_address_line_1 = $(form ).find('.clinic_address_line_1').val();
	clinic_address_line_2 = $(form ).find('.clinic_address_line_2').val();
	
	
	clinic_city = $(form ).find('input[name=clinic_city]').val();
	clinic_state = $(form ).find('input[name=clinic_state]').val();
	clinic_pincode = $(form ).find('input[name=clinic_pincode]').val();
	clinic_landmark = $(form ).find('input[name=clinic_landmark]').val();
	clinic_phone_number = $(form ).find('input[name=clinic_phone_number]').val();	
	clinic_owner_id = $(form ).find('.clinic_owner_id1').val();
	
	clinic_owner = $('#clinic_owner1').val();
	//clinic_owner = $('.clinic_owner_id').find(':selected').attr('data-name');
	
	clinic_email = $(form ).find('input[name=clinic_email]').val();
    clinic_open_time = $(form ).find('input[name=clinic_open_time]').val();
	clinic_close_time = $(form ).find('input[name=clinic_close_time]').val();
	//alert(blood_id);return false;
	
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/clinics/add') ?>',
		type:'POST',
		data:{clinic_name:clinic_name,clinic_address_line_1:clinic_address_line_1,clinic_address_line_2:clinic_address_line_2,clinic_city:clinic_city,clinic_state:clinic_state,clinic_pincode:clinic_pincode,clinic_landmark:clinic_landmark,clinic_phone_number:clinic_phone_number,clinic_owner:clinic_owner,clinic_owner_id:clinic_owner_id, clinic_email:clinic_email, clinic_open_time:clinic_open_time, clinic_close_time:clinic_close_time},
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
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
	clinic_name = $(form ).find('input[name=clinic_name]').val();
	
	clinic_address_line_1 = $(form ).find('.clinic_address_line_1').val();
	clinic_address_line_2 = $(form ).find('.clinic_address_line_2').val();
	
	
	clinic_city = $(form ).find('input[name=clinic_city]').val();
	clinic_state = $(form ).find('input[name=clinic_state]').val();
	clinic_pincode = $(form ).find('input[name=clinic_pincode]').val();
	clinic_landmark = $(form ).find('input[name=clinic_landmark]').val();
	clinic_phone_number = $(form ).find('input[name=clinic_phone_number]').val();	
	clinic_owner_id = $(form ).find('.clinic_owner_id').val();
	
	clinic_owner = $('#clinic_owner').val();
	//clinic_owner = $('.clinic_owner_id').find(':selected').attr('data-name');
	
	clinic_email = $(form ).find('input[name=clinic_email]').val();
    clinic_open_time = $(form ).find('input[name=clinic_open_time]').val();
	clinic_close_time = $(form ).find('input[name=clinic_close_time]').val();
	//alert(blood_id);return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/clinics/edit') ?>/' + id,
		type:'POST',
		data:{clinic_name:clinic_name,clinic_address_line_1:clinic_address_line_1,clinic_address_line_2:clinic_address_line_2,clinic_city:clinic_city,clinic_state:clinic_state,clinic_pincode:clinic_pincode,clinic_landmark:clinic_landmark,clinic_phone_number:clinic_phone_number,clinic_owner:clinic_owner,clinic_owner_id:clinic_owner_id, clinic_email:clinic_email, clinic_open_time:clinic_open_time, clinic_close_time:clinic_close_time},
		
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					location.reload(); 
				}else
				{
					$("#overlay").hide();
					$('#err_edit'+id).html(result);
				}
		  
		 }
	  });
	
	
});


$(function() {
	$('#example1').dataTable({
	});
});

/*function setOwnerName(obj){
	var name = obj.attr("data-name");
	$("#clinic_owner").val(name);
}*/

$('.clinic_owner_id1').on('change', function (e) {
    //var optionSelected = $("option:selected", this);
    //var valueSelected = this.value;
    var name = $(this).find(':selected').attr('data-name');
	console.log('Name : '+name);
	$("#clinic_owner1").val(name);
});
$('.clinic_owner_id').on('change', function (e) {
    //var optionSelected = $("option:selected", this);
    //var valueSelected = this.value;
    var name = $(this).find(':selected').attr('data-name');
	console.log('Name : '+name);
	$("#clinic_owner").val(name);
});
</script>