<?php
$this->breadcrumbs = array(
    'Rights' => Rights::getBaseUrl(),
    Rights::getAuthItemTypeNamePlural($model->type) => Rights::getAuthItemRoute($model->type),
    $model->name,
);
?>

<div class="row">
    <div class="col-md-6">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-pencil"></i>
                    <?php echo Rights::t('core', 'Update :name', array(':name' => $model->name)); ?>
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
                    array('class' => 'btn btn-default')
                ); ?>
            </div>
        </div>

    </div>
    <div class="col-md-6">

        <?php if ($model->name !== Rights::module()->superuserName): ?>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-sitemap"></i> <?php echo Rights::t('core', 'Relations'); ?></h3>
                </div>
                <div class="card-body">

                    <?php if ($childFormModel !== null): ?>
                        <h6 class="text-muted text-uppercase font-weight-bold" style="font-size:11px;letter-spacing:.5px;margin-bottom:10px;">
                            <i class="fa fa-plus"></i> <?php echo Rights::t('core', 'Add Child'); ?>
                        </h6>
                        <?php $this->renderPartial('_childForm', array(
                            'model'                => $childFormModel,
                            'itemnameSelectOptions' => $childSelectOptions,
                        )); ?>
                    <?php else: ?>
                        <p class="text-muted" style="font-size:13px;">
                            <?php echo Rights::t('core', 'No children available to be added to this item.'); ?>
                        </p>
                    <?php endif; ?>

                    <h6 class="text-muted text-uppercase font-weight-bold" style="font-size:11px;letter-spacing:.5px;margin:18px 0 10px;">
                        <i class="fa fa-arrow-down"></i> <?php echo Rights::t('core', 'Children'); ?>
                    </h6>
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $childDataProvider,
                        'template'     => '{items}',
                        'hideHeader'   => true,
                        'emptyText'    => Rights::t('core', 'This item has no children.'),
                        'htmlOptions'  => array('class' => 'grid-view mini'),
                        'columns'      => array(
                            array('name' => 'name', 'type' => 'raw', 'value' => '$data->getNameLink()', 'htmlOptions' => array('class' => 'name-column')),
                            array('name' => 'type', 'type' => 'raw', 'value' => '$data->getTypeText()', 'htmlOptions' => array('class' => 'type-column')),
                            array('type' => 'raw', 'value' => '$data->getRemoveChildLink()', 'htmlOptions' => array('class' => 'actions-column')),
                        )
                    )); ?>

                    <h6 class="text-muted text-uppercase font-weight-bold" style="font-size:11px;letter-spacing:.5px;margin:18px 0 10px;">
                        <i class="fa fa-arrow-up"></i> <?php echo Rights::t('core', 'Parents'); ?>
                    </h6>
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $parentDataProvider,
                        'template'     => '{items}',
                        'hideHeader'   => true,
                        'emptyText'    => Rights::t('core', 'This item has no parents.'),
                        'htmlOptions'  => array('class' => 'grid-view mini'),
                        'columns'      => array(
                            array('name' => 'name', 'type' => 'raw', 'value' => '$data->getNameLink()', 'htmlOptions' => array('class' => 'name-column')),
                            array('name' => 'type', 'type' => 'raw', 'value' => '$data->getTypeText()', 'htmlOptions' => array('class' => 'type-column')),
                            array('type' => 'raw', 'value' => '""', 'htmlOptions' => array('class' => 'actions-column')),
                        )
                    )); ?>

                </div>
            </div>

        <?php else: ?>

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-info-circle"></i> <?php echo Rights::t('core', 'Relations'); ?></h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">
                        <?php echo Rights::t('core', 'No relations need to be set for the superuser role.'); ?><br>
                        <?php echo Rights::t('core', 'Super users are always granted access implicitly.'); ?>
                    </p>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<script>
$(document).on('click', '.card-footer .btn-primary', function(e) {
    e.preventDefault();
    $('form').first().submit();
});
</script>
