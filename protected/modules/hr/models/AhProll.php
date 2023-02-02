<?php

class AhProll extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return AhProll the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ah_proll';
    }

    const EARNING=13;
    const DEDUCTION=14;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('paygrade_id, title, ac_type', 'required'),
            array('paygrade_id, ac_type', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, paygrade_id, title, ac_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ahAmountProlls' => array(self::HAS_MANY, 'AhAmountProll', 'ah_proll_id'),
            'paygrade' => array(self::BELONGS_TO, 'PayGrades', 'paygrade_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'paygrade_id' => 'Pay Grade',
            'title' => 'Title',
            'ac_type' => 'Earn / Deduct',
        );
    }
    
    public function getPayGrade(){
        $val=PayGrades::model()->nameOfThis($this->paygrade_id);
        return $val;
    }
    
    public function getAcTypeWithName() {
        if($this->ac_type==self::EARNING)
             $val=$this->title." (Earn)";
        else
            $val=$this->title." (Deduct)";
        return $val;
    }

    public function nameOfThis($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->title;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('paygrade_id', $this->paygrade_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('ac_type', $this->ac_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}