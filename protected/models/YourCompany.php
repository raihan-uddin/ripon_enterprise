<?php

class YourCompany extends CActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 2;

    public static function activeCompanyName()
    {
        $data = self::model()->findByAttributes(array('is_active' => self::ACTIVE));
        if ($data)
            return $data->company_name;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'your_company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_name, location, road, house, contact', 'required'),
            array('is_active', 'numerical', 'integerOnly' => true),
            array('company_name, location, email, web, house', 'length', 'max' => 255),
            array('road, contact, vat_regi_no, trn_no', 'length', 'max' => 255),
            array('email', 'email'),
            array('web', 'url', 'defaultScheme' => 'http'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, company_name, location, trn_no, road, house, contact, email, web, is_active, vat_regi_no', 'safe', 'on' => 'search'),
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
            'company_name' => 'Company Name',
            'location' => 'Location',
            'road' => 'Road',
            'house' => 'House',
            'contact' => 'Contact',
            'email' => 'Email',
            'web' => 'Web',
            'trn_no' => 'TRN',
            'is_active' => 'Is Active',
        );
    }

    public function afterSave()
    {
        if ($this->is_active == self::ACTIVE) {
            self::model()->updateAll(array('is_active' => self::INACTIVE), 'id!=:id', array(':id' => $this->id));
        }
        return parent::afterSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * @return YourCompany the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function activeInfo()
    {
        $data = self::model()->findByAttributes(array('is_active' => self::ACTIVE));
        if ($data)
            return $data;
    }

    public function statusColor($status)
    {
        if ($status == self::ACTIVE) {
            echo "<span class='greenColor'>ACTIVE</b></span>";
        } else {
            echo "<span class='redColor'>INACTIVE</b></span>";
        }
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
        $criteria->compare('trn_no', $this->trn_no, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('location', $this->location, true);
        $criteria->compare('road', $this->road, true);
        $criteria->compare('house', $this->house, true);
        $criteria->compare('contact', $this->contact, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('web', $this->web, true);
        $criteria->compare('is_active', $this->is_active);

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