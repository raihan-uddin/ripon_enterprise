<style>
    /* ================================
    ERP REPORT CARD LAYOUT
    ================================ */
    .report-card {
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 20px;
    }

    /* ================================
       TABLE BASE
       ================================ */
    .summaryTab {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .summaryTab th,
    .summaryTab td {
        padding: 6px 8px;
        border-bottom: 1px solid #e9ecef;
        text-align: right;
        white-space: nowrap;
    }

    /* ================================
       HEADER
       ================================ */
    .summaryTab thead th {
        background: #212529;
        color: #ffffff;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }

    #sticky-header-clone-sdr {
        display: none;
        position: fixed;
        z-index: 1000;
        background: #212529;
        border-collapse: collapse;
    }

    #sticky-header-clone-sdr th {
        background: #212529 !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        padding: 6px 8px;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
    }

    /* ================================
       ROW STYLES
       ================================ */
    .summaryTab tbody tr:nth-child(even) {
        background: #f8f9fa;
    }

    .summaryTab tbody tr:hover {
        background: #e9f5ff;
        transition: background 0.15s ease;
    }

    /* ================================
       INVOICE LINK STYLE
       ================================ */
    .invoiceDetails {
        color: #007bff;
        cursor: pointer;
        font-weight: 600;
    }

    .invoiceDetails:hover {
        text-decoration: underline;
    }

    /* ================================
       TOTAL ROW
       ================================ */
    .summaryTab .total-row th,
    .summaryTab .total-row td {
        background: #212529;
        color: #ffffff;
        font-weight: 700;
        border-top: 2px solid #000;
    }

    /* ================================
       NUMBER FORMAT
       ================================ */
    .summaryTab td {
        font-family: "JetBrains Mono", monospace;
        letter-spacing: 0.3px;
    }

    /* ================================
       MODAL POLISH
       ================================ */
    .modal-content {
        border-radius: 6px;
    }

    .modal-header {
        background: #212529;
        color: #ffffff;
    }

    .modal-footer {
        background: #f8f9fa;
    }

    /* ================================
       REPORT META PANEL
    ================================ */
    .report-meta-card {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-left: 4px solid #17a2b8;
        border-radius: 4px;
        margin-bottom: 12px;
        font-size: 12px;
    }

    .meta-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .meta-sub {
        display: block;
        font-size: 11px;
        color: #6c757d;
    }

    .meta-time {
        font-size: 11px;
        color: #495057;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 10px;
        padding: 10px 12px;
    }

    .meta-grid small {
        display: block;
        font-size: 10px;
        color: #6c757d;
    }

    .meta-grid b {
        font-weight: 600;
        color: #212529;
    }

    .meta-formula {
        padding: 8px 12px;
        border-top: 1px dashed #dee2e6;
        background: #fdfefe;
    }

    .meta-formula ul {
        padding-left: 16px;
        margin: 4px 0 0 0;
    }

    .meta-formula li {
        font-size: 11px;
        color: #495057;
    }

    @media (max-width: 768px) {
        .summaryTab { font-size: 11px; }
    }

    @media print {
        .stock-table-wrapper {
            overflow: visible !important;
        }

        .summaryTab {
            font-size: 10px;
        }

        .summaryTab th,
        .summaryTab td {
            white-space: normal !important;
            padding: 3px 4px;
        }

        .summaryTab thead th {
            white-space: nowrap !important;
        }
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

    <div class="report-meta-card">
        <div class="meta-header">
            <div>
                <b>📊 Sale Details Report</b>
                <span class="meta-sub">System-generated line-item sales breakdown</span>
            </div>
            <div class="meta-time">
                Generated: <?= date('d M Y, h:i A') ?>
            </div>
        </div>

        <div class="meta-grid">
            <div>
                <small>Period</small>
                <b><?= strip_tags($message) ?></b>
            </div>
            <div>
                <small>Printed By</small>
                <b><?= CHtml::encode(Yii::app()->user->name) ?></b>
            </div>
        </div>

        <div class="meta-formula">
            <b>Calculation Logic:</b>
            <ul>
                <li><b>P.P</b> = Purchase Price (Costing ÷ Qty)</li>
                <li><b>S.P</b> = Unit Sell Price</li>
                <li><b>T.S.P</b> = Row Total Sell Price</li>
                <li><b>N.I</b> = Net Income (Row Total − Costing)</li>
            </ul>
        </div>
    </div>

    <div class="stock-table-wrapper" style="overflow-x: auto;">
        <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
               id="table-sdr">
            <thead>
            <tr class="titlesTr">
                <th style="width: 2%;">SL</th>
                <th style="width: 10%;">Date</th>
                <th style="width: 7%;">Invoice Id</th>
                <th>Customer</th>
                <th>Product</th>
                <th style="width: 10%;" title="Purchase Price">P.P</th>
                <th style="width: 10%;">Qty</th>
                <th style="width: 10%;" title="Sell Price">S.P</th>
                <th style="width: 10%;" title="Row Total Sell Price">T.S.P</th>
                <th style="width: 10%;" title="Net Income">N.I</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sl = 1;
            $rowFound = false;
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
            if (!$rowFound) {
                ?>
                <tr>
                    <td colspan='10' style='text-align: center; font-size: 18px; text-transform: uppercase;'>
                        <div class='alert alert-warning'><i class='fa fa-exclamation-triangle'></i> No result found!</div>
                    </td>
                </tr>
                <?php
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
    </div>
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
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(".exportToExcel").click(function (e) {
            var table = $('.table2excel');
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "SALE_DETAILS_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });
    });

    $('#table-sdr').off('click', '.invoiceDetails').on('click', '.invoiceDetails', function () {
        var invoiceId = $(this).text();
        var $this = $(this);
        $this.html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("sell/sellOrder/voucherPreview") ?>',
            type: 'POST',
            data: { invoiceId: invoiceId },
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

    // JS sticky header
    (function () {
        var $table   = $('#table-sdr');
        var $origRow = $table.find('thead tr.titlesTr');
        var $clone   = null;

        function buildClone() {
            var $c = $('<table id="sticky-header-clone-sdr"><thead><tr></tr></thead></table>');
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
