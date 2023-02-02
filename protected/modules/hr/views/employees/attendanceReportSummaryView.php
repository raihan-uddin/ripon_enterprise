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
$companyDetails = YourCompany::model()->activeInfo();
if ($companyDetails) {
    $companyName = $companyDetails->company_name;
    echo $companyName . "<br>";
}
?>
        <?php echo $message; ?>
    </span>
    <table class="reportTab">
        <tr>
            <td>SL</td>
            <td>Name</td>
            <td>ID</td>
            <td class="diagonal">Designation</td>
            <td class="diagonal">Department</td>
            <?php
                for($i=1; $i<=$days_of_month; $i++):
                    ?>
            <td><?php if(strlen($i)==1) echo "0".$i; else echo $i; ?></td>
                    <?php
                endfor;
            ?>
            <td>Working Day(s)</td>
            <td>Present Day(s)</td>
            <td>Absent Day(s)</td>
            <td>Late Day(s)</td>
            <td>Leave Day's</td>
        </tr>
        <?php
           if($data){ 
               $sl=1;
        ?>
        <?php foreach($data as $d): ?>
            <tr class="<?php if($sl%2==0) echo "even"; else echo "odd"; ?>">
                <td><?php echo $sl++; ?></td>
                <td><?php echo $d->full_name; ?></td>
                <td><?php echo $d->emp_id_no; ?></td>
                <td><?php echo Designations::model()->infoOfThis($d->designation_id); ?></td>
                <td><?php echo Departments::model()->nameOfThis($d->department_id); ?></td>
                <?php 
                $presentDayCount=0; 
                $absentDayCount=0; 
                $accurateEntryCount=0;
                $lateEntryCount=0;
                $earlyLeaveCount=0;
                $accurateLeaveCount=0;
				$approvedLeaveCount=0;
                				
				$criteriaSpentLvDetails = new CDbCriteria();
				$criteriaSpentLvDetails->select="sum(day_to_leave) as sumDay";
				$criteriaSpentLvDetails->addColumnCondition(array(
					'emp_id' => $d->id,
					'is_approved' => EmpLeavesNormal::APPROVED,
					'month' => $monthFetch,
					'year' => $yearFetch,
						), 'AND');
				$criteriaSpentLvDetails->order = "transaction_date ASC";
				$spentLvDetailsData = EmpLeavesNormal::model()->findAll($criteriaSpentLvDetails);
				if($spentLvDetailsData){
					foreach($spentLvDetailsData as $sldd):
						$approvedLeaveCount= $sldd->sumDay;
						$leaveType = $sldd->lh_proll_normal_id;
					endforeach;
				}
                for($i=1; $i<=$days_of_month; $i++):
                       
					if(strlen($i)==1) 
						$dayFetch= "0".$i; 
					else 
						$dayFetch= $i;
					$queryDate=$yearFetch."-".$monthFetch."-".$dayFetch;
					
					$attendanceData = EmpAttendance::model()->findByAttributes(array('card_no' => $d->device_id, 'date'=>$queryDate), 'in_time>0');
                    
					if($attendanceData){
						
						$dataShifts = ShiftHeads::model()->findByPk($d->shift_id);
						if($dataShifts){
							if (strtotime($dataShifts->in_time) == strtotime($attendanceData->in_time)) { // accurate entry
								$accurateEntryCount++;
							}
							if (strtotime($dataShifts->in_time) < strtotime($attendanceData->in_time)) { // late entry
								$lateEntryCount++;
							}
							if (strtotime($dataShifts->out_time) > strtotime($attendanceData->out_time)) { // early leave
								$earlyLeaveCount++;
							}
							if (strtotime($dataShifts->out_time) <= strtotime($attendanceData->out_time)) { // accurate leave / left later
								$accurateLeaveCount++;
							}
						}
						
						if ($lateEntryCount){
							$presentDayCount++;
							echo "<td class='green'>P/L</td>";
						}
						else{
							$presentDayCount++;
							echo "<td class='green'>P</td>";
						}
					}
					else{ 
						$criteriaSpentLvDetails1 = new CDbCriteria();
						$criteriaSpentLvDetails1->select = "id, lh_proll_normal_id";
						$criteriaSpentLvDetails1->condition = "emp_id= $d->id and is_approved= ".EmpLeavesNormal::APPROVED." and month = $monthFetch and year = $yearFetch and leave_from <= '$queryDate' and leave_to >= '$queryDate'";
						$criteriaSpentLvDetails1->order = "transaction_date ASC";
						$spentLvDetailsData = EmpLeavesNormal::model()->findAll($criteriaSpentLvDetails1);
						if($spentLvDetailsData){
							foreach($spentLvDetailsData as $sld){
								$leaveTpe = $sld->lh_proll_normal_id;
								if ($leaveTpe==2){
									echo "<td class='red'><strong>CL</strong></td>";
								}else{
									echo "<td class='red'><strong>ML</strong></td>";
								}
							}
						}
						else{
							$absentDayCount++;
							echo "<td class='red'>A</td>";
						}
					} endfor;
                	?>
                <td><?php echo $working_day; ?></td>
                <td><?php echo $presentDayCount; ?></td>
                <td><?php echo floor($working_day - $presentDayCount); ?></td>
                <td><?php echo $lateEntryCount; ?></td>
                <td>
					<?php echo $approvedLeaveCount; ?>
                    <?php $actualLeaveDayCount=$presentDayCount+$approvedLeaveCount-$absentDayCount; ?>
           		</td>
            </tr>
        <?php endforeach; ?>
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
    table.reportTab tr td.red{
        color:red;
    }
    table.reportTab tr td.green{
        color:green;
        font-weight: bold;
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
    span.reportTitle{
        float: left;
        width: 100%;
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>