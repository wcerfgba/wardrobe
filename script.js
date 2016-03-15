var $ = window.jQuery;
var SVGInjector = window.SVGInjector;


document.addEventListener("DOMContentLoaded", function () {
    registerSidebarToggle();
    injectIcons();
    registerPostSidepage();
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

function registerPostSidepage() {
    $("#primary").after('<div id="sidepage" class="display-none"></div>');
    $(".grid-post").click(function () {
        if (! $("#sidepage").hasClass("display-none")) {
            var active_title = "#grid-" + $("#sidepage article").attr("id") +
                               "-title";
            $(active_title).removeClass("active-post-title");
        }

        var id = /^grid-post-(\d+)$/.exec($(this).attr("id"))[1];
        $("#sidepage").load(document.URL + "?sidepage=true&p=" + id);

        if (! $(this).children(".grid-post-title").hasClass("active-post-title")) {
            $(this).children(".grid-post-title").addClass("active-post-title");
        }

        if ($("#sidepage").hasClass("display-none")) {
            $("#sidepage").removeClass("display-none");
            $("#primary").width("60%");
        }
    });
}
