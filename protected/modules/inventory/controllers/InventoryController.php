<?php

class InventoryController extends Controller
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
            -Jquery_showprodSlNoSearch
            -Jquery_getStockQty',
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

    public function allowedActions()
    {
        return '';
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Inventory();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Inventory'])) {
            $model->attributes = $_POST['Inventory'];
            $model->sl_no = $sl_no = Inventory::maxSlNo();
            $model->model_id = 1;//dummy for save
            $model->challan_no = str_pad($sl_no, 6, '0', STR_PAD_LEFT);
            $model->stock_status = Inventory::MANUAL_ENTRY;

            $t_type = $_POST['Inventory']['t_type'];
            if ($t_type == Inventory::STOCK_IN) {
                $challan_no = "GRN-" . $model->challan_no;
            } else {
                $challan_no = "GI-" . $model->challan_no;
            }
            if ($model->validate()) {
                foreach ($_POST['Inventory']['temp_model_id'] as $key => $model_id) {
                    $model2 = new Inventory();
                    $model2->sl_no = $sl_no;
                    $model2->challan_no = $challan_no;
                    $model2->model_id = $model_id;
                    $model2->date = $_POST['Inventory']['date'];
                    $model2->product_sl_no = $_POST['Inventory']['temp_product_sl_no'][$key];
                    $model2->store_id = $_POST['Inventory']['store_id'];
                    $model2->location_id = $_POST['Inventory']['location_id'];
                    if ($t_type == Inventory::STOCK_IN) {
                        $model2->stock_in = $_POST['Inventory']['temp_stock_in'][$key] > 0 ? $_POST['Inventory']['temp_stock_in'][$key] : $_POST['Inventory']['temp_stock_out'][$key];
                    } else {
                        $model2->stock_out = $_POST['Inventory']['temp_stock_out'][$key] > 0 ? $_POST['Inventory']['temp_stock_out'][$key] : $_POST['Inventory']['temp_stock_in'][$key];
                    }
                    $model2->sell_price = $_POST['Inventory']['temp_sell_price'][$key];
                    $model2->row_total = $model2->stock_in > 0 ? round($model2->stock_in * $model2->sell_price, 2) : round($model2->stock_out * $model2->sell_price, 2);
                    $model2->stock_status = Inventory::MANUAL_ENTRY;
                    $model2->source_id = Inventory::SOURCE_DEFAULT;
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

        $this->pageTitle = 'INVENTORY';
        $this->render('create', array(
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
        $model = new Inventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Inventory']))
            $model->attributes = $_GET['Inventory'];

        $this->pageTitle = "INVENTORY";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Inventory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Inventory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Inventory $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionVoucherPreview()
    {
        $challan_no = isset($_POST['challan_no']) ? trim($_POST['challan_no']) : "";

        if ($challan_no != "") {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pm.model_name, pm.unit_id";
            $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id";
            $criteria->addColumnCondition(['challan_no' => $challan_no]);
            $data = Inventory::model()->findAll($criteria);
            if ($data) {
                echo $this->renderPartial("voucherPreview", array('data' => $data,), true, true);
            } else {
                header('Content-type: application/json');
                echo CJSON::encode(array(
                    'status' => 'error',
                ));
            }
            Yii::app()->end();
        } else {
            echo '<div class="flash-error">Please select sales invoice no!</div>';
        }
    }


    public function actionJquery_getStockQty()
    {
        $model_id = isset($_POST['model_id']) ? $_POST['model_id'] : 0;
        $store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
        $location_id = isset($_POST['location_id']) ? $_POST['location_id'] : 0;
        $stock = Inventory::model()->closingStock($model_id, $store_id, $location_id);
        echo json_encode($stock);
    }


    public function actionJquery_showprodSlNoSearch()
    {
        $search_prodName = trim($_POST['q']);

        $criteria2 = new CDbCriteria();
        $criteria2->compare('product_sl_no', $search_prodName);
        $criteria2->addCondition("product_sl_no IS NOT NULL");

        $criteria = new CDbCriteria();
        $criteria->mergeWith($criteria2);
        $criteria->select = "pm.code, pm.model_name, pm.id, pm.item_id, pm.brand_id, pm.unit_id, pm.warranty, pm.image";
        $criteria->order = "product_sl_no asc";
        $criteria->join = "INNER JOIN prod_models pm on t.model_id = pm.id ";
        $criteria->limit = 20;
        $prodInfos = Inventory::model()->findAll($criteria);
        if ($prodInfos) {
            foreach ($prodInfos as $prodInfo) {
                $code = $prodInfo->code;
                $value = "$prodInfo->model_name || $code";
                $label = "$prodInfo->model_name || $code";
                $id = $prodInfo->id;
                $name = $prodInfo->model_name;
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
                    'sell_price' => $sellPrice,
                    'unit_id' => $unit_id,
                    'sellDiscount' => $sellDiscount,
                    'img' => $imageWithUrl,
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
                'sellDiscount' => '',
                'img' => $imageWithUrl,
            );
        }
        echo json_encode($results);
    }

}
