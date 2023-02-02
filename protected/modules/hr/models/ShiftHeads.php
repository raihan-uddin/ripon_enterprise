<?php

class ShiftHeads extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ShiftHeads the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'shift_heads';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, in_time, out_time', 'required'),
            array('title, in_time, out_time', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, in_time, out_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'in_time' => 'In Time',
            'out_time' => 'Out Time',
        );
    }
    
    public function nameOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->title;
    }
    
    public function detailsOfThis($id){
        $data=self::model()->findByPk($id);
        if($data)
            return $data->title." ( In: ".$data->in_time.", Out: ".$data->out_time.")";
    }
//    public function __get($key){
//        $action = 'get'.str_replace(' ','',ucwords(str_replace('_',' ',$key)));
//        if(method_exists($this, $action)) 
//                return $this->$action();
//        return parent::__get($key);
//    }
//
//    public function getDetails(){
//        return $this->title.' ('.$this->in_time.' - '.$this->out_time.')';
//    }
    
    public function getTitleWithInOutTime(){
        return $this->title.' ('.$this->in_time.' - '.$this->out_time.')';
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('in_time', $this->in_time, true);
        $criteria->compare('out_time', $this->out_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

}