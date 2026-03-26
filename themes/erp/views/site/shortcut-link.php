<?php
$startDate = date('Y-m-01');
$endDate   = date('Y-m-t');
?>
<div class="db-actions-grid">

    <?php if (Yii::app()->user->checkAccess('ProdModels.Admin') || Yii::app()->user->checkAccess('ProdModels.Create') || Yii::app()->user->checkAccess('ProdModels.Update')): ?>
    <a class="db-action-card t-gray" href="<?= Yii::app()->createUrl('prodModels/create') ?>">
        <span class="db-action-badge"><?= ProdModels::model()->count() ?></span>
        <div class="db-action-icon"><i class="fa fa-th-large"></i></div>
        <div class="db-action-label">Products</div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Sell.Customers.Admin')): ?>
    <a class="db-action-card t-green" href="<?= Yii::app()->createUrl('sell/customers/admin') ?>">
        <span class="db-action-badge"><?= Customers::model()->count() ?></span>
        <div class="db-action-icon"><i class="fa fa-user-circle-o"></i></div>
        <div class="db-action-label">Customers</div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Sell.sellOrderQuotation.Admin')): ?>
    <a class="db-action-card t-purple" href="<?= Yii::app()->createUrl('/sell/sellOrderQuotation/create') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(grand_total)), 0) as total_amount')
                ->from('sell_order_quotation')
                ->where('date BETWEEN :s AND :e', [':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-file-text-o"></i></div>
        <div class="db-action-label">Draft<small>Ctrl+S</small></div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Sell.SellOrder.Admin')): ?>
    <a class="db-action-card t-red" href="<?= Yii::app()->createUrl('/sell/sellOrder/create') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(grand_total)), 0) as total_amount')
                ->from('sell_order')
                ->where('order_type = :type AND date BETWEEN :s AND :e',
                    [':type' => SellOrder::NEW_ORDER, ':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-shopping-cart"></i></div>
        <div class="db-action-label">Orders<small>Ctrl+S</small></div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Sell.SellReturn.CreateProductReturn')): ?>
    <a class="db-action-card t-rose" href="<?= Yii::app()->createUrl('sell/SellReturn/CreateProductReturn') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(return_amount)), 0) as return_amount')
                ->from('sell_return')
                ->where('return_date BETWEEN :s AND :e', [':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-reply"></i></div>
        <div class="db-action-label">Return</div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Commercial.PurchaseOrder.Create')): ?>
    <a class="db-action-card t-blue" href="<?= Yii::app()->createUrl('/commercial/purchaseOrder/create') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(grand_total)), 0) as total_amount')
                ->from('purchase_order')
                ->where('date BETWEEN :s AND :e', [':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-truck"></i></div>
        <div class="db-action-label">Purchase<small>Ctrl+P</small></div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Accounting.Expense.Create')): ?>
    <a class="db-action-card t-amber" href="<?= Yii::app()->createUrl('/accounting/expense/create') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(amount)), 0) as total_amount')
                ->from('expense')
                ->where('date BETWEEN :s AND :e', [':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-credit-card"></i></div>
        <div class="db-action-label">Expense</div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Loan.LoanTransactions.Admin')): ?>
    <a class="db-action-card t-rose" href="<?= Yii::app()->createUrl('/loan/loanTransactions/admin') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(amount)), 0) as amount')
                ->from('loan_transactions')
                ->where('transaction_date BETWEEN :s AND :e', [':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-university"></i></div>
        <div class="db-action-label">Loan</div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Accounting.MoneyReceipt.AdminMoneyReceipt')): ?>
    <a class="db-action-card t-indigo" href="<?= Yii::app()->createUrl('/accounting/moneyReceipt/adminMoneyReceipt') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(amount)), 0) as total_amount')
                ->from('money_receipt')
                ->where('date BETWEEN :s AND :e', [':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-sign-in"></i></div>
        <div class="db-action-label">Collection</div>
    </a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Accounting.PaymentReceipt.AdminPaymentReceipt')): ?>
    <a class="db-action-card t-teal" href="<?= Yii::app()->createUrl('/accounting/paymentReceipt/adminPaymentReceipt') ?>">
        <span class="db-action-badge"><?=
            Yii::app()->db->createCommand()
                ->select('FORMAT(ROUND(SUM(amount)), 0) as total_amount')
                ->from('payment_receipt')
                ->where('date BETWEEN :s AND :e', [':s' => $startDate, ':e' => $endDate])
                ->queryScalar();
        ?></span>
        <div class="db-action-icon"><i class="fa fa-sign-out"></i></div>
        <div class="db-action-label">Payment</div>
    </a>
    <?php endif; ?>

</div>
