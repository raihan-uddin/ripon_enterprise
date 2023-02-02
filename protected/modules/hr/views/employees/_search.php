<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'full_name'); ?>
        <?php echo $form->textField($model, 'full_name', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'designation_id'); ?>
        <?php echo $form->textField($model, 'designation_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'department_id'); ?>
        <?php echo $form->textField($model, 'department_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'contact_no'); ?>
        <?php echo $form->textField($model, 'contact_no', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'address'); ?>
        <?php echo $form->textArea($model, 'address', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->