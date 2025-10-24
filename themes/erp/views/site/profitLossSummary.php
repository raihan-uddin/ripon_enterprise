<?php
/** @var float $totalPurchaseValue */
/** @var float $totalExpenseValue */
/** @var float $totalMoneyReceiptValue */
/** @var float $totalSalesValue */
/** @var float $totalCogsValue */
/** @var float $totalPaymentValue */
/** @var float $totalSaleDiscountValue */
/** @var float $totalReturnValue */
/** @var float $totalReturnCosting */
/** @var float $prevMonthProfit */
$returnProfit = $totalReturnValue - $totalReturnCosting;
$profit = $totalSalesValue - ($totalCogsValue + $returnProfit) - $totalSaleDiscountValue - $totalExpenseValue;
$grossProfit = $totalSalesValue - ($totalCogsValue + $returnProfit);
$profitMargin = $totalSalesValue > 0 ? ($profit / $totalSalesValue) * 100 : 0;
$netCashFlow = $totalMoneyReceiptValue - $totalPaymentValue - $totalExpenseValue;

// optional mock comparison
$prevProfit = $prevMonthProfit;
$profitChange = $prevProfit ? (($profit - $prevProfit) / $prevProfit) * 100 : 0;
$trendIcon = $profitChange > 0 ? '↑' : ($profitChange < 0 ? '↓' : '→');
$trendColor = $profitChange > 0 ? 'text-success' : ($profitChange < 0 ? 'text-danger' : 'text-muted');

$expenseRatio = $totalSalesValue > 0 ? ($totalExpenseValue / $totalSalesValue) * 100 : 0;
$returnRatio = $totalSalesValue > 0 ? ($totalReturnValue / $totalSalesValue) * 100 : 0;
$collectionEfficiency = $totalSalesValue > 0 ? ($totalMoneyReceiptValue / $totalSalesValue) * 100 : 0;
$paymentToPurchaseRatio = $totalPurchaseValue > 0 ? ($totalPaymentValue / $totalPurchaseValue) * 100 : 0;


$netCashFlow = $totalMoneyReceiptValue - $totalPaymentValue - $totalExpenseValue;

?>
<div class="row">
    <!-- Net Profit Card -->
    <div class="col-md-12">
        <div class="card card-success mb-3" title="Sales - (COGS + Return + Discount + Expense)">
            <div class="card-header">
                <h3 class="card-title">Net Profit</h3>
            </div>

            <div class="card-body text-center">
                <h4 class="mb-1 fw-bold <?= $profit >= 0 ? 'text-success' : 'text-danger'; ?>">
                    <?= number_format((float)$profit, 2); ?>
                </h4>

                <div class="small text-muted mb-1">
                    <span>Sales: <strong><?= number_format((float)$totalSalesValue, 2); ?></strong></span> |
                    <span>COGS: <strong><?= number_format((float)$totalCogsValue, 2); ?></strong></span> |
                    <span>Return: <strong><?= number_format((float)$returnProfit, 2); ?></strong></span> |
                    <span>Discount: <strong><?= number_format((float)$totalSaleDiscountValue, 2); ?></strong></span> |
                    <span>Expense: <strong><?= number_format((float)$totalExpenseValue, 2); ?></strong></span>
                </div>

                <!-- Formula with tooltips -->
                <div class="calculation small text-secondary mt-2 fst-italic">
                    (
                    <span title="Total Sales Value"><?= number_format((float)$totalSalesValue, 2); ?></span>
                    − (
                    <span title="Total Cost of Goods Sold (COGS)"><?= number_format((float)$totalCogsValue, 2); ?></span>
                    +
                    <span title="Total Return Profit"><?= number_format((float)$returnProfit, 2); ?></span>
                    )
                    − <span title="Total Sales Discount"><?= number_format((float)$totalSaleDiscountValue, 2); ?></span>
                    − <span title="Total Expense"><?= number_format((float)$totalExpenseValue, 2); ?></span>
                    )
                </div>

                <div class="mt-2">
                    <small>
                        <span class="hover-info" title="Profit Margin = (Net Profit ÷ Total Sales) × 100">
                            Profit Margin:
                        </span>
                        <strong><?= number_format($profitMargin, 2); ?>%</strong>
                    </small>
                    |
                    <small>
                        <span class="hover-info" title="Gross Profit = Total Sales − (COGS + Return Profit)">
                            Gross Profit:
                        </span>
                        <strong><?= number_format($grossProfit, 2); ?></strong>
                    </small>
                </div>

                <div class="mt-1 <?= $trendColor; ?>">
                    <?= $trendIcon; ?> <?= number_format(abs($profitChange), 2); ?>% vs last period
                </div>

                <?php
                $profitChange = (float)$profitChange;
                $isPositive = $profitChange > 0;
                $isNegative = $profitChange < 0;

                $badgeColor = $isPositive ? 'bg-success' : ($isNegative ? 'bg-danger' : 'bg-secondary');
                $arrow = $isPositive ? '↑' : ($isNegative ? '↓' : '→');

                $profitChangeTitle = "Profit Change = ((Current Profit − Previous Profit) ÷ Previous Profit) × 100";
                $profitMarginTitle = "Profit Margin = (Net Profit ÷ Total Sales) × 100";
                $netCashTitle = "Net Cash Flow = Total Collection − (Total Payment + Total Expense)";
                ?>

                <div class="mt-2 badges-info text-center">
                    <span class="badge <?= $badgeColor; ?>" title="<?= $profitChangeTitle; ?>">
                        <?= $arrow ?>
                        <?= number_format(abs($profitChange), 2); ?>%
                        <?= $isPositive ? 'Growth' : ($isNegative ? 'Decline' : 'No Change'); ?>
                    </span>

                    <span class="badge bg-info" title="<?= $profitMarginTitle; ?>">
                        Margin: <?= number_format((float)$profitMargin, 2); ?>%
                    </span>

                    <span class="badge bg-secondary" title="<?= $netCashTitle; ?>">
                        Net Cash: <?= number_format((float)$netCashFlow, 2); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title
                ">Total Sales</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center">
                    <?php
                    echo number_format((float)$totalSalesValue, 2);
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <!-- Total Return -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Total Return</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center">
                    <?php
                    echo number_format((float)$totalReturnValue, 2);
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Total Collection</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center">
                    <?php
                    echo number_format((float)$totalMoneyReceiptValue, 2);
                    ?>
                </h4>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-4">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Total Purchase</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center">
                    <?php
                    echo number_format((float)$totalPurchaseValue, 2);
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class=" card card-warning">
            <div class="card-header">
                <h3 class="card-title ">Total Payment</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center">
                    <?php
                    echo number_format((float)$totalPaymentValue, 2);
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Total Expense</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center">
                    <?php
                    echo number_format((float)$totalExpenseValue, 2);
                    ?>
                </h4>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="card card-info shadow-sm border-0">
            <div class="card-header d-flex align-items-center justify-content-between bg-gradient-info text-white">
                <h3 class="card-title mb-0"><i class="fa fa-chart-line me-2"></i>Financial KPIs</h3>
                <small class="text-white-50">Performance Ratios Overview</small>
            </div>

            <div class="card-body text-center small d-flex flex-wrap justify-content-around gap-3 py-3">
                <div class="kpi-item" title="Expense ÷ Sales × 100">
                    <i class="fa fa-shopping-cart kpi-icon text-danger"></i>
                    <div class="kpi-label">Expense Ratio</div>
                    <div class="kpi-value text-danger fw-bold"><?= number_format((float)$expenseRatio, 2); ?>%</div>
                </div>

                <div class="kpi-item" title="Return ÷ Sales × 100">
                    <i class="fa fa-undo kpi-icon text-warning"></i>
                    <div class="kpi-label">Return Ratio</div>
                    <div class="kpi-value text-warning fw-bold"><?= number_format((float)$returnRatio, 2); ?>%</div>
                </div>

                <div class="kpi-item" title="Collection ÷ Sales × 100">
                    <i class="fa fa-money kpi-icon text-success"></i>
                    <div class="kpi-label">Collection Efficiency</div>
                    <div class="kpi-value text-success fw-bold"><?= number_format((float)$collectionEfficiency, 2); ?>
                        %
                    </div>
                </div>

                <div class="kpi-item" title="Payment ÷ Purchase × 100">
                    <i class="fa fa-credit-card kpi-icon text-info"></i>
                    <div class="kpi-label">Payment Coverage</div>
                    <div class="kpi-value text-info fw-bold"><?= number_format((float)$paymentToPurchaseRatio, 2); ?>%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-light fw-semibold">
                <i class="fa fa-chart-bar text-primary me-2"></i> Period Comparison Summary
            </div>

            <div class="card-body d-flex flex-wrap justify-content-around gap-3 py-3">

                <!-- Sales Card -->
                <?php
                $salesDiff = $totalSalesValue - $prevSalesSummary['total_amount'];
                $salesUp = $salesDiff >= 0;
                ?>
                <div class="metric-box <?= $salesUp ? 'border-success' : 'border-danger'; ?>">
                    <div class="metric-icon">
                        <i class="fa fa-bar-chart <?= $salesUp ? 'text-success' : 'text-danger'; ?>"></i>
                    </div>
                    <div class="metric-title">Sales</div>
                    <div class="metric-current"><?= number_format((float)$totalSalesValue, 2); ?></div>
                    <div class="metric-prev text-muted">
                        Prev: <?= number_format((float)$prevSalesSummary['total_amount'], 2); ?></div>
                    <div class="metric-change <?= $salesUp ? 'text-success' : 'text-danger'; ?>">
                        <i class="fa <?= $salesUp ? 'fa-arrow-up' : 'fa-arrow-down'; ?>"></i>
                        <?= number_format(abs($salesDiff), 2); ?>
                    </div>
                </div>

                <!-- Expense Card -->
                <?php
                $expDiff = $totalExpenseValue - $prevExpense;
                $expUp = $expDiff <= 0; // lower = good
                ?>
                <div class="metric-box <?= $expUp ? 'border-success' : 'border-danger'; ?>">
                    <div class="metric-icon">
                        <i class="fa fa-bars <?= $expUp ? 'text-success' : 'text-danger'; ?>"></i>
                    </div>
                    <div class="metric-title">Expense</div>
                    <div class="metric-current"><?= number_format((float)$totalExpenseValue, 2); ?></div>
                    <div class="metric-prev text-muted">Prev: <?= number_format((float)$prevExpense, 2); ?></div>
                    <div class="metric-change <?= $expUp ? 'text-success' : 'text-danger'; ?>">
                        <i class="fa <?= $expUp ? 'fa-arrow-down' : 'fa-arrow-up'; ?>"></i>
                        <?= number_format(abs($expDiff), 2); ?>
                    </div>
                </div>

                <!-- Net Profit Card -->
                <?php
                $profitDiff = $profit - $prevProfit;
                $profitUp = $profitDiff >= 0;
                ?>
                <div class="metric-box <?= $profitUp ? 'border-success' : 'border-danger'; ?>">
                    <div class="metric-icon">
                        <i class="fa fa-money <?= $profitUp ? 'text-success' : 'text-danger'; ?>"></i>
                    </div>
                    <div class="metric-title">Net Profit</div>
                    <div class="metric-current"><?= number_format((float)$profit, 2); ?></div>
                    <div class="metric-prev text-muted">Prev: <?= number_format((float)$prevProfit, 2); ?></div>
                    <div class="metric-change <?= $profitUp ? 'text-success' : 'text-danger'; ?>">
                        <i class="fa <?= $profitUp ? 'fa-arrow-up' : 'fa-arrow-down'; ?>"></i>
                        <?= number_format(abs($profitDiff), 2); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="col-md-12 mt-3">
        <div class="text-muted small mt-2">
            Period: <?= date('M d, Y', strtotime($startDate)); ?> → <?= date('M d, Y', strtotime($endDate)); ?><br>
            Compared with <?= date('M d, Y', strtotime($prevStartDate)); ?>
            → <?= date('M d, Y', strtotime($prevEndDate)); ?>
        </div>
    </div>
</div>
<style>
    .card-success {
        border: 1px solid #d1e7dd;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .card-success .card-header {
        background: linear-gradient(90deg, #198754, #20c997);
        color: #fff;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-success .card-body h4 {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .card-success .text-muted span {
        margin: 0 6px;
    }


    .calculation span {
        cursor: help;
        color: #0d6efd;
        font-weight: 500;
        transition: color 0.2s ease;
        position: relative;
    }

    .calculation span:hover {
        color: #0a58ca;
        text-decoration: underline dotted;
    }

    .calculation span:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(90deg, #198754, #20c997);
        color: #fff;
        font-size: 12px;
        padding: 5px 8px;
        border-radius: 5px;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        opacity: 0;
        animation: fadeInTooltip 0.2s forwards;
    }

    /*@keyframes fadeInTooltip {*/
    /*    to {*/
    /*        opacity: 1;*/
    /*    }*/
    /*}*/

    .bg-gradient-info {
        background: linear-gradient(90deg, #0dcaf0, #0aa2c0);
    }

    .kpi-item {
        flex: 1 1 22%;
        min-width: 140px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px 14px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .kpi-item:hover {
        transform: translateY(-4px);
        background: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    }

    .kpi-icon {
        font-size: 22px;
        margin-bottom: 6px;
        transition: transform 0.3s ease;
    }

    .kpi-item:hover .kpi-icon {
        transform: scale(1.1);
    }

    .kpi-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 2px;
    }

    .kpi-value {
        font-size: 15px;
        letter-spacing: 0.3px;
    }

    .card-title i {
        margin-right: 6px;
    }

    .table th, .table td {
        vertical-align: middle;
        padding: 10px 12px;
        font-size: 14px;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }

    .card-header.bg-gradient-light {
        background: linear-gradient(90deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #dee2e6;
    }

    .fa-arrow-up {
        color: #198754; /* green */
    }

    .fa-arrow-down {
        color: #dc3545; /* red */
    }

    .metric-box {
        flex: 1 1 28%;
        min-width: 220px;
        background: #fff;
        border-radius: 10px;
        padding: 16px 14px;
        border: 2px solid transparent;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-align: center;
    }

    .metric-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .metric-icon {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .metric-title {
        font-weight: 600;
        color: #495057;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .metric-current {
        font-size: 20px;
        font-weight: 700;
        color: #212529;
    }

    .metric-prev {
        font-size: 13px;
        margin-bottom: 5px;
    }

    .metric-change {
        font-size: 14px;
        font-weight: 600;
    }

    .border-success {
        border-color: #198754 !important;
    }

    .border-danger {
        border-color: #dc3545 !important;
    }

    .bg-gradient-light {
        background: linear-gradient(90deg, #f8f9fa, #e9ecef);
    }

    .badges-info .badge {
        font-size: 13px;
        margin: 0 4px;
        padding: 8px 10px;
        border-radius: 6px;
        cursor: help;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .badges-info .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    /* Optional: Custom Tooltip style */
    .badges-info .badge[title]:hover::after {
        content: attr(title);
        position: absolute;
        z-index: 10;
        background: rgba(33, 37, 41, 0.95);
        color: #fff;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
        top: -35px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        animation: fadeInTooltip 0.2s forwards;
    }

    @keyframes fadeInTooltip {
        from {
            opacity: 0;
            transform: translate(-50%, -5px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -8px);
        }
    }

</style>