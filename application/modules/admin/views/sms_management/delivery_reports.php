<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active">Delivery Reports</li>
        </ol>
</section>

<section class="content">
  	  	 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                   
<div class="button_set pull-right">
    	<!--<a class="btn btn-default" href=""><i class="icon-plus-sign"></i> <?php echo lang('add_new');?></a>-->
        <div class="btn btn-danger"><?php echo  $count->sms_limit; ?> Messages Remaining</div>
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
            <th>#</th>
            <th>Patient</th>
            <th>Consultant</th>
            <th>Type</th>
            <th>Delivered On</th>
        </tr>
    </thead>
    <tbody>
    <?php $count = 1; ?>
    <?php foreach($sms as $new): ?>
        <tr class="gc_row">
            <td><?php echo $count; $count++; ?></td>
            <td><?php $patient = $this->patient_model->get_patient_by_id($new['patient_id']); echo $patient->name; ?></td>
            <td><?php $consultant = $this->consultant_model->get_consultant_by_id($new['consultant']); echo $consultant->name; ?></td>
            <td><?php $type=$new['type']; if($type=='instant') echo "Instant Message"; 
                        else if($type=='doctor') echo "Reminder for Doctor"; 
                        else echo "Reminder for Patient"; ?></td>
            <td><?php echo $new['date']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
function areyousure()
{
    return confirm('<?php echo lang('are_you_sure');?>');
}
</script>