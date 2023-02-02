<?php

class SupplierContactPersons extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @return SupplierContactPersons the static model class
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
        return 'supplier_contact_persons';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, contact_person_name, contact_number1', 'required'),
            array('company_id, designation_id', 'numerical', 'integerOnly' => true),
            array('contact_person_name', 'length', 'max' => 255),
            array('contact_number1, contact_number2, contact_number3', 'length', 'max' => 255),
            array('email', 'length', 'max' => 50),
            array('email', 'email'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, company_id, contact_person_name, designation_id, contact_number1, contact_number2, contact_number3, email', 'safe', 'on' => 'search'),
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
            'companySup' => array(self::BELONGS_TO, 'Suppliers', 'company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'company_id' => 'Company',
            'contact_person_name' => 'Contact Person Name',
            'designation_id' => 'Designation',
            'contact_number1' => 'Contact Number1',
            'contact_number2' => 'Contact Number2',
            'contact_number3' => 'Contact Number3',
            'email' => 'Email',
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
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('contact_person_name', $this->contact_person_name, true);
        $criteria->compare('designation_id', $this->designation_id);
        $criteria->compare('contact_number1', $this->contact_number1, true);
        $criteria->compare('contact_number2', $this->contact_number2, true);
        $criteria->compare('contact_number3', $this->contact_number3, true);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 'company_id, id DESC',
            ),
        ));
    }

}