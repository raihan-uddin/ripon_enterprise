<?php

class ReportController extends Controller
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

    public function actionCreateCountryFromOutSide()
    {
        $model = new Countries;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Countries'])) {
            $model->attributes = $_POST['Countries'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = $model;
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => '<div class="alert alert-success">
                                      New Country successfully added
                                    </div>',
                        'value' => $data->id,
                        'label' => $data->country,
                    ));
                    exit;
                } else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $resultDiv = '';
            echo CJSON::encode(array(
                'status' => 'failure',
                'resultDiv' => $resultDiv,
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
        } else
            $this->render('create', array('model' => $model,));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'countries-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
            $message .= "<br>  Date: " . date('d-m-Y', strtotime($dateFrom)) . "-" . date('d-m-Y', strtotime($dateTo));

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
                    SELECT id, date, so_no AS order_no, customer_id, grand_total AS amount, 'sale' as trx_type
                    FROM sell_order
                    WHERE date BETWEEN '$dateFrom' AND '$dateTo' " . ($customer_id > 0 ? " AND customer_id = $customer_id" : "") . "
                    UNION
                    SELECT id, date, mr_no AS order_no, customer_id, amount, 'mr'
                    FROM money_receipt
                    WHERE date BETWEEN '$dateFrom' AND '$dateTo' " . ($customer_id > 0 ? " AND customer_id = $customer_id" : "") . "
                ) temp";
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

}
