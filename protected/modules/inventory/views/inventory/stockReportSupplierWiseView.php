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

    #sticky-header-clone-sw {
        display: none;
        position: fixed;
        z-index: 1000;
        background: #1a2c3d;
        border-collapse: collapse;
    }

    #sticky-header-clone-sw th {
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
        transition: background-color 0.3s;
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

    .report-header-logo { flex: 0 0 auto; }

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
        .report-header-wrapper { width: 100%; page-break-inside: avoid; }
        .report-header-inner { display: table; width: 100%; table-layout: fixed; }
        .report-header-logo,
        .report-header-company,
        .report-header-meta { display: table-cell; vertical-align: middle; }
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
        'title' => ' ',
        'tooltip' => 'Print',
        'text' => '',
        'element' => '.printAllTableForThisReport',
        'exceptions' => array(),
        'publishCss' => TRUE,
        'visible' => !Yii::app()->user->isGuest,
        'alt' => 'print',
        'debug' => FALSE,
        'id' => 'print-div2'
));
echo "</div>";
?>

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
            <div class="report-title">Stock Report (Supplier Wise)</div>
            <div><span class="meta-label">Period:</span> <?= htmlspecialchars($message) ?></div>
            <div><span class="meta-label">Generated:</span> <?= date('d M Y, h:i A') ?></div>
            <div><span class="meta-label">Printed by:</span> <?= htmlspecialchars(Yii::app()->user->name) ?></div>
        </div>

    </div>
</div>

<div class="stock-table-wrapper">
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-sw">
        <thead>
        <tr class="titlesTr negative zero positive">
            <th style="width: 2%;">SL</th>
            <th>Product Name</th>
            <th>Manufacturer</th>
            <th style="width: 10%; min-width: 60px;">Stock</th>
            <th>S.P</th>
            <th style="width: 10%; min-width: 60px;">Sell Value</th>
            <th style="width: 10%; min-width: 60px;">AVG P.P</th>
            <th style="width: 10%; min-width: 50px;">Stock Value</th>
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
                    <td colspan="8">
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
                    <td><?= $prod['manufacturer_name'] ?></td>
                    <td style="text-align:right;"><?= $prod['qty'] ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($prod['sell_price']), 2) ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($sellValue), 2) ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($prod['avg_pp']), 2) ?></td>
                    <td style="text-align:right;"><?= number_format(floatval($stockValue), 2) ?></td>
                </tr>

            <?php endforeach; ?>

                <!-- ======================= SUPPLIER TOTAL ======================= -->
                <tr class="supplier-total">
                    <td colspan="5" style="text-align:right;">Supplier Total</td>
                    <td style="text-align:right;"><?= number_format(floatval($supplierTotalSell), 2) ?></td>
                    <td></td>
                    <td style="text-align:right;"><?= number_format(floatval($supplierTotalStock), 2) ?></td>
                </tr>

                <tr>
                    <td colspan="8" style="background:#fff;"></td>
                </tr>

            <?php endforeach; ?>

        <?php endif; ?>


        <?php if (!$rowFound): ?>

            <tr>
                <td colspan="8" style='text-align:center; font-size:18px;'>
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No result found!</div>
                </td>
            </tr>

        <?php else: ?>

            <!-- ======================= GRAND TOTAL ======================= -->
            <tr class="grand-total">
                <td colspan="5" style="text-align:right;">Grand Total</td>
                <td style="text-align:right;"><?= number_format(floatval($grandTotalSellValue), 2) ?></td>
                <td></td>
                <td style="text-align:right;"><?= number_format(floatval($grandTotalStockValue), 2) ?></td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>
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
<div class="modal fade" id="information-modal" tabindex="-1" data-bs-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">LEDGER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Loading...</p>
            </div>
        </div>
    </div>
</div>


<script>

    let anyLedgerCallSw = false;

    $(function () {
        $(".exportToExcel").click(function (e) {
            var table = $('.table2excel');
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "STOCK_REPORT_SUPPLIER-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
        if (anyLedgerCallSw) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }
        anyLedgerCallSw = true;

        var invoiceId = element.innerHTML;
        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        $.ajax({
            url: '<?= Yii::app()->createUrl("inventory/inventory/currentStockReportBatchWiseView") ?>',
            type: 'GET',
            data: { product_id: product_id },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('information-modal')).show();
                $('#information-modal .modal-body').html(response);
                element.innerHTML = invoiceId;
            },
            error: function () {
                element.innerHTML = invoiceId;
                toastr.error('Something went wrong');
            },
            complete: function () { anyLedgerCallSw = false; }
        });
    }

    function currentStockOutPreview(element, product_id) {
        if (anyLedgerCallSw) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }
        anyLedgerCallSw = true;

        var invoiceId = element.innerHTML;
        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        $.ajax({
            url: '<?= Yii::app()->createUrl("inventory/inventory/currentStockOutReportBatchWiseView") ?>',
            type: 'GET',
            data: { product_id: product_id },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('information-modal')).show();
                $('#information-modal .modal-body').html(response);
                element.innerHTML = invoiceId;
            },
            error: function () {
                element.innerHTML = invoiceId;
                toastr.error('Something went wrong');
            },
            complete: function () { anyLedgerCallSw = false; }
        });
    }

    function currentStockInPreview(element, product_id, start_date, end_date) {
        if (anyLedgerCallSw) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }

        var invoiceId = element.innerHTML;
        element.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        $.ajax({
            url: '<?= Yii::app()->createUrl("inventory/inventory/currentStockInReportBatchWiseView") ?>',
            type: 'GET',
            data: { product_id: product_id },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('information-modal')).show();
                $('#information-modal .modal-body').html(response);
                element.innerHTML = invoiceId;
            },
            error: function () {
                element.innerHTML = invoiceId;
                toastr.error('Something went wrong');
            },
            complete: function () { anyLedgerCallSw = false; }
        });
    }

    $('body').off('click', '.showProductLedger').on('click', '.showProductLedger', showProductLedger);

    function showProductLedger() {
        if (anyLedgerCallSw) {
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
            data: { 'Inventory[model_id]': model_id },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('information-modal')).show();
                $('#information-modal .modal-body').html(response);
                $this.html(currentText);
            },
            error: function () {
                $this.html(currentText);
                toastr.error('Something went wrong');
            },
            complete: function () { anyLedgerCallSw = false; }
        });
    }

    // JS sticky header
    (function () {
        var $table   = $('#table-sw');
        var $origRow = $table.find('thead tr.titlesTr');
        var $clone   = null;

        function buildClone() {
            var $c = $('<table id="sticky-header-clone-sw"><thead><tr></tr></thead></table>');
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
