<?php

class LhAmountProll extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return LhAmountProll the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lh_amount_proll';
    }
    
    const ACTIVE=1;
    const INACTIVE=2;
    public $percentAmount;
    public $isPercentAmount;
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lh_proll_id, day, hour, amount_adj', 'required'),
            array('lh_proll_id, percentage_of_ah_proll_id, is_active, create_by, update_by', 'numerical', 'integerOnly' => true),
            array('day, hour, amount_adj', 'numerical'),
            array('start_from, end_to, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, lh_proll_id, day, hour, percentage_of_ah_proll_id, amount_adj, start_from, end_to, is_active, create_by, create_time, update_by, update_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lhProll' => array(self::BELONGS_TO, 'LhProll', 'lh_proll_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'lh_proll_id' => 'Head',
            'day' => 'Day',
            'hour' => 'Hour',
            'percentage_of_ah_proll_id' => 'Percentage',
            'amount_adj' => 'Amount Adjust',
            'start_from' => 'Start From',
            'end_to' => 'End To',
            'is_active' => 'Is Active',
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
            $criteria->condition="id!=".$this->id." AND lh_proll_id=".$this->lh_proll_id;
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
    
    public function remainingLeave($emp_id, $lh_proll_id){
        
        if($emp_id!="" && $lh_proll_id!=""){
            $criteriaLhAmountProll=new CDbCriteria();
            $criteriaLhAmountProll->condition="lh_proll_id=".$lh_proll_id." AND is_active=".LhAmountProll::ACTIVE;
            $dataLhAmountProll=LhAmountProll::model()->findAll($criteriaLhAmountProll);
            if($dataLhAmountProll){
                $dataLhProll=LhProll::model()->findByPk($lh_proll_id);
                $payGradeLHProll=$dataLhProll->paygrade_id;

                $dataEmployee=  Employees::model()->findByPk($emp_id);
                $payGradeEmployee=$dataEmployee->paygrade_id;
                
                if($payGradeLHProll==$payGradeEmployee){
                    
                    $leaveDay=0;
                    $leaveHour=0;
                    
                    foreach($dataLhAmountProll as $dlhap):
                        $leaveDay=$dlhap->day;
                        $leaveHour=$dlhap->hour;
                    endforeach;
                    $currYear=  date('Y');
                    $criteriaSpentLeave=new CDbCriteria();
                    $criteriaSpentLeave->select="sum(day_to_leave) as sumDay, sum(hour_to_leave) as sumHour";
                    $criteriaSpentLeave->addColumnCondition(array('lh_proll_id'=>$dataLhProll->id, 'emp_id'=>$dataEmployee->id, 'year'=>$currYear), 'AND', 'AND');
                    $dataSepntLeave=EmpLeaves::model()->findAll($criteriaSpentLeave);
                    
                    $sumDaySpent=0;
                    $sumHourSpent=0;
                    
                    if($dataSepntLeave){
                        foreach($dataSepntLeave as $dsp):
                            $sumDaySpent=$dsp->sumDay;
                            $sumHourSpent=$dsp->sumHour;
                        endforeach;
                    }
                    
                    $remainingLeaveDay=($leaveDay-$sumDaySpent);
                    $remainingLeaveHour=($leaveHour-$sumHourSpent);
                    
                    $leaveData="Remaining Day: ".$remainingLeaveDay." (Hour: ".$remainingLeaveHour.")- current year";
                }else{
                    $leaveData="<div class='flash-error'>No paygrade has been defined for this employee!</div>";
                }
            }else{
                $leaveData="<div class='flash-error'>This leave has not been configured!</div>";
            }
        }else{
            $leaveData="";
        }
        
        echo $leaveData;
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
        $criteria->compare('lh_proll_id', $this->lh_proll_id);
        $criteria->compare('day', $this->day);
        $criteria->compare('hour', $this->hour);
        $criteria->compare('percentage_of_ah_proll_id', $this->percentage_of_ah_proll_id);
        $criteria->compare('amount_adj', $this->amount_adj);
        $criteria->compare('start_from', $this->start_from, true);
        $criteria->compare('end_to', $this->end_to, true);
        $criteria->compare('is_active', $this->is_active);
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