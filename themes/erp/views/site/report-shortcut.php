<div class="row">
    <div class="margin p-2">
        <?php
        $stockReportPermission = Yii::app()->createUrl("inventory/inventory/stockReport");
        $productPerformanceReportPermission = Yii::app()->createUrl("report/productPerformanceReport");
        if (
            $stockReportPermission ||
            $productPerformanceReportPermission
        ) {
            ?>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    Inventory Report
                </button>
                <div class="dropdown-menu" role="menu">
                    <?php
                    if ($stockReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("inventory/inventory/stockReport") ?>">Stock
                            Report</a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($productPerformanceReportPermission) {
                        ?>
                        <a class="dropdown-item"
                           href="<?= Yii::app()->createUrl("report/productPerformanceReport") ?>">Product Performance
                            Report</a>
                        <?php
                    }
                    ?>
                    <a class="dropdown-item disabled"
                       href="<?= Yii::app()->createUrl("inventory/inventory/stockReport") ?>">Slow
                        Moving Report</a>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
        $collectionReportPermission = Yii::app()->createUrl("report/collectionReport");
        $customerDueReportPermission = Yii::app()->createUrl("report/customerDueReport");
        $customerLedgerPermission = Yii::app()->createUrl("report/customerLedger");
        $paymentReportPermission = Yii::app()->createUrl("report/paymentReport");
        $supplierDueReportPermission = Yii::app()->createUrl("report/supplierDueReport");
        $supplierLedgerPermission = Yii::app()->createUrl("report/supplierLedger");
        $dayInOutReportPermission = Yii::app()->createUrl("report/dayInOutReport");

        if (
            $collectionReportPermission
            || $customerDueReportPermission
            || $customerLedgerPermission
            || $paymentReportPermission
            || $supplierDueReportPermission
            || $supplierLedgerPermission
            || $dayInOutReportPermission
        ) {
            ?>
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    Ledger Reports
                </button>
                <div class="dropdown-menu" role="menu">
                    <?php
                    if ($collectionReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/collectionReport") ?>">Collection
                            Report</a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($customerDueReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerDueReport") ?>">Customer
                            Due
                            Report</a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($customerLedgerPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerLedger") ?>">Customer
                            Ledger</a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($paymentReportPermission || $supplierDueReportPermission || $supplierLedgerPermission) {
                        ?>
                        <div class="dropdown-divider"></div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($paymentReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/paymentReport") ?>">Payment
                            Report</a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($supplierDueReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierDueReport") ?>">Supplier
                            Due
                            Report</a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($supplierLedgerPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierLedger") ?>">Supplier
                            Ledger</a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($dayInOutReportPermission) {
                        ?>
                        <div class="dropdown-divider"></div>
                        <?php
                    }
                    ?>

                    <?php
                    if ($dayInOutReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/dayInOutReport") ?>">Day In/Out
                            Report</a>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <?php
        }
        ?>

        <?php
        if (
            Yii::app()->user->checkAccess('Report.SalesReport')
            || Yii::app()->user->checkAccess('Report.SaleDetailsReport')
            || Yii::app()->user->checkAccess('Report.PurchaseReport')
            || Yii::app()->user->checkAccess('Report.PurchaseDetailsReport')
        ) {
            ?>


            <div class="btn-group">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    Sales/Purchase Report
                </button>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/salesReport") ?>">Sales Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/saleDetailsReport") ?>">Sales
                        Report
                        (Product Wise)</a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/purchaseReport") ?>">Purchase
                        Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/purchaseDetailsReport") ?>">Purchase
                        Report (Product Wise)</a>

                </div>
            </div>

            <?php
        }
        ?>

    </div>
</div>