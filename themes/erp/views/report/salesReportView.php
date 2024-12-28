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
<div class='printAllTableForThisReport table-responsive p-0'>
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
            <th style="width: 7%; box-shadow: 0px 0px 0px 1px black inset;">ID</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;">Customer</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Sell Value</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Delivery Charge</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Discount</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Amount</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">N.I</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Due</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $groundTotal = $total_amount = $total_delivery_charge = $total_return = 0;
        $row_closing = $row_closing_discount = $net_income_total = $total_due = 0;
        ?>

        <?php
        if ($data) {
            foreach ($data as $dmr) {
                $total_amount += $dmr->total_amount;
                $total_return += $dmr->total_return;
                $total_delivery_charge += $dmr->delivery_charge;
                $row_closing_discount += $dmr->discount_amount;
                $row_closing += $dmr->grand_total;
                $netIncome = $dmr->total_amount - $dmr->costing - $dmr->discount_amount;
                $rowFound = true;

                $net_income_total += $netIncome;
                $total_due += $dmr->total_due;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
                    <td style="text-align: center;"><?php 
                        if($group_by === 't.id' || $group_by === 't.date'){
                            echo $dmr->date; 
                        }
                    ?></td>
                    <td style="text-align: center; text-decoration: underline; cursor: zoom-in;" class="invoiceDetails"
                        title="click here to get the preview">
                        <?php 
                        if($group_by === 't.id'){
                            echo $dmr->id;
                        }
                        ?>
                    </td>
                    <td style="text-align: left;"><?php
                    if($group_by === 't.id' || $group_by === 't.customer_id'){ 
                        echo sprintf("%s | %s", $dmr->customer_name, $dmr->contact_no);
                    } 
                    ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->total_amount, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->delivery_charge, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->discount_amount, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->grand_total, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($netIncome, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr->total_due, 2); ?></td>
                </tr>
                <?php

            }
        }
        if (!$rowFound) {
            ?>
            <tr>
                <td colspan='12' style='text-align: center; font-size: 18px; text-transform: uppercase; '>
                    <div class='alert alert-warning'><i class='fa fa-exclamation-triangle'></i> No result found !</div>
                </td>
            </tr>
            <?php
        }
        ?>

        <tr>
            <th style="text-align: right;" colspan="4">Ground Total</th>
            <th style="text-align: right;"><?= number_format($total_amount, 2) ?></th>
            <th style="text-align: right;"><?= number_format($total_delivery_charge, 2) ?></th>
            <th style="text-align: right;"><?= number_format($row_closing_discount, 2) ?></th>
            <th style="text-align: right;"><?= number_format($row_closing, 2) ?></th>
            <th style="text-align: right;"><?= number_format($net_income_total, 2) ?></th>
            <th style="text-align: right;"><?= number_format($total_due, 2) ?></th>
        </tr>

        </tbody>
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

    $('body #table-1').off('click', '.invoiceDetails').on('click', '.invoiceDetails', function () {

        var invoiceId = $(this).text();
        var $this = $(this);
        $this.html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("sell/sellOrder/voucherPreview") ?>',
            type: 'POST',
            data: {
                invoiceId: invoiceId,
                show_profit: 1
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