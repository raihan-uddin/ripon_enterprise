<?php
/**
 * @var array|null  $data
 * @var float       $opening
 * @var int         $personId
 * @var string      $message
 */
?>
<style>
    .loan-ledger-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .loan-ledger-table thead th {
        background: #1a2c3d;
        color: #fff;
        padding: 6px 9px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #2c3e50;
        white-space: nowrap;
    }

    .loan-ledger-table tbody td {
        padding: 4px 9px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .loan-ledger-table tfoot td {
        padding: 5px 9px;
        font-weight: 700;
        font-size: 12px;
        border: 1px solid #dee2e6;
        background: #f0f4f8;
    }

    /* Row types */
    .row-lend {
        background: #fff5f5;
    }

    .row-borrow {
        background: #f5fff8;
    }

    .row-lend:hover td  { background: #ffe8e8 !important; }
    .row-borrow:hover td { background: #e2f7e9 !important; }

    /* Amount cells */
    .amt-dr {
        color: #c0392b;
        font-weight: 700;
        text-align: right;
    }

    .amt-cr {
        color: #1a7a40;
        font-weight: 700;
        text-align: right;
    }

    .amt-blank {
        color: #ccc;
        text-align: right;
    }

    .bal-paona {
        color: #c0392b;
        font-weight: 700;
        text-align: right;
    }

    .bal-dena {
        color: #1a7a40;
        font-weight: 700;
        text-align: right;
    }

    .bal-zero {
        color: #888;
        text-align: right;
    }

    /* Opening / closing rows */
    .row-opening td, .row-closing td {
        background: #eaf0f8;
        font-weight: 700;
        font-style: italic;
        color: #1a2c3d;
    }

    /* Type badge */
    .badge-lend {
        background: #fdecea;
        color: #c0392b;
        border: 1px solid #f5b7b1;
        padding: 1px 6px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-borrow {
        background: #e6f9ee;
        color: #1a7a40;
        border: 1px solid #a9dfbf;
        padding: 1px 6px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Summary cards */
    .loan-summary-cards {
        display: flex;
        gap: 8px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .loan-summary-card {
        flex: 1;
        min-width: 120px;
        border-radius: 4px;
        padding: 8px 12px;
        border-left: 3px solid;
    }

    .loan-summary-card .card-label {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 2px;
    }

    .loan-summary-card .card-value {
        font-size: 16px;
        font-weight: 800;
    }

    .card-opening  { background:#f0f4f8; border-color:#7f8c8d; color:#34495e; }
    .card-dr       { background:#fff5f5; border-color:#e74c3c; color:#c0392b; }
    .card-cr       { background:#f5fff8; border-color:#27ae60; color:#1a7a40; }
    .card-closing-paona { background:#fff0f0; border-color:#e74c3c; color:#c0392b; }
    .card-closing-dena  { background:#f0fff4; border-color:#27ae60; color:#1a7a40; }
    .card-closing-zero  { background:#f8f9fa; border-color:#95a5a6; color:#666; }

    .report-message {
        background: #f0f4f8;
        border-left: 3px solid #1a2c3d;
        padding: 5px 10px;
        font-size: 12px;
        color: #1a2c3d;
        margin-bottom: 8px;
        border-radius: 3px;
    }

    @media print {
        @page { size: A4; margin: 8mm 8mm 8mm 8mm; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

        /* Compact summary cards */
        .loan-summary-cards { display: table; width: 100%; margin-bottom: 8px; }
        .loan-summary-card  { display: table-cell; padding: 6px 10px; }
        .loan-summary-card .card-label { font-size: 8px; margin-bottom: 2px; }
        .loan-summary-card .card-value { font-size: 14px; }

        /* Compact report message */
        .report-message { padding: 4px 10px; margin-bottom: 8px; font-size: 11px; }

        /* Compact table */
        .loan-ledger-table { font-size: 10px; }
        .loan-ledger-table thead th { padding: 5px 7px; font-size: 9px; background: #1a2c3d !important; color: #fff !important; }
        .loan-ledger-table tbody td { padding: 4px 7px; }
        .loan-ledger-table tfoot td  { padding: 5px 7px; font-size: 10px; }

        /* Row colors */
        .row-lend  td { background: #fff5f5 !important; }
        .row-borrow td { background: #f5fff8 !important; }
        .row-opening td, .row-closing td { background: #eaf0f8 !important; }
    }
</style>

<?php if ($data === null): ?>
    <div class="alert alert-info"><i class="fas fa-info-circle"></i> অনুসন্ধান করুন।</div>
<?php elseif (empty($data) && $opening == 0): ?>
    <div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> এই সময়কালে কোনো লেনদেন বা ব্যালেন্স পাওয়া যায়নি। (No transactions or balance found)</div>
<?php else: ?>


    <div class="loan-ledger-print-area">
    <div class="report-message" style="margin-bottom:10px;"><?= $message ?></div>

    <?php
    // Calculate totals
    $totalDr = 0;
    $totalCr = 0;
    foreach ($data as $row) {
        if ($row['transaction_type'] === 'lend')   $totalDr += $row['amount'];
        else                                        $totalCr += $row['amount'];
    }
    $closing = $opening + $totalDr - $totalCr;

    // Closing card class
    if ($closing > 0)      $closingCardClass = 'card-closing-paona';
    elseif ($closing < 0)  $closingCardClass = 'card-closing-dena';
    else                   $closingCardClass = 'card-closing-zero';

    $closingLabel = $closing > 0
        ? 'পাওনা (Receivable)'
        : ($closing < 0 ? 'দেনা (Payable)' : 'সমান (Settled)');
    ?>

    <!-- Summary cards -->
    <div class="loan-summary-cards">
        <div class="loan-summary-card card-opening">
            <div class="card-label">Opening Balance</div>
            <div class="card-value">
                <?= number_format(abs($opening), 2) ?>
                <span style="font-size:11px; font-weight:600; margin-left:4px;">
                    <?= $opening > 0 ? 'পাওনা' : ($opening < 0 ? 'দেনা' : 'শূন্য') ?>
                </span>
            </div>
        </div>
        <div class="loan-summary-card card-dr">
            <div class="card-label">Total DR — দিলাম</div>
            <div class="card-value"><?= number_format($totalDr, 2) ?></div>
        </div>
        <div class="loan-summary-card card-cr">
            <div class="card-label">Total CR — নিলাম / পেলাম</div>
            <div class="card-value"><?= number_format($totalCr, 2) ?></div>
        </div>
        <div class="loan-summary-card <?= $closingCardClass ?>">
            <div class="card-label">Closing — <?= $closingLabel ?></div>
            <div class="card-value"><?= number_format(abs($closing), 2) ?></div>
        </div>
    </div>

    <!-- Ledger table -->
    <div style="overflow-x:auto;">
    <table class="loan-ledger-table">
        <thead>
            <tr>
                <th style="width:36px;">#</th>
                <th style="width:95px;">তারিখ (Date)</th>
                <?php if (!$personId): ?><th>ব্যক্তি (Person)</th><?php endif; ?>
                <th>বিবরণ (Note)</th>
                <th style="width:80px; text-align:center;">ধরন (Type)</th>
                <th style="width:110px;">DR — দিলাম</th>
                <th style="width:110px;">CR — নিলাম</th>
                <th style="width:120px;">Balance</th>
            </tr>
        </thead>
        <tbody>
            <!-- Opening row -->
            <tr class="row-opening">
                <td colspan="<?= $personId ? 4 : 5 ?>" style="text-align:right;">Opening Balance</td>
                <td></td>
                <td></td>
                <td class="<?= $opening > 0 ? 'bal-paona' : ($opening < 0 ? 'bal-dena' : 'bal-zero') ?>">
                    <?= number_format(abs($opening), 2) ?>
                    <span style="font-size:10px; font-weight:400;">
                        <?= $opening > 0 ? ' পাওনা' : ($opening < 0 ? ' দেনা' : '') ?>
                    </span>
                </td>
            </tr>

            <?php
            $balance = $opening;
            $sl = 1;
            foreach ($data as $row):
                $isLend = $row['transaction_type'] === 'lend';
                $balance += $isLend ? $row['amount'] : -$row['amount'];
                $rowClass = $isLend ? 'row-lend' : 'row-borrow';
            ?>
            <tr class="<?= $rowClass ?>">
                <td style="text-align:center; color:#aaa; font-size:11px;"><?= $sl++ ?></td>
                <td style="white-space:nowrap;"><?= date('d M Y', strtotime($row['transaction_date'])) ?></td>
                <?php if (!$personId): ?>
                <td style="font-weight:600;"><?= htmlspecialchars($row['person_name']) ?></td>
                <?php endif; ?>
                <td style="color:#555;"><?= htmlspecialchars($row['note'] ?: '—') ?></td>
                <td style="text-align:center;">
                    <?php if ($isLend): ?>
                        <span class="badge-lend">দিলাম (DR)</span>
                    <?php else: ?>
                        <span class="badge-borrow">নিলাম (CR)</span>
                    <?php endif; ?>
                </td>
                <td class="<?= $isLend ? 'amt-dr' : 'amt-blank' ?>">
                    <?= $isLend ? number_format($row['amount'], 2) : '—' ?>
                </td>
                <td class="<?= !$isLend ? 'amt-cr' : 'amt-blank' ?>">
                    <?= !$isLend ? number_format($row['amount'], 2) : '—' ?>
                </td>
                <td class="<?= $balance > 0 ? 'bal-paona' : ($balance < 0 ? 'bal-dena' : 'bal-zero') ?>">
                    <?= number_format(abs($balance), 2) ?>
                    <span style="font-size:10px; font-weight:400;">
                        <?= $balance > 0 ? ' পাওনা' : ($balance < 0 ? ' দেনা' : ' ✓') ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>

            <!-- Closing row -->
            <tr class="row-closing">
                <td colspan="<?= $personId ? 4 : 5 ?>" style="text-align:right;">Closing Balance</td>
                <td class="amt-dr"><?= number_format($totalDr, 2) ?></td>
                <td class="amt-cr"><?= number_format($totalCr, 2) ?></td>
                <td class="<?= $closing > 0 ? 'bal-paona' : ($closing < 0 ? 'bal-dena' : 'bal-zero') ?>">
                    <?= number_format(abs($closing), 2) ?>
                    <span style="font-size:10px; font-weight:400;">
                        <?= $closing > 0 ? ' পাওনা' : ($closing < 0 ? ' দেনা' : ' ✓') ?>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
    </div>

    </div><!-- /.loan-ledger-print-area -->

<?php endif; ?>
