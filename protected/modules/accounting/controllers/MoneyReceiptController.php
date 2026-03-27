<?php

class MoneyReceiptController extends RController
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
    public function actionCreate($id)
    {
        $model = new MoneyReceipt;
        $model->scenario = 'custom_form_save';
        $model2 = Customers::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $createTime = date('Y-m-d H:i:s');
            if (isset($_POST['MoneyReceipt'])) {
                $model->attributes = $_POST['MoneyReceipt'];
                $model->max_sl_no = MoneyReceipt::maxSlNo();
                $model->invoice_id = 0;
                $model->amount = 0;
                $model->mr_no =  "MR" . date('y') . date('m') . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
                if ($model->validate()) {
                    $model2 = new MoneyReceipt();
                    $model2->max_sl_no = MoneyReceipt::maxSlNo();
                    $model2->amount = $_POST['MoneyReceipt']['amount'];
                    $model2->invoice_id = NULL;
                    $model2->mr_no = $model->mr_no;
                    $model2->date = $model->date;
                    $model2->customer_id = $model->customer_id;
                    $model2->payment_type = $model->payment_type;
                    $model2->bank_id = $model->bank_id;
                    $model2->cheque_no = $model->cheque_no;
                    $model2->discount = $_POST['MoneyReceipt']['discount'] > 0 ? $_POST['MoneyReceipt']['discount'] : 0;
                    $model2->created_by = Yii::app()->user->getState('user_id');
                    $model2->remarks = $model->remarks;
                    $model2->cheque_date = $model->cheque_date;
                    $model2->created_at = $createTime;
                    if (!$model2->save()) {
                        $transaction->rollBack();
                        throw new CHttpException(500, sprintf('Error in saving order details! %s <br>', json_encode($model2->getErrors())));
                    }

                    $transaction->commit();

                    $criteria = new CDbCriteria;
                    $criteria->select = "SUM(amount) as amount, sum(discount) as discount, customer_id, date, mr_no, bank_id, cheque_no, cheque_date, remarks, created_by";
                    $criteria->addColumnCondition(['customer_id' => $model->customer_id, 'mr_no' => $model->mr_no]);
                    $criteria->group = 'customer_id, mr_no';
                    $dataMr = MoneyReceipt::model()->findAll($criteria);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $dataMr, 'new' => true), true, true), //
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
        } catch (PDOException $e) {
            if($transaction->active)
                $transaction->rollBack();
            throw new CHttpException(500, $e->getMessage());
        } catch (Exception $e) {
            if($transaction->active)
                $transaction->rollBack();
            throw new CHttpException(500, $e->getMessage());
        }


        $this->pageTitle = "MR CREATE";
        $this->render('create', array(
            'model' => $model,
            'model2' => $model2,
            'id' => $id,
        ));
    }


    public function actionUpdate($id)
    {
        $model    = $this->loadModel($id);
        $customer = Customers::model()->findByPk($model->customer_id);

        if (!$customer)
            throw new CHttpException(404, 'Customer not found.');

        if (isset($_POST['MoneyReceipt'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->date         = $_POST['MoneyReceipt']['date'];
                $model->amount       = $_POST['MoneyReceipt']['amount'];
                $model->discount     = isset($_POST['MoneyReceipt']['discount']) ? $_POST['MoneyReceipt']['discount'] : 0;
                $model->payment_type = $_POST['MoneyReceipt']['payment_type'];
                $model->bank_id      = isset($_POST['MoneyReceipt']['bank_id']) ? $_POST['MoneyReceipt']['bank_id'] : null;
                $model->cheque_no    = isset($_POST['MoneyReceipt']['cheque_no']) ? $_POST['MoneyReceipt']['cheque_no'] : null;
                $model->cheque_date  = isset($_POST['MoneyReceipt']['cheque_date']) ? $_POST['MoneyReceipt']['cheque_date'] : null;
                $model->remarks      = isset($_POST['MoneyReceipt']['remarks']) ? $_POST['MoneyReceipt']['remarks'] : null;
                $model->updated_by   = Yii::app()->user->getState('user_id');

                if ($model->save()) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Money receipt updated successfully.');
                    $this->redirect(array('admin'));
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                if ($transaction->active) $transaction->rollBack();
                throw new CHttpException(500, $e->getMessage());
            }
        }

        $this->pageTitle = "UPDATE MONEY RECEIPT";
        $this->render('update', array(
            'model'    => $model,
            'customer' => $customer,
        ));
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
            $data = $this->loadModel($id);
            if ($data) {
                if (!$this->loadModel($id)->delete())
                    throw new CHttpException(404, 'The requested page does not exist.');
            }
            $transaction->commit();
        } catch (PDOException $e) {
            $transaction->rollBack();
            throw new CHttpException(500, $e->getMessage());
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Manages all models.
     */
    public function actionAdminMoneyReceipt()
    {
        $model = new Customers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customers']))
            $model->attributes = $_GET['Customers'];

        $this->pageTitle = "CREATE MONEY RECEIPT";
        $this->render('adminMoneyReceipt', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new MoneyReceipt('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MoneyReceipt']))
            $model->attributes = $_GET['MoneyReceipt'];

        $this->pageTitle = "MANAGE MONEY RECEIPT";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MoneyReceipt the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = MoneyReceipt::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MoneyReceipt $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'money-receipt-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionVoucherPreview()
    {
        $mr_no = isset($_POST['mr_no']) ? trim($_POST['mr_no']) : "";

        if (strlen($mr_no) > 0) {
            $criteria = new CDbCriteria;
            $criteria->select = "SUM(amount) as amount, sum(discount) as discount, customer_id, date, mr_no, bank_id, cheque_no, cheque_date, remarks, created_by";
            $criteria->addColumnCondition(['mr_no' => $mr_no]);
            $criteria->group = 'customer_id, mr_no';
            $data = MoneyReceipt::model()->findAll($criteria);
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
            echo '<div class="alert alert-danger" role="alert">Please select  MR no!</div>';
        }
    }
}
