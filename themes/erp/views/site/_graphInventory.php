<div class="card mt-3 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fa fa-boxes text-info"></i> Inventory Analytics</h5>
        <button id="load-inventory-stats" class="btn btn-outline-info btn-sm">
            <i class="fa fa-sync"></i> Load / Refresh
        </button>
    </div>
    <div class="card-body text-center" id="inventory-charts">
        <p class="text-muted">📦 Click "Load / Refresh" to visualize inventory data.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $('#load-inventory-stats').on('click', function() {
        const $btn = $(this);
        const $div = $('#inventory-charts');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $div.html('<p><i class="fa fa-spinner fa-spin"></i> Fetching inventory analytics...</p>');

        $.ajax({
            url: '<?= Yii::app()->createUrl("site/inventoryStats") ?>',
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html('<i class="fa fa-sync"></i> Refresh');
                const d = res.data;
                $div.html(`
              <div class="row">
                <div class="col-md-6"><div id="chart-trend"></div></div>
                <div class="col-md-6"><div id="chart-top"></div></div>
              </div>
              <div class="row mt-4">
                <div class="col-md-6"><div id="chart-aging"></div></div>
                <div class="col-md-6"><div id="chart-movement"></div></div>
              </div>
              <div class="row mt-4">
                <div class="col-md-12"><div id="chart-brand"></div></div>
              </div>
            `);

                // 1️⃣ Closing stock value trend
                new ApexCharts(document.querySelector("#chart-trend"), {
                    chart: { type: 'area', height: 280 },
                    series: [{
                        name: 'Stock Value',
                        data: d.closingTrend.map(i => i.value)
                    }],
                    xaxis: { categories: d.closingTrend.map(i => i.day) },
                    title: { text: 'Closing Stock Value Trend (Last 15 Days)', align: 'center' },
                    colors: ['#2E86DE'],
                    stroke: { curve: 'smooth' },
                    fill: { opacity: 0.3 }
                }).render();

                // 2️⃣ Top 10 items
                new ApexCharts(document.querySelector("#chart-top"), {
                    chart: { type: 'bar', height: 300 },
                    series: [{ name: 'Value', data: d.topItems.map(i => i.value) }],
                    xaxis: { categories: d.topItems.map(i => i.model_name) },
                    colors: ['#16A085'],
                    title: { text: 'Top 10 Items by Stock Value', align: 'center' },
                }).render();

                // 3️⃣ Stock aging
                new ApexCharts(document.querySelector("#chart-aging"), {
                    chart: { type: 'donut', height: 280 },
                    series: [
                        d.aging.days_0_30,
                        d.aging.days_31_60,
                        d.aging.days_61_90,
                        d.aging.days_90_plus
                    ],
                    labels: ['0–30 Days', '31–60', '61–90', '90+'],
                    colors: ['#27AE60', '#F39C12', '#E67E22', '#E74C3C'],
                    title: { text: 'Stock Aging Distribution', align: 'center' },
                }).render();

                // 4️⃣ Fast vs Slow
                new ApexCharts(document.querySelector("#chart-movement"), {
                    chart: { type: 'pie', height: 280 },
                    series: [d.fast, d.slow],
                    labels: ['Fast-Moving', 'Slow-Moving'],
                    colors: ['#1ABC9C', '#C0392B'],
                    title: { text: 'Fast vs Slow-Moving Products', align: 'center' },
                }).render();

                // 5️⃣ Brand-wise stock value
                new ApexCharts(document.querySelector("#chart-brand"), {
                    chart: { type: 'bar', height: 300 },
                    series: [{ name: 'Value', data: d.brandWise.map(i => i.value) }],
                    xaxis: { categories: d.brandWise.map(i => i.brand_name || 'Unknown') },
                    colors: ['#9B59B6'],
                    title: { text: 'Brand-wise Stock Value', align: 'center' },
                }).render();
            },
            error: function() {
                $div.html('<p class="text-danger">⚠️ Failed to load inventory stats.</p>');
                $btn.prop('disabled', false).html('<i class="fa fa-sync"></i> Retry');
            }
        });
    });

</script>