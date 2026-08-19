document.addEventListener('DOMContentLoaded', function () {
    initMobileNav();
    initFaqAccordion();
    initPopup();
    initStickyHeader();
    initHeroSlider();
});

function initHeroSlider() {
    var root = document.querySelector('[data-hero-slider]');
    if (!root) return;

    var slides = root.querySelectorAll('.hero__slide');
    var dots = root.querySelectorAll('[data-hero-dot]');
    if (slides.length < 2) return;

    var current = 0;
    var timer;

    function goTo(index) {
        slides[current].classList.remove('is-active');
        if (dots[current]) dots[current].classList.remove('is-active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('is-active');
        if (dots[current]) dots[current].classList.add('is-active');
    }

    function start() {
        timer = window.setInterval(function () {
            goTo(current + 1);
        }, 6000);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            window.clearInterval(timer);
            goTo(parseInt(dot.getAttribute('data-hero-dot'), 10));
            start();
        });
    });

    start();
}

function initMobileNav() {
    var burger = document.getElementById('burger-toggle');
    var nav = document.getElementById('site-nav');
    if (!burger || !nav) return;

    var toggles = nav.querySelectorAll('.site-nav__toggle');

    function closeNav() {
        nav.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
        burger.classList.remove('is-active');
        document.body.classList.remove('menu-open');
    }

    function closeSubmenus() {
        toggles.forEach(function (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
            var item = toggle.closest('.menu-item-has-children');
            if (item) {
                item.classList.remove('is-sub-open');
            }
        });
    }

    burger.addEventListener('click', function () {
        var isOpen = nav.classList.toggle('is-open');
        burger.setAttribute('aria-expanded', String(isOpen));
        burger.classList.toggle('is-active', isOpen);
        document.body.classList.toggle('menu-open', isOpen);
        if (!isOpen) {
            closeSubmenus();
        }
    });

    document.addEventListener('click', function (e) {
        if (!nav.contains(e.target) && !burger.contains(e.target) && nav.classList.contains('is-open')) {
            closeNav();
            closeSubmenus();
        }
    });

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            if (window.innerWidth > 1024) return;

            var item = toggle.closest('.menu-item-has-children');
            if (!item) return;

            var willOpen = !item.classList.contains('is-sub-open');

            toggles.forEach(function (otherToggle) {
                if (otherToggle !== toggle) {
                    otherToggle.setAttribute('aria-expanded', 'false');
                    var otherItem = otherToggle.closest('.menu-item-has-children');
                    if (otherItem) {
                        otherItem.classList.remove('is-sub-open');
                    }
                }
            });

            item.classList.toggle('is-sub-open', willOpen);
            toggle.setAttribute('aria-expanded', String(willOpen));
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 1024) {
            nav.classList.remove('is-open');
            burger.setAttribute('aria-expanded', 'false');
            burger.classList.remove('is-active');
            document.body.classList.remove('menu-open');
            closeSubmenus();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && nav.classList.contains('is-open')) {
            closeNav();
            closeSubmenus();
        }
    });
}

function initFaqAccordion() {
    document.querySelectorAll('.faq-item__question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.faq-item');
            var answer = item.querySelector('.faq-item__answer');
            var inner = answer.querySelector('.faq-item__answer-inner');
            var isOpen = item.classList.contains('is-open');

            document.querySelectorAll('.faq-item.is-open').forEach(function (openItem) {
                if (openItem !== item) {
                    openItem.classList.remove('is-open');
                    openItem.querySelector('.faq-item__answer').style.maxHeight = '0';
                }
            });

            if (isOpen) {
                item.classList.remove('is-open');
                answer.style.maxHeight = '0';
            } else {
                item.classList.add('is-open');
                answer.style.maxHeight = inner.scrollHeight + 'px';
            }
        });
    });
}

function initPopup() {
    document.querySelectorAll('[data-popup-open]').forEach(function (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            var target = document.getElementById(trigger.dataset.popupOpen);
            if (target) target.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        });
    });

    document.querySelectorAll('[data-popup-close]').forEach(function (closeBtn) {
        closeBtn.addEventListener('click', function () {
            var overlay = closeBtn.closest('.popup-overlay');
            if (overlay) overlay.classList.remove('is-active');
            document.body.style.overflow = '';
        });
    });

    document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('is-active');
                document.body.style.overflow = '';
            }
        });
    });
}

function initStickyHeader() {
    var header = document.getElementById('site-header');
    if (!header) return;
    var lastScroll = 0;

    window.addEventListener('scroll', function () {
        var currentScroll = window.pageYOffset;
        if (currentScroll > 200) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }
        lastScroll = currentScroll;
    }, { passive: true });
}
