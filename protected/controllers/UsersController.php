<?php

class UsersController extends Controller
{

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    private $_model;

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


    public function actionCreate()
    {
        $model = new Users('create');
        $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->status = Users::STATUS_ACTIVE;
            if (isset($_POST['Users']['employee_id']) && $_POST['Users']['employee_id'] != '') {
                $model->employee_id = $_POST['Users']['employee_id'];
            } else {
                $model->employee_id = 0;
            }
            $valid = $model->validate();
            if ($valid) {
                $model->save();
                //do anything here
                echo CJSON::encode(array(
                    'status' => 'success'
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

    public function actionUpdate()
    {
        $model = $this->loadModel();
        $this->performAjaxValidation($model);
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
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

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            //Yii::app()->user->isSuperuser;  OR Rights::getAuthorizer()->isSuperuser(Yii::app()->user->getId());
            if (Rights::getAuthorizer()->isSuperuser($id) === true) {
                echo "<div class='flash-error'>Can not delete Super User! You can only change the info.</div>"; //for ajax
            } else {
                $this->loadModel()->delete();
            }
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    public function actionAdmin()
    {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }
        $this->pageTitle = "USER MANAGE";
        $this->render('admin', array(
            'model' => $model,
        ));
    }


    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = Users::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDbBackup()
    {
        $this->backup_Database1('localhost', 'root', 'OF1YKK4HxtLSFUtF', 'erp');
        //$this->backup_Database1('localhost', 'root', 'OF1YKK4HxtLSFUtF', 'erp');
    }

    function backup_Database1($hostName, $userName, $password, $DbName)
    {
        // CONNECT TO THE DATABASE
        $con = mysqli_connect($hostName, $userName, $password) or die(mysqli_error());
        mysqli_select_db($DbName, $con) or die(mysqli_error());
        $tables = '*';
        // GET ALL TABLES
        if ($tables == '*') {
            $tables = array();
            $result = mysqli_query('SHOW TABLES');
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        $data = '';
        foreach ($tables as $table) {
            $result = mysqli_query('SELECT * FROM ' . $table) or die(mysqli_error());
            $num_fields = mysqli_num_fields($result) or die(mysqli_error());
            $data .= 'DROP TABLE IF EXISTS ' . $table . ';';
            $row2 = mysqli_fetch_row(mysqli_query('SHOW CREATE TABLE ' . $table));
            $data .= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $data .= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($x = 0; $x < $num_fields; $x++) {
                        $row[$x] = addslashes($row[$x]);
                        $row[$x] = $this->clean($row[$x]);
                        if (isset($row[$x])) {
                            $data .= '"' . $row[$x] . '"';
                        } else {
                            $data .= '""';
                        }
                        if ($x < ($num_fields - 1)) {
                            $data .= ',';
                        }
                    }
                    $data .= ");\n";
                }
            }
            $data .= "\n\n\n";
        }
        date_default_timezone_set("Asia/Dhaka");
        $backup_name = 'db_backup' . date('Y-m-d @ h-i-s') . '.sql';
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
        echo $data;
        //exit;
    }


    function clean($str)
    {
        if (@isset($str)) {
            $str = @trim($str);
            if (get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        } else {
            return 'NULL';
        }
    }

}
