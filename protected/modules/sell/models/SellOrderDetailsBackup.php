<?php

/**
 * This is the model class for table "sell_order_details_backup".
 *
 * The followings are the available columns in table 'sell_order_details_backup':
 * @property integer $id
 * @property integer $sell_order_id
 * @property integer $model_id
 * @property string $product_sl_no
 * @property double $qty
 * @property integer $warranty
 * @property double $amount
 * @property double $row_total
 * @property string $pp
 * @property string $costing
 * @property string $color
 * @property string $note
 * @property string $discount_amount
 * @property string $discount_percentage
 * @property integer $is_delivery_done
 * @property integer $is_invoice_done
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $is_deleted
 * @property integer $business_id
 * @property integer $branch_id
 */
class SellOrderDetailsBackup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sell_order_details_backup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('sell_order_id, model_id, qty, amount, row_total', 'required'),
            array('sell_order_id, model_id, is_delivery_done, is_invoice_done, created_by, updated_by, warranty', 'numerical', 'integerOnly' => true),
            array('discount_amount, discount_percentage, pp', 'numerical'),
            array('qty, amount, row_total, costing', 'numerical'),
            array('created_at, updated_at, color, note, product_sl_no', 'safe'),
            // The following rule is used by search().
            array('id, sell_order_id, model_id, qty, note, product_sl_no, pp, amount, discount_amount, discount_percentage, row_total, is_delivery_done, warranty, color, is_invoice_done, created_by, created_at, updated_by, updated_at, costing', 'safe', 'on' => 'search'),
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
			'model_id' => 'Model',
			'product_sl_no' => 'Product Sl No',
			'qty' => 'Qty',
			'warranty' => 'Warranty',
			'amount' => 'Amount',
			'row_total' => 'Row Total',
			'pp' => 'Pp',
			'costing' => 'Costing',
			'color' => 'Color',
			'note' => 'Note',
			'discount_amount' => 'Discount Amount',
			'discount_percentage' => 'Discount Percentage',
			'is_delivery_done' => 'Is Delivery Done',
			'is_invoice_done' => 'Is Invoice Done',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_by' => 'Updated By',
			'updated_at' => 'Updated At',
			'is_deleted' => 'Is Deleted',
			'business_id' => 'Business',
			'branch_id' => 'Branch',
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
		$criteria->compare('sell_order_id',$this->sell_order_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('product_sl_no',$this->product_sl_no,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('warranty',$this->warranty);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('row_total',$this->row_total);
		$criteria->compare('pp',$this->pp,true);
		$criteria->compare('costing',$this->costing,true);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('discount_amount',$this->discount_amount,true);
		$criteria->compare('discount_percentage',$this->discount_percentage,true);
		$criteria->compare('is_delivery_done',$this->is_delivery_done);
		$criteria->compare('is_invoice_done',$this->is_invoice_done);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('branch_id',$this->branch_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellOrderDetailsBackup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
