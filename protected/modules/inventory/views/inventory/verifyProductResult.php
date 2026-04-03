<?php
/** @var Inventory $data */
/** @var string $product_sl */
$model_name = end($data)->model_name;
$model_id = end($data)->model_id;
?>

<style>
    .vfr-card{background:#fff;border:1px solid #eef2ff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.06);overflow:hidden;margin-bottom:20px}
    .vfr-card-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #eef2ff;background:#fafbff}
    .vfr-card-header-left{display:flex;align-items:center;gap:12px}
    .vfr-sl-badge{display:inline-block;background:#f1f5f9;border-radius:6px;padding:4px 10px;font-family:monospace;font-size:14px;font-weight:700;color:#6366f1}
    .vfr-model-name{font-size:12px;color:#64748b;font-weight:500}
    .vfr-ledger-btn{display:inline-flex;align-items:center;gap:5px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;border:none;border-radius:8px;padding:6px 14px;font-size:11px;font-weight:600;cursor:pointer;transition:opacity .2s}
    .vfr-ledger-btn:hover{opacity:.88}
    .vfr-ledger-btn i{font-size:12px}
    .vfr-card-body{padding:0}
    .vfr-table-wrap{overflow-x:auto;border-radius:0 0 12px 12px}
    .vfr-table{width:100%;border-collapse:collapse;font-size:12px}
    .vfr-table thead tr{background:linear-gradient(135deg,#4f46e5,#7c3aed)}
    .vfr-table thead th{color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 12px;white-space:nowrap;border:none}
    .vfr-table tbody td{padding:9px 12px;color:#1e293b;font-size:12.5px;font-weight:500;border-bottom:1px solid #f1f5f9;vertical-align:middle}
    .vfr-table tbody tr:last-child td{border-bottom:none}
    .vfr-table tbody tr:hover{background:#f8faff}
    .vfr-table .vfr-link{color:#6366f1;cursor:pointer;font-weight:600;transition:color .15s}
    .vfr-table .vfr-link:hover{color:#4f46e5;text-decoration:underline}
    .vfr-stock-in{display:inline-block;background:#ecfdf5;color:#059669;font-weight:700;border-radius:4px;padding:2px 8px;font-size:11px}
    .vfr-stock-out{display:inline-block;background:#fef2f2;color:#ef4444;font-weight:700;border-radius:4px;padding:2px 8px;font-size:11px}
    .vfr-warranty-expired{background:#fef2f2;color:#ef4444;font-weight:600;border-radius:4px;padding:2px 6px}
    .vfr-meta{font-size:11px;color:#64748b}
</style>

<div class="vfr-card">
    <div class="vfr-card-header">
        <div class="vfr-card-header-left">
            <span class="vfr-sl-badge"><?= htmlspecialchars($product_sl) ?></span>
            <span class="vfr-model-name"><?= htmlspecialchars($model_name) ?></span>
        </div>
        <div>
            <button class="vfr-ledger-btn" type="button" id="showProductLedger" data-id="<?= $model_id ?>" title="Show Product Ledger">
                <i class="fas fa-reorder"></i> Product Ledger
            </button>
        </div>
    </div>
    <div class="vfr-card-body">
        <div class="vfr-table-wrap">
            <table class="vfr-table" id="table-1">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer/Supplier</th>
                    <th>Sale / Purchase Id</th>
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
                            $expired_class = "vfr-warranty-expired";
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
                                <td class="text-center text-uppercase vfr-link supplier_ledger"
                                    data-id="<?= $d->supplier_id ?>">
                                    <?= sprintf("%s | %s | %s", $d->supplier_name, $d->supplier_contact_no, $d->supplier_id) ?>
                                </td>
                                <?php
                            } else if ($d->customer_id > 0) {
                                ?>
                                <td class="text-center text-uppercase vfr-link customer_ledger"
                                    data-id="<?= $d->customer_id ?>">
                                    <?= sprintf("%s | %s | %s", $d->customer_name, $d->customer_contact_no, $d->customer_id) ?>
                                </td>
                                <?php
                            } else {
                                ?>
                                <td class="text-center vfr-meta" title="Stock Adjustment">N/A</td>
                                <?php
                            }
                            ?>
                            <td class="text-center">
                                <?= $d->master_id > 0 ? $d->master_id : '' ?>
                            </td>
                            <td class="text-center"><?= $d->stock_in > 0 ? '<span class="vfr-stock-in">' . number_format($d->stock_in) . '</span>' : '' ?></td>
                            <td class="text-center"><?= $d->stock_out > 0 ? '<span class="vfr-stock-out">' . number_format($d->stock_out) . '</span>' : '' ?></td>
                            <td class="text-end"><?= number_format($d->purchase_price, 2) ?></td>
                            <td class="text-end"><?= number_format($d->sell_price, 2) ?></td>
                            <td class="text-center <?= $expired_class ?>"
                                title="<?= $d->sales_warranty > 0 ? sprintf("%d Month", $d->sales_warranty) : '' ?>">
                                <?= $warranty_month ? date('d/m/y', strtotime($warranty_expire_date)) : '' ?>
                            </td>
                            <td class="text-center vfr-meta"><?= date("d/m/Y h:i A", strtotime($d->create_time)) ?></td>
                            <td class="text-center vfr-meta"><?= $d->create_by > 0 ? Users::model()->findByPk($d->create_by)->username : "" ?></td>
                            <td class="text-center vfr-meta"><?= $d->update_time ? date("d/m/Y h:i A", strtotime($d->update_time)) : "" ?></td>
                            <td class="text-center vfr-meta"><?= $d->update_by > 0 ? Users::model()->findByPk($d->update_by)->username : "" ?></td>
                        </tr>
                    <?php
                    endforeach;
                } else {
                    ?>
                    <tr>
                        <td colspan="12" style="text-align:center;padding:20px;color:#64748b;">No data found</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-bs-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ledger</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        $this.html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '<?= Yii::app()->createUrl("report/customerLedgerView") ?>',
            type: 'POST',
            data: {
                'Inventory[date_from]': '2020-01-01',
                'Inventory[date_to]': "<?= date('Y-m-d') ?>",
                'Inventory[customer_id]': customer_id
            },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal")).show();
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
        $this.html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '<?= Yii::app()->createUrl("report/supplierLedgerView") ?>',
            type: 'POST',
            data: {
                'Inventory[date_from]': '2020-01-01',
                'Inventory[date_to]': "<?= date('Y-m-d') ?>",
                'Inventory[supplier_id]': supplier_id
            },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal")).show();
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
        $this.html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("report/productStockLedgerView") ?>',
            type: 'POST',
            data: {
                'Inventory[model_id]': model_id
            },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal")).show();
                $('#information-modal .modal-body').html(response);
                $this.html('<i class="fas fa-reorder"></i> Product Ledger');
            },
            error: function () {
                $this.html('<i class="fas fa-reorder"></i> Product Ledger');
                toastr.error('Something went wrong');
            },
            complete: function () {
                anyLedgerCall = false;
            }
        });
    }
</script>
