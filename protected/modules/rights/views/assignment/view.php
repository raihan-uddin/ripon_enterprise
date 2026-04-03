<?php $this->breadcrumbs = array(
    'Rights'                 => Rights::getBaseUrl(),
    Rights::t('core', 'Assignments'),
); ?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-users"></i> <?php echo Rights::t('core', 'Assignments'); ?></h3>
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width:220px;">
                <input type="text" id="search" class="form-control" placeholder="Search users…">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'template'     => "{pager}\n{summary}\n{items}\n{pager}",
            'emptyText'    => Rights::t('core', 'No users found.'),
            'htmlOptions'  => array('class' => 'grid-view assignment-table'),
            'columns'      => array(
                array('name' => 'name',        'header' => Rights::t('core', 'Name'),       'type' => 'raw', 'value' => '$data->getAssignmentNameLink()', 'filter' => array('1' => 'Active', '0' => 'Inactive')),
                array('name' => 'assignments', 'header' => Rights::t('core', 'Roles'),      'type' => 'raw', 'value' => '$data->getAssignmentsText(CAuthItem::TYPE_ROLE)'),
                array('name' => 'assignments', 'header' => Rights::t('core', 'Tasks'),      'type' => 'raw', 'value' => '$data->getAssignmentsText(CAuthItem::TYPE_TASK)'),
                array('name' => 'assignments', 'header' => Rights::t('core', 'Operations'), 'type' => 'raw', 'value' => '$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)'),
            )
        )); ?>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#search').on('keyup', function () {
        var text = $(this).val().replace(/\//g, '.');
        $('.items tbody tr').hide();
        $('.items tbody tr:contains("' + text + '")').show();
    });
});
$.expr[':'].contains = $.expr.createPseudo(function (arg) {
    return function (elem) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});
</script>
