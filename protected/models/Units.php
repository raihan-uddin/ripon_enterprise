<?php

/**
 * This is the model class for table "units".
 *
 * The followings are the available columns in table 'units':
 * @property integer $id
 * @property string $label
 * @property double $value
 */
class Units extends CActiveRecord
{

    const CURR_UNIT = 7;
    const QTY_UNIT = 8;
    const MEASUREMENT = 17;
    const WEIGHT = 18;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'units';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('label', 'required'),
            array('label', 'unique', 'caseSensitive' => FALSE),
            array('value', 'numerical'),
            array('label', 'length', 'max' => 50),
            array('remarks', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, label, value', 'safe', 'on' => 'search'),
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
            'label' => 'Unit Name',
            'value' => 'Value',
            'remarks' => 'Remarks',
        );
    }

    public function unitValue($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->value;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Units the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function unitLabel($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->label;
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->label;
    }


    public function dropdownUnits($fieldname, $selectedvalue = '')
    {
        if ($fieldname != '') {
            $models = Units::model()->findAll(array('order' => 'label ASC'));
            $list = CHtml::listData($models, 'id', 'label');
            return CHtml::dropDownList($fieldname, $selectedvalue, $list, array('empty' => '(Select Unit)'));
        } else {
            return '';
        }
    }

    public function dropdownOptions($selectedvalue = '')
    {
        $models = Units::model()->findAll(array('order' => 'label ASC'));
        $list = CHtml::listData($models, 'id', 'label');
        $returnstr = '';
        if ($list) {
            foreach ($list as $value => $label) {
                $selected = '';
                if ($value == $selectedvalue) {
                    $selected = ' selected="selected"';
                }
                $returnstr .= "<option$selected value=\"$value\">$label</option>";
            }
        }
        return $returnstr;
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
        $criteria->compare('label', $this->label, true);
        $criteria->compare('value', $this->value);
        $criteria->compare('remarks', $this->remarks, true);

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