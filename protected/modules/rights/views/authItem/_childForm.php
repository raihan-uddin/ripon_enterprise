<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="form-group mb-2">
    <?php echo CHtml::activeListBox($model, 'itemname', $itemnameSelectOptions, array(
        'multiple'         => 'multiple',
        'data-rms'         => '1',
        'data-placeholder' => Rights::t('core', 'Select an item…'),
    )); ?>
    <?php echo $form->error($model, 'itemname', array('class' => 'text-danger', 'style' => 'font-size:12px;margin-top:4px;display:block')); ?>
</div>

<div class="form-group mb-0">
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fa fa-plus"></i> <?php echo Rights::t('core', 'Add Child'); ?>
    </button>
</div>

<?php $this->endWidget(); ?>
