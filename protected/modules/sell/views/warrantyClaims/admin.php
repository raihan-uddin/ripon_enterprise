<?php
/* @var $this WarrantyClaimsController */
/* @var $model WarrantyClaims */

$this->breadcrumbs=array(
	'Warranty Claims'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WarrantyClaims', 'url'=>array('index')),
	array('label'=>'Create WarrantyClaims', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#warranty-claims-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Warranty Claims</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'warranty-claims-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'pager' => array(
		'class'          => 'CLinkPager',
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
	'columns'=>array(
		'id',
		'claim_type',
		'claim_date',
		'customer_id',
		'claim_description',
		'claim_status',
		/*
		'resolution_date',
		'resolution_description',
		'total_sp',
		'total_pp',
		'created_by',
		'created_at',
		'updated_by',
		'updatetd_at',
		'is_deleted',
		'business_id',
		'branch_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'htmlOptions' => ['class' => 'actions-cell'],
			'buttons' => array(
				'view' => array(
					'label' => '<i class="fa fa-eye"></i>',
					'imageUrl' => false,
					'options' => array('class' => 'action-btn btn-view', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'View'),
				),
				'update' => array(
					'label' => '<i class="fa fa-pencil-square-o"></i>',
					'imageUrl' => false,
					'options' => array('class' => 'action-btn btn-edit', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Edit'),
				),
				'delete' => array(
					'label' => '<i class="fa fa-trash"></i>',
					'imageUrl' => false,
					'options' => array('class' => 'action-btn btn-delete', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Delete'),
				),
			),
		),
	),
)); ?>

<script>
function goToPage() {
    var page = parseInt($('#goto-page-input').val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update('warranty-claims-grid', { data: { 'warranty-claims-grid_page': page } });
    $('#goto-page-input').val('');
}
$(document).on('keypress', '#goto-page-input', function(e) {
    if (e.which === 13) goToPage();
});
</script>
