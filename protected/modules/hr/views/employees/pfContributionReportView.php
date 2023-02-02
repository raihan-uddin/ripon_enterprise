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
            <th>Emp. Name & Id</th>
            <th>Grade</th>
            <th>Designation</th>
            <th>Deparment</th>
            <th>Joining Date</th>
            <th>Basic Salary</th>
            <th>H/Rent & Medical</th>
            <th>Gross Salary</th>
            <th>PF Per Month</th>
            <th>PF Openning Balance</th>
            <?php
			$tc = 11;
			$monthsArray = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
			$startDate = date('Y', strtotime($startDate)).'-'.date('m', strtotime($startDate)).'-1';
			$endDate = date('Y', strtotime($endDate)).'-'.date('m', strtotime($endDate)).'-1';
			$endDate = date('Y-m-d', strtotime($endDate . ' -1 day'));
			
			$monthCount = EmpIncrement::model()->getD2DMonthCount($startDate, $endDate);
			
			if(strtotime($startDate)<strtotime($endDate)){
				$startMonth = date('m', strtotime($startDate));
				$startYear = date('m', strtotime($startDate));
			}
			else{
				$startMonth = date('m', strtotime($endDate));
				$startYear = date('m', strtotime($endDate));
			}
			
			$selectedMonths = array();
			for($i=0; $i<$monthCount; $i++){
				$monthIndex = $startMonth+$i-1;
				if($monthIndex>11){$monthIndex = $monthIndex-12;}
				$monthName = $monthsArray[$monthIndex];
				$selectedIndex = strtotime($startYear.'-'.($monthIndex+1).'-1');
				$selectedMonths[$selectedIndex] = $monthName;
				$tc++;
				echo "<th>$monthName</th>";
			}
			$tc = $tc+3;
			?>
            <th>Profit on PF</th>
            <th>Loan From PF</th>
            <th>PF Closing Balance</th>
        </tr>
        <?php 
		if($dataEmp){
		
			$sl=0;
			$grandLoanBalance = 0;
			$grandClosingBalance = 0;
			
			foreach($dataEmp as $de){
				$sl++;				
				if($sl%2==0){$class = 'even';}
				else{$class = 'odd';}
				
				$employeeId = $de->id;
				$employeeName = $de->full_name.' - '.$de->emp_id_no;
				$teamName = Teams::model()->infoOfThis($de->team_id);
				$designationName = Designations::model()->infoOfThis($de->designation_id);
				$departmentName = Departments::model()->nameOfThis($de->department_id);
				$join_date = $de->join_date;
				
				$basicSalary = 0;
				$houseMedical = 0;
				$providentFund = 0;
				$providentFundStarting = '';
				
				$conditionSalaryEarn = "employee_id=$employeeId AND is_active=".AhAmounProllNormal::ACTIVE;
                $salaryData = AhAmounProllNormal::model()->findAll(array('condition'=>$conditionSalaryEarn), 'id');
                if($salaryData){
					foreach ($salaryData as $sOneRow){
						
						if ($sOneRow->ah_proll_normal_id == 1){
							$basicSalary = $sOneRow->amount_adj;
						}
						elseif ($sOneRow->ah_proll_normal_id == 2){
							$houseMedical = $sOneRow->amount_adj;
						}
						elseif ($sOneRow->ah_proll_normal_id == 6){
							$providentFund = $sOneRow->amount_adj;
							$providentFundStarting = $sOneRow->start_from;
						}
					}
                }
                
                $grossSalary = $basicSalary+$houseMedical;
				
				$incTimeRows = array();
				$incDataRows = array();
				
				$extrarow = 0;
				if($providentFundStarting !=''){
					$extrarow++;
					$incTimeRows[] = strtotime(date('Y',strtotime($providentFundStarting)).'-'.date('m',strtotime($providentFundStarting)).'-1');
				}
				
				$incCondition = "employee_id=$employeeId and effective_date<='$endDate' order by id asc";
                $incAllData = EmpIncrement::model()->findAll(array('condition'=>$incCondition), 'id');                
				if($incAllData){
					$e=0;
					foreach($incAllData as $incitem){
						
						$e++;
						$new_pf = $incitem->new_pf;
						$year = $incitem->year;
						$month = $incitem->month;
						$incTimeRows[] = strtotime($year.'-'.$month.'-01');
						if($e==1 && $extrarow>0){
							$incDataRows[] = array(date('Y',strtotime($providentFundStarting)), date('m',strtotime($providentFundStarting)), $incitem->prev_pf);
						}
						$incDataRows[] = array($year, $month, $new_pf);
						
					}
				}
				
				$pfOpeningBalance = 0;
				$pfCurrentArray = array();
				if(count($incTimeRows)>0){
					$l=0;
					foreach($incTimeRows as $oneMonthTime){
						
						$startTime = $oneMonthTime;
						if(count($incTimeRows)>floor($l+1)){
							$endTime = $incTimeRows[$l+1];
							$endTime = strtotime( date('Y-m-d', $endTime) . ' -1 day');
			
						}
						else{
							$endTime = strtotime(date('Y', strtotime($endDate)).'-'.date('m', strtotime($endDate)).'-1');
						}
						
						if(array_key_exists($l, $incDataRows)){
							$incOneRow = $incDataRows[$l];
							
							$newStartDate = date('Y-m-d', $startTime);
							$newEndDate = date('Y-m-d', $endTime);
							$newmonthCount = EmpIncrement::model()->getD2DMonthCount($newStartDate, $newEndDate);
							$pfPerMonth = $incOneRow[2];
							
							if($newmonthCount>0){
								for($m=0; $m<$newmonthCount; $m++){
									$currentDateTime = strtotime($newStartDate." +$m month");
									
									if(strtotime($startDate)>$currentDateTime){
										
										$pfOpeningBalance = $pfOpeningBalance+$pfPerMonth;
										//echo '<br />Opening Balance Month :'.date('Y-m',$currentDateTime).' PF Per Month : '.$pfPerMonth.' Total PF : '.$pfOpeningBalance;
									}
									else{
										$pfCurrentArray[] = $pfPerMonth;
										//echo '<br />Month :'.date('Y-m',$currentDateTime).' PF Per Month : '.$pfPerMonth;
									}
								}
							}
						}
						//echo '<br />Start from :'.$newStartDate.' to : '.$newEndDate.' PF Per Month : '.$pfPerMonth.' Total PF : '.$totalPF;
						$l++;
					}
				}
				
				$loanBalance = 0;
				$advCondition = "employee_id=$employeeId and effective_date <='$endDate' and adv_pay_type = 24 order by effective_date asc";
                $advAllData = AdvancePayRecv::model()->findAll(array('condition'=>$advCondition), 'id');                
				if($advAllData){
					$e=0;
					foreach($advAllData as $advitem){
						
						$e++;
						$amount = $advitem->amount;
						$installment = $advitem->installment;
						$no_of_month = $advitem->no_of_month;
						$effective_date = $advitem->effective_date;
						
						$advStartingDate = date('Y',strtotime($effective_date)).'-'.date('m',strtotime($effective_date)).'-01';
						$advEndingDate = date('Y-m-d', strtotime($advStartingDate." +$no_of_month month"));
						
						if($advStartingDate>=$startDate && $advEndingDate>$endDate){
							//echo "<br />amount : $amount, installment:$installment, no_of_month:$no_of_month, effective_date from:$advStartingDate, to: $advEndingDate";
							
							$newmonthCount = EmpIncrement::model()->getD2DMonthCount($advStartingDate, $endDate)-1;							
							if($newmonthCount>0){
								$loanBalance = $loanBalance+($amount-($installment*$newmonthCount));
							}							
						}
						
					}
				}
				
				$closingBalance = 0;
				?>        
                <tr class="<?php echo $class;?>">
                    <td><?php echo $sl++; ?></td>
                    <td class="textAlgnLeft"><?php echo $employeeName; ?></td>
                    <td><?php echo $teamName;?></td>
                    <td class="textAlgnLeft"><?php echo $designationName;?></td>
                    <td class="textAlgnLeft"><?php echo $departmentName;?></td>
                    <td class="textAlgnLeft"><?php echo $join_date; ?></td>
                    <td class="textAlgnRight"><?php echo number_format(floatval($basicSalary)); ?></td>
                    <td class="textAlgnRight"><?php echo number_format(floatval($houseMedical)); ?></td>
                    <td class="textAlgnRight"><?php echo number_format(floatval($grossSalary)); ?></td>
                    <td class="textAlgnRight"><?php echo number_format(floatval($providentFund));?></td>
                    <td class="textAlgnRight">
						<?php 
						echo number_format(floatval($pfOpeningBalance));
						$closingBalance = $closingBalance+$pfOpeningBalance;
						?>
                   	</td>
                    <?php
					
                    if(count($pfCurrentArray)>0){
						foreach($pfCurrentArray as $onePF){
							?>
                            <td class="textAlgnRight"><?php echo number_format(floatval($onePF));?></td>
                            <?php
							$closingBalance = $closingBalance+$onePF;
						}
					}
					?>
                    <td>&nbsp;</td>
                    <td class="textAlgnRight">
						<?php 
						echo number_format(floatval($loanBalance));
						$closingBalance = $closingBalance-$loanBalance;
						
						$grandLoanBalance = $grandLoanBalance+$loanBalance;
						$grandClosingBalance = $grandClosingBalance+$closingBalance;			
						?>
                  	</td>
                    <td class="textAlgnRight"><?php echo number_format(floatval($closingBalance)); ?></td>
               	</tr>
                <?php
			}
        }?>
        <tr>
        	<th class="textAlgnRight" colspan="<?php echo ($tc-2);?>">Grand Total</th>
            <th align="right"><?php echo number_format(floatval($grandLoanBalance)); ?></th>
            <th align="right"><?php echo number_format(floatval($grandClosingBalance)); ?></th>
        </tr>
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