<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php $themeUrl = Yii::app()->theme->baseUrl; ?>
    <link rel="icon" type="image/svg+xml" href="<?php echo $themeUrl; ?>/images/favicon.svg"/>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/vendor/fontawesome6/css/all.min.css?v=6.5.2">
    <!-- Bootstrap 5.3 -->
    <link rel="stylesheet" href="<?php echo $themeUrl; ?>/vendor/bootstrap5/css/bootstrap.min.css?v=5.3.3">
</head>
<body class="login-page">
<?php echo $content; ?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/vendor/bootstrap5/js/bootstrap.bundle.min.js');
?>
</body>
</html>
