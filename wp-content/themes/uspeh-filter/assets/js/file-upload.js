(function () {
    document.querySelectorAll('.file-upload').forEach(function (zone) {
        var input = zone.querySelector('input[type="file"]');
        var preview = zone.querySelector('.file-upload__preview');
        if (!input) return;

        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.classList.add('is-dragover');
        });
        zone.addEventListener('dragleave', function () {
            zone.classList.remove('is-dragover');
        });
        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('is-dragover');
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                updatePreview(input.files, preview);
            }
        });

        input.addEventListener('change', function () {
            updatePreview(input.files, preview);
        });
    });

    function updatePreview(files, container) {
        if (!container) return;
        container.innerHTML = '';
        Array.from(files).forEach(function (file) {
            var el = document.createElement('span');
            el.className = 'file-upload__file';
            el.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
            container.appendChild(el);
        });
    }
})();
