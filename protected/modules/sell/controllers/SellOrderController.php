<?php

class SellOrderController extends RController
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
            -VoucherPreview
            -SinglePreview, 
            -SoDetails',
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

        $costing = 0;
        if (isset($_POST['SellOrder'], $_POST['SellOrderDetails'])) {
            $model->attributes = $_POST['SellOrder'];
            $model->max_sl_no = SellOrder::maxSlNo();
            $model->discount_percentage = 0;
            $model->total_due = $_POST['SellOrder']['grand_total'];
            $model->so_no = date('y') . date('m') . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            $inv_sl = Inventory::maxSlNo();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    // count total $_POST['SellOrderDetails']['temp_model_id']
                    $total_item = count($_POST['SellOrderDetails']['temp_model_id']);
                    $per_item_discount = $model->discount_amount / $total_item;
                    foreach ($_POST['SellOrderDetails']['temp_model_id'] as $key => $model_id) {

                        $percentage_discount = ($per_item_discount / $_POST['SellOrderDetails']['temp_unit_price'][$key]) * 100;


                        $purchasePrice = $_POST['SellOrderDetails']['temp_pp'][$key];
                        if (!$purchasePrice > 0) {
                            $purchasePrice = ProdModels::model()->findByPk($model_id)->purchase_price;
                        }
                        $product = ProdModels::model()->findByPk($model_id);
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
                        $model2->discount_amount = $per_item_discount;
                        $model2->discount_percentage = $percentage_discount;
                        $model2->pp = $purchasePrice;
                        $model2->costing = round(($model2->qty * $purchasePrice), 2);
                        if (!$model2->save()) {
                            $transaction->rollBack();
                            throw new CHttpException(500, sprintf('Error in saving order details! %s <br>', json_encode($model2->getErrors())));
                        }
                        if ($model->order_type == SellOrder::NEW_ORDER) {
                            if ($product->stockable) {
                                $inventory = new Inventory();
                                $inventory->sl_no = $inv_sl;
                                $inventory->date = $model->date;
                                $inventory->challan_no = $model->so_no;
                                $inventory->store_id = 1;
                                $inventory->location_id = 1;
                                $inventory->model_id = $model2->model_id;
                                $inventory->stock_out = $model2->qty;
                                $inventory->sell_price = $model2->amount;
                                $inventory->purchase_price = $purchasePrice;
                                $inventory->row_total = $model2->row_total;
                                $inventory->product_sl_no = $model2->product_sl_no;
                                $inventory->stock_status = Inventory::SALES_DELIVERY;
                                $inventory->source_id = $model2->id;
                                $inventory->master_id = $model->id;
                                if (!$inventory->save()) {
                                    $transaction->rollBack();
                                    throw new CHttpException(500, 'Error in saving inventory! <br> ' . json_encode($inventory->getErrors()));
                                }
                            }
                        }

                        $costing += $model2->costing;
                        ProdModels::model()->updateProductPrice($model2->model_id, $model2->amount);
                    }


                    if ($model->cash_due == Lookup::CASH) {
                        $moneyReceipt = new MoneyReceipt();
                        $moneyReceipt->customer_id = $model->customer_id;
                        $moneyReceipt->invoice_id = $model->id;
                        $moneyReceipt->max_sl_no = MoneyReceipt::maxSlNo();
                        $moneyReceipt->mr_no = "MR-" . date('y') . "-" . date('m') . "-" . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
                        $moneyReceipt->amount = $model->total_due;
                        $moneyReceipt->payment_type = 1; // cash
                        $moneyReceipt->date = $model->date;
                        $moneyReceipt->is_approved = 0;
                        $moneyReceipt->remarks = "Cash payment for sales order no: " . $model->so_no . " on " . $model->date . " by " . Yii::app()->user->name;
                        if (!$moneyReceipt->save()) {
                            $transaction->rollBack();
                            throw new CHttpException(500, 'Error in saving money receipt! <br> ' . json_encode($moneyReceipt->getErrors()));
                        }
                        $model->total_paid = $model->total_due;
                        $model->total_due = 0;
                        $model->is_paid = SellOrder::PAID;
                    }

                    $model->costing = $costing;
                    $model->save();

                    $transaction->commit();


                    // if cash order then create money receipt
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
            } catch (PDOException $e) {
                $transaction->rollBack();
                throw new CHttpException(500, $e->getMessage());
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
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

        $costing = 0;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if (isset($_POST['SellOrder'], $_POST['SellOrderDetails'])) {
                $model->attributes = $_POST['SellOrder'];
                $model->discount_percentage = 0;
                $model->discount_amount = $_POST['SellOrder']['discount_amount'];
                $model->total_due = $_POST['SellOrder']['grand_total'] - $model->total_paid;
                if ($model->save()) {
                    $total_item = count($_POST['SellOrderDetails']['temp_model_id']);
                    $per_item_discount = $model->discount_amount / $total_item;
                    $details_id_arr = [];
                    foreach ($_POST['SellOrderDetails']['temp_model_id'] as $key => $model_id) {
                        $product_sl_no = $_POST['SellOrderDetails']['temp_product_sl_no'][$key];
                        $purchasePrice = $_POST['SellOrderDetails']['temp_pp'][$key];
                        $percentage_discount = ($per_item_discount / $_POST['SellOrderDetails']['temp_unit_price'][$key]) * 100;

                        if (!$purchasePrice > 0) {
                            $purchasePrice = ProdModels::model()->findByPk($model_id)->purchase_price;
                        }
                        $model2 = SellOrderDetails::model()->findByAttributes(['model_id' => $model_id, 'sell_order_id' => $model->id, 'product_sl_no' => $product_sl_no, 'is_deleted' => 0]);
                        if (!$model2)
                            $model2 = new SellOrderDetails();
                        $model2->sell_order_id = $model->id;
                        $model2->model_id = $model_id;
                        $model2->qty = $_POST['SellOrderDetails']['temp_qty'][$key];
                        $model2->amount = $_POST['SellOrderDetails']['temp_unit_price'][$key];
                        $model2->row_total = $_POST['SellOrderDetails']['temp_row_total'][$key];
                        $model2->color = $_POST['SellOrderDetails']['temp_color'][$key];
                        $model2->note = $_POST['SellOrderDetails']['temp_note'][$key];
                        $model2->warranty = $_POST['SellOrderDetails']['temp_warranty'][$key];
                        $model2->discount_amount = $per_item_discount;
                        $model2->discount_percentage = $percentage_discount;
                        $model2->pp = $purchasePrice;
                        $model2->costing = round(($model2->qty * $purchasePrice), 2);
                        $model2->product_sl_no = $product_sl_no;
                        if (!$model2->save()) {
                            $transaction->rollBack();
                            throw new CHttpException(500, sprintf('Error in saving order details! %s <br>', json_encode($model2->getErrors())));
                        }

                        ProdModels::model()->updateProductPrice($model2->model_id, $model2->amount);

                        $details_id_arr[] = $model2->id;
                        $costing += $model2->costing;
                    }
                    if (count($details_id_arr) > 0) {
                        $criteriaDel = new CDbCriteria;
                        $criteriaDel->addNotInCondition('id', $details_id_arr);
                        $criteriaDel->addColumnCondition(['sell_order_id' => $id, 'is_deleted' => 0]);
                        SellOrderDetails::model()->deleteAll($criteriaDel);
                    }

                    $delete_inv_arr = [];
                    $criteria2 = new CDbCriteria();
                    $criteria2->addColumnCondition(['sell_order_id' => $id, 'is_deleted' => 0]);
                    $sellOrderDetails = SellOrderDetails::model()->findAll($criteria2);

                    $inv_sl = Inventory::maxSlNo();
                    foreach ($sellOrderDetails as $detail) {
                        $product = ProdModels::model()->findByPk($detail->model_id);
                        $inventory = Inventory::model()->findByAttributes(['model_id' => $detail->model_id, 'stock_status' => Inventory::SALES_DELIVERY, 'source_id' => $detail->id, 'product_sl_no' => $detail->product_sl_no, 'is_deleted' => 0]);
                        if (!$inventory) {
                            $inventory = new Inventory();
                        }
                        if ($product->stockable) {
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
                                $transaction->rollBack();
                                throw new CHttpException(500, sprintf('Error in saving inventory! %s <br>', json_encode($inventory->getErrors())));
                            }

                        }
                        if ($inventory)
                            $delete_inv_arr[] = $inventory->id;
                    }
                    if (count($delete_inv_arr) > 0) {
                        $criteriaDel = new CDbCriteria;
                        $criteriaDel->addNotInCondition('id', $delete_inv_arr);
                        $criteriaDel->addColumnCondition(['master_id' => $id, 'stock_status' => Inventory::SALES_DELIVERY, 'is_deleted' => 0]);
                        Inventory::model()->deleteAll($criteriaDel);
                    }

                    $model->costing = $costing;
                    $model->save();
                    $transaction->commit();


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
        } catch (PDOException $e) {
            $transaction->rollBack();
            throw new CHttpException(500, $e->getMessage());
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new CHttpException(500, $e->getMessage());
        }
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

        $transaction = Yii::app()->db->beginTransaction();
        try {
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
            $transaction->commit();

        } catch (Exception $e) {
            $transaction->rollBack();
            throw new CHttpException(500, $e->getMessage());
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
        $invoiceId = isset($_POST['invoiceId']) ? trim($_POST['invoiceId']) : 0;
        $show_profit = isset($_POST['show_profit']) ? trim($_POST['show_profit']) : 0;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        if (($so_no && $preview_type > 0) || $invoiceId > 0) {
            $criteria = new CDbCriteria;
            if ($invoiceId > 0) {
                $criteria->addColumnCondition(['t.id' => $invoiceId]);
            } else
                $criteria->addColumnCondition(['t.so_no' => $so_no]);
            $data = SellOrder::model()->findByAttributes([], $criteria);

            if ($data) {
                echo $this->renderPartial("voucherPreview", array('data' => $data, 'preview_type' => $preview_type, 'show_profit' => $show_profit), true, true);
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


}
