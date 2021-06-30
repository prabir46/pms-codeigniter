<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
    .row{
        margin-bottom:10px;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .text-justify {
        text-align: justify;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo lang('manage_prescription'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>

        <li class="active"><?php echo lang('manage_prescription'); ?></li>
    </ol>
</section>

<section class="content">
    <?php
    if (validation_errors()) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
            <b><?php echo lang('alert'); ?>!</b><?php echo validation_errors(); ?>
        </div>

    <?php } ?>  

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">

                </div><!-- /.box-header -->
                <!-- form start -->


                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/template/') ?>"
                      <div class="box-body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('header'); ?></label>
                                </div>	
                                <div class="col-md-8">
                                    <?php
                                    if (strpos($template->header, 'http://') === false && strpos($template->header, 'https://') === false) {
                                        echo '<div readonly="">' . $template->header . '</div>';
                                    } else {
                                        echo '<img src="' . $template->header . '" height="200px" width="100%" />';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;">Enter Text</label>
                                </div>	
                                <div class="col-md-8">
                                    <textarea id="header" type="text" name="header" class="form-control" >
                                        <?php
                                        if (strpos($template->header, 'http://') === false && strpos($template->header, 'https://') === false)
                                            if (empty($template->header) != true)
                                                echo $template->header
                                                ?>
                                    </textarea>

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
                                    <label for="name" style="clear:both;"> <?php echo lang('footer'); ?></label>
                                </div>	
                                <div class="col-md-8">

                                    <textarea name="footer"class="form-control redactor"><?php echo @$template->footer; ?></textarea>
                                </div>
                            </div>
                        </div>




                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>  

<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/redactor.min.js') ?>"></script>
<script type="text/javascript">
    $(function () {

        $('.chzn').chosen();

    });

</script>
<script>
    (function ($)
    {
        $.Redactor.prototype.alignment = function ()
        {
            return {
                langs: {
                    en: {
                        "align": "Align",
                        "align-left": "Align Left",
                        "align-center": "Align Center",
                        "align-right": "Align Right",
                        "align-justify": "Align Justify",
                    }
                },
                init: function ()
                {
                    var that = this;
                    var dropdown = {};

                    dropdown.left = {title: that.lang.get('align-left'), func: that.alignment.setLeft};
                    dropdown.center = {title: that.lang.get('align-center'), func: that.alignment.setCenter};
                    dropdown.right = {title: that.lang.get('align-right'), func: that.alignment.setRight};
                    dropdown.justify = {title: that.lang.get('align-justify'), func: that.alignment.setJustify};

                    var button = this.button.add('alignment', this.lang.get('align'));
                    this.button.setIcon(button, '<i class="re-icon-alignment"></i>');
                    this.button.addDropdown(button, dropdown);
                },
                removeAlign: function ()
                {
                    this.block.removeClass('text-center');
                    this.block.removeClass('text-right');
                    this.block.removeClass('text-justify');
                },
                setLeft: function ()
                {
                    this.buffer.set();
                    this.alignment.removeAlign();
                },
                setCenter: function ()
                {
                    this.buffer.set();
                    this.alignment.removeAlign();
                    this.block.addClass('text-center');
                    this.core.editor().focus()
                },
                setRight: function ()
                {
                    this.buffer.set();
                    this.alignment.removeAlign();
                    this.block.addClass('text-right');
                    this.core.editor().focus()
                },
                setJustify: function ()
                {
                    this.buffer.set();
                    this.alignment.removeAlign();
                    this.block.addClass('text-justify');
                    this.core.editor().focus()
                }
            };
        };
    })(jQuery);
    $(document).ready(function () {

        $.Redactor.prototype.header_spacing = function ()
        {
            return {
                init: function ()
                {
                    var dropdown = {};

                    dropdown.point1 = {title: '1 Inch', func: this.header_spacing.pointFirstCallback};
                    dropdown.point2 = {title: '1.5 Inch', func: this.header_spacing.pointSecondCallback};
                    dropdown.point3 = {title: '2 Inch', func: this.header_spacing.pointThirdCallback};

                    var button = this.button.add('header_spacing', 'Header Height');
                    this.button.addDropdown(button, dropdown);
                    this.button.setIcon(button, '<i class="fa fa-arrows-v"></i> Header Margin');


                },
                pointFirstCallback: function (buttonName)
                {
                    var html = '<br/>&nbsp;<br/>&nbsp;<hr/>';
                    $('#header').redactor('code.set', '');
                    $('#header').redactor('insert.html', html);
                },
                pointSecondCallback: function (buttonName)
                {
                    var html = '&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<hr/>';
                    $('#header').redactor('code.set', '');
                    $('#header').redactor('insert.html', html);
                },
                pointThirdCallback: function (buttonName)
                {
                    var html = '&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<hr/>';
                    $('#header').redactor('code.set', '');
                    $('#header').redactor('insert.html', html);
                }
            };
        };


        $('#header').redactor({
            air: false,
            plugins: ['alignment', 'header_spacing'],
        });

        $('.redactor').redactor({
            plugins: ['alignment'],
        });

    });

</script>

