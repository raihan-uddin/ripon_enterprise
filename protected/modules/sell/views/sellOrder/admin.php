<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Order', 'url' => array('admin')),
        array('name' => 'Manage'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('prod-items-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
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
if (Yii::app()->user->checkAccess('Sell.Order.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preview Order</h3>

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
                <div class="col-md-2 col-sm-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="basic-addon1">SO No</span>
                        </div>
                        <?php echo $form->textField($model, 'so_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'so_no'); ?></span>

                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="basic-addon1">PRINT</span>
                        </div>
                        <?php
                        echo $form->dropDownList(
                            $model, 'print_type', [
                            SellOrder::NORMAL_ORDER_PRINT => 'NORMAL PRINT',
                            SellOrder::NORMAL_PAD_PRINT => 'PAD PRINT',
//                            SellOrder::PRODUCTION_ORDER_PRINT => 'PRODUCTION ORDER',
//                            SellOrder::ORDER_BOM => 'JOB CARD',
                        ], array('class' => 'form-control',));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'print_type'); ?></span>

                </div>


                <div class="col-md-3 col-sm-12">
                    <?php
                    echo CHtml::ajaxLink(
                        "Print", Yii::app()->createUrl('/sell/sellOrder/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                        let so_no = $('#SellOrder_so_no').val();
                        if(so_no == ''){
                        toastr.error('Please insert so no!');
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
                            'so_no' => 'js:jQuery("#SellOrder_so_no").val()',
                            'preview_type' => 'js:jQuery("#SellOrder_print_type").val()',
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
        <h3 class="card-title">Manage Order</h3>

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
            'id' => 'sell-order-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions' => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
            'mergeColumns' => array('order_type', 'date'),
//            'loadingCssClass' => 'fa fa-spinner fa-spin fa-2x',
            'pager' => array(            //  pager like twitter bootstrap
                'htmlOptions' => array('class' => 'pagination  justify-content-end'),
                'header' => '',
                'cssFile' => false,
                'maxButtonCount' => 10,
                'selectedPageCssClass' => 'page-item active', //default "selected"
                'nextPageCssClass' => 'page-item',//default "next"
                'hiddenPageCssClass' => 'page-item disabled',//default "hidden"
                'firstPageCssClass' => 'page-item previous', //default "first"\
                'lastPageCssClass' => 'page-item last', //default "last"
                'internalPageCssClass' => 'page-item',//default "page"
                'previousPageCssClass' => 'page-item',//default "previours"\
                'firstPageLabel' => '<<',
                'lastPageLabel' => '>>',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
//                'footer'=>'End',//defalut empty
            ),
            'template' => "{pager}\n\n{summary}{items}{summary}\n{pager}",
            'summaryText' => "<div class='dataTables_info' role='status' aria-live='polite'><p>Displaying {start}-{end} of {page} result(s)</p></div>",
            'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i>No results found.</div>",
            'summaryCssClass' => 'col-sm-12 col-md-5',
            'pagerCssClass' => 'col-sm-12 col-md-7 pager',
            'columns' => array(
//                'id',
                array(
                    'name' => 'order_type',
                    'value' => 'SellOrder::model()->orderType($data->order_type)',
                    'type' => 'raw',
                    'filter' => [SellOrder::NEW_ORDER => 'NEW ORDER', SellOrder::REPAIR_ORDER => 'REPLACE ORDER']
                ),
                array(
                    'name' => 'date',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'so_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                /* array(
                     'name' => 'job_no',
                     'htmlOptions' => ['class' => 'text-center']
                 ),*/
                array(
                    'name' => 'customer_id',
                    'value' => 'Customers::model()->nameOfThis($data->customer_id)',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                /* array(
                     'name' => 'discount_percentage',
                     'htmlOptions' => ['class' => 'text-center']
                 ),
                 array(
                     'name' => 'discount_amount',
                     'htmlOptions' => ['class' => 'text-center']
                 ),
                 */
                array(
                    'name' => 'vat_percentage',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'delivery_charge',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'vat_amount',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'discount_amount',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'grand_total',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'total_paid',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'total_due',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'is_paid',
                    'filter' => [Invoice::PAID => 'PAID', Invoice::DUE => 'DUE'],
                    'value' => 'SellOrder::model()->isPaid($data->is_paid)',
                    'type' => 'raw',
                    'htmlOptions' => ['class' => 'text-center']

                ),
                /* array(
                     'name' => 'bom_complete',
                     'value' => 'SellOrder::model()->bomStatus($data->bom_complete)',
                     'type' => 'raw',
                     'filter' => [SellOrder::BOM_COMPLETE => 'COMPLETE', SellOrder::BOM_NOT_COMPLETE => 'NOT COMPLETE'],
                     'htmlOptions' => ['class' => 'text-center']
                 ),*/
                /*array(
                    'name' => 'is_job_card_done',
                    'value' => 'SellOrder::model()->jobStatus($data->is_job_card_done)',
                    'type' => 'raw',
                    'filter' => [SellOrder::JOB_CARD_DONE => 'STARTED', SellOrder::JOB_CARD_NOT_DONE => 'NOT STARTED']
                ),*/
                /*
                'is_invoice_done',
                'is_job_card_done',
                'is_delivery_done',
                'is_partial_delivery',
                'is_partial_invoice',
                'created_by',
                'created_at',
                'updated_by',
                'updated_at',
                */
                array
                (
                    'header' => '',
                    'htmlOptions' => array('style' => 'width:20px'),
                    'template' => '{singleInvoice}',
                    'class' => 'CButtonColumn',
                    'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                    'buttons' => array(
                        'singleInvoice' => array(
                            'label' => '<i class="fa fa-file-pdf-o fa-2x" style="color: green; cursor: pointer; "></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Preview Invoice')),
                            'url' => 'Yii::app()->controller->createUrl("singlePreview",array("id"=>$data->id))',
                            'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('sell-order-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $('#AjFlash').html(data).show();
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                        ),
                    )
                ),
                array
                (
                    'header' => 'Options',
                    'template' => '{createMr}{update}{delete}',
                    'class' => 'CButtonColumn',
                    'htmlOptions' => ['style' => 'width: 200px', 'class' => 'text-center'],
                    'buttons' => array(
                        'createMr' => array(
                            'label' => '<i class="fa fa-money fa-2x" style="color: green;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Create MR')),
                            'url' => 'Yii::app()->controller->createUrl("/accounting/moneyReceipt/create",array("id"=>$data->customer_id, "sell_id"=>$data->id))',
                            'visible' => '$data->total_paid == 0 ? TRUE : FALSE',
                        ),
                        'update' => array(
                            'label' => '<i class="fa fa-pencil-square-o fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                            'visible' => '$data->total_paid == 0 ? TRUE : FALSE',
                        ),
                        'delete' => array(
                            'label' => '<i class="fa fa-trash fa-2x" style="color: red;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                            'visible' => '($data->total_paid == 0) ? TRUE : FALSE',
                        ),
                    )
                ),
            ),
        )); ?>

    </div>
</div>

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
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
