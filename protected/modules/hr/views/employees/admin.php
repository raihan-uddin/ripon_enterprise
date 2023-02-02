<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'HR', 'url' => array('')),
        array('name' => 'Config', 'url' => array('admin')),
        array('name' => 'Employee Manage'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>


<?php
$user = Yii::app()->getUser();
foreach ($user->getFlashKeys() as $key):
    if ($user->hasFlash($key)): ?>
        <div class="alert alert-<?php echo $key; ?> alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $user->getFlash($key); ?>
        </div>
    <?php
    endif;
endforeach;
?>


<div id="statusMsg"></div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Manage Employees</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <!--<button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fa fa-times"></i>
            </button>-->
        </div>
    </div>
    <div class="card-body">
        <?php
        $this->widget('ext.groupgridview.GroupGridView', array(
            'id' => 'employees-grid',
            'dataProvider' => $model->search(),
            'mergeColumns' => array('department_id'),
            'filter' => $model,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions' => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
//            'loadingCssClass' => 'fa fa-spinner fa-spin fa-2x',
            'pager' => array(            //  pager like twitter bootstrap
                'htmlOptions' => array('class' => 'pagination  justify-content-end'),
//                'header'=>'',
//                'cssFile'=>false,
//                'maxButtonCount'=>24,
//                'selectedPageCssClass'=>'active',
//                'hiddenPageCssClass'=>'disabled',
//                'firstPageCssClass'=>'previous',
//                'lastPageCssClass'=>'next',
//                'firstPageLabel'=>'<<',
//                'lastPageLabel'=>'>>',
//                'prevPageLabel'=>'<',
//                'nextPageLabel'=>'>',
            ),
//            'template' => "{pager}{summary}{items}{summary}{pager}",
            'columns' => array(
                array(
                    'name' => 'id',
                    'header' => 'SL',
                    'value' => '++$row',
                    'filter' => ''
                ),
                /*
                array(
                    'class' => 'EImageColumn',
                    'name' => 'photo',
                    'htmlOptions' => array('style' => 'width: 70px; height:70px;'),
                    'alt' => 'Employee-Photo',
                    'pathPrefix' => Yii::app()->request->baseUrl . '/upload/empPhoto/',
                ),*/
                'emp_id_no',
                'full_name',
                'contact_no',
                'address',
                'join_date',
                'email',
                //'opening_balance',
                //'monthly_installment',
                //'national_id_no',
                //'contact_no_office',
                /*
                  array(
                    'name' => 'blood_group',
                    'value' => 'Lookup::item("blood_group", $data->blood_group)',
                    'filter' => Lookup::items('blood_group'),
                ),
                array(
                    'name' => 'religion',
                    'value' => 'Lookup::item("religion", $data->religion)',
                    'filter' => Lookup::items('religion'),
                ),*/
                array(
                    'name' => 'is_active',
                    'value' => 'Employees::model()->statusColor($data->is_active)',
                    'filter' => Lookup::items('is_active'),
                ),
                array
                (
                    'header' => 'Options',
                    'template' => '{update}',
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'label' => '<i class="fa fa-pencil-square-o fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                        ),
                        'delete' => array(
                            'label' => 'Termination Letter',
                            'imageUrl' => Yii::app()->theme->baseUrl . '/images/termination_letter.png',
                            'url' => 'Yii::app()->controller->createUrl("delete",array("id"=>$data->id))',
                            'options' => array("target" => "_blank"),
                        ),
                    )
                ),
            )
        ));
        ?>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'viewDialog',
    'options' => array(
        'title' => 'Viewing Single Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => '1200',
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderView" style="display: none;"><img
            src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></div>
<div id='AjFlash' style="display:none; margin-top: 20px;">

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

