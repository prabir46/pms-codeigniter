<?php

header('Content-Type: "text/csv"');

header('Content-Disposition: attachment; filename="report_income.csv"');

header('Expires: 0');

header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

header("Content-Transfer-Encoding: binary");

header('Pragma: public');

?>

<?php
if(isset($income) && count($income)>1)
{	
	//print_r($income);exit();
	echo 'Sr.No.,Patient,Doctor,Pending Amount';
	echo "\n";
	
	
	for ($j=1;$j<count($income);$j++) {
		echo $j.",";
		for($i=0;$i<count($income[$j]);$i++) {
			echo $income[$j][$i].",";

			
		}
		echo "\n";
	}

	echo ",Total Pending,".$total_pending;
	echo "\n";
}

if(isset($balance) && count($balance)>0)
{
	echo 'Sr.No.,Patient,Doctor,Received Amount';
	echo "\n";
	
	foreach ($balance as $key1 => $record) {
		echo $key1.",";
		foreach ($record as $key2 => $value) {
			echo $value.",";
		}
		echo "\n";
	}
}
?>
<?php 
if(isset($table3) && count($table3)>0)
	{	echo "\n";
		echo 'Total Cash Amount,Total Cheque Amount,Total Card Amount,Total Online Amount';
		echo "\n";
		foreach ($table3 as $key => $value) {
		echo $value.",";
		}
		echo "\n";
	}
?> 