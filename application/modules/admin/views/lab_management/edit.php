<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure'); ?>');
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
        <small><?php echo lang('edit'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('lab_management'); ?></li>
    </ol>
</section>


<!-- Add Payment-->
<div class="" id="" tabindex="-1" role="dialog" aria-labelledby="addlabel">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" onclick="clos()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('update'); ?> </h4>
            </div>
            <div class="modal-body">
                <div id="err">  
                    <?php
                    if (validation_errors()) {
                        ?>
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                            <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
                        </div>

                    <?php } ?>  
                </div>
                <!-- form start -->
                <form method="post" action="<?php echo site_url('admin/lab_management/update/' . $ids) ?>" enctype="multipart/form-data" id="add_form">

                    <div class="box-body">
                        <div class="form-group" style="margin-top:20px;"> 
                            <legend><?php echo lang('lab_management') ?></legend>  
                        </div>
                        <div class="form-group" style="margin-top:20px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('patient') ?></b>
                                </div>
                                <div class="col-md-4">

                                    <select name="patient_id" class="form-control chzn patient patient_id " <?php echo (!empty($p_id)) ? 'disabled' : ''; ?>  >
                                        <option value="">--<?php echo lang('select_patient'); ?>--</option>
                                        <?php
                                        foreach ($pateints as $new) {
                                            $sel = "";
                                            if ($lab_management->patient_id == $new->id)
                                                $sel = "selected='selected'";
                                            echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . ',' . $new->username . ',' . $new->contact . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('lab_select') ?></b>
                                </div>
                                <div class="col-md-4">
                                    <select name="lab_select" class="form-control chzn lab_select "  >

                                        <?php
                                        foreach ($lab_select_work as $new) {
                                            $sel = "";
                                            if ($lab_management->lab_select == $new->name)
                                                $sel = "selected='selected'";
                                            echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('lab_select_work') ?></b>
                                </div>
                                <div class="col-md-4">
                                    <textarea name="lab_select_work" class="form-control lab_select_work "><?php echo $lab_management->lab_select_work; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="display:none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('lab_payment') ?></b>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="lab_payment" value="<?php echo $lab_management->lab_payment; ?>" class="form-control lab_payment" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="order_date" style="clear:both;"><?php echo 'Order Date'; ?></label></div>
                                <div class="col-md-4">
                                    <input type="text" name="order_date"  value="<?php echo $lab_management->order_date; ?>" class="form-control datepicker date_time">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('date'); ?></label></div>
                                <div class="col-md-4">
                                    <input type="text" name="date_time" value="<?php echo $lab_management->dates; ?>" class="form-control datetimepicker date_time">
                                </div>
                            </div>
                        </div>


                        <?php
                        if ($fields) {
                            foreach ($fields as $doc) {
                                $output = '';
                                if ($doc->field_type == 1) { //testbox
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
                            <?php
                            }
                            if ($doc->field_type == 2) { //dropdown list
                                $values = explode(",", $doc->values);
                                ?>	<div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="reply[<?php echo $doc->id ?>]" class="form-control">
                                                <?php
                                                foreach ($values as $key => $val) {
                                                    echo '<option value="' . $val . '">' . $val . '</option>';
                                                }
                                                ?>			
                                            </select>	
                                        </div> </div>
                                </div>
                        </div>
                    <?php
                    }
                    if ($doc->field_type == 3) { //radio buttons
                        $values = explode(",", $doc->values);
                        ?>	<div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                </div>
                                <div class="col-md-4">

                                    <?php foreach ($values as $key => $val) { ?>

                                        <input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" />	<?php echo $val; ?> &nbsp; &nbsp; &nbsp; &nbsp;
                                    <?php }
                                    ?>			
                                </div> </div>
                        </div>
                    </div>

                <?php
                }
                if ($doc->field_type == 4) { //checkbox
                    $values = explode(",", $doc->values);
                    ?>	<div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                            </div>
                            <div class="col-md-4">
                                <?php foreach ($values as $key => $val) { ?>

                                    <input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" class="form-control" />	<?php echo $val; ?>&nbsp; &nbsp; &nbsp; &nbsp;
                                <?php }
                                ?>			
                            </div> </div>
                    </div>
                </div>
            <?php } if ($doc->field_type == 5) { //Textarea
                ?>	<div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                        </div>
                        <div class="col-md-4">
                            <textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
                            ></div>
                    </div>
                </div>
            </div>


            <?php
        }
    }
}
?>	

<div class="box-footer">
    <button  type="submit" class="btn btn-primary"><?php echo lang('update') ?></button>
</div>
</form>
</div>		  
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clos()"><?php echo lang('close') ?></button>  
</div>
</div>
</div>
</div>




<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<?php if (!empty($p_id)) { ?>
    <script>
            $(function () {
                $('#add').modal();
            });
    </script>

<?php } ?>

<script type="text/javascript">
    $(function () {
        $('#example1').dataTable({
        });
        $('.chzn').chosen({search_contains: true});
    });

    function clos() {
        window.location.assign("/doctor/admin/lab_management");
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

    $("#add_form").submit(function (event) {

        var form = $(this).closest('form');
        patient_id = $(form).find('.patient_id').val();
        lab_select = $(form).find('.lab_select').val();
        lab_select_work = $(form).find('.lab_select_work').val();
        lab_payment = $(form).find('.lab_payment').val();
        dates = $(form).find('input[name=date_time]').val();


        call_loader_ajax();
        $.ajax({
            url: '<?php echo base_url('admin/lab_management/update/' . $ids) ?>',
            type: 'POST',
            data: {patient_id: patient_id, lab_select: lab_select, lab_select_work: lab_select_work, lab_payment: lab_payment, dates: dates},
            success: function (result) {

                if (result == 1)
                {

                    //alert("value=0");
                    //$('#myModal').fadeOut(500);
                    $('#add').modal('hide');
                    window.close();
                    location.reload();
                    window.location.assign("http://doctori8.com/doctor/admin/lab_management");
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



    $(".update").click(function (event) {
        event.preventDefault();
//$(this).closest("form").submit();	

        var form = $(this).closest('form');
        id = $(form).find('input[name=id]').val();
        patient_id = $(form).find('.patient_id').val();
        invoice_no = $(form).find('.invoice_no').val();
        amount = $(form).find('.amount').val();
        payment_mode_id = $(form).find('.payment_mode_id').val();
        date = $(form).find('.date').val();
        payment_for = $(form).find('.payment_for').val();
        balance = $(form).find('.balance').val();
        //alert(amount);return false;
        call_loader_ajax();
        $.ajax({
            url: '<?php echo base_url('admin/payment/edit_payment') ?>/' + id,
            type: 'POST',
            data: {patient_id: patient_id, invoice_no: invoice_no, amount: amount, payment_mode_id: payment_mode_id, date: date, payment_for: payment_for, balance: balance},
            success: function (result) {
                //alert(result);return false;
                if (result == 1)
                {
                    location.reload();
                    // $('#edit'+id).modal('hide');
                    //window.close(); 
                }
                else
                {
                    $("#overlay").hide();
                    $('#err_edit' + id).html(result);
                }

                $(".chzn").chosen();
            }
        });
    });



    $(".patient").hide();
    $(".contact").hide();
    $(".other").hide();
    $(document).on('change', '.whom', function () {
        vch = $(this).val();
        $("div").removeClass("block");
        //alert(vch);  
        if (vch == 1) {
            $(".patient").show();
            $(".contact").hide();
            $(".other").hide();
        }

        if (vch == 2) {
            $(".contact").show();
            $(".patient").hide();
            $(".other").hide();
        }
        if (vch == 3) {
            $(".contact").hide();
            $(".patient").hide();
            $(".other").show();
        }

    });

    jQuery('.datetimepicker').datetimepicker({
        lang: 'en',
        i18n: {
            de: {
                months: [
                    'Januar', 'Februar', 'M�rz', 'April',
                    'Mai', 'Juni', 'Juli', 'August',
                    'September', 'Oktober', 'November', 'Dezember',
                ],
                dayOfWeek: [
                    "So.", "Mo", "Di", "Mi",
                    "Do", "Fr", "Sa.",
                ]
            }
        },
        timepicker: false,
        format: 'y-m-d H:i:00'
    });
</script>