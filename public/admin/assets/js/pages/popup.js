!function(l) {
    "use strict";
    function e() {
        this.$body = l("body"),
        this.$modal = new bootstrap.Modal(document.getElementById("client-modal"), {
            backdrop: "static"
        }),
        this.$btnNewclient = l("#btn-new-client")
        
        this.$btnNewclient2 = l("#btn-new-client-1")
    }
    e.prototype.init = function() {
        var self = this;
        this.$btnNewclient.on("click", function() {
            self.$modal.show();
        });
        this.$btnNewclient2.on("click", function() {
            self.$modal.show();
        });
    },
    l.CalendarApp = new e,
    l.CalendarApp.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.CalendarApp.init()
}();

