<div class="db-report-wrap">

    <?php
    $stockReportPermission              = Yii::app()->createUrl("inventory/inventory/stockReport");
    $productPerformanceReportPermission = Yii::app()->createUrl("report/productPerformanceReport");
    if ($stockReportPermission || $productPerformanceReportPermission):
    ?>
    <div class="btn-group">
        <button type="button" class="db-report-btn r-blue dropdown-toggle"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cubes"></i> Inventory Report
        </button>
        <div class="dropdown-menu" role="menu">
            <?php if ($stockReportPermission): ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("inventory/inventory/stockReport") ?>">
                <i class="fa fa-archive mr-2 text-primary"></i> Stock Report
            </a>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("inventory/inventory/stockReportSupplierWise") ?>">
                <i class="fa fa-user-secret mr-2 text-success"></i> Stock Report (Supplier Wise)
            </a>
            <?php endif; ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/PriceListView") ?>">
                <i class="fa fa-tag mr-2 text-info"></i> Price List
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/fastMovingReport") ?>">
                <i class="fa fa-bolt mr-2 text-warning"></i> Fast Moving Report
            </a>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/deadStockReport") ?>">
                <i class="fa fa-ban mr-2 text-danger"></i> Non-Moving / Dead Stock
            </a>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/inventoryAgingReport") ?>">
                <i class="fa fa-calendar mr-2 text-info"></i> Inventory Aging Report
            </a>
        </div>
    </div>
    <?php endif; ?>

    <?php
    $collectionReportPermission  = Yii::app()->createUrl("report/collectionReport");
    $customerDueReportPermission = Yii::app()->createUrl("report/customerDueReport");
    $customerLedgerPermission    = Yii::app()->createUrl("report/customerLedger");
    $paymentReportPermission     = Yii::app()->createUrl("report/paymentReport");
    $supplierDueReportPermission = Yii::app()->createUrl("report/supplierDueReport");
    $supplierLedgerPermission    = Yii::app()->createUrl("report/supplierLedger");
    $dayInOutReportPermission    = Yii::app()->createUrl("report/dayInOutReport");
    if ($collectionReportPermission || $customerDueReportPermission || $customerLedgerPermission
        || $paymentReportPermission || $supplierDueReportPermission
        || $supplierLedgerPermission || $dayInOutReportPermission):
    ?>
    <div class="btn-group">
        <button type="button" class="db-report-btn r-cyan dropdown-toggle"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-book"></i> Ledger Reports
        </button>
        <div class="dropdown-menu" role="menu">
            <?php if ($collectionReportPermission): ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/collectionReport") ?>">
                <i class="fa fa-money mr-2"></i> Collection Report
            </a>
            <?php endif; ?>
            <?php if ($customerDueReportPermission): ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerDueReport") ?>">
                <i class="fa fa-exclamation-circle mr-2"></i> Customer Due Report
            </a>
            <?php endif; ?>
            <?php if ($customerLedgerPermission): ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerLedger") ?>">
                <i class="fa fa-list-alt mr-2"></i> Customer Ledger
            </a>
            <?php endif; ?>
            <?php if ($paymentReportPermission || $supplierDueReportPermission || $supplierLedgerPermission): ?>
            <div class="dropdown-divider"></div>
            <?php endif; ?>
            <?php if ($paymentReportPermission): ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/paymentReport") ?>">
                <i class="fa fa-credit-card mr-2"></i> Payment Report
            </a>
            <?php endif; ?>
            <?php if ($supplierDueReportPermission): ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierDueReport") ?>">
                <i class="fa fa-exclamation-triangle mr-2"></i> Supplier Due Report
            </a>
            <?php endif; ?>
            <?php if ($supplierLedgerPermission): ?>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierLedger") ?>">
                <i class="fa fa-book mr-2"></i> Supplier Ledger
            </a>
            <?php endif; ?>
            <?php if ($dayInOutReportPermission): ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/dayInOutReport") ?>">
                <i class="fa fa-calendar-check-o mr-2"></i> Day In/Out Report
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('Report.SalesReport')
        || Yii::app()->user->checkAccess('Report.SaleDetailsReport')
        || Yii::app()->user->checkAccess('Report.PurchaseReport')
        || Yii::app()->user->checkAccess('Report.PurchaseDetailsReport')): ?>
    <div class="btn-group">
        <button type="button" class="db-report-btn r-amber dropdown-toggle"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-shopping-cart"></i> Sales / Purchase
        </button>
        <div class="dropdown-menu" role="menu">
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/salesReport") ?>">
                <i class="fa fa-line-chart mr-2"></i> Sales Report
            </a>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/saleDetailsReport") ?>">
                <i class="fa fa-bar-chart mr-2"></i> Sales Report (Product Wise)
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/purchaseReport") ?>">
                <i class="fa fa-pie-chart mr-2"></i> Purchase Report
            </a>
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/purchaseDetailsReport") ?>">
                <i class="fa fa-area-chart mr-2"></i> Purchase Report (Product Wise)
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div class="btn-group">
        <button type="button" class="db-report-btn r-gray dropdown-toggle"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-handshake-o"></i> Loan Report
        </button>
        <div class="dropdown-menu" role="menu">
            <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/loanLedger") ?>">
                <i class="fa fa-book mr-2 text-primary"></i> Person Ledger
            </a>
        </div>
    </div>

</div>
