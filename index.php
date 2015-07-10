<?php
if(is_file("files/".$_GET['f']) && isset($_GET['f']) && $_GET['f'] != "") {
	$filename = htmlspecialchars($_GET['f']);
	$modate = date("F j, Y", filemtime("files/".$_GET['f'])) . " at " . date("g:i a", filemtime("files/".$_GET['f']));
	$lang = preg_match("/.*\.(\w+)$/", $_GET['f'], $res);
	$lang = $res[1];
	$file = "files/".$_GET['f'];
	$linecount = 0;
	$handle = fopen($file, "r");
	while(!feof($handle)){
		$line = fgets($handle);
		$linecount++;
	}
	fclose($handle);
} elseif (isset($_GET['f']) && $_GET['f'] != "") {
	header("status: 404 Not Found");
	include "../error/index.php";
	exit();
} else {
	$filename = "<i>New Snippet</i>";
	$new = true;
}
if($new) {
	$fcontent = "// Paste you code here";
} else {
	$fcontent = nl2br(file_get_contents("files/".$_GET['f']), false);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
if(!$new) {
	echo $filename." &#8212; Snippet";
} else {
	echo "New Snippet";
}
			?>
		</title>
		<link rel="stylesheet" href="highlightjs/styles/obsidian.css">
		<style type="text/css">
			body, html {
				margin: 0px;
				padding: 0px;
				height: 100%;
				background-color: #282b2e;
			}
			#wrapper {
				height: 100%;
			}
			#area {
				outline: none;
				visibility: hidden;
			}

			#header {
				display: flex;
				align-items: center;
				font-family: Permian Serif;
				padding: 18px 0 18px 18px;
				background-color: #1d1f21;
				position: fixed;
				width: 100%;
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
				height: 100%;
				padding-top: 79px;
				padding-bottom: 10px;
				font-size: 13px;
			}
			#line-numbers {
				height: 100%;
				float: left;
				background-color: #3e4348;
				color: #ffffff;
				padding: 79px 18px 10px 18px;
				font-size: 13px;
				text-align: center;
				font-family: monospace;
			}
			<?php include "../scripts/php/clippings/fonts/PermianSerif.php" ?>
		</style>
		<?php include "../scripts/php/clippings/header.php" ?>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<span id="headerlarge"><?=$filename ?></span><span id="headersmall">&nbsp;&#x2013;&nbsp; <span id="ctext">loading...</span></span>
			</div>
			<div id="areacontainer">
				<div id="line-numbers"></div>
				<pre id="area" class="hljs js" contenteditable="<?php if($new) {echo "true";} else {echo "false";} ?>"><?=$fcontent ?></pre>
			</div>
		</div>
		<script type="text/javascript" src="highlightjs/highlight.pack.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript">
			var area = document.getElementById("area");
			var newf = <?php if($new) {echo "true";} else {echo "false";} ?>;
			if(!newf) {
				var lines = <?=$linecount; ?>;
				}
			var i = 1;
			window.onload = function() {
				hljs.configure({useBR: true});
				hljs.highlightBlock(area);
				if(newf) {
					document.getElementById("headersmall").innerHTML = "";
				} else {
					document.getElementById("ctext").innerHTML = "saved <?=$modate ?>";
					while(i <= lines) {
						document.getElementById("line-numbers").innerHTML += i+"<br>\n";
						i++;
					}
				}
				area.style.visibility = "visible";
			};
			area.onkeyup = function() {
				hljs.highlightBlock(area);
			};
		</script>
	</body>
</html>
