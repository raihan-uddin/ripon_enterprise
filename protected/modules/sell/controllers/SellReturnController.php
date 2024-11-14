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
			if(isset($_POST['SellReturn']))
			{
				$sell_id = $_POST['SellReturn']['sell_id'];
				$sell = SellOrder::model()->findByPk($sell_id);
				if($sell === null){
					echo json_encode(['status' => 'error', 'message' => 'Invalid sell order']);
					Yii::app()->end();
				}
				// db transaction
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$model->attributes=$_POST['SellReturn'];
					$model->customer_id = $_POST['SellReturn']['customer_id'];
					$model->discount = 0;
					$model->discount_percentage = 0;
					$model->costing = 0;
					$model->return_type = SellReturn::CASH_RETURN;
					$model->remarks = $_POST['SellReturn']['remarks'];
					$model->status = SellReturn::RETURN_STATUS_PENDING;
					$model->sell_id = $_POST['SellReturn']['sell_id'];
					$model->return_amount = $_POST['SellReturn']['return_amount'];
					$model->is_deleted = 0;
					if($model->save()){
						$costing = 0;
						$detailsData = $_POST['SellReturnDetails']['model_id'];
						$challan_no = $sl_no = Inventory::maxSlNo() + 1;
						foreach ($detailsData as $key =>  $detail){
							$model_id = $_POST['SellReturnDetails']['model_id'][$key];
							$product = ProdModels::model()->findByPk($model_id);

							$detailModel = new SellReturnDetails();
							$detailModel->return_id = $model->id;
							$detailModel->model_id = $model_id;
							$detailModel->return_qty = $_POST['SellReturnDetails']['qty'][$key];
							$detailModel->sell_price = $_POST['SellReturnDetails']['sell_price'][$key];
							$detailModel->purchase_price = $_POST['SellReturnDetails']['purchase_price'][$key];
							$detailModel->product_sl_no = $_POST['SellReturnDetails']['product_sl_no'][$key];
							$detailModel->row_total = $_POST['SellReturnDetails']['row_total'][$key];
							$detailModel->costing = $_POST['SellReturnDetails']['purchase_price'][$key] * $_POST['SellReturnDetails']['qty'][$key];
							$detailModel->discount_amount = 0;
							$detailModel->discount_percentage = 0;
							$detailModel->created_by = Yii::app()->user->id;
							$detailModel->created_at = date('Y-m-d H:i:s');
							$detailModel->is_deleted = 0;
							if(!$detailModel->save()){
								throw new Exception('Product return details creation failed');
							}
							$costing += $detailModel->costing;
							// insert into stock
							$stock = new Inventory();
							$stock->date = $model->return_date;
							$stock->challan_no =  $challan_no;
							$stock->sl_no = $sl_no;
							$stock->model_id = $detailModel->model_id;
							$stock->product_sl_no = $detailModel->product_sl_no;
							$stock->stock_in = $detailModel->return_qty;
							$stock->stock_out = 0;
							$stock->sell_price = $product->sell_price;
							$stock->purchase_price = $product->purchase_price;
							$stock->row_total = $product->purchase_price * $detailModel->return_qty;
							$stock->stock_status = Inventory::CASH_SALE_RETURN;
							$stock->master_id = $model->id;
							$stock->source_id = $detailModel->id;
							$stock->remarks = $model->remarks;
							if(!$stock->save()){
								throw new Exception('Stock creation failed');
							}
						}
						$model->costing = $costing;
						$model->save();

						SellOrder::model()->changePaidDue($sell);

						$transaction->commit();

						echo CJSON::encode(array(
							'status' => 'success',
							'voucherPreview' => $this->renderPartial('warrantyVoucherPreview', array('data' => $model, 'new' => true), true, true), //
						));
						Yii::app()->end();
					}
				}catch(Exception $e){
					if($transaction->active){
						$transaction->rollback();
					}
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
		// begin db transaction
		$transaction = Yii::app()->db->beginTransaction();
		try{
			// load model
			$model = $this->loadModel($id);
			// hard delete all details
			$details = SellReturnDetails::model()->findAllByAttributes(['return_id' => $model->id]);
			foreach ($details as $detail){
				// delete return inventory
				$criteraInv = new CDbCriteria();
				$criteraInv->addColumnCondition(['source_id' => $detail->id, 'master_id' => $model->id]);
				$criteraInv->addInCondition('stock_status', [Inventory::WARRANTY_RETURN, Inventory::CASH_SALE_RETURN]);
				$inventory = Inventory::model()->findAll($criteraInv);
				foreach ($inventory as $inv){
					if(!$inv->delete()){
						throw new Exception('Inventory delete failed');
					}
				}
				// delete replacement inventory
				if($detail->replace_model_id > 0){
					$criteraInvReplace = new CDbCriteria();
					$criteraInvReplace->addColumnCondition(['master_id' => $model->id, 'model_id' => $detail->replace_model_id]);
					$criteraInvReplace->addInCondition('stock_status', [Inventory::WARRANTY_RETURN, Inventory::CASH_SALE_RETURN]);
					$inventoryReplace = Inventory::model()->findAll($criteraInvReplace);
					foreach ($inventoryReplace as $invReplace){
						if(!$invReplace->delete()){
							throw new Exception('Inventory delete failed');
						}
					}
				}

				if(!$detail->delete()){
					throw new Exception('Return Detail delete failed');
				}
			}
			
			// recalculate amount
			$sell = SellOrder::model()->findByPk($model->sell_id);
			if($sell){
				SellOrder::model()->changePaidDue($sell);
			}
			if(!$model->delete()){
				throw new Exception('Return delete failed');
			}
			
			$transaction->commit();
		}
		catch(Exception $e){
			$transaction->rollback();
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}

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

		$this->pageTitle = "SALE RETURN LIST";
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionApprove($id){
		$model = $this->loadModel($id);
		if(isset($_POST['SellReturnDetails'])){
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;

			// db transaction
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if (isset($SellReturnDetails['id'], $SellReturnDetails['replace_model_id'])) {
					foreach ($SellReturnDetails['id'] as $index => $id) {
						// Retrieve corresponding values with a fallback if values are missing
						$replaceModelId = $SellReturnDetails['replace_model_id'][$index] ?? 'N/A';
						$replaceProductSlNo = $SellReturnDetails['replace_product_sl_no'][$index] ?? 'N/A';

						echo sprintf(
							"ID: %s, Replace Model ID: %s, Replace Product Serial No: %s\n",
							$id,
							$replaceModelId,
							$replaceProductSlNo
						);

						// Here you can handle further processing, like inserting into a database
					}
				} else {
					echo 'Invalid request';
				}

				Yii::app()->end();
				$model->status = SellReturn::RETURN_STATUS_APPROVED;
				// $model->approved_by = Yii::app()->user->id;
				// $model->approved_at = date('Y-m-d H:i:s');
				if(!$model->save()){
					throw new Exception('Approval failed');
				}
				// update inventory
				if($model->return_type == SellReturn::DAMAGE_RETURN){
					foreach($_POST['SellReturnDetails'][''] as $detail){

					}
					$details = SellReturnDetails::model()->findAllByAttributes(['return_id' => $model->id]);
					foreach ($details as $detail){
						// delete previous inventory replacement model
						if($detail->replace_model_id > 0){
							// delete previous inventory replacement model
							$criteria = new CDbCriteria();
							$criteria->addColumnCondition(['master_id' => $model->id]);
							$criteria->addInCondition('stock_status', [Inventory::PRODUCT_REPLACEMENT]);
							$inventory = Inventory::model()->findAll($criteria);
							foreach ($inventory as $inv){
								if(!$inv->delete()){
									throw new Exception('Previous Approved Inventory delete failed');
								}
							}

							// insert new inventory replacement model
							$stock = new Inventory();
							$stock->date = $model->return_date;
							$stock->challan_no = Inventory::maxSlNo() + 1;
							$stock->sl_no = Inventory::maxSlNo() + 1;

						}
						if($detail->replace_model_id > 0){

						}
					}
				}
				$transaction->commit();
				echo json_encode(['status' => 'success', 'message' => 'Approved successfully']);
				Yii::app()->end();

			} catch (Exception $e) {
				$transaction->rollback();
				echo json_encode(['status' => 'error', 'message' => 'Approval failed']);
				Yii::app()->end();
			}
			Yii::app()->end();
		} else {
			$this->pageTitle = "SALE RETURN APPROVE";
			$this->render('_formProductReturnApprove', array('model' => $model));
		}
	}

	public function actionVoucherPreview(){
		if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }
		$id = isset($_POST['id']) ? trim($_POST['id']) : "";
		if(!($id > 0)){
			echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
			Yii::app()->end();
		}

		$data = $this->loadModel($id);
		echo $this->renderPartial('warrantyVoucherPreview', array('data' => $data,), true, true);
		Yii::app()->end();
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
