<?php

header('Content-Type: "text/csv"');

header('Content-Disposition: attachment; filename="report_expense.csv"');

header('Expires: 0');

header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

header("Content-Transfer-Encoding: binary");

header('Pragma: public');

?>
<?php echo 'Sr.No.'; ?>,<?php echo 'Details';?>,<?php echo 'Date';?>,<?php echo 'Amount';echo "\n";?>
<?php if(!empty($expenses)){
				$i=1;
				$total=0;
				foreach($expenses as $new){
					
					echo $i.",";
					echo $new->details.",";
					echo $new->date.",";
					echo $new->amount.",";
					echo "\n";
					$total+=$new->amount;
					$i++;
				}
				echo ',,Total Amount,'.$total;
				
			}
?>
							