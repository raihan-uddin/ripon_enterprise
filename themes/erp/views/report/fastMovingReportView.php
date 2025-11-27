<?php
/**
 * @var string $message
 * @var string $startDate
 * @var string $endDate
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
<div class='printAllTableForThisReport table-responsive'>
    <div class="report-conditions-box"
         style="background:#f9f9f9; border:1px solid #ccc; padding:12px; margin-bottom:12px; font-size:13px; line-height:18px;">

        <strong style="font-size:14px;">Report Conditions (Fast Moving Logic):</strong>
        <br><br>

        <ul style="margin:0 0 0 18px; padding:0;">

            <li><strong>Date Range:</strong> <?= $startDate ?> to <?= $endDate ?></li>

            <li><strong>Fast Moving Definition:</strong> Products with the
                <u>highest stock-out quantity</u> during the selected period.
                (More stock-out = faster movement)
            </li>

            <li><strong>Movement Formula:</strong>
                Total Stock Out = SUM(stock_out) within the date range
            </li>

            <li><strong>Sale Value:</strong>
                Total Stock Out × Selling Price
            </li>

            <li><strong>Purchase Movement Value:</strong>
                Total Stock Out × Purchase Price
            </li>

            <li><strong>Sorting Logic:</strong>
                Sorted in <strong>descending order</strong> by Total Stock Out (Highest first)
            </li>
        </ul>
    </div>

    <table class="summaryTab table-bordered table-sm" id="fast-moving-table">
        <thead>
        <tr>
            <th colspan="9" style="font-size:16px; font-weight:bold; text-align:center">
                <?= $message ?>
            </th>
        </tr>
        <tr>
            <th>SL</th>
            <th>Product Name</th>
            <th>Code</th>
            <th>Company</th>
            <th>Total Stock Out</th>
            <th>Selling Price</th>
            <th>Sale Value</th>
            <th>Purchase Price</th>
            <th>Total Out Value</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $sl = 1;
        $grandSale = 0;
        $grandOutValue = 0;
        $dataFound = false;
        if (!empty($data)) {
            foreach ($data as $d) {
                if ($d->total_stock_out > 0) {
                    $dataFound = true;
                    $grandSale += $d->sale_value;
                    $grandOutValue += $d->total_out_value;

                    ?>
                    <tr>
                        <td><?= $sl++ ?></td>
                        <td><?= $d->model_name ?></td>
                        <td><?= $d->code ?></td>
                        <td><?= $d->manufacturer_name ?></td>
                        <td style="text-align:center"><?= $d->total_stock_out ?></td>
                        <td style="text-align:right"><?= number_format(floatval($d->sell_price), 2) ?></td>
                        <td style="text-align:right"><?= number_format(floatval($d->sale_value), 2) ?></td>
                        <td style="text-align:right"><?= number_format(floatval($d->purchase_price), 2) ?></td>
                        <td style="text-align:right"><?= number_format(floatval($d->total_out_value), 2) ?></td>
                    </tr>
                    <?php
                }
            }
        } else {
            ?>
            <tr>
                <td colspan="9" style="text-align: center;">No data found for the selected criteria.</td>
            </tr>
            <?php
        }
        if (!$dataFound) {
            ?>
            <tr>
                <td colspan="9" style="text-align: center;">No data found for the selected criteria.</td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <th colspan="6" style="text-align:right;">Grand Total</th>
            <th style="text-align:right;"><?= number_format(floatval($grandSale), 2) ?></th>
            <th></th>
            <th style="text-align:right;"><?= number_format(floatval($grandOutValue), 2) ?></th>
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
                    filename: "FAST_MOVING_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });


    function currentStockPreview(element, product_id, start_date, end_date) {
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

    function currentStockOutPreview(element, product_id, start_date, end_date) {
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
                start_date: start_date,
                end_date: end_date
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
                product_id: product_id,
                start_date: start_date,
                end_date: end_date
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
                'Inventory[date_from]': '<?= $startDate ?>',
                'Inventory[date_to]': '<?= $endDate ?>'
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