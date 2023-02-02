<?php

class InvoiceController extends Controller
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Invoice the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Invoice::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Creates a new model..
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Invoice;
        $model2 = new InvoiceDetails();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Invoice'], $_POST['InvoiceDetails'])) {
            $model->attributes = $_POST['Invoice'];
            $order = SellOrder::model()->findByPk($model->order_id);
            $model->max_sl_no = Invoice::maxSlNo();
            $model->invoice_no = "INV-" . date('y') . "-" . date('m') . "-" . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            if ($model->save()) {
                foreach ($_POST['InvoiceDetails']['temp_model_id'] as $key => $model_id) {
                    $color = $_POST['InvoiceDetails']['temp_color'][$key];
                    $note = $_POST['InvoiceDetails']['temp_note'][$key];
                    $order_qty = $_POST['InvoiceDetails']['temp_order_qty'][$key];
                    $rem_qty = $_POST['InvoiceDetails']['temp_rem_qty'][$key];
                    $bill_qty = $_POST['InvoiceDetails']['temp_bill_qty'][$key];
                    $unit_price = $_POST['InvoiceDetails']['temp_unit_price'][$key];
                    $row_total = $_POST['InvoiceDetails']['temp_row_total'][$key];

                    $model2 = new InvoiceDetails();
                    $model2->invoice_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->color = $color;
                    $model2->note = $note;
                    $model2->qty = $bill_qty;
                    $model2->unit_price = $unit_price;
                    $model2->row_total = $row_total;
                    if (!$model2->save()) {
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
                        $billQty = InvoiceDetails::model()->totalInvoiceQtyOfThisModelByOrder($dt->model_id, $model->id);
                        $rem_qty = $order_qty - $billQty;
                        if ($rem_qty == 0) {
                            $dt->is_invoice_done = SellOrder::INVOICE_DONE;
                            $dt->save();
                        } else {
                            $pendingItemQty++;
                        }
                    }
                }
                if ($pendingItemQty == 0) {
                    $order->is_invoice_done = SellOrder::INVOICE_DONE;
                }
                $order->is_partial_invoice = SellOrder::PARTIAL_INVOICE_DONE;
                $order->save();
                echo CJSON::encode(array(
                    'status' => 'success',
                    'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $model, 'new' => true), true, true), //
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                $error2 = CActiveForm::validate($model2);
                if ($error != '[]')
                    echo $error;
                if ($error2 != '[]')
                    echo $error2;
                Yii::app()->end();
            }
        }

        $this->pageTitle = "CREATE INVOICE";
        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['Invoice'])) {
            $model->attributes = $_POST['Invoice'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
        $model = new Invoice('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Invoice']))
            $model->attributes = $_GET['Invoice'];

        $this->pageTitle = "INVOICE MANAGE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param Invoice $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'invoice-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionVoucherPreview()
    {
        $invoice_no = isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : "";

        if (strlen($invoice_no) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(['invoice_no' => $invoice_no]);
            $data = Invoice::model()->findByAttributes([], $criteria);
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
            echo '<div class="alert alert-danger" role="alert">Please select  invoice no!</div>';
        }
    }

}
