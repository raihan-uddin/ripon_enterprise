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
            'mergeType' => 'nested',
            'pager' => array(
                'cssFile'        => false,
                'header'         => '',
                'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                'lastPageLabel'  => '<i class="fa fa-angle-double-right"></i>',
                'prevPageLabel'  => '<i class="fa fa-angle-left"></i>',
                'nextPageLabel'  => '<i class="fa fa-angle-right"></i>',
                'maxButtonCount' => 7,
                'htmlOptions'    => array('class' => 'pagination pagination-sm', 'style' => 'float:right; margin:4px 0;'),
                'selectedPageCssClass' => 'active',
                'hiddenPageCssClass'   => 'disabled',
            ),
            'template' => "<div class='row' style='text-align:right; margin-bottom:6px;'>{pager}</div>\n{summary}{items}{summary}\n{pager}",
            'summaryText' => "
    <div style='display:inline-flex; align-items:center; gap:8px; font-size:12px; color:#6c757d; padding:4px 0; flex-wrap:wrap;'>
        <span style='background:#e8f4fd; color:#1a6fa3; font-weight:700; font-size:11px; padding:2px 10px; border-radius:10px; border:1px solid #b0cfe8; font-family:monospace;'>{start}–{end}</span>
        <span>of <strong style='color:#1a2c3d;'>{count}</strong> records</span>
        <span style='color:#dee2e6;'>|</span>
        <span style='background:#f0f4f8; color:#4a6278; font-size:11px; font-weight:600; padding:2px 8px; border-radius:8px; border:1px solid #c8d8e8;'>
            Page {page} of {pages}
        </span>
    </div>",
            'summaryCssClass' => 'col-sm-12 col-md-6',
            'pagerCssClass'   => 'col-xs-12 text-right',
            'columns' => array(
                array(
                    'name' => 'date',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 100px;']
                ),
                array(
                    'name' => 'mr_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'payment_type',
                    'header' => 'Col. Type',
                    'value' => 'MoneyReceipt::model()->paymentTypeString($data->payment_type)',
                    'type' => 'raw',
                    'filter' => CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'),
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 70px;']
                ),
                array(
                    'name' => 'customer_id',
                    'value' => 'Customers::model()->nameOfThis($data->customer_id)',
                    'htmlOptions' => ['class' => '', 'style' => 'width: 250px; text-align: left;']
                ),
                array(
                    'name' => 'invoice_id',
                    'header' => 'Invoice',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 80px;']
                ),
                array(
                    'name' => 'amount',
                    'value' => 'number_format($data->amount, 2)',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 80px;']
                ),

                array(
                    'name' => 'discount',
                    'value' => 'number_format($data->discount, 2)',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 80px;']
                ),
                array(
                    'name' => 'remarks',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'created_by',
                    'value' => 'Users::model()->nameOfThis($data->created_by)',
                ),
                'created_at',
                /*
                'updated_by',
                'updated_at',
                */
                array
                (
                    'header' => 'Options',
                    'template' => '{delete}',
                    'class' => 'CButtonColumn',
                    'htmlOptions' => ['class' => 'actions-cell'],
                    'buttons' => array(
                        'delete' => array(
                            'label' => '<i class="fa fa-trash"></i>',
                            'imageUrl' => false,
                            'options' => array('class' => 'action-btn btn-delete', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                        ),
                    )
                ),
            ),
        )); ?>
    </div>
    <div class="card-footer" style="background:#f8f9fa; padding:8px 16px;">
        <div class="row" style="align-items:center;">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6 text-right">
                <div class="goto-page-wrap" style="justify-content:flex-end;">
                    <span>Go to page</span>
                    <input type="number" id="goto-page-input-money-receipt-grid" class="form-control" min="1" placeholder="Page #"/>
                    <button onclick="goToPage('money-receipt-grid')"><i class="fa fa-arrow-right"></i> Go</button>
                </div>
            </div>
        </div>
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

<script>
function goToPage(gridId) {
    var page = parseInt($('#goto-page-input-' + gridId).val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update(gridId, { data: { [gridId + '_page']: page } });
    $('#goto-page-input-' + gridId).val('');
}
$(document).on('keypress', '[id^="goto-page-input-"]', function(e) {
    if (e.which === 13) goToPage($(this).attr('id').replace('goto-page-input-', ''));
});
</script>
