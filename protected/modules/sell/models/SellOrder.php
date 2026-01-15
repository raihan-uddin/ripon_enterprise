<?php

/**
 * This is the model class for table "sell_order".
 *
 * The followings are the available columns in table 'sell_order':
 * @property integer $id
 * @property integer $cash_due
 * @property string $date
 * @property string $exp_delivery_date
 * @property integer $max_sl_no
 * @property string $so_no
 * @property integer $customer_id
 * @property double $discount_percentage
 * @property double $vat_amount
 * @property double $total_amount
 * @property double $discount_amount
 * @property double $vat_percentage
 * @property double $grand_total
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property integer $order_type
 * @property string $updated_at
 * @property string $order_note
 * @property double $total_paid
 * @property double $total_due
 * @property double $costing
 * @property double $delivery_charge
 * @property boolean $is_paid
 * @property boolean $is_opening
 */
class SellOrder extends CActiveRecord
{
    public $city;
    public $state;
    public $total_qty;
    public $avg_sp;
    public $invoice_no;
    public $item_count;
    public $row_total;
    public $customer_name;
    public $invoice_id;
    public $username;
    public $contact_no;
    public $print_type;
    public $company_name;
    public $customer_code;
    public $pp;
    public $cogs;
    public $product_name;
    public $product_code;
    public $qty;
    public $amount;
    public $total_sales;
    public $return_amount;
    public $group_by;
    public $manufacturer_id;

    const NEW_ORDER = 1;
    const REPAIR_ORDER = 2;

    const NORMAL_ORDER_PRINT = 1;
    const NORMAL_PAD_PRINT = 4;
    const DELIVERY_CHALLAN_PRINT = 5;

    const PAID = 1;
    const DUE = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sell_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('max_sl_no, cash_due, so_no, date, customer_id, discount_percentage, discount_amount, grand_total, order_type', 'required'),
            array('grand_total, discount_amount, discount_percentage, vat_percentage, vat_amount, is_opening, total_return, road_fee, damage_value, sr_commission,
            total_amount, is_paid, total_paid, total_due, delivery_charge, costing', 'numerical'),
            array('max_sl_no, cash_due, customer_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('created_at, updated_at, date, exp_delivery_date, so_no, order_note', 'safe'),
            // The following rule is used by search().
            array('id, date, cash_due, exp_delivery_date, max_sl_no, vat_percentage, so_no, customer_id, discount_percentage, 
            discount_amount, grand_total, created_by, total_return, damage_value, road_fee, sr_commission,
            created_at, updated_by, updated_at, total_amount, order_type, total_paid, total_due, delivery_charge,
            order_note, is_paid, costing, is_opening', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cash_due' => 'Cash / Credit',
            'date' => 'Date',
            'exp_delivery_date' => 'Exp. Delivery Date',
            'max_sl_no' => 'Max Sl No',
            'so_no' => 'SO No',
            'job_no' => 'Job No',
            'job_card_date' => 'Job Card Date',
            'job_max_sl_no' => 'JOB Sl',
            'vat_percentage' => 'VAT(%)',
            'vat_amount' => 'VAT',
            'customer_id' => 'Customer',
            'discount_percentage' => 'Discount Percentage',
            'discount_amount' => 'Discount Amount',
            'grand_total' => 'Grand Total',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'order_type' => 'Order Type',
            'order_note' => 'Order Note',
            'is_paid' => 'Paid?',
            'total_amount' => 'Total Amount',
            'total_paid' => 'Total Paid',
            'total_due' => 'Total Due',
            'delivery_charge' => 'Delivery Charge',
            'costing' => 'Costing',
            'is_opening' => 'Is Opening',
            'total_return' => 'Total Return',
            'manufacturer_id' => 'Company',
            'sr_commission' => 'SR Commission',
            'road_fee' => 'Road Fee',
            'damage_value' => 'Damage',
        );
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        return $data ? $data->so_no : "N/A";
    }

    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(max_sl_no) as max_sl_no";
        $criteria->addColumnCondition(['year(date)' => date('Y'), 'month(date)' => date('m')]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->max_sl_no + 1 : 1;
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

        $criteria->addColumnCondition(['t.is_deleted' => 0]);

        if (!Yii::app()->user->checkAccess('Admin')) {
            $criteria->addColumnCondition(['t.created_by' => Yii::app()->user->getState('user_id')]);
        }

        if (($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->compare('c.company_name', ($this->customer_id), true);
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('delivery_charge', $this->delivery_charge);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('so_no', $this->so_no, true);
        $criteria->compare('job_no', $this->job_no);
        $criteria->compare('is_all_issue_done', $this->is_all_issue_done);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('total_paid', $this->total_paid, true);
        $criteria->compare('total_due', $this->total_due, true);
        $criteria->compare('cash_due', $this->cash_due);
        $criteria->compare('is_opening', $this->is_opening);
        $criteria->compare('job_card_date', $this->job_card_date);
        $criteria->compare('job_max_sl_no', $this->job_max_sl_no);
        $criteria->compare('vat_percentage', $this->vat_percentage);
        $criteria->compare('vat_amount', $this->vat_amount);
        $criteria->compare('exp_delivery_date', $this->exp_delivery_date);
        $criteria->compare('discount_percentage', $this->discount_percentage);
        $criteria->compare('discount_amount', $this->discount_amount);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('total_amount', $this->total_amount, true);
        $criteria->compare('order_note', $this->order_note, true);
        $criteria->compare('costing', $this->costing, true);
        $criteria->compare('road_fee', $this->road_fee, true);
        $criteria->compare('damage_value', $this->damage_value, true);
        $criteria->compare('sr_commission', $this->sr_commission, true);


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

        $dateTime = date('Y-m-d H:i:s');


        $businessId = Yii::app()->user->getState('business_id');
        $branchId = Yii::app()->user->getState('branch_id');

        $this->business_id = $businessId;
        $this->branch_id = $branchId;


        if (($this->exp_delivery_date) == '') {
            $this->exp_delivery_date = NULL;
        }
        if ($this->isNewRecord) {
            $this->created_at = $dateTime;
            $this->created_by = Yii::app()->user->getState('user_id');
        } else {
            $this->updated_by = Yii::app()->user->getState('user_id');
            $this->updated_at = $dateTime;
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SellOrder the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function orderType($value)
    {
        if ($value != self::NEW_ORDER) {
            $string = "<span class='badge badge-danger'>QUOTATION</span>";
        } else {
            $string = "<span class='badge badge-success'>NEW ORDER</span>";
        }
        return $string;
    }


    public function isPaid($value)
    {
        if ($value != self::PAID) {
            $string = "<span class='badge badge-danger'>DUE</span>";
        } else {
            $string = "<span class='badge badge-success'>PAID</span>";
        }
        return $string;
    }

    public function totalSales($customer_id){
        $criteria = new CDbCriteria();
        $criteria->select = "SUM(grand_total) as total_sales";
        $criteria->addColumnCondition(['customer_id' => $customer_id]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->total_sales : 0;
    }

    public function totalPaidWithReturnOfInvoice($invoice_id){
        $total_mr = MoneyReceipt::model()->totalPaidAmountOfThisInvoice($invoice_id);
        $total_return = SellReturn::model()->totalReturnAmountOfThisInvoiceBySellId($invoice_id);

        return [
            'total_paid' => $total_mr, 
            'total_return' => $total_return,
            'total_paid_with_return' => $total_mr + $total_return
        ];
    }

    public function changePaidDue($sellObj){
        $totalMoneyReceipt = MoneyReceipt::model()->totalPaidAmountOfThisInvoice($sellObj->id);
        if($totalMoneyReceipt <= 0){
            $totalMoneyReceipt = 0;
        }

        $totalReturn = SellReturn::model()->totalReturnAmountOfThisInvoiceBySellId($sellObj->id);

        $rem = $sellObj->grand_total - $totalMoneyReceipt - $totalReturn;
        $sellObj->total_paid = $totalMoneyReceipt;
        $sellObj->total_return = $totalReturn;
        $sellObj->total_due = $rem > 0 ? $rem : 0;
        if($rem <= 0){
            $sellObj->is_paid = self::PAID;
        }else{ 
            $sellObj->is_paid = self::DUE;
        }
        $sellObj->save();
    }

}
