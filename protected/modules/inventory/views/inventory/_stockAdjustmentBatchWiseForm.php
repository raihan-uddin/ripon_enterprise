
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stock Adjustment</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f5f5f5;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    table {
        width: 100%;
        margin-bottom: 30px;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .row {
        margin-bottom: 20px;
        overflow: hidden;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .btn-container {
        text-align: right;
    }

    .btn {
        padding: 12px 24px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-transform: uppercase;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'stock-adjustment-form',
    'enableAjaxValidation' => false,
)); ?>

<div class="container">
    <table class="summaryTab final-result" id="table-1">
        <thead>
        <tr>
            <td colspan="9"
                style="font-size:16px; font-weight:bold; text-align:center; line-height: 24px;">
                <span style="text-transform: uppercase; color: red;"><u>Stock Adjustment Batch Wise</u></span>
                <br>
                <?php
                /** @var integer $model_id */
                if ($model_id > 0) {
                    echo "<i>" . ProdModels::model()->modelName($model_id) . "</i>";
                }
                ?>
            </td>
        </tr>
        <tr class="titlesTr">
            <th style="width: 5%;">SL NO</th>
            <th>Product Serial NO</th>
            <th style="width: 10%;">P.P.</th>
            <th style="width: 10%;">S.P</th>
            <th style="width: 10%;">Closing Qty</th>
            <th style="width: 10%;">Physical Stock</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        if ($model_id) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['model_id' => $model_id]);

            $criteria->select = "product_sl_no, sum(stock_in - stock_out) as stock_in, pm.purchase_price, pm.sell_price, t.purchase_price as batch_pp, t.sell_price as batch_sp";
            $criteria->join = 'INNER JOIN prod_models pm ON pm.id = t.model_id';
            $criteria->order = " product_sl_no ASC ";
            $criteria->group = " model_id, product_sl_no ";
            $criteria->having = "stock_in != 0";
            $data = Inventory::model()->findAll($criteria);
            $sl = 1;
            foreach ($data as $d):
                $total += $d->stock_in;
                $pp = $d->batch_pp > 0 ? $d->batch_pp : $d->purchase_price;
                $sp = $d->sell_price;
                ?>
                <tr title="<?= sprintf("Current P.P: %s, S.P: %s, Batch P.P: %s, S.P: %s", $d->purchase_price, $d->sell_price, $d->batch_pp, $d->batch_sp) ?>">
                    <td style="text-align: center;"><?= $sl++ ?></td>
                    <td>
                        <?php echo $d->product_sl_no ? $d->product_sl_no : "N/A" ?>
                    </td>
                    <td style="text-align: center;"><?php echo number_format($pp, 2) ?></td>
                    <td style="text-align: center;"><?php echo number_format($sp, 2); ?></td>
                    <td style="text-align: center;"><?php echo $d->stock_in; ?></td>
                    <td style="text-align: center;">
                        <input type="hidden" value="<?= $d->model_id ?>" name="model_id[]">
                        <input type="hidden" value="<?= $pp ?>" name="pp[]">
                        <input type="hidden" value="<?= $sp ?>" name="sp[]">
                        <input type="hidden" value="<?= $d->product_sl_no ?>" name="product_sl_no[]">
                        <label>
                            <input type="text" name="stock[]" style="text-align: center;">
                        </label>
                    </td>
                </tr>
            <?php
            endforeach;
        }
        ?>
        </tbody>
    </table>
    <div class="row btn-container">
        <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>