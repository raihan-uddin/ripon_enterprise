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
                        ['label' => Yii::t('app', 'EXPENSE HEAD'), 'url' => ['/accounting/expenseHead/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.ExpenseHead.Admin')],

                        ['label' => Yii::t('app', 'UNIT'), 'url' => ['/units/admin'], 'visible' => Yii::app()->user->checkAccess('Units.Admin')],
//                        ['label' => Yii::t('app', 'COUNTRY'), 'url' => ['/countries/admin'], 'visible' => Yii::app()->user->checkAccess('Countries.Admin')],
//                        ['label' => Yii::t('app', 'SHIP BY'), 'url' => ['/shipBy/admin'], 'visible' => Yii::app()->user->checkAccess('ShipBy.Admin')],
//                        ['label' => Yii::t('app', 'COMPANY'), 'url' => ['/yourCompany/admin'], 'visible' => Yii::app()->user->checkAccess('YourCompany.Admin')],
//                        ['label' => Yii::t('app', 'DB BACKUP'), 'url' => ['/users/dbBackup'], 'visible' => Yii::app()->user->checkAccess('Users.DbBackup')],

                    ),
                ),
                array('label' => 'EXPENSE',
                    'items' => array(
                        ['label' => Yii::t('app', 'ENTRY'), 'url' => ['/accounting/expense/create'], 'visible' => Yii::app()->user->checkAccess('Accounting.Expense.Create')],
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/accounting/expense/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.Expense.Admin')],
                    ),
                ),
            ),
        ),

        array('label' => 'INVENTORY',
            'items' => array(
                /* array('label' => 'JOB CARD ISSUE',
                     'items' => array(
                         ['label' => Yii::t('app', 'CREATE'), 'url' => ['/inventory/jobCardIssue/create'], 'visible' => Yii::app()->user->checkAccess('Inventory.JobCardIssue.Create')],
                         ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/inventory/jobCardIssue/admin'], 'visible' => Yii::app()->user->checkAccess('Inventory.JobCardIssue.Admin')],
                     ),
                 ),*/
                array('label' => 'STOCK',
                    'items' => array(
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/inventory/inventory/admin'], 'visible' => Yii::app()->user->checkAccess('Inventory.Inventory.Admin')],
                    ),
                ),

                array('label' => 'REPORTS',
                    'items' => array(
                        ['label' => Yii::t('app', 'STOCK REPORT'), 'url' => ['/inventory/inventory/stockReport'], 'visible' => Yii::app()->user->checkAccess('Inventory.Inventory.StockReport')],
                    ),
                ),
            ),
        ),
        /*array('label' => 'PRODUCTION',
            'items' => array(
                array('label' => 'CONFIG',
                    'items' => array(
                        ['label' => Yii::t('app', 'FG CONFIG (BOM)'), 'url' => ['/production/bom/admin'], 'visible' => Yii::app()->user->checkAccess('Production.Bom.Admin')],
                    ),
                ),
                array('label' => 'ORDER',
                    'items' => array(
                        ['label' => Yii::t('app', 'PRODUCTION ORDER'), 'url' => ['/sell/sellOrder/adminProductionOrder'], 'visible' => Yii::app()->user->checkAccess('Sell.SellOrder.AdminProductionOrder')],
                        ['label' => Yii::t('app', 'JOB CARD'), 'url' => ['/production/sellOrderBom/admin'], 'visible' => Yii::app()->user->checkAccess('Production.SellOrderBom.Admin')],
                    ),
                ),

                array('label' => 'PRODUCTION ENTRY',
                    'items' => array(
                        ['label' => Yii::t('app', 'CREATE'), 'url' => ['/production/production/create'], 'visible' => Yii::app()->user->checkAccess('Production.Production.Create')],
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/production/production/admin'], 'visible' => Yii::app()->user->checkAccess('Production.Production.Admin')],
                    ),
                ),
            ),
        ),*/
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
                /*array('label' => 'DELIVERY',
                    'items' => array(
                        ['label' => Yii::t('app', 'PENDING DELIVERY'), 'url' => ['/sell/sellDelivery/adminPendingDelivery'], 'visible' => Yii::app()->user->checkAccess('Sell.SellDelivery.AdminPendingDelivery')],
                        ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/sell/sellDelivery/admin'], 'visible' => Yii::app()->user->checkAccess('Sell.SellDelivery.Admin')],

                    ),
                ),*/
                /* array('label' => 'INVOICE',
                     'items' => array(
                         ['label' => Yii::t('app', 'CREATE'), 'url' => ['/crm/invoice/create'], 'visible' => Yii::app()->user->checkAccess('Crm.Invoice.AdminPendingDelivery')],
                         ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/crm/invoice/admin'], 'visible' => Yii::app()->user->checkAccess('Crm.Invoice.Admin')],

                     ),
                 ),*/
                array('label' => 'COLLECTION',
                    'items' => array(
                        ['label' => Yii::t('app', 'MR CREATE'), 'url' => ['/accounting/moneyReceipt/adminMoneyReceipt'], 'visible' => Yii::app()->user->checkAccess('Accounting.MoneyReceipt.AdminMoneyReceipt')],
                        ['label' => Yii::t('app', 'MR MANAGE'), 'url' => ['/accounting/moneyReceipt/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.MoneyReceipt.Admin')],
                    ),
                ),
                array('label' => 'REPORTS',
                    'items' => array(
                        ['label' => Yii::t('app', 'CUSTOMER DUE REPORT'), 'url' => ['/report/customerDueReport'], 'visible' => Yii::app()->user->checkAccess('Report.CustomerDueReport')],
                        ['label' => Yii::t('app', 'CUSTOMER LEDGER'), 'url' => ['/report/customerLedger'], 'visible' => Yii::app()->user->checkAccess('Report.CustomerLedger')],
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

                array('label' => 'REPORTS',
                    'items' => array(
                        ['label' => Yii::t('app', 'SUPPLIER DUE REPORT'), 'url' => ['/report/supplierDueReport'], 'visible' => Yii::app()->user->checkAccess('Report.SupplierDueReport')],
                        ['label' => Yii::t('app', 'SUPPLIER LEDGER'), 'url' => ['/report/supplierLedger'], 'visible' => Yii::app()->user->checkAccess('Report.SupplierLedger')],
                        ['label' => Yii::t('app', 'Collection Report'), 'url' => ['/report/collectionReport'], 'visible' => Yii::app()->user->checkAccess('Report.CollectionReport')],
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