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
       TOOLBAR
       ================================ */
    .report-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 14px;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .report-title {
        font-size: 14px;
        font-weight: 600;
        color: #343a40;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .report-actions {
        display: flex;
        gap: 8px;
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

    /* Left aligned text columns */
    .summaryTab td:nth-child(4),
    .summaryTab th:nth-child(4) {
        text-align: left;
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

    #sticky-header-clone-sr {
        display: none;
        position: fixed;
        z-index: 1000;
        background: #212529;
        border-collapse: collapse;
    }

    #sticky-header-clone-sr th {
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
       MOBILE
       ================================ */
    @media (max-width: 768px) {
        .report-toolbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .summaryTab {
            font-size: 11px;
        }
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
<div class='printAllTableForThisReport'>
    <div class="report-meta-card">

        <div class="meta-header">
            <div>
                <b>📊 Sales Report</b>
                <span class="meta-sub">
                System-generated summary & financial breakdown
            </span>
            </div>
            <div class="meta-time">
                Generated: <?= date('d M Y, h:i A') ?>
            </div>
        </div>

        <div class="meta-grid">
            <div>
                <small>Company</small>
                <b><?= CHtml::encode(Yii::app()->params['company']['name']) ?></b>
            </div>

            <div>
                <small>Date Range</small>
                <b><?= date('d/m/Y', strtotime($dateFrom)) ?> → <?= date('d/m/Y', strtotime($dateTo)) ?></b>
            </div>

            <div>
                <small>Grouped By</small>
                <b><?= CHtml::encode($group_by ?: 'Invoice') ?></b>
            </div>

            <div>
                <small>Sorted By</small>
                <b><?= CHtml::encode($sort_by ?: 'Date') ?> (<?= CHtml::encode($sort_order ?: 'ASC') ?>)</b>
            </div>

            <div>
                <small>Filters</small>
                <b>
                    <?= $customer_id > 0 ? 'Customer Applied' : 'All Customers' ?> |
                    <?= $created_by > 0 ? 'User Applied' : 'All Users' ?>
                </b>
            </div>
        </div>

        <div class="meta-formula">
            <b>Calculation Logic:</b>
            <ul>
                <li><b>Sell Value</b> = SUM(Total Amount)</li>
                <li><b>VAT</b> = SUM(VAT Amount)</li>
                <li><b>Net Amount</b> = Grand Total</li>
                <li><b>Net Income</b> = Total Amount − Costing − Discount − SR Commission − Road Fee − Damage + Delivery</li>
            </ul>
        </div>

    </div>
    <div class="stock-table-wrapper" style="overflow-x: auto;">
        <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
               id="table-sr">
            <thead>
            <tr class="titlesTr">
                <th style="width: 2%;">SL</th>
                <th style="width: 10%;">Date</th>
                <th style="width: 7%;">ID</th>
                <th>Customer</th>
                <th style="width: 10%;">Sell Value</th>
                <th style="width: 10%;">Vat</th>
                <th style="width: 10%;">Delivery Charge</th>
                <th style="width: 10%;">Discount</th>
                <th style="width: 10%;">Road Fee</th>
                <th style="width: 10%;">Damage</th>
                <th style="width: 10%;">SR Commission</th>
                <th style="width: 10%;">Amount</th>
                <th style="width: 10%;">N.I</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sl = 1;
            $rowFound = false;
            $groundTotal = $total_amount = $total_delivery_charge = $total_return = $total_vat = $total_sr_commission = $total_road_fee = $total_damage = 0;
            $row_closing = $row_closing_discount = $net_income_total = $total_due = 0;
            ?>

            <?php
            if ($data) {
                foreach ($data as $dmr) {
                    $total_amount += $dmr->total_amount;
                    $total_return += $dmr->total_return;
                    $total_delivery_charge += $dmr->delivery_charge;
                    $row_closing_discount += $dmr->discount_amount;
                    $total_vat += $dmr->vat_amount;
                    $total_sr_commission += $dmr->sr_commission;
                    $total_road_fee += $dmr->road_fee;
                    $total_damage += $dmr->damage_value;
                    $row_closing += $dmr->grand_total;
                    $netIncome = $dmr->total_amount - $dmr->costing - $dmr->discount_amount - $dmr->sr_commission - $dmr->road_fee - $dmr->damage_value + $dmr->delivery_charge;
                    $rowFound = true;

                    $net_income_total += $netIncome;
                    $total_due += $dmr->total_due;
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $sl++; ?></td>
                        <td style="text-align: center;">
                            <?php
                            if ($group_by === 't.id' || $group_by === 't.date' || $group_by === 'YEAR(t.date), MONTH(t.date)' || $group_by === 'YEAR(t.date)') {
                                echo $dmr->date;
                            }
                            ?>
                        </td>
                        <td style="text-align: center; text-decoration: underline; cursor: zoom-in;"
                            class="invoiceDetails"
                            title="click here to get the preview">
                            <?php
                            if ($group_by === 't.id') {
                                echo $dmr->id;
                            }
                            ?>
                        </td>
                        <td style="text-align: left;"><?php
                            if ($group_by === 't.id' || $group_by === 't.customer_id') {
                                echo sprintf("%s | %s", $dmr->customer_name, $dmr->contact_no);
                            }
                            ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->total_amount, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->vat_amount, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->delivery_charge, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->discount_amount, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->road_fee, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->damage_value, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->sr_commission, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($dmr->grand_total, 4); ?></td>
                        <td style="text-align: right;"><?php echo number_format($netIncome, 4); ?></td>
                    </tr>
                    <?php

                }
            }
            if (!$rowFound) {
                ?>
                <tr>
                    <td colspan='12' style='text-align: center; font-size: 18px; text-transform: uppercase; '>
                        <div class='alert alert-warning'><i class='fas fa-exclamation-triangle'></i> No result found !
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>

            <tr>
                <th style="text-align: right;" colspan="4">Ground Total</th>
                <th style="text-align: right;"><?= number_format($total_amount, 4) ?></th>
                <th style="text-align: right;"><?= number_format($total_vat, 4) ?></th>
                <th style="text-align: right;"><?= number_format($total_delivery_charge, 4) ?></th>
                <th style="text-align: right;"><?= number_format($row_closing_discount, 4) ?></th>
                <th style="text-align: right;"><?= number_format($total_road_fee, 4) ?></th>
                <th style="text-align: right;"><?= number_format($total_damage, 4) ?></th>
                <th style="text-align: right;"><?= number_format($total_sr_commission, 4) ?></th>
                <th style="text-align: right;"><?= number_format($row_closing, 4) ?></th>
                <th style="text-align: right;"><?= number_format($net_income_total, 4) ?></th>
            </tr>

            </tbody>
        </table>
    </div>
</div>

<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-bs-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    $('body #table-sr').off('click', '.invoiceDetails').on('click', '.invoiceDetails', function () {

        var invoiceId = $(this).text();
        var $this = $(this);
        $this.html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("sell/sellOrder/voucherPreview") ?>',
            type: 'POST',
            data: {
                invoiceId: invoiceId,
                show_profit: 1
            },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal")).show();
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
        var $table   = $('#table-sr');
        var $origRow = $table.find('thead tr.titlesTr');
        var $clone   = null;

        function buildClone() {
            var $c = $('<table id="sticky-header-clone-sr"><thead><tr></tr></thead></table>');
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