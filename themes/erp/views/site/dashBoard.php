<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(array('name' => 'Dashboard')),
));
?>
<style>
/* ================================================================
   DASHBOARD — Full Redesign
   ================================================================ */
@keyframes dbFadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
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
.db-kbd{display:inline-flex;align-items:center;gap:4px;font-size:11px;color:#6366f1;
    background:rgba(99,102,241,.08);border:1px solid rgba(99,102,241,.25);
    border-radius:6px;padding:3px 8px;white-space:nowrap;font-weight:600}
.db-kbd kbd{font-size:9.5px;font-weight:700;background:rgba(99,102,241,.18);border-radius:3px;
    padding:1px 4px;font-family:monospace;color:#4338ca}


/* ── Today's snapshot strip ── */
.db-today-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.db-today-tile{border-radius:16px;padding:16px 18px;border:none;color:#fff;
    box-shadow:0 4px 14px rgba(0,0,0,.18);
    position:relative;overflow:hidden;
    transition:transform .22s ease,box-shadow .22s ease}
.db-today-tile:hover{transform:translateY(-3px);box-shadow:0 10px 24px rgba(0,0,0,.25)}
/* decorative orb */
.db-today-tile::before{content:'';position:absolute;top:-18px;right:-18px;
    width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,.13);pointer-events:none}
.db-today-tile.ts-indigo{background:linear-gradient(135deg,#6366f1,#4338ca);box-shadow:0 4px 14px rgba(99,102,241,.5)}
.db-today-tile.ts-green {background:linear-gradient(135deg,#22c55e,#15803d);box-shadow:0 4px 14px rgba(34,197,94,.5)}
.db-today-tile.ts-amber {background:linear-gradient(135deg,#f59e0b,#b45309);box-shadow:0 4px 14px rgba(245,158,11,.5)}
.db-today-tile.ts-red   {background:linear-gradient(135deg,#ef4444,#b91c1c);box-shadow:0 4px 14px rgba(239,68,68,.5)}
.db-today-label{font-size:10.5px;font-weight:700;text-transform:uppercase;
    letter-spacing:.6px;color:rgba(255,255,255,.8);margin-bottom:6px;
    display:flex;align-items:center;gap:5px}
.db-today-label i{font-size:11px;color:#fff}
.db-today-val{font-size:22px;font-weight:700;color:#fff;line-height:1;text-shadow:0 1px 4px rgba(0,0,0,.2)}
.db-today-sub{font-size:10.5px;color:rgba(255,255,255,.72);margin-top:4px}
.db-today-vs{display:inline-flex;align-items:center;gap:3px;font-size:10px;
    font-weight:700;margin-left:6px;padding:1px 5px;border-radius:10px}
.db-today-vs.up  {background:rgba(255,255,255,.22);color:#fff}
.db-today-vs.down{background:rgba(0,0,0,.18);color:rgba(255,255,255,.9)}

/* ── Section wrapper ── */
.db-section{margin-bottom:28px}
.db-section-head{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.db-section-head h6{font-size:11px;font-weight:800;text-transform:uppercase;
    letter-spacing:1px;color:#374151;margin:0;white-space:nowrap;
    display:flex;align-items:center;gap:7px}
.db-section-head h6::before{content:'';display:inline-block;width:8px;height:8px;
    border-radius:50%;background:linear-gradient(135deg,#6366f1,#a855f7);flex-shrink:0;
    box-shadow:0 0 0 3px rgba(99,102,241,.15)}
.db-section-head::after{content:'';flex:1;height:1.5px;
    background:linear-gradient(90deg,rgba(99,102,241,.3),transparent)}

/* ── Collapse toggle ── */
.db-section-toggle{margin-left:6px;background:none;border:none;cursor:pointer;
    color:#d1d5db;font-size:12px;padding:2px 4px;border-radius:4px;
    transition:color .15s,transform .2s;line-height:1}
.db-section-toggle:hover{color:#6366f1}
.db-section-toggle.collapsed{transform:rotate(-90deg)}
.db-section-body{overflow:hidden;transition:max-height .35s ease,opacity .3s ease}
.db-section-body.collapsed{max-height:0!important;opacity:0}

/* ── Stat cards ── */
.db-stat-card{border-radius:16px;padding:20px 22px;border:none;color:#fff;
    display:flex;align-items:center;gap:16px;
    transition:transform .22s,box-shadow .22s;position:relative;overflow:hidden;margin-bottom:20px}
/* shimmer sweep on hover */
.db-stat-card::after{content:'';position:absolute;top:0;left:-80%;width:50%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);
    transform:skewX(-18deg);transition:left .5s;pointer-events:none}
.db-stat-card:hover::after{left:130%}
/* decorative orb */
.db-stat-card::before{content:'';position:absolute;top:-22px;right:-22px;
    width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,.12);pointer-events:none}
.db-stat-card:hover{transform:translateY(-4px)}
.c-indigo.db-stat-card{background:linear-gradient(135deg,#6366f1,#4338ca);box-shadow:0 6px 20px rgba(99,102,241,.5)}
.c-green.db-stat-card {background:linear-gradient(135deg,#22c55e,#15803d);box-shadow:0 6px 20px rgba(34,197,94,.5)}
.c-amber.db-stat-card {background:linear-gradient(135deg,#f59e0b,#b45309);box-shadow:0 6px 20px rgba(245,158,11,.5)}
.c-blue.db-stat-card  {background:linear-gradient(135deg,#3b82f6,#1d4ed8);box-shadow:0 6px 20px rgba(59,130,246,.5)}
.db-stat-icon{width:54px;height:54px;flex-shrink:0;border-radius:14px;color:#fff;
    display:flex;align-items:center;justify-content:center;font-size:22px;
    background:rgba(255,255,255,.22);
    transition:transform .22s cubic-bezier(.34,1.56,.64,1)}
.db-stat-card:hover .db-stat-icon{transform:scale(1.12) rotate(-4deg);background:rgba(255,255,255,.35)}
.db-stat-body{flex:1;min-width:0}
.db-stat-num{font-size:32px;font-weight:700;color:#fff;line-height:1;margin-bottom:4px;text-shadow:0 1px 4px rgba(0,0,0,.15)}
.db-stat-label{font-size:12.5px;color:rgba(255,255,255,.82);font-weight:500;display:flex;align-items:center;flex-wrap:wrap;gap:2px}

/* ── bw badge (month comparison) ── */
.bw-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;
    font-weight:700;border-radius:20px;padding:2px 7px;margin-left:4px}
.bw-badge i{font-size:9px}
.bw-up  {background:rgba(255,255,255,.22);color:#fff}
.bw-down{background:rgba(0,0,0,.18);color:rgba(255,255,255,.9)}

/* ── Quick action cards ── */
.db-actions-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(118px,1fr));gap:12px}
.db-action-card{border-radius:16px;padding:16px 10px 13px;text-align:center;text-decoration:none;
    display:flex;flex-direction:column;align-items:center;gap:8px;border:none;color:#fff;
    transition:all .22s ease;position:relative;overflow:hidden;
    box-shadow:0 4px 14px rgba(0,0,0,.18)}
.db-action-card:hover,.db-action-card:focus{text-decoration:none;color:#fff;
    transform:translateY(-5px) scale(1.03);box-shadow:0 14px 32px rgba(0,0,0,.28)}
/* bold vivid gradients */
.db-action-card.t-gray  {background:linear-gradient(135deg,#64748b,#334155);box-shadow:0 4px 14px rgba(100,116,139,.5)}
.db-action-card.t-green {background:linear-gradient(135deg,#22c55e,#15803d);box-shadow:0 4px 14px rgba(34,197,94,.5)}
.db-action-card.t-purple{background:linear-gradient(135deg,#a855f7,#7e22ce);box-shadow:0 4px 14px rgba(168,85,247,.5)}
.db-action-card.t-red   {background:linear-gradient(135deg,#ef4444,#b91c1c);box-shadow:0 4px 14px rgba(239,68,68,.5)}
.db-action-card.t-blue  {background:linear-gradient(135deg,#3b82f6,#1d4ed8);box-shadow:0 4px 14px rgba(59,130,246,.5)}
.db-action-card.t-amber {background:linear-gradient(135deg,#f59e0b,#b45309);box-shadow:0 4px 14px rgba(245,158,11,.5)}
.db-action-card.t-rose  {background:linear-gradient(135deg,#f43f5e,#be123c);box-shadow:0 4px 14px rgba(244,63,94,.5)}
.db-action-card.t-indigo{background:linear-gradient(135deg,#6366f1,#4338ca);box-shadow:0 4px 14px rgba(99,102,241,.5)}
.db-action-card.t-teal  {background:linear-gradient(135deg,#14b8a6,#0f766e);box-shadow:0 4px 14px rgba(20,184,166,.5)}
/* hover brightens */
.db-action-card.t-gray:hover  {background:linear-gradient(135deg,#94a3b8,#475569)}
.db-action-card.t-green:hover {background:linear-gradient(135deg,#4ade80,#16a34a)}
.db-action-card.t-purple:hover{background:linear-gradient(135deg,#c084fc,#9333ea)}
.db-action-card.t-red:hover   {background:linear-gradient(135deg,#f87171,#dc2626)}
.db-action-card.t-blue:hover  {background:linear-gradient(135deg,#60a5fa,#2563eb)}
.db-action-card.t-amber:hover {background:linear-gradient(135deg,#fbbf24,#d97706)}
.db-action-card.t-rose:hover  {background:linear-gradient(135deg,#fb7185,#e11d48)}
.db-action-card.t-indigo:hover{background:linear-gradient(135deg,#818cf8,#4f46e5)}
.db-action-card.t-teal:hover  {background:linear-gradient(135deg,#2dd4bf,#0d9488)}
/* decorative glowing orb top-right */
.db-action-card::before{content:'';position:absolute;top:-20px;right:-20px;
    width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,.13);pointer-events:none}
.db-action-card .db-ripple{position:absolute;border-radius:50%;transform:scale(0);
    pointer-events:none;animation:dbRipple .5s ease-out forwards;background:rgba(255,255,255,.3)}
@keyframes dbRipple{to{transform:scale(4);opacity:0}}
.db-action-icon{width:46px;height:46px;border-radius:12px;display:flex;
    align-items:center;justify-content:center;font-size:20px;color:#fff;
    background:rgba(255,255,255,.22);
    transition:transform .22s cubic-bezier(.34,1.56,.64,1)}
.db-action-card:hover .db-action-icon{transform:scale(1.2) translateY(-2px);background:rgba(255,255,255,.35)}
.db-action-label{font-size:12px;font-weight:700;color:#fff;line-height:1.3;text-shadow:0 1px 3px rgba(0,0,0,.2)}
.db-action-label small{display:block;font-size:10px;font-weight:400;color:rgba(255,255,255,.78);margin-top:1px}
.db-action-badge{position:absolute;top:8px;right:8px;font-size:9px;font-weight:700;color:#fff;
    border-radius:6px;padding:2px 6px;max-width:68px;overflow:hidden;
    text-overflow:ellipsis;white-space:nowrap;background:rgba(0,0,0,.22)}

/* ── Report buttons ── */
.db-report-wrap{display:flex;flex-wrap:wrap;gap:10px}
.db-report-btn{display:inline-flex;align-items:center;gap:8px;font-size:13px;
    font-weight:700;padding:9px 18px;border-radius:10px;border:none;color:#fff;
    cursor:pointer;transition:all .2s ease;white-space:nowrap;line-height:1;
    position:relative;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,.18)}
.db-report-btn::before{content:'';position:absolute;top:-14px;right:-14px;
    width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.12);pointer-events:none}
.db-report-btn i{transition:transform .2s}
.db-report-btn:hover{transform:translateY(-2px);color:#fff}
.db-report-btn:hover i{transform:rotate(-6deg) scale(1.15)}
.db-report-btn.r-blue {background:linear-gradient(135deg,#3b82f6,#1d4ed8);box-shadow:0 3px 10px rgba(59,130,246,.45)}
.db-report-btn.r-blue:hover {background:linear-gradient(135deg,#60a5fa,#2563eb);box-shadow:0 8px 20px rgba(59,130,246,.5)}
.db-report-btn.r-cyan {background:linear-gradient(135deg,#06b6d4,#0e7490);box-shadow:0 3px 10px rgba(6,182,212,.45)}
.db-report-btn.r-cyan:hover {background:linear-gradient(135deg,#22d3ee,#0891b2);box-shadow:0 8px 20px rgba(6,182,212,.5)}
.db-report-btn.r-amber{background:linear-gradient(135deg,#f59e0b,#b45309);box-shadow:0 3px 10px rgba(245,158,11,.45)}
.db-report-btn.r-amber:hover{background:linear-gradient(135deg,#fbbf24,#d97706);box-shadow:0 8px 20px rgba(245,158,11,.5)}
.db-report-btn.r-gray {background:linear-gradient(135deg,#64748b,#334155);box-shadow:0 3px 10px rgba(100,116,139,.45)}
.db-report-btn.r-gray:hover {background:linear-gradient(135deg,#94a3b8,#475569);box-shadow:0 8px 20px rgba(100,116,139,.5)}
.db-report-wrap .dropdown-menu{border-radius:12px;box-shadow:0 10px 28px rgba(0,0,0,.14);
    border:1px solid #f3f4f6;padding:6px;min-width:215px;animation:dbFadeUp .2s ease both}
.db-report-wrap .dropdown-item{border-radius:6px;font-size:13px;padding:7px 12px;transition:background .15s}
.db-report-wrap .dropdown-item:hover{background:#f1f5f9}
.db-report-wrap .dropdown-divider{margin:4px 6px}

/* ── P&L card ── */
.db-pl-card{background:linear-gradient(135deg,#6366f1,#4338ca);border-radius:16px;padding:20px 24px;
    box-shadow:0 6px 20px rgba(99,102,241,.45);border:none;color:#fff;
    display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.db-pl-icon{width:46px;height:46px;border-radius:12px;flex-shrink:0;
    background:rgba(255,255,255,.22);color:#fff;
    display:flex;align-items:center;justify-content:center;font-size:20px}
.db-pl-card .input-group{flex:1;min-width:240px;max-width:400px;margin:0}
.db-pl-card .form-control{border-radius:8px 0 0 8px!important;border-color:rgba(255,255,255,.3);
    background:rgba(255,255,255,.15);color:#fff;font-size:13px;height:38px}
.db-pl-card .form-control::placeholder{color:rgba(255,255,255,.6)}
.db-pl-card .btn-primary{border-radius:0 8px 8px 0!important;background:#fff;
    border-color:#fff;color:#4338ca;height:38px;font-size:13px;font-weight:700}
.db-pl-card .btn-primary:hover{background:#e0e7ff;border-color:#e0e7ff;color:#3730a3}
.db-pl-label{font-size:14px;font-weight:700;color:#fff;margin-bottom:2px}
.db-pl-card small,.db-pl-card .text-muted{color:rgba(255,255,255,.72)!important;font-size:11.5px}

/* ── Skeleton ── */
.db-skeleton{background:linear-gradient(90deg,#f3f4f6 25%,#e9eaec 50%,#f3f4f6 75%);
    background-size:200% 100%;animation:dbSkeleton 1.4s ease infinite;border-radius:6px}
@keyframes dbSkeleton{0%{background-position:200% 0}100%{background-position:-200% 0}}

/* ── Responsive ── */
@media(max-width:768px){
    .db-stat-num{font-size:24px}.db-welcome-title{font-size:18px}
    .db-shortcuts-hint{display:none}.db-header-right{align-items:flex-start}
    .db-today-strip{grid-template-columns:repeat(2,1fr)}
    /* Report dropdowns: stack vertically, open inline below button */
    .db-report-wrap{flex-direction:column}
    .db-report-wrap .btn-group{width:100%;position:relative}
    .db-report-wrap .db-report-btn{width:100%;justify-content:space-between}
    .db-report-wrap .dropdown-menu{
        position:static!important;float:none!important;
        width:100%!important;margin-top:4px!important;
        box-shadow:0 2px 8px rgba(0,0,0,.08)!important;
        border-radius:8px!important;border-color:#f3f4f6!important}
}
@media(max-width:480px){
    .db-actions-grid{grid-template-columns:repeat(3,1fr)}
    .db-stat-icon{width:42px;height:42px;font-size:17px}
    .db-pl-card{flex-direction:column;align-items:flex-start}
    .db-avatar{width:44px;height:44px;font-size:17px}
    .db-header-right{width:100%}.db-month-progress{width:100%}
    .db-today-strip{grid-template-columns:repeat(2,1fr)}
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
        <div class="db-month-progress">
            <div class="db-month-label">
                <?= date('F Y') ?> &nbsp;<span id="db-month-pct">0%</span>
            </div>
            <div class="db-progress-track">
                <div class="db-progress-fill" id="db-month-fill"></div>
            </div>
        </div>
        <div class="db-shortcuts-hint">
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>D</kbd> Draft</span>
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>S</kbd> Order</span>
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>P</kbd> Purchase</span>
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>E</kbd> Expense</span>
        </div>
    </div>
</div>

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

<!-- ── Today's Snapshot ── -->
<div class="db-section db-animate db-animate-d2" style="animation-delay:.08s">
    <div class="db-section-head">
        <h6>Today's Snapshot &mdash; <?= date('d M Y') ?></h6>
        <button class="db-section-toggle" data-target="sec-today" title="Collapse"><i class="fa fa-chevron-down"></i></button>
    </div>
    <div class="db-section-body" id="sec-today">
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
        if(gt) gt.textContent=greet+', <?= addslashes(strtoupper(Yii::app()->user->name)) ?>';
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
            body.style.maxHeight='none';
            body.style.overflow='visible'; /* allow dropdowns to escape section boundary */
        }
        btn.addEventListener('click',function(){
            var isCollapsed=body.classList.contains('collapsed');
            if(isCollapsed){
                /* expand: animate from 0 → scrollHeight, then release to none */
                body.style.overflow='hidden'; /* clip during animation */
                body.classList.remove('collapsed');btn.classList.remove('collapsed');
                body.style.maxHeight=body.scrollHeight+'px';body.style.opacity='1';
                body.addEventListener('transitionend',function onExp(){
                    body.removeEventListener('transitionend',onExp);
                    if(!body.classList.contains('collapsed')){
                        body.style.maxHeight='none';
                        body.style.overflow='visible'; /* dropdowns work after expand */
                    }
                });
                delete collapsed[id];
            } else {
                /* collapse: pin current height first so transition has a start value */
                body.style.overflow='hidden'; /* clip during animation */
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

/* ── Strip animation after play so sections don't retain stacking contexts ── */
document.querySelectorAll('.db-section.db-animate').forEach(function(el){
    el.addEventListener('animationend', function(){
        el.style.animation  = 'none';  /* remove animation property entirely */
        el.style.opacity    = '1';
        el.style.transform  = '';      /* clear any retained transform */
    }, {once: true});
});

/* ── Report dropdown: position:fixed via MutationObserver (bypass all stacking contexts) ── */
(function(){
    var isMobile = function(){ return window.innerWidth <= 768; };

    function applyFixed($btn, $menu){
        var rect = $btn[0].getBoundingClientRect();
        $menu.css({
            position : 'fixed',
            top      : (rect.bottom + 4) + 'px',
            left     : rect.left + 'px',
            minWidth : Math.max(215, rect.width) + 'px',
            width    : 'auto',
            zIndex   : 99999
        });
    }
    function resetMenu($menu){
        $menu.css({position:'', top:'', left:'', minWidth:'', width:'', zIndex:''});
    }

    /* Watch class changes on each .btn-group — works regardless of Bootstrap version */
    document.querySelectorAll('.db-report-wrap .btn-group').forEach(function(btnGroup){
        var obs = new MutationObserver(function(){
            if(isMobile()) return;
            var $bg   = $(btnGroup);
            var $btn  = $bg.find('[data-toggle="dropdown"]');
            var $menu = $bg.find('.dropdown-menu');
            if($bg.hasClass('open') || $menu.hasClass('show')){
                applyFixed($btn, $menu);
            } else {
                resetMenu($menu);
            }
        });
        obs.observe(btnGroup, {attributes: true, attributeFilter: ['class']});
        /* Also watch the menu itself (Bootstrap 4 adds .show to the menu) */
        var menu = btnGroup.querySelector('.dropdown-menu');
        if(menu) obs.observe(menu, {attributes: true, attributeFilter: ['class']});
    });

    /* Close fixed dropdowns on scroll so menu doesn't drift from its button */
    $(window).on('scroll.dbreport', function(){
        if(!isMobile()) $('.db-report-wrap .btn-group.open').removeClass('open');
    });
})();

/* ── Keyboard shortcuts ── */
$(document).keydown(function(e){
    if(document.activeElement.tagName==='INPUT'||document.activeElement.tagName==='TEXTAREA') return;
    if(e.ctrlKey&&e.keyCode===68){e.preventDefault();window.location.href='<?= Yii::app()->createUrl("sell/sellOrderQuotation/create") ?>';} /* Ctrl+D → Draft */
    if(e.ctrlKey&&e.keyCode===83){e.preventDefault();window.location.href='<?= Yii::app()->createUrl("sell/sellOrder/create") ?>';} /* Ctrl+S → Orders */
    if(e.ctrlKey&&e.keyCode===80){e.preventDefault();window.location.href='<?= Yii::app()->createUrl("commercial/purchaseOrder/create") ?>';}
    if(e.ctrlKey&&e.keyCode===69){e.preventDefault();window.location.href='<?= Yii::app()->createUrl("accounting/expense/create") ?>';}
});
</script>
