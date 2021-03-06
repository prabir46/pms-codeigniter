<div id="err_inv">
  <?php
  $treatment_Advised_id = json_decode($tooth_list->treatment_Advised_id);
  /*if(isset($treatment_Advised_id[0]))
  	$treatment_Advised_id = $treatment_Advised_id[0];*/
  
  $toothString = '';
  $tooth = array();
  if($tooth_list->tooth != '')
  {
  	  $toothString = json_decode($tooth_list->tooth);
	  if(isset($toothString[0]))
	  {
		  $tooth = explode(",",$toothString[0]);
	  }
	  $toothString = $toothString[0];
  }
  //echo 'DD : '.$treatment_Advised_id;
  //echo '<pre>'; print_r($tooth); echo '</pre>';die;
  if (validation_errors()) {
  ?>
  <div class="alert alert-danger alert-dismissable"> <i class="fa fa-ban"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
    <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?> </div>
  <?php } ?>
</div>
<!-- form start -->
<input type="text" readonly="readonly" id="err" style="display:none;" />
<form method="post" action="<?php echo site_url('admin/payment/edit_tooth/') ?>" enctype="multipart/form-data" id="treatment_plan_form">
<input type="hidden"  name="patient_id" class="patient_id"  value="<?php echo $tooth_list->patient_id; ?>" />
  <input type="hidden"  name="tooth_id" class="tooth_id"  value="<?php echo $tooth_list->id; ?>" />
  <?php //#####################################################################################   ?>
  <div class="form-group input_fields_wrap2">
    <div class="form-group" style="margin-top:20px;">
      <div class="row">
        <div class="col-md-3"> <b><?php echo lang('treatment_advised') ?></b> </div>
        <div class="col-md-4">
          <select name="treatment_Advised_id[]" class="form-control chzn" multiple="multiple">
            <option value="">--
			<?php echo lang('treatment_advised'); ?>--</option>
            <?php
			foreach ($treatment_Advised as $new) {
				$sel = "";
				//if ($treatment_Advised_id == $new->name)
				if(in_array($new->name,$treatment_Advised_id))
					$sel = "selected='selected'";
				echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
			}
			?>
          </select>
          <input type="text" name="tooth[]" value="<?php echo $toothString;?>" id="toot_val_edit" style="display:none;" />
        </div>
      </div>
    </div>
  </div>
  <div class="form-group input_fields_wrap2 quantity">
    <div class="form-group" style="margin-top:20px;">
      <div class="row">
        <div class="col-md-3"> <b>Quantity</b> </div>
        <div class="col-md-4">
          <input type="text" class="form-control est_qty" name="quantity" id="est_qty" value="<?php echo $tooth_list->quantity;?>" onkeyup="calclulate_estimate();">
        </div>
      </div>
    </div>
  </div>
  <div class="form-group input_fields_wrap2 quantity">
    <div class="form-group" style="margin-top:20px;">
      <div class="row">
        <div class="col-md-3"> <b>Rate</b> </div>
        <div class="col-md-4">
          <input type="text" class="form-control est_rate" id="est_rate" value="<?php echo ($tooth_list->estimate/$tooth_list->quantity);?>"  onkeyup="calclulate_estimate();">
        </div>
      </div>
    </div>
  </div>
  <div class="form-group input_fields_wrap2 consultation_charge">
    <div class="form-group" style="margin-top:20px;">
      <div class="row">
        <div class="col-md-3"> <b>Estimation cost</b> </div>
        <div class="col-md-4">
          <input type="text" class="form-control est_cost" id="est_cost" name="consultation_charge" value="<?php echo $tooth_list->estimate;?>">
        </div>
      </div>
    </div>
  </div>
  <?php //#####################################################################################    ?>
  <div class="form-group">
    <div class="row">
      <div class="col-md-12">
        <h3 style="text-align: center;">Permanent Tooth</h3>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col-md-1 "> <img src="http://doctori8.com/doctor/assets/img/teeth-img/18.png"  class="img-circle <?php if(in_array(18,$tooth)) echo 'act';?>" alt="User Image" id="18_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>18</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/17.png" class="img-circle <?php if(in_array(17,$tooth)) echo 'act';?>" alt="User Image" id="17_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>17</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/16.png" class="img-circle <?php if(in_array(16,$tooth)) echo 'act';?>" alt="User Image" id="16_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>16</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/15.png" class="img-circle <?php if(in_array(15,$tooth)) echo 'act';?>" alt="User Image" id="15_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>15</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/14.png" class="img-circle <?php if(in_array(14,$tooth)) echo 'act';?>" alt="User Image" id="14_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>14</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/13.png" class="img-circle <?php if(in_array(13,$tooth)) echo 'act';?>" alt="User Image" id="13_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>13</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/12.png" class="img-circle <?php if(in_array(12,$tooth)) echo 'act';?>" alt="User Image" id="12_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>12</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/11.png" class="img-circle <?php if(in_array(11,$tooth)) echo 'act';?>" alt="User Image" id="11_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>11</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/21.png" class="img-circle <?php if(in_array(21,$tooth)) echo 'act';?>" alt="User Image" id="21_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>21</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/22.png" class="img-circle <?php if(in_array(22,$tooth)) echo 'act';?>" alt="User Image" id="22_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>22</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/23.png" class="img-circle <?php if(in_array(23,$tooth)) echo 'act';?>" alt="User Image" id="23_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>23</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/24.png" class="img-circle <?php if(in_array(24,$tooth)) echo 'act';?>" alt="User Image" id="24_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>24</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/25.png" class="img-circle <?php if(in_array(25,$tooth)) echo 'act';?>" alt="User Image" id="25_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>25</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/26.png" class="img-circle <?php if(in_array(26,$tooth)) echo 'act';?>" alt="User Image" id="26_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>26</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/27.png" class="img-circle <?php if(in_array(27,$tooth)) echo 'act';?>" alt="User Image" id="27_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>27</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/28.png" class="img-circle <?php if(in_array(28,$tooth)) echo 'act';?>" alt="User Image" id="28_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>28</p>
      </div>
    </div>
  </div>
  <?php //#####################################################################################    ?>
  <div class="form-group">
    <div class="row">
      <div class="col-md-1 "> <img src="http://doctori8.com/doctor/assets/img/teeth-img/48.png"  class="img-circle <?php if(in_array(48,$tooth)) echo 'act';?>" alt="User Image" id="48_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>48</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/47.png" class="img-circle <?php if(in_array(47,$tooth)) echo 'act';?>" alt="User Image" id="47_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>47</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/46.png" class="img-circle <?php if(in_array(46,$tooth)) echo 'act';?>" alt="User Image" id="46_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>46</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/45.png" class="img-circle <?php if(in_array(45,$tooth)) echo 'act';?>" alt="User Image" id="45_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>45</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/44.png" class="img-circle <?php if(in_array(44,$tooth)) echo 'act';?>" alt="User Image" id="44_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>44</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/43.png" class="img-circle <?php if(in_array(43,$tooth)) echo 'act';?>" alt="User Image" id="43_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>43</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/42.png" class="img-circle <?php if(in_array(42,$tooth)) echo 'act';?>" alt="User Image" id="42_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>42</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/41.png" class="img-circle <?php if(in_array(41,$tooth)) echo 'act';?>" alt="User Image" id="41_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>41</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/31.png" class="img-circle <?php if(in_array(31,$tooth)) echo 'act';?>" alt="User Image" id="31_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>31</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/32.png" class="img-circle <?php if(in_array(32,$tooth)) echo 'act';?>" alt="User Image" id="32_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>32</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/33.png" class="img-circle <?php if(in_array(33,$tooth)) echo 'act';?>" alt="User Image" id="33_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>33</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/34.png" class="img-circle <?php if(in_array(34,$tooth)) echo 'act';?>" alt="User Image" id="34_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>34</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/35.png" class="img-circle <?php if(in_array(35,$tooth)) echo 'act';?>" alt="User Image" id="35_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>35</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/36.png" class="img-circle <?php if(in_array(36,$tooth)) echo 'act';?>" alt="User Image" id="36_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>36</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/37.png" class="img-circle <?php if(in_array(37,$tooth)) echo 'act';?>" alt="User Image" id="37_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>37</p>
      </div>
      <div class="col-md-1"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/38.png" class="img-circle <?php if(in_array(38,$tooth)) echo 'act';?>" alt="User Image" id="38_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>38</p>
      </div>
    </div>
  </div>
  <?php //#####################################################################################    ?>
  <div class="form-group">
    <div class="row">
      <div class="col-md-12">
        <h3 style="text-align: center;">Child Tooth</h3>
      </div>
    </div>
  </div>
  <?php //#####################################################################################    ?>
  <div class="form-group">
    <div class="row">
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/a.png" class="img-circle <?php if(in_array(55,$tooth)) echo 'act';?>" alt="User Image" id="55_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>55</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/b.png" class="img-circle <?php if(in_array(54,$tooth)) echo 'act';?>" alt="User Image" id="54_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>54</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/c.png" class="img-circle <?php if(in_array(53,$tooth)) echo 'act';?>" alt="User Image" id="53_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>53</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/d.png" class="img-circle <?php if(in_array(52,$tooth)) echo 'act';?>" alt="User Image" id="52_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>52</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/e.png" class="img-circle <?php if(in_array(51,$tooth)) echo 'act';?>" alt="User Image" id="51_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>51</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/f.png" class="img-circle <?php if(in_array(61,$tooth)) echo 'act';?>" alt="User Image" id="61_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>61</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/g.png" class="img-circle <?php if(in_array(62,$tooth)) echo 'act';?>" alt="User Image" id="62_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>62</p>
      </div>
      <div class="col-md-2 child-tooth" > <img src="http://doctori8.com/doctor/assets/img/teeth-img/h.png" class="img-circle <?php if(in_array(63,$tooth)) echo 'act';?>" alt="User Image" id="63_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>63</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/i.png" class="img-circle <?php if(in_array(64,$tooth)) echo 'act';?>" alt="User Image" id="64_toot_edit"onclick="javascriptsEdit(this.id);">
        <p>64</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/j.png" class="img-circle <?php if(in_array(65,$tooth)) echo 'act';?>" alt="User Image" id="65_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>65</p>
      </div>
    </div>
  </div>
  <?php //#####################################################################################    ?>
  <div class="form-group">
    <div class="row">
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/k.png" class="img-circle <?php if(in_array(85,$tooth)) echo 'act';?>" alt="User Image" id="85_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>85</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/l.png" class="img-circle <?php if(in_array(84,$tooth)) echo 'act';?>" alt="User Image" id="84_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>84</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/m.png" class="img-circle <?php if(in_array(83,$tooth)) echo 'act';?>" alt="User Image" id="83_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>83</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/n.png" class="img-circle <?php if(in_array(82,$tooth)) echo 'act';?>" alt="User Image" id="82_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>82</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/o.png" class="img-circle <?php if(in_array(81,$tooth)) echo 'act';?>" alt="User Image" id="81_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>81</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/p.png" class="img-circle <?php if(in_array(71,$tooth)) echo 'act';?>" alt="User Image" id="71_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>71</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/q.png" class="img-circle <?php if(in_array(72,$tooth)) echo 'act';?>" alt="User Image" id="72_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>72</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/r.png" class="img-circle <?php if(in_array(73,$tooth)) echo 'act';?>" alt="User Image" id="73_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>73</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/s.png" class="img-circle <?php if(in_array(74,$tooth)) echo 'act';?>" alt="User Image" id="74_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>74</p>
      </div>
      <div class="col-md-2 child-tooth"> <img src="http://doctori8.com/doctor/assets/img/teeth-img/t.png" class="img-circle <?php if(in_array(75,$tooth)) echo 'act';?>" alt="User Image" id="75_toot_edit" onclick="javascriptsEdit(this.id);">
        <p>75</p>
      </div>
    </div>
  </div>
  <?php //#####################################################################################   ?>
  <div class="form-group">
    <div class="row"> </div>
  </div>
  <?php //#####################################################################################    ?>
  <?php //===============================================================================   ?>
  <div class="box-footer">
    <button  type="submit" class="btn btn-primary">Update</button>
  </div>
</form>
<script type="text/javascript">
function javascriptsEdit(id) {
	var toot_val_edit = $("#toot_val_edit").val();	
	var resId = id.split("_toot_edit");
	var index = toot_val_edit.indexOf(resId[0]);
	
	var tooth1 = toot_val_edit.split(",");
	/*console.log('tooth : '+toot_val_edit);
	console.log('Val : '+resId[0]);
	console.log('index : '+index);*/
	
	if (index > -1) {
		$("#" + id).removeClass('act');
		//tooth1.splice(index, 1);
		//tooth1 = removeValue(toot_val_edit,resId[0]);
		tooth1 = removeValue(toot_val_edit,resId[0],",");
		//console.log('removed tooth1 : '+tooth1);
	} else {
		$("#" + id).addClass('act');
		tooth1.push(resId[0]);
		//console.log('added tooth1 : '+tooth1);
	}	
	$("#toot_val_edit").val(tooth1);
}
function removeValue(list, value, separator) {
  separator = separator || ",";
  var values = list.split(separator);
  for(var i = 0 ; i < values.length ; i++) {
    if(values[i] == value) {
      values.splice(i, 1);
      return values.join(separator);
    }
  }
  return list;
}
function calclulate_estimate() {
	var est_qty = $("#est_qty").val();
	var est_rate = $("#est_rate").val();
	var est_cost = est_qty*est_rate;
	/*console.log('est_qty : '+est_qty);
	console.log('est_rate : '+est_rate);
	console.log('est_cost : '+est_cost);*/
	$("#est_cost").val(est_cost);
}
</script>