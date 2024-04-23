<?php

/**
 * This is the model class for table "branches".
 *
 * The followings are the available columns in table 'branches':
 * @property integer $id
 * @property integer $business_id
 * @property string $slug
 * @property string $display_name
 * @property integer $address
 * @property integer $phone_number
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Branch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'branches';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_id, display_name, address, phone_number, status, created_at, created_by, updated_at, updated_by', 'required'),
			array('business_id, address, phone_number, status, created_at, created_by, updated_at, updated_by', 'numerical', 'integerOnly'=>true),
			array('slug', 'length', 'max'=>255),
			array('display_name', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, business_id, slug, display_name, address, phone_number, status, created_at, created_by, updated_at, updated_by', 'safe', 'on'=>'search'),
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
			'business_id' => 'Business',
			'slug' => 'Slug',
			'display_name' => 'Display Name',
			'address' => 'Address',
			'phone_number' => 'Phone Number',
			'status' => 'Status',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
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
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('address',$this->address);
		$criteria->compare('phone_number',$this->phone_number);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('updated_by',$this->updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Branch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
