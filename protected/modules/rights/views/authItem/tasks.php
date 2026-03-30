<?php $this->breadcrumbs = array(
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Tasks'),
); ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-tasks"></i> <?php echo Rights::t('core', 'Tasks'); ?></h3>
        <div class="card-tools">
            <?php echo CHtml::link(
                '<i class="fa fa-plus"></i> ' . Rights::t('core', 'New Task'),
                array('authItem/create', 'type' => CAuthItem::TYPE_TASK),
                array('class' => 'btn btn-sm btn-light')
            ); ?>
        </div>
    </div>
    <div class="card-body p-0">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'template'     => '{items}',
            'emptyText'    => Rights::t('core', 'No tasks found.'),
            'htmlOptions'  => array('class' => 'grid-view'),
            'columns'      => array(
                array('name' => 'name',        'header' => Rights::t('core', 'Name'),          'type' => 'raw', 'value' => '$data->getGridNameLink()'),
                array('name' => 'description', 'header' => Rights::t('core', 'Description'),   'type' => 'raw'),
                array('name' => 'bizRule',     'header' => Rights::t('core', 'Business rule'), 'type' => 'raw', 'visible' => Rights::module()->enableBizRule === true),
                array('name' => 'data',        'header' => Rights::t('core', 'Data'),          'type' => 'raw', 'visible' => Rights::module()->enableBizRuleData === true),
                array('header' => '', 'type' => 'raw', 'value' => '$data->getDeleteTaskLink()', 'htmlOptions' => array('class' => 'actions-column', 'style' => 'width:60px;text-align:center')),
            )
        )); ?>
    </div>
    <div class="card-footer">
        <small class="text-muted"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></small>
    </div>
</div>
