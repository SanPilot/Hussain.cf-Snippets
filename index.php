<?php
if(isset($_GET['f']) && $_GET['f'] != "") {
	$filename = json_encode($_GET['f']);
	$new = "false";
} else {
	$filename = "\"\"";
	$new = "true";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Loading - Snippets
		</title>
		<link rel="stylesheet" href="highlightjs/styles/obsidian.css">
		<style type="text/css">
			body, html {
				margin: 0px;
				padding: 0px;
				background-color: #282b2e;
			}
			#area {
				outline: none;
			}
			#header {
				display: flex;
				align-items: center;
				font-family: Permian Serif, Serif;
				padding: 18px 0 18px 18px;
				background-color: #1d1f21;
				position: fixed;
				width: 100%;
				z-index: 999;
				height: 28px;
			}
			#headerlarge {
				font-size: 25px;
				color: #ebebeb;
				display: inline-block;
			}
			#headersmall {
				font-size: 20px;
				color: #aaaaaa;
			}
			#areacontainer > pre {
				margin: 0px;
				padding-left: 18px;
				padding-top: 79px;
				padding-bottom: 10px;
				font-size: 13px;
			}
			#line-numbers {
				float: left;
				background-color: #3e4348;
				color: #ffffff;
				padding: 79px 0px 10px 0;
				width: 40px;
				font-size: 13px;
				text-align: center;
				font-family: monospace;
				z-index: 20;
				position: relative;
			}
			#line-back {
				float: left;
				height: 100%;
				background-color: #3e4348;
				width: 40px;
				position: absolute;
				z-index: 10;
			}
			#ctext {
				transition: color 0.2s linear;
			}
			#areacontainer {
				display: none;
				overflow: auto;
			}
			#container-curtain {
				position: absolute;
				z-index: 100;
				height: 100%;
				width: 100%;
				background-color: #282b2e;
				transition: opacity 0.2s;
			}
			.headerlight {
				display: block;
				color: #898989;
			}
			.highlight {
				margin-left: auto;
				margin-right: 18px;
				opacity: 0;
				transition: 0.2s opacity;
			}
			<?php include "../scripts/php/clippings/fonts/PermianSerif.php" ?>
		</style>
		<?php include "../scripts/php/clippings/header.php" ?>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<span id="headerlarge"></span><span id="headersmall"><span id="ctext">Loading...</span></span>
				<span class="headerlight highlight">Highlighting As: <span id="highlight-status">unknown</span></span>
			</div>
			<div id="container-curtain"></div>
			<div id="areacontainer">
				<div id="line-numbers"></div>
				<div id="line-back"></div>
				<pre id="area" class="hljs" contenteditable="false"></pre>
			</div>
		</div>
		<script type="text/javascript" src="highlightjs/highlight.pack.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript">
			hljs.configure({useBR: true});
			var filename = <?=$filename ?>;
			var newfile = <?=$new ?>;
			var writeHeader = function(msg) {
				if(!newfile) {
					$("#headerlarge").text(msg).html();
				}
			}
			var writeSecondary = function(msg) {
				if(!newfile) {
					$("#ctext").text(msg).html();
					$("#ctext").html("&nbsp–&nbsp"+$("#ctext").html());
				} else {
					$("#ctext").text(msg).html();
				}
			}
			var error = function(msg) {
				writeHeader(filename);
				$("#ctext").css("color","#d13131").text(msg).html();
			}
			var lines = function(numlines) {
				var i = 1;
				while(i <= numlines) {
					document.getElementById("line-numbers").innerHTML += i+"<br>\n";
					i++;
				}
			}
			var populate = function(str, lang) {
				$("#area").html(str);
				if(hljs.getLanguage(lang) != undefined) {
					$(".hljs").attr("class", $(".hljs").attr("class")+" "+lang);
					$("#highlight-status").html(lang);
					$(".highlight").css("opacity", 1);
				} else {
					$("#highlight-status").html("unknown");
					$(".highlight").css("opacity", 1);
				}
				hljs.highlightBlock($("#area")[0]);
			}
			var update = function() {
				hljs.highlightBlock($("#area")[0]);
			}
			var parse = function(obj) {
				if(obj.status) {
					writeHeader(obj.filename);
					writeSecondary("saved "+obj.modate);
					lines(obj.linecount);
					populate(obj.content, obj.lang);
					$("#areacontainer").css("display","initial");
					$("#container-curtain").css("opacity", 0);
					setTimeout(function() {
						$("#container-curtain").css("display", "none");
					}, 200);
				} else {
					error(obj.error);
					return;
				}
			}
			if(!newfile) {
				$.ajax("api/?info="+encodeURIComponent(filename), {timeout: 10000}).done(function(response) {
					parse(JSON.parse(response));
				}).fail(function() {
					error("Could not load snippet");
				});
			}
		</script>
	</body>
</html>
