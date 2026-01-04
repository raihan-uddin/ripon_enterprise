<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Quotation', 'url' => array('admin')),
        array('name' => 'Manage'),
    ),
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
if (Yii::app()->user->checkAccess('Sell.SellOrderQuotation.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preview Draft</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
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
                                id="basic-addon1">Draft No</span>
                        </div>
                        <?php /** @var mixed $model */
                        echo $form->textField($model, 'so_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
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
                            SellOrderQuotation::NORMAL_ORDER_PRINT => 'NORMAL PRINT',
                            SellOrderQuotation::NORMAL_PAD_PRINT => 'PAD PRINT',
                            SellOrderQuotation::DELIVERY_CHALLAN_PRINT => 'CHALLAN PRINT',
                        ], array('class' => 'form-control',));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'print_type'); ?></span>

                </div>


                <div class="col-md-3 col-sm-12">
                    <?php
                    echo CHtml::ajaxLink(
                        "Print", Yii::app()->createUrl('/sell/sellOrderQuotation/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                            let so_no = $('#SellOrderQuotation_so_no').val();
                            let dateRange = $('#daterange-picker').val();
                            if(so_no == '' && dateRange == ''){
                                toastr.error('Please insert so no or select date range!');
                                return false;
                            }
                            $('#overlay').fadeIn(300);　 
                        }",
                        'success' => "function( data ){
                            if(data.status=='error'){
                                toastr.error('No data found!');
                            } else {
                                $('#information-modal').modal('show');
                                $('#information-modal .modal-body').html(data);    
                            }      
                            $('#overlay').fadeOut(300);　                                                         
                        }",
                        'complete' => "function(){
                            $('#overlay').fadeOut(300);　      
                        }",
                        'data' => array(
                            'so_no' => 'js:jQuery("#SellOrderQuotation_so_no").val()',
                            'preview_type' => 'js:jQuery("#SellOrderQuotation_print_type").val()',
                            'date_range' => 'js:jQuery("#daterange-picker").val()',
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
        <h3 class="card-title">Manage Draft</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
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
            'mergeColumns' => array( 'date'),
            'template' => "{pager}\n\n{summary}{items}{summary}\n{pager}",
            'summaryText' => "<div class='dataTables_info' role='status' aria-live='polite'><p>Displaying {start}-{end} of {page} result(s)</p></div>",
            'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i>No results found.</div>",
            'summaryCssClass' => 'col-sm-12 col-md-5',
            'pagerCssClass' => 'col-sm-12 col-md-7 pager',
            'columns' => array(
                'id',
                array(
                    'name' => 'date',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'so_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'customer_id',
                    'value' => 'Customers::model()->nameOfThis($data->customer_id)',
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
                'created_at',
                'updated_at',
                array
                (
                    'header' => '',
                    'htmlOptions' => array('style' => 'width:20px; text-align: center;', 'class' => 'text-center'),
                    'template' => '{singleInvoice}',
                    'class' => 'CButtonColumn',
                    'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                    'buttons' => array(
                        'singleInvoice' => array(
                            'label' => '<i class="fa fa-file-pdf-o fa-2x" style="color: green; cursor: pointer; "></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Preview Invoice')),
                            // Remove the 'url' attribute
                            'click' => "function() {
                                // Get the invoice ID
                                var invoiceId = $(this).closest('tr').find('td:first').text();
                                // Send a POST request to the controller action
                                $.post('" . Yii::app()->controller->createUrl('voucherPreview') . "', { invoiceId: invoiceId })
                                    .done(function(data) {
                                        $('#ajaxLoaderView').hide();  
                                         $('#information-modal').modal('show');
                                              $('#information-modal .modal-body').html(data);   
                                    })
                                    .fail(function(xhr) {
                                         // Parse the error message from the server response
                                        var errorMessage = xhr.responseText;
                                        // Show toaster message with the error
                                        toastr.error('Error: ' + errorMessage);
                                    });
                                return false; // Prevent the default link behavior
                            }",
                        ),
                    )
                ),
                array
                (
                    'header' => 'Options',
                    'template' => '{delete}', //{update}
                    'class' => 'CButtonColumn',
                    'htmlOptions' => ['style' => 'width: 200px', 'class' => 'text-center'],
                    'buttons' => array(
                        'update' => array(
                            'label' => '<i class="fa fa-pencil-square-o fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                        ),
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

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>


<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
