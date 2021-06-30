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
        <small><?php echo lang('list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('lab_management'); ?></li>
    </ol>
</section>

<section class="content">
    <?php
    $admin = $this->session->userdata('admin');
    if ($admin['user_role'] == 1 || $admin['user_role'] == 3) {
        ?>
        <div class="row no-print" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add" onclick="{
                                $('input[name=order_date]').val(moment().format('DD/MM/YYYY'))
                            }" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('lab_add'); ?></a>
                </div>
            </div>    
        </div>	
    <?php } ?>		

    <div class="row no-print">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('lab_management'); ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive no-print" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="display:none">#</th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo 'Lab Name'; ?></th>
                                <th><?php echo lang('lab_work'); ?></th>
                                <th><?php echo 'Order Date'; ?></th>
                                <th><?php echo 'Expected Date'; ?></th>
                                <th><?php echo 'Status'; ?></th>
                                <th>Appointment</th>
                                <th width="30%"></th>
                            </tr>
                        </thead>


                        <tbody>

                            <?php
                            $i = 1;
                            foreach ($tests as $new) {
                                ?>
                                <tr class="gc_row">
                                    <td id="<?php echo $new->patient_id; ?>" style="display:none"><?php echo $i; ?></td>
                                    <?php
                                    foreach ($pateints as $new1) {
                                        if ($new->patient_id == $new1->id) {
                                            ?>
                                            <td  id="<?php echo $new->patient_id; ?>"><?php echo $new1->name; ?></td>	
                                            <?php
                                        }
                                    }
                                    ?>			
                                    <td id="<?php echo $new->patient_id; ?>"><?php echo $new->lab_select ?></td>
                                    <td id="<?php echo $new->patient_id; ?>"><?php echo $new->lab_select_work ?></td>
                                    <td id="<?php echo $new->patient_id; ?>"><?php echo $new->order_date ?></td>
                                    <td id="<?php echo $new->patient_id; ?>"><?php echo $new->dates ?></td>
                                    <td>

                                        <?php
                                        if ($new->status == 0) {
                                            $val = '<a href="' . site_url('admin/lab_management/approve/' . $new->id) . '/2" class="btn btn-danger">PENDING</a>';
                                        } else if ($new->status == 1) {
                                            $val = '<a href="' . site_url('admin/lab_management/approve/' . $new->id) . '/0" class="btn btn-success">DELIVERED</a>';
                                        } else if ($new->status == 2) {
                                            $val = '<a href="' . site_url('admin/lab_management/approve/' . $new->id) . '/1" class="btn btn-warning">RECEIVED</a>';
                                        }

                                        echo $val;
                                        ?></td>

                                    <td>

                                        <a href="<?php echo site_url('admin/lab_management/add_appointment/' . $new->patient_id); ?>" class="btn btn-info" data-toggle="modal"><i class="fa fa-plus"></i>  Appointment</a>

                                    </td>

                                    <td width="30%">
                                        <div class="btn-group">
                                            <a class="btn btn-default" style="margin-left:10px; display:none;"  href="#invoice<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice'); ?></a>
                                            <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/lab_management/edit/' . $new->id); ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                            <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/lab_management/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>





<?php //#########################################################################   ?>

<script></script>
<?php //###############################################################################   ?>

<!-- Add Payment-->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('lab_add'); ?> </h4>
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
                <form method="post" action="<?php echo site_url('admin/lab_management/add/') ?>" enctype="multipart/form-data" id="add_form">

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
                                            if ($p_id == $new->id)
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
                                    <select name="lab_select" class="form-control chzn patient lab_select "  >

                                        <?php
                                        foreach ($lab_select_work as $new) {
                                            echo '<option value="' . $new->name . '" >' . $new->name . '</option>';
                                        }
                                        ?>


                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <b><?php echo lang('lab_work') ?></b>
                                </div>
                                <div class="col-md-4">

                                    <textarea name="lab_select_work" class="form-control lab_select_work "></textarea>											
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="display:none;">
                            <div class="row" >
                                <div class="col-md-3">
                                    <b><?php echo lang('lab_payment') ?></b>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="lab_payment" value="" class="form-control lab_payment" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="order_date" style="clear:both;"><?php echo 'Order Date'; ?></label></div>
                                <div class="col-md-4">
                                    <input type="text" name="order_date"  value="<?php echo set_value('order_date'); ?>" class="form-control datepicker date_time">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo 'Expected date'; ?></label></div>
                                <div class="col-md-4">
                                    <input type="text" name="date_time" value="<?php echo set_value('date_time'); ?>" class="form-control datepicker date_time">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row" style="display:none;">
                                <div class="col-md-3">
                                    <b><?php echo lang('lab_status') ?></b>
                                </div>
                                <div class="col-md-4">
                                    <input type="radio" name="lab_status" value="0" class="form-control lab_status" />PENDING 

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
    <button  type="submit" class="btn btn-primary"><?php echo lang('save') ?></button>
</div>
</form>
</div>		  
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
</div>
</div>
</div>
</div>




<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/moment.min.js') ?>" type="text/javascript"></script>
<?php if (!empty($p_id)) { ?>
    <script>
                                                $(function () {
                                                    $('#add').modal();

                                                });
    </script>

<?php } ?>

<script type="text/javascript">
    function color_change(ddlFruits) {

        selectedText = ddlFruits.options[ddlFruits.selectedIndex].id;
        document.getElementById("colorvalue").value = selectedText;
    }
    $(function () {
        $('#example1').dataTable({
        });
        $('.chzn').chosen({search_contains: true});
    });


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
        lab_status = $(form).find('input[name=lab_status]').val();
        dates = $(form).find('input[name=date_time]').val();
         dates1 = $(form).find('input[name=order_date]').val();
        call_loader_ajax();
        $.ajax({
            url: '<?php echo base_url('admin/lab_management/add/') ?>',
            type: 'POST',
            data: {patient_id: patient_id, lab_select: lab_select, lab_select_work: lab_select_work, lab_payment: lab_payment, lab_status: lab_status, dates:dates,dates1:dates1},
            success: function (result) {

                if (result == 1)
                {

                    //alert("value=0");
                    //$('#myModal').fadeOut(500);
                    $('#add').modal('hide');
                    window.close();

                    window.location = "<?php echo base_url('admin/lab_management') ?>";
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


    $("#add_app").submit(function (event) {
        //title 		= $('input[name=title]').val();
        var form = $(this).closest('form');
        consultant = $(form).find('.consultant').val();
        colorvalue = $(form).find('#colorvalue').val();
        title = $(form).find('.title').val();
        whom = $(form).find('.whom').val();
        patient_id = $(form).find('.patient_id').val();
        contact_id = '';
        other = '';
        date_time = $(form).find('.date_time').val();
        notes = $(form).find('.notes').val();
        motive = $(form).find('.motive').val();
        is_paid = $(form).find('.is_paid:checked').val();
        //alert(consultant); return false;

        call_loader_ajax();
        $.ajax({
            url: '<?php echo site_url('admin/appointments/add/') ?>',
            type: 'POST',
            data: {consultant: consultant, colorvalue: colorvalue, title: title, whom: whom, patient_id: patient_id, contact_id: contact_id, other: other, date_time: date_time, motive: motive, notes: notes, is_paid: is_paid},
            success: function (result) {
                //alert(result);return false;
                if (result == 1)
                {
                    //alert("value=0");
                    //$('#myModal').fadeOut(500);
                    $('#add').modal('hide');
                    window.close();
                    location.reload();
                }
                else
                {
                    $("#overlay").remove();
                    $('#err').html(result);
                }

            }
        });

        event.preventDefault();
    });

    jQuery('.datepicker').datetimepicker({
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
        format: 'd/m/Y'
    });
    jQuery('.datetimepicker').datetimepicker({
        lang: 'en',
        i18n: {
            de: {
                months: [
                    'January', 'February', 'March', 'April',
                    'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December',
                ],
                dayOfWeek: [
                    "Sun.", "Mon", "Tue", "Wed",
                    "Thu", "Fri", "Sat",
                ]
            }
        },
        timepicker: true,
        format: 'y-m-d H:i:00'
    });

    $("#example1 tbody td").on('click', function () {
        var id = $(this).attr('id');
        document.location.href = "<?php echo site_url('admin/patients/view/') ?>/" + id;
    });

</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/scroller/1.4.3/js/dataTables.scroller.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>-->
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<!--<script src="https://code.jquery.com/jquery-1.11.3.js"></script> --->
<script>
    $(document).ready(function(){
        $("#boxchecked").click(function (){
            if ($("#boxchecked").prop("checked")){
                $("#hidden").hide();
            }else{
                $("#hidden").show();
            }              
        });
    });
</script>
<script type="text/javascript">
                    // $("#add_form").submit(function (event) {
                    //     name = $('.name').val();
                    //     gender = $('input:radio[name=gender]:checked').val();
                    //     blood_id = $('.blood_id').val();
                    //     dob = $('.dob').val();
                    //      dob1 = $('.dob1').val();
                    //       dob2 = $('.dob2').val();
                    //     //username = $('.username_u').val();
                    //     email = $('.email').val();
                    //     password = $('.password').val();
                    //     conf = $('.confirm').val();
                    //     contact = $('.contact').val();
                    //     address = $('.address').val();
                    //     group = $('.group').val();
                    //     //alert(blood_id);return false;

                    //     call_loader_ajax();
                    //     $.ajax({
                    //         url: '<?php echo base_url('admin/patients/add') ?>',
                    //         type: 'POST',
                    //         //data:{name:name,gender:gender,blood_id:blood_id,dob:dob,dob1:dob1,dob2:dob2,email:email,password:password,confirm:conf,contact:contact,address:address,group:group},
                    //         data: $('#add_form').serialize(),
                    //         success: function (result) {
                    //             //alert(result);return false;
                    //             if (result == 1)
                    //             {
                    //                 //alert("value=0");
                    //                 //$('#myModal').fadeOut(500);
                    //                 location.reload();
                    //                 $('#add').modal('hide');
                    //                 window.close();
                    //             } else
                    //             {
                    //                 $("#overlay").hide();
                    //                 $('#err').html(result);
                    //             }

                    //             $(".chzn").chosen();
                    //         }
                    //     });

                    //     event.preventDefault();
                    // });

                    $(".update").click(function (event) {
                        event.preventDefault();
//$(this).closest("form").submit();	
                        var form = $(this).closest('form');
                        id = $(form).find('input[name=id]').val();
                        name = $(form).find('input[name=name]').val();
                        gender = $('input:radio[name=gender]:checked').val();
                        blood_id = $(form).find('.blood_id').val();
                        dob = $(form).find('input[name=dob]').val();
                        //username = $(form ).find('input[name=username]').val();
                        email = $(form).find('input[name=email]').val();
                        password = $(form).find('input[name=password]').val();
                        conf = $(form).find('input[name=confirm]').val();
                        contact = $(form).find('input[name=contact]').val();
                        contact1 = $(form).find('input[name=contact1]').val();
                        address = $(form).find('.address').val();
                        //alert(blood_id);return false;
                        call_loader_ajax();
                        $.ajax({
                            url: '<?php echo base_url('admin/patients/edit') ?>/' + id,
                            type: 'POST',
                            data: {name: name, gender: gender, blood_id: blood_id, dob: dob, email: email, password: password, confirm: conf, contact: contact, contact1: contact1, address: address},
                            success: function (result) {
                                //alert(result);return false;
                                if (result == 1)
                                {
                                    location.reload();
                                    // $('#edit'+id).modal('hide');
                                    //window.close(); 
                                } else
                                {
                                    $("#overlay").hide();
                                    $('#err_edit' + id).html(result);
                                }

                                $(".chzn").chosen();
                            }
                        });


                    });



                    $(document).ready(function () {
                        /*$( '#example1' ).dataTable( {
                         "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                         // Bold the grade for all 'A' grade browsers
                         if ( aData[4] == "A" )
                         {
                         $('td:eq(4)', nRow).html( '<b>A</b>' );
                         }
                         }
                         } );*/

//                        $('#example1').DataTable({
//                            deferRender: true,
//                            scrollY: 600,
//                            scrollCollapse: true,
//                            scroller: true
//                        });
                    //     $('#example1').DataTable({
                    //         "paging": true,
                    //         "processing": true, //Feature control the processing indicator.
                    //         "serverSide": true, //Feature control DataTables' server-side processing mode.
                    //         "order": [], //Initial no order.

                    //         // Load data for the table's content from an Ajax source
                    //         "ajax": {
                    //             "url": "<?php echo site_url('admin/patients/ajax_list') ?>",
                    //             "type": "POST"
                    //         },
                    //         //Set column definition initialisation properties.
                    //         "columnDefs": [
                    //             {
                    //                 //"targets": [0], //first column / numbering column
                    //                 "orderable": false, //set not orderable
                    //             },
                    //         ],
                    //     });
                    // });

                    // $(function () {
                    //     $(".chzn").chosen({search_contains: true});
                    // });
                    // jQuery('.datepicker').datetimepicker({
                    //     lang: 'en',
                    //     i18n: {
                    //         de: {
                    //             months: [
                    //                 'Januar', 'Februar', 'M�rz', 'April',
                    //                 'Mai', 'Juni', 'Juli', 'August',
                    //                 'September', 'Oktober', 'November', 'Dezember',
                    //             ],
                    //             dayOfWeek: [
                    //                 "So.", "Mo", "Di", "Mi",
                    //                 "Do", "Fr", "Sa.",
                    //             ]
                    //         }
                    //     },
                    //     timepicker: false,
                    //     format: 'Y-m-d'
                    // });

                    // jQuery('.datetimepicker').datetimepicker({
                    //     lang: 'en',
                    //     i18n: {
                    //         de: {
                    //             months: [
                    //                 'Januar', 'Februar', 'M�rz', 'April',
                    //                 'Mai', 'Juni', 'Juli', 'August',
                    //                 'September', 'Oktober', 'November', 'Dezember',
                    //             ],
                    //             dayOfWeek: [
                    //                 "So.", "Mo", "Di", "Mi",
                    //                 "Do", "Fr", "Sa.",
                    //             ]
                    //         }
                    //     },
                    //     timepicker: false,
                    //     format: 'Y-m-d'
                    // });

                    $(document).on('change', '#patient_id', function () {
                        vch = $(this).val();

                        call_loader_ajax();

                        $.ajax({
                            url: '<?php echo base_url('admin/patients/get_patient') ?>',
                            type: 'POST',
                            data: {id: vch},
                            success: function (result) {
                                //alert(result);return false;

                                $('#result').html(result);
                                $(".chzn").chosen({search_contains: true});
                                //$('#example1').dataTable({});
                                $('#example1').DataTable({
                                    "paging": true,
                                    "processing": true, //Feature control the processing indicator.
                                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                                    "order": [], //Initial no order.

                                    // Load data for the table's content from an Ajax source
                                    "ajax": {
                                        "url": "<?php echo site_url('admin/patients/ajax_list') ?>",
                                        "type": "POST"
                                    },
                                    //Set column definition initialisation properties.

                                    "columnDefs": [
                                        {
                                            "targets": [0], //first column / numbering column
                                            "orderable": false, //set not orderable
                                        },
                                    ],
                                });

                                $("#overlay").hide();

                            }
                        });
                    });
</script>

<script>
    $("#example1 tbody td").on('click', function () {
        var id = $(this).attr('id');
        document.location.href = "<?php echo site_url('admin/patients/view/') ?>/" + id;
    });

</script>

