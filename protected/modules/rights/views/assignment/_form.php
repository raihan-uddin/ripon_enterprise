<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>
	
	<div class="row">
		<?php //echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
        <?php
        $this->widget('ext.select2.ESelect2', [
            'model' => $model,
            'attribute' => 'itemname',
            'data' => $itemnameSelectOptions,
            'options' => [
            //    'placeholder' => 'Select Depot',
                'width' => '600',
                'allowClear' => true,
            ],
        ]);
        ?>
		<?php echo $form->error($model, 'itemname'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton(Rights::t('core', 'Assign')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>