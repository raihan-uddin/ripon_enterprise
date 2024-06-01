<?php
/** @var integer $model_id */
/** @var integer $start_date */
/** @var integer $end_date */
?>

<div class='printAllTableForThisReport table-responsive'>
    <table class="table table-responsive-sm table-sm table-striped table-bordered table-hover   " id="table-1">
        <thead>
        <tr>
            <td colspan="9"
                style="font-size:16px; font-weight:bold; text-align:center; line-height: 24px; text-transform: uppercase;">
                <?php
                if ($model_id > 0) {
                    echo "Product: " . ProdModels::model()->modelName($model_id);
                }

                if ($start_date == $end_date) {
                    echo "<sub> Date: " . date('d-m-y', $start_date) . "</sub>";
                } else {
                    echo "<sub>  Date: " . date('d-m-y', $start_date) . " to " . date('d-m-y', $end_date) . "</sub>";
                }
                ?>
            </td>
        </tr>
        <tr class="titlesTr">
            <th style="width: 5%;">SL NO</th>
            <th>Date</th>
            <th>Type</th>
            <th>Invoice No</th>
            <th>Customer</th>
            <th>Product Serial NO</th>
            <th>Stock Out Qty</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        if ($model_id) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['model_id' => $model_id, 'is_deleted' => 0]);
            $criteria->addBetweenCondition('date', date('Y-m-d', $start_date), date('Y-m-d', $end_date));
            $criteria->addCondition('stock_out != 0');

            $criteria->select = "product_sl_no, stock_in, stock_out, stock_status, master_id, source_id, date";
            $criteria->order = " date ASC ";
            $data = Inventory::model()->findAll($criteria);
            $sl = 1;
            foreach ($data as $d):
                $total += $d->stock_out;

                $customerName = "";
                if ($d->stock_status == Inventory::SALES_DELIVERY) {
                    $sales = SellOrder::model()->findByPk($d->master_id);
                    if ($sales) {
                        $customerName = $sales->customer->company_name;
                    } else {
                        $customerName = "N/A" . $d->source_id;
                    }
                }
                ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= date('d-m-y', strtotime($d->date)) ?></td>
                    <td>
                        <?php
                        //                        if ($d->stock_in == 0)
                        echo Inventory::model()->getStatus($d->stock_status);
                        //                        else echo "ADJUSTMENT";
                        ?>
                    </td>
                    <td><?= $d->master_id > 0 ? $d->master_id : ''; ?></td>
                    <td><?= $customerName; ?></td>
                    <td>
                        <?php echo strlen($d->product_sl_no) > 0 ? $d->product_sl_no : '<span style="color: red;">N/A</span>' ?>
                    </td>
                    <td style="text-align: center;"><?php echo $d->stock_out; ?></td>
                </tr>
            <?php
            endforeach;
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="6">Total</th>
            <th style="text-align: center;"><?= $total ?></th>
        </tr>
        </tfoot>
    </table>
</div>