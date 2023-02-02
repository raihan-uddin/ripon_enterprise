<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Inventory', 'url' => array('admin')),
        array('name' => 'Issue', 'url' => array('admin')),
        array('name' => 'Manage'),
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
<?php
if (Yii::app()->user->checkAccess('Inventory.JobCardIssue.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preview Issue</h3>

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

            <?php $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
            )); ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="basic-addon1">Issue No</span>
                        </div>
                        <?php echo $form->textField($model, 'issue_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'issue_no'); ?></span>

                </div>


                <div class="col-md-3">
                    <?php
                    echo CHtml::ajaxLink(
                        "Print", Yii::app()->createUrl('/inventory/jobCardIssue/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                        let issue_no = $('#JobCardIssue_issue_no').val();
                        if(issue_no == ''){
                        toastr.error('Please insert issue no!');
                            return false;
                        }
                        $('#overlay').fadeIn(300);　 
                     }",
                        'success' => "function( data ){
                        if(data.status=='error'){
                            toastr.error('No data found!');
                        } else {
                         $('#viewDialog').dialog('open');   
                         $('#AjFlash').html(data).show();    
                        }      
                        $('#overlay').fadeOut(300);　                                                         
                    }",
                        'complete' => "function(){
                        $('#overlay').fadeOut(300);　      
                    }",
                        'data' => array(
                            'issue_no' => 'js:jQuery("#JobCardIssue_issue_no").val()',
                            'printOrPreview' => 'print',
                        )
                    ), array(
                            'class' => 'btn btn-info',
                        )
                    );
                    ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
}
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Manage Job Card Issue</h3>

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

        <div class="card-body">
            <?php $this->widget('ext.groupgridview.GroupGridView', array(
                'id' => 'job-card-issue-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'table-responsive grid-view'),
                'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
                'mergeColumns' => array('date', 'order_id', 'customer_id', 'job_no',),
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
//                'id',
                    'date',
                    array(
                        'name' => 'order_id',
                        'value' => 'SellOrder::model()->nameOfThis($data->order_id)',
                    ),
                    array(
                        'name' => 'customer_id',
                        'value' => 'Customers::model()->nameOfThis($data->customer_id)',
                    ),
                    array(
                        'name' => 'job_no',
                        'htmlOptions' => ['class' => 'text-center']
                    ),
                    array(
                        'name' => 'issue_no',
                        'htmlOptions' => ['class' => 'text-center']
                    ),

//                    'remarks',
//                'is_paid',
                    array(
                        'name' => 'created_by',
                        'value' => 'Users::model()->nameOfThis($data->created_by)',
                    ),
                    'created_at',
                    /*
                    'updated_by',
                    'updated_at',
                    */
                    /*array(
                        'class' => 'CButtonColumn',
                    ),*/
                ),
            )); ?>
        </div>
    </div>


    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'viewDialog',
        'options' => array(
            'title' => Yii::t('user', 'Viewing Issue Data'),
            'autoOpen' => false,
            'modal' => true,
            'width' => 'auto',
            'resizable' => false,
        ),
    ));
    ?>
    <div id="ajaxLoaderView" style="display: none;"><img
                src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></div>
    <div id='AjFlash' style="display:none; margin-top: 20px;">

    </div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


