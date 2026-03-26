<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Dashboard'),
    ),
));
?>

<style>
/* ================================================================
   DASHBOARD — Enhanced Responsive Design
   ================================================================ */

/* ── Entrance animation ── */
@keyframes dbFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.db-animate { animation: dbFadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both; }
.db-animate-d1 { animation-delay: 0.05s; }
.db-animate-d2 { animation-delay: 0.12s; }
.db-animate-d3 { animation-delay: 0.19s; }
.db-animate-d4 { animation-delay: 0.26s; }

/* ── Welcome header ── */
.db-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; flex-wrap: wrap;
    gap: 16px; margin-bottom: 28px;
    padding: 0 0 22px;
    border-bottom: 1px solid #f3f4f6;
    animation: dbFadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
}
.db-header-left  { display: flex; align-items: center; gap: 14px; }
.db-header-right { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; }

.db-avatar {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; font-weight: 700; color: #fff;
    box-shadow: 0 4px 14px rgba(99,102,241,0.35);
    letter-spacing: -1px;
}
.db-welcome-title {
    font-size: 21px; font-weight: 700; color: #111827;
    margin: 0 0 3px; line-height: 1.2;
}
.db-welcome-sub { font-size: 13px; color: #6b7280; margin: 0; }

/* Month progress bar */
.db-month-progress { min-width: 180px; }
.db-month-label {
    font-size: 11px; font-weight: 600; color: #9ca3af;
    text-transform: uppercase; letter-spacing: 0.6px;
    margin-bottom: 5px; display: flex; justify-content: space-between;
}
.db-month-label span { color: #6366f1; }
.db-progress-track {
    height: 5px; background: #f3f4f6; border-radius: 99px; overflow: hidden;
}
.db-progress-fill {
    height: 100%; border-radius: 99px;
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    transition: width 1s cubic-bezier(0.22,1,0.36,1);
    width: 0;
}

/* Keyboard hints */
.db-shortcuts-hint { display: flex; gap: 7px; flex-wrap: wrap; align-items: center; }
.db-kbd {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; color: #6b7280;
    background: #f9fafb; border: 1px solid #e5e7eb;
    border-radius: 6px; padding: 3px 8px;
    white-space: nowrap;
}
.db-kbd kbd {
    font-size: 9.5px; font-weight: 700;
    background: #e5e7eb; border-radius: 3px;
    padding: 1px 4px; font-family: monospace; color: #374151;
}

/* ── Section wrapper ── */
.db-section { margin-bottom: 28px; }
.db-section-head { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
.db-section-head h6 {
    font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.9px;
    color: #9ca3af; margin: 0; white-space: nowrap;
    display: flex; align-items: center; gap: 6px;
}
.db-section-head h6::before {
    content: ''; display: inline-block;
    width: 7px; height: 7px; border-radius: 50%;
    background: #6366f1; flex-shrink: 0;
}
.db-section-head::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }

/* ── Stat cards ── */
.db-stat-card {
    background: #fff; border-radius: 14px; padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 14px rgba(0,0,0,0.04);
    display: flex; align-items: center; gap: 16px;
    border: 1px solid #f3f4f6;
    transition: transform 0.22s ease, box-shadow 0.22s ease;
    position: relative; overflow: hidden; margin-bottom: 20px;
}
.db-stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%;
}
/* Shimmer on hover */
.db-stat-card::after {
    content: ''; position: absolute;
    top: 0; left: -80%; width: 50%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.55), transparent);
    transform: skewX(-18deg);
    transition: left 0.5s ease; pointer-events: none;
}
.db-stat-card:hover::after { left: 130%; }
.db-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.09); }

.db-stat-card.c-indigo::before { background: #6366f1; }
.db-stat-card.c-green::before  { background: #22c55e; }
.db-stat-card.c-amber::before  { background: #f59e0b; }
.db-stat-card.c-blue::before   { background: #3b82f6; }

.db-stat-icon {
    width: 52px; height: 52px; flex-shrink: 0; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; font-size: 20px;
    transition: transform 0.22s ease;
}
.db-stat-card:hover .db-stat-icon { transform: scale(1.1) rotate(-4deg); }

.c-indigo .db-stat-icon { background: rgba(99,102,241,0.10);  color: #6366f1; }
.c-green  .db-stat-icon { background: rgba(34,197,94,0.10);   color: #16a34a; }
.c-amber  .db-stat-icon { background: rgba(245,158,11,0.10);  color: #d97706; }
.c-blue   .db-stat-icon { background: rgba(59,130,246,0.10);  color: #2563eb; }

.db-stat-body { flex: 1; min-width: 0; }
.db-stat-num  { font-size: 30px; font-weight: 700; color: #111827; line-height: 1; margin-bottom: 4px; }
.db-stat-label { font-size: 12.5px; color: #6b7280; font-weight: 500; }

/* ── Quick action cards ── */
.db-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(118px, 1fr));
    gap: 10px;
}
.db-action-card {
    background: #fff; border: 1.5px solid #f3f4f6; border-radius: 12px;
    padding: 14px 10px 12px; text-align: center; text-decoration: none;
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease,
                background 0.2s ease;
    position: relative; color: #374151;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}
.db-action-card:hover, .db-action-card:focus {
    text-decoration: none; color: #374151;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.10);
}
/* subtle bg tint on hover per theme */
.db-action-card:hover.t-gray   { background: rgba(107,114,128,0.03); border-color: rgba(107,114,128,0.35); }
.db-action-card:hover.t-green  { background: rgba(34,197,94,0.03);   border-color: rgba(34,197,94,0.4);    }
.db-action-card:hover.t-purple { background: rgba(168,85,247,0.03);  border-color: rgba(168,85,247,0.4);   }
.db-action-card:hover.t-red    { background: rgba(239,68,68,0.03);   border-color: rgba(239,68,68,0.4);    }
.db-action-card:hover.t-blue   { background: rgba(59,130,246,0.03);  border-color: rgba(59,130,246,0.4);   }
.db-action-card:hover.t-amber  { background: rgba(245,158,11,0.03);  border-color: rgba(245,158,11,0.4);   }
.db-action-card:hover.t-rose   { background: rgba(244,63,94,0.03);   border-color: rgba(244,63,94,0.4);    }
.db-action-card:hover.t-indigo { background: rgba(99,102,241,0.03);  border-color: rgba(99,102,241,0.4);   }
.db-action-card:hover.t-teal   { background: rgba(20,184,166,0.03);  border-color: rgba(20,184,166,0.4);   }

/* ripple */
.db-action-card .db-ripple {
    position: absolute; border-radius: 50%;
    transform: scale(0); pointer-events: none;
    animation: dbRipple 0.5s ease-out forwards;
    background: rgba(99,102,241,0.18);
}
@keyframes dbRipple { to { transform: scale(4); opacity: 0; } }

.db-action-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px;
    transition: transform 0.22s cubic-bezier(0.34,1.56,0.64,1);
}
.db-action-card:hover .db-action-icon { transform: scale(1.15) translateY(-1px); }

.db-action-label { font-size: 11.5px; font-weight: 600; color: #374151; line-height: 1.3; }
.db-action-label small {
    display: block; font-size: 10px; font-weight: 400; color: #9ca3af; margin-top: 1px;
}
/* badge — color-matched per theme */
.db-action-badge {
    position: absolute; top: 7px; right: 7px;
    font-size: 9px; font-weight: 700; border-radius: 6px;
    padding: 1px 5px; max-width: 68px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.t-gray   .db-action-badge { background: rgba(107,114,128,0.1); color: #6b7280; }
.t-green  .db-action-badge { background: rgba(34,197,94,0.1);   color: #16a34a; }
.t-purple .db-action-badge { background: rgba(168,85,247,0.1);  color: #9333ea; }
.t-red    .db-action-badge { background: rgba(239,68,68,0.1);   color: #dc2626; }
.t-blue   .db-action-badge { background: rgba(59,130,246,0.1);  color: #2563eb; }
.t-amber  .db-action-badge { background: rgba(245,158,11,0.1);  color: #d97706; }
.t-rose   .db-action-badge { background: rgba(244,63,94,0.1);   color: #e11d48; }
.t-indigo .db-action-badge { background: rgba(99,102,241,0.1);  color: #6366f1; }
.t-teal   .db-action-badge { background: rgba(20,184,166,0.1);  color: #0d9488; }

/* icon colours */
.t-gray   .db-action-icon { background: rgba(107,114,128,0.1); color: #6b7280; }
.t-green  .db-action-icon { background: rgba(34,197,94,0.1);   color: #16a34a; }
.t-purple .db-action-icon { background: rgba(168,85,247,0.1);  color: #9333ea; }
.t-red    .db-action-icon { background: rgba(239,68,68,0.1);   color: #dc2626; }
.t-blue   .db-action-icon { background: rgba(59,130,246,0.1);  color: #2563eb; }
.t-amber  .db-action-icon { background: rgba(245,158,11,0.1);  color: #d97706; }
.t-rose   .db-action-icon { background: rgba(244,63,94,0.1);   color: #e11d48; }
.t-indigo .db-action-icon { background: rgba(99,102,241,0.1);  color: #6366f1; }
.t-teal   .db-action-icon { background: rgba(20,184,166,0.1);  color: #0d9488; }

/* ── Report buttons ── */
.db-report-wrap { display: flex; flex-wrap: wrap; gap: 8px; }
.db-report-btn {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 600;
    padding: 8px 16px; border-radius: 8px; border: 1.5px solid;
    background: transparent; cursor: pointer;
    transition: all 0.18s ease; white-space: nowrap; line-height: 1;
}
.db-report-btn i { transition: transform 0.2s ease; }
.db-report-btn:hover i { transform: rotate(-6deg) scale(1.15); }

.db-report-btn.r-blue  { color: #2563eb; border-color: rgba(59,130,246,0.35);  }
.db-report-btn.r-blue:hover  { background: #2563eb; color: #fff; border-color: #2563eb;  box-shadow: 0 4px 14px rgba(37,99,235,0.3); }
.db-report-btn.r-cyan  { color: #0891b2; border-color: rgba(6,182,212,0.35);   }
.db-report-btn.r-cyan:hover  { background: #0891b2; color: #fff; border-color: #0891b2;  box-shadow: 0 4px 14px rgba(8,145,178,0.3); }
.db-report-btn.r-amber { color: #d97706; border-color: rgba(245,158,11,0.35);  }
.db-report-btn.r-amber:hover { background: #d97706; color: #fff; border-color: #d97706; box-shadow: 0 4px 14px rgba(217,119,6,0.3);  }
.db-report-btn.r-gray  { color: #6b7280; border-color: rgba(107,114,128,0.35); }
.db-report-btn.r-gray:hover  { background: #6b7280; color: #fff; border-color: #6b7280;  box-shadow: 0 4px 14px rgba(107,114,128,0.3); }

.db-report-wrap .dropdown-menu {
    border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    border: 1px solid #f3f4f6; padding: 6px; min-width: 215px;
    animation: dbFadeUp 0.2s ease both;
}
.db-report-wrap .dropdown-item {
    border-radius: 6px; font-size: 13px; padding: 7px 12px; transition: background 0.15s;
}
.db-report-wrap .dropdown-item:hover { background: #f9fafb; }
.db-report-wrap .dropdown-divider { margin: 4px 6px; }

/* ── P&L card ── */
.db-pl-card {
    background: #fff; border-radius: 14px; padding: 20px 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 14px rgba(0,0,0,0.04);
    border: 1px solid #f3f4f6;
    display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.db-pl-icon {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    background: rgba(99,102,241,0.1); color: #6366f1;
    display: flex; align-items: center; justify-content: center; font-size: 18px;
}
.db-pl-label { font-size: 13px; font-weight: 600; color: #374151; white-space: nowrap; }
.db-pl-card .input-group { flex: 1; min-width: 240px; max-width: 400px; margin: 0; }
.db-pl-card .form-control {
    border-radius: 8px 0 0 8px !important; border-color: #e5e7eb; font-size: 13px; height: 38px;
}
.db-pl-card .btn-primary {
    border-radius: 0 8px 8px 0 !important; background: #6366f1; border-color: #6366f1;
    height: 38px; font-size: 13px;
}
.db-pl-card .btn-primary:hover { background: #4f46e5; border-color: #4f46e5; }

/* ── Stat skeleton (loading state) ── */
.db-skeleton {
    background: linear-gradient(90deg, #f3f4f6 25%, #e9eaec 50%, #f3f4f6 75%);
    background-size: 200% 100%;
    animation: dbSkeleton 1.4s ease infinite;
    border-radius: 6px;
}
@keyframes dbSkeleton {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .db-stat-num { font-size: 24px; }
    .db-welcome-title { font-size: 18px; }
    .db-shortcuts-hint { display: none; }
    .db-header-right { align-items: flex-start; }
    .db-month-progress { min-width: 140px; }
}
@media (max-width: 480px) {
    .db-actions-grid { grid-template-columns: repeat(3, 1fr); }
    .db-stat-icon { width: 42px; height: 42px; font-size: 17px; }
    .db-pl-card { flex-direction: column; align-items: flex-start; }
    .db-avatar { width: 44px; height: 44px; font-size: 17px; }
    .db-header-right { width: 100%; }
    .db-month-progress { width: 100%; }
}
@media (max-width: 340px) {
    .db-actions-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<!-- ── Welcome Header ── -->
<div class="db-header">
    <div class="db-header-left">
        <div class="db-avatar" id="db-avatar">?</div>
        <div>
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
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>S</kbd> Order</span>
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>P</kbd> Purchase</span>
            <span class="db-kbd"><kbd>Ctrl</kbd>+<kbd>E</kbd> Expense</span>
        </div>
    </div>
</div>

<!-- ── Stat Cards ── -->
<div class="db-section db-animate db-animate-d1">
    <div class="db-section-head"><h6>Overview</h6></div>
    <?php $this->renderPartial('block-widget'); ?>
</div>

<!-- ── Quick Actions ── -->
<div class="db-section db-animate db-animate-d2">
    <div class="db-section-head"><h6>Quick Actions &mdash; <?= date('F Y') ?></h6></div>
    <?php $this->renderPartial('shortcut-link'); ?>
</div>

<!-- ── Reports ── -->
<div class="db-section db-animate db-animate-d3">
    <div class="db-section-head"><h6>Reports</h6></div>
    <?php $this->renderPartial('report-shortcut'); ?>
</div>

<?php if (Yii::app()->user->checkAccess('admin')): ?>

<!-- ── P&L Summary ── -->
<div class="db-section db-animate db-animate-d4">
    <div class="db-section-head"><h6>Profit &amp; Loss Analysis</h6></div>
    <?php $this->renderPartial('summary-widget'); ?>
</div>

<!-- ── Analytics Charts ── -->
<div class="db-section db-animate" style="animation-delay:0.33s">
    <div class="db-section-head"><h6>Analytics</h6></div>
    <?php $this->renderPartial('_graph'); ?>
</div>

<?php endif; ?>

<script>
(function () {

    /* ── Greeting + live clock (updates every minute) ── */
    function updateHeader() {
        var now  = new Date();
        var h    = now.getHours();
        var greet =
            h >= 5  && h < 12 ? 'Good morning'   :
            h >= 12 && h < 17 ? 'Good afternoon' :
            h >= 17 && h < 21 ? 'Good evening'   : 'Good night';
        var days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var time   = now.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
        var gt = document.getElementById('db-greeting-text');
        var dt = document.getElementById('db-datetime-text');
        if (gt) gt.textContent = greet + ', <?= addslashes(Yii::app()->user->name) ?>';
        if (dt) dt.textContent = days[now.getDay()] + ', ' + now.getDate() + ' ' +
            months[now.getMonth()] + ' ' + now.getFullYear() + ' \u00b7 ' + time;
    }
    updateHeader();
    setInterval(updateHeader, 60000);

    /* ── Avatar initials ── */
    var av   = document.getElementById('db-avatar');
    var name = '<?= addslashes(Yii::app()->user->name) ?>';
    if (av && name) {
        var parts    = name.trim().split(/\s+/);
        var initials = parts.length >= 2
            ? (parts[0][0] + parts[parts.length - 1][0]).toUpperCase()
            : name.slice(0, 2).toUpperCase();
        av.textContent = initials;
    }

    /* ── Month progress bar ── */
    (function () {
        var now      = new Date();
        var total    = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
        var pct      = Math.round((now.getDate() / total) * 100);
        var fill     = document.getElementById('db-month-fill');
        var pctLabel = document.getElementById('db-month-pct');
        if (pctLabel) pctLabel.textContent = pct + '%';
        if (fill) setTimeout(function () { fill.style.width = pct + '%'; }, 300);
    })();

    /* ── Count-up animation for stat numbers ── */
    function countUp(el, target, duration) {
        var start     = 0;
        var startTime = null;
        function step(ts) {
            if (!startTime) startTime = ts;
            var progress = Math.min((ts - startTime) / duration, 1);
            var ease     = 1 - Math.pow(1 - progress, 3); /* ease-out cubic */
            el.textContent = Math.floor(ease * target).toLocaleString();
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString();
        }
        requestAnimationFrame(step);
    }
    document.querySelectorAll('.db-stat-num[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (!isNaN(target)) countUp(el, target, 900);
    });

    /* ── Ripple on action cards ── */
    document.querySelectorAll('.db-action-card').forEach(function (card) {
        card.addEventListener('click', function (e) {
            var r    = card.getBoundingClientRect();
            var size = Math.max(r.width, r.height) * 2;
            var rip  = document.createElement('span');
            rip.className  = 'db-ripple';
            rip.style.cssText =
                'width:' + size + 'px;height:' + size + 'px;' +
                'left:' + (e.clientX - r.left - size / 2) + 'px;' +
                'top:'  + (e.clientY - r.top  - size / 2) + 'px;';
            card.appendChild(rip);
            setTimeout(function () { rip.remove(); }, 520);
        });
    });

})();

/* ── Keyboard shortcuts ── */
$(document).keydown(function (e) {
    if (e.ctrlKey && e.keyCode === 83) {
        e.preventDefault();
        window.location.href = '<?= Yii::app()->createUrl("sell/sellOrder/create") ?>';
    }
    if (e.ctrlKey && e.keyCode === 80) {
        e.preventDefault();
        window.location.href = '<?= Yii::app()->createUrl("commercial/purchaseOrder/create") ?>';
    }
    if (e.ctrlKey && e.keyCode === 69) {
        e.preventDefault();
        window.location.href = '<?= Yii::app()->createUrl("accounting/expense/create ") ?>';
    }
});
</script>
