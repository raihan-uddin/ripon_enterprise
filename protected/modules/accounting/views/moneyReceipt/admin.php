<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Collection', 'url' => array('admin')),
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
if (Yii::app()->user->checkAccess('Accounting.MoneyReceipt.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preview MR</h3>

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
                                  id="basic-addon1">MR No</span>
                        </div>
                        <?php echo $form->textField($model, 'mr_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'mr_no'); ?></span>

                </div>


                <div class="col-md-3">
                    <?php
                    echo CHtml::ajaxLink(
                        "Print", Yii::app()->createUrl('/accounting/moneyReceipt/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                        let mr_no = $('#MoneyReceipt_mr_no').val();
                        if(mr_no == ''){
                        toastr.error('Please insert MR no!');
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
                            'mr_no' => 'js:jQuery("#MoneyReceipt_mr_no").val()',
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
        <h3 class="card-title">Manage Money Receipt</h3>

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
            'id' => 'money-receipt-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions' => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
            'mergeColumns' => array('date', 'mr_no', 'payment_type', 'invoice_id', 'customer_id'),
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
                    'name' => 'mr_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'payment_type',
                    'value' => 'MoneyReceipt::model()->paymentTypeString($data->payment_type)',
                    'type' => 'raw',
                    'filter' => CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'),
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'customer_id',
                    'value' => 'Customers::model()->nameOfThis($data->customer_id)',
                ),
                array(
                    'name' => 'invoice_id',
                    'value' => 'SellOrder::model()->nameOfThis($data->invoice_id)',
                ),
                array(
                    'name' => 'bank_id',
                    'value' => 'CrmBank::model()->nameOfThis($data->bank_id)',
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


