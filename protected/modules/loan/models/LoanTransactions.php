<?php

/**
 * This is the model class for table "loan_transactions".
 *
 * The followings are the available columns in table 'loan_transactions':
 * @property integer $id
 * @property integer $person_id
 * @property string $transaction_type
 * @property string $amount
 * @property string $transaction_date
 * @property string $note
 * @property string $created_at
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property LoanPersons $person
 */
class LoanTransactions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'loan_transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, transaction_type, amount, transaction_date', 'required'),
			array('person_id, created_by', 'numerical', 'integerOnly'=>true),
			array('transaction_type', 'length', 'max'=>6),
			array('amount', 'length', 'max'=>12),
			array('note, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, transaction_type, amount, transaction_date, note, created_at, created_by', 'safe', 'on'=>'search'),
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
			'person' => array(self::BELONGS_TO, 'LoanPersons', 'person_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'person_id' => 'Person',
			'transaction_type' => 'Transaction Type',
			'amount' => 'Amount',
			'transaction_date' => 'Transaction Date',
			'note' => 'Note',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
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
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('transaction_type',$this->transaction_type,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('transaction_date',$this->transaction_date,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoanTransactions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
