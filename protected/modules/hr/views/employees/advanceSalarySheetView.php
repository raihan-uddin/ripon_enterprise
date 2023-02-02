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
        <?php echo $message; ?>
        <?php
        $longTermAmount= AdvancePayRecv::model()->currMonthPayableEmpLongTerm($empId, $endDate);
        $currentAmount= AdvancePayRecv::model()->currMonthPayableEmpCurrent($empId, $startDate, $endDate);
        $netPayable=$longTermAmount+$currentAmount; // deduction
        
        $currentMonthPaidRecvd=AdvancePayRecv::model()->currMonthPaidReceivedEmp($empId, $startDate, $endDate); // current
        
        $prevPaidAmount= AdvancePayRecv::model()->totalPreviouslyPaidThisEmp($empId, $startDate); // opening
        
        $total=$currentMonthPaidRecvd+$prevPaidAmount;
        $closing=$total-$netPayable;
        ?>
        <tr>
            <td>Particulars</td>
            <td>Opening</td>
            <td>Current</td>
            <td>Total</td>
            <td>Deduction</td>
            <td>Closing</td>
        </tr>
        <tr>
            <td>Advance Salary</td>
            <td><?php echo number_format(floatval($prevPaidAmount), 2); ?></td>
            <td><?php echo number_format(floatval($currentMonthPaidRecvd), 2); ?></td>
            <td><?php echo number_format(floatval($total), 2); ?></td>
            <td><?php echo number_format(floatval($netPayable), 2); ?></td>
            <td><?php echo number_format(floatval($closing), 2); ?></td>
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