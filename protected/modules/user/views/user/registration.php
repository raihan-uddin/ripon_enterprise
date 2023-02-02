<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>
	.employee-registration{
		background: rgba(61,141,188,0.2);
		padding: 50px 0px 50px 50px;
		margin: 100px auto;
		border-radius: 50px;
		border: 2px solid #ccc;
	} 
	.employee-registration label{
		text-transform: capitalize;
	}
</style>

<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
	$this->breadcrumbs=array(
		UserModule::t("Registration"),
	);
?>



<div class="container">
	<div class="row">
		<div class="col-md-12 employee-registration">

		<div class="col-sm-10 col-sm-offset-2">
			<h3><?php echo UserModule::t("Employee Registration"); ?></h3>

			<p>
				<?php if(Yii::app()->user->hasFlash('registration')): ?>
					<div class="success">
				<?php echo Yii::app()->user->getFlash('registration'); ?>
					</div>
				<?php else: ?>
			</p>
		</div>

		<div class="form form-horizontal">

			<?php $form=$this->beginWidget('UActiveForm', array(
				'id'=>'registration-form',
				'enableAjaxValidation'=>true,
				'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
				'htmlOptions' => array('enctype'=>'multipart/form-data'),
			)); ?>

			<div class="col-sm-10 col-sm-offset-2">
				<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
				<?php echo $form->errorSummary(array($model,$profile)); ?>
			</div>

			

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">
					<?php echo $form->labelEx($model,'username'); ?>
				</label>
				<div class="col-sm-10">
					<?php echo $form->textField($model,'username'); ?>
					<?php echo $form->error($model,'username'); ?>
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">
					<?php echo $form->labelEx($model,'password'); ?>
				</label>
				<div class="col-sm-10">
					<?php echo $form->passwordField($model,'password'); ?>
					<?php echo $form->error($model,'password'); ?>					
				</div>
				<div class="col-sm-10 col-sm-offset-2">
					<p class="hint">
						<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
					</p>
				</div>	
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">
					<?php echo $form->labelEx($model,'verifyPassword'); ?>
				</label>
				<div class="col-sm-10">
					<?php echo $form->passwordField($model,'verifyPassword'); ?>
					<?php echo $form->error($model,'verifyPassword'); ?>
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">
					<?php echo $form->labelEx($model,'email'); ?>
				</label>
				<div class="col-sm-10">
					<?php echo $form->textField($model,'email'); ?>
					<?php echo $form->error($model,'email'); ?>
				</div>
			</div>


			<?php 
				$profileFields=$profile->getFields();
				if ($profileFields) {
					foreach($profileFields as $field) {
					?>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">
								<?php echo $form->labelEx($profile,$field->varname); ?>
							</label>
							<div class="col-sm-10">
								<?php 
									if ($widgetEdit = $field->widgetEdit($profile)) {
										echo $widgetEdit;
									} elseif ($field->range) {
										echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
									} elseif ($field->field_type=="TEXT") {
										echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
									} else {
										echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
									}
								?>
								<?php echo $form->error($profile,$field->varname); ?>
							</div>
						</div>
						<?php
					}
				}
			?>

			<?php if (UserModule::doCaptcha('registration')): ?>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">
						<?php echo $form->labelEx($model,'verifyCode'); ?>
					</label>
					<div class="col-sm-10">
						<?php $this->widget('CCaptcha'); ?>						
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
					<?php echo $form->textField($model,'verifyCode'); ?>
						<?php echo $form->error($model,'verifyCode'); ?>						
						<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
						<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
					</div>
				</div>
			<?php endif; ?>

			<div class="col-sm-10 col-sm-offset-2">
				<div class="submit">
					<?php echo CHtml::submitButton(UserModule::t("Register")); ?>
					<?php //echo CHtml::link('Login',array('site/login')); ?>
				</div>
			</div>

			<?php $this->endWidget(); ?>
		</div ><!-- form -->

		</div>
	</div>
</div>

<?php endif; ?>


<style>
    /* .emp-reg{
        text-align: left;
    } */
    .submit a{
        background-color:#3366CC;
        margin:auto;
        padding: 3px 15px !important;
        border: 2px solid #9B59B6;
        color: #FFF;
    }
</style>