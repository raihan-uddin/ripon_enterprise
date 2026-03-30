<?php
/** @var integer $model_id */

$product      = ($model_id > 0) ? ProdModels::model()->findByPk($model_id) : null;
$manufacturer = ($product && $product->manufacturer_id) ? Company::model()->findByPk($product->manufacturer_id) : null;
$category     = ($product && $product->item_id)         ? ProdItems::model()->findByPk($product->item_id)             : null;
$subCategory  = ($product && $product->brand_id)        ? ProdBrands::model()->findByPk($product->brand_id)           : null;

$total = 0; $totalPositive = 0; $totalNegative = 0; $rows = [];
if ($model_id) {
    $criteria = new CDbCriteria();
    $criteria->addColumnCondition(['model_id' => $model_id]);
    $criteria->select = 'product_sl_no, sum(stock_in - stock_out) as stock_in';
    $criteria->order  = 'product_sl_no ASC';
    $criteria->group  = 'model_id, product_sl_no';
    $criteria->having = 'stock_in != 0';
    $rows = Inventory::model()->findAll($criteria);
    foreach ($rows as $r) {
        $total += $r->stock_in;
        if ($r->stock_in > 0) $totalPositive += $r->stock_in;
        else $totalNegative += $r->stock_in;
    }
}
$maxQty = 0;
foreach ($rows as $r) { if ($r->stock_in > $maxQty) $maxQty = $r->stock_in; }
?>
<style>
:root{
    --cs-accent:#4f46e5;--cs-accent2:#818cf8;
    --cs-accent-light:#eef2ff;--cs-accent-border:#c7d2fe;
    --cs-green:#15803d;--cs-red:#b91c1c;
    --cs-text:#0f172a;--cs-muted:#64748b;--cs-border:#e2e8f0;
}
.cs-wrap{font-family:'Segoe UI',system-ui,sans-serif;color:var(--cs-text);margin-bottom:24px;}

/* ─── HEADER ─── */
.cs-hdr{position:relative;border-radius:14px;overflow:hidden;
        background:linear-gradient(135deg,#312e81 0%,#4f46e5 50%,#6d28d9 100%);
        padding:20px 24px;margin-bottom:18px;
        box-shadow:0 8px 32px rgba(79,70,229,.30);}
.cs-hdr::before{content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse at 80% -10%,rgba(255,255,255,.15) 0%,transparent 55%),
               radial-gradient(ellipse at 5% 110%,rgba(167,139,250,.20) 0%,transparent 50%);
    pointer-events:none;}
.cs-hdr-inner{position:relative;display:flex;align-items:center;
              justify-content:space-between;flex-wrap:wrap;gap:12px;}
.cs-hdr-left{display:flex;align-items:center;gap:14px;}
.cs-hdr-icon{width:48px;height:48px;border-radius:12px;flex-shrink:0;
             background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
             display:flex;align-items:center;justify-content:center;
             font-size:22px;color:#fff;}
.cs-hdr-title{color:#fff;font-size:17px;font-weight:700;margin:0;line-height:1.3;}
.cs-hdr-sub{color:rgba(255,255,255,.75);font-size:12.5px;margin:2px 0 0;}
.cs-pill{display:inline-flex;align-items:center;gap:6px;
         background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
         border-radius:20px;padding:5px 13px;color:#fff;font-size:12px;}

/* ─── STATS ─── */
.cs-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));
          gap:12px;margin-bottom:18px;}
.cs-stat{border-radius:10px;padding:14px 16px;background:#fff;
         border:1px solid var(--cs-border);
         box-shadow:0 1px 6px rgba(0,0,0,.05);
         transition:transform .15s,box-shadow .15s;position:relative;overflow:hidden;}
.cs-stat:hover{transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,0,0,.08);}
.cs-stat::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:3px 3px 0 0;}
.cs-stat.indigo::before{background:linear-gradient(90deg,#4f46e5,#818cf8);}
.cs-stat.green::before{background:linear-gradient(90deg,#15803d,#22c55e);}
.cs-stat.red::before{background:linear-gradient(90deg,#991b1b,#ef4444);}
.cs-stat.slate::before{background:linear-gradient(90deg,#475569,#94a3b8);}
.cs-stat-val{font-size:22px;font-weight:800;line-height:1;color:var(--cs-text);font-variant-numeric:tabular-nums;}
.cs-stat-lbl{font-size:10.5px;color:var(--cs-muted);margin-top:5px;text-transform:uppercase;letter-spacing:.6px;font-weight:600;}
.cs-stat-icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:28px;opacity:.08;}

/* ─── TABLE ─── */
.cs-tbl-wrap{border-radius:10px;overflow:hidden;border:1px solid var(--cs-border);box-shadow:0 2px 12px rgba(0,0,0,.06);}
.cs-tbl{width:100%;border-collapse:collapse;font-size:12.5px;}
.cs-tbl thead{background:#0f172a;}
.cs-tbl thead th{color:rgba(255,255,255,.80);font-weight:600;font-size:10.5px;
                 text-transform:uppercase;letter-spacing:.7px;padding:11px 14px;border:none;white-space:nowrap;}
.cs-tbl tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s,border-left-color .12s;}
.cs-tbl tbody tr:nth-child(odd){background:#fff;}
.cs-tbl tbody tr:nth-child(even){background:#f8fafc;}
.cs-tbl tbody tr:last-child{border-bottom:none;}
.cs-tbl tbody tr:hover{background:var(--cs-accent-light);border-left:3px solid var(--cs-accent2);}
.cs-tbl tbody tr:not(:hover){border-left:3px solid transparent;}
.cs-tbl td{padding:10px 14px;vertical-align:middle;}
.cs-tbl tfoot{background:#f5f3ff;border-top:2px solid var(--cs-accent-border);}
.cs-tbl tfoot th{padding:10px 14px;border:none;font-size:12.5px;}

/* cells */
.cc-sl{width:44px;text-align:center;font-size:10.5px;color:#94a3b8;font-weight:700;}
.cc-serial{font-family:'SFMono-Regular',Consolas,monospace;font-size:13px;color:var(--cs-text);font-weight:600;}
.cc-serial-na{color:#94a3b8;font-style:italic;font-size:12px;}
.cc-qty-wrap{display:flex;align-items:center;gap:10px;}
.cc-qty-num{font-weight:800;font-size:15px;font-variant-numeric:tabular-nums;min-width:32px;text-align:right;}
.cc-qty-pos{color:var(--cs-green);}
.cc-qty-neg{color:var(--cs-red);}
.cc-qty-bar-track{flex:1;height:6px;background:#e2e8f0;border-radius:4px;overflow:hidden;min-width:50px;}
.cc-qty-bar-fill{height:100%;border-radius:4px;background:linear-gradient(90deg,#4f46e5,#818cf8);}
.cc-action{text-align:center;width:70px;}
.cc-adj-btn{display:inline-flex;align-items:center;justify-content:center;
            width:34px;height:34px;border-radius:8px;
            background:#fef2f2;border:1px solid #fecaca;
            color:#ef4444;cursor:pointer;transition:all .15s;text-decoration:none;}
.cc-adj-btn:hover{background:#ef4444;color:#fff;border-color:#ef4444;box-shadow:0 4px 12px rgba(239,68,68,.30);}
.cc-adj-btn svg{width:15px;height:15px;}
.cc-foot-lbl{text-align:right;color:var(--cs-muted);font-size:10.5px;text-transform:uppercase;letter-spacing:.5px;}
.cc-foot-val{text-align:center;font-weight:800;color:var(--cs-accent);font-size:15px;font-variant-numeric:tabular-nums;}
.cc-no-data{text-align:center;padding:48px 20px;color:var(--cs-muted);}
.cc-no-data i{font-size:36px;display:block;margin-bottom:10px;opacity:.25;}

/* ─── PRODUCT META STRIP ─── */
.cs-meta{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:18px;}
.cs-meta-item{background:#fff;border:1px solid var(--cs-border);border-radius:8px;
              padding:8px 14px;display:flex;flex-direction:column;gap:2px;min-width:110px;
              box-shadow:0 1px 4px rgba(0,0,0,.04);}
.cs-meta-lbl{font-size:9.5px;color:var(--cs-muted);text-transform:uppercase;
             letter-spacing:.6px;font-weight:600;}
.cs-meta-val{font-size:13px;font-weight:700;color:var(--cs-text);}
.cs-meta-pp{color:#1d4ed8;}
.cs-meta-sp{color:#15803d;}
@media print{
    .cs-hdr,.cs-tbl thead{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
    .cs-stat::before{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
    .cc-adj-btn{display:none;}
}
</style>

<div class="cs-wrap printAllTableForThisReport">

<!-- Header -->
<div class="cs-hdr">
  <div class="cs-hdr-inner">
    <div class="cs-hdr-left">
      <div class="cs-hdr-icon"><i class="fa fa-cubes"></i></div>
      <div>
        <p class="cs-hdr-title"><?= $product ? CHtml::encode($product->model_name) : 'Current Stock' ?></p>
        <p class="cs-hdr-sub">Batch-Wise Current Stock Levels</p>
      </div>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
      <?php if ($product && $product->code): ?>
      <div class="cs-pill"><i class="fa fa-tag"></i><?= CHtml::encode($product->code) ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Product meta -->
<div class="cs-meta">
  <?php if ($manufacturer): ?>
  <div class="cs-meta-item">
    <span class="cs-meta-lbl"><i class="fa fa-building-o"></i> Company</span>
    <span class="cs-meta-val"><?= CHtml::encode($manufacturer->name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($category): ?>
  <div class="cs-meta-item">
    <span class="cs-meta-lbl"><i class="fa fa-folder-o"></i> Category</span>
    <span class="cs-meta-val"><?= CHtml::encode($category->item_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($subCategory): ?>
  <div class="cs-meta-item">
    <span class="cs-meta-lbl"><i class="fa fa-tag"></i> Sub-Category</span>
    <span class="cs-meta-val"><?= CHtml::encode($subCategory->brand_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->purchase_price > 0): ?>
  <div class="cs-meta-item">
    <span class="cs-meta-lbl"><i class="fa fa-shopping-cart"></i> Purchase Price</span>
    <span class="cs-meta-val cs-meta-pp"><?= number_format($product->purchase_price, 2) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->sell_price > 0): ?>
  <div class="cs-meta-item">
    <span class="cs-meta-lbl"><i class="fa fa-money"></i> Sale Price</span>
    <span class="cs-meta-val cs-meta-sp"><?= number_format($product->sell_price, 2) ?></span>
  </div>
  <?php endif; ?>
</div>

<!-- Stats -->
<div class="cs-stats">
  <div class="cs-stat indigo">
    <div class="cs-stat-val"><?= count($rows) ?></div>
    <div class="cs-stat-lbl">Serial Batches</div>
    <i class="fa fa-th cs-stat-icon"></i>
  </div>
  <div class="cs-stat green">
    <div class="cs-stat-val"><?= number_format($total) ?></div>
    <div class="cs-stat-lbl">Total Stock</div>
    <i class="fa fa-cubes cs-stat-icon"></i>
  </div>
  <div class="cs-stat green">
    <div class="cs-stat-val"><?= number_format($totalPositive) ?></div>
    <div class="cs-stat-lbl">In Stock</div>
    <i class="fa fa-arrow-up cs-stat-icon"></i>
  </div>
  <?php if ($totalNegative < 0): ?>
  <div class="cs-stat red">
    <div class="cs-stat-val"><?= number_format(abs($totalNegative)) ?></div>
    <div class="cs-stat-lbl">Negative Batches</div>
    <i class="fa fa-warning cs-stat-icon"></i>
  </div>
  <?php endif; ?>
</div>

<!-- Table -->
<div class="cs-tbl-wrap">
<table class="cs-tbl">
  <thead>
    <tr>
      <th class="cc-sl">#</th>
      <th>Serial / Batch No</th>
      <th>Stock Qty</th>
      <th style="text-align:center;">Adjust</th>
    </tr>
  </thead>
  <tbody>
  <?php if (empty($rows)): ?>
    <tr><td colspan="4" class="cc-no-data">
      <i class="fa fa-inbox"></i>No stock records found for this product.
    </td></tr>
  <?php else:
    $sl = 1;
    foreach ($rows as $d):
      $barPct = $maxQty > 0 ? max(0, min(100, ($d->stock_in / $maxQty) * 100)) : 0;
      $qtyClass = $d->stock_in >= 0 ? 'cc-qty-pos' : 'cc-qty-neg';
  ?>
    <tr>
      <td class="cc-sl"><?= $sl++ ?></td>
      <td>
        <?php if ($d->product_sl_no): ?>
          <span class="cc-serial"><?= CHtml::encode($d->product_sl_no) ?></span>
        <?php else: ?>
          <span class="cc-serial-na"><i class="fa fa-minus-circle"></i> No Serial / Bulk</span>
        <?php endif; ?>
      </td>
      <td>
        <div class="cc-qty-wrap">
          <span class="cc-qty-num <?= $qtyClass ?>"><?= number_format($d->stock_in) ?></span>
          <?php if ($d->stock_in > 0 && $maxQty > 0): ?>
          <div class="cc-qty-bar-track">
            <div class="cc-qty-bar-fill" style="width:<?= $barPct ?>%;"></div>
          </div>
          <?php endif; ?>
        </div>
      </td>
      <td class="cc-action" title="Stock Adjustment">
        <a href="#" class="cc-adj-btn removeProductSlFromCurrentStock"
           data-model_id="<?= $model_id ?>"
           data-product_sl_no="<?= CHtml::encode($d->product_sl_no) ?>"
           data-model_name="<?= $product ? CHtml::encode($product->model_name) : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 7H14M10 5V9M21 7H17M3 12H7M7 10V14M21 12H10M14 19H21M17 17V21M3 19H10"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </td>
    </tr>
  <?php endforeach; endif; ?>
  </tbody>
  <?php if (!empty($rows)): ?>
  <tfoot>
    <tr>
      <th colspan="2" class="cc-foot-lbl">Total Stock</th>
      <th class="cc-foot-val"><?= number_format($total) ?></th>
      <th></th>
    </tr>
  </tfoot>
  <?php endif; ?>
</table>
</div>
</div>

<script>
$(document).ready(function(){
    $(document).off('click','.removeProductSlFromCurrentStock');
    $(document).on('click','.removeProductSlFromCurrentStock',function(e){
        e.preventDefault();
        var model_id=$(this).data('model_id'),product_sl_no=$(this).data('product_sl_no'),
            url='<?= Yii::app()->createUrl('inventory/inventory/removeProductSlFromCurrentStock') ?>',
            data={model_id:model_id,product_sl_no:product_sl_no},that=$(this),stock_given=0;
        if(!product_sl_no){
            var cs=prompt('Please enter current stock quantity for this product:');
            if(isNaN(cs)){toastr.error('Invalid stock quantity.');return;}
            if(cs!==null){data.physical_stock=cs;data.modify_stock=1;stock_given=cs;}
            else{toastr.info('Action canceled.');return;}
        }
        var remarks=prompt('Please enter remarks for this action:');
        if(remarks!==null)data.remarks=remarks;
        else{toastr.info('Action canceled.');return;}
        var msg=product_sl_no
            ?'Remove serial no from current stock? SN: '+product_sl_no
            :'Adjust stock for: '+$(this).data('model_name')+'. Current: '+stock_given;
        if(confirm(msg)){
            $.post(url,data,function(r){
                if(r.status==='success'){if(r.remove_rows==1)that.closest('tr').remove();toastr.success(r.message);}
                else toastr.error(r.message);
            },'json');
        }
    });
});
</script>
