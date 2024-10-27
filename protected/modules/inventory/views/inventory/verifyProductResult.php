<?php
/** @var Inventory $data */
/** @var string $product_sl */
$model_name = end($data)->model_name;
$model_id = end($data)->model_id;
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <?= sprintf("<b>%s</b> | <small><sub>%s</sub></small>", $product_sl, $model_name); ?>
            <button class="btn btn-sm btn-warning" type="button" id="showProductLedger" data-id="<?= $model_id ?>"
                    title="Show Product Ledger">
                <i class="fa fa-reorder"></i>
            </button>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-12 table-responsive">
                <table class="table table-striped table-sm table-bordered table-hover" id="table-1" style="font-size: 12px;" >
                    <thead>
                    <tr class="text-uppercase">
                        <th>Date</th>
                        <th>Customer/Supplier</th>
                        <th> Sale / Purchase Id </th>
                        <th>Stock In</th>
                        <th>Stock Out</th>
                        <th class="text-center">P.P</th>
                        <th class="text-center">S.P</th>
                        <th>Warranty</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>
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
                            $stockStatus  = $d->stock_status;
                            $masterId = $d->master_id;
                            $showSalePurchaseReturnPreview  = false;
                            $purchasePreview  = false;
                            $salesPreview = false;
                            if($stockStatus == Inventory::PURCHASE_RECEIVE && $masterId > 0){
                                $showSalePurchaseReturnPreview = true;
                                $purchasePreview = true;
                            } else if($stockStatus == Inventory::SALES_DELIVERY && $masterId > 0){
                                $showSalePurchaseReturnPreview = true;
                                $salesPreview = true;
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
                                } else if ($d->customer_id > 0) {
                                    ?>
                                    <td class="text-center text-uppercase customer_ledger"
                                        data-id="<?= $d->customer_id ?>">fff
                                        <?= sprintf("%s | %s | %s", $d->customer_name, $d->customer_contact_no, $d->customer_id) ?>
                                    </td>
                                    <?php
                                } else {
                                    ?>
                                    <td class="text-center" title="Stock Adjustment">N/A</td>
                                    <?php
                                }
                                ?>
                                <td class="text-center">
                                    <?= $d->master_id > 0 ? $d->master_id : '' ?>
                                </td>
                                <td class="text-center"><?= $d->stock_in > 0 ? number_format($d->stock_in) : '' ?></td>
                                <td class="text-center"><?= $d->stock_out > 0 ? number_format($d->stock_out) : '' ?></td>
                                <td class="text-right"><?= number_format($d->purchase_price, 2) ?></td>
                                <td class="text-right"><?= number_format($d->sell_price, 2) ?></td>
                                <td class="text-center <?= $expired_class ?> "
                                    title="<?= $d->sales_warranty > 0 ? sprintf("%d Month", $d->sales_warranty) : '' ?>">
                                    <?= $warranty_month ? date('d/m/y', strtotime($warranty_expire_date)) : '' ?>
                                </td>
                                <td class="text-center"><?= date("d/m/Y h:i A", strtotime($d->create_time)) ?></td>
                                <td class="text-center"><?= $d->create_by > 0 ? Users::model()->findByPk($d->create_by)->username : "" ?></td>
                                <td class="text-center"><?= $d->update_time ? date("d/m/Y h:i A", strtotime($d->update_time)) : "" ?></td>
                                <td class="text-center"><?= $d->update_by > 0 ? Users::model()->findByPk($d->update_by)->username : "" ?></td>
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
                </table>
            </div>
        </div>
    </div>
</div>

<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ledger</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let anyLedgerCall = false;
    $('body #table-1').off('click', '.customer_ledger').on('click', '.customer_ledger', function () {
        if (anyLedgerCall) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }
        anyLedgerCall = true;

        let currentText = $(this).text();
        let customer_id = $(this).data('id');
        let $this = $(this);
        $this.html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: '<?= Yii::app()->createUrl("report/customerLedgerView") ?>',
            type: 'POST',
            data: {
                'Inventory[date_from]': '2020-01-01',
                'Inventory[date_to]': "<?= date('Y-m-d') ?>",
                'Inventory[customer_id]': customer_id
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                $this.html(currentText);
            },
            error: function () {
                $this.html(currentText);
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });
    });


    $('body #table-1').off('click', '.supplier_ledger').on('click', '.supplier_ledger', function () {
        if (anyLedgerCall) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }
        anyLedgerCall = true;

        let currentText = $(this).text();
        let supplier_id = $(this).data('id');
        let $this = $(this);
        $this.html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: '<?= Yii::app()->createUrl("report/supplierLedgerView") ?>',
            type: 'POST',
            data: {
                'Inventory[date_from]': '2020-01-01',
                'Inventory[date_to]': "<?= date('Y-m-d') ?>",
                'Inventory[supplier_id]': supplier_id
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                $this.html(currentText);
            },
            error: function () {
                $this.html(currentText);
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });

    });

    $('body').off('click', '#showProductLedger').on('click', '#showProductLedger', showProductLedger);

    function showProductLedger() {

        if (anyLedgerCall) {
            toastr.warning('Please wait for the previous request to complete');
            return;
        }
        anyLedgerCall = true;

        let model_id = $('#showProductLedger').data('id');
        let $this = $('#showProductLedger');
        $this.html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("report/productStockLedgerView") ?>',
            type: 'POST',
            data: {
                'Inventory[model_id]': model_id
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                $this.html('<i class="fa fa-reorder"></i>');
            },
            error: function () {
                $this.html('<i class="fa fa-reorder"></i>');
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });
    }
</script>
