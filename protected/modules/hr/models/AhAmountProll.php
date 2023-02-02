<?php

class AhAmountProll extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return AhAmountProll the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ah_amount_proll';
    }

    const ACTIVE=1;
    const INACTIVE=2;
    const MONTHLY_BASIS=79;
    const DAILY_BASIS=80;
    
    public $percentAmount;
    public $isPercentAmount;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ah_proll_id, amount_adj, earn_deduct_type', 'required'),
            array('ah_proll_id, percentage_of_ah_proll_id, is_active, create_by, update_by, earn_deduct_type', 'numerical', 'integerOnly' => true),
            array('amount_adj', 'numerical'),
            array('start_from, end_to, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ah_proll_id, percentage_of_ah_proll_id, amount_adj, start_from, end_to, is_active, create_by, create_time, update_by, update_time, earn_deduct_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ahProll' => array(self::BELONGS_TO, 'AhProll', 'ah_proll_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ah_proll_id' => 'Head',
            'percentage_of_ah_proll_id' => 'Percentage',
            'amount_adj' => 'Amount Adjust',
            'earn_deduct_type'=>'Basis',
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
            $criteria->condition = "id!=" . $this->id . " AND ah_proll_id=" . $this->ah_proll_id;
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

    public function percengateAmount($percentageAmountOf, $amountAdj) {
        if ($percentageAmountOf != "" || $percentageAmountOf != 0) {
            $criteria = new CDbCriteria();
            $criteria->select = "amount_adj";
            $criteria->condition = "is_active=" . self::ACTIVE . " AND ah_proll_id=" . $percentageAmountOf;
            $data = self::model()->findAll($criteria);
            if ($data) {
                foreach ($data as $d):
                    $adjAmountFinal = $d->amount_adj;
                endforeach;
                $adjAmountFinal = ($amountAdj/$adjAmountFinal)*100;
                $nameOfAh="% of ".AhProll::model()->nameOfThis($percentageAmountOf);
            }else {
                $adjAmountFinal = "";
                $nameOfAh="";
            }
        } else {
            $adjAmountFinal = "";
            $nameOfAh="";
        }

        return $adjAmountFinal." ".$nameOfAh;
    }
    
    public function percengateAmountOnly($percentageAmountOf, $amountAdj){
        if ($percentageAmountOf != "") {
            $criteria = new CDbCriteria();
            $criteria->select = "amount_adj";
            $criteria->condition = "is_active=" . self::ACTIVE . " AND ah_proll_id=" . $percentageAmountOf;
            $data = self::model()->findAll($criteria);
            if ($data) {
                foreach ($data as $d):
                    $adjAmountFinal = $d->amount_adj;
                endforeach;
                $adjAmountFinal = ($amountAdj/$adjAmountFinal)*100;
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

        $criteria->compare('id', $this->id);
        $criteria->compare('ah_proll_id', $this->ah_proll_id);
        $criteria->compare('percentage_of_ah_proll_id', $this->percentage_of_ah_proll_id);
        $criteria->compare('amount_adj', $this->amount_adj);
        $criteria->compare('earn_deduct_type', $this->earn_deduct_type);
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