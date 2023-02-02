<?php

class Designations extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'designations';
    }

    public function rules()
    {
        return array(
            array('designation', 'required'),
            array('designation', 'length', 'max' => 255),
            array('id, designation', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'designation' => 'Designation',
        );
    }

    public function infoOfThis($id)
    {
        $data = self::model()->findByPk($id);

        if ($data)
            return $data->designation;
    }

    public function allInfos()
    {
        $data = self::model()->findAll(array('order' => 'designation ASC'));

        if ($data)
            return $data;
        else
            return array();
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
        $criteria->compare('designation', $this->designation, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}