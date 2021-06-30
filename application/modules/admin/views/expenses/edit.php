<!-- form start -->
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
<center>
<form method="post" action="<?php echo site_url('admin/expenses/edit_new/');?>" enctype="multipart/form-data" id="add_form">

    <div class="box-body">

        <div class="form-group" style="margin-top:20px;">
            <div class="row">
                <div class="col-md-3">
                    <b>Date</b>
                </div>
                <div class="col-md-4">
                    <input type="text" name="date" class="form-control datetimepicker" value="<?php echo $new->date;?>" readonly/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <b>Amount</b>
                </div>
                <div class="col-md-4">
                    <input type="text" name="amount" class="form-control" value="<?php echo $new->amount;?>" />
                </div>
            </div>
        </div>
        <input type="hidden" name="id" class="form-control" value="<?php echo $new->id;?>"/>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <b>Details</b>
                </div>
                <div class="col-md-4">
                    <input type="text" name="details" class="form-control" value="<?php echo $new->details;?>"/>
                </div>
            </div>
        </div>
</center>

        <div class="box-footer">
            <div class="row">
                <div class="col-md-6" align="right">
            <button  type="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-md-6">
                    <a href="<?php echo  base_url('admin/expenses/');?>" class="btn btn-danger" role="button">Cancel</a>
                </div>
            </div>
        </div>
</form>

<script>
$(function() {
$('#example1').dataTable({
});
$('.chzn').chosen({search_contains:true});
});


$( "#add_form" ).submit(function( event ) {

call_loader_ajax();
$.ajax({
url: '<?php echo base_url('admin/expenses/edit_new/') ?>',
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
