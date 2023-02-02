<?php

class ProdItems extends CActiveRecord
{

    const FINISHED_GOODS = 3;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'prod_items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_name', 'required'),
            array('item_name', 'length', 'max' => 255),
            array('item_name', 'unique', 'caseSensitive' => FALSE),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, item_name', 'safe', 'on' => 'search'),
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
            'prodBrands' => array(self::HAS_MANY, 'ProdBrands', 'item_id'),
            'prodModels' => array(self::HAS_MANY, 'ProdModels', 'item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'item_name' => 'Category',
        );
    }

    public function itemName($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->item_name;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return ProdItems the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->item_name = strtoupper($this->item_name);
        return parent::beforeSave();
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
        $criteria->compare('item_name', $this->item_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}