<style>
.al-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;}
.al-card{background:#fff;border-radius:14px;border:1px solid #f3f4f6;
    box-shadow:0 1px 3px rgba(0,0,0,0.05),0 4px 14px rgba(0,0,0,0.04);overflow:hidden;}
.al-head{display:flex;align-items:center;gap:12px;padding:14px 18px 10px;
    border-bottom:1px solid #f9fafb;}
.al-icon{width:36px;height:36px;border-radius:9px;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:15px;}
.al-title{font-size:13px;font-weight:700;color:#111827;margin-bottom:1px;}
.al-sub  {font-size:11px;color:#9ca3af;}
.al-body {padding:0;max-height:220px;overflow-y:auto;}
.al-body::-webkit-scrollbar{width:4px;}
.al-body::-webkit-scrollbar-thumb{background:#f3f4f6;border-radius:4px;}

.al-row-item{display:flex;align-items:center;justify-content:space-between;
    padding:9px 16px;border-bottom:1px solid #fafafa;font-size:12.5px;
    transition:background 0.15s;}
.al-row-item:last-child{border-bottom:none;}
.al-row-item:hover{background:#fafafa;}
.al-row-item-name{color:#374151;font-weight:500;overflow:hidden;
    text-overflow:ellipsis;white-space:nowrap;max-width:65%;}
.al-badge-qty{font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;white-space:nowrap;}
.al-badge-qty.low {background:rgba(239,68,68,0.1);color:#dc2626;}
.al-badge-qty.ok  {background:rgba(245,158,11,0.1);color:#d97706;}
.al-badge-due{font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;
    background:rgba(239,68,68,0.1);color:#dc2626;white-space:nowrap;}

.al-empty{padding:20px;text-align:center;font-size:12.5px;color:#9ca3af;}
.al-skeleton-line{height:40px;margin:1px 0;}

@media(max-width:640px){.al-row{grid-template-columns:1fr;}}
</style>

<div class="al-row">

    <!-- Low Stock -->
    <div class="al-card">
        <div class="al-head">
            <div class="al-icon" style="background:rgba(245,158,11,0.1);color:#d97706">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div>
                <div class="al-title">Low Stock Alert</div>
                <div class="al-sub">Items with 5 or fewer units remaining</div>
            </div>
        </div>
        <div class="al-body" id="al-low-stock-body">
            <div class="al-skeleton-line db-skeleton"></div>
            <div class="al-skeleton-line db-skeleton"></div>
            <div class="al-skeleton-line db-skeleton"></div>
        </div>
    </div>

    <!-- Outstanding Dues -->
    <div class="al-card">
        <div class="al-head">
            <div class="al-icon" style="background:rgba(239,68,68,0.1);color:#dc2626">
                <i class="fa fa-clock-o"></i>
            </div>
            <div>
                <div class="al-title">Outstanding Dues</div>
                <div class="al-sub">Customers with unpaid balances</div>
            </div>
        </div>
        <div class="al-body" id="al-dues-body">
            <div class="al-skeleton-line db-skeleton"></div>
            <div class="al-skeleton-line db-skeleton"></div>
            <div class="al-skeleton-line db-skeleton"></div>
        </div>
    </div>

</div>

<script>
(function(){
    function fmt(n){
        n=parseFloat(n)||0;
        if(n>=1000000) return '\u09f3'+(n/1000000).toFixed(1)+'M';
        if(n>=1000)    return '\u09f3'+(n/1000).toFixed(1)+'K';
        return '\u09f3'+n.toLocaleString('en-BD');
    }
    $.ajax({
        url:'<?= Yii::app()->createUrl("site/alerts") ?>',
        type:'POST', dataType:'json',
        success:function(res){
            /* Low stock */
            var lsEl=document.getElementById('al-low-stock-body');
            if(res.success && res.data.lowStock.length){
                lsEl.innerHTML=res.data.lowStock.map(function(r){
                    var cls=parseInt(r.qty)===0?'low':'ok';
                    return '<div class="al-row-item">' +
                        '<span class="al-row-item-name" title="'+r.model_name+'">'+r.model_name+'</span>'+
                        '<span class="al-badge-qty '+cls+'">'+(parseInt(r.qty)===0?'Out of stock':r.qty+' left')+'</span>'+
                        '</div>';
                }).join('');
            } else {
                lsEl.innerHTML='<div class="al-empty"><i class="fa fa-check-circle" style="color:#22c55e;margin-right:6px"></i>All items are well-stocked</div>';
            }
            /* Dues */
            var dEl=document.getElementById('al-dues-body');
            if(res.success && res.data.dues.length){
                dEl.innerHTML=res.data.dues.map(function(r){
                    return '<div class="al-row-item">' +
                        '<span class="al-row-item-name" title="'+r.name+'">'+r.name+'</span>'+
                        '<span class="al-badge-due">'+fmt(r.due)+'</span>'+
                        '</div>';
                }).join('');
            } else {
                dEl.innerHTML='<div class="al-empty"><i class="fa fa-check-circle" style="color:#22c55e;margin-right:6px"></i>No outstanding dues</div>';
            }
        },
        error:function(){
            document.getElementById('al-low-stock-body').innerHTML='<div class="al-empty">Could not load data</div>';
            document.getElementById('al-dues-body').innerHTML='<div class="al-empty">Could not load data</div>';
        }
    });
})();
</script>
