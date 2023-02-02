<?php

class SellDeliveryController extends Controller
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
     * @return SellDelivery the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SellDelivery::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionDelivery($id)
    {
        $model = new SellDelivery();
        $model2 = new SellDeliveryDetails();
        $data = SellOrder::model()->findByPk($id);
        if ($data->is_delivery_done == SellOrder::DELIVERY_DONE) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

        if (isset($_POST['SellDelivery'], $_POST['SellDeliveryDetails'], $_POST['SellOrder'])) {

            if ($_POST['SellDelivery']['date'] != '') {
                $model->attributes = $_POST['SellDelivery'];
                $model->sell_order_id = $id;
                $model->customer_id = $data->customer_id;
                $model->grand_total = 0;
                $model->max_sl_no = $sl_no = SellDelivery::maxSlNo();
                $model->delivery_no = "CHALLAN-" . str_pad($sl_no, 6, '0', STR_PAD_LEFT);
                if ($model->save()) {

                    $g_total = 0;
                    $inv_sl = Inventory::maxSlNo();
                    $inv_sl_challan = "CHALLAN-" . str_pad($sl_no, 6, '0', STR_PAD_LEFT);
                    foreach ($_POST['SellDeliveryDetails']['temp_model_id'] as $key => $model_id) {
                        $del_qty = $_POST['SellDeliveryDetails']['temp_del_qty'][$key];
                        $store_id = $_POST['SellDeliveryDetails']['temp_store_id'][$key];
                        $location_id = $_POST['SellDeliveryDetails']['temp_location_id'][$key];
                        $stock_qty = $_POST['SellDeliveryDetails']['temp_stock_qty'][$key];
                        $unit_price = $_POST['SellDeliveryDetails']['temp_unit_price'][$key];

                        if ($del_qty > 0) {
                            $row_total = $unit_price * $del_qty;
                            $g_total += $row_total;
                            $m = new SellDeliveryDetails;
                            $m->sell_delivery_id = $model->id;
                            $m->model_id = $model_id;
                            $m->store_id = $store_id;
                            $m->location_id = $location_id;
                            $m->qty = $del_qty;
                            $m->unit_price = $unit_price;
                            $m->row_total = $row_total;
                            if ($m->save()) {
                                $inventory = new Inventory();
                                $inventory->sl_no = $inv_sl;
                                $inventory->date = $model->date;
                                $inventory->challan_no = $inv_sl_challan;
                                $inventory->store_id = $m->store_id;
                                $inventory->location_id = $m->location_id;
                                $inventory->model_id = $m->model_id;
                                $inventory->stock_out = $m->qty;
                                $inventory->sell_price = $m->unit_price;
                                $inventory->row_total = $m->row_total;
                                $inventory->stock_status = Inventory::SALES_DELIVERY;
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
                        $model->grand_total = $g_total;
                        $model->save();
                    }
                    $criteria = new CDbCriteria();
                    $criteria->addColumnCondition(['sell_order_id' => $id, 'is_delivery_done' => SellOrderDetails::DELIVERY_NOT_DONE]);
                    $orderDetails = SellOrderDetails::model()->findAll($criteria);
                    $all_delivery_done = true;
                    foreach ($orderDetails as $od) {
                        $totalDelivery = SellDeliveryDetails::model()->totalDeliveryQtyOfThisModelByOrder($od->model_id, $id);
                        if ($totalDelivery >= $od->qty) {
                            $od->is_delivery_done = SellOrderDetails::DELIVERY_DONE;
                            $od->save();
                        } else {
                            $all_delivery_done = false;
                        }
                    }
                    if ($all_delivery_done) {
                        $data->is_delivery_done = SellOrder::DELIVERY_DONE;
                    }
                    $data->is_partial_delivery = SellOrder::PARTIAL_DELIVERY_DONE;
                    $data->save();
                    $data2 = SellDelivery::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $data2, 'new' => true), true, true), //
                    ));
                    Yii::app()->end();
                }
            }

        }

        $this->pageTitle = 'SELL DELIVERY';
        $this->render('_formDelivery', array(
            'model' => $model,
            'model2' => $model2,
            'data' => $data,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
//    public function actionDelete($id)
//    {
//        $this->loadModel($id)->delete();
//
//        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//        if (!isset($_GET['ajax']))
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SellDelivery('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SellDelivery']))
            $model->attributes = $_GET['SellDelivery'];

        $this->pageTitle = 'SELL DELIVERY MANAGE';
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminPendingDelivery()
    {
        $model = new SellOrder('searchPendingDelivery');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SellOrder']))
            $model->attributes = $_GET['SellOrder'];

        $this->pageTitle = 'PENDING DELIVERY';
        $this->render('adminPendingDelivery', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param SellDelivery $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sell-delivery-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionVoucherPreview()
    {
        $delivery_no = isset($_POST['delivery_no']) ? trim($_POST['delivery_no']) : "";

        if ($delivery_no != "") {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(['delivery_no' => $delivery_no]);
            $data = SellDelivery::model()->findByAttributes([], $criteria);

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
            echo '<div class="alert alert-danger" role="alert">Please select delivery no!</div>';
        }
    }

}
