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
