<?php
/** @var integer $model_id */
?>
<div class='printAllTableForThisReport table-responsive'>
    <table class="final-result table table-sm table-responsive-sm table-bordered  table-striped table-hover"
           id="table-1 product_ledger"  style="font-size: 12px;">
        <thead>
        <tr>
            <td colspan="9"
                style="font-size:16px; font-weight:bold; text-align:center; line-height: 24px;">
                <?php
                if ($model_id > 0) {
                    $product = ProdModels::model()->findByPk($model_id);
                    if ($product)
                        echo sprintf("%s <sub>%s</sub>", $product->model_name, $product->code);
                }
                ?>
            </td>
        </tr>
        <tr class="titlesTr">
            <th style="width: 5%;" scope="col">SL NO</th>
            <th scope="col">Product Serial NO</th>
            <th style="width: 10%;" scope="col">Stock Qty</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        if ($model_id) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['model_id' => $model_id]);

            $criteria->select = "product_sl_no, sum(stock_in - stock_out) as stock_in ";
            $criteria->order = " product_sl_no ASC ";
            $criteria->group = " model_id, product_sl_no ";
            $criteria->having = "stock_in != 0";
            $data = Inventory::model()->findAll($criteria);
            $sl = 1;
            foreach ($data as $d):
                $total += $d->stock_in;
                ?>
                <tr>
                    <td scope="row"><?= $sl++ ?></td>
                    <td>
                        <?php echo $d->product_sl_no ?>
                    </td>
                    <td style="text-align: center;"><?php echo $d->stock_in; ?></td>
                    <td style="text-align: center;" title="Stock Adjustment">
                        <a href="#" 
                            data-model_id="<?= $model_id ?>" 
                            data-product_sl_no="<?= $d->product_sl_no ?>" 
                            data-model_name = "<?= $product->model_name ?>"
                            class="btn btn-danger btn-sm removeProductSlFromCurrentStock" >
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 7H14M10 5V9M21 7H17M3 12H7M7 10V14M21 12H10M14 19H21M17 17V21M3 19H10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php
            endforeach;
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">Total</th>
            <th style="text-align: center;"><?= $total ?></th>
            <th></th>
        </tr>
        </tfoot>
    </table>
</div>
<script>
    $(document).ready(function () {
        // Clear any previous bindings to prevent duplicate requests
        $(document).off('click', '.removeProductSlFromCurrentStock');

        // body on #product_ledger .removeProductSlFromCurrentStock click
        $(document).on('click', '.removeProductSlFromCurrentStock', function (e) {
            e.preventDefault();
            let model_id = $(this).data('model_id');
            let product_sl_no = $(this).data('product_sl_no');
            let url = '<?= Yii::app()->createUrl('inventory/inventory/removeProductSlFromCurrentStock') ?>';
            let data = {model_id: model_id, product_sl_no: product_sl_no};
            let that = $(this);
            let stock_given = 0;
            if (!product_sl_no) {
                var currentStock = prompt("Please enter current stock quantity for this product:");
                // check if numeric value is given
                if (isNaN(currentStock)) {
                    toastr.error('Invalid stock quantity provided. Please provide a numeric value.');
                    return;
                }
                if (currentStock !== null) {
                    data.physical_stock = currentStock;
                    data.modify_stock = 1;
                    stock_given = currentStock;
                } else {
                    toastr.info('Action canceled. No current stock quantity provided.');
                    return;
                }
            }

            var remarks = prompt("Please enter remarks for this action:");
            if (remarks !== null) {
                data.remarks = remarks;
            } else {
                toastr.info('Action canceled. No remarks provided.');
                return;
            }
            
            let message = `Are you sure you want to remove this serial no from current stock? Serial No: ${product_sl_no}`;
            if (!product_sl_no) {
                message = `Are you sure you want adjust the stock for this product? Product Name: ${$(this).data('model_name')}. Current Stock: ${stock_given}`;
            }

            if (confirm(message)) {
                $.post(url, data, function (response) {
                    if (response.status == 'success') {
                        if(response.remove_rows == 1)
                            that.closest('tr').remove();
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                }, 'json');
            }
        });
    });
</script>