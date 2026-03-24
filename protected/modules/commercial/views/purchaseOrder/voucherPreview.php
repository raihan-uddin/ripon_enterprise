<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>

<style>
    @page {
        size: 8.27in 11.69in; /* A4 */
        margin: 8mm 10mm;
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
        .printAllTableForThisReport {
            font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #000 !important;
        }
    }

    @media screen {
        .printAllTableForThisReport {
            font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
            font-size: 12px;
        }
    }

    /* ── Header ── */
    .po-header-wrapper {
        border-bottom: 3px solid #333;
        margin-bottom: 10px;
        padding-bottom: 6px;
    }
    .po-header-inner {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .po-header-logo,
    .po-header-company,
    .po-header-barcode {
        display: table-cell;
        vertical-align: middle;
    }
    .po-header-logo { width: 22%; }
    .po-header-logo img {
        height: 110px;
        max-width: 200px;
        object-fit: contain;
    }
    .po-header-company {
        width: 54%;
        text-align: center;
        font-weight: bold;
    }
    .po-header-company .co-name {
        font-size: 22px;
        font-weight: 700;
        color: #111;
        letter-spacing: 0.5px;
    }
    .po-header-company .co-detail {
        font-size: 11px;
        color: #444;
        line-height: 1.8;
        margin-top: 4px;
    }
    .po-header-barcode {
        width: 24%;
        text-align: right;
        overflow: visible;
    }
    .po-header-barcode svg { display: block; overflow: visible; margin-left: auto; }

    /* ── Title banner ── */
    .po-title-banner {
        background: #222;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 6px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    /* ── Info block (supplier + order meta) ── */
    .po-info-block {
        display: table;
        width: 100%;
        table-layout: fixed;
        margin-bottom: 12px;
        border-collapse: collapse;
    }
    .po-bill-to, .po-meta-cell {
        display: table-cell;
        vertical-align: top;
    }
    .po-bill-to {
        width: 55%;
        background: #f5f8fb;
        border: 1px solid #d0dae6;
        border-left: 4px solid #222;
        border-radius: 3px;
        padding: 8px 12px;
    }
    .po-bill-to .section-label {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        color: #444;
        display: block;
        margin-bottom: 5px;
        opacity: 0.7;
    }
    .po-bill-to .supplier-name {
        font-size: 14px;
        font-weight: 700;
        color: #111;
        margin-bottom: 4px;
    }
    .po-bill-to .supplier-detail {
        font-size: 11px;
        color: #555;
        line-height: 1.7;
    }
    .po-meta-cell {
        width: 42%;
        padding-left: 14px;
        vertical-align: top;
    }
    .po-meta-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #d0dae6;
        border-radius: 3px;
        overflow: hidden;
    }
    .po-meta-table tr td {
        padding: 6px 10px;
        font-size: 12px;
        border-bottom: 1px solid #e8ecf0;
    }
    .po-meta-table tr:last-child td { border-bottom: none; }
    .po-meta-table tr:nth-child(odd)  { background: #f5f8fb; }
    .po-meta-table tr:nth-child(even) { background: #fff; }
    .po-meta-table tr td:first-child {
        color: #6c757d;
        font-weight: 600;
        white-space: nowrap;
        width: 44%;
        border-right: 1px solid #d0dae6;
    }
    .po-meta-table tr td:last-child {
        font-weight: 700;
        color: #111;
        text-align: right;
    }

    /* ── Item table ── */
    .po-item-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-bottom: 0;
    }
    .po-item-table thead tr th {
        background: #222;
        color: #fff;
        padding: 7px 8px;
        text-align: center;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.3px;
        border: 1px solid #444;
    }
    .po-item-table tbody tr td {
        border: 1px solid #ccc;
        padding: 6px 8px;
        vertical-align: middle;
    }
    .po-item-table tbody tr:nth-child(even) { background: #f8f8f8; }
    .po-item-table tbody tr:nth-child(odd)  { background: #fff; }

    /* ── Totals footer ── */
    .po-totals-wrap {
        display: table;
        width: 100%;
        table-layout: fixed;
        margin-top: 0;
        border-top: 2px solid #222;
    }
    .po-words-cell, .po-totals-cell {
        display: table-cell;
        vertical-align: top;
        padding-top: 8px;
    }
    .po-words-cell {
        width: 55%;
        font-size: 11px;
        padding-right: 16px;
        color: #333;
        font-style: italic;
    }
    .po-words-cell .words-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #666;
        font-style: normal;
        margin-bottom: 3px;
    }
    .po-totals-cell { width: 45%; }
    .po-totals-table {
        width: 100%;
        border-collapse: collapse;
    }
    .po-totals-table tr td {
        padding: 4px 8px;
        font-size: 12px;
        border-bottom: 1px solid #e5e5e5;
    }
    .po-totals-table tr:last-child td { border-bottom: none; }
    .po-totals-table tr td:first-child {
        color: #555;
        font-weight: 600;
    }
    .po-totals-table tr td:last-child {
        text-align: right;
        font-weight: 700;
        color: #111;
    }
    .po-grand-row td {
        background: #222 !important;
        color: #fff !important;
        font-size: 13px;
        font-weight: 700 !important;
        padding: 6px 8px !important;
    }

    /* ── Signature footer ── */
    .po-sig-footer {
        display: table;
        width: 100%;
        table-layout: fixed;
        margin-top: 40px;
        padding-top: 8px;
        border-top: 1px solid #ccc;
    }
    .po-sig-cell {
        display: table-cell;
        width: 33.3%;
        text-align: center;
        padding: 0 10px;
        vertical-align: bottom;
    }
    .po-sig-space { height: 40px; }
    .po-sig-line {
        border-top: 1.5px solid #555;
        padding-top: 4px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #444;
    }
</style>

<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Purchase Order Preview</h3>
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
        $logoInline = is_file($logoPath) ? 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath)) : Yii::app()->theme->baseUrl . '/images/logo.png';
        $supplier   = Suppliers::model()->findByPk($data->supplier_id);
        $amountInWord = new AmountInWord();

        // Barcode
        require_once(Yii::app()->basePath . '/vendors/html2pdf/_tcpdf_5.0.002/barcodes.php');
        $bcSvg = '';
        try {
            $bc    = new TCPDFBarcode($data->po_no, 'C128B');
            $bcArr = $bc->getBarcodeArray();
            $barW  = 1.5; $barH = 45; $pad = 4; $textH = 16;
            $svgW  = round($bcArr['maxw'] * $barW) + $pad * 2;
            $svgH  = $barH + $pad + $textH;
            $textY = $barH + $pad + 12;
            $x     = $pad; $rects = '';
            foreach ($bcArr['bcode'] as $bar) {
                $bw = $bar['w'] * $barW;
                if ($bar['t']) $rects .= '<rect x="'.$x.'" y="0" width="'.$bw.'" height="'.$barH.'" fill="#000"/>';
                $x += $bw;
            }
            $bcSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$svgW.'" height="'.$svgH.'" style="display:block; overflow:visible;">'
                   . $rects
                   . '<text x="'.($svgW/2).'" y="'.$textY.'" text-anchor="middle" font-size="11" font-family="monospace" fill="#000">'.htmlspecialchars($data->po_no).'</text>'
                   . '</svg>';
        } catch (Exception $e) {}
        ?>

        <div class="printAllTableForThisReport page-break-div">

            <!-- HEADER -->
            <div class="po-header-wrapper">
                <div class="po-header-inner">
                    <div class="po-header-logo">
                        <img src="<?= $logoInline ?>" alt="Logo">
                    </div>
                    <div class="po-header-company">
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
                        </div>
                    </div>
                    <div class="po-header-barcode">
                        <?= $bcSvg ?>
                    </div>
                </div>
            </div>

            <!-- TITLE BANNER -->
            <div class="po-title-banner">Purchase Order</div>

            <!-- SUPPLIER + META -->
            <div class="po-info-block">
                <div class="po-bill-to">
                    <span class="section-label">Supplier</span>
                    <?php if ($supplier): ?>
                        <div class="supplier-name"><?= CHtml::encode($supplier->company_name) ?></div>
                        <?php if (!empty($supplier->company_address)): ?>
                            <div class="supplier-detail"><?= CHtml::encode($supplier->company_address) ?></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="supplier-name" style="color:#aaa;">N/A</div>
                    <?php endif; ?>
                </div>
                <div class="po-meta-cell">
                    <table class="po-meta-table">
                        <tr>
                            <td>PO Number</td>
                            <td><?= CHtml::encode($data->po_no) ?></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td><?= date('d M Y', strtotime($data->date)) ?></td>
                        </tr>
                        <?php if ($supplier): ?>
                        <tr>
                            <td>Supplier Code</td>
                            <td><?= CHtml::encode($supplier->id) ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- ITEM TABLE -->
            <?php
            $criteria = new CDbCriteria();
            $criteria->select = "SUM(t.qty) as qty, t.unit_price, SUM(t.row_total) as row_total, pm.model_name, pm.code";
            $criteria->join = "INNER JOIN prod_models pm ON t.model_id = pm.id";
            $criteria->addColumnCondition(['t.order_id' => $data->id]);
            $criteria->group = "model_id";
            $criteria->order = "pm.model_name ASC";
            $items = PurchaseOrderDetails::model()->findAll($criteria);
            $row_total = 0;
            ?>
            <table class="po-item-table">
                <thead>
                    <tr>
                        <th style="width:4%;">#</th>
                        <th style="text-align:left;">Description</th>
                        <th style="width:10%;">Qty</th>
                        <th style="width:14%;">Unit Price</th>
                        <th style="width:14%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($items):
                    $i = 1;
                    foreach ($items as $dt):
                        $row_total += $dt->row_total;
                ?>
                    <tr>
                        <td style="text-align:center;"><?= $i++ ?></td>
                        <td style="text-align:left;"><?= CHtml::encode($dt->model_name) ?></td>
                        <td style="text-align:center;"><?= number_format($dt->qty, 2) ?></td>
                        <td style="text-align:right;"><?= number_format($dt->unit_price, 2) ?></td>
                        <td style="text-align:right;"><?= number_format($dt->row_total, 2) ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#999; padding:16px;">No items found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <!-- TOTALS -->
            <div class="po-totals-wrap">
                <div class="po-words-cell">
                    <div class="words-label">Amount in Words</div>
                    <?php
                    $inword = $amountInWord->convert(intval($row_total));
                    $inword .= $amountInWord->convertFloat($row_total) ? $amountInWord->convertFloat($row_total) . ' Only' : ' Only';
                    ?>
                    BDT: <?= $inword ?>
                </div>
                <div class="po-totals-cell">
                    <table class="po-totals-table">
                        <tr>
                            <td>Sub Total</td>
                            <td><?= number_format($row_total, 2) ?></td>
                        </tr>
                        <?php if ((float)$data->vat_amount != 0): ?>
                        <tr>
                            <td>VAT</td>
                            <td><?= number_format($data->vat_amount, 2) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="po-grand-row">
                            <td>Grand Total</td>
                            <td><?= number_format($data->grand_total, 2) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- SIGNATURE FOOTER -->
            <div class="po-sig-footer">
                <div class="po-sig-cell">
                    <div class="po-sig-space"></div>
                    <div class="po-sig-line">Prepared By</div>
                </div>
                <div class="po-sig-cell">
                    <div class="po-sig-space"></div>
                    <div class="po-sig-line">Authorised By</div>
                </div>
                <div class="po-sig-cell">
                    <div class="po-sig-space"></div>
                    <div class="po-sig-line">Received By &amp; Date</div>
                </div>
            </div>

        </div><!-- /printAllTableForThisReport -->

        <?php else: ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle" style="margin-right:6px;"></i>No result found!
        </div>
        <?php endif; ?>
    </div>
</div>
