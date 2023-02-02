<?php

class ProductionController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Production();
        $model2 = new ProductionDetails();
        $model3 = new ProductionPerson();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Production'], $_POST['ProductionDetails'], $_POST['ProductionPerson'])) {
            $model->attributes = $_POST['Production'];
            $order = SellOrder::model()->findByPk($model->order_id);
            $model->max_sl_no = Production::maxSlNo();
            $model->order_id = $order->id;
            $model->job_card_no = $order->job_no;
            $model->production_no = date('y') . date('m') . str_pad($model->max_sl_no, 3, "0", STR_PAD_LEFT);
            if ($model->save()) {
                $inv_sl = Inventory::maxSlNo();
                $inv_sl_challan = "PROD-" . str_pad($inv_sl, 6, '0', STR_PAD_LEFT);
                foreach ($_POST['ProductionDetails']['temp_model_id'] as $key => $model_id) {
                    $rem_qty = $_POST['ProductionDetails']['temp_rem_qty'][$key];
                    $issue_qty = $_POST['ProductionDetails']['temp_production_qty'][$key];
                    $model2 = new ProductionDetails();
                    $model2->production_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $issue_qty;
                    $sellPrice = SellPrice::model()->activeSellPriceOnly($model2->id);
                    $sellPrice = $sellPrice > 0 ? $sellPrice : 0;
                    if ($model2->save()) {
                        $inventory = new Inventory();
                        $inventory->sl_no = $inv_sl;
                        $inventory->date = $model->date;
                        $inventory->challan_no = $inv_sl_challan;
                        $inventory->model_id = $model2->model_id;
                        $inventory->stock_in = $model2->qty;
                        $inventory->sell_price = $sellPrice;
                        $inventory->row_total = $sellPrice * $model2->qty;
                        $inventory->stock_status = Inventory::PRODUCTION;
                        $inventory->source_id = $model2->id;
                        if (!$inventory->save()) {
                            var_dump($inventory->getErrors());
                            exit;
                        }
                    } else {
                        var_dump($model2->getErrors());
                        exit;
                    }

                }

                $criteria = new CDbCriteria();
                $criteria->addColumnCondition(['sell_order_id' => $model->order_id]);
                $data = SellOrderDetails::model()->findAll($criteria);
                $pendingItemQty = 0;
                if ($data) {
                    foreach ($data as $dt) {
                        $order_qty = $dt->qty;
                        $issue_qty = ProductionDetails::model()->totalProductionQtyOfThisModelByOrder($dt->model_id, $order->id);
                        $rem_qty = $order_qty - $issue_qty;
                        if (!($rem_qty == 0)) {
                            $pendingItemQty++;
                        }
                    }
                }
                if ($pendingItemQty == 0) {
                    $order->is_all_production_done = SellOrder::PRODUCTION_DONE;
                    $order->save();
                }

                $employees = $_POST['ProductionPerson']['employee_id'];
                if(count($employees) > 0){
                    foreach ($employees as $emp){
                        $productionEmp = new ProductionPerson();
                        $productionEmp->production_id = $model->id;
                        $productionEmp->employee_id = $emp;
                        $productionEmp->save();
                    }
                }
                echo CJSON::encode(array(
                    'status' => 'success',
                    'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $model, 'new' => true), true, true), //
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                $error2 = CActiveForm::validate($model2);
                $error3 = CActiveForm::validate($model3);
                if ($error != '[]')
                    echo $error;
                if ($error2 != '[]')
                    echo $error2;
                Yii::app()->end();
            }
        }

        $this->pageTitle = "PRODUCTION ENTRY";
        $this->render('create', array(
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Production'])) {
            $model->attributes = $_POST['Production'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Production the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Production::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Production('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Production']))
            $model->attributes = $_GET['Production'];

        $this->pageTitle = "PRODUCTION MANAGE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param Production $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'production-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionVoucherPreview()
    {
        $issue_no = isset($_POST['production_no']) ? trim($_POST['production_no']) : "";

        if (strlen($issue_no) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(['production_no' => $issue_no]);
            $data = Production::model()->findByAttributes([], $criteria);
            if ($data) {
                echo $this->renderPartial("voucherPreview", array('data' => $data,), true, true);
            } else {
                header('Content-type: application/json');
                echo CJSON::encode(array(
                    'status' => 'error',
                ));
            }
            Yii::app()->end();
        } else {
            echo '<div class="alert alert-danger" role="alert">Please insert production no!</div>';
        }
    }
}
