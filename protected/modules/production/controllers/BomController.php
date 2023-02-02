<?php

class BomController extends Controller
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {

        $this->pageTitle = 'BOM VIEW';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Bom the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Bom::model()->findByPk($id);
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
        $model = new Bom;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Bom'], $_POST['BomDetails'])) {
            $model->attributes = $_POST['Bom'];
            $model->date = date('Y-m-d');
            $model->bom_no = strtoupper(uniqid());
            $model->qty = 1;
            if ($model->save()) {
                foreach ($_POST['BomDetails']['temp_model_id'] as $key => $model_id) {
                    $model2 = new BomDetails();
                    $model2->bom_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['BomDetails']['temp_qty'][$key];
                    $model2->unit_id = $_POST['BomDetails']['temp_unit_id'][$key];
                    if (!$model2->save()) {
                        var_dump($model2->getErrors());
                        exit;
                    }
                }
                echo CJSON::encode(array(
                    'status' => 'success',
                    'message' => 'Saved successfully!',
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        }

        $this->pageTitle = 'BOM CREATE';
        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['Bom'], $_POST['BomDetails'])) {
            $model->attributes = $_POST['Bom'];
            if ($model->save()) {
                $details_id_arr = [];
                foreach ($_POST['BomDetails']['temp_model_id'] as $key => $model_id) {
                    $model2 = BomDetails::model()->findByAttributes(['model_id' => $model_id, 'bom_id' => $model->id]);
                    if (!$model2)
                        $model2 = new BomDetails();
                    $model2->bom_id = $model->id;
                    $model2->model_id = $model_id;
                    $model2->qty = $_POST['BomDetails']['temp_qty'][$key];
                    $model2->unit_id = $_POST['BomDetails']['temp_unit_id'][$key];
                    if (!$model2->save()) {
                        var_dump($model2->getErrors());
                        exit;
                    }
                    $details_id_arr[] = $model2->id;
                }
                if (count($details_id_arr) > 0) {
                    $criteriaDel = new CDbCriteria;
                    $criteriaDel->addNotInCondition('id', $details_id_arr);
                    $criteriaDel->addColumnCondition(['bom_id' => $id]);
                    BomDetails::model()->deleteAll($criteriaDel);
                }
                echo CJSON::encode(array(
                    'status' => 'success',
                    'message' => 'Saved successfully!',
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        }

        $modelDetails = new BomDetails();
        $this->pageTitle = 'BOM UPDATE';
        $this->render('update', array(
            'model' => $model,
            'modelDetails' => $modelDetails,
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
        $model = new Bom('search');
        $modelDetails = new BomDetails();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Bom']))
            $model->attributes = $_GET['Bom'];

        $this->pageTitle = 'BOM';
        $this->render('admin', array(
            'model' => $model,
            'modelDetails' => $modelDetails,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param Bom $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bom-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
