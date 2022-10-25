jQuery(document).ready(function () {

    // Dark / Light mode toggle
    const light = 'light';
    const dark = 'dark';

    function handleBody(response) {
        body.removeClass(light);
        body.removeClass(dark);
        body.addClass(response.theme);
    }

    let body = jQuery('body');
    let darkLightUrl = jQuery('#dark-light-link');

    darkLightUrl.click(function (e) {


        e.preventDefault();
        darkLightUrl.html(' ....... ');

        jQuery.get(darkLightUrl.attr('href'), function (response) {

            if (response.theme === light) {
                darkLightUrl.html('<i class="bi bi-moon-fill"></i>');
            } else {
                darkLightUrl.html('<i class="bi bi-sun-fill"></i>');
            }

            handleBody(response);
        });

        return false;
    });

});