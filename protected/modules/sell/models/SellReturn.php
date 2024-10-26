<?php

/**
 * This is the model class for table "sell_return".
 *
 * The followings are the available columns in table 'sell_return':
 * @property integer $id
 * @property string $return_date
 * @property integer $customer_id
 * @property string $return_amount
 * @property string $costing
 * @property integer $return_type
 * @property string $remarks
 * @property integer $is_deleted
 * @property integer $business_id
 * @property integer $branch_id
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $is_opening
 */
class SellReturn extends CActiveRecord
{
    public $supplier_id;
    public $grand_total;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sell_return';
    }

    const CASH_RETURN = 1;
    const DAMAGE_RETURN = 2;

    const RETURN_STATUS_PENDING = 1;
    const RETURN_STATUS_APPROVED = 2;
    const RETURN_STATUS_REJECTED = 3;



    const RETURN_TYPE_ARR = [
        self::CASH_RETURN => "CASH RETURN",
        self::DAMAGE_RETURN => "WARRANTY/REPLACEMENT",
    ];

    const RETURN_STATUS_ARR = [
        self::RETURN_STATUS_PENDING => "PENDING",
        self::RETURN_STATUS_APPROVED => "APPROVED",
        self::RETURN_STATUS_REJECTED => "REJECTED",
    ];

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('return_date, customer_id', 'required'),
            array('customer_id, return_type, is_deleted, business_id, branch_id, created_by, updated_by, is_opening, status', 'numerical', 'integerOnly' => true),
            array('return_amount, costing', 'length', 'max' => 10),
            array('remarks, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, return_date, customer_id, return_amount, costing, status, return_type, remarks, is_deleted, business_id, branch_id, created_by, created_at, updated_by, updated_at, is_opening', 'safe', 'on' => 'search'),
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
            'return_date' => 'Return Date',
            'customer_id' => 'Customer',
            'return_amount' => 'Return Amount',
            'costing' => 'Costing',
            'return_type' => 'Return Type',
            'remarks' => 'Remarks',
            'is_deleted' => 'Is Deleted',
            'business_id' => 'Business',
            'status' => 'Status',
            'branch_id' => 'Branch',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_opening' => 'Is Opening',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.return_date', $this->return_date, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.return_amount', $this->return_amount, true);
        $criteria->compare('t.costing', $this->costing, true);
        $criteria->compare('t.return_type', $this->return_type);
        $criteria->compare('t.remarks', $this->remarks, true);
        $criteria->compare('t.is_deleted', $this->is_deleted);
        $criteria->compare('t.business_id', $this->business_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.updated_by', $this->updated_by);
        $criteria->compare('t.updated_at', $this->updated_at, true);
        $criteria->compare('t.is_opening', $this->is_opening);
        $criteria->compare('t.status', $this->status);

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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SellReturn the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        // set default time zone to asia/dhaka
        date_default_timezone_set('Asia/Dhaka');

        $dateTime = date('Y-m-d H:i:s');

        $businessId = Yii::app()->user->getState('business_id') ?: null;
        $branchId = Yii::app()->user->getState('branch_id') ?: null;

        $this->business_id = $businessId;
        $this->branch_id = $branchId;

        if ($this->isNewRecord) {
            $this->created_at = $dateTime;
            $this->created_by = Yii::app()->user->getState('user_id');
        } else {
            $this->updated_by = Yii::app()->user->getState('user_id');
            $this->updated_at = $dateTime;
        }
        return parent::beforeSave();
    }
}
