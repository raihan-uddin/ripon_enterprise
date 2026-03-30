<?php $this->breadcrumbs = array(
    'Rights'                          => Rights::getBaseUrl(),
    Rights::t('core', 'Assignments') => array('assignment/view'),
    $model->getName(),
); ?>

<div class="row">

    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-shield"></i>
                    <?php echo Rights::t('core', 'Assignments for :username', array(':username' => $model->getName())); ?>
                </h3>
            </div>
            <div class="card-body p-0">
                <?php $this->widget('ext.groupgridview.GroupGridView', array(
                    'dataProvider' => $dataProvider,
                    'template'     => '{items}',
                    'hideHeader'   => true,
                    'emptyText'    => Rights::t('core', 'This user has not been assigned any items.'),
                    'htmlOptions'  => array('class' => 'grid-view mini'),
                    'columns'      => array(
                        array('name' => 'name', 'type' => 'raw', 'value' => '$data->getNameText()',             'htmlOptions' => array('class' => 'name-column')),
                        array('name' => 'type', 'type' => 'raw', 'value' => '$data->getTypeText()',             'htmlOptions' => array('class' => 'type-column')),
                        array('type' => 'raw',  'value' => '$data->getRevokeAssignmentLink()', 'htmlOptions' => array('class' => 'actions-column', 'style' => 'width:80px;text-align:center')),
                    )
                )); ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-plus-circle"></i> <?php echo Rights::t('core', 'Assign item'); ?></h3>
            </div>
            <div class="card-body">
                <?php if ($formModel !== null): ?>
                    <?php $this->renderPartial('_form', array(
                        'model'                => $formModel,
                        'itemnameSelectOptions' => $assignSelectOptions,
                    )); ?>
                <?php else: ?>
                    <p class="text-muted mb-0" style="font-size:13px;">
                        <?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
