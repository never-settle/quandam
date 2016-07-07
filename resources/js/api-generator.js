var apiGenerator = (function () {

    var instance;

    function init() {

        console.log("Starting APIGenerator...");

        // private variables & functions
        // ...

        // public variables & functions
        var inputFields = $(".wizard input");

        return {

            generateController: function (showSuccess) {

                var params = {};
                inputFields.each(function () {
                    params[$(this).attr("name")] = $(this).val();
                });

                $.ajax({
                    method: "POST",
                    url: "/quandam/app/services/setupService",
                    data: params,
                    async: false,
                    success: function (response) {
                        showSuccess(response);
                    },
                    error: function (response) {
                        console.log("error");
                        console.log(response);

                        // return error for ViewController Actions;
                    }
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
