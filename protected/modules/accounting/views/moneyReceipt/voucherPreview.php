<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>

<style>
    @page {
        size: A5 landscape;
        margin: 5mm 7mm 10mm;
        @bottom-left {
            content: "<?= date('d M Y  h:i A') ?>";
            font-size: 9px;
            color: #888;
            font-family: Arial, sans-serif;
        }
        @bottom-center {
            content: "Developed by: raihan-uddin.github.io";
            font-size: 9px;
            color: #aaa;
            font-family: Arial, sans-serif;
        }
        @bottom-right {
            content: "Page " counter(page) " of " counter(pages);
            font-size: 9px;
            color: #888;
            font-family: Arial, sans-serif;
        }
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

    .mr-doc {
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
    .mr-header {
        display: table;
        width: 100%;
        table-layout: fixed;
        background: #f5f9ff;
        border-bottom: 3px solid #0077d9;
        padding: 10px 14px 10px;
        box-sizing: border-box;
    }
    .mr-header-logo,
    .mr-header-company,
    .mr-header-meta {
        display: table-cell;
        vertical-align: middle;
    }
    .mr-header-logo { width: 20%; }
    .mr-header-logo img {
        height: 80px;
        max-width: 150px;
        object-fit: contain;
    }
    .mr-header-company {
        width: 52%;
        text-align: center;
        padding: 0 8px;
    }
    .mr-header-company .co-name {
        font-size: 19px;
        font-weight: 700;
        color: #0a1a2e;
        letter-spacing: 0.5px;
        line-height: 1.2;
    }
    .mr-header-company .co-detail {
        font-size: 10px;
        color: #555;
        line-height: 1.8;
        margin-top: 3px;
    }
    .mr-header-meta {
        width: 28%;
        text-align: right;
        vertical-align: middle;
        padding-right: 4px;
    }

    /* ── Title banner ── */
    .mr-title-banner {
        background: linear-gradient(90deg, #005bb5 0%, #0077d9 60%, #2196f3 100%);
        color: #fff;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
    }

    /* ── MR number badge ── */
    .mr-no-badge {
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
    .mr-date-row {
        margin-top: 5px;
        font-size: 10px;
        color: #555;
    }
    .mr-date-row strong {
        font-size: 11px;
        color: #0a1a2e;
    }

    /* ── Body ── */
    .mr-body-wrap {
        padding: 10px 14px 0;
    }
    .mr-body {
        border: 1px solid #d0dce8;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 10px;
    }
    .mr-row {
        display: table;
        width: 100%;
        table-layout: fixed;
        border-bottom: 1px solid #e8eef4;
        min-height: 28px;
        box-sizing: border-box;
    }
    .mr-row:last-child { border-bottom: none; }

    .mr-lbl, .mr-val {
        display: table-cell;
        vertical-align: middle;
        padding: 6px 10px;
    }
    .mr-lbl {
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
    .mr-val {
        font-size: 12px;
        font-weight: 600;
        color: #0a1a2e;
    }

    /* ── Amount highlight ── */
    .mr-amount-block {
        background: #f0faf4;
        border-left: 4px solid #1a9a50;
        padding: 7px 10px;
    }
    .mr-amount-figure {
        font-size: 16px;
        font-weight: 700;
        color: #1a7a40;
        letter-spacing: 0.5px;
    }
    .mr-amount-words {
        font-size: 10px;
        font-style: italic;
        color: #4a7060;
        margin-top: 2px;
    }
    .mr-discount-tag {
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
    .mr-pay-badge {
        display: inline-block;
        background: #e8f0ff;
        border: 1px solid #9ab4e0;
        color: #1a3fa3;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 10px;
        letter-spacing: 0.5px;
    }
    .mr-pay-badge.cash  { background: #e6f9ee; border-color: #88cca0; color: #1a6a30; }
    .mr-pay-badge.check { background: #fff3e0; border-color: #f0c060; color: #8a5000; }
    .mr-pay-badge.online{ background: #f3e8ff; border-color: #c090e8; color: #6a20a8; }

    /* ── Invoice ref ── */
    .mr-inv-chip {
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
    .mr-row-2col {
        display: table;
        width: 100%;
        table-layout: fixed;
        border-bottom: 1px solid #e8eef4;
    }
    .mr-row-2col:last-child { border-bottom: none; }
    .mr-col { display: table-cell; }
    .mr-col:first-child { border-right: 1px solid #e8eef4; }

    /* ── Footer ── */
    .mr-footer {
        display: table;
        width: 100%;
        table-layout: fixed;
        padding: 0 14px;
        margin-top: 10px;
        box-sizing: border-box;
    }
    .mr-footer-cell {
        display: table-cell;
        width: 33.3%;
        text-align: center;
        vertical-align: bottom;
        padding: 0 10px;
    }
    .mr-sig-space {
        height: 36px;
    }
    .mr-sig-line {
        border-top: 1.5px solid #555;
        padding-top: 4px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #555;
    }

    /* ── Barcode wrapper ── */
    .mr-barcode { text-align: right; }
    .mr-barcode svg { display: inline-block; overflow: visible; }
</style>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file-text-o" style="margin-right:6px;"></i>Money Receipt Preview</h3>
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
            $paymentLabel = MoneyReceipt::model()->paymentTypeStringWithoutBedge($dt->payment_type);
            $isCheque     = ($paymentLabel === 'CHECK');
            $badgeClass   = strtolower($paymentLabel); // cash / check / online
            $amountInt    = (int) floor($dt->amount);
            $amountWords  = $amountInWord->convert((string) $amountInt);

            // Barcode for MR No
            $bcSvg = '';
            try {
                $bc    = new TCPDFBarcode($dt->mr_no, 'C128B');
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
                       . '<text x="'.($svgW/2).'" y="'.$textY.'" text-anchor="middle" font-size="9" font-family="monospace" fill="#000">'.htmlspecialchars($dt->mr_no).'</text>'
                       . '</svg>';
            } catch (Exception $e) {}
        ?>

        <div class="printAllTableForThisReport page-break-div" style="margin-bottom:24px;">
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

                <div class="mr-header-meta">
                    <div class="mr-no-badge"><?= CHtml::encode($dt->mr_no) ?></div>
                    <div class="mr-date-row">Date: <strong><?= date('d M Y', strtotime($dt->date)) ?></strong></div>
                    <?php if ($bcSvg): ?>
                        <div class="mr-barcode" style="margin-top:4px;"><?= $bcSvg ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TITLE BANNER -->
            <div class="mr-title-banner">&#11036; &nbsp; Money Receipt &nbsp; &#11036;</div>

            <!-- BODY -->
            <div class="mr-body-wrap">
            <div class="mr-body">

                <!-- Received from -->
                <div class="mr-row">
                    <div class="mr-lbl">Received From</div>
                    <div class="mr-val"><?= CHtml::encode(Customers::model()->nameOfThis($dt->customer_id)) ?></div>
                </div>

                <!-- Amount -->
                <div class="mr-row">
                    <div class="mr-lbl">Amount</div>
                    <div class="mr-val" style="padding:0;">
                        <div class="mr-amount-block">
                            <span class="mr-amount-figure">BDT <?= number_format($dt->amount, 2) ?> /=</span>
                            <?php if ($dt->discount > 0): ?>
                                <span class="mr-discount-tag">Disc: <?= number_format($dt->discount, 2) ?></span>
                            <?php endif; ?>
                            <?php if ($amountWords): ?>
                                <div class="mr-amount-words"><?= CHtml::encode(ucfirst($amountWords)) ?> taka only</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Payment type + Invoice ref -->
                <div class="mr-row-2col">
                    <div class="mr-col">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-lbl">Payment</div>
                            <div class="mr-val">
                                <span class="mr-pay-badge <?= $badgeClass ?>"><?= CHtml::encode($paymentLabel) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="mr-col">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-lbl">Invoice Ref</div>
                            <div class="mr-val">
                                <?php if ($dt->invoice_id): ?>
                                    <span class="mr-inv-chip">#<?= CHtml::encode($dt->invoice_id) ?></span>
                                <?php else: ?>
                                    <span style="color:#bbb;">—</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cheque details (cheque only) -->
                <?php if ($isCheque): ?>
                <div class="mr-row-2col">
                    <div class="mr-col">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-lbl">Cheque No</div>
                            <div class="mr-val"><?= CHtml::encode($dt->cheque_no ?: '—') ?></div>
                        </div>
                    </div>
                    <div class="mr-col">
                        <div class="mr-row" style="border-bottom:none;">
                            <div class="mr-lbl">Cheque Date</div>
                            <div class="mr-val"><?= $dt->cheque_date ? date('d M Y', strtotime($dt->cheque_date)) : '—' ?></div>
                        </div>
                    </div>
                </div>
                <div class="mr-row">
                    <div class="mr-lbl">Bank</div>
                    <div class="mr-val"><?= CHtml::encode(CrmBank::model()->nameOfThis($dt->bank_id) ?: '—') ?></div>
                </div>
                <?php endif; ?>

                <!-- Being / Remarks -->
                <?php if (!empty($dt->remarks)): ?>
                <div class="mr-row">
                    <div class="mr-lbl">Being</div>
                    <div class="mr-val"><?= CHtml::encode($dt->remarks) ?></div>
                </div>
                <?php endif; ?>

            </div><!-- /mr-body -->
            </div><!-- /mr-body-wrap -->

            <!-- FOOTER -->
            <div class="mr-footer">
                <div class="mr-footer-cell">
                    <div class="mr-sig-space"></div>
                    <div class="mr-sig-line">Received By</div>
                </div>
                <div class="mr-footer-cell">
                    <div class="mr-sig-space"></div>
                    <div class="mr-sig-line">Checked By</div>
                </div>
                <div class="mr-footer-cell">
                    <div class="mr-sig-space"></div>
                    <div class="mr-sig-line">For <?= CHtml::encode(strtoupper(Yii::app()->params['company']['name'])) ?></div>
                </div>
            </div>

        </div><!-- /mr-doc -->
        </div><!-- /printAllTableForThisReport -->

        <?php endforeach; ?>

        <?php else: ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle" style="margin-right:6px;"></i>No result found!
        </div>
        <?php endif; ?>
    </div>
</div>
