<?php $this->breadcrumbs = array(
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Create :type', array(':type' => Rights::getAuthItemTypeName($_GET['type']))),
); ?>

<div class="row">
    <div class="col-md-7">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-plus-circle"></i>
                    <?php echo Rights::t('core', 'Create :type', array(':type' => Rights::getAuthItemTypeName($_GET['type']))); ?>
                </h3>
            </div>
            <div class="card-body">
                <?php $this->renderPartial('_form', array('model' => $formModel)); ?>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" form="yw0">
                    <i class="fa fa-save"></i> <?php echo Rights::t('core', 'Save'); ?>
                </button>
                <?php echo CHtml::link(
                    Rights::t('core', 'Cancel'),
                    Yii::app()->user->rightsReturnUrl,
                    array('class' => 'btn btn-secondary')
                ); ?>
            </div>
        </div>
    </div>
</div>

<script>
/* Submit the CActiveForm (id=yw0) when footer buttons are clicked */
$(document).on('click', '.card-footer .btn-primary', function(e) {
    e.preventDefault();
    $('form').first().submit();
});
</script>
