var $ = window.jQuery;


document.addEventListener("DOMContentLoaded", function () {
    registerSidebarToggle();
    registerSidepage();
});


function registerSidebarToggle() {
    var button = $(".sidebar-button__button");
    var sidebar = $("#secondary");
    
    button.click(function () {
        sidebar.fadeToggle();
    });
}


function registerSidepage() {
    $("#main").after('<div id="sidepage" style="display: none;"></div>');
    $(".post-link").click(function (event) {
        // Follow the link if the sidepage would be too small.
        if (window.innerWidth < 1000) {
            return;
        }

        event.preventDefault(); // Don't load the link.

        // Clear currently active post link, if any.
        if ($("#sidepage").css("display") !== "none") {
            var activePostLink = "#" + $("#sidepage article").attr("id") +
                                 "-link";
            $(activePostLink).removeClass("post-link_active");
        }

        loadSidepage(this);
    });
}

function loadSidepage(postLink) {
    $.get(buildSubpageURL($(postLink).attr("href")), function (data) {
        // Build subpage.
        var subpage = $(data);
        
        // Clear currently active post link, if any.
        var activePostLink = "#" + $("#sidepage article").attr("id") + "-link";
        $(activePostLink).removeClass("post-link_active");

        // Insert subpage into sidepage.
        $("#sidepage").html(subpage);

        // Highlight active post.
        if (! $(postLink).hasClass("post-link_active")) {
            $(postLink).addClass("post-link_active");
        }

        // Display sidepage if hidden.
        if ($("#sidepage").css("display") === "none") {
            $("#sidepage").removeAttr("style");
            $("#sidepage").animate({ width: "40%" });
            $("#main").animate({ width: "60%" });
        }

        // Bind button listeners.
        $(".sidepage-close-button").click(function () {
            $(postLink).removeClass("post-link_active");
            $("#sidepage").animate({ width: "0%" }, function () {
                $("#sidepage").attr("style", "display: none;");
            });
            $("#main").animate({ width: "100%" });
        });
        
        $(".nav-links__prev-link").click(sidepageNavButtonHandler);
        $(".nav-links__next-link").click(sidepageNavButtonHandler);
    });
}

function buildSubpageURL(url) {
    if (/[?&][^?&=]+=[^?&=]+$/.test(url)) {
        return url + "&subpage=true";
    } else {
        return url + "?subpage=true";
    }
}

function sidepageNavButtonHandler(event) {
    event.preventDefault();

    var postLink = $("#post-" + $(this).attr("post-id") + "-link");
    loadSidepage(postLink);
}
