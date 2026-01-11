<?php

/**
 * This is the model class for table "sell_order_quotation_details".
 *
 * The followings are the available columns in table 'sell_order_quotation_details':
 * @property integer $id
 * @property integer $order_type
 * @property integer $customer_id
 * @property double $grand_total
 * @property string $total_paid
 * @property string $total_return
 * @property string $total_due
 * @property string $date
 * @property integer $max_sl_no
 * @property string $so_no
 * @property integer $cash_due
 * @property double $vat_percentage
 * @property double $vat_amount
 * @property integer $bom_complete
 * @property string $exp_delivery_date
 * @property double $discount_percentage
 * @property double $discount_amount
 * @property integer $job_max_sl_no
 * @property string $job_no
 * @property double $total_amount
 * @property string $job_card_date
 * @property string $costing
 * @property string $delivery_charge
 * @property string $order_note
 * @property integer $is_invoice_done
 * @property integer $is_job_card_done
 * @property integer $is_delivery_done
 * @property integer $is_partial_delivery
 * @property integer $is_partial_invoice
 * @property integer $is_all_issue_done
 * @property integer $is_all_production_done
 * @property integer $is_paid
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $business_id
 * @property integer $branch_id
 * @property integer $is_opening
 * @property integer $is_deleted
 */
class SellOrderQuotationDetails extends CActiveRecord
{
	public $unit_id;
    public $model_name;
    public $code;
    public $image;
    public $description;
    public $total_costing;
    public $item_id;
    public $brand_id;
    public $purchase_price;
    public $stock;
    public $sell_price;
    public $customer_name;
    public $actual_sp;
    public $so_no;
    public $customer_id;
    public $company_name;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sell_order_quotation_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('sell_order_id, model_id', 'required'),
            array('sell_order_id, model_id,  created_by, updated_by, warranty', 'numerical', 'integerOnly' => true),
            array('discount_amount, discount_percentage, pp', 'numerical'),
            array('qty, amount, row_total, costing', 'numerical'),
            array('created_at, updated_at, color, note, product_sl_no', 'safe'),
            // The following rule is used by search().
            array('id, sell_order_id, model_id, qty, note, product_sl_no, pp, amount, discount_amount, discount_percentage, row_total, warranty, color, created_by, created_at, updated_by, updated_at, costing', 'safe', 'on' => 'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'sell_order_id' => 'Sell Order',
            'model_id' => 'Product',
            'qty' => 'Qty',
            'color' => 'Color',
            'note' => 'Product Note',
            'amount' => 'Unit Price',
            'row_total' => 'Row Total',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'costing' => 'Costing',
            'warranty' => 'Warranty (Mon.)',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('order_type',$this->order_type);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('grand_total',$this->grand_total);
		$criteria->compare('total_paid',$this->total_paid,true);
		$criteria->compare('total_return',$this->total_return,true);
		$criteria->compare('total_due',$this->total_due,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('max_sl_no',$this->max_sl_no);
		$criteria->compare('so_no',$this->so_no,true);
		$criteria->compare('cash_due',$this->cash_due);
		$criteria->compare('vat_percentage',$this->vat_percentage);
		$criteria->compare('vat_amount',$this->vat_amount);
		$criteria->compare('bom_complete',$this->bom_complete);
		$criteria->compare('exp_delivery_date',$this->exp_delivery_date,true);
		$criteria->compare('discount_percentage',$this->discount_percentage);
		$criteria->compare('discount_amount',$this->discount_amount);
		$criteria->compare('job_max_sl_no',$this->job_max_sl_no);
		$criteria->compare('job_no',$this->job_no,true);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('job_card_date',$this->job_card_date,true);
		$criteria->compare('costing',$this->costing,true);
		$criteria->compare('delivery_charge',$this->delivery_charge,true);
		$criteria->compare('order_note',$this->order_note,true);
		$criteria->compare('is_invoice_done',$this->is_invoice_done);
		$criteria->compare('is_job_card_done',$this->is_job_card_done);
		$criteria->compare('is_delivery_done',$this->is_delivery_done);
		$criteria->compare('is_partial_delivery',$this->is_partial_delivery);
		$criteria->compare('is_partial_invoice',$this->is_partial_invoice);
		$criteria->compare('is_all_issue_done',$this->is_all_issue_done);
		$criteria->compare('is_all_production_done',$this->is_all_production_done);
		$criteria->compare('is_paid',$this->is_paid);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('is_opening',$this->is_opening);
		$criteria->compare('is_deleted',$this->is_deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellOrderQuotationDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
        }else {
            $this->updated_by = Yii::app()->user->getState('user_id');
            $this->updated_at = $dateTime;
        }
        return parent::beforeSave();
    }

	public function getTotalCosting($order_id)
    {
        if (empty($order_id)) return 0;

        $criteria = new CDbCriteria();
        $criteria->select = "SUM(costing) as total_costing";
        $criteria->condition = "sell_order_id = $order_id";
        $result = $this->find($criteria);

        return $result->total_costing;
    }
}
