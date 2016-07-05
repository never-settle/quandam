(function () {

    var vc = viewController.getInstance();
    vc.startSetup();

    $(document).on("click", ".js-btn-continue", function () {
        vc.continueSetup();
    });

    $(document).on("click", ".js-btn-generate", function () {
        vc.closeSetup();
    });

})();

