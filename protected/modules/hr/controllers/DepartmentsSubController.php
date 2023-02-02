<?php

class DepartmentsSubController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function filters() {
        return array(
            'rights-SubCatOfThisCat',
        );
    }

    public function allowedActions() {
        return '';
    }
    
    public function actionSubCatOfThisCat() {
        $catId = $_POST['catId'];
        $subCatList = '';
        
        if ($catId != '') {
            $condition = 'department_id = ' . $catId . ' ORDER BY id DESC';
            $data = DepartmentsSub::model()->findAll(array("condition" => $condition,), "id");
            
            if ($data) {
                $subCatList = CHtml::tag('option', array('value' => ''), 'Select', true);
                foreach ($data as $d) {
                    $subCatList .= CHtml::tag('option', array('value' => $d->id), CHtml::encode($d->title), true);
                }
            } else {
                $subCatList = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        } else {
            $data = DepartmentsSub::model()->findAll();
            if($data){
                $subCatList = CHtml::tag('option', array('value' => ""), "Select", true);
                foreach ($data as $d) {
                    $subCatList .= CHtml::tag('option', array('value' => $d->id), CHtml::encode($d->title), true);
                }
            }else {
                $subCatList = CHtml::tag('option', array('value' => ''), CHtml::encode("NULL"), true);
            }
        }
        echo CJSON::encode(array(
            'subCatList' => $subCatList,
        ));
    }


    public function actionCreateSectionSubFromOutSide() {
        $model = new DepartmentsSub;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DepartmentsSub'])) {
            $model->attributes = $_POST['DepartmentsSub'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    $data = DepartmentsSub::model()->findByPk($model->id);
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'div' => '<div class="alert alert-success">Successfully created!</div>',
                        'value' => $data->id,
                        'label' => $data->title,
                    ));
                    exit;
                }
                else
                    $this->redirect(array('admin'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'status' => 'failure',
                'div' => $this->renderPartial('_form2', array('model' => $model), true)));
            exit;
        }
        else
            $this->render('create', array('model' => $model,));
    }

    public function actionCreate() {
        $model = new DepartmentsSub;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DepartmentsSub'])) {
            $model->attributes = $_POST['DepartmentsSub'];
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

        if (isset($_POST['DepartmentsSub'])) {
            $model->attributes = $_POST['DepartmentsSub'];
            if ($model->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    // Stop jQuery from re-initialization
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;

                    echo CJSON::encode(array(
                        'status' => 'success',
                        'content' => '<div class="alert alert-success">Successfully updated! </div>',
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

	public function actionDelete($id){
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('DepartmentsSub');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin(){
		$model=new DepartmentsSub('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DepartmentsSub']))
			$model->attributes=$_GET['DepartmentsSub'];

        $this->pageTitle = 'SUB-DEPARTMENT';
        $this->render('admin', array(
            'model' => $model,
        ));
	}

	public function loadModel($id){
		$model=DepartmentsSub::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='departments-sub-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
