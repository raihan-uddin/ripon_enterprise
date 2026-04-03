/**
 * common.js — App-wide utilities loaded on every page
 */
$(function () {
    // ── Alert auto-fade (3s delay → fadeOut) ──
    setTimeout(function () {
        $(".alert:not(.alert-permanent)").animate({ opacity: 0, height: 0 }, 400, function () {
            $(this).remove();
        });
    }, 3000);

    // ── Toastr default configuration ──
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 4000,
            extendedTimeOut: 2000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
    }

    // ── CSRF token for AJAX requests ──
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    if (csrfToken) {
        $.ajaxSetup({
            data: { YII_CSRF_TOKEN: csrfToken }
        });
    }

    // ── Global AJAX error handler ──
    $(document).ajaxError(function (event, xhr) {
        if (xhr.status === 401) {
            window.location.href = '/site/login';
        } else if (xhr.status === 403) {
            if (typeof toastr !== 'undefined') {
                toastr.error('You do not have permission to perform this action.');
            }
        } else if (xhr.status >= 500) {
            if (typeof toastr !== 'undefined') {
                toastr.error('Server error. Please try again or contact support.');
            }
        }
    });
});

/**
 * Bootstrap 5 Modal helper
 * Usage: bsModal('myModal', 'show') or bsModal('myModal', 'hide')
 */
function bsModal(id, action) {
    var el = document.getElementById(id);
    if (el) {
        bootstrap.Modal.getOrCreateInstance(el)[action]();
    }
}
