var $ = window.jQuery;
var SVGInjector = window.SVGInjector;


document.addEventListener("DOMContentLoaded", function () {
    registerSidebarToggle();
    injectIcons();
    registerSidepage();
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

function registerSidepage() {
    $("#primary").after('<div id="sidepage" style="display: none;"></div>');
    $(".grid-post").click(function () {
        // Clear currently selected grid post, if any.
        if ($("#sidepage").css("display") !== "none") {
            var active_title = "#grid-" + $("#sidepage article").attr("id") +
                               "-title";
            $(active_title).removeClass("active-post-title");
        }

        // Load relevant post.
        var id = gridPostId(this);
        $("#sidepage").load(document.URL + "?sidepage=true&p=" + id,
                            sidepageLoadHandler(this));
    });
}

function gridPostId(gridPost) {
    return /^grid-post-(\d+)$/.exec($(gridPost).attr("id"))[1];
}

function sidepageLoadHandler(gridPost) {
    return function () {
        // Highlight active post.
        if (! $(gridPost).children(".grid-post-title")
                         .hasClass("active-post-title")) {
            $(gridPost).children(".grid-post-title")
                       .addClass("active-post-title");
        }

        // Display sidepage if hidden.
        if ($("#sidepage").css("display") === "none") {
            $("#sidepage").removeAttr("style");
            $("#sidepage").animate({ width: "40%" });
            $("#primary").animate({ width: "60%" });
        }

        // Bind button listeners.
        $("#sidepage-close-button").click(function () {
            $(gridPost).children(".grid-post-title")
                       .removeClass("active-post-title");
            $("#sidepage").animate({ width: "0%" }, function () {
                $("#sidepage").attr("style", "display: none;");
            });
            $("#primary").animate({ width: "100%" });
        });

        $("#sidepage-prev-button").click(function () {
            var prevGridPost;

            if ($(gridPost).prev().is(".grid-post")) {
                prevGridPost = $(gridPost).prev();
            } else {
                prevGridPost = $(gridPost).siblings().last();
            }

            // Clear currently selected grid post, if any.
            if ($("#sidepage").css("display") !== "none") {
                var active_title = "#grid-" + $("#sidepage article").attr("id") +
                                   "-title";
                $(active_title).removeClass("active-post-title");
            }

            var id = gridPostId(prevGridPost);
            $("#sidepage").load(document.URL + "?sidepage=true&p=" + id,
                                sidepageLoadHandler(prevGridPost));
        });
        
        $("#sidepage-next-button").click(function () {
            var nextGridPost;

            if ($(gridPost).next().is(".grid-post")) {
                nextGridPost = $(gridPost).next();
            } else {
                nextGridPost = $(gridPost).siblings().first();
            }

            // Clear currently selected grid post, if any.
            if (! $("#sidepage").hasClass("display-none")) {
                var active_title = "#grid-" + $("#sidepage article").attr("id") +
                                   "-title";
                $(active_title).removeClass("active-post-title");
            }

            var id = gridPostId(nextGridPost);
            $("#sidepage").load(document.URL + "?sidepage=true&p=" + id,
                                sidepageLoadHandler(nextGridPost));
        });
    };
}
