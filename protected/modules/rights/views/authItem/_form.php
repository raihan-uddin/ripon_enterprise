<?php $form = $this->beginWidget('CActiveForm', array(
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
)); ?>

<?php if ($model->scenario === 'update'): ?>
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label font-weight-bold">Type</label>
        <div class="col-sm-9 d-flex align-items-center">
            <span class="badge bg-primary" style="font-size:12px;padding:5px 10px;">
                <?php echo Rights::getAuthItemTypeName($model->type); ?>
            </span>
        </div>
    </div>
<?php endif; ?>

<div class="mb-3 row">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-3 col-form-label font-weight-bold')); ?>
    <div class="col-sm-9">
        <?php if ($model->scenario === 'update'): ?>
            <?php echo $form->textField($model, 'name', array(
                'maxlength' => 255,
                'class'     => 'form-control',
                'readonly'  => true,
                'style'     => 'background:#f8f9fa;color:#6c757d;',
            )); ?>
            <small class="form-text text-muted">
                <i class="fas fa-info-circle"></i>
                <?php echo Rights::t('core', 'Do not change the name unless you know what you are doing.'); ?>
            </small>
        <?php else: ?>
            <?php echo $form->textField($model, 'name', array(
                'maxlength'   => 255,
                'class'       => 'form-control',
                'placeholder' => 'e.g. Module.Controller.Action',
            )); ?>
        <?php endif; ?>
        <?php echo $form->error($model, 'name', array('class' => 'text-danger', 'style' => 'font-size:12px;margin-top:4px;')); ?>
    </div>
</div>

<div class="mb-3 row">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-3 col-form-label font-weight-bold')); ?>
    <div class="col-sm-9">
        <?php echo $form->textField($model, 'description', array(
            'maxlength'   => 255,
            'class'       => 'form-control',
            'placeholder' => Rights::t('core', 'A descriptive name for this item.'),
        )); ?>
        <?php echo $form->error($model, 'description', array('class' => 'text-danger', 'style' => 'font-size:12px;margin-top:4px;')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
