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

    .stock-table-wrapper {
        overflow-x: auto;
    }

    .final-result thead tr.titlesTr th {
        background: #1a2c3d !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: 1px solid #243d54;
        border-bottom: 3px solid #17a2b8;
        text-align: center;
        padding: 7px 6px;
        white-space: nowrap;
    }

    #sticky-header-clone {
        display: none;
        position: fixed;
        z-index: 1000;
        background: #1a2c3d;
        border-collapse: collapse;
    }

    #sticky-header-clone th {
        background: #1a2c3d !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: 1px solid #243d54;
        border-bottom: 3px solid #17a2b8;
        text-align: center;
        padding: 7px 6px;
        white-space: nowrap;
    }

    .final-result tbody tr:hover {
        background: #dedede;
        transition: background-color 100ms;
    }

    table tr {
        transition: background-color 0.3s; /* Add transition for smooth effect */
    }


    /* ── Report header ── */
    .report-header-wrapper {
        border-bottom: 3px solid #0077d9;
        margin-bottom: 10px;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .report-header-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 8px;
    }

    .report-header-logo {
        flex: 0 0 auto;
    }

    .report-header-logo img {
        height: 90px;
        max-width: 200px;
        object-fit: contain;
    }

    .report-header-company {
        flex: 1 1 auto;
        text-align: center;
        line-height: 1.6;
    }

    .report-header-company .company-name {
        font-size: 22px;
        font-weight: 700;
        color: #1a2c3d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .report-header-company .company-sub {
        font-size: 12px;
        color: #555;
    }

    .report-header-meta {
        flex: 0 0 auto;
        text-align: right;
        font-size: 12px;
        line-height: 1.8;
        color: #444;
    }

    .report-header-meta .report-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a2c3d;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #17a2b8;
        padding-bottom: 2px;
        margin-bottom: 4px;
    }

    .report-header-meta .meta-label {
        color: #888;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media print {
        .report-header-wrapper {
            width: 100%;
            page-break-inside: avoid;
        }
        .report-header-inner {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        .report-header-logo,
        .report-header-company,
        .report-header-meta {
            display: table-cell;
            vertical-align: middle;
        }
        .report-header-logo  { width: 20%; }
        .report-header-company { width: 50%; text-align: center; }
        .report-header-meta  { width: 30%; text-align: right; }
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
<!--need a radio button group for show only stock, zero stock, negative stock-->
<div class="btn-group" data-toggle="buttons">
    <label class="btn btn-secondary active">
        <input type="radio" name="stockFilter" value="all" checked> Show All
    </label>
    <label class="btn btn-secondary">
        <input type="radio" name="stockFilter" value="negative"> Negative Stock
    </label>
    <label class="btn btn-secondary">
        <input type="radio" name="stockFilter" value="zero"> Zero Stock
    </label>
    <label class="btn btn-secondary">
        <input type="radio" name="stockFilter" value="positive"> Only Stock
    </label>
</div>
<script src="<?= Yii::app()->theme->baseUrl ?>/js/jquery.table2excel.js"></script>
<div class='printAllTableForThisReport'>

<?php
$logoPath   = Yii::app()->theme->basePath . '/images/logo.svg';
$logoInline = '';
if (is_file($logoPath)) {
    $logoInline = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));
}
?>

<div class="report-header-wrapper">
    <div class="report-header-inner">

        <div class="report-header-logo">
            <?php if ($logoInline): ?>
                <img src="<?= $logoInline ?>" alt="Logo">
            <?php endif; ?>
        </div>

        <div class="report-header-company">
            <div class="company-name"><?= htmlspecialchars(Yii::app()->params['company']['name']) ?></div>
            <div class="company-sub"><?= htmlspecialchars(Yii::app()->params['company']['address_line_1']) ?></div>
            <div class="company-sub">Tel: <?= htmlspecialchars(Yii::app()->params['company']['phone_1']) ?></div>
        </div>

        <div class="report-header-meta">
            <div class="report-title">Stock Report</div>
            <div><span class="meta-label">Period:</span> <?= htmlspecialchars($message) ?></div>
            <div><span class="meta-label">Generated:</span> <?= date('d M Y, h:i A') ?></div>
            <div><span class="meta-label">Printed by:</span> <?= htmlspecialchars(Yii::app()->user->name) ?></div>
        </div>

    </div>
</div>
<div class="stock-table-wrapper">
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-1">
        <thead>
        <tr class="titlesTr sticky negative zero positive">
            <th style="width: 2%;">SL</th>
            <th>Product Name</th>
            <th>Manufacturer</th>
            <th style="width: 10%; min-width: 30px;">Opening</th>
            <th style="width: 10%; min-width: 60px;">Stock In</th>
            <th style="width: 10%; min-width: 60px;">Stock Out</th>
            <th style="width: 10%; min-width: 60px;">Closing Stock</th>
            <th>AVG P.P</th>
            <th>Stock Value</th>
            <th>S.P</th>
            <th>Sell Value</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $groundTotalSaleValue = 0;
        $groundTotalStockValue = 0;
        foreach ($data as $dmr) {
            $avg_purchase_price = $dmr->avg_purchase_price;
            if ($dmr->opening_stock != 0 || $dmr->stock_in != 0 || $dmr->stock_out) {
                $closing = (($dmr->opening_stock + $dmr->stock_in) - $dmr->stock_out);
                $stockSaleValue = $closing * $dmr->sell_price;
                $cpp = $dmr->cpp;
                $rowFound = true;
                $groundTotalSaleValue += $stockSaleValue;

                $opening_stock_value = $dmr->opening_stock_value;
                $stock_in_value = $dmr->stock_in_value;
                $stock_out_value = $dmr->stock_out_value;
                $row_stock_closing_value = $closing > 0 ? $closing * $avg_purchase_price : 0;

                $groundTotalStockValue += $row_stock_closing_value;


                $negativeStockClass = $closing < 0 ? '  negative ' : ' ';
                $zeroStockClass = $closing == 0 ? '  zero ' : ' ';
                $positiveStockClass = $closing > 0 ? ' positive ' : ' ';
                ?>
                <tr class="<?= $positiveStockClass . $zeroStockClass . $negativeStockClass ?>">
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
                    <td style="text-align: left;">
                        <a href="#"
                            onclick="currentStockPreview(this, <?= $dmr->model_id > 0 ? $dmr->model_id : 0 ?>);">
                            <?php echo $dmr->model_name; ?>
                        </a>
                    </td>
                    <td style="text-align: left;"><?php echo $dmr->manufacturer_name; ?></td>
                    <td style="text-align: center;"
                        title="Stock Value: <?= number_format($opening_stock_value, 2) ?>"><?php echo $dmr->opening_stock; ?></td>
                    <td style="text-align: center;" title="Stock Value: <?= number_format($stock_in_value, 2) ?>"><a
                                href="#" onclick="currentStockInPreview( this,
                        <?= $dmr->model_id > 0 ? $dmr->model_id : 0 ?>,
                        <?= strtotime($startDate) ?>,
                        <?= strtotime($endDate) ?> )"
                        ><?php echo $dmr->stock_in; ?></a></td>
                    <td style="text-align: center;" title="Stock Value: <?= number_format($stock_out_value, 2) ?>"><a
                                href="#" onclick="currentStockOutPreview(this,
                        <?= $dmr->model_id > 0 ? $dmr->model_id : 0 ?>,
                        <?= strtotime($startDate) ?>,
                        <?= strtotime($endDate) ?> )"
                        ><?php echo $dmr->stock_out; ?></a></td>
                    <td style="text-align: center;" class="showProductLedger" data-id="<?= $dmr->model_id ?>">
                        <a href="#">
                            <?php echo $closing; ?>
                        </a>
                    </td>
                    <td style="text-align: right;"><?php echo is_numeric($avg_purchase_price) ? number_format($avg_purchase_price, 2) : ''; ?></td>
                    <td style="text-align: right;"><?php echo is_numeric($row_stock_closing_value) ? number_format($row_stock_closing_value, 2) : ''; ?></td>
                    <td style="text-align: center;"><?php echo is_numeric($dmr->sell_price) ? number_format($dmr->sell_price, 2) : ''; ?></td>
                    <td style="text-align: right;"><?php echo is_numeric($stockSaleValue) ? number_format($stockSaleValue, 2) : ''; ?></td>
                </tr>
                <?php
            }
        }
        ?>
        <?php
        if (!$rowFound) {
            ?>
            <tr>
                <td colspan="14"
                    style='text-align: center; font-size: 18px; text-transform: uppercase; font-weight: bold;'>
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No result found !</div>
                </td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <th style="text-align: right;" colspan="8">Ground Total</th>
                <th style="text-align: right;"><?= number_format($groundTotalStockValue, 2) ?></th>
                <th> </th>
                <th style="text-align: right;"><?= number_format($groundTotalSaleValue, 2) ?></th>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
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

    $(document).ready(function () {
        $('input[name="stockFilter"]').change(function () {
            var selectedValue = $(this).val();
            $('#table-1 tr').each(function () {
                if (selectedValue === "all") {
                    $(this).show();
                } else if ($(this).hasClass(selectedValue)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Initial execution to show all rows
        $('input[value="all"]').change();
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

    // JS sticky header (CSS sticky blocked by layout overflow ancestors)
    (function () {
        var $table   = $('#table-1');
        var $origRow = $table.find('thead tr.titlesTr');
        var $clone   = null;

        function buildClone() {
            var $c = $('<table id="sticky-header-clone"><thead><tr></tr></thead></table>');
            $origRow.find('th').each(function () {
                var w = $(this).outerWidth();
                $c.find('tr').append(
                    $('<th>').text($(this).text()).css('width', w + 'px').css('min-width', w + 'px')
                );
            });
            $c.css('width', $table.outerWidth() + 'px');
            $('body').append($c);
            $clone = $c;
        }

        function updateClonePosition() {
            if (!$clone) return;
            var left = $table.offset().left - $(window).scrollLeft();
            $clone.css({ top: 0, left: left + 'px' });
        }

        $(window).on('scroll resize', function () {
            var tableTop    = $table.offset().top;
            var tableBottom = tableTop + $table.outerHeight();
            var scrollTop   = $(window).scrollTop();

            if (scrollTop > tableTop && scrollTop < tableBottom) {
                if (!$clone) buildClone();
                $clone.show();
                updateClonePosition();
            } else {
                if ($clone) $clone.hide();
            }
        });
    })();
</script>