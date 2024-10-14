<?php

/**
 * This is the model class for table "sell_return_details".
 *
 * The followings are the available columns in table 'sell_return_details':
 * @property integer $id
 * @property integer $return_id
 * @property integer $model_id
 * @property string $return_qty
 * @property string $sell_price
 * @property string $purchase_price
 * @property string $product_sl_no
 * @property string $row_total
 * @property string $costing
 * @property string $note
 * @property string $discount_amount
 * @property string $discount_percentage
 * @property integer $replace_model_id
 * @property string $replace_product_sl_no
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $is_deleted
 */
class SellReturnDetails extends CActiveRecord
{
    public $qty;
    public $amount;
    public $pp;
    public $warranty;
    public $color;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sell_return_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('return_id, model_id, return_qty', 'required'),
			array('return_id, model_id, replace_model_id, created_by, updated_by, is_deleted', 'numerical', 'integerOnly'=>true),
			array('return_qty, sell_price, purchase_price, row_total, costing, discount_amount, discount_percentage', 'length', 'max'=>10),
			array('product_sl_no, replace_product_sl_no', 'length', 'max'=>300),
			array('note', 'length', 'max'=>350),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, return_id, model_id, return_qty, sell_price, purchase_price, product_sl_no, row_total, costing, note, discount_amount, discount_percentage, replace_model_id, replace_product_sl_no, created_by, created_at, updated_by, updated_at, is_deleted', 'safe', 'on'=>'search'),
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
			'return_id' => 'Return',
			'model_id' => 'Product',
			'return_qty' => 'Return Qty',
			'sell_price' => 'Sell Price',
			'purchase_price' => 'Purchase Price',
			'product_sl_no' => 'Product Sl No',
			'row_total' => 'Row Total',
			'costing' => 'Costing',
			'note' => 'Note',
			'discount_amount' => 'Discount Amount',
			'discount_percentage' => 'Discount Percentage',
			'replace_model_id' => 'Replace Product',
			'replace_product_sl_no' => 'Replace Product Sl No',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_by' => 'Updated By',
			'updated_at' => 'Updated At',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.return_id',$this->return_id);
		$criteria->compare('t.model_id',$this->model_id);
		$criteria->compare('t.return_qty',$this->return_qty,true);
		$criteria->compare('t.sell_price',$this->sell_price,true);
		$criteria->compare('t.purchase_price',$this->purchase_price,true);
		$criteria->compare('t.product_sl_no',$this->product_sl_no,true);
		$criteria->compare('t.row_total',$this->row_total,true);
		$criteria->compare('t.costing',$this->costing,true);
		$criteria->compare('t.note',$this->note,true);
		$criteria->compare('t.discount_amount',$this->discount_amount,true);
		$criteria->compare('t.discount_percentage',$this->discount_percentage,true);
		$criteria->compare('t.replace_model_id',$this->replace_model_id);
		$criteria->compare('t.replace_product_sl_no',$this->replace_product_sl_no,true);
		$criteria->compare('t.created_by',$this->created_by);
		$criteria->compare('t.created_at',$this->created_at,true);
		$criteria->compare('t.updated_by',$this->updated_by);
		$criteria->compare('t.updated_at',$this->updated_at,true);
		$criteria->compare('t.is_deleted',$this->is_deleted);

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
	 * @return SellReturnDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
