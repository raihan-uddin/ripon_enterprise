<?php

class VoucherNoFormateAc extends CActiveRecord
{

    const JURNAL = 7;
    const CONTRA = 8;
    const PAYMENT = 9;
    const RECEIPT = 10;

    const CONTRA_RECEIPT=11;
    const CONTRA_PAYMENT=12;
    const CONTRA_BANK_TO_BANK=13;



    public $lastInsertId;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'voucher_no_formate_ac';
    }

    public function numberFormatOfThis($whatType)
    {
        $data = self::model()->findByAttributes(array('type' => $whatType));
        $typeFormat = "";
        if ($data) {
            $typeFormat = $data->type_format;
        }

        return $typeFormat;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return VoucherNoFormateAc the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function maxValOfThis($whatModel, $whatField, $whatFieldsMaxVal)
    {

        $maxVal = 0;
        $maxValL = 0;
        $criteria = new CDbCriteria();
        $criteria->select = 'MAX(' . $whatField . ') as ' . $whatFieldsMaxVal . '';
        $maxValInfo = $whatModel::model()->findAll($criteria);
        foreach ($maxValInfo as $mvi):
            $maxVal = $mvi->$whatFieldsMaxVal;
        endforeach;
        $maxNumberVal = floatval($maxVal + 1);

        if ($whatModel == "ProdModels") {
            if ($maxNumberVal == 1) {
                $list = Yii::app()->db->createCommand("SELECT `AUTO_INCREMENT`
                FROM  INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '" . Yii::app()->params->dbName . "'
                AND   TABLE_NAME   = 'prod_models'")->queryAll();

                foreach ($list as $item) {
                    $rs = $item['AUTO_INCREMENT'];
                }
                $maxNumberVal = $rs;
            }
        }


        return $maxNumberVal;
    }

    public function maxValOfThisOfThisType($whatModel, $whatField, $whatFieldsMaxVal, $whatType)
    {
        $maxVal = 0;
        $maxValL = 0;
        $criteria = new CDbCriteria();
        $criteria->select = 'MAX(' . $whatField . ') as ' . $whatFieldsMaxVal . '';
        $criteria->addColumnCondition(array('voucher_type' => $whatType));
        $maxValInfo = $whatModel::model()->findAll($criteria);
        foreach ($maxValInfo as $mvi):
            $maxVal = $mvi->$whatFieldsMaxVal;
        endforeach;
        $maxNumberVal = floatval($maxVal + 1);

        if ($whatModel == "ProdModels") {
            if ($maxNumberVal == 1) {
                $list = Yii::app()->db->createCommand("SELECT `AUTO_INCREMENT`
                FROM  INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '" . Yii::app()->params->dbName . "'
                AND   TABLE_NAME   = 'prod_models'")->queryAll();

                foreach ($list as $item) {
                    $rs = $item['AUTO_INCREMENT'];
                }
                $maxNumberVal = $rs;
            }
        }


        return $maxNumberVal;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, type_format', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('type_format', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, type, type_format', 'safe', 'on' => 'search'),
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
            'type' => 'Voucher Type',
            'type_format' => 'Format',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('type', $this->type);
        $criteria->compare('type_format', $this->type_format, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}