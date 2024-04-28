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
            <td colspan="10" style="font-size:16px; font-weight:bold; text-align:center"><?php echo $message; ?>
            </td>
        </tr>
        <tr class="titlesTr sticky">
            <th style="width: 2%; box-shadow: 0px 0px 0px 1px black inset;">SL</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Date</th>
            <th style="width: 7%; box-shadow: 0px 0px 0px 1px black inset;">Invoice Id</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;">Customer</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;">Product</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;" title="Purchase Price">P.P</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Qty</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;" title="Sell Price">S.P</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;" title="Row Total Sell Price">T.S.P</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;" title="Net Income">N.I</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $groundTotal = 0;
        $row_closing = $row_closing_discount = $net_income_total = $total_due = 0;
        $qty_total = $amount_total = $row_total_total = $net_income_total = 0;
        ?>

        <?php
        if ($data) {
            foreach ($data as $dmr) {
                $rowFound = true;

                $pp = round($dmr->costing / $dmr->qty, 2);
                $net_income = $dmr->row_total - $dmr->costing;
                $qty_total += $dmr->qty;
                $amount_total += $dmr->amount;
                $row_total_total += $dmr->row_total;
                $net_income_total += $net_income;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
                    <td style="text-align: center;"><?php echo $dmr->date; ?></td>
                    <td style="text-align: center; text-decoration: underline; cursor:zoom-in;" class="invoiceDetails"
                        title="click here to get the preview"><?php echo $dmr->id; ?></td>
                    <td style="text-align: left;"><?php echo sprintf("%s | %s", $dmr->customer_name, $dmr->contact_no); ?></td>
                    <td style="text-align: left;"><?php echo sprintf("%s | %s", $dmr->product_name, $dmr->product_code); ?></td>
                    <td style="text-align: right;"><?php echo number_format($pp, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->qty, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->amount, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->row_total, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($net_income, 2); ?></td>
                </tr>
                <?php

            }
        }
        ?>

        <tr>
            <th style="text-align: right;" colspan="6">Ground Total</th>
            <th style="text-align: right;"><?php echo number_format($qty_total, 2); ?></th>
            <th style="text-align: right;"><?php echo number_format($amount_total, 2); ?></th>
            <th style="text-align: right;"><?php echo number_format($row_total_total, 2); ?></th>
            <th style="text-align: right;"><?php echo number_format($net_income_total, 2); ?></th>
        </tr>

        </tbody>
    </table>

    <table class="headerTab table table-bordered " style="float: left; width: 100%;">
        <tr>
            <td style="padding-top: 40px; text-align: left;"></td>
            <td style="padding-top: 40px; text-align: right;"></td>
            <td style="padding-top: 40px; text-align: center;"></td>
            <td style="padding-top: 40px; text-align: center;"></td>
        </tr>
        <tr>
            <th style="text-decoration: overline; text-align: left;">Prepared By</th>
            <th style="text-decoration: overline;text-align: center;">Checked By</th>
            <th style="text-decoration: overline;text-align: center;">Head of Department</th>
            <th style="text-decoration: overline; text-align: right;">Approved By</th>
        </tr>
    </table>
</div>

<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
                    filename: "SELL_ORDER_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });
    });
    //
    $('#table-1').off('click', '.invoiceDetails').on('click', '.invoiceDetails', function () {

        var invoiceId = $(this).text();
        var $this = $(this);
        $this.html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("sell/sellOrder/voucherPreview") ?>',
            type: 'POST',
            data: {
                invoiceId: invoiceId
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                $this.html(invoiceId);
            },
            error: function () {
                $this.html(invoiceId);
                toastr.error('Something went wrong');
            }
        });
    });
</script>