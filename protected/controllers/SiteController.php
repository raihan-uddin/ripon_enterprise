<?php

class SiteController extends Controller
{
    public $defaultAction = 'login';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }


    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('site/login'));
        } else {
            $this->redirect(Yii::app()->createUrl('site/dashBoard'));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                LoginHistory::saveLoginInformation();

                $user = Users::model()->findByPk(Yii::app()->user->id);

                Yii::app()->user->setState('user_id', $user->id);
                Yii::app()->user->setState('business_id', $user->business_id);
                Yii::app()->user->setState('branch_id', $user->branch_id);

                $this->redirect(Yii::app()->createUrl('site/dashBoard'));
            } else {
                $remarks = "";
                foreach ($model->getErrors() as $value) {
                    foreach ($value as $v)
                        $remarks .= "$v, ";
                }
//                LoginHistory::saveLoginInformation(['status' => LoginHistory::STATUS_FAILED, 'remarks' => $remarks, 'username' => $_POST['LoginForm']['username']]);
            }

        }
        // display the login form
        $this->render('login', array('model' => $model));
    }


    public function actionDashBoard()
    {
        if (!Yii::app()->user->isGuest) {
            $this->layout = 'column1';

            $this->pageTitle = 'DASHBOARD';
            $this->render('dashBoard');
        } else {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
    }

    public function actionProfitLossSummary()
    {
        $this->layout = 'column1';
        $this->pageTitle = 'Profit & Loss Summary';
        $date = explode(' - ', $_POST['dateRange']);
        $startDate = date('Y-m-d', strtotime($date[0]));
        $endDate = date('Y-m-d', strtotime($date[1]));
        if (!$endDate) {
            $endDate = $startDate;
        }

        // Determine previous period range
        $periodDays = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1; // +1 to include both ends
        $prevEndDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
        $prevStartDate = date('Y-m-d', strtotime($prevEndDate . " -{$periodDays} days"));

        // calculate previous sales
        $prevSalesSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(total_amount)) as total_amount, ROUND(SUM(costing)) as cogs, ROUND(SUM(discount_amount)) as discount_amount')
            ->from('sell_order')
            ->where('order_type = :type AND date BETWEEN :start_date AND :end_date', [
                ':type' => SellOrder::NEW_ORDER,
                ':start_date' => $prevStartDate,
                ':end_date' => $prevEndDate,
            ])
            ->queryRow();

        $prevReturnSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(return_amount)) as return_amount, ROUND(SUM(costing)) as costing')
            ->from('sell_return')
            ->where('return_date BETWEEN :start_date AND :end_date', [
                ':start_date' => $prevStartDate,
                ':end_date' => $prevEndDate,
            ])
            ->queryRow();

        $prevExpense = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(amount)) as total_amount')
            ->from('expense')
            ->where('date BETWEEN :start_date AND :end_date', [
                ':start_date' => $prevStartDate,
                ':end_date' => $prevEndDate,
            ])
            ->queryScalar();

        // === Calculate Previous Profit ===
        $prevProfit = (
            $prevSalesSummary['total_amount']
            - ($prevSalesSummary['cogs'] + ($prevReturnSummary['return_amount'] - $prevReturnSummary['costing']))
            - $prevSalesSummary['discount_amount']
            - $prevExpense
        );

        // calculate total sales amount with the profit
        $totalSalesSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(total_amount)) as total_amount, ROUND(SUM(costing)) as cogs, ROUND(SUM(discount_amount)) as discount_amount')
            ->from('sell_order')
            ->where('order_type = :type AND date BETWEEN :start_date AND :end_date',
                array(
                    ':type' => SellOrder::NEW_ORDER,
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ))
            ->queryRow();
        $totalCogsValue = $totalSalesSummary['cogs'];
        $totalSaleDiscountValue = $totalSalesSummary['discount_amount'];
        $totalSalesValue = $totalSalesSummary['total_amount'];

        //calculate return
        $totalReturnSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(return_amount)) as return_amount, ROUND(SUM(costing)) as costing')
            ->from('sell_return')
            ->where('return_date BETWEEN :start_date AND :end_date',
                array(
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ))
            ->queryRow();
        $totalReturnAmount = $totalReturnSummary['return_amount'];
        $totalReturnCosting = $totalReturnSummary['costing'];

        // calculate total purchase amount
        $totalPurchaseSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(grand_total)) as grand_total')
            ->from('purchase_order')
            ->where('date BETWEEN :start_date AND :end_date', array(
                ':start_date' => $startDate,
                ':end_date' => $endDate,
            ))
            ->queryScalar();

        // calculate total expense amount
        $totalExpenseSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(amount)) as total_amount')
            ->from('expense')
            ->where(' date BETWEEN :start_date AND :end_date',
                array(
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ))
            ->queryScalar();

        // total money receipt amount
        $totalMoneyReceiptSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(amount)) as total_amount')
            ->from('money_receipt')
            ->where(' date BETWEEN :start_date AND :end_date',
                array(
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ))
            ->queryScalar();

        // total payment amount
        $totalPaymentSummary = Yii::app()->db->createCommand()
            ->select('ROUND(SUM(amount)) as total_amount')
            ->from('payment_receipt')
            ->where(' date BETWEEN :start_date AND :end_date',
                array(
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ))
            ->queryScalar();


        $this->renderPartial('profitLossSummary', array(
            'totalSalesValue' => $totalSalesValue,
            'totalSaleDiscountValue' => $totalSaleDiscountValue,
            'totalCogsValue' => $totalCogsValue,
            'totalPurchaseValue' => $totalPurchaseSummary,
            'totalExpenseValue' => $totalExpenseSummary,
            'totalMoneyReceiptValue' => $totalMoneyReceiptSummary,
            'totalPaymentValue' => $totalPaymentSummary,
            'totalReturnValue' => $totalReturnAmount,
            'totalReturnCosting' => $totalReturnCosting,
            'prevMonthProfit' => $prevProfit,
            'prevSalesSummary' => $prevSalesSummary,
            'prevReturnSummary' => $prevReturnSummary,
            'prevExpense' => $prevExpense,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'prevStartDate' => $prevStartDate,
            'prevEndDate' => $prevEndDate,
        ));
    }

    public function actionDashboardStats()
    {
        header('Content-Type: application/json');

        $dateRange = Yii::app()->request->getPost('dateRange', '');
        if ($dateRange) {
            $date = explode(' - ', $dateRange);
            $startDate = date('Y-m-d', strtotime($date[0]));
            $endDate = date('Y-m-d', strtotime($date[1]));
        } else {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');
        }

        $db = Yii::app()->db;

        // 1️⃣ Total Sales
        $sales = (int) $db->createCommand()
            ->select('ROUND(SUM(total_amount))')
            ->from('sell_order')
            ->where('order_type=:type AND date BETWEEN :start AND :end', [
                ':type' => SellOrder::NEW_ORDER,
                ':start' => $startDate,
                ':end' => $endDate,
            ])->queryScalar();

        // 2️⃣ Total Purchase
        $purchase = (int) $db->createCommand()
            ->select('ROUND(SUM(grand_total))')
            ->from('purchase_order')
            ->where('date BETWEEN :start AND :end', [
                ':start' => $startDate,
                ':end' => $endDate,
            ])->queryScalar();

        // 3️⃣ Total Expense
        $expense = (int) $db->createCommand()
            ->select('ROUND(SUM(amount))')
            ->from('expense')
            ->where('date BETWEEN :start AND :end', [
                ':start' => $startDate,
                ':end' => $endDate,
            ])->queryScalar();

        // 4️⃣ Total Collection
        $collection = (int) $db->createCommand()
            ->select('ROUND(SUM(amount))')
            ->from('money_receipt')
            ->where('date BETWEEN :start AND :end', [
                ':start' => $startDate,
                ':end' => $endDate,
            ])->queryScalar();

        // 5️⃣ Total Payment
        $payment = (int) $db->createCommand()
            ->select('ROUND(SUM(amount))')
            ->from('payment_receipt')
            ->where('date BETWEEN :start AND :end', [
                ':start' => $startDate,
                ':end' => $endDate,
            ])->queryScalar();

        // 6️⃣ Return
        $returns = (int) $db->createCommand()
            ->select('ROUND(SUM(return_amount))')
            ->from('sell_return')
            ->where('return_date BETWEEN :start AND :end', [
                ':start' => $startDate,
                ':end' => $endDate,
            ])->queryScalar();

        // 7️⃣ Profit (roughly sales - purchase - expense)
        $profit = $sales - $purchase - $expense;



        // --- Sales trend ---
        $salesTrend = $db->createCommand("
    SELECT DATE(date) AS day, ROUND(SUM(total_amount)) AS amount
    FROM sell_order
    WHERE order_type = :type AND date BETWEEN :start AND :end
    GROUP BY DATE(date)
    ORDER BY DATE(date)
")->queryAll(true, [
            ':type' => SellOrder::NEW_ORDER,
            ':start' => $startDate,
            ':end' => $endDate,
        ]);

// --- Purchase trend ---
        $purchaseTrend = $db->createCommand("
    SELECT DATE(date) AS day, ROUND(SUM(grand_total)) AS amount
    FROM purchase_order
    WHERE date BETWEEN :start AND :end
    GROUP BY DATE(date)
    ORDER BY DATE(date)
")->queryAll(true, [':start' => $startDate, ':end' => $endDate]);

// --- Expense trend ---
        $expenseTrend = $db->createCommand("
    SELECT DATE(date) AS day, ROUND(SUM(amount)) AS amount
    FROM expense
    WHERE date BETWEEN :start AND :end
    GROUP BY DATE(date)
    ORDER BY DATE(date)
")->queryAll(true, [':start' => $startDate, ':end' => $endDate]);

// Prepare aligned dates (important for consistent X-axis)
        $allDates = [];
        foreach ([$salesTrend, $purchaseTrend, $expenseTrend] as $arr) {
            foreach ($arr as $r) $allDates[$r['day']] = true;
        }
        $allDates = array_keys($allDates);
        sort($allDates);

        function mapTrend($source, $dates) {
            $mapped = [];
            $byDate = [];
            foreach ($source as $r) $byDate[$r['day']] = $r['amount'];
            foreach ($dates as $d) $mapped[] = isset($byDate[$d]) ? (int)$byDate[$d] : 0;
            return $mapped;
        }


        echo CJSON::encode([
            'success' => true,
            'data' => [
                'sales' => $sales,
                'purchase' => $purchase,
                'expense' => $expense,
                'collection' => $collection,
                'payment' => $payment,
                'returns' => $returns,
                'profit' => $profit,
                'trend' => [
                    'dates' => $allDates,
                    'sales' => mapTrend($salesTrend, $allDates),
                    'purchase' => mapTrend($purchaseTrend, $allDates),
                    'expense' => mapTrend($expenseTrend, $allDates),
                ],
            ]
        ]);
        Yii::app()->end();
    }

    public function actionInventoryStats()
    {
        header('Content-Type: application/json');

        $dateFrom = Yii::app()->request->getPost('dateFrom', date('Y-m-01'));
        $dateTo = Yii::app()->request->getPost('dateTo', date('Y-m-t'));

        $db = Yii::app()->db;

        // 1️⃣ Closing stock & value by date (for trend)
        $closingTrend = $db->createCommand("
    SELECT
        d.report_date AS day,
        ROUND(SUM(
            (SELECT SUM(inv2.stock_in - inv2.stock_out)
             FROM inventory inv2
             WHERE inv2.model_id = inv.model_id
               AND inv2.date <= d.report_date
               AND inv2.is_deleted = 0)
        )) AS qty,
        ROUND(SUM(
            (SELECT SUM((inv2.stock_in - inv2.stock_out) * inv2.purchase_price)
             FROM inventory inv2
             WHERE inv2.model_id = inv.model_id
               AND inv2.date <= d.report_date
               AND inv2.is_deleted = 0)
        )) AS value
    FROM
        (SELECT DISTINCT DATE(inv.date) AS report_date FROM inventory inv
         WHERE inv.date BETWEEN DATE_SUB(:to, INTERVAL 15 DAY) AND :to
           AND inv.is_deleted = 0) d
    JOIN inventory inv ON inv.date <= d.report_date AND inv.is_deleted = 0
    GROUP BY d.report_date
    ORDER BY d.report_date
")->queryAll(true, [':to' => $dateTo]);

        // 2️⃣ Top 10 items by closing value
        $topItems = $db->createCommand("
        SELECT 
            p.model_name,
            (SUM(inv.stock_in) - SUM(inv.stock_out)) AS closing_qty,
            ROUND(AVG(inv.purchase_price), 2) AS avg_price,
            ROUND((SUM(inv.stock_in) - SUM(inv.stock_out)) * AVG(inv.purchase_price)) AS value
        FROM inventory inv
        JOIN prod_models p ON p.id = inv.model_id
        WHERE inv.date <= :to AND inv.is_deleted = 0
        GROUP BY inv.model_id
        HAVING closing_qty > 0
        ORDER BY value DESC
        LIMIT 10
    ")->queryAll(true, [':to' => $dateTo]);

        // 3️⃣ Stock aging buckets
        $aging = $db->createCommand("
        SELECT 
            SUM(CASE WHEN DATEDIFF(:to, inv.date) <= 30 THEN (inv.stock_in - inv.stock_out) ELSE 0 END) AS days_0_30,
            SUM(CASE WHEN DATEDIFF(:to, inv.date) BETWEEN 31 AND 60 THEN (inv.stock_in - inv.stock_out) ELSE 0 END) AS days_31_60,
            SUM(CASE WHEN DATEDIFF(:to, inv.date) BETWEEN 61 AND 90 THEN (inv.stock_in - inv.stock_out) ELSE 0 END) AS days_61_90,
            SUM(CASE WHEN DATEDIFF(:to, inv.date) > 90 THEN (inv.stock_in - inv.stock_out) ELSE 0 END) AS days_90_plus
        FROM inventory inv
        WHERE inv.date <= :to AND inv.is_deleted = 0
    ")->queryRow(true, [':to' => $dateTo]);

        // 4️⃣ Fast vs Slow moving (based on sales movement)
        $movementData = $db->createCommand("
        SELECT 
            model_id,
            SUM(stock_out) AS total_out
        FROM inventory
        WHERE date BETWEEN DATE_SUB(:to, INTERVAL 30 DAY) AND :to
          AND is_deleted = 0
        GROUP BY model_id
    ")->queryAll(true, [':to' => $dateTo]);

        $fast = 0;
        $slow = 0;

        foreach ($movementData as $row) {
            if ($row['total_out'] > 10) {
                $fast++;
            } else {
                $slow++;
            }
        }

        // 5️⃣ Brand-wise stock share
        $brandWise = $db->createCommand("
        SELECT 
            b.brand_name AS brand_name,
            ROUND(SUM((inv.stock_in - inv.stock_out) * inv.purchase_price)) AS value
        FROM inventory inv
        JOIN prod_models p ON p.id = inv.model_id
        LEFT JOIN prod_brands b ON b.id = p.brand_id
        WHERE inv.date <= :to AND inv.is_deleted = 0
        GROUP BY b.brand_name
        ORDER BY value DESC
        LIMIT 10
    ")->queryAll(true, [':to' => $dateTo]);

        echo CJSON::encode([
            'success' => true,
            'data' => [
                'closingTrend' => $closingTrend,
                'topItems' => $topItems,
                'aging' => $aging,
                'fast' => $fast,
                'slow' => $slow,
                'brandWise' => $brandWise,
            ]
        ]);
        Yii::app()->end();
    }




    public function actionHelp()
    {
        if (!Yii::app()->user->isGuest) {
            $this->render('help');
        } else {
            $this->redirect(Yii::app()->createUrl('site/login'));
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionEvent()
    {
        $this->layout = 'column1';
        $this->render('event');
    }

}
