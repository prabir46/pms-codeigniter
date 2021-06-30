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
<div class=""  tabindex="-1" role="dialog" aria-labelledby="addlabel">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" onclick="clos()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"  onclick="clos()">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('update');?> </h4>
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
                <form method="post" action="<?php echo site_url('admin/inventory_management_order/update/'.$ids)?>" enctype="multipart/form-data">

                    <div class="box-body">
                        <div class="form-group" style="margin-top:20px;">
                            <legend><?php echo lang('inventory_management')?></legend>
                        </div>
                        <div class="form-group" style="margin-top:20px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('name')?></b>
                                </div>
                                <div class="col-md-4">

                                    <input type="text" name="name" value="<?php echo $inventory_management->name; ?>" class="form-control name" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('quantity')?></b>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="quantity" value="<?php echo $inventory_management->quantity; ?>" class="form-control quantity" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('supplier')?></b>
                                </div>
                                <div class="col-md-4">
                                    <select name="supplier" class="form-control chzn patient supplier "  >
                                        <?php foreach($name as $new) {
                                            $sel = "";
                                            $contact_id=$inventory_management->supplier;
                                            if(set_select('supplier', $new->id)) $sel = "selected='selected'";
                                            echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="dates" value="<?php echo $inventory_management->date; ?>" class="form-control datetimepicker">
                                </div>
                            </div>
                        </div>



                        <?php
                        if($fields){
                        foreach($fields as $doc){
                        $output = '';
                        if($doc->field_type==1) //testbox
                        {
                        ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control reply" name="reply[<?php echo $doc->id ?>]" />
                                </div> </div>
                        </div>
                    </div>
                    <?php 	}
                    if($doc->field_type==2) //dropdown list
                    {
                    $values = explode(",", $doc->values);
                    ?>	<div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                            </div>
                            <div class="col-md-4">
                                <select name="reply[<?php echo $doc->id ?>]" class="form-control">
                                    <?php
                                    foreach($values as $key=>$val) {
                                        echo '<option value="'.$val.'">'.$val.'</option>';
                                    }
                                    ?>
                                </select>
                            </div> </div>
                    </div>
            </div>
            <?php	}
            if($doc->field_type==3) //radio buttons
            {
            $values = explode(",", $doc->values);
            ?>	<div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                    </div>
                    <div class="col-md-4">

                        <?php
                        foreach($values as $key=>$val) { ?>

                            <input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
                        <?php 			}
                        ?>
                    </div> </div>
            </div>
        </div>

        <?php }
        if($doc->field_type==4) //checkbox
        {
        $values = explode(",", $doc->values);
        ?>	<div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                </div>
                <div class="col-md-4">
                    <?php
                    foreach($values as $key=>$val) { ?>

                        <input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" class="form-control" />	<?php echo $val;?>&nbsp; &nbsp; &nbsp; &nbsp;
                    <?php 			}
                    ?>
                </div> </div>
        </div>
    </div>
    <?php }	if($doc->field_type==5) //Textarea
    {		?>	<div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
            </div>
            <div class="col-md-4">
										<textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea
                                        >


<?php
}
}
}
?>

<div class="box-footer">
    <button  type="submit" class="btn btn-primary"><?php echo lang('update')?></button>
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
    $(function() {
        $('#example1').dataTable({
        });
        $('.chzn').chosen({search_contains:true});
    });

    function clos(){
        window.location.assign("http://doctori8.com/doctor/admin/inventory_management");
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

    $( "#add_form" ).submit(function( event ) {

        var form = $(this).closest('form');
        name = $(form ).find('.name').val();
        quantity = $(form ).find('.quantity').val();
        supplier = $(form ).find('.supplier').val();
        dates =$(form ).find('.datetimepicker').val();


        call_loader_ajax();
        $.ajax({
            url: '<?php echo base_url('admin/inventory_management_order/update/'.$ids) ?>',
            type:'POST',
            data:{name:name,quantity:quantity,supplier:supplier,dates:dates},
            success:function(result){

                if(result==1)
                {

                    //alert("value=0");
                    //$('#myModal').fadeOut(500);
                    $('#add').modal('hide');
                    window.close();
                    location.reload();
                    window.location.assign("http://doctori8.com/doctor/admin/inventory_management");
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
        invoice_no = $(form ).find('.invoice_no').val();
        amount= $(form ).find('.amount').val();
        payment_mode_id = $(form ).find('.payment_mode_id').val();
        date = $(form ).find('.date').val();
        payment_for = $(form ).find('.payment_for').val();
        balance = $(form ).find('.balance').val();
        //alert(amount);return false;
        call_loader_ajax();
        $.ajax({
            url: '<?php echo base_url('admin/payment/edit_payment') ?>/' + id,
            type:'POST',
            data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date,payment_for:payment_for,balance:balance},
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

                $(".chzn").chosen();
            }
        });
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
        format:'y-m-d H:i:00'
    });
</script>