<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active">SMS Management</li>
        </ol>
</section>

<section class="content">
  	  	 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                   
<div class="button_set pull-right">
    	<!--<a class="btn btn-default" href=""><i class="icon-plus-sign"></i> <?php echo lang('add_new');?></a>-->
</div>          

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
            <th>Type</th>
            <th>Language</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($sms as $new): ?>
        <tr class="gc_row">
            <td><?php $type=$new['type']; if($type=='instant') echo "Instant Message"; 
                        else if($type=='doctor') echo "Reminder for Doctor"; 
                        else echo "Reminder for Patient"; ?></td>
            <td><?php echo ucfirst($new['lang']); ?></td>
            <td><?php $enable = $new['status']; if($enable==0) echo "Disabled"; else echo "Enabled"; ?>
            <td>
                <span class="btn-group">
                    <a class="btn btn-default" data-toggle="modal" href="#edit<?php echo $new['id']; ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
                   
                </span>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if(isset($sms)):?>
<?php $i=1;
foreach ($sms as $new){

?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel">Manage SMS</h4>
      </div>
      <div class="modal-body">
	  <div id="err_edit<?php $name->id ?>">  
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
		<?php echo form_open_multipart('admin/settings/sms_edit/'.$new['id']); ?>
                    <div class="box-body">
                        <input type="hidden" name="id" value="<?php echo $new['id']?>" />
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label style="clear:both;"><b>Service</b></label>
									<input type="hidden" name="type" value="<?php echo $new['type']; ?>" class="form-control name">    
                                </div>
                                <div class="col-md-4">
                                    <?php if($new['type']=='instant') echo 'Instant Messages'; else if ($new['type']=='doctor') echo 'Reminder for Doctor'; else echo 'Reminder for Patient'; ?>
                                </div>
                            </div>

                        	<div class="row">
                                <div class="col-md-2">
                                    <label style="clear:both;"><b>Status</b></label>
									
                                </div>
                                <div class="col-md-4">
                                    
                                    <input type="radio" id="enable" name="status" value="1" class="form-control name" <?php if($new['status']=='1') echo 'checked'; ?> >
<label for="enable">Enabled</label>
                                    <input type="radio" id="disable" name="status" value="0" class="form-control name" <?php if($new['status']=='0') echo 'checked'; ?> >
<label for="disable">Disabled</label>   
                                </div>
                            </div>


                        	<div class="row">
                                <div class="col-md-2">
                                    <label style="clear:both;"><b>Language</b></label>
									
                                </div>
                                <div class="col-md-4">
                                    <select name="lang" class="form-control">
                                         <option value="english" <?php if($new['lang']=='english') echo 'selected="selected"'; ?> >English</option>
                                         <option value="hindi" <?php if($new['lang']=='hindi') echo 'selected="selected"'; ?> >Hindi</option>
                                         <option value="bengali" <?php if($new['lang']=='bengali') echo 'selected="selected"'; ?> >Bengali</option>
                                         <option value="telugu" <?php if($new['lang']=='telugu') echo 'selected="selected"'; ?> >Telugu</option>
                                         <option value="marathi" <?php if($new['lang']=='marathi') echo 'selected="selected"'; ?> >Marathi</option>
                                    </select>
                                </div>
                            </div>

                        </div>
						
						
						
			   			
                     	
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary update"><?php echo lang('update');?></button>
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

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
function areyousure()
{
    return confirm('<?php echo lang('are_you_sure');?>');
}
</script>