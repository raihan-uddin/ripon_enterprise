<?php

class DiscountTab extends CActiveRecord
{

    const SALE_ORDER = 40;
    const QUICK_SALE = 41;

    /**
     * Returns the static model of the specified AR class.
     * @return DiscountTab the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'discount_tab';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('no_type', 'numerical', 'integerOnly' => true),
            array('discount', 'numerical'),
            array('no', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, no, discount, no_type', 'safe', 'on' => 'search'),
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
            'no' => 'No',
            'discount' => 'Discount',
            'no_type' => 'No Type',
        );
    }

    public function lineTotalWithDiscount($subTotal, $discountOfThis)
    {
        $discountTypeP = DiscountType::model()->findByPk(DiscountType::PERCENTAGE);
        if ($discountTypeP->is_active == DiscountType::ACTIVE)
            $data = ($subTotal - ($subTotal * ($discountOfThis / 100)));
        else
            $data = ($subTotal - $discountOfThis);
        return $data;
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
        $criteria->compare('no', $this->no, true);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('no_type', $this->no_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}