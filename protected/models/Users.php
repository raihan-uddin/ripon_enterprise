<?php

class Users extends CActiveRecord
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;
    public $password2;
    public $userLevel;
    public $authorized_by;
    public $oldPassword;
    public $roles;
    public $old_password;
    public $new_password;
    public $repeat_password;
    protected $oldAttributes;

    const DEV_SUPERADMIN_ID_ARR = [1];


    public function tableName()
    {
        return 'users';
    }


    //matching the old password with your existing password.

    public function rules()
    {
        return array(
            array('username, password, password2', 'required', 'on' => 'create'),
            array('username', 'required', 'on' => 'update'), //password, password2
            array('id', 'required', 'on' => 'customChange'), //password, password2

            array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
            array('old_password', 'findPasswords', 'on' => 'changePwd'),
            array('repeat_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'changePwd'),

//            array('username, password, password2', 'required'),
            array('username', 'unique', 'caseSensitive' => FALSE, 'message' => 'Username already exist! Please choose another.'),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => "Incorrect symbols (A-z0-9)."),
//            array('username', 'match' ,'pattern'=>'/^[A-Za-z_]+$/u', 'message'=>'Username can contain only alphanumeric characters and hyphens(-).'),
            array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANNED)),
            array('id, employee_id, business_id, branch_id', 'numerical', 'integerOnly' => true),
            array('username, password, password2, old_password, new_password, repeat_password, ', 'length', 'max' => 250, 'min' => 4),
//            array('password', 'compare', 'compareAttribute' => 'password2'),
            array('password', 'compare', 'compareAttribute' => 'password2', 'on' => 'create'),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
//            array('lastvisit_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('id, employee_id, roles,  status, username, password, create_by, create_time, update_by, update_time', 'safe', 'on' => 'search'),
        );
    }

    public function findPasswords($attribute, $params)
    {
        $user = self::model()->findByPk(Yii::app()->user->id);
        if ($user->password != md5($this->old_password)) {
            $this->addError($attribute, 'Old password is incorrect.');
        }
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array();
    }

    public function validatePassword($password)
    {
        return $this->hashPassword($password) === $this->password;
    }

    public function hashPassword($password)
    {
        return md5($password);
    }

    public function beforeSave()
    {
        // set default time zone to asia/dhaka
        date_default_timezone_set('Asia/Dhaka');
        if ($this->password != "") {
            $this->password = $pass = md5($this->password);
            $this->activkey = $apiKey = self::hashPassword($pass);
            $this->apiKey = $apiKey;
        } else {
            $this->password = $this->oldPassword == "" ? $this->password : $this->oldPassword;
        }
        if ($this->activkey == "")
            $this->activkey = $this->password;
        if ($this->apiKey == "")
            $this->apiKey = $this->password;

        if ($this->isNewRecord) {
            $this->create_time = ($this->create_time == "") ? new CDbExpression('NOW()') : $this->create_time;
            $this->create_by = ($this->create_by == "") ? Yii::app()->user->name : $this->create_by;
        } else {
            $this->update_time = new CDbExpression('NOW()');
            $this->update_by = Yii::app()->user->name;
        }
        return parent::beforeSave();
    }

    public function afterFind()
    {
        $this->oldAttributes = $this->attributes;
        return parent::afterFind();
    }

    public function afterSave()
    {
        parent::afterSave();
        if (isset($_POST['roles'])) {
            //assign role
            if ($this->isNewRecord) {
                foreach ($_POST['roles'] as $role) {
                    $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
                    $authorizer->authManager->assign($role, $this->id);
                }
            }
        }
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'userLevel' => 'User Level',
            'employee_id' => 'Employee',
            'username' => 'User Name',
            'password' => 'Password',
            'password2' => 'Repeat Password',
            'create_by' => 'Create By',
            'create_time' => 'Create Time',
            'update_by' => 'Update By',
            'update_time' => 'Update Time',
        );
    }

    public function roleOfThisUser($user_id)
    {
        $roles = Rights::getAssignedRoles($user_id);
        $total = count($roles);
        $i = 1;
        $markup = "";
        foreach ($roles as $key => $role) // for multiple role
        {
            $linkData = "<span class='badge badge-info' >" . $role->description . "</span><br>";
            $markup .= CHtml::link($linkData, array(
                'rights/authItem/update',
                'name' => urlencode($role->name),
            ), array('class' => 'hello', "onMouseOver" => "this.style.color='#0F0'", "onMouseOut" => "this.style.color='#00F'")); //
            if ($total != $i)
                $markup .= "<br>";
            $i++;
        }
        return $markup;
    }

    public function fullEmpInfoOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data) {
            $empInfo = Employees::model()->findByPk($data->employee_id);
            if ($empInfo)
                return $empInfo;
        }
    }

    public function fullNameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data) {
            $empInfo = Employees::model()->findByPk($data->employee_id);
            if ($empInfo)
                return $empInfo->full_name;
        }
    }

    public function userNameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data) {
            return $data->username;
        }
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data) {
            return $data->username;
        }
    }


    public function findAllRolesOfThisUser($id)
    {
        echo "
            <style>
                span.userLevelSpan{
                    color: #FFFFFF;
                    display: block;
                    float: left;
                    height: 100%;
                    padding: 2px;
                    width: 98%;
                }
            </style>
        ";
        if (Rights::getAuthorizer()->isSuperuser($id) === true) {
            $roles = Rights::getAssignedRoles($id);
            foreach ($roles as $role):
                echo "<span class='userLevelSpan' style='background-color: red;'>" . $role->name . "</span><br>";
            endforeach;
        } else {
            $roles = Rights::getAssignedRoles($id);
            foreach ($roles as $role):
                echo "<span class='userLevelSpan' style='background-color: seagreen;'>" . $role->name . "</span><br>";
            endforeach;
        }
    }

    public function allAvailableRoles()
    {
        Yii::import("application.modules.rights.components.dataproviders.RAuthItemDataProvider");
        $all_roles = new RAuthItemDataProvider('roles', array(
            'type' => 2, // type 2 means all roles;
        ));
        $data = $all_roles->fetchData();
        return CHtml::dropDownList("Type", '', CHtml::listData($data, 'name', 'name'), array('prompt' => ''));
    }

    public function allUsersOfAParticularRole($roleName)
    {
        $data_entry_users = Yii::app()->getAuthManager()->getAssignmentsByItemName($roleName);
        $data_entry_users_id = array();
        foreach ($data_entry_users as $id => $assignment):
            $data_entry_users_id[] = $id;
        endforeach;

        return $data_entry_users_id;
    }

    public function getCreatetime()
    {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value)
    {
        $this->create_at = date('Y-m-d H:i:s', $value);
    }

//    public function getLastvisit()
//    {
//        return strtotime($this->lastvisit_at);
//    }
//
//    public function setLastvisit($value)
//    {
//        $this->lastvisit_at = date('Y-m-d H:i:s', $value);
//    }

    public static function superuserStatus($user_id)
    {
        $sql = "SELECT * from AuthAssignment WHERE userid = '$user_id' and itemname = 'Admin'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $rowCount = $command->execute();
        if ($rowCount >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function userDropDownList()
    {
        $criteria = new CDbCriteria();
        $user_id = Yii::app()->user->id;
        if (in_array($user_id, self::DEV_SUPERADMIN_ID_ARR)) {
            // only for developers
        } else {
            $criteria->addNotInCondition('id', self::DEV_SUPERADMIN_ID_ARR);
        }
        $criteria->order = 'username';
        return CHtml::listData(Users::model()->findAll($criteria), "id", "username");

    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("id > 1 ");
        $criteria->compare('id', $this->id);
        $criteria->compare('status', $this->status);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('create_by', $this->create_by, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_by', $this->update_by, true);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 25,
            ),
            'sort' => array(
                'defaultOrder' => 'username ASC',
            ),
        ));
    }

}