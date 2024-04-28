<?php

class UnitsController extends RController
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

    public function allowedActions()
    {
        return '';
    }

    public function actionCreateUnitFromOutSide()
    {
        $model = new Units;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Units'])) {
            $model->attributes = $_POST['Units'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = Units::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => '<div class="alert alert-success">
                                      Successfully created!
                                    </div>',
                        'value' => $data->id,
                        'label' => $data->label,
                    ));
                    exit;
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Units;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Units'])) {
            $model->attributes = $_POST['Units'];
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

        if (isset($_POST['Units'])) {
            $model->attributes = $_POST['Units'];
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
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Units('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Units']))
            $model->attributes = $_GET['Units'];

        $this->pageTitle = "UNITS";
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
        $model = Units::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'units-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
