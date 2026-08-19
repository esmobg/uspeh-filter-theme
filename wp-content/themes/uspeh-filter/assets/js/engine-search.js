(function () {
    var form = document.getElementById('engine-search-form');
    var results = document.getElementById('engine-search-results');
    var countEl = document.getElementById('engine-search-count');
    if (!form || !results) return;

    var vehicleTypeSelect = form.querySelector('[name="vehicle_type"]');
    var makeSelect = form.querySelector('[name="vehicle_make"]');

    if (vehicleTypeSelect && makeSelect) {
        vehicleTypeSelect.addEventListener('change', function () {
            loadMakes(vehicleTypeSelect.value);
        });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        doSearch(1);
    });

    results.addEventListener('click', function (e) {
        var pageBtn = e.target.closest('[data-page]');
        if (pageBtn) {
            e.preventDefault();
            doSearch(parseInt(pageBtn.dataset.page, 10));
        }
    });

    function doSearch(page) {
        var data = new FormData(form);
        data.append('action', 'uspeh_engine_search');
        data.append('nonce', uspehAjax.nonce);
        data.append('paged', page);

        results.classList.add('is-loading');

        fetch(uspehAjax.url, { method: 'POST', body: data })
            .then(function (r) { return r.json(); })
            .then(function (resp) {
                results.classList.remove('is-loading');
                if (resp.success) {
                    results.innerHTML = resp.data.html;
                    if (countEl) {
                        countEl.textContent = resp.data.found + ' резултата';
                    }
                    if (resp.data.max_pages > page) {
                        results.insertAdjacentHTML('beforeend',
                            '<div class="engine-search__pagination">' +
                            '<button class="btn btn--outline btn--small" data-page="' + (page + 1) + '">Следваща страница →</button>' +
                            '</div>'
                        );
                    }
                }
            })
            .catch(function () {
                results.classList.remove('is-loading');
                results.innerHTML = '<p>Възникна грешка. Моля, опитайте отново.</p>';
            });
    }

    function loadMakes(vehicleType) {
        var data = new FormData();
        data.append('action', 'uspeh_get_makes');
        data.append('nonce', uspehAjax.nonce);
        data.append('vehicle_type', vehicleType);

        fetch(uspehAjax.url, { method: 'POST', body: data })
            .then(function (r) { return r.json(); })
            .then(function (resp) {
                if (!resp.success || !makeSelect) return;
                makeSelect.innerHTML = '<option value="">' + makeSelect.dataset.placeholder + '</option>';
                resp.data.forEach(function (term) {
                    var opt = document.createElement('option');
                    opt.value = term.slug;
                    opt.textContent = term.name;
                    makeSelect.appendChild(opt);
                });
            });
    }
})();
