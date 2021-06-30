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
<style>
.chosen-container{width:60% !important} 
#divcalendarcolor{z-index:10000000000000000000000000000000 !important}
</style>    
    <script type="text/javascript">
        $(function() {
				$('.chzn').chosen({search_contains:true});
		});
		if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        function getHM(date)
        {
             var hour =date.getHours();
             var minute= date.getMinutes();
             var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
             return ret;
        }
        $(document).ready(function() {
            //debugger;
            var DATA_FEED_URL = "<?php echo site_url('admin/datafeed')?>";
            var arrT = [];
            var tt = "{0}:{1}";
          
// changed the range from a full twenty four hours to from the hours 9a to 9p if (i >= 9 && i <= 21)
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00").hide();
                    $("#etparttime").val("00:00").hide();
                }
                else {
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(getHM(d)).show();
                    $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
            }
            $("#Savebtn").click(function() { $("#calendar_event_form").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
                 if (confirm("Are you sure to remove this event")) {  
				 	id =  $(".hidden_id").val();
					type_id =  $(".hidden_type_id").val();
                    var param = [{ "name": "id", value: id},{ "name": "type_id", value: type_id}];                
                   $.post(DATA_FEED_URL + "?method=remove",
                        param,
						
                        function(data){
                              if (data.IsSuccess) {
                                    alert(data.Msg); 
                                    CloseModelWindow(null,true);                            
                                }
                                else {
                                    alert("Error occurs.\r\n" + data.Msg);
                                }
                        }
                    ,"json");
                }
            });
         $(document).ready(function(){         
           $("#stpartdate,#etpartdate").datetimepicker({format:'m/d/Y',timepicker:false,});    
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                    return true;
                },
                dataType: "json",
                success: function(data) {
                    alert(data.Msg);
                    if (data.IsSuccess) {
                        CloseModelWindow(null,true);  
                    }
                }
            };
		
            $.validator.addMethod("date", function(value, element) {                             
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year,month,day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
            $.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
            }, "Invalid time format");
            $.validator.addMethod("safe", function(value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, "$<> not allowed");
            $("#calendar_event_form").validate({
                submitHandler: function(form) { $("#calendar_event_form").ajaxSubmit(options); },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
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
	  
	  	@$start =  explode(' ',$_GET['start']);
		@$end =  explode(' ',$_GET['end']);
	  //	echo '<pre>'; print_r($_GET);die;
	  ?>        
	  
	
	 <form action="<?php echo site_url('admin/consultant/add_form')?>?method=add_form" class="fform" id="calendar_event_form1" method="post">                 
             <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"> Name</label>
									<input type="text" name="name" id="Subject" value="" class="form-control name" style="height: 34px;">   <input id="colorvalue" name="colorvalue" type="hidden" value="" />   
                                </div>
                            </div>
                        </div>
    	                  
          <label>                    
            	<span>Color:</span>                    
           		 <div id="calendarcolor" class="containtdiv" title="Color"></div>
		</label>                 
          <br />

		  
		  <label style="display:none;">                    
            <span>*Time:
            </span>                    
            <div>  
              <?php 
			  if(!empty($event)){
                  $sarr = explode(" ", php2JsTime(mySql2PhpTime($starttime)));
                  $earr = explode(" ", php2JsTime(mySql2PhpTime($endtime)));
              }?>                    
			  <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate"  type="text" value="" />           
			  <input MaxLength="5" class="required time" id="stparttime" name="stparttime"  style="width:60px;"   type="text" value="" />
			 <br /><br />
      
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" type="text" value="" />                       
              <input MaxLength="5" class="required time" id="etparttime" name="etparttime" style="width:60px;" type="text" value="" />                                            
              <label class="checkp"> 
                <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1" />          All Day Event                      
              </label>                    
            </div>                
          </label>   
		                
		
	
		</form>         
      </div>         
    </div>
<script>

//$(".ui-helper-clearfix").hide();
$("#show_appointment").hide();
$("#show_hospital").hide()
$("#show_college").hide()
$(document).on('change', '.schedule_category', function(){
 var type_id = $(".schedule_category").val();
 if(type_id==1){
 
		$("#show_appointment").hide();
		$(".detail").show();
		//$(".contact").hide();
		//$(".other").hide();
 }	
 if(type_id==2){
 
		$("#show_appointment").show();
		$("#show_hospital").hide()
		$("#show_college").hide()
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 
 if(type_id==3){
 
		$("#show_appointment").hide();
		$("#show_hospital").show()
		$("#show_college").hide();
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 
 if(type_id==4){
 
		$("#show_appointment").hide();
		$("#show_hospital").hide()
		$("#show_college").show()
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 if(type_id==5){
 
		$("#show_appointment").hide();
		$("#show_hospital").hide()
		$("#show_college").hide()
		$(".detail").show();
		//$(".contact").hide();
		//$(".other").hide();
 }		

});

$(".patient").hide();
$(".detail").hide();
$(".paid").hide();
$(".contact").hide();
$(".other").hide();
$(document).on('change', '.whom', function(){
  vch = $(this).val();
  $( "div" ).removeClass( "block" );
	//alert(vch);  
	if(vch==1){
		$(".patient").show();
		$(".paid").show();
		$(".contact").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	
	if(vch==2){
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	if(vch==3){
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
		$(".show").hide();
	}

});
setTimeout(function(){ 
vch = $('.whom').val();
//alert(vch);
if(vch==1){
		
		$("#show_appointment").show();
		$(".patient").show();
		$(".paid").show();
		$(".contact").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	
	if(vch==2){
		$("#show_appointment").show();
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	if(vch==3){
		$("#show_appointment").show();
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
		$(".show").hide();
	}
 }, 100);
</script>
