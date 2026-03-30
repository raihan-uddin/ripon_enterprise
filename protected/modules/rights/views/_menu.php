<?php
$ctrl   = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
$isActive = function($c, $a = null) use ($ctrl, $action) {
    if ($ctrl !== $c) return false;
    return $a === null || $action === $a;
};
?>
<style>
/* ── Rights sub-nav — light tab strip (clearly secondary to dark main nav) ── */
.rights-nav{
    background:#fff;
    border-bottom:1.5px solid #e5e7eb;
    display:flex;align-items:stretch;
    margin-bottom:24px;
    position:relative;z-index:10}
.rights-nav-left{
    display:flex;align-items:stretch;flex:1;
    overflow-x:auto;scrollbar-width:none}
.rights-nav-left::-webkit-scrollbar{display:none}
.rights-nav-right{
    display:flex;align-items:stretch;flex-shrink:0;
    border-left:1px solid #f3f4f6}

/* section label */
.rights-nav-label{
    display:flex;align-items:center;gap:7px;
    padding:0 16px;
    font-size:10px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;
    color:#9ca3af;border-right:1px solid #f3f4f6;white-space:nowrap;flex-shrink:0}
.rights-nav-label i{color:#6366f1;font-size:11px}

/* tab links */
.rights-nav a.rn-link{
    display:inline-flex;align-items:center;gap:7px;
    padding:0 16px;height:44px;
    font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.3px;
    color:#6b7280!important;
    text-decoration:none;white-space:nowrap;
    border-bottom:2px solid transparent;
    margin-bottom:-1.5px;
    transition:color .15s,border-color .15s,background .15s}
.rights-nav a.rn-link i{
    font-size:11px;width:13px;text-align:center;
    color:#d1d5db;transition:color .15s}
.rights-nav a.rn-link:hover{
    color:#374151!important;background:#f9fafb;
    border-bottom-color:#c7d2fe!important;text-decoration:none}
.rights-nav a.rn-link:hover i{color:#6366f1}
.rights-nav a.rn-link.rn-active{
    color:#4338ca!important;
    background:#f5f3ff;
    border-bottom-color:#6366f1!important}
.rights-nav a.rn-link.rn-active i{color:#6366f1}

/* right utility links — smaller, muted */
.rights-nav-right a.rn-link{
    font-size:10.5px;padding:0 13px;color:#9ca3af!important;
    text-transform:none;letter-spacing:.2px;border-bottom:none;margin-bottom:0}
.rights-nav-right a.rn-link + a.rn-link{border-left:1px solid #f3f4f6}
.rights-nav-right a.rn-link:hover{
    color:#374151!important;background:#f9fafb;border-bottom-color:transparent!important}

@media(max-width:767px){
    .rights-nav-label{display:none}
    .rights-nav a.rn-link{font-size:10px;padding:0 10px;gap:5px}
}
</style>

<nav class="rights-nav">
    <div class="rights-nav-label">
        <i class="fa fa-shield"></i> Access Control
    </div>
    <div class="rights-nav-left">
        <a class="rn-link <?php echo $isActive('assignment') ? 'rn-active' : ''; ?>"
           href="<?php echo Yii::app()->createUrl('/rights/assignment/view'); ?>">
            <i class="fa fa-users"></i> <?php echo Rights::t('core', 'Assignments'); ?>
        </a>
        <a class="rn-link <?php echo $isActive('authItem', 'permissions') ? 'rn-active' : ''; ?>"
           href="<?php echo Yii::app()->createUrl('/rights/authItem/permissions'); ?>">
            <i class="fa fa-lock"></i> <?php echo Rights::t('core', 'Permissions'); ?>
        </a>
        <a class="rn-link <?php echo $isActive('authItem', 'roles') ? 'rn-active' : ''; ?>"
           href="<?php echo Yii::app()->createUrl('/rights/authItem/roles'); ?>">
            <i class="fa fa-id-badge"></i> <?php echo Rights::t('core', 'Roles'); ?>
        </a>
        <a class="rn-link <?php echo $isActive('authItem', 'tasks') ? 'rn-active' : ''; ?>"
           href="<?php echo Yii::app()->createUrl('/rights/authItem/tasks'); ?>">
            <i class="fa fa-tasks"></i> <?php echo Rights::t('core', 'Tasks'); ?>
        </a>
        <a class="rn-link <?php echo $isActive('authItem', 'operations') ? 'rn-active' : ''; ?>"
           href="<?php echo Yii::app()->createUrl('/rights/authItem/operations'); ?>">
            <i class="fa fa-cog"></i> <?php echo Rights::t('core', 'Operations'); ?>
        </a>
    </div>
    <div class="rights-nav-right">
        <a class="rn-link" href="<?php echo Yii::app()->createUrl('/rights/authItem/generateFile'); ?>"
           title="<?php echo Rights::t('core', 'Update Permission Cache File'); ?>">
            <i class="fa fa-refresh"></i> Refresh Cache
        </a>
        <a class="rn-link" href="<?php echo Yii::app()->createUrl('/site/dashBoard'); ?>">
            <i class="fa fa-home"></i> Dashboard
        </a>
    </div>
</nav>
