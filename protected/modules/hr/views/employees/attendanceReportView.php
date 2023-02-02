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
    </span>
    <table class="reportTab">
        <?php echo $message; ?>
        <tr>
            <th style="padding: 15px 0px;" colspan="5">ATTENDANCE</th>
        </tr>
        <tr class="titlesTr">
            <th style="width: 20px;">SL</th>
            <th>Date</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Shift</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($attendanceData as $ad): ?>
            <tr class="<?php
        if ($i % 2 == 0)
            echo "even"; else
            echo "odd";
            ?>">
                <td><?php echo $i++; ?></td>
                <td><?php echo $ad->date; ?></td>
                <td><?php echo $ad->in_time; ?></td>
                <td><?php echo $ad->out_time; ?></td>
                <td>
                    <?php
                            $dataShifts = ShiftHeads::model()->findByPk($shiftId);
                            if($dataShifts){
                                if (strtotime($dataShifts->in_time) == strtotime($ad->in_time)) { // accurate entry
                                    echo "RIGHT IN- ";
                                }
                                if (strtotime($dataShifts->in_time) < strtotime($ad->in_time)) { // late entry
                                    echo "LATE IN- ";
                                }
                                if (strtotime($dataShifts->out_time) > strtotime($ad->out_time)) { // early leave
                                    echo "EARLY LEAVE";
                                }
                                if (strtotime($dataShifts->out_time) <= strtotime($ad->out_time)) { // accurate leave / left later
                                    echo "RIGHT OUT";
                                }
                            }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5">Total Present Day: <?php echo $i; ?></td>
        </tr>
        <tr>
            <th style="padding: 15px 0px;" colspan="5">LEAVES</th>
        </tr>
        <tr>
            <th style="width: 20px;">SL</th>
            <th>Date</th>
            <th>Leave Head</th>
            <th>Day:Hour</th>
            <th></th>
        </tr>
        <?php
        $criteriaSpentLvDetails = new CDbCriteria();
        $criteriaSpentLvDetails->addColumnCondition(array(
            'emp_id' => $empId,
            'is_approved' => EmpLeavesNormal::APPROVED,
            'month' => $monthFetch,
            'year' => $yearFetch,
                ), 'AND');
        $criteriaSpentLvDetails->order = "transaction_date ASC";
        $spentLvDetailsData = EmpLeavesNormal::model()->findAll($criteriaSpentLvDetails);
        if ($spentLvDetailsData) {
            $i = 1;
            foreach ($spentLvDetailsData as $sldd):
                ?>
                <tr class="<?php
        if ($i % 2 == 0)
            echo "even"; else
            echo "odd";
                ?>">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $sldd->transaction_date; ?></td>
                    <td><?php echo LhProllNormal::model()->nameOfThis($sldd->lh_proll_normal_id); ?></td>
                    <td><?php echo $sldd->day_to_leave . ":" . $sldd->hour_to_leave; ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        <?php } ?>
        <tr>
            <th style="padding: 15px 0px;" colspan="5">ASSIGNED LEAVES</th>
        </tr>
        <tr>
            <th style="width: 20px;">SL</th>
            <th>Leave Head</th>
            <th>Assigned (Day:Hour)</th>
            <th>Spent (Day:Hour)</th>
            <th>Remaining (Day:Hour)</th>
        </tr>
        <?php
            $finalTotalAssignDay = 0;
            $finalTotalAssignHour = 0;

            $finalTotalSpentDay = 0;
            $finalTotalSpentHour = 0;

            $finalTotalRemainingDay = 0;
            $finalTotalRemainingHour = 0;
            ?>
        <?php if ($assignedLeave) { ?>
            <?php $i = 1; ?>
            <?php foreach ($assignedLeave as $ald): ?>
                <tr class="<?php
        if ($i % 2 == 0)
            echo "even"; else
            echo "odd";
                ?>">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo LhProllNormal::model()->nameOfThis($ald->lh_proll_normal_id); ?></td>
                    <td><?php echo $ald->day . ":" . $ald->hour; ?></td>
                    <td>
                        <?php
                        $criteriaSpentLeave = new CDbCriteria();
                        $criteriaSpentLeave->select = "sum(day_to_leave) as sumDay, sum(hour_to_leave) as sumHour";
                        $criteriaSpentLeave->addColumnCondition(array(
                            'lh_proll_normal_id' => $ald->lh_proll_normal_id,
                            'emp_id' => $empId,
                            'is_approved' => EmpLeavesNormal::APPROVED,
                            'year' => $yearFetch,
                                ), 'AND');
                        $dataSpentLeave = EmpLeavesNormal::model()->findAll($criteriaSpentLeave);
                        $totalSpentDay = 0;
                        $totalSpentHr = 0;
                        if ($dataSpentLeave) {
                            foreach ($dataSpentLeave as $dsl):
                                $totalSpentDay = $dsl->sumDay;
                                $totalSpentHr = $dsl->sumHour;
                            endforeach;
                        }
                        ?>
                        <?php echo $totalSpentDay . ":" . $totalSpentHr; ?>
                    </td>
                    <td>
                        <?php
                        $remainingLeaveDay = $ald->day - $totalSpentDay;
                        $remainingLeaveHr = $ald->hour - $totalSpentHr;
                        ?>
                        <?php echo $remainingLeaveDay . ":" . $remainingLeaveHr; ?>
                    </td>
                </tr>
                <?php
                $finalTotalAssignDay = $ald->day + $finalTotalAssignDay;
                $finalTotalAssignHour = $ald->hour + $finalTotalAssignHour;

                $finalTotalSpentDay = $totalSpentDay + $finalTotalSpentDay;
                $finalTotalSpentHour = $totalSpentHr + $finalTotalSpentHour;

                $finalTotalRemainingDay = $remainingLeaveDay + $finalTotalRemainingDay;
                $finalTotalRemainingHour = $remainingLeaveHr + $finalTotalRemainingHour;
                ?>
            <?php endforeach; ?>
        <?php } ?>
        <tr>
            <td colspan="2">Total: </td>
            <td><?php echo $finalTotalAssignDay . ":" . $finalTotalAssignHour; ?></td>
            <td><?php echo $finalTotalSpentDay . ":" . $finalTotalSpentHour; ?></td>
            <td><?php echo $finalTotalRemainingDay . ":" . $finalTotalRemainingHour; ?></td>
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