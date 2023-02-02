<?php

/**
 * This is the model class for table "invoice_details".
 *
 * The followings are the available columns in table 'invoice_details':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $model_id
 * @property double $unit_price
 * @property double $qty
 * @property double $row_total
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $color
 * @property string $note
 */
class InvoiceDetails extends CActiveRecord
{
    public $image;
    public $model_name;
    public $code;
    public $unit_id;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InvoiceDetails the static model class
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
        return 'invoice_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invoice_id, model_id, qty', 'required'),
            array('invoice_id, model_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('unit_price, qty, row_total', 'numerical'),
            array('created_at, updated_at, color, note', 'safe'),
            // The following rule is used by search().
            array('id, invoice_id, model_id, unit_price, qty, row_total, created_by, created_at, color, updated_by, note, updated_at', 'safe', 'on' => 'search'),
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
            'invoice_id' => 'Invoice No',
            'model_id' => 'Material Name',
            'unit_price' => 'Unit Price',
            'qty' => 'Qty',
            'note' => 'Note',
            'color' => 'Color',
            'row_total' => 'Row Total',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('invoice_id', $this->invoice_id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('unit_price', $this->unit_price);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('row_total', $this->row_total);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function totalInvoiceQtyOfThisModelByOrder($model_id, $order_id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = " SUM(qty) AS qty";
        $criteria->join = "INNER JOIN invoice inv on t.invoice_id = inv.id";
        $criteria->addColumnCondition(['inv.order_id' => $order_id, 't.model_id' => $model_id]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->qty : 0;
    }

}
