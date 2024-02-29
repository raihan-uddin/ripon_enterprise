<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('admin')),
        array('name' => 'Payment', 'url' => array('admin')),
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
if (Yii::app()->user->checkAccess('Accounting.PaymentReceipt.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preview PR</h3>

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
                                  id="basic-addon1">PR No</span>
                        </div>
                        <?php echo $form->textField($model, 'pr_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'pr_no'); ?></span>

                </div>


                <div class="col-md-3">
                    <?php
                    echo CHtml::ajaxLink(
                        "Print", Yii::app()->createUrl('/accounting/paymentReceipt/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                        let pr_no = $('#PaymentReceipt_pr_no').val();
                        if(pr_no == ''){
                        toastr.error('Please insert PR no!');
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
                            'pr_no' => 'js:jQuery("#PaymentReceipt_pr_no").val()',
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
        <h3 class="card-title">Manage Payment Receipt</h3>

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
        <?php $this->widget('ext.groupgridview.GroupGridView', array(
            'id' => 'payment-receipt-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions' => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
            'mergeColumns' => array('date', 'pr_no', 'payment_type', 'order_id', 'supplier_id'),
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
                array(
                    'name' => 'date',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'pr_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'payment_type',
                    'value' => 'PaymentReceipt::model()->paymentTypeString($data->payment_type)',
                    'type' => 'raw',
                    'filter' => CHtml::listData(PaymentReceipt::model()->paymentTypeFilter(), 'id', 'title'),
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'supplier_id',
                    'value' => 'Suppliers::model()->nameOfThis($data->supplier_id)',
                ),
                array(
                    'name' => 'order_id',
                    'value' => 'PurchaseOrder::model()->nameOfThis($data->order_id)',
                ),
                array(
                    'name' => 'bank_id',
                    'value' => 'ComBank::model()->nameOfThis($data->bank_id)',
                ),

                array(
                    'name' => 'cheque_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'cheque_date',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'discount',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'amount',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                'remarks',
                array(
                    'name' => 'created_by',
                    'value' => 'Users::model()->nameOfThis($data->created_by)',
                ),
                'created_at',
                array
                (
                    'header' => 'Options',
                    'template' => '{delete}',
                    'class' => 'CButtonColumn',
                    'htmlOptions' => ['style' => 'width: 200px', 'class' => 'text-center'],
                    'buttons' => array(
                        'delete' => array(
                            'label' => '<i class="fa fa-trash fa-2x" style="color: red;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                        ),
                    )
                ),
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


