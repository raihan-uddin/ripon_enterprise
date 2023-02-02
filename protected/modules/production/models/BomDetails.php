<?php

/**
 * This is the model class for table "bom_details".
 *
 * The followings are the available columns in table 'bom_details':
 * @property integer $id
 * @property integer $bom_id
 * @property integer $model_id
 * @property integer $unit_id
 * @property double $qty
 * @property integer $created_by
 * @property string $created_at
 */
class BomDetails extends CActiveRecord
{
    public $model_name;
    public $code;
    public $image;
    public $pm_unit_id;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BomDetails the static model class
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
        return 'bom_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bom_id, model_id, qty', 'required'),
            array('bom_id, model_id, unit_id, created_by', 'numerical', 'integerOnly' => true),
            array('qty', 'numerical'),
            array('created_at', 'safe'),
            // The following rule is used by search().
            array('id, bom_id, model_id, unit_id, qty, created_by, created_at', 'safe', 'on' => 'search'),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
            $this->created_by = Yii::app()->user->id;
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
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'bom_id' => 'Bom',
            'model_id' => 'Material',
            'unit_id' => 'Unit',
            'qty' => 'Qty',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('bom_id', $this->bom_id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_at', $this->created_at, true);

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
