<?php

class StoresController extends RController
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Stores;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Stores'])) {
            $model->attributes = $_POST['Stores'];
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

    public function actionCreateStoreFromOutSide()
    {
        $model = new Stores;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Stores'])) {
            $model->attributes = $_POST['Stores'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = Stores::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => '<div class="alert alert-success">
                                      Successfully created!
                                    </div>',
                        'value' => $data->id,
                        'label' => $data->name,
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
                'div' => $this->renderPartial('_form3', array('model' => $model), true)));
            exit;
        } else
            $this->render('create', array('model' => $model,));
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

        if (isset($_POST['Stores'])) {
            $model->attributes = $_POST['Stores'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="alert alert-success">
                                      Successfully updated!
                                    </div>',
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
    public function actionDelete($id)
    {
        $location = Location::model()->findByAttributes(['store_id' => $id]);
        $inventory = Inventory::model()->findByAttributes(['store_id' => $id]);
        if (!$location && !$inventory) {
            $this->loadModel($id)->delete();
        }else {
            throw new CHttpException(500, 'You cannot delete this item');
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
        $model = new Stores('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Stores']))
            $model->attributes = $_GET['Stores'];

        $this->pageTitle = "STORE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Stores the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Stores::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Stores $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'stores-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
