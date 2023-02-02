<?php

/**
 * This is the model class for table "sell_order_bom".
 *
 * The followings are the available columns in table 'sell_order_bom':
 * @property integer $id
 * @property integer $sell_order_id
 * @property integer $max_sl_no
 * @property string $bom_no
 * @property integer $model_id
 * @property double $qty
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 * @property string $date
 */
class SellOrderBom extends CActiveRecord
{
    public $fg_model_id;
    public $unit_id;
    public $model_name;
    public $code;
    public $so_no;
    public $job_card;
    public $print_type;

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
     * @return SellOrderBom the static model class
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
        return 'sell_order_bom';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sell_order_id, max_sl_no, bom_no, model_id, qty', 'required'),
            array('sell_order_id, max_sl_no, model_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty', 'numerical'),
            array('bom_no', 'length', 'max' => 255),
            array('created_at, updated_at, date', 'safe'),
            // The following rule is used by search().
            array('id, sell_order_id, max_sl_no, bom_no, model_id, qty, created_by, created_at, updated_by, updated_at, date', 'safe', 'on' => 'search'),
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
            'sell_order_id' => 'SO No',
            'max_sl_no' => 'Max Sl No',
            'bom_no' => 'Bom No',
            'model_id' => 'Model',
            'qty' => 'Qty',
            'job_card' => 'Job Card',
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
        $criteria->join = "";
        if (trim($this->sell_order_id) != "" || trim($this->job_card) != "") {
            $criteria->join .= " INNER JOIN sell_order so on t.sell_order_id = so.id ";
            $criteria->compare('so.so_no', trim($this->sell_order_id), true);
            $criteria->compare('so.job_no', trim($this->job_card), true);
        }

        if (trim($this->model_id) != "") {
            $criteria->join .= " INNER JOIN prod_models pm on t.model_id = pm.id ";
            $criteria->compare('pm.model_name', trim($this->model_id), true);
        }

        if (trim($this->created_by) != "") {
            $criteria->join .= " INNER JOIN users u on t.created_by = u.id ";
            $criteria->compare('u.username', trim($this->created_by), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date);
        $criteria->compare('max_sl_no', $this->max_sl_no);
        $criteria->compare('bom_no', $this->bom_no, true);
        $criteria->compare('qty', $this->qty);
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
