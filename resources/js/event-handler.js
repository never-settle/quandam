(function () {

    console.log("EventHandler is listening ...");
    var vc  = viewController.getInstance();
    var api = apiGenerator.getInstance();

    vc.startSetup();

    $(document).on("click", ".js-btn-continue", function () {
        vc.continueSetup();
    });

    $(document).on("click", ".js-btn-generate", function () {
        vc.closeSetup();
        api.generateController();
    });

})();

