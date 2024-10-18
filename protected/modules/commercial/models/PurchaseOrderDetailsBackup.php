<?php

/**
 * This is the model class for table "purchase_order_details_backup".
 *
 * The followings are the available columns in table 'purchase_order_details_backup':
 * @property integer $id
 * @property integer $order_id
 * @property integer $model_id
 * @property string $product_sl_no
 * @property double $qty
 * @property double $unit_price
 * @property string $note
 * @property double $row_total
 * @property integer $warranty
 * @property integer $is_all_received
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $business_id
 * @property integer $branch_id
 * @property integer $is_deleted
 */
class PurchaseOrderDetailsBackup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchase_order_details_backup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('model_id, qty, unit_price, row_total, order_id', 'required'),
            array('model_id, is_all_received, created_by, updated_by, order_id', 'numerical', 'integerOnly' => true),
            array('qty, unit_price, row_total', 'numerical'),
            array('created_at, updated_at, note, product_sl_no, warranty', 'safe'),
            // The following rule is used by search().

            array('id, model_id, note, qty, unit_price, row_total, order_id, product_sl_no, warranty, is_all_received, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
			'order_id' => 'Order',
			'model_id' => 'Model',
			'product_sl_no' => 'Product Sl No',
			'qty' => 'Qty',
			'unit_price' => 'Unit Price',
			'note' => 'Note',
			'row_total' => 'Row Total',
			'warranty' => 'Warranty',
			'is_all_received' => 'Is All Received',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_by' => 'Updated By',
			'updated_at' => 'Updated At',
			'business_id' => 'Business',
			'branch_id' => 'Branch',
			'is_deleted' => 'Is Deleted',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('product_sl_no',$this->product_sl_no,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('row_total',$this->row_total);
		$criteria->compare('warranty',$this->warranty);
		$criteria->compare('is_all_received',$this->is_all_received);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('is_deleted',$this->is_deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PurchaseOrderDetailsBackup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
