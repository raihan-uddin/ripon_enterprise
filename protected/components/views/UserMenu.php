<?php
$this->widget('application.extensions.mbmenu.MbMenu', array(

    'items' => array(
        array('label' => 'DASHBOARD', 'url' => array('/site/index')),
        array('label' => 'SOFTWARE',
            'items' => array(
                array('label' => 'USER',
                    'items' => array(
                        ['label' => Yii::t('app', 'MANAGE USERS'), 'url' => ['/users/admin'], 'visible' => Yii::app()->user->checkAccess('Users.Admin')],
                        ['label' => Yii::t('app', 'MANAGE PERMISSION'), 'url' => ['/rights'], 'visible' => Yii::app()->user->checkAccess('rights')],
                    ),
                ),
                array('label' => 'CONFIG',
                    'items' => array(
                        ['label' => Yii::t('app', 'UNIT'), 'url' => ['/units/admin'], 'visible' => Yii::app()->user->checkAccess('Units.Admin')],
//                        ['label' => Yii::t('app', 'COUNTRY'), 'url' => ['/countries/admin'], 'visible' => Yii::app()->user->checkAccess('Countries.Admin')],
//                        ['label' => Yii::t('app', 'SHIP BY'), 'url' => ['/shipBy/admin'], 'visible' => Yii::app()->user->checkAccess('ShipBy.Admin')],
//                        ['label' => Yii::t('app', 'COMPANY'), 'url' => ['/yourCompany/admin'], 'visible' => Yii::app()->user->checkAccess('YourCompany.Admin')],
//                        ['label' => Yii::t('app', 'DB BACKUP'), 'url' => ['/users/dbBackup'], 'visible' => Yii::app()->user->checkAccess('Users.DbBackup')],

                    ),
                )
            ),
        ),
        /*array('label' => 'HR',
            'items' => array(
                array('label' => 'CONFIG',
                    'items' => array(
                        ['label' => Yii::t('app', 'BRANCHES'), 'url' => ['/hr/branches/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.Branches.Admin')],
                        ['label' => Yii::t('app', 'DEPARTMENT'), 'url' => ['/hr/departments/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.Departments.Admin')],
                        ['label' => Yii::t('app', 'SUB-DEPARTMENT'), 'url' => ['/hr/departmentsSub/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.DepartmentsSub.Admin')],
                        ['label' => Yii::t('app', 'DESIGNATION'), 'url' => ['/hr/designations/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.Designations.Admin')],
                        ['label' => Yii::t('app', 'STAFF CAT'), 'url' => ['/hr/stuffCat/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.StuffCat.Admin')],
                        ['label' => Yii::t('app', 'SHIFT'), 'url' => ['/hr/shiftHeads/create'], 'visible' => Yii::app()->user->checkAccess('Hr.ShiftHeads.Create')],
                        array('label' => 'EMPLOYEES',
                            'items' => array(
                                ['label' => Yii::t('app', 'CREATE'), 'url' => ['/hr/Employees/create'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.Create')],
                                ['label' => Yii::t('app', 'MANAGE'), 'url' => ['/hr/Employees/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.Admin')],
                            ),
                        ),
                        ['label' => Yii::t('app', 'BONUS HEAD'), 'url' => ['/hr/bonusTitles/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.BonusTitles.Admin')],
                        ['label' => Yii::t('app', 'LEAVE HEAD'), 'url' => ['/hr/lhProllNormal/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.LhProllNormal.Admin')],
                        ['label' => Yii::t('app', 'EARNING HEAD'), 'url' => ['/hr/ahProllNormal/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.AhProllNormal.Admin')],
                    ),
                ),
                array('label' => 'EARN/DEDUCT',
                    'items' => array(
                        ['label' => Yii::t('app', 'SALARY SETUP'), 'url' => ['/hr/ahAmounProllNormal/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.AhAmounProllNormal.Admin')],
                        ['label' => Yii::t('app', 'ASSIGN BONUS'), 'url' => ['/hr/bonusAmounts/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.BonusAmounts.Admin')],
//                        ['label' => Yii::t('app', 'Advance Pay / Receive'), 'url' => ['/hr/advancePayRecv/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.AdvancePayRecv.Admin')],
//                        ['label' => Yii::t('app', 'Punishment/Adjust'), 'url' => ['/hr/punishment/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.Punishment.Admin')],
                    ),
                ),
                array('label' => 'LEAVE MANAGEMENT',
                    'items' => array(
                        ['label' => Yii::t('app', 'LEAVE SETUP'), 'url' => ['/hr/lhAmountProllNormal/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.LhAmountProllNormal.Admin')],
                        ['label' => Yii::t('app', 'TAKE A LEAVE '), 'url' => ['/hr/empLeavesNormal/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.EmpLeavesNormal.Admin')],
                    ),
                ),
                array('label' => 'ATTENDANCE MANAGEMENT',
                    'items' => array(
                        ['label' => Yii::t('app', 'WORKING DAY'), 'url' => ['/hr/workingDay/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.WorkingDay.Admin')],
                        ['label' => Yii::t('app', 'ADD SHIFT ASSIGN'), 'url' => ['/hr/empShiftAsign/create'], 'visible' => Yii::app()->user->checkAccess('Hr.EmpShiftAsign.Create')],
                        ['label' => Yii::t('app', 'MANAGE SHIFT ASSIGN'), 'url' => ['/hr/empShiftAsign/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.EmpShiftAsign.Admin')],
                        ['label' => Yii::t('app', 'ATTENDANCE (MANUAL)'), 'url' => ['/hr/empAttendance/create'], 'visible' => Yii::app()->user->checkAccess('Hr.EmpAttendance.Create')],
                        ['label' => Yii::t('app', 'ATTENDANCE (DEVICE)'), 'url' => ['/hr/empAttendance/uploadDeveiceData'], 'visible' => Yii::app()->user->checkAccess('Hr.EmpAttendance.UploadDeveiceData')],
                        ['label' => Yii::t('app', 'MANAGE ATTN. INFO'), 'url' => ['/hr/empAttendance/admin'], 'visible' => Yii::app()->user->checkAccess('Hr.EmpAttendance.Admin')],
                    ),
                ),
                array('label' => 'REPORTS',
                    'items' => array(
                        ['label' => Yii::t('app', 'LEAVE SUMMARY (ALL)'), 'url' => ['/hr/employees/allEmpLeaveReportSummary'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.AllEmpLeaveReportSummary')],
                        ['label' => Yii::t('app', 'LEAVE SUMMARY(EMP. WISE)'), 'url' => ['/hr/employees/leaveReportSummary'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.LeaveReportSummary')],
                        ['label' => Yii::t('app', 'ATTENDANCE (SUMMARY)'), 'url' => ['/hr/employees/attendanceReportSummary'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.AttendanceReportSummary')],
                        ['label' => Yii::t('app', 'INCOMPLETE ATTENDANCE (SUMMARY)'), 'url' => ['/hr/employees/incompleteAttendanceSummary'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.IncompleteAttendanceSummary')],
                        ['label' => Yii::t('app', 'ATTENDANCE (DAILY)'), 'url' => ['/hr/employees/attendanceReportDaily'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.AttendanceReportDaily')],
                        ['label' => Yii::t('app', 'ATTENDANCE (EMP. WISE)'), 'url' => ['/hr/employees/attendanceReport'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.AttendanceReport')],
                        ['label' => Yii::t('app', 'SALARY SHEET'), 'url' => ['/hr/employees/employeePaySlip'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.EmployeePaySlip')],
                        ['label' => Yii::t('app', 'SALARY SHEET 2'), 'url' => ['/hr/employees/salarySheet'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.SalarySheet')],
                        ['label' => Yii::t('app', 'PAYSLIP'), 'url' => ['/hr/employees/paySlipSingle'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.PaySlipSingle')],
                        ['label' => Yii::t('app', 'ADVANCE SALARY SHEET'), 'url' => ['/hr/employees/advanceSalarySheet'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.AdvanceSalarySheet')],
                        ['label' => Yii::t('app', 'ADVANCE/LOAN REPORT'), 'url' => ['/hr/advancePayRecv/advLoanReport'], 'visible' => Yii::app()->user->checkAccess('Hr.AdvancePayRecv.AdvLoanReport')],
                        ['label' => Yii::t('app', 'LEAVE REPORT'), 'url' => ['/hr/empLeavesNormal/leaveReport'], 'visible' => Yii::app()->user->checkAccess('Hr.EmpLeavesNormal.LeaveReport')],
                        ['label' => Yii::t('app', 'EMPLOYEE REPORT'), 'url' => ['/hr/employees/employeeReport'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.EmployeeReport')],
                        ['label' => Yii::t('app', 'JOINING REPORT'), 'url' => ['/hr/employees/joiningReport'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.joiningReport')],
                        ['label' => Yii::t('app', 'SALARY REPORT GENERATE'), 'url' => ['/hr/employees/salaryReportGenerate'], 'visible' => Yii::app()->user->checkAccess('Hr.Employees.salaryReportGenerate')],
                    ),
                ),
            ),
        ),*/
        array('label' => 'EXPENSE',
            'items' => array(
                array('label' => 'CONFIG',
                    'items' => array(
                        ['label' => Yii::t('app', 'EXPENSE HEAD'), 'url' => ['/accounting/expenseHead/admin'], 'visible' => Yii::app()->user->checkAccess('Accounting.ExpenseHead.Admin')],
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
//                        ['label' => Yii::t('app', 'STORE'), 'url' => ['/inventory/stores/admin'], 'visible' => Yii::app()->user->checkAccess('Inventory.Stores.Admin')],
//                        ['label' => Yii::t('app', 'LOCATION'), 'url' => ['/inventory/location/admin'], 'visible' => Yii::app()->user->checkAccess('Inventory.Location.Admin')],
                    ),
                ),
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
                        ['label' => Yii::t('app', 'SUPPLIER DUE REPORT'), 'url' => ['/report/customerDueReport'], 'visible' => Yii::app()->user->checkAccess('Report.CustomerDueReport')],
                        ['label' => Yii::t('app', 'SUPPLIER LEDGER'), 'url' => ['/report/supplierLedger'], 'visible' => Yii::app()->user->checkAccess('Report.SupplierLedger')],
                    ),
                ),
            ),
        ),
        array('label' => 'LOGOUT (' . Yii::app()->user->name . ')', 'url' => array('/site/logout')),
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