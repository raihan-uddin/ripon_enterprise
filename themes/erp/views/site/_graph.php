<style>
/* ── Analytics section ── */
.ch-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px; margin-bottom: 18px;
}
.ch-toolbar-left { display: flex; align-items: center; gap: 10px; }
.ch-toolbar-title {
    font-size: 14px; font-weight: 700; color: #111827; margin: 0;
}
.ch-toolbar-sub { font-size: 12px; color: #9ca3af; }
.ch-refresh-btn {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12.5px; font-weight: 600; color: #6366f1;
    background: rgba(99,102,241,0.07); border: 1.5px solid rgba(99,102,241,0.2);
    border-radius: 8px; padding: 6px 14px; cursor: pointer;
    transition: all 0.18s ease;
}
.ch-refresh-btn:hover { background: #6366f1; color: #fff; border-color: #6366f1; }
.ch-refresh-btn i { transition: transform 0.5s ease; }
.ch-refresh-btn.loading i { animation: chSpin 0.8s linear infinite; }
@keyframes chSpin { to { transform: rotate(360deg); } }

/* ── KPI strip ── */
.ch-kpi-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px; margin-bottom: 20px;
}
.ch-kpi {
    background: #fff; border-radius: 12px;
    padding: 14px 16px;
    border: 1px solid #f3f4f6;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    position: relative; overflow: hidden;
    animation: dbFadeUp 0.4s ease both;
}
.ch-kpi::before {
    content: ''; position: absolute;
    bottom: 0; left: 0; right: 0; height: 3px;
}
.ch-kpi.k-sales::before   { background: linear-gradient(90deg,#6366f1,#8b5cf6); }
.ch-kpi.k-purchase::before { background: linear-gradient(90deg,#f59e0b,#f97316); }
.ch-kpi.k-expense::before  { background: linear-gradient(90deg,#ef4444,#f43f5e); }
.ch-kpi.k-profit::before   { background: linear-gradient(90deg,#22c55e,#10b981); }

.ch-kpi-label {
    font-size: 10.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.7px; color: #9ca3af; margin-bottom: 6px;
    display: flex; align-items: center; gap: 5px;
}
.ch-kpi-label i { font-size: 11px; }
.ch-kpi.k-sales   .ch-kpi-label i { color: #6366f1; }
.ch-kpi.k-purchase .ch-kpi-label i { color: #f59e0b; }
.ch-kpi.k-expense  .ch-kpi-label i { color: #ef4444; }
.ch-kpi.k-profit   .ch-kpi-label i { color: #22c55e; }

.ch-kpi-val {
    font-size: 19px; font-weight: 700; color: #111827; line-height: 1;
}
.ch-kpi.k-profit .ch-kpi-val.negative { color: #ef4444; }
.ch-kpi.k-profit .ch-kpi-val.positive { color: #16a34a; }

/* ── Chart cards ── */
.ch-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #f3f4f6;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 14px rgba(0,0,0,0.04);
    overflow: hidden; margin-bottom: 20px;
    animation: dbFadeUp 0.5s ease both;
}
.ch-card-head {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px 12px;
    border-bottom: 1px solid #f9fafb;
}
.ch-card-icon {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
}
.ch-card-title { font-size: 13px; font-weight: 700; color: #111827; margin-bottom: 1px; }
.ch-card-sub   { font-size: 11px; color: #9ca3af; }
.ch-card-body  { padding: 4px 8px 8px; }

/* skeleton placeholders */
.ch-skeleton-row { display: flex; gap: 12px; margin-bottom: 20px; }
.ch-skeleton-card {
    flex: 1; border-radius: 14px; overflow: hidden;
    border: 1px solid #f3f4f6;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.ch-skeleton-head { height: 56px; padding: 10px 18px; border-bottom: 1px solid #f9fafb;
    display: flex; align-items: center; gap: 10px; }
.ch-skeleton-circle { width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0; }
.ch-skeleton-line { height: 12px; border-radius: 6px; }
.ch-skeleton-lines { flex: 1; display: flex; flex-direction: column; gap: 5px; }
.ch-skeleton-chart { height: 260px; padding: 16px; display: flex; align-items: flex-end; gap: 8px; }
.ch-skeleton-bar { border-radius: 4px 4px 0 0; flex: 1; }

.ch-skeleton-kpi { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 20px; }
.ch-skeleton-kpi-card { height: 72px; border-radius: 12px; }

@media (max-width: 768px) {
    .ch-kpi-row { grid-template-columns: repeat(2,1fr); }
    .ch-skeleton-kpi { grid-template-columns: repeat(2,1fr); }
    .ch-kpi-val { font-size: 16px; }
}
@media (max-width: 480px) {
    .ch-kpi-row { grid-template-columns: repeat(2,1fr); }
}
</style>

<div class="ch-toolbar">
    <div class="ch-toolbar-left">
        <div>
            <div class="ch-toolbar-title"><i class="fa fa-line-chart" style="color:#6366f1;margin-right:7px;"></i>Statistical Dashboard</div>
            <div class="ch-toolbar-sub">Financial analytics for the current period</div>
        </div>
    </div>
    <button id="load-dashboard-stats" class="ch-refresh-btn">
        <i class="fa fa-refresh"></i> Refresh Charts
    </button>
</div>

<div id="charts-container">
    <!-- Skeleton loading state shown on first load -->
    <div id="ch-skeleton">
        <div class="ch-skeleton-kpi">
            <?php for($i=0;$i<4;$i++): ?>
            <div class="ch-skeleton-kpi-card db-skeleton"></div>
            <?php endfor; ?>
        </div>
        <div class="ch-skeleton-row">
            <?php for($i=0;$i<2;$i++): ?>
            <div class="ch-skeleton-card">
                <div class="ch-skeleton-head">
                    <div class="ch-skeleton-circle db-skeleton"></div>
                    <div class="ch-skeleton-lines">
                        <div class="ch-skeleton-line db-skeleton" style="width:55%"></div>
                        <div class="ch-skeleton-line db-skeleton" style="width:35%"></div>
                    </div>
                </div>
                <div class="ch-skeleton-chart">
                    <?php $heights=['55%','80%','45%','90%','65%','70%','40%'];
                    foreach($heights as $h): ?>
                    <div class="ch-skeleton-bar db-skeleton" style="height:<?=$h?>"></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <div class="ch-skeleton-row">
            <?php for($i=0;$i<2;$i++): ?>
            <div class="ch-skeleton-card">
                <div class="ch-skeleton-head">
                    <div class="ch-skeleton-circle db-skeleton"></div>
                    <div class="ch-skeleton-lines">
                        <div class="ch-skeleton-line db-skeleton" style="width:50%"></div>
                        <div class="ch-skeleton-line db-skeleton" style="width:30%"></div>
                    </div>
                </div>
                <div class="ch-skeleton-chart">
                    <?php $heights=['60%','85%','50%','75%','40%','95%','65%'];
                    foreach($heights as $h): ?>
                    <div class="ch-skeleton-bar db-skeleton" style="height:<?=$h?>"></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
(function () {

    var COLORS = {
        indigo: '#6366f1', purple: '#8b5cf6',
        green:  '#22c55e', emerald:'#10b981',
        amber:  '#f59e0b', orange: '#f97316',
        red:    '#ef4444', rose:   '#f43f5e',
        blue:   '#3b82f6', cyan:   '#06b6d4',
        gray:   '#9ca3af'
    };

    var fmt = function (val) {
        if (val === null || val === undefined) return '0';
        var n = parseFloat(val);
        if (n >= 1000000) return '\u09f3' + (n / 1000000).toFixed(2) + 'M';
        if (n >= 1000)    return '\u09f3' + (n / 1000).toFixed(1) + 'K';
        return '\u09f3' + n.toLocaleString('en-BD');
    };

    var BASE_CHART = {
        fontFamily: "'Source Sans Pro', 'Inter', sans-serif",
        toolbar: { show: false },
        animations: { enabled: true, easing: 'easeinout', speed: 700 }
    };

    var BASE_GRID = {
        borderColor: '#f3f4f6', strokeDashArray: 4,
        xaxis: { lines: { show: false } }
    };

    var BASE_TOOLTIP = {
        theme: 'light',
        style: { fontSize: '12px' },
        y: { formatter: fmt }
    };

    function renderCharts(d) {
        var html = '' +
            /* KPI strip */
            '<div class="ch-kpi-row" id="ch-kpi-row">' +
            '  <div class="ch-kpi k-sales"   style="animation-delay:0.05s">' +
            '    <div class="ch-kpi-label"><i class="fa fa-shopping-cart"></i> Total Sales</div>' +
            '    <div class="ch-kpi-val" id="kpi-sales">—</div>' +
            '  </div>' +
            '  <div class="ch-kpi k-purchase" style="animation-delay:0.10s">' +
            '    <div class="ch-kpi-label"><i class="fa fa-truck"></i> Total Purchase</div>' +
            '    <div class="ch-kpi-val" id="kpi-purchase">—</div>' +
            '  </div>' +
            '  <div class="ch-kpi k-expense"  style="animation-delay:0.15s">' +
            '    <div class="ch-kpi-label"><i class="fa fa-credit-card"></i> Total Expense</div>' +
            '    <div class="ch-kpi-val" id="kpi-expense">—</div>' +
            '  </div>' +
            '  <div class="ch-kpi k-profit"   style="animation-delay:0.20s">' +
            '    <div class="ch-kpi-label"><i class="fa fa-line-chart"></i> Net Profit</div>' +
            '    <div class="ch-kpi-val" id="kpi-profit">—</div>' +
            '  </div>' +
            '</div>' +
            /* Row 1: Summary bar + Finance donut */
            '<div class="row">' +
            '  <div class="col-md-7">' +
            '    <div class="ch-card" style="animation-delay:0.1s">' +
            '      <div class="ch-card-head">' +
            '        <div class="ch-card-icon" style="background:rgba(99,102,241,0.1);color:#6366f1"><i class="fa fa-bar-chart"></i></div>' +
            '        <div><div class="ch-card-title">Revenue Summary</div><div class="ch-card-sub">Sales · Purchase · Expense comparison</div></div>' +
            '      </div><div class="ch-card-body"><div id="chart-summary"></div></div>' +
            '    </div>' +
            '  </div>' +
            '  <div class="col-md-5">' +
            '    <div class="ch-card" style="animation-delay:0.15s">' +
            '      <div class="ch-card-head">' +
            '        <div class="ch-card-icon" style="background:rgba(34,197,94,0.1);color:#16a34a"><i class="fa fa-pie-chart"></i></div>' +
            '        <div><div class="ch-card-title">Finance Overview</div><div class="ch-card-sub">Collection · Payment · Profit</div></div>' +
            '      </div><div class="ch-card-body"><div id="chart-finance"></div></div>' +
            '    </div>' +
            '  </div>' +
            '</div>' +
            /* Row 2: Trend line + Return ratio */
            '<div class="row">' +
            '  <div class="col-md-8">' +
            '    <div class="ch-card" style="animation-delay:0.2s">' +
            '      <div class="ch-card-head">' +
            '        <div class="ch-card-icon" style="background:rgba(59,130,246,0.1);color:#2563eb"><i class="fa fa-line-chart"></i></div>' +
            '        <div><div class="ch-card-title">Trend Analysis</div><div class="ch-card-sub">Sales · Purchase · Expense over time</div></div>' +
            '      </div><div class="ch-card-body"><div id="chart-trend"></div></div>' +
            '    </div>' +
            '  </div>' +
            '  <div class="col-md-4">' +
            '    <div class="ch-card" style="animation-delay:0.25s">' +
            '      <div class="ch-card-head">' +
            '        <div class="ch-card-icon" style="background:rgba(239,68,68,0.1);color:#dc2626"><i class="fa fa-undo"></i></div>' +
            '        <div><div class="ch-card-title">Return Ratio</div><div class="ch-card-sub">Sales vs product returns</div></div>' +
            '      </div><div class="ch-card-body"><div id="chart-ratio"></div></div>' +
            '    </div>' +
            '  </div>' +
            '</div>' +
            /* Row 3: Cash flow full width */
            '<div class="row">' +
            '  <div class="col-12">' +
            '    <div class="ch-card" style="animation-delay:0.3s">' +
            '      <div class="ch-card-head">' +
            '        <div class="ch-card-icon" style="background:rgba(245,158,11,0.1);color:#d97706"><i class="fa fa-exchange"></i></div>' +
            '        <div><div class="ch-card-title">Cash Flow</div><div class="ch-card-sub">Inflow (Collection + Sales) vs Outflow (Payment + Expense)</div></div>' +
            '      </div><div class="ch-card-body"><div id="chart-cashflow"></div></div>' +
            '    </div>' +
            '  </div>' +
            '</div>';

        document.getElementById('charts-container').innerHTML = html;

        /* KPI values */
        document.getElementById('kpi-sales').textContent    = fmt(d.sales);
        document.getElementById('kpi-purchase').textContent = fmt(d.purchase);
        document.getElementById('kpi-expense').textContent  = fmt(d.expense);
        var profitEl = document.getElementById('kpi-profit');
        profitEl.textContent = fmt(d.profit);
        profitEl.className   = 'ch-kpi-val ' + (parseFloat(d.profit) >= 0 ? 'positive' : 'negative');

        /* 1 — Revenue Summary (grouped bar with gradient) */
        new ApexCharts(document.querySelector('#chart-summary'), {
            chart: Object.assign({}, BASE_CHART, { type: 'bar', height: 290 }),
            series: [
                { name: 'Sales',    data: [d.sales] },
                { name: 'Purchase', data: [d.purchase] },
                { name: 'Expense',  data: [d.expense] }
            ],
            xaxis: { categories: ['Current Period'], labels: { style: { fontSize: '12px' } } },
            yaxis: { labels: { formatter: fmt, style: { fontSize: '11px' } } },
            colors: [COLORS.indigo, COLORS.amber, COLORS.red],
            plotOptions: {
                bar: { horizontal: false, columnWidth: '55%', borderRadius: 6,
                       dataLabels: { position: 'top' } }
            },
            dataLabels: { enabled: true, formatter: fmt,
                          style: { fontSize: '11px', fontWeight: 600 },
                          offsetY: -22 },
            fill: {
                type: 'gradient',
                gradient: { shade: 'light', type: 'vertical',
                             shadeIntensity: 0.25, opacityFrom: 1, opacityTo: 0.82 }
            },
            legend: { position: 'top', fontSize: '12px', markers: { radius: 4 } },
            tooltip: BASE_TOOLTIP,
            grid: BASE_GRID
        }).render();

        /* 2 — Finance Donut */
        new ApexCharts(document.querySelector('#chart-finance'), {
            chart: Object.assign({}, BASE_CHART, { type: 'donut', height: 290 }),
            series: [parseFloat(d.collection)||0, parseFloat(d.payment)||0, parseFloat(d.profit)||0],
            labels: ['Collection', 'Payment', 'Profit'],
            colors: [COLORS.green, COLORS.purple, COLORS.blue],
            plotOptions: {
                pie: { donut: { size: '65%',
                    labels: { show: true,
                        total: { show: true, label: 'Total', fontSize: '13px',
                                 formatter: function (w) {
                                     return fmt(w.globals.seriesTotals.reduce(function(a,b){return a+b;},0));
                                 }
                        }
                    }
                } }
            },
            legend: { position: 'bottom', fontSize: '12px', markers: { radius: 4 } },
            dataLabels: { enabled: true, formatter: function(val){ return val.toFixed(1)+'%'; },
                          style: { fontSize: '11px' }, dropShadow: { enabled: false } },
            tooltip: BASE_TOOLTIP
        }).render();

        /* 3 — Trend Line */
        new ApexCharts(document.querySelector('#chart-trend'), {
            chart: Object.assign({}, BASE_CHART, { type: 'area', height: 290 }),
            series: [
                { name: 'Sales',    data: d.trend.sales },
                { name: 'Purchase', data: d.trend.purchase },
                { name: 'Expense',  data: d.trend.expense }
            ],
            xaxis: { categories: d.trend.dates,
                     labels: { style: { fontSize: '11px' }, rotate: -30 },
                     axisBorder: { show: false } },
            yaxis: { labels: { formatter: fmt, style: { fontSize: '11px' } } },
            colors: [COLORS.indigo, COLORS.amber, COLORS.red],
            stroke: { curve: 'smooth', width: 2.5 },
            fill: { type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.28, opacityTo: 0.03,
                                 stops: [0, 90, 100] } },
            markers: { size: 3, strokeWidth: 0 },
            legend: { position: 'top', fontSize: '12px', markers: { radius: 4 } },
            tooltip: Object.assign({}, BASE_TOOLTIP, { shared: true, intersect: false }),
            dataLabels: { enabled: false },
            grid: BASE_GRID
        }).render();

        /* 4 — Return Ratio Radial */
        var salesVal   = parseFloat(d.sales)   || 0;
        var returnsVal = parseFloat(d.returns) || 0;
        var returnPct  = salesVal > 0 ? Math.min(100, Math.round((returnsVal / salesVal) * 100)) : 0;
        new ApexCharts(document.querySelector('#chart-ratio'), {
            chart: Object.assign({}, BASE_CHART, { type: 'radialBar', height: 290 }),
            series: [returnPct, 100 - returnPct],
            labels: ['Returns', 'Net Sales'],
            colors: [COLORS.red, COLORS.indigo],
            plotOptions: {
                radialBar: {
                    offsetY: 0,
                    hollow: { size: '40%' },
                    dataLabels: {
                        name: { fontSize: '13px', fontWeight: 600 },
                        value: { fontSize: '14px', fontWeight: 700,
                                 formatter: function(v){ return v+'%'; } },
                        total: { show: true, label: 'Return Rate',
                                 formatter: function(){ return returnPct+'%'; } }
                    },
                    track: { background: '#f3f4f6', strokeWidth: '97%' }
                }
            },
            legend: { show: true, position: 'bottom', fontSize: '12px', markers: { radius: 4 } },
            tooltip: { enabled: false }
        }).render();

        /* 5 — Cash Flow horizontal bar */
        new ApexCharts(document.querySelector('#chart-cashflow'), {
            chart: Object.assign({}, BASE_CHART, { type: 'bar', height: 220 }),
            series: [
                { name: 'Inflow',  data: [parseFloat(d.collection)||0, parseFloat(d.sales)||0] },
                { name: 'Outflow', data: [parseFloat(d.payment)||0,    parseFloat(d.expense)||0] }
            ],
            xaxis: { categories: ['Collection / Payment', 'Sales / Expense'],
                     labels: { style: { fontSize: '12px' } } },
            yaxis: { labels: { formatter: fmt, style: { fontSize: '11px' } } },
            colors: [COLORS.green, COLORS.red],
            plotOptions: {
                bar: { horizontal: false, columnWidth: '45%', borderRadius: 5,
                       dataLabels: { position: 'top' } }
            },
            dataLabels: { enabled: true, formatter: fmt,
                          style: { fontSize: '11px', fontWeight: 600 }, offsetY: -22 },
            fill: {
                type: 'gradient',
                gradient: { shade: 'light', type: 'vertical',
                             shadeIntensity: 0.2, opacityFrom: 1, opacityTo: 0.85 }
            },
            legend: { position: 'top', fontSize: '12px', markers: { radius: 4 } },
            tooltip: BASE_TOOLTIP,
            grid: BASE_GRID
        }).render();
    }

    function loadStats() {
        var btn = document.getElementById('load-dashboard-stats');
        var container = document.getElementById('charts-container');
        if (btn) { btn.classList.add('loading'); btn.disabled = true; }

        $.ajax({
            url:      '<?= Yii::app()->createUrl("site/dashboardStats") ?>',
            type:     'POST',
            dataType: 'json',
            success: function (res) {
                if (btn) { btn.classList.remove('loading'); btn.disabled = false; }
                if (!res || !res.success) {
                    container.innerHTML = '<p class="text-danger" style="padding:20px"><i class="fa fa-exclamation-triangle mr-2"></i>Failed to load statistics.</p>';
                    return;
                }
                renderCharts(res.data);
            },
            error: function () {
                if (btn) { btn.classList.remove('loading'); btn.disabled = false; }
                container.innerHTML = '<p class="text-danger" style="padding:20px"><i class="fa fa-exclamation-triangle mr-2"></i>Failed to fetch dashboard data.</p>';
            }
        });
    }

    /* Auto-load on page ready */
    $(document).ready(function () {
        setTimeout(loadStats, 400);
        $('#load-dashboard-stats').on('click', loadStats);
    });

})();
</script>
