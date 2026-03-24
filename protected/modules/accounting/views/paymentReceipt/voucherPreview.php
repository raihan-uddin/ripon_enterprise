<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>

<style>
    @page {
        size: A5 landscape;
        margin: 5mm 7mm;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        body { margin: 0; padding: 0; }
        .page-break-div { page-break-after: always !important; }
        .no-print { display: none !important; }
    }

    .pr-doc {
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 12px;
        color: #111;
        width: 100%;
        max-width: 7.6in;
        margin: 0 auto;
        box-sizing: border-box;
        border: 1.5px solid #c0cfe0;
        border-radius: 6px;
        overflow: hidden;
        padding-bottom: 12px;
    }

    /* ── Header ── */
    .pr-header {
        display: table;
        width: 100%;
        table-layout: fixed;
        background: #f5f9ff;
        border-bottom: 3px solid #0077d9;
        padding: 10px 14px;
        box-sizing: border-box;
    }
    .pr-header-logo,
    .pr-header-company,
    .pr-header-meta {
        display: table-cell;
        vertical-align: middle;
    }
    .pr-header-logo { width: 20%; }
    .pr-header-logo img {
        height: 80px;
        max-width: 150px;
        object-fit: contain;
    }
    .pr-header-company {
        width: 52%;
        text-align: center;
        padding: 0 8px;
    }
    .pr-header-company .co-name {
        font-size: 19px;
        font-weight: 700;
        color: #0a1a2e;
        letter-spacing: 0.5px;
        line-height: 1.2;
    }
    .pr-header-company .co-detail {
        font-size: 10px;
        color: #555;
        line-height: 1.8;
        margin-top: 3px;
    }
    .pr-header-meta {
        width: 28%;
        text-align: right;
        vertical-align: middle;
        padding-right: 4px;
    }

    /* ── PR number badge ── */
    .pr-no-badge {
        display: inline-block;
        background: #fff;
        border: 1.5px solid #0077d9;
        border-radius: 4px;
        padding: 3px 12px;
        font-size: 13px;
        font-weight: 700;
        color: #005bb5;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .pr-date-row {
        margin-top: 5px;
        font-size: 10px;
        color: #555;
    }
    .pr-date-row strong {
        font-size: 11px;
        color: #0a1a2e;
    }
    .pr-barcode { text-align: right; margin-top: 4px; }
    .pr-barcode svg { display: inline-block; overflow: visible; }

    /* ── Title banner ── */
    .pr-title-banner {
        background: linear-gradient(90deg, #005bb5 0%, #0077d9 60%, #2196f3 100%);
        color: #fff;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
    }

    /* ── Body ── */
    .pr-body-wrap { padding: 10px 14px 0; }
    .pr-body {
        border: 1px solid #d0dce8;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 10px;
    }
    .pr-row {
        display: table;
        width: 100%;
        table-layout: fixed;
        border-bottom: 1px solid #e8eef4;
        min-height: 28px;
        box-sizing: border-box;
    }
    .pr-row:last-child { border-bottom: none; }
    .pr-lbl, .pr-val {
        display: table-cell;
        vertical-align: middle;
        padding: 6px 10px;
    }
    .pr-lbl {
        width: 20%;
        background: #f0f5fb;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #5570a0;
        border-right: 1px solid #d0dce8;
        white-space: nowrap;
    }
    .pr-val {
        font-size: 12px;
        font-weight: 600;
        color: #0a1a2e;
    }

    /* ── Amount highlight ── */
    .pr-amount-block {
        background: #f0faf4;
        border-left: 4px solid #1a9a50;
        padding: 7px 10px;
    }
    .pr-amount-figure {
        font-size: 16px;
        font-weight: 700;
        color: #1a7a40;
        letter-spacing: 0.5px;
    }
    .pr-amount-words {
        font-size: 10px;
        font-style: italic;
        color: #4a7060;
        margin-top: 2px;
    }
    .pr-discount-tag {
        display: inline-block;
        background: #fff8e1;
        border: 1px solid #f0c040;
        color: #7a5000;
        font-size: 10px;
        font-weight: 700;
        padding: 1px 8px;
        border-radius: 10px;
        margin-left: 8px;
        vertical-align: middle;
    }

    /* ── Payment badge ── */
    .pr-pay-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 10px;
        letter-spacing: 0.5px;
    }
    .pr-pay-badge.cash   { background: #e6f9ee; border: 1px solid #88cca0; color: #1a6a30; }
    .pr-pay-badge.check  { background: #fff3e0; border: 1px solid #f0c060; color: #8a5000; }
    .pr-pay-badge.online { background: #f3e8ff; border: 1px solid #c090e8; color: #6a20a8; }

    /* ── Order ref chip ── */
    .pr-inv-chip {
        display: inline-block;
        background: #f0f4f8;
        border: 1px solid #c0cce0;
        border-radius: 4px;
        padding: 1px 8px;
        font-size: 11px;
        font-weight: 700;
        color: #1a2c3d;
        font-family: 'Courier New', monospace;
    }

    /* ── Two-col row ── */
    .pr-row-2col {
        display: table;
        width: 100%;
        table-layout: fixed;
        border-bottom: 1px solid #e8eef4;
    }
    .pr-row-2col:last-child { border-bottom: none; }
    .pr-col { display: table-cell; }
    .pr-col:first-child { border-right: 1px solid #e8eef4; }

    /* ── Footer ── */
    .pr-footer {
        display: table;
        width: 100%;
        table-layout: fixed;
        padding: 0 14px;
        margin-top: 10px;
        box-sizing: border-box;
    }
    .pr-footer-cell {
        display: table-cell;
        width: 33.3%;
        text-align: center;
        vertical-align: bottom;
        padding: 0 10px;
    }
    .pr-sig-space { height: 36px; }
    .pr-sig-line {
        border-top: 1.5px solid #555;
        padding-top: 4px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #555;
    }
</style>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file-text-o" style="margin-right:6px;"></i>Payment Receipt Preview</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if ($data): ?>

        <div class="no-print" style="margin-bottom:14px;">
            <?php
            echo "<div class='printBtn' style='display:inline-block;'>";
            $this->widget('ext.mPrint.mPrint', array(
                'title'      => ' ',
                'tooltip'    => 'Print',
                'text'       => '',
                'element'    => '.printAllTableForThisReport',
                'exceptions' => array('.summary', '.search-form', '#excludeDiv', '.no-print'),
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
        require_once(Yii::app()->basePath . '/vendors/html2pdf/_tcpdf_5.0.002/barcodes.php');
        $amountInWord = new AmountInWord();
        ?>

        <?php foreach ($data as $dt):
            $paymentLabel = PaymentReceipt::model()->paymentTypeStringWithoutBedge($dt->payment_type);
            $isCheque     = ($paymentLabel === 'CHECK');
            $badgeClass   = strtolower($paymentLabel);
            $amountInt    = (int) floor($dt->amount);
            $amountWords  = $amountInWord->convert((string) $amountInt);

            // Barcode for PR No
            $bcSvg = '';
            try {
                $bc    = new TCPDFBarcode($dt->pr_no, 'C128B');
                $bcArr = $bc->getBarcodeArray();
                $barW  = 1.2; $barH = 30; $pad = 2; $textH = 12;
                $svgW  = round($bcArr['maxw'] * $barW) + $pad * 2;
                $svgH  = $barH + $pad + $textH;
                $textY = $barH + $pad + 10;
                $x     = $pad; $rects = '';
                foreach ($bcArr['bcode'] as $bar) {
                    $bw = $bar['w'] * $barW;
                    if ($bar['t']) $rects .= '<rect x="'.$x.'" y="0" width="'.$bw.'" height="'.$barH.'" fill="#000"/>';
                    $x += $bw;
                }
                $bcSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$svgW.'" height="'.$svgH.'" style="display:block; overflow:visible;">'
                       . $rects
                       . '<text x="'.($svgW/2).'" y="'.$textY.'" text-anchor="middle" font-size="9" font-family="monospace" fill="#000">'.htmlspecialchars($dt->pr_no).'</text>'
                       . '</svg>';
            } catch (Exception $e) {}
        ?>

        <div class="printAllTableForThisReport page-break-div" style="margin-bottom:24px;">
        <div class="pr-doc">

            <!-- HEADER -->
            <div class="pr-header">
                <div class="pr-header-logo">
                    <?php if ($logoInline): ?>
                        <img src="<?= $logoInline ?>" alt="Logo">
                    <?php endif; ?>
                </div>

                <div class="pr-header-company">
                    <div class="co-name"><?= CHtml::encode(strtoupper(Yii::app()->params['company']['name'])) ?></div>
                    <div class="co-detail">
                        <?= CHtml::encode(Yii::app()->params['company']['address_line_1']) ?>
                        <?php if (!empty(Yii::app()->params['company']['address_line_2'])): ?>
                            &nbsp;&middot;&nbsp;<?= CHtml::encode(Yii::app()->params['company']['address_line_2']) ?>
                        <?php endif; ?>
                        <br>
                        Tel: <?= CHtml::encode(Yii::app()->params['company']['phone_1']) ?>
                        <?php if (!empty(Yii::app()->params['company']['phone_2'])): ?>
                            &nbsp;&middot;&nbsp;<?= CHtml::encode(Yii::app()->params['company']['phone_2']) ?>
                        <?php endif; ?>
                        <?php if (!empty(Yii::app()->params['company']['email_1'])): ?>
                            &nbsp;&middot;&nbsp;<?= CHtml::encode(Yii::app()->params['company']['email_1']) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="pr-header-meta">
                    <div class="pr-no-badge"><?= CHtml::encode($dt->pr_no) ?></div>
                    <div class="pr-date-row">Date: <strong><?= date('d M Y', strtotime($dt->date)) ?></strong></div>
                    <?php if ($bcSvg): ?>
                        <div class="pr-barcode"><?= $bcSvg ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TITLE BANNER -->
            <div class="pr-title-banner">&#11036; &nbsp; Payment Receipt &nbsp; &#11036;</div>

            <!-- BODY -->
            <div class="pr-body-wrap">
            <div class="pr-body">

                <!-- Payment To -->
                <div class="pr-row">
                    <div class="pr-lbl">Payment To</div>
                    <div class="pr-val"><?= CHtml::encode(Suppliers::model()->nameOfThis($dt->supplier_id)) ?></div>
                </div>

                <!-- Amount -->
                <div class="pr-row">
                    <div class="pr-lbl">Amount</div>
                    <div class="pr-val" style="padding:0;">
                        <div class="pr-amount-block">
                            <span class="pr-amount-figure">BDT <?= number_format($dt->amount, 2) ?> /=</span>
                            <?php if (!empty($dt->discount) && $dt->discount > 0): ?>
                                <span class="pr-discount-tag">Disc: <?= number_format($dt->discount, 2) ?></span>
                            <?php endif; ?>
                            <?php if ($amountWords): ?>
                                <div class="pr-amount-words"><?= CHtml::encode(ucfirst($amountWords)) ?> taka only</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Payment type + Order ref -->
                <div class="pr-row-2col">
                    <div class="pr-col">
                        <div class="pr-row" style="border-bottom:none;">
                            <div class="pr-lbl">Payment</div>
                            <div class="pr-val">
                                <span class="pr-pay-badge <?= $badgeClass ?>"><?= CHtml::encode($paymentLabel) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="pr-col">
                        <div class="pr-row" style="border-bottom:none;">
                            <div class="pr-lbl">Order Ref</div>
                            <div class="pr-val">
                                <?php if ($dt->order_id): ?>
                                    <span class="pr-inv-chip">#<?= CHtml::encode($dt->order_id) ?></span>
                                <?php else: ?>
                                    <span style="color:#bbb;">—</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cheque details (cheque only) -->
                <?php if ($isCheque): ?>
                <div class="pr-row-2col">
                    <div class="pr-col">
                        <div class="pr-row" style="border-bottom:none;">
                            <div class="pr-lbl">Cheque No</div>
                            <div class="pr-val"><?= CHtml::encode($dt->cheque_no ?: '—') ?></div>
                        </div>
                    </div>
                    <div class="pr-col">
                        <div class="pr-row" style="border-bottom:none;">
                            <div class="pr-lbl">Cheque Date</div>
                            <div class="pr-val"><?= $dt->cheque_date ? date('d M Y', strtotime($dt->cheque_date)) : '—' ?></div>
                        </div>
                    </div>
                </div>
                <div class="pr-row">
                    <div class="pr-lbl">Bank</div>
                    <div class="pr-val"><?= CHtml::encode(ComBank::model()->nameOfThis($dt->bank_id) ?: '—') ?></div>
                </div>
                <?php endif; ?>

                <!-- Being / Remarks -->
                <?php if (!empty($dt->remarks)): ?>
                <div class="pr-row">
                    <div class="pr-lbl">Being</div>
                    <div class="pr-val"><?= CHtml::encode($dt->remarks) ?></div>
                </div>
                <?php endif; ?>

            </div><!-- /pr-body -->
            </div><!-- /pr-body-wrap -->

            <!-- FOOTER -->
            <div class="pr-footer">
                <div class="pr-footer-cell">
                    <div class="pr-sig-space"></div>
                    <div class="pr-sig-line">Received By</div>
                </div>
                <div class="pr-footer-cell">
                    <div class="pr-sig-space"></div>
                    <div class="pr-sig-line">Checked By</div>
                </div>
                <div class="pr-footer-cell">
                    <div class="pr-sig-space"></div>
                    <div class="pr-sig-line">For <?= CHtml::encode(strtoupper(Yii::app()->params['company']['name'])) ?></div>
                </div>
            </div>

        </div><!-- /pr-doc -->
        </div><!-- /printAllTableForThisReport -->

        <?php endforeach; ?>

        <?php else: ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle" style="margin-right:6px;"></i>No result found!
        </div>
        <?php endif; ?>
    </div>
</div>
