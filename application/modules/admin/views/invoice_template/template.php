<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Manage Invoice
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
      
        <li class="active">Manage Invoice</li>
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
	   
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                   
                </div><!-- /.box-header -->
                <!-- form start -->
				
			
				<form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/manage_invoice/')?>"
                    <div class="box-body">
                       
                       <div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('header');?></label>
								</div>	
                                <div class="col-md-8">
                                <?php if(strpos($template->header,'http://')===false && strpos($template->header,'https://')===false){
							echo '<textarea name="header" class="form-control redactor">'.$template->header.'</textarea>'; }else{ 
echo '
<img src="'.$template->header.'" height="200px" width="100%" />'; } ?>
                                </div>
                            </div>
                        </div>

                       <div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <label for="name" style="clear:both;">Enter Text</label>
								</div>	
                                <div class="col-md-8">
                                    <input type="text" name="header" class="form-control redactor" />

                                </div>
                            </div>
                        </div>

                       <div class="row">
                                 <div class="col-md-2 col-md-offset-5">
                                        <h4 class="text-center">OR</h4>
                                 </div>
                       </div>
                       <div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <label for="name" style="clear:both;">Upload an Image</label>
								</div>	
                                <div class="col-md-8">
                                    <input type="file" name="header_file" class="form-control" />

                                </div>
                            </div>
                        </div>
                        
                         <div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('footer');?></label>
								</div>	
                                <div class="col-md-8">
                                    
									<textarea name="footer"class="form-control redactor"><?php echo @$template->footer; ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        
                        
						
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
             </form>
            </div><!-- /.box -->
        </div>
     </div>
</section>  

<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/redactor.min.js')?>"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});

</script>
<script>
  $(document).ready(function(){
    $('.redactor').redactor({
	buttons:['html', 'formatting', 'bold', 'italic', 'deleted',
'unorderedlist', 'orderedlist', 'outdent', 'indent',
 'alignment', 'horizontalrule'],
	removeEmpty: ['strong', 'em', 'span', 'p'],
			link:false,
			insertVideo:false,
			image_web_link:false,
            
      });
	
});
  </script>
