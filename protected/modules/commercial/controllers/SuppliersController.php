<?php

class SuppliersController extends RController
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
            -jquery_supplierSearch', // perform access control for CRUD operations
        );
    }

    public function allowedActions()
    {
        return '';
    }


    public function actionJquery_supplierSearch()
    {
        $supplierName = trim($_POST['q']);
        $criteria = new CDbCriteria();
        $criteria->compare('company_name', $supplierName, true);
        $criteria->order = 'company_name asc';
        $criteria->limit = 10;
        $info = Suppliers::model()->findAll($criteria);
        if ($info) {
            foreach ($info as $row) {
                $value = $row->company_name;
                $label = $row->company_name;
                $contact_no = $row->company_contact_no;
                $address = $row->company_address;
                $web = $row->company_web;
                $id = $row->id;
                $results[] = array(
                    'value' => $value,
                    'label' => $label,
                    'id' => $id,
                    'contact_no' => $contact_no,
                    'address' => $address,
                    'web' => $web,
                );
            }
        } else {
            $results[] = array('value' => "", 'label' => "No Data Available", 'id' => '', 'contact_no' => '', 'web' => '', 'address' => '');
        }
        echo json_encode($results);
    }

    public function actionCreateSupplierFromOutSide()
    {
        $model = new Suppliers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Suppliers'])) {
            $model->attributes = $_POST['Suppliers'];
            if ($model->save()) {
                if ($model->opening_amount > 0) {
                    // create a new purchase order
                    $purchaseOrder = new PurchaseOrder();
                    $purchaseOrder->supplier_id = $model->id;
                    $purchaseOrder->order_type = 1;
                    $purchaseOrder->is_opening = 1;
                    $purchaseOrder->date = date('Y-m-d');
                    $purchaseOrder->max_sl_no = PurchaseOrder::maxSlNo();
                    $purchaseOrder->po_no = "OP" . date('y') . "-" . date('m') . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
                    $purchaseOrder->total_amount = $model->opening_amount;
                    $purchaseOrder->grand_total = $model->opening_amount;
                    $purchaseOrder->cash_due = 82;
                    $purchaseOrder->is_paid = PurchaseOrder::DUE;
                    $purchaseOrder->save();
                }
                if (Yii::app()->request->isAjaxRequest) {
                    $data = Suppliers::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => '<div class="alert alert-success" role="alert">Successfully created!</div>',
                        'value' => $data->id,
                        'label' => $data->company_name,
                        'contact_no' => $data->company_contact_no,
                        'web' => $data->company_web,
                        'address' => $data->company_address,
                    ));
                    exit;
                } else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $resultDiv = '';
            echo CJSON::encode(array(
                'status' => 'failure',
                'resultDiv' => $resultDiv,
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
        } else
            $this->render('create', array('model' => $model,));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function actionCreate()
    {
        $model = new Suppliers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Suppliers'])) {
            $model->attributes = $_POST['Suppliers'];
            $valid = $model->validate();
            if ($valid) {
                if ($model->save()) {
                    if ($model->opening_amount > 0) {
                        // create a new purchase order
                        $purchaseOrder = new PurchaseOrder();

                        $purchaseOrder->supplier_id = $model->id;
                        $purchaseOrder->order_type = 1;
                        $purchaseOrder->is_opening = 1;
                        $purchaseOrder->date = date('Y-m-d');
                        $purchaseOrder->max_sl_no = PurchaseOrder::maxSlNo();
                        $purchaseOrder->po_no = "OP" . date('y') . "-" . date('m') . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
                        $purchaseOrder->total_amount = $model->opening_amount;
                        $purchaseOrder->grand_total = $model->opening_amount;
                        $purchaseOrder->cash_due = 82;
                        $purchaseOrder->is_paid = PurchaseOrder::DUE;
                        $purchaseOrder->save();
                    }
                }
                //do anything here

                echo CJSON::encode(array(
                    'status' => 'success',
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        } else {
            $this->render('admin', array(
                'model' => $model,
            ));
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

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Suppliers'])) {
            $model->attributes = $_POST['Suppliers'];
            if ($model->save()) {
                if ($model->opening_amount > 0) {
                    $purchaseOrder = PurchaseOrder::model()->findByAttributes(array('supplier_id' => $model->id, 'is_opening' => 1, 'order_type' => 1));
                    if (!$purchaseOrder) {
                        $purchaseOrder = new PurchaseOrder();
                        $purchaseOrder->supplier_id = $model->id;
                        $purchaseOrder->order_type = 1;
                        $purchaseOrder->is_opening = 1;
                        $purchaseOrder->date = date('Y-m-d');
                        $purchaseOrder->max_sl_no = PurchaseOrder::maxSlNo();
                        $purchaseOrder->po_no = "OP" . date('y') . "-" . date('m') . str_pad($purchaseOrder->max_sl_no, 5, "0", STR_PAD_LEFT);
                    }

                    $purchaseOrder->total_amount = $model->opening_amount;
                    $purchaseOrder->grand_total = $model->opening_amount;
                    $purchaseOrder->cash_due = 82;
                    $purchaseOrder->is_paid = PurchaseOrder::DUE;
                    $purchaseOrder->save();
                }
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="alert alert-success" role="alert">Successfully updated</div>',
                    ));
                    exit;
                } else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_form2', array(
                    'model' => $model), true, true),
            ));
            exit;
        } else
            $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public
    function actionDelete($id)
    {

        $purchaseItemsData = PurchaseOrder::model()->findByAttributes(array('supplier_id' => $id));
        $paymentReceiptData = PaymentReceipt::model()->findByAttributes(array('supplier_id' => $id));

        if (empty($purchaseItemsData) && empty($paymentReceiptData)) {
            $this->loadModel($id)->delete();
            echo "<div class='flash-success'>Supplier deleted Successfully.</div>";
        } else {
            echo "<div class='flash-error'>Supplier cannot be deleted.</div>";
        }

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

    }


    /**
     * Manages all models.
     */
    public
    function actionAdmin()
    {
        $model = new Suppliers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Suppliers']))
            $model->attributes = $_GET['Suppliers'];

        $this->pageTitle = "SUPPLIER MANAGE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public
    function loadModel($id)
    {
        $model = Suppliers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected
    function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'suppliers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
