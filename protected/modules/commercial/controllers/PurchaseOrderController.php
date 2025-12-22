<?php

class PurchaseOrderController extends RController
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
            'rights
            -VoucherPreview',
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

            // Begin transaction
            $transaction = Yii::app()->db->beginTransaction();

            $model->attributes = $_POST['PurchaseOrder'];
            $model->max_sl_no = PurchaseOrder::maxSlNo();
            $model->discount_percentage = 0;
            $model->po_no = "PO" . date('y') . "-" . date('m') . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            $model->is_all_received = PurchaseOrder::ALL_RECEIVED;
            try {
                if (!$model->save()) {
                    // Rollback transaction if an error occurred
                    $transaction->rollback();
                    $error = CActiveForm::validate($model);
                    if ($error != '[]')
                        echo $error;
                    Yii::app()->end();
                }
                $sl_no = Inventory::maxSlNo();
                $challan_no = "PUR-" . str_pad($sl_no, 6, '0', STR_PAD_LEFT);
                foreach ($_POST['PurchaseOrderDetails']['temp_model_id'] as $key => $model_id) {
                    $product = ProdModels::model()->findByPk($model_id);
                    $model2 = new PurchaseOrderDetails();
                    $model2->order_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['PurchaseOrderDetails']['temp_qty'][$key];
                    $model2->unit_price = $_POST['PurchaseOrderDetails']['temp_unit_price'][$key];
                    $model2->row_total = $_POST['PurchaseOrderDetails']['temp_row_total'][$key];
                    $model2->product_sl_no = $_POST['PurchaseOrderDetails']['temp_product_sl_no'][$key];
                    $model2->note = $_POST['PurchaseOrderDetails']['temp_note'][$key];
                    $model2->is_all_received = PurchaseOrder::ALL_RECEIVED;
                    if (!$model2->save()) {
                        //  Rollback transaction if an error occurred
                        $transaction->rollback();
                        throw new Exception('Error in saving Purchase Order Details!');
                    }
                    $inv = new Inventory();
                    $inv->model_id = $model_id;
                    $inv->date = $model->date;
                    $inv->sl_no = $sl_no;
                    $inv->challan_no = $challan_no;
                    $inv->store_id = $model->store_id;
                    $inv->location_id = $model->location_id;
                    $inv->stock_in = $model2->qty;
                    $inv->sell_price = $product->sell_price;
                    $inv->purchase_price = $model2->unit_price;
                    $inv->row_total = $model2->row_total;
                    $inv->product_sl_no = $model2->product_sl_no;
                    $inv->stock_status = Inventory::PURCHASE_RECEIVE;
                    $inv->source_id = $model2->id;
                    $inv->master_id = $model->id;
                    $inv->remarks = $model2->note;
                    if (!$inv->save()) {
                        // Rollback transaction if an error occurred
                        $transaction->rollback();
                        throw new Exception('Error in saving Inventory!');
                    }
                }

                if ($model->cash_due == Lookup::CASH) {
                    $model->is_paid = PurchaseOrder::PAID;
                    if (!$model->save()) {
                        // Rollback transaction if an error occurred
                        $transaction->rollback();
                        throw new Exception('Error in saving Purchase Order paid/due!');
                    }

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
                        // Rollback transaction if an error occurred
                        $transaction->rollback();
                        throw new Exception('Error in saving Payment Receipt!');
                    }
                }
                $transaction->commit();
                $data = $model;
                echo CJSON::encode(array(
                    'status' => 'success',
                    'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $data, 'new' => true), true, true), //
                ));
                Yii::app()->end();
            } catch (Exception $e) {
                // Rollback transaction if an error occurred
                $transaction->rollback();

                // Return JSON response with error message
                echo CJSON::encode(array(
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ));
            }

        }
        $this->pageTitle = 'CREATE PO';
        $this->render('_form', array(
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
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
        }
        if (isset($_POST['PurchaseOrder'], $_POST['PurchaseOrderDetails'])) {
            $currentInvoiceValue = $_POST['PurchaseOrder']['grand_total'];
            /*$currentInvoicePaid = PaymentReceipt::model()->totalPaidAmountOfThisOrder($id);
            if ($currentInvoiceValue < $currentInvoicePaid) {
                $message = 'The total amount paid (BDT' . $currentInvoicePaid . ') is greater than the invoice total (BDT' . $currentInvoiceValue . '). Please review your payment details.';
                echo CJSON::encode(array(
                    'status' => 'error',
                    'message' => $message,
                ));
                Yii::app()->end();
            }
            if ($currentInvoicePaid >= $currentInvoiceValue) {
                $model->is_paid = PurchaseOrder::PAID;
            } else {
                $model->is_paid = PurchaseOrder::DUE;
            }
            */
            $model->attributes = $_POST['PurchaseOrder'];
            // Begin transaction
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!$model->save()) {
                    // Rollback transaction if an error occurred
                    $transaction->rollback();
                    $error = CActiveForm::validate($model);
                    if ($error != '[]')
                        echo $error;
                    Yii::app()->end();
                }
                
                // now delete all the previous data of this order from PurchaseOrderDetails table & Inventory table
                // $detailsDelete = PurchaseOrderDetails::model()->deleteAll(['order_id' => $id]);
                $detailsDelete = PurchaseOrderDetails::model()->deleteAll('order_id = :order_id', [':order_id' => $id]);

                if ($detailsDelete == 0) {
                    // Rollback transaction if an error occurred
                    $transaction->rollback();
                    throw new Exception('Error in deleting Purchase Order Details!');
                }
                $dataInvDelete = Inventory::model()->deleteAll('master_id = :master_id AND stock_status = :stock_status', [':master_id' => $id, ':stock_status' => Inventory::PURCHASE_RECEIVE]);
                // $dataInvDelete = Inventory::model()->deleteAll(['master_id' => $id, 'stock_status' => Inventory::PURCHASE_RECEIVE]);
                if ($dataInvDelete == 0) {
                    // Rollback transaction if an error occurred
                    $transaction->rollback();
                    throw new Exception('Error in deleting Inventory!');
                }
                

                $sl_no = Inventory::maxSlNo();
                $challan_no = "PUR-" . str_pad($sl_no, 6, '0', STR_PAD_LEFT);
                foreach ($_POST['PurchaseOrderDetails']['temp_model_id'] as $key => $model_id) {
                    $product = ProdModels::model()->findByPk($model_id);
                    $product_sl_no = $_POST['PurchaseOrderDetails']['temp_product_sl_no'][$key];
                    
                    $model2 = new PurchaseOrderDetails();
                    $model2->order_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['PurchaseOrderDetails']['temp_qty'][$key];
                    $model2->product_sl_no = $product_sl_no;
                    $model2->unit_price = $_POST['PurchaseOrderDetails']['temp_unit_price'][$key];
                    $model2->row_total = $_POST['PurchaseOrderDetails']['temp_row_total'][$key];
                    $model2->note = $_POST['PurchaseOrderDetails']['temp_note'][$key];
                    if (!$model2->save()) {
                        // get validation errors
                        $errors = $model2->getErrors();
                        // log or display the errors for debugging
                        Yii::log(CVarDumper::dumpAsString($errors), CLogger::LEVEL_ERROR, 'application');
                        // Rollback transaction if an error occurred
                        $transaction->rollback();
                        throw new Exception('Error in saving Purchase Order Details:' . CVarDumper::dumpAsString($errors));
                    }
                    
                    $inv = new Inventory();
                    $challan_no = $challan_no;
                    $sl_no = $sl_no;
                    $inv->model_id = $model_id;
                    $inv->date = $model->date;
                    $inv->sl_no = $sl_no;
                    $inv->challan_no = $challan_no;
                    $inv->store_id = $model->store_id;
                    $inv->location_id = $model->location_id;
                    $inv->stock_in = $model2->qty;
                    $inv->sell_price = $product->sell_price;
                    $inv->row_total = $model2->row_total;
                    $inv->purchase_price = $model2->unit_price;
                    $inv->product_sl_no = $model2->product_sl_no;
                    $inv->stock_status = Inventory::PURCHASE_RECEIVE;
                    $inv->source_id = $model2->id;
                    $inv->master_id = $model->id;
                    $inv->remarks = $model2->note;
                    if(!$inv->save()){
                        // Get validation errors
                        $errors = $inv->getErrors();
                        // Log or display the errors for debugging
                        Yii::log(CVarDumper::dumpAsString($errors), CLogger::LEVEL_ERROR, 'application');
                        // Rollback transaction if an error occurred
                        $transaction->rollback();
                        throw new Exception('Error in saving Inventory:' . CVarDumper::dumpAsString($errors));
                    }
                }                

                $transaction->commit();

                echo CJSON::encode(array(
                    'status' => 'success',
                    'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $model, 'new' => true), true, true), //
                ));
                Yii::app()->end();

            } catch (Exception $e) {
                // Rollback transaction if an error occurred
                $transaction->rollback();
                throw new Exception('fucking Details!');

                // Return JSON response with error message
                echo CJSON::encode(array(
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ));
            }
        }


        $criteria = new CDbCriteria();
        $criteria->select = "t.*, pm.model_name, pm.code";
        $criteria->addColumnCondition(['order_id' => $id]);
        $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
        $criteria->order = "pm.model_name ASC";
        $data = PurchaseOrderDetails::model()->findAll($criteria);

        $this->pageTitle = 'UPDATE ORDER';
        $this->render('update', array(
            'model' => $model,
            'model2' => $model2,
            'model3' => $data,
        ));
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
        $pr = PaymentReceipt::model()->findAllByAttributes(['supplier_id' => $model->supplier_id, 'order_id' => $id]);
        $inv = Inventory::model()->findAllByAttributes(['master_id' => $id, 'stock_status' => Inventory::PURCHASE_RECEIVE]);
        // need to delete all the PaymentReceipt & Inventory also use db transaction & try catch
        // Begin transaction
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($pr as $p) {
                $p->delete();
            }
            foreach ($inv as $i) {
                $i->delete();
            }
            $model->delete();

            $transaction->commit();
        } catch (Exception $e) {
            // Rollback transaction if an error occurred
            $transaction->rollback();
        }

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
        $invoiceId = isset($_POST['invoiceId']) ? trim($_POST['invoiceId']) : "";

        if ($po_no != "" || $invoiceId > 0) {
            $criteria = new CDbCriteria;
            if ($invoiceId != "")
                $criteria->addColumnCondition(['id' => $invoiceId]);
            else
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
