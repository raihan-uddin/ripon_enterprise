<?php

/**
 * This is the model class for table "expense".
 *
 * The followings are the available columns in table 'expense':
 * @property integer $id
 * @property integer $max_sl_no
 * @property string $entry_no
 * @property string $date
 * @property double $amount
 * @property string $remarks
 * @property integer $is_approved
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Expense extends CActiveRecord
{
    public $so_no;
    public $customer_name;
    public $customer_id;
    public $order_id;
    public $total_amount;
    public $vat_percentage;
    public $vat_amount;
    public $grand_total;
    public $created_by_text;

    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(max_sl_no) as max_sl_no";
        $criteria->addColumnCondition(['year(date)' => date('Y'), 'month(date)' => date('m')]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->max_sl_no + 1 : 1;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Expense the static model class
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
        return 'expense';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('max_sl_no, entry_no, date, amount', 'required'),
            array('max_sl_no, is_approved, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical'),
            array('entry_no', 'length', 'max' => 255),
            array('remarks, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, max_sl_no, entry_no, date, amount, remarks, is_approved, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'max_sl_no' => 'Max Sl No',
            'entry_no' => 'Entry No',
            'date' => 'Date',
            'amount' => 'Amount',
            'remarks' => 'Remarks',
            'is_approved' => 'Is Approved',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {

        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = " ";


        if (($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', ($this->created_by), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('entry_no', $this->entry_no, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_at = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

}
