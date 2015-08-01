hljs.configure({useBR: true});
var linecount, lineinterval, storeBool, pubObj, observe, changestyleinterval;
var writeHeader = function(msg) {
	$("#headerlarge").html(msg);
};
var writeSecondary = function(msg) {
	if(!newfile) {
		$("#ctext").text(msg).html();
		$("#ctext").html("&nbsp–&nbsp"+$("#ctext").html());
	} else {
		$("#ctext").text(msg).html();
	}
};
var error = function(msg, dash) {
	if(dash === undefined) {
		dash = true;
	}
	$("#ctext").css("color","#d13131").text(msg).html();
	if(dash) {
		$("#ctext").html("&nbsp–&nbsp"+$("#ctext").html());
	}
};
var clearError = function() {
	$("#ctext").html("").css("color", "#aaaaaa");
};
var lines = function(numlines) {
	var i = 1;
	var res = "";
	while(i <= numlines) {
		res += i+"<br>\n";
		i++;
	}
	$("#line-numbers").html(res);
};
var populate = function(str, lang) {
	if(!newfile) {
		$("#area").html(str);
	} else {
		$("#area").val(str);
	}
	if(hljs.getLanguage(lang) != undefined) {
		$(".hljs").attr("class", $(".hljs").attr("class")+" "+lang);
		if(hljs.getLanguage(lang).aliases == undefined || hljs.getLanguage(lang).aliases.sort(function (a, b) {return b.length - a.length;})[0].length < lang.length) {
			$("#highlight-status").html(lang);
		} else {
			$("#highlight-status").html(hljs.getLanguage(lang).aliases.sort(function (a, b) {return b.length - a.length;})[0]);
		}
		$(".highlight").css("opacity", 1);
	} else {
		$("#highlight-status").html("unknown");
		$(".highlight").css("opacity", 1);
	}
	hljs.highlightBlock($("#area")[0]);
};
var update = function() {
	storeBool = store.get("draft") != $("#area").val() || store.get("name") != $("#headerlarge").html();
	if(store.enabled && storeBool) {
		store.set("draft", $("#area").val());
		store.set("name", $("#headerlarge").html());
		var currentdate = new Date(), drafthours, draftminutes, draftseconds, meridian;
		if(currentdate.getHours() > 12) {
			drafthours = currentdate.getHours() - 12;
			meridian = "pm";
		} else if(currentdate.getHours() < 12) {
			drafthours = currentdate.getHours();
			meridian = "am";
			if(currentdate.getHours() == 0) {
				drafthours = 12;
			}
		} else {
			drafthours = currentdate.getHours();
			meridian = "pm";
		}
		if(currentdate.getMinutes() < 10) {
			draftminutes = "0"+currentdate.getMinutes();
		} else {
			draftminutes = currentdate.getMinutes();
		}
		if(currentdate.getSeconds() < 10) {
			draftseconds = "0"+currentdate.getSeconds();
		} else {
			draftseconds = currentdate.getSeconds();
		}
		$(".highlight").css("opacity", 1);
		$("#highlightinr").html("Drafted at ");
		$("#highlight-status").html(
			drafthours + ":" +
			draftminutes + ":" +
			draftseconds + " " +
			meridian
		);
	}
};
var cancel = function() {
	if(store.enabled) {
		store.remove("draft");
		store.remove("name");
	}
	history.back();
};
var publish = function() {
	if($("#area").val() == "") {
		error("Snippet is empty");
	} else if(!headermod) {
		error("Please set a name");
	} else {
		$.ajax("api/", {
			timeout: 5000,
			method: "POST",
			data: {
				"publish": $("#headerlarge").html(),
				"content": $("#area").val()
			}
		}).done(function(response) {
			pubObj = response;
			if(pubObj.status) {
				if(store.enabled) {
					store.remove("draft");
					store.remove("name");
				}
				window.location = $("#headerlarge").html();
			} else if(response != "") {
				error(pubObj.error);
			} else {
				error("Could not publish snippet");
			}
		}).fail(function() {
			error("Could not publish snippet");
		});
	}
};
var parse = function(obj) {
	if(obj.status) {
		document.title = obj.filename+" - Snippets";
		$("#publink").attr("href", "../snippets/?fork="+encodeURIComponent(obj.filename));
		writeHeader(obj.filename);
		writeSecondary("modified "+obj.modate);
		lines(obj.linecount);
		populate(obj.content, obj.lang);
		$("#areacontainer").css("display","initial");
		$("#container-curtain").css("opacity", 0);
		setTimeout(function() {
			$("#container-curtain").css("display", "none");
		}, 200);
		$("#download-button").css("display", "initial").on("click", function() {
			$("#download-iframe")[0].src = "download/"+obj.filename;
		});
	} else {
		document.title = obj.filename+"Error - Snippets";
		error(obj.error, false);
		$("#fork").html("CREATE THIS SNIPPET");
		$("#publink").attr("href", "../snippets/?create="+encodeURIComponent(filename));
		$("#styleselect").css("display", "none");
	}
};
if (window.attachEvent) {
	observe = function (element, event, handler) {
		element.attachEvent('on'+event, handler);
	};
}
else {
	observe = function (element, event, handler) {
		element.addEventListener(event, handler, false);
	};
}
var text = $("#area")[0];
var resize = function() {
	text.style.height = 'auto';
	text.style.height = text.scrollHeight - 78 +'px';
};
var delayedResize = function() {
	setTimeout(resize, 0);
};
$(document).ready(function() {
	observe(text, 'change', resize);
	observe(text, 'cut', delayedResize);
	observe(text, 'paste', delayedResize);
	observe(text, 'drop', delayedResize);
	observe(text, 'keydown', delayedResize);
	text.focus();
	text.select();
	resize();
	$("#area")[0].selectionStart = $("#area")[0].selectionEnd = 0;
});
var changeStyle = function(newstyle) {
	Cookies.set("style", newstyle, {expires: 365});
	$("link[rel='stylesheet']")[0].href = "styles/hljs-styles/"+newstyle+".css";
	changestyleinterval = setInterval(function() {
		$("body, html").css("background-color", $(".hljs").css("background-color"));
	}, 1);
	setTimeout(function() {
		clearInterval(changestyleinterval);
	}, 5000);
};
var getParameterByName = function(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
if(!newfile) {
	$.ajax("api/?info="+encodeURIComponent(filename)+"&offset="+new Date().getTimezoneOffset(), {timeout: 5000}).done(function(response) {
		parse(response);
	}).fail(function() {
		error("Could not load snippet");
	});
	setTimeout(function() {
		if(Cookies.get("style") != undefined) {
			changeStyle(Cookies.get("style"));
		}
	}, 1);
} else {
	if(getParameterByName("fork") != "") {
		$.ajax("api/?info="+getParameterByName("fork")+"&offset="+new Date().getTimezoneOffset(), {timeout: 5000}).done(function(response) {
			if(response.status) {
				$("#headerlarge").html(response.filename.replace(/(.+)(\..*)/, "$1"+".fork"+"$2"));
				$("#area").val(response.rawcontent);
				headermod = true;
				$("#headerlarge").css("font-style", "initial");
			} else {
				error(response.error);
			}
			setTimeout(resize, 10);
		}).fail(function() {
			error("Could not load snippet");
		});
	} else if(getParameterByName("create") != "") {
		setTimeout(function() {
			$("#headerlarge").html(getParameterByName("create")).css("font-style", "initial");
			headermod = true;
			$("#headermod").css("font-style", "initial");
		}, 1);
	}
	$("#styleselect").css("display", "none");
	$input = $("#area");
	$textarea = $("<textarea></textarea>").attr({
		id: $input.attr('id'),
		class: $input.attr('class'),
		spellcheck: $input.attr('spellcheck'),
		placeholder: "// Paste your snippet here",
		wrap: "off"
	});
	$input.after($textarea).remove();
	var headermod = false;
	document.title = "New Snippet - Snippets";
	writeHeader("New Snippet");
	writeSecondary("");
	if(store.enabled && store.get("draft") != undefined) {
		$("#area").val(store.get("draft"));
		if($("#headerlarge").html() != store.get("name") && store.get("name") != undefined && store.get("name") != "") {
			$("#headerlarge").html(store.get("name"));
			headermod = true;
		}
		linecount = $("#area").val().split(/\r*\n/).length;
		if(navigator.userAgent.indexOf("MSIE") != -1) {
			linecount--;
		}
		lines(linecount);
	}
	$("#area").on("keydown", function(e) {
		lineinterval = setInterval(function() {
			linecount = $("#area").val().split(/\r*\n/).length;
			if(navigator.userAgent.indexOf("MSIE") != -1) {
				linecount--;
			}
			lines(linecount);
		}, 100);
		if(e.keyCode === 9) {
			var start = this.selectionStart;
			var end = this.selectionEnd;
			var $this = $(this);
			$this.val($this.val().substring(0, start)
					  + "\t"
					  + $this.val().substring(end));
			this.selectionStart = this.selectionEnd = start + 1;
			return false;
		}
	}).on("keyup", function() {
		clearInterval(lineinterval);
		linecount = $("#area").val().split(/\r*\n/).length;
		if(navigator.userAgent.indexOf("MSIE") != -1) {
			linecount--;
		}
		lines(linecount);
	});
	setInterval(update, 500);
	if(!headermod) {
		$("#headerlarge").css("font-style", "italic");
	}
	$("#headerlarge").attr("contenteditable", "true").hover(function() {
		$(this).css("background-color", "rgba(201, 201, 201, 0.5)");
	}, function() {
		$(this).css("background-color", "initial");
	}).on("focus", function() {
		$(this).css("font-style", "initial");
	}).on("blur", function() {
		if($(this).html() == "New Snippet" && headermod == false) {
			$(this).css("font-style", "italic");
		} else {
			headermod = true;
		}
		if($(this).html().length <= 40 && $(this).html().length > 0) {
			clearError();
			$.ajax("api/?name_available="+encodeURIComponent($(this).html()), {timeout: 5000}).done(function(response) {
				if(!response.status) {
					error(response.error);
				}
			});
		} else {
			if($(this).html().length > 40) {
				error("Name is longer than 40 characters");
			} else {
				error("You must provide a name", false);
			}
		}
	}).on("keydown", function(e) {
		if(e.keyCode == 13) {
			return false;
		}
		update();
	});
	$("#fork").html("PUBLISH");
	$("#new").html("CANCEL");
	$("#newlink").attr("href", "javascript:cancel();");
	$("#publink").attr("href", "javascript:publish();");
	$("#areacontainer").css("display","initial");
	$("#container-curtain").css("opacity", 0);
	setTimeout(function() {
		$("#container-curtain").css("display", "none");
	}, 200);
	$("#area").focus();
}
$("#styleselect").on("input", function() {
	changeStyle($("#styleselect").val());
});
