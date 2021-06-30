<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script> 
<link href="<?php echo base_url('assets/wd/')?>/css/colorselect.css" rel="stylesheet" />   
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.colorselect.js" type="text/javascript"></script>   
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.validate.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/')?>/datepicker_lang_US.js" type="text/javascript"></script>        
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.datepicker.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.dropdown.js" type="text/javascript"></script>  
<script src="<?php echo base_url('assets/js/')?>/jscolor.min.js" type="text/javascript"></script>    
<style>
.chosen-container{width:60% !important} 
#divcalendarcolor{z-index:10000000000000000000000000000000 !important}
</style>    
    <script type="text/javascript">
        
       
        $(document).ready(function() {
            $("#Savebtn").click(function() { $("#calendar_event_form").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
          
         $(document).ready(function(){         
		
            function showerror(error, target) {
                var pos = target.position();
                var height = target.height();
                var newpos = { left: pos.left, top: pos.top + height + 2 }
                var form = $("#calendar_event_form");             
                error.appendTo(form).css(newpos);
            }
        });
	});		
    </script>        
   
           <?php 
if($_GET["type_id"]==2){

	$event	= $this->consultant_model->get_consultant_by_id($_GET["id"]);
//print_r($event);
	$name = $event->name;
	$id = $event->id;
        $mobile = $event->mobile;
	$color=$event->Color;
	
}
?>
	  
	
	 <form action="<?php echo site_url('admin/consultant/add_form')?>?method=add_form" class="fform" id="calendar_event_form" method="post">                 
             <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"> Name</label>
				<input type="text" name="name" id="Subject"  value="<?php echo (!empty($event))?$name:"" ?>" class="form-control name" style="height: 34px;">
<input type="hidden" name="id" id="id"  value="<?php echo (!empty($event))?$id:"" ?>" class="form-control id" style="height: 34px;">
   
                                </div>
                            </div>
                        </div>
    	                  
          <label>                    
            	<span>Color:</span>                    
           		 <input name="colorvalue" type="text" value="<?php echo (!empty($event))?$color:"" ?>" class="jscolor"/>   
		</label>  
                                    <label for="Mobile" style="clear:both;"> Phone</label>
				<input type="number" name="phone" id="Mobile"  value="<?php echo (!empty($event))?$mobile:"" ;?>" class="form-control name" style="height: 34px;width:200px;">        
          <br />

		  
		 
		                
		
	
		</form>         
      </div>         
    </div>

