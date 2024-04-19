<?php
$this->widget('application.extensions.mbmenu.MbMenu', array(

    'items' => array(
        array('label' => 'DASHBOARD', 'url' => array('/site/index')),
        array('label' => 'COMMON',
            'items' => array(
                array('label' => 'USER',
                    'items' => array(
                        ['label' => Yii::t('app', 'MANAGE USERS'), 'url' => ['/users/admin'], 'visible' => Yii::app()->user->checkAccess('Users.Admin')],
                        ['label' => Yii::t('app', 'MANAGE PERMISSION'), 'url' => ['/rights'], 'visible' => Yii::app()->user->checkAccess('rights')],
                    ),
                ),
                array('label' => 'EXPENSE',
                    'items' => array(
                        ['label' => Yii::t('app', 'ENTRY'), 'url' => ['/accounting/expense/create'], 'visible' => Yii::app()->user->checkAccess('Accounting.Expense.Create')],
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/accounting/expense/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.Expense.Admin')],
                        ['label' => Yii::t('app', 'EXPENSE HEAD'), 'url' => ['/accounting/expenseHead/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.ExpenseHead.Admin')],

                    ),
                ),
            ),
        ),

        array('label' => 'INVENTORY',
            'items' => array(
                array('label' => 'CONFIG',
                    'items' => array(
                        ['label' => Yii::t('app', 'CATEGORY'), 'url' => ['/prodItems/admin'], 'visible' => Yii::app()->user->checkAccess('ProdItems.Admin')],
                        ['label' => Yii::t('app', 'SUB-CATEGORY'), 'url' => ['/prodBrands/admin'], 'visible' => Yii::app()->user->checkAccess('ProdBrands.Admin')],
                        array('label' => 'PRODUCT SETUP',
                            'items' => array(
                                ['label' => Yii::t('app', 'CREATE'), 'url' => ['/prodModels/create'], 'visible' => Yii::app()->user->checkAccess('ProdModels.Create')],
                                ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/prodModels/admin'], 'visible' => Yii::app()->user->checkAccess('ProdModels.Admin')],
                            ),
                        ),

                        ['label' => Yii::t('app', 'UNIT'), 'url' => ['/units/admin'], 'visible' => Yii::app()->user->checkAccess('Units.Admin')],
                        ['label' => Yii::t('app', 'COMPANY'), 'url' => ['/companies/admin'], 'visible' => Yii::app()->user->checkAccess('Companies.Admin')],
//                        ['label' => Yii::t('app', 'COUNTRY'), 'url' => ['/countries/admin'], 'visible' => Yii::app()->user->checkAccess('Countries.Admin')],
//                        ['label' => Yii::t('app', 'SHIP BY'), 'url' => ['/shipBy/admin'], 'visible' => Yii::app()->user->checkAccess('ShipBy.Admin')],
//                        ['label' => Yii::t('app', 'COMPANY'), 'url' => ['/yourCompany/admin'], 'visible' => Yii::app()->user->checkAccess('YourCompany.Admin')],
//                        ['label' => Yii::t('app', 'DB BACKUP'), 'url' => ['/users/dbBackup'], 'visible' => Yii::app()->user->checkAccess('Users.DbBackup')],

                    ),
                ),

                array('label' => 'STOCK',
                    'items' => array(
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/inventory/inventory/admin'], 'visible' => Yii::app()->user->checkAccess('Inventory.Inventory.Admin')],
                    ),
                ),
            ),
        ),

        array('label' => 'SALES',
            'items' => array(
                array('label' => 'CONFIG',
                    'items' => array(
                        ['label' => Yii::t('app', 'CUSTOMER'), 'url' => ['/crm/customers/admin'], 'visible' => Yii::app()->user->checkAccess('Crm.Customers.Admin')],
                        ['label' => Yii::t('app', 'BANK'), 'url' => ['/crm/crmBank/admin'], 'visible' => Yii::app()->user->checkAccess('Crm.CrmBank.Admin')],
                    ),
                ),
                array('label' => 'ORDER',
                    'items' => array(
                        ['label' => Yii::t('app', 'CREATE'), 'url' => ['/sell/sellOrder/create'], 'visible' => Yii::app()->user->checkAccess('Sell.SellOrder.Create')],
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/sell/sellOrder/admin'], 'visible' => Yii::app()->user->checkAccess('Sell.SellOrder.Admin')],

                    ),
                ),
                array('label' => 'COLLECTION',
                    'items' => array(
                        ['label' => Yii::t('app', 'MR CREATE'), 'url' => ['/accounting/moneyReceipt/adminMoneyReceipt'], 'visible' => Yii::app()->user->checkAccess('Accounting.MoneyReceipt.AdminMoneyReceipt')],
                        ['label' => Yii::t('app', 'MR MANAGE'), 'url' => ['/accounting/moneyReceipt/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.MoneyReceipt.Admin')],
                    ),
                ),
            ),
        ),

        array('label' => 'PURCHASE',
            'items' => array(
                array('label' => 'CONFIG',
                    'items' => array(
                        ['label' => Yii::t('app', 'BANK'), 'url' => ['/commercial/comBank/admin'], 'visible' => Yii::app()->user->checkAccess('Commercial.ComBank.Admin')],
                        ['label' => Yii::t('app', 'SUPPLIER'), 'url' => ['/commercial/suppliers/admin'], 'visible' => Yii::app()->user->checkAccess('Commercial.Suppliers.Admin')],
                    ),
                ),
                array('label' => 'ORDER',
                    'items' => array(
                        ['label' => Yii::t('app', 'CREATE'), 'url' => ['/commercial/purchaseOrder/create'], 'visible' => Yii::app()->user->checkAccess('Commercial.PurchaseOrder.Create')],
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/commercial/purchaseOrder/admin'], 'visible' => Yii::app()->user->checkAccess('Commercial.PurchaseOrder.Admin')],

                    ),
                ),
                array('label' => 'PAYMENT',
                    'items' => array(
                        ['label' => Yii::t('app', 'CREATE'), 'url' => ['/accounting/paymentReceipt/adminPaymentReceipt'], 'visible' => Yii::app()->user->checkAccess('Accounting.PaymentReceipt.AdminPaymentReceipt')],
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/accounting/paymentReceipt/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.PaymentReceipt.Create')],

                    ),
                ),

            ),
        ),

        array('label' => 'REPORT',
            'items' => array(
                array('label' => 'INVENTORY',
                    'items' => array(
                        ['label' => Yii::t('app', 'STOCK REPORT'), 'url' => ['/inventory/inventory/stockReport'], 'visible' => Yii::app()->user->checkAccess('Inventory.Inventory.StockReport')],
                    ),
                ),
                array('label' => 'SALES',
                    'items' => array(
                        ['label' => Yii::t('app', 'SALES REPORT'), 'url' => ['/report/salesReport'], 'visible' => Yii::app()->user->checkAccess('Report.SalesReport')],
                        ['label' => Yii::t('app', 'SALES DETAILS REPORT'), 'url' => ['/report/saleDetailsReport'], 'visible' => Yii::app()->user->checkAccess('Report.SaleDetailsReport')],
                        ['label' => Yii::t('app', 'CUSTOMER DUE REPORT'), 'url' => ['/report/customerDueReport'], 'visible' => Yii::app()->user->checkAccess('Report.CustomerDueReport')],
                        ['label' => Yii::t('app', 'CUSTOMER LEDGER'), 'url' => ['/report/customerLedger'], 'visible' => Yii::app()->user->checkAccess('Report.CustomerLedger')],
                        ['label' => Yii::t('app', 'COLLECTION REPORT'), 'url' => ['/report/collectionReport'], 'visible' => Yii::app()->user->checkAccess('Report.CollectionReport')],
                    ),
                ),
                array('label' => 'PURCHASE',
                    'items' => array(
                        ['label' => Yii::t('app', 'PURCHASE REPORT'), 'url' => ['/report/purchaseReport'], 'visible' => Yii::app()->user->checkAccess('Report.PurchaseReport')],
//                        ['label' => Yii::t('app', 'PURCHASE DETAILS REPORT'), 'url' => ['/report/purchaseDetailsReport'], 'visible' => Yii::app()->user->checkAccess('Report.PurchaseDetailsReport')],
                        ['label' => Yii::t('app', 'SUPPLIER DUE REPORT'), 'url' => ['/report/supplierDueReport'], 'visible' => Yii::app()->user->checkAccess('Report.SupplierDueReport')],
                        ['label' => Yii::t('app', 'SUPPLIER LEDGER'), 'url' => ['/report/supplierLedger'], 'visible' => Yii::app()->user->checkAccess('Report.SupplierLedger')],
                        ['label' => Yii::t('app', 'PAYMENT REPORT'), 'url' => ['/report/paymentReport'], 'visible' => Yii::app()->user->checkAccess('Report.PaymentReport')],
                    ),
                ),
            ),
        ),
        array('label' => 'LOGOUT', 'url' => array('/site/logout')),
    ),
));
?>
<style>
    #nav-bar {
        border-top: 1px solid #013C65;
        /* border-bottom: 1px solid #2d444f; */
        background: #013C65;
        /*padding: 0 30px;*/
    }


    #nav li {
        background: initial;
    }

    #nav li.active {
        background: green;
    }

    .portlet .portlet-content #nav-container #nav-bar #nav li {
        border-right: 2px solid white;
    }

    #nav ul span, #nav ul li.last li span {
        padding: 9px 15px !important;
    }
</style>