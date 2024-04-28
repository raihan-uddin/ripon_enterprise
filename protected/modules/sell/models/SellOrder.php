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
 * @property integer $is_invoice_done
 * @property integer $is_job_card_done
 * @property integer $is_delivery_done
 * @property integer $is_partial_delivery
 * @property integer $is_partial_invoice
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property integer $bom_complete
 * @property integer $job_max_sl_no
 * @property integer $order_type
 * @property integer $is_all_issue_done
 * @property integer $is_all_production_done
 * @property string $updated_at
 * @property string $job_no
 * @property string $job_card_date
 * @property string $order_note
 * @property double $total_paid
 * @property double $total_due
 * @property double $costing
 * @property boolean $is_paid
 * @property boolean $is_opening
 */
class SellOrder extends CActiveRecord
{
    public $city;
    public $state;
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

    const INVOICE_DONE = 1;
    const INVOICE_NOT_DONE = 0;

    const JOB_CARD_ISSUE_DONE = 1;
    const JOB_CARD_ISSUE_NOT_DONE = 0;

    const PRODUCTION_DONE = 1;
    const PRODUCTION_NOT_DONE = 0;

    const JOB_CARD_DONE = 1;
    const JOB_CARD_NOT_DONE = 0;

    const DELIVERY_DONE = 1;
    const DELIVERY_NOT_DONE = 0;

    const PARTIAL_INVOICE_DONE = 1;
    const PARTIAL_INVOICE_NOT_DONE = 0;

    const PARTIAL_DELIVERY_DONE = 1;
    const PARTIAL_DELIVERY_NOT_DONE = 0;

    const BOM_COMPLETE = 1;
    const BOM_NOT_COMPLETE = 2;

    const NEW_ORDER = 1;
    const REPAIR_ORDER = 2;

    const NORMAL_ORDER_PRINT = 1;
    const NORMAL_PAD_PRINT = 4;
    const PRODUCTION_ORDER_PRINT = 2;
    const ORDER_BOM = 3;

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
            array('grand_total, discount_amount, discount_percentage, vat_percentage, vat_amount, job_max_sl_no, is_opening,
            total_amount, is_all_issue_done, is_all_production_done, is_paid, total_paid, total_due, delivery_charge, costing', 'numerical'),
            array('max_sl_no, cash_due, customer_id, is_invoice_done, bom_complete, is_job_card_done, is_delivery_done, 
            is_partial_delivery, is_partial_invoice, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('created_at, updated_at, date, exp_delivery_date, so_no, job_no, job_card_date, order_note', 'safe'),
            // The following rule is used by search().
            array('id, date, cash_due, exp_delivery_date, max_sl_no, vat_percentage, so_no, customer_id, discount_percentage, bom_complete, 
            discount_amount, grand_total, is_invoice_done, is_job_card_done, is_delivery_done, is_partial_delivery, is_partial_invoice, created_by, 
            created_at, updated_by, updated_at, job_max_sl_no, job_no, job_card_date, total_amount, order_type, total_paid, total_due, delivery_charge,
            order_note, is_all_issue_done, is_all_production_done, is_paid, costing, is_opening', 'safe', 'on' => 'search'),
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
            'is_invoice_done' => 'Is Invoice Done',
            'is_job_card_done' => 'Is Job Card Done',
            'is_delivery_done' => 'Is Delivery Done',
            'is_partial_delivery' => 'Is Partial Delivery',
            'is_partial_invoice' => 'Is Partial Invoice',
            'bom_complete' => 'BOM Complete?',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'order_type' => 'Order Type',
            'order_note' => 'Order Note',
            'is_all_issue_done' => 'Issue Done?',
            'is_paid' => 'Paid?',
            'is_all_production_done' => 'Production Done?',
            'total_amount' => 'Total Amount',
            'total_paid' => 'Total Paid',
            'total_due' => 'Total Due',
            'delivery_charge' => 'Delivery Charge',
            'costing' => 'Costing',
        );
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        return $data ? $data->so_no : "N/A";
    }

    public function jobCard($id)
    {
        $data = self::model()->findByPk($id);
        return $data ? $data->job_no : "";
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
            $criteria->addColumnCondition(['t.created_by' => Yii::app()->user->id]);
        }

        if (($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->compare('c.company_name', ($this->customer_id), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
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
        $criteria->compare('bom_complete', $this->bom_complete);
        $criteria->compare('exp_delivery_date', $this->exp_delivery_date);
        $criteria->compare('discount_percentage', $this->discount_percentage);
        $criteria->compare('discount_amount', $this->discount_amount);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('is_invoice_done', $this->is_invoice_done);
        $criteria->compare('is_job_card_done', $this->is_job_card_done);
        $criteria->compare('is_delivery_done', $this->is_delivery_done);
        $criteria->compare('is_all_production_done', $this->is_all_production_done);
        $criteria->compare('is_partial_delivery', $this->is_partial_delivery);
        $criteria->compare('is_partial_invoice', $this->is_partial_invoice);
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

    public function searchProductionOrder()
    {

        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = " ";
        $criteria->addColumnCondition(['order_type' => self::NEW_ORDER]);
        $criteria->addCondition("job_max_sl_no > 0");

        if (($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->compare('c.company_name', ($this->customer_id), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date);
        $criteria->compare('delivery_charge', $this->delivery_charge);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('so_no', $this->so_no);
        $criteria->compare('job_no', $this->job_no);
        $criteria->compare('cash_due', $this->cash_due);
        $criteria->compare('job_card_date', $this->job_card_date);
        $criteria->compare('job_max_sl_no', $this->job_max_sl_no);
        $criteria->compare('vat_percentage', $this->vat_percentage);
        $criteria->compare('vat_amount', $this->vat_amount);
        $criteria->compare('bom_complete', $this->bom_complete);
        $criteria->compare('exp_delivery_date', $this->exp_delivery_date);
        $criteria->compare('discount_percentage', $this->discount_percentage);
        $criteria->compare('discount_amount', $this->discount_amount);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('is_invoice_done', $this->is_invoice_done);
        $criteria->compare('is_job_card_done', $this->is_job_card_done);
        $criteria->compare('is_delivery_done', $this->is_delivery_done);
        $criteria->compare('is_partial_delivery', $this->is_partial_delivery);
        $criteria->compare('is_partial_invoice', $this->is_partial_invoice);
        $criteria->compare('is_all_issue_done', $this->is_all_issue_done);
        $criteria->compare('is_all_production_done', $this->is_all_production_done);
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

    public function searchPendingDelivery()
    {

        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = " ";
        $criteria->addColumnCondition(['is_delivery_done' => SellOrder::DELIVERY_NOT_DONE]);

        if (($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->compare('c.company_name', ($this->customer_id), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('is_all_production_done', $this->is_all_production_done);
        $criteria->compare('is_all_issue_done', $this->is_all_issue_done);
        $criteria->compare('so_no', $this->so_no);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('job_no', $this->job_no);
        $criteria->compare('delivery_charge', $this->delivery_charge);
        $criteria->compare('cash_due', $this->cash_due);
        $criteria->compare('job_card_date', $this->job_card_date);
        $criteria->compare('job_max_sl_no', $this->job_max_sl_no);
        $criteria->compare('vat_percentage', $this->vat_percentage);
        $criteria->compare('vat_amount', $this->vat_amount);
        $criteria->compare('bom_complete', $this->bom_complete);
        $criteria->compare('exp_delivery_date', $this->exp_delivery_date);
        $criteria->compare('discount_percentage', $this->discount_percentage);
        $criteria->compare('discount_amount', $this->discount_amount);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('is_invoice_done', $this->is_invoice_done);
        $criteria->compare('is_job_card_done', $this->is_job_card_done);
        $criteria->compare('is_delivery_done', $this->is_delivery_done);
        $criteria->compare('is_partial_delivery', $this->is_partial_delivery);
        $criteria->compare('is_partial_invoice', $this->is_partial_invoice);
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
        if (($this->exp_delivery_date) == '') {
            $this->exp_delivery_date = NULL;
        }
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_by = Yii::app()->user->id;
            $this->updated_at = new CDbExpression('NOW()');
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

    public function bomStatus($value)
    {
        if ($value != self::BOM_COMPLETE) {
            $string = "<span class='badge badge-danger'>NOT COMPLETE</span>";
        } else {
            $string = "<span class='badge badge-success'>COMPLETE</span>";
        }
        return $string;
    }

    public function isPaid($value)
    {
        if ($value != Invoice::PAID) {
            $string = "<span class='badge badge-danger'>DUE</span>";
        } else {
            $string = "<span class='badge badge-success'>PAID</span>";
        }
        return $string;
    }

    public function jobStatus($value)
    {
        if ($value != self::JOB_CARD_DONE) {
            $string = "<span class='badge badge-danger'>NOT STARTED</span>";
        } else {
            $string = "<span class='badge badge-success'>STARTED</span>";
        }
        return $string;
    }
}
