<?php

class ReceivePurchaseController extends Controller
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
        $model = new ReceivePurchase('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ReceivePurchase']))
            $model->attributes = $_GET['ReceivePurchase'];

        $this->pageTitle = "RECEIVE PURCHASE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Manages all models.
     */
    public function actionAdminPendingReceive()
    {
        $model = new PurchaseOrder('searchPendingReceive');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PurchaseOrder']))
            $model->attributes = $_GET['PurchaseOrder'];

        $this->pageTitle = "PENDING RECEIVE";
        $this->render('adminPendingReceive', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ReceivePurchase the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ReceivePurchase::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ReceivePurchase $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'receive-purchase-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionReceive($id)
    {
        $model = new ReceivePurchase();
        $model2 = new ReceivePurchaseDetails();
        $data = PurchaseOrder::model()->findByPk($id);
        if ($data->is_all_received == PurchaseOrder::ALL_RECEIVED) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

        if (isset($_POST['ReceivePurchase'], $_POST['ReceivePurchaseDetails'], $_POST['PurchaseOrder'])) {

            if ($_POST['ReceivePurchase']['date'] != '') {
                $model->attributes = $_POST['ReceivePurchase'];
                $model->purchase_order_id = $id;
                $model->supplier_id = $data->supplier_id;
                $model->rcv_amount = 0;
                $model->max_sl_no = $sl_no = SellOrder::maxSlNo();
                $model->receive_no = "RCV-" . date('y') . "-" . date('m') . "-" . str_pad($sl_no, 5, "0", STR_PAD_LEFT);
                if ($model->save()) {

                    $g_total = 0;
                    $inv_sl = Inventory::maxSlNo();
                    $inv_sl_challan = "CHALLAN-" . str_pad($sl_no, 6, '0', STR_PAD_LEFT);
                    foreach ($_POST['ReceivePurchaseDetails']['temp_model_id'] as $key => $model_id) {
                        $rcv_qty = $_POST['ReceivePurchaseDetails']['temp_rcv_qty'][$key];
                        $unit_price = $_POST['ReceivePurchaseDetails']['temp_unit_price'][$key];
                        $product_sl_no = $_POST['ReceivePurchaseDetails']['temp_product_sl_no'][$key];

                        if ($rcv_qty > 0) {
                            $row_total = $unit_price * $rcv_qty;
                            $g_total += $row_total;
                            $m = new ReceivePurchaseDetails;
                            $m->receive_purchase_id = $model->id;
                            $m->model_id = $model_id;
                            $m->qty = $rcv_qty;
                            $m->unit_price = $unit_price;
                            $m->row_total = $row_total;
                            $m->product_sl_no = $product_sl_no;
                            if ($m->save()) {
                                $inventory = new Inventory();
                                $inventory->sl_no = $inv_sl;
                                $inventory->date = $model->date;
                                $inventory->challan_no = $inv_sl_challan;
                                $inventory->model_id = $m->model_id;
                                $inventory->stock_in = $m->qty;
                                $inventory->purchase_price = $m->unit_price;
                                $inventory->sell_price = $m->unit_price;
                                $inventory->row_total = $m->row_total;
                                $inventory->product_sl_no = $m->product_sl_no;
                                $inventory->stock_status = Inventory::PURCHASE_RECEIVE;
                                $inventory->source_id = $m->id;
                                if (!$inventory->save()) {
                                    var_dump($inventory->getErrors());
                                    exit;
                                }
                            } else {
                                var_dump($m->getErrors());
                                exit;
                            }
                        }
                        $model->rcv_amount = $g_total;
                        $model->save();
                    }
                    $criteria = new CDbCriteria();
                    $criteria->addColumnCondition(['order_id' => $id]);
                    $orderDetails = PurchaseOrderDetails::model()->findAll($criteria);
                    $all_delivery_done = true;
                    foreach ($orderDetails as $od) {
                        $totalRcv = ReceivePurchaseDetails::model()->totalReceiveQtyOfThisModelByOrder($od->model_id, $id, $od->product_sl_no);
                        $rem = $od->qty - $totalRcv;
                        if ($rem > 0) {
                            $all_delivery_done = false;
                            break;
                        }
                    }
                    if ($all_delivery_done) {
                        $data->is_all_received = PurchaseOrder::ALL_RECEIVED;
                    }
                    $data->save();
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $model, 'new' => true), true, true), //
                    ));
                    Yii::app()->end();
                }
            }

        }

        $this->pageTitle = 'PURCHASE RECEIVE';
        $this->render('_formReceive', array(
            'model' => $model,
            'model2' => $model2,
            'data' => $data,
        ));
    }

    public function actionVoucherPreview()
    {
        $rcv_no = isset($_POST['rcv_no']) ? trim($_POST['rcv_no']) : "";

        if ($rcv_no != "") {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(['receive_no' => $rcv_no]);
            $data = ReceivePurchase::model()->findByAttributes([], $criteria);

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
            echo '<div class="alert alert-danger" role="alert">Please select RCV no!</div>';
        }
    }
}
