<?php

class LocationController extends Controller
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
        //echo 'OK';
        $model = new Location;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Location'])) {
            $model->attributes = $_POST['Location'];
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
            /* echo CJSON::encode(array(
              'status' => 'Error',
              )); */
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

        if (isset($_POST['Location'])) {
            $model->attributes = $_POST['Location'];
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

    public function actionCreateLocationFromOutSide()
    {
        $model = new Location;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['Location'])) {
            $model->attributes = $_POST['Location'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = Location::model()->findByPk($model->id);
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
            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
        } else
            $this->render('create', array('model' => $model,));
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $inventory = Inventory::model()->findByAttributes(['location_id' => $id]);
        if (!$inventory) {
            $this->loadModel($id)->delete();
        } else {
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
        $model = new Location('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Location']))
            $model->attributes = $_GET['Location'];

        $this->pageTitle = "LOCATION";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Location the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Location::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Location $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'location-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSubCatOfThisCat()
    {
        $catId = trim($_POST['store_id']);
        $subCatList = '';

        if ($catId != '') {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['store_id' => $catId]);
            $criteria->order = 'name asc';
            $data = Location::model()->findAll($criteria);
            if ($data) {
                $subCatList = CHtml::tag('option', array('value' => ''), 'Select', true);
                foreach ($data as $d) {
                    $subCatList .= CHtml::tag('option', array('value' => $d->id), CHtml::decode($d->name), true);
                }
            } else {
                $subCatList = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        } else {
            $criteria = new CDbCriteria();
            $criteria->order = 'name asc';
            $data = Location::model()->findAll($criteria);
            if ($data) {
                $subCatList = CHtml::tag('option', array('value' => ""), "Select", true);
                foreach ($data as $d) {
                    $subCatList .= CHtml::tag('option', array('value' => $d->id), CHtml::decode($d->name), true);
                }
            } else {
                $subCatList = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        }
        echo CJSON::encode(array(
            'subCatList' => $subCatList,
        ));
    }
}
