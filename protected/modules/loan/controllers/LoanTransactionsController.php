<?php

class LoanTransactionsController extends Controller
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
			-GetPersonBalance
			', // perform access control for CRUD operations
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
        $model = new LoanTransactions;
        $this->performAjaxValidation($model);

        if (isset($_POST['LoanTransactions'])) {
            $model->attributes = $_POST['LoanTransactions'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::app()->user->id;

            if ($model->validate()) {
                $model->save(false);
                echo CJSON::encode(['status'=>'success']);
            } else {
                echo CActiveForm::validate($model);
            }
            Yii::app()->end();
        }

        $this->render('admin', ['model'=>$model]);
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
    public function actionUpdate($id)
    {
        $model = LoanTransactions::model()->findByPk($id);
        if(!$model) throw new CHttpException(404);

        $this->performAjaxValidation($model);
        Yii::app()->clientScript->scriptMap['jquery.js']=false;

        if (isset($_POST['LoanTransactions'])) {
            $model->attributes = $_POST['LoanTransactions'];
            if ($model->save()) {
                echo CJSON::encode([
                    'status'=>'success',
                    'content'=>'<div class="alert alert-success">Updated successfully</div>'
                ]);
            } else {
                echo CJSON::encode([
                    'status'=>'failure',
                    'content'=>$this->renderPartial('_form', ['model'=>$model], true, true)
                ]);
            }
            Yii::app()->end();
        }

        echo CJSON::encode([
            'status'=>'failure',
            'content'=>$this->renderPartial('_form', ['model'=>$model], true, true)
        ]);
        Yii::app()->end();
    }

    public function actionGetPersonBalance()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(400, 'Invalid request');
        }

        $personId = Yii::app()->request->getPost('person_id');

        if (!$personId) {
            echo CJSON::encode(['balance' => 0]);
            Yii::app()->end();
        }

        // +amount = person owes you
        // -amount = you owe person
        $balance = Yii::app()->db->createCommand()
            ->select('SUM(
            CASE 
                WHEN transaction_type = "lend" THEN amount
                WHEN transaction_type = "borrow" THEN -amount
                ELSE 0
            END
        ) AS balance')
            ->from('loan_transactions')
            ->where('person_id = :pid', [':pid' => $personId])
            ->queryScalar();

        echo CJSON::encode([
            'balance' => round((float)$balance, 2),
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LoanTransactions');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LoanTransactions('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LoanTransactions']))
			$model->attributes=$_GET['LoanTransactions'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LoanTransactions the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LoanTransactions::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LoanTransactions $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='loan-transactions-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
