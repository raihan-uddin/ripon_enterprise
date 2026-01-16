<?php

class SellOrderQuotationController extends RController
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
            -SinglePreview
            -Jquery_showSoldProdSlNoSearch
            -fetchProductPrice
            -Jquery_showSellSearch
            -nJquery_showProductSearch
            -Jquery_showProductSlSearchForReturn
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
     * @return SellOrderQuotation the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SellOrderQuotation::model()->findByPk($id);
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
        $model = new SellOrderQuotation;
        $model2 = new SellOrderQuotationDetails();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

        }

        $costing = 0;
        if (isset($_POST['SellOrderQuotation'], $_POST['SellOrderQuotationDetails'])) {
            $model->attributes = $_POST['SellOrderQuotation'];
            $model->max_sl_no = SellOrderQuotation::maxSlNo();
            $model->discount_percentage = 0;
            $model->so_no = date('y') . date('m') . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            $transaction = Yii::app()->db->beginTransaction();

            try {
                if ($model->save()) {
                    $qtyList = $_POST['SellOrderQuotationDetails']['temp_qty'] ?? [];
                    $total_item = count(array_filter($qtyList, function ($qty) {
                        return (int)$qty > 0;
                    }));

                    $qtys = $_POST['SellOrderQuotationDetails']['temp_qty'] ?? [];

                    $per_item_discount = 0;

                    if ($total_item > 0) {
                        $per_item_discount = $model->discount_amount / $total_item;
                    }
                    foreach ($_POST['SellOrderQuotationDetails']['temp_model_id'] as $key => $model_id) {

                        $percentage_discount = 0;
                        if ($_POST['SellOrderQuotationDetails']['temp_unit_price'][$key] > 0) {
                            $percentage_discount = ($per_item_discount / $_POST['SellOrderQuotationDetails']['temp_unit_price'][$key]) * 100;
                        }


                        $purchasePrice = $_POST['SellOrderQuotationDetails']['temp_pp'][$key];
                        if (!$purchasePrice > 0) {
                            $purchasePrice = ProdModels::model()->findByPk($model_id)->purchase_price;
                        }
                        $model2 = new SellOrderQuotationDetails();
                        $model2->sell_order_id = $model->id;
                        $model2->model_id = $model_id;
                        $model2->qty = $_POST['SellOrderQuotationDetails']['temp_qty'][$key];
                        $model2->amount = $_POST['SellOrderQuotationDetails']['temp_unit_price'][$key];
                        $model2->row_total = $_POST['SellOrderQuotationDetails']['temp_row_total'][$key];
                        $model2->discount_amount = $per_item_discount;
                        $model2->discount_percentage = $percentage_discount;
                        $model2->pp = $purchasePrice;
                        $model2->costing = round(((float)$model2->qty * (float)$purchasePrice), 2);
                        if (!$model2->save()) {
                            $transaction->rollBack();
                            throw new CHttpException(500, sprintf('Error in saving order details! %s <br>', json_encode($model2->getErrors())));
                        }

                        $costing += $model2->costing;
                    }

                    $model->costing = $costing;
                    $model->save();

                    $transaction->commit();

                    $data = SellOrderQuotation::model()->findAllByAttributes(['id' => $model->id]);

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
            } catch (PDOException $e) {
                $transaction->rollBack();
                throw new CHttpException(500, $e->getMessage());
                Yii::app()->end();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
                Yii::app()->end();
            }
        }
        $this->pageTitle = 'CREATE DRAFT';
        $this->render('create', array(
            'model' => $model,
            'model2' => $model2,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param SellOrderQuotation $model the model to be validated
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
        $model2 = new SellOrderQuotationDetails();

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        $costing = 0;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if (isset($_POST['SellOrderQuotation'], $_POST['SellOrderQuotationDetails'])) {
                $model->attributes = $_POST['SellOrderQuotation'];
                $model->discount_percentage = 0;
                $model->discount_amount = $_POST['SellOrderQuotation']['discount_amount'];
                if ($model->save()) {

                    $total_item = count($_POST['SellOrderQuotationDetails']['temp_model_id']);
                    $per_item_discount = $model->discount_amount / $total_item;


                    $criteriaDel = new CDbCriteria;
                    $criteriaDel->addColumnCondition(['sell_order_id' => $id, 'is_deleted' => 0]);
                    SellOrderQuotationDetails::model()->deleteAll($criteriaDel);

                    foreach ($_POST['SellOrderQuotationDetails']['temp_model_id'] as $key => $model_id) {
                        if ($_POST['SellOrderQuotationDetails']['temp_qty'][$key] <= 0) {
                            continue;
                        }

                        $purchasePrice = $_POST['SellOrderQuotationDetails']['temp_pp'][$key];
                        $percentage_discount =  $per_item_discount != 0 ? ($per_item_discount / $_POST['SellOrderQuotationDetails']['temp_unit_price'][$key]) * 100 : 0;

                        $model2 = new SellOrderQuotationDetails();
                        $model2->sell_order_id = $model->id;
                        $model2->model_id = $model_id;
                        $model2->qty = $_POST['SellOrderQuotationDetails']['temp_qty'][$key];
                        $model2->amount = $_POST['SellOrderQuotationDetails']['temp_unit_price'][$key];
                        $model2->row_total = $_POST['SellOrderQuotationDetails']['temp_row_total'][$key];
                        $model2->discount_amount = $per_item_discount;
                        $model2->discount_percentage = $percentage_discount;
                        $model2->pp = $purchasePrice;
                        $model2->costing = round(($model2->qty * $purchasePrice), 2);
                        if (!$model2->save()) {
                            $transaction->rollBack();
                            throw new CHttpException(500, sprintf('Error in saving order details! %s <br>', json_encode($model2->getErrors())));
                        }

                        $details_id_arr[] = $model2->id;
                        $costing += $model2->costing;
                    }

                    $model->costing = $costing;
                    $model->save();
                    $transaction->commit();

                    $data = SellOrderQuotation::model()->findAllByAttributes(['id' => $model->id]);

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

            $criteria = new CDbCriteria();
            $criteria->select = "t.*, pm.model_name, pm.code";
            $criteria->addColumnCondition(['sell_order_id' => $id]);
            $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
            $criteria->order = "pm.model_name ASC";
            $this->pageTitle = 'UPDATE DRAFT';
            $this->render('update', array(
                'model' => $model,
                'model2' => $model2,
                'model3' => SellOrderQuotationDetails::model()->findAll($criteria),
            ));
        } catch (PDOException $e) {
            if ($transaction->active) {
                $transaction->rollBack();
            }
            throw new CHttpException(500, $e->getMessage());
        } catch (Exception $e) {
            if ($transaction->active) {
                $transaction->rollBack();
            }
            // Handle the exception (e.g., log it or display a message)
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, $e->getMessage());
        }
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
            $sellOrderDetail = SellOrderQuotationDetails::model()->findAll($criteria);
            if ($sellOrderDetail) {
                foreach ($sellOrderDetail as $item) {
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
        $model = new SellOrderQuotation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SellOrderQuotation']))
            $model->attributes = $_GET['SellOrderQuotation'];

        $this->pageTitle = 'QUOTATION MANAGE';
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    public function actionVoucherPreview()
    {
        $so_no = isset($_POST['so_no']) ? trim($_POST['so_no']) : "";
        $preview_type = isset($_POST['preview_type']) ? trim($_POST['preview_type']) : 0;
        $invoiceId = isset($_POST['invoiceId']) ? trim($_POST['invoiceId']) : 0;
        if (isset($_GET['invoiceId']) && $_GET['invoiceId'] > 0) {
            $invoiceId = $_GET['invoiceId'];
        }
        $show_profit = isset($_POST['show_profit']) ? trim($_POST['show_profit']) : 0;
        $date_range = isset($_POST['date_range']) ? trim($_POST['date_range']) : '';
        // remove ... from date range
        $date_range = str_replace('...', '', $date_range);
        $date_range = explode(' - ', $date_range);

        $from_date = isset($date_range[0]) ? $date_range[0] : '';
        $to_date = isset($date_range[1]) ? $date_range[1] : '';
        if (empty($to_date)) {
            $to_date = $from_date;
        }
        if (!empty($from_date) && !empty($to_date)) {
            // posted data was in d/m/Y format need data in Y-m-d format
            // 02/05/2024  replace / with - and then convert to Y-m-d format
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
            $to_date = date('Y-m-d', strtotime(str_replace('/', '-', $to_date)));
        }


        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

            Yii::app()->clientScript->scriptMap['jquery-ui-i18n.min.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui-timepicker-addon.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        }

        if (($so_no && $preview_type > 0) || $invoiceId > 0 || !empty($from_date) && !empty($to_date)) {
            $criteria = new CDbCriteria;
            if ($invoiceId > 0) {
                $criteria->addColumnCondition(['t.id' => $invoiceId]);
            }
            if (!empty($so_no)) {
                $criteria->addColumnCondition(['t.so_no' => $so_no]);
            }
            if ($from_date && $to_date) {
                $criteria->addBetweenCondition('t.date', $from_date, $to_date);
            }
            $data = SellOrderQuotation::model()->findAllByAttributes([], $criteria);

            if ($data) {
                if ($preview_type == SellOrderQuotation::DELIVERY_CHALLAN_PRINT) {
                    $view = "challanPreview";
                } else {
                    $view = "voucherPreview";
                }
                echo $this->renderPartial("$view", array('data' => $data, 'preview_type' => $preview_type, 'show_profit' => $show_profit), true, true);
            } else {
                header('Content-type: application/json');
                echo CJSON::encode(array(
                    'status' => 'error',
                ));
            }
            Yii::app()->end();
        } else {
            echo '<div class="alert alert-danger" role="alert">Please select Quotation no!</div>';
        }
    }
}
