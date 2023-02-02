<div class="form span-12 first">

    <?php if ($model->scenario === 'update'): ?>

        <h3><?php echo Rights::getAuthItemTypeName($model->type); ?></h3>

    <?php endif; ?>
    <div style="height: 20px; width: 100%;"></div>
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'name', array('style' => 'text-align: left;')); ?>
        <?php
        if ($model->scenario === 'update')
            echo $form->textField($model, 'name', array('maxlength' => 255, 'class' => 'text-field form-control', 'readonly' => true));
        else
            echo $form->textField($model, 'name', array('maxlength' => 255, 'class' => 'text-field  form-control'));
        ?>
        <?php echo $form->error($model, 'name'); ?>
        <small class="form-text text-muted"><?php echo Rights::t('core', 'Do not change the name unless you know what you are doing.'); ?></small>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'description', array('style' => 'text-align: left;')); ?>
        <?php echo $form->textField($model, 'description', array('maxlength' => 255, 'class' => 'text-field  form-control')); ?>
        <?php echo $form->error($model, 'description'); ?>
        <small class="form-text text-muted"><?php echo Rights::t('core', 'A descriptive name for this item.'); ?></small>
    </div>

    <?php /*if (Rights::module()->enableBizRule === true): */ ?><!--

        <div class="row">
            <?php /*echo $form->labelEx($model, 'bizRule', array('style' => 'text-align: left;')); */ ?>
            <?php /*echo $form->textField($model, 'bizRule', array('maxlength' => 255, 'class' => 'text-field')); */ ?>
            <?php /*echo $form->error($model, 'bizRule'); */ ?>
            <p class="hint"><?php /*echo Rights::t('core', 'Code that will be executed when performing access checking.'); */ ?></p>
        </div>

    --><?php /*endif; */ ?>

    <?php /*if (Rights::module()->enableBizRule === true && Rights::module()->enableBizRuleData): */ ?><!--

        <div class="row">
            <?php /*echo $form->labelEx($model, 'data', array('style' => 'text-align: left;')); */ ?>
            <?php /*echo $form->textField($model, 'data', array('maxlength' => 255, 'class' => 'text-field')); */ ?>
            <?php /*echo $form->error($model, 'data'); */ ?>
            <p class="hint"><?php /*echo Rights::t('core', 'Additional data available when executing the business rule.'); */ ?></p>
        </div>

    --><?php /*endif; */ ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Rights::t('core', 'Save'), ['class' => 'btn btn-success']); ?>
        | <?php echo CHtml::link(Rights::t('core', 'Cancel'), Yii::app()->user->rightsReturnUrl, ['class' => 'btn btn-primary', 'style' => 'color:white']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>