jQuery(document).ready(function () {
    const hash = window.location.hash;
    hash && $('ul.nav.nav-pills a[href="' + hash + '"]').tab('show');
    $('ul.nav.nav-pills a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop() || $('html').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });
});