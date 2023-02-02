<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sell-price-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<script>
    $(document).ready(function () {
        $("#SellPrice_model_id").css("background-color", "#EEEEEE");
        $("#SellPrice_model_id").focus(function () {
            $(this).blur();
        });
    });
</script>
<?php
$model->model_id = $modelId;
$modelName = CHtml::encode(ProdModels::model()->modelName($model->model_id));
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add Sell Price' : 'Update Sell Price'); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <!--            <button type="button" class="btn btn-tool" data-card-widget="remove">-->
            <!--                <i class="fa fa-times"></i>-->
            <!--            </button>-->
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <div class=" col-xs-12 col-sm-12 col-lg-12">
                <?php echo $form->labelEx($model, 'model_id'); ?>
                <?php echo $form->hiddenField($model, 'model_id');
                echo $modelName; ?>

            <span class="help-block"
                  style="color: red; width: 100%"> <?php echo $form->error($model, 'model_id'); ?></span>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-12">
            <?php echo $form->labelEx($model, 'sell_price'); ?>
            <?php echo $form->textField($model, 'sell_price', array('maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="help-block"
                  style="color: red; width: 100%"> <?php echo $form->error($model, 'sell_price'); ?></span>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-12">
            <?php echo $form->labelEx($model, 'discount'); ?>
            <?php echo $form->textField($model, 'discount', array('maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="help-block"
                  style="color: red; width: 100%"> <?php echo $form->error($model, 'discount'); ?></span>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <?php echo $form->labelEx($model, 'is_active'); ?>
            <?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active'), ['class' => 'form-control']); ?>
            <span class="help-block"
                  style="color: red; width: 100%"> <?php echo $form->error($model, 'is_active'); ?></span>
        </div>
    </div>
</div>


<div class="card-footer">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'btn btn-primary btn-md')); ?>
    <span id="ajaxLoaderMR2" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR2").show();
    }

</script>
</div>

<?php $this->endWidget(); ?>
