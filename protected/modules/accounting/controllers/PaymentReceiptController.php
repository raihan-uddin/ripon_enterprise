<?php

class PaymentReceiptController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights
            -VoucherPreview',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array();
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function actionCreate($id, $order_id = 0)
    {
        $model = new PaymentReceipt();
        $model2 = Suppliers::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $transaction = Yii::app()->db->beginTransaction();
        try {
            if (isset($_POST['PaymentReceipt'])) {
                $model->attributes = $_POST['PaymentReceipt'];
                $model->max_sl_no = PaymentReceipt::maxSlNo();
                $model->order_id = 0;
                $model->amount = 0;
                $model->pr_no = "PR-" . date('y') . "-" . date('m') . "-" . str_pad($model->max_sl_no, 5, "0", STR_PAD_LEFT);
                if ($model->validate()) {
                    $order_id_arr = [];
                    foreach ($_POST['PaymentReceipt']['amount'] as $key => $amount) {
                        $rem_amount = $_POST['PaymentReceipt']['rem_amount'][$key];
                        $order_id = $_POST['PaymentReceipt']['order_id'][$key];
                        if ($amount > 0) {
                            $model2 = new PaymentReceipt();
                            $model2->date = $model->date;
                            $model2->payment_type = $model->payment_type;
                            $model2->supplier_id = $model->supplier_id;
                            $model2->order_id = $order_id;
                            $model2->max_sl_no = $model->max_sl_no;
                            $model2->pr_no = $model->pr_no;
                            $model2->amount = $amount;
                            $model2->bank_id = $model->bank_id;
                            $model2->cheque_no = $model->cheque_no;
                            $model2->remarks = $model->remarks;
                            $model2->cheque_date = $model->cheque_date;
                            if (!$model2->save()) {
                                $transaction->rollBack();
                                throw new CHttpException(500, sprintf('Error in saving order details! %s <br>', json_encode($model2->getErrors())));
                            }
                            $order_id_arr[] = $order_id;
                        }
                    }
                    $criteria = new CDbCriteria();
                    $criteria->addInCondition('id', $order_id_arr);
                    $data = PurchaseOrder::model()->findAll($criteria);
                    if ($data) {
                        foreach ($data as $dt) {
                            $grand_total = $dt->grand_total;
                            $total_mr = PaymentReceipt::model()->totalPaidAmountOfThisOrder($dt->id);
                            $rem = $grand_total - $total_mr;
                            if ($total_mr >= $grand_total) {
                                $dt->is_paid = PurchaseOrder::PAID;
                                $dt->save();
                            }
                        }
                    }

                    $transaction->commit();

                    $criteria = new CDbCriteria;
                    $criteria->select = "SUM(amount) as amount, supplier_id, date, pr_no, bank_id, cheque_no, cheque_date, remarks, created_by";
                    $criteria->addColumnCondition(['supplier_id' => $model->supplier_id, 'pr_no' => $model->pr_no]);
                    $criteria->group = 'supplier_id, pr_no';
                    $dataMr = PaymentReceipt::model()->findAll($criteria);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'soReportInfo' => $this->renderPartial('voucherPreview', array('data' => $dataMr, 'new' => true), true, true), //
                    ));
                    Yii::app()->end();
                } else {
                    $error = CActiveForm::validate($model);
                    $error2 = CActiveForm::validate($model2);
                    if ($error != '[]')
                        echo $error;
                    if ($error2 != '[]')
                        echo $error2;
                    Yii::app()->end();
                }
            }
        } catch (PDOException $e) {
            $transaction->rollBack();
            throw new CHttpException(500, $e->getMessage());
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }


        $this->pageTitle = "PR CREATE";
        $this->render('_form', array(
            'model' => $model,
            'model2' => $model2,
            'id' => $id,
            'order_id' => $order_id,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param PaymentReceipt $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-receipt-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $data = $this->loadModel($id);
        if ($data) {
            $orderId = $data->order_id;
            $invoice = PurchaseOrder::model()->findByPk($orderId);
            if (!$invoice)
                throw new CHttpException(404, 'The requested page does not exist.');

            if (!$this->loadModel($id)->delete())
                throw new CHttpException(404, 'The requested page does not exist.');

            $currentCollection = PaymentReceipt::model()->totalPaidAmountOfThisOrder($orderId);

            if ($invoice) {
                $invoice->is_paid = $currentCollection >= $invoice->grand_total ? PurchaseOrder::PAID : PurchaseOrder::DUE;
                $invoice->save();
            }
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PaymentReceipt the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = PaymentReceipt::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new PaymentReceipt('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentReceipt']))
            $model->attributes = $_GET['PaymentReceipt'];


        $this->pageTitle = "PAYMENT RECEIPT MANAGE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminPaymentReceipt()
    {
        $model = new Suppliers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Suppliers']))
            $model->attributes = $_GET['Suppliers'];

        $this->pageTitle = "SUPPLIER MANAGE";
        $this->render('adminPaymentReceipt', array(
            'model' => $model,
        ));
    }

    public function actionVoucherPreview()
    {
        $pr_no = isset($_POST['pr_no']) ? trim($_POST['pr_no']) : "";

        if (strlen($pr_no) > 0) {
            $criteria = new CDbCriteria;
            $criteria->select = "SUM(amount) as amount, supplier_id, date, pr_no, bank_id, cheque_no, cheque_date, remarks, created_by";
            $criteria->addColumnCondition(['pr_no' => $pr_no]);
            $criteria->group = 'supplier_id, pr_no';
            $data = PaymentReceipt::model()->findAll($criteria);
            if ($data) {
                echo $this->renderPartial("voucherPreview", array('data' => $data,), true, true);
            } else {
                header('Content-type: application/json');
                echo CJSON::encode(array(
                    'status' => 'error',
                ));
            }
            Yii::app()->end();
        } else {
            echo '<div class="alert alert-danger" role="alert">Please select  PR no!</div>';
        }
    }


    public function actionFixPaymentIssue()
    {
        $sql = "SELECT id, date, supplier_id, amount, max_sl_no, pr_no, payment_type, bank_id, cheque_no, cheque_date, discount, remarks, created_by, created_at FROM payment_receipt_cp where is_deleted = 0";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if ($data) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($data as $dt) {
                    $supplier_id = $dt['supplier_id'];
                    $currentPaidAmt = $dt['amount'];
                    $date = $dt['date'];
                    $max_sl_no = $dt['max_sl_no'];
                    $pr_no = $dt['pr_no'];
                    $payment_type = $dt['payment_type'];
                    $bank_id = $dt['bank_id'];
                    $cheque_no = $dt['cheque_no'];
                    $cheque_date = $dt['cheque_date'];
                    $discount = $dt['discount'];
                    $remarks = $dt['remarks'];
                    $created_by = $dt['created_by'];
                    $created_at = $dt['created_at'];

                    echo sprintf("Supplier ID: %s, Amount: %s, Date: %s, Max SL No: %s, PR No: %s, Payment Type: %s, <br>", $supplier_id, $currentPaidAmt, $date, $max_sl_no, $pr_no, $payment_type);

                    // get all the order id of this supplier
                    $criteria = new CDbCriteria();
                    $criteria->select = "id, grand_total, is_paid, date, max_sl_no, po_no, supplier_id";
                    $criteria->addColumnCondition(['supplier_id' => $supplier_id, 'is_paid' => PurchaseOrder::DUE, 'is_deleted' => 0]);
                    $po_data = PurchaseOrder::model()->findAll($criteria);
                    if ($po_data) {
                        $newPaidAmt = $currentPaidAmt;
                        foreach ($po_data as $po) {
                            $po_id = $po->id;
                            $po_amount = $po->grand_total;
                            $total_mr = PaymentReceipt::model()->totalPaidAmountOfThisOrder($po_id);
                            $rem = $po_amount - $total_mr;
                            $newPaidAmt = round(($newPaidAmt - $po_amount), 2);
                            if ($newPaidAmt < 0) {
                                $newPaidAmt = 0;
                                echo sprintf("........................<br>");
                                echo sprintf("Paid amount is now less than 0! breaking the operation<br>");
                                echo sprintf("........................<br>");
                                break;
                            }
                            $model = new PaymentReceipt();
                            if ($newPaidAmt > $po_amount) {
                                echo sprintf("New Paid Amount is greater than the order amount! <br>");
                                echo sprintf("Order ID: %s, Paid Amount: %s, Remaining Amount: %s, New Paid Amount: %s, <br>", $po_id, $total_mr, $rem, $newPaidAmt);
                                $model->date = $date;
                                $model->supplier_id = $supplier_id;
                                $model->order_id = $po_id;
                                $model->max_sl_no = $max_sl_no;
                                $model->pr_no = $pr_no;
                                $model->amount = $po_amount;
                                $model->payment_type = $payment_type;
                                $model->bank_id = $bank_id;
                                $model->cheque_no = $cheque_no;
                                $model->cheque_date = $cheque_date;
                                $model->discount = $discount;
                                $model->remarks = $remarks;
                                $model->created_by = $created_by;
                                $model->created_at = $created_at;
                                if (!$model->save()) {
                                    $transaction->rollBack();
                                    throw new CHttpException(500, sprintf('Error in saving payment receipt! greater than the order amount. %s <br>', json_encode($model->getErrors())));
                                }
                                $po->is_paid = PurchaseOrder::PAID;
                                if (!$po->save(false)) {
                                    $transaction->rollBack();
                                    throw new CHttpException(500, sprintf('Error in saving purchase order! greater than the order amount. %s <br>', json_encode($po->getErrors())));
                                }
                            } elseif ($newPaidAmt == $po_amount) {
                                echo sprintf("New Paid Amount is equal to the order amount! <br>");
                                echo sprintf("Order ID: %s, Paid Amount: %s, Remaining Amount: %s, New Paid Amount: %s, <br>", $po_id, $total_mr, $rem, $newPaidAmt);
                                $model->date = $date;
                                $model->supplier_id = $supplier_id;
                                $model->order_id = $po_id;
                                $model->max_sl_no = $max_sl_no;
                                $model->pr_no = $pr_no;
                                $model->amount = $po_amount;
                                $model->payment_type = $payment_type;
                                $model->bank_id = $bank_id;
                                $model->cheque_no = $cheque_no;
                                $model->cheque_date = $cheque_date;
                                $model->discount = $discount;
                                $model->remarks = $remarks;
                                $model->created_by = $created_by;
                                $model->created_at = $created_at;
                                if (!$model->save()) {
                                    $transaction->rollBack();
                                    throw new CHttpException(500, sprintf('Error in saving payment receipt! equal to the order amount! %s <br>', json_encode($model->getErrors())));
                                }
                                $po->is_paid = PurchaseOrder::PAID;
                                if (!$po->save(false)) {
                                    $transaction->rollBack();
                                    throw new CHttpException(500, sprintf('Error in saving purchase order! equal to the order amount! %s <br>', json_encode($po->getErrors())));
                                }
                                break;
                            } else {
                                echo sprintf("New Paid Amount is less than the order amount! <br>");
                                echo sprintf("Order ID: %s, Paid Amount: %s, Remaining Amount: %s, New Paid Amount: %s, <br>", $po_id, $total_mr, $rem, $newPaidAmt);
                                $model = new PaymentReceipt();
                                $model->date = $date;
                                $model->supplier_id = $supplier_id;
                                $model->order_id = $po_id;
                                $model->max_sl_no = $max_sl_no;
                                $model->pr_no = $pr_no;
                                $model->amount = $newPaidAmt;
                                $model->payment_type = $payment_type;
                                $model->bank_id = $bank_id;
                                $model->cheque_no = $cheque_no;
                                $model->cheque_date = $cheque_date;
                                $model->discount = $discount;
                                $model->remarks = $remarks;
                                $model->created_by = $created_by;
                                $model->created_at = $created_at;
                                if (!$model->save()) {
                                    $transaction->rollBack();
                                    throw new CHttpException(500, sprintf('Error in saving payment receipt! less than the order amount! %s <br>', json_encode($model->getErrors())));
                                }
                                $po->is_paid = PurchaseOrder::DUE;
                                if (!$po->save(false)) {
                                    $transaction->rollBack();
                                    throw new CHttpException(500, sprintf('Error in saving purchase order! less than the order amount! %s <br>', json_encode($po->getErrors())));
                                }
                                break;
                            }
                        }
                    }

                    // update the payment receipt_cp table is_deleted = 1 by  id
                    $sql = "UPDATE payment_receipt_cp SET is_deleted = 1 WHERE id = :id";
                    $params = [':id' => $dt['id']];
                    Yii::app()->db->createCommand($sql)->execute($params);


                }
                $transaction->commit();
                echo "Data fixed successfully!";
            } catch (PDOException $e) {
                $transaction->rollBack();
                throw new CHttpException(500, $e->getMessage());
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }
        } else {
            echo "No data found!";
        }
    }
}
