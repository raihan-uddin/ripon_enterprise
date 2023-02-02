<?php
/* @var $this ExpenseController */
/* @var $model Expense */

$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Expense', 'url' => array('')),
        array('name' => 'Expense', 'url' => array('admin')),
        array('name' => 'Manage'),
    ),
));
//if (Yii::app()->user->checkAccess('Accounting.ExpenseHead.Create')) {
//    echo $this->renderPartial('_form', array('model' => $model));
//}
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
if (Yii::app()->user->checkAccess('Accounting.Expense.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preview Expense</h3>

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
                                  id="basic-addon1">Entry No</span>
                        </div>
                        <?php echo $form->textField($model, 'entry_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'entry_no'); ?></span>

                </div>


                <div class="col-md-3">
                    <?php
                    echo CHtml::ajaxLink(
                        "Print", Yii::app()->createUrl('/accounting/expense/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                        let entry_no = $('#Expense_entry_no').val();
                        if(entry_no == ''){
                        toastr.error('Please insert entry no!');
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
                            'entry_no' => 'js:jQuery("#Expense_entry_no").val()',
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
        <h3 class="card-title">Manage Expense</h3>

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
            'id' => 'expense-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,

            'mergeColumns' => array('date'),
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
//                'id',
//                'max_sl_no',
                array(
                    'name' => 'date',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'entry_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'amount',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'remarks',
                    'htmlOptions' => ['class' => 'text-left']
                ),
//                'is_approved',
                array(
                    'name' => 'created_by',
                    'value' => 'User::model()->nameOfThis($data->created_by)',
                    'htmlOptions' => ['class' => 'text-center'],
                ),
                'created_at',
//                'updated_by',
//                'updated_at',
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
        'title' => Yii::t('user', 'Viewing Single Data'),
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



