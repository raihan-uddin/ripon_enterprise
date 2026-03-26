<style>
.bc-nav{display:flex;align-items:center;padding:6px 0 14px;margin:0}
.bc-nav ol{display:flex;flex-wrap:wrap;align-items:center;list-style:none;margin:0;padding:0;gap:2px}
.bc-nav .bc-item{display:inline-flex;align-items:center;font-size:12.5px}
.bc-nav .bc-item+.bc-item::before{content:'\f105';font-family:'FontAwesome';font-size:11px;color:#d1d5db;margin-right:6px;margin-left:4px}
.bc-nav .bc-item a{color:#6b7280;text-decoration:none;font-weight:500;transition:color .15s}
.bc-nav .bc-item a:hover{color:#6366f1;text-decoration:none}
.bc-nav .bc-item.bc-active{color:#374151;font-weight:600}
.bc-nav .bc-home-icon{color:#9ca3af;font-size:13px;transition:color .15s}
.bc-nav .bc-item a:hover .bc-home-icon{color:#6366f1}
</style>

<nav class="bc-nav" aria-label="breadcrumb">
    <ol>
        <li class="bc-item">
            <a href="<?= Yii::app()->createUrl('site/dashBoard') ?>">
                <i class="fa fa-home bc-home-icon"></i>
            </a>
        </li>
        <?php foreach ($this->crumbs as $crumb): ?>
        <?php if (isset($crumb['url'])): ?>
        <li class="bc-item">
            <a href="<?= CHtml::normalizeUrl($crumb['url']) ?>">
                <?= CHtml::encode($crumb['name']) ?>
            </a>
        </li>
        <?php else: ?>
        <li class="bc-item bc-active" aria-current="page">
            <?= CHtml::encode($crumb['name']) ?>
        </li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
