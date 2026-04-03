<?php
/** @var SellOrder $data */
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>

<style>

    /* override styles when printing */
    @media print {
        @page {
            size: A5;
            margin: 1mm 3mm 12mm 3mm;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            color: #000 !important;
        }

        .printAllTableForThisReport {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #000;
        }

        .page-break-div {
            page-break-after: always !important;
        }

        .card-header {
            display: none !important;
        }

        .card, .card-body {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }
    }


    @media screen {
        .printAllTableForThisReport {
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 12px;
        }
    }


    @page {
        @bottom-left {
            content: "<?= date('d M Y  h:i A') ?>";
            font-size: 10px;
            color: #555;
            font-family: Arial, sans-serif;
        }
        @bottom-center {
            content: "Developed by: raihan-uddin.github.io";
            font-size: 10px;
            color: #888;
            font-family: Arial, sans-serif;
        }
        @bottom-right {
            content: "Page " counter(page) " of " counter(pages);
            font-size: 10px;
            color: #555;
            font-family: Arial, sans-serif;
        }
    }

    .print-page-footer {
        display: none;
    }

    .print-date-stamp {
        display: none;
    }

    .item-list tbody th,
    .item-list tbody td {
        border: 1px solid black;
        font-family: fangsong;
    }


    .top-sheet-item-list tbody th,
    .top-sheet-item-list tbody td,
    .top-sheet-footer td,
    .top-sheet-footer th {
        border: 1px solid black;
        font-family: fangsong;
    }

    .page-break-div {
        page-break-after: always !important;
    }

    .pageNumber::before {
        content: "Page " counter(page);
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
    }

    /* ── Invoice info block ── */
    .invoice-info-block {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2px;
        margin-top: 2px;
    }

    .invoice-info-block td {
        vertical-align: top;
        padding: 0;
        border: none;
    }

    .invoice-bill-to {
        width: 55%;
        padding-right: 16px;
    }

    .invoice-bill-to {
        border: 1px solid #d0dae6;
        border-left: 4px solid #1a2c3d;
        border-radius: 3px;
        /*padding: 8px 12px !important;*/
    }

    .invoice-bill-to .section-label {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        color: #1a2c3d;
        display: block;
        margin-bottom: 5px;
        opacity: 0.6;
    }

    .invoice-bill-to .customer-name {
        font-size: 15px;
        font-weight: 700;
        color: #1a2c3d;
        margin-bottom: 2px;
        line-height: 1.3;
        text-align: left;
    }

    .invoice-bill-to .customer-detail {
        font-size: 12px;
        color: #555;
        line-height: 1.7;
        text-align: left;
    }

    .invoice-bill-to .customer-detail .detail-row {
        display: flex;
        align-items: baseline;
        gap: 4px;
    }

    .invoice-bill-to .customer-detail .detail-label {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        color: #888;
        min-width: 30px;
        letter-spacing: 0.5px;
    }

    .invoice-meta {
        width: 40%;
        vertical-align: top;
    }

    .invoice-meta-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #d0dae6;
        border-radius: 4px;
        overflow: hidden;
    }

    .invoice-meta-table tr td {
        /*padding: 5px 10px;*/
        font-size: 12px;
        border-bottom: 1px solid #e8ecf0;
    }

    .invoice-meta-table tr:nth-child(odd) {
        background: #f5f8fb;
    }

    .invoice-meta-table tr:nth-child(even) {
        background: #fff;
    }

    .invoice-meta-table tr td:first-child {
        color: #6c757d;
        font-weight: 600;
        white-space: nowrap;
        width: 42%;
        border-right: 1px solid #d0dae6;
    }

    .invoice-meta-table tr td:last-child {
        font-weight: 700;
        color: #1a2c3d;
        text-align: right;
    }

    .invoice-meta-table tr:last-child td {
        border-bottom: none;
    }

    /* ── PO-style header ── */
    .so-header-wrapper {
        border-bottom: 3px solid #333;
        margin-bottom: 2px;
        padding-bottom: 0px;
    }

    .so-header-inner {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .so-header-logo,
    .so-header-company,
    .so-header-barcode {
        display: table-cell;
        vertical-align: middle;
    }

    .so-header-logo {
        width: 20%;
    }

    .so-header-logo img {
        display: block;
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    .so-header-company {
        width: 60%;
        text-align: center;
        font-weight: bold;
    }

    .so-header-company .co-name {
        font-size: 22px;
        font-weight: 700;
        color: #111;
        letter-spacing: 0.5px;
    }

    .so-header-company .co-detail {
        font-size: 13px;
        color: #444;
        line-height: 1.5;
        margin-top: 0;
    }

    .so-header-barcode {
        width: 20%;
        text-align: right;
        overflow: hidden;
    }

    .so-header-barcode svg {
        display: block;
        margin-left: auto;
    }

    /* ── Title banner ── */
    .so-title-banner {
        background: #222;
        color: #fff;
        text-align: center;
        padding: 4px 0;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 6px;
        text-transform: uppercase;
        margin-bottom: 2px;
    }
</style>

<div class="card card-primary  table-responsive">
    <div class="card-header">
        <h3 class="card-title">
            <?php
            echo "<div class='printBtn' style='float: left; clear:right; width: 10%;'>";
            $this->widget('ext.mPrint.mPrint', array(
//             'title' => 'Report generated by: '.Yii::app()->user->name. ' ' . ' =====  ' .Yii::app()->name.'',
                    'title' => ' ', //the title of the document. Defaults to the HTML title
                    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
                    'text' => '', //text which will appear beside the print icon. Defaults to NULL
                    'element' => '.printAllTableForThisReport', //the element to be printed.
                    'exceptions' => array(//the element/s which will be ignored
                            '.summary',
                            '.search-form',
                            '#excludeDiv',
                    ),
                    'publishCss' => FALSE, //publish the CSS for the whole page?
                    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
                    'alt' => 'print', //text which will appear if image can't be loaded
                    'debug' => true, //enable the debugger to see what you will get
                    'id' => 'print-div'         //id of the print link
            ));
            echo "</div>";
            ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="print-page-footer"></div>
        <div class="print-date-stamp" id="print-date-stamp"></div>
        <div class="printAllTableForThisReport">
            <?php
            $logoPath = Yii::app()->theme->basePath . '/images/logo.svg';
            $logoInline = is_file($logoPath)
                    ? 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath))
                    : Yii::app()->theme->baseUrl . '/images/logo.png';
            require_once(Yii::app()->basePath . '/vendors/html2pdf/_tcpdf_5.0.002/barcodes.php');

            $dataItems = is_array($data) ? $data : iterator_to_array($data);
            $totalItems = count($dataItems);
            $itemIndex = 0;
            foreach ($dataItems as $item) {
                $itemIndex++;
                $showProfitLossSummary = isset($show_profit) ? $show_profit : false;
                $footerRowSpan = 9;
                $footerColspan = 5;
                if ($showProfitLossSummary) {
                    $footerColspan = 6;
                }
                if ($item) {
                    $customer = Customers::model()->findByPk($item->customer_id);
                    ?>
                    <div style="width: 100%;">
                        <?php
                        // Barcode for this order
                        $bcSvg = '';
                        try {
                            $bc = new TCPDFBarcode($item->so_no, 'C128B');
                            $bcArr = $bc->getBarcodeArray();
                            $barW = 1.0;
                            $barH = 36;
                            $pad = 3;
                            $textH = 14;
                            $svgW = round($bcArr['maxw'] * $barW) + $pad * 2;
                            $svgH = $barH + $pad + $textH;
                            $textY = $barH + $pad + 11;
                            $x = $pad;
                            $rects = '';
                            foreach ($bcArr['bcode'] as $bar) {
                                $bw = $bar['w'] * $barW;
                                if ($bar['t']) $rects .= '<rect x="' . $x . '" y="0" width="' . $bw . '" height="' . $barH . '" fill="#000"/>';
                                $x += $bw;
                            }
                            $bcSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $svgW . ' ' . $svgH . '" width="100%" style="display:block; max-width:' . $svgW . 'px;">'
                                    . $rects
                                    . '<text x="' . ($svgW / 2) . '" y="' . $textY . '" text-anchor="middle" font-size="10" font-family="monospace" fill="#000">' . htmlspecialchars($item->so_no) . '</text>'
                                    . '</svg>';
                        } catch (Exception $e) {
                        }
                        ?>
                        <!-- PO-style header -->
                        <div class="so-header-wrapper">
                            <div class="so-header-inner">
                                <div class="so-header-logo">
                                    <img src="<?= $logoInline ?>" alt="Logo">
                                </div>
                                <div class="so-header-company">
                                    <div class="co-name"><?= CHtml::encode(strtoupper(Yii::app()->params['company']['name'])) ?></div>
                                    <div class="co-detail"><?= CHtml::encode(Yii::app()->params['company']['address_line_1']) ?><?php if (!empty(Yii::app()->params['company']['address_line_2'])): ?> &middot; <?= CHtml::encode(Yii::app()->params['company']['address_line_2']) ?><?php endif; ?>
                                        <br>অফিস: <?= CHtml::encode(Yii::app()->params['company']['phone_1']) ?><?php if (!empty(Yii::app()->params['company']['phone_2'])): ?>
                                            <br> <?= CHtml::encode(Yii::app()->params['company']['invoice_contact_person']) ?>: <?= CHtml::encode(Yii::app()->params['company']['phone_2']) ?><?php endif; ?>
                                    </div>
                                </div>
                                <div class="so-header-barcode">
                                    <?= $bcSvg ?>
                                </div>
                            </div>
                        </div>
                        <!-- Title banner -->
                        <div class="so-title-banner">Sales Order</div>
                        <!-- customer & invoice info -->
                        <?php $customer_name = $customer ? $customer->company_name : 'N/A'; ?>
                        <table class="invoice-info-block">
                            <tr>
                                <td class="invoice-bill-to">
                                    <?php if ($customer): ?>
                                        <div class="customer-name"><?= htmlspecialchars($customer->company_name) ?></div>
                                        <div class="customer-detail">
                                            <?php if (!empty($customer->company_address)): ?>
                                                <div class="detail-row"><?= htmlspecialchars($customer->company_address) ?></div>
                                            <?php endif; ?>
                                            <?php if (!empty($customer->owner_mobile_no)): ?>
                                                <div class="detail-row"><span
                                                            style="font-weight:700;"><?= htmlspecialchars($customer->owner_mobile_no) ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($customer->trn_no)): ?>
                                                <div class="detail-row">
                                                    <span class="detail-label">TRN</span>
                                                    <span><?= htmlspecialchars($customer->trn_no) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="customer-name" style="color:#aaa;">N/A</div>
                                    <?php endif; ?>
                                </td>
                                <td class="invoice-meta">
                                    <table class="invoice-meta-table">
                                        <tr>
                                            <td>Invoice No</td>
                                            <td>#<?= htmlspecialchars($item->so_no) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td><?= date('d M Y', strtotime($item->date)) ?></td>
                                        </tr>
                                        <?php if ($showProfitLossSummary): ?>
                                            <tr>
                                                <td>P / L</td>
                                                <td><span id="profitLossText_<?= $item->id ?>"
                                                          style="font-size:15px;"></span></td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table style="width: 100%; border-collapse: collapse; font-size: 15px;" class="item-list">
                        <thead>
                        <tr>
                            <td style="text-align: center; width: 2%; border: 1px solid black;">#</td>
                            <td style="text-align: center; border: 1px solid black;">Description</td>
                            <td style="text-align: center;  width: 15%; border: 1px solid black;">Qty</td>
                            <td style="text-align: center;  width: 15%; border: 1px solid black;">Price</td>
                            <td style="text-align: center; width: 15%; border: 1px solid black;">Total</td>
                            <?php
                            if ($showProfitLossSummary) {
                                ?>
                                <td style="text-align: center; width: 10%;">N.I</td>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $vat = $item->vat_amount;
                        $vat_percentage = $item->vat_percentage;
                        $delivery_charge = $item->delivery_charge;
                        $discount_amount = $item->discount_amount;
                        $road_fee = $item->road_fee;
                        $damage = $item->damage_value;
                        $sr_commission = $item->sr_commission;
                        $criteria = new CDbCriteria();
                        $criteria->select = "pm.model_name, pm.code, pm.image, sum(t.qty) as qty, t.amount, t.discount_amount,
                                            t.note, sum(t.row_total) as row_total,  sum(costing) as costing,
                                            pm.description";
                        $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
                        $criteria->addColumnCondition(['t.sell_order_id' => $item->id]);
                        $criteria->group = "pm.id";
                        $criteria->order = "pm.item_id DESC, pm.model_name ASC";
                        $data2 = SellOrderDetails::model()->findAll($criteria);
                        $row_total = 0;
                        $totalCosting = 0;
                        if ($data2) {
                            $i = 1;
                            foreach ($data2 as $dt) {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?= $i++ ?></td>
                                    <td style="text-align: left; padding-left: 10px; border: 1px solid black; font-weight: ">
                                        <?= $dt->model_name ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?= rtrim(rtrim(number_format($dt->qty, 4, '.', ','), '0'), '.') ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 5px;">
                                        <?= rtrim(rtrim(number_format($dt->amount, 4, '.', ','), '0'), '.') ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 5px;">
                                        <?= rtrim(rtrim(number_format($dt->row_total, 4, '.', ','), '0'), '.') ?>
                                    </td>
                                    <?php
                                    if ($showProfitLossSummary) {
                                        $netIncome = $dt->row_total - ($dt->costing + $dt->discount_amount);
                                        ?>
                                        <td style="text-align: right; padding-right: 5px;">
                                            <?= rtrim(rtrim(number_format($netIncome, 4, '.', ','), '0'), '.') ?>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $row_total += $dt->row_total;
                                $totalCosting += ($dt->costing);
                            }
                            if ($totalCosting != $item->costing) {
                                $item->costing = $totalCosting;
                                $item->save();
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">
                                    <div class="alert alert-danger" role="alert">
                                        No item found
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }

                        $vatDisplay = $vat != 0 ? "" : "display: none;";
                        $deliveryChargeDisplay = $delivery_charge != 0 ? "" : "display: none;";
                        $discountDisplay = $discount_amount != 0 ? "" : "display: none;";
                        $roadFeeDisplay = $road_fee != 0 ? "" : "display: none;";
                        $damageDisplay = $damage != 0 ? "" : "display: none;";
                        $srCommissionDisplay = $sr_commission != 0 ? "" : "display: none;";

                        if ((float)$vat == 0) $footerRowSpan--;
                        if ((float)$delivery_charge == 0) $footerRowSpan--;
                        if ((float)$discount_amount == 0) $footerRowSpan--;
                        if ((float)$road_fee == 0) $footerRowSpan--;
                        if ((float)$damage == 0) $footerRowSpan--;
                        if ((float)$sr_commission == 0) $footerRowSpan--;
                        ?>
                        <tr>
                            <td rowspan="<?= $footerRowSpan ?>>" colspan="2"
                                style="border: none; background: white; text-align: left; letter-spacing: 1px; font-weight: bold;">
                                <div>In Words: <i>BDT
                                        <?php
                                        $amountInWord = new AmountInWord();
                                        $grandTotal = $item->grand_total;
                                        $inword = $amountInWord->convert(intval($grandTotal)) . ' Taka';
                                        $paisaPart = $amountInWord->convertFloat($grandTotal);
                                        if ($paisaPart) {
                                            $inword .= ' and ' . $paisaPart . ' Paisa';
                                        }
                                        $inword .= ' Only';
                                        echo $inword;
                                        ?>
                                    </i>
                                </div>
                                <br><br>
                                <div style="font-weight: normal;">
                                    Note: <?= $item->order_note ?>
                                </div>
                            </td>
                            <td colspan="2" style="border: none; background: white;">Sub Total</td>
                            <td style="text-align: right; border: none;">
                                <?= rtrim(rtrim(number_format($row_total, 4, '.', ','), '0'), '.') ?>
                            </td>
                        </tr>
                        <tr style="<?= $vatDisplay ?>">
                            <td colspan="2" style="border: none; background: white; <?= $vatDisplay ?>">Vat
                                (<?= number_format($vat_percentage, 2) ?>%) (+)
                            </td>
                            <td style="text-align: right; border: none;  <?= $vatDisplay ?>">
                                <?= rtrim(rtrim(number_format($vat, 4, '.', ','), '0'), '.') ?>
                            </td>
                        </tr>
                        <tr style="<?= $deliveryChargeDisplay ?>">
                            <td colspan="2" style="border: none; background: white;">Delivery Charge (+)</td>
                            <td style="text-align: right; border: none;">
                                <?= rtrim(rtrim(number_format($delivery_charge, 4, '.', ','), '0'), '.') ?>
                            </td>
                        </tr>
                        <tr style="<?= $discountDisplay ?>">
                            <td colspan="2" style="border: none; background: white;">Discount (-)</td>
                            <td style="text-align: right; border: none;">
                                (<?= rtrim(rtrim(number_format($discount_amount, 4, '.', ','), '0'), '.') ?>)
                            </td>
                        </tr>
                        <tr style="<?= $roadFeeDisplay ?>">
                            <td colspan="2" style="border: none; background: white;">Road Fee (-)</td>
                            <td style="text-align: right; border: none;">
                                (<?= rtrim(rtrim(number_format($road_fee, 4, '.', ','), '0'), '.') ?>)
                            </td>
                        </tr>

                        <tr style="<?= $damageDisplay ?>">
                            <td colspan="2" style="border: none; background: white;">Damage (-)</td>
                            <td style="text-align: right; border: none;">
                                (<?= rtrim(rtrim(number_format($damage, 4, '.', ','), '0'), '.') ?>)
                            </td>
                        </tr>
                        <tr style="<?= $srCommissionDisplay ?>">
                            <td colspan="2" style="border: none; background: white;">SR Commission (-)</td>
                            <td style="text-align: right; border: none;">
                                (<?= rtrim(rtrim(number_format($sr_commission, 4, '.', ','), '0'), '.') ?>)
                            </td>
                        </tr>

                        <tr style="font-weight: bold;">
                            <td colspan="2" style="border: none; background: white;">
                                <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                Net payable amount
                            </td>
                            <td style="text-align: right; border: none;">
                                <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                <?= rtrim(rtrim(number_format($item->grand_total, 4, '.', ','), '0'), '.') ?>
                            </td>
                        </tr>
                        <?php
                        $specialCustomeIdArr = [0];
                        if (!in_array($item->customer_id, $specialCustomeIdArr)) {
                            ?>

                            <tr>
                                <td colspan="2" style="border: none; background: white;">
                                    Previous Due Amount
                                </td>
                                <td style="text-align: right; border: none;">
                                    <?php
                                    $criteria = new CDbCriteria();
                                    $criteria->select = "SUM(grand_total) as grand_total";
                                    $criteria->addColumnCondition(['t.customer_id' => $item->customer_id]);
                                    $criteria->addCondition("id != '$item->id' AND date <= '$item->date'");
                                    $sellOrder = SellOrder::model()->findByAttributes([], $criteria);
                                    $prev_sell_value = $sellOrder ? $sellOrder->grand_total : 0;

                                    //                                    echo "<span style='color: red;'>S: TK" . number_format($prev_sell_value, 2) . "... </span><br>";

                                    $criteriaMr = new CDbCriteria();
                                    $criteriaMr->select = "SUM(amount+discount) as amount";
                                    $criteriaMr->addColumnCondition(['t.customer_id' => $item->customer_id]);
                                    $criteriaMr->addCondition("date < '$item->date'");
                                    $moneyReceipt = MoneyReceipt::model()->findByAttributes([], $criteriaMr);
                                    $prev_collection = $moneyReceipt ? $moneyReceipt->amount : 0;
                                    //                                    echo "<span style='color: green;'>C: TK" . number_format($prev_collection, 2) . "... </span><br>";

                                    $criteriaReturn = new CDbCriteria();
                                    $criteriaReturn->select = "SUM(return_amount) as return_amount";
                                    $criteriaReturn->addColumnCondition(['t.customer_id' => $item->customer_id]);
                                    $criteriaReturn->addCondition("return_date <= '$item->date'");
                                    $sellReturn = SellReturn::model()->findByAttributes([], $criteriaReturn);
                                    $prev_return = $sellReturn ? $sellReturn->return_amount : 0;
                                    //                                    echo "<span style='color: violet;'>R: TK" . number_format($prev_return, 2) . "... </span><br>";

                                    $criteriaMr1 = new CDbCriteria();
                                    $criteriaMr1->select = "SUM(amount) as amount, SUM(discount) as discount";
                                    $criteriaMr1->addColumnCondition(['t.customer_id' => $item->customer_id, 'date' => $item->date]);
                                    $moneyReceipt1 = MoneyReceipt::model()->findByAttributes([], $criteriaMr1);
                                    $current_collection = $moneyReceipt1 ? $moneyReceipt1->amount : 0;
                                    $current_collection = $current_collection > 0 ? $current_collection : 0;
                                    $current_collection_discount = $moneyReceipt1 ? $moneyReceipt1->discount : 0;

                                    $criteriaReturn1 = new CDbCriteria();
                                    $criteriaReturn1->select = "SUM(return_amount) as return_amount";
                                    $criteriaReturn1->addColumnCondition(['t.customer_id' => $item->customer_id, 'return_date' => $item->date]);
                                    $sellReturn1 = SellReturn::model()->findByAttributes([], $criteriaReturn1);
                                    $current_return = $sellReturn1 ? $sellReturn1->return_amount : 0;

                                    $previous_due_amount = $prev_sell_value - $prev_collection - $prev_return;

                                    $current_due_amount = $previous_due_amount + $item->grand_total - $current_collection - $current_collection_discount - $current_return;
                                    ?>
                                    <?= number_format($previous_due_amount, 2) ?>
                                </td>
                            </tr>
                            <?php
                            if ($current_collection > 0) {
                                ?>
                                <tr style="font-weight: bold;">
                                    <td colspan="2" style="border: none; background: white;"></td>
                                    <td colspan="2" style="border: none;">
                                        Current Paid Amount
                                    </td>
                                    <td style="text-align: right; border: none;">
                                        <?= rtrim(rtrim(number_format($current_collection, 4, '.', ','), '0'), '.') ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            if ($current_return > 0) {
                                ?>
                                <tr style="">
                                    <td colspan="2" style="border: none; background: white;"></td>
                                    <td colspan="2" style="border: none;">
                                        Current Return Amount
                                    </td>
                                    <td style="text-align: right; border: none;">
                                        <?= rtrim(rtrim(number_format($current_return, 4, '.', ','), '0'), '.') ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if ($current_collection_discount > 0) {
                                ?>
                                <tr>
                                    <td colspan="2" style="border: none; background: white;"></td>
                                    <td colspan="2" style="border: none;">
                                        Cash Discount
                                    </td>
                                    <td style="text-align: right; border: none;">
                                        (<?= rtrim(rtrim(number_format($current_collection_discount > 0 ? $current_collection_discount : 0, 2), '0'), '.') ?>
                                        )
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr style="font-weight: bold;">
                                <td colspan="2" style="border: none; background: white;"></td>
                                <td colspan="2" style="border: none;">
                                    <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                    Current Due Amount
                                </td>
                                <td style="text-align: right; border: none;">
                                    <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                    <?= rtrim(rtrim(number_format($current_due_amount, 4, '.', ','), '0'), '.') ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>

                    <table style="width: 100%; font-size: 12px; margin-top: 20px; border-collapse: collapse;">
                        <tr>
                            <td style="width: 50%; padding: 0 30px 0 0; text-align: center; vertical-align: bottom;">
                                <div style="height: 70px;"></div>
                                <div style="border-top: 1px solid #000; padding-top: 6px;">
                                    <div style="font-weight: bold;"><?= strtoupper(Yii::app()->params['company']['name']) ?></div>
                                    <div>Authorized Signatory</div>
                                    <div style="margin-top: 6px;">Date: <?= date('d/m/Y') ?></div>
                                </div>
                            </td>
                            <td style="width: 50%; padding: 0 0 0 30px; text-align: center; vertical-align: bottom;">
                                <div style="height: 70px;"></div>
                                <div style="border-top: 1px solid #000; padding-top: 6px;">
                                    <div style="font-weight: bold;"><?= $customer_name ?></div>
                                    <div>Customer Signature</div>
                                    <div style="margin-top: 6px;">Date: ___/___/______</div>
                                </div>
                            </td>
                        </tr>
                    </table>

                <?php if ($itemIndex < $totalItems): ?>
                    <div class="page-break-div"></div>
                <?php endif; ?>

                    <script>
                        <?php
                        if ($showProfitLossSummary){
                        ?>
                        var profitLoss = <?= $row_total - $totalCosting - $discount_amount ?>;
                        // if profit then show green color else show red color
                        if (profitLoss > 0) {
                            // use pure javascript instead of jquery
                            //$('#profitLossText_<?php //= $item->id ?>//').css('color', 'green');
                            document.getElementById('profitLossText_<?= $item->id ?>').style.color = 'green';

                        } else {
                            //$('#profitLossText_<?php //= $item->id ?>//').css('color', 'red');
                            document.getElementById('profitLossText_<?= $item->id ?>').style.color = 'red';
                        }
                        //$('#profitLossText_<?php //= $item->id ?>//').text(profitLoss.toFixed(2));

                        document.getElementById('profitLossText_<?= $item->id ?>').innerHTML = profitLoss.toFixed(2);

                        <?php
                        }
                        ?>
                    </script>
                <?php
                } else {
                ?>
                    <div class="alert alert-danger" role="alert">
                        No result found!
                    </div>
                    <?php
                }
            }
            ?>

        </div>
    </div>
</div>
