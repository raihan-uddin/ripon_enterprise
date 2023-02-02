<?php

class ExpenseController extends Controller
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
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Expense the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Expense::model()->findByPk($id);
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
        $model = new Expense();
        $model2 = new ExpenseDetails();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Expense'], $_POST['ExpenseDetails'])) {
            $model->attributes = $_POST['Expense'];
            $model->max_sl_no = Expense::maxSlNo();
            $model->entry_no = date('y') . date('m') . str_pad($model->max_sl_no, 3, "0", STR_PAD_LEFT);
            if ($model->save()) {
                foreach ($_POST['ExpenseDetails']['temp_expense_head_id'] as $key => $expense_head_id) {
                    $note = $_POST['ExpenseDetails']['temp_remarks'][$key];
                    $amount = $_POST['ExpenseDetails']['temp_amount'][$key];

                    $model2 = new ExpenseDetails();
                    $model2->expense_id = $model->id;
                    $model2->remarks = $note;
                    $model2->expense_head_id = $expense_head_id;
                    $model2->amount = $amount;
                    if (!$model2->save()) {
                        var_dump($model2->getErrors());
                        exit;
                    }
                }
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

        $this->pageTitle = "CREATE EXPENSE";
        $this->render('create', array(
            'model' => $model,
            'model2' => $model2,
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

        if (isset($_POST['Expense'])) {
            $model->attributes = $_POST['Expense'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $model = new Expense('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Expense']))
            $model->attributes = $_GET['Expense'];

        $this->pageTitle = "EXPENSE MANAGE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionVoucherPreview()
    {
        $entry_no = isset($_POST['entry_no']) ? trim($_POST['entry_no']) : "";

        if (strlen($entry_no) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(['entry_no' => $entry_no]);
            $data = Expense::model()->findByAttributes([], $criteria);
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
            echo '<div class="alert alert-danger" role="alert">Please select  Expense no!</div>';
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Expense $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'expense-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
