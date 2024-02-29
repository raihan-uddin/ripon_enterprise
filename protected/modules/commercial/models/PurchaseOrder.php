<?php

/**
 * This is the model class for table "purchase_order".
 *
 * The followings are the available columns in table 'purchase_order':
 * @property integer $id
 * @property string $date
 * @property integer $max_sl_no
 * @property string $po_no
 * @property string $manual_po_no
 * @property integer $supplier_id
 * @property double $total
 * @property double $vat
 * @property double $discount_percentage
 * @property double $discount
 * @property double $grand_total
 * @property integer $is_paid
 * @property integer $is_all_received
 * @property integer $cash_due
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property integer $order_type
 * @property integer $store_id
 * @property integer $location_id
 * @property integer $ship_by
 * @property string $updated_at
 * @property string $bill_to
 * @property string $ship_to
 * @property string $exp_receive_date
 */
class PurchaseOrder extends CActiveRecord
{
    public $city;
    public $state;
    public $item_count;
    public $row_total;
    public $print_type;
    public $exp_delivery_date;
    public $customer_id;
    public $note;
    public $web;
    public $address;
    public $contact_no;
    public $unit_id;
    public $so_no;
    public $invoice_no;

    const PURCHASE = 1;
    const PURCHASE_RECEIVE = 2;
    const ALL_RECEIVED = 1;
    const NOT_RECEIVED = 0;

    const PAID = 1;
    const DUE = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, max_sl_no, po_no, supplier_id, total_amount, cash_due, order_type', 'required'),
            array('max_sl_no, supplier_id, is_paid, is_all_received, cash_due, created_by, updated_by, ship_by, order_type, location_id, 
			store_id', 'numerical', 'integerOnly' => true),
            array('total_amount, vat_amount, discount_percentage, discount, vat_percentage, grand_total', 'numerical'),
            array('po_no, manual_po_no', 'length', 'max' => 255),
            array('created_at, updated_at, bill_to, ship_to, exp_receive_date, order_note', 'safe'),
            // The following rule is used by search().

            array('id, date, max_sl_no, bill_to, ship_to, order_note, ship_by, order_type, po_no, store_id, vat_percentage, grand_total, manual_po_no, location_id,
			 supplier_id, total_amount, vat_amount, discount_percentage, discount, is_paid, is_all_received, cash_due, created_by, created_at, updated_by, exp_receive_date, 
			 updated_at', 'safe', 'on' => 'search'),
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
            'supplier' => array(self::BELONGS_TO, 'Suppliers', 'supplier_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'store_id' => 'Store',
            'location_id' => 'Location',
            'order_type' => 'Type',
            'date' => 'Date',
            'max_sl_no' => 'Max Sl No',
            'po_no' => 'Po No',
            'manual_po_no' => 'Manual Po No',
            'supplier_id' => 'Supplier',
            'total_amount' => 'Total',
            'vat_percentage' => 'Vat (%)',
            'vat_amount' => 'Vat',
            'discount_percentage' => 'Discount Percentage',
            'discount' => 'Discount',
            'is_paid' => 'Is Paid',
            'is_all_received' => 'Is All Received',
            'cash_due' => 'Cash Due',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'grand_total' => 'Grand Total',
            'updated_at' => 'Updated At',
            'ship_by' => 'Ship By',
            'bill_to' => 'Bill To',
            'ship_to' => 'Ship To',
            'exp_receive_date' => 'Exp. Rcv. Date',
            'order_note' => 'Order Note',
        );
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

        if (($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN suppliers s on t.supplier_id = s.id ";
            $criteria->compare('s.company_name', ($this->supplier_id), true);
        }
        if (($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', ($this->created_by), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('ship_by', $this->ship_by);
        $criteria->compare('location_id', $this->location_id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('po_no', $this->po_no, true);
        $criteria->compare('manual_po_no', $this->manual_po_no, true);
        $criteria->compare('total_amount', $this->total_amount);
        $criteria->compare('vat_amount', $this->vat_amount);
        $criteria->compare('discount_percentage', $this->discount_percentage);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('vat_percentage', $this->vat_percentage);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('is_all_received', $this->is_all_received);
        $criteria->compare('cash_due', $this->cash_due);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('bill_to', $this->bill_to, true);
        $criteria->compare('ship_to', $this->ship_to, true);
        $criteria->compare('exp_receive_date', $this->exp_receive_date, true);

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


    public function searchPendingReceive()
    {

        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = " ";

        $criteria->addColumnCondition(['is_all_received' => PurchaseOrder::NOT_RECEIVED]);
        if (($this->supplier_id) != "") {
            $criteria->join .= " INNER JOIN suppliers s on t.supplier_id = s.id ";
            $criteria->compare('s.company_name', ($this->supplier_id), true);
        }
        if (($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', ($this->created_by), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('ship_by', $this->ship_by);
        $criteria->compare('location_id', $this->location_id);
        $criteria->compare('store_id', $this->store_id);
        $criteria->compare('order_type', $this->order_type);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('po_no', $this->po_no, true);
        $criteria->compare('manual_po_no', $this->manual_po_no, true);
        $criteria->compare('total_amount', $this->total_amount);
        $criteria->compare('vat_amount', $this->vat_amount);
        $criteria->compare('discount_percentage', $this->discount_percentage);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('vat_percentage', $this->vat_percentage);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('is_all_received', $this->is_all_received);
        $criteria->compare('cash_due', $this->cash_due);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('bill_to', $this->bill_to, true);
        $criteria->compare('ship_to', $this->ship_to, true);
        $criteria->compare('exp_receive_date', $this->exp_receive_date, true);

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
        if (($this->exp_receive_date) == "")
            $this->exp_receive_date = NULL;
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
     * @return PurchaseOrder the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        return $data ? $data->po_no : "";
    }
}
