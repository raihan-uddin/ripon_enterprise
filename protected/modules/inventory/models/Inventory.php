<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property integer $id
 * @property integer $sl_no
 * @property string $date
 * @property string $challan_no
 * @property integer $model_id
 * @property double $stock_in
 * @property double $stock_out
 * @property double $sell_price
 * @property double $purchase_price
 * @property double $row_total
 * @property integer $stock_status
 * @property integer $source_id
 * @property string $product_sl_no
 * @property string $remarks
 * @property string $create_time
 * @property integer $create_by
 * @property integer $master_id
 * @property string $update_time
 * @property integer $update_by
 */
class Inventory extends CActiveRecord
{

    const STOCK_IN = 1;
    const STOCK_OUT = 2;

    const SOURCE_DEFAULT = 0;
    const MANUAL_ENTRY = 0;
    const PURCHASE_RECEIVE = 1;
    const SALES_DELIVERY = 3;
    const CASH_SALE_RETURN = 4;
    const WARRANTY_RETURN = 5;
    const PRODUCT_REPLACEMENT = 6;

    const SHOW_ALL_PRODUCT_SL_NO = 2;

    public $model_name;
    public $code;
    public $name;
    public $created_by;
    public $opening_stock;
    public $customer_id;
    public $supplier_id;
    public $pp;
    public $sp;
    public $t_type;
    public $unit_id;
    public $item_id;
    public $brand_id;
    public $supplier_name;
    public $customer_name;
    public $image;
    public $stock;
    public $closing_stock;
    public $expense_head_id;
    public $sales_warranty;
    public $supplier_contact_no;
    public $customer_contact_no;
    public $product_name;
    public $product_code;
    public $manufacturer_id;
    public $avg_purchase_price;
    public $order_type;
    public $group_by;
    public $sort_by_column;
    public $sort_by;
    public $sort_order;

    public static function maxSlNo()
    {
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(sl_no) as sl_no";
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->sl_no + 1 : 1;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Inventory the static model class
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
        return 'inventory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, model_id, stock_status', 'required'),
            array('sl_no, model_id, stock_status, source_id, create_by, update_by, warranty', 'numerical', 'integerOnly' => true),
            array('stock_in, stock_out, sell_price, purchase_price, row_total, master_id, source_id', 'numerical'),
            array('challan_no, remarks, product_sl_no', 'length', 'max' => 255),
            array('date, create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, sl_no, date, challan_no, row_total, master_id, source_id, product_sl_no, model_id, stock_in, warranty, stock_out, sell_price, purchase_price, stock_status, source_id, product_sl_no, remarks, create_time, create_by, update_time, update_by', 'safe', 'on' => 'search'),
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
            'sl_no' => 'Sl No',
            'closing_stock' => 'Stock',
            'row_total' => 'Total',
            't_type' => 'Trx. Type',
            'date' => 'Date',
            'challan_no' => 'Challan No',
            'model_id' => 'Product',
            'stock_in' => 'Stock In',
            'stock_out' => 'Stock Out',
            'sell_price' => 'Sell Price',
            'purchase_price' => 'Purchase Price',
            'stock_status' => 'Stock Status',
            'source_id' => 'Source ID',
            'master_id' => 'Master ID',
            'remarks' => 'Remarks',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
            'update_time' => 'Update Time',
            'update_by' => 'Update By',
            'warranty' => 'Warranty',
            'customer_id' => 'Customer',
            'supplier_id' => 'Supplier',
            'manufacturer_id' => 'Company',
            'item_id' => 'Category',
            'brand_id' => 'Sub-Category',
            'expense_head_id' => 'Expense Head',
        );
    }

    public function closingStock($model_id, $product_sl_no = null)
    {
        $criteria = new CDbCriteria();
        $criteria->select = "SUM(stock_in) AS stock_in, sum(stock_out) AS stock_out";
        $criteria->addColumnCondition(['model_id' => $model_id, 'is_deleted' => 0]);

        if ($product_sl_no && strlen($product_sl_no) > 0) {
            $criteria->addColumnCondition(['t.product_sl_no' => $product_sl_no]);
        }
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? ($data->stock_in - $data->stock_out) : 0;
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
        $criteria->addColumnCondition(['t.is_deleted' => 0]);

        if (($this->model_id) != "") {
            $criteria->join .= " INNER JOIN prod_models pm on t.model_id = pm.id ";
            $criteria->compare('pm.model_name', ($this->model_id), true);
        }

        if (($this->create_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', ($this->create_by), true);
        }

        if (!Yii::app()->user->checkAccess('Admin')) {
            $criteria->addColumnCondition(['t.created_by' => Yii::app()->user->getState('user_id')]);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('sl_no', $this->sl_no);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('challan_no', $this->challan_no, true);
        $criteria->compare('stock_in', $this->stock_in);
        $criteria->compare('stock_out', $this->stock_out);
        $criteria->compare('sell_price', $this->sell_price);
        $criteria->compare('purchase_price', $this->purchase_price);
        $criteria->compare('stock_status', $this->stock_status);
        $criteria->compare('source_id', $this->source_id);
        $criteria->compare('master_id', $this->master_id);
        $criteria->compare('product_sl_no', $this->product_sl_no);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('create_by', $this->create_by);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('update_by', $this->update_by);
        $criteria->compare('row_total', $this->row_total);

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

    public function beforeSave()
    {
        $dateTime = date('Y-m-d H:i:s');

        // set default time zone to asia/dhaka
        date_default_timezone_set('Asia/Dhaka');
        if ($this->isNewRecord) {
            $this->create_time = $dateTime;
            $this->create_by = Yii::app()->user->getState('user_id');
        } else {
            $this->update_time = $dateTime;
            $this->update_by = Yii::app()->user->getState('user_id');
        }
        return parent::beforeSave();
    }

    public function getStockStatusFilter()
    {
        return array(
            array('id' => self::MANUAL_ENTRY, 'title' => 'MANUAL ENTRY'),
            array('id' => self::PURCHASE_RECEIVE, 'title' => 'PURCHASE'),
            array('id' => self::SALES_DELIVERY, 'title' => 'SALES'),
            array('id' => self::CASH_SALE_RETURN, 'title' => 'CASH SALE RETURN'),
            array('id' => self::WARRANTY_RETURN, 'title' => 'WARRANTY RETURN'),
//            array('id' => self::JOB_CARD_ISSUE, 'title' => 'JC ISSUE'),
//            array('id' => self::PRODUCTION, 'title' => 'PRODUCTION'),
        );
    }


    public function getStatus($value)
    {
        if ($value == self::MANUAL_ENTRY)
            $badge = "<span class='badge badge-info'>MANUAL ENTRY</span>";
        else if ($value == self::PURCHASE_RECEIVE)
            $badge = "<span class='badge badge-info'>PURCHASE</span>";
        else if ($value == self::SALES_DELIVERY)
            $badge = "<span class='badge badge-info'>SALES</span>";
        else if ($value == self::CASH_SALE_RETURN)
            $badge = "<span class='badge badge-info'>CASH SALE RETURN</span>";
        else if ($value == self::WARRANTY_RETURN)
            $badge = "<span class='badge badge-info'>WARRANTY RETURN</span>";
        else
            $badge = "";
        return $badge;

    }

}
