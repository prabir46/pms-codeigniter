<?php 
if($setting->image!=""){
				$img ='<img src="'.site_url('assets/uploads/images/'.$data['setting']->image).'"  height="70" width="80" />';
			}else{
				$img ='';
			}
$date = new DateTime($prescription->dob);
$now = new DateTime();
$interval = $now->diff($date);			

?>		
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>PDF</title>
<style>
	.aligncenter { text-align:center !important }
  @font-face {
    font-family: shonar;
    src: url('<?php echo base_url('assets/fonts/kalpurush-ANSI.ttf')?>') format('true-type');
  }
  table{
    font-family:'shonar';
}


</style>
	</head>
<body>	
<table width="100%" border="0" id="render_me" lang="bn" style="padding-bottom:0px; height:100%">
						<thead>
						<tr>
							<td>
								<table width="100%" style="border-bottom:1px solid;">
									<tr>
										<td style="line-height:110%">
											<?php echo @$template->header;?>											
										</td>
										
									</tr>
								</table>
							</td>
						</tr>
						</thead>
						<tbody>	
						<tr>
							<td >
								<table width="100%">
									<tr>
										<td width="40%"><b><?php echo lang('name')?></b> : <?php echo substr($prescription->patient,0,20)?></td>
										<td width="18%"><b><?php echo lang('age')?></b> : <?php echo date("Y")-$prescription->dob?> Years</td>
										<td ><b><?php echo lang('sex')?></b> : <?php echo $prescription->gender?></td>
										<td ><b><?php echo lang('id')?></b> : <?php echo $prescription->prescription_id?></td>
										<td ><b><?php echo lang('date')?></b> : <?php echo date("d-m-y", strtotime($prescription->date_time))?></td>
									</tr>
								</table>	
							</td>
						</tr>
					
						<tr height="100%">
							<td valign="top">
								<table width="100%" border="0">
								
								
									<tr>
										<td width="51%" valign="top">
											<table width="80%" border="0">
											<?php //###########################################################Chiff Complaint################################################################################# ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>CHIEF COMPLAINT</b></td>
															</tr>
															<?php $d = json_decode($prescription->chiff_Complaint_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->chiff_Complaint_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
												<tr>
														<td width="100%">
															<table border="0" >
																<tr>
																	<td><b>Medical History</b></td>
																</tr>
																<?php $c = json_decode($prescription->medical_History_id);
																
																if(is_array($c)){
																	foreach($c as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$c.'</td></tr>';
																}
																?>
																<tr>
																	<td><?php echo $prescription->medical_History_history ?></td>
																</tr>
															</table>
														</td>
												</tr>
												

                                                
     <?php //############################################################################################################################################ ?>
     
      <?php //#########################################################durg allergy################################################################################### ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>DRUG ALLERGY</b></td>
															</tr>
															<?php $d = json_decode($prescription->drug_Allergy_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->drug_Allergy_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
     
  
           <?php //##########################################################Extra oral exm################################################################################## ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>EXTRA ORAL EXM.</b></td>
															</tr>
															<?php $d = json_decode($prescription->extra_Oral_Exm_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->extra_Oral_Exm_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
 <?php //#############################################################inter oral Exm############################################################################### ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>INTRA ORAL EXM.</b></td>
															</tr>
															<?php $d = json_decode($prescription->intra_Oral_Exm_id);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->intra_Oral_Exm_history;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
												
											</table>
										</td>
										<td valign="top">
											<table border="0" width="100%" >
												<tr>
													<td><p><span style="font-size:26px"><b>R</span ><sub style="font-size:18px">x</b></sub></p></td>
												</tr>
												<?php $d = json_decode($prescription->medicines);
													  $ins = json_decode($prescription->medicine_instruction);
													if(is_array($d)){
														$i=1;
														foreach($d as $key => $new){
														if(!empty($d[$key]))
															echo '<tr><td style="padding-left:18px;">'.$i.'. '.$d[$key] .'<td></tr>';
															echo '<tr><td><p style="padding-left:32px;"><small>'.@$ins[$key] .'</small></p><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td style="padding-left:18px;">'.$i.' '.$d.'<td></tr>';
														echo '<tr><td><p style="padding-left:32px;"><small>'.$ins.'</small></p><td></tr>';
													}	
													?>
												<tr>
                                              <tr>
													<td width="51%">
																<?php 
													$d = json_decode($prescription->tests);
													//echo '<pre>'; print_r($d);'</pre>';
													if(!empty($d[0])){?>
																	<table border="0" width="100%">
																		<tr>
																			<td><b><?php echo lang('test')?></b></td>
																		</tr>
																		<?php 
																			  $ins = json_decode($prescription->test_instructions);
																			if(is_array($d)){
																				$i=1;
																				foreach($d as $key => $new){
																				
																					echo '<tr><td>'.$i.'. '.$d[$key] .'<td></tr>';
																				if(!empty($ins[$key])){	
																					echo '<tr><td><p style="padding-left:14px;"><small>('.$ins[$key] .')</small></p><td></tr>';
																				}
																				 $i++;}
																			}else{
																				echo '<tr><td>'.$i.' '.$d.'<td></tr>';
																				echo '<tr><td><p style="padding-left:14px;"><small>( '.$ins.' )</small></p><td></tr>';
																			}	
																			?>
																	</table>	
															<?php } ?>		
																</td>
												</tr>
                                                 <?php //#############################################################Treatment Advised############################################################################### ?>                                         <tr>
													<td>
														<table border="0">
															<tr>
																<td><b>Treatment Advised</b></td>
															</tr>
															
															<tr>
																<td><?php
																 $d = json_decode($prescription->treatment_Advised_id);
																  $ins1 = json_decode($prescription->treatment_Advised_instruction);
													if(is_array($d)){
														$i=1;
														foreach($d as $key => $new){
														if(!empty($d[$key]))
															echo '<tr><td style="padding-left:18px;">'.$i.'. '.$d[$key] .'<td></tr>';
															echo '<tr><td><p style="padding-left:32px;"><small>'.@$ins1[$key] .'</small></p><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td style="padding-left:18px;">'.$i.' '.$d.'<td></tr>';
														echo '<tr><td><p style="padding-left:32px;"><small>'.$ins.'</small></p><td></tr>';
													}
																?></td>
														   </tr>		
														</table>
													</td>
												</tr>
                                                
     <?php //############################################################################################################################################ ?>
  
     
													<td>
														<?php if(!empty($prescription->remark)){?>
																<table width="100%" border="0">
																	<tr>
																		<td><b><?php echo lang('remark')?></b></td>
																	</tr>
																	<tr>
																		<td><?php echo $prescription->remark ?></td>
																	</tr>
																</table>
														<?php } ?>		
														</td>	
												</tr>	
											</table>	
										</td>
									</tr>
											
								</table>
							</td>
						</tr>
						
					</tbody>
                   
					<tfoot>	
                     <tr>	
                     <td><p><span style="font-size:20px"><b>Consent : </span ></b></p><p>I authorize the doctor to perform appropriate medical/dental  care for me/my patient. I also appoint him as my legal representative and authorize him to make decisions regarding medical/dental treatment.</p></td>
							
						</tr>
						<tr>	
							<td style="border-top:1px solid;" class="aligncenter">

								<?php echo @$template->footer;?>
							</td>
						</tr>
					</tfoot>
						
					</table>

                   	
                   	
</body>
 </html>

                   
								
						
						
					

