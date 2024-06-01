<?php
/** @var integer $model_id */
?>
<div class='printAllTableForThisReport table-responsive'>
    <table class="final-result table table-sm table-responsive-sm table-bordered  table-striped table-hover"
           id="table-1"> <!--summaryTab-->
        <thead>
        <tr>
            <td colspan="9"
                style="font-size:16px; font-weight:bold; text-align:center; line-height: 24px;"><?php
                if ($model_id > 0) {
                    $product = ProdModels::model()->findByPk($model_id);
                    if ($product)
                        echo sprintf("%s <sub>%s</sub>", $product->model_name, $product->code);
                }
                ?>
            </td>
        </tr>
        <tr class="titlesTr">
            <th style="width: 5%;">SL NO</th>
            <th>Product Serial NO</th>
            <th style="width: 10%;">Stock Qty</th>
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
                    <td><?= $sl++ ?></td>
                    <td>
                        <?php echo $d->product_sl_no ?>
                    </td>
                    <td style="text-align: center;"><?php echo $d->stock_in; ?></td>
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
        </tr>
        </tfoot>
    </table>
</div>