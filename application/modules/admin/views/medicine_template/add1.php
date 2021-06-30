<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure');?>');
    }
</script>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li class="active"><?php echo "Medicine Teplate";?></li>
    </ol>
</section>

<section class="content">
    <div class="row" style="margin-bottom:10px;">
        <div class="col-xs-12">
            <div class="btn-group pull-right">
                <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new');?></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('drug_allergy');?></h3>
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th><?php echo lang('serial_number');?></th>
                            <th><?php echo lang('name');?></th>
                            <th width="25%"></th>
                        </tr>
                        </thead>

                        <?php if(isset($case_historys)):?>
                            <tbody>
                            <?php $i=1;foreach ($case_historys as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo $new->name?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-default"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('view');?></a>
                                            <a class="btn btn-primary"  href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
                                            <a class="btn btn-danger"  href="<?php echo site_url('admin/drug_allergy/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
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





<?php if(isset($case_historys)):?>
    <?php $i=1;
    foreach ($case_historys as $new){
        $case_history = $this->drug_allergy_model->get_case_history_by_id($new->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('drug_allergy')?></h4>
                    </div>
                    <div class="modal-body">
                        <div id="err_edit<?php echo $case_history->id;?>">
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
                        <?php echo form_open_multipart('admin/drug_allergy/edit/'.$case_history->id); ?>
                        <input type="hidden" name="id" value="<?php echo $case_history->id?>" />
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
                                        <input type="text" name="name" value="<?php echo set_value('name') . $case_history->name?>" class="form-control name">
                                    </div>
                                </div>
                            </div>




                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary update"><?php echo lang('update');?></button>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php $i++;}?>
<?php endif;?>




<?php if(isset($case_historys)):?>
    <?php $i=1;
    foreach ($case_historys as $new){
        $case_history = $this->drug_allergy_model->get_case_history_by_id($new->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="view<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel"><?php echo lang('view');?> <?php echo lang('drug_allergy')?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo $case_history->name?>
                                    </div>
                                </div>
                            </div>


                        </div><!-- /.box-body -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php $i++;}?>
<?php endif;?>





<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editlabel"><?php echo lang('add');?> <?php echo "Medicine Template"?></h4>
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
                <form method="post" action="<?php echo base_url();?>admin/medicine_template/add" id="add_form">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo "Template Name";?></label>
                                    <input type="text" name="name" value="<?php echo set_value('name')?>" class="form-control name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group input_fields_wrap">
                            <div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine'); ?></label>

                                </div>
                                <div class="col-md-4" >
                                    <div>
                                        <select name="medicine_id[]" class="form-control ">
                                            <option value="">--<?php echo lang('select_medicine'); ?>--</option>
                                            <?php
                                            foreach ($medicines as $new) {
                                                $sel = "";
                                                $sel = set_select('medicine_id', $new->name, FALSE);
                                                echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <select name="instruction[]" class="form-control ">
                                        <option value="">--<?php echo lang('medicine_instruction'); ?>--</option>
                                        <?php
                                        foreach ($medicine_ins as $new) {
                                            $sel = "";
                                            if (set_select('instruction', $new->name))
                                                $sel = "selected='selected'";
                                            echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="frequency[]" class="form-control ">
                                        <option value="">-- Frequency for Medicine --</option>
                                        <option value="Every Hour">Every Hour</option>
                                        <option value="Every other day">Every other day</option>
                                        <option value="Twice a day">Twice a day</option>
                                        <option value="Three times a day">Three times a day</option>
                                        <option value="Four times a day">Four times a day</option>
                                        <option value="At Night">At Night</option>
                                        <option value="At Morning">At Morning</option>
                                        <option value="At Noon">At Noon</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <select name="duration1[]" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                </div>
                                <div class="col-md-1 ">
                                    <select name="duration2[]" class="form-control ">
                                        <option value="Day(s)">Day(s)</option>
                                        <option value="Month(s)">Month(s)</option>
                                        <option value="Year(s)">Year(s)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-offset-2" style="padding-left:12px;">
                                            <button type="button" class="add_field_button btn btn-success"><?php echo lang('add'); ?> </button>
                                        </div>
                                    </div>
                                </div>
                           
                        


                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>
            </div>
        </div>
    </div>
</div>
</form>







<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example1').dataTable({
        });
    });


    $( "#add_form" ).submit(function( event ) {
        var form = $(this).closest('form');
        name = $(form ).find('.name').val();
        call_loader_ajax();
        $.ajax({
            url: '<?php echo site_url('admin/medicine_template/add/') ?>',
            type:'POST',
            data:{name:name,medicine_id:medicine_id,instruction:instruction,frquency:frequency,duration1:duration1,duration2:duration2};
        success:function(result){
            //alert(result);return false;
            if(result==1)
            {
                //alert("value=0");
                //$('#myModal').fadeOut(500);
                $('#add').modal('hide');
                window.close();
                location.reload();
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
        name = $(form ).find('.name').val();
        //alert(date_time);return false;
        call_loader_ajax();
        $.ajax({
            url: '<?php echo site_url('admin/drug_allergy/edit') ?>/' + id,
            type:'POST',
            data:{name:name},

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

            }
        });


    });

    $(document).ready(function () {
        var max_fields = 100; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper

        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count

        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="row"><div class="col-md-2"></div><div class="col-md-2"><select name="medicine_id[]" class="form-control "><option value="">--\n\
<?php echo lang('select_medicine'); ?>--</option><?php
                    foreach ($medicines as $new) {
                        echo '<option value="' . $new->name . '">' . $new->name . '</option>';
                    }
                    ?></select></div><div class="col-md-2 "><select name="instruction[]" class="form-control "><option value="">--<?php echo lang('medicine_instruction'); ?>--</option><?php
                    foreach ($medicine_ins as $new) {
                        echo '<option value="' . $new->name . '">' . $new->name . '</option>';
                    }
                    ?></select></div>\n\
                                        <div class="col-md-2"><select name="frequency[]" class="form-control "><option value="">-- Frequency for Medicine --</option><option value="Every Hour">Every Hour</option><option value="Every other day">Every other day</option><option value="Twice a day">Twice a day</option><option value="Three times a day">Three times a day</option><option value="Four times a day">Four times a day</option><option value="At Night">At Night</option><option value="At Morning">At Morning</option><option value="At Noon">At Noon</option></select></div>\n\
                                        <div class="col-md-1 "><select name="duration1[]" class="form-control "><option value="1">1</option>\n\
                                        <option value="2">2</option>\n\
                                        <option value="3">3</option>\n\
                                        <option value="4">4</option>\n\
                                        <option value="5">5</option>\n\
                                        <option value="6">6</option>\n\
                                        <option value="7">7</option>\n\
                                        <option value="8">8</option>\n\
                                        <option value="9">9</option>\n\
                                        <option value="10">10</option>\n\
                                        <option value="11">11</option>\n\
                                        <option value="12">12</option>\n\
                                        <option value="13">13</option>\n\
                                        <option value="14">14</option>\n\
                                        <option value="15">15</option>\n\
                                        <option value="16">16</option>\n\
                                        <option value="17">17</option>\n\
                                        <option value="18">18</option>\n\
                                        <option value="19">19</option>\n\
                                        <option value="20">20</option>\n\
                                        <option value="21">21</option>\n\
                                        <option value="22">22</option>\n\
                                        <option value="23">23</option>\n\
                                        <option value="24">24</option>\n\
                                        <option value="25">25</option>\n\
                                        <option value="26">26</option>\n\
                                        <option value="27">27</option>\n\
                                        <option value="28">28</option>\n\
                                        <option value="29">29</option>\n\
                                        <option value="30">30</option>\n\
                                        <option value="31">31</option>\n\
                                        </select></div>\n\
                                                        <div class="col-md-1 "><select name="duration2[]" class="form-control "><option value="Day(s)">Day(s)</option><option value="Month(s)">Month(s)</option><option value="Year(s)">Year(s)</option></select></div><a href="javascript:{$(this).parent("div").remove();}" class="remove_field btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box

                //$('.chzn').chosen({search_contains: true});
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });


</script>