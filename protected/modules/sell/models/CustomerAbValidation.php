<?php

class CustomerAbValidation extends CActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 2;

    /**
     * Returns the static model of the specified AR class.
     * @return CustomerAbValidation the static model class
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
        return 'customer_ab_validation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('is_active', 'numerical', 'integerOnly' => true),
            array('validation_field', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, validation_field, is_active', 'safe', 'on' => 'search'),
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
            'validation_field' => 'Validation Field',
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
        $criteria->addCondition('id = 1');

        $criteria->compare('id', $this->id);
        $criteria->compare('validation_field', $this->validation_field, true);
        $criteria->compare('is_active', $this->is_active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function search2()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('id = 2');

        $criteria->compare('id', $this->id);
        $criteria->compare('validation_field', $this->validation_field, true);
        $criteria->compare('is_active', $this->is_active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}