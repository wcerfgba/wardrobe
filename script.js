var $ = window.jQuery;


document.addEventListener("DOMContentLoaded", function () {
    registerSidebarToggle();
    registerSidepage();
});


function registerSidebarToggle() {
    var button = $("#sidebar-toggle");
    var sidebar = $("#secondary");
    
    button.click(function () {
        sidebar.fadeToggle();
    });
}


function registerSidepage() {
    $("#primary").after('<div id="sidepage" style="display: none;"></div>');
    $(".post-link").click(function (event) {
        event.preventDefault(); // Don't load the link.

        // Clear currently selected grid post, if any.
        if ($("#sidepage").css("display") !== "none") {
            var active_title = "#grid-" + $("#sidepage article").attr("id") +
                               "-title";
            // TODO: Fix active highlighting for sidepage posts.
            $(active_title).removeClass("active-post-title");
        }

        // Load relevant post.
        $("#sidepage").load($(this).attr("href") + "&sidepage=true",
                            sidepageLoadHandler(this));
    });
}

function sidepageLoadHandler(postLink) {
    return function () {
        /* Highlight active post.
        if (! $(gridPost).children(".grid-post-title")
                         .hasClass("active-post-title")) {
            $(gridPost).children(".grid-post-title")
                       .addClass("active-post-title");
        }*/

        // Display sidepage if hidden.
        if ($("#sidepage").css("display") === "none") {
            $("#sidepage").removeAttr("style");
            $("#sidepage").animate({ width: "40%" });
            $("#primary").animate({ width: "60%" });
        }

        // Bind button listeners.
        $("#sidepage-close-button").click(function () {
           /* $(gridPost).children(".grid-post-title")
                       .removeClass("active-post-title");*/
            $("#sidepage").animate({ width: "0%" }, function () {
                $("#sidepage").attr("style", "display: none;");
            });
            $("#primary").animate({ width: "100%" });
        });

        $("#sidepage-prev-button").click(function () {
            var prevPostLink;

            if ($(postLink).parent().prev().is("article")) {
                // UNSAFE!
                prevPostLink = $(postLink).parent().prev().children().first();
            } else {
                prevPostLink = $(postLink).parent().siblings().last().children().first();
            }

            // Clear currently selected grid post, if any.
            if ($("#sidepage").css("display") !== "none") {
                var active_title = "#grid-" + $("#sidepage article").attr("id") +
                                   "-title";
                $(active_title).removeClass("active-post-title");
            }

            $("#sidepage").load($(prevPostLink).attr("href") + "&sidepage=true",
                                sidepageLoadHandler(prevPostLink));
        });
        
        $("#sidepage-next-button").click(function () {
            var nextPostLink;

            if ($(postLink).parent().next().is("article")) {
                // UNSAFE!
                nextPostLink = $(postLink).parent().next().children().first();
            } else {
                nextPostLink = $(postLink).parent().siblings().first().children().first();
            }

            // Clear currently selected grid post, if any.
            if ($("#sidepage").css("display") !== "none") {
                var active_title = "#grid-" + $("#sidepage article").attr("id") +
                                   "-title";
                $(active_title).removeClass("active-post-title");
            }

            $("#sidepage").load($(nextPostLink).attr("href") + "&sidepage=true",
                                sidepageLoadHandler(prevPostLink));
        });
    };
}
