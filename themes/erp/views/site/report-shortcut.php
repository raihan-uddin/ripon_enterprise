<div class="row">
    <div class="margin p-2">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                Inventory Report
            </button>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="<?= Yii::app()->createUrl("inventory/inventory/stockReport") ?>">Stock
                    Report</a>
                <a class="dropdown-item disabled" href="<?= Yii::app()->createUrl("inventory/inventory/stockReport") ?>">Slow
                    Moving Report</a>
            </div>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                Ledger Reports
            </button>
            <div class="dropdown-menu" role="menu">
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
                <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/dayInOutReport") ?>">Day In/Out
                    Report</a>
            </div>
        </div>


        <div class="btn-group">
            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                Sales/Purchase Report
            </button>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/salesReport") ?>">Sales Report</a>
                <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/saleDetailsReport") ?>">Sales Report
                    (Product Wise)</a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="<?= Yii::app()->createUrl("report/purchaseReport") ?>">Purchase
                    Report</a>
                <a class="dropdown-item disabled" href="<?= Yii::app()->createUrl("report/purchaseDetailsReport") ?>">Purchase
                    Report (Product Wise)</a>

            </div>
        </div>
    </div>
</div>