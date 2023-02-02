<?php

/**
 * This is the model class for table "receive_purchase".
 *
 * The followings are the available columns in table 'receive_purchase':
 * @property integer $id
 * @property string $date
 * @property integer $max_sl_no
 * @property string $receive_no
 * @property string $supplier_memo_no
 * @property string $supplier_memo_date
 * @property integer $supplier_id
 * @property integer $purchase_order_id
 * @property double $rcv_amount
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $remarks
 */
class ReceivePurchase extends CActiveRecord
{

    public $store_id;
    public $location_id;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'receive_purchase';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, max_sl_no, receive_no, supplier_id, purchase_order_id, rcv_amount', 'required'),
            array('max_sl_no, supplier_id, purchase_order_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('rcv_amount', 'numerical'),
            array('receive_no, supplier_memo_no', 'length', 'max' => 255),
            array('supplier_memo_date, created_at, updated_at, remarks', 'safe'),
            // The following rule is used by search().

            array('id, date, max_sl_no, receive_no, supplier_memo_no, supplier_memo_date, supplier_id, purchase_order_id, rcv_amount, created_by, 
            remarks, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'date' => 'Rcv. Date',
            'max_sl_no' => 'Max Sl No',
            'receive_no' => 'Receive No',
            'supplier_memo_no' => 'Supplier Memo No',
            'supplier_memo_date' => 'Supplier Memo Date',
            'supplier_id' => 'Supplier',
            'purchase_order_id' => 'PO No',
            'rcv_amount' => 'Rcv Amount',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'remarks' => 'Remarks',
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


        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = " ";

        if (trim($this->supplier_id) != "") {
            $criteria->join .= " INNER JOIN suppliers s on t.supplier_id = s.id ";
            $criteria->compare('s.company_name', trim($this->supplier_id), true);
        }
        if (trim($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', trim($this->created_by), true);
        }
        if (trim($this->purchase_order_id) != "") {
            $criteria->join .= " INNER JOIN purchase_order po on t.purchase_order_id = po.id ";
            $criteria->compare('po.po_no', trim($this->purchase_order_id), true);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('receive_no', $this->receive_no, true);
        $criteria->compare('supplier_memo_no', $this->supplier_memo_no, true);
        $criteria->compare('supplier_memo_date', $this->supplier_memo_date, true);
        $criteria->compare('rcv_amount', $this->rcv_amount);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('remarks', $this->remarks, true);

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
     * @return ReceivePurchase the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(max_sl_no) as max_sl_no";
        $criteria->addColumnCondition(['year(date)' => date('Y'), 'month(date)' => date('m')]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->max_sl_no + 1 : 1;
    }


    public function beforeSave()
    {
        if (trim($this->supplier_memo_date) == "") {
            $this->supplier_memo_date = NULL;
        }
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_at = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

}
