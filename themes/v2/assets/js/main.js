jQuery(document).ready(function () {

    // Handling toggle sidebar
    let content = jQuery('section.content');
    let leftNavigation = jQuery('aside.left-navigation');
    jQuery('#btn-toggle-sidebar').on('click', function () {
        let width = leftNavigation.css('width');
        if (width === '0px') {
            content.css('margin-left', '200px');
            leftNavigation.css('width', '200px');
            leftNavigation.css('border-right', '1px solid #e9ecef');
        } else {
            content.css('margin-left', 0);
            leftNavigation.css('width', 0);
            leftNavigation.css('border-right', 'none');
        }

    });

    // Handling click li sidebar : icon
    jQuery('.sidebar-nav li').click(function (e) {
        let i = jQuery(this).find('div.pe-1 i');
        if (i.hasClass('bi-arrow-right-circle')) {
            i.removeClass('bi-arrow-right-circle');
            i.addClass('bi-arrow-down-circle');
        } else {
            i.removeClass('bi-arrow-down-circle');
            i.addClass('bi-arrow-right-circle');
        }
    });

    // Handling mnemonic shortcut
    let searchBox = jQuery('#search-menu');
    document.onkeyup = function (e) {
        if (e.ctrlKey && e.which === 191) {
            searchBox.select2('open');
        }
    };

    // Dark OR Light mode toggle
    const light = 'light';
    const dark = 'dark';

    let body = jQuery('body');

    function handleBody(response) {
        body.removeClass(light);
        body.removeClass(dark);
        body.addClass(response.theme);
    }


    let navbar = jQuery('#navbar');

    function handleNavbar(response) {
        navbar.removeClass('navbar-dark');
        navbar.removeClass('bg-dark');
        navbar.removeClass('navbar-light');
        navbar.removeClass('bg-light');
        navbar.addClass('navbar-' + response.theme);
        navbar.addClass('bg-' + response.theme);
    }

    let darkLightUrl = jQuery('#dark-light-link');
    darkLightUrl.click(function (e) {

        e.preventDefault();
        darkLightUrl.html(' ....... ');

        jQuery.get(darkLightUrl.attr('href'), function (response) {

            if (response.theme === light) {
                darkLightUrl.html('<i class="bi bi-moon"></i>');
            } else {
                darkLightUrl.html('<i class="bi bi-sun"></i>');
            }

            handleBody(response);
            handleNavbar(response);
        });

        return false;
    });

    // Animation On Submit
    jQuery(document).on('beforeSubmit', 'form', function (event) {
        let buttonSubmit = jQuery(this).find('button[type=submit]');
        buttonSubmit.html('<i class="bi bi-arrow-repeat"></i> Memproses...');
        buttonSubmit.attr('disabled', true).addClass('disabled');
    });

    let modalAlert = jQuery('#pa3py6aka-modal-alert');
    if (modalAlert) {
        let modalTitle = jQuery('#pa3py6aka-modal-alert .modal-dialog .modal-content .modal-header .modal-title');
        if (modalTitle.html() === '') {
            modalTitle.html('Pesan Sistem');
        }
    }


});