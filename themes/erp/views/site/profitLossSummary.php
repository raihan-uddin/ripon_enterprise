<?php
/** @var float $totalPurchaseValue */
/** @var float $totalExpenseValue */
/** @var float $totalMoneyReceiptValue */
/** @var float $totalSalesValue */
/** @var float $totalCogsValue */
/** @var float $totalPaymentValue */
?>
<div class="row">
    <div class="col-md-3">
        <div class="card card-success" title="Sales Value - COGS - Expense">
            <div class="card-header">
                <h3 class="card-title">Net Profit</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center">
                    <?php
                    $profit = $totalSalesValue - $totalCogsValue - $totalExpenseValue;
                    echo number_format((float)$profit, 2);
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
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
</div>