<?php

class DiscountTypeController extends Controller
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

    public function actionChangeStatus($id)
    {
        DiscountType::model()->updateAll(array('is_active' => DiscountType::ACTIVE), 'id=:id', array(':id' => $id));
        DiscountType::model()->updateAll(array('is_active' => DiscountType::INACTIVE), 'id!=:id', array(':id' => $id));
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new DiscountType('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DiscountType']))
            $model->attributes = $_GET['DiscountType'];

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
        $model = DiscountType::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'discount-type-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
