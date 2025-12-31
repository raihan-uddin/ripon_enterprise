<?php

/**
 * This is the model class for table "prod_models".
 *
 * The followings are the available columns in table 'prod_models':
 * @property integer $id
 * @property integer $item_id
 * @property integer $brand_id
 * @property string $model_name
 * @property string $code
 * @property integer $unit_id
 * @property integer $min_order_qty
 * @property double $warranty
 * @property string $image
 * @property string $thumbnail
 * @property string $created_at
 * @property integer $created_by
 * @property double $purchase_price
 * @property double $sell_price
 * @property string $updated_at
 * @property string $description
 * @property integer $updated_by
 * @property boolean $stockable
 * @property boolean $status
 *
 * The followings are the available model relations:
 * @property ProdBrands $brand
 * @property ProdItems $item
 * @property Units $unit
 */
class ProdModels extends CActiveRecord
{

    public $maxProdId;
    public $activePrice;
    public $cpp;
    public $deviceFile;
    public $opening_stock_value;
    public $stock_in_value;
    public $stock_out_value;
    public $min_order_qty;
    public $qty;
    public $total_stock_out;
    public $sale_value;
    public $total_out_value;
    public $manufacturer_name;
    public $stock_value;
    public $closing_stock;
    public $barCodeGenerator;
    public $image2;
    public $opening_stock;
    public $stock_in;
    public $stock_out;
    public $model_id;
    public $company_name;
    public $brand_name;
    public $avg_purchase_price;
    public $item_name;

    const ACTIVE=1;

    public static function prodNameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->model_name;
    }

    public static function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->model_name;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'prod_models';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_id, brand_id, model_name, code, unit_id', 'required'),
            array('item_id, brand_id, unit_id, stockable, manufacturer_id, status', 'numerical', 'integerOnly' => true),
            array('sell_price, purchase_price', 'numerical'),
            array('model_name, code, min_order_qty', 'length', 'max' => 255),
            array('warranty', 'numerical'),
            array('code', 'unique', 'caseSensitive' => FALSE),
            array('image, thumbnail', 'length', 'max' => 300),
            array('features, description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('min_order_qty, id, item_id, brand_id, model_name, manufacturer_id, status, features, stockable, warranty, description,  purchase_price, sell_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Product ID',
            'qty' => 'Stock Qty',
            'item_id' => 'Category',
            'brand_id' => 'Sub-Category',
            'model_name' => 'Product Name',
            'code' => 'BarCode',
            'min_order_qty' => 'Alert QTY',
            'warranty' => 'Warranty (Month)',
            'activePrice' => 'Price (Pictorial)',
            'unit_id' => 'Unit',
            'description' => 'Description',
            'image' => 'Image',
            'purchase_price' => 'Purchase Price',
            'sell_price' => 'Sell Price',
            'stockable' => 'Stock Maintain?',
            'manufacturer_id' => 'Company',
            'status' => 'Status',
        );
    }

    public function beforeSave()
    {
        // set default time zone to asia/dhaka
        date_default_timezone_set('Asia/Dhaka');
        $dateTime = date('Y-m-d H:i:s');

        $businessId = Yii::app()->user->getState('business_id');
        $branchId = Yii::app()->user->getState('branch_id');

        $this->business_id = $businessId;
        $this->branch_id = $branchId;

        $this->model_name = strtoupper($this->model_name);
        if (!$this->sell_price > 0) {
            $this->sell_price = NULL;
        }

        if (!$this->purchase_price > 0) {
            $this->purchase_price = NULL;
        }

        if ($this->isNewRecord) {
            $this->created_at = $dateTime;
            $this->created_by = Yii::app()->user->getState('user_id');
            if ($this->item_id == 1) {
                $this->stockable = 0;
            }
        } else {
            $this->updated_at = $dateTime;
            $this->updated_by = Yii::app()->user->getState('user_id');
        }
        return parent::beforeSave();
    }


    /**
     * Returns the static model of the specified AR class.
     * @return ProdModels the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getNameAndUnit()
    {
        return $this->model_name . " (" . Units::model()->unitLabel($this->unit_id) . ")";
    }

    public function prodCodeOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->code;
    }

    public function minQtyOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->min_order_qty;
    }


    public function getCatSubCat()
    {
        $cat = ProdItems::model()->itemName($this->item_id);
        $subcat = ProdBrands::model()->brandName($this->brand_id);
        return $this->model_name . " (" . $subcat . ") - " . $cat;
    }

    public function neededInfo($id)
    {
        $data = self::model()->findByPk($id);
        if ($data) {
            $cat = ProdItems::model()->itemName($data->item_id);
            $subcat = ProdBrands::model()->brandName($data->brand_id);
            return $data->model_name . " (" . $subcat . ") - " . $cat;
        }
    }

    public function modelName($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->model_name;
    }

    public function infoOfThisProduct($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data;
    }


    public function updateProductPrice($id, $sellPrice = 0, $purchasePrice = 0)
    {
        $data = self::model()->findByPk($id);
        if ($data) {
            $changed = false;
            if ($sellPrice != $data->sell_price && $sellPrice > 0) {
                $data->sell_price = $sellPrice;
                $changed = true;
                $sp = new SellPrice();
                $sp->model_id = $data->id;
                $sp->sell_price = $data->sell_price;
                $sp->is_active = SellPrice::ACTIVE;
                $sp->save();
            }
            if ($purchasePrice != $data->sell_price && $purchasePrice > 0) {
                $data->purchase_price = $purchasePrice;
                $changed = true;
            }
            if ($changed) {
                $data->save();
            }
        }
    }

    public function barcodeGenerator($code)
    {
        //$link = '<form target="_blank" action="' . Yii::app()->request->baseUrl . '/myBarCodeGen/html/BCGupca.php" method="post">';
        $link = '<form target="_blank" action="' . Yii::app()->request->baseUrl . '/myBarCodeGen/html/BCGcode39.php" method="post">';
        $link .= '<input type="hidden" name="codeTobe" value="' . $code . '">';
        $link .= '<input class="barCodeBtn" type="submit" value="Generate">';
        $link .= '</form>';

        echo $link;
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('manufacturer_id', $this->manufacturer_id);
        $criteria->compare('model_name', $this->model_name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('min_order_qty', $this->min_order_qty, true);
        $criteria->compare('warranty', $this->warranty);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('stockable', $this->stockable);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('features', $this->features, true);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('sell_price', $this->sell_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
            'sort' => array(
                'defaultOrder' => 'item_id, brand_id ASC',
            ),
        ));
    }

}
