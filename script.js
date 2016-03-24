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

        // Clear currently active post link, if any.
        if ($("#sidepage").css("display") !== "none") {
            var activePostLink = "#" + $("#sidepage article").attr("id") +
                                 "-link";
            $(activePostLink).removeClass("active-post-link");
        }

        // Load relevant post.
        $("#sidepage").load($(this).attr("href") + "&sidepage=true",
                            sidepageLoadHandler(this));
    });
}

function sidepageLoadHandler(postLink) {
    return function () {
        // Highlight active post.
        if (! $(postLink).hasClass("active-post-link")) {
            $(postLink).addClass("active-post-link");
        }

        // Display sidepage if hidden.
        if ($("#sidepage").css("display") === "none") {
            $("#sidepage").removeAttr("style");
            $("#sidepage").animate({ width: "40%" });
            $("#primary").animate({ width: "60%" });
        }

        // Bind button listeners.
        $("#sidepage-close-button").click(function () {
            $(postLink).removeClass("active-post-link");
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

            // Clear currently active post link, if any.
            if ($("#sidepage").css("display") !== "none") {
                var activePostLink = "#" + $("#sidepage article").attr("id") +
                                     "-link";
                $(activePostLink).removeClass("active-post-link");
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

            // Clear currently active post link, if any.
            if ($("#sidepage").css("display") !== "none") {
                var activePostLink = "#" + $("#sidepage article").attr("id") +
                                     "-link";
                $(activePostLink).removeClass("active-post-link");
            }

            $("#sidepage").load($(nextPostLink).attr("href") + "&sidepage=true",
                                sidepageLoadHandler(nextPostLink));
        });
    };
}
