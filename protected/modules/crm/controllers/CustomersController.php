<?php

class CustomersController extends Controller
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
            -jquery_customerSearch', // perform access control for CRUD operations
        );
    }

    public function allowedActions()
    {
        return '';
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Customers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Customers'])) {
            $model->attributes = $_POST['Customers'];
            $model->max_sl_no = Customers::maxSlNo();
            $model->customer_code = "CUS" . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            $valid = $model->validate();
            if ($valid) {
                $model->save();
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

    public function actionCreateCustomerFromOutSide()
    {
        $model = new Customers();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Customers'])) {
            $model->attributes = $_POST['Customers'];
            $model->max_sl_no = Customers::maxSlNo();
            $model->customer_code = "CUS" . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => '<div class="alert alert-success" role="alert">Successfully Created</div>',
                        'value' => $model->id,
                        'label' => $name = $model->company_name,
                        'name' => $name,
                        'id' => $model->id,
                        'city' => $model->city,
                        'zip' => $model->zip,
                        'state' => $model->state,
                        'contact_no' => $model->company_contact_no,
                        'customer_code' => $model->customer_code,
                    ));
                    exit;
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $resultDiv = '';
            echo CJSON::encode(array(
                'status' => 'failure',
                'resultDiv' => $resultDiv,
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
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

        if (isset($_POST['Customers'])) {
            $model->attributes = $_POST['Customers'];
            if ($model->save()) {
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
            $this->render('_form2', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {

        $sellItemsData = SellOrder::model()->findByAttributes(array('customer_id' => $id));
        $moneyReceiptData = MoneyReceipt::model()->findByAttributes(array('customer_id' => $id));

        if (empty($sellItemsData) && empty($moneyReceiptData)) {
            $this->loadModel($id)->delete();
            echo "<div class='flash-success'>Customer deleted Successfully.</div>";
        } else {
            echo "<div class='flash-error'>Customer cannot be deleted.</div>";
        }

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Customers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customers']))
            $model->attributes = $_GET['Customers'];

        $this->pageTitle = "CUSTOMER MANAGE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Customers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionJquery_customerSearch()
    {
        $customerName = trim($_POST['q']);
        $criteria = new CDbCriteria();
        $criteria->compare('company_name', $customerName, true);
        $criteria->compare('customer_code', $customerName, true, "OR");
        $criteria->order = 'company_name asc';
        $criteria->limit = 10;
        $info = Customers::model()->findAll($criteria);
        if ($info) {
            foreach ($info as $row) {
                $value = $label = $name = $row->company_name;
                $id = $row->id;
                $city = $row->city;
                $state = $row->state;
                $zip = $row->zip;
                $contact_no = $row->company_contact_no;
                $customer_code = $row->customer_code;
                $results[] = array(
                    'value' => $value,
                    'label' => $label,
                    'name' => $name,
                    'id' => $id,
                    'city' => $city ? $city : "N/A",
                    'zip' => $zip ? $zip : "N/A",
                    'state' => $state ? $state : "N/A",
                    'contact_no' => $contact_no ? $contact_no : "N/A",
                    'customer_code' => $customer_code ? $customer_code : "N/A",
                );
            }
        } else {
            $results[] = array('value' => "", 'label' => "No data found", 'name' => "No data found", 'id' => "", 'city' => "N/A", 'zip' => "N/A", 'state' => "N/A", 'contact_no' => "N/A", 'customer_code' => 'N/A');
        }
        echo json_encode($results);
    }
}
