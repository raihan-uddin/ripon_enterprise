<?php

class CustomerAbValidationController extends RController
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

    public function actionChangeStatus($id, $status)
    {

        if ($status == "activate") {
            CustomerAbValidation::model()->updateByPk($id, array('is_active' => CustomerAbValidation::ACTIVE));
        } else {
            CustomerAbValidation::model()->updateByPk($id, array('is_active' => CustomerAbValidation::INACTIVE));
        }

    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
//		$model=new CustomerAbValidation;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['CustomerAbValidation']))
//		{
//			$model->attributes=$_POST['CustomerAbValidation'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
//		}
//
//		$this->render('create',array(
//			'model'=>$model,
//		));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
//		$model=$this->loadModel($id);
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['CustomerAbValidation']))
//		{
//			$model->attributes=$_POST['CustomerAbValidation'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
//		}
//
//		$this->render('update',array(
//			'model'=>$model,
//		));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
//		if(Yii::app()->request->isPostRequest)
//		{
//			// we only allow deletion via POST request
//			$this->loadModel($id)->delete();
//
//			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//			if(!isset($_GET['ajax']))
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
//			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new CustomerAbValidation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerAbValidation']))
            $model->attributes = $_GET['CustomerAbValidation'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdmin2()
    {
        $model = new CustomerAbValidation('search2');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CustomerAbValidation']))
            $model->attributes = $_GET['CustomerAbValidation'];

        $this->render('admin2', array(
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
        $model = CustomerAbValidation::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-ab-validation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
