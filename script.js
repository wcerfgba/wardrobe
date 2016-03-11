var $ = window.jQuery;
var SVGInjector = window.SVGInjector;


document.addEventListener("DOMContentLoaded", function () {
    registerSidebarToggle();
    injectIcons();
});


function registerSidebarToggle() {
    var button = $("#sidebar-toggle");
    var sidebar = $("#secondary");
    
    button.click(function () {
        sidebar.fadeToggle();
    });
}

function injectIcons() {
    SVGInjector(document.querySelectorAll(".iconic-sprite"));
}
