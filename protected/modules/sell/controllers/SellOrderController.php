<?php

class SellOrderController extends Controller
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
            -SoDetails
            -JobCardDetails
            -ProductionDetails',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    public function allowedActions()
    {
        return '';
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SellOrder the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SellOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new SellOrder;
        $model2 = new SellOrderDetails();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        if (isset($_POST['SellOrder'], $_POST['SellOrderDetails'])) {
            $model->attributes = $_POST['SellOrder'];
            $model->max_sl_no = SellOrder::maxSlNo();
            $model->discount_percentage = 0;
            $model->is_invoice_done = SellOrder::INVOICE_NOT_DONE;
            $model->is_delivery_done = SellOrder::DELIVERY_DONE;
            $model->is_job_card_done = SellOrder::JOB_CARD_NOT_DONE;
            $model->is_partial_invoice = SellOrder::PARTIAL_INVOICE_NOT_DONE;
            $model->is_partial_delivery = SellOrder::PARTIAL_DELIVERY_NOT_DONE;
            $model->bom_complete = SellOrder::BOM_NOT_COMPLETE;
            $model->total_due = $_POST['SellOrder']['grand_total'];
            $model->so_no = date('y') . date('m') . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            $inv_sl = Inventory::maxSlNo();
            if ($model->save()) {
                foreach ($_POST['SellOrderDetails']['temp_model_id'] as $key => $model_id) {
                    $model2 = new SellOrderDetails();
                    $model2->sell_order_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['SellOrderDetails']['temp_qty'][$key];
                    $model2->warranty = $_POST['SellOrderDetails']['temp_warranty'][$key];
                    $model2->amount = $_POST['SellOrderDetails']['temp_unit_price'][$key];
                    $model2->product_sl_no = $_POST['SellOrderDetails']['temp_product_sl_no'][$key];
                    $model2->row_total = $_POST['SellOrderDetails']['temp_row_total'][$key];
                    $model2->color = $_POST['SellOrderDetails']['temp_color'][$key];
                    $model2->note = $_POST['SellOrderDetails']['temp_note'][$key];
                    if (!$model2->save()) {
                        var_dump($model2->getErrors());
                        exit;
                    } else {
                        if ($model->order_type == SellOrder::NEW_ORDER) {
                            $inventory = new Inventory();
                            $inventory->sl_no = $inv_sl;
                            $inventory->date = $model->date;
                            $inventory->challan_no = $model->so_no;
                            $inventory->store_id = 1;
                            $inventory->location_id = 1;
                            $inventory->model_id = $model2->model_id;
                            $inventory->stock_out = $model2->qty;
                            $inventory->sell_price = $model2->amount;
                            $inventory->row_total = $model2->row_total;
                            $inventory->product_sl_no = $model2->product_sl_no;
                            $inventory->stock_status = Inventory::SALES_DELIVERY;
                            $inventory->source_id = $model2->id;
                            $inventory->master_id = $model->id;
                            if (!$inventory->save()) {
                                var_dump($inventory->getErrors());
                                exit;
                            }
                        }
                    }
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
        $this->pageTitle = 'CREATE ORDER';
        $this->render('create', array(
            'model' => $model,
            'model2' => $model2,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param SellOrder $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sell-order-form') {
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
        $model2 = new SellOrderDetails();

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        if (isset($_POST['SellOrder'], $_POST['SellOrderDetails'])) {
            $model->attributes = $_POST['SellOrder'];
            $model->discount_percentage = 0;
            $model->discount_amount = 0;
            $model->is_invoice_done = SellOrder::INVOICE_DONE;
            $model->is_delivery_done = SellOrder::DELIVERY_DONE;
            $model->is_job_card_done = SellOrder::JOB_CARD_DONE;
            $model->is_partial_invoice = SellOrder::PARTIAL_INVOICE_DONE;
            $model->is_partial_delivery = SellOrder::PARTIAL_DELIVERY_DONE;
            $model->bom_complete = SellOrder::BOM_COMPLETE;
            $model->total_due = $_POST['SellOrder']['grand_total'] - $model->total_paid;
            if ($model->save()) {
                $details_id_arr = [];
                foreach ($_POST['SellOrderDetails']['temp_model_id'] as $key => $model_id) {
                    $product_sl_no = $_POST['SellOrderDetails']['temp_product_sl_no'][$key];
                    $model2 = SellOrderDetails::model()->findByAttributes(['model_id' => $model_id, 'sell_order_id' => $model->id, 'product_sl_no' => $product_sl_no]);
                    if (!$model2)
                        $model2 = new SellOrderDetails();
                    $model2->sell_order_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['SellOrderDetails']['temp_qty'][$key];
                    $model2->amount = $_POST['SellOrderDetails']['temp_unit_price'][$key];
                    $model2->row_total = $_POST['SellOrderDetails']['temp_row_total'][$key];
                    $model2->color = $_POST['SellOrderDetails']['temp_color'][$key];
                    $model2->note = $_POST['SellOrderDetails']['temp_note'][$key];
                    $model2->product_sl_no = $product_sl_no;
                    if (!$model2->save()) {
                        var_dump($model2->getErrors());
                        exit;
                    }
                    $details_id_arr[] = $model2->id;
                }
                if (count($details_id_arr) > 0) {
                    $criteriaDel = new CDbCriteria;
                    $criteriaDel->addNotInCondition('id', $details_id_arr);
                    $criteriaDel->addColumnCondition(['sell_order_id' => $id]);
                    SellOrderDetails::model()->deleteAll($criteriaDel);
                }

                $delete_inv_arr = [];
                $criteria2 = new CDbCriteria();
                $criteria2->addColumnCondition(['sell_order_id' => $id]);
                $sellOrderDetails = SellOrderDetails::model()->findAll($criteria2);

//                echo count($sellOrderDetails);exit;
                $inv_sl = Inventory::maxSlNo();
                foreach ($sellOrderDetails as $detail) {
                    $inventory = Inventory::model()->findByAttributes(['model_id' => $detail->model_id, 'stock_status' => Inventory::SALES_DELIVERY, 'source_id' => $detail->id, 'product_sl_no' => $detail->product_sl_no]);
                    if (!$inventory) {
                        $inventory = new Inventory();
                        $inventory->sl_no = $inv_sl;
                        $inventory->date = $model->date;
                        $inventory->challan_no = $model->so_no;
                        $inventory->store_id = 1;
                        $inventory->location_id = 1;
                        $inventory->model_id = $detail->model_id;
                        $inventory->stock_out = $detail->qty;
                        $inventory->sell_price = $detail->amount;
                        $inventory->row_total = $detail->row_total;
                        $inventory->product_sl_no = $detail->product_sl_no;
                        $inventory->stock_status = Inventory::SALES_DELIVERY;
                        $inventory->source_id = $detail->id;
                        $inventory->master_id = $id;
                        if (!$inventory->save()) {
                            var_dump($inventory->getErrors());
                            exit;
                        }
                    }
                    $delete_inv_arr[] = $inventory->id;
                }
                if (count($delete_inv_arr) > 0) {
                    $criteriaDel = new CDbCriteria;
                    $criteriaDel->addNotInCondition('id', $delete_inv_arr);
                    $criteriaDel->addColumnCondition(['master_id' => $id, 'stock_status' => Inventory::SALES_DELIVERY]);
                    Inventory::model()->deleteAll($criteriaDel);
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

//        if ($model->total_paid == 0) {

            $criteria = new CDbCriteria();
            $criteria->select = "t.*, pm.model_name, pm.code";
            $criteria->addColumnCondition(['sell_order_id' => $id]);
        $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
        $criteria->order = "pm.model_name ASC, t.product_sl_no ASC";
        $this->pageTitle = 'UPDATE ORDER';
            $this->render('update', array(
                'model' => $model,
                'model2' => $model2,
                'model3' => SellOrderDetails::model()->findAll($criteria),
            ));
        /* } else {
             $status = ['status' => 'danger', 'message' => 'You can not update this order(' . $model->so_no . ') now!'];
             Yii::app()->user->setFlash($status['status'], $status['message']);
             $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
         }*/
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {

        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(['sell_order_id' => $id]);
        $sellOrderDetail = SellOrderDetails::model()->findAll($criteria);
        if ($sellOrderDetail) {
            foreach ($sellOrderDetail as $item) {
                $inventory = Inventory::model()->findByAttributes(['source_id' => $item->id, 'stock_status' => Inventory::SALES_DELIVERY]); // 'master_id' => $id,
                if ($inventory) {
                    $inventory->delete();
                }
                $item->delete();
            }
            $this->loadModel($id)->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SellOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SellOrder']))
            $model->attributes = $_GET['SellOrder'];

        $this->pageTitle = 'SELL ORDER MANAGE';
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    public function actionVoucherPreview()
    {
        $so_no = isset($_POST['so_no']) ? trim($_POST['so_no']) : "";
        $preview_type = isset($_POST['preview_type']) ? trim($_POST['preview_type']) : 0;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        if ($so_no && $preview_type > 0) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(['so_no' => $so_no]);
            $data = SellOrder::model()->findByAttributes([], $criteria);

            if ($data) {
                echo $this->renderPartial("voucherPreview", array('data' => $data, 'preview_type' => $preview_type), true, true);
            } else {
                header('Content-type: application/json');
                echo CJSON::encode(array(
                    'status' => 'error',
                ));
            }
            Yii::app()->end();
        } else {
            echo '<div class="alert alert-danger" role="alert">Please select sales invoice no!</div>';
        }
    }


    public function actionSinglePreview($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
//            Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui-i18n.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui-timepicker-addon.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        }
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(['id' => $id]);
        $data = SellOrder::model()->findByAttributes([], $criteria);
        echo $this->renderPartial('voucherPreview', array('data' => $data, 'preview_type' => SellOrder::NORMAL_ORDER_PRINT), true, true);

        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }

    }


    public function actionSoDetails()
    {
        $so_no = trim($_POST['so_no']);
        $status = 404;
        $order_item_status = 405;
        $message = 'Order not found!';
        $data = NULL;
        $order_items = [];
        $order_info = [];
        if (strlen($so_no) > 0) {
            $criteria = new CDbCriteria();
            $criteria->select = "t.*, c.company_name, c.customer_code";
            $criteria->join = " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->addColumnCondition(['so_no' => $so_no]);
            $data = SellOrder::model()->findByAttributes([], $criteria);
            if ($data) {
                $order_info = [
                    'order_id' => $data->id,
                    'customer_id' => $data->customer_id,
                    'customer_name' => $data->company_name,
                    'customer_code' => $data->customer_code,
                    'so_no' => $data->so_no,
                    'date' => $data->date,
                ];
                $status = 200;
                $message = 'Order found!';
                $criteria2 = new CDbCriteria();
                $criteria2->select = "t.*, pm.model_name, pm.unit_id, pm.code ";
                $criteria2->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
                $criteria2->addColumnCondition(['sell_order_id' => $data->id]);
                $orderDetails = SellOrderDetails::model()->findAll($criteria2);
                if ($orderDetails) {
                    foreach ($orderDetails as $od) {
                        $order_qty = $od->qty;
                        $total_invoice_qty = InvoiceDetails::model()->totalInvoiceQtyOfThisModelByOrder($od->model_id, $data->id);
                        $rem_qty = $order_qty - $total_invoice_qty;
                        if ($rem_qty > 0) {
                            $order_item_status = 200;
                            $order_items[] = [
                                'model_name' => $od->model_name,
                                'code' => $od->code,
                                'model_id' => $od->model_id,
                                'rem_qty' => $rem_qty,
                                'qty' => $od->qty,
                                'unit_price' => $od->amount,
                                'color' => $od->color,
                                'note' => $od->note,
                            ];
                        }
                    }
                } else {
                    $message = 'Order items not found!';
                }
            }
        } else {
            $message = 'Please insert order No!';

        }
        echo CJSON::encode(array(
            'status' => $status,
            'order' => $data,
            'order_info' => $order_info,
            'order_item_status' => $order_item_status,
            'order_items' => $order_items,
            'message' => $message,
        ));
    }

}
