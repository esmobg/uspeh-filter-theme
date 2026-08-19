(function () {
    var subMenuParents = document.querySelectorAll('.site-nav__list > li.menu-item-has-children > a');
    if (window.innerWidth > 1024) return;

    subMenuParents.forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth > 1024) return;
            var parent = link.parentElement;
            var sub = parent.querySelector('.sub-menu');
            if (!sub) return;

            e.preventDefault();
            parent.classList.toggle('is-sub-open');
        });
    });
})();
