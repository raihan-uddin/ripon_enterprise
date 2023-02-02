<?php

/**
 * This is the model class for table "purchase_prices_manual".
 *
 * The followings are the available columns in table 'purchase_prices_manual':
 * @property integer $id
 * @property integer $model_id
 * @property double $purchase_price
 * @property double $qty
 * @property string $month
 * @property integer $year
 * @property string $date
 * @property integer $is_active
 */
class PurchasePricesManual extends CActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'purchase_prices_manual';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('model_id, year, is_active', 'numerical', 'integerOnly' => true),
            array('purchase_price, qty,original_purchase_price,vat_ptc', 'numerical'),
            array('month', 'length', 'max' => 2),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, model_id, purchase_price,original_purchase_price,vat_ptc, qty, month, year, date, is_active', 'safe', 'on' => 'search'),
        );
    }

    public function afterSave()
    {
        if ($this->is_active == self::ACTIVE) {
            self::model()->updateAll(array('is_active' => self::INACTIVE), 'id!=:id AND model_id=:model_id', array(':id' => $this->id, ':model_id' => $this->model_id));
        }
        return parent::afterSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * @return PurchasePricesManual the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function activePurchasePrice($modelId)
    {
        $data = self::model()->findByAttributes(array('model_id' => $modelId, 'is_active' => self::ACTIVE));
        if ($data) {
            return $var = $data->purchase_price;
        } else {
            return 0;
        }
    }

    public function activePurchasePriceDate($modelId)
    {
        $data = self::model()->findByAttributes(array('model_id' => $modelId, 'is_active' => self::ACTIVE));
        if ($data) {
            return $var = $data->date;
        }
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
            'model_id' => 'Model',
            'purchase_price' => 'Purchase Price',
            'original_purchase_price' => 'Original Purchase Price',
            'vat_ptc' => 'VAT%',
            'qty' => 'Qty',
            'month' => 'Month',
            'year' => 'Year',
            'date' => 'Date',
            'is_active' => 'Is Active',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('purchase_price', $this->purchase_price);
        $criteria->compare('original_purchase_price', $this->original_purchase_price);
        $criteria->compare('vat_ptc', $this->vat_ptc);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('month', $this->month, true);
        $criteria->compare('year', $this->year);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('is_active', $this->is_active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
