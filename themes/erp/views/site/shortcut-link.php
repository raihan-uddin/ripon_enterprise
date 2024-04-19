<?php

// Get the start and end date of the current month
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');
?>
    <div class="row">
        <a class="btn btn-app bg-secondary"
           href="<?= Yii::app()->createUrl("prodModels/create"/*,array("id"=>$data->primaryKey)*/) ?>">
        <span class="badge bg-success">
            <?= ProdModels::model()->count() ?>
        </span>
            <i class="fa fa-barcode"></i> Products
        </a>
        <a class="btn btn-app bg-success" href="<?= Yii::app()->createUrl("crm/customers/admin") ?>">
            <span class="badge bg-purple"><?= Customers::model()->count() ?></span>
            <i class="fa fa-users"></i> Customers
        </a>
        <a class="btn btn-app bg-danger" href="<?= Yii::app()->createUrl("/sell/sellOrder/create") ?>">
        <span class="badge bg-teal"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(grand_total)), 0) as total_amount')
                ->from('sell_order')
                ->where('order_type = :type AND date BETWEEN :start_date AND :end_date',
                    array(
                        ':type' => SellOrder::NEW_ORDER,
                        ':start_date' => $startDate,
                        ':end_date' => $endDate,
                    ))
                ->queryScalar();
            /*SellOrder::model()->countByAttributes(array(
                'order_type' => SellOrder::NEW_ORDER
            )); */

            ?></span>
            <i class="fa fa-inbox"></i> Orders
        </a>
        <a class="btn btn-app bg-info" href="<?= Yii::app()->createUrl("/commercial/purchaseOrder/create") ?>">
        <span class="badge bg-teal"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(grand_total)), 0) as total_amount')
                ->from('purchase_order')
                ->where('date BETWEEN :start_date AND :end_date', array(
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ))
                ->queryScalar();
            ?></span>
            <i class="fa fa-inbox"></i> Purchase Order
        </a>
        <a class="btn btn-app bg-gradient-warning" href="<?= Yii::app()->createUrl("/accounting/expense/create") ?>">
            <span class="badge bg-teal"><?=
                Yii::app()->db->createCommand()
                    ->select('FORMAT(ROUND(SUM(amount)), 0) as total_amount')
                    ->from('expense')
                    ->where(' date BETWEEN :start_date AND :end_date',
                        array(
                            ':start_date' => $startDate,
                            ':end_date' => $endDate,
                        ))
                    ->queryScalar();
                ?></span>
            <i class="fa fa-money"></i> Expense
        </a>
        <a class="btn btn-app bg-primary"
           href="<?= Yii::app()->createUrl("/accounting/moneyReceipt/adminMoneyReceipt") ?>">
             <span class="badge bg-teal"><?=
                 Yii::app()->db->createCommand()
                     ->select('FORMAT(ROUND(SUM(amount)), 0) as total_amount')
                     ->from('money_receipt')
                     ->where(' date BETWEEN :start_date AND :end_date',
                         array(
                             ':start_date' => $startDate,
                             ':end_date' => $endDate,
                         ))
                     ->queryScalar();
                 ?></span>
            <i class="fa fa-money"></i> Collection
        </a>
        <a class="btn btn-app bg-primary"
           href="<?= Yii::app()->createUrl("/accounting/paymentReceipt/adminPaymentReceipt") ?>">
             <span class="badge bg-teal"><?=
                 Yii::app()->db->createCommand()
                     ->select('FORMAT(ROUND(SUM(amount)), 0) as total_amount')
                     ->from('payment_receipt')
                     ->where(' date BETWEEN :start_date AND :end_date',
                         array(
                             ':start_date' => $startDate,
                             ':end_date' => $endDate,
                         ))
                     ->queryScalar();
                 ?></span>
            <i class="fa fa-money"></i> Payment
        </a>
    </div>
<?php

$this->renderPartial('report-shortcut');

$this->renderPartial('summary-widget');

