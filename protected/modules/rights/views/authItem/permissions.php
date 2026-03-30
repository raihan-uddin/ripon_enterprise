<?php $this->breadcrumbs = array(
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Permissions'),
); ?>

<div class="card card-primary perm-card">

    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-lock"></i> <?php echo Rights::t('core', 'Permissions'); ?></h3>
        <div class="card-tools">
            <?php echo CHtml::link(
                '<i class="fa fa-magic"></i> ' . Rights::t('core', 'Generate items'),
                array('authItem/generate'),
                array('class' => 'btn btn-sm btn-light')
            ); ?>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="perm-toolbar">
        <div class="perm-toolbar-search">
            <div class="perm-search-wrap">
                <i class="fa fa-search perm-search-icon"></i>
                <input type="text" id="search" class="perm-search-input"
                       placeholder="<?php echo Rights::t('core', 'Filter permissions…'); ?>">
                <button type="button" id="permSearchClear" class="perm-search-clear" style="display:none;">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="perm-toolbar-role">
            <?php
            $rolesData = Yii::app()->db->createCommand("SELECT name, description FROM AuthItem WHERE type = 2")->queryAll();
            ?>
            <select id="userRoleId" class="perm-role-select">
                <option value=""><?php echo Rights::t('core', '— Select a role —'); ?></option>
                <?php foreach ($rolesData as $r): ?>
                    <option value="<?php echo CHtml::encode($r['name']); ?>">
                        <?php echo CHtml::encode($r['description']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="perm-toolbar-actions">
            <button type="button" id="assignRevokeBtn" class="perm-ar-btn" disabled>
                <i class="fa fa-exchange"></i>
                <span><?php echo Rights::t('core', 'Assign / Revoke'); ?></span>
            </button>
            <span id="permStats" class="perm-stats"></span>
        </div>
    </div>

    <!-- Inline feedback -->
    <div id="permMsg"></div>

    <!-- Table (edge-to-edge) -->
    <div id="permissions">
        <div class="perm-table-wrap">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $dataProvider,
                'template'     => '{items}',
                'emptyText'    => Rights::t('core', 'No authorization items found.'),
                'htmlOptions'  => array('class' => 'grid-view permission-table'),
                'columns'      => $columns,
            )); ?>
        </div>
    </div>
    <input type="hidden" id="assignRevokeUrls">

    <div class="card-footer perm-footer">
        <small class="text-muted">
            <i class="fa fa-info-circle text-info"></i>
            <?php echo Rights::t('core', 'Hover <span class="perm-inherited-sample">Inherited *</span> to see the source.'); ?>
            &nbsp;&middot;&nbsp;
            <?php echo Rights::t('core', 'Manage items under {roleLink}, {taskLink} and {operationLink}.', array(
                '{roleLink}'      => CHtml::link(Rights::t('core', 'Roles'),      array('authItem/roles')),
                '{taskLink}'      => CHtml::link(Rights::t('core', 'Tasks'),      array('authItem/tasks')),
                '{operationLink}' => CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
            )); ?>
        </small>
    </div>

</div>

<style>
/* ── Permissions card ── */
.perm-card { overflow:hidden }

/* Toolbar */
.perm-toolbar {
    display:flex; align-items:center; gap:10px;
    padding:10px 18px; border-bottom:1px solid #e9ecef;
    background:#f8fafc; flex-wrap:wrap;
}
.perm-toolbar-search { flex:1; min-width:160px; max-width:320px }
.perm-toolbar-role   { min-width:180px; max-width:260px }
.perm-toolbar-actions{ display:flex; align-items:center; gap:10px; margin-left:auto }

/* Search */
.perm-search-wrap { position:relative; display:flex; align-items:center }
.perm-search-icon {
    position:absolute; left:9px; color:#9ca3af; font-size:12px; pointer-events:none
}
.perm-search-input {
    width:100%; border:1px solid #e2e8f0; border-radius:7px;
    padding:6px 28px; font-size:13px; outline:none; background:#fff;
    transition:border-color .15s,box-shadow .15s;
}
.perm-search-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.12) }
.perm-search-clear {
    position:absolute; right:8px; background:none; border:none;
    color:#9ca3af; cursor:pointer; font-size:12px; padding:2px; line-height:1;
}
.perm-search-clear:hover { color:#374151 }

/* Role select */
.perm-role-select {
    width:100%; border:1px solid #e2e8f0; border-radius:7px;
    padding:6px 10px; font-size:13px; background:#fff; outline:none; cursor:pointer;
    transition:border-color .15s,box-shadow .15s; -webkit-appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%239ca3af'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center; padding-right:28px;
}
.perm-role-select:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.12) }

/* Assign/Revoke button */
.perm-ar-btn {
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 14px; border-radius:7px; font-size:13px; font-weight:500;
    border:1px solid #6366f1; color:#6366f1; background:#fff; cursor:pointer;
    transition:background .14s,color .14s,opacity .14s; white-space:nowrap;
}
.perm-ar-btn:hover:not(:disabled) { background:#6366f1; color:#fff }
.perm-ar-btn:disabled { opacity:.45; cursor:not-allowed }
.perm-ar-btn.loading { pointer-events:none; opacity:.7 }

/* Stats */
.perm-stats { font-size:12px; color:#6c757d; white-space:nowrap }
.perm-stats strong { color:#1e293b; font-weight:600 }

/* Feedback messages */
#permMsg { margin:0 }
#permMsg .perm-alert {
    display:flex; align-items:center; gap:8px;
    padding:10px 18px; font-size:13px; border-bottom:1px solid transparent;
    animation:permMsgIn .2s ease;
}
@keyframes permMsgIn { from { opacity:0; transform:translateY(-4px) } to { opacity:1; transform:none } }
#permMsg .perm-alert-error   { background:#fef2f2; color:#991b1b; border-color:#fecaca }
#permMsg .perm-alert-success { background:#f0fdf4; color:#166534; border-color:#bbf7d0 }
#permMsg .perm-alert-loading { background:#eff6ff; color:#1e40af; border-color:#bfdbfe }

/* Table wrapper */
.perm-table-wrap { overflow-x:auto }

/* Permissions table */
.permission-table table {
    table-layout:auto!important; width:100%!important; min-width:100%;
    border-collapse:collapse; margin:0;
}
.permission-table table th {
    background:#f1f5f9; color:#64748b; font-size:10.5px;
    font-weight:700; text-transform:uppercase; letter-spacing:.6px;
    padding:10px 14px; border-bottom:2px solid #e2e8f0;
    white-space:nowrap; position:sticky; top:0; z-index:2;
}
.permission-table table td {
    padding:8px 14px; border-bottom:1px solid #f1f3f5;
    vertical-align:middle; font-size:13px; color:#374151;
}
.permission-table table tbody tr:hover td { background:#f8faff }

/* Permission name column — don't stretch it */
.permission-table td.permission-column,
.permission-table th.permission-column {
    width:auto!important; min-width:200px; max-width:340px;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.permission-table .permission-column a {
    color:#3730a3; font-weight:500; font-size:13px;
    font-family:'SFMono-Regular',Consolas,'Liberation Mono',Menlo,monospace;
    text-decoration:none;
}
.permission-table .permission-column a:hover { color:#6366f1; text-decoration:underline }

/* Role columns — compact, centered */
.permission-table td.role-column,
.permission-table th.role-column {
    width:auto!important; min-width:110px; text-align:center;
}

/* Injected checkbox column */
.permission-table .perm-chk-th,
.permission-table .perm-chk-td {
    width:44px!important; text-align:center; padding:8px 0!important;
}
.permission-table input.chk,
.permission-table #chkAll {
    width:15px; height:15px; accent-color:#6366f1; cursor:pointer; vertical-align:middle;
}

/* Assign / Revoke / Inherited badges */
.assign-link {
    display:inline-flex; align-items:center;
    background:#dcfce7; color:#166534; border:1px solid #bbf7d0;
    padding:3px 11px; border-radius:20px; font-size:11.5px; font-weight:600;
    text-decoration:none!important; transition:background .14s,color .14s,border-color .14s;
}
.assign-link:hover { background:#16a34a; color:#fff!important; border-color:#16a34a }

.revoke-link {
    display:inline-flex; align-items:center;
    background:#fee2e2; color:#991b1b; border:1px solid #fecaca;
    padding:3px 11px; border-radius:20px; font-size:11.5px; font-weight:600;
    text-decoration:none!important; transition:background .14s,color .14s,border-color .14s;
}
.revoke-link:hover { background:#dc2626; color:#fff!important; border-color:#dc2626 }
.revoke-link span  { color:inherit!important; font-size:inherit!important }

.inherited-item {
    display:inline-flex; align-items:center; gap:4px;
    background:#f3e8ff; color:#6d28d9; border:1px solid #ddd6fe;
    padding:3px 11px; border-radius:20px; font-size:11.5px; font-weight:500;
    font-style:normal!important; cursor:help;
}

/* Footer */
.perm-footer { background:#f8fafc }
.perm-inherited-sample {
    background:#f3e8ff; color:#6d28d9; border:1px solid #ddd6fe;
    padding:1px 7px; border-radius:10px; font-size:11px; font-weight:500;
    font-style:normal; display:inline-flex; align-items:center;
    vertical-align:middle; margin:0 1px;
}
</style>

<script>
jQuery('.inherited-item').rightsTooltip({ title: '<?php echo Rights::t('core', 'Source'); ?>: ' });

$(document).ready(function () {

    /* ══════════════════════════════════════
       Helpers
    ══════════════════════════════════════ */
    function showMsg(type, html) {
        /* type: 'error' | 'success' | 'loading' */
        var icon = type === 'error'   ? 'fa-exclamation-circle'
                 : type === 'success' ? 'fa-check-circle'
                 :                     'fa-circle-o-notch fa-spin';
        $('#permMsg').html(
            '<div class="perm-alert perm-alert-' + type + '">' +
            '<i class="fa ' + icon + '"></i> ' + html + '</div>'
        );
    }
    function clearMsg() { $('#permMsg').html(''); }

    function getQuery(url, param) {
        return (url.match(new RegExp('[?&]' + param + '=([^&]+)')) || [, null])[1];
    }

    /* ══════════════════════════════════════
       Inject checkboxes
    ══════════════════════════════════════ */
    function injectCheckboxes() {
        var iterate = 0;
        $('.permission-table .items tbody tr').each(function () {
            iterate++;
            $(this).find('.permission-column').before(
                '<td class="perm-chk-td"><input type="checkbox" class="chk" id="chk_' + iterate + '"></td>'
            );
        });
        $('.permission-table .items thead tr').each(function () {
            $(this).find('th').first().before(
                '<th class="perm-chk-th"><input id="chkAll" type="checkbox" title="Select all"></th>'
            );
        });
    }
    injectCheckboxes();

    /* ══════════════════════════════════════
       Stats
    ══════════════════════════════════════ */
    function updateStats() {
        var total   = $('.permission-table .chk').length;
        var checked = $('.permission-table .chk:checked').length;
        var s = '<strong>' + total + '</strong> permissions';
        if (checked > 0) s += ' &nbsp;·&nbsp; <strong>' + checked + '</strong> selected';
        $('#permStats').html(s);

        var hasRole    = !!$('#userRoleId').val();
        var hasChecked = checked > 0;
        $('#assignRevokeBtn').prop('disabled', !(hasRole && hasChecked));

        var allVis   = $('.permission-table .chk:visible').length;
        var allChked = $('.permission-table .chk:visible:checked').length;
        $('#chkAll')
            .prop('indeterminate', allChked > 0 && allChked < allVis)
            .prop('checked', allVis > 0 && allChked === allVis);
    }
    updateStats();

    /* ══════════════════════════════════════
       Search
    ══════════════════════════════════════ */
    var searchTimer;
    $('#search').on('input', function () {
        clearTimeout(searchTimer);
        var input = this;
        searchTimer = setTimeout(function () {
            var text = $(input).val().replace(/\//g, '.').toUpperCase();
            $('#permSearchClear').toggle(text.length > 0);
            $('.permission-table .items tbody tr').each(function () {
                var match = !text || $(this).text().toUpperCase().indexOf(text) >= 0;
                $(this).toggle(match);
            });
            updateStats();
        }, 120);
    });

    $('#permSearchClear').on('click', function () {
        $('#search').val('').trigger('input').focus();
    });

    $(document).on('keydown', function (e) {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
            e.preventDefault();
            $('#search').focus().select();
        }
    });

    /* ══════════════════════════════════════
       Checkbox interactions
    ══════════════════════════════════════ */
    function updateUrlsForRow(row, isChecked) {
        var e            = document.getElementById('userRoleId');
        var selectedVal  = e.options[e.selectedIndex].value;
        var selectedText = e.options[e.selectedIndex].text.trim();
        if (!selectedVal) return;

        var role     = encodeURIComponent(selectedVal.replace(/ /gi, '+'));
        var childRef = row.find('.permission-column a').attr('href');
        var child    = getQuery(window.location.origin + childRef, 'name');
        var $headers = row.closest('table').find('thead tr th');
        var urls     = $('#assignRevokeUrls').val().split('@').filter(Boolean);

        row.find('.role-column').each(function () {
            var colIdx     = $(this).index();
            var headerText = $headers.eq(colIdx).text().trim();
            if (headerText !== selectedText) return;
            var linkText   = $(this).find('a').text().trim();
            var action     = (linkText === 'Assign') ? 'assign' : 'revoke';
            var url        = '/' + action + '?name=' + role + '&child=' + child;
            var idx        = urls.indexOf(url);
            if (isChecked  && idx < 0)  urls.push(url);
            if (!isChecked && idx > -1) urls.splice(idx, 1);
        });

        $('#assignRevokeUrls').val(urls.join('@'));
    }

    $(document).on('click', '.chk', function () {
        updateUrlsForRow($(this).closest('tr'), this.checked);
        updateStats();
    });

    $(document).on('click', '#chkAll', function () {
        var checked = this.checked;
        $('.permission-table .chk:visible').each(function () {
            this.checked = checked;
            updateUrlsForRow($(this).closest('tr'), checked);
        });
        updateStats();
    });

    /* ══════════════════════════════════════
       Role change — reset selections
    ══════════════════════════════════════ */
    $('#userRoleId').on('change', function () {
        $('.permission-table .chk, #chkAll').prop('checked', false).prop('indeterminate', false);
        $('#assignRevokeUrls').val('');
        updateStats();
    });

    /* ══════════════════════════════════════
       Assign / Revoke (bulk)
    ══════════════════════════════════════ */
    $('#assignRevokeBtn').on('click', function () {
        var e        = document.getElementById('userRoleId');
        var roleName = e.options[e.selectedIndex].value;
        if (!roleName) {
            showMsg('error', '<?php echo Rights::t('core', 'Please select a role first.'); ?>');
            return;
        }
        var urls = $('#assignRevokeUrls').val().split('@').filter(Boolean);
        if (!urls.length) {
            showMsg('error', '<?php echo Rights::t('core', 'Please check at least one permission.'); ?>');
            return;
        }

        var base  = '<?php echo Yii::app()->createAbsoluteUrl("rights/authItem/"); ?>';
        var total = urls.length, done = 0;

        $('#assignRevokeBtn').addClass('loading');
        showMsg('loading', '<?php echo Rights::t('core', 'Saving…'); ?>');

        urls.forEach(function (u) {
            $.ajax({
                type: 'POST', url: base + u, data: { ajax: 1 },
                complete: function () {
                    if (++done === total) {
                        showMsg('success', '<?php echo Rights::t('core', 'Permissions updated.'); ?>');
                        $('#assignRevokeBtn').removeClass('loading');
                        setTimeout(function () {
                            clearMsg();
                            window.location.reload();
                        }, 900);
                    }
                }
            });
        });
    });

});
</script>
