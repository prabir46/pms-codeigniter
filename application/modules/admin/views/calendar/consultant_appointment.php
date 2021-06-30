<?php 

								$appointmentspr =	$this->dashboard_model->get_todays_appointments_consultant($_POST['consultant_id']);
									?>
										 <?php $i=1;foreach ($appointmentspr as $new){
										 	$with="";
											if(($new->whom==1)){
												$with = $new->name;
											}
											if(($new->whom==2)){
												$with = $new->contact;
											}
											if(($new->whom==3)){
												$with = $new->other;
											}
										 ?>
                                        <li style="background:#<?php echo $new->Color; ?>;">
                                            <!-- drag handle -->
                                            <span class="handle ui-sortable-handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                            <!-- todo text -->
                                            <span class="text"><a href="<?php echo site_url('admin/appointments/view_appointment/'.$new->id); ?>"><?php echo date("h:i:a", strtotime($new->date))  ." - ". $with; ?> </a></span>
                                            <!-- Emphasis label -->
                                           
                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <i class="fa fa-eye"></i>
                                                
                                            </div>
                                        </li>
										<?php $i++;}?>
								