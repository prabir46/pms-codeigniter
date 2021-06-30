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
            <small><?php echo lang('edit');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active"><?php echo lang('lab_management');?></li>
        </ol>
</section>


<!-- Add Payment-->
<div class="" id="" tabindex="-1" role="dialog" aria-labelledby="addlabel">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" onclick="clos()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> </h4>
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
				<form method="post" action="" enctype="multipart/form-data" id="add_app">
			
			        <div class="box-body">
                      <div class="form-group" style="margin-top:20px;"> 
							 <legend><?php echo lang('lab_management')?></legend>  
					    </div>                
		<input type="hidden" name="hidden_id" class="hidden_id" value="<?php echo @$id;?>" />
		<input type="hidden" name="hidden_type_id" class="hidden_type_id" value="<?php echo $_GET['type_id'];?>" />
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
                                    <label for="name" style="clear:both;"><?php echo lang('consultant');?></label>
<div class="controls">
									   <select name="consultant" class="form-control chzn consultant_id " onchange="color_change(this)">
											<option id="" value="1">Select Consultant </option>
											<?php foreach($consultant_copy as $new) {
													$sel = "";
		if($consultant==$new->id) $sel = "selected='selected'";
		echo '<option  id="'.$new->Color.'" value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                               </div>
		  </div>	
		</div>              
		<br/>
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
<br/
						
						 <div class="form-group col-md-12">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
									   <select name="whom" class="form-control chzn whom" >
							
											<option value="1"><?php echo lang('patient');?></option>
							
										
										</select>
                                </div>
							
                            </div>
                        </div>
						
						 <div class="form-group patient col-md-12">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									   <select name="patient_id" class="form-control chzn patient_id">
								
											 <?php foreach($pateints as $new1) {	
														if($ids==$new1->id){ 
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

						 <div class="control-group motive col-md-12">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><b><?php echo ('Reason')?></b></label>
									 <select name="motive" class="form-control chzn">
												<option value="">--<?php echo lang('treatment_advised');?>--</option>
                                              
												<?php foreach($treatment_Advised as $new) {
														$sel = "";
	
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									<!--<textarea name="motive" class="form-control motive" style="width:60%"><?php if($followup==''){echo @$motive;}else{ } ?> </textarea> -->
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group col-md-12">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('is_paid')?></label>
<br/>
									<input type="checkbox" name="is_paid" value="1" class="is_paid" /> <label for="name" style="clear:both;"><?php echo 'Send Message'?></label>
					            </div>
                            </div>
                        </div>
						
            
                    <div class="box-footer col-md-12">
                         <button type="submit" class="btn btn-primary" name="ok" value="ok"><?php echo lang('save');?></button>
                    </div>
			</form>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clos()"><?php echo lang('close')?></button>  
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
function color_change(ddlFruits){

selectedText = ddlFruits.options[ddlFruits.selectedIndex].id;
document.getElementById("colorvalue").value=selectedText;
}
$(function() {
	$('#example1').dataTable({
	});
	$('.chzn').chosen({search_contains:true});
});

function clos(){
window.location.assign("doctor/admin/lab_management");
}
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

$( "#add_app" ).submit(function( event ) {
	//title 		= $('input[name=title]').val();
	var form = $(this).closest('form');
	consultant = $(form ).find('.consultant').val();
	colorvalue = $(form ).find('#colorvalue').val();
	title = $(form ).find('.title').val();
	whom 		= $(form ).find('.whom').val();
	patient_id 	= $(form ).find('.patient_id').val();
	contact_id 	= '';
	other	   	= '';
	date_time	= $(form ).find('.date_time').val();
	notes 		= $(form ).find('.notes').val();
	motive 		= $(form ).find('.motive').val();
	is_paid 		= $(form ).find('.is_paid:checked').val();
	//alert(consultant); return false;
	
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/datafeed?method=adddetails') ?>',
		type:'POST',
		data: $("#add_app").serialize(),
		dataType: "json",
		success:function(data){
                   alert(data.Msg);
		}

	  });
	
	event.preventDefault();
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