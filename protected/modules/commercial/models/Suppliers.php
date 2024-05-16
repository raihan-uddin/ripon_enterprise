<?php
/**
 * This is the model class for table "suppliers".
 *
 * The followings are the available columns in table 'suppliers':
 * @property integer $id
 * @property string $company_name
 * @property string $company_address
 * @property string $company_contact_no
 * @property string $contact_number_2
 * @property string $company_fax
 * @property string $company_email
 * @property string $company_web
 * @property double $opening_amount
 * @property string $created_datetime
 * @property integer $created_by
 * @property string $updated_datetime
 * @property integer $updated_by
 */
class Suppliers extends CActiveRecord
{

    public $totalPaymentReceipt;
    public $totalPurchaseOrder;
    public $startDate;
    public $endDate;
    public $month;
    public $year;
    public $bank_id;
    public $date;
    public $supplier_id;
    public $date_diff;
    public $column_no;
    public $column_vals;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'suppliers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('opening_amount', 'numerical'),
            array('company_name, company_contact_no', 'length', 'max' => 255),
            array('contact_number_2, company_fax', 'length', 'max' => 20),
            array('company_email, company_web', 'length', 'max' => 50),
            array('company_address, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, company_name, company_address, company_contact_no, contact_number_2, company_fax, company_email, company_web, opening_amount, created_datetime, created_by, updated_datetime, updated_by', 'safe', 'on' => 'search'),
        );
    }


    public function beforeSave()
    {
        $dateTime = date('Y-m-d H:i:s');

        $businessId = Yii::app()->user->getState('business_id');
        $branchId = Yii::app()->user->getState('branch_id');

        $this->business_id = $businessId;
        $this->branch_id = $branchId;


        if ($this->isNewRecord) {
            $this->created_datetime = $dateTime;
            $this->created_by = Yii::app()->user->getState('user_id');
        } else {
            $this->updated_datetime = $dateTime;
            $this->updated_by = Yii::app()->user->getState('user_id');
        }
        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'payReceiptCustomer' => array(self::HAS_MANY, 'PaymentReceipt', 'supplier_id'),
            'contactPersonSupplier' => array(self::HAS_MANY, 'SupplierContactPersons', 'company_id'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Suppliers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function supplierName($id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = "company_name";
        $data = self::model()->findByPk($id, $criteria);
        if ($data)
            return $data->company_name;
    }

    public function nameOfThis($id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = "company_name";
        $data = self::model()->findByPk($id, $criteria);
        if ($data)
            return $data->company_name;
    }

    public function supplierAllInfo($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'company_contact_no' => 'Company Contact No',
            'contact_number_2' => 'Contact Number 2',
            'company_fax' => 'Company Fax',
            'company_email' => 'Company Email',
            'company_web' => 'Company Web',
            'opening_amount' => 'Opening Amount',
            'created_datetime' => 'Created Datetime',
            'created_by' => 'Created By',
            'updated_datetime' => 'Updated Datetime',
            'updated_by' => 'Updated By',
        );
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

        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_address', $this->company_address, true);
        $criteria->compare('company_contact_no', $this->company_contact_no, true);
        $criteria->compare('contact_number_2', $this->contact_number_2, true);
        $criteria->compare('company_fax', $this->company_fax, true);
        $criteria->compare('company_email', $this->company_email, true);
        $criteria->compare('company_web', $this->company_web, true);
        $criteria->compare('opening_amount', $this->opening_amount);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('updated_by', $this->updated_by);


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
