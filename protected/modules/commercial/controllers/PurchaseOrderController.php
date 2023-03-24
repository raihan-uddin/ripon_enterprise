<?php

class PurchaseOrderController extends Controller
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
        $model = new PurchaseOrder();
        $model2 = new PurchaseOrderDetails();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        if (isset($_POST['PurchaseOrder'], $_POST['PurchaseOrderDetails'])) {
            $model->attributes = $_POST['PurchaseOrder'];
            $model->max_sl_no = PurchaseOrder::maxSlNo();
            $model->discount_percentage = 0;
            $model->po_no = "PO-" . date('y') . "-" . date('m') . "-" . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            if ($model->order_type == PurchaseOrder::PURCHASE_RECEIVE) {
                $model->is_all_received = PurchaseOrder::ALL_RECEIVED;
            }
            if ($model->save()) {
                $rcv_id = $challan_no = $sl_no = NULL;
                if ($model->order_type == PurchaseOrder::PURCHASE_RECEIVE) {
                    $rcv_max_sl_no = ReceivePurchase::maxSlNo();
                    $modelRcv = new ReceivePurchase();
                    $modelRcv->max_sl_no = $rcv_max_sl_no;
                    $modelRcv->receive_no = "RCV-" . date('y') . "-" . date('m') . "-" . str_pad($modelRcv->max_sl_no, 5, "0", STR_PAD_LEFT);
                    $modelRcv->date = $model->date;
                    $modelRcv->supplier_id = $model->supplier_id;
                    $modelRcv->purchase_order_id = $model->id;
                    $modelRcv->rcv_amount = $model->grand_total;
                    if ($modelRcv->save()) {
                        $rcv_id = $modelRcv->id;
                        $sl_no = Inventory::maxSlNo();
                        $challan_no = "RCV-" . str_pad($sl_no, 6, '0', STR_PAD_LEFT);
                    }
                }
                foreach ($_POST['PurchaseOrderDetails']['temp_model_id'] as $key => $model_id) {
                    $model2 = new PurchaseOrderDetails();
                    $model2->order_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['PurchaseOrderDetails']['temp_qty'][$key];
                    $model2->unit_price = $_POST['PurchaseOrderDetails']['temp_unit_price'][$key];
                    $model2->row_total = $_POST['PurchaseOrderDetails']['temp_row_total'][$key];
                    $model2->product_sl_no = $_POST['PurchaseOrderDetails']['temp_product_sl_no'][$key];
                    $model2->note = $_POST['PurchaseOrderDetails']['temp_note'][$key];
                    if ($model->order_type == PurchaseOrder::PURCHASE_RECEIVE) {
                        $model2->is_all_received = PurchaseOrder::ALL_RECEIVED;
                    }
                    if ($model2->save()) {
                        if ($rcv_id > 0) {
                            $modelRcvD = new ReceivePurchaseDetails();
                            $modelRcvD->receive_purchase_id = $rcv_id;
                            $modelRcvD->model_id = $model_id;
                            $modelRcvD->unit_price = $model2->unit_price;
                            $modelRcvD->qty = $model2->qty;
                            $modelRcvD->row_total = $model2->row_total;
                            $modelRcvD->product_sl_no = $model2->product_sl_no;
                            if ($modelRcvD->save()) {

                                $inv = new Inventory();
                                $inv->model_id = $model_id;
                                $inv->date = $model->date;
                                $inv->sl_no = $sl_no;
                                $inv->challan_no = $challan_no;
                                $inv->store_id = $model->store_id;
                                $inv->location_id = $model->location_id;
                                $inv->stock_in = $model2->qty;
                                $inv->sell_price = $model2->unit_price;
                                $inv->row_total = $model2->row_total;
                                $inv->purchase_price = $model2->unit_price;
                                $inv->product_sl_no = $model2->product_sl_no;
                                $inv->stock_status = Inventory::PURCHASE_RECEIVE;
                                $inv->source_id = $modelRcvD->id;
                                $inv->master_id = $model->id;
                                $inv->remarks = $model2->note;
                                $inv->save();
                            }
                        }
                    } else {
                        var_dump($model2->getErrors());
                        exit;
                    }
                }

                if ($model->cash_due == Lookup::CASH) {
                    $model->is_paid = PurchaseOrder::PAID;
                    $model->save();
                    $payment = new PaymentReceipt();
                    $payment->date = $model->date;
                    $payment->payment_type = PaymentReceipt::CASH;
                    $payment->supplier_id = $model->supplier_id;
                    $payment->order_id = $model->id;
                    $payment->max_sl_no = PaymentReceipt::maxSlNo();
                    $payment->pr_no = "PR-" . date('y') . "-" . date('m') . "-" . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
                    $payment->payment_type = Lookup::PAYMENT_CASH;
                    $payment->amount = $model->grand_total;
                    if (!$payment->save()) {
                        var_dump($payment->getErrors());
                        exit;
                    }
                }
                if ($model->order_type == PurchaseOrder::PURCHASE_RECEIVE) {
                    $model->is_all_received = PurchaseOrder::ALL_RECEIVED;
                    $model->save();
                }
                $data = $model;
                echo CJSON::encode(array(
                    'status' => 'success',
                    'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $data, 'new' => true), true, true), //
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        }
        $this->pageTitle = 'CREATE PO';
        $this->render('create', array(
            'model' => $model,
            'model2' => $model2,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param PurchaseOrder $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'purchase-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model2 = new PurchaseOrderDetails();
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }
        if (isset($_POST['PurchaseOrder'], $_POST['PurchaseOrderDetails'])) {
            $model->attributes = $_POST['PurchaseOrder'];
            if ($model->save()) {
                $details_id_arr = [];
                foreach ($_POST['PurchaseOrderDetails']['temp_model_id'] as $key => $model_id) {
                    $product_sl_no = $_POST['PurchaseOrderDetails']['temp_product_sl_no'][$key];
                    $criteria = new CDbCriteria();
                    $criteria->addColumnCondition(['order_id' => $id, 'model_id' => $model_id]);
                    if (strlen(($product_sl_no)) > 0) {
                        $criteria->addColumnCondition(['product_sl_no' => $product_sl_no]);
                    }
                    $model2 = PurchaseOrderDetails::model()->findByAttributes([], $criteria);
                    if (!$model2)
                        $model2 = new PurchaseOrderDetails();
                    $model2->order_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['PurchaseOrderDetails']['temp_qty'][$key];
                    $model2->product_sl_no = $product_sl_no;
                    $model2->unit_price = $_POST['PurchaseOrderDetails']['temp_unit_price'][$key];
                    $model2->row_total = $_POST['PurchaseOrderDetails']['temp_row_total'][$key];
                    $model2->note = $_POST['PurchaseOrderDetails']['temp_note'][$key];
                    if (!$model2->save()) {
                        var_dump($model2->getErrors());
                        exit;
                    }
                    $details_id_arr[] = $model2->id;
                }
                if (count($details_id_arr) > 0) {
                    $criteriaDel = new CDbCriteria;
                    $criteriaDel->addNotInCondition('id', $details_id_arr);
                    $criteriaDel->addColumnCondition(['order_id' => $id]);
                    PurchaseOrderDetails::model()->deleteAll($criteriaDel);
                }
                echo CJSON::encode(array(
                    'status' => 'success',
                    'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $model, 'new' => true), true, true), //
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        }

        $pr = PaymentReceipt::model()->findByAttributes(['supplier_id' => $model->supplier_id, 'order_id' => $id]);
        $rcv = ReceivePurchase::model()->findByAttributes(['purchase_order_id' => $id]);
        if (!$pr && !$rcv && $model->cash_due == Lookup::DUE) {

            $criteria = new CDbCriteria();
            $criteria->select = "t.*, pm.model_name, pm.code";
            $criteria->addColumnCondition(['order_id' => $id]);
            $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
            $criteria->order = "pm.model_name ASC";
            $this->pageTitle = 'UPDATE ORDER';
            $this->render('update', array(
                'model' => $model,
                'model2' => $model2,
                'model3' => PurchaseOrderDetails::model()->findAll($criteria),
            ));
        } else {
            $status = ['status' => 'danger', 'message' => 'You can not update this order(' . $model->po_no . ') now!'];
            Yii::app()->user->setFlash($status['status'], $status['message']);
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PurchaseOrder the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = PurchaseOrder::model()->findByPk($id);
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
        $model = $this->loadModel($id);
        $pr = PaymentReceipt::model()->findByAttributes(['supplier_id' => $model->supplier_id, 'order_id' => $id]);
        $rcv = ReceivePurchase::model()->findByAttributes(['purchase_order_id' => $id]);
        if (!$pr && !$rcv)
            $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new PurchaseOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseOrder']))
            $model->attributes = $_GET['PurchaseOrder'];

        $this->pageTitle = "PURCHASE ORDER";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionVoucherPreview()
    {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }
        $po_no = isset($_POST['po_no']) ? trim($_POST['po_no']) : "";

        if ($po_no != "") {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(['po_no' => $po_no]);
            $data = PurchaseOrder::model()->findByAttributes([], $criteria);


            if ($data) {
                echo $this->renderPartial('voucherPreview', array('data' => $data,), true, true);
            } else {
                header('Content-type: application/json');
                echo CJSON::encode(array(
                    'status' => 'error',
                ));
            }
            Yii::app()->end();
        } else {
            echo '<div class="alert alert-danger" role="alert">Please select PO no!</div>';
        }
    }
}
