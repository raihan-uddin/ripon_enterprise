<?php

class EmployeesController extends Controller
{

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function filters()
    {
        return array(
            'rights
            -JqueryEmpSearch
            -Upload', // perform access control for CRUD operations
        );
    }

    public function allowedActions()
    {
        return '';
    }


    public function actionUpload()
    {

        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $pathImage = Yii::getPathOfAlias('webroot') . '/uploads/empPhoto/';
        if (!is_dir($pathImage)) {
            mkdir($pathImage, 0777, true);
        }
        $folder = 'uploads/empPhoto/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "png",); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 2 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME

        echo $return; // it's array
    }

    public function actionUploadFiles()
    {

        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $pathImage = Yii::getPathOfAlias('webroot') . '/uploads/empFiles/';
        if (!is_dir($pathImage)) {
            mkdir($pathImage, 0777, true);
        }
        $folder = 'uploads/empFiles/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "png", "pdf"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME

        echo $return; // it's array
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->renderPartial('view', array('model' => $model,));
        if (!isset($_GET['ajax'])) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function loadModel($id)
    {
        $model = Employees::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionView2($id)
    {
        $this->pageTitle = 'TERMINATION LETTER';
        $this->render('view2', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model = new Employees;
        if (isset($_POST['Employees'])) {
            $model->attributes = $_POST['Employees'];
            $valid = $model->validate();
            if ($valid) {
                if ($model->save()) {

                    $employeeId = $model->id;
                    echo CJSON::encode(array(
                        'status' => 'success',
                    ));
                    Yii::app()->end();
                    $this->redirect(array('admin'));
                }
            }
        } else {
            $this->pageTitle = 'ADD EMPLOYEE';
            $this->render('_form', array(
                'model' => $model,
            ));
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['Employees'])) {
            $model->attributes = $_POST['Employees'];
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->pageTitle = 'UPDATE EMPLOYEE';
        $this->render('_form2', array(
            'model' => $model,
        ));
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employees-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

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

    public function actionAdmin()
    {
        $model = new Employees('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employees']))
            $model->attributes = $_GET['Employees'];

        $this->pageTitle = 'EMPLOYEE MANAGE';
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionJqueryEmpSearch()
    {
        $empName = trim($_POST['empName']);
        $results = array();
        $criteria2 = new CDbCriteria();
        $criteria2->compare("full_name", $empName, true, "OR");
        $criteria2->compare("emp_id_no", $empName, true, "OR");

        $criteria = new CDbCriteria();
        $criteria->select = 'id, full_name, id_no, emp_id_no, contact_no';
        $criteria->mergeWith($criteria2);
        $empModel = Employees::model()->findAll($criteria);
        if ($empModel) {
            foreach ($empModel as $emp) {
                $value = $emp->id;
                $contact = $emp->contact_no;
                $label = $emp->full_name . ' || ' . $emp->emp_id_no;
                $results[] = array('value' => $value, 'label' => $label, 'contact' => $contact);
            }
        } else {
            $results[] = array('value' => 0, 'label' => 'no data available', 'contact' => 0);
        }

        echo json_encode($results);
    }

}
