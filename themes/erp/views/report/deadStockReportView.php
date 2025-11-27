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

        <strong style="font-size:14px;">Report Conditions:</strong>
        <br><br>

        <ul style="margin:0 0 0 18px; padding:0;">
            <li><strong>Date Range:</strong> <?= $startDate ?> to <?= $endDate ?></li>

            <li><strong>Non-Moving Logic:</strong> Showing items with
                <u>zero stock-out</u> (no sales/issuance) during the selected date range.
            </li>

            <li><strong>Dead Stock Logic:</strong> Closing Stock > 0 but
                <u>no movement</u> within the selected period.
            </li>

            <li><strong>Closing Stock Formula:</strong> (Opening Stock + Stock In) − Stock Out</li>

            <li><strong>Stock Value Formula:</strong> Closing Stock × Purchase Price</li>

        </ul>
    </div>

    <table class="summaryTab table-bordered table-sm" id="dead-stock-table">

        <thead>
        <tr>
            <th colspan="10" style="font-size:16px; font-weight:bold; text-align:center">
                <?= $message ?>
            </th>
        </tr>
        <tr>
            <th>SL</th>
            <th>Product Name</th>
            <th>Code</th>
            <th>Company</th>
            <th>Opening</th>
            <th>Stock In</th>
            <th>Stock Out</th>
            <th>Closing Stock</th>
            <th>Purchase Price</th>
            <th>Stock Value</th>
        </tr>
        </thead>

        <tbody>

        <?php
        $sl = 1;
        $grandStockValue = 0;

        foreach ($data as $d) {
            $grandStockValue += $d->stock_value;
            ?>
            <tr>
                <td><?= $sl++; ?></td>
                <td><?= $d->model_name ?></td>
                <td><?= $d->code ?></td>
                <td><?= $d->manufacturer_name ?></td>
                <td style="text-align:center"><?= $d->opening_stock ?></td>
                <td style="text-align:center"><?= $d->stock_in ?></td>
                <td style="text-align:center"><?= $d->stock_out ?></td>
                <td style="text-align:center"><?= $d->closing_stock ?></td>
                <td style="text-align:right"><?= number_format(floatval($d->purchase_price), 2) ?></td>
                <td style="text-align:right"><?= number_format(floatval($d->stock_value), 2) ?></td>
            </tr>
        <?php } ?>

        <tr>
            <th colspan="9" style="text-align:right;">Total Stock Value</th>
            <th style="text-align:right;"><?= number_format(floatval($grandStockValue, 2)) ?></th>
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
                    filename: "DEAD_STOCK_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });
    

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