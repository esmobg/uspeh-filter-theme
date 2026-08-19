(function () {
    var params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
    var search = new URLSearchParams(window.location.search);
    var stored = {};

    params.forEach(function (p) {
        var val = search.get(p);
        if (val) {
            stored[p] = val;
            try { sessionStorage.setItem('uspeh_' + p, val); } catch (e) { /* silent */ }
        } else {
            try { stored[p] = sessionStorage.getItem('uspeh_' + p) || ''; } catch (e) { stored[p] = ''; }
        }
    });

    try {
        if (!sessionStorage.getItem('uspeh_landing_page')) {
            sessionStorage.setItem('uspeh_landing_page', window.location.href);
        }
        if (!sessionStorage.getItem('uspeh_referrer') && document.referrer) {
            sessionStorage.setItem('uspeh_referrer', document.referrer);
        }
        stored.landing_page = sessionStorage.getItem('uspeh_landing_page') || '';
        stored.referrer = sessionStorage.getItem('uspeh_referrer') || '';
    } catch (e) { /* silent */ }

    function fillFields() {
        document.querySelectorAll('.uspeh-utm-field').forEach(function (field) {
            var key = field.dataset.utm;
            if (key && stored[key]) {
                field.value = stored[key];
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fillFields);
    } else {
        fillFields();
    }

    var observer = new MutationObserver(function () { fillFields(); });
    observer.observe(document.body, { childList: true, subtree: true });
})();
