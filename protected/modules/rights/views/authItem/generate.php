<?php $this->breadcrumbs = array(
    'Rights'                          => Rights::getBaseUrl(),
    Rights::t('core', 'Permissions') => array('authItem/permissions'),
    Rights::t('core', 'Generate items'),
); ?>

<div class="card card-primary rgen-card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-magic"></i>
            <?php echo Rights::t('core', 'Generate items'); ?>
        </h3>
    </div>

    <!-- Toolbar -->
    <div class="rgen-toolbar">
        <div class="rgen-toolbar-left">
            <button type="button" id="rgenSelectAll" class="rgen-tb-btn">
                <i class="fa fa-check-square-o"></i> <?php echo Rights::t('core', 'Select all'); ?>
            </button>
            <button type="button" id="rgenSelectNone" class="rgen-tb-btn rgen-tb-btn-muted">
                <i class="fa fa-square-o"></i> <?php echo Rights::t('core', 'Select none'); ?>
            </button>
        </div>
        <div class="rgen-toolbar-center">
            <div class="rgen-search-wrap">
                <i class="fa fa-search rgen-search-icon"></i>
                <input type="text" id="rgenSearch" class="rgen-search-input"
                       placeholder="<?php echo Rights::t('core', 'Filter permissions… (press / to focus)'); ?>">
                <button type="button" id="rgenSearchClear" class="rgen-search-clear" style="display:none;">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="rgen-toolbar-right">
            <span id="rgenStats" class="rgen-stats"></span>
        </div>
    </div>

    <!-- Table -->
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <div class="rgen-table-wrap">
        <table class="rgen-table generate-item-table">
            <thead>
                <tr>
                    <th class="rgen-th-check">
                        <input type="checkbox" id="rgenChkAll" title="<?php echo Rights::t('core', 'Select all visible'); ?>">
                    </th>
                    <th class="rgen-th-name"><?php echo Rights::t('core', 'Permission'); ?></th>
                    <th class="rgen-th-path"><?php echo Rights::t('core', 'File'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr class="application-heading-row" data-section="app">
                    <th colspan="3">
                        <span class="rgen-section-toggle"><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-th-large" style="margin-right:7px;opacity:.7;"></i>
                        <?php echo Rights::t('core', 'Application'); ?>
                        <span class="rgen-section-badge"></span>
                    </th>
                </tr>
                <?php $this->renderPartial('_generateItems', array(
                    'model'                   => $model,
                    'form'                    => $form,
                    'items'                   => $items,
                    'existingItems'           => $existingItems,
                    'displayModuleHeadingRow' => true,
                    'basePathLength'          => strlen(Yii::app()->basePath),
                )); ?>
            </tbody>
        </table>
    </div>

    <div id="rgenEmpty" class="rgen-empty" style="display:none;">
        <i class="fa fa-filter" style="font-size:28px;margin-bottom:10px;color:#d1d5db;"></i>
        <div style="font-weight:600;color:#6b7280;margin-bottom:4px;"><?php echo Rights::t('core', 'No permissions match'); ?></div>
        <div style="color:#9ca3af;font-size:12px;"><?php echo Rights::t('core', 'Try a different keyword'); ?></div>
    </div>

    <div class="card-footer rgen-footer">
        <button type="submit" id="rgenSubmit" class="btn btn-primary">
            <i class="fa fa-magic"></i> <span id="rgenSubmitLabel"><?php echo Rights::t('core', 'Generate'); ?></span>
        </button>
        <?php echo CHtml::link(
            Rights::t('core', 'Cancel'),
            array('authItem/permissions'),
            array('class' => 'btn btn-default')
        ); ?>
        <span id="rgenSubmitHint" class="rgen-submit-hint"></span>
    </div>

    <?php $this->endWidget(); ?>
</div>

<style>
/* ── Generate card ── */
.rgen-card { overflow:hidden }

/* Toolbar */
.rgen-toolbar {
    display:flex; align-items:center; gap:10px;
    padding:10px 18px; border-bottom:1px solid #e9ecef;
    background:#f8fafc; flex-wrap:wrap;
}
.rgen-toolbar-left  { display:flex; gap:6px; align-items:center }
.rgen-toolbar-center{ flex:1; min-width:160px; max-width:360px }
.rgen-toolbar-right { margin-left:auto; white-space:nowrap }

.rgen-tb-btn {
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 12px; border-radius:6px; font-size:12.5px; font-weight:500;
    border:1px solid #6366f1; color:#6366f1; background:#fff; cursor:pointer;
    transition:background .14s,color .14s,border-color .14s; line-height:1.4;
}
.rgen-tb-btn:hover       { background:#6366f1; color:#fff }
.rgen-tb-btn-muted       { border-color:#cbd5e1; color:#64748b }
.rgen-tb-btn-muted:hover { background:#64748b; color:#fff; border-color:#64748b }

.rgen-search-wrap { position:relative; display:flex; align-items:center }
.rgen-search-icon {
    position:absolute; left:9px; color:#9ca3af; font-size:12px; pointer-events:none
}
.rgen-search-input {
    width:100%; border:1px solid #e2e8f0; border-radius:7px;
    padding:6px 30px 6px 28px; font-size:13px; outline:none; background:#fff;
    transition:border-color .15s,box-shadow .15s;
}
.rgen-search-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.12) }
.rgen-search-clear {
    position:absolute; right:8px; background:none; border:none;
    color:#9ca3af; cursor:pointer; font-size:12px; padding:2px; line-height:1;
}
.rgen-search-clear:hover { color:#374151 }

.rgen-stats { font-size:12px; color:#6c757d; letter-spacing:.1px }
.rgen-stats strong { color:#1e293b; font-weight:600 }

/* Empty state */
.rgen-empty {
    text-align:center; padding:52px 20px;
    display:flex; flex-direction:column; align-items:center;
}

/* Table wrap */
.rgen-table-wrap { overflow-x:auto; border-bottom:1px solid #e9ecef }
.rgen-table      { width:100%; border-collapse:collapse; font-size:13px; margin:0 }

/* Thead */
.rgen-table thead th {
    background:#f1f5f9; color:#64748b; font-size:10.5px;
    font-weight:700; text-transform:uppercase; letter-spacing:.6px;
    padding:10px 14px; border-bottom:2px solid #e2e8f0;
    white-space:nowrap; position:sticky; top:0; z-index:3;
}
.rgen-th-check { width:44px; text-align:center; padding-left:16px!important }
.rgen-th-name  { padding-left:14px!important }
.rgen-th-path  { width:36%; color:#94a3b8 }

#rgenChkAll {
    width:15px; height:15px; cursor:pointer; accent-color:#6366f1;
    vertical-align:middle;
}

/* ── Section heading rows ── */
.application-heading-row th {
    background:#1e293b; color:rgba(255,255,255,.88);
    font-size:11px; font-weight:700; text-transform:uppercase;
    letter-spacing:.8px; padding:10px 14px; cursor:pointer;
    user-select:none; border-left:4px solid #6366f1;
}
.application-heading-row:hover th { background:#263548 }

.rgen-table tr:has(.module-heading-row) th,
.rgen-table .module-heading-row {
    background:#334155; color:rgba(255,255,255,.82);
    font-size:11px; font-weight:700; text-transform:uppercase;
    letter-spacing:.6px; padding:8px 14px 8px 28px; cursor:pointer;
    user-select:none; border-left:4px solid #818cf8;
}
.rgen-table tr:has(.module-heading-row):hover .module-heading-row { background:#3d4f66 }

.rgen-table tr:has(.module-row) th,
.rgen-table .module-row {
    background:#f1f5f9; color:#334155;
    font-size:11.5px; font-weight:600; padding:7px 14px 7px 38px; cursor:pointer;
    user-select:none; border-left:3px solid #a5b4fc;
    border-top:1px solid #e2e8f0; border-bottom:1px solid #e2e8f0;
}
.rgen-table tr:has(.module-row):hover .module-row { background:#e8edf5 }

.rgen-section-toggle { margin-right:8px; font-size:11px; opacity:.6; transition:transform .2s; display:inline-block }
.rgen-section-badge  {
    float:right; background:rgba(255,255,255,.18); color:rgba(255,255,255,.75);
    font-size:10px; font-weight:600; padding:1px 7px; border-radius:10px;
    margin-top:1px; letter-spacing:.3px;
}
.rgen-table .module-row .rgen-section-badge {
    background:rgba(99,102,241,.12); color:#6366f1;
}

/* ── Controller rows ── */
.rgen-table .controller-row td {
    background:#fafbfe; font-size:12.5px;
    padding:8px 14px; border-bottom:1px solid #e9ecef; border-left:none;
}
.rgen-table .controller-row td.checkbox-column {
    text-align:center; width:44px; padding-left:16px;
}
.rgen-table .controller-row .name-column {
    font-family:'SFMono-Regular',Consolas,'Liberation Mono',Menlo,monospace;
    font-weight:600; color:#3730a3; padding-left:0;
    border-left:3px solid #6366f1; padding-left:11px;
}
.rgen-table .controller-row .path-column { color:#94a3b8; font-size:11.5px }
.rgen-table .controller-row:hover td     { background:#eef2ff }
.rgen-table .controller-row:hover .name-column { border-left-color:#4f46e5 }

/* ── Action rows ── */
.rgen-table .action-row td {
    background:#fff; font-size:13px;
    padding:6px 14px; border-bottom:1px solid #f3f4f6;
}
.rgen-table .action-row td.checkbox-column { text-align:center; width:44px; padding-left:16px }
.rgen-table .action-row .name-column {
    font-family:'SFMono-Regular',Consolas,'Liberation Mono',Menlo,monospace;
    color:#4b5563; padding-left:0; position:relative; padding-left:30px;
}
.rgen-table .action-row .name-column::before {
    content:''; position:absolute; left:8px; top:50%; width:12px; height:0;
    border-top:1px dashed #d1d5db; margin-top:-1px;
}
.rgen-table .action-row .path-column { font-size:11.5px; color:#9ca3af }
.rgen-table .action-row.even td     { background:#fafbfc }
.rgen-table .action-row:hover td    { background:#f0f4ff }
.rgen-table .action-row:hover .name-column { color:#3730a3 }

/* Row checkboxes */
.rgen-table .action-row input[type="checkbox"],
.rgen-table .controller-row input[type="checkbox"] {
    width:15px; height:15px; cursor:pointer; accent-color:#6366f1; vertical-align:middle
}

/* Footer */
.rgen-footer { display:flex; align-items:center; gap:8px; background:#f8fafc }
.rgen-submit-hint { font-size:12px; color:#ef4444; margin-left:4px }
</style>

<script>
$(document).ready(function () {

    var MONO = "'SFMono-Regular',Consolas,'Liberation Mono',Menlo,monospace";

    /* ══════════════════════════════════════════
       Helpers
    ══════════════════════════════════════════ */
    function rowsForSection($heading) {
        var rows = [];
        var $next = $heading.next('tr');
        while ($next.length) {
            var isHeading = $next.hasClass('application-heading-row') ||
                            $next.find('.module-heading-row').length ||
                            $next.find('.module-row').length;
            if (isHeading) break;
            rows.push($next[0]);
            $next = $next.next('tr');
        }
        return $(rows);
    }

    function actionsForController($ctrlRow) {
        var rows = [];
        var $next = $ctrlRow.next('tr');
        while ($next.length) {
            if (!$next.hasClass('action-row')) break;
            rows.push($next[0]);
            $next = $next.next('tr');
        }
        return $(rows);
    }

    /* ══════════════════════════════════════════
       Stats + submit button
    ══════════════════════════════════════════ */
    function updateUI() {
        var $all     = $('.generate-item-table :checkbox:not(#rgenChkAll)');
        var $visible = $all.filter(':visible');
        var $checked = $all.filter(':checked');
        var total    = $all.length;
        var vis      = $visible.length;
        var sel      = $checked.length;
        var filtered = vis !== total;

        /* Stats text */
        var s = filtered
            ? '<strong>' + vis + '</strong> of ' + total + ' shown'
            : '<strong>' + total + '</strong> permissions';
        if (sel > 0) s += '&nbsp; · &nbsp;<strong>' + sel + '</strong> selected';
        $('#rgenStats').html(s);

        /* Submit label */
        $('#rgenSubmitLabel').text(sel > 0
            ? '<?php echo Rights::t('core', 'Generate'); ?> (' + sel + ')'
            : '<?php echo Rights::t('core', 'Generate'); ?>'
        );
        $('#rgenSubmit').toggleClass('btn-primary', sel > 0).toggleClass('btn-default', sel === 0);
        $('#rgenSubmitHint').text(sel === 0 ? '<?php echo Rights::t('core', 'Select at least one item'); ?>' : '');

        /* Header checkbox state */
        if (vis === 0) {
            $('#rgenChkAll').prop('indeterminate', false).prop('checked', false);
        } else {
            var visChecked = $visible.filter(':checked').length;
            $('#rgenChkAll')
                .prop('indeterminate', visChecked > 0 && visChecked < vis)
                .prop('checked', visChecked === vis);
        }

        /* Section badges */
        updateSectionBadges();
    }

    /* ══════════════════════════════════════════
       Section badges
    ══════════════════════════════════════════ */
    function updateSectionBadges() {
        $('.rgen-table tbody tr').each(function () {
            var $row = $(this);
            var isSection = $row.hasClass('application-heading-row') ||
                            $row.find('.module-heading-row').length ||
                            $row.find('.module-row').length;
            if (!isSection) return;
            var $sectionRows = rowsForSection($row);
            var total   = $sectionRows.find(':checkbox').length;
            var checked = $sectionRows.find(':checkbox:checked').length;
            var badge   = checked > 0 ? checked + ' / ' + total : total;
            $row.find('.rgen-section-badge').text(badge);
        });
    }

    /* ══════════════════════════════════════════
       Controller checkbox sync
    ══════════════════════════════════════════ */
    function syncControllerState($ctrlRow) {
        var $actions = actionsForController($ctrlRow);
        if (!$actions.length) return;
        var total   = $actions.find(':checkbox').length;
        var checked = $actions.find(':checkbox:checked').length;
        var $chk    = $ctrlRow.find('input[type="checkbox"]');
        $chk.prop('indeterminate', checked > 0 && checked < total)
            .prop('checked', checked > 0 && checked === total);
    }

    /* On load, sync all controller states */
    $('.rgen-table .controller-row').each(function () { syncControllerState($(this)); });

    /* ══════════════════════════════════════════
       Search
    ══════════════════════════════════════════ */
    var searchTimer;
    $('#rgenSearch').on('input', function () {
        clearTimeout(searchTimer);
        var input = this;
        searchTimer = setTimeout(function () {
            var text    = $(input).val().replace(/\//g, '.').toUpperCase();
            var hasText = text.length > 0;
            $('#rgenSearchClear').toggle(hasText);

            var anyVisible = false;
            $('.rgen-table .action-row, .rgen-table .controller-row').each(function () {
                var match = !hasText || $(this).find('.name-column').text().toUpperCase().indexOf(text) >= 0;
                $(this).toggle(match);
                if (match) anyVisible = true;
            });

            $('#rgenEmpty').toggle(!anyVisible && hasText);
            $('.rgen-table-wrap').toggle(anyVisible || !hasText);
            updateUI();
        }, 120);
    });

    $('#rgenSearchClear').on('click', function () {
        $('#rgenSearch').val('').trigger('input').focus();
    });

    /* Press / to focus search */
    $(document).on('keydown', function (e) {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
            e.preventDefault();
            $('#rgenSearch').focus().select();
        }
    });

    /* ══════════════════════════════════════════
       Select all / none (toolbar)
    ══════════════════════════════════════════ */
    $('#rgenSelectAll').on('click', function () {
        $('.generate-item-table :checkbox:not(#rgenChkAll):visible').prop('checked', true);
        $('.rgen-table .controller-row').each(function () { syncControllerState($(this)); });
        updateUI();
    });

    $('#rgenSelectNone').on('click', function () {
        $('.generate-item-table :checkbox').prop('checked', false).prop('indeterminate', false);
        updateUI();
    });

    /* Header checkbox */
    $('#rgenChkAll').on('change', function () {
        var checked = this.checked;
        $('.generate-item-table :checkbox:not(#rgenChkAll):visible').prop('checked', checked);
        $('.rgen-table .controller-row').each(function () { syncControllerState($(this)); });
        updateUI();
    });

    /* ══════════════════════════════════════════
       Controller checkbox → toggle its actions
    ══════════════════════════════════════════ */
    $(document).on('change', '.rgen-table .controller-row input[type="checkbox"]', function () {
        var $ctrlRow = $(this).closest('tr');
        var checked  = this.checked;
        actionsForController($ctrlRow).find('input[type="checkbox"]').prop('checked', checked);
        updateUI();
    });

    /* ══════════════════════════════════════════
       Action checkbox → sync its controller
    ══════════════════════════════════════════ */
    $(document).on('change', '.rgen-table .action-row input[type="checkbox"]', function () {
        var $prevCtrl = $(this).closest('tr').prevAll('.controller-row').first();
        if ($prevCtrl.length) syncControllerState($prevCtrl);
        updateUI();
    });

    /* ══════════════════════════════════════════
       Section collapse / expand
    ══════════════════════════════════════════ */
    function initSectionHeadings() {
        var $headings = $('.rgen-table tbody tr').filter(function () {
            return $(this).hasClass('application-heading-row') ||
                   $(this).find('.module-heading-row').length  ||
                   $(this).find('.module-row').length;
        });

        $headings.each(function () {
            var $h = $(this);
            if (!$h.find('.rgen-section-toggle').length) {
                $h.find('th,td').first().prepend(
                    '<span class="rgen-section-toggle"><i class="fa fa-chevron-down"></i></span>'
                );
            }
            if (!$h.find('.rgen-section-badge').length) {
                $h.find('th,td').first().append('<span class="rgen-section-badge"></span>');
            }
        });

        $headings.on('click', function (e) {
            if ($(e.target).is('input')) return;
            var $h       = $(this);
            var $rows    = rowsForSection($h);
            var isHidden = $rows.filter(':visible').length === 0;
            $rows.toggle(isHidden);
            $h.find('.rgen-section-toggle i')
              .toggleClass('fa-chevron-down', isHidden)
              .toggleClass('fa-chevron-right', !isHidden);
            updateUI();
        });
    }
    initSectionHeadings();

    /* ══════════════════════════════════════════
       Submit validation
    ══════════════════════════════════════════ */
    $('#rgenSubmit').closest('form').on('submit', function (e) {
        var sel = $('.generate-item-table :checkbox:not(#rgenChkAll):checked').length;
        if (sel === 0) {
            e.preventDefault();
            $('#rgenSubmit').addClass('btn-danger').removeClass('btn-primary btn-default');
            $('#rgenSubmitHint').text('<?php echo Rights::t('core', 'Select at least one item'); ?>');
            setTimeout(function () {
                $('#rgenSubmit').removeClass('btn-danger').addClass('btn-primary');
            }, 1800);
        }
    });

    /* ══════════════════════════════════════════
       Init
    ══════════════════════════════════════════ */
    updateUI();
});
</script>
