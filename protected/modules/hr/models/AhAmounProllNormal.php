<?php

class AhAmounProllNormal extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return AhAmounProllNormal the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ah_amoun_proll_normal';
    }

    const ACTIVE = 1;
    const INACTIVE = 2;
    const MONTHLY_BASIS = 79;
    const DAILY_BASIS = 80;

    public $percentAmount;
    public $isPercentAmount;
    public $temp_ah_proll_normal_id;
    public $temp_amount_adj;
    public $earn_deduct_type;
    public $temp_percentage_of_ah_proll_normal_id;
    public $temp_start_from;
    public $temp_end_to;
    public $temp_is_active;
    public $card_no;
    public $emp_id_no;
    public $full_name;
    public $branch_name;
    public $department_name;
    public $amount;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ah_proll_normal_id, amount_adj, employee_id, earn_deduct_type', 'required', 'on' => 'requiredScenario'),
            array('employee_id, ah_proll_normal_id, percentage_of_ah_proll_normal_id, is_active, create_by, update_by, earn_deduct_type', 'numerical', 'integerOnly' => true),
            array('amount_adj', 'numerical'),
            array('start_from, emp_id_no, full_name,effective_month, end_to, branch_name,create_time, update_time, department_name', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, employee_id, emp_id_no, full_name,effective_month, department_name, branch_name, ah_proll_normal_id, card_no, percentage_of_ah_proll_normal_id, amount_adj, start_from, end_to, is_active, create_by, create_time, update_by, update_time, earn_deduct_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ahProllNormal' => array(self::BELONGS_TO, 'AhProllNormal', 'ah_proll_normal_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'employee_id' => 'Employee',
            'full_name' => 'Employee',
            'emp_id_no' => 'Card No',
            'branch_name' => 'Branch Name',
            'ah_proll_normal_id' => 'Head',
            'percentage_of_ah_proll_normal_id' => 'Percentage',
            'amount_adj' => 'Amount',
            'earn_deduct_type' => 'Basis',
            'start_from' => 'PF Contribution Start',
            'end_to' => 'End To',
            'effective_month' => 'Effective Month',
            'is_active' => 'Is Active',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'update_by' => 'Update By',
            'update_time' => 'Update Time',
            'department_name' => 'Department',
        );
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->create_time = new CDbExpression('NOW()');
            $this->create_by = Yii::app()->user->id;
        } else {
            $this->update_time = new CDbExpression('NOW()');
            $this->update_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if ($this->is_active == self::ACTIVE) {
            $criteria = new CDbCriteria;
            $criteria->condition = "id!=" . $this->id . " AND ah_proll_normal_id=" . $this->ah_proll_normal_id . " AND employee_id=" . $this->employee_id;
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

    public function showIdByEmpId($employee_id) {
        $data = self::model()->findByAttributes(array("employee_id" => $employee_id));
        if ($data)
            return $data->id;
    }

    public function basicSalaryByEmpId($employee_id) {
        $basicAmout = 0;
        $criteria = new CDbCriteria();
        //$criteria->select = "amount_adj";
        $criteria->addColumnCondition(array("employee_id" => $employee_id, "ah_proll_normal_id" => 1), "AND", "AND");
        $data = self::model()->findAll($criteria);
        if ($data) {
            $basicAmout = end($data)->amount_adj;
        }

        return $basicAmout;
    }

    public function grossSalaryByEmpId($employee_id) {

        $sql = "SELECT sum(amount_adj) as amount FROM ah_amoun_proll_normal INNER JOIN ah_proll_normal ON ah_amoun_proll_normal.ah_proll_normal_id = ah_proll_normal.id where ah_proll_normal.ac_type =13 AND ah_amoun_proll_normal.employee_id=$employee_id";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $data = $command->queryRow();
        if ($data) {
            $amout = $data['amount'];
        }
        return $amout;
    }

    public function basicSalaryByEmpIdWithHead($employee_id, $salaryHead) {
        $basicAmout = 0;
        $criteria = new CDbCriteria();
        //$criteria->select = "amount_adj";
        $criteria->addColumnCondition(array("employee_id" => $employee_id, "ah_proll_normal_id" => $salaryHead), "AND", "AND");
        $data = self::model()->findAll($criteria);
        if ($data) {
            $basicAmout = end($data)->amount_adj;
        }
        return $basicAmout;
    }

    public function basicSalaryByEmployeeId($employee_id, $ah_proll_normal_id) {
        $basicAmout = 0;
        $criteria = new CDbCriteria();
        //$criteria->select = "amount_adj";
        $criteria->addColumnCondition(array("employee_id" => $employee_id, "ah_proll_normal_id" => $ah_proll_normal_id), "AND", "AND");
        $data = self::model()->findAll($criteria);
        if ($data) {
            $basicAmout = end($data)->amount_adj;
        }

        return $basicAmout;
    }

    public function hmSalaryByEmpId($employee_id) {
        $basicAmout = 0;
        $criteria = new CDbCriteria();
        //$criteria->select = "amount_adj";
        $criteria->addColumnCondition(array("employee_id" => $employee_id, "ah_proll_normal_id" => 2), "AND", "AND");
        $data = self::model()->findAll($criteria);
        if ($data) {
            $basicAmout = end($data)->amount_adj;
        }

        return $basicAmout;
    }

    public function pfByEmpId($employee_id) {
        $basicAmout = 0;
        $criteria = new CDbCriteria();
        //$criteria->select = "amount_adj";
        $criteria->addColumnCondition(array("employee_id" => $employee_id, "ah_proll_normal_id" => 6), "AND", "AND");
        $data = self::model()->findAll($criteria);
        if ($data) {
            $basicAmout = end($data)->amount_adj;
        }

        return $basicAmout;
    }

    public function percengateAmount($percentageAmountOf, $amountAdj) {
        if ($percentageAmountOf != "") {
            $criteria = new CDbCriteria();
            $criteria->select = "amount_adj";
            $criteria->condition = "ah_proll_normal_id=" . $percentageAmountOf;
            $data = self::model()->findAll($criteria);
            if ($data) {
                foreach ($data as $d):
                    $adjAmountFinal = $d->amount_adj;
                endforeach;
                $adjAmountFinal = ($amountAdj / $adjAmountFinal) * 100;
                $nameOfAh = "% of " . AhProllNormal::model()->nameOfThis($percentageAmountOf);
            }else {
                $adjAmountFinal = "";
                $nameOfAh = "";
            }
        } else {
            $adjAmountFinal = "";
            $nameOfAh = "";
        }

        return $adjAmountFinal . " " . $nameOfAh;
    }

    public function percengateAmountOnly($percentageAmountOf, $amountAdj) {
        if ($percentageAmountOf != "") {
            $criteria = new CDbCriteria();
            $criteria->select = "amount_adj";
            $criteria->condition = "ah_proll_normal_id=" . $percentageAmountOf;
            $data = self::model()->findAll($criteria);
            if ($data) {
                foreach ($data as $d):
                    $adjAmountFinal = $d->amount_adj;
                endforeach;
                $adjAmountFinal = ($amountAdj / $adjAmountFinal) * 100;
            }else {
                $adjAmountFinal = "";
            }
        } else {
            $adjAmountFinal = "";
        }

        return $adjAmountFinal;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "t.*, emp.emp_id_no, emp.full_name, emp.branch_id, branch.title as branch_name, department.department_name ";
        $criteria->join = " LEFT JOIN employees as emp ON t.employee_id=emp.id ";
        $criteria->join .= " LEFT JOIN branches as branch ON emp.branch_id=branch.id ";
        $criteria->join .= " LEFT JOIN departments as department ON emp.department_id=department.id ";

        $criteria->compare('t.id', $this->id);
        //$criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('t.ah_proll_normal_id', $this->ah_proll_normal_id);
        $criteria->compare('t.percentage_of_ah_proll_normal_id', $this->percentage_of_ah_proll_normal_id);
        $criteria->compare('t.amount_adj', $this->amount_adj);
        $criteria->compare('t.earn_deduct_type', $this->earn_deduct_type);
        $criteria->compare('t.start_from', $this->start_from, true);
        $criteria->compare('t.end_to', $this->end_to, true);
        $criteria->compare('t.is_active', $this->is_active);
        $criteria->compare('t.create_by', $this->create_by);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.update_by', $this->update_by);
        $criteria->compare('t.update_time', $this->update_time, true);
        $criteria->compare('t.effective_month', $this->effective_month, true);
        $criteria->compare('emp.emp_id_no', $this->emp_id_no, true);
        $criteria->compare('emp.full_name', $this->full_name, true);
        $criteria->compare('branch.id', $this->branch_name);
        $criteria->compare('department.department_name', $this->department_name);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
            'sort' => array(
                'defaultOrder' => 'employee_id DESC',
            ),
        ));
    }

}
