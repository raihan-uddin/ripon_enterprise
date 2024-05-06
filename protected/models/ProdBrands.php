<?php

class ProdBrands extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'prod_brands';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_id, brand_name', 'required'),
            array('item_id, ca_id', 'numerical', 'integerOnly' => true),
            array('brand_name', 'length', 'max' => 255),
            //array('brand_name', 'unique', 'caseSensitive'=>FALSE),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ca_id, item_id, brand_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'item' => array(self::BELONGS_TO, 'ProdItems', 'item_id'),
            'prodModels' => array(self::HAS_MANY, 'ProdModels', 'brand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'ca_id' => 'CA ID',
            'item_id' => 'Category',
            'brand_name' => 'Sub Category',
        );
    }

    public function brandName($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->brand_name;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return ProdBrands the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('brand_name', $this->brand_name, true);
        $criteria->compare('ca_id', $this->brand_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'item_id DESC',
            ),
        ));
    }

    public function beforeSave()
    {
        $businessId = Yii::app()->user->getState('business_id');
        $branchId = Yii::app()->user->getState('branch_id');

        $this->business_id = $businessId;
        $this->branch_id = $branchId;

        $this->brand_name = strtoupper($this->brand_name);
        return parent::beforeSave();
    }

}