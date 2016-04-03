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

        loadSidepage($(this).attr("href"));
    });
}

function loadSidepage(url) {
    $.get(buildSubpageURL(url), function (data) {
        // Build subpage.
        var subpage = $(data);

        clearActivePostLink();        

        // Insert subpage into sidepage.
        $("#sidepage").html(subpage);

        setActivePostLink();
        
        // Display sidepage if hidden.
        if ($("#sidepage").css("display") === "none") {
            $("#sidepage").removeAttr("style");
            $("#sidepage").animate({ width: "40%" });
            $("#main").animate({ width: "60%" });
        }

        // Bind button listeners.
        $(".sidepage-close-button").click(function () {
            clearActivePostLink();

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
    if (/[?&]/.test(url)) {
        return url + "&subpage=true";
    } else {
        return url + "?subpage=true";
    }
}

function clearActivePostLink() {
        var activePostLink = "#" + $("#sidepage article").attr("id") + "-link";
        $(activePostLink).removeClass("post-link_active");
}

function setActivePostLink() {
        var activePostLink = "#" + $("#sidepage article").attr("id") + "-link";
        $(activePostLink).addClass("post-link_active");
}

function sidepageNavButtonHandler(event) {
    event.preventDefault();

    loadSidepage($(this).attr("href"));
}
