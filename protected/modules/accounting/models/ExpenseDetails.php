<?php

/**
 * This is the model class for table "expense_details".
 *
 * The followings are the available columns in table 'expense_details':
 * @property integer $id
 * @property integer $expense_id
 * @property double $amount
 * @property string $remarks
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property integer $expense_head_id
 * @property string $updated_at
 */
class ExpenseDetails extends CActiveRecord
{
    public $title;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'expense_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('expense_id, amount, expense_head_id', 'required'),
            array('expense_id, created_by, updated_by, expense_head_id', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical'),
            array('remarks, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, expense_id, amount, remarks, created_by, created_at, updated_by, updated_at, expense_head_id', 'safe', 'on' => 'search'),
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
            'expense_head_id' => 'Title',
            'expense_id' => 'Expense',
            'amount' => 'Amount',
            'remarks' => 'Note',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('expense_id', $this->expense_id);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_by', $this->created_by);
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
        // set default time zone to asia/dhaka
        date_default_timezone_set('Asia/Dhaka');
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_at = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ExpenseDetails the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
