jQuery(document).ready(function () {

    // Handling toggle sidebar
    let content = jQuery('section.content');
    let leftNavigation = jQuery('aside.left-navigation');

    function getSidebarWidth() {
        // 1) Prefer a CSS custom property if present
        const root = document.documentElement;
        let cssVar = getComputedStyle(root).getPropertyValue('--sidebar-width');
        if (cssVar) {
            cssVar = cssVar.trim();
            if (cssVar && cssVar !== '0' && cssVar !== '0px') return cssVar;
        }
        // 2) Use current content margin-left if > 0
        let ml = getComputedStyle(content.get(0)).marginLeft;
        if (ml && ml !== '0px') return ml;
        // 3) Use current leftNavigation width if > 0
        let lw = leftNavigation.length ? getComputedStyle(leftNavigation.get(0)).width : '0px';
        if (lw && lw !== '0px') return lw;
        // 4) Fallback: try to read sidebar inner container width
        const inner = leftNavigation.find('.sidebar-shell');
        if (inner.length) {
            const rect = inner.get(0).getBoundingClientRect();
            if (rect.width) return rect.width + 'px';
        }
        // 5) As a last neutral fallback, return current margin-left (could be 0)
        return ml || '0px';
    }

    jQuery('#btn-toggle-sidebar').on('click', function () {
        let width = leftNavigation.css('width');
        if (width === '0px') {
            const sw = getSidebarWidth();
            content.css('margin-left', sw);
            leftNavigation.css('width', sw);
            // leftNavigation.css('border-right', '1px solid #e9ecef');
        } else {
            content.css('margin-left', 0);
            leftNavigation.css('width', 0);
            // leftNavigation.css('border-right', 'none');
        }

    });

    // Handling click li sidebar : icon
    jQuery('.sidebar-nav li').click(function () {
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
    jQuery(document).on('beforeSubmit', 'form', function () {
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