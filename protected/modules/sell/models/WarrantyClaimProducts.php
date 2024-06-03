<?php

/**
 * This is the model class for table "warranty_claim_products".
 *
 * The followings are the available columns in table 'warranty_claim_products':
 * @property integer $id
 * @property integer $warranty_claim_id
 * @property string $claim_description
 * @property integer $claim_status
 * @property string $resolution_date
 * @property string $resolution_description
 * @property integer $model_id
 * @property string $product_sl_no
 * @property string $qty
 * @property string $pp
 * @property string $sp
 * @property integer $replace_model_id
 * @property string $replace_product_sl_no
 * @property string $replace_qty
 * @property string $replace_pp
 * @property string $replace_sp
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $is_deleted
 */
class WarrantyClaimProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'warranty_claim_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warranty_claim_id, model_id', 'required'),
			array('warranty_claim_id, claim_status, model_id, replace_model_id, created_by, updated_by, is_deleted', 'numerical', 'integerOnly'=>true),
			array('product_sl_no, replace_product_sl_no', 'length', 'max'=>300),
			array('qty, replace_qty', 'length', 'max'=>10),
			array('pp, sp, replace_pp, replace_sp', 'length', 'max'=>20),
			array('claim_description, resolution_date, resolution_description, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, warranty_claim_id, claim_description, claim_status, resolution_date, resolution_description, model_id, product_sl_no, qty, pp, sp, replace_model_id, replace_product_sl_no, replace_qty, replace_pp, replace_sp, created_by, created_at, updated_by, updated_at, is_deleted', 'safe', 'on'=>'search'),
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
			'warranty_claim_id' => 'Warranty Claim',
			'claim_description' => 'Claim Description',
			'claim_status' => 'Claim Status',
			'resolution_date' => 'Resolution Date',
			'resolution_description' => 'Resolution Description',
			'model_id' => 'Model',
			'product_sl_no' => 'Product Sl No',
			'qty' => 'Qty',
			'pp' => 'Pp',
			'sp' => 'Sp',
			'replace_model_id' => 'Replace Model',
			'replace_product_sl_no' => 'Replace Product Sl No',
			'replace_qty' => 'Replace Qty',
			'replace_pp' => 'Replace Pp',
			'replace_sp' => 'Replace Sp',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('warranty_claim_id',$this->warranty_claim_id);
		$criteria->compare('claim_description',$this->claim_description,true);
		$criteria->compare('claim_status',$this->claim_status);
		$criteria->compare('resolution_date',$this->resolution_date,true);
		$criteria->compare('resolution_description',$this->resolution_description,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('product_sl_no',$this->product_sl_no,true);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('pp',$this->pp,true);
		$criteria->compare('sp',$this->sp,true);
		$criteria->compare('replace_model_id',$this->replace_model_id);
		$criteria->compare('replace_product_sl_no',$this->replace_product_sl_no,true);
		$criteria->compare('replace_qty',$this->replace_qty,true);
		$criteria->compare('replace_pp',$this->replace_pp,true);
		$criteria->compare('replace_sp',$this->replace_sp,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('is_deleted',$this->is_deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WarrantyClaimProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
