<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property integer $id
 * @property string $company_name
 * @property string $company_address
 * @property string $company_contact_no
 * @property string $company_fax
 * @property string $company_email
 * @property string $company_web
 * @property double $opening_amount
 * @property string $owner_mobile_no
 * @property string $owner_person
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property integer $status
 * @property integer $created_by
 * @property string $created_datetime
 * @property integer $updated_by
 * @property integer $max_sl_no
 * @property string $updated_datetime
 * @property string $trn_no
 * @property string $customer_code
 */
class Customers extends CActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 0;

    public $balance;
    public $month;
    public $year;
    public $startDate;
    public $endDate;
    public $company_name_address;
    public $date;
    public $customer_id;
    public $model_id;
    public $code;
    public $unit_id;
    public $image;
    public $note;
    public $color;
    public $qty;
    public $amount;
    public $row_total;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'customers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_name', 'required'),
            array('opening_amount, max_sl_no, status', 'numerical'),
            array('company_name', 'length', 'max' => 255),
            array('company_contact_no, company_fax', 'length', 'max' => 255),
            array('company_email, company_web', 'length', 'max' => 50),
            array('company_address, owner_person, owner_mobile_no, city, state, zip, trn_no, customer_code', 'safe'),
            array('company_email', 'email'),
//            array('company_web', 'url', 'defaultScheme' => 'http'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,  company_name, company_address, trn_no, owner_mobile_no, max_sl_no, customer_code, city, state, zip, owner_person, company_contact_no, company_fax, company_email, company_web', 'safe', 'on' => 'search'),
        );
    }



    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(max_sl_no) as max_sl_no";
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->max_sl_no + 1 : 1;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'monyeReceiptCustomer' => array(self::HAS_MANY, 'MoneyReceipt', 'customer_id'),
            'contactPersonCustomer' => array(self::HAS_MANY, 'CustomerContactPersons', 'company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Customer Id',
            'max_sl_no' => 'Max SL No',
            'customer_code' => 'Customer Code',
            'owner_person' => 'Owner Name.',
            'owner_mobile_no' => 'Mobile No.',
            'company_name' => 'Customer Name',
            'company_address' => 'Address',
            'company_fax' => 'FAX No',
            'company_email' => 'E-Mail',
            'company_web' => 'Web',
            'activeCreditLimit' => 'Active Credit Limit',
            'totalMoneyReceipt' => 'Total Received Amount(Cr)',
            'totalSalesOrder' => 'Total Sales Amount(Dr)',
            'balance' => 'Party Balance',
            'opening_amount' => 'Opening Amount',
            'company_contact_no' => 'Telephone No',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'trn_no' => 'TRN',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_datetime' => 'Created Datetime',
            'updated_by' => 'Updated By',
            'updated_datetime' => 'Updated Datetime',
        );
    }

    public function beforeSave()
    {
        $dateTime = date('Y-m-d H:i:s');

        $this->company_name = strtoupper($this->company_name);
        if ($this->status != self::ACTIVE) {
            $this->status = self::INACTIVE;
        } else {
            $this->status = self::ACTIVE;
        }
        if ($this->isNewRecord) {
            $this->created_datetime = $dateTime;
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_datetime = $dateTime;
            $this->updated_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }


    /**
     * Returns the static model of the specified AR class.
     * @return Customers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function customerName($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_name;
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_name;
    }


    public function customerAddress($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->company_address;
    }

    public function customerAllInfo($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('max_sl_no', $this->max_sl_no, true);
        $criteria->compare('owner_person', $this->owner_person, true);
        $criteria->compare('owner_mobile_no', $this->owner_mobile_no, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_address', $this->company_address, true);
        $criteria->compare('company_contact_no', $this->company_contact_no, true);
        $criteria->compare('company_fax', $this->company_fax, true);
        $criteria->compare('company_email', $this->company_email, true);
        $criteria->compare('company_web', $this->company_web, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('trn_no', $this->trn_no, true);


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

}
