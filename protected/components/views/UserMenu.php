<?php
$loggedUser = Yii::app()->user->getState('user_id');
$devIds     = [1];
$isDev      = in_array($loggedUser, $devIds);
$userName   = Yii::app()->user->name;
$parts      = explode(' ', trim($userName));
$initials   = count($parts) >= 2
    ? strtoupper($parts[0][0] . $parts[count($parts)-1][0])
    : strtoupper(substr($userName, 0, 2));

// ── Permission cache (session-scoped, clears on logout) ─────────────────────
// RDbAuthManager loads all auth items in ~2 DB queries per request.
// We cache the final booleans in the session so subsequent page loads cost 0 queries.
$_navPerms = Yii::app()->user->getState('_nav_perms');
if ($_navPerms === null) {
    $u = Yii::app()->user;
    $_navPerms = array_fill_keys([
        'Users.Admin','rights',
        'Accounting.Expense.Create','Accounting.Expense.Admin','Accounting.ExpenseHead.Admin',
        'ProdItems.Admin','ProdBrands.Admin','ProdModels.Create','ProdModels.Admin',
        'Units.Admin','Companies.Admin',
        'Inventory.Inventory.Admin','Inventory.Inventory.VerifyProduct',
        'Inventory.Inventory.StockReport','Inventory.Inventory.StockReportSupplierWise',
        'Sell.Customers.Admin','Sell.CrmBank.Admin',
        'Sell.SellOrder.Create','Sell.SellOrder.Admin',
        'Sell.SellOrderQuotation.Create','Sell.SellOrderQuotation.Admin',
        'Sell.SellReturn.CreateProductReturn','Sell.SellReturn.Admin',
        'Accounting.MoneyReceipt.AdminMoneyReceipt','Accounting.MoneyReceipt.Admin',
        'Commercial.ComBank.Admin','Commercial.Suppliers.Admin',
        'Commercial.PurchaseOrder.Create','Commercial.PurchaseOrder.Admin',
        'Accounting.PaymentReceipt.AdminPaymentReceipt','Accounting.PaymentReceipt.Create',
        'Loan.LoanPersons.Admin','Loan.LoanTransactions.Admin',
        'Report.PriceListView',
        'Report.SalesReport','Report.SaleDetailsReport','Report.CustomerDueReport',
        'Report.CustomerLedger','Report.CollectionReport',
        'Report.PurchaseReport','Report.PurchaseDetailsReport','Report.SupplierDueReport',
        'Report.SupplierLedger','Report.PaymentReport',
        'Report.ExpenseSummaryReport','Report.ExpenseDetailsReport',
        'Report.DayInOutReport',
    ], false);
    foreach ($_navPerms as $k => $_) {
        $_navPerms[$k] = $u->checkAccess($k);
    }
    Yii::app()->user->setState('_nav_perms', $_navPerms);
}
$ca = function($perm) use ($_navPerms) { return !empty($_navPerms[$perm]); };

// ── Active menu detection ────────────────────────────────────────────────────
// Using a closure avoids "Cannot redeclare function" on every widget render.
$curModule     = Yii::app()->controller->module ? Yii::app()->controller->module->id : '';
$curController = Yii::app()->controller->id;
$curAction     = Yii::app()->controller->action ? Yii::app()->controller->action->id : '';

// Returns true if current page is in any of the given module/controller routes.
// 'sell'              → any page in the sell module
// 'accounting/expense'→ accounting module + expense controller only
$inRoute = function(array $routes) use ($curModule, $curController) {
    foreach ($routes as $r) {
        $p = explode('/', $r);
        if (count($p) === 1) {
            if ($curModule === '' && $curController === $p[0]) return true; // bare controller
            if ($curModule === $p[0])                          return true; // whole module
        }
        if (count($p) === 2 && $curModule === $p[0] && $curController === $p[1]) return true;
    }
    return false;
};

// Per-page route check (for dropdown item highlighting via JS data attributes)
$isPage = function($mod, $ctrl, $act = null) use ($curModule, $curController, $curAction) {
    if ($curModule !== $mod || $curController !== $ctrl) return false;
    return $act === null || $curAction === $act;
};

// Top-level active flags — module-prefix matching so ANY page in a module activates its menu
$activeDashboard = ($curModule === '' && $curController === 'site');
$activeInventory = $inRoute(['prodItems','prodBrands','prodModels','units','companies','inventory']);
$activeSales     = $inRoute(['sell']) || $isPage('accounting','moneyReceipt');
$activePurchase  = $inRoute(['commercial']) || $isPage('accounting','paymentReceipt');
$activeLoan      = $inRoute(['loan']);
$activeReports   = $inRoute(['report']);
$activeCommon    = !$activeSales && !$activePurchase
               && $inRoute(['users','rights','business','branch','accounting']);

$showCommon = $isDev
    || $ca('Users.Admin') || $ca('rights')
    || $ca('Accounting.Expense.Create') || $ca('Accounting.Expense.Admin') || $ca('Accounting.ExpenseHead.Admin');

$showInventory = $ca('ProdItems.Admin') || $ca('ProdBrands.Admin')
    || $ca('ProdModels.Create') || $ca('ProdModels.Admin')
    || $ca('Units.Admin') || $ca('Companies.Admin')
    || $ca('Inventory.Inventory.Admin') || $ca('Inventory.Inventory.VerifyProduct');

$showSales = $ca('Sell.Customers.Admin') || $ca('Sell.CrmBank.Admin')
    || $ca('Sell.SellOrder.Create') || $ca('Sell.SellOrder.Admin')
    || $ca('Sell.SellOrderQuotation.Create') || $ca('Sell.SellOrderQuotation.Admin')
    || $ca('Sell.SellReturn.CreateProductReturn') || $ca('Sell.SellReturn.Admin')
    || $ca('Accounting.MoneyReceipt.AdminMoneyReceipt') || $ca('Accounting.MoneyReceipt.Admin');

$showPurchase = $ca('Commercial.ComBank.Admin') || $ca('Commercial.Suppliers.Admin')
    || $ca('Commercial.PurchaseOrder.Create') || $ca('Commercial.PurchaseOrder.Admin')
    || $ca('Accounting.PaymentReceipt.AdminPaymentReceipt') || $ca('Accounting.PaymentReceipt.Create');

$showReports = $ca('Inventory.Inventory.StockReport') || $ca('Inventory.Inventory.StockReportSupplierWise') || $ca('Report.PriceListView')
    || $ca('Report.SalesReport') || $ca('Report.SaleDetailsReport') || $ca('Report.CustomerDueReport') || $ca('Report.CustomerLedger') || $ca('Report.CollectionReport')
    || $ca('Report.PurchaseReport') || $ca('Report.PurchaseDetailsReport') || $ca('Report.SupplierDueReport') || $ca('Report.SupplierLedger') || $ca('Report.PaymentReport')
    || $ca('Report.ExpenseSummaryReport') || $ca('Report.ExpenseDetailsReport')
    || $ca('Report.DayInOutReport');
?>
<style>
/* ═══════════════════════════════════════════════
   ERP Navbar  (collapses at <992px / lg)
═══════════════════════════════════════════════ */
.erp-nav{background:#0f172a;padding:0;position:relative;z-index:1050;
    box-shadow:0 2px 8px rgba(0,0,0,.25)}
.erp-nav .navbar-brand{display:flex;align-items:center;gap:8px;
    padding:8px 14px;color:#fff!important;font-size:14px;font-weight:700;
    letter-spacing:.3px;text-decoration:none;flex-shrink:0}
.erp-nav .navbar-brand img{height:42px;width:auto;filter:brightness(0) invert(1)}
/* Hamburger — mobile only */
.erp-nav .navbar-toggler{
    display:none}                          /* hidden by default; shown only mobile */
@media(max-width:991px){
    .erp-nav .navbar-toggler{
        display:flex!important;            /* override any Bootstrap reset */
        align-items:center;justify-content:center;
        border:1.5px solid rgba(255,255,255,.35);
        border-radius:6px;padding:0;
        width:38px;height:38px;
        margin-right:12px;flex-shrink:0;
        background:rgba(255,255,255,.08);
        transition:background .15s,border-color .15s}
    .erp-nav .navbar-toggler:hover{background:rgba(255,255,255,.16);border-color:rgba(255,255,255,.6)}
    .erp-nav .navbar-toggler:focus{outline:none;box-shadow:none}
}
.erp-nav .navbar-toggler-icon{
    width:18px;height:18px;
    background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 18 18'%3e%3cpath stroke='rgba(255,255,255,1)' stroke-linecap='round' stroke-width='2' d='M2 4h14M2 9h14M2 14h14'/%3e%3c/svg%3e");
    background-size:18px 18px}

/* Top-level nav items */
.erp-nav .navbar-nav>.nav-item>.nav-link{
    color:rgba(255,255,255,.68)!important;
    font-size:11px;font-weight:600;letter-spacing:.35px;
    padding:14px 11px!important;text-transform:uppercase;
    transition:color .18s,background .18s,border-color .18s;
    white-space:nowrap;border-bottom:2px solid transparent}
.erp-nav .navbar-nav>.nav-item>.nav-link:hover{
    color:#fff!important;
    background:rgba(255,255,255,.07)!important;
    border-bottom-color:rgba(99,102,241,.55)!important}

/* Active — server-rendered class */
nav.erp-nav .navbar-nav>.nav-item.active>.nav-link,
nav.erp-nav .navbar-nav>.nav-item.active>.nav-link:focus{
    color:#fff!important;
    background:rgba(99,102,241,.2)!important;
    border-bottom-color:#6366f1!important}

/* Dropdown open animation */
@media(min-width:992px){
    .erp-nav .dropdown-menu{
        animation:erpFadeIn .14s ease-out both}
    @keyframes erpFadeIn{
        from{opacity:0;transform:translateY(-4px)}
        to  {opacity:1;transform:translateY(0)}}
}

/* Desktop: no wrap */
@media(min-width:992px){
    .erp-nav .navbar-nav{flex-wrap:nowrap}
}

/* Wider screens get more padding */
@media(min-width:1280px){
    .erp-nav .navbar-nav>.nav-item>.nav-link{font-size:12px;padding:14px 14px!important}
    .erp-nav .navbar-brand{padding:9px 16px}
    .erp-nav .navbar-brand img{height:38px}
}

/* Dropdown menus */
.erp-nav .dropdown-menu{background:#1e293b;border:1px solid rgba(255,255,255,.08);
    border-radius:10px;padding:6px;min-width:210px;
    box-shadow:0 8px 28px rgba(0,0,0,.35);margin-top:0}
.erp-nav .dropdown-header{color:#6b7280;font-size:10px;font-weight:700;
    text-transform:uppercase;letter-spacing:.8px;padding:8px 12px 4px;
    display:flex;align-items:center;gap:6px}
.erp-nav .dropdown-header i{font-size:10px;color:#6366f1}
.erp-nav .dropdown-item{color:rgba(255,255,255,.78);font-size:12.5px;
    padding:7px 12px;border-radius:6px;transition:background .12s,color .12s;
    display:flex;align-items:center;gap:8px;font-weight:500}
.erp-nav .dropdown-item i{font-size:11px;width:14px;text-align:center;
    color:#6b7280;flex-shrink:0}
.erp-nav .dropdown-item:hover,.erp-nav .dropdown-item:focus{
    background:rgba(99,102,241,.18);color:#fff}
.erp-nav .dropdown-item:hover i,.erp-nav .dropdown-item:focus i{color:#a5b4fc}
.erp-nav .dropdown-divider{border-color:rgba(255,255,255,.07);margin:4px 6px}

/* Active dropdown item */
.erp-nav .dropdown-item.erp-di-active{
    background:rgba(99,102,241,.22)!important;color:#fff!important;
    border-left:2px solid #6366f1}
.erp-nav .dropdown-item.erp-di-active i{color:#a5b4fc!important}

/* 3rd-level submenu */
.erp-nav .dropdown-submenu{position:relative}
.erp-nav .dropdown-submenu>.dropdown-item::after{
    content:'\f105';font-family:'FontAwesome';font-size:10px;
    margin-left:auto;color:#6b7280}
.erp-nav .dropdown-submenu>.dropdown-menu{
    top:0;left:100%;margin-top:-6px;margin-left:3px;display:none}
.erp-nav .dropdown-submenu:hover>.dropdown-menu{display:block}

/* Support block */
.erp-support-block{padding:2px 0}
.erp-support-label{
    font-size:10px;font-weight:700;color:#6b7280;
    text-transform:uppercase;letter-spacing:.8px;
    padding:4px 12px 2px;display:flex;align-items:center;gap:5px}
.erp-support-label i{font-size:10px;color:#6366f1}
.erp-support-call{
    display:flex;align-items:center;gap:8px;
    color:rgba(255,255,255,.78);font-size:12.5px;font-weight:500;
    text-decoration:none;padding:7px 12px;border-radius:6px;
    transition:background .12s,color .12s}
.erp-support-call:hover{
    background:rgba(255,255,255,.06);color:#fff;text-decoration:none}
.erp-support-call i{color:#6366f1;font-size:12px;flex-shrink:0;width:14px;text-align:center}

/* Connect block */
.erp-connect-block{padding:2px 0}
.erp-connect-item{
    display:flex;align-items:center;gap:8px;
    color:rgba(255,255,255,.78);font-size:12.5px;font-weight:500;
    text-decoration:none;padding:7px 12px;border-radius:6px;
    transition:background .12s,color .12s}
.erp-connect-item:hover{background:rgba(255,255,255,.06);color:#fff;text-decoration:none}
.erp-connect-item i{font-size:13px;flex-shrink:0;width:14px;text-align:center}
.erp-ci-globe{color:#6366f1}
.erp-ci-li{color:#0a66c2}
.erp-ci-fb{color:#1877f2}

/* User badge */
.erp-nav .erp-user-btn{display:flex;align-items:center;gap:8px;
    color:rgba(255,255,255,.8)!important;font-size:12.5px;font-weight:600;
    padding:10px 14px!important;cursor:pointer;border:none;background:transparent}
.erp-nav .erp-avatar{width:30px;height:30px;border-radius:8px;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    display:flex;align-items:center;justify-content:center;
    font-size:11px;font-weight:700;color:#fff;flex-shrink:0;letter-spacing:-.5px}
.erp-nav .erp-user-btn:hover{color:#fff!important}

/* Mobile collapse (<992px) */
@media(max-width:991px){
    nav.erp-nav .navbar-collapse{
        background:#0f172a!important;
        border-top:1px solid rgba(255,255,255,.1)!important;
        padding:6px 0 14px!important;
        max-height:80vh;overflow-y:auto;
        width:100%}
    nav.erp-nav .navbar-nav{
        flex-direction:column!important;
        width:100%!important}
    nav.erp-nav .nav-item{width:100%}
    nav.erp-nav .nav-item>.nav-link{
        color:rgba(255,255,255,.85)!important;
        background:transparent!important;
        padding:10px 20px!important;
        border-bottom:none!important;
        border-left:3px solid transparent!important;
        font-size:12px!important}
    nav.erp-nav .nav-item>.nav-link:hover,
    nav.erp-nav .nav-item>.nav-link:focus{
        background:rgba(255,255,255,.06)!important;
        border-left-color:#6366f1!important;
        color:#fff!important}
    nav.erp-nav .dropdown-menu{
        position:static!important;display:none;
        background:#111827!important;
        border:none!important;border-radius:0!important;
        box-shadow:none!important;padding:2px 0 6px!important;margin:0!important;
        width:100%!important}
    nav.erp-nav .dropdown-menu.show{display:block!important}
    nav.erp-nav .dropdown-menu .dropdown-header{
        padding-left:32px!important;color:#6b7280!important}
    nav.erp-nav .dropdown-menu .dropdown-item{
        padding-left:32px!important;
        color:rgba(255,255,255,.75)!important;
        background:transparent!important;border-radius:0!important}
    nav.erp-nav .dropdown-menu .dropdown-item:hover{
        background:rgba(99,102,241,.15)!important;color:#fff!important}
    nav.erp-nav .ml-auto{
        margin-left:0!important;width:100%!important;
        border-top:1px solid rgba(255,255,255,.07)!important;padding-top:6px!important}
    nav.erp-nav .dropdown-submenu>.dropdown-menu{
        margin:0 0 0 16px!important;background:rgba(255,255,255,.03)!important}
    nav.erp-nav .dropdown-submenu.open>.dropdown-menu{display:block!important}
}
</style>

<nav class="navbar navbar-expand-lg erp-nav">

    <!-- Brand -->
    <a class="navbar-brand" href="<?= Yii::app()->createUrl('site/dashBoard') ?>">
        <img src="<?= Yii::app()->theme->baseUrl ?>/images/logo.svg" alt="Logo">
    </a>

    <!-- Hamburger -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#erpNav"
            aria-controls="erpNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="erpNav">
        <ul class="navbar-nav">

            <!-- Dashboard -->
            <li class="nav-item<?= $activeDashboard ? ' active' : '' ?>">
                <a class="nav-link" href="<?= Yii::app()->createUrl('site/dashBoard') ?>">
                    <i class="fa fa-home mr-1"></i> Dashboard
                </a>
            </li>

            <!-- Common -->
            <?php if ($showCommon): ?>
            <li class="nav-item dropdown<?= $activeCommon ? ' active' : '' ?>">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <i class="fa fa-cogs mr-1"></i> Common
                </a>
                <div class="dropdown-menu">
                    <?php if ($ca('Users.Admin') || $ca('rights') || $isDev): ?>
                    <div class="dropdown-header"><i class="fa fa-users"></i> User</div>
                    <?php if ($ca('Users.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/users/admin') ?>"><i class="fa fa-user-circle-o"></i> Manage Users</a>
                    <?php endif; ?>
                    <?php if ($ca('rights')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/rights') ?>"><i class="fa fa-lock"></i> Permissions</a>
                    <?php endif; ?>
                    <?php if ($isDev): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/business') ?>"><i class="fa fa-building-o"></i> Business</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/branch') ?>"><i class="fa fa-code-fork"></i> Branch</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Accounting.Expense.Create') || $ca('Accounting.Expense.Admin') || $ca('Accounting.ExpenseHead.Admin')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-credit-card"></i> Expense</div>
                    <?php if ($ca('Accounting.Expense.Create')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/accounting/expense/create') ?>"><i class="fa fa-plus"></i> New Expense</a>
                    <?php endif; ?>
                    <?php if ($ca('Accounting.Expense.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/accounting/expense/admin') ?>"><i class="fa fa-list"></i> Manage Expenses</a>
                    <?php endif; ?>
                    <?php if ($ca('Accounting.ExpenseHead.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/accounting/expenseHead/admin') ?>"><i class="fa fa-tags"></i> Expense Heads</a>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>
            <?php endif; ?>

            <!-- Inventory -->
            <?php if ($showInventory): ?>
            <li class="nav-item dropdown<?= $activeInventory ? ' active' : '' ?>">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <i class="fa fa-cubes mr-1"></i> Inventory
                </a>
                <div class="dropdown-menu">
                    <?php if ($ca('ProdItems.Admin') || $ca('ProdBrands.Admin') || $ca('ProdModels.Admin') || $ca('Units.Admin') || $ca('Companies.Admin')): ?>
                    <div class="dropdown-header"><i class="fa fa-sliders"></i> Config</div>
                    <?php if ($ca('ProdItems.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/prodItems/admin') ?>"><i class="fa fa-folder-o"></i> Category</a>
                    <?php endif; ?>
                    <?php if ($ca('ProdBrands.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/prodBrands/admin') ?>"><i class="fa fa-tag"></i> Sub-Category</a>
                    <?php endif; ?>
                    <?php if ($ca('ProdModels.Create') || $ca('ProdModels.Admin')): ?>
                    <div class="dropdown-submenu">
                        <a class="dropdown-item" href="#"><i class="fa fa-th-large"></i> Product Setup</a>
                        <div class="dropdown-menu">
                            <?php if ($ca('ProdModels.Create')): ?>
                            <a class="dropdown-item" href="<?= Yii::app()->createUrl('/prodModels/create') ?>"><i class="fa fa-plus"></i> Create Product</a>
                            <?php endif; ?>
                            <?php if ($ca('ProdModels.Admin')): ?>
                            <a class="dropdown-item" href="<?= Yii::app()->createUrl('/prodModels/admin') ?>"><i class="fa fa-list"></i> Manage Products</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($ca('Units.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/units/admin') ?>"><i class="fa fa-balance-scale"></i> Units</a>
                    <?php endif; ?>
                    <?php if ($ca('Companies.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/companies/admin') ?>"><i class="fa fa-industry"></i> Companies</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Inventory.Inventory.Admin') || $ca('Inventory.Inventory.VerifyProduct')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-archive"></i> Stock</div>
                    <?php if ($ca('Inventory.Inventory.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/inventory/inventory/admin') ?>"><i class="fa fa-list"></i> Manage Stock</a>
                    <?php endif; ?>
                    <?php if ($ca('Inventory.Inventory.VerifyProduct')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/inventory/inventory/verifyProduct') ?>"><i class="fa fa-check-square-o"></i> Verify Product</a>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>
            <?php endif; ?>

            <!-- Sales -->
            <?php if ($showSales): ?>
            <li class="nav-item dropdown<?= $activeSales ? ' active' : '' ?>">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <i class="fa fa-shopping-cart mr-1"></i> Sales
                </a>
                <div class="dropdown-menu">
                    <?php if ($ca('Sell.Customers.Admin') || $ca('Sell.CrmBank.Admin')): ?>
                    <div class="dropdown-header"><i class="fa fa-sliders"></i> Config</div>
                    <?php if ($ca('Sell.Customers.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/customers/admin') ?>"><i class="fa fa-users"></i> Customers</a>
                    <?php endif; ?>
                    <?php if ($ca('Sell.CrmBank.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/crmBank/admin') ?>"><i class="fa fa-university"></i> Banks</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Sell.SellOrder.Create') || $ca('Sell.SellOrder.Admin')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-file-text-o"></i> Orders</div>
                    <?php if ($ca('Sell.SellOrder.Create')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/sellOrder/create') ?>"><i class="fa fa-plus"></i> New Order</a>
                    <?php endif; ?>
                    <?php if ($ca('Sell.SellOrder.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/sellOrder/admin') ?>"><i class="fa fa-list"></i> Manage Orders</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Sell.SellOrderQuotation.Create') || $ca('Sell.SellOrderQuotation.Admin')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-file-o"></i> Draft</div>
                    <?php if ($ca('Sell.SellOrderQuotation.Create')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/sellOrderQuotation/create') ?>"><i class="fa fa-plus"></i> New Draft</a>
                    <?php endif; ?>
                    <?php if ($ca('Sell.SellOrderQuotation.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/sellOrderQuotation/admin') ?>"><i class="fa fa-list"></i> Manage Drafts</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Sell.SellReturn.CreateProductReturn') || $ca('Sell.SellReturn.Admin')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-reply"></i> Return</div>
                    <?php if ($ca('Sell.SellReturn.CreateProductReturn')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/sellReturn/createProductReturn') ?>"><i class="fa fa-undo"></i> New Return</a>
                    <?php endif; ?>
                    <?php if ($ca('Sell.SellReturn.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/sell/sellReturn/admin') ?>"><i class="fa fa-list"></i> Manage Returns</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Accounting.MoneyReceipt.AdminMoneyReceipt') || $ca('Accounting.MoneyReceipt.Admin')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-sign-in"></i> Collection</div>
                    <?php if ($ca('Accounting.MoneyReceipt.AdminMoneyReceipt')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/accounting/moneyReceipt/adminMoneyReceipt') ?>"><i class="fa fa-plus"></i> New Receipt</a>
                    <?php endif; ?>
                    <?php if ($ca('Accounting.MoneyReceipt.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/accounting/moneyReceipt/admin') ?>"><i class="fa fa-list"></i> Manage Receipts</a>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>
            <?php endif; ?>

            <!-- Purchase -->
            <?php if ($showPurchase): ?>
            <li class="nav-item dropdown<?= $activePurchase ? ' active' : '' ?>">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <i class="fa fa-truck mr-1"></i> Purchase
                </a>
                <div class="dropdown-menu">
                    <?php if ($ca('Commercial.ComBank.Admin') || $ca('Commercial.Suppliers.Admin')): ?>
                    <div class="dropdown-header"><i class="fa fa-sliders"></i> Config</div>
                    <?php if ($ca('Commercial.ComBank.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/commercial/comBank/admin') ?>"><i class="fa fa-university"></i> Banks</a>
                    <?php endif; ?>
                    <?php if ($ca('Commercial.Suppliers.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/commercial/suppliers/admin') ?>"><i class="fa fa-truck"></i> Suppliers</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Commercial.PurchaseOrder.Create') || $ca('Commercial.PurchaseOrder.Admin')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-shopping-basket"></i> Orders</div>
                    <?php if ($ca('Commercial.PurchaseOrder.Create')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/commercial/purchaseOrder/create') ?>"><i class="fa fa-plus"></i> New Purchase</a>
                    <?php endif; ?>
                    <?php if ($ca('Commercial.PurchaseOrder.Admin')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/commercial/purchaseOrder/admin') ?>"><i class="fa fa-list"></i> Manage Purchases</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Accounting.PaymentReceipt.AdminPaymentReceipt') || $ca('Accounting.PaymentReceipt.Create')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-sign-out"></i> Payment</div>
                    <?php if ($ca('Accounting.PaymentReceipt.AdminPaymentReceipt')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/accounting/paymentReceipt/adminPaymentReceipt') ?>"><i class="fa fa-plus"></i> New Payment</a>
                    <?php endif; ?>
                    <?php if ($ca('Accounting.PaymentReceipt.Create')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/accounting/paymentReceipt/admin') ?>"><i class="fa fa-list"></i> Manage Payments</a>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>
            <?php endif; ?>

            <!-- Loan -->
            <?php if ($ca('Loan.LoanPersons.Admin') || $ca('Loan.LoanTransactions.Admin') || $isDev): ?>
            <li class="nav-item dropdown<?= $activeLoan ? ' active' : '' ?>">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <i class="fa fa-handshake-o mr-1"></i> Loan
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/loan/loanPersons/admin') ?>"><i class="fa fa-user-plus"></i> Persons</a>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/loan/loanTransactions/admin') ?>"><i class="fa fa-exchange"></i> Transactions</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/loanLedger') ?>"><i class="fa fa-book"></i> Person Ledger</a>
                </div>
            </li>
            <?php endif; ?>

            <!-- Report -->
            <?php if ($showReports): ?>
            <li class="nav-item dropdown<?= $activeReports ? ' active' : '' ?>">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <i class="fa fa-bar-chart mr-1"></i> Reports
                </a>
                <div class="dropdown-menu" style="min-width:240px">
                    <?php if ($ca('Inventory.Inventory.StockReport') || $ca('Inventory.Inventory.StockReportSupplierWise') || $ca('Report.PriceListView')): ?>
                    <div class="dropdown-header"><i class="fa fa-archive"></i> Inventory</div>
                    <?php if ($ca('Inventory.Inventory.StockReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/inventory/inventory/stockReport') ?>"><i class="fa fa-cube"></i> Stock Report</a>
                    <?php endif; ?>
                    <?php if ($ca('Inventory.Inventory.StockReportSupplierWise')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/inventory/inventory/stockReportSupplierWise') ?>"><i class="fa fa-truck"></i> Stock (Supplier Wise)</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.PriceListView')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/priceListView') ?>"><i class="fa fa-tag"></i> Price List</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Report.SalesReport') || $ca('Report.SaleDetailsReport') || $ca('Report.CustomerDueReport') || $ca('Report.CustomerLedger') || $ca('Report.CollectionReport')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-shopping-cart"></i> Sales</div>
                    <?php if ($ca('Report.SalesReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/salesReport') ?>"><i class="fa fa-line-chart"></i> Sales Report</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.SaleDetailsReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/saleDetailsReport') ?>"><i class="fa fa-bar-chart"></i> Sales (Product Wise)</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.CustomerDueReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/customerDueReport') ?>"><i class="fa fa-exclamation-circle"></i> Customer Due</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.CustomerLedger')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/customerLedger') ?>"><i class="fa fa-list-alt"></i> Customer Ledger</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.CollectionReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/collectionReport') ?>"><i class="fa fa-money"></i> Collection Report</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Report.PurchaseReport') || $ca('Report.PurchaseDetailsReport') || $ca('Report.SupplierDueReport') || $ca('Report.SupplierLedger') || $ca('Report.PaymentReport')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-truck"></i> Purchase</div>
                    <?php if ($ca('Report.PurchaseReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/purchaseReport') ?>"><i class="fa fa-pie-chart"></i> Purchase Report</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.PurchaseDetailsReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/purchaseDetailsReport') ?>"><i class="fa fa-area-chart"></i> Purchase (Product Wise)</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.SupplierDueReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/supplierDueReport') ?>"><i class="fa fa-exclamation-triangle"></i> Supplier Due</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.SupplierLedger')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/supplierLedger') ?>"><i class="fa fa-book"></i> Supplier Ledger</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.PaymentReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/paymentReport') ?>"><i class="fa fa-credit-card"></i> Payment Report</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Report.ExpenseSummaryReport') || $ca('Report.ExpenseDetailsReport')): ?>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header"><i class="fa fa-credit-card"></i> Expense</div>
                    <?php if ($ca('Report.ExpenseSummaryReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/expenseSummaryReport') ?>"><i class="fa fa-table"></i> Expense Summary</a>
                    <?php endif; ?>
                    <?php if ($ca('Report.ExpenseDetailsReport')): ?>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/expenseDetailsReport') ?>"><i class="fa fa-list"></i> Expense Details</a>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($ca('Report.DayInOutReport')): ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/report/dayInOutReport') ?>"><i class="fa fa-calendar-check-o"></i> Day In/Out Report</a>
                    <?php endif; ?>
                </div>
            </li>
            <?php endif; ?>

        </ul>

        <!-- Right: draft notifications + user + logout -->
        <ul class="navbar-nav ml-auto">

            <!-- Draft notifications (JS-populated) -->
            <li class="nav-item dropdown" id="draft-notif-item" style="display:none;">
                <a class="nav-link position-relative" href="#" id="draft-notif-toggle"
                   data-toggle="dropdown" role="button" title="Unsaved Drafts"
                   style="padding-right:10px;">
                    <i class="fa fa-pencil-square-o" style="font-size:16px;"></i>
                    <span id="draft-notif-count"
                          class="badge badge-danger badge-pill"
                          style="position:absolute; top:6px; right:2px;
                                 font-size:9px; min-width:16px; padding:2px 4px;">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow-sm p-0"
                     id="draft-notif-menu" style="min-width:300px; max-width:340px;">
                    <div class="dropdown-header d-flex align-items-center justify-content-between
                                px-3 py-2"
                         style="background:#f8f9fa; border-bottom:1px solid #dee2e6;
                                font-size:12px; font-weight:700; text-transform:uppercase;
                                letter-spacing:0.5px; color:#495057;">
                        <span><i class="fa fa-pencil-square-o mr-1"></i> Unsaved Drafts</span>
                        <a href="#" id="draft-clear-all"
                           class="text-danger" style="font-size:11px; font-weight:400;">
                            <i class="fa fa-trash"></i> Clear all
                        </a>
                    </div>
                    <div id="draft-notif-list"></div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link erp-user-btn dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <span class="erp-avatar"><?= $initials ?></span>
                    <span class="d-none d-lg-inline"><?= CHtml::encode($userName) ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header"><i class="fa fa-user-circle-o"></i> <?= CHtml::encode($userName) ?></div>
                    <div class="dropdown-divider"></div>
                    <div class="erp-support-block">
                        <div class="erp-support-label"><i class="fa fa-headphones"></i> Support</div>
                        <a class="erp-support-call" href="tel:<?= CHtml::encode(preg_replace('/\s+/', '', Yii::app()->params->adminPhone)) ?>">
                            <i class="fa fa-phone"></i>
                            <?= CHtml::encode(Yii::app()->params->adminPhone) ?>
                        </a>
                    </div>
                    <div class="erp-connect-block">
                        <div class="erp-support-label"><i class="fa fa-globe"></i> Connect</div>
                        <a class="erp-connect-item" href="http://raihan-uddin.github.io/" target="_blank" rel="noopener">
                            <i class="fa fa-globe erp-ci-globe"></i> Portfolio
                        </a>
                        <a class="erp-connect-item" href="https://www.linkedin.com/in/raihanuddin2/" target="_blank" rel="noopener">
                            <i class="fa fa-linkedin-square erp-ci-li"></i> LinkedIn
                        </a>
                        <a class="erp-connect-item" href="https://www.facebook.com/raihan.uddin22" target="_blank" rel="noopener">
                            <i class="fa fa-facebook-square erp-ci-fb"></i> Facebook
                        </a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= Yii::app()->createUrl('/site/logout') ?>">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
(function () {
    var BASE = '<?= Yii::app()->baseUrl ?>';

    // ── Collect all drafts from localStorage ──────────────────────────────────
    function getDrafts() {
        var list = [];

        // Sales Order draft
        try {
            var so = localStorage.getItem('so_draft_create');
            if (so) {
                var d = JSON.parse(so);
                var rowCount = d.rows ? Object.keys(d.rows).length : 0;
                if (d.customer_id || rowCount > 0) {
                    var parts = [];
                    if (d.customer_text) parts.push(d.customer_text);
                    if (rowCount > 0)    parts.push(rowCount + ' item' + (rowCount > 1 ? 's' : ''));
                    list.push({
                        key:     'so_draft_create',
                        title:   'Sales Order',
                        icon:    'fa-shopping-cart',
                        color:   '#007bff',
                        url:     BASE + '/index.php/sell/sellOrder/create',
                        label:   parts.join(' — '),
                        savedAt: d.saved_at,
                    });
                }
            }
        } catch (e) { localStorage.removeItem('so_draft_create'); }

        // Money Receipt drafts (one per customer)
        for (var i = 0; i < localStorage.length; i++) {
            var key = localStorage.key(i);
            if (!key) continue;
            var m = key.match(/^mr_draft_customer_(\d+)$/);
            if (!m) continue;
            try {
                var mr = JSON.parse(localStorage.getItem(key));
                var amt = (parseFloat(mr.amount) || 0) + (parseFloat(mr.discount) || 0);
                if (amt > 0 || mr.date) {
                    var customerId = m[1];
                    var mrParts = [];
                    if (mr.customer_name) mrParts.push(mr.customer_name);
                    else                  mrParts.push('Customer #' + customerId);
                    if (amt > 0) mrParts.push('৳ ' + amt.toFixed(2));
                    list.push({
                        key:     key,
                        title:   'Money Receipt',
                        icon:    'fa-money',
                        color:   '#28a745',
                        url:     BASE + '/index.php/accounting/moneyReceipt/create/' + customerId,
                        label:   mrParts.join(' — '),
                        savedAt: mr.saved_at,
                    });
                }
            } catch (e) { localStorage.removeItem(key); }
        }

        return list;
    }

    // ── Render notification dropdown ──────────────────────────────────────────
    function buildDraftMenu() {
        var drafts = getDrafts();
        var $item  = $('#draft-notif-item');
        var $list  = $('#draft-notif-list');
        var $count = $('#draft-notif-count');

        if (drafts.length === 0) { $item.hide(); return; }

        $item.show();
        $count.text(drafts.length);
        $list.empty();

        drafts.forEach(function (entry) {
            var ts = entry.savedAt ? new Date(entry.savedAt).toLocaleString() : '';
            $list.append(
                '<a class="dropdown-item d-flex align-items-start py-2 px-3" href="' + entry.url + '"' +
                    ' style="border-bottom:1px solid #f0f0f0;">' +
                    '<span class="mr-2 mt-1" style="color:' + entry.color + '; font-size:18px; flex-shrink:0;">' +
                        '<i class="fa ' + entry.icon + '"></i>' +
                    '</span>' +
                    '<div style="flex:1; min-width:0; overflow:hidden;">' +
                        '<div style="font-weight:600; font-size:13px; color:#212529;">' + entry.title + '</div>' +
                        '<div style="font-size:11px; color:#666; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">' +
                            (entry.label || 'Unsaved draft') +
                        '</div>' +
                        (ts ? '<div style="font-size:10px; color:#aaa; margin-top:1px;">' +
                            '<i class="fa fa-clock-o"></i> ' + ts + '</div>' : '') +
                    '</div>' +
                    '<button class="draft-discard-btn ml-2" data-key="' + entry.key + '"' +
                        ' style="background:none; border:1px solid #dc3545; border-radius:3px;' +
                        ' color:#dc3545; font-size:10px; padding:1px 6px; flex-shrink:0; cursor:pointer;"' +
                        ' title="Discard draft">' +
                        '<i class="fa fa-times"></i>' +
                    '</button>' +
                '</a>'
            );
        });
    }

    // ── Wire up events ────────────────────────────────────────────────────────
    $(document).ready(function () {
        buildDraftMenu();

        // Discard one draft
        $(document).on('click', '.draft-discard-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            localStorage.removeItem($(this).data('key'));
            buildDraftMenu();
        });

        // Clear all drafts
        $(document).on('click', '#draft-clear-all', function (e) {
            e.preventDefault();
            getDrafts().forEach(function (d) { localStorage.removeItem(d.key); });
            buildDraftMenu();
        });
    });

    // Re-scan when another tab saves/clears a draft
    window.addEventListener('storage', buildDraftMenu);
})();
</script>

<script>
$(function(){
    /* ── Active dropdown item: highlight by URL match ───────────────── */
    var path = window.location.pathname;
    $('.erp-nav .dropdown-item[href]').each(function(){
        var href = $(this).attr('href');
        if(href && href !== '#' && path.indexOf(href) === 0){
            $(this).addClass('erp-di-active');
        }
    });

    /* ── Mobile: auto-expand the active parent dropdown ─────────────── */
    if($(window).width() < 992){
        $('.erp-nav .nav-item.active').each(function(){
            var $menu = $(this).find('>.dropdown-menu');
            if($menu.length) $menu.addClass('show');
        });
    }

    /* ── Mobile: toggle dropdown-submenu on click ───────────────────── */
    $(document).on('click', '.erp-nav .dropdown-submenu > .dropdown-item', function(e){
        if($(window).width() < 992){
            e.preventDefault();
            e.stopPropagation();
            var $p = $(this).closest('.dropdown-submenu');
            $p.toggleClass('open');
            $p.siblings('.dropdown-submenu').removeClass('open');
        }
    });

    /* ── Close submenus when parent dropdown closes ─────────────────── */
    $('.erp-nav .dropdown').on('hidden.bs.dropdown', function(){
        $(this).find('.dropdown-submenu').removeClass('open');
    });
});
</script>
