<?php
/** @var double $opening */
/** @var double $opening_purchase_amount */
/** @var double $opening_payment_amount */
/** @var string $message */
/** @var mixed $data */

date_default_timezone_set("Asia/Dhaka");

$total_purchase = $total_payment = $row_closing = 0;
$row_closing += $opening;

if ($data) {
    foreach ($data as $dmr) {
        if ($dmr['trx_type'] === 'purchase') {
            $row_closing += $dmr['amount'];
            $total_purchase += $dmr['amount'];
        } else {
            $row_closing -= $dmr['amount'];
            $total_payment += $dmr['amount'];
        }
    }
}
$closing_class = $row_closing < 0 ? 'negative' : 'positive';
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: "Inter", "Roboto", Arial, sans-serif;
        background: #f9fafc;
        color: #2f3542;
    }

    /* ==== SUMMARY STRIP ==== */
    .summary-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .summary-item {
        flex: 1;
        min-width: 180px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 12px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .summary-item .label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .summary-item .value {
        font-size: 17px;
        font-weight: 700;
        margin-top: 3px;
    }

    .summary-item.opening .value {
        color: #1976d2;
    }

    .summary-item.purchase .value {
        color: #2e7d32;
    }

    .summary-item.payment .value {
        color: #d32f2f;
    }

    .summary-item.closing.positive .value {
        color: #2e7d32;
    }

    .summary-item.closing.negative .value {
        color: #c62828;
    }

    /* ==== TABLE ==== */
    .summaryTab {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        font-size: 13px;
    }

    .summaryTab thead tr:first-child td {
        background: #1e88e5;
        color: #fff;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.4px;
        padding: 10px;
        text-align: center;
    }

    .summaryTab thead tr.titlesTr {
        background: #f1f5f9;
        color: #37474f;
        font-weight: 600;
    }

    .summaryTab th, .summaryTab td {
        border: 1px solid #e3e6ea;
        padding: 8px 10px;
        text-align: center;
        vertical-align: middle;
    }

    .summaryTab tbody tr:nth-child(even) {
        background: #f9fbfc;
    }

    .summaryTab tbody tr:hover {
        background: #eef4ff;
        transition: background .2s ease;
    }

    /* Transaction type badge */
    .trx-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }

    .trx-purchase {
        background: #2e7d32;
    }

    .trx-payment {
        background: #d32f2f;
    }

    .trx-other {
        background: #607d8b;
    }

    /* Trend arrow */
    .trend-up {
        color: #2e7d32;
        font-weight: 700;
    }

    .trend-down {
        color: #c62828;
        font-weight: 700;
    }

    /* Sticky Header */
    .titlesTr th {
        position: sticky;
        top: 0;
        background: #f1f5f9;
        z-index: 10;
    }


    /* Print mode */
    @media print {
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            background: #fff;
            font-size: 12px;
        }

        /* Hide UI elements */
        .printBtn,
        .exportToExcel {
            display: none !important;
        }

        /* Hide trend icons */
        .trend-up,
        .trend-down {
            display: none !important;
        }

        /* --- Show summary strip only on first page --- */
        .summary-strip {
            display: block !important;
            page-break-after: avoid;
            margin-bottom: 10px;
            border: 1px solid #aaa;
            box-shadow: none !important;
            background: #fafafa !important;
        }

        /* Hide duplicate summary if printed more than once */
        .summary-strip + .summary-strip {
            display: none !important;
        }

        /* Table cleanup */
        .summaryTab {
            box-shadow: none;
            border: 1px solid #000;
        }

        .summaryTab thead tr.titlesTr th {
            background: #ddd !important;
            color: #000 !important;
        }

        .summaryTab tbody tr:hover {
            background: white !important;
        }
    }


    /* Export Icon */
    .printBtn {
        margin-bottom: 12px;
    }

    .printBtn img {
        /*height: 28px;*/
        cursor: pointer;
        opacity: 0.85;
        transition: transform .2s ease, opacity .2s;
    }

    .exportToExcel {
        height: 50px;
    }

    .printBtn img:hover {
        transform: scale(1.1);
        opacity: 1;
    }

</style>

<div class="printBtn">
    <img class="exportToExcel" id="exportToExcel"
         src="<?= Yii::app()->theme->baseUrl ?>/images/excel.png"
         title="EXPORT TO EXCEL" alt="excel export">
    <?php
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
    ?>
</div>

<!-- === SUMMARY STRIP === -->
<div class="summary-strip">
    <div class="summary-item opening">
        <div class="label">Opening</div>
        <div class="value"><?= number_format((float)$opening, 2) ?></div>
    </div>
    <div class="summary-item purchase">
        <div class="label">Total Purchase</div>
        <div class="value"><?= number_format((float)$total_purchase, 2) ?></div>
    </div>
    <div class="summary-item payment">
        <div class="label">Total Payment</div>
        <div class="value"><?= number_format((float)$total_payment, 2) ?></div>
    </div>
    <div class="summary-item closing <?= $closing_class ?>">
        <div class="label">Closing Balance</div>
        <div class="value"><?= number_format((float)$row_closing, 2) ?></div>
    </div>
</div>

<script src="<?= Yii::app()->theme->baseUrl ?>/js/jquery.table2excel.js"></script>

<div class="printAllTableForThisReport table-responsive p-0">
    <table class="summaryTab table2excel table2excel_with_colors" id="table-1">
        <thead>
        <tr>
            <td colspan="10" style="text-align:center; font-weight:600; font-size:15px; padding:8px;">
                <?= nl2br($message) ?>
            </td>
        </tr>
        <tr class="titlesTr">
            <th>SL</th>
            <th>Trx Type</th>
            <th>Date</th>
            <th>ID</th>
            <th>Invoice No</th>
            <th>Amount</th>
            <th>Closing</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $previous_closing = $opening;
        $row_closing = $opening;

        if ($opening) {
            echo "<tr style='background:#e3f2fd;font-weight:600;color:#1976d2;'>
                    <td></td>
                    <td>Opening</td>
                    <td colspan='3'></td>
                    <td style='text-align:right;'>" . number_format((float)$opening, 2) . "</td>
                    <td></td>
                  </tr>";
        }

        if ($data) {
            foreach ($data as $dmr) {
                $trx_type = $dmr['trx_type'];
                $amount = $dmr['amount'];
                if ($trx_type === 'purchase') {
                    $row_closing += $amount;
                } else {
                    $row_closing -= $amount;
                }

                $previous_closing = $row_closing;
                $rowFound = true;

                $badgeClass = $trx_type === 'purchase' ? 'trx-purchase' :
                        ($trx_type === 'payment' ? 'trx-payment' : 'trx-other');

                echo "<tr>
                        <td>{$sl}</td>
                        <td><span>" . ucfirst($trx_type) . "</span></td>
                        <td>{$dmr['date']}</td>
                        <td>{$dmr['id']}</td>
                        <td style='text-align:left;'>{$dmr['order_no']}</td>
                        <td style='text-align:right;'>" . number_format((float)$amount, 2) . "</td>
                        <td style='text-align:right;'>" . number_format((float)$row_closing, 2) . "</td>
                      </tr>";
                $sl++;
            }
        }

        if (!$rowFound) {
            echo "<tr><td colspan='7'>
                    <div class='alert alert-warning' style='text-align:center; font-weight:600;'>
                        <i class='fa fa-exclamation-triangle'></i> No result found!
                    </div>
                  </td></tr>";
        }

        echo "<tr style='background:#f1f5f9;font-weight:600;color:#37474f;'>
                <td colspan='2'></td>
                <td>Opening Purchase</td>
                <td>Opening Payment</td>
                <td>Date Range Purchase</td>
                <td>Date Range Payment</td>
                <td>Closing</td>
              </tr>
              <tr style='background:#e8f5e9;font-weight:600;color:#2e7d32;'>
                <td colspan='2'></td>
                <td>" . number_format((float)$opening_purchase_amount, 2) . "</td>
                <td>" . number_format((float)$opening_payment_amount, 2) . "</td>
                <td>" . number_format((float)$total_purchase, 2) . "</td>
                <td>" . number_format((float)$total_payment, 2) . "</td>
                <td>" . number_format((float)$row_closing, 2) . "</td>
              </tr>";
        ?>
        </tbody>
    </table>
</div>

<script>
    $(function () {
        $(".exportToExcel").click(function () {
            var table = $('.table2excel');
            if (table.length) {
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Supplier Ledger",
                    filename: "SUPPLIER_LEDGER-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true
                });
            }
        });
    });
</script>
