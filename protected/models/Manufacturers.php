<?php

/**
 * This is the model class for table "manufacturers".
 *
 * The followings are the available columns in table 'manufacturers':
 * @property integer $id
 * @property string $manufacturer
 */
class Manufacturers extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'manufacturers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('manufacturer, code', 'required'),
            array('manufacturer', 'length', 'max' => 255),
            array('code', 'length', 'max' => 5, 'min' => 5),
            array('manufacturer', 'unique', 'caseSensitive' => FALSE),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, code, manufacturer', 'safe', 'on' => 'search'),
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
            'manufacturer' => 'Manufacturer Name',
            'code' => 'Manufacturer Code',
        );
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->manufacturer;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Manufacturers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function codeOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->code;
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
        $criteria->compare('manufacturer', $this->manufacturer, true);
        $criteria->compare('code', $this->code, true);

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