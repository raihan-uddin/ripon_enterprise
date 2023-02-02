<?php $this->beginContent('//layouts/main'); ?>

<div class="wrapper">
    <?php if (!Yii::app()->user->isGuest) { ?>
        <div class="mainWrapperMenu">
            <div class="menuDiv">
                <div class="upperBorder"></div>
                <?php $this->widget('UserMenu'); ?>
                <div class="bottomBorder"></div>
            </div>
        </div>
    <?php } ?>
    <div class="container-fluid" style="min-height: 800px;">
        <?php echo $content; ?>
    </div>

    <footer class="card-footer">
        <div class="container-fluid">
            <div class="pull-right hidden-xs">
                <b>Version</b> <?php echo Yii::app()->params->version; ?>
            </div>
            <strong>Copyright © <?php echo Yii::app()->params->copyrightBy; ?> <a
                        href="#"><?php echo Yii::app()->params->developedBy; ?></a>.</strong> All rights
            reserved.
        </div>
        <!-- /.container -->
    </footer>

</div>
<?php $this->endContent(); ?>
