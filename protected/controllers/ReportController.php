<?php

class ReportController extends RController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function allowedActions()
    {
        return '';
    }

    public function actionCustomerLedger()
    {
        $model = new Inventory();
        $this->pageTitle = 'CUSTOMER LEDGER';
        $this->render('customerLedger', array('model' => $model));
    }

    public function actionCustomerLedgerView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];
        $customer_id = $_POST['Inventory']['customer_id'];

        $message = "";
        $data = NULL;

        if ($dateFrom != "" && $dateTo != '' & $customer_id > 0) {
            $message .= "Customer: " . Customers::model()->nameOfThis($customer_id);
            $message .= "<br>  Date: " . date('d/m/Y', strtotime($dateFrom)) . "-" . date('d/m/Y', strtotime($dateTo));

            $criteriaOpSell = new CDbCriteria();
            $criteriaOpSell->select = " sum(grand_total) as grand_total";
            $criteriaOpSell->addColumnCondition(['customer_id' => $customer_id]);
            $criteriaOpSell->addCondition(" date < '$dateFrom'");
            $data_opening_sell = SellOrder::model()->findByAttributes([], $criteriaOpSell);

            $criteriaOpMr = new CDbCriteria();
            $criteriaOpMr->select = " sum(amount) as amount";
            $criteriaOpMr->addColumnCondition(['customer_id' => $customer_id]);
            $criteriaOpMr->addCondition(" date < '$dateFrom'");
            $data_opening_mr = MoneyReceipt::model()->findByAttributes([], $criteriaOpMr);
            $opening = ($data_opening_sell ? $data_opening_sell->grand_total : 0) - ($data_opening_mr ? $data_opening_mr->amount : 0);

            $sql = "SELECT temp.* FROM (
                    SELECT id, date, so_no AS order_no, customer_id, grand_total AS amount, 'sale' as trx_type, created_at
                    FROM sell_order
                    WHERE date BETWEEN '$dateFrom' AND '$dateTo' " . ($customer_id > 0 ? " AND customer_id = $customer_id" : "") . "
                    UNION
                    SELECT id, date, mr_no AS order_no, customer_id, amount, 'collection', created_at
                    FROM money_receipt
                    WHERE date BETWEEN '$dateFrom' AND '$dateTo' " . ($customer_id > 0 ? " AND customer_id = $customer_id" : "") . "
                ) temp
                ORDER BY created_at ASC;
                ";
            $command = Yii::app()->db->createCommand($sql);
            $data = $command->queryAll();
        }
        echo $this->renderPartial('customerLedgerView', array(
            'data' => $data,
            'message' => $message,
            'opening' => $opening,
        ), true, true);
        Yii::app()->end();
    }

    public function actionCustomerDueReport()
    {
        $model = new Inventory();
        $this->pageTitle = 'CUSTOMER DUE REPORT';
        $this->render('customerDueReport', array('model' => $model));
    }

    public function actionCustomerDueReportView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];
        $customer_id = $_POST['Inventory']['customer_id'];

        $message = "";
        $data = NULL;


        $message .= "DUE REPORT";

        $sql = "SELECT 
                customer_id, 
                c.company_name,
                c.company_contact_no,
                ROUND(SUM(t.sale_amount), 2) AS total_sale_amount,
                ROUND(SUM(t.receipt_amount), 2) AS total_receipt_amount,
                ROUND(SUM(amount), 2) AS due_amount
            FROM 
                (SELECT 
                    customer_id, 
                    grand_total as sale_amount,
                    0 as receipt_amount,
                    grand_total as amount 
                FROM 
                    sell_order
                    " . ($customer_id > 0 ? " WHERE customer_id = $customer_id" : "") . "
                UNION ALL
                SELECT 
                    customer_id, 
                    0 as sale_amount,
                    (amount+discount) as receipt_amount,
                    -(amount+discount) 
                FROM 
                    money_receipt
                    " . ($customer_id > 0 ? " WHERE customer_id = $customer_id" : "") . "
                ) AS t
            inner join customers c on t.customer_id = c.id
            GROUP BY 
                customer_id
            HAVING 
                due_amount <> 0
            ORDER BY c.company_name;";
        $command = Yii::app()->db->createCommand($sql);
        $data = $command->queryAll();

        echo $this->renderPartial('customerDueReportView', array(
            'data' => $data,
            'message' => $message,
        ), true, true);
        Yii::app()->end();
    }

    public function actionSupplierLedger()
    {
        $model = new Inventory();
        $this->pageTitle = 'CUSTOMER LEDGER';
        $this->render('supplierLedger', array('model' => $model));
    }

    public function actionSupplierLedgerView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];
        $customer_id = $_POST['Inventory']['supplier_id'];

        $message = "";
        $data = NULL;

        if ($dateFrom != "" && $dateTo != '' & $customer_id > 0) {
            $message .= "Supplier: " . Suppliers::model()->nameOfThis($customer_id);
            $message .= "<br>  Date: " . date('d/m/Y', strtotime($dateFrom)) . "-" . date('d/m/Y', strtotime($dateTo));

            $criteriaOpSell = new CDbCriteria();
            $criteriaOpSell->select = " sum(grand_total) as total_amount";
            $criteriaOpSell->addColumnCondition(['supplier_id' => $customer_id]);
            $criteriaOpSell->addCondition(" date < '$dateFrom'");
            $data_opening_sell = PurchaseOrder::model()->findByAttributes([], $criteriaOpSell);

            $criteriaOpMr = new CDbCriteria();
            $criteriaOpMr->select = " sum(amount) as amount";
            $criteriaOpMr->addColumnCondition(['supplier_id' => $customer_id]);
            $criteriaOpMr->addCondition(" date < '$dateFrom'");
            $data_opening_mr = PaymentReceipt::model()->findByAttributes([], $criteriaOpMr);
            $opening = ($data_opening_sell ? $data_opening_sell->total_amount : 0) - ($data_opening_mr ? $data_opening_mr->amount : 0);

            $sql = "SELECT temp.* FROM (
                    SELECT id, date, po_no AS order_no, supplier_id, grand_total AS amount, 'purchase' as trx_type, created_at
                    FROM purchase_order
                    WHERE date BETWEEN '$dateFrom' AND '$dateTo' " . ($customer_id > 0 ? " AND supplier_id = $customer_id" : "") . "
                    UNION
                    SELECT id, date, pr_no AS order_no, supplier_id, amount, 'payment', created_at
                    FROM payment_receipt
                    WHERE date BETWEEN '$dateFrom' AND '$dateTo' " . ($customer_id > 0 ? " AND supplier_id = $customer_id" : "") . "
                ) temp
                
                ORDER BY created_at ASC;";
            $command = Yii::app()->db->createCommand($sql);
            $data = $command->queryAll();
        }
        echo $this->renderPartial('supplierLedgerView', array(
            'data' => $data,
            'message' => $message,
            'opening' => $opening,
        ), true, true);
        Yii::app()->end();
    }

    public function actionSupplierDueReport()
    {
        $model = new Inventory();
        $this->pageTitle = 'SUPPLIER DUE REPORT';
        $this->render('supplierDueReport', array('model' => $model));
    }

    public function actionSupplierDueReportView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];
        $customer_id = $_POST['Inventory']['supplier_id'];

        $message = "";
        $data = NULL;


        $message .= "DUE REPORT";

        $sql = "SELECT 
                supplier_id, 
                s.company_name,
                s.company_contact_no,
                ROUND(SUM(t.purchase_amount), 2) AS total_purchase_amount,
                ROUND(SUM(t.payment_amount), 2) AS total_payment_amount,
                ROUND(SUM(amount), 2) AS due_amount
            FROM 
                (SELECT 
                    supplier_id, 
                    grand_total as purchase_amount,
                    0 as payment_amount,
                    grand_total as amount 
                FROM 
                    purchase_order
                    " . ($customer_id > 0 ? " WHERE supplier_id = $customer_id" : "") . "
                UNION ALL
                SELECT 
                    supplier_id, 
                    0 as purchase_amount,
                    amount as payment_amount,
                    -amount 
                FROM 
                    payment_receipt
                    " . ($customer_id > 0 ? " WHERE supplier_id = $customer_id" : "") . "
                ) AS t
            inner join suppliers s on t.supplier_id = s.id
            GROUP BY 
                supplier_id
            HAVING 
                due_amount <> 0
            ORDER BY s.company_name;";
        $command = Yii::app()->db->createCommand($sql);
        $data = $command->queryAll();

        echo $this->renderPartial('supplierDueReportView', array(
            'data' => $data,
            'message' => $message,
        ), true, true);
        Yii::app()->end();
    }

    public function actionDayInOutReport()
    {
        $model = new Inventory();
        $this->pageTitle = 'DAY IN/OUT REPORT';
        $this->render('dayInOutReport', array('model' => $model));
    }

    public function actionDayInOutReportView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];

        $message = "";
        $data = NULL;
        $opening = 0;
        if ($dateFrom != "" && $dateTo != '') {

            $message = "<br>  Date: " . date('d/m/Y', strtotime($dateFrom)) . "-" . date('d/m/Y', strtotime($dateTo));

            $criteriaOpMr = new CDbCriteria();
            $criteriaOpMr->select = " sum(amount) as amount";
            $criteriaOpMr->addCondition(" date < '$dateFrom'");
            $data_opening_mr = MoneyReceipt::model()->findByAttributes([], $criteriaOpMr);

            $criteriaOpPr = new CDbCriteria();
            $criteriaOpPr->select = " sum(amount) as amount";
            $criteriaOpPr->addCondition(" date < '$dateFrom'");
            $data_opening_pr = PaymentReceipt::model()->findByAttributes([], $criteriaOpPr);

            $criteriaOpExp = new CDbCriteria();
            $criteriaOpExp->select = " sum(amount) as amount";
            $criteriaOpExp->addCondition(" date < '$dateFrom'");
            $data_opening_exp = Expense::model()->findByAttributes([], $criteriaOpExp);

            $opening = ($data_opening_mr ? $data_opening_mr->amount : 0) - (($data_opening_pr ? $data_opening_pr->amount : 0) + ($data_opening_exp ? $data_opening_exp->amount : 0));

            $sql = "SELECT date, 
               SUM(CASE WHEN transaction_type = 'Expense' THEN amount ELSE 0 END) AS expense, 
               SUM(CASE WHEN transaction_type = 'Income' THEN amount ELSE 0 END) AS income, 
               SUM(CASE WHEN transaction_type = 'Outgoing Payment' THEN amount ELSE 0 END) AS payment 
                FROM (
                        (SELECT 'Expense' AS transaction_type, date, amount
                         FROM expense
                         WHERE date BETWEEN '$dateFrom' AND '$dateTo')
                
                         UNION ALL
                
                         (SELECT 'Income' AS transaction_type, date, amount
                         FROM money_receipt
                         WHERE date BETWEEN '$dateFrom' AND '$dateTo')
                
                         UNION ALL
                
                         (SELECT 'Outgoing Payment' AS transaction_type, date, amount
                         FROM payment_receipt
                         WHERE date BETWEEN '$dateFrom' AND '$dateTo')
                     ) AS t
                GROUP BY date";
            $command = Yii::app()->db->createCommand($sql);
            $data = $command->queryAll();
        }
        echo $this->renderPartial('dayInOutReportView', array(
            'data' => $data,
            'message' => $message,
            'opening' => $opening,
        ), true, true);
        Yii::app()->end();
    }

    public function actionCollectionReport()
    {
        $model = new Inventory();
        $this->pageTitle = 'COLLECTION REPORT';
        $this->render('collectionReport', array('model' => $model));
    }

    public function actionCollectionReportView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];
        $customer_id = $_POST['Inventory']['customer_id'];
        $created_by = $_POST['Inventory']['created_by'];

        $message = "";
        $data = NULL;

        if ($dateFrom != "" && $dateTo != '') {
            $message .= "<br>  Date: " . date('d/m/Y', strtotime($dateFrom)) . "-" . date('d/m/Y', strtotime($dateTo));

            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('t.date', $dateFrom, $dateTo);
            if ($customer_id > 0) {
                $criteria->addColumnCondition(['t.customer_id' => $customer_id]);
            }
            if ($created_by > 0) {
                $criteria->addColumnCondition(['t.created_by' => $created_by]);
            }
            $criteria->join = " INNER JOIN users u on t.created_by = u.id ";
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->select = "t.*, u.username, c.company_name as customer_name, c.company_contact_no as contact_no";
            $criteria->order = 't.date asc';
            $data = MoneyReceipt::model()->findAll($criteria);
        }
        echo $this->renderPartial('collectionReportView', array(
            'data' => $data,
            'message' => $message,
        ), true, true);
        Yii::app()->end();
    }


    public function actionPaymentReport()
    {
        $model = new Inventory();
        $this->pageTitle = 'PAYMENT REPORT';
        $this->render('paymentReport', array('model' => $model));
    }

    public function actionPaymentReportView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];
        $supplier_id = $_POST['Inventory']['supplier_id'];
        $created_by = $_POST['Inventory']['created_by'];

        $message = "";
        $data = NULL;

        if ($dateFrom != "" && $dateTo != '') {
            $message .= "<br>  Date: " . date('d/m/Y', strtotime($dateFrom)) . "-" . date('d/m/Y', strtotime($dateTo));

            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('t.date', $dateFrom, $dateTo);
            if ($supplier_id > 0) {
                $criteria->addColumnCondition(['t.supplier_id' => $supplier_id]);
            }
            if ($created_by > 0) {
                $criteria->addColumnCondition(['t.created_by' => $created_by]);
            }
            $criteria->join = " INNER JOIN users u on t.created_by = u.id ";
            $criteria->join .= " INNER JOIN suppliers c on t.supplier_id = c.id ";
            $criteria->select = "t.*, u.username, c.company_name as customer_name, c.company_contact_no as contact_no";
            $criteria->order = 't.date asc';
            $data = PaymentReceipt::model()->findAll($criteria);
        }
        echo $this->renderPartial('paymentReportView', array(
            'data' => $data,
            'message' => $message,
        ), true, true);
        Yii::app()->end();
    }
}
