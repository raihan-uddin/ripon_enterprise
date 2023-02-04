<?php

/**
 * This is the model class for table "sell_delivery_details".
 *
 * The followings are the available columns in table 'sell_delivery_details':
 * @property integer $id
 * @property integer $sell_delivery_id
 * @property integer $model_id
 * @property double $qty
 * @property double $unit_price
 * @property double $row_total
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $product_sl_no
 * @property integer $store_id
 * @property integer $location_id
 */
class SellDeliveryDetails extends CActiveRecord
{
    public $model_name;
    public $code;
    public $unit_id;
    public $image;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sell_delivery_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sell_delivery_id, model_id, qty, unit_price, row_total', 'required'),
            array('sell_delivery_id, model_id, created_by, updated_by, store_id, location_id', 'numerical', 'integerOnly' => true),
            array('qty, unit_price, row_total', 'numerical'),
            array('created_at, updated_at, product_sl_no', 'safe'),
            // The following rule is used by search().
            array('id, sell_delivery_id, model_id, qty, unit_price, row_total, created_by, store_id, location_id, product_sl_no, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'sell_delivery_id' => 'Delivery No',
            'model_id' => 'Model',
            'qty' => 'Qty',
            'store_id' => 'Store',
            'location_id' => 'Location',
            'unit_price' => 'Unit Price',
            'row_total' => 'Row Total',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('sell_delivery_id', $this->sell_delivery_id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('unit_price', $this->unit_price);
        $criteria->compare('row_total', $this->row_total);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('location_id', $this->location_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }


    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $prodModel = ProdModels::model()->findByPk($this->model_id);
            if ($prodModel) {
                $prodModel->purchase_price = $this->unit_price;
                $prodModel->save();
            }
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_by = Yii::app()->user->id;
            $this->updated_at = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    public function totalDeliveryQtyOfThisModelByOrder($model_id, $order_id, $product_sl_no)
    {
        $criteria = new CDbCriteria();
        $criteria->select = " SUM(qty) AS qty";
        $criteria->join = "INNER JOIN sell_delivery sd on t.sell_delivery_id = sd.id";
        $criteria->addColumnCondition(['sd.sell_order_id' => $order_id, 't.model_id' => $model_id]);
        if (strlen($product_sl_no) > 0) {
            $criteria->addColumnCondition(['t.product_sl_no' => $product_sl_no]);
        }
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->qty : 0;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SellDeliveryDetails the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
