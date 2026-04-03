<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <meta name="language" content="en"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=5" name="viewport">
    <?php $themeUrl = Yii::app()->theme->baseUrl; $themePath = Yii::app()->theme->basePath; ?>

    <link rel="icon" type="image/svg+xml" href="<?php echo $themeUrl; ?>/images/favicon.svg"/>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/vendor/fontawesome6/css/all.min.css?v=6.5.2">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/vendor/toastr/toastr.min.css?v=<?php echo filemtime($themePath.'/vendor/toastr/toastr.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/vendor/bootstrap5/css/bootstrap.min.css?v=5.3.3">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/css/lightpick.css">

    <!-- App CSS -->
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/css/form-components.css?v=<?php echo filemtime($themePath.'/css/form-components.css'); ?>">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/css/report-tables.css?v=<?php echo filemtime($themePath.'/css/report-tables.css'); ?>">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/css/admin-grids.css?v=<?php echo filemtime($themePath.'/css/admin-grids.css'); ?>">
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/css/custom.css?v=<?php echo filemtime($themePath.'/css/custom.css'); ?>">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body style="font-size: 14px;">

<?php echo $content; ?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/alertify.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/bootstrap5/js/bootstrap.bundle.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/moment/moment.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/inputmask/jquery.inputmask.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/toastr/toastr.min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lightpick.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/as-min.js');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/common.js');
?>
</body>
</html>
