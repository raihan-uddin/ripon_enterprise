<?php

/**
 * This is the model class for table "job_card_issue_details".
 *
 * The followings are the available columns in table 'job_card_issue_details':
 * @property integer $id
 * @property integer $job_card_issue_id
 * @property integer $model_id
 * @property double $qty
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class JobCardIssueDetails extends CActiveRecord
{
    public $model_name;
    public $code;
    public $unit_id;
    public $image;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JobCardIssueDetails the static model class
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
        return 'job_card_issue_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('job_card_issue_id, model_id, qty', 'required'),
            array('job_card_issue_id, model_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('qty', 'numerical'),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            array('id, job_card_issue_id, model_id, qty, created_by, created_at, updated_by, updated_at', 'safe', 'on' => 'search'),
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
            'job_card_issue_id' => 'Job Card Issue',
            'model_id' => 'Model',
            'qty' => 'Qty',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('job_card_issue_id', $this->job_card_issue_id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('created_by', $this->created_by);
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


    public function totalIssueQtyOfThisModelByOrder($model_id, $order_id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = " SUM(qty) AS qty";
        $criteria->join = "INNER JOIN job_card_issue jci on t.job_card_issue_id = jci.id";
        $criteria->addColumnCondition(['jci.order_id' => $order_id, 't.model_id' => $model_id]);
        $data = self::model()->findByAttributes([], $criteria);
        return $data ? $data->qty : 0;
    }
}
