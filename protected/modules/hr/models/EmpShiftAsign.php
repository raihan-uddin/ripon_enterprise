<?php

/**
 * This is the model class for table "emp_shift_asign".
 *
 * The followings are the available columns in table 'emp_shift_asign':
 * @property integer $id
 * @property integer $emp_id
 * @property integer $shift_id
 * @property string $date_asign
 * @property string $created_datetime
 * @property integer $created_by
 * @property string $updated_datetime
 * @property integer $updated_by
 */
class EmpShiftAsign extends CActiveRecord {

    public $department_id;
    public $date_from;
    public $date_to;
    public $shift_transfer;
	public $sub_department_id;
	public $device_id;

    /**
     * Returns the static model of the specified AR class.
     * @return EmpShiftAsign the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'emp_shift_asign';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
           // array('shift_id, date_from, date_to', 'required'),
            array('emp_id, shift_id', 'numerical', 'integerOnly' => true),
            array('date_asign, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, emp_id, shift_id, device_id, date_asign, created_datetime, created_by, updated_datetime, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'emp_id' => 'Employee',
            'shift_id' => 'Shift',
            'date_asign' => 'Date Asign',
            'device_id' => 'Device ID',
            'created_datetime' => 'Created Datetime',
            'created_by' => 'Created By',
            'updated_datetime' => 'Updated Datetime',
            'updated_by' => 'Updated By',
        );
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_datetime = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->getId();
        } else {
            $this->updated_datetime = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->getId();
        }
        return parent::beforeSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
		
		$criteria->join = "";
        if (trim($this->device_id) != "") {
                $criteria->join .= " INNER JOIN employees on t.emp_id = employees.id and employees.device_id like '%".trim($this->device_id)."%'";
        }
		
        $criteria->compare('id', $this->id);
        $criteria->compare('emp_id', $this->emp_id);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('date_asign', $this->date_asign, true);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
            'sort' => array(
                'defaultOrder' => 'emp_id ASC',
            ),
        ));
    }

}
