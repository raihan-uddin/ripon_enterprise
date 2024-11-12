<?php

class SellReturnController extends RController
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SellReturn();
        $model2 = new SellReturnDetails();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SellReturn']))
		{
			$model->attributes=$_POST['SellReturn'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

        $this->pageTitle = "CASH RETURN CREATE";
        $this->render('_formCashReturn', array(
			'model'=>$model,
            'model2' => $model2,
		));
	}

	/**
	 * Create a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateProductReturn(){
		$model=new SellReturn();
        $model2 = new SellReturnDetails();

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		if (Yii::app()->request->isAjaxRequest) {
			// db transaction
			$transaction = Yii::app()->db->beginTransaction();
			if(isset($_POST['SellReturn']))
			{
				try{
					$model->attributes=$_POST['SellReturn'];
					$model->customer_id = $_POST['SellReturn']['customer_id'];
					$model->return_amount = 0;
					$model->discount = 0;
					$model->discount_percentage = 0;
					$model->costing = 0;
					$model->return_type = SellReturn::DAMAGE_RETURN;
					$model->remarks = $_POST['SellReturn']['remarks'];
					$model->status = SellReturn::RETURN_STATUS_PENDING;
					$model->is_deleted = 0;
					if($model->save()){
						$detailsData = $_POST['SellReturnDetails']['model_id'];
						
						foreach ($detailsData as $key =>  $detail){
							$detailModel = new SellReturnDetails();
							$detailModel->return_id = $model->id;
							$detailModel->model_id = $_POST['SellReturnDetails']['model_id'][$key];
							$detailModel->return_qty = $_POST['SellReturnDetails']['qty'][$key];
							$detailModel->sell_price = 0;
							$detailModel->purchase_price = 0;
							$detailModel->product_sl_no = $_POST['SellReturnDetails']['product_sl_no'][$key];
							$detailModel->row_total = 0;
							$detailModel->costing = 0;
							$detailModel->discount_amount = 0;
							$detailModel->discount_percentage = 0;
							$detailModel->created_by = Yii::app()->user->id;
							$detailModel->created_at = date('Y-m-d H:i:s');
							$detailModel->is_deleted = 0;
							if(!$detailModel->save()){
								throw new Exception('Product return details creation failed');
							}
						}
						$transaction->commit();
						echo CJSON::encode(array(
							'status' => 'success',
							// 'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $data, 'new' => true), true, true), //
						));
					}
				}catch(Exception $e){
					$transaction->rollback();
					echo json_encode(['status' => 'error', 'message' => 'Product return creation failed' . $e->getMessage()]);
					Yii::app()->end();
				}
			}
		}

        $this->pageTitle = "PRODUCT RETURN CREATE";
        $this->render('_formProductReturn', array(
			'model'=>$model,
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SellReturn']))
		{
			$model->attributes=$_POST['SellReturn'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}



	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SellReturn('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SellReturn']))
			$model->attributes=$_GET['SellReturn'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SellReturn the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SellReturn::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SellReturn $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sell-return-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
