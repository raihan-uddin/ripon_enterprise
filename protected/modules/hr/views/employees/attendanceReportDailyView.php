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
    </span>
    <table class="reportTab">
        <thead>
            <tr>
                <td colspan="12" style=" border-color:#FFF; font-size:16px; color:#000; font-weight:bold; text-align:center"><?php echo $message; ?></td>
            </tr>
            <tr>
                <th>SL</th>
                <th>Employee Name</th>
                <th>ID</th>
                <th class="diagonal">Designation</th>
                <th class="diagonal">Department</th>
                <th class="diagonal">Joining Date</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Duration</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data) {
                $sl = 1;
                foreach ($data as $d):
                    ?>
                    <tr class="<?php if ($sl % 2 == 0)
                echo "even";
            else
                echo "odd";
                    ?>">

                        <?php
                        $presentDayCount = 0;
                        $absentDayCount = 0;
                        $accurateEntryCount = 0;
                        $lateEntryCount = 0;
                        $earlyLeaveCount = 0;
                        $accurateLeaveCount = 0;
                        $approvedLeaveCount = 0;
                        $intime = '';
                        $outtime = '';

                        $criteriaSpentLvDetails = new CDbCriteria();
                        $criteriaSpentLvDetails->select = "sum(day_to_leave) as sumDay";
                        $criteriaSpentLvDetails->addColumnCondition(array(
                            'emp_id' => $d->id,
                            'is_approved' => EmpLeavesNormal::APPROVED,
                            'month' => $monthFetch,
                            'year' => $yearFetch,
                                ), 'AND');
                        $criteriaSpentLvDetails->order = "transaction_date ASC";
                        $spentLvDetailsData = EmpLeavesNormal::model()->findAll($criteriaSpentLvDetails);
                        if ($spentLvDetailsData) {
                            foreach ($spentLvDetailsData as $sldd):
                                $approvedLeaveCount = $sldd->sumDay;
                            endforeach;
                        }

                        /* for($i=1; $i<=$days_of_month; $i++):
                          if(strlen($i)==1)
                          $dayFetch= "0".$i;
                          else
                          $dayFetch= $i;
                          $queryDate=$yearFetch."-".$monthFetch."-".$dayFetch; */
                        //$attendanceData = EmpAttendance::model()->findByAttributes(array('card_no' => $d->device_id, 'date' => $date), 'in_time>0');
                        $attendanceData = EmpAttendance::model()->findByAttributes(array('card_no' => $d->device_id, 'date' => $date));
                        //echo "<pre>";
                        //print_r($attendanceData);
                       // echo "</pre>";
                        if ($attendanceData) {
                            $dataShifts = ShiftHeads::model()->findByPk($d->shift_id);
                            if ($dataShifts) {
                                if (strtotime($dataShifts->in_time) > strtotime($attendanceData->in_time)) { // accurate entry
                                    $accurateEntryCount++;
                                }
                                if (strtotime($dataShifts->in_time) <= strtotime($attendanceData->in_time)) { // late entry
                                    $lateEntryCount++;
                                }/*
                                if (strtotime($dataShifts->out_time) > strtotime($attendanceData->out_time)) { // early leave
                                    $earlyLeaveCount++;
                                }
                                if (strtotime($dataShifts->out_time) <= strtotime($attendanceData->out_time)) { // accurate leave / left later
                                    $accurateLeaveCount++;
                                }*/
                            }
                            if ($lateEntryCount && $pStatus == 2) {
                                /* ----Start--------- */
                                ?>
                                <td> <?php echo $sl++; ?></td>
                                <td style="text-align:left"><?php echo $d->full_name; ?></td>
                                <td style="text-align:left"><?php echo $d->emp_id_no; ?></td>
                                <td style="text-align:left"><?php echo Designations::model()->infoOfThis($d->designation_id); ?></td>
                                <td style="text-align:left"><?php echo Departments::model()->nameOfThis($d->department_id); ?></td>
                                <td><?php echo $d->join_date; ?></td>
                                <td>
                                    <?php
                                    if ($attendanceData == '') {
                                        echo 'N/A';
                                    } else {
                                        echo $attendanceData->in_time;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($attendanceData == '') {
                                        echo 'N/A';
                                    } else {
                                        echo $attendanceData->out_time;
                                    }
                                    ?>
                                </td>
                                <td></td>
                                <?php
                                /* -----End --------- */
                                echo "<td class='green'>P/L</td>";
                            } else if ($attendanceData->in_time >0 && strtotime($dataShifts->in_time) >= strtotime($attendanceData->in_time) && $pStatus == 1) {
                                /* ----Start--------- */
                                ?>
                                <td> <?php echo $sl++; ?></td>
                                <td style="text-align:left"><?php echo $d->full_name; ?></td>
                                <td style="text-align:left"><?php echo $d->emp_id_no; ?></td>
                                <td style="text-align:left"><?php echo Designations::model()->infoOfThis($d->designation_id); ?></td>
                                <td style="text-align:left"><?php echo Departments::model()->nameOfThis($d->department_id); ?></td>
                                <td><?php echo $d->join_date; ?></td>
                                <td>
                                    <?php
                                    if ($attendanceData == '') {
                                        echo 'N/A';
                                    } else {
                                        echo $attendanceData->in_time;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($attendanceData == '') {
                                        echo 'N/A';
                                    } else {
                                        echo $attendanceData->out_time;
                                    }
                                    ?>
                                </td>
                                <td></td>
                                <?php
                                 echo "<td class='green'>P</td>";
                                /* -----End --------- */
                            }
                         else if ( $attendanceData->in_time <=0 && $pStatus == 3) {
                            /* ----Start--------- */
                            ?>
                            <td> <?php echo $sl++; ?></td>
                            <td style="text-align:left"><?php echo $d->full_name; ?></td>
                            <td style="text-align:left"><?php echo $d->emp_id_no; ?></td>
                            <td style="text-align:left"><?php echo Designations::model()->infoOfThis($d->designation_id); ?></td>
                            <td style="text-align:left"><?php echo Departments::model()->nameOfThis($d->department_id); ?></td>
                            <td><?php echo $d->join_date; ?></td>
                            <td>
                                <?php
                                if ($attendanceData == '') {
                                    echo 'N/A';
                                } else {
                                    echo $attendanceData->in_time;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($attendanceData == '') {
                                    echo 'N/A';
                                } else {
                                    echo $attendanceData->out_time;
                                }
                                ?>
                            </td>
                            <td></td>
                            <?php
                            /* -----End --------- */
                            $criteriaSpentLvDetails1 = new CDbCriteria();
                            $criteriaSpentLvDetails1->select = "id, lh_proll_normal_id";
                            $criteriaSpentLvDetails1->condition = "emp_id= $d->id and is_approved= " . EmpLeavesNormal::APPROVED . " and leave_from <= '$date' and leave_to >= '$date'";
                            $criteriaSpentLvDetails1->order = "transaction_date ASC";
                            $spentLvDetailsData = EmpLeavesNormal::model()->findAll($criteriaSpentLvDetails1);
                            if ($spentLvDetailsData) {
                                foreach ($spentLvDetailsData as $sld) {
                                    $leaveTpe = $sld->lh_proll_normal_id;
                                    if ($leaveTpe == 2) {
                                        echo "<td class='red'><strong>CL</strong></td>";
                                    } else {
                                        echo "<td class='red'><strong>ML</strong></td>";
                                    }
                                }
                            } else {
                                echo "<td class='red'>A</td>";
                            }
                        }
                        }
                        ?>
                    </tr>
                <?php endforeach; ?>
<?php } ?>
        </tbody>
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
        font-size: 12px;
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
        font-size: 10px;
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