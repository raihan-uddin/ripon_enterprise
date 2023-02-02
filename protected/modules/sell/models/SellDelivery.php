<?php

/**
 * This is the model class for table "sell_delivery".
 *
 * The followings are the available columns in table 'sell_delivery':
 * @property integer $id
 * @property integer $sell_order_id
 * @property string $date
 * @property integer $max_sl_no
 * @property string $delivery_no
 * @property integer $customer_id
 * @property double $grand_total
 * @property string $remarks
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class SellDelivery extends CActiveRecord
{
    public $so_no;
    public $store_id;
    public $location_id;

    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(max_sl_no) as max_sl_no";
        $criteria->addColumnCondition(['year(date)' => date('Y'), 'month(date)' => date('m')]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->max_sl_no + 1 : 1;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SellDelivery the static model class
     */
    public
    static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sell_delivery';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sell_order_id, date, max_sl_no, delivery_no, customer_id, grand_total', 'required'),
            array('sell_order_id, max_sl_no, customer_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('grand_total', 'numerical'),
            array('delivery_no', 'length', 'max' => 255),
            array('remarks, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, sell_order_id, date, max_sl_no, delivery_no, customer_id, grand_total, remarks, created_by,
             created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'sell_order_id' => 'SO No',
            'date' => 'Delivery Date',
            'max_sl_no' => 'Max Sl No',
            'delivery_no' => 'Delivery No',
            'customer_id' => 'Customer',
            'grand_total' => 'Grand Total',
            'remarks' => 'Delivery Note',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'store_id' => 'Store',
            'location_id' => 'Location',
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

        if (trim($this->sell_order_id) != "") {
            $criteria->join .= " INNER JOIN customers c on t.customer_id = c.id ";
            $criteria->compare('c.company_name', trim($this->customer_id), true);
        }
        if (trim($this->customer_id) != "") {
            $criteria->join .= " INNER JOIN sell_order so on t.sell_order_id = so.id ";
            $criteria->compare('so.so_no', trim($this->sell_order_id), true);
        }
        if (trim($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', trim($this->created_by), true);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('delivery_no', $this->delivery_no, true);
        $criteria->compare('grand_total', $this->grand_total);
        $criteria->compare('remarks', $this->remarks, true);
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
}
