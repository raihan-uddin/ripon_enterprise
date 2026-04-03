<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="mb-3">
    <?php echo CHtml::activeListBox($model, 'itemname', $itemnameSelectOptions, array(
        'multiple'         => 'multiple',
        'data-rms'         => '1',
        'data-placeholder' => Rights::t('core', 'Select a role or permission…'),
    )); ?>
    <?php echo $form->error($model, 'itemname', array('class' => 'text-danger', 'style' => 'font-size:12px;margin-top:4px;display:block')); ?>
</div>

<div class="mb-3 mb-0">
    <button type="submit" class="btn btn-success w-100">
        <i class="fas fa-check"></i> <?php echo Rights::t('core', 'Assign'); ?>
    </button>
</div>

<?php $this->endWidget(); ?>
