<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Change Password");
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Profile', 'url' => array('/user/profile')),
        array('name' => 'Change Password'),
    ),
));
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-5">

        <div class="card shadow-sm" style="border:none; border-radius:16px; overflow:hidden;">
            <div class="card-header text-white"
                 style="background:linear-gradient(135deg,#6366f1,#4338ca); padding:16px 20px;">
                <h5 class="mb-0" style="font-size:15px; font-weight:700;">
                    <i class="fa fa-key mr-2"></i> Change Password
                </h5>
            </div>

            <div class="card-body" style="padding:24px;">

                <?php if (Yii::app()->user->hasFlash('profileMessage')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <i class="fa fa-check-circle mr-1"></i>
                    <?= CHtml::encode(Yii::app()->user->getFlash('profileMessage')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                </div>
                <?php endif; ?>

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id'                   => 'changepassword-form',
                    'enableAjaxValidation' => true,
                    'clientOptions'        => array('validateOnSubmit' => true),
                ));
                ?>

                <?php echo $form->errorSummary($model, null, null, array('class' => 'alert alert-danger', 'style' => 'font-size:13px;')); ?>

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'oldPassword', array('class' => 'control-label')); ?>
                    <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                        <?php echo $form->passwordField($model, 'oldPassword', array(
                            'class'       => 'form-control',
                            'placeholder' => 'Current password',
                            'id'          => 'oldPassword',
                        )); ?>
                            <button type="button" class="btn btn-outline-secondary toggle-pw" data-bs-target="oldPassword" tabindex="-1">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'oldPassword', array('class' => 'text-danger small')); ?>
                </div>

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>
                    <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>
                        <?php echo $form->passwordField($model, 'password', array(
                            'class'       => 'form-control',
                            'placeholder' => 'New password (min 4 characters)',
                            'id'          => 'newPassword',
                        )); ?>
                            <button type="button" class="btn btn-outline-secondary toggle-pw" data-bs-target="newPassword" tabindex="-1">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'password', array('class' => 'text-danger small')); ?>
                </div>

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'verifyPassword', array('class' => 'control-label')); ?>
                    <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-check-circle-o"></i></span>
                        </div>
                        <?php echo $form->passwordField($model, 'verifyPassword', array(
                            'class'       => 'form-control',
                            'placeholder' => 'Repeat new password',
                            'id'          => 'verifyPassword',
                        )); ?>
                            <button type="button" class="btn btn-outline-secondary toggle-pw" data-bs-target="verifyPassword" tabindex="-1">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'verifyPassword', array('class' => 'text-danger small')); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>

            <div class="card-footer d-flex align-items-center justify-content-between"
                 style="background:#f8fafc; padding:14px 20px; border-top:1px solid #f1f5f9;">
                <a href="<?= Yii::app()->createUrl('/user/profile') ?>"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-arrow-left mr-1"></i> Back
                </a>
                <?php echo CHtml::submitButton('Save Password', array(
                    'form'  => 'changepassword-form',
                    'class' => 'btn btn-primary',
                    'style' => 'background:#6366f1; border-color:#6366f1;',
                    'id'    => 'btn-save-password',
                )); ?>
            </div>
        </div>

    </div>
</div>

<script>
$(function(){
    $('.toggle-pw').on('click', function(){
        var $btn    = $(this);
        var target  = $btn.data('target');
        var $field  = $('#' + target);
        var isText  = $field.attr('type') === 'text';
        $field.attr('type', isText ? 'password' : 'text');
        $btn.find('i').toggleClass('fa-eye fa-eye-slash');
    });
});
</script>
