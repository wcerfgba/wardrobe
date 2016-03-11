var $ = window.jQuery;

document.addEventListener("DOMContentLoaded", function () {
    registerSidebarToggle();
});


function registerSidebarToggle() {
    var button = $("#sidebar-toggle");
    var sidebar = $("#secondary");
    
    button.click(function () {
        sidebar.fadeToggle();
    });
}
