<?php

class AhAmountProllController extends RController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    public function allowedActions() {
        return '';
    }

    
    public function actionActiveAmountOfThis(){
        $percentageAmount = $_POST['percentageAmount'];
        $percentageAmountOf = $_POST['percentageAmountOf'];
        if($percentageAmount!="" && $percentageAmountOf!=""){
            $criteria=new CDbCriteria();
            $criteria->select="amount_adj";
            $criteria->condition="is_active=".AhAmountProll::ACTIVE." AND ah_proll_id=".$percentageAmountOf;
            $data=AhAmountProll::model()->findAll($criteria);
            if($data){
                foreach($data as $d):
                    $adjAmount=$d->amount_adj;
                endforeach;
                $adjAmount=($percentageAmount/100)*$adjAmount;
            }else{
                $adjAmount="";
            }
            
            echo CJSON::encode(array(
                'adjAmount' => $adjAmount,
            ));
        }else{
            echo CJSON::encode(array(
                'adjAmount' => '',
            ));
        }
    }
    
    public function actionCreate() {
        $model = new AhAmountProll;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['AhAmountProll'])) {
            $model->attributes = $_POST['AhAmountProll'];
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
        }else {
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
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
            // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['AhAmountProll'])) {
            $model->attributes = $_POST['AhAmountProll'];
                if ($model->save()) {
                    if (Yii::app()->request->isAjaxRequest) {
                        // Stop jQuery from re-initialization
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                        echo CJSON::encode(array(
                            'status' => 'success',
                            'content' => '<div class="flash-notice">successfully updated</div>',
                        ));
                        exit;
                    }
                    else
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
        }
        else
            $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('AhAmountProll');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AhAmountProll('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AhAmountProll']))
            $model->attributes = $_GET['AhAmountProll'];

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
        $model = AhAmountProll::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ah-amount-proll-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
