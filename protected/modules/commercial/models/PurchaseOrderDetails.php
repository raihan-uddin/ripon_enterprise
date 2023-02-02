<?php

/**
 * This is the model class for table "purchase_order_details".
 *
 * The followings are the available columns in table 'purchase_order_details':
 * @property integer $id
 * @property integer $model_id
 * @property integer $order_id
 * @property double $qty
 * @property double $unit_price
 * @property double $row_total
 * @property integer $is_all_received
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $note
 */
class PurchaseOrderDetails extends CActiveRecord
{
    public $color;
    public $amount;
    public $unit_id;
    public $model_name;
    public $code;
    public $image;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'purchase_order_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('model_id, qty, unit_price, row_total, order_id', 'required'),
            array('model_id, is_all_received, created_by, updated_by, order_id', 'numerical', 'integerOnly' => true),
            array('qty, unit_price, row_total', 'numerical'),
            array('created_at, updated_at, note', 'safe'),
            // The following rule is used by search().

            array('id, model_id, note, qty, unit_price, row_total, order_id, is_all_received, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'order_id' => 'PO',
            'model_id' => 'Model',
            'qty' => 'Qty',
            'unit_price' => 'Unit Price',
            'row_total' => 'Row Total',
            'is_all_received' => 'Is All Received',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'note' => 'Note',
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
        $criteria->compare('id', $this->id);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('unit_price', $this->unit_price);
        $criteria->compare('row_total', $this->row_total);
        $criteria->compare('is_all_received', $this->is_all_received);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_by', $this->updated_by);
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
        } else {
            $this->updated_at = new CDbExpression('NOW()');
            $this->updated_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PurchaseOrderDetails the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
