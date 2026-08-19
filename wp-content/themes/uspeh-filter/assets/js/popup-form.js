(function () {
    document.querySelectorAll('[data-product-inquiry]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var product = btn.dataset.productInquiry || '';
            var popup = document.getElementById('popup-quote');
            if (!popup) return;

            var productField = popup.querySelector('[name="product"]');
            if (productField) productField.value = product;

            popup.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        });
    });
})();
