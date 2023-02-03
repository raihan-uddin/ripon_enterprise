<?php

/**
 * This is the model class for table "sell_order_details".
 *
 * The followings are the available columns in table 'sell_order_details':
 * @property integer $id
 * @property integer $sell_order_id
 * @property integer $model_id
 * @property double $qty
 * @property double $amount
 * @property double $row_total
 * @property integer $is_delivery_done
 * @property integer $is_invoice_done
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $color
 * @property string $note
 * @property string $product_sl_no
 */
class SellOrderDetails extends CActiveRecord
{
    public $unit_id;
    public $model_name;
    public $code;
    public $image;

    const DELIVERY_DONE = 1;
    const DELIVERY_NOT_DONE = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sell_order_details';
    }

    /**
     * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('sell_order_id, model_id, qty, amount, row_total', 'required'),
            array('sell_order_id, model_id, is_delivery_done, is_invoice_done, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty, amount, row_total', 'numerical'),
            array('created_at, updated_at, color, note, product_sl_no', 'safe'),
            // The following rule is used by search().
            array('id, sell_order_id, model_id, qty, note, product_sl_no, amount, row_total, is_delivery_done, color, is_invoice_done, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'sell_order_id' => 'Sell Order',
            'model_id' => 'Product',
            'qty' => 'Qty',
            'color' => 'Color',
            'note' => 'Product Note',
            'amount' => 'Unit Price',
            'row_total' => 'Row Total',
            'is_delivery_done' => 'Is Delivery Done',
            'is_invoice_done' => 'Is Invoice Done',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
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
		$criteria=new CDbCriteria;
        $criteria->select = "t.*";
        $criteria->join = " ";

		$criteria->compare('id',$this->id);
        $criteria->compare('sell_order_id', $this->sell_order_id);
        $criteria->compare('product_sl_no', $this->product_sl_no);
        $criteria->compare('model_id', $this->model_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('row_total',$this->row_total);
		$criteria->compare('color',$this->color);
		$criteria->compare('is_delivery_done',$this->is_delivery_done);
		$criteria->compare('is_invoice_done',$this->is_invoice_done);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_by',$this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('note', $this->note, true);

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
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
        }else {
            $this->updated_by = Yii::app()->user->id;
            $this->updated_at = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellOrderDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
