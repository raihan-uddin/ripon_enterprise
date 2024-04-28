<?php

/**
 * This is the model class for table "payment_receipt".
 *
 * The followings are the available columns in table 'payment_receipt':
 * @property integer $id
 * @property string $date
 * @property integer $supplier_id
 * @property integer $order_id
 * @property integer $max_sl_no
 * @property string $pr_no
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
class PaymentReceipt extends CActiveRecord
{

    const CASH = 1;
    const CHECK = 2;
    const ONLINE = 3;
    const APPROVED = 1;
    const DENY = 2;
    const PENDING = 0;
    public $order_type;
    public $cash_due;
    public $exp_delivery_date;
    public $city;
    public $invoice_id;
    public $username;
    public $state;
    public $item_count;
    public $so_no;
    public $customer_name;
    public $total_amount;
    public $vat_percentage;
    public $vat_amount;
    public $grand_total;
    public $paid_amt;
    public $model_id;
    public $row_total;
    public $order_note;
    public $due_amount;
    public $rem_amount;
    public $invoice_total;
    public $invoice_total_due;
    public $rem_total_amount;
    public $total_paid_amount;
    public $received_by;
    public $po_no;

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
     * @return PaymentReceipt the static model class
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
        return 'payment_receipt';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, supplier_id, order_id, max_sl_no, pr_no, payment_type, amount', 'required'),
            array('supplier_id, order_id, max_sl_no, payment_type, bank_id, is_approved, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('amount, discount', 'numerical'),
            array('pr_no, cheque_no', 'length', 'max' => 255),
            array('cheque_date, remarks, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, date, supplier_id, order_id, max_sl_no, pr_no, payment_type, bank_id, cheque_no, cheque_date, amount, discount, is_approved, remarks, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'supplier_id' => 'Supplier',
            'order_id' => 'Order',
            'max_sl_no' => 'Max Sl No',
            'pr_no' => 'Pr No',
            'payment_type' => 'Pay Type',
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
            'received_by' => 'Pay By',
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

        if (($this->order_id) != "") {
            $criteria->join .= " INNER JOIN purchase_order po on t.order_id = po.id ";
            $criteria->compare('po.po_no', ($this->order_id), true);
        }
        if (($this->supplier_id) != "") {
            $criteria->join .= " INNER JOIN suppliers s on t.supplier_id = s.id ";
            $criteria->compare('s.company_name', ($this->supplier_id), true);
        }
        if (($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', ($this->created_by), true);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('pr_no', $this->pr_no, true);
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
        if (($this->cheque_date) == "") {
            $this->cheque_date = NULL;
        }
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_at = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

    public function totalPaidAmountOfThisOrder($order_id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = "CAST(SUM(COALESCE(amount, 0) + COALESCE(discount, 0)) AS DECIMAL(10,2)) AS amount";
        $criteria->addColumnCondition(['t.order_id' => $order_id]);
        $data = self::model()->findByAttributes([], $criteria);
        $prAmount = 0;
        if ($data)
            if ($data->amount)
                $prAmount = $data->amount;
        return $prAmount;
    }

}
