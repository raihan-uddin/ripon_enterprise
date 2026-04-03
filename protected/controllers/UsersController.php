<?php

class UsersController extends RController
{

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    private $_model;

    public function filters()
    {
        return array(
            'rights
            -jquery_userSearch', // perform access control for CRUD operations
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


    public function actionMakeSuperAdmin($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            try {
                $user_id = (int)$id;
                $sql = "INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES ('Admin', :user_id, NULL, 'N;');";
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $rowCount = $command->execute();
                if ($rowCount > 0) {
                    Yii::app()->user->setFlash('success', 'This user is now superadmin!');
                    echo "<div class='flash-success'>Deleted Successfully</div>"; //for ajax
                } else {
                    Yii::app()->user->setFlash('error', 'Please try again!');
                    echo "<div class='flash-error'>Please try again</div>"; //for ajax
                }
            } catch (CDbException $e) {
                Yii::app()->user->setFlash('error', 'Please try again!');
                echo "<div class='flash-error'>Please try again</div>"; //for ajax
            }
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionRevokeSuperAdmin($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // Stop jQuery from re-initialization
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            try {
                $user_id = (int)$id;
                $sql = "DELETE FROM AuthAssignment WHERE itemname ='Admin' AND userid = :user_id";
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $rowCount = $command->execute();
                if ($rowCount > 0) {
                    Yii::app()->user->setFlash('success', 'This user is now not a superadmin!');
                    echo "<div class='flash-success'>Deleted Successfully</div>"; //for ajax
                } else {
                    Yii::app()->user->setFlash('error', 'Please try again!');
                    echo "<div class='flash-error'>Please try again</div>"; //for ajax
                }
            } catch (CDbException $e) {
                Yii::app()->user->setFlash('error', 'Please try again!');
                echo "<div class='flash-error'>Please try again</div>"; //for ajax
            }
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
        $this->backup_Database1();
    }

    function backup_Database1()
    {
        // USE YII'S DB CONNECTION INSTEAD OF HARDCODED CREDENTIALS
        $db = Yii::app()->db;
        $con = $db->getPdoInstance();
        $DbName = preg_match('/dbname=([^;]+)/', $db->connectionString, $m) ? $m[1] : '';
        // GET ALL TABLES
        $tables = array();
        $result = $con->query('SHOW TABLES');
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        $data = '';
        foreach ($tables as $table) {
            $result = $con->query('SELECT * FROM `' . $table . '`');
            $num_fields = $result->columnCount();
            $data .= 'DROP TABLE IF EXISTS `' . $table . '`;';
            $row2 = $con->query('SHOW CREATE TABLE `' . $table . '`')->fetch(PDO::FETCH_NUM);
            $data .= "\n\n" . $row2[1] . ";\n\n";

            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $data .= 'INSERT INTO `' . $table . '` VALUES(';
                for ($x = 0; $x < $num_fields; $x++) {
                    if (isset($row[$x])) {
                        $row[$x] = addslashes($row[$x]);
                        $row[$x] = $this->clean($row[$x]);
                        $data .= '"' . $row[$x] . '"';
                    } else {
                        $data .= 'NULL';
                    }
                    if ($x < ($num_fields - 1)) {
                        $data .= ',';
                    }
                }
                $data .= ");\n";
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

    public function actionJquery_userSearch()
    {
        $search_prodName = trim($_POST['q']);

        $criteria2 = new CDbCriteria();
        $criteria2->compare('username', $search_prodName, true);

        $criteria = new CDbCriteria();
        $criteria->mergeWith($criteria2);

        $criteria->order = "username asc";
        $criteria->limit = 20;
        $users = User::model()->findAll($criteria);
        if ($users) {
            foreach ($users as $user) {
                $value = "$user->username";
                $label = "$user->username";
                $id = $user->id;

                $results[] = array(
                    'id' => $id,
                    'name' => $value,
                    'value' => $value,
                    'label' => $label,
                );
            }
        } else {
            $results[] = array(
                'id' => '',
                'name' => 'No data found!',
                'value' => 'No data found!',
                'label' => 'No data found!',
            );
        }
        echo json_encode($results);
    }

}
