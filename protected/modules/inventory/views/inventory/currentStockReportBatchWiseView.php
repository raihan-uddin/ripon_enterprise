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
                style="font-size:16px; font-weight:bold; text-align:center; line-height: 24px;"><?php
                if ($model_id > 0) {
                    echo "Product: " . ProdModels::model()->modelName($model_id);
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