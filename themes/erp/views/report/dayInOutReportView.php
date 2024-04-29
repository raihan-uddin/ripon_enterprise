<style>
    .summaryTab {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        font-size: 12px;
        border: none;
        border-collapse: collapse;
    }

    .summaryTab tr {
        border: 1px dotted #a6a6a6;
    }

    .summaryTab tr td,
    .summaryTab tr th {
        padding: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }

    .summaryTab tr th {
        background-color: #c0c0c0;
        font-weight: bold;
        border: 1px solid #a6a6a6;
        text-align: center;
    }


    .final-result .sticky {
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        background: white;
    }

    .final-result .sticky2 {
        position: sticky;
        position: -webkit-sticky;
        top: 25px;
        background: white;
    }

    .final-result tbody tr:hover {
        background: #dedede;
        transition: background-color 100ms;
    }

</style>

<?php
date_default_timezone_set("Asia/Dhaka");


echo "<div class='printBtn' style='width: unset;'>";
echo "  <img class='exportToExcel' id='exportToExcel'  src='" . Yii::app()->theme->baseUrl . "/images/excel.png' title='EXPORT TO EXCEL'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
    ),
    'publishCss' => TRUE, //publish the CSS for the whole page?
    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div2'         //id of the print link
));
echo "</div>";

?>
<script src="<?= Yii::app()->theme->baseUrl ?>/js/jquery.table2excel.js"></script>
<div class='printAllTableForThisReport table-responsive p-0"'>
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-1">
        <thead>
        <tr>
            <td colspan="10" style="font-size:16px; font-weight:bold; text-align:center"><?php echo $message; ?>
            </td>
        </tr>
        <tr class="titlesTr sticky">
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;" rowspan="2">(A) Date</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;" rowspan="2">(B) Income</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;" colspan="3">Expense</th>
            <th style="width: 5%;box-shadow: 0px 0px 0px 1px black inset;" rowspan="2">Closing</th>
        </tr>
        <tr class="titlesTr sticky2">
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Payment</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Expense</th>
            <th style="width: 8%; box-shadow: 0px 0px 0px 1px black inset;">Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $groundTotal = $total_income = $total_payment = $total_expense = $g_total_expense = 0;
        $row_closing = 0;
        if ($opening) {
            ?>
            <tr>
                <td style="text-align: center;">Opening</td>
                <td colspan="4"></td>
                <td style="text-align: right;"><?= number_format($opening) ?></td>
            </tr>

            <?php
        }
        $row_closing += $opening;
        if ($data) {
            foreach ($data as $dmr) {
                $payment = $dmr['payment'];
                $expense = $dmr['expense'];
                $income = $dmr['income'];

                $exp_row_total = ($payment + $expense);

                $row_closing += ($income - $exp_row_total);

                $total_income += $income;
                $total_payment += $payment;
                $total_expense += $expense;
                $g_total_expense += $exp_row_total;
                $rowFound = true;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $dmr['date']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($income, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($payment, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($expense, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($exp_row_total, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_closing, 2); ?></td>
                </tr>
                <?php

            }
        }
        if (!$rowFound) {
            ?>
            <tr>
                <td colspan='8' style='text-align: center; font-size: 18px; text-transform: uppercase; '>
                    <div class='alert alert-warning'><i class='fa fa-exclamation-triangle'></i> No result found !</div>
                </td>
            </tr>
            <?php
        }
        ?>

        <tr>
            <th style="text-align: right;">Ground Total</th>
            <th style="text-align: right;"><?= number_format($total_income, 2) ?></th>
            <th style="text-align: right;"><?= number_format($total_payment, 2) ?></th>
            <th style="text-align: right;"><?= number_format($total_expense, 2) ?></th>
            <th style="text-align: right;"><?= number_format($g_total_expense, 2) ?></th>
            <th style="text-align: right;"><?= number_format($row_closing, 2) ?></th>
        </tr>

        </tbody>
    </table>
</div>

<style>
    .summaryTab tr td, .summaryTab tr {
        padding: 3px 3px 3px 3px;
        margin: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }
</style>

<script>
    $(function () {
        $(".exportToExcel").click(function (e) {
            var table = $('.table2excel');

            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "DAY_IN_OUT_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });
</script>