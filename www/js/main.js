(function ($) {
    "use strict";

    // Initiate the wowjs
    new WOW().init();


    // Header shadow on scroll
    $(window).scroll(function () {
        $('.site-header').toggleClass('scrolled', $(this).scrollTop() > 10);
    });

    // Close mobile menu after clicking a link
    $('#navbarCollapse .nav-link').on('click', function () {
        $('#navbarCollapse').removeClass('show');
    });

    // Certificate lightbox
    const lightbox = document.getElementById('certLightbox');
    if (lightbox) {
        const $items = $('.cert-item');
        const img = lightbox.querySelector('img');
        let current = 0;

        const show = function (index) {
            current = (index + $items.length) % $items.length;
            const item = $items[current];
            img.src = item.href;
            img.alt = $(item).find('img').attr('alt');
        };

        $items.on('click', function (e) {
            e.preventDefault();
            show($items.index(this));
            lightbox.showModal();
        });

        $(lightbox).on('click', '[data-lightbox]', function (e) {
            e.stopPropagation();
            const action = $(this).data('lightbox');
            if (action === 'close') lightbox.close();
            if (action === 'prev') show(current - 1);
            if (action === 'next') show(current + 1);
        });

        // Click on the backdrop closes the dialog
        $(lightbox).on('click', function (e) {
            if (e.target === lightbox) lightbox.close();
        });

        $(document).on('keydown', function (e) {
            if (!lightbox.open) return;
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });
    }

})(jQuery);
