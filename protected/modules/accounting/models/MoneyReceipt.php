<?php

/**
 * This is the model class for table "money_receipt".
 *
 * The followings are the available columns in table 'money_receipt':
 * @property integer $id
 * @property string $date
 * @property integer $customer_id
 * @property integer $invoice_id
 * @property integer $max_sl_no
 * @property string $mr_no
 * @property integer $payment_type
 * @property integer $bank_id
 * @property string $cheque_no
 * @property string $cheque_date
 * @property double $amount
 * @property double $discount
 * @property integer $is_approved
 * @property string $remarks
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class MoneyReceipt extends CActiveRecord
{
    public $ids;
    public $order_type;
    public $cash_due;
    public $exp_delivery_date;
    public $city;
    public $state;
    public $item_count;
    public $so_no;
    public $customer_name;
    public $total_amount;
    public $vat_percentage;
    public $vat_amount;
    public $grand_total;
    public $model_id;
    public $row_total;
    public $order_note;
    public $total_due;
    public $username;
    public $due_amount;
    public $rem_amount;
    public $invoice_total;
    public $invoice_total_due;
    public $rem_total_amount;
    public $total_paid_amount;
    public $received_by;
    public $tmp_amount;
    public $tmp_discount;
    public $tmp_invoice_id;
    public $total_discount_amount;
    public $collected_amt;
    public $current_due;

    const CASH = 1;
    const CHECK = 2;
    const ONLINE = 3;

    const APPROVED = 1;
    const DENY = 2;
    const PENDING = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'money_receipt';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, customer_id, max_sl_no, mr_no, payment_type, amount', 'required'),
            array('customer_id, invoice_id, max_sl_no, payment_type, bank_id, is_approved, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('amount, discount', 'numerical'),
            array('mr_no, cheque_no', 'length', 'max' => 255),
            array('cheque_date, remarks, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, date, customer_id, invoice_id, max_sl_no, mr_no, payment_type, bank_id, cheque_no, cheque_date, amount, discount, is_approved, remarks, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'date' => 'Date',
            'customer_id' => 'Customer',
            'invoice_id' => 'Invoice No',
            'max_sl_no' => 'Max Sl No',
            'mr_no' => 'Mr No',
            'payment_type' => 'Collection Type',
            'bank_id' => 'Bank',
            'cheque_no' => 'Cheque No',
            'cheque_date' => 'Cheque Date',
            'amount' => 'Amount',
            'discount' => 'Discount',
            'is_approved' => 'Is Approved',
            'remarks' => 'Remarks',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        );
    }


    public function paymentTypeFilter()
    {
        return array(
            array('id' => self::CASH, 'title' => 'CASH'),
            array('id' => self::CHECK, 'title' => 'CHEQUE'),
            array('id' => self::ONLINE, 'title' => 'ONLINE'),
        );
    }


    public function paymentTypeString($value)
    {
        if ($value == self::CASH)
            $badge = "<span class='badge badge-success'>CASH</span>";
        else if ($value == self::CHECK)
            $badge = "<span class='badge badge-info'>CHECK</span>";
        else if ($value == self::ONLINE)
            $badge = "<span class='badge badge-warning'>ONLINE</span>";
        else
            $badge = "";
        return $badge;

    }

    public function beforeSave()
    {
        // set default time zone to asia/dhaka
        date_default_timezone_set('Asia/Dhaka');
        $dateTime = date('Y-m-d H:i:s');


        $businessId = Yii::app()->user->getState('business_id');
        $branchId = Yii::app()->user->getState('branch_id');

        $this->business_id = $businessId;
        $this->branch_id = $branchId;

        if ($this->cheque_date == "")
            $this->cheque_date = NULL;
        if ($this->isNewRecord) {
            $this->created_at = $dateTime;
            $this->created_by = Yii::app()->user->getState('user_id');
        } else {
            $this->updated_at = $dateTime;
            $this->updated_by = Yii::app()->user->getState('user_id');
        }
        return parent::beforeSave();
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
        // $criteria->addColumnCondition(['t.is_deleted' => 0]);


        if (($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->compare('c.company_name', ($this->customer_id), true);
        }
        if (($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', ($this->created_by), true);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('invoice_id', $this->invoice_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('mr_no', $this->mr_no, true);
        $criteria->compare('payment_type', $this->payment_type);
        $criteria->compare('bank_id', $this->bank_id);
        $criteria->compare('cheque_no', $this->cheque_no, true);
        $criteria->compare('cheque_date', $this->cheque_date, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('is_approved', $this->is_approved);
        $criteria->compare('remarks', $this->remarks, true);
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MoneyReceipt the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(max_sl_no) as max_sl_no";
        $criteria->addColumnCondition(['year(date)' => date('Y'), 'month(date)' => date('m')]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->max_sl_no + 1 : 1;
    }

    public function totalPaidAmountOfThisInvoice($invoice_id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = "CAST(SUM(COALESCE(amount, 0) + COALESCE(discount, 0)) AS DECIMAL(10,2)) AS amount";
        $criteria->addColumnCondition(['t.invoice_id' => $invoice_id, 't.is_deleted' => 0]);
        $data = self::model()->findByAttributes([], $criteria);
        $collectionAmt = 0;
        if ($data)
            if ($data->amount > 0)
                $collectionAmt = $data->amount;

        return round($collectionAmt, 2);
    }

    public function totalPaidAmountAndDiscountOfThisInvoice($invoice_id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = " SUM(COALESCE(amount, 0)) AS amount, SUM(COALESCE(discount, 0)) AS discount, GROUP_CONCAT(id) as ids";
        $criteria->addColumnCondition(['t.invoice_id' => $invoice_id, 't.is_deleted' => 0]);
        $data = self::model()->findByAttributes([], $criteria);
        $mrCount = 0;
        if ($data)
            if ($data->amount > 0)
                $mrCount = count(explode(',', $data->ids));
        return [
            'collection_amt' => $data ? $data->amount : 0,
            'collection_disc' => $data ? $data->discount : 0,
            'ids' => $data ? $data->ids : 0,
            'mr_count' => $mrCount,
        ];
    }

    public function totalCollection($customer_id){
        if($customer_id == 0){
            return [
                'collection_amt' => 0,
                'collection_disc' => 0,
                'total_collection' => 0,
            ];
        }
        $criteria = new CDbCriteria();
        $criteria->select = " SUM(COALESCE(amount, 0)) AS amount, SUM(COALESCE(discount, 0)) AS discount";
        $criteria->addColumnCondition(['t.customer_id' => $customer_id, 't.is_deleted' => 0]);
        $data = self::model()->findByAttributes([], $criteria);

        return [
            'collection_amt' => $data ? $data->amount : 0,
            'collection_disc' => $data ? $data->discount : 0,
            'total_collection' => $data ? $data->amount + $data->discount : 0,
        ];
    }
}
