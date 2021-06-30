<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<link href="<?php echo base_url('assets/')?>/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/wd/')?>/css/dailog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/wd/')?>/css/calendar.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url('assets/wd/')?>/css/dp.css" rel="stylesheet" type="text/css" />   
<link href="<?php echo base_url('assets/wd/')?>/css/alert.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url('assets/wd/')?>/css/main.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url('assets/wd/')?>/css/colorselect.css" rel="stylesheet" />   
<script src="<?php echo base_url('assets/wd/js/')?>/color.js" type="text/javascript"></script>   
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.validate.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/')?>/datepicker_lang_US.js" type="text/javascript"></script>        
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.datepicker.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.dropdown.js" type="text/javascript"></script>     

<link href="<?php echo base_url('assets/wd/')?>/css/main.css" rel="stylesheet" type="text/css" />       
<link href="<?php echo base_url('assets/wd/')?>/css/dp.css" rel="stylesheet" />    
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<style>

.color-box {
    display: inline-block;
    width: 15px;
    height: 15px;
    border: solid 1px #555555;
    vertical-align: top;
    margin-top: 2px;
    margin-left: 5px;
}

</style>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
<script src="<?php echo base_url('assets/js/')?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/wd/js/')?>/Common.js" type="text/javascript"></script>    
<script src="<?php echo base_url('assets/wd/js/')?>/datepicker_lang_US.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.datepicker.js" type="text/javascript"></script>

<script src="<?php echo base_url('assets/wd/js/')?>/jquery.alert.js" type="text/javascript"></script>    
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
<script src="<?php echo base_url('assets/wd/js/')?>/wdCalendar_lang_US.js" type="text/javascript"></script>    
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.calendar.js" type="text/javascript"></script>   
    	
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
                    <a  id="faddbtn" class="fbutton btn btn-default" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
                </div>
            </div>    
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                
				
				
				 <div class="box-body table-responsive" style="margin-top:40px;">
 <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('name');?></th>
				<th>Color</th>
								
				<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                      <?php if(isset($consultant)):?>
			<tbody>

                            <?php $i=1;foreach ($consultant as $new){	?>
	
							   <td><?php echo  $new->name; ?></td>
								   <td>
<?php echo $new->Color; ?></td>
								   <td width="25%">
                                        <div class="btn-group">
										
										 <a class="btn btn-primary remove" href="#edit<?php echo @$new->id; ?>" id="<?php echo @$new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/consultant/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i><?php echo lang('delete');?></a>
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
<div id="consultant_add" title="Consultant Add">
	<div id="consultant_inner_add"></div>
</div>	

<div id="consultant_edit" title="Consultant Edit">
	<div id="consultant_inner_edit"></div>
</div>	
	 <script type="text/javascript">
var calendar_id_edit=0;
   $(document).ready(function() {
        $("#faddbtn").click(function(e) {
        
            calendar_id = 0;
            calendar_data = [];
            $('#consultant_add').dialog('open');
           call_loader_ajax();
		    
        });
            $(".remove").click(function() {
    var ids = $(this).attr('id'); 
     
       
        //alert(ids);
             calendar_id = 0;
            calendar_id_edit = ids;
            calendar_data = [];
            $('#consultant_edit').dialog('open');
           call_loader_ajax();
});
            
        });
    </script>	
        
 <script>
         // scripts to open the modal window for our event editing:
	$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
		options.async = true;
	});

    var calendar_id = 0; // currently editing calendar event id?
    var calendar_data = []; // currently editing calendar event id?
	
	
	
	
	
	 $(function(){	
		
		$("#consultant_add").dialog({
			autoOpen: false,
			height: 600,
			width: 500,
			modal: true,
			buttons: {
				'Add': function() {
					
					$.ajax({
						type: 'POST',
                     	 url: '<?php echo site_url('admin/consultant/add_form')?>?method=add_form',
						data: $('#calendar_event_form').serialize(),
                        dataType: 'html',
						success: function(d){
							alert(d);
                            // refresh the calender with these new changes
if(d=="Consultant Succefully Added"){
                            $("#consultant_add").dialog('close');
                            $("#gridcontainer").reload();
                            location.reload();
}
						//console.log(d.Msg);
						message = JSON.parse(d);
						alert(message.Msg);
						},
                        error: function (header, status, error) {
                            console.log('ajax answer post returned error ' + header + ' ' + status + ' ' + error);
                        }
					});
				},
                'Cancel': function() {
					$('.xdsoft_noselect').hide();
					$(this).dialog('close');
					
				}
			},
			open: function(){
                var calendar_data_for_post = {};
                if(typeof calendar_data[0] != 'undefined'){
                    calendar_data_for_post['calendar_id'] = calendar_data[0];
                }
                if(typeof calendar_data[1] != 'undefined'){
                    calendar_data_for_post['title'] = calendar_data[1];
                }
                if(typeof calendar_data[2] != 'undefined'){
                    calendar_data_for_post['start_date_time'] = calendar_data[2];
                }
                if(typeof calendar_data[3] != 'undefined'){
                    calendar_data_for_post['end_date_time'] = calendar_data[3];
                }
                if(typeof calendar_data[4] != 'undefined'){
                    calendar_data_for_post['is_all_day'] = calendar_data[4];
                }
				$.ajax({
					type: "POST",
                		url: '<?php echo site_url('admin/consultant/add')?>?id='+calendar_data[0]+'&start='+calendar_data[2]+'&end='+calendar_data[2]+'&isallday='+calendar_data[4]+'&title='+calendar_data[1]+'&type_id=1',
                  
                    data: calendar_data_for_post,
					dataType: "html",
					success: function(d){

						$("#overlay").remove();
                        $('#consultant_inner_add').html(d);
                        
					}
				});
			},
			close: function() {
				$('#consultant_inner_add').html('');
			
			}
		});
		 



		}); 
 $(function(){	
$("#consultant_edit").dialog({
			autoOpen: false,
			height: 600,
			width: 500,
			modal: true,
			buttons: {
				'Edit': function() {
					
					$.ajax({
						type: 'POST',
                     	 url: '<?php echo site_url('admin/consultant/edit_form')?>?method=add_form',
						data: $('#calendar_event_form').serialize(),
                        dataType: 'html',
						success: function(d){
							alert(d);
                            // refresh the calender with these new changes
if(d=="Consultant Succefully Updated"){
                            $("#consultant_edit").dialog('close');
                            $("#gridcontainer").reload();
                            location.reload();
}
						//console.log(d.Msg);
						message = JSON.parse(d);
						alert(message.Msg);
						},
                        error: function (header, status, error) {
                            console.log('ajax answer post returned error ' + header + ' ' + status + ' ' + error);
                        }
					});
				},
                'Cancel': function() {
					$('.xdsoft_noselect').hide();
					$(this).dialog('close');
					
				}
			},
			open: function(){
                var calendar_data_for_post = {};
                if(typeof calendar_data[0] != 'undefined'){
                    calendar_data_for_post['calendar_id'] = calendar_data[0];
                }
                if(typeof calendar_data[1] != 'undefined'){
                    calendar_data_for_post['title'] = calendar_data[1];
                }
                if(typeof calendar_data[2] != 'undefined'){
                    calendar_data_for_post['start_date_time'] = calendar_data[2];
                }
                if(typeof calendar_data[3] != 'undefined'){
                    calendar_data_for_post['end_date_time'] = calendar_data[3];
                }
                if(typeof calendar_data[4] != 'undefined'){
                    calendar_data_for_post['is_all_day'] = calendar_data[4];
                }

				$.ajax({
					type: "POST",
                		url: '<?php echo site_url('admin/consultant/add')?>?id='+calendar_id_edit+'&type_id=2',
                  
                    data: calendar_data_for_post,
					dataType: "html",
					success: function(d){

						$("#overlay").remove();
                        $('#consultant_inner_edit').html(d);
                       
					}
				});
			},
			close: function() {
				$('#consultant_inner_edit').html('');
			
			}
		});
});
	
 </script>
 
 
 