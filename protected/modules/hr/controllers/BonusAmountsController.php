<?php

class BonusAmountsController extends RController {

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
    
    public function actionStatusChangedHistory($id){
        $condition="bonus_amount_id=".$id;
        $data=  BonusStatusHistory::model()->findAll(array('condition'=>$condition), 'id');
        if($data){
            echo "<table class='summaryTab'>";
            echo "<tr><td>STATUS</td><td>CHANGED BY</td><td>DATE</td></tr>";
            foreach($data as $d):
                echo "<tr>";
                echo "<td>";
                BonusAmounts::model()->statusColorIsAproved($d->status);
                echo "</td>";
                echo "<td style='text-align: left'>".Users::model()->fullNameOfThis($d->status_changed_by)."</td>";
                echo "<td>".$d->status_changed_time."</td>";
                echo "<tr>";
            endforeach;
            echo "</table>";
        }
    }


    public function actionApprove($id){
        BonusAmounts::model()->updateByPk($id, array('is_approved'=>  BonusAmounts::APPROVED));
        $model=new BonusStatusHistory;
        $model->bonus_amount_id=$id;
        $model->status=BonusAmounts::APPROVED;
        $model->status_changed_by=Yii::app()->user->getId();
        $model->status_changed_time= new CDbExpression('NOW()');
        $model->save();
        echo "Application approved.";
    }
	
    public function actionDeny($id){
        BonusAmounts::model()->updateByPk($id, array('is_approved'=>  BonusAmounts::DENIED));
        $model=new BonusStatusHistory;
        $model->bonus_amount_id=$id;
        $model->status=  BonusAmounts::DENIED;
        $model->status_changed_by=Yii::app()->user->getId();
        $model->status_changed_time= new CDbExpression('NOW()');
        $model->save();
        echo "Application denied.";
    }


    public function actionCreate() {
        $model = new BonusAmounts;
		$this->performAjaxValidation($model);

        if (isset($_POST['BonusAmounts'])) {
            $model->attributes = $_POST['BonusAmounts'];
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

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['BonusAmounts'])) {
            $model->attributes = $_POST['BonusAmounts'];
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

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('BonusAmounts');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new BonusAmounts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BonusAmounts']))
            $model->attributes = $_GET['BonusAmounts'];

		$this->pageTitle = 'BONUS SETUP';
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
        $model = BonusAmounts::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bonus-amounts-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
