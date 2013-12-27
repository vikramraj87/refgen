/**
 * Peroforms ajax request using the configuration parameters provided and runs callback functions on success and
 * failure.
 *
 * @param {Object} p Contains configuration parameters
 */
function ajaxCall(p)
{
	var params = {
		method  : "get",
		url     : "url",
		data    : null,
		async   : false,
		success : null,
		failure : null
	};
	for(prop in p) {
		if(prop in params) {
			params[prop] = p[prop]  
		}
	}

    /**
     * @type XMLHttpRequest
     */
    var xhr;
	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4) {
			if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304) {
				if(typeof params.success == "function") {
					params.success(xhr.responseText);
				}
			} else {
				if(typeof params.failure == "function") {
					params.failure();
				}
			}
		}
	};
	xhr.open(params.method, params.url, params.async);
	xhr.send(params.data);
}

function rebuildList(result) 
{
	var ol = document.querySelector("ol#citations");
	if(!ol) {
		ol = document.createElement("ol");
		ol.id = "citations";
		
		sb = document.querySelector("section#sidebar");
		
		var p = sb.querySelector("p");
		
		if(p) {
			p.parentNode.removeChild(p);
		}
		sb.appendChild(ol);
		
	}
	dragHandler.destroy();
	var lis = ol.querySelectorAll("li");
	if(lis) {
		[].forEach.call(lis, function(li) {
			li.querySelector("a").removeEventListener("click", removeHandler, false);
			li.parentNode.removeChild(li);
		});
	}
	if(result.length > 0) {
		result.forEach(function(val) {
			var li = document.createElement("li"),
				a  = document.createElement("a");
				
			li.classList.add("clear-fix");
			li.setAttribute("draggable", "true");
			li.appendChild(document.createTextNode(val["cite"]));
			
			a.setAttribute("href", "search.php?action=del&pmid=" + val["pmid"]);
			a.setAttribute("data-pmid", val["pmid"]);
			a.addEventListener("click",removeHandler,false);
			a.appendChild(document.createTextNode("Remove"));
			
			
			li.appendChild(a);
			ol.appendChild(li);
		});
		dragHandler.init();
	} else {
		var p = document.createElement("p");
		p.appendChild(document.createTextNode('Add references to build a numbered list. Click the "Add to list" link to add the corresponding reference to your collection.'));
		ol.parentNode.replaceChild(p, ol);
	}
}


function addHandler(e)
{
	e.preventDefault();
	
	var pmid = e.target.dataset.pmid;
	
	ajaxCall({
		url     : "ajaxhandler.php?action=add&pmid=" + pmid,
		success : function(responseText) {
			try {
				var result = JSON.parse(xhr.responseText);
				rebuildList(result);
			} catch (ex) {
			}
		}
	});	
}

function removeHandler(e)
{
	e.preventDefault();
	
	var pmid = e.target.dataset.pmid;
		
	ajaxCall({
		url     : "ajaxhandler.php?action=del&pmid=" + pmid,
		success : function(responseText) {
			try {
				var result = JSON.parse(xhr.responseText);
				rebuildList(result);
			} catch (ex) {
			}
		}
	});
}

var dragHandler = {
	srcElement: null,
	listItems: null,
	list: null,
	order:[],
	from:-1,
	to:-1,
	
	init:function() {
		// Clear previous values
		dragHandler.srcElement = null;
		dragHandler.listItems  = null;
		dragHandler.order      = [];
		dragHandler.from       = -1;
		dragHandler.to         = -1;
		
		dragHandler.list      = document.querySelector("ol#citations");
		if(dragHandler.list) {
			dragHandler.listItems = dragHandler.list.querySelectorAll("li");
			if(dragHandler.listItems) {
				[].forEach.call(dragHandler.listItems, function(li, index) {
					li.addEventListener("dragstart", dragHandler.dragStart, false);
					li.addEventListener("dragenter", dragHandler.dragEnter, false);
					li.addEventListener("dragleave", dragHandler.dragLeave, false);
					li.addEventListener("dragover",  dragHandler.dragOver,  false);
					li.addEventListener("drop",      dragHandler.drop,      false);
					li.addEventListener("dragend",   dragHandler.dragEnd,   false);
					li.dataset.in = index;
					li.setAttribute("draggable", "true");
					var pmid = li.querySelector("a").dataset.pmid;
					dragHandler.order.push(pmid);
				});
			}
		}
	},
	destroy: function() {
		if(dragHandler.listItems) {
			[].forEach.call(dragHandler.listItems, function(li) {
				li.removeEventListener("dragstart", dragHandler.dragStart, false);
				li.removeEventListener("dragenter", dragHandler.dragEnter, false);
				li.removeEventListener("dragleave", dragHandler.dragLeave, false);
				li.removeEventListener("dragover",  dragHandler.dragOver,  false);
				li.removeEventListener("drop",      dragHandler.drop,      false);
				li.removeEventListener("dragend",   dragHandler.dragEnd,   false);
			});
		}
	},
	
	dragStart: function(e) {
		dragHandler.srcElement = e.target;
		e.target.classList.add("dragged");
		dragHandler.from = e.target.dataset.in;
	},
	dragEnter: function(e) {
		e.target.classList.add("drag-over");
	},
	dragLeave: function(e) {
		e.target.classList.remove("drag-over");
	},
	dragOver: function(e) {
		e.preventDefault();
		return false;
	},
	drop: function(e) {
		e.stopPropagation();
		dragHandler.list.insertBefore(dragHandler.srcElement, e.target);
		dragHandler.to = e.target.dataset.in;
		return false;
	},
	dragEnd: function(e) {
		e.target.classList.remove("dragged");
		[].forEach.call(dragHandler.listItems, function(li) {
			li.classList.remove("drag-over");
		});
		if(dragHandler.from != dragHandler.to && dragHandler.from != -1 && dragHandler.to != -1) {
			[].forEach.call(dragHandler.listItems, function(li) {
				li.setAttribute("draggable", "false");
			});
			if(dragHandler.from < dragHandler.to) {
				dragHandler.to--;
			}
			var moved = dragHandler.order.splice(dragHandler.from,1);
			dragHandler.order.splice(dragHandler.to,0,moved[0]);
			ajaxCall({
				url     : "ajaxhandler.php?action=sort&pmid=" + dragHandler.order.join(","),
				success : function(responseText) {
					try {
						var result = JSON.parse(xhr.responseText);
						rebuildList(result);
					} catch (ex) {
					}
				}
			});
		}
	}
};

window.addEventListener("load", function() {
	/*
    dragHandler.init();
	
	var addToList   = document.querySelectorAll("a.add-to-list"),
		remFromList = document.querySelectorAll("ol#citations li a");
	
	[].forEach.call(addToList, function(el) {
		el.addEventListener("click", addHandler, false);
	});
	[].forEach.call(remFromList, function(el) {
		el.addEventListener("click", removeHandler, false);
	});
	*/

    /**
     * @type {HTMLElement}
     */
    var formSearch;

    formSearch = document.getElementById("form-search");
    formSearch.addEventListener("submit", function(e) {
        e.preventDefault();
        /**
         * Search term
         *
         * @type {String}
         */
        var term = this.elements["term"].value;

        // trimming the text
        term = term.replace(/^\s+|\s+$/g, "");
        if(term.length > 0) {
            window.location.href = "http://" + location.hostname + "/search/result/term/" + encodeURIComponent(term);
        }
    }, false);
	
}, false);

