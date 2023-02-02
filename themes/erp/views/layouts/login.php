<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.ico"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
          href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<?php echo $content; ?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.js');
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/jquery/jquery.min.js');
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/plugins/bootstrap/js/bootstrap.bundle.min.js');
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/dist/js/adminlte.min.js');
?>
</body>
</html>

