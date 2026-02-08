<?php

class LoanPersonsController extends Controller
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
	public function accessRules()
	{
		return array(
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
    public function actionCreate()
    {
        $model = new LoanPersons;
        $this->performAjaxValidation($model);

        if (isset($_POST['LoanPersons'])) {
            $model->attributes = $_POST['LoanPersons'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::app()->user->id;

            if ($model->validate()) {
                $model->save(false);
                echo CJSON::encode(['status' => 'success']);
            } else {
                echo CActiveForm::validate($model);
            }
            Yii::app()->end();
        }

        $this->render('admin', ['model' => $model]);
    }


    /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['LoanPersons'])) {
            $model->attributes = $_POST['LoanPersons'];
            if ($model->save()) {
                echo CJSON::encode([
                    'status' => 'success',
                    'content' => '<div class="alert alert-success">Updated successfully</div>',
                ]);
            } else {
                echo CJSON::encode([
                    'status' => 'failure',
                    'content' => $this->renderPartial('_form2', ['model'=>$model], true, true),
                ]);
            }
            Yii::app()->end();
        }

        echo CJSON::encode([
            'status' => 'failure',
            'content' => $this->renderPartial('_form2', ['model'=>$model], true, true),
        ]);
        Yii::app()->end();
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
            if (!isset($_GET['ajax'])) {
                $this->redirect(['admin']);
            }
        } else {
            throw new CHttpException(400);
        }
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LoanPersons('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LoanPersons']))
			$model->attributes=$_GET['LoanPersons'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LoanPersons the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LoanPersons::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LoanPersons $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='loan-persons-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
