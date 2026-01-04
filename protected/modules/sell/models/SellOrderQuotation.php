<?php

/**
 * This is the model class for table "sell_order_quotation".
 *
 * The followings are the available columns in table 'sell_order_quotation':
 * @property integer $id
 * @property integer $customer_id
 * @property double $grand_total
 * @property string $date
 * @property integer $max_sl_no
 * @property string $so_no
 * @property double $vat_percentage
 * @property double $vat_amount
 * @property double $discount_percentage
 * @property double $discount_amount
 * @property double $total_amount
 * @property string $costing
 * @property string $delivery_charge
 * @property string $order_note
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $business_id
 * @property integer $branch_id
 * @property integer $is_deleted
 */
class SellOrderQuotation extends CActiveRecord
{
	
    public $city;
    public $state;
    public $invoice_no;
    public $item_count;
    public $row_total;
    public $customer_name;
    public $manufacturer_id;
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
    public $total_paid;
    public $total_return;
    public $total_due;
    public $order_type;
    public $cash_due;
    public $exp_delivery_date;
    public $color;

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
		return 'sell_order_quotation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('max_sl_no, so_no, date, customer_id, discount_percentage, discount_amount, grand_total', 'required'),
            array('grand_total, discount_amount, discount_percentage, vat_percentage, vat_amount,
            total_amount, delivery_charge, costing', 'numerical'),
            array('max_sl_no, customer_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('created_at, updated_at, date, so_no, order_note', 'safe'),
            // The following rule is used by search().
            array('id, date, max_sl_no, vat_percentage, so_no, customer_id, discount_percentage, 
            discount_amount, grand_total, created_by, created_at, updated_by, updated_at, total_amount, delivery_charge,
            order_note, costing', 'safe', 'on' => 'search'),
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
            'date' => 'Date',
            'max_sl_no' => 'Max Sl No',
            'so_no' => 'Draft No',
            'vat_percentage' => 'VAT(%)',
            'vat_amount' => 'VAT',
            'discount_percentage' => 'Discount Percentage',
            'discount_amount' => 'Discount Amount',
            'grand_total' => 'Grand Total',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'order_note' => 'Quotation Note',
            'total_amount' => 'Total Amount',
            'delivery_charge' => 'Delivery Charge',
            'costing' => 'Costing',
            'customer_id' => 'Customer',
            'manufacturer_id' => 'Company'
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
        $criteria->compare('delivery_charge', $this->delivery_charge);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('so_no', $this->so_no, true);
        $criteria->compare('vat_percentage', $this->vat_percentage);
        $criteria->compare('vat_amount', $this->vat_amount);
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

        if ($this->isNewRecord) {
            $this->created_at = $dateTime;
            $this->created_by = Yii::app()->user->getState('user_id');
        } else {
            $this->updated_by = Yii::app()->user->getState('user_id');
            $this->updated_at = $dateTime;
        }
        return parent::beforeSave();
    }


    public function totalSales($customer_id){
        $criteria = new CDbCriteria();
        $criteria->select = "SUM(grand_total) as total_sales";
        $criteria->addColumnCondition(['customer_id' => $customer_id]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->total_sales : 0;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellOrderQuotation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
