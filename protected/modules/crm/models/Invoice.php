<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property integer $id
 * @property string $date
 * @property integer $order_id
 * @property integer $customer_id
 * @property integer $max_sl_no
 * @property string $invoice_no
 * @property double $vat_percentage
 * @property double $vat_amount
 * @property double $discount_percentage
 * @property double $discount_amount
 * @property double $total_amount
 * @property double $grand_total
 * @property string $remarks
 * @property integer $is_paid
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Invoice extends CActiveRecord
{
    public $so_no;
    public $customer_name;
    public $print_type;
    public $model_id;
    public $qty;

    const PAID = 1;
    const DUE = 0;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Invoice the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'invoice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, order_id, customer_id, max_sl_no, invoice_no, total_amount, grand_total', 'required'),
            array('order_id, customer_id, max_sl_no, is_paid, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('vat_percentage, vat_amount, discount_percentage, discount_amount, total_amount, grand_total', 'numerical'),
            array('invoice_no', 'length', 'max' => 255),
            array('remarks, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, date, order_id, customer_id, max_sl_no, invoice_no, vat_percentage, vat_amount, discount_percentage, discount_amount, total_amount, grand_total, remarks, is_paid, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'date' => 'Date',
            'order_id' => 'SO No',
            'customer_name' => 'Customer',
            'customer_id' => 'Customer',
            'max_sl_no' => 'Max Sl No',
            'invoice_no' => 'Invoice No',
            'vat_percentage' => 'Vat Percentage',
            'vat_amount' => 'Vat Amount',
            'discount_percentage' => 'Discount Percentage',
            'discount_amount' => 'Discount Amount',
            'total_amount' => 'Total Amount',
            'grand_total' => 'Grand Total',
            'remarks' => 'Remarks',
            'is_paid' => 'Is Paid',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        );
    }


    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_by = Yii::app()->user->id;
            $this->updated_at = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
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

        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = " ";

        if (trim($this->order_id) != "") {
            $criteria->join .= " INNER JOIN sell_order so on t.order_id = so.id ";
            $criteria->compare('so.so_no', trim($this->order_id), true);
        }
        if (trim($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->compare('c.company_name', trim($this->customer_id), true);
        }
        if (trim($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', trim($this->created_by), true);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('vat_percentage', $this->vat_percentage);
        $criteria->compare('vat_amount', $this->vat_amount);
        $criteria->compare('discount_percentage', $this->discount_percentage);
        $criteria->compare('discount_amount', $this->discount_amount);
        $criteria->compare('total_amount', $this->total_amount);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('is_paid', $this->is_paid);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);


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


    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(max_sl_no) as max_sl_no";
        $criteria->addColumnCondition(['year(date)' => date('Y'), 'month(date)' => date('m')]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->max_sl_no + 1 : 1;
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        return $data ? $data->invoice_no : "N/A";
    }
}
