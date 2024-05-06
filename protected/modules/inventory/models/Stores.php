<?php

/**
 * This is the model class for table "stores".
 *
 * The followings are the available columns in table 'stores':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Stores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('address, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			array('id, name, address, created_by, created_at, updated_by, updated_at', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'address' => 'Address',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_by' => 'Updated By',
			'updated_at' => 'Updated At',
		);
	}


    public function beforeSave()
    {
        $dateTime = date('Y-m-d H:i:s');

        if ($this->isNewRecord) {
            $this->created_at = $dateTime;
            $this->created_by = Yii::app()->user->id;
        } else {
            $this->updated_at = $dateTime;
            $this->updated_by = Yii::app()->user->id;
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->name;
    }

    public function dropdownStore($fieldname = 'name', $selectedvalue = 0)
    {

        $data = self::model()->findAll(array('order' => $fieldname . ' ASC'));
        $list = "<option value=\"0\">Select</option>";
        if ($data) {
            foreach ($data as $onerow) {
                $id = $onerow->id;
                $store_name = stripslashes(trim($onerow->$fieldname));

                $selected = '';
                if ($selectedvalue == $id) {
                    $selected = ' selected';
                }
                $list .= "<option value=\"$id\" $selected>$store_name</option>";
            }
        }

        return $list;
    }

    public function storeName($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->name;
    }

    public function preFormattedAddr($addr)
    {
        echo "<pre>" . $addr . "</pre>";
    }

    public function storeList()
    {
        $data = CHtml::listData(self::model()->findAll(['order' => 'name ASC']), 'id', 'name');
        return $data;
    }

}
