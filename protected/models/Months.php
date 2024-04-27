<?php

/**
 * This is the model class for table "months".
 *
 * The followings are the available columns in table 'months':
 * @property string $id
 * @property string $month_name
 */
class Months extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'months';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('month_name', 'length', 'max' => 8),
            array('code', 'length', 'max' => 2),
            array('short_name', 'length', 'max' => 3),
            array('days', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, month_name, code, short_name', 'safe', 'on' => 'search'),
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
            'month_name' => 'Month Name',
            'code' => 'Code',
            'short_name' => 'Short Name',
        );
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->month_name;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Months the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function shortNameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->short_name;
    }

    public function codeOfThis($code)
    {
        $data = self::model()->findByAttributes(array('code' => $code));
        if ($data)
            return $data->month_name;
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('month_name', $this->month_name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('short_name', $this->short_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}