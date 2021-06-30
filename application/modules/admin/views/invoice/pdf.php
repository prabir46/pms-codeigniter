<?php 
if($setting->image!=""){
				$img ='<img src="'.site_url('assets/uploads/images/'.$data['setting']->image).'"  height="70" width="80" />';
			}else{
				$img ='<img src="'.site_url('assets/img/doctor_logo.png').'"  height="70" width="80" />';
			}
			
?>
<?php
foreach($fees_all as $inv){
  $details = $this->invoice_model->get_detail_new($inv->id);
}?>
<table width="100%" border="0"  id="print_in_all" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											<td align="left"><?php if(@$setting->image!=""){?>
											<img src="<?php echo base_url('assets/uploads/images/'.@$setting->image)?>"  height="70" width="80" />
										<?php }else{?>
										<img src="<?php echo base_url('assets/img/doctor_logo.png/')?>"  height="70" width="80" />
											<?php } ?>	</td>
											<td align="right">
												<b><?php echo lang('invoice_number')?> #<?php echo $id; ?></b><br />
												
												<b>Issue Date: </b><?php echo date('d/m/Y');?> <br/>
												
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
										<tr>
											<td align="left">Payment To<br />
												 <strong><?php echo @$setting->name ?></strong><br>
										   <?php echo @$setting->address ?><br>
											<?php echo lang('phone') ?>: <?php echo @$setting->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo @$setting->email ?>		
											
											</td>
											<td align="right" colspan="2">Bill To<br />
											
											<strong><?php echo $details->patient ?></strong><br>
											<?php echo $details->address ?><br>
											<?php echo lang('phone') ?>: <?php echo $details->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo $details->email ?>
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr >
								<th align="left" style="padding-top:10px;">Invoice Entries</th>
							</tr>
							<tr>  
								<td>
<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>S. No.</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="75%" align="left"><b>Treatment Advised</b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="15%"><b>Price</b></td>
										</tr>
<?php
$j=1;
$tot_amt = 0;
foreach($fees_all as $inv){
$det = $this->invoice_model->get_detail_new($inv->id);
$tring = preg_replace('/[^A-Za-z0-9\-]/', '', $det->treatment_Advised_id);
if($tring=='Discount'){
 $discountamt = $det->amount;
 continue;
}
if($det->treatment_Advised_id!=''):
?>									
										<tr >
											 <td width="10%" style="border-right:1px solid #CCCCCC" ><?php echo $j?></td>
											 <td width="75%" style="border-right:1px solid #CCCCCC"><?php echo $string = preg_replace('/[^A-Za-z0-9\-]/', '', $det->treatment_Advised_id);?>
											 </td>											 <td width="15%" ><?php echo $det->amount;
$tot_amt = $tot_amt + $det->amount; 
?> INR
</td>                                                  	
										</tr>
										<?php $j++; endif; }?>
                                                                                <tr> 
<td style="border-right:1px solid #CCCCCC; border-top:1px solid #CCCCCC;"  width="10%" align="left"><b></b></td>
<td style="border-right:1px solid #CCCCCC; border-top:1px solid #CCCCCC;"  width="75%" align="left"><b>Total Amount</b></td>
<td style="border-top:1px solid #CCCCCC;"  width="15%" id="totamount"><b><?php echo $tot_amt; ?> INR</b></td>
                                                                                </tr>
<?php if(isset($discountamt)):?>
<tr> 
<td style="border-right:1px solid #CCCCCC; border-top:1px solid #CCCCCC;"  width="10%" align="left"><b></b></td>
<td style="border-right:1px solid #CCCCCC; border-top:1px solid #CCCCCC;"  width="75%" align="left"><b>Discount</b></td>
<td style="border-top:1px solid #CCCCCC;"  width="15%" id="totamount"><b><?php echo $discountamt; ?> INR</b></td>
                                                                                </tr>
<tr> 
<td style="border-right:1px solid #CCCCCC; border-top:1px solid #CCCCCC;"  width="10%" align="left"><b></b></td>
<td style="border-right:1px solid #CCCCCC; border-top:1px solid #CCCCCC;"  width="75%" align="left"><b>Final Amount</b></td>
<td style="border-top:1px solid #CCCCCC;"  width="15%" id="totamount"><b><?php echo $tot_amt-$discountamt; ?>INR</b></td>
                                                                                </tr>
<?php endif; ?>
									</table>
                                       
								</td>
							</tr>
						</table>

								</td>
							</tr>
									
						</table>