<?php

class BonusAmounts extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return BonusAmounts the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bonus_amounts';
    }
	
	public $designation_id;
	public $department_id;
	public $join_date;
	public $basic_salary;
	
    const ACTIVE=1;
    const INACTIVE=2;
    
    const PENDING=15;
    const APPROVED=16;
    const DENIED=17;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bonus_id, employee_id, date, is_active', 'required'),
            array('bonus_id, employee_id, is_active, is_approved, create_by, update_by', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical'),
            array('date, designation_id, gross_salary, department_id, join_date, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, bonus_id, employee_id, designation_id, department_id, join_date, amount, amount_per, date, is_active, is_approved, create_by, create_time, update_by, update_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'employee' => array(self::BELONGS_TO, 'Employees', 'employee_id'),
            'bonus' => array(self::BELONGS_TO, 'BonusTitles', 'bonus_id'),
            'bonusStatusHistories' => array(self::HAS_MANY, 'BonusStatusHistory', 'bonus_amount_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'bonus_id' => 'Bonus Head',
            'employee_id' => 'Employee Name',
            'designation_id' => 'Designation',
            'department_id' => 'Department',
            'join_date' => 'Join Date',
            'basic_salary' => 'Basic Salary',
            'amount_per' => 'Bonus Amount %',
            'amount' => 'Bonus Amount',
            'date' => 'Date',
            'is_active' => 'Is Active',
            'is_approved' => 'Is Approved',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'update_by' => 'Update By',
            'update_time' => 'Update Time',
        );
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->create_time = new CDbExpression('NOW()');
            $this->create_by = Yii::app()->user->getId();
        } else {
            $this->update_time = new CDbExpression('NOW()');
            $this->update_by = Yii::app()->user->getId();
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if ($this->is_active == self::ACTIVE) {
            $criteria = new CDbCriteria;
            $criteria->condition = "id!=" . $this->id . " AND bonus_id=" . $this->bonus_id . " AND employee_id=" . $this->employee_id;
            self::model()->updateAll(array('is_active' => self::INACTIVE), $criteria);
        }
        return parent::afterSave();
    }

    public function statusColor($status) {
        if ($status == self::ACTIVE) {
            echo "<span class='greenColor'>ACTIVE</b></span>";
        } else {
            echo "<span class='redColor'>INACTIVE</b></span>";
        }
    }
    
    public function statusColorIsAproved($is_approved){
        if ($is_approved == self::PENDING)
            echo "<font style='color: orange; font-weight: bold;'>PENDING</font>";
        else if ($is_approved == self::APPROVED)
            echo "<font style='color: green; font-weight: bold;'>APPROVED</font>";
        else if ($is_approved == self::DENIED)
            echo "<font style='color: red; font-weight: bold;'>DENIED</font>";
        else
            echo "";
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
        $criteria->compare('bonus_id', $this->bonus_id);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('create_by', $this->create_by);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_by', $this->update_by);
        $criteria->compare('update_time', $this->update_time, true);

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