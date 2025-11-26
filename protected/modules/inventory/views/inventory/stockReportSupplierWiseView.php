<?php
/**
 * @var string $message
 * @var mixed $data
 */
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
        top: 0;
        background: white;
    }

    .final-result tbody tr:hover {
        background: #dedede;
        transition: background-color 100ms;
    }

    table tr {
        transition: background-color 0.3s; /* Add transition for smooth effect */
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
        <tr class=" negative zero positive">
            <td colspan="13" style="font-size:16px; font-weight:bold; text-align:center">
                <?php echo $message; ?></td>
        </tr>
        <tr class="titlesTr sticky negative zero positive">
            <th style="width: 2%; box-shadow: 0px 0px 0px 1px black inset;">SL</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;">Product Name</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">
                Stock
            </th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;">S.P</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">
                Sell Value
            </th>

            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">
                AVG P.P
            </th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 50px;">
                Stock Value
            </th>

        </tr>
        </thead>
        <tbody>

        <?php
        $sl = 1;
        $rowFound = false;

        $grandTotalSellValue = 0;
        $grandTotalStockValue = 0;

        if (!empty($data)):

            foreach ($data as $supplierId => $sup):

                $supplierTotalSell = 0;
                $supplierTotalStock = 0;
                $rowFound = true;
                ?>

                <!-- ======================= SUPPLIER HEADER ======================= -->
                <tr class="supplier-header">
                    <td colspan="7">
                        <div class="supplier-box">
                            <div class="supplier-name">
                                <i class="fa fa-industry"></i> <?= $sup['supplier_name'] ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- ======================= PRODUCTS ======================= -->
                <?php foreach ($sup['products'] as $prod): ?>

                <?php
                $sellValue = floatval($prod['sell_price'] * $prod['qty']);
                $stockValue = floatval($prod['avg_pp'] * $prod['qty']);

                $supplierTotalSell += $sellValue;
                $supplierTotalStock += $stockValue;

                $grandTotalSellValue += $sellValue;
                $grandTotalStockValue += $stockValue;
                ?>

                <tr class="product-row">
                    <td><?= $sl++ ?></td>
                    <td><?= $prod['product_name'] ?></td>
                    <td style="text-align:right;"><?= $prod['qty'] ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($prod['sell_price']), 2) ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($sellValue), 2) ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($prod['avg_pp']), 2) ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($stockValue), 2) ?></td>
                </tr>

            <?php endforeach; ?>

                <!-- ======================= SUPPLIER TOTAL ======================= -->
                <tr class="supplier-total">
                    <td colspan="4" style="text-align:right;">Supplier Total</td>
                    <td style="text-align:right;"><?= number_format(floatval($supplierTotalSell), 2) ?></td>
                    <td></td>
                    <td style="text-align:right;"><?= number_format(floatval($supplierTotalStock), 2) ?></td>
                </tr>

                <tr>
                    <td colspan="7" style="background:#fff;"></td>
                </tr>

            <?php endforeach; ?>

        <?php endif; ?>


        <?php if (!$rowFound): ?>

            <tr>
                <td colspan="13" style='text-align:center; font-size:18px;'>
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No result found!</div>
                </td>
            </tr>

        <?php else: ?>

            <!-- ======================= GRAND TOTAL ======================= -->
            <tr class="grand-total">
                <td colspan="4" style="text-align:right;">Grand Total</td>
                <td style="text-align:right;"><?= number_format(floatval($grandTotalSellValue), 2) ?></td>
                <td></td>
                <td style="text-align:right;"><?= number_format(floatval($grandTotalStockValue), 2) ?></td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>
</div>
<style>
    .supplier-header td {
        padding: 0 !important;
        background: #eef5ff;
    }

    .supplier-box {
        padding: 10px;
        font-size: 15px;
        font-weight: bold;
        border-left: 4px solid #3b7ddd;
        background: #eef5ff;
    }

    .supplier-name i {
        margin-right: 6px;
        color: #3b7ddd;
    }

    .product-row:hover {
        background: #f1f1f1 !important;
    }

    .product-row td.num {
        text-align: right !important;
    }

    .supplier-total {
        background: #fafafa;
        font-weight: bold;
    }

    .supplier-total td {
        border-top: 2px solid #ccc;
        border-bottom: 2px solid #ccc;
    }

    .grand-total {
        background: #d0f0d0;
        font-weight: bold;
        font-size: 13px;
    }

    .grand-total td {
        border-top: 2px solid #8BC34A;
        border-bottom: 2px solid #8BC34A;
    }

    .no-result {
        font-size: 18px;
        text-align: center;
    }
</style>


<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">LEDGER</h5>
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

<!-- modal for stock qty modify -->
<div class="modal fade" id="stockQtyModifyModal" tabindex="-1" role="dialog" aria-labelledby="stockQtyModifyModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stock Quantity Modify</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
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

    let anyLedgerCall = false;

    $(function () {
        $(".exportToExcel").click(function (e) {
            var table = $('.table2excel');
            console.log(table);
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "STOCK_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });


    function currentStockPreview(element, product_id) {
        if (anyLedgerCall) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }
        anyLedgerCall = true;

        var invoiceId = element.innerHTML;
        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        $.ajax({
            url: '<?= Yii::app()->createUrl("inventory/inventory/currentStockReportBatchWiseView") ?>',
            type: 'GET',
            data: {
                product_id: product_id
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                element.innerHTML = invoiceId;
            },
            error: function () {
                element.innerHTML = invoiceId;
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });
    }

    function currentStockOutPreview(element, product_id) {
        if (anyLedgerCall) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }
        anyLedgerCall = true;

        var invoiceId = element.innerHTML;
        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        $.ajax({
            url: '<?= Yii::app()->createUrl("inventory/inventory/currentStockOutReportBatchWiseView") ?>',
            type: 'GET',
            data: {
                product_id: product_id,
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                element.innerHTML = invoiceId;
            },
            error: function () {
                element.innerHTML = invoiceId;
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });
    }

    function currentStockInPreview(element, product_id, start_date, end_date) {

        if (anyLedgerCall) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }

        var invoiceId = element.innerHTML;
        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        $.ajax({
            url: '<?= Yii::app()->createUrl("inventory/inventory/currentStockInReportBatchWiseView") ?>',
            type: 'GET',
            data: {
                product_id: product_id
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                element.innerHTML = invoiceId;
            },
            error: function () {
                element.innerHTML = invoiceId;
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });
    }


    $('body').off('click', '.showProductLedger').on('click', '.showProductLedger', showProductLedger);

    function showProductLedger() {
        if (anyLedgerCall) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }

        let model_id = $(this).data('id');
        let currentText = $(this).text();
        let $this = $(this);
        $this.html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("report/productStockLedgerView") ?>',
            type: 'POST',
            data: {
                'Inventory[model_id]': model_id,
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                $this.html(currentText);
            },
            error: function () {
                $this.html(currentText);
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });
    }
</script>