(function () {
    window.print();
    window.onafterprint = function () {
        window.close();
    }
    console.log("Copyright this app, ahmadfadlydziljalal@gmail.com");
})();