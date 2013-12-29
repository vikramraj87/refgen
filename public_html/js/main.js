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


    /* Correct the col height */
    if($("div#column-wrapper").length > 0) {
        var maxHeight = 0;
        $("div#column-wrapper .col").each(function(){
            console.log($(this).height());
            if($(this).height() > maxHeight) {
                maxHeight = $(this).outerHeight(true);
            }
        });
        $("div#column-wrapper .col").height(maxHeight + "px");
    }

    var md = {
        modal: null,
        overlay: null,
        border: null,

        showModal: function() {
            md.overlay.fadeIn("slow", function() {
                md.border.show();
            });
        },

        hideModal: function() {
            md.modal.css("height", "auto");
            md.modal.children().not(".close").remove();
            md.border.hide();
            md.overlay.fadeOut("slow");
        },

        initModal: function() {
            if(md.modal === null) {
                md.overlay = $('<div class="modal-overlay"></div>');
                md.overlay.appendTo("body");
                md.border = $('<div class="modal-window-border"></div>');
                md.overlay.append(md.border);
                md.modal = $('<div class="modal-window"></div>');
                $(".modal-window-border").append(md.modal);
            }
            $('<a class="close" href="#">x</a>')
                .click(function(){
                    md.hideModal();
                })
                .appendTo(md.modal);
            md.border.hide();
            md.overlay.hide();
            return md.modal;
        }

    };
    var exportClick = function(event) {
        event.preventDefault();
        var modal = md.initModal();
        md.showModal();

        var list = $("ol#citations");
        var ol = $('<ol></ol>');
        list.find("li").each(function(){
            var text = $(this).text();
            text = text.replace(/\s*x\s*$/,"");
            $('<li></li>').text(text).appendTo(ol);
        });
        ol.prependTo(modal);
        $('<h2>Citations</h2>').prependTo(modal);
        if(modal.height() > 400) {
            modal.css({
                height: "400px",
                overflow: "scroll"
            });
        }
    };
    $("a#export").click(exportClick);


    var ajaxLoader = {
        loaderDiv: null,
        loaderGif: null,
        sideBar:   $("section#sidebar"),
        list:      $("ol#citations"),

        init: function() {
            var sbH = this.sideBar.find("h2");

            this.sideBar.css("position", "relative");

            this.loaderGif = $('<img src="/img/loader.gif">');

            this.loaderDiv = $('<div id="ajax-status"></div>')
                .css({
                    position: "absolute",
                    top: sbH.outerHeight(true) + "px",
                    left: 0,
                    width: this.sideBar.outerWidth() + "px"
                })
                .appendTo(this.sideBar);

            this.loaderGif
                .appendTo(this.loaderDiv)
                .on("load", function(){
                    $(this).css({
                        display: "block",
                        marginLeft: "auto",
                        marginRight: "auto"
                    });
            });
            if($("p.replace").length < 1) {
                $("<p></p>")
                    .addClass("replace")
                    .text("Add references to build a numbered list. Click the \"Add to list\" link to add the corresponding reference to your collection. Order of the references can be rearranged by dragging and dropping the references.")
                    .insertAfter("ol#citations")
                    .hide();
            }
            this.loaderDiv
                .hide();
        },

        showLoader: function() {
            var sbH = this.sideBar.find("h2"),
                contentHeight = this.sideBar.outerHeight() - sbH.outerHeight(true);
            this.loaderDiv.css({
               height: contentHeight + "px"
            });

            this.loaderGif.css({
                marginTop: (contentHeight/2 - 20) + "px"
            });
            this.loaderDiv.fadeIn("slow");
        },

        hideLoader: function(callback) {
            this.loaderDiv.fadeOut("slow",function(){
                if(callback.call) {
                    callback.call();
                }
            });
        }
    };

    ajaxLoader.init();

    $("ol#citations").click(function(event){
        event.preventDefault();
        if(!$(event.target).is("a")) {
            return;
        }
        var curA = $(event.target),
            href = curA.attr("href"),
            pmid = /^.*\/pmid\/(\d+).*$/.exec(href)[1],
            list = $("ol#citations"),
            item = curA.parents("li");

        list.fadeTo("slow", 0.2, function() {
            ajaxLoader.showLoader();
            var removeItem = false;
            $.getJSON("/ajax/del/pmid/" + pmid, function(data) {
                console.log(data);
                if(data.status) {
                    removeItem = true;
                }
            });
            ajaxLoader.hideLoader(function(){
                list.fadeTo("slow", 1, function() {
                    item.slideUp("slow", function() {
                        if(removeItem) {
                            item.remove();
                            if(list.find("li").length < 1) {
                                $("p.replace")
                                    .slideDown("slow", function() {
                                        $("div#options").slideUp("slow");
                                    })
                                    .fadeTo("slow", 1);
                            }
                        }
                    });
                });
            })
        });
    });

    $("p.add-to-list a").click(function(event){
        event.preventDefault();

        if($(this).hasClass("active")) {
            return false;
        }

        var clicked  = $(this).addClass("active"),
            href     = $(this).attr("href"),
            matches  = /^.*\/pmid\/(\d+).*$/.exec(href),
            pmid     = matches[1],
            cite     = $(this).parents("footer").find("span.citation").text(),
            replaceP = $("p.replace"),
            list     = $("ol#citations");

        if(replaceP.length > 0 && replaceP.is(":visible")) {
            replaceP.fadeTo("slow", 0.2);
        }

        list.fadeTo("slow", 0.2, function() {
            var newItem;

            ajaxLoader.showLoader();

            $.getJSON("/ajax/add/pmid/" + pmid, function(data) {
                if(data.pmid) {
                    if(replaceP.length > 0) {
                        replaceP.slideUp("slow");
                        var options = $("div#options");
                        if(options.length < 1) {
                            options = $('<div id="options"></div>')
                                .addClass("clearfix")
                                .append('<a href="#" id="export">export</a>')
                                .insertAfter(list)
                                .hide()
                                .find("a#export")
                                .click(exportClick);
                        }
                    }
                    var remLink = $('<a>x</a>')
                        .attr(
                            "href", [
                                "/search/remove/pmid/",
                                pmid,
                                "?redirect=",
                                location.pathname
                            ].join("")
                    );
                    newItem = $('<li></li>')
                        .text(cite)
                        .append(remLink)
                        .appendTo(list)
                        .hide();
                }
                ajaxLoader.hideLoader(function(){
                    list.fadeTo("slow", 1, function() {
                        if(newItem) {
                            newItem.slideDown("slow", function() {
                                if(!$("div#options").is(":visible")) {
                                    $("div#options").slideDown("slow");
                                }
                            });
                        }
                    });
                });
            });
            clicked.removeClass("active");
        });
    });

});