<div class="row">
    <div class="margin p-2">
        <div class="col-md-3">
            <div class="btn-group">
                <button type="button" class="btn btn-success">Reports</button>
                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon"
                        data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("inventory/inventory/stockReport") ?>">Stock
                        Report</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/collectionReport") ?>">Collection
                        Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerDueReport") ?>">Customer
                        Due
                        Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/customerLedger") ?>">Customer
                        Ledger</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/paymentReport") ?>">Payment
                        Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierDueReport") ?>">Supplier
                        Due
                        Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierLedger") ?>">Supplier
                        Ledger</a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/salesReport") ?>">Sales Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/saleDetailsReport") ?>">Sales Report (Product Wise)</a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierLedger") ?>">Purchase Report</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/supplierLedger") ?>">Purchase Report (Product Wise)</a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/dayInOutReport") ?>">Day In/Out
                        Report</a>

                    <!--                <a class="dropdown-item" href="#">Another action</a>-->
                    <!--                <a class="dropdown-item" href="#">Something else here</a>-->
                    <!--                <div class="dropdown-divider"></div>-->
                    <!--                <a class="dropdown-item" href="#">Separated link</a>-->
                </div>
            </div>
        </div>
    </div>
</div>