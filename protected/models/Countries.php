<?php

/**
 * This is the model class for table "countries".
 *
 * The followings are the available columns in table 'countries':
 * @property integer $id
 * @property string $country
 */
class Countries extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'countries';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country', 'required'),
            array('iso2', 'length', 'max' => 2),
            array('iso3', 'length', 'max' => 3),
            array('country', 'length', 'max' => 64),
            array('country, iso2, iso3', 'unique', 'caseSensitive' => FALSE),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, iso2, iso3, country', 'safe', 'on' => 'search'),
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
            'iso2' => 'ISO2-Name',
            'iso3' => 'ISO3-Name',
            'country' => 'EN-Name',
        );
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->country;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Countries the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
        $criteria->compare('iso2', $this->iso2, true);
        $criteria->compare('iso3', $this->iso3, true);
        $criteria->compare('country', $this->country, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
            'sort' => array(
                'defaultOrder' => 'country ASC',
            ),
        ));
    }

}