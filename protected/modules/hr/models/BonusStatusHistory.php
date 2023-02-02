<?php

class BonusStatusHistory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return BonusStatusHistory the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bonus_status_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, bonus_amount_id, status, status_changed_by', 'numerical', 'integerOnly' => true),
            array('status_changed_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, bonus_amount_id, status, status_changed_by, status_changed_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bonusAmount' => array(self::BELONGS_TO, 'BonusAmounts', 'bonus_amount_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'bonus_amount_id' => 'Bonus Amount',
            'status' => 'Status',
            'status_changed_by' => 'Status Changed By',
            'status_changed_time' => 'Status Changed Time',
        );
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
        $criteria->compare('bonus_amount_id', $this->bonus_amount_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('status_changed_by', $this->status_changed_by);
        $criteria->compare('status_changed_time', $this->status_changed_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}