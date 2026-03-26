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

    <footer class="erp-footer">
        <div class="erp-footer-inner">
            <span class="erp-footer-copy">
                &copy; <?php echo date('Y'); ?> &nbsp;
                <a href="<?php echo Yii::app()->params->developedByUrl; ?>" target="_blank">
                    <?php echo CHtml::encode(Yii::app()->params->developedBy); ?>
                </a>
                &nbsp;&mdash;&nbsp; All rights reserved.
            </span>
            <span class="erp-footer-version">
                <i class="fa fa-code-fork"></i> v<?php echo Yii::app()->params->version; ?>
            </span>
        </div>
    </footer>
    <style>
    .erp-footer{
        background:#0f172a;
        border-top:1px solid rgba(255,255,255,.06);
        padding:0;margin-top:32px}
    .erp-footer-inner{
        display:flex;align-items:center;justify-content:space-between;
        padding:14px 24px;
        flex-wrap:wrap;gap:8px}
    .erp-footer-copy{
        font-size:12.5px;color:rgba(255,255,255,.45);font-weight:500}
    .erp-footer-copy a{
        color:rgba(255,255,255,.7);text-decoration:none;font-weight:600;
        transition:color .15s}
    .erp-footer-copy a:hover{color:#6366f1}
    .erp-footer-version{
        font-size:11.5px;color:rgba(255,255,255,.3);
        display:flex;align-items:center;gap:5px;font-weight:600;letter-spacing:.3px}
    .erp-footer-version i{color:#6366f1;font-size:11px}
    @media(max-width:576px){
        .erp-footer-inner{justify-content:center;text-align:center}
    }
    </style>

</div>
<?php $this->endContent(); ?>
