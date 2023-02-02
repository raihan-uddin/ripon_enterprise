<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">

    <meta name="language" content="en"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Google Font: Source Sans Pro -->
    <!--  <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">-->
    <!--    <link rel="stylesheet" href="-->
    <?php //echo Yii::app()->theme->baseUrl; ?><!--/css/layout.css" type="text/css"-->
    <!--          media="screen"/>-->
    <!--    <link rel="stylesheet" href="-->
    <?php //echo Yii::app()->theme->baseUrl; ?><!--/css/style.css" type="text/css"-->
    <!--          media="screen"/>-->
    <!--    <link rel="stylesheet" href="-->
    <?php //echo Yii::app()->theme->baseUrl; ?><!--/css/custom.css" type="text/css"-->
    <!--          media="screen"/>-->
    <link rel="icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.ico"/>

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/toastr/toastr.min.css">


    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/lightpick.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/custom.css">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="hold-transition layout-top-nav" style="font-size: 14px;">

<?php echo $content; ?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/alertify.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/bootstrap/js/bootstrap.bundle.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/moment/moment.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/inputmask/jquery.inputmask.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/toastr/toastr.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/bootstrap-switch/js/bootstrap-switch.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/dist/js/adminlte.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lightpick.js');
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/bootstrap-autocomplete.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/as-min.js');
?>
</body>
</html>