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
    public $deviceFile;
    public $min_order_qty;
    public $qty;
    public $barCodeGenerator;
    public $image2;
    public $opening_stock;
    public $stock_in;
    public $stock_out;
    public $model_id;

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
            array('item_id, brand_id, unit_id, stockable', 'numerical', 'integerOnly' => true),
            array('sell_price, purchase_price', 'numerical'),
            array('model_name, code, min_order_qty', 'length', 'max' => 255),
            array('warranty', 'numerical'),
            array('code', 'unique', 'caseSensitive' => FALSE),
            array('image, thumbnail', 'length', 'max' => 300),
            array('features, description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('min_order_qty, id, item_id, brand_id, model_name, features, stockable, warranty, description,  purchase_price, sell_price', 'safe', 'on' => 'search'),
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
            'code' => 'Code',
            'min_order_qty' => 'Alert QTY',
            'warranty' => 'Warranty (M)',
            'activePrice' => 'Price (Pictorial)',
            'unit_id' => 'Unit',
            'description' => 'Description',
            'image' => 'Image',
            'purchase_price' => 'Purchase Price',
            'sell_price' => 'Sell Price',
            'stockable' => 'Stock Maintain?',
        );
    }

    public function beforeSave()
    {
        $this->model_name = strtoupper($this->model_name);
        if (!$this->sell_price > 0) {
            $this->sell_price = NULL;
        }

        if (!$this->purchase_price > 0) {
            $this->purchase_price = NULL;
        }

        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_at = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->id;
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

        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('model_name', $this->model_name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('min_order_qty', $this->min_order_qty, true);
        $criteria->compare('warranty', $this->warranty);
        $criteria->compare('unit_id', $this->unit_id);
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
