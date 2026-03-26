<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(array('name' => 'Dashboard')),
));
?>
<style>
/* ================================================================
   DASHBOARD — Full Redesign
   ================================================================ */
@keyframes dbFadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.db-animate{animation:dbFadeUp .5s cubic-bezier(.22,1,.36,1) both}
.db-animate-d1{animation-delay:.05s}.db-animate-d2{animation-delay:.12s}
.db-animate-d3{animation-delay:.19s}.db-animate-d4{animation-delay:.26s}

/* ── Welcome header ── */
.db-header{display:flex;align-items:flex-start;justify-content:space-between;
    flex-wrap:wrap;gap:16px;margin-bottom:24px;padding:0 0 20px;
    border-bottom:1px solid #f3f4f6;animation:dbFadeUp .5s cubic-bezier(.22,1,.36,1) both;
    position:relative;z-index:100}
.db-header-left{display:flex;align-items:center;gap:14px;flex:1;min-width:0;}
.db-header-right{display:flex;flex-direction:column;align-items:flex-end;gap:8px}
.db-avatar{width:52px;height:52px;border-radius:14px;flex-shrink:0;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    display:flex;align-items:center;justify-content:center;
    font-size:20px;font-weight:700;color:#fff;letter-spacing:-1px;
    box-shadow:0 4px 14px rgba(99,102,241,0.35)}
.db-welcome-title{font-size:21px;font-weight:700;color:#111827;margin:0 0 3px;line-height:1.2}
.db-welcome-sub{font-size:13px;color:#6b7280;margin:0}
.db-month-progress{min-width:200px}
.db-month-label{font-size:10.5px;font-weight:700;color:#9ca3af;text-transform:uppercase;
    letter-spacing:.6px;margin-bottom:5px;display:flex;justify-content:space-between}
.db-month-label span{color:#6366f1}
.db-progress-track{height:5px;background:#f3f4f6;border-radius:99px;overflow:hidden}
.db-progress-fill{height:100%;border-radius:99px;
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    transition:width 1s cubic-bezier(.22,1,.36,1);width:0}
.db-shortcuts-hint{display:flex;gap:7px;flex-wrap:wrap;align-items:center}
.db-kbd{display:inline-flex;align-items:center;gap:4px;font-size:11px;color:#6b7280;
    background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:3px 8px;white-space:nowrap}
.db-kbd kbd{font-size:9.5px;font-weight:700;background:#e5e7eb;border-radius:3px;
    padding:1px 4px;font-family:monospace;color:#374151}

/* ── Quick search ── */
.db-search-wrap{position:relative;flex:1;max-width:320px}
.db-search-input{width:100%;height:36px;padding:0 36px 0 36px;
    border:1.5px solid #e5e7eb;border-radius:10px;font-size:13px;
    color:#111827;outline:none;background:#f9fafb;
    transition:border-color .2s,background .2s,box-shadow .2s}
.db-search-input:focus{border-color:#6366f1;background:#fff;
    box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.db-search-ico{position:absolute;left:11px;top:50%;transform:translateY(-50%);
    color:#9ca3af;font-size:13px;pointer-events:none}
.db-search-clear{position:absolute;right:10px;top:50%;transform:translateY(-50%);
    color:#9ca3af;font-size:12px;cursor:pointer;display:none;
    background:none;border:none;padding:0;line-height:1}
.db-search-drop{position:absolute;top:calc(100% + 6px);left:0;right:0;
    background:#fff;border:1px solid #f3f4f6;border-radius:12px;
    box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:999;
    overflow:hidden;display:none;animation:dbFadeUp .15s ease}
.db-search-item{display:flex;align-items:center;gap:10px;
    padding:9px 14px;cursor:pointer;text-decoration:none;
    transition:background .15s;color:#374151}
.db-search-item:hover{background:#f9fafb;text-decoration:none;color:#374151}
.db-search-item-icon{width:28px;height:28px;border-radius:7px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:12px}
.db-search-item-label{font-size:12.5px;font-weight:500}
.db-search-item-type{font-size:10px;color:#9ca3af;margin-left:auto;white-space:nowrap}
.db-search-empty{padding:14px;text-align:center;font-size:12.5px;color:#9ca3af}
.db-search-item.focused{background:#f0f0ff;color:#374151}
.db-search-section{font-size:10px;font-weight:700;text-transform:uppercase;
    letter-spacing:.7px;color:#9ca3af;padding:8px 14px 4px}

/* ── Today's snapshot strip ── */
.db-today-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;
    margin-bottom:24px;animation:dbFadeUp .5s ease .05s both}
.db-today-tile{background:#fff;border-radius:12px;padding:12px 14px;
    border:1px solid #f3f4f6;
    box-shadow:0 1px 3px rgba(0,0,0,.04);
    position:relative;overflow:hidden}
.db-today-tile::after{content:'';position:absolute;top:0;right:0;
    width:60px;height:60px;border-radius:50%;
    transform:translate(20px,-20px);opacity:.06}
.db-today-tile.ts-indigo::after{background:#6366f1}
.db-today-tile.ts-green::after {background:#22c55e}
.db-today-tile.ts-amber::after {background:#f59e0b}
.db-today-tile.ts-red::after   {background:#ef4444}
.db-today-label{font-size:10.5px;font-weight:700;text-transform:uppercase;
    letter-spacing:.6px;color:#9ca3af;margin-bottom:4px;
    display:flex;align-items:center;gap:5px}
.db-today-label i{font-size:11px}
.ts-indigo .db-today-label i{color:#6366f1}
.ts-green  .db-today-label i{color:#16a34a}
.ts-amber  .db-today-label i{color:#d97706}
.ts-red    .db-today-label i{color:#dc2626}
.db-today-val{font-size:18px;font-weight:700;color:#111827;line-height:1}
.db-today-sub{font-size:10.5px;color:#9ca3af;margin-top:3px}
.db-today-vs{display:inline-flex;align-items:center;gap:3px;font-size:10px;
    font-weight:700;margin-left:6px;padding:1px 5px;border-radius:10px}
.db-today-vs.up  {background:rgba(34,197,94,.1); color:#16a34a}
.db-today-vs.down{background:rgba(239,68,68,.1); color:#dc2626}

/* ── Section wrapper ── */
.db-section{margin-bottom:28px}
.db-section-head{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.db-section-head h6{font-size:10.5px;font-weight:700;text-transform:uppercase;
    letter-spacing:.9px;color:#9ca3af;margin:0;white-space:nowrap;
    display:flex;align-items:center;gap:6px}
.db-section-head h6::before{content:'';display:inline-block;width:7px;height:7px;
    border-radius:50%;background:#6366f1;flex-shrink:0}
.db-section-head::after{content:'';flex:1;height:1px;background:#f3f4f6}

/* ── Collapse toggle ── */
.db-section-toggle{margin-left:6px;background:none;border:none;cursor:pointer;
    color:#d1d5db;font-size:12px;padding:2px 4px;border-radius:4px;
    transition:color .15s,transform .2s;line-height:1}
.db-section-toggle:hover{color:#6366f1}
.db-section-toggle.collapsed{transform:rotate(-90deg)}
.db-section-body{overflow:hidden;transition:max-height .35s ease,opacity .3s ease}
.db-section-body.collapsed{max-height:0!important;opacity:0}

/* ── Stat cards ── */
.db-stat-card{background:#fff;border-radius:14px;padding:18px 20px;
    box-shadow:0 1px 3px rgba(0,0,0,.05),0 4px 14px rgba(0,0,0,.04);
    display:flex;align-items:center;gap:16px;border:1px solid #f3f4f6;
    transition:transform .22s,box-shadow .22s;position:relative;overflow:hidden;margin-bottom:20px}
.db-stat-card::before{content:'';position:absolute;top:0;left:0;width:4px;height:100%}
.db-stat-card::after{content:'';position:absolute;top:0;left:-80%;width:50%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.55),transparent);
    transform:skewX(-18deg);transition:left .5s;pointer-events:none}
.db-stat-card:hover::after{left:130%}
.db-stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.09)}
.c-indigo.db-stat-card::before{background:#6366f1}
.c-green.db-stat-card::before {background:#22c55e}
.c-amber.db-stat-card::before {background:#f59e0b}
.c-blue.db-stat-card::before  {background:#3b82f6}
.db-stat-icon{width:52px;height:52px;flex-shrink:0;border-radius:12px;
    display:flex;align-items:center;justify-content:center;font-size:20px;
    transition:transform .22s cubic-bezier(.34,1.56,.64,1)}
.db-stat-card:hover .db-stat-icon{transform:scale(1.1) rotate(-4deg)}
.c-indigo .db-stat-icon{background:rgba(99,102,241,.10);color:#6366f1}
.c-green  .db-stat-icon{background:rgba(34,197,94,.10); color:#16a34a}
.c-amber  .db-stat-icon{background:rgba(245,158,11,.10);color:#d97706}
.c-blue   .db-stat-icon{background:rgba(59,130,246,.10);color:#2563eb}
.db-stat-body{flex:1;min-width:0}
.db-stat-num{font-size:30px;font-weight:700;color:#111827;line-height:1;margin-bottom:4px}
.db-stat-label{font-size:12.5px;color:#6b7280;font-weight:500;display:flex;align-items:center;flex-wrap:wrap;gap:2px}

/* ── bw badge (month comparison) ── */
.bw-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;
    font-weight:700;border-radius:20px;padding:2px 7px;margin-left:4px}
.bw-badge i{font-size:9px}
.bw-up  {background:rgba(34,197,94,.12);color:#16a34a}
.bw-down{background:rgba(239,68,68,.12);color:#dc2626}

/* ── Quick action cards ── */
.db-actions-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(118px,1fr));gap:10px}
.db-action-card{background:#fff;border:1.5px solid #f3f4f6;border-radius:12px;
    padding:14px 10px 12px;text-align:center;text-decoration:none;
    display:flex;flex-direction:column;align-items:center;gap:7px;
    transition:all .2s ease;position:relative;color:#374151;
    box-shadow:0 1px 3px rgba(0,0,0,.05);overflow:hidden}
.db-action-card:hover,.db-action-card:focus{text-decoration:none;color:#374151;
    transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,0,0,.10)}
.db-action-card:hover.t-gray  {background:rgba(107,114,128,.03);border-color:rgba(107,114,128,.35)}
.db-action-card:hover.t-green {background:rgba(34,197,94,.03);  border-color:rgba(34,197,94,.4)}
.db-action-card:hover.t-purple{background:rgba(168,85,247,.03); border-color:rgba(168,85,247,.4)}
.db-action-card:hover.t-red   {background:rgba(239,68,68,.03);  border-color:rgba(239,68,68,.4)}
.db-action-card:hover.t-blue  {background:rgba(59,130,246,.03); border-color:rgba(59,130,246,.4)}
.db-action-card:hover.t-amber {background:rgba(245,158,11,.03); border-color:rgba(245,158,11,.4)}
.db-action-card:hover.t-rose  {background:rgba(244,63,94,.03);  border-color:rgba(244,63,94,.4)}
.db-action-card:hover.t-indigo{background:rgba(99,102,241,.03); border-color:rgba(99,102,241,.4)}
.db-action-card:hover.t-teal  {background:rgba(20,184,166,.03); border-color:rgba(20,184,166,.4)}
.db-action-card .db-ripple{position:absolute;border-radius:50%;transform:scale(0);
    pointer-events:none;animation:dbRipple .5s ease-out forwards;background:rgba(99,102,241,.18)}
@keyframes dbRipple{to{transform:scale(4);opacity:0}}
.db-action-icon{width:42px;height:42px;border-radius:10px;display:flex;
    align-items:center;justify-content:center;font-size:17px;
    transition:transform .22s cubic-bezier(.34,1.56,.64,1)}
.db-action-card:hover .db-action-icon{transform:scale(1.15) translateY(-1px)}
.db-action-label{font-size:11.5px;font-weight:600;color:#374151;line-height:1.3}
.db-action-label small{display:block;font-size:10px;font-weight:400;color:#9ca3af;margin-top:1px}
.db-action-badge{position:absolute;top:7px;right:7px;font-size:9px;font-weight:700;
    border-radius:6px;padding:1px 5px;max-width:68px;overflow:hidden;
    text-overflow:ellipsis;white-space:nowrap}
.t-gray   .db-action-icon,.t-gray   .db-action-badge{background:rgba(107,114,128,.1);color:#6b7280}
.t-green  .db-action-icon,.t-green  .db-action-badge{background:rgba(34,197,94,.1); color:#16a34a}
.t-purple .db-action-icon,.t-purple .db-action-badge{background:rgba(168,85,247,.1);color:#9333ea}
.t-red    .db-action-icon,.t-red    .db-action-badge{background:rgba(239,68,68,.1); color:#dc2626}
.t-blue   .db-action-icon,.t-blue   .db-action-badge{background:rgba(59,130,246,.1);color:#2563eb}
.t-amber  .db-action-icon,.t-amber  .db-action-badge{background:rgba(245,158,11,.1);color:#d97706}
.t-rose   .db-action-icon,.t-rose   .db-action-badge{background:rgba(244,63,94,.1); color:#e11d48}
.t-indigo .db-action-icon,.t-indigo .db-action-badge{background:rgba(99,102,241,.1);color:#6366f1}
.t-teal   .db-action-icon,.t-teal   .db-action-badge{background:rgba(20,184,166,.1);color:#0d9488}

/* ── Report buttons ── */
.db-report-wrap{display:flex;flex-wrap:wrap;gap:8px}
.db-report-btn{display:inline-flex;align-items:center;gap:7px;font-size:13px;
    font-weight:600;padding:8px 16px;border-radius:8px;border:1.5px solid;
    background:transparent;cursor:pointer;transition:all .18s ease;white-space:nowrap;line-height:1}
.db-report-btn i{transition:transform .2s}
.db-report-btn:hover i{transform:rotate(-6deg) scale(1.15)}
.db-report-btn.r-blue {color:#2563eb;border-color:rgba(59,130,246,.35)}
.db-report-btn.r-blue:hover {background:#2563eb;color:#fff;border-color:#2563eb;box-shadow:0 4px 14px rgba(37,99,235,.3)}
.db-report-btn.r-cyan {color:#0891b2;border-color:rgba(6,182,212,.35)}
.db-report-btn.r-cyan:hover {background:#0891b2;color:#fff;border-color:#0891b2;box-shadow:0 4px 14px rgba(8,145,178,.3)}
.db-report-btn.r-amber{color:#d97706;border-color:rgba(245,158,11,.35)}
.db-report-btn.r-amber:hover{background:#d97706;color:#fff;border-color:#d97706;box-shadow:0 4px 14px rgba(217,119,6,.3)}
.db-report-btn.r-gray {color:#6b7280;border-color:rgba(107,114,128,.35)}
.db-report-btn.r-gray:hover {background:#6b7280;color:#fff;border-color:#6b7280;box-shadow:0 4px 14px rgba(107,114,128,.3)}
.db-report-wrap .dropdown-menu{border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.12);
    border:1px solid #f3f4f6;padding:6px;min-width:215px;animation:dbFadeUp .2s ease both}
.db-report-wrap .dropdown-item{border-radius:6px;font-size:13px;padding:7px 12px;transition:background .15s}
.db-report-wrap .dropdown-item:hover{background:#f9fafb}
.db-report-wrap .dropdown-divider{margin:4px 6px}

/* ── P&L card ── */
.db-pl-card{background:#fff;border-radius:14px;padding:20px 24px;
    box-shadow:0 1px 3px rgba(0,0,0,.05),0 4px 14px rgba(0,0,0,.04);
    border:1px solid #f3f4f6;display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.db-pl-icon{width:44px;height:44px;border-radius:10px;flex-shrink:0;
    background:rgba(99,102,241,.1);color:#6366f1;
    display:flex;align-items:center;justify-content:center;font-size:18px}
.db-pl-card .input-group{flex:1;min-width:240px;max-width:400px;margin:0}
.db-pl-card .form-control{border-radius:8px 0 0 8px!important;border-color:#e5e7eb;font-size:13px;height:38px}
.db-pl-card .btn-primary{border-radius:0 8px 8px 0!important;background:#6366f1;
    border-color:#6366f1;height:38px;font-size:13px}
.db-pl-card .btn-primary:hover{background:#4f46e5;border-color:#4f46e5}

/* ── Skeleton ── */
.db-skeleton{background:linear-gradient(90deg,#f3f4f6 25%,#e9eaec 50%,#f3f4f6 75%);
    background-size:200% 100%;animation:dbSkeleton 1.4s ease infinite;border-radius:6px}
@keyframes dbSkeleton{0%{background-position:200% 0}100%{background-position:-200% 0}}

/* ── Responsive ── */
@media(max-width:768px){
    .db-stat-num{font-size:24px}.db-welcome-title{font-size:18px}
    .db-shortcuts-hint{display:none}.db-header-right{align-items:flex-start}
    .db-today-strip{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:480px){
    .db-actions-grid{grid-template-columns:repeat(3,1fr)}
    .db-stat-icon{width:42px;height:42px;font-size:17px}
    .db-pl-card{flex-direction:column;align-items:flex-start}
    .db-avatar{width:44px;height:44px;font-size:17px}
    .db-header-right{width:100%}.db-month-progress{width:100%}
    .db-today-strip{grid-template-columns:repeat(2,1fr)}
    .db-search-wrap{max-width:100%}
}
@media(max-width:340px){.db-actions-grid{grid-template-columns:repeat(2,1fr)}}
</style>

<!-- ── Welcome Header ── -->
<div class="db-header">
    <div class="db-header-left">
        <div class="db-avatar" id="db-avatar">?</div>
        <div style="min-width:0">
            <h1 class="db-welcome-title" id="db-greeting-text">Welcome back</h1>
            <p class="db-welcome-sub" id="db-datetime-text"></p>
        </div>
    </div>
    <div class="db-header-right">
        <!-- Quick search -->
        <div class="db-search-wrap">
            <i class="fa fa-search db-search-ico"></i>
            <input type="text" id="db-search-input" class="db-search-input"
                   placeholder="Search customers, products, orders…" autocomplete="off">
            <button class="db-search-clear" id="db-search-clear" title="Clear">
                <i class="fa fa-times"></i>
            </button>
            <div class="db-search-drop" id="db-search-drop"></div>
        </div>
        <div class="db-month-progress">
            <div class="db-month-label">
                <?= date('F Y') ?> &nbsp;<span id="db-month-pct">0%</span>
            </div>
            <div class="db-progress-track">
                <div class="db-progress-fill" id="db-month-fill"></div>
            </div>
        </div>
        <div class="db-shortcuts-hint">
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>S</kbd> Order</span>
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>P</kbd> Purchase</span>
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>E</kbd> Expense</span>
        </div>
    </div>
</div>

<!-- ── Today's Snapshot ── -->
<div class="db-today-strip" id="db-today-strip">
    <div class="db-today-tile ts-indigo">
        <div class="db-today-label"><i class="fa fa-shopping-cart"></i> Today's Orders</div>
        <div class="db-today-val" id="ts-orders">—</div>
        <div class="db-today-sub" id="ts-orders-sub">Loading…</div>
    </div>
    <div class="db-today-tile ts-green">
        <div class="db-today-label"><i class="fa fa-line-chart"></i> Today's Sales</div>
        <div class="db-today-val" id="ts-sales">—</div>
        <div class="db-today-sub" id="ts-sales-sub">Loading…</div>
    </div>
    <div class="db-today-tile ts-amber">
        <div class="db-today-label"><i class="fa fa-sign-in"></i> Today's Collection</div>
        <div class="db-today-val" id="ts-collection">—</div>
        <div class="db-today-sub">&nbsp;</div>
    </div>
    <div class="db-today-tile ts-red">
        <div class="db-today-label"><i class="fa fa-credit-card"></i> Today's Expense</div>
        <div class="db-today-val" id="ts-expense">—</div>
        <div class="db-today-sub">&nbsp;</div>
    </div>
</div>

<!-- ── Stat Cards ── -->
<div class="db-section db-animate db-animate-d1">
    <div class="db-section-head">
        <h6>Overview</h6>
        <button class="db-section-toggle" data-target="sec-overview" title="Collapse"><i class="fa fa-chevron-down"></i></button>
    </div>
    <div class="db-section-body" id="sec-overview">
        <?php $this->renderPartial('block-widget'); ?>
    </div>
</div>

<!-- ── Alerts ── -->
<?php if (Yii::app()->user->checkAccess('admin')): ?>
<div class="db-section db-animate db-animate-d2">
    <div class="db-section-head">
        <h6>Alerts</h6>
        <button class="db-section-toggle" data-target="sec-alerts" title="Collapse"><i class="fa fa-chevron-down"></i></button>
    </div>
    <div class="db-section-body" id="sec-alerts">
        <?php $this->renderPartial('_alerts'); ?>
    </div>
</div>
<?php endif; ?>

<!-- ── Quick Actions ── -->
<div class="db-section db-animate db-animate-d2">
    <div class="db-section-head">
        <h6>Quick Actions &mdash; <?= date('F Y') ?></h6>
        <button class="db-section-toggle" data-target="sec-actions" title="Collapse"><i class="fa fa-chevron-down"></i></button>
    </div>
    <div class="db-section-body" id="sec-actions">
        <?php $this->renderPartial('shortcut-link'); ?>
    </div>
</div>

<!-- ── Reports ── -->
<div class="db-section db-animate db-animate-d3">
    <div class="db-section-head">
        <h6>Reports</h6>
        <button class="db-section-toggle" data-target="sec-reports" title="Collapse"><i class="fa fa-chevron-down"></i></button>
    </div>
    <div class="db-section-body" id="sec-reports">
        <?php $this->renderPartial('report-shortcut'); ?>
    </div>
</div>

<?php if (Yii::app()->user->checkAccess('admin')): ?>

<!-- ── P&L Summary ── -->
<div class="db-section db-animate db-animate-d4">
    <div class="db-section-head">
        <h6>Profit &amp; Loss Analysis</h6>
        <button class="db-section-toggle" data-target="sec-pl" title="Collapse"><i class="fa fa-chevron-down"></i></button>
    </div>
    <div class="db-section-body" id="sec-pl">
        <?php $this->renderPartial('summary-widget'); ?>
    </div>
</div>

<!-- ── Analytics ── -->
<div class="db-section db-animate" style="animation-delay:.26s">
    <div class="db-section-head">
        <h6>Analytics</h6>
        <button class="db-section-toggle" data-target="sec-analytics" title="Collapse"><i class="fa fa-chevron-down"></i></button>
    </div>
    <div class="db-section-body" id="sec-analytics">
        <?php $this->renderPartial('_graph'); ?>
    </div>
</div>

<?php endif; ?>

<script>
(function () {

    /* ── Greeting + clock ── */
    function updateHeader() {
        var now=new Date(), h=now.getHours();
        var greet=h>=5&&h<12?'Good morning':h>=12&&h<17?'Good afternoon':h>=17&&h<21?'Good evening':'Good night';
        var days=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        var months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var time=now.toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'});
        var gt=document.getElementById('db-greeting-text');
        var dt=document.getElementById('db-datetime-text');
        if(gt) gt.textContent=greet+', <?= addslashes(Yii::app()->user->name) ?>';
        if(dt) dt.textContent=days[now.getDay()]+', '+now.getDate()+' '+months[now.getMonth()]+' '+now.getFullYear()+' \u00b7 '+time;
    }
    updateHeader(); setInterval(updateHeader,60000);

    /* ── Avatar initials ── */
    var av=document.getElementById('db-avatar');
    var nm='<?= addslashes(Yii::app()->user->name) ?>';
    if(av&&nm){var p=nm.trim().split(/\s+/);av.textContent=p.length>=2?(p[0][0]+p[p.length-1][0]).toUpperCase():nm.slice(0,2).toUpperCase();}

    /* ── Month progress ── */
    (function(){
        var now=new Date();
        var total=new Date(now.getFullYear(),now.getMonth()+1,0).getDate();
        var pct=Math.round(now.getDate()/total*100);
        var fill=document.getElementById('db-month-fill');
        var lbl=document.getElementById('db-month-pct');
        if(lbl) lbl.textContent=pct+'%';
        if(fill) setTimeout(function(){fill.style.width=pct+'%';},300);
    })();

    /* ── Count-up ── */
    function countUp(el,target,dur){
        var st=null;
        function step(ts){if(!st)st=ts;var p=Math.min((ts-st)/dur,1),e=1-Math.pow(1-p,3);
            el.textContent=Math.floor(e*target).toLocaleString();if(p<1)requestAnimationFrame(step);else el.textContent=target.toLocaleString();}
        requestAnimationFrame(step);
    }
    document.querySelectorAll('.db-stat-num[data-count]').forEach(function(el){
        var t=parseInt(el.getAttribute('data-count'),10);if(!isNaN(t))countUp(el,t,900);
    });

    /* ── Ripple on action cards ── */
    document.querySelectorAll('.db-action-card').forEach(function(card){
        card.addEventListener('click',function(e){
            var r=card.getBoundingClientRect(),sz=Math.max(r.width,r.height)*2;
            var rip=document.createElement('span');rip.className='db-ripple';
            rip.style.cssText='width:'+sz+'px;height:'+sz+'px;left:'+(e.clientX-r.left-sz/2)+'px;top:'+(e.clientY-r.top-sz/2)+'px;';
            card.appendChild(rip);setTimeout(function(){rip.remove();},520);
        });
    });

    /* ── Today's snapshot ── */
    function fmtMoney(n){n=parseFloat(n)||0;if(n>=1000000)return '\u09f3'+(n/1000000).toFixed(2)+'M';if(n>=1000)return '\u09f3'+(n/1000).toFixed(1)+'K';return '\u09f3'+n.toLocaleString('en-BD');}
    function vsTag(cur,prev){
        if(!prev) return '';
        var pct=Math.round((cur-prev)/prev*100);
        var cls=pct>=0?'up':'down',ico=pct>=0?'fa-arrow-up':'fa-arrow-down';
        return '<span class="db-today-vs '+cls+'"><i class="fa '+ico+'"></i>'+(pct>=0?'+':'')+pct+'%</span>';
    }
    $.ajax({url:'<?= Yii::app()->createUrl("site/todayStats") ?>',type:'POST',dataType:'json',
        success:function(res){
            if(!res.success) return;
            var d=res.data;
            document.getElementById('ts-orders').textContent=d.orderCount;
            document.getElementById('ts-orders-sub').innerHTML=fmtMoney(d.sales)+' total';
            document.getElementById('ts-sales').innerHTML=fmtMoney(d.sales)+vsTag(d.sales,d.yesterdaySales);
            document.getElementById('ts-sales-sub').innerHTML='Yesterday: '+fmtMoney(d.yesterdaySales);
            document.getElementById('ts-collection').textContent=fmtMoney(d.collection);
            document.getElementById('ts-expense').textContent=fmtMoney(d.expense);
        }
    });

    /* ── Quick search ── */
    var searchInput=document.getElementById('db-search-input');
    var searchDrop =document.getElementById('db-search-drop');
    var searchClear=document.getElementById('db-search-clear');
    var searchTimer=null;
    var typeIcons={customer:'fa-user-circle-o',product:'fa-th-large',order:'fa-shopping-cart'};
    var typeColors={customer:'rgba(34,197,94,.1)',product:'rgba(99,102,241,.1)',order:'rgba(239,68,68,.1)'};
    var typeTextColors={customer:'#16a34a',product:'#6366f1',order:'#dc2626'};

    if(searchInput){
        searchInput.addEventListener('input',function(){
            var q=this.value.trim();
            if(searchClear) searchClear.style.display=q?'block':'none';
            clearTimeout(searchTimer);
            if(q.length<2){searchDrop.style.display='none';return;}
            searchTimer=setTimeout(function(){
                $.ajax({url:'<?= Yii::app()->createUrl("site/quickSearch") ?>',type:'POST',
                    data:{q:q},dataType:'json',
                    success:function(res){
                        if(!res.results||!res.results.length){
                            searchDrop.innerHTML='<div class="db-search-empty">No results found</div>';
                        } else {
                            var html='';
                            res.results.forEach(function(r){
                                html+='<a href="'+r.url+'" class="db-search-item">'+
                                    '<span class="db-search-item-icon" style="background:'+typeColors[r.type]+';color:'+typeTextColors[r.type]+'"><i class="fa '+typeIcons[r.type]+'"></i></span>'+
                                    '<span class="db-search-item-label">'+r.label+'</span>'+
                                    '<span class="db-search-item-type">'+r.type+'</span>'+
                                    '</a>';
                            });
                            searchDrop.innerHTML=html;
                        }
                        searchDrop.style.display='block';
                        /* reset keyboard focus */
                        searchDrop.querySelectorAll('.db-search-item.focused').forEach(function(el){el.classList.remove('focused');});
                    }
                });
            },280);
        });
        if(searchClear) searchClear.addEventListener('click',function(){
            searchInput.value='';searchDrop.style.display='none';this.style.display='none';searchInput.focus();
        });
        document.addEventListener('click',function(e){
            if(!searchInput.contains(e.target)&&!searchDrop.contains(e.target))
                searchDrop.style.display='none';
        });
        searchInput.addEventListener('keydown',function(e){
            if(e.key==='Escape'){searchDrop.style.display='none';this.blur();return;}
            if(searchDrop.style.display==='none') return;
            var items=searchDrop.querySelectorAll('.db-search-item');
            if(!items.length) return;
            var cur=searchDrop.querySelector('.db-search-item.focused');
            var idx=Array.prototype.indexOf.call(items,cur);
            if(e.key==='ArrowDown'){
                e.preventDefault();
                var next=idx<items.length-1?idx+1:0;
                if(cur) cur.classList.remove('focused');
                items[next].classList.add('focused');
                items[next].scrollIntoView({block:'nearest'});
            } else if(e.key==='ArrowUp'){
                e.preventDefault();
                var prev=idx>0?idx-1:items.length-1;
                if(cur) cur.classList.remove('focused');
                items[prev].classList.add('focused');
                items[prev].scrollIntoView({block:'nearest'});
            } else if(e.key==='Enter'){
                e.preventDefault();
                if(cur) window.location.href=cur.getAttribute('href');
            }
        });
    }

    /* ── Collapsible sections ── */
    var STORE_KEY='db_collapsed';
    var collapsed=JSON.parse(localStorage.getItem(STORE_KEY)||'{}');
    document.querySelectorAll('.db-section-toggle').forEach(function(btn){
        var id=btn.getAttribute('data-target');
        var body=document.getElementById(id);
        if(!body) return;
        /* restore state */
        if(collapsed[id]){
            body.style.maxHeight='0';body.style.opacity='0';
            body.classList.add('collapsed');btn.classList.add('collapsed');
        } else {
            body.style.maxHeight=body.scrollHeight+'px';
        }
        btn.addEventListener('click',function(){
            var isCollapsed=body.classList.contains('collapsed');
            if(isCollapsed){
                body.classList.remove('collapsed');btn.classList.remove('collapsed');
                body.style.maxHeight=body.scrollHeight+'px';body.style.opacity='1';
                delete collapsed[id];
            } else {
                body.style.maxHeight=body.scrollHeight+'px';
                requestAnimationFrame(function(){
                    body.classList.add('collapsed');btn.classList.add('collapsed');
                    body.style.maxHeight='0';body.style.opacity='0';
                });
                collapsed[id]=true;
            }
            localStorage.setItem(STORE_KEY,JSON.stringify(collapsed));
        });
    });

})();

/* ── Keyboard shortcuts ── */
$(document).keydown(function(e){
    if(document.getElementById('db-search-input')===document.activeElement) return;
    if(e.ctrlKey&&e.keyCode===83){e.preventDefault();window.location.href='<?= Yii::app()->createUrl("sell/sellOrder/create") ?>';}
    if(e.ctrlKey&&e.keyCode===80){e.preventDefault();window.location.href='<?= Yii::app()->createUrl("commercial/purchaseOrder/create") ?>';}
    if(e.ctrlKey&&e.keyCode===69){e.preventDefault();window.location.href='<?= Yii::app()->createUrl("accounting/expense/create ") ?>';}
});
</script>
