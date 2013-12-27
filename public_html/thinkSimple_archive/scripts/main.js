function checkOrder(order)
{
    if(!$.isArray(order)) {
        throw new TypeError("order should be an array of ids");
    }

}
function addToList(pmid, cite)
{

}

function modifyList(action, values)
{

}

$(document).ready(function(){
    /* Remove hidden attribute and replace with "display:none" so that we can animate */
    $("div.full").removeAttr("hidden").hide();

    /* Prevent form submit and redirect with the required parameters so that we can prevent ugly URLs */
    $("#form-search").submit(function(event){
        event.preventDefault();

        // Get the search term
        var term = this.elements["term"].value;

        // Trim the term
        term = term.replace(/^\s+|\s+$/g, "");

        // Redirect to the proper URL
        if(term.length > 0) {
            window.location.href = [
                "http://",
                location.hostname,
                "/search/result/term/",
                encodeURIComponent(term)
            ].join("");
        }
    });

    /* Read more action */
    $("p.read-more a").click(function(event){
        event.preventDefault();
        var currentRmLink = $(this);
        $(this).parents("div.abstract").find("p.truncated").slideUp("fast", function(){
            $(this).parent().find("div.full").slideDown("slow");
            currentRmLink.hide();
        });
    });

    (function(){
        var sb  = $("section#sidebar");
        sb.css({
            position: "relative"
        });
        var sbH = sb.find("h2"),
            ajaxStatusDivHeight = sb.outerHeight() - sbH.outerHeight(true),
            content         = sbH.next(),
            loaderImgHeight = 0,
            loaderDiv       = $("<div></div>")
                .attr("id", "ajax-status")
                .css({
                    position: "absolute",
                    top: sbH.outerHeight(true) + "px",
                    left: 0,
                    height: ajaxStatusDivHeight + "px",
                    width: sb.outerWidth() + "px"
                })
                .append('<img>')
                .find("img")
                .attr("src", "/images/484.gif")
                .on("load", function(){
                    loaderImgHeight = $(this).height();
                    $(this).css({
                        display:"block",
                        marginTop: (ajaxStatusDivHeight/2 - loaderImgHeight/2) + "px",
                        marginLeft: "auto",
                        marginRight: "auto"
                    });
                })
                .end()
                .appendTo(sb)
                .hide(),
            citeOl;
        $("a.add-to-list").click(function(event){
            event.preventDefault();
            var href    = $(this).attr("href"),
                matches = /^.*\/pmid\/(\d+).*$/.exec(href),
                pmid    = matches[1],
                cite    = $(this).parents("footer").find("span.citation").text();

            content.fadeTo("slow", 0.2, function(){
                loaderDiv.fadeIn("slow");
                $.get("/ajax/add/pmid/" + pmid, {}, function(data) {
                    data = $.parseJSON(data);
                    if(data.pmid) {
                        console.log("ok");
                        if(citeOl == null) {
                            citeOl = $("ol#citations");
                            if(citeOl.length < 1) {
                                citeOl = $('<ol id="citations"></ol>').appendTo(sb);
                                var replaceP = $("section#sidebar p.replace");
                                if(replaceP.length > 0) {
                                    replaceP.remove();
                                }
                            }
                        }
                        var redirect = location.pathname;
                        $("<li></li>")
                            .addClass("clearfix")
                            .text(cite)
                            .appendTo(citeOl)
                            .append("<a></a>")
                            .find("a")
                            .attr("src", "/search/remove/pmid/" + pmid + "?redirect=" + location.pathname)
                            .text("Remove");
                    }
                    loaderDiv.fadeOut("slow", function() {
                        content.fadeTo("slow", 1);
                    });
                });
            });


        });
    })();
});