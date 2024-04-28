<?php
/** @var double $opening */
/** @var double $opening_purchase_amount */
/** @var double $opening_payment_amount */
/** @var string $message */
/** @var mixed $data */
?>
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
            <td colspan="10" style="font-size:16px; font-weight:bold; text-align:center">
                <?php echo $message; ?>
            </td>
        </tr>
        <tr class="titlesTr sticky">
            <th style="width: 2%; box-shadow: 0px 0px 0px 1px black inset;">SL</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Trx Type</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Date</th>
            <th style="width: 5%;box-shadow: 0px 0px 0px 1px black inset;">ID</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Invoice No</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Amount</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset; width: 10%; min-width: 60px;">Closing</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $groundTotal = 0;
        $row_closing = 0;
        ?>
        <tr>
            <td></td>
            <td style="text-align: center;">Opening</td>
            <td colspan="3"></td>
            <td style="text-align: right;"><?= number_format($opening) ?></td>
            <td></td>
        </tr>

        <?php
        $total_purchase = $total_payment = 0;
        $row_closing += $opening;
        if ($data) {
            foreach ($data as $dmr) {
                $trx_type = $dmr['trx_type'];
                if ($trx_type == 'purchase') {
                    $row_closing += $dmr['amount'];
                    $total_purchase += $dmr['amount'];
                } else {
                    $row_closing -= $dmr['amount'];
                    $total_payment += $dmr['amount'];
                }
                $rowFound = true;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
                    <td style="text-align: center;"><?php echo $dmr['trx_type']; ?></td>
                    <td style="text-align: center;"><?php echo $dmr['date']; ?></td>
                    <td style="text-align: center;"><?php echo $dmr['id']; ?></td>
                    <td style="text-align: left;"><?php echo $dmr['order_no']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['amount'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_closing, 2); ?></td>
                </tr>
                <?php

            }
        }
        ?>
        <tr>
            <th colspan="2"></th>
            <th>Opening Purchase</th>
            <th>Opening Payment</th>
            <th>Date Range Purchase</th>
            <th>Date Range Payment</th>
            <th>Closing</th>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td style="text-align: center; font-weight: bold;"><?= $opening_purchase_amount ? number_format($opening_purchase_amount, 2) : 0 ?></td>
            <td style="text-align: center; font-weight: bold;"><?= $opening_payment_amount ? number_format($opening_payment_amount, 2) : 0 ?></td>
            <td style="text-align: center; font-weight: bold;"><?= $total_purchase ? number_format($total_purchase, 2) : 0 ?></td>
            <td style="text-align: center; font-weight: bold;"><?= $total_payment ? number_format($total_payment, 2) : 0 ?></td>
            <td style="text-align: center; font-weight: bold;"><?= $row_closing ? number_format($row_closing, 2) : 0 ?></td>
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
                    filename: "CUSTOMER_LEDGER-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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