<?php
/* ── fetch counts ── */
$cOrders = new CDbCriteria();
$cOrders->addColumnCondition(['order_type' => SellOrder::NEW_ORDER]);
$cOrders->select = "COUNT(*) as id";
$dOrders = SellOrder::model()->findByAttributes([], $cOrders);
$totalOrders = $dOrders ? (int)$dOrders->id : 0;

$cQuote = new CDbCriteria();
$cQuote->addColumnCondition(['order_type' => SellOrder::REPAIR_ORDER]);
$cQuote->select = "COUNT(*) as id";
$dQuote = SellOrder::model()->findByAttributes([], $cQuote);
$totalQuotations = $dQuote ? (int)$dQuote->id : 0;

$cSupp = new CDbCriteria(); $cSupp->select = "COUNT(*) as id";
$dSupp = Suppliers::model()->findByAttributes([], $cSupp);
$totalSuppliers = $dSupp ? (int)$dSupp->id : 0;

$cCust = new CDbCriteria(); $cCust->select = "COUNT(*) as id";
$dCust = Customers::model()->findByAttributes([], $cCust);
$totalCustomers = $dCust ? (int)$dCust->id : 0;
?>
<div class="row">

    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-indigo db-animate db-animate-d1">
            <div class="db-stat-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalOrders ?>">0</div>
                <div class="db-stat-label">Total Orders</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-green db-animate db-animate-d2">
            <div class="db-stat-icon"><i class="fa fa-file-text-o"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalQuotations ?>">0</div>
                <div class="db-stat-label">Total Quotations</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-amber db-animate db-animate-d3">
            <div class="db-stat-icon"><i class="fa fa-truck"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalSuppliers ?>">0</div>
                <div class="db-stat-label">Suppliers</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-blue db-animate db-animate-d4">
            <div class="db-stat-icon"><i class="fa fa-users"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalCustomers ?>">0</div>
                <div class="db-stat-label">Customers</div>
            </div>
        </div>
    </div>

</div>
