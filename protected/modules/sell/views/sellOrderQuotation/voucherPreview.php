<?php
/** @var SellOrderQuotation[] $data */
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme
    ->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>

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

    .print-page-footer { display: none; }
    .print-date-stamp { display: none; }

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

    .invoice-bill-to .bill-to-line {
        color: #000;
        font-size: 14px;
        line-height: 1.4;
    }

    .invoice-bill-to .customer-name {
        font-size: 16px;
        font-weight: 700;
        color: #000;
    }

    .invoice-bill-to .bill-to-sep {
        margin: 0 6px;
        color: #555;
    }

    .invoice-bill-to .customer-addr,
    .invoice-bill-to .customer-tel {
        color: #000;
        font-weight: 500;
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
            $this->widget("ext.mPrint.mPrint", [
                "title" => " ",
                "tooltip" => "Print",
                "text" => "",
                "element" => ".printAllTableForThisReport",
                "exceptions" => [".summary", ".search-form", "#excludeDiv"],
                "publishCss" => false,
                "visible" => !Yii::app()->user->isGuest,
                "alt" => "print",
                "debug" => false,
                "id" => "print-div",
            ]);
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
            <?php foreach ($data as $item) {
                if ($item) {
                    $customer = Customers::model()->findByPk(
                        $item->customer_id,
                    ); ?>
                    <div style="width: 100%;">
                        <?php if (
                            isset($preview_type) &&
                            $preview_type == SellOrder::NORMAL_PAD_PRINT
                        ) {
                            $this->renderPartial(
                                "application.modules.sell.views.sellOrderQuotation.pad_header",
                            );
                        } else {
                            $this->renderPartial(
                                "application.modules.sell.views.sellOrderQuotation.without_pad_header",
                                ["id" => $item->id, "so_no" => $item->so_no],
                            );
                        } ?>
                        <!-- customer & invoice info -->
                        <?php $customer_name = $customer
                            ? $customer->company_name
                            : "N/A"; ?>
                        <table class="invoice-info-block">
                            <tr>
                                <td class="invoice-bill-to">
                                    <?php if ($customer): ?>
                                        <div class="bill-to-line">
                                            <span class="customer-name"><?= htmlspecialchars(
                                                $customer->company_name,
                                            ) ?></span>
                                            <?php if (
                                                !empty(
                                                    $customer->company_address
                                                )
                                            ): ?>
                                                <span class="bill-to-sep">·</span>
                                                <span class="customer-addr"><?= htmlspecialchars(
                                                    $customer->company_address,
                                                ) ?></span>
                                            <?php endif; ?>
                                            <?php if (
                                                !empty(
                                                    $customer->owner_mobile_no
                                                )
                                            ): ?>
                                                <span class="bill-to-sep">·</span>
                                                <span class="customer-tel"><?= htmlspecialchars(
                                                    $customer->owner_mobile_no,
                                                ) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="customer-name" style="color:#aaa;">N/A</div>
                                    <?php endif; ?>
                                </td>
                                <td class="invoice-meta">
                                    <table class="invoice-meta-table">
                                        <tr>
                                            <td>Draft No</td>
                                            <td>D-<?= htmlspecialchars(
                                                $item->so_no,
                                            ) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td><?= date(
                                                "d M Y",
                                                strtotime($item->date),
                                            ) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <table style="width: 100%; border-collapse: collapse; font-size: 15px;" class="item-list">
                        <thead>
                        <tr>
                            <td rowspan="2" style="text-align: center; width: 2%; border: 1px solid black;">#</td>
                            <td rowspan="2" style="text-align: center; border: 1px solid black;">Description</td>
                            <td rowspan="2" style="text-align: center; width: 15%; border: 1px solid black;">Qty</td>
                            <td colspan="2" style="text-align: center; width: 18%; border: 1px solid black;">Price</td>
                            <td rowspan="2" style="text-align: center; width: 15%; border: 1px solid black;">Total</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; width: 9%; border: 1px solid black;">Ctn</td>
                            <td style="text-align: center; width: 9%; border: 1px solid black;">Pcs</td>
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
                        $criteria->select = "pm.model_name, pm.code, pm.image, sum(t.qty) as qty,
                                            sum(t.ctn_qty) as ctn_qty, sum(t.pcs_qty) as pcs_qty,
                                            pm.pcs_per_ctn as pcs_per_ctn,
                                            t.amount, t.discount_amount,
                                            t.note, sum(t.row_total) as row_total, sum(costing) as costing,
                                            companies.name as company_name, pm.description";
                        $criteria->join =
                            " INNER JOIN prod_models pm on t.model_id = pm.id ";
                        $criteria->join .=
                            " INNER JOIN companies on pm.manufacturer_id = companies.id ";
                        $criteria->addColumnCondition([
                            "t.sell_order_id" => $item->id,
                        ]);
                        $criteria->group = "pm.id";
                        $criteria->order =
                            "companies.name, pm.item_id DESC, pm.model_name ASC";
                        $data2 = SellOrderQuotationDetails::model()->findAll(
                            $criteria,
                        );
                        $row_total = 0;
                        $lastCompany = "";

                        if ($data2) {
                            $i = 1;
                            foreach ($data2 as $dt) {
                                if (!($dt->qty > 0)) {
                                    continue;
                                } ?>
                                <tr>
                                    <td style="text-align: center;"><?= $i++ ?></td>
                                    <td style="text-align: left; padding-left: 10px;"><?= $dt->model_name ?></td>
                                    <td style="text-align: center;"><?php
                                        $c = (int)$dt->ctn_qty;
                                        $p = (int)$dt->pcs_qty;
                                        if ($c === 0 && $p === 0) {
                                            echo rtrim(rtrim(number_format($dt->qty, 4, '.', ','), '0'), '.');
                                        } elseif ($c > 0 && $p > 0) {
                                            echo '<b>' . $c . '</b> ctn + <b>' . $p . '</b> pcs';
                                        } elseif ($c > 0) {
                                            echo '<b>' . $c . '</b> ctn';
                                        } else {
                                            echo '<b>' . $p . '</b> pcs';
                                        }
                                    ?></td>
                                    <?php
                                        $ppc = max(1, (int)$dt->pcs_per_ctn);
                                        $perCtn = (float)$dt->amount;
                                        $perPcs = $perCtn / $ppc;
                                        $fmt = function($n) {
                                            return rtrim(rtrim(number_format($n, 4, '.', ','), '0'), '.');
                                        };
                                    ?>
                                    <td style="text-align: right; padding-right: 5px;"><?= $fmt($perCtn) ?></td>
                                    <td style="text-align: right; padding-right: 5px;"><?= $ppc > 1 ? $fmt($perPcs) : '-' ?></td>
                                    <td style="text-align: right; padding-right: 5px;"><?= rtrim(
                                        rtrim(
                                            number_format(
                                                $dt->row_total,
                                                4,
                                                ".",
                                                ",",
                                            ),
                                            "0",
                                        ),
                                        ".",
                                    ) ?></td>
                                </tr>
                                <?php $row_total += $dt->row_total;
                            }
                        } else {
                             ?>
                            <tr>
                                <td colspan="6">
                                    <div class="alert alert-danger" role="alert">No item found</div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        $vatDisplay = $vat != 0 ? "" : "display: none;";
                        $deliveryChargeDisplay =
                            $delivery_charge != 0 ? "" : "display: none;";
                        $discountDisplay =
                            $discount_amount != 0 ? "" : "display: none;";
                        $roadFeeDisplay =
                            $road_fee != 0 ? "" : "display: none;";
                        $damageDisplay = $damage != 0 ? "" : "display: none;";
                        $srCommissionDisplay =
                            $sr_commission != 0 ? "" : "display: none;";

                        $footerRowSpan = 8;
                        if ((float) $vat == 0) {
                            $footerRowSpan--;
                        }
                        if ((float) $delivery_charge == 0) {
                            $footerRowSpan--;
                        }
                        if ((float) $discount_amount == 0) {
                            $footerRowSpan--;
                        }
                        if ((float) $road_fee == 0) {
                            $footerRowSpan--;
                        }
                        if ((float) $damage == 0) {
                            $footerRowSpan--;
                        }
                        if ((float) $sr_commission == 0) {
                            $footerRowSpan--;
                        }
                        ?>
                        <tr>
                            <td rowspan="<?= $footerRowSpan ?>" colspan="2"
                                style="border: none; background: white; text-align: left; letter-spacing: 1px; font-weight: bold;">
                                <div>In Words: <i>BDT
                                    <?php
                                    $amountInWord = new AmountInWord();
                                    $grandTotal = $item->grand_total;
                                    $inword =
                                        $amountInWord->convert(
                                            intval($grandTotal),
                                        ) . " Taka";
                                    $paisaPart = $amountInWord->convertFloat(
                                        $grandTotal,
                                    );
                                    if ($paisaPart) {
                                        $inword .=
                                            " and " . $paisaPart . " Paisa";
                                    }
                                    $inword .= " Only";
                                    echo $inword;
                                    ?>
                                </i></div>
                                <br><br>
                                <div style="font-weight: normal;">Note: <?= $item->order_note ?></div>
                            </td>
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px;">Sub Total</td>
                            <td style="text-align: right; border: none; padding-right: 5px;"><?= rtrim(
                                rtrim(
                                    number_format($row_total, 4, ".", ","),
                                    "0",
                                ),
                                ".",
                            ) ?></td>
                        </tr>
                        <tr style="<?= $vatDisplay ?>">
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px; <?= $vatDisplay ?>">Vat (<?= number_format(
    $vat_percentage,
    2,
) ?>%) (+)</td>
                            <td style="text-align: right; border: none; padding-right: 5px; <?= $vatDisplay ?>"><?= rtrim(
    rtrim(number_format($vat, 4, ".", ","), "0"),
    ".",
) ?></td>
                        </tr>
                        <tr style="<?= $deliveryChargeDisplay ?>">
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px;">Delivery Charge (+)</td>
                            <td style="text-align: right; border: none; padding-right: 5px;"><?= rtrim(
                                rtrim(
                                    number_format(
                                        $delivery_charge,
                                        4,
                                        ".",
                                        ",",
                                    ),
                                    "0",
                                ),
                                ".",
                            ) ?></td>
                        </tr>
                        <tr style="<?= $discountDisplay ?>">
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px;">Discount (-)</td>
                            <td style="text-align: right; border: none; padding-right: 5px;">(<?= rtrim(
                                rtrim(
                                    number_format(
                                        $discount_amount,
                                        4,
                                        ".",
                                        ",",
                                    ),
                                    "0",
                                ),
                                ".",
                            ) ?>)</td>
                        </tr>
                        <tr style="<?= $roadFeeDisplay ?>">
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px;">Road Fee (-)</td>
                            <td style="text-align: right; border: none; padding-right: 5px;">(<?= rtrim(
                                rtrim(
                                    number_format($road_fee, 4, ".", ","),
                                    "0",
                                ),
                                ".",
                            ) ?>)</td>
                        </tr>
                        <tr style="<?= $damageDisplay ?>">
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px;">Damage (-)</td>
                            <td style="text-align: right; border: none; padding-right: 5px;">(<?= rtrim(
                                rtrim(number_format($damage, 4, ".", ","), "0"),
                                ".",
                            ) ?>)</td>
                        </tr>
                        <tr style="<?= $srCommissionDisplay ?>">
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px;">SR Commission (-)</td>
                            <td style="text-align: right; border: none; padding-right: 5px;">(<?= rtrim(
                                rtrim(
                                    number_format($sr_commission, 4, ".", ","),
                                    "0",
                                ),
                                ".",
                            ) ?>)</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" style="border: none; background: white; text-align: right; padding-right: 8px;">
                                <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                Net Payable Amount
                            </td>
                            <td style="text-align: right; border: none; padding-right: 5px;">
                                <div style="height: 1px; width: 100%; border: 1px solid black;"></div>
                                <?= rtrim(
                                    rtrim(
                                        number_format(
                                            $item->grand_total,
                                            4,
                                            ".",
                                            ",",
                                        ),
                                        "0",
                                    ),
                                    ".",
                                ) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div style="width: 100%; font-size: 12px; margin-top: 20px;">
                        <div style="margin-bottom: 10px; font-style: italic; color: #555;">উপরের পণ্যসমূহ ও মূল্য বুঝে নিয়ে গ্রাহক স্বাক্ষর করেছেন।</div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 50%; padding: 0 30px 0 0; text-align: center; vertical-align: bottom;">
                                    <div style="height: 70px;"></div>
                                    <div style="border-top: 1px solid #000; padding-top: 6px;">
                                        <div style="font-weight: bold;"><?= strtoupper(
                                            Yii::app()->params["company"][
                                                "name"
                                            ],
                                        ) ?></div>
                                        <div>Authorized Signatory</div>
                                        <div style="margin-top: 6px;">Date: <?= date(
                                            "d/m/Y",
                                        ) ?></div>
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
                    </div>

                    <div class="page-break-div"></div>

                    <?php
                } else {
                     ?>
                    <div class="alert alert-danger" role="alert">No result found!</div>
                    <?php
                }
            } ?>
        </div>
    </div>
</div>
