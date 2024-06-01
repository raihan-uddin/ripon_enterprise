<?php
/** @var integer $model_id */
/** @var integer $start_date */
/** @var integer $end_date */
?>

<style>
    table.summaryTab {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        font-size: 12px;
        border: none;
        border-collapse: collapse;
    }

    table.summaryTab tr {
        border: 1px dotted #a6a6a6;
    }

    table.summaryTab tr td,
    table.summaryTab tr th {
        padding: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }

    table.summaryTab tr th {
        background-color: #c0c0c0;
        font-weight: bold;
        border: 1px solid #a6a6a6;
        text-align: center;
    }

    }

    .final-result tbody tr:hover {
        background: #dedede;
        transition: background-color 100ms;
    }

    table tr {
        transition: background-color 0.3s; /* Add transition for smooth effect */
    }

    table tr:hover {
        background-color: #f0f0f0;
    }
</style>


<?php

//echo "<div class='printBtn' style='width: unset;'>";
//$this->widget('ext.mPrint.mPrint', array(
//    'title' => ' ', //the title of the document. Defaults to the HTML title
//    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
//    'text' => '', //text which will appear beside the print icon. Defaults to NULL
//    'element' => '.printAllTableForThisReport', //the element to be printed.
//    'exceptions' => array(//the element/s which will be ignored
//
//    ),
//    'publishCss' => TRUE, //publish the CSS for the whole page?
//    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
//    'alt' => 'print', //text which will appear if image can't be loaded
//    'debug' => FALSE, //enable the debugger to see what you will get
//    'id' => 'print-div2'         //id of the print link
//));
//echo "</div>";
?>
<div class='printAllTableForThisReport table-responsive'>
    <table class="summaryTab final-result" id="table-1">
        <thead>
        <tr>
            <td colspan="9"
                style="font-size:16px; font-weight:bold; text-align:center; line-height: 24px;">
                <?php
                if ($model_id > 0) {
                    echo "Product: " . ProdModels::model()->modelName($model_id);
                }

                if ($start_date == $end_date) {
                    echo "<br> Date: " . date('d-m-y', $start_date);
                } else {
                    echo "<br>  Date: " . date('d-m-y', $start_date) . " to " . date('d-m-y', $end_date);
                }
                ?>
            </td>
        </tr>
        <tr class="titlesTr">
            <th style="width: 5%;">SL NO</th>
            <th>Date</th>
            <th>Type</th>
            <th>Invoice No</th>
            <th>Supplier</th>
            <th>Product Serial NO</th>
            <th>Stock In Qty</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        if ($model_id) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['model_id' => $model_id]);
            $criteria->addBetweenCondition('date', date('Y-m-d', $start_date), date('Y-m-d', $end_date));
            $criteria->addCondition('stock_in != 0');

            $criteria->select = "product_sl_no, stock_in, stock_out, stock_status, master_id, source_id, date";
            $criteria->order = " date ASC ";
            $data = Inventory::model()->findAll($criteria);
            $sl = 1;
            foreach ($data as $d):
                $total += $d->stock_in;

                $customerName = "";
                if ($d->stock_status == Inventory::PURCHASE_RECEIVE) {
                    $sales = PurchaseOrder::model()->findByPk($d->master_id);
                    if ($sales) {
                        $customerName = $sales->supplier->company_name;
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
//                        if ($d->stock_in == Inventory::PURCHASE_RECEIVE)
                            echo Inventory::model()->getStatus($d->stock_status);
//                        else echo "ADJUSTMENT";
                        ?>
                    </td>
                    <td><?= $d->master_id > 0 ? $d->master_id : ''; ?></td>
                    <td><?= $customerName; ?></td>
                    <td>
                        <?php echo strlen($d->product_sl_no) > 0 ? $d->product_sl_no : '<span style="color: red;">N/A</span>' ?>
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
            <th colspan="6">Total</th>
            <th style="text-align: center;"><?= $total ?></th>
        </tr>
        </tfoot>
    </table>
</div>