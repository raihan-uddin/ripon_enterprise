<?php

class LhProll extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return LhProll the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lh_proll';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('paygrade_id, title', 'required'),
            array('paygrade_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, paygrade_id, title', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lhAmountProlls' => array(self::HAS_MANY, 'LhAmountProll', 'lh_proll_id'),
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
        );
    }
    
    public function getPayGrade(){
        $val=PayGrades::model()->nameOfThis($this->paygrade_id);
        return $val;
    }
    
    public function nameOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
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