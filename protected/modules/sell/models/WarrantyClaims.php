<?php

/**
 * This is the model class for table "warranty_claims".
 *
 * The followings are the available columns in table 'warranty_claims':
 * @property integer $id
 * @property integer $claim_type
 * @property string $claim_date
 * @property integer $customer_id
 * @property string $claim_description
 * @property integer $claim_status
 * @property string $resolution_date
 * @property string $resolution_description
 * @property string $total_sp
 * @property string $total_pp
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updatetd_at
 * @property integer $is_deleted
 * @property integer $business_id
 * @property integer $branch_id
 */
class WarrantyClaims extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'warranty_claims';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('claim_date, customer_id', 'required'),
			array('claim_type, customer_id, claim_status, created_by, updated_by, is_deleted, business_id, branch_id', 'numerical', 'integerOnly'=>true),
			array('total_sp, total_pp', 'length', 'max'=>20),
			array('claim_description, resolution_date, resolution_description, created_at, updatetd_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, claim_type, claim_date, customer_id, claim_description, claim_status, resolution_date, resolution_description, total_sp, total_pp, created_by, created_at, updated_by, updatetd_at, is_deleted, business_id, branch_id', 'safe', 'on'=>'search'),
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
			'claim_type' => 'Claim Type',
			'claim_date' => 'Claim Date',
			'customer_id' => 'Customer',
			'claim_description' => 'Claim Description',
			'claim_status' => 'Claim Status',
			'resolution_date' => 'Resolution Date',
			'resolution_description' => 'Resolution Description',
			'total_sp' => 'Total Sp',
			'total_pp' => 'Total Pp',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_by' => 'Updated By',
			'updatetd_at' => 'Updatetd At',
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
		$criteria->compare('claim_type',$this->claim_type);
		$criteria->compare('claim_date',$this->claim_date,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('claim_description',$this->claim_description,true);
		$criteria->compare('claim_status',$this->claim_status);
		$criteria->compare('resolution_date',$this->resolution_date,true);
		$criteria->compare('resolution_description',$this->resolution_description,true);
		$criteria->compare('total_sp',$this->total_sp,true);
		$criteria->compare('total_pp',$this->total_pp,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updatetd_at',$this->updatetd_at,true);
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
	 * @return WarrantyClaims the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
