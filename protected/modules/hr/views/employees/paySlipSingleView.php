<?php
echo "<div class='printBtn'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
    ),
    'publishCss' => FALSE, //publish the CSS for the whole page?
    'visible' => Yii::app()->user->checkAccess('print'), //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div'         //id of the print link
));
echo "</div>";
?>
<div class='printAllTableForThisReport'>
    <span class="reportTitle">
        <?php
            $companyDetails=YourCompany::model()->activeInfo();
            if($companyDetails){
                $companyName=$companyDetails->company_name;
				$companylocation=$companyDetails->location;
				$companyroad=$companyDetails->road;
				$companyhouse=$companyDetails->house;
                echo $companyName."<br>".$companyroad.', '.$companyhouse.', '.$companylocation."<br>";
            }
        ?>
    </span>
    
    <table class="reportTab">
    <?php echo $message; ?>
        <tr>
        	<td colspan="2" style="vertical-align:top !important;">
            	<table class="reportTab">
                	<tr>
                        <th style="font-size:12px;">EARNINGS</th>
                        <th style="font-size:12px;">TAKA</th>
                   	</tr>
                    <tr>
						<?php
                        if ($salaryData) {
                            $totalEarning=0; 
                            $totalDeduct=0;
                            $sl = 1;
                            foreach ($salaryData as $salD) {
                                $ahProllData=AhProllNormal::model()->findByPk($salD->ah_proll_normal_id);
                                if($ahProllData){
                                $ahHead=$ahProllData->title;
                                if($ahProllData->ac_type==AhProllNormal::EARNING){
                               ?>
                    	<td class="textAlgnLeft">
                        <?php
						echo "<font style='font-weight:bold;'>$ahHead</font>";
						/*if ($salD->percentage_of_ah_proll_normal_id) {
							echo " (" . AhAmounProllNormal::model()->percengateAmount($salD->percentage_of_ah_proll_normal_id, $salD->amount_adj) . ")";
						}*/
						?>
                        </td>
                        <td class="textAlgnRight">
							<?php
                            if ($salD->earn_deduct_type == AhAmounProllNormal::DAILY_BASIS) { // daily basis
                                $amount = $totalPresentDay * $salD->amount_adj;
                            } else { // monthly basis
                                $amount = $salD->amount_adj;
                            }
                            echo number_format(floatval($amount), 2);
                            ?>
                        </td>
                    </tr>
						<?php
                            $totalEarning=$amount+$totalEarning;
                                }
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td class="textAlgnLeft heightLight" style="font-size:12px; font-weight:bold; text-align:left">Sub Total</td>
                        <td class="textAlgnRight heightLight" style="font-size:12px; font-weight:bold; text-align:right"><?php echo number_format(floatval($totalEarning), 2); ?></td>
                	</tr>
            	</table>
      		</td>
            <td colspan="2" style="vertical-align:top !important;">
            	<table class="reportTab">
                	<tr>
                        <th width="60%" style="font-size:12px;">DEDUCTS</th>
                        <th width="40%" style="font-size:12px;">TAKA</th>
                    </tr>
                    <tr>
                    	<?php
						$sl = 1;
							foreach ($salaryData as $salD) {
							$ahProllData=AhProllNormal::model()->findByPk($salD->ah_proll_normal_id);
							if($ahProllData){
							$ahHead=$ahProllData->title;
							if($ahProllData->ac_type==AhProllNormal::DEDUCTION){
							?>
                    	<td class="textAlgnLeft">
							<?php
                            echo "<font style='font-weight:bold;'>$ahHead</font>";
                            /*if ($salD->percentage_of_ah_proll_normal_id) {
                                echo " (" . AhAmounProllNormal::model()->percengateAmount($salD->percentage_of_ah_proll_normal_id, $salD->amount_adj) . ")";
                            }*/
                            ?>
                        </td>
                        <td class="textAlgnRight">
							<?php
                            if ($salD->earn_deduct_type == AhAmounProllNormal::DAILY_BASIS) { // daily basis
                                $amount = $totalPresentDay * $salD->amount_adj;
                            } else { // monthly basis
                                $amount = $salD->amount_adj;
                            }
                            echo number_format(floatval($amount), 2);
                            ?>
                        </td>
                    </tr>
						<?php
							$totalDeduct=$amount+$totalDeduct;
							}
						}
					}
					?>
                    <tr>
                    <?php
						//=================================== Current/ Long Term Loan ==========================================//
						$conditionLong = "employee_id=" . $empId . " AND transaction_date < '" . $endDate . "' AND is_approved=" . AdvancePayRecv::APPROVED. " AND adv_pay_type!=" . AdvancePayRecv::PF;
        				$dataLong = AdvancePayRecv::model()->findAll(array('condition' => $conditionLong), 'id');
						$acRecvblAmountPrMnthTotal = 0;
						$amountReceivedTotal = 0;
						$amountReceivedTotalCurrent = 0;
						$acRecvblAmountPrMnthTotalCurrent = 0;
						if ($dataLong) {
							foreach ($dataLong as $dl):
								if ($dl->adv_pay_type == AdvancePayRecv::LONG_TERM) {
									if ($dl->payOrReceive == AdvancePayRecv::PAY) {
										$d1 = new DateTime($dl->transaction_date); // stored date
										$d2 = new DateTime($endDate); // given date
										$interval = $d2->diff($d1);
										$dateDiff = round($interval->format('%m')+1);
										if ($dateDiff <= $dl->no_of_month) {
											
											$remainingBalance = $dl->amount-(($dateDiff-1) * $dl->installment);
											if($remainingBalance<$dl->installment){
												$amountWithInstallMent = $remainingBalance;
											}else{
												$amountWithInstallMent = $dl->installment;
											}
											
											$amountWithInterest = ($amountWithInstallMent * ($dl->interest / 100));
											$acRecvblAmountPrMnth = $amountWithInstallMent + $amountWithInterest;
											$acRecvblAmountPrMnthTotal = $acRecvblAmountPrMnth + $acRecvblAmountPrMnthTotal;
										}
									} else {
										$amountReceivedTotal = $dl->amount + $amountReceivedTotal;
									}
								} else {
									if ($dl->payOrReceive == AdvancePayRecv::PAY) {
										$d1 = new DateTime($dl->transaction_date); // stored date
										$d2 = new DateTime($endDate); // given date
										$interval = $d2->diff($d1);
										$dateDiff = round($interval->format('%m')+1);
										if ($dateDiff <= $dl->no_of_month) {
										$acRecvblAmountPrMnthTotalCurrent = $dl->amount + $acRecvblAmountPrMnthTotalCurrent;
										}
									} else {
										$amountReceivedTotalCurrent = $dl->amount + $amountReceivedTotalCurrent;
									}
								}
							endforeach;
						}
							$duductableAmountLong = $acRecvblAmountPrMnthTotal - $amountReceivedTotal;
							
							$duductableAmountLongCurrent = $acRecvblAmountPrMnthTotalCurrent - $amountReceivedTotalCurrent;
							
							if ($duductableAmountLong > 0)
								$duductableAmountLong = $duductableAmountLong;
							else
								$duductableAmountLong=$acRecvblAmountPrMnthTotal;
						?>
                        <td class="textAlgnLeft">Advance Salary (Loan)</td>
                        <td class="textAlgnRight"><?php echo number_format(floatval($duductableAmountLong), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="textAlgnLeft">Temporary adv. agt. Salary</td>
                        <td class="textAlgnRight"><?php echo number_format(floatval($duductableAmountLongCurrent), 2); ?></td>
                    </tr>
                    <?php
						//=============================================== PF Loan ==================================================//
						$conditionPf = "employee_id=" . $empId . " AND transaction_date < '" . $endDate . "' AND is_approved=" . AdvancePayRecv::APPROVED . " AND adv_pay_type=" . AdvancePayRecv::PF;
						$dataPf = AdvancePayRecv::model()->findAll(array('condition' => $conditionPf), 'id');
						$pfAcRecvblAmountPrMnthTotal = 0;
						$pfAmountReceivedTotal = 0;
						$pfAmountReceivedTotalCurrent = 0;
						$pfAcRecvblAmountPrMnthTotalCurrent = 0;
						$amountWithInterest = 0;
						if ($dataPf) {
							foreach ($dataPf as $dpf):
								if ($dpf->adv_pay_type == AdvancePayRecv::PF) {
									if ($dpf->payOrReceive == AdvancePayRecv::PAY) {
										$d1 = new DateTime($dpf->transaction_date); // stored date
										$d2 = new DateTime($endDate); // given date
										$interval = $d2->diff($d1);
										$dateDiff = round($interval->format('%m')+1);
										if ($dateDiff <= $dpf->no_of_month) {
											
											$pfremainingBalance = $dpf->amount-(($dateDiff-1) * $dpf->installment);
											if($pfremainingBalance<$dpf->installment){
												$pfAmountWithInstallMent = $pfremainingBalance;
											}else{
												$pfAmountWithInstallMent = $dpf->installment;
											}											
											
											$amountWithInterest = ($pfAmountWithInstallMent * ($dpf->interest / 100));
											$pfAcRecvblAmountPrMnth = $pfAmountWithInstallMent;
											$pfAcRecvblAmountPrMnthTotal = $pfAcRecvblAmountPrMnth + $pfAcRecvblAmountPrMnthTotal;
										}
									} else {
										$pfAmountReceivedTotal = $dpf->amount + $pfAmountReceivedTotal;
									}
								} else {
									if ($dpf->payOrReceive == AdvancePayRecv::PAY) {
										$pfAcRecvblAmountPrMnthTotalCurrent = $dpf->amount + $pfAcRecvblAmountPrMnthTotalCurrent;
									} else {
										$pfAmountReceivedTotalCurrent = $dpf->amount + $pfAmountReceivedTotalCurrent;
									}
								}
							endforeach;
						}
				
						$duductableAmountPf = $pfAcRecvblAmountPrMnthTotal - $pfAmountReceivedTotal;
						
						$duductableAmountPfCurrent = $pfAcRecvblAmountPrMnthTotalCurrent - $pfAmountReceivedTotalCurrent;
						
						if ($duductableAmountPf > 0)
							$duductableAmountPf = $duductableAmountPf;
						else
							$duductableAmountPf=$pfAcRecvblAmountPrMnthTotal;
						$totalLoanAndDeduct=$duductableAmountLong+$duductableAmountLongCurrent+$totalDeduct+$duductableAmountPf+$amountWithInterest;
						?>
                    <tr>
                        <td class="textAlgnLeft">Loan From PF</td>
                        <td class="textAlgnRight"><?php echo number_format(floatval($duductableAmountPf), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="textAlgnLeft">PF Loan Profit</td>
                        <td class="textAlgnRight"><?php echo number_format(floatval($amountWithInterest), 2); ?></td>
                    </tr>
                    <tr>
                        <td class="textAlgnLeft heightLight" style="font-size:12px; font-weight:bold; text-align:left">Sub Total</td>
                        <td class="textAlgnRight heightLight" style="font-size:12px; font-weight:bold; text-align:right"><?php echo number_format(floatval($totalLoanAndDeduct), 2); ?></td>
                    </tr>
                    <?php
                       $totalGross=$totalEarning-$totalLoanAndDeduct;
                    ?>
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px; font-weight:bold; text-align:right">Total Gross Salary</td>
            <td style="font-size:12px; font-weight:bold; text-align:right; padding-right: 9px;"><?php echo number_format(floatval($totalGross), 2); ?></td>
        </tr>
        <?php
            $eachDaySalary=$totalEarning/$working_day;
            $totalNet=$totalGross-($eachDaySalary*$unApprovedLeaveCurrMonth);
        ?>
        <tr>
            
            <td colspan="" style="font-size:12px; font-weight:bold" class="textAlgnRight heightLight">Total Net Amount Payable</td>
            <td style="font-size:12px; font-weight:bold; padding-right: 9px;" class="textAlgnRight heightLight"><?php echo number_format(floatval($totalNet), 2); ?></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size:12px; text-align:left; font-weight:bold;">In Word (TK): <?php $amountInWord = new AmountInWord(); echo $amountInWord->convert(intval($totalNet)); ?></td>
        </tr>
        <tr>
            <td colspan="6" align="left" valign="top">
				<table width="100%" class="listtable" border="0" cellspacing="0" cellpadding="0">
					<tr style="border:1px #666666; padding:0px">
                        <td width="50%" colspan="3" style="text-align: right; font-weight: bold; padding-top:55px;">Employee Signature</td>
                        <td width="50%" colspan="3" style="text-align: right; font-weight: bold; padding-top:55px;">Admin Signature</td>
					</tr>
				</table>
			</td>
		</tr>
    </table>
</div>


                    
<?php
echo "<hr>";
?>
<style>
    table.reportTab{
    float: left;
    width: 100%;
    border-collapse: collapse;
    background-color: rgba(0, 0, 0, 0);
    border: 1px solid #C0C0C0;
    color: #000000;
    text-align: center;
	vertical-align:top !important;
}

table.reportTab tr, 
table.reportTab tr td,
table.reportTab tr th{
    border: 1px solid #C0C0C0;
	font-size:12px;
}
table.reportTab tr th{
    background-color: #DADADA;
    color: #000000;
    padding:4px;
}
table.reportTab tr.odd{
    background-color: #FFFFDC;
}
table.reportTab tr.even{
    background-color: #FFFFFF;
}
table.reportTab tr td{
    padding:4px;
}
table.reportTab tr td img{
    height: 20px;
    position: relative;
    top: 10px;
}
table.reportTab tr td.textAlgnLeft{
    text-align: left;
}
table.reportTab tr td.textAlgnRight{
    text-align: right;
}
table.reportTab tr td.heightLight{
    background-color: #FFFF00;
}
table.reportTab tr td.merge{
    background-color: #FFFFB8;
}
table.reportTab tr.noborderTr, 
table.reportTab tr.noborderTr td{
    border: none;
    font-weight: bold;
    font-size: 12px;
}
ol{
    list-style: circle;
}

table#header-fixed{
    float: left;
    width: 1195px;
    border-collapse: collapse;
    text-align: center;
    position: fixed; 
    top: 0px; 
    display:none;
}
table#header-fixed tr th{
    border: 1px solid #C0C0C0;
}
table#header-fixed tr th{
    background-color: #DADADA;
    color: #000000;
    padding:4px;
}
ul.specialUl{
    float: left;
    width: 100%;
    list-style: none;
}
ul.specialUl li{
    float: left;
    width: 96.4%;
}
ul.specialUl li span.specialUlLeft{
    float: left;
}
ul.specialUl li span.specialUlRight{
    float: right;
}
span.reportTitle{
    float: left;
    width: 100%;
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 10px;
}
</style>