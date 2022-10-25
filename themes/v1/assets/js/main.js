jQuery(document).ready(function () {


    // Handling toggle sidebar
    let navbar = jQuery('#navbar');
    let contentDiv = jQuery('.content-section');
    let sidebar = jQuery('aside.sidebar');

    jQuery('#btn-toggle-sidebar').on('click', function () {

        let margin = sidebar.css('margin-left');
        console.log(margin);

        if (margin === '-250px') {

            sidebar.css('margin-left', '1rem');
            contentDiv.css('left', '272px');
            contentDiv.css('margin-left', '250px');
            navbar.css('margin-left', '1rem');

        } else {
            sidebar.css('margin-left', '-250px');
            contentDiv.css('left', '0');
            contentDiv.css('margin-left', '1rem');
            navbar.css('margin-left', '-250px');
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

});