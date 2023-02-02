<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo Yii::app()->baseUrl; ?>" class="h1"><b>ADMIN</b>PANEL</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="input-group mb-3">
                <?php echo $form->textField($model, 'username', ['placeholder' => 'Username', 'class' => 'form-control']); ?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <div style="color: red; width: 100%"> <?php echo $form->error($model, 'username'); ?></div>
            </div>
            <div class="input-group mb-3">
                <?php echo $form->passwordField($model, 'password', ['placeholder' => 'Password', 'class' => 'form-control']); ?>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <div style="color: red; width: 100%"> <?php echo $form->error($model, 'password'); ?></div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <?php echo CHtml::submitButton('Sign In', ['class' => 'btn btn-primary btn-block']); ?>
                </div>
                <!-- /.col -->
            </div>

            <?php $this->endWidget(); ?>

            <p class="mb-1">
                <a href="<?php echo Yii::app()->baseUrl; ?>">I forgot my password</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
