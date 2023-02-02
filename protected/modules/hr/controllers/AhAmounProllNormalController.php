<?php

class AhAmounProllNormalController extends RController {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function allowedActions() {
        return '';
    }

    public function actionAmountOfThis() {
        $percentageAmount = $_POST['percentageAmount'];
        $percentageAmountOf = $_POST['percentageAmountOf'];
        if ($percentageAmount != "" && $percentageAmountOf != "") {
            $criteria = new CDbCriteria();
            $criteria->select = "amount_adj";
            $criteria->condition = "ah_proll_normal_id=" . $percentageAmountOf;
            $data = AhAmounProllNormal::model()->findAll($criteria);
            if ($data) {
                foreach ($data as $d):
                    $adjAmount = $d->amount_adj;
                endforeach;
                $adjAmount = ($percentageAmount / 100) * $adjAmount;
            }else {
                $adjAmount = "";
            }

            echo CJSON::encode(array(
                'adjAmount' => $adjAmount,
            ));
        } else {
            echo CJSON::encode(array(
                'adjAmount' => '',
            ));
        }
    }
   
    public function actionCreate() {
        $model = new AhAmounProllNormal;
        $this->performAjaxValidation($model);
        
        if (isset($_POST['AhAmounProllNormal'])) {
            $model->attributes = $_POST['AhAmounProllNormal'];
            //$model->setScenario('requiredScenario');
            //$valid = $model->validate();
            $status = 'Error! Could not save data.';
            //if ($valid)
                {
                if (isset($_POST['AhAmounProllNormal']['ah_proll_normal_id']) && $_POST['AhAmounProllNormal']['ah_proll_normal_id'] != "") {
                    $i = 0;
                    $duplicate = 0;
                    $newsave = 0;
                    //print_r($_POST);die;
                    foreach ($_POST['AhAmounProllNormal']['ah_proll_normal_id'] as $tempCAid):
                        $model = new AhAmounProllNormal;
                        $model->employee_id = $employee_id = $_POST['AhAmounProllNormal']['employee_id'];
                        $model->ah_proll_normal_id = $ah_proll_normal_id = $tempCAid;
                        $model->amount_adj = $_POST['AhAmounProllNormal']['amount_adj'][$i];
                        $model->earn_deduct_type = $_POST['AhAmounProllNormal']['earn_deduct_type'][$i];
                        //$model->percentage_of_ah_proll_normal_id = $_POST['AhAmounProllNormal']['temp_percentage_of_ah_proll_normal_id'][$i];
                        //$model->start_from = $_POST['AhAmounProllNormal']['start_from'][$i];
                        //$model->end_to = $_POST['AhAmounProllNormal']['temp_end_to'][$i];
                        $model->is_active = $_POST['AhAmounProllNormal']['is_active'][$i];
                        if($_POST['AhAmounProllNormal']['effective_month'][$i]){
                            $model->effective_month = date('Y-m', strtotime($_POST['AhAmounProllNormal']['effective_month'][$i]));
                        }                        
                        $criteria2 = new CDbCriteria();
                        $criteria2->select = "id";
                        $criteria2->addColumnCondition(array("employee_id" => $employee_id, "ah_proll_normal_id" => $ah_proll_normal_id), "AND", "AND");
                        $data2 = AhAmounProllNormal::model()->count($criteria2);
                        if ($data2 > 0) {
                            $duplicate++;
                        } else {
                            $model->save();
                            $newsave++;
                        }
                        $i++;
                    endforeach;

                    if ($duplicate > 0) {
                        $status = $duplicate . ' duplicate data found and ' . $newsave . ' new data save.';
                    } else {
                        $status = 'success';
                    }
                }
            }

            echo CJSON::encode(array(
                'status' => $status,
            ));
            Yii::app()->end();
        } else {
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    public function actionCreatef() {
        $model = new AhAmounProllNormal;
        $this->performAjaxValidation($model);

        if (isset($_POST['AhAmounProllNormal'])) {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $model->attributes = $_POST['AhAmounProllNormal'];
            
             if (isset($_POST['AhAmounProllNormal']['ah_proll_normal_id']) && $_POST['AhAmounProllNormal']['ah_proll_normal_id'] != "") {
                $modelPS = new AhAmounProllNormal;
                $valid = $modelPS->validate();
                if ($valid) {
                    $i = 0;
                    $employee_id = $_POST['AhAmounProllNormal']['employee_id'];
                    if (is_array($_POST['AhAmounProllNormal']['ah_proll_normal_id']) || is_object($_POST['AhAmounProllNormal']['ah_proll_normal_id'])) {
                        foreach ($_POST['AhAmounProllNormal']['ah_proll_normal_id'] as $tempCAid){
                           $modelPS = new AhAmounProllNormal;
                            $modelPS->employee_id = $employee_id;
                            $modelPS->ah_proll_normal_id = $ah_proll_normal_id = $tempCAid;
                            $modelPS->amount_adj = $_POST['AhAmounProllNormal']['amount_adj'][$i];
                            $modelPS->earn_deduct_type = $_POST['AhAmounProllNormal']['earn_deduct_type'][$i];
                            $modelPS->start_from = $_POST['AhAmounProllNormal']['start_from'][$i];
                            $modelPS->is_active = $_POST['AhAmounProllNormal']['is_active'][$i];
                            $modelPS->save();
                            $i++;
                        }
                        echo CJSON::encode(array(
                            'status' => 'success',
                        ));
                        Yii::app()->end();
                    }
                    else {
                        echo CJSON::encode(array(
                            'status' => 'errorBalance',
                        ));
                        Yii::app()->end();
                    }
                } else {
                    $error = CActiveForm::validate($model);
                    if ($error != '[]')
                        echo $error;
                    $this->render('admin', array(
                        'model' => $model,
                    ));
                }
            } else {
                echo CJSON::encode(array(
                    'status' => 'errorBalance',
                ));
                Yii::app()->end();
            }
        } else {
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }
    
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['AhAmounProllNormal'])) {
            $model->attributes = $_POST['AhAmounProllNormal'];
            if($_POST['AhAmounProllNormal']['effective_month']){
                $model->effective_month = date('Y-m', strtotime($_POST['AhAmounProllNormal']['effective_month']));
            } 
            $model->setScenario('requiredScenario');
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="flash-notice">successfully updated</div>',
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

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('AhAmounProllNormal');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new AhAmounProllNormal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AhAmounProllNormal']))
            $model->attributes = $_GET['AhAmounProllNormal'];


        $this->pageTitle = 'SALARY SETUP';
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AhAmounProllNormal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ah-amoun-proll-normal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
