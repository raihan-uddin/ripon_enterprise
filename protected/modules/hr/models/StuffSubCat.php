<?php

/**
 * This is the model class for table "stuff_sub_cat".
 *
 * The followings are the available columns in table 'stuff_sub_cat':
 * @property integer $id
 * @property integer $stuff_cat_id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property StuffCat $stuffCat
 */
class StuffSubCat extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return StuffSubCat the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'stuff_sub_cat';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('stuff_cat_id, title', 'required'),
            array('stuff_cat_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, stuff_cat_id, title', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'stuffCat' => array(self::BELONGS_TO, 'StuffCat', 'stuff_cat_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'stuff_cat_id' => 'Stuff Cat',
            'title' => 'Title',
        );
    }

    public function nameOfThis($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->title;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('stuff_cat_id', $this->stuff_cat_id);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'stuff_cat_id DESC',
            ),
        ));
    }

}