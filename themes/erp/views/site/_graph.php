<div class="card mt-3 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fa fa-chart-line text-primary"></i> Statistical Dashboard</h5>
        <button id="load-dashboard-stats" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-sync"></i> Load / Refresh Charts
        </button>
    </div>
    <div class="card-body text-center" id="charts-container">
        <p class="text-muted mb-0">📊 Click "Load / Refresh Charts" to visualize dashboard statistics.</p>
    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $('#load-dashboard-stats').on('click', function() {
        const $btn = $(this);
        const $container = $('#charts-container');
        $container.html('<p><i class="fa fa-spinner fa-spin"></i> Loading data...</p>');
        $btn.prop('disabled', true);

        $.ajax({
            url: '<?= Yii::app()->createUrl("site/dashboardStats") ?>',
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false);
                if (!res.success) {
                    $container.html('<p class="text-danger">Failed to load stats.</p>');
                    return;
                }

                const d = res.data;

                // 🔢 Formatter for numbers (BD style with commas)
                const fmt = val => {
                    if (val === null || val === undefined) return '0';
                    const n = parseFloat(val);
                    if (n >= 1_000_000) return '৳' + (n / 1_000_000).toFixed(2) + 'M';
                    if (n >= 1_000) return '৳' + (n / 1_000).toFixed(2) + 'K';
                    return '৳' + n.toLocaleString('en-BD');
                };

                $container.html(`
                    <div class="row">
                      <div class="col-md-6"><div id="chart-summary"></div></div>
                      <div class="col-md-6"><div id="chart-finance"></div></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-md-6"><div id="chart-trend"></div></div>
                      <div class="col-md-6"><div id="chart-ratio"></div></div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-md-12"><div id="chart-cashflow"></div></div>
                    </div>
                `);

                // 1️⃣ Summary Bar (Sales, Purchase, Expense)
                new ApexCharts(document.querySelector("#chart-summary"), {
                    chart: { type: 'bar', height: 300 },
                    series: [{ name: 'Amount', data: [d.sales, d.purchase, d.expense] }],
                    xaxis: { categories: ['Sales', 'Purchase', 'Expense'] },
                    colors: ['#2E86DE', '#F39C12', '#E74C3C'],
                    title: { text: 'Sales / Purchase / Expense Summary', align: 'center' },
                    dataLabels: { enabled: true, formatter: fmt },
                    tooltip: {y: { formatter: fmt }},
                    yaxis: {label: {formatter: fmt }}
                }).render();

                // 2️⃣ Finance Donut (Collection vs Payment vs Profit)
                new ApexCharts(document.querySelector("#chart-finance"), {
                    chart: { type: 'donut', height: 300 },
                    series: [d.collection, d.payment, d.profit],
                    labels: ['Collection', 'Payment', 'Profit'],
                    colors: ['#27AE60', '#8E44AD', '#3498DB'],
                    title: { text: 'Finance Overview', align: 'center' },
                    dataLabels: { enabled: true, formatter: fmt },
                    tooltip: {y: { formatter: fmt }},
                    yaxis: {label: {formatter: fmt }}
                }).render();

                // 3️⃣ Sales Trend (Line Chart)
                new ApexCharts(document.querySelector("#chart-trend"), {
                    chart: { type: 'line', height: 300 },
                    series: [
                        { name: 'Sales', data: d.trend.sales },
                        { name: 'Purchase', data: d.trend.purchase },
                        { name: 'Expense', data: d.trend.expense }
                    ],
                    xaxis: { categories: d.trend.dates },
                    stroke: { curve: 'smooth', width: 3 },
                    colors: ['#00B894', '#0984E3', '#D63031'], // green, blue, red
                    title: { text: 'Sales / Purchase / Expense Trend', align: 'center' },
                    markers: { size: 4 },
                    legend: { position: 'top' },
                    // tooltip: { shared: true, intersect: false },
                    tooltip: { shared: true, y: { formatter: fmt } },
                    yaxis: { labels: { formatter: fmt } },
                    dataLabels: { enabled: false },
                    grid: { strokeDashArray: 3 }
                }).render();

                // 4️⃣ Return vs Sales Ratio (Pie)
                new ApexCharts(document.querySelector("#chart-ratio"), {
                    chart: { type: 'pie', height: 300 },
                    series: [d.sales, d.returns],
                    labels: ['Sales', 'Return'],
                    colors: ['#3498DB', '#E74C3C'],
                    title: { text: 'Sales vs Return Ratio', align: 'center' },
                    tooltip: { y: { formatter: fmt } },
                    dataLabels: {
                        formatter: (val, opts) => fmt(opts.w.globals.series[opts.seriesIndex])
                    },
                    // legend: { position: 'bottom' }
                }).render();

                // 5️⃣ Cash Flow Bar (Inflow vs Outflow)
                new ApexCharts(document.querySelector("#chart-cashflow"), {
                    chart: { type: 'bar', height: 300, stacked: true },
                    series: [
                        { name: 'Inflow', data: [d.collection, d.sales] },
                        { name: 'Outflow', data: [d.payment, d.expense] }
                    ],
                    xaxis: { categories: ['Finance Flow'] },
                    colors: ['#2ECC71', '#E74C3C'],
                    title: { text: 'Cash Flow Overview', align: 'center' },
                    tooltip: { y: { formatter: fmt } },
                    yaxis: { labels: { formatter: fmt } },
                    dataLabels: { enabled: true, formatter: fmt }
                }).render();
            },
            error: function() {
                $container.html('<p class="text-danger">⚠️ Failed to fetch dashboard data.</p>');
                $btn.prop('disabled', false);
            }
        });
    });

</script>