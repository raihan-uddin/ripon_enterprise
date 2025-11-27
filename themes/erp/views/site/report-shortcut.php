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
            <div class="btn-group pr-2 pb-2">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    <i class="fa fa-cubes"></i> Inventory Report
                </button>
                <div class="dropdown-menu" role="menu">
                    <?php
                    if ($stockReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("inventory/inventory/stockReport") ?>">
                            <i class="fa fa-archive mr-2 text-primary"></i> Stock Report
                        </a>
                        <a class="dropdown-item"
                           href="<?= Yii::app()->createUrl("inventory/inventory/stockReportSupplierWise") ?>">
                            <i class="fa fa-user-secret mr-2 text-success"></i> Stock Report (Supplier Wise)
                        </a>
                        <?php
                    }
                    ?>
                    <a class="dropdown-item"
                       href="<?= Yii::app()->createUrl("report/PriceListView") ?>">
                        <i class="fa fa-tag mr-2 text-info"></i> Price List
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- NEW REPORTS -->
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/fastMovingReport") ?>">
                        <i class="fa fa-bolt mr-2 text-warning"></i> Fast Moving Report
                    </a>

                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/deadStockReport") ?>">
                        <i class="fa fa-ban mr-2 text-danger"></i> Non-Moving / Dead Stock
                    </a>

<!--                    <a class="dropdown-item disabled" href="#">-->
<!--                        <i class="fa fa-balance-scale mr-2 text-dark"></i> Stock Valuation-->
<!--                    </a>-->

<!--                    <a class="dropdown-item disabled" href="#">-->
<!--                        <i class="fa fa-level-down mr-2 text-success"></i> Reorder Level Report-->
<!--                    </a>-->

<!--                    <a class="dropdown-item disabled" href="#">-->
<!--                        <i class="fa fa-archive mr-2 text-primary"></i> Overstock Report-->
<!--                    </a>-->

                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/inventoryAgingReport") ?>">
                        <i class="fa fa-calendar mr-2 text-info"></i> Inventory Aging Report
                    </a>

<!--                    <a class="dropdown-item disabled" href="#">-->
<!--                        <i class="fa fa-pencil-square-o mr-2 text-purple"></i> Stock Adjustment Report-->
<!--                    </a>-->

<!--                    <div class="dropdown-divider"></div>-->

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
            <div class="btn-group pr-2 pb-2">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="fa fa-book"></i> Ledger Reports
                </button>
                <div class="dropdown-menu" role="menu">
                    <?php
                    if ($collectionReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/collectionReport") ?>">
                            <i class="fa fa-money"></i> Collection Report
                        </a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($customerDueReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerDueReport") ?>">
                            <i class="fa fa-exclamation-circle"></i> Customer Due Report
                        </a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($customerLedgerPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerLedger") ?>">
                            <i class="fa fa-list-alt"></i> Customer Ledger
                        </a>
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
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/paymentReport") ?>">
                            <i class="fa fa-credit-card"></i> Payment Report
                        </a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($supplierDueReportPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierDueReport") ?>">
                            <i class="fa fa-exclamation-triangle"></i> Supplier Due Report
                        </a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($supplierLedgerPermission) {
                        ?>
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierLedger") ?>">
                            <i class="fa fa-book"></i>
                            Supplier Ledger
                        </a>
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
                        <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/dayInOutReport") ?>">
                            <i class="fa fa-calendar-check-o"></i>
                            Day In/Out Report
                        </a>
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


            <div class="btn-group pr-2 pb-2">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    <i class="fa fa-shopping-cart"></i>
                    Sales/Purchase Report
                </button>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/salesReport") ?>">
                        <i class="fa fa-line-chart"></i>
                        Sales Report
                    </a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/saleDetailsReport") ?>">
                        <i class="fa fa-bar-chart"></i>
                        Sales Report (Product Wise)
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/purchaseReport") ?>">
                        <i class="fa fa-pie-chart"></i>
                        Purchase Report
                    </a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/purchaseDetailsReport") ?>">
                        <i class="fa fa-area-chart"></i>
                        Purchase Report (Product Wise)
                    </a>
                </div>
            </div>

            <?php
        }
        ?>

    </div>
</div>