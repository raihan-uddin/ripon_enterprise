<?php
/** @var Inventory $model */

$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Inventory', 'url' => array('')),
        array('name' => 'Stock', 'url' => array('admin')),
        array('name' => 'Verify Product'),
    ),
//    'delimiter' => ' &rarr; ',
));


$form = $this->beginWidget('CActiveForm', array(
    'id' => 'verify-items-form',
    'action' => $this->createUrl('inventory/verifyProduct'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Verify Product' : 'Update Entry'); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="form-group col-md-12">
                <?php echo $form->labelEx($model, 'product_sl_no'); ?>
                <div class="input-group" data-target-input="nearest">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-barcode"></i>
                        </div>
                    </div>
                    <input type="text" id="product_sl_no_text" class="form-control">
                    <?php echo $form->hiddenField($model, 'product_sl_no', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                    <div class="input-group-append" onclick="verifyProductSlNo()">
                        <button class="btn btn-outline-primary" type="button">Search</button>

                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'product_sl_no'); ?></span>
            </div>
        </div>
    </div>

    <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
</div>

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<div id="formResult" class="ajaxTargetDiv"></div>
<div id="formResultError" class="ajaxTargetDivErr"></div>
<?php $this->endWidget(); ?>

<script>
    // on page load focus on the input field
    $(document).ready(function () {
        $('#product_sl_no_text').focus();
    });
    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {

            verifyProductSlNo();
            return false;
        }
    });

    function verifyProductSlNo() {
        // clear the error message
        $('#formResultError').html('');

        let product_sl = $('#product_sl_no_text').val();
        if (product_sl.length === 0) {
            toastr.error('Please enter a valid Product SL No.');
            return;
        }
        $('#overlay').fadeIn();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('inventory/verifyProduct') ?>',
            data: {product_sl: product_sl},
            success: function (data) {
                $('#formResult').html(data);
                $('#overlay').fadeOut();
            },
            error: function (data) {
                // add bootstrap alert to the div with id formResultError
                $('#formResultError').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
                    '  <strong>Error!</strong> ' + data.responseText +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>');
                $('#overlay').fadeOut();
            }
        });
        // clear the input field & focus on it
        // $('#product_sl_no_text').val('');
        $('#product_sl_no_text').focus();
    }
</script>
