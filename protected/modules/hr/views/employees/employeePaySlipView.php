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
                echo $companyName."<br>";
            }
        ?>
        <font style="font-size: 14px;"><?php echo $message; ?></font>
    </span>
    <table class="reportTab">
        <tr>
            <th>Sl</th>
            <th>Employee Name & Id</th>
            <th>Grade</th>
            <th>Designation</th>
            <?php 
            $earnArray=array();
                if($dataEarnHeads!=""){
                    foreach($dataEarnHeads as $deh):
                        $earnArray[]=$deh->id;
                        ?>
            <th><?php echo $deh->title; ?></th>
                        <?php
                    endforeach;
                }
            ?>
            <th>Gross Salary</th>
            <th>Attn.</th>
            <th>Net Salary</th>
            <?php 
            $deductArray=array();
                if($dataDeductHeads!=""){
                    foreach($dataDeductHeads as $ddh):
                        $deductArray[]=$ddh->id;
                        ?>
            <th><?php echo $ddh->title; ?></th>
                        <?php
                    endforeach;
                }
            ?>
            <th>Monthly Loan<br/> Deduct</th>
            <th>PF Loan Deduct with Profit</th>
            <th>Total Deduct</th>
            <th>Net Payable</th>
            <th>Signature</th>
        </tr>
        <?php if($dataEmp!=""){ ?>
        <?php $countEarnArr=count($earnArray); ?>
        <?php $countDeductArr=count($deductArray); ?>
        <?php $sl=1; ?>
        <?php
        $finalGrossSalary=0;
        $finalNetSalary=0;
        $finalCurrMonthAdv=0;
        $finalPfCurrMonthAdv=0;
        $finalTotalDeduct=0;
        ?>
        <?php foreach($dataEmp as $de): ?>
        <?php
			$criteria=new CDbCriteria();
			$criteria->select="count(id) as sumOfPresentDay";
			$criteria->addColumnCondition(array('card_no'=>$de->device_id), 'AND in_time>0 AND');
                        //$criteria->addColumnCondition('in_time > 0', 'AND');
			$criteria->addBetweenCondition('date', $startDate, $endDate);
			$criteria->order="date ASC";
			$attendanceData=EmpAttendance::model()->findAll($criteria);
                                           
			$totalPresentDay=0;
			foreach($attendanceData as $atndncData):
				$totalPresentDay=$atndncData->sumOfPresentDay;
			endforeach;
			$totalAbsentDay=$days_of_month-$totalPresentDay;
			
			$criteria2=new CDbCriteria();
			$criteria2->select="sum(day) as sumOfDay";
			$criteria2->addColumnCondition(array('employee_id'=>$de->id, 'is_active'=>LhAmountProllNormal::ACTIVE), 'AND');
			$assignedLeaveData=LhAmountProllNormal::model()->findAll($criteria2);
			$totalAssignedLeaveDay=0;
			foreach($assignedLeaveData as $assgnLvData):
				$totalAssignedLeaveDay=$assgnLvData->sumOfDay;
			endforeach;
			
			$criteria3 = new CDbCriteria();
			$criteria3->select="sum(day_to_leave) as sumDay";
			$criteria3->addColumnCondition(array(
				'emp_id' => $de->id,
				'is_approved' => EmpLeavesNormal::APPROVED,
				'month' => $monthFetch,
				'year' => $yearFetch,
					), 'AND');
			$spentLvDataCurrMnth = EmpLeavesNormal::model()->findAll($criteria3);
			$approvedLeaveCurrMonth=0;
			foreach($spentLvDataCurrMnth as $spntLvCurrMnth):
				$approvedLeaveCurrMonth=$spntLvCurrMnth->sumDay;
			endforeach;
			
			$criteria4 = new CDbCriteria();
			$criteria4->select="sum(day_to_leave) as sumDay";
			$criteria4->addColumnCondition(array(
				'emp_id' => $de->id,
				'is_approved' => EmpLeavesNormal::APPROVED,
				'month' => $monthFetch,
					), 'AND');
			$spentLvDetailsCurrYr = EmpLeavesNormal::model()->findAll($criteria4);
			$approvedLeaveCurrYr=0;
			foreach($spentLvDetailsCurrYr as $spntLvCurrYr):
				$approvedLeaveCurrYr=$spntLvCurrYr->sumDay;
			endforeach;
			
			$unApprovedLeaveCurrMonth=$totalAbsentDay-$approvedLeaveCurrMonth;
			
			$amountEarningLineTotal=0;
			$amountDeductLineTotal=0;
        ?>
        
        <tr class="<?php if($sl%2==0) echo "even"; else "odd"; ?>">
            <td><?php echo $sl++; ?></td>
            <td class="textAlgnLeft"><?php echo $de->full_name . ' -' .$de->emp_id_no; ?></td>
            <td><?php echo Teams::model()->infoOfThis($de->team_id); ?></td>
            <td class="textAlgnLeft"><?php echo Designations::model()->infoOfThis($de->designation_id); ?></td>
            <?php for($i=0; $i<$countEarnArr; $i++): ?>
            <td>
                <?php
                    $conditionSalaryEarn="employee_id=".$de->id." AND ah_proll_normal_id=".$earnArray[$i]." AND is_active=".AhAmounProllNormal::ACTIVE;
                    $salaryDataEarn=AhAmounProllNormal::model()->findAll(array('condition'=>$conditionSalaryEarn), 'id');
                    if($salaryDataEarn){
                    foreach ($salaryDataEarn as $salDE):
                        if ($salDE->earn_deduct_type == AhAmounProllNormal::DAILY_BASIS) { // daily basis
                            $amountEarning = $totalPresentDay * $salDE->amount_adj;
                        } else {
                            $amountEarning = $salDE->amount_adj;
                        }
                    endforeach;
                    }else{
                        $amountEarning=0;
                    }
                    echo number_format(floatval($amountEarning));
                    $amountEarningLineTotal=$amountEarning+$amountEarningLineTotal;
                ?>
            </td>
            <?php endfor; ?>
            <td><?php echo number_format(floatval($amountEarningLineTotal)); ?></td>
            <td><?php echo floor($totalPresentDay+$approvedLeaveCurrYr); ?></td>
            <td>
            <?php
            $finalGrossSalary=$amountEarningLineTotal+$finalGrossSalary;
			$eachDaySalaryEarn=$amountEarningLineTotal/$days_of_month;
			$salaryDeductForEachDayAbsent=$unApprovedLeaveCurrMonth*$eachDaySalaryEarn;
            $netSalaryLineTotal=$amountEarningLineTotal-$salaryDeductForEachDayAbsent;
            echo number_format(floatval($netSalaryLineTotal));
            $finalNetSalary=$finalNetSalary+$netSalaryLineTotal;
            ?>
            </td>
            <?php for($i=0; $i<$countDeductArr; $i++): ?>
            <td>
                <?php
                    $conditionSalaryDeduct="employee_id=".$de->id." AND ah_proll_normal_id=".$deductArray[$i]." AND is_active=".AhAmounProllNormal::ACTIVE;
                    $salaryDataDeduct=AhAmounProllNormal::model()->findAll(array('condition'=>$conditionSalaryDeduct), 'id');
                    
                    if($salaryDataDeduct){
                    foreach ($salaryDataDeduct as $salDD):
                        if ($salDD->earn_deduct_type == AhAmounProllNormal::DAILY_BASIS) { // daily basis
                            $amountDeduct = $totalPresentDay * $salDD->amount_adj;
                        } else {
                            $amountDeduct = $salDD->amount_adj;
                        }
                    endforeach;
                    }else{
                        $amountDeduct=0;
                    }
                    echo "<font color='red'>".number_format(floatval($amountDeduct))."</font>";
                    
                    $amountDeductLineTotal=$amountDeduct+$amountDeductLineTotal;
                ?>
            </td>
            <?php endfor; ?>
            <td>
                <!--        Advanced payment/Receive calculation-->

		<?php
        $conditionLong = "employee_id=" . $de->id . " AND transaction_date < '" . $endDate . "' AND is_approved=" . AdvancePayRecv::APPROVED. " AND adv_pay_type!=" . AdvancePayRecv::PF;
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
                        $dateDiff = round($interval->format('%m'))+1;
                        if ($dateDiff <= $dl->no_of_month && $dateDiff!=0) {
                           /*$dateDiff = round($interval->format('%m')+1); 
                            $totalpaid = $dl->installment * $dateDiff;
                            $remainbalance = $dl->amount - $totalpaid;
                            
                            $amountWithInstallMent = $dl->installment;
                            
                            if ($remainbalance < $dl->installment){
                                $amountWithInstallMent = $remainbalance;	
                            }*/
							
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
                        $dateDiff = round($interval->format('%m'))+1;
                        if ($dateDiff <= $dl->no_of_month  && $dateDiff!=0) {
                        	$acRecvblAmountPrMnthTotalCurrent = $dl->amount+ $acRecvblAmountPrMnthTotalCurrent;
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
		
		$totalLoan=$duductableAmountLong+$duductableAmountLongCurrent;
		echo "<font color='red'>".number_format(floatval($totalLoan))."</font>";
		$finalCurrMonthAdv=$finalCurrMonthAdv+$totalLoan;
		?>
            </td>
            <td>
				<?php
				//================= PF Loan ===========================//
                $conditionPf = "employee_id=" . $de->id . " AND transaction_date < '" . $endDate . "' AND is_approved=" . AdvancePayRecv::APPROVED . " AND adv_pay_type=" . AdvancePayRecv::PF;
                $dataPf = AdvancePayRecv::model()->findAll(array('condition' => $conditionPf), 'id');
                $pfAcRecvblAmountPrMnthTotal = 0;
                $pfAmountReceivedTotal = 0;
                $pfAmountReceivedTotalCurrent = 0;
                $pfAcRecvblAmountPrMnthTotalCurrent = 0;
                if ($dataPf) {
                    foreach ($dataPf as $dpf):
                        if ($dpf->adv_pay_type == AdvancePayRecv::PF) {
                            if ($dpf->payOrReceive == AdvancePayRecv::PAY) {
                                $d1 = new DateTime($dpf->transaction_date); // stored date
                                $d2 = new DateTime($endDate); // given date
                                $interval = $d2->diff($d1);
                                $dateDiff = round($interval->format('%m'))+1;
                                if ($dateDiff <= $dpf->no_of_month && $dateDiff!=0) { 
								
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
                
                $totalPfLoan=$duductableAmountPf+$duductableAmountPfCurrent;
                echo "<font color='red'>".number_format(floatval($totalPfLoan))."</font>";
                $finalPfCurrMonthAdv=$finalPfCurrMonthAdv+$totalPfLoan;
                ?>
            </td>
            <td>
                <?php
                    $totalDeductionAmount=($totalLoan+$totalPfLoan)+$amountDeductLineTotal;
                    echo "<font color='red'>".number_format(floatval($totalDeductionAmount))."</font>";
                    
                    $finalTotalDeduct=$finalTotalDeduct+$totalDeductionAmount;
                ?>
            </td>
            <td>
                <?php
                    $netPayableLineTotal=$netSalaryLineTotal-$totalDeductionAmount;
                    echo number_format(floatval($netPayableLineTotal));
                ?>
            </td>
            <td></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="heightLight">Sub Total</td>
            <td class="heightLight" colspan="<?php echo $countEarnArr; ?>"></td>
            <td class="heightLight"><?php echo number_format(floatval($finalGrossSalary)); ?></td>
            <td class="heightLight"></td>
            <td class="heightLight"><?php echo number_format(floatval($finalNetSalary)); ?></td>
            <td class="heightLight" colspan="<?php echo $countDeductArr; ?>"></td>
            <td class="heightLight"><?php echo number_format(floatval($finalCurrMonthAdv)); ?></td>
            <td class="heightLight"><?php echo number_format(floatval($finalPfCurrMonthAdv)); ?></td>
            <td class="heightLight"><?php echo number_format(floatval($finalTotalDeduct)); ?></td>
            <td class="heightLight">
                <?php
                    $finalNetPayable=$finalNetSalary-$finalTotalDeduct;
                    echo number_format(floatval($finalNetPayable));
                ?>
            </td>
            <td class="heightLight"></td>
        </tr>
        <?php } ?>
    </table>
</div>
<style>
    table.reportTab{
    float: left;
    width: 100%;
    border-collapse: collapse;
    background-color: rgba(0, 0, 0, 0);
    border: 1px solid #C0C0C0;
    color: #8B4513;
    text-align: center;
}

table.reportTab tr, 
table.reportTab tr td,
table.reportTab tr th{
    border: 1px solid #C0C0C0;
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
    font-size: 14px;
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