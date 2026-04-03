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
    $criteria->addColumnCondition(['model_id' => $model_id]);
    $criteria->addBetweenCondition('date', date('Y-m-d', $start_date), date('Y-m-d', $end_date));
    $criteria->addCondition('stock_in != 0');
    $criteria->select = 'id, product_sl_no, stock_in, stock_out, stock_status, master_id, source_id, date, purchase_price, challan_no, remarks, create_time';
    $criteria->order  = 'date ASC, id ASC';
    $rows = Inventory::model()->findAll($criteria);
    foreach ($rows as $r) {
        $total      += $r->stock_in;
        $totalValue += $r->stock_in * $r->purchase_price;
    }
}
$uniqueDays = $isSingleDay ? 1 : ceil(($end_date - $start_date) / 86400) + 1;
?>
<style>
:root {
    --si-accent: #1d4ed8;
    --si-accent2: #3b82f6;
    --si-accent-light: #eff6ff;
    --si-accent-border: #bfdbfe;
    --si-green: #15803d;
    --si-text: #0f172a;
    --si-muted: #64748b;
    --si-border: #e2e8f0;
    --si-row-alt: #f8fafc;
    --si-shadow: 0 4px 24px rgba(29,78,216,.10);
}
.si-wrap{font-family:'Segoe UI',system-ui,sans-serif;color:var(--si-text);margin-bottom:24px;}

/* ─── HEADER ─── */
.si-hdr{position:relative;border-radius:14px;overflow:hidden;
        background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 55%,#2563eb 100%);
        padding:20px 24px;margin-bottom:18px;
        box-shadow:0 8px 32px rgba(29,78,216,.30);}
.si-hdr::before{content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse at 80% -10%,rgba(255,255,255,.15) 0%,transparent 60%),
               radial-gradient(ellipse at 10% 120%,rgba(96,165,250,.20) 0%,transparent 50%);
    pointer-events:none;}
.si-hdr-inner{position:relative;display:flex;align-items:center;
              justify-content:space-between;flex-wrap:wrap;gap:12px;}
.si-hdr-left{display:flex;align-items:center;gap:14px;}
.si-hdr-icon{width:48px;height:48px;border-radius:12px;flex-shrink:0;
             background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
             display:flex;align-items:center;justify-content:center;
             font-size:22px;color:#fff;backdrop-filter:blur(4px);}
.si-hdr-title{color:#fff;font-size:17px;font-weight:700;margin:0;line-height:1.3;}
.si-hdr-sub{color:rgba(255,255,255,.75);font-size:12.5px;margin:2px 0 0;}
.si-hdr-right{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.si-pill{display:inline-flex;align-items:center;gap:6px;
         background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
         border-radius:20px;padding:5px 13px;color:#fff;font-size:12px;backdrop-filter:blur(4px);}

/* ─── STAT CARDS ─── */
.si-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));
          gap:12px;margin-bottom:18px;}
.si-stat{border-radius:10px;padding:14px 16px;
         background:#fff;border:1px solid var(--si-border);
         box-shadow:0 1px 6px rgba(0,0,0,.05);
         transition:transform .15s,box-shadow .15s;position:relative;overflow:hidden;}
.si-stat:hover{transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,0,0,.08);}
.si-stat::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:3px 3px 0 0;}
.si-stat.blue::before{background:linear-gradient(90deg,#1d4ed8,#3b82f6);}
.si-stat.green::before{background:linear-gradient(90deg,#15803d,#22c55e);}
.si-stat.indigo::before{background:linear-gradient(90deg,#4f46e5,#818cf8);}
.si-stat.slate::before{background:linear-gradient(90deg,#475569,#94a3b8);}
.si-stat-val{font-size:22px;font-weight:800;line-height:1;color:var(--si-text);
             font-variant-numeric:tabular-nums;}
.si-stat-lbl{font-size:10.5px;color:var(--si-muted);margin-top:5px;
             text-transform:uppercase;letter-spacing:.6px;font-weight:600;}
.si-stat-icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);
              font-size:28px;opacity:.08;color:var(--si-text);}

/* ─── TABLE ─── */
.si-tbl-wrap{border-radius:10px;overflow:hidden;
             border:1px solid var(--si-border);
             box-shadow:0 2px 12px rgba(0,0,0,.06);}
.si-tbl{width:100%;border-collapse:collapse;font-size:12.5px;}
.si-tbl thead{background:#0f172a;}
.si-tbl thead th{color:rgba(255,255,255,.80);font-weight:600;font-size:10.5px;
                 text-transform:uppercase;letter-spacing:.7px;
                 padding:11px 13px;border:none;white-space:nowrap;}
.si-tbl tbody tr{border-bottom:1px solid #f1f5f9;
                 transition:background .12s,border-left-color .12s;}
.si-tbl tbody tr:nth-child(odd){background:#fff;}
.si-tbl tbody tr:nth-child(even){background:var(--si-row-alt);}
.si-tbl tbody tr:last-child{border-bottom:none;}
.si-tbl tbody tr:hover{background:var(--si-accent-light);
                        border-left:3px solid var(--si-accent2);}
.si-tbl tbody tr:not(:hover){border-left:3px solid transparent;}
.si-tbl td{padding:9px 13px;vertical-align:middle;}
.si-tbl tfoot{background:#f0f6ff;border-top:2px solid var(--si-accent-border);}
.si-tbl tfoot th{padding:10px 13px;border:none;font-size:12.5px;}

/* ─── CELL TYPES ─── */
.c-sl{width:44px;text-align:center;font-size:10.5px;color:#94a3b8;font-weight:700;}
.c-date{white-space:nowrap;font-size:12px;}
.c-date .c-date-main{color:var(--si-text);font-weight:600;}
.c-date .c-date-time{color:var(--si-muted);font-size:10.5px;margin-top:1px;}
.c-ref{font-family:'SFMono-Regular',Consolas,monospace;font-size:11.5px;}
.c-ref .c-ref-main{color:var(--si-accent);font-weight:700;}
.c-ref .c-ref-sub{color:var(--si-muted);font-size:10px;margin-top:2px;}
.c-party{}
.c-party .c-party-name{color:var(--si-text);font-weight:600;font-size:12.5px;}
.c-party .c-party-contact{color:var(--si-muted);font-size:10.5px;margin-top:2px;}
.c-price{text-align:right;font-family:'SFMono-Regular',Consolas,monospace;
         font-size:12px;color:#374151;font-variant-numeric:tabular-nums;}
.c-qty{text-align:center;font-weight:800;font-size:14px;
       color:var(--si-green);font-variant-numeric:tabular-nums;}
.c-total{text-align:right;font-family:'SFMono-Regular',Consolas,monospace;
         font-size:12.5px;font-weight:700;color:var(--si-accent);font-variant-numeric:tabular-nums;}
.c-running{text-align:center;font-family:'SFMono-Regular',Consolas,monospace;
           font-size:12px;font-weight:700;color:#7c3aed;font-variant-numeric:tabular-nums;}
.c-remarks{font-size:11.5px;color:var(--si-muted);max-width:160px;
           overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.c-foot-lbl{text-align:right;color:var(--si-muted);font-size:10.5px;
            text-transform:uppercase;letter-spacing:.5px;}
.c-foot-qty{text-align:center;font-weight:800;color:var(--si-green);font-size:15px;}
.c-foot-val{text-align:right;font-weight:800;color:var(--si-accent);font-size:13px;
            font-family:'SFMono-Regular',Consolas,monospace;}
.c-no-data{text-align:center;padding:48px 20px;color:var(--si-muted);}
.c-no-data i{font-size:36px;display:block;margin-bottom:10px;opacity:.25;}

/* ─── STATUS BADGE ─── */
.si-badge{display:inline-flex;align-items:center;gap:4px;
          font-size:10px;font-weight:700;padding:3px 9px;
          border-radius:20px;white-space:nowrap;letter-spacing:.3px;}
.si-badge-purchase{background:#dbeafe;color:#1d4ed8;}
.si-badge-manual{background:#f0fdf4;color:#15803d;}
.si-badge-warranty{background:#fdf4ff;color:#7e22ce;}
.si-badge-replace{background:#fff7ed;color:#c2410c;}
.si-badge-return{background:#f0fdf4;color:#065f46;}
.si-bg-secondary{background:#f1f5f9;color:#475569;}

/* ─── PRODUCT META STRIP ─── */
.si-meta{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:18px;}
.si-meta-item{background:#fff;border:1px solid var(--si-border);border-radius:8px;
              padding:8px 14px;display:flex;flex-direction:column;gap:2px;min-width:110px;
              box-shadow:0 1px 4px rgba(0,0,0,.04);}
.si-meta-lbl{font-size:9.5px;color:var(--si-muted);text-transform:uppercase;
             letter-spacing:.6px;font-weight:600;}
.si-meta-val{font-size:13px;font-weight:700;color:var(--si-text);}
.si-meta-pp{color:#1d4ed8;}
.si-meta-sp{color:var(--si-green);}
@media print{
    .si-hdr,.si-tbl thead{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
    .si-stat::before{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
}
</style>

<div class="si-wrap printAllTableForThisReport">

<!-- Header -->
<div class="si-hdr">
  <div class="si-hdr-inner">
    <div class="si-hdr-left">
      <div class="si-hdr-icon"><i class="fa fa-arrow-circle-down"></i></div>
      <div>
        <p class="si-hdr-title">Stock-In Report — Batch Wise</p>
        <p class="si-hdr-sub">
          <?= CHtml::encode($productName) ?>
          <?php if ($productCode): ?><span style="opacity:.7;margin-left:6px;font-size:11px;">(<?= CHtml::encode($productCode) ?>)</span><?php endif; ?>
        </p>
      </div>
    </div>
    <div class="si-hdr-right">
      <div class="si-pill"><i class="fa fa-calendar"></i><?= $dateLabel ?></div>
    </div>
  </div>
</div>

<!-- Product meta -->
<div class="si-meta">
  <?php if ($manufacturer): ?>
  <div class="si-meta-item">
    <span class="si-meta-lbl"><i class="fa fa-building-o"></i> Company</span>
    <span class="si-meta-val"><?= CHtml::encode($manufacturer->name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($category): ?>
  <div class="si-meta-item">
    <span class="si-meta-lbl"><i class="fa fa-folder-o"></i> Category</span>
    <span class="si-meta-val"><?= CHtml::encode($category->item_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($subCategory): ?>
  <div class="si-meta-item">
    <span class="si-meta-lbl"><i class="fa fa-tag"></i> Sub-Category</span>
    <span class="si-meta-val"><?= CHtml::encode($subCategory->brand_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->purchase_price > 0): ?>
  <div class="si-meta-item">
    <span class="si-meta-lbl"><i class="fa fa-shopping-cart"></i> Purchase Price</span>
    <span class="si-meta-val si-meta-pp"><?= number_format($product->purchase_price, 2) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->sell_price > 0): ?>
  <div class="si-meta-item">
    <span class="si-meta-lbl"><i class="fa fa-money"></i> Sale Price</span>
    <span class="si-meta-val si-meta-sp"><?= number_format($product->sell_price, 2) ?></span>
  </div>
  <?php endif; ?>
</div>

<!-- Stats -->
<div class="si-stats">
  <div class="si-stat blue">
    <div class="si-stat-val"><?= count($rows) ?></div>
    <div class="si-stat-lbl">Transactions</div>
    <i class="fa fa-list si-stat-icon"></i>
  </div>
  <div class="si-stat green">
    <div class="si-stat-val"><?= number_format($total) ?></div>
    <div class="si-stat-lbl">Total Qty In</div>
    <i class="fa fa-cubes si-stat-icon"></i>
  </div>
  <div class="si-stat indigo">
    <div class="si-stat-val"><?= number_format($totalValue, 0) ?></div>
    <div class="si-stat-lbl">Total Value</div>
    <i class="fa fa-money si-stat-icon"></i>
  </div>
  <div class="si-stat slate">
    <div class="si-stat-val"><?= $uniqueDays ?></div>
    <div class="si-stat-lbl"><?= $isSingleDay ? 'Single Day' : 'Days' ?></div>
    <i class="fa fa-calendar-o si-stat-icon"></i>
  </div>
</div>

<!-- Table -->
<div class="si-tbl-wrap">
<table class="si-tbl">
  <thead>
    <tr>
      <th class="c-sl">#</th>
      <th>Date</th>
      <th>PO # / Challan</th>
      <th>Supplier</th>
      <th>Type</th>
      <th style="text-align:right;">Unit Price</th>
      <th style="text-align:center;">Qty In</th>
      <th style="text-align:right;">Total Value</th>
      <th style="text-align:center;">Running Total</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>
  <?php if (empty($rows)): ?>
    <tr><td colspan="10" class="c-no-data">
      <i class="fa fa-inbox"></i>No stock-in records found for this selection.
    </td></tr>
  <?php else:
    $sl = 1; $running = 0;
    foreach ($rows as $d):
      $running += $d->stock_in;
      $rowVal   = $d->stock_in * $d->purchase_price;
      $po = null; $supplierName = '—'; $supplierContact = ''; $poNo = '—';
      if ($d->stock_status == Inventory::PURCHASE_RECEIVE && $d->master_id > 0) {
          $po = PurchaseOrder::model()->findByPk($d->master_id);
          if ($po) {
              $supplierName    = $po->supplier->company_name;
              $supplierContact = $po->supplier->company_contact_no;
              $poNo            = $po->po_no ? $po->po_no : '#'.$d->master_id;
          }
      }
      $statusLabel = strip_tags(Inventory::model()->getStatus($d->stock_status));
      switch ($d->stock_status) {
          case Inventory::PURCHASE_RECEIVE:   $badgeClass = 'si-badge-purchase'; break;
          case Inventory::MANUAL_ENTRY:       $badgeClass = 'si-badge-manual';   break;
          case Inventory::WARRANTY_RETURN:    $badgeClass = 'si-badge-warranty'; break;
          case Inventory::PRODUCT_REPLACEMENT:$badgeClass = 'si-badge-replace';  break;
          case Inventory::CASH_SALE_RETURN:   $badgeClass = 'si-badge-return';   break;
          default:                            $badgeClass = 'si-bg-secondary';
      }
  ?>
    <tr>
      <td class="c-sl"><?= $sl++ ?></td>
      <td><div class="c-date">
        <div class="c-date-main"><?= date('d M Y', strtotime($d->date)) ?></div>
        <?php if ($d->create_time): ?><div class="c-date-time"><?= date('h:i A', strtotime($d->create_time)) ?></div><?php endif; ?>
      </div></td>
      <td><div class="c-ref">
        <div class="c-ref-main"><?= CHtml::encode($poNo) ?></div>
        <?php if ($d->challan_no): ?><div class="c-ref-sub"><i class="fa fa-file-text-o"></i> <?= CHtml::encode($d->challan_no) ?></div><?php endif; ?>
      </div></td>
      <td><div class="c-party">
        <div class="c-party-name"><?= CHtml::encode($supplierName) ?></div>
        <?php if ($supplierContact): ?><div class="c-party-contact"><i class="fa fa-phone" style="font-size:10px;margin-right:3px;"></i><?= CHtml::encode($supplierContact) ?></div><?php endif; ?>
      </div></td>
      <td><span class="si-badge <?= $badgeClass ?>"><?= CHtml::encode($statusLabel ?: 'Entry') ?></span></td>
      <td class="c-price"><?= $d->purchase_price > 0 ? number_format($d->purchase_price, 2) : '—' ?></td>
      <td class="c-qty"><?= number_format($d->stock_in) ?></td>
      <td class="c-total"><?= $rowVal > 0 ? number_format($rowVal, 2) : '—' ?></td>
      <td class="c-running"><?= number_format($running) ?></td>
      <td class="c-remarks" title="<?= CHtml::encode($d->remarks) ?>"><?= $d->remarks ? CHtml::encode($d->remarks) : '<span style="color:#cbd5e1">—</span>' ?></td>
    </tr>
  <?php endforeach; endif; ?>
  </tbody>
  <?php if (!empty($rows)): ?>
  <tfoot>
    <tr>
      <th colspan="6" class="c-foot-lbl">Total</th>
      <th class="c-foot-qty"><?= number_format($total) ?></th>
      <th class="c-foot-val"><?= number_format($totalValue, 2) ?></th>
      <th colspan="2"></th>
    </tr>
  </tfoot>
  <?php endif; ?>
</table>
</div>
</div>
