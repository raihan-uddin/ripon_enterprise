<?php

class PurchasePrices extends CActiveRecord
{

    public $tPQty;
    public $tPP;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'purchase_prices';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('model_id, po_no', 'numerical', 'integerOnly' => true),
            array('purchase_price, qty', 'numerical'),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, model_id, purchase_price, qty', 'safe', 'on' => 'search'),
        );
    }

    // UPDATE purchase_prices SET purchase_prices.date=(SELECT transaction_date FROM inventory WHERE id=purchase_prices.po_no)

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
            'date' => 'Date',
            'model_id' => 'Product',
            'purchase_price' => 'Purchase Price',
            'qty' => 'Qty',
        );
    }

    public function totalAveragePrice($model_id)
    {

        $criteria = new CDbCriteria();
        $criteria->condition = "date!='0000-00-00' AND model_id=" . $model_id;
        $data = self::model()->findAll($criteria);
        $totalQty = 0;
        $totalPP = 0;
        if ($data) {
            foreach ($data as $d):
                $totalQty = $d->qty + $totalQty;
                $totalPP = $d->purchase_price + $totalPP;
            endforeach;
            $averagePP = $totalPP / $totalQty;
        } else
            $averagePP = 0;

        return number_format($averagePP, 2);
    }

    /**
     * Returns the static model of the specified AR class.
     * @return PurchasePrices the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function prodAveragePrice($model_id)
    {

        $criteria = new CDbCriteria();
        $criteria->condition = "date!='0000-00-00' AND model_id=" . $model_id;
        $data = self::model()->findAll($criteria);
        $totalQty = 0;
        $gTotalPP = 0;
        $averagePP = 0;

        if ($data) {
            foreach ($data as $d):
                $qty = $d->qty;
                $totalQty = round($totalQty + $qty, 2);

                $purchase_price = $d->purchase_price;
                $totalPP = round($purchase_price * $qty, 2);
                $gTotalPP = round($gTotalPP + $totalPP, 2);
            endforeach;
        }

        if ($totalQty > 0) {
            $averagePP = $gTotalPP / $totalQty;
        }

        return number_format($averagePP, 2);
    }

    public function costingPriceList($startDate, $endDate, $model_id)
    {
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');
        $criteria->addColumnCondition(array('model_id' => $model_id), 'AND', 'AND');
        $criteria->order = "id DESC";
        $data = self::model()->findAll($criteria);

        return $data;
    }

    public function costing($model_id, $endDate)
    {

        $averagePP = 0;
        $totalQty = 0;
        $totalPP = 0;
        $criteria = new CDbCriteria();
        $criteria->condition = "date <= '" . $endDate . "' AND model_id=" . $model_id;
        $data = self::model()->findAll($criteria);
        if ($data) {
            foreach ($data as $d):
                $purchaseTotalPrice = round($d->qty * $d->purchase_price, 8);
                $totalPP = round($totalPP + $purchaseTotalPrice, 8);
                $totalQty = round($totalQty + $d->qty);
            endforeach;
        }

        if ($totalQty > 0) {
            $averagePP = round($totalPP / $totalQty, 2);
        }

        return $averagePP;
    }

    public function costingBetweenDate($model_id, $startDate, $endDate)
    {

        $averagePP = 0;
        $totalQty = 0;
        $totalPP = 0;
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');
        $criteria->addColumnCondition(array('model_id' => $model_id), 'AND', 'AND');
        $data = self::model()->findAll($criteria);
        if ($data) {
            foreach ($data as $d):
                $purchaseTotalPrice = round($d->qty * $d->purchase_price, 8);
                $totalPP = round($totalPP + $purchaseTotalPrice, 8);
                $totalQty = round($totalQty + $d->qty);
            endforeach;
        }

        if ($totalQty > 0) {
            $averagePP = round($totalPP / $totalQty, 2);
        }

        return $averagePP;
    }

    public function purchasePriceOfThis($model_id, $actualStockOut, $type, $startDate, $endDate)
    {
        if ($actualStockOut > 0) {
            $purchasePrice = 0;
            $quantity = $actualStockOut;
            $totalQtyCalculated = 0;
            if ($type == PpSelectionType::AVERAGE) {
                $purchasePrice = self::model()->purchasePriceAvarage($model_id, $actualStockOut, $startDate, $endDate);
                return $purchasePrice;
            } else {
                $criteria = new CDbCriteria();
                $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');
                $criteria->addColumnCondition(array('model_id' => $model_id), 'AND', 'AND');
                if ($type == PpSelectionType::FIFO)
                    $criteria->order = "id ASC";
                else if ($type == PpSelectionType::LIFO)
                    $criteria->order = "id DESC";
                $data = self::model()->findAll($criteria);
                if ($data) {
                    $breakingPoint = count($data);
                    $qtyCalculated = 0;
                    for ($i = 0; $i < $breakingPoint; $i++) {
                        if ($data[$i]->qty < $quantity && $quantity > 0) {
                            $purchasePrice = $purchasePrice + ($data[$i]->qty * $data[$i]->purchase_price);
                            $qtyCalculated = $data[$i]->qty;
                        } else if ($data[$i]->qty > $quantity && $quantity > 0) {
                            $purchasePrice = $purchasePrice + ($quantity * $data[$i]->purchase_price);
                            $qtyCalculated = $quantity;
                        } else if ($data[$i]->qty == $quantity && $quantity > 0) {
                            $purchasePrice = $purchasePrice + ($data[$i]->qty * $data[$i]->purchase_price);
                            $qtyCalculated = $data[$i]->qty;
                            $breakingPoint = 0;
                        } else {
                            $breakingPoint = 0;
                            $qtyCalculated = 0;
                        }

                        $quantity = $quantity - $data[$i]->qty;

                        $totalQtyCalculated = $qtyCalculated + $totalQtyCalculated;
                    }
                    $qtyCalculationRemaining = ($actualStockOut - $totalQtyCalculated);
                    if ($qtyCalculationRemaining > 0) {
                        $date = new DateTime($startDate);

                        $date->sub(new DateInterval('P1D'));
                        $newStartDate = $date->format('Y-m-d');

                        $criteriaLast = new CDbCriteria();
                        $criteriaLast->condition = 'id!=0 ORDER BY id DESC LIMIT 0,1';
                        $lastData = self::model()->findAll($criteriaLast);

                        if (end($lastData)->date > $newStartDate) { // that means here calculation ends if startDate is less then this date
                            $purchasePriceInfo = ($averagePP * $actualStockOut);
                            return $purchasePriceInfo;
                        } else {
                            return self::model()->purchasePriceOfThis($model_id, $actualStockOut, $type, $newStartDate, $endDate);
                        }
                    } else {
                        return $purchasePrice;
                    }
                } else {
                    $qtyCalculationRemaining = ($actualStockOut - $totalQtyCalculated);
                    if ($qtyCalculationRemaining > 0) {
                        $date = new DateTime($startDate);

                        $date->sub(new DateInterval('P1D'));
                        $newStartDate = $date->format('Y-m-d');

                        return self::model()->purchasePriceOfThis($model_id, $actualStockOut, $type, $newStartDate, $endDate);
                    } else {
                        return $purchasePrice;
                    }
                }
            }
        } else {
            return 0;
        }
    }

    public function purchasePriceAvarage($model_id, $actualStockOut, $startDate, $endDate)
    {

        $averagePP = 0;
        $criteria = new CDbCriteria();
        //$criteria->select = 'sum(qty) as tPQty, sum(purchase_price) as tPP';
        $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');
        $criteria->addColumnCondition(array('model_id' => $model_id), 'AND', 'AND');
        $data = self::model()->findAll($criteria);

        $purchasePriceQtyTtl = 0;
        $purchaseQty = 0;
        if ($data) {
            foreach ($data as $d):
                $purchasePrice = ($d->qty * $d->purchase_price);
                $purchaseQty = $d->qty + $purchaseQty;
                $purchasePriceQtyTtl = $purchasePrice + $purchasePriceQtyTtl;
            endforeach;
        }
        $averagePP = 0;

        if ($purchaseQty != 0) {
            $averagePP = ($purchasePriceQtyTtl / $purchaseQty);
        }

        if ($purchaseQty < $actualStockOut) {
            $date = new DateTime($startDate);
            $date->sub(new DateInterval('P1D'));
            $newStartDate = $date->format('Y-m-d');

            $criteriaLast = new CDbCriteria();
            $criteriaLast->condition = 'id!=0 ORDER BY id DESC LIMIT 0,1';
            $lastData = self::model()->findAll($criteriaLast);

            if (end($lastData)->date > $newStartDate) { // that means here calculation ends if startDate is less then this date
                $purchasePriceInfo = ($averagePP * $actualStockOut);
                return $purchasePriceInfo;
            } else {
                return self::model()->purchasePriceAvarage($model_id, $actualStockOut, $newStartDate, $endDate);
            }
        } else {
            $purchasePriceInfo = ($averagePP * $actualStockOut);

            return $purchasePriceInfo;
        }
    }

    public function purchasePriceOfThisPreviousDate($model_id, $actualStockOut, $type, $startDate)
    {
        if ($actualStockOut > 0) {
            $purchasePrice = 0;
            $quantity = $actualStockOut;
            if ($type == PpSelectionType::AVERAGE) {
                $purchasePrice = self::model()->purchasePriceAvaragePreviousDate($model_id, $actualStockOut, $startDate);
                return $purchasePrice;
            } else {
                $criteria = new CDbCriteria();
                $criteria->condition = "date < '" . $startDate . "' AND model_id=" . $model_id;
                if ($type == PpSelectionType::FIFO)
                    $criteria->order = "id ASC";
                else if ($type == PpSelectionType::LIFO)
                    $criteria->order = "id DESC";
                $data = self::model()->findAll($criteria);
                if ($data) {
                    $breakingPoint = count($data);
                    for ($i = 0; $i < $breakingPoint; $i++) {
                        if ($data[$i]->qty < $quantity && $quantity > 0) {
                            $purchasePrice = $purchasePrice + ($data[$i]->qty * $data[$i]->purchase_price);
                        } else if ($data[$i]->qty > $quantity && $quantity > 0) {
                            $purchasePrice = $purchasePrice + ($quantity * $data[$i]->purchase_price);
                        } else if ($data[$i]->qty == $quantity && $quantity > 0) {
                            $purchasePrice = $purchasePrice + ($data[$i]->qty * $data[$i]->purchase_price);
                            $breakingPoint = 0;
                        } else {
                            $breakingPoint = 0;
                        }
                        $quantity = $quantity - $data[$i]->qty;
                    }
                    return $purchasePrice;
                } else {
                    return $purchasePrice;
                }
            }
        } else {
            return 0;
        }
    }

    public function purchasePriceAvaragePreviousDate($model_id, $actualStockOut, $startDate)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(qty) as tPQty, sum(purchase_price) as tPP';
        $criteria->condition = 'date < "' . $startDate . '" AND model_id=' . $model_id;
        $data = self::model()->findAll($criteria);
        $averagePP = 0;
        if ($data) {
            foreach ($data as $d):
                $pp = $d->tPP;
                $pq = $d->tPQty;
            endforeach;
            $averagePP = ($pp / $pq);
        }
        $purchasePriceInfo = ($averagePP * $actualStockOut);

        return $purchasePriceInfo;
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('purchase_price', $this->purchase_price);
        $criteria->compare('qty', $this->qty);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
