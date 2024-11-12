<?php

class ProdModelsController extends RController
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
            -Jquery_showprodSearch
            -Jquery_showprodCodeSearch
            -SubCatOfThisCat',
        );
    }

    public function allowedActions()
    {
        return '';
    }

    public function actionJquery_showprodSearch()
    {
        $search_prodName = isset($_POST['q']) ? trim($_POST['q']) : '';
        $term = isset($_REQUEST['term']) ? trim($_REQUEST['term']) : '';
        $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : [];
        $item_id_excluded = isset($_POST['item_id_excluded']) ? trim($_POST['item_id_excluded']) : false;
        $criteria = new CDbCriteria();
        if(strlen($search_prodName) > 0){
            $criteria2 = new CDbCriteria();
            $criteria2->compare('t.model_name', $search_prodName, true);
            $criteria2->compare('t.code', $search_prodName, true, "OR");
            $criteria->mergeWith($criteria2);
        }
        if (strlen($term) > 0) {
            $critera3 = new CDbCriteria();
            $critera3->compare('t.model_name', $term, true);
            $critera3->compare('t.code', $term, true, "OR");
            $criteria->mergeWith($critera3, 'OR');
        }
        if (count($item_id) > 0) {
            if (!$item_id_excluded)
                $criteria->addInCondition('t.item_id', $item_id);
            else
                $criteria->addNotInCondition('t.item_id', $item_id);
        }
        $criteria->order = "t.model_name asc";
        $criteria->limit = 20;
        $prodInfos = ProdModels::model()->findAll($criteria);
        if ($prodInfos) {
            foreach ($prodInfos as $prodInfo) {
                if ($prodInfo->stockable) {
                    $stock = Inventory::model()->closingStock($prodInfo->id);
                } else {
                    $stock = 0;
                }

                $code = $prodInfo->code;
                $value = "$prodInfo->model_name || $code";
                $label = "$prodInfo->model_name || $code";
                $id = $prodInfo->id;
                $name = $prodInfo->model_name;
                $purchasePrice = $prodInfo->purchase_price;
                $item_id = $prodInfo->item_id;
                $brand_id = $prodInfo->brand_id;
                $unit_id = $prodInfo->unit_id;
                $warranty = $prodInfo->warranty;

                $sellPrice = $prodInfo->sell_price;
                $sellDiscount = 0;

                $imageWithUrl = $prodInfo->image != "" ? Yii::app()->baseUrl . "/uploads/products/$prodInfo->image" : Yii::app()->theme->baseUrl . "/images/no-image.jpg";
                $results[] = array(
                    'id' => $id,
                    'name' => $name,
                    'value' => $value,
                    'label' => $label,
                    'item_id' => $item_id,
                    'brand_id' => $brand_id,
                    'code' => $code,
                    'warranty' => $warranty,
                    'purchasePrice' => $purchasePrice,
                    'sell_price' => $sellPrice,
                    'unit_id' => $unit_id,
                    'sellDiscount' => $sellDiscount,
                    'img' => $imageWithUrl,
                    'stock' => $stock,
                );
            }
        } else {
            $imageWithUrl = Yii::app()->theme->baseUrl . "/images/no-image.jpg";
            $results[] = array(
                'id' => '',
                'name' => 'No data found!',
                'value' => 'No data found!',
                'label' => 'No data found!',
                'item_id' => '',
                'brand_id' => '',
                'code' => '',
                'warranty' => '',
                'purchasePrice' => '',
                'sell_price' => '',
                'unit_id' => '',
                'sellDiscount' => '',
                'img' => $imageWithUrl,
                'stock' => '',
            );
        }
        echo json_encode($results);
    }


    public function actionJquery_showprodCodeSearch()
    {
        $search_prodName = trim($_POST['q']);
        $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : [];
        $item_id_excluded = isset($_POST['item_id_excluded']) ? trim($_POST['item_id_excluded']) : false;

        $criteria2 = new CDbCriteria();
        $criteria2->compare('code', $search_prodName);

        $criteria = new CDbCriteria();
        $criteria->mergeWith($criteria2);
        if (count($item_id) > 0) {
            if (!$item_id_excluded)
                $criteria->addInCondition('item_id', $item_id);
            else
                $criteria->addNotInCondition('item_id', $item_id);
        }
        $criteria->order = "code asc";
        $criteria->limit = 20;
        $prodInfos = ProdModels::model()->findAll($criteria);
        if ($prodInfos) {
            foreach ($prodInfos as $prodInfo) {
                if ($prodInfo->stockable) {
                    $stock = Inventory::model()->closingStock($prodInfo->id);
                } else {
                    $stock = 0;
                }
                $code = $prodInfo->code;
                $value = "$prodInfo->model_name || $code";
                $label = "$prodInfo->model_name || $code";
                $id = $prodInfo->id;
                $name = $prodInfo->model_name;
                $purchasePrice = $prodInfo->purchase_price;
                $item_id = $prodInfo->item_id;
                $brand_id = $prodInfo->brand_id;
                $unit_id = $prodInfo->unit_id;
                $warranty = $prodInfo->warranty;
                $activeInfos = SellPrice::model()->activeInfos($prodInfo->id);
                $sellPrice = $sellDiscount = 0;
                if ($activeInfos) {
                    $sellPrice = $activeInfos->sell_price;
                    $sellDiscount = $activeInfos->discount;
                }
                $imageWithUrl = $prodInfo->image != "" ? Yii::app()->baseUrl . "/uploads/products/$prodInfo->image" : Yii::app()->theme->baseUrl . "/images/no-image.jpg";
                $results[] = array(
                    'id' => $id,
                    'name' => $name,
                    'value' => $value,
                    'label' => $label,
                    'item_id' => $item_id,
                    'brand_id' => $brand_id,
                    'code' => $code,
                    'warranty' => $warranty,
                    'purchasePrice' => $purchasePrice,
                    'sell_price' => $sellPrice,
                    'unit_id' => $unit_id,
                    'sellDiscount' => $sellDiscount,
                    'img' => $imageWithUrl,
                    'stock' => $stock,
                );
            }
        } else {
            $imageWithUrl = Yii::app()->theme->baseUrl . "/images/no-image.jpg";
            $results[] = array(
                'id' => '',
                'name' => 'No data found!',
                'value' => 'No data found!',
                'label' => 'No data found!',
                'item_id' => '',
                'brand_id' => '',
                'code' => '',
                'warranty' => '',
                'sell_price' => '',
                'unit_id' => '',
                'purchasePrice' => '',
                'sellDiscount' => '',
                'img' => $imageWithUrl,
                'stock' => '',
            );
        }
        echo json_encode($results);
    }

    public function actionSubCatOfThisCat()
    {
        $catId = trim($_POST['catId']);
        $subCatList = '';

        if ($catId != '') {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['item_id' => $catId]);
            $criteria->order = 'brand_name asc';
            $data = ProdBrands::model()->findAll($criteria);
            if ($data) {
                $subCatList = CHtml::tag('option', array('value' => ''), 'Select', true);
                foreach ($data as $d) {
                    $subCatList .= CHtml::tag('option', array('value' => $d->id), CHtml::decode($d->brand_name), true);
                }
            } else {
                $subCatList = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        } else {
            $criteria = new CDbCriteria();
            $criteria->order = 'brand_name asc';
            $data = ProdBrands::model()->findAll($criteria);
            if ($data) {
                $subCatList = CHtml::tag('option', array('value' => ""), "Select", true);
                foreach ($data as $d) {
                    $subCatList .= CHtml::tag('option', array('value' => $d->id), CHtml::decode($d->brand_name), true);
                }
            } else {
                $subCatList = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        }
        echo CJSON::encode(array(
            'subCatList' => $subCatList,
        ));
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->renderPartial('view', array('model' => $model,));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionCreateProdModelsFromOutSide()
    {
        $model = new ProdModels;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ProdModels'])) {
            $model->attributes = $_POST['ProdModels'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = ProdModels::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => '<div class="alert alert-success">
                                      Successfully created!
                                    </div>',
                        'value' => $data->id,
                        'label' => $data->model_name,
                        'code' => $data->code,
                        'unit_id' => $data->unit_id,
                        'item_id' => $data->item_id,
                        'brand_id' => $data->brand_id,
                    ));
                    exit;
                } else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form3', array('model' => $model), true)));
            exit;
        } else
            $this->render('create', array('model' => $model,));
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ProdModels;
        $this->performAjaxValidation(array($model));
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation(array($model));

        if (isset($_POST['ProdModels'])) {
            $model->attributes = $_POST['ProdModels'];

            $imageUploadFile = CUploadedFile::getInstance($model, 'image2');
            if ($imageUploadFile !== null) { // only do if file is really uploaded
                $imageFileName = time() . uniqid() . "." . $imageUploadFile->getExtensionName();
                $model->image = $imageFileName;
            }


            if ($model->save()) {
                if ($imageUploadFile !== null) {
                    $pathImage = Yii::getPathOfAlias('webroot') . '/uploads/products/';

                    if (!is_dir($pathImage)) {
                        mkdir($pathImage, 0777, true);
                    }
                    $newFile = $pathImage . $imageFileName;
                    $imageUploadFile->saveAs($newFile);
                }
                if ($model->sell_price > 0) {
                    $sellPrice = SellPrice::model()->activeSellPriceOnly($model->id);
                    if ($model->sell_price != $sellPrice) {
                        $sp = new SellPrice();
                        $sp->model_id = $model->id;
                        $sp->sell_price = $model->sell_price;
                        $sp->is_active = SellPrice::ACTIVE;
                        $sp->save();
                    }
                }
                $this->redirect(array('admin'));
            }
        }


        $this->pageTitle = "CREATE MATERIAL";
        $this->render('_form', array(
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
        $this->performAjaxValidation(array($model));

        if (isset($_POST['ProdModels'])) {
            $model->attributes = $_POST['ProdModels'];

            $imageUploadFile = CUploadedFile::getInstance($model, 'image2');
            if ($imageUploadFile !== null) { // only do if file is really uploaded
                $imageFileName = time() . uniqid() . "." . $imageUploadFile->getExtensionName();
                $model->image = $imageFileName;
            }


            if ($model->save()) {
                if ($imageUploadFile !== null) {
                    $pathImage = Yii::getPathOfAlias('webroot') . '/uploads/products/';

                    if (!is_dir($pathImage)) {
                        mkdir($pathImage, 0777, true);
                    }
                    $newFile = $pathImage . $imageFileName;
                    $imageUploadFile->saveAs($newFile);
                }
                if ($model->sell_price > 0) {
                    $sellPrice = SellPrice::model()->activeSellPriceOnly($model->id);
                    if ($model->sell_price != $sellPrice) {
                        $sp = new SellPrice();
                        $sp->model_id = $model->id;
                        $sp->sell_price = $model->sell_price;
                        $sp->is_active = SellPrice::ACTIVE;
                        $sp->save();
                    }
                }
                $this->redirect(array('admin'));
            }
        }

        $this->pageTitle = "UPDATE MATERIAL: $model->model_name";
        $this->render('_form2', array(
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
        $model = new ProdModels('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProdModels']))
            $model->attributes = $_GET['ProdModels'];
        $this->pageTitle = "MANAGE MATERIAL";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminSellPrice()
    {
        $model = new ProdModels('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProdModels']))
            $model->attributes = $_GET['ProdModels'];
        $this->pageTitle = "MANAGE SELL PRICE";
        $this->render('adminSellPrice', array(
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
        $model = ProdModels::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'prod-models-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
