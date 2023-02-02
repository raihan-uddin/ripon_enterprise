<?php

class SellOrderBomController extends Controller
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
            'rights', // perform access control for CRUD operations
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


    public function actionCreate($id)
    {
        $model = new SellOrderBom();
        $modelDetails = new SellOrderBom();
        $sellItemsData = SellOrder::model()->findByPk($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SellOrder'], $_POST['SellOrderBom'])) {
            $sellItemsData->bom_complete = SellOrder::BOM_COMPLETE;
            if ($sellItemsData->save()) {
                $max_sl_no = SellOrderBom::maxSlNo();
                $bom_no = "SO-BOM-" . date('y') . "-" . date('m') . "-" . str_pad($max_sl_no, 5, "0", STR_PAD_LEFT);

                $item_present_arr = [];
                foreach ($_POST['SellOrderBom']['temp_model_id'] as $key => $model_id) {
                    $model = SellOrderBom::model()->findByAttributes(['sell_order_id' => $id, 'model_id' => $model_id]);
                    if (!$model)
                        $model = new SellOrderBom();
                    $model->sell_order_id = $id;
                    $model->max_sl_no = $max_sl_no;
                    $model->bom_no = $bom_no;
                    $model->date = date('Y-m-d');
                    $model->model_id = $model_id;
                    $model->qty = $_POST['SellOrderBom']['temp_qty'][$key];
                    if (!$model->save()) {
                        var_dump($model->getErrors());
                        exit;
                    }
                    $item_present_arr[] = $model->id;
                }
                if (count($item_present_arr) > 0) {
                    $criteriaDel = new CDbCriteria;
                    $criteriaDel->addNotInCondition('id', $item_present_arr);
                    $criteriaDel->addColumnCondition(['sell_order_id' => $id]);
                    SellOrderBom::model()->deleteAll($criteriaDel);
                }

                $data = SellOrder::model()->findByPk($id);
                echo CJSON::encode(array(
                    'status' => 'success',
                    'soReportInfo' => $this->renderPartial('sell.views.sellOrder.voucherPreviewBom', array('data' => $data, 'new' => true), true, true), //
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
        $criteria->addColumnCondition(['sell_order_id' => $id]);
        $sellDetails = SellOrderDetails::model()->findAll($criteria);
        $item_arr = [];
        foreach ($sellDetails as $key => $dt) {
            $criteriaBom = new CDbCriteria();
            $criteriaBom->join = " INNER JOIN bom b on t.bom_id = b.id ";
            $criteriaBom->addColumnCondition(['b.fg_model_id' => $dt->model_id]);
            $bomDetails = BomDetails::model()->findAll($criteriaBom);
            foreach ($bomDetails as $bd) {
                $req_qty = $bd->qty * $dt->qty;
                if (isset($item_arr[$bd->model_id])) {
                    $item_arr[$bd->model_id] += $req_qty;
                } else {
                    $item_arr[$bd->model_id] = $req_qty;
                }
            }
        }
        if ($sellItemsData->bom_complete == SellOrder::BOM_NOT_COMPLETE && $sellItemsData->order_type == SellOrder::NEW_ORDER) {
            $this->pageTitle = 'BOM CREATE';
            $this->render('_form', array(
                'sellItemsData' => $sellItemsData,
                'sellDetails' => $sellDetails,
                'item_arr' => $item_arr,
                'model' => $model,
                'modelDetails' => $modelDetails,
            ));
        } else {
            if ($sellItemsData->bom_complete == SellOrder::BOM_COMPLETE) {
                $status = ['status' => 'danger', 'message' => 'BOM Already Created!'];
            } else if ($sellItemsData->order_type == SellOrder::REPAIR_ORDER) {
                $status = ['status' => 'danger', 'message' => 'You cannot create a BOM of Repair Order!'];
            } else {
                $status = ['status' => 'danger', 'message' => 'You Cannot create BOM of this order!'];
            }
            Yii::app()->user->setFlash($status['status'], $status['message']);
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    /*public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }*/


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SellOrderBom('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SellOrderBom']))
            $model->attributes = $_GET['SellOrderBom'];

        $this->pageTitle = "MANAGE JOB CARD";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SellOrderBom the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SellOrderBom::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SellOrderBom $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sell-order-bom-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
