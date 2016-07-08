var viewController = (function () {

    "use strict;"
    var instance;

    function init() {

        console.log("Starting ViewController...");

        // private variables & functions
        var transitionIsDone = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd';

        var wizardRight = $('.wizard-right');
        var wizardLeft = $('.wizard-left');
        var loading = $(".loading");

        var spinner = $(".spinner");

        // public variables & functions
        return {

            startSetup: function () {
                wizardRight.addClass("left-in");
            },

            continueSetup: function () {
                wizardRight.toggleClass("left-out left-in");
                wizardRight.one(transitionIsDone, function () {
                    wizardLeft.addClass("left-in");
                });
            },

            closeSetup: function () {
                wizardLeft.children().each(function () {
                    $(this).addClass("fade-out");
                });
                wizardLeft.addClass("show-fullscreen");
                $(".loading").fadeIn(330);
            },

            showMessage: function (message) {
                window.setTimeout(function () {
                    spinner.addClass("hide-fullscreen");
                    spinner.one(transitionIsDone, function () {
                        spinner.remove();
                        console.log(message);
                        $(".done > .message-box").text(message);
                        $(".done").addClass("show-message");
                    });
                }, 1500);
            }
        }; // return

    }; // init

    return {

        // Get the Singleton instance if one exists
        // or create one if it doesn't
        getInstance: function () {
            if (!instance) {
                instance = init();
            }
            return instance;
        }

    };

})(); // viewController
