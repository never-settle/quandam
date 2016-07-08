var apiGenerator = (function () {

    "use strict;"
    var instance;

    function init() {

        console.log("Starting APIGenerator...");

        // private variables & functions
        // ...

        // public variables & functions
        var inputFields = $(".wizard input");

        return {

            generateController: function (showMessage) {

                var callback = showMessage;

                var params = {};
                inputFields.each(function () {
                    params[$(this).attr("name")] = $(this).val();
                });

                $.when($.ajax({
                    method: "POST",
                    url: "/quandam/app/services/setupService",
                    data: params
                })).then(function (data) {
                    console.log(data);

                    var json = JSON.parse(data);
                    console.log(json);

                    callback(json.status);
                });

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

})(); // apiGenerator
