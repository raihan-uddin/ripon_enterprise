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
    <div class="mainWrapperContent">
        <?php echo $content; ?>
    </div>
</div>
<div class="mainWrapperFooter">
        Copyright &COPY; <?php echo Yii::app()->params->copyrightBy; ?>, Developed By <a href="tel:01680527922"  target="_blank"><?php echo Yii::app()->params->developedBy; ?></a>
</div>
<?php $this->endContent(); ?>