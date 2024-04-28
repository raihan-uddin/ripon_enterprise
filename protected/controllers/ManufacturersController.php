<?php

class ManufacturersController extends RController
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
            'rights', // perform access control for CRUD operations
        );
    }

    public function allowedActions()
    {
        return '';
    }

    public function actionCodeOfThis()
    {
        $id = $_POST['manufacturer_id'];

        if ($id != "") {
            $maxProdId = VoucherNoFormate::model()->maxValOfThis('ProdModels', 'id', 'maxProdId');
            $prodId = str_pad($maxProdId, 4, "0", STR_PAD_LEFT);
            //$prodId = str_pad($maxProdId, 5, "0", STR_PAD_LEFT); 

            $code = Manufacturers::model()->codeOfThis($id);

            // this is for UPC-A
//            $prodCodeGenerated = "8" . $code . $prodId;
//            $digits =(string)$prodCodeGenerated;
//            // 1. sum each of the odd numbered digits
//            $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];  
//            // 2. multiply result by three
//            $odd_sum_three = $odd_sum * 3;
//            // 3. add the result to the sum of each of the even numbered digits
//            $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9];
//            $total_sum = $odd_sum_three + $even_sum;
//            // 4. subtract the result from the next highest power of 10
//            $next_ten = (ceil($total_sum/10))*10;
//            $check_digit = $next_ten - $total_sum;
//            $prodCodeGenerated= $digits . $check_digit;

            // this is for EAN-13
            $prodCodeGenerated = "955" . $code . $prodId;
            $digits = (string)$prodCodeGenerated;
            $sequence_ean8 = array(3, 1);
            $sequence_ean13 = array(1, 3);

            $sums = 0;

            foreach (str_split($digits) as $n => $digit) {
                if (strlen($digits) == 7) {
                    $sums += $digit * $sequence_ean8[$n % 2];
                } elseif (strlen($digits) == 12) {
                    $sums += $digit * $sequence_ean13[$n % 2];
                } else {
                    $digits = "code length invalid";
                    $checksum = "";
                }
            }

            $checksum = 10 - $sums % 10;
            if ($checksum == 10) {
                $checksum = 0;
            }
            $prodCodeGenerated = $digits . $checksum;


            echo CJSON::encode(array(
                'generatedCode' => $prodCodeGenerated,
            ));
        } else {
            echo CJSON::encode(array(
                'generatedCode' => '',
            ));
        }
    }

    public function actionCodeOfThisUpdate()
    {
        $id = $_POST['manufacturer_id'];
        $prodId = $_POST['prodId'];
        if ($id != "") {
            $code = Manufacturers::model()->codeOfThis($id);

            // this is for UPC-A
//            $prodCodeGenerated = "8" . $code . $prodId;
//            $digits =(string)$prodCodeGenerated;
//            // 1. sum each of the odd numbered digits
//            $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];  
//            // 2. multiply result by three
//            $odd_sum_three = $odd_sum * 3;
//            // 3. add the result to the sum of each of the even numbered digits
//            $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9];
//            $total_sum = $odd_sum_three + $even_sum;
//            // 4. subtract the result from the next highest power of 10
//            $next_ten = (ceil($total_sum/10))*10;
//            $check_digit = $next_ten - $total_sum;
//            $prodCodeGenerated= $digits . $check_digit;

            // this is for EAN-13
            $prodCodeGenerated = "955" . $code . $prodId;
            $digits = (string)$prodCodeGenerated;
            $sequence_ean8 = array(3, 1);
            $sequence_ean13 = array(1, 3);

            $sums = 0;

            foreach (str_split($digits) as $n => $digit) {
                if (strlen($digits) == 7) {
                    $sums += $digit * $sequence_ean8[$n % 2];
                } elseif (strlen($digits) == 12) {
                    $sums += $digit * $sequence_ean13[$n % 2];
                } else {
                    $digits = "code length invalid";
                    $checksum = "";
                }
            }

            $checksum = 10 - $sums % 10;
            if ($checksum == 10) {
                $checksum = 0;
            }
            $prodCodeGenerated = $digits . $checksum;

            echo CJSON::encode(array(
                'generatedCode' => $prodCodeGenerated,
            ));
        } else {
            echo CJSON::encode(array(
                'generatedCode' => '',
            ));
        }
    }

    public function actionCreateManufacturerFromOutSide()
    {
        $model = new Manufacturers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Manufacturers'])) {
            $model->attributes = $_POST['Manufacturers'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = Manufacturers::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => "<div class='flash-notice'>New Manufacturer successfully added</div>",
                        'value' => $data->id,
                        'label' => $data->manufacturer,
                    ));
                    exit;
                } else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $resultDiv = '';
            echo CJSON::encode(array(
                'status' => 'failure',
                'resultDiv' => $resultDiv,
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
        } else
            $this->render('create', array('model' => $model,));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Manufacturers;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Manufacturers'])) {
            $model->attributes = $_POST['Manufacturers'];
            $valid = $model->validate();
            if ($valid) {
                $model->save();
                //do anything here

                echo CJSON::encode(array(
                    'status' => 'success',
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
                Yii::app()->end();
            }
        } else {
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Manufacturers'])) {
            $model->attributes = $_POST['Manufacturers'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="alert alert-success" role="alert">Successfully updated</div>',
                    ));
                    exit;
                } else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;

            echo CJSON::encode(array(
                'status' => 'failure',
                'content' => $this->renderPartial('_form2', array(
                    'model' => $model), true, true),
            ));
            exit;
        } else
            $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Manufacturers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Manufacturers']))
            $model->attributes = $_GET['Manufacturers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Manufacturers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
