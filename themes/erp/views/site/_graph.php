<style>
/* ── Analytics ── */
.ch-toolbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:16px}
.ch-toolbar-title{font-size:14px;font-weight:700;color:#111827;margin:0}
.ch-toolbar-sub{font-size:12px;color:#9ca3af}
.ch-toolbar-right{display:flex;align-items:center;gap:8px;flex-wrap:wrap}

/* Date tabs */
.ch-date-tabs{display:flex;background:#f9fafb;border:1px solid #f3f4f6;
    border-radius:8px;padding:3px;gap:2px}
.ch-date-tab{font-size:12px;font-weight:600;color:#6b7280;padding:5px 12px;
    border-radius:6px;cursor:pointer;border:none;background:transparent;
    transition:all .15s ease;white-space:nowrap}
.ch-date-tab:hover{color:#374151;background:#fff}
.ch-date-tab.active{background:#fff;color:#6366f1;
    box-shadow:0 1px 3px rgba(0,0,0,.08)}

.ch-refresh-btn{display:inline-flex;align-items:center;gap:6px;
    font-size:12.5px;font-weight:600;color:#6366f1;
    background:rgba(99,102,241,.07);border:1.5px solid rgba(99,102,241,.2);
    border-radius:8px;padding:6px 14px;cursor:pointer;transition:all .18s}
.ch-refresh-btn:hover{background:#6366f1;color:#fff;border-color:#6366f1}
.ch-refresh-btn i{transition:transform .5s}
.ch-refresh-btn.loading i{animation:chSpin .8s linear infinite}
@keyframes chSpin{to{transform:rotate(360deg)}}

/* KPI strip */
.ch-kpi-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
.ch-kpi{background:#fff;border-radius:12px;padding:14px 16px;
    border:1px solid #f3f4f6;box-shadow:0 1px 3px rgba(0,0,0,.04);
    position:relative;overflow:hidden;animation:dbFadeUp .4s ease both}
.ch-kpi::before{content:'';position:absolute;bottom:0;left:0;right:0;height:3px}
.ch-kpi.k-sales::before  {background:linear-gradient(90deg,#6366f1,#8b5cf6)}
.ch-kpi.k-purchase::before{background:linear-gradient(90deg,#f59e0b,#f97316)}
.ch-kpi.k-expense::before {background:linear-gradient(90deg,#ef4444,#f43f5e)}
.ch-kpi.k-profit::before  {background:linear-gradient(90deg,#22c55e,#10b981)}
.ch-kpi-label{font-size:10.5px;font-weight:700;text-transform:uppercase;
    letter-spacing:.7px;color:#9ca3af;margin-bottom:6px;display:flex;align-items:center;gap:5px}
.ch-kpi-label i{font-size:11px}
.k-sales   .ch-kpi-label i{color:#6366f1}
.k-purchase .ch-kpi-label i{color:#f59e0b}
.k-expense  .ch-kpi-label i{color:#ef4444}
.k-profit   .ch-kpi-label i{color:#22c55e}
.ch-kpi-val{font-size:19px;font-weight:700;color:#111827;line-height:1}
.ch-kpi.k-profit .ch-kpi-val.negative{color:#ef4444}
.ch-kpi.k-profit .ch-kpi-val.positive{color:#16a34a}

/* Chart cards */
.ch-card{background:#fff;border-radius:14px;border:1px solid #f3f4f6;
    box-shadow:0 1px 3px rgba(0,0,0,.05),0 4px 14px rgba(0,0,0,.04);
    overflow:hidden;margin-bottom:20px;animation:dbFadeUp .5s ease both}
.ch-card-head{display:flex;align-items:center;gap:12px;padding:12px 16px 10px;
    border-bottom:1px solid #f9fafb}
.ch-card-icon{width:34px;height:34px;border-radius:8px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:14px}
.ch-card-title{font-size:13px;font-weight:700;color:#111827;margin-bottom:1px}
.ch-card-sub{font-size:11px;color:#9ca3af}
.ch-card-body{padding:4px 8px 8px}
.ch-card-actions{margin-left:auto;display:flex;gap:4px}
.ch-toggle-btn{font-size:11px;font-weight:600;color:#9ca3af;border:1px solid #f3f4f6;
    background:none;border-radius:6px;padding:3px 8px;cursor:pointer;transition:all .15s}
.ch-toggle-btn:hover,.ch-toggle-btn.active{background:#6366f1;color:#fff;border-color:#6366f1}

/* Skeletons */
.ch-skeleton-row{display:flex;gap:12px;margin-bottom:20px}
.ch-skeleton-card{flex:1;border-radius:14px;overflow:hidden;border:1px solid #f3f4f6;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.04)}
.ch-skeleton-head{height:54px;padding:10px 16px;border-bottom:1px solid #f9fafb;display:flex;align-items:center;gap:10px}
.ch-skeleton-circle{width:34px;height:34px;border-radius:8px;flex-shrink:0}
.ch-skeleton-lines{flex:1;display:flex;flex-direction:column;gap:5px}
.ch-skeleton-line{height:11px;border-radius:5px}
.ch-skeleton-chart{height:250px;padding:16px;display:flex;align-items:flex-end;gap:8px}
.ch-skeleton-bar{border-radius:4px 4px 0 0;flex:1}
.ch-skeleton-kpi{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
.ch-skeleton-kpi-card{height:72px;border-radius:12px}

@media(max-width:768px){
    .ch-kpi-row{grid-template-columns:repeat(2,1fr)}
    .ch-skeleton-kpi{grid-template-columns:repeat(2,1fr)}
    .ch-kpi-val{font-size:16px}
    .ch-date-tab{padding:4px 8px;font-size:11px}
}
</style>

<div class="ch-toolbar">
    <div>
        <div class="ch-toolbar-title"><i class="fa fa-line-chart" style="color:#6366f1;margin-right:7px"></i>Statistical Dashboard</div>
        <div class="ch-toolbar-sub" id="ch-period-label">Current month</div>
    </div>
    <div class="ch-toolbar-right">
        <div class="ch-date-tabs">
            <button class="ch-date-tab" data-range="today">Today</button>
            <button class="ch-date-tab" data-range="week">This Week</button>
            <button class="ch-date-tab active" data-range="month">This Month</button>
            <button class="ch-date-tab" data-range="year">This Year</button>
        </div>
        <button id="load-dashboard-stats" class="ch-refresh-btn">
            <i class="fa fa-refresh"></i> Refresh
        </button>
    </div>
</div>

<div id="charts-container">
    <div id="ch-skeleton">
        <div class="ch-skeleton-kpi">
            <?php for($i=0;$i<4;$i++): ?>
            <div class="ch-skeleton-kpi-card db-skeleton"></div>
            <?php endfor; ?>
        </div>
        <?php for($r=0;$r<2;$r++): ?>
        <div class="ch-skeleton-row">
            <?php $heights=[['55%','80%','45%','90%','65%','70%','40%'],['60%','85%','50%','75%','40%','95%','65%']]; ?>
            <?php foreach([0,1] as $ci): ?>
            <div class="ch-skeleton-card">
                <div class="ch-skeleton-head">
                    <div class="ch-skeleton-circle db-skeleton"></div>
                    <div class="ch-skeleton-lines">
                        <div class="ch-skeleton-line db-skeleton" style="width:55%"></div>
                        <div class="ch-skeleton-line db-skeleton" style="width:35%"></div>
                    </div>
                </div>
                <div class="ch-skeleton-chart">
                    <?php foreach($heights[$ci] as $h): ?>
                    <div class="ch-skeleton-bar db-skeleton" style="height:<?=$h?>"></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endfor; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
(function(){
    var COLORS={indigo:'#6366f1',purple:'#8b5cf6',green:'#22c55e',emerald:'#10b981',
        amber:'#f59e0b',orange:'#f97316',red:'#ef4444',rose:'#f43f5e',blue:'#3b82f6',cyan:'#06b6d4'};
    var BASE={fontFamily:"'Source Sans Pro','Inter',sans-serif",toolbar:{show:false},
        animations:{enabled:true,easing:'easeinout',speed:700}};
    var GRID={borderColor:'#f3f4f6',strokeDashArray:4,xaxis:{lines:{show:false}}};
    var fmt=function(val){
        if(val===null||val===undefined)return '0';
        var n=parseFloat(val);
        if(n>=1000000)return '\u09f3'+(n/1000000).toFixed(2)+'M';
        if(n>=1000)return '\u09f3'+(n/1000).toFixed(1)+'K';
        return '\u09f3'+n.toLocaleString('en-BD');
    };

    /* Date range helpers */
    function pad(n){return String(n).padStart(2,'0');}
    function fmtDate(d){return d.getFullYear()+'-'+pad(d.getMonth()+1)+'-'+pad(d.getDate());}
    function getRange(key){
        var now=new Date(), s,e=fmtDate(now);
        if(key==='today'){s=e;}
        else if(key==='week'){var d=new Date(now);d.setDate(d.getDate()-d.getDay());s=fmtDate(d);}
        else if(key==='month'){s=now.getFullYear()+'-'+pad(now.getMonth()+1)+'-01';}
        else{s=now.getFullYear()+'-01-01';}
        return s+' - '+e;
    }
    var labels={today:'Today',week:'This week',month:'This month',year:'This year'};

    /* Chart instances for toggle */
    var chartInstances={};

    function renderCharts(d){
        var html=
            '<div class="ch-kpi-row" id="ch-kpi-row">'+
            '<div class="ch-kpi k-sales"   style="animation-delay:.05s"><div class="ch-kpi-label"><i class="fa fa-shopping-cart"></i> Total Sales</div><div class="ch-kpi-val" id="kpi-sales">—</div></div>'+
            '<div class="ch-kpi k-purchase" style="animation-delay:.10s"><div class="ch-kpi-label"><i class="fa fa-truck"></i> Total Purchase</div><div class="ch-kpi-val" id="kpi-purchase">—</div></div>'+
            '<div class="ch-kpi k-expense"  style="animation-delay:.15s"><div class="ch-kpi-label"><i class="fa fa-credit-card"></i> Total Expense</div><div class="ch-kpi-val" id="kpi-expense">—</div></div>'+
            '<div class="ch-kpi k-profit"   style="animation-delay:.20s"><div class="ch-kpi-label"><i class="fa fa-line-chart"></i> Net Profit</div><div class="ch-kpi-val" id="kpi-profit">—</div></div>'+
            '</div>'+
            '<div class="row">'+
            '<div class="col-md-7"><div class="ch-card" style="animation-delay:.1s">'+
            '<div class="ch-card-head"><div class="ch-card-icon" style="background:rgba(99,102,241,.1);color:#6366f1"><i class="fa fa-bar-chart"></i></div>'+
            '<div><div class="ch-card-title">Revenue Summary</div><div class="ch-card-sub">Sales · Purchase · Expense</div></div>'+
            '<div class="ch-card-actions"><button class="ch-toggle-btn active" data-chart="summary" data-type="bar">Bar</button><button class="ch-toggle-btn" data-chart="summary" data-type="line">Line</button></div>'+
            '</div><div class="ch-card-body"><div id="chart-summary"></div></div></div></div>'+
            '<div class="col-md-5"><div class="ch-card" style="animation-delay:.15s">'+
            '<div class="ch-card-head"><div class="ch-card-icon" style="background:rgba(34,197,94,.1);color:#16a34a"><i class="fa fa-pie-chart"></i></div>'+
            '<div><div class="ch-card-title">Finance Overview</div><div class="ch-card-sub">Collection · Payment · Profit</div></div>'+
            '<div class="ch-card-actions"><button class="ch-toggle-btn active" data-chart="finance" data-type="donut">Donut</button><button class="ch-toggle-btn" data-chart="finance" data-type="pie">Pie</button></div>'+
            '</div><div class="ch-card-body"><div id="chart-finance"></div></div></div></div>'+
            '</div>'+
            '<div class="row">'+
            '<div class="col-md-8"><div class="ch-card" style="animation-delay:.2s">'+
            '<div class="ch-card-head"><div class="ch-card-icon" style="background:rgba(59,130,246,.1);color:#2563eb"><i class="fa fa-line-chart"></i></div>'+
            '<div><div class="ch-card-title">Trend Analysis</div><div class="ch-card-sub">Sales · Purchase · Expense over time</div></div>'+
            '<div class="ch-card-actions"><button class="ch-toggle-btn active" data-chart="trend" data-type="area">Area</button><button class="ch-toggle-btn" data-chart="trend" data-type="line">Line</button><button class="ch-toggle-btn" data-chart="trend" data-type="bar">Bar</button></div>'+
            '</div><div class="ch-card-body"><div id="chart-trend"></div></div></div></div>'+
            '<div class="col-md-4"><div class="ch-card" style="animation-delay:.25s">'+
            '<div class="ch-card-head"><div class="ch-card-icon" style="background:rgba(239,68,68,.1);color:#dc2626"><i class="fa fa-undo"></i></div>'+
            '<div><div class="ch-card-title">Return Ratio</div><div class="ch-card-sub">Sales vs returns</div></div>'+
            '</div><div class="ch-card-body"><div id="chart-ratio"></div></div></div></div>'+
            '</div>'+
            '<div class="row">'+
            '<div class="col-12"><div class="ch-card" style="animation-delay:.3s">'+
            '<div class="ch-card-head"><div class="ch-card-icon" style="background:rgba(245,158,11,.1);color:#d97706"><i class="fa fa-exchange"></i></div>'+
            '<div><div class="ch-card-title">Cash Flow</div><div class="ch-card-sub">Inflow vs Outflow comparison</div></div>'+
            '<div class="ch-card-actions"><button class="ch-toggle-btn active" data-chart="cashflow" data-type="bar">Bar</button><button class="ch-toggle-btn" data-chart="cashflow" data-type="line">Line</button></div>'+
            '</div><div class="ch-card-body"><div id="chart-cashflow"></div></div></div></div>'+
            '</div>';

        document.getElementById('charts-container').innerHTML=html;

        /* KPI values */
        document.getElementById('kpi-sales').textContent=fmt(d.sales);
        document.getElementById('kpi-purchase').textContent=fmt(d.purchase);
        document.getElementById('kpi-expense').textContent=fmt(d.expense);
        var profitEl=document.getElementById('kpi-profit');
        profitEl.textContent=fmt(d.profit);
        profitEl.className='ch-kpi-val '+(parseFloat(d.profit)>=0?'positive':'negative');

        /* 1 — Revenue Summary */
        chartInstances.summary=new ApexCharts(document.querySelector('#chart-summary'),{
            chart:Object.assign({},BASE,{type:'bar',height:290,toolbar:{show:true,tools:{download:true,selection:false,zoom:false,zoomin:false,zoomout:false,pan:false,reset:false}}}),
            series:[{name:'Sales',data:[d.sales]},{name:'Purchase',data:[d.purchase]},{name:'Expense',data:[d.expense]}],
            xaxis:{categories:['Period'],labels:{style:{fontSize:'12px'}}},
            yaxis:{labels:{formatter:fmt,style:{fontSize:'11px'}}},
            colors:[COLORS.indigo,COLORS.amber,COLORS.red],
            plotOptions:{bar:{columnWidth:'55%',borderRadius:6,dataLabels:{position:'top'}}},
            dataLabels:{enabled:true,formatter:fmt,style:{fontSize:'11px',fontWeight:600},offsetY:-22},
            fill:{type:'gradient',gradient:{shade:'light',type:'vertical',shadeIntensity:.25,opacityFrom:1,opacityTo:.82}},
            legend:{position:'top',fontSize:'12px',markers:{radius:4}},
            tooltip:{theme:'light',style:{fontSize:'12px'},y:{formatter:fmt}},grid:GRID
        });
        chartInstances.summary.render();

        /* 2 — Finance Donut */
        chartInstances.finance=new ApexCharts(document.querySelector('#chart-finance'),{
            chart:Object.assign({},BASE,{type:'donut',height:290}),
            series:[parseFloat(d.collection)||0,parseFloat(d.payment)||0,parseFloat(d.profit)||0],
            labels:['Collection','Payment','Profit'],colors:[COLORS.green,COLORS.purple,COLORS.blue],
            plotOptions:{pie:{donut:{size:'65%',labels:{show:true,total:{show:true,label:'Total',fontSize:'13px',
                formatter:function(w){return fmt(w.globals.seriesTotals.reduce(function(a,b){return a+b;},0));}}}}}},
            legend:{position:'bottom',fontSize:'12px',markers:{radius:4}},
            dataLabels:{enabled:true,formatter:function(v){return v.toFixed(1)+'%';},style:{fontSize:'11px'},dropShadow:{enabled:false}},
            tooltip:{theme:'light',y:{formatter:fmt}}
        });
        chartInstances.finance.render();

        /* 3 — Trend */
        chartInstances.trend=new ApexCharts(document.querySelector('#chart-trend'),{
            chart:Object.assign({},BASE,{type:'area',height:290}),
            series:[{name:'Sales',data:d.trend.sales},{name:'Purchase',data:d.trend.purchase},{name:'Expense',data:d.trend.expense}],
            xaxis:{categories:d.trend.dates,labels:{style:{fontSize:'11px'},rotate:-30},axisBorder:{show:false}},
            yaxis:{labels:{formatter:fmt,style:{fontSize:'11px'}}},
            colors:[COLORS.indigo,COLORS.amber,COLORS.red],
            stroke:{curve:'smooth',width:2.5},
            fill:{type:'gradient',gradient:{shadeIntensity:1,opacityFrom:.28,opacityTo:.03,stops:[0,90,100]}},
            markers:{size:3,strokeWidth:0},
            legend:{position:'top',fontSize:'12px',markers:{radius:4}},
            tooltip:{theme:'light',shared:true,intersect:false,y:{formatter:fmt}},
            dataLabels:{enabled:false},grid:GRID
        });
        chartInstances.trend.render();

        /* 4 — Return Radial */
        var salesVal=parseFloat(d.sales)||0, returnsVal=parseFloat(d.returns)||0;
        var returnPct=salesVal>0?Math.min(100,Math.round(returnsVal/salesVal*100)):0;
        chartInstances.ratio=new ApexCharts(document.querySelector('#chart-ratio'),{
            chart:Object.assign({},BASE,{type:'radialBar',height:290}),
            series:[returnPct,100-returnPct],labels:['Returns','Net Sales'],
            colors:[COLORS.red,COLORS.indigo],
            plotOptions:{radialBar:{hollow:{size:'40%'},dataLabels:{name:{fontSize:'13px',fontWeight:600},
                value:{fontSize:'14px',fontWeight:700,formatter:function(v){return v+'%';}},
                total:{show:true,label:'Return Rate',formatter:function(){return returnPct+'%';}}},
                track:{background:'#f3f4f6',strokeWidth:'97%'}}},
            legend:{show:true,position:'bottom',fontSize:'12px',markers:{radius:4}},
            tooltip:{enabled:false}
        });
        chartInstances.ratio.render();

        /* 5 — Cash Flow */
        chartInstances.cashflow=new ApexCharts(document.querySelector('#chart-cashflow'),{
            chart:Object.assign({},BASE,{type:'bar',height:220,toolbar:{show:true,tools:{download:true,selection:false,zoom:false,zoomin:false,zoomout:false,pan:false,reset:false}}}),
            series:[{name:'Inflow',data:[parseFloat(d.collection)||0,parseFloat(d.sales)||0]},{name:'Outflow',data:[parseFloat(d.payment)||0,parseFloat(d.expense)||0]}],
            xaxis:{categories:['Collection / Payment','Sales / Expense'],labels:{style:{fontSize:'12px'}}},
            yaxis:{labels:{formatter:fmt,style:{fontSize:'11px'}}},
            colors:[COLORS.green,COLORS.red],
            plotOptions:{bar:{columnWidth:'45%',borderRadius:5,dataLabels:{position:'top'}}},
            dataLabels:{enabled:true,formatter:fmt,style:{fontSize:'11px',fontWeight:600},offsetY:-22},
            fill:{type:'gradient',gradient:{shade:'light',type:'vertical',shadeIntensity:.2,opacityFrom:1,opacityTo:.85}},
            legend:{position:'top',fontSize:'12px',markers:{radius:4}},
            tooltip:{theme:'light',y:{formatter:fmt}},grid:GRID
        });
        chartInstances.cashflow.render();

        /* Chart type toggle buttons */
        document.querySelectorAll('.ch-toggle-btn[data-chart]').forEach(function(btn){
            btn.addEventListener('click',function(){
                var chartKey=btn.getAttribute('data-chart');
                var newType=btn.getAttribute('data-type');
                var inst=chartInstances[chartKey];
                if(!inst) return;
                /* update active state */
                document.querySelectorAll('.ch-toggle-btn[data-chart="'+chartKey+'"]').forEach(function(b){b.classList.remove('active');});
                btn.classList.add('active');
                /* update chart type */
                inst.updateOptions({chart:{type:newType},stroke:newType==='line'?{curve:'smooth',width:2.5}:{},
                    fill:newType==='area'?{type:'gradient',gradient:{shadeIntensity:1,opacityFrom:.28,opacityTo:.03,stops:[0,90,100]}}:(newType==='bar'?{type:'gradient',gradient:{shade:'light',type:'vertical',shadeIntensity:.25,opacityFrom:1,opacityTo:.82}}:{type:'solid'})
                });
            });
        });
    }

    var currentRange='month';
    function loadStats(range){
        range=range||currentRange;
        currentRange=range;
        var btn=document.getElementById('load-dashboard-stats');
        var container=document.getElementById('charts-container');
        if(btn){btn.classList.add('loading');btn.disabled=true;}
        var lbl=document.getElementById('ch-period-label');
        if(lbl) lbl.textContent=labels[range]||'Current period';

        $.ajax({
            url:'<?= Yii::app()->createUrl("site/dashboardStats") ?>',
            type:'POST',dataType:'json',
            data:{dateRange:getRange(range)},
            success:function(res){
                if(btn){btn.classList.remove('loading');btn.disabled=false;}
                if(!res||!res.success){
                    container.innerHTML='<p class="text-danger" style="padding:20px"><i class="fa fa-exclamation-triangle mr-2"></i>Failed to load statistics.</p>';
                    return;
                }
                renderCharts(res.data);
            },
            error:function(){
                if(btn){btn.classList.remove('loading');btn.disabled=false;}
                container.innerHTML='<p class="text-danger" style="padding:20px"><i class="fa fa-exclamation-triangle mr-2"></i>Failed to fetch data.</p>';
            }
        });
    }

    $(document).ready(function(){
        setTimeout(function(){loadStats('month');},400);
        $('#load-dashboard-stats').on('click',function(){loadStats(currentRange);});
        /* Date tab clicks */
        document.querySelectorAll('.ch-date-tab').forEach(function(tab){
            tab.addEventListener('click',function(){
                document.querySelectorAll('.ch-date-tab').forEach(function(t){t.classList.remove('active');});
                tab.classList.add('active');
                loadStats(tab.getAttribute('data-range'));
            });
        });
    });
})();
</script>
