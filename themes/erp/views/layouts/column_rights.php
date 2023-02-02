<?php $this->beginContent('//layouts/main'); ?>
    <div class="mainWrapper">
        <?php if (!Yii::app()->user->isGuest) { ?>
            <div class="mainWrapperMenu">
                <div class="menuDiv">
                    <div class="upperBorder"></div>
                    <?php $this->widget('UserMenu'); ?>
                    <div class="bottomBorder"></div>
                </div>
            </div>
        <?php } ?>
        <div id="rights" class="container">

            <div id="content">

                <?php if( $this->id!=='install' ): ?>

                    <div id="menu">

                        <?php $this->renderPartial('/_menu'); ?>

                    </div>

                <?php endif; ?>

                <?php $this->renderPartial('/_flash'); ?>

                <?php echo $content; ?>

            </div><!-- content -->

        </div>
        <div class="mainWrapperContent">
        </div>
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
<?php $this->endContent(); ?>