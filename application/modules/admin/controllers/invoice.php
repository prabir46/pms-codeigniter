<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class invoice extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();
		$this->load->model('invoice_model');
		$this->load->model('setting_model');
                $this->load->model('patient_model');
		error_reporting(0); 
	}
	
	
	function index($id=false){
		$data['details'] = $this->invoice_model->get_detail($id);
			
		$data['setting']   = $this->setting_model->get_setting();	
		$data['page_title'] = lang('invoice');
		$data['body'] = 'invoice/invoice';
		$this->load->view('template/main', $data);	

	}	
	
	function pdf($id=false){
		$this->load->helper('dompdf_helper');
		$this->load->helper('download');
		$data['details'] = $this->invoice_model->get_detail($id);
			
		$data['setting']   = $this->setting_model->get_setting();	
		$data['page_title'] = lang('invoice');
		$pdfFilePath =$data['details']->invoice.".pdf";
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		$pdf->autoLangToFont = true;
		
		
		//$data['body'] = 'invoice/pdf';
		$html = $this->load->view('invoice/pdf', $data,true);		
		$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
		pdf_create($html, 'Invoice_'.$data['details']->invoice);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, "I");
		

	}	

       function pdf_all($id=false){
               $this->load->helper('dompdf_helper');
	       $this->load->helper('download');
               $data['fees_all'] = $this->patient_model->get_patients_by_invoice($id);
               $data['setting']   = $this->setting_model->get_setting();	
	       $data['page_title'] = lang('invoice');
               $data['id'] = $id;
               $pdfFilePath =$id.".pdf";
               $this->load->library('m_pdf');     
	       $pdf = $this->m_pdf->load();
	       $pdf->autoLangToFont = true;

               $html = $this->load->view('invoice/pdf', $data,true);	
	       $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
	       pdf_create($html, 'Invoice#'.$id);
	       $pdf->WriteHTML($html);
	       $pdf->Output($pdfFilePath, "I");
       }
	
	
	public function mail($id=false)
	{ 
		$details = $this->invoice_model->get_detail($id);
			
		$data['setting']   = $this->setting_model->get_setting();	
	    $data['body'] = 'invoice/pdf';
		
			if($data['setting']->image!=""){
				$img ='<td align="left"><img src="'.site_url('assets/uploads/images/'.$data['setting']->image).'"  height="70" width="80" /></td>';
			}else{
				$img ='<td align="left"><img src="'.site_url('assets/img/doctor_logo.png/').'"  height="70" width="80" /></td>';
			}
			
		$message = '
						<html>
							<head>
								<title>Invoice</title>
							</head>
							<body>
						<table width="100%" border="0"  id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											'.$img.'
											<td align="right">
												<b>'.lang('invoice_number').' #'.$details->invoice.'</b><br />
												
												<b>'.lang('payment_mode') .':</b>'.$details->mode.'<br/>
												
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
												 <strong>'.@$setting->name .'</strong><br>
										   '.@$setting->address .'<br>
											'.lang('phone').': '.@$setting->contact.'<br/>
											'.lang('email').': '.@$setting->email .'		
											
											</td>
											<td align="right" colspan="2">Bill To<br />
											
											<strong>'.$details->patient.'</strong><br>
											'.$details->address.' <br>
											'.lang('phone').': '.$details->contact.'<br/>
											'.lang('email').': '.$details->email.'
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
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="55%" align="left"><b>Entry</b></td>
                                            <td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="20%"><b>Date</b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="20%"><b>Price</b></td>
										</tr>';
										 error_reporting(0);
											  $d = json_decode($details->treatment_Advised_id);
											  	  $ins1 = json_decode($details->dates);
												   $bal = json_decode($details->balance);
											 if(is_array($d)){
														$i=1;
														echo "Total Amount : ". $details->amount." INR";
														foreach($d as $key => $new){ 
														if(!empty($d[$key]))
										$message .='<tr >
											 <td width="5%" style="border-right:1px solid #CCCCCC" >'.$i.'</td>
                                             
											 <td width="55%" style="border-right:1px solid #CCCCCC">';
											
														
														if(!empty($d[$key])){
															echo $d[$key];
														
														$i++; 
													}else{
														echo $d;
														
													}
											$message .='</td>
                                             <td width="20%" style="border-right:1px solid #CCCCCC"  >';
												
														if(!empty($ins1[$key])){
															echo $ins1[$key];
														
														
													}else{
														echo $ins1[$key];
														}
													
											 $message .='</td>
											 <td width="20%" style="border-right:1px solid #CCCCCC"  >';
														if(!empty($bal[$key])){
															echo $bal[$key];
														
														 
													}else{
														echo $bal[$key];
														} 
														$message .='</td>
											
										</tr>
                                          '; }
													}else{
														echo $d;
														
													}  
									$message .='</table>';
                                    echo $details->status;
								$message .='</td>
							</tr>
									</table>
								</td>
							</tr>
						</table>
							</body>
						</html>
				';
		
		$this->load->library('email');
		$this->load->helper('string');    
		/*$config = array(
				'protocol' => "smtp",
				'smtp_host' => "ssl://smtp.gmail.com",
				'smtp_port' => "465",
				'smtp_user' => "",
				'smtp_pass' => "",
				'charset' => "utf-8",
				'mailtype' => "html",
				'newline' => "\r\n"
			);*/
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		

        $this->load->library('email', $config);
			
		$this->email->initialize($config);
		
													
			
			//echo '<pre>';print_r($message);exit;
			$this->email->from($data['setting']->email,$data['setting']->name);
			
			$email = $details->email;
			$this->email->to($email);
			$this->email->subject('Invoice');
			$this->email->message(html_entity_decode($message,ENT_QUOTES, 'UTF-8'));
			$sent = $this->email->send();
			$this->session->set_flashdata('message', 'Mail sent successfully');
			redirect('admin/payment');
	}
	
	
		
	
	
}