<?php

class Report extends CActiveRecord
{
    public $id;
    public $date;
    public $date_from;
    public $date_to;
    public $order_no;
    public $customer_id;
    public $amount;
    public $company_name;

    public function tableName()
    {
        return null;
    }
}
