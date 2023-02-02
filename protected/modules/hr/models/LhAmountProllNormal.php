<?php

class LhAmountProllNormal extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'lh_amount_proll_normal';
    }
    
    const ACTIVE=1;
    const INACTIVE=2;
    
    public $temp_start_from;
    public $temp_end_to;
    public $temp_is_active;
    public $temp_day;
    public $temp_hour;
    
    public $sumOfDay;
	public $designation_id;
	public $department_id;
    
	public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lh_proll_normal_id, day, employee_id', 'required', 'on' => 'requiredScenario'),
            array('lh_proll_normal_id, create_by, update_by, is_active, employee_id', 'numerical', 'integerOnly' => true),
            array('day, hour', 'numerical'),
            array('start_from, end_to, create_time, update_time, designation_id, department_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, lh_proll_normal_id, designation_id, department_id, day, hour, is_active, start_from, end_to, create_by, create_time, update_by, update_time, employee_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'lhProllNormal' => array(self::BELONGS_TO, 'LhProllNormal', 'lh_proll_normal_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'lh_proll_normal_id' => 'Leave Type',
            'day' => 'Day',
            'hour' => 'Hour',
            'start_from' => 'Permanent Date',
            'end_to' => 'End To',
            'is_active' => 'Is Active',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'update_by' => 'Update By',
            'update_time' => 'Update Time',
            'employee_id' => 'Employee',
            'designation_id' => 'Designation',
            'department_id' => 'Department',
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
            $criteria->condition="id!=".$this->id." AND lh_proll_normal_id=".$this->lh_proll_normal_id. " AND employee_id=" . $this->employee_id;
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

    public function remainingLeave($emp_id, $lh_proll_normal_id) {

        if ($emp_id != "" && $lh_proll_normal_id != "") {
            $leaveData = "";
        } else {
            $leaveData = "";
        }

        echo $leaveData;
    }
    
    public function detailsOfThisLhProllNormalId2($id){
        $criteria=new CDbCriteria();
        $criteria->select="day, hour";
        $criteria->condition="lh_proll_normal_id=".$id." AND is_active=".self::ACTIVE;
        $data=self::model()->findAll($criteria);
        $leaveData="";
        if($data){
            foreach($data as $d):
                $leaveData.="Days: ".$d->day." (Hour: ".$d->hour.")";
            endforeach;
        }
        return $leaveData;
    }
    
    public function detailsOfThisLhProllNormalId($id){
        $criteria=new CDbCriteria();
        $criteria->select="day, hour";
        $criteria->condition="lh_proll_normal_id=".$id." AND is_active=".self::ACTIVE;
        $data=self::model()->findAll($criteria);
        $leaveData="";
        $leaveData.="<table class='summaryTab'>";
        if($data){
            foreach($data as $d):
                $leaveData.="<tr><td>Days: ".$d->day." (Hour: ".$d->hour.")</td></tr>";
            endforeach;
        }
        $leaveData.="</table>";
        return $leaveData;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
		
		$criteria->join = "";
		if (trim($this->employee_id) != "") {
			$criteria->join .= " INNER JOIN employees ON t.employee_id = employees.id and employees.full_name like '%".trim($this->employee_id)."%'";
		}
		
        $criteria->compare('id', $this->id);
        $criteria->compare('lh_proll_normal_id', $this->lh_proll_normal_id);
        $criteria->compare('day', $this->day);
        $criteria->compare('hour', $this->hour);
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
                'pageSize' => 40,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}