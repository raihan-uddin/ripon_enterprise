<?php
/** @var Inventory $data */
/** @var string $dateFrom */
/** @var string $dateTo */
/** @var integer $model_id */
$model_name = end($data)->product_name;
$code = end($data)->product_code;
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <?= sprintf("<b>%s</b> | <small><sub>%s - %s</sub></small>",
                $model_name,
                date('d-m-y', strtotime($dateFrom)),
                date('d-m-y', strtotime($dateTo)));
            ?>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-12">
                <table class="table table-striped table-sm table-borderless table-hover" id="table-1">
                    <thead>
                    <tr class="text-uppercase">
                        <th>Date</th>
                        <th>Customer/Supplier</th>
                        <th>Warranty</th>
                        <th class="text-center">P.P</th>
                        <th class="text-center">S.P</th>
                        <th>Stock In</th>
                        <th>Stock Out</th>
                        <th>Created At</th>
                        <!--                        <th>Created By</th>-->
                        <!--                        <th>Updated At</th>-->
                        <!--                        <th>Updated By</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($data) {
                        foreach ($data as $d):
                            $warranty_month = $d->sales_warranty;
                            $warranty_expire_date = date('Y-m-d', strtotime($d->date . " + $warranty_month month"));
                            $expired_class = "";
                            if ($warranty_month > 0 && strtotime($warranty_expire_date) < strtotime(date('Y-m-d'))) {
                                $expired_class = "bg-danger";
                            }
                            ?>
                            <tr>
                                <td class="text-center"><?= date("d/m/Y", strtotime($d->date)) ?></td>
                                <?php
                                if ($d->supplier_id > 0) {
                                    ?>
                                    <td class="text-center text-uppercase supplier_ledger"
                                        data-id="<?= $d->supplier_id ?>">
                                        <?= sprintf("%s | %s | %s", $d->supplier_name, $d->supplier_contact_no, $d->supplier_id) ?>
                                    </td>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($d->customer_id > 0) {
                                    ?>
                                    <td class="text-center text-uppercase customer_ledger"
                                        data-id="<?= $d->customer_id ?>">
                                        <?= sprintf("%s | %s | %s", $d->customer_name, $d->customer_contact_no, $d->customer_id) ?>
                                    </td>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($d->supplier_id == 0 && $d->customer_id == 0) {
                                    ?>
                                    <td class="text-center">N/A</td>
                                    <?php
                                }
                                ?>
                                <td class="text-center <?= $expired_class ?> "
                                    title="<?= $d->sales_warranty > 0 ? sprintf("%d Month", $d->sales_warranty) : '' ?>">
                                    <?= $warranty_month ? date('d/m/y', strtotime($warranty_expire_date)) : '' ?>
                                </td>
                                <td class="text-right"><?= number_format($d->purchase_price, 2) ?></td>
                                <td class="text-right"><?= number_format($d->sell_price, 2) ?></td>

                                <td class="text-center"><?= $d->stock_in > 0 ? number_format($d->stock_in) : '' ?></td>
                                <td class="text-center"><?= $d->stock_out > 0 ? number_format($d->stock_out) : '' ?></td>
                                <td class="text-center"><?= date("d/m/Y h:i A", strtotime($d->create_time)) ?></td>
                                <!--                                <td class="text-center">-->
                                <?php //= $d->create_by > 0 ? Users::model()->findByPk($d->create_by)->username : ""
                                ?><!--</td>-->
                                <!--                                <td class="text-center">-->
                                <?php //= $d->update_time ? date("d/m/Y h:i A", strtotime($d->update_time)) : ""
                                ?><!--</td>-->
                                <!--                                <td class="text-center">-->
                                <?php //= $d->update_by > 0 ? Users::model()->findByPk($d->update_by)->username : ""
                                ?><!--</td>-->
                            </tr>
                        <?php
                        endforeach;
                    } else {
                        ?>
                        <tr>
                            <td colspan="9" style="text-align: center;">No data found</td>
                        </tr>
                        ?>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th class="text-center"><?= number_format(array_sum(array_column($data, 'stock_in'))) ?></th>
                        <th class="text-center"><?= number_format(array_sum(array_column($data, 'stock_out'))) ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right">Balance</th>
                        <th class="text-center"
                            colspan="2"><?= number_format(array_sum(array_column($data, 'stock_in')) - array_sum(array_column($data, 'stock_out'))) ?></th>
                        <th class="text-center"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
