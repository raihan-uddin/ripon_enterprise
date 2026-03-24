<?php
/** @var SellOrderQuotation[] $data */
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>

<style>
    @media print {
        @page {
            size: A5;
            margin: 5mm 5mm 5mm 5mm;
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
    }

    @media screen {
        .printAllTableForThisReport {
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 12px;
        }
    }

    .item-list tbody th,
    .item-list tbody td {
        border: 1px solid black;
        font-family: fangsong;
    }

    .item-list tbody tr:nth-child(even) { background: #f5f5f5; }
    .item-list tbody tr:nth-child(odd)  { background: white; }

    .page-break-div { page-break-after: always !important; }

    /* ── DRAFT watermark ── */
    @page {
        @bottom-right {
            content: "Page " counter(page) " of " counter(pages);
            font-size: 10px;
            color: #555;
            font-family: Arial, sans-serif;
        }
    }
    .print-page-footer { display: none; }
    @media print {
        .print-date-stamp {
            display: block !important;
            position: fixed;
            bottom: 3mm;
            left: 5mm;
            font-size: 10px;
            color: #444;
            font-family: Arial, sans-serif;
        }
    }
    @media screen {
        .print-date-stamp { display: none; }
    }

    .draft-wrap { position: relative; }
    .draft-wrap > * { position: relative; z-index: 1; }

    .draft-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-35deg);
        font-size: 110px;
        font-weight: 900;
        color: rgba(0, 0, 0, 0.07);
        letter-spacing: 12px;
        pointer-events: none;
        z-index: 0;
        white-space: nowrap;
        user-select: none;
    }

    @media print {
        .draft-watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-35deg);
        }
    }

    /* ── DRAFT badge in meta table ── */
    .draft-badge {
        display: inline-block;
        background: #fff3cd;
        border: 1.5px solid #ffc107;
        color: #856404;
        font-size: 10px;
        font-weight: 700;
        padding: 1px 8px;
        border-radius: 3px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        vertical-align: middle;
        margin-left: 6px;
    }

    /* ── Invoice info block ── */
    .invoice-info-block {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
        margin-top: 4px;
    }

    .invoice-info-block td {
        vertical-align: top;
        padding: 0;
        border: none;
    }

    .invoice-bill-to {
        width: 55%;
        background: #f5f8fb;
        border: 1px solid #d0dae6;
        border-left: 4px solid #1a2c3d;
        border-radius: 3px;
        padding: 8px 12px !important;
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
        font-size: 13px;
        font-weight: 700;
        color: #1a2c3d;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .invoice-bill-to .customer-detail {
        font-size: 11px;
        color: #555;
        line-height: 1.7;
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
        padding: 5px 10px;
        font-size: 12px;
        border-bottom: 1px solid #e8ecf0;
    }

    .invoice-meta-table tr:nth-child(odd)  { background: #f5f8fb; }
    .invoice-meta-table tr:nth-child(even) { background: #fff; }

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

    .invoice-meta-table tr:last-child td { border-bottom: none; }
</style>

<div class="card card-primary table-responsive">
    <div class="card-header">
        <h3 class="card-title">
            <?php
            echo "<div class='printBtn' style='float: left; clear:right; width: 10%;'>";
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
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="print-page-footer"></div>
        <div class="print-date-stamp" id="print-date-stamp"></div>
        <div class="printAllTableForThisReport">
            <?php
            foreach ($data as $item) {
                if ($item) {
                    $customer = Customers::model()->findByPk($item->customer_id);
                    ?>
                    <div style="width: 100%;" class="draft-wrap">
                        <div class="draft-watermark">DRAFT</div>
                        <?php
                        if (isset($preview_type) && $preview_type == SellOrder::NORMAL_PAD_PRINT) {
                            $this->renderPartial('application.modules.sell.views.sellOrderQuotation.pad_header');
                        } else {
                            $this->renderPartial('application.modules.sell.views.sellOrderQuotation.without_pad_header', ['id' => $item->id, 'so_no' => $item->so_no]);
                        }
                        ?>
                        <!-- customer & invoice info -->
                        <?php $customer_name = $customer ? $customer->company_name : 'N/A'; ?>
                        <table class="invoice-info-block">
                            <tr>
                                <td class="invoice-bill-to">
                                    <div class="section-label">Bill To</div>
                                    <?php if ($customer): ?>
                                        <div class="customer-name"><?= htmlspecialchars($customer->company_name) ?></div>
                                        <div class="customer-detail">
                                            <?php if (!empty($customer->company_address)): ?>
                                                <div class="detail-row">
                                                    <span class="detail-label">Addr</span>
                                                    <span><?= htmlspecialchars($customer->company_address) ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($customer->owner_mobile_no)): ?>
                                                <div class="detail-row">
                                                    <span class="detail-label">Tel</span>
                                                    <span><?= htmlspecialchars($customer->owner_mobile_no) ?></span>
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
                                            <td>Draft No / ID</td>
                                            <td>#<?= htmlspecialchars($item->so_no) ?> &nbsp;<span style="color:#aaa;">|</span>&nbsp; #<?= $item->id ?> <span class="draft-badge">Draft</span></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td><?= date('d M Y', strtotime($item->date)) ?></td>
                                        </tr>
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
                            <td style="text-align: center; width: 15%; border: 1px solid black;">Qty</td>
                            <td style="text-align: center; width: 15%; border: 1px solid black;">Price</td>
                            <td style="text-align: center; width: 15%; border: 1px solid black;">Total</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $vat             = $item->vat_amount;
                        $vat_percentage  = $item->vat_percentage;
                        $delivery_charge = $item->delivery_charge;
                        $discount_amount = $item->discount_amount;

                        $criteria = new CDbCriteria();
                        $criteria->select = "pm.model_name, pm.code, pm.image, sum(t.qty) as qty, t.amount, t.discount_amount,
                                            t.note, sum(t.row_total) as row_total, sum(costing) as costing,
                                            companies.name as company_name, pm.description";
                        $criteria->join  = " INNER JOIN prod_models pm on t.model_id = pm.id ";
                        $criteria->join .= " INNER JOIN companies on pm.manufacturer_id = companies.id ";
                        $criteria->addColumnCondition(['t.sell_order_id' => $item->id]);
                        $criteria->group = "pm.id";
                        $criteria->order = "companies.name, pm.item_id DESC, pm.model_name ASC";
                        $data2       = SellOrderQuotationDetails::model()->findAll($criteria);
                        $row_total   = 0;
                        $lastCompany = '';

                        if ($data2) {
                            $i = 1;
                            foreach ($data2 as $dt) {
                                if (!($dt->qty > 0)) continue;
                                if ($lastCompany !== $dt->company_name) {
                                    $lastCompany = $dt->company_name;
                                    ?>
                                    <tr>
                                        <td colspan="5" style="background:#f4f6f9; font-weight:600; padding:6px 10px; text-align:left; border:1px solid #ccc;">
                                            <?= CHtml::encode($dt->company_name) ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?= $i++ ?></td>
                                    <td style="text-align: left; padding-left: 10px;"><?= $dt->model_name ?></td>
                                    <td style="text-align: center;"><?= rtrim(rtrim(number_format($dt->qty, 4, '.', ','), '0'), '.') ?></td>
                                    <td style="text-align: right; padding-right: 5px;"><?= rtrim(rtrim(number_format($dt->amount, 4, '.', ','), '0'), '.') ?></td>
                                    <td style="text-align: right; padding-right: 5px;"><?= rtrim(rtrim(number_format($dt->row_total, 4, '.', ','), '0'), '.') ?></td>
                                </tr>
                                <?php
                                $row_total += $dt->row_total;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger" role="alert">No item found</div>
                                </td>
                            </tr>
                            <?php
                        }

                        ?>
                        <tr>
                            <td rowspan="7" colspan="2"
                                style="border: none; background: white; text-align: left; letter-spacing: 1px; font-weight: bold;">
                                <div>In Words: <i>BDT
                                    <?php
                                    $amountInWord = new AmountInWord();
                                    $inword = $amountInWord->convert(intval($row_total));
                                    $inword .= $amountInWord->convertFloat($row_total) ? $amountInWord->convertFloat($row_total) . ' Taka Only' : ' Only';
                                    echo $inword;
                                    ?>
                                </i></div>
                                <br><br>
                                <div style="font-weight: normal;">Note: <?= $item->order_note ?></div>
                            </td>
                            <td colspan="2" style="border: none; background: white; text-align: right; padding-right: 8px;">Sub Total</td>
                            <td style="text-align: right; border: none; padding-right: 5px;"><?= rtrim(rtrim(number_format($row_total, 4, '.', ','), '0'), '.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; background: white; text-align: right; padding-right: 8px;">Vat (+)</td>
                            <td style="border: none;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; background: white; text-align: right; padding-right: 8px;">Delivery Charge (+)</td>
                            <td style="border: none;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; background: white; text-align: right; padding-right: 8px;">S.R Commission (-)</td>
                            <td style="border: none;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; background: white; text-align: right; padding-right: 8px;">Discount (-)</td>
                            <td style="border: none;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: none; background: white; text-align: right; padding-right: 8px;">Damage (-)</td>
                            <td style="border: none;"></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="2" style="border: none; background: white; text-align: right; padding-right: 8px;">
                                <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                Net Payable Amount
                            </td>
                            <td style="text-align: right; border: none; padding-right: 5px;">
                                <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                &nbsp;
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div style="width: 100%; float: left; clear: right; height: 150px; font-size: 12px; margin-top: 20px;">
                        <div style="height: 30px; text-align: left; width: 100%; float: left; clear: right;">
                            By signing this document, the customer agrees to the services and conditions described in this document.
                        </div>
                        <br>
                        <div style="width: 100%; float: left; clear:right;">
                            <div style="width: 50%; float: left; clear:right; margin: auto; display: flex; justify-content: center; align-items: center;">
                                <span style="text-decoration: underline; font-weight: bold;"><?= strtoupper(Yii::app()->params['company']['name']) ?></span>
                            </div>
                            <div style="width: 50%; float: left; clear:right; margin: auto; display: flex; justify-content: center; align-items: center;">
                                <span style="text-decoration: underline; font-weight: bold;"><?= $customer_name ?></span>
                            </div>
                        </div>
                        <div style="height: 50px; width: 100%; float: left; clear: right; margin-top: 40px;">
                            <div style="width: 50%; float: left; clear: right; margin: auto; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <div style="text-decoration: overline;"><?= date('F d, Y') ?></div>
                            </div>
                            <div style="width: 50%; float: left; clear:right; margin: auto; display: flex; justify-content: center; align-items: center;">
                                <div>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</div>
                            </div>
                        </div>
                    </div>

                    <div class="page-break-div"></div>

                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">No result found!</div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<script>
function setPrintDate() {
    var el = document.getElementById('print-date-stamp');
    if (!el) return;
    var now = new Date();
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var d = now.getDate();
    var m = months[now.getMonth()];
    var y = now.getFullYear();
    var h = now.getHours();
    var min = now.getMinutes() < 10 ? '0' + now.getMinutes() : now.getMinutes();
    var ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12; if (h === 0) h = 12;
    el.textContent = 'Printed: ' + d + ' ' + m + ' ' + y + '  ' + h + ':' + min + ' ' + ampm;
}
window.onbeforeprint = setPrintDate;
if (window.matchMedia) {
    window.matchMedia('print').addListener(function(m){ if(m.matches) setPrintDate(); });
}
</script>
