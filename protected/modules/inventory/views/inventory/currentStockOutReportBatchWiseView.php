<?php
/** @var integer $model_id */
/** @var integer $start_date */
/** @var integer $end_date */

$product      = $model_id > 0 ? ProdModels::model()->findByPk($model_id) : null;
$productName  = $product ? $product->model_name : '—';
$productCode  = $product ? $product->code : '';
$manufacturer = ($product && $product->manufacturer_id) ? Company::model()->findByPk($product->manufacturer_id) : null;
$category     = ($product && $product->item_id)         ? ProdItems::model()->findByPk($product->item_id)             : null;
$subCategory  = ($product && $product->brand_id)        ? ProdBrands::model()->findByPk($product->brand_id)           : null;

$isSingleDay = ($start_date == $end_date);
$dateLabel   = $isSingleDay
    ? date('d M Y', $start_date)
    : date('d M Y', $start_date) . ' – ' . date('d M Y', $end_date);

$total = 0; $totalValue = 0; $rows = [];
if ($model_id) {
    $criteria = new CDbCriteria();
    $criteria->addColumnCondition(['model_id' => $model_id, 'is_deleted' => 0]);
    $criteria->addBetweenCondition('date', date('Y-m-d', $start_date), date('Y-m-d', $end_date));
    $criteria->addCondition('stock_out != 0');
    $criteria->select = 'id, product_sl_no, stock_in, stock_out, stock_status, master_id, source_id, date, sell_price, challan_no, remarks, create_time';
    $criteria->order  = 'date ASC, id ASC';
    $rows = Inventory::model()->findAll($criteria);
    foreach ($rows as $r) {
        $total      += $r->stock_out;
        $totalValue += $r->stock_out * $r->sell_price;
    }
}
$uniqueDays = $isSingleDay ? 1 : ceil(($end_date - $start_date) / 86400) + 1;
?>
<style>
:root {
    --so-accent: #b91c1c;
    --so-accent2: #ef4444;
    --so-accent-light: #fff5f5;
    --so-accent-border: #fecaca;
    --so-red: #b91c1c;
    --so-text: #0f172a;
    --so-muted: #64748b;
    --so-border: #e2e8f0;
    --so-row-alt: #f8fafc;
}
.so-wrap{font-family:'Segoe UI',system-ui,sans-serif;color:var(--so-text);margin-bottom:24px;}

/* ─── HEADER ─── */
.so-hdr{position:relative;border-radius:14px;overflow:hidden;
        background:linear-gradient(135deg,#7f1d1d 0%,#b91c1c 55%,#dc2626 100%);
        padding:20px 24px;margin-bottom:18px;
        box-shadow:0 8px 32px rgba(185,28,28,.28);}
.so-hdr::before{content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse at 80% -10%,rgba(255,255,255,.12) 0%,transparent 55%),
               radial-gradient(ellipse at 10% 120%,rgba(252,165,165,.15) 0%,transparent 50%);
    pointer-events:none;}
.so-hdr-inner{position:relative;display:flex;align-items:center;
              justify-content:space-between;flex-wrap:wrap;gap:12px;}
.so-hdr-left{display:flex;align-items:center;gap:14px;}
.so-hdr-icon{width:48px;height:48px;border-radius:12px;flex-shrink:0;
             background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
             display:flex;align-items:center;justify-content:center;
             font-size:22px;color:#fff;backdrop-filter:blur(4px);}
.so-hdr-title{color:#fff;font-size:17px;font-weight:700;margin:0;line-height:1.3;}
.so-hdr-sub{color:rgba(255,255,255,.75);font-size:12.5px;margin:2px 0 0;}
.so-hdr-right{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.so-pill{display:inline-flex;align-items:center;gap:6px;
         background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
         border-radius:20px;padding:5px 13px;color:#fff;font-size:12px;backdrop-filter:blur(4px);}

/* ─── STAT CARDS ─── */
.so-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));
          gap:12px;margin-bottom:18px;}
.so-stat{border-radius:10px;padding:14px 16px;
         background:#fff;border:1px solid var(--so-border);
         box-shadow:0 1px 6px rgba(0,0,0,.05);
         transition:transform .15s,box-shadow .15s;position:relative;overflow:hidden;}
.so-stat:hover{transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,0,0,.08);}
.so-stat::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:3px 3px 0 0;}
.so-stat.red::before{background:linear-gradient(90deg,#991b1b,#ef4444);}
.so-stat.orange::before{background:linear-gradient(90deg,#c2410c,#fb923c);}
.so-stat.rose::before{background:linear-gradient(90deg,#9f1239,#fb7185);}
.so-stat.slate::before{background:linear-gradient(90deg,#475569,#94a3b8);}
.so-stat-val{font-size:22px;font-weight:800;line-height:1;color:var(--so-text);
             font-variant-numeric:tabular-nums;}
.so-stat-lbl{font-size:10.5px;color:var(--so-muted);margin-top:5px;
             text-transform:uppercase;letter-spacing:.6px;font-weight:600;}
.so-stat-icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);
              font-size:28px;opacity:.08;color:var(--so-text);}

/* ─── TABLE ─── */
.so-tbl-wrap{border-radius:10px;overflow:hidden;
             border:1px solid var(--so-border);
             box-shadow:0 2px 12px rgba(0,0,0,.06);}
.so-tbl{width:100%;border-collapse:collapse;font-size:12.5px;}
.so-tbl thead{background:#0f172a;}
.so-tbl thead th{color:rgba(255,255,255,.80);font-weight:600;font-size:10.5px;
                 text-transform:uppercase;letter-spacing:.7px;
                 padding:11px 13px;border:none;white-space:nowrap;}
.so-tbl tbody tr{border-bottom:1px solid #f1f5f9;
                 transition:background .12s,border-left-color .12s;}
.so-tbl tbody tr:nth-child(odd){background:#fff;}
.so-tbl tbody tr:nth-child(even){background:var(--so-row-alt);}
.so-tbl tbody tr:last-child{border-bottom:none;}
.so-tbl tbody tr:hover{background:var(--so-accent-light);border-left:3px solid var(--so-accent2);}
.so-tbl tbody tr:not(:hover){border-left:3px solid transparent;}
.so-tbl td{padding:9px 13px;vertical-align:middle;}
.so-tbl tfoot{background:#fff5f5;border-top:2px solid var(--so-accent-border);}
.so-tbl tfoot th{padding:10px 13px;border:none;font-size:12.5px;}

/* ─── CELL TYPES ─── */
.co-sl{width:44px;text-align:center;font-size:10.5px;color:#94a3b8;font-weight:700;}
.co-date .co-date-main{color:var(--so-text);font-weight:600;font-size:12px;}
.co-date .co-date-time{color:var(--so-muted);font-size:10.5px;margin-top:1px;}
.co-ref{font-family:'SFMono-Regular',Consolas,monospace;font-size:11.5px;}
.co-ref-main{color:var(--so-red);font-weight:700;}
.co-ref-sub{color:var(--so-muted);font-size:10px;margin-top:2px;}
.co-party-name{color:var(--so-text);font-weight:600;font-size:12.5px;}
.co-party-contact{color:var(--so-muted);font-size:10.5px;margin-top:2px;}
.co-price{text-align:right;font-family:'SFMono-Regular',Consolas,monospace;
          font-size:12px;color:#374151;font-variant-numeric:tabular-nums;}
.co-qty{text-align:center;font-weight:800;font-size:14px;
        color:var(--so-red);font-variant-numeric:tabular-nums;}
.co-total{text-align:right;font-family:'SFMono-Regular',Consolas,monospace;
          font-size:12.5px;font-weight:700;color:#7c3aed;font-variant-numeric:tabular-nums;}
.co-running{text-align:center;font-family:'SFMono-Regular',Consolas,monospace;
            font-size:12px;font-weight:700;color:var(--so-red);font-variant-numeric:tabular-nums;}
.co-remarks{font-size:11.5px;color:var(--so-muted);max-width:160px;
            overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.co-foot-lbl{text-align:right;color:var(--so-muted);font-size:10.5px;
             text-transform:uppercase;letter-spacing:.5px;}
.co-foot-qty{text-align:center;font-weight:800;color:var(--so-red);font-size:15px;}
.co-foot-val{text-align:right;font-weight:800;color:#7c3aed;font-size:13px;
             font-family:'SFMono-Regular',Consolas,monospace;}
.co-no-data{text-align:center;padding:48px 20px;color:var(--so-muted);}
.co-no-data i{font-size:36px;display:block;margin-bottom:10px;opacity:.25;}

/* ─── STATUS BADGE ─── */
.so-badge{display:inline-flex;align-items:center;gap:4px;
          font-size:10px;font-weight:700;padding:3px 9px;
          border-radius:20px;white-space:nowrap;letter-spacing:.3px;}
.so-badge-sales{background:#fee2e2;color:#991b1b;}
.so-badge-manual{background:#fef9c3;color:#854d0e;}
.so-badge-warranty{background:#fdf4ff;color:#7e22ce;}
.so-badge-replace{background:#fff7ed;color:#c2410c;}
.so-badge-return{background:#ecfdf5;color:#065f46;}
.so-bg-secondary{background:#f1f5f9;color:#475569;}

/* ─── PRODUCT META STRIP ─── */
.so-meta{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:18px;}
.so-meta-item{background:#fff;border:1px solid var(--so-border);border-radius:8px;
              padding:8px 14px;display:flex;flex-direction:column;gap:2px;min-width:110px;
              box-shadow:0 1px 4px rgba(0,0,0,.04);}
.so-meta-lbl{font-size:9.5px;color:var(--so-muted);text-transform:uppercase;
             letter-spacing:.6px;font-weight:600;}
.so-meta-val{font-size:13px;font-weight:700;color:var(--so-text);}
.so-meta-pp{color:#1d4ed8;}
.so-meta-sp{color:#15803d;}
@media print{
    .so-hdr,.so-tbl thead{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
    .so-stat::before{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
}
</style>

<div class="so-wrap printAllTableForThisReport">

<!-- Header -->
<div class="so-hdr">
  <div class="so-hdr-inner">
    <div class="so-hdr-left">
      <div class="so-hdr-icon"><i class="fa fa-arrow-circle-up"></i></div>
      <div>
        <p class="so-hdr-title">Stock-Out Report — Batch Wise</p>
        <p class="so-hdr-sub">
          <?= CHtml::encode($productName) ?>
          <?php if ($productCode): ?><span style="opacity:.7;margin-left:6px;font-size:11px;">(<?= CHtml::encode($productCode) ?>)</span><?php endif; ?>
        </p>
      </div>
    </div>
    <div class="so-hdr-right">
      <div class="so-pill"><i class="fa fa-calendar"></i><?= $dateLabel ?></div>
    </div>
  </div>
</div>

<!-- Product meta -->
<div class="so-meta">
  <?php if ($manufacturer): ?>
  <div class="so-meta-item">
    <span class="so-meta-lbl"><i class="fa fa-building-o"></i> Company</span>
    <span class="so-meta-val"><?= CHtml::encode($manufacturer->name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($category): ?>
  <div class="so-meta-item">
    <span class="so-meta-lbl"><i class="fa fa-folder-o"></i> Category</span>
    <span class="so-meta-val"><?= CHtml::encode($category->item_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($subCategory): ?>
  <div class="so-meta-item">
    <span class="so-meta-lbl"><i class="fa fa-tag"></i> Sub-Category</span>
    <span class="so-meta-val"><?= CHtml::encode($subCategory->brand_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->purchase_price > 0): ?>
  <div class="so-meta-item">
    <span class="so-meta-lbl"><i class="fa fa-shopping-cart"></i> Purchase Price</span>
    <span class="so-meta-val so-meta-pp"><?= number_format($product->purchase_price, 2) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->sell_price > 0): ?>
  <div class="so-meta-item">
    <span class="so-meta-lbl"><i class="fa fa-money"></i> Sale Price</span>
    <span class="so-meta-val so-meta-sp"><?= number_format($product->sell_price, 2) ?></span>
  </div>
  <?php endif; ?>
</div>

<!-- Stats -->
<div class="so-stats">
  <div class="so-stat red">
    <div class="so-stat-val"><?= count($rows) ?></div>
    <div class="so-stat-lbl">Transactions</div>
    <i class="fa fa-list so-stat-icon"></i>
  </div>
  <div class="so-stat orange">
    <div class="so-stat-val"><?= number_format($total) ?></div>
    <div class="so-stat-lbl">Total Qty Out</div>
    <i class="fa fa-cubes so-stat-icon"></i>
  </div>
  <div class="so-stat rose">
    <div class="so-stat-val"><?= number_format($totalValue, 0) ?></div>
    <div class="so-stat-lbl">Total Value</div>
    <i class="fa fa-money so-stat-icon"></i>
  </div>
  <div class="so-stat slate">
    <div class="so-stat-val"><?= $uniqueDays ?></div>
    <div class="so-stat-lbl"><?= $isSingleDay ? 'Single Day' : 'Days' ?></div>
    <i class="fa fa-calendar-o so-stat-icon"></i>
  </div>
</div>

<!-- Table -->
<div class="so-tbl-wrap">
<table class="so-tbl">
  <thead>
    <tr>
      <th class="co-sl">#</th>
      <th>Date</th>
      <th>SO # / Challan</th>
      <th>Customer</th>
      <th>Type</th>
      <th style="text-align:right;">Unit Price</th>
      <th style="text-align:center;">Qty Out</th>
      <th style="text-align:right;">Total Value</th>
      <th style="text-align:center;">Running Total</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>
  <?php if (empty($rows)): ?>
    <tr><td colspan="10" class="co-no-data">
      <i class="fa fa-inbox"></i>No stock-out records found for this selection.
    </td></tr>
  <?php else:
    $sl = 1; $running = 0;
    foreach ($rows as $d):
      $running += $d->stock_out;
      $rowVal   = $d->stock_out * $d->sell_price;
      $customerName = '—'; $customerContact = ''; $soNo = '—';
      if ($d->stock_status == Inventory::SALES_DELIVERY && $d->master_id > 0) {
          $so = SellOrder::model()->findByPk($d->master_id);
          if ($so) {
              $customerName    = $so->customer->company_name;
              $customerContact = $so->customer->owner_mobile_no;
              $soNo            = $so->so_no ? $so->so_no : '#'.$d->master_id;
          }
      }
      $statusLabel = strip_tags(Inventory::model()->getStatus($d->stock_status));
      switch ($d->stock_status) {
          case Inventory::SALES_DELIVERY:      $badgeClass = 'so-badge-sales';   break;
          case Inventory::MANUAL_ENTRY:        $badgeClass = 'so-badge-manual';  break;
          case Inventory::WARRANTY_RETURN:     $badgeClass = 'so-badge-warranty';break;
          case Inventory::PRODUCT_REPLACEMENT: $badgeClass = 'so-badge-replace'; break;
          case Inventory::CASH_SALE_RETURN:    $badgeClass = 'so-badge-return';  break;
          default:                             $badgeClass = 'so-bg-secondary';
      }
  ?>
    <tr>
      <td class="co-sl"><?= $sl++ ?></td>
      <td><div class="co-date">
        <div class="co-date-main"><?= date('d M Y', strtotime($d->date)) ?></div>
        <?php if ($d->create_time): ?><div class="co-date-time"><?= date('h:i A', strtotime($d->create_time)) ?></div><?php endif; ?>
      </div></td>
      <td><div class="co-ref">
        <div class="co-ref-main"><?= CHtml::encode($soNo) ?></div>
        <?php if ($d->challan_no): ?><div class="co-ref-sub"><i class="fa fa-file-text-o"></i> <?= CHtml::encode($d->challan_no) ?></div><?php endif; ?>
      </div></td>
      <td>
        <div class="co-party-name"><?= CHtml::encode($customerName) ?></div>
        <?php if ($customerContact): ?><div class="co-party-contact"><i class="fa fa-phone" style="font-size:10px;margin-right:3px;"></i><?= CHtml::encode($customerContact) ?></div><?php endif; ?>
      </td>
      <td><span class="so-badge <?= $badgeClass ?>"><?= CHtml::encode($statusLabel ?: 'Entry') ?></span></td>
      <td class="co-price"><?= $d->sell_price > 0 ? number_format($d->sell_price, 2) : '—' ?></td>
      <td class="co-qty"><?= number_format($d->stock_out) ?></td>
      <td class="co-total"><?= $rowVal > 0 ? number_format($rowVal, 2) : '—' ?></td>
      <td class="co-running"><?= number_format($running) ?></td>
      <td class="co-remarks" title="<?= CHtml::encode($d->remarks) ?>"><?= $d->remarks ? CHtml::encode($d->remarks) : '<span style="color:#cbd5e1">—</span>' ?></td>
    </tr>
  <?php endforeach; endif; ?>
  </tbody>
  <?php if (!empty($rows)): ?>
  <tfoot>
    <tr>
      <th colspan="6" class="co-foot-lbl">Total</th>
      <th class="co-foot-qty"><?= number_format($total) ?></th>
      <th class="co-foot-val"><?= number_format($totalValue, 2) ?></th>
      <th colspan="2"></th>
    </tr>
  </tfoot>
  <?php endif; ?>
</table>
</div>
</div>
