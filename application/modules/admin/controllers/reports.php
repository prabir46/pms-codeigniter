<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model("reports_model");
		$this->load->model("doctor_model");
		$this->load->model("consultant_model");
		$this->load->model("notification_model");
        $this->load->model("treatment_advised_model");
         $this->load->model("expenses_model");
	}
	
	
	function index(){
		
			
			 
		
			for($i = 30; $i > -1; $i--)
			{
				
				$data['date'][$i]	=	$this->reports_model->get_earning_by_dates(date('Y-m-d', strtotime("- ".$i." days")));
			}
			
			for($i = 6; $i > -1; $i--)
			{
				
				$data['week_data'][date('Y-m-d', strtotime("- ".$i." days"))]	=	$this->reports_model->get_earning_by_dates(date('Y-m-d', strtotime("- ".$i." days")));
				//echo date('Y-m-d', strtotime("- ".$i." days"));
			}
			
			//echo '<pre>'; print_r($data['week_data']);die;
		
		$data['months'] = $this->reports_model->get_earning_by_month();
		$data['weeks'] = $this->reports_model->get_earning_by_week();
		$data['years'] = $this->reports_model->get_earning_by_year();
		$data['clients'] = $this->reports_model->get_earning_by_patient();
		
		$data['page_title'] = lang('reports');
		$data['body'] = 'reports/reports';
		$this->load->view('template/main', $data);          	

	}	

        function year(){
           $year = $this->input->post('year');
           $consultant = $this->input->post('consultant');
           $select_treatment=$this->input->post('select_treatment');
           $select_group=$this->input->post('select_group');
           $dummy_date = $year."-01-01";
           $dummy_date2 = ($year+1)."-12-31";
           $date1 = date('Y-01-01', strtotime($dummy_date));
           $date2 = date('Y-12-31', strtotime($dummy_date2));
           $result=$this->reports_model->dates($date1,$date2,$consultant,$select_treatment,$select_group);
           $b[] = '';
           $t_total=0;
	   $t_pend=0;
	   $t_balance=0;
	   $cheque=0;
	   $card=0;
	   $cash=0;
	   $sr=0;
	   $online=0;
        
	   foreach($result as $ind => $datasd) {
		$sr++;
	    $p_treat = json_decode($datasd->treatment_Advised_id);
	$treatu=$datasd->treatment_Advised_id;
		$pid=$datasd->patient_id;
		$cid=$datasd->consultant;
		$p_gender='';
		$p_contact='';
                if($cid==0){
                continue;
                }
		$names=$this->reports_model->p($pid);
		$cnames=$this->reports_model->consultantbyId($cid);
		$p_name='';
		$c_name='';

		foreach($names as $ind => $namesss) {
			$p_name=$namesss->name;
			$pid=$namesss->id;
			$p_gender = $namesss->gender;
			$p_contact = $namesss->contact;
		}
		foreach($cnames as $cind => $cnamesss) {
			$c_name=$cnamesss->name;
			
		}
		$balance=json_decode($datasd->credit);
		if($datasd->payment_mode_id==1){
			$cash=$cash+$balance;
		}
		if($datasd->payment_mode_id==2){
			$cheque=$cheque+$balance;
		}
		if($datasd->payment_mode_id==3){
			$card=$card+$balance;
		}
		if($datasd->payment_mode_id==4){
			$online=$online+$balance;
		}
		if (in_array($pid, $b)){
		
		}else{
			$b[]=$pid;
			$total=$datasd->credit;
			$t_total=$t_total+$total;
		}

		$admin = $this->session->userdata('admin');
		$t_balance=$t_balance+$balance;
		$t_pend=$t_total-$t_balance;
		$pending=$datasd->status;
		$pppid="'".$pid."'";
		if($balance ==0){}else{
		echo '<tbody style="cursor:pointer" onclick="pr('.$pppid.')"><tr>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC" id="'.$pid.'"  width="5%" align="left"><b>'.$sr.'</b></td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" id="'.$pid.'" align="left">'.$p_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" id="'.$pid.'" align="left">'.$p_gender.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" id="'.$pid.'" align="left">'.$p_contact.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.$c_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">'.$balance.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.$treatu.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" id="'.$pid.'" align="left">'.$pending.'</td>
		</tr></tbody>'; }
}
		echo '</table><table  width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b></b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left"><b></b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left">'.$t_total.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">'.$t_balance.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left">'.$t_pend.'</td></tr></table>';
		echo '<table  width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Cash Amount= '.$cash.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Cheque Amount= '.$cheque.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Card Amount= '.$card.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Online Amount= '.$online.'</td></tr></table>';
        }

        function month(){
           $month = $this->input->post('month');
           $consultant = $this->input->post('consultant');
           $select_treatment=$this->input->post('select_treatment');
           $select_group=$this->input->post('select_group');
           $dummy_date = $month."-10";
           $date1 = date('Y-m-01', strtotime($dummy_date));
           $date2 = date('Y-m-31', strtotime($dummy_date));
           
           $result=$this->reports_model->dates($date1,$date2,$consultant,$select_treatment,$select_group);
           $b[] = '';
           $t_total=0;
	   $t_pend=0;
	   $t_balance=0;
	   $cheque=0;
	   $card=0;
	   $cash=0;
	   $sr=0;
	   $online=0;
        
	   foreach($result as $ind => $datasd) {
		$sr++;
	$p_treat = json_decode($datasd->treatment_Advised_id);
	$treatu=$datasd->treatment_Advised_id;
		$pid=$datasd->patient_id;
		$cid=$datasd->consultant;
		$p_gender='';
		$p_contact='';
                if($cid==0){
                continue;
                }
		$names=$this->reports_model->p($pid);
		$cnames=$this->reports_model->consultantbyId($cid);
		$p_name='';
		$c_name='';

		foreach($names as $ind => $namesss) {
			$p_name=$namesss->name;
			$pid=$namesss->id;
			$p_gender = $namesss->gender;
			$p_contact = $namesss->contact;
		}
		foreach($cnames as $cind => $cnamesss) {
			$c_name=$cnamesss->name;
			
		}
		$balance=json_decode($datasd->credit);
		if($datasd->payment_mode_id==1){
			$cash=$cash+$balance;
		}
		if($datasd->payment_mode_id==2){
			$cheque=$cheque+$balance;
		}
		if($datasd->payment_mode_id==3){
			$card=$card+$balance;
		}
		if($datasd->payment_mode_id==4){
			$online=$online+$balance;
		}
		if (in_array($pid, $b)){
		
		}else{
			$b[]=$pid;
			$total=$datasd->credit;
			$t_total=$t_total+$total;
		}

		$admin = $this->session->userdata('admin');
		$t_balance=$t_balance+$balance;
		$t_pend=$t_total-$t_balance;
		$pending=$datasd->status;
		$pppid="'".$pid."'";
		if($balance ==0) {
		    
		}else{
		echo '<tbody style="cursor:pointer" onclick="pr('.$pppid.')">
		<tr>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC" id="'.$pid.'"  width="5%" align="left"><b>'.$sr.'</b></td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" id="'.$pid.'" align="left">'.$p_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" id="'.$pid.'" align="left">'.$p_gender.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" id="'.$pid.'" align="left">'.$p_contact.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.$c_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">'.$balance.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.$treatu.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" id="'.$pid.'" align="left">'.$pending.'</td>
		</tr></tbody>'; 
		    
		}
        }
		echo '</table><table  width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b></b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left"><b></b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left">'.$t_total.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">'.$t_balance.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left">'.$t_pend.'</td></tr></table>';
		echo '<table  width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Cash Amount= '.$cash.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Cheque Amount= '.$cheque.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Card Amount= '.$card.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Online Amount= '.$online.'</td></tr></table>';
               
        }
	
	function dates(){
	$b[]='';
	$date1 = $this->input->post('date1');
	$date2 = $this->input->post('date2');
	$paid= $this->input->post('paid');
	$select_consultant= $this->input->post('select_consultant');
    $select_treatment=$this->input->post('select_treatment');
    
    $select_group=$this->input->post('select_group');
	$excludeDiscount = $this->input->post('discount');
	
	$datee1='"'.$date1.'"';
	$datee2='"'.$date2.'"';
	$t_total=0;
	$t_pend=0;
	$t_balance=0;
	$cheque=0;
	$card=0;
	$cash=0;
	$sr=0;
	$online=0;

	//echo '<br>Paid : '.$paid;die;
       if($paid==1){
       $result_p =$this->reports_model->pending_fee($select_consultant);
       $ptotal =0;
          foreach($result_p as $ind => $datasd) {
		$sr++;
         $treatu1=$datasd->treatment_Advised_id;
         $treatu = str_replace( array( '\'', '"', ',' , '[', ']', '>' ), ' ', $treatu1);
		$pid=$datasd->patient_id;
		$cid=$datasd->consultant;
                if($cid==0){
                 continue;
                }
		$names=$this->reports_model->p($pid);
		$cnames=$this->reports_model->consultantbyId($cid);
		$p_name='';
		$c_name='';
		$p_gender='';
		$p_contact='';

		foreach($names as $ind => $namesss) {
			$p_name=$namesss->name;
			$pid=$namesss->id;
			$p_gender = $namesss->gender;
			$p_contact = $namesss->contact;
			
		}
		foreach($cnames as $cind => $cnamesss) {
			$c_name=$cnamesss->name;
			
		}
		
		

		$admin = $this->session->userdata('admin');
		$total_c1=$datasd->totalcredit;
		$total_d1=$datasd->totaldebit;
		$total_b1=0;
		$total_b1=$total_c1-$total_d1;
		//$pending=$datasd->total;
		$ptotal = $ptotal + $total_b1;
		$pppid="'".$pid."'";
		if($total_b1 == 0){}else{
		echo '<tbody style="cursor:pointer" onclick="pr('.$pppid.')"><tr>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC" id="'.$pid.'"  width="5%" align="left"><b>'.$sr.'</b></td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" id="'.$pid.'" align="left">'.$p_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" id="'.$pid.'" align="left">'.$p_gender.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" id="'.$pid.'" align="left">'.$p_contact.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.$c_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.abs($total_b1).'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.$treatu.'</td></tr></tbody>';
		}
}
echo '</table><table  id="example2" width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="3%" align="left"><b></b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="30%" align="left"><b>Total Pending Amount</b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="15%" align="left">'.abs($ptotal).'</td></tr></table>';

       }else{
        
        $result=$this->reports_model->dates($date1,$date2,$select_consultant,$select_treatment,$select_group,$excludeDiscount);
		
        $pres_template= $this->notification_model->get_template();
        if($pres_template->header !='' && $pres_template->header !=NULL){
		 echo '<img id="exa1" src="' . $pres_template->header . '" width="100%" height="auto" />';
        }else{
            echo '';
        }
		//echo '<pre>'; print_r($result); echo '</pre>';die;
	foreach($result as $ind => $datasd) {
		
	
		$pid=$datasd->patient_id;
		$treatu=$datasd->treatment_Advised_id;
		$cid=$datasd->consultant;
		$names=$this->reports_model->p($pid);
		$cnames=$this->reports_model->consultantbyId($cid);
		$p_name='';
		$c_name='';
	    $p_gender='';
		$p_contact='';

		foreach($names as $ind => $namesss) {
			$p_name=$namesss->name;
			$pid=$namesss->id;
			$p_gender = $namesss->gender;
			$p_contact = $namesss->contact;
		}
		foreach($cnames as $cind => $cnamesss) {
			$c_name=$cnamesss->name;
			
		}
		$balance=json_decode($datasd->credit);
		if($datasd->payment_mode_id==1){
			$cash=$cash+$balance;
		}
		if($datasd->payment_mode_id==2){
			$cheque=$cheque+$balance;
		}
		if($datasd->payment_mode_id==3){
			$card=$card+$balance;
		}
		if($datasd->payment_mode_id==4){
			$online=$online+$balance;
		}
		if (in_array($pid, $b)){
		
		}else{
			$b[]=$pid;
			$total=$datasd->credit;
			$t_total=$t_total+$total;
		}

		$admin = $this->session->userdata('admin');
		$t_balance=$t_balance+$balance;
		$t_pend=$t_total-$t_balance;
		$pending=$datasd->status;
		$pppid="'".$pid."'";
		if($paid==1){
			$balance=$balance;
		}
		if($balance ==0){}else{
		$sr++;
		//echo  $pres_template->header;
		//print_r($pres_template);
		echo '<tbody style="cursor:pointer" onclick="pr('.$pppid.')"><tr>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC" id="'.$pid.'"  width="5%" align="left"><b>'.$sr.'</b></td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" id="'.$pid.'" align="left">'.$p_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" id="'.$pid.'" align="left">'.$p_gender.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" id="'.$pid.'" align="left">'.$p_contact.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="15%"  id="'.$pid.'"align="left">'.$c_name.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="15%" align="left">'.$balance.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;"  width="25%"  id="'.$pid.'"align="left">'.$treatu.'</td>
		<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" id="'.$pid.'" align="left">'.$pending.'</td>
		</tr></tbody>'; }
}
		echo '</table><table id="example2" width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="5%" align="left"><b></b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="53%" align="left"><b></b></td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left">'.$t_total.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">'.$t_balance.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC;display:none;"  width="25%" align="left">'.$t_pend.'</td></tr></table>';
		echo '<table id="example3" width="100%" style="border:1px solid #CCCCCC;" ><tr><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Cash Amount= '.$cash.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Cheque Amount= '.$cheque.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Card Amount= '.$card.'</td><td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="25%" align="left">Total Online Amount= '.$online.'</td></tr></table>';
  }
  
    echo '<div class="row" style="margin-bottom:10px;"> <div class="col-xs-12"> <div class="btn-group pull-left">';
        echo '<form method="post" action="' . site_url('admin/reports/export_income/') . '" enctype="multipart/form-data">';
        echo '<input type="hidden" name="date1" value="' . $this->input->post('date1') . '">';
        echo '<input type="hidden" name="date2" value="' . $this->input->post('date2') . '">';
        echo '<input type="hidden" name="paid" value="' . $this->input->post('paid') . '">';
        echo '<input type="hidden" name="paid2" value="' . $this->input->post('paid2') . '">';
        echo '<input type="hidden" name="select_consultant" value="' . $this->input->post('select_consultant') . '">';


echo '<button class="btn btn-default" onclick="printIncome()"><i class="fa fa-print"></i> Print</button>';
 echo '<button class="btn btn-danger" type="submit" style="margin-left:12px;"><i class="fa fa-download"></i> ' . lang("export") . '</button>';
     
        
        echo '</form> </div></div> </div>';
}







     
 function export_income() {

        $b[] = '';
        $date1 = $this->input->post('date1');
        $date2 = $this->input->post('date2');
        $paid = $this->input->post('paid');
        $select_consultant = $this->input->post('select_consultant');

        $datee1 = '"' . $date1 . '"';
        $datee2 = '"' . $date2 . '"';
        $t_total = 0;
        $t_pend = 0;
        $t_balance = 0;
        $cheque = 0;
        $card = 0;
        $cash = 0;
        $sr = 0;
        $online = 0;
        $income = array(array());
        $total_pending = 0;
        $balance_record = array();
        $select_group='';
        $select_treatment='';

        if ($paid == 1) {
            $result_p = $this->reports_model->pending_fee($select_consultant);
            $ptotal = 0;
            foreach ($result_p as $ind => $datasd) {
                $sr++;

                $pid = $datasd->patient_id;
                $cid = $datasd->consultant;

                $names = $this->reports_model->p($pid);
                $cnames = $this->reports_model->consultantbyId($cid);
                $p_name = '';
                $c_name = '';

                foreach ($names as $ind => $namesss) {
                    $p_name = $namesss->name;
                    $pid = $namesss->id;
                }
                foreach ($cnames as $cind => $cnamesss) {
                    $c_name = $cnamesss->name;
                }



                $admin = $this->session->userdata('admin');
                $total_c1 = $datasd->totalcredit;
                $total_d1 = $datasd->totaldebit;
                $total_b1 = 0;
                $total_b1 = $total_c1 - $total_d1;
                //$pending=$datasd->total;
                $ptotal = $ptotal + $total_b1;
                $pppid = "'" . $pid . "'";
                if ($total_b1 == 0) {

                } else {
                    array_push($income, array($p_name, $c_name, abs($total_b1)));
                }
                $total_pending = abs($ptotal);
            }
        } else {
            $result = $this->reports_model->dates($date1, $date2, $select_consultant,$select_treatment,$select_group);
          //  $expenses = $this->expenses_model->dates($date1, $date2);

            foreach ($result as $ind => $datasd) {
                $sr++;

                $pid = $datasd->patient_id;
                $cid = $datasd->consultant;
                if ($cid == 0) {
                    continue;
                }
                $names = $this->reports_model->p($pid);
                $cnames = $this->reports_model->consultantbyId($cid);
                $p_name = '';
                $c_name = '';

                foreach ($names as $ind => $namesss) {
                    $p_name = $namesss->name;
                    $pid = $namesss->id;
                }
                foreach ($cnames as $cind => $cnamesss) {
                    $c_name = $cnamesss->name;
                }
                $balance = json_decode($datasd->credit);
                if ($datasd->payment_mode_id == 1) {
                    $cash = $cash + $balance;
                }
                if ($datasd->payment_mode_id == 2) {
                    $cheque = $cheque + $balance;
                }
                if ($datasd->payment_mode_id == 3) {
                    $card = $card + $balance;
                }
                if ($datasd->payment_mode_id == 4) {
                    $online = $online + $balance;
                }
                if (in_array($pid, $b)) {

                } else {
                    $b[] = $pid;
                    $total = $datasd->credit;
                    $t_total = $t_total + $total;
                }

                $admin = $this->session->userdata('admin');
                $t_balance = $t_balance + $balance;
                $t_pend = $t_total - $t_balance;
                $pending = $datasd->status;
                $pppid = "'" . $pid . "'";
                if ($paid == 1) {
                    $balance = $balance;
                }
                if ($balance == 0) {

                } else {
                    array_push($balance_record, array($p_name, $c_name, $balance));
                }
            }
            $data['table3'] = array($cash, $cheque, $card, $online);
        }
        $data['income'] = $income;
        $data['total_pending'] = $total_pending;
        $data['balance'] = $balance_record;

        $this->load->view('reports/export_income', $data);
    }

   /* function export_expense() {
        $b[] = '';

        $date1 = $this->input->post('date1');
        $date2 = $this->input->post('date2');
        $paid = $this->input->post('paid');
        $select_consultant = $this->input->post('select_consultant');

        $datee1 = '"' . $date1 . '"';
        $datee2 = '"' . $date2 . '"';
        $t_total = 0;
        $t_pend = 0;
        $t_balance = 0;
        $cheque = 0;
        $card = 0;
        $cash = 0;
        $sr = 0;
        $online = 0;

        $result = $this->reports_model->dates($date1, $date2, $select_consultant);
        $expenses = $this->expenses_model->dates($date1, $date2);

        foreach ($result as $ind => $datasd) {
            $sr++;

            $pid = $datasd->patient_id;
            $cid = $datasd->consultant;
            if ($cid == 0) {
                continue;
            }
            $names = $this->reports_model->p($pid);
            $cnames = $this->reports_model->consultantbyId($cid);
            $p_name = '';
            $c_name = '';

            foreach ($names as $ind => $namesss) {
                $p_name = $namesss->name;
                $pid = $namesss->id;
            }
            foreach ($cnames as $cind => $cnamesss) {
                $c_name = $cnamesss->name;
            }
            $balance = json_decode($datasd->credit);
            if ($datasd->payment_mode_id == 1) {
                $cash = $cash + $balance;
            }
            if ($datasd->payment_mode_id == 2) {
                $cheque = $cheque + $balance;
            }
            if ($datasd->payment_mode_id == 3) {
                $card = $card + $balance;
            }
            if ($datasd->payment_mode_id == 4) {
                $online = $online + $balance;
            }
            if (in_array($pid, $b)) {

            } else {
                $b[] = $pid;
                $total = $datasd->credit;
                $t_total = $t_total + $total;
            }

            $admin = $this->session->userdata('admin');
            $t_balance = $t_balance + $balance;
            $t_pend = $t_total - $t_balance;
            $pending = $datasd->status;
            $pppid = "'" . $pid . "'";
            if ($paid == 1) {
                $balance = $balance;
            }
            if ($balance == 0) {

            } else {

            }
        }


        $data['expenses'] = $expenses;
        $this->load->view('reports/export_expense', $data);
    }*/

}
		
	

