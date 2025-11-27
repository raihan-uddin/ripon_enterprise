<?php

class InventoryController extends RController
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
            -VoucherPreview
            -Jquery_showprodSlNoSearch
            -removeProductSlFromCurrentStock
            -fetchProductPrice
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
                    $prodmodel = ProdModels::model()->findByPk($model_id);
                    $purchase_price = $prodmodel->purchase_price;
                    $productSlNo = Inventory::model()->findByAttributes([
                        'product_sl_no' => $_POST['Inventory']['temp_product_sl_no'][$key],
                        'model_id' => $model_id,
                    ]);
                    if ($productSlNo) {
                        $purchase_price = $productSlNo->purchase_price;
                    }
                    $model2 = new Inventory();
                    $model2->sl_no = $sl_no;
                    $model2->challan_no = $challan_no;
                    $model2->model_id = $model_id;
                    $model2->date = $_POST['Inventory']['date'];
                    $model2->product_sl_no = $_POST['Inventory']['temp_product_sl_no'][$key];
                    $model2->purchase_price = $purchase_price;
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

    public function actionVerifyProduct()
    {
        $model = new Inventory('search');
        // check if request is ajax
        if (Yii::app()->request->isAjaxRequest) {
            $product_sl = isset($_POST['product_sl']) ? $_POST['product_sl'] : "";
            $criteria = new CDbCriteria();
            $criteria->select = "t.*, pm.model_name, 
                                c.company_name as customer_name, c.id as customer_id, c.customer_code, c.owner_mobile_no as customer_contact_no,
                                s.company_name as supplier_name, s.id as supplier_id, s.company_contact_no as supplier_contact_no, 
                                po.po_no, so.so_no as invoice_no, sod.warranty as sales_warranty";
            $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id";
            $criteria->join .= " LEFT JOIN sell_order so on t.master_id = so.id and t.stock_status = 3";
            $criteria->join .= " LEFT JOIN sell_order_details sod on t.source_id = sod.id and t.stock_status = 3";
            $criteria->join .= " LEFT JOIN customers c on so.customer_id = c.id";
            $criteria->join .= " LEFT JOIN purchase_order po on t.master_id = po.id and t.stock_status = 1";
            $criteria->join .= " LEFT JOIN suppliers s on po.supplier_id = s.id";
            $criteria->addColumnCondition(['t.product_sl_no' => trim($product_sl)]);
            $data = Inventory::model()->findAll($criteria);
            if ($data) {
                echo $this->renderPartial('verifyProductResult', array('model' => $model, 'data' => $data, 'product_sl' => $product_sl), true, true);
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>SL No: ' . $product_sl . '</strong> not found!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
            Yii::app()->end();
        }

        $this->pageTitle = "PRODUCT VERIFY";
        $this->render('_verifyProduct', array(
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
        $challan_no = isset($_POST['challan_no']) ? ($_POST['challan_no']) : "";

        if ($challan_no != "") {
            $criteria = new CDbCriteria;
            $criteria->select = "t.*, pm.model_name, pm.unit_id";
            $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id";
            $criteria->addColumnCondition(['challan_no' => trim($challan_no)]);
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
        Yii::app()->end();
    }


    public function actionJquery_getStockQty()
    {
        $model_id = isset($_POST['model_id']) ? $_POST['model_id'] : 0;
        $product_sl_no = isset($_POST['product_sl_no']) ? $_POST['product_sl_no'] : "";
        $stock = Inventory::model()->closingStock($model_id, $product_sl_no);
        echo json_encode($stock);
        Yii::app()->end();
    }


    public function actionJquery_showprodSlNoSearch()
    {
        $search_prodName = trim($_POST['q']);
        $model_id = isset($_POST['model_id']) ? trim($_POST['model_id']) : 0;
        $show_all = isset($_POST['show_all']) ? trim($_POST['show_all']) : Inventory::SHOW_ALL_PRODUCT_SL_NO;

        $criteria2 = new CDbCriteria();
        $criteria2->compare('product_sl_no', $search_prodName);
        if ($model_id > 0) {
            $criteria2->addColumnCondition(['model_id' => $model_id]);
        }
        $criteria2->addCondition("product_sl_no IS NOT NULL");

        $criteria = new CDbCriteria();
        $criteria->mergeWith($criteria2);
        $criteria->select = "pm.code, pm.model_name, pm.id, pm.item_id, pm.brand_id, pm.unit_id, pm.warranty, pm.image, 
                            product_sl_no, SUM(t.stock_in - t.stock_out) as stock, t.purchase_price, pm.sell_price";
        $criteria->order = "product_sl_no asc";
        $criteria->join = "INNER JOIN prod_models pm on t.model_id = pm.id ";
        if ($show_all == 2) {
            $criteria->having = 'stock > 0';
        }
        $criteria->group = 't.model_id, t.product_sl_no';
        $criteria->limit = 20;
        $criteria->addCondition('product_sl_no IS NOT NULL AND product_sl_no != ""');
        $prodInfos = Inventory::model()->findAll($criteria);
        if ($prodInfos) {
            foreach ($prodInfos as $prodInfo) {
                $code = $prodInfo->code;
                $value = "$prodInfo->product_sl_no";
                $label = "$prodInfo->model_name || $code";
                $id = $prodInfo->id;
                $name = $prodInfo->model_name;
                $product_sl_no = $prodInfo->product_sl_no;
                $item_id = $prodInfo->item_id;
                $brand_id = $prodInfo->brand_id;
                $unit_id = $prodInfo->unit_id;
                $warranty = $prodInfo->warranty;
                $purchase_price = $prodInfo->purchase_price;
                $sellPrice = $prodInfo->sell_price;
                $sellDiscount = 0;

                $imageWithUrl = $prodInfo->image != "" ? Yii::app()->baseUrl . "/uploads/products/$prodInfo->image" : Yii::app()->theme->baseUrl . "/images/no-image.jpg";
                $results[] = array(
                    'id' => $id,
                    'product_sl_no' => $product_sl_no,
                    'stock' => $prodInfo->stock,
                    'name' => $name,
                    'value' => $value,
                    'label' => $label,
                    'item_id' => $item_id,
                    'brand_id' => $brand_id,
                    'code' => $code,
                    'warranty' => $warranty,
                    'sell_price' => $sellPrice,
                    'unit_id' => $unit_id,
                    'purchasePrice' => $purchase_price,
                    'sellDiscount' => $sellDiscount,
                    'img' => $imageWithUrl,
                );
            }
        } else {
            $imageWithUrl = Yii::app()->theme->baseUrl . "/images/no-image.jpg";
            $results[] = array(
                'id' => '',
                'product_sl_no' => '',
                'name' => 'No data found!',
                'value' => 'No data found!',
                'label' => 'No data found!',
                'purchasePrice' => '',
                'item_id' => '',
                'brand_id' => '',
                'code' => '',
                'warranty' => '',
                'sell_price' => '',
                'unit_id' => '',
                'sellDiscount' => '',
                'stock' => '',
                'img' => $imageWithUrl,
            );
        }
        echo json_encode($results);
    }


    public function actionStockReport()
    {
        $model = new Inventory();
        $this->pageTitle = 'STOCK REPORT';
        $this->render('stockReport', array('model' => $model));
    }

    public function actionStockReportView()
    {

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $dateFrom = $_POST['Inventory']['date_from'];
        $dateTo = $_POST['Inventory']['date_to'];
        $model_id = $_POST['Inventory']['model_id'];
        $manufacturer_id = $_POST['Inventory']['manufacturer_id'];
        $item_id = $_POST['Inventory']['item_id'];
        $brand_id = $_POST['Inventory']['brand_id'];

        $message = "";
        $data = "";

        if ($dateFrom != "" && $dateTo != '') {
            $criteria = new CDbCriteria;
            $criteria->select = "
            t.model_name, t.code, inv.model_id, t.sell_price, t.purchase_price as cpp, 
            c.name as manufacturer_name,
            IFNULL((SELECT (SUM(op.stock_in) - SUM(op.stock_out)) FROM inventory op where op.date < '$dateFrom' AND op.model_id = t.id AND op.is_deleted = 0), 0) as opening_stock,
            IFNULL((SELECT (SUM(op.stock_in*op.purchase_price) - SUM(op.stock_out*op.purchase_price)) FROM inventory op where op.date < '$dateFrom' AND op.model_id = t.id  AND op.is_deleted = 0), 0) as opening_stock_value,
            SUM(CASE WHEN (inv.date BETWEEN '$dateFrom' AND '$dateTo') THEN inv.stock_in ELSE 0 END) as stock_in, 
            SUM(CASE WHEN (inv.date BETWEEN '$dateFrom' AND '$dateTo') THEN inv.stock_out ELSE 0 END) as stock_out,
            SUM(CASE WHEN (inv.date BETWEEN '$dateFrom' AND '$dateTo') THEN (inv.stock_in * inv.purchase_price) ELSE 0 END) as stock_in_value, 
            SUM(CASE WHEN (inv.date BETWEEN '$dateFrom' AND '$dateTo') THEN (inv.stock_out * inv.purchase_price) ELSE 0 END) as stock_out_value,
            AVG(CASE WHEN inv.stock_status = 1 THEN inv.purchase_price END) AS avg_purchase_price
            ";
            // get the purchase avg price if stock_status = 1

            $message .= "Stock Report from  $dateFrom To $dateTo";

            $criteria->addColumnCondition(['stockable' => 1]);

            if ($model_id > 0) {
                $criteria->addColumnCondition(['t.id' => $model_id]);
            }
            if ($manufacturer_id > 0) {
                $criteria->addColumnCondition(['t.manufacturer_id' => $manufacturer_id]);
            }
            if ($item_id > 0) {
                $criteria->addColumnCondition(['t.item_id' => $item_id]);
            }
            if ($brand_id > 0) {
                $criteria->addColumnCondition(['t.brand_id' => $brand_id]);
            }

            $criteria->addColumnCondition(['inv.is_deleted' => 0]);

            $criteria->join = " LEFT JOIN inventory inv  on inv.model_id = t.id ";
            $criteria->join .= " LEFT JOIN companies c ON t.manufacturer_id = c.id ";
            $criteria->group = " t.id ";
            $criteria->order = 't.model_name ASC';
            $data = ProdModels::model()->findAll($criteria);
        } else {
            $message = "<div class='flash-error'>Please select date range!</div>";
        }
        echo $this->renderPartial('stockReportView', array(
            'data' => $data,
            'startDate' => $dateFrom,
            'endDate' => $dateTo,
            'message' => $message,
        ), true, true);
        Yii::app()->end();
    }


    public function actionStockReportSupplierWise()
    {
        $model = new Inventory();
        $this->pageTitle = 'STOCK REPORT (SUPPLIER WISE)';
        $this->render('stockReportSupplierWise', array('model' => $model));
    }

    public function actionStockReportSupplierWiseView()
    {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        date_default_timezone_set("Asia/Dhaka");
        $model_id = $_POST['Inventory']['model_id'];
        $manufacturer_id = $_POST['Inventory']['manufacturer_id'];
        $item_id = $_POST['Inventory']['item_id'];
        $brand_id = $_POST['Inventory']['brand_id'];
        $selectedSupplierId = $_POST['Inventory']['supplier_id'];

        $message = "";
        $data = "";

        // PRODUCT STOCK BASE DATA

        $supplierProducts = [];
        if ($selectedSupplierId > 0) {
            $supplierPurchaseCriteria = new CDbCriteria;
            $supplierPurchaseCriteria->select = "DISTINCT t.model_id";
            $supplierPurchaseCriteria->join = " INNER JOIN purchase_order po ON t.order_id = po.id ";
            $supplierPurchaseCriteria->compare('po.supplier_id', $selectedSupplierId);

            $purchasedProducts = PurchaseOrderDetails::model()->findAll($supplierPurchaseCriteria);

            if (!empty($purchasedProducts)) {
                $supplierProducts = array_map(function($item){
                    return $item->model_id;
                }, $purchasedProducts);
            }
        }

        $criteria = new CDbCriteria;
        $criteria->select = "pm.model_name, 
                            t.model_id, 
                            sum(stock_in) - sum(stock_out) as closing_stock, 
                            pm.sell_price, 
                            pm.purchase_price as cpp,  
                            c.name as manufacturer_name,
                            AVG(CASE WHEN t.stock_status = 1 THEN t.purchase_price END) AS avg_purchase_price ";

        $criteria->order = 'pm.model_name ASC';
        $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
        $criteria->join .= " LEFT JOIN companies c ON pm.manufacturer_id = c.id ";
        $criteria->group = 't.model_id';

        if ($model_id > 0) $criteria->addColumnCondition(['model_id' => $model_id]);
        if ($manufacturer_id > 0) $criteria->addColumnCondition(['pm.manufacturer_id' => $manufacturer_id]);
        if ($item_id > 0) $criteria->addColumnCondition(['t.item_id' => $item_id]);
        if ($brand_id > 0) $criteria->addColumnCondition(['t.brand_id' => $brand_id]);

        if ($selectedSupplierId > 0 && count($supplierProducts) > 0) {
            $criteria->addInCondition('t.model_id', $supplierProducts);
        }

        $products = Inventory::model()->findAll($criteria);


        $allSuppliers = Suppliers::model()->findAll([
            'select' => 't.id, t.company_name'
        ]);

        // Create simple ID -> Name mapping
        $supplierMap = [];
        foreach ($allSuppliers as $s) {
            $supplierMap[$s->id] = $s->company_name;
        }

        // Final array for view
        $finalSupplierOutput = [];


        foreach ($products as $p) {

            $modelId = $p->model_id;
            $closingStock = (int)$p->closing_stock;

            if ($closingStock <= 0) continue;

            // 🔥 FIFO Supplier Allocation
            $allocations = Inventory::model()->getSupplierWiseLastStock($modelId, $closingStock);

            foreach ($allocations as $supplierId => $qty) {
                if ($selectedSupplierId > 0 && $supplierId != $selectedSupplierId) {
                    continue;
                }


                if (!isset($finalSupplierOutput[$supplierId])) {
                    $finalSupplierOutput[$supplierId] = [
                        'supplier_id'   => $supplierId,
                        'supplier_name' => isset($supplierMap[$supplierId])
                            ? $supplierMap[$supplierId]
                            : "Unknown Supplier",
                        'products'      => []
                    ];
                }

                $finalSupplierOutput[$supplierId]['products'][] = [
                    'product_name' => $p->model_name,
                    'manufacturer_name' => $p->manufacturer_name,
                    'model_id'     => $modelId,
                    'qty'          => $qty,
                    'sell_price'   => $p->sell_price,
                    'avg_pp'       => $p->avg_purchase_price,
                ];
            }
        }

        // Send data to view
        echo $this->renderPartial('stockReportSupplierWiseView', [
            'data'    => $finalSupplierOutput,
            'message' => "Supplier Closing Stock Report (FIFO Applied)"
        ], true, true);
        Yii::app()->end();
    }

    public function actionCurrentStockReportBatchWiseView()
    {
        date_default_timezone_set('Asia/Dhaka');
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        $data = '';
        $condition = '';
        if ($_GET['product_id'] != "") {
            $message = "";
        } else {
            $message = "<div class='flash-error'>Please select a product!</div>";
        }
        $model_id = $_GET['product_id'];

        echo $this->renderPartial('currentStockReportBatchWiseView', array(
            'model_id' => $model_id,
            'message' => $message
        ), true, true);
        Yii::app()->end();
    }

    public function actionCurrentStockOutReportBatchWiseView()
    {
        date_default_timezone_set('Asia/Dhaka');

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        $data = '';
        $condition = '';
        if ($_GET['product_id'] != "") {
            $message = "";
        } else {
            $message = "<div class='flash-error'>Please select a product!</div>";
        }
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $model_id = $_GET['product_id'];

        echo $this->renderPartial('currentStockOutReportBatchWiseView', array(
            'model_id' => $model_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'message' => $message
        ), true, true);
        Yii::app()->end();
    }


    public function actionCurrentStockInReportBatchWiseView()
    {
        date_default_timezone_set('Asia/Dhaka');

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        }

        $data = '';
        $condition = '';
        if ($_GET['product_id'] != "") {
            $message = "";
        } else {
            $message = "<div class='flash-error'>Please select a product!</div>";
        }
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $model_id = $_GET['product_id'];

        echo $this->renderPartial('currentStockInReportBatchWiseView', array(
            'model_id' => $model_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'message' => $message
        ), true, true);
        Yii::app()->end();
    }

    public function actionRemoveProductSlFromCurrentStock()
    {
        $model_id = isset($_POST['model_id']) ? $_POST['model_id'] : 0;
        $product_sl_no = isset($_POST['product_sl_no']) ? $_POST['product_sl_no'] : "";
        $physical_stock = isset($_POST['physical_stock']) ? $_POST['physical_stock'] : 0;
        $modify_stock_flag = isset($_POST['modify_stock']) ? $_POST['modify_stock'] : 0;
        $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : "";
        $criteria = new CDbCriteria();
        $criteria->select = "SUM(stock_in - stock_out) as closing_stock";
        $criteria->addColumnCondition(['model_id' => $model_id]);
        if ($product_sl_no) {
            $criteria->addColumnCondition(['product_sl_no' => $product_sl_no]);
        }
        $data = Inventory::model()->findByAttributes([], $criteria);

        $message = "Adjustment Done. Please Reopen the modal for change!";
        $remove_rows = false;
        if ($data) {
            $model = new Inventory();
            $model->model_id = $model_id;
            $model->date = date('Y-m-d');
            $model->challan_no = Inventory::maxSlNo() + 1;
            $model->sl_no = $model->challan_no;
            $model->product_sl_no = $product_sl_no;
            if ($modify_stock_flag > 0) {
                if ($data->closing_stock > $physical_stock) {
                    $model->stock_out = $data->closing_stock - $physical_stock;
                } else {
                    $model->stock_in = $physical_stock - $data->closing_stock;
                }
            } else {
                if ($data->closing_stock > 0) {
                    $model->stock_out = $data->closing_stock;
                } else {
                    $model->stock_in = abs($data->closing_stock);
                }
                $remove_rows = 1;
            }

            $model->stock_status = Inventory::MANUAL_ENTRY;
            $product = ProdModels::model()->findByPk($model_id);
            $model->sell_price = $product->sell_price;
            $model->purchase_price = $product->purchase_price;
            $model->row_total = $model->stock_in > 0 ? round($model->stock_in * $model->sell_price, 2) : round($model->stock_out * $model->sell_price, 2);
            $model->remarks = $remarks ? $remarks : "Serial No: $product_sl_no removed from current stock! ";
            if ($model->stock_in > 0 || $model->stock_out > 0) {
                $model->save();
                $model->save();
                echo CJSON::encode(array(
                    'status' => 'success',
                    'remove_rows' => $remove_rows,
                    'message' => $message
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'error',
                    'message' => 'No stock adjustment found!',
                    'remove_rows' => false,
                ));
            }
        } else {
            echo CJSON::encode(array(
                'status' => 'error',
                'message' => 'No data found!',
                'remove_rows' => false,
            ));
        }

        Yii::app()->end();
    }

    public function actionFixPurchasePrice()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.model_id, t.purchase_price, t.sell_price, pm.purchase_price as pp, pm.sell_price as sp, t.stock_in, t.stock_out, t.source_id';
        $criteria->addColumnCondition(['t.purchase_price' => 0]);
        $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
        $data = Inventory::model()->findAll($criteria);
        if ($data) {
            $total_fix = 0;
            foreach ($data as $dt) {
                $saved = false;
                if ($dt->stock_in > 0) {
                    $purchase_price = $dt->purchase_price > 0 ? $dt->purchase_price : $dt->pp;
                    $sell_price = $dt->sell_price > 0 ? $dt->sell_price : $dt->sp;
                    $row_total = $dt->stock_in * $purchase_price;
                    $dt->purchase_price = $purchase_price;
//                    $dt->sell_price = $sell_price;
                    $dt->row_total = $row_total;
                    $dt->save();
                    $saved = true;
                }
                if ($dt->stock_out > 0) {
                    $source_id = $dt->source_id;

                    $purchase_price = $dt->purchase_price > 0 ? $dt->purchase_price : $dt->pp;

                    if ($source_id > 0) {
                        $sellOrderDetails = SellOrderDetails::model()->findByPk($source_id);
                        if ($sellOrderDetails) {
                            $qty = $sellOrderDetails->qty;
                            $costing = $sellOrderDetails->costing;
                            $purchase_price = round($costing / $qty, 2);
                        }
                    }

                    $sell_price = $dt->sell_price > 0 ? $dt->sell_price : $dt->sp;
                    $row_total = $dt->stock_out * $purchase_price;
                    $dt->purchase_price = $purchase_price;
//                    $dt->sell_price = $sell_price;
                    $dt->row_total = $row_total;
                    $dt->save();
                    $saved = true;
                }
                if ($saved) {
                    $total_fix++;
                }
            }
            echo "Total Fixed: $total_fix";
        }

    }

    public function actionFixSellOrderPP()
    {
        $sql = "SELECT sod.id, sod.sell_order_id, sod.model_id, sod.amount, sod.qty, (sod.costing / sod.qty) as sod_cost, pm.purchase_price , pm.model_name
                FROM `sell_order_details` sod 
                INNER JOIN prod_models pm on sod.model_id = pm.id 
                WHERE pm.stockable = 1 and LENGTH(sod.product_sl_no) <= 0 
                HAVING pm.purchase_price != sod_cost ORDER BY `sod`.`sell_order_id` ASC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if ($data) {
            $total_fix = 0;
            foreach ($data as $dt) {
                $sellOrderDetails = SellOrderDetails::model()->findByPk($dt['sell_order_id']);
                if ($sellOrderDetails) {
                    $sellOrderDetails->costing = $dt['purchase_price'] * $dt['qty'];
                    if ($sellOrderDetails->save()) {
                        // update sell order costing value
                        $sellOrder = SellOrder::model()->findByPk($dt['sell_order_id']);
                        if ($sellOrder) {
                            $sellOrder->costing = SellOrderDetails::model()->getTotalCosting($dt['sell_order_id']);
                            $sellOrder->save();
                        }

                        // fix inventory purchase price
                        $inventory = Inventory::model()->findByAttributes(['source_id' => $dt['id']]);
                        if ($inventory) {
                            $inventory->purchase_price = $dt['purchase_price'];
                            $inventory->save();
                        }
                    }
                    echo sprintf("Sell Order ID: %s, Model: %s, Old Costing: %s, New Costing: %s <br>", $dt['sell_order_id'], $dt['model_name'], $dt['sod_cost'], $dt['purchase_price']);
                    $total_fix++;
                }
            }
            echo "Total Fixed: $total_fix";
        }
    }

}
