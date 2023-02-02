<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<div style="width:800px; margin: 200px auto 0 auto; text-align: center;">
    <img style="position: inherit; width: 80%" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png"/>
</div>
<div style="width:800px; margin: 0 auto; text-align: center; margin-top:1%;">
    <h1 style="font-family: serif; color: #008B8B">Globe Pharmaceuticals Group of Companies</h1>
</div>
<div style="width:400px; margin: 0 auto; text-align: center">
    <fieldset style="margin-top: 30px;padding-top: 10px;">
        <div class="formelement">
            <table style="float: left; width: 100%;font-size:13px">
                <tr>
                    <td><label><?php echo $form->labelEx($model, 'username'); ?></label></td>
                    <td><?php echo $form->textField($model, 'username'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'username'); ?></td>
                </tr>
                <tr>
                    <td><label><?php echo $form->labelEx($model, 'password'); ?></label></td>
                    <td><?php echo $form->passwordField($model, 'password'); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'password'); ?></td>
                </tr>
            </table>
        </div>
    </fieldset>
    <fieldset class="tblFooters">
        <table width="100%">
            <tr>
                <td class="emp-reg">
                    <?php echo CHtml::link('Registration',array('/user/registration')); ?>
                </td>
                <td><?php echo CHtml::submitButton('Login',['style'=>'background-color:#3366CC;margin:auto;padding: 3px 15px !important;']); ?></td>
            </tr>
        </table>
    </fieldset>
</div>

<div style="width:800px; margin: 0 auto; text-align: center; margin-top:1%;">
    <h2 style="font-family: serif; color: #008000">Developed By: ABCD</h2>
</div>
<?php $this->endWidget(); ?>
<style>
    img {
        position: fixed;
        top: -12px;
        z-index: -1;
    }
    .ribbon {
        background: #ba89b6 none repeat scroll 0 0;
        color: #fff;
        margin-left: 54px;
        padding: 1em 2em;
        position: relative;
        text-align: center;
        width: 100%;
    }
    .emp-reg{
        text-align: left;
    }
    .emp-reg a{
        background-color:#3366CC;
        margin:auto;
        padding: 3px 15px !important;
        border: 2px solid #9B59B6;
        color: #FFF;
    }
</style>