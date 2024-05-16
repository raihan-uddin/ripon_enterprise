<?php

/**
 * This is the model class for table "businesses".
 *
 * The followings are the available columns in table 'businesses':
 * @property integer $id
 * @property string $slug
 * @property string $display_name
 * @property integer $status
 * @property string $owner_name
 * @property string $phone_number
 * @property string $email
 * @property string $address
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Business extends CActiveRecord
{
    const ACTIVE = 1;
    const PENDING = 2;
    const INACTIVE = 3;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'businesses';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('display_name', 'required'),
            array('status, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('slug, display_name', 'length', 'max' => 300),
            array('owner_name, phone_number', 'length', 'max' => 255),
            array('email', 'length', 'max' => 50),
            array('address, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, slug, display_name, status, owner_name, phone_number, email, address, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
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
            'slug' => 'Slug',
            'display_name' => 'Display Name',
            'status' => 'Status',
            'owner_name' => 'Owner Name',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'address' => 'Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('display_name', $this->display_name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('owner_name', $this->owner_name, true);
        $criteria->compare('phone_number', $this->phone_number, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Business the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $dateTime = date('Y-m-d H:i:s');

        if ($this->isNewRecord) {
            $this->slug = $this->createSlug($this->display_name);
            $this->created_at = $dateTime;
            $this->created_by = Yii::app()->user->getState('user_id');
        } else {
            $this->updated_at = $dateTime;
            $this->updated_by = Yii::app()->user->getState('user_id');
        }
        return parent::beforeSave();
    }

    public function createSlug($string)
    {
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', "-", $slug);
        return $slug;
    }

    public function statusFilter()
    {
        return array(
            array('id' => self::ACTIVE, 'title' => 'ACTIVE'),
            array('id' => self::PENDING, 'title' => 'PENDING'),
            array('id' => self::INACTIVE, 'title' => 'INACTIVE'),
        );
    }

    public function statusString($value)
    {
        if ($value == self::ACTIVE)
            $badge = "<span class='badge badge-success'>ACTIVE</span>";
        elseif ($value == self::PENDING)
            $badge = "<span class='badge badge-warning'>PENDING</span>";
        elseif ($value == self::INACTIVE)
            $badge = "<span class='badge badge-danger'>INACTIVE</span>";
        else
            $badge = "<span class='badge badge-secondary'>UNKNOWN</span>";
        return $badge;
    }

    public function nameOfThis($id)
    {
        $model = Business::model()->findByPk($id);
        if ($model)
            return $model->display_name;

    }

}