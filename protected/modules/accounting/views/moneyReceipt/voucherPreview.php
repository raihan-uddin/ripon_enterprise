<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>

<style>
    @page {
        size: A5 landscape;
        margin: 6mm 8mm;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body { margin: 0; padding: 0; }
        .page-break-div { page-break-after: always !important; }
    }

    .mr-doc {
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 12px;
        color: #111;
        width: 100%;
        max-width: 7.5in;
        margin: 0 auto;
        box-sizing: border-box;
    }

    /* ── Header ── */
    .mr-header {
        display: table;
        width: 100%;
        table-layout: fixed;
        border-bottom: 3px solid #0077d9;
        padding-bottom: 8px;
        margin-bottom: 0;
    }
    .mr-header-logo,
    .mr-header-company,
    .mr-header-meta {
        display: table-cell;
        vertical-align: middle;
    }
    .mr-header-logo {
        width: 22%;
    }
    .mr-header-logo img {
        height: 90px;
        max-width: 160px;
        object-fit: contain;
    }
    .mr-header-company {
        width: 50%;
        text-align: center;
        padding: 0 10px;
    }
    .mr-header-company .co-name {
        font-size: 20px;
        font-weight: 700;
        color: #0a1a2e;
        letter-spacing: 0.5px;
        line-height: 1.2;
    }
    .mr-header-company .co-detail {
        font-size: 10.5px;
        color: #444;
        line-height: 1.7;
        margin-top: 3px;
    }
    .mr-header-meta {
        width: 28%;
        text-align: right;
        vertical-align: bottom;
        padding-bottom: 2px;
    }

    /* ── Title banner ── */
    .mr-title-banner {
        background: #0077d9;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    /* ── MR number badge ── */
    .mr-no-badge {
        display: inline-block;
        background: #f0f7ff;
        border: 1.5px solid #0077d9;
        border-radius: 4px;
        padding: 3px 12px;
        font-size: 13px;
        font-weight: 700;
        color: #0055aa;
        font-family: monospace;
        letter-spacing: 0.5px;
    }
    .mr-date-label {
        font-size: 11px;
        color: #555;
        margin-top: 4px;
    }
    .mr-date-value {
        font-size: 12px;
        font-weight: 700;
        color: #0a1a2e;
    }

    /* ── Body rows ── */
    .mr-body {
        border: 1.5px solid #c8d8e8;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 12px;
    }
    .mr-row {
        display: table;
        width: 100%;
        table-layout: fixed;
        border-bottom: 1px solid #e4ecf4;
        min-height: 30px;
    }
    .mr-row:last-child {
        border-bottom: none;
    }
    .mr-row-label,
    .mr-row-value {
        display: table-cell;
        vertical-align: middle;
        padding: 7px 12px;
    }
    .mr-row-label {
        width: 22%;
        background: #f4f8fc;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #5a7a9a;
        border-right: 1px solid #d0dae8;
        white-space: nowrap;
    }
    .mr-row-value {
        font-size: 12px;
        font-weight: 600;
        color: #0a1a2e;
    }
    .mr-amount-value {
        font-size: 14px;
        font-weight: 700;
        color: #1a7a40;
    }
    .mr-words {
        font-size: 10.5px;
        color: #555;
        font-style: italic;
        margin-top: 2px;
    }
    .mr-discount-tag {
        display: inline-block;
        background: #fff3cd;
        border: 1px solid #e0c870;
        color: #7a5800;
        font-size: 10px;
        font-weight: 700;
        padding: 1px 8px;
        border-radius: 10px;
        margin-left: 10px;
    }
    .mr-payment-badge {
        display: inline-block;
        background: #e8f4fd;
        border: 1px solid #a8cce8;
        color: #1a6fa3;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 10px;
        letter-spacing: 0.5px;
    }

    /* ── Two-column row ── */
    .mr-row-half {
        display: table;
        width: 100%;
        table-layout: fixed;
        border-bottom: 1px solid #e4ecf4;
    }
    .mr-half {
        display: table-cell;
        vertical-align: middle;
    }
    .mr-half:first-child {
        border-right: 1px solid #e4ecf4;
    }

    /* ── Footer ── */
    .mr-footer {
        display: table;
        width: 100%;
        table-layout: fixed;
        margin-top: 24px;
    }
    .mr-footer-left,
    .mr-footer-right {
        display: table-cell;
        width: 50%;
        vertical-align: bottom;
        text-align: center;
        padding: 0 16px;
    }
    .mr-sig-line {
        border-top: 1.5px solid #333;
        padding-top: 5px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #444;
    }
    .mr-sig-name {
        font-size: 11px;
        font-weight: 700;
        color: #0a1a2e;
        margin-bottom: 2px;
    }

    /* ── Invoice ref chip ── */
    .mr-invoice-chip {
        display: inline-block;
        background: #f0f4f8;
        border: 1px solid #c8d8e8;
        border-radius: 4px;
        padding: 1px 8px;
        font-size: 11px;
        font-weight: 700;
        color: #1a2c3d;
        font-family: monospace;
    }
</style>

<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Money Receipt Preview</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if ($data): ?>
        <div style="margin-bottom:12px;">
            <?php
            echo "<div class='printBtn' style='display:inline-block;'>";
            $this->widget('ext.mPrint.mPrint', array(
                'title'      => ' ',
                'tooltip'    => 'Print',
                'text'       => '',
                'element'    => '.printAllTableForThisReport',
                'exceptions' => array('.summary', '.search-form', '#excludeDiv'),
                'publishCss' => false,
                'visible'    => !Yii::app()->user->isGuest,
                'alt'        => 'print',
                'debug'      => false,
                'id'         => 'print-div',
            ));
            echo "</div>";
            ?>
        </div>

        <?php
        $logoPath   = Yii::app()->theme->basePath . '/images/logo.svg';
        $logoInline = '';
        if (is_file($logoPath)) {
            $logoInline = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));
        }
        $amountInWord = new AmountInWord();
        ?>

        <?php foreach ($data as $dt):
            $paymentLabel = MoneyReceipt::model()->paymentTypeStringWithoutBedge($dt->payment_type);
            $isCheque     = ($paymentLabel === 'CHECK');
            $amountInt    = (int) floor($dt->amount);
            $amountWords  = $amountInWord->convert((string) $amountInt);
        ?>
        <div class="printAllTableForThisReport page-break-div">
        <div class="mr-doc">

            <!-- HEADER -->
            <div class="mr-header">
                <div class="mr-header-logo">
                    <?php if ($logoInline): ?>
                        <img src="<?= $logoInline ?>" alt="Logo">
                    <?php endif; ?>
                </div>
                <div class="mr-header-company">
                    <div class="co-name"><?= CHtml::encode(strtoupper(Yii::app()->params['company']['name'])) ?></div>
                    <div class="co-detail">
                        <?= CHtml::encode(Yii::app()->params['company']['address_line_1']) ?><br>
                        <?php if (!empty(Yii::app()->params['company']['address_line_2'])): ?>
                            <?= CHtml::encode(Yii::app()->params['company']['address_line_2']) ?><br>
                        <?php endif; ?>
                        Tel: <?= CHtml::encode(Yii::app()->params['company']['phone_1']) ?>
                        <?php if (!empty(Yii::app()->params['company']['phone_2'])): ?>
                            &nbsp;|&nbsp; <?= CHtml::encode(Yii::app()->params['company']['phone_2']) ?>
                        <?php endif; ?>
                        <?php if (!empty(Yii::app()->params['company']['email_1'])): ?>
                            <br><?= CHtml::encode(Yii::app()->params['company']['email_1']) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mr-header-meta">
                    <div class="mr-no-badge"><?= CHtml::encode($dt->mr_no) ?></div>
                    <div class="mr-date-label" style="margin-top:6px;">Date</div>
                    <div class="mr-date-value"><?= date('d M Y', strtotime($dt->date)) ?></div>
                </div>
            </div>

            <!-- TITLE BANNER -->
            <div class="mr-title-banner">Money Receipt</div>

            <!-- BODY -->
            <div class="mr-body">

                <!-- Received from -->
                <div class="mr-row">
                    <div class="mr-row-label">Received From</div>
                    <div class="mr-row-value"><?= CHtml::encode(Customers::model()->nameOfThis($dt->customer_id)) ?></div>
                </div>

                <!-- Amount -->
                <div class="mr-row">
                    <div class="mr-row-label">Amount (BDT)</div>
                    <div class="mr-row-value">
                        <span class="mr-amount-value"><?= number_format($dt->amount, 2) ?> /=</span>
                        <?php if ($dt->discount > 0): ?>
                            <span class="mr-discount-tag">Discount: <?= number_format($dt->discount, 2) ?></span>
                        <?php endif; ?>
                        <?php if ($amountWords): ?>
                            <div class="mr-words"><?= CHtml::encode(ucfirst($amountWords)) ?> taka only</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Payment type + Invoice ref (two halves) -->
                <div class="mr-row-half mr-body" style="border:none; border-bottom:1px solid #e4ecf4; margin-bottom:0; border-radius:0;">
                    <div class="mr-half">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-row-label">Payment Type</div>
                            <div class="mr-row-value">
                                <span class="mr-payment-badge"><?= CHtml::encode($paymentLabel) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="mr-half">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-row-label">Invoice Ref</div>
                            <div class="mr-row-value">
                                <?php if ($dt->invoice_id): ?>
                                    <span class="mr-invoice-chip">#<?= CHtml::encode($dt->invoice_id) ?></span>
                                <?php else: ?>
                                    <span style="color:#aaa;">—</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cheque details (only if cheque payment) -->
                <?php if ($isCheque): ?>
                <div class="mr-row-half mr-body" style="border:none; border-bottom:1px solid #e4ecf4; margin-bottom:0; border-radius:0;">
                    <div class="mr-half">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-row-label">Cheque No</div>
                            <div class="mr-row-value"><?= CHtml::encode($dt->cheque_no ?: '—') ?></div>
                        </div>
                    </div>
                    <div class="mr-half">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-row-label">Cheque Date</div>
                            <div class="mr-row-value"><?= $dt->cheque_date ? date('d M Y', strtotime($dt->cheque_date)) : '—' ?></div>
                        </div>
                    </div>
                </div>

                <!-- Bank -->
                <div class="mr-row">
                    <div class="mr-row-label">Bank</div>
                    <div class="mr-row-value"><?= CHtml::encode(CrmBank::model()->nameOfThis($dt->bank_id) ?: '—') ?></div>
                </div>
                <?php endif; ?>

                <!-- Being / Remarks -->
                <?php if (!empty($dt->remarks)): ?>
                <div class="mr-row">
                    <div class="mr-row-label">Being</div>
                    <div class="mr-row-value"><?= CHtml::encode($dt->remarks) ?></div>
                </div>
                <?php endif; ?>

            </div><!-- /mr-body -->

            <!-- FOOTER -->
            <div class="mr-footer">
                <div class="mr-footer-left">
                    <div class="mr-sig-name"><?= CHtml::encode(Users::model()->nameOfThis($dt->created_by)) ?></div>
                    <div class="mr-sig-line">Received By</div>
                </div>
                <div class="mr-footer-right">
                    <div class="mr-sig-line">For <?= CHtml::encode(strtoupper(Yii::app()->params['company']['name'])) ?></div>
                </div>
            </div>

        </div><!-- /mr-doc -->
        </div><!-- /printAllTableForThisReport -->
        <?php endforeach; ?>

        <?php else: ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle" style="margin-right:6px;"></i>No result found!</div>
        <?php endif; ?>
    </div>
</div>
