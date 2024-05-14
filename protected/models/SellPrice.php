<?php

class SellPrice extends CActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sell_price';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('model_id, sell_price, is_active', 'required'),
            array('model_id, is_active, ideal_qty, warn_qty, add_by, update_by', 'numerical', 'integerOnly' => true),
            array('sell_price, discount', 'numerical'),
            array('add_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, model_id, sell_price, start_date, end_date, is_active, discount, ideal_qty, warn_qty', 'safe', 'on' => 'search'),
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
            'prodModels' => array(self::BELONGS_TO, 'ProdModels', 'model_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'model_id' => 'Product',
            'sell_price' => 'Sell Price',
            'discount' => 'Discount(%)',
            'ideal_qty' => 'Ideal Qty',
            'warn_qty' => 'Warn Qty',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'is_active' => 'Is Active',
            'add_time' => 'Added Time',
            'update_time' => 'Updated Time',
            'add_by' => 'Added By',
            'update_by' => 'Updated By',
        );
    }

    public function activeSellpriceByProdId($prodId)
    {
        $sellPriceModel = SellPrice::model()->findByAttributes(array('model_id' => $prodId, 'is_active' => 1));
        if ($sellPriceModel != '')
            return $sellPriceModel->sell_price;
        else
            return 0;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return SellPrice the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function beforeSave()
    {
        // set default time zone to asia/dhaka
        date_default_timezone_set('Asia/Dhaka');
        $dateTime = date('Y-m-d H:i:s');

        $businessId = Yii::app()->user->getState('business_id');
        $branchId = Yii::app()->user->getState('branch_id');

        $this->business_id = $businessId;
        $this->branch_id = $branchId;

        if ($this->is_active) {
            $prodModel = ProdModels::model()->findByPk($this->model_id);
            if ($prodModel) {
                $prodModel->sell_price = $this->sell_price;
                $prodModel->save();
            }
        }
        if ($this->isNewRecord) {
            $this->add_time = $dateTime;
            $this->add_by = Yii::app()->user->getId();
        } else {
            $this->update_time = $dateTime;
            $this->update_by = Yii::app()->user->getId();
        }
        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->is_active == self::ACTIVE) {
            self::model()->updateAll(array('is_active' => self::INACTIVE), 'id!=:id AND model_id=:model_id', array(':id' => $this->id, ':model_id' => $this->model_id));
        }
        return parent::afterSave();
    }

    public function statusColor($status)
    {
        if ($status == self::ACTIVE) {
            echo "<span class='badge badge-success'>ACTIVE</b></span>";
        } else {
            echo "<span class='badge badge-danger'>INACTIVE</b></span>";
        }
    }


    public function activeSellPriceOnly($modelId)
    {
        $data = self::model()->findByAttributes(array('model_id' => $modelId, 'is_active' => self::ACTIVE));
        if ($data) {
            return $data->sell_price;
        } else {
            return 0;
        }
    }

    public function activeInfos($modelId)
    {
        $data = self::model()->findByAttributes(array('model_id' => $modelId, 'is_active' => self::ACTIVE));
        return $data;
    }

    public function activeSellPriceAndDiscount($modelId)
    {
        $data = self::model()->findByAttributes(array('model_id' => $modelId, 'is_active' => self::ACTIVE));
        if ($data) {
            echo $data->sell_price . "(" . $data->discount . "%)";
        } else {
            echo "<font style='color: red; font-weight: bold;'>No active price/discount!</font>";
        }
    }

    public function activeSellPriceWithDiscountAndIdealWarnQty($modelId)
    {
        $data = self::model()->findByAttributes(array('model_id' => $modelId, 'is_active' => self::ACTIVE));
        $activeSellPrice = 0;
        $activeDiscount = 0;
        $activeIdealQty = 0;
        $activeWarnQty = 0;
        if ($data) {
            $activeSellPrice = $data->sell_price;
            $activeDiscount = $data->discount;
            $activeIdealQty = $data->ideal_qty;
            $activeWarnQty = $data->warn_qty;
        }

        echo "<span class='badge badge-success'>Price: " . $activeSellPrice . "</span>, <span class='badge badge-warning'>Discount: " . $activeDiscount . "% </span>, <span class='badge badge-danger'>Ideal Qty: " . $activeIdealQty . "</span>, <span class='badge badge-info'>Warn Qty: " . $activeWarnQty . "</span>";
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
        $criteria->select = " t.*";
        $criteria->join = "";
        if (($this->model_id) != "") {
            $criteria->join .= " INNER JOIN prod_models pm on t.model_id = pm.id ";
            $criteria->compare("pm.model_name", ($this->model_id), true);
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('sell_price', $this->sell_price);
        $criteria->compare('discount', $this->discount);
        $criteria->compare('ideal_qty', $this->ideal_qty);
        $criteria->compare('warn_qty', $this->warn_qty);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('is_active', $this->is_active);

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

    public function getSellPriceByModelId($model_id)
    {
        $sellPrice = 0;
        $sql = "SELECT * FROM sell_price where model_id = {$model_id} order by id desc limit 1";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $data = $command->queryRow();
        if ($data)
            $sellPrice = $data['sell_price'];
        else
            $sellPrice = 0;
        return $sellPrice;
    }

}
