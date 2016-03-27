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

var sidepageCloseButtonHTML = 
'<div class="buttons-left">' +
'   <button class="sidepage-close-button">' +
'   	<svg viewBox="0 0 8 8" class="icon">' +
'   		<use xlink:href="#x" class="icon-use icon-close-sidepage"></use>' +
'   	</svg>' +
'   	<span class="button-text text-close-sidepage">Close</span>' +
'   </button>' +
'</div>';

function loadSidepage(postLink) {
    $.get($(postLink).attr("href"), function (data) {
        // Build data.
        data = $(data);
        
        // Extract header and content.
        var header = $("#masthead", data);
        var content = $("article", data);

        // Mangle header.
        header.removeAttr("id")
              .removeClass()
              .addClass("sidepage-header");
        $(".site-title", header).replaceWith(sidepageCloseButtonHTML);
        $(".sidebar-button", header).remove();
        
        // Clear currently active post link, if any.
        var activePostLink = "#" + $("#sidepage article").attr("id") + "-link";
        $(activePostLink).removeClass("post-link_active");

        // Insert header and content into sidepage.
        $("#sidepage").html("")
                      .append(header)
                      .append(content);

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

function sidepageNavButtonHandler(event) {
    event.preventDefault();

    var postLink = $("#post-" + $(this).attr("post-id") + "-link");
    loadSidepage(postLink);
}
