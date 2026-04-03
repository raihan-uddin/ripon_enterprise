<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('')),
        array('name' => 'Config', 'url' => array('admin')),
        array('name' => 'Customers'),
    ),
));
?>

<style>
    /* ── Grid header ── */
    #customers-grid th {
        background: #f0f4f8;
        color: #1a2c3d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        white-space: nowrap;
        padding: 8px 10px;
        border: 1px solid #c8d8e8;
        border-bottom: 2px solid #2c3e50;
    }

    /* ── Filter row inputs ── */
    #customers-grid .filters input,
    #customers-grid .filters select {
        width: 100%;
        font-size: 12px;
        height: 28px;
        padding: 2px 6px;
        border: 1px solid #c8d8e8;
        border-radius: 4px;
        background: #fff;
        color: #212529;
    }

    #customers-grid .filters input:focus,
    #customers-grid .filters select:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 0 2px rgba(23,162,184,0.15);
        outline: none;
    }

    /* ── Grid rows ── */
    #customers-grid td {
        vertical-align: middle;
        font-size: 13px;
        padding: 7px 10px;
    }

    #customers-grid tr:hover td {
        background: #f0f7ff !important;
    }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 6px;
        font-size: 14px;
        margin: 2px;
        text-decoration: none;
        transition: background 0.15s, transform 0.1s, box-shadow 0.1s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .action-btn:hover {
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    .action-btn:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .btn-preview  { background: #e6f4ea; color: #1a7a40; border: 1px solid #a8d5b5; }
    .btn-payment  { background: #e8f4fd; color: #1a6fa3; border: 1px solid #a8cce8; }
    .btn-edit     { background: #fff8e6; color: #8a6200; border: 1px solid #e0c870; }
    .btn-delete   { background: #fdecea; color: #b71c1c; border: 1px solid #e8a8a8; }

    .btn-preview:hover  { background: #c8ecd1; color: #155a2e; }
    .btn-payment:hover  { background: #cce6f8; color: #114e7a; }
    .btn-edit:hover     { background: #ffefc0; color: #6b4a00; }
    .btn-delete:hover   { background: #fad4d0; color: #8b1111; }

    /* ── Actions cell ── */
    .actions-cell {
        white-space: nowrap;
        text-align: center;
        padding: 6px 8px !important;
    }

    /* ── Pagination ── */
    .col-xs-12 .pagination {
        float: right;
        margin: 4px 0;
    }

    .col-xs-12::after {
        content: '';
        display: table;
        clear: both;
    }

    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        font-size: 13px;
        border: 1px solid #c8d8e8;
        border-radius: 5px !important;
        margin: 2px;
        color: #1a6fa3;
        background: #fff;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }

    .pagination li a:hover {
        background: #e8f4fd;
        border-color: #1a6fa3;
        color: #1a6fa3;
    }

    .pagination li.active a,
    .pagination li.active span {
        background: #1a2c3d;
        border-color: #1a2c3d;
        color: #fff;
        font-weight: 700;
    }

    .pagination li.disabled a,
    .pagination li.disabled span {
        color: #aaa;
        border-color: #e0e0e0;
        background: #f8f9fa;
        pointer-events: none;
    }

    /* ── Go to page ── */
    .goto-page-wrap {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    .goto-page-wrap input {
        width: 90px;
        height: 30px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #c8d8e8;
        border-radius: 5px;
        padding: 0 6px;
        color: #1a2c3d;
    }

    .goto-page-wrap input:focus {
        border-color: #17a2b8;
        outline: none;
        box-shadow: 0 0 0 2px rgba(23,162,184,0.15);
    }

    .goto-page-wrap button {
        height: 30px;
        padding: 0 10px;
        font-size: 12px;
        font-weight: 600;
        background: #1a2c3d;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.15s;
    }

    .goto-page-wrap button:hover {
        background: #2c3e50;
    }
</style>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

<?php //echo CHtml::link('<i class="fa fa-users"></i> Manage Contact Persons', array('/sell/customerContactPersons/admin'), array('class' => 'btn btn-warning mb-2')); ?>

<?php
$user = Yii::app()->getUser();
foreach ($user->getFlashKeys() as $key):
    if ($user->hasFlash($key)): ?>
        <div class="alert alert-<?php echo $key; ?> alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-<?php echo ($key === 'success') ? 'check-circle' : 'exclamation-triangle'; ?>" style="margin-right:6px;"></i>
            <?php echo $user->getFlash($key); ?>
        </div>
    <?php
    endif;
endforeach;
?>
<script>
    setTimeout(function () {
        $('.alert.fade.show').fadeOut(600, function () { $(this).remove(); });
    }, 4000);
</script>

<div id="statusMsg"></div>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-users" style="margin-right:6px;"></i>Manage Customers</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php
        $this->widget('ext.groupgridview.GroupGridView', array(
            'id'            => 'customers-grid',
            'dataProvider'  => $model->search(),
            'filter'        => $model,
            'cssFile'       => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions'   => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-bordered dataTable dtr-inline',
            'pager' => array(
                'class'               => 'CLinkPager',
                'cssFile'             => false,
                'header'              => '',
                'firstPageLabel'      => '<i class="fa fa-angle-double-left"></i>',
                'lastPageLabel'       => '<i class="fa fa-angle-double-right"></i>',
                'prevPageLabel'       => '<i class="fa fa-angle-left"></i>',
                'nextPageLabel'       => '<i class="fa fa-angle-right"></i>',
                'maxButtonCount'      => 7,
                'htmlOptions'         => array('class' => 'pagination pagination-sm', 'style' => 'float:right; margin:4px 0;'),
                'selectedPageCssClass' => 'active',
                'hiddenPageCssClass'   => 'disabled',
            ),
            'template'       => "<div class='row' style='text-align:right; margin-bottom:6px;'>{pager}</div>\n{summary}{items}{summary}\n{pager}",
            'summaryText'    => "
                <div style='display:inline-flex; align-items:center; gap:8px; font-size:12px; color:#6c757d; padding:4px 0; flex-wrap:wrap;'>
                    <span style='background:#e8f4fd; color:#1a6fa3; font-weight:700; font-size:11px; padding:2px 10px; border-radius:10px; border:1px solid #b0cfe8; font-family:monospace;'>{start}–{end}</span>
                    <span>of <strong style='color:#1a2c3d;'>{count}</strong> customers</span>
                    <span style='color:#dee2e6;'>|</span>
                    <span style='background:#f0f4f8; color:#4a6278; font-size:11px; font-weight:600; padding:2px 8px; border-radius:8px; border:1px solid #c8d8e8;'>
                        Page {page} of {pages}
                    </span>
                </div>",
            'emptyText'      => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i> No results found.</div>",
            'summaryCssClass' => 'col-sm-12 col-md-6',
            'pagerCssClass'   => 'col-xs-12 text-right',
            'columns' => array(
                array(
                    'name'       => 'id',
                    'htmlOptions' => array('class' => 'text-center', 'style' => 'width:55px;'),
                ),
                array(
                    'name'       => 'company_name',
                    'header'     => 'Company',
                    'htmlOptions' => array('class' => 'text-left'),
                ),
                array(
                    'name'       => 'customer_code',
                    'header'     => 'Code',
                    'htmlOptions' => array('class' => 'text-center', 'style' => 'width:90px;'),
                ),
                array(
                    'name'       => 'owner_person',
                    'header'     => 'Contact',
                    'htmlOptions' => array('class' => 'text-left'),
                ),
                array(
                    'name'       => 'owner_mobile_no',
                    'header'     => 'Mobile',
                    'htmlOptions' => array('class' => 'text-center', 'style' => 'width:120px;'),
                ),
                array(
                    'name'       => 'company_address',
                    'header'     => 'Address',
                    'htmlOptions' => array('class' => 'text-left'),
                ),
                array(
                    'name'       => 'opening_amount',
                    'header'     => 'Opening',
                    'type'       => 'raw',
                    'value'      => 'number_format((float)$data->opening_amount, 2)',
                    'htmlOptions' => array('class' => 'text-right', 'style' => 'width:100px;'),
                ),
                array(
                    'header'     => 'Actions',
                    'class'      => 'CButtonColumn',
                    'template'   => '{update}{customDelete}',
                    'htmlOptions' => array('class' => 'actions-cell', 'style' => 'width:90px;'),
                    'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                    'buttons' => array(
                        'update' => array(
                            'label'    => '<i class="fa fa-pencil-square-o"></i>',
                            'imageUrl' => false,
                            'options'  => array(
                                'class'       => 'action-btn btn-edit',
                                'rel'         => 'tooltip',
                                'data-bs-toggle' => 'tooltip',
                                'title'       => Yii::t('app', 'Edit'),
                            ),
                            'click' => "function(e) {
                                e.preventDefault();
                                $('#update-dialog').children(':eq(0)').empty();
                                updateDialog($(this).attr('href'));
                                $('#update-dialog').dialog({ title: 'Update Customer Info' }).dialog('open');
                            }",
                        ),
                        'customDelete' => array(
                            'label'    => '<i class="fa fa-trash"></i>',
                            'imageUrl' => false,
                            'options'  => array(
                                'class'       => 'action-btn btn-delete',
                                'rel'         => 'tooltip',
                                'data-bs-toggle' => 'tooltip',
                                'title'       => Yii::t('app', 'Delete'),
                            ),
                            'url'   => 'Yii::app()->controller->createUrl("customers/delete", array("id"=>$data->id))',
                            'click' => "function() {
                                if (!confirm('Are you sure you want to delete this customer?')) return false;
                                $.fn.yiiGridView.update('customers-grid', {
                                    type: 'POST',
                                    url: $(this).attr('href'),
                                    success: function(data) {
                                        $('#statusMsg').html(data).fadeIn().animate({opacity:1.0}, 3000).fadeOut('slow');
                                        $.fn.yiiGridView.update('customers-grid');
                                    }
                                });
                                return false;
                            }",
                        ),
                    ),
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
                    <input type="number" id="goto-page-input" class="form-control" min="1" placeholder="Page #"/>
                    <button onclick="goToPage()"><i class="fa fa-arrow-right"></i> Go</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'      => 'update-dialog',
    'options' => array(
        'title'     => 'Update Customer Info',
        'autoOpen'  => false,
        'modal'     => true,
        'width'     => 'auto',
        'resizable' => false,
    ),
));
?>
    <div class="update-dialog-content"></div>
<?php $this->endWidget(); ?>

<?php
$updateJS = CHtml::ajax(array(
    'url'      => "js:url",
    'data'     => "js:form.serialize() + action",
    'type'     => 'post',
    'dataType' => 'json',
    'success'  => "function(data) {
        if (data.status == 'failure') {
            $('#update-dialog div.update-dialog-content').html(data.content);
            $('#update-dialog div.update-dialog-content form input[type=submit]')
                .off().on('click', function(e) {
                    e.preventDefault();
                    updateDialog(false, $(this).attr('name'));
                });
        } else {
            $('#update-dialog div.update-dialog-content').html(data.content);
            if (data.status == 'success') {
                $('div.grid-view').each(function() {
                    $.fn.yiiGridView.update($(this).attr('id'));
                });
            }
            setTimeout(\"$('#update-dialog').dialog('close').children(':eq(0)').empty();\", 1000);
        }
    }"
));
?>

<?php Yii::app()->clientScript->registerScript('updateDialog', "
function updateDialog(url, act) {
    var action = '';
    var form = $('#update-dialog div.update-dialog-content form');
    if (url == false) {
        action = '&action=' + act;
        url = form.attr('action');
    }
    {$updateJS}
}"); ?>

<script>
function goToPage() {
    var page = parseInt($('#goto-page-input').val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update('customers-grid', { data: { 'customers-grid_page': page } });
    $('#goto-page-input').val('');
}
$(document).on('keypress', '#goto-page-input', function(e) {
    if (e.which === 13) goToPage();
});
$(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
