<?php
if(is_file("files/".$_GET['f']) && isset($_GET['f']) && $_GET['f'] != "") {
	$filename = htmlspecialchars($_GET['f']);
	$modate = date("F j, Y", filemtime("files/".$_GET['f'])) . " at " . date("g:i a", filemtime("files/".$_GET['f']));
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
		<link rel="stylesheet" href="highlightjs/styles/hybrid.css">
		<style type="text/css">
			body {
				margin: 0px;
				background-color: #1d1f21;
				padding: 10px;
			}
			#area {
				outline: none;
				visibility: hidden;
			}
			#header {
				display: flex;
				align-items: center;
				font-family: Permian Serif;
				margin-left: 8px;
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
			<?php include "../scripts/php/clippings/fonts/PermianSerif.php" ?>
		</style>
		<?php include "../scripts/php/clippings/header.php" ?>
	</head>
	<body>
		<div id="header">
			<span id="headerlarge"><?=$filename ?></span><span id="headersmall">&nbsp;&#x2013;&nbsp; <span id="ctext">loading...</span></span>
		</div>
		<div id="area" class="hljs" contenteditable="<?php if($new) {echo "true";} else {echo "false";} ?>">
			<?=$fcontent ?>
		</div>
		<script type="text/javascript" src="highlightjs/highlight.pack.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript">
			var area = document.getElementById("area");
			var newf = <? if($new) {echo "true";} else {echo "false";} ?>;
				window.onload = function() {
					hljs.configure({useBR: true});
					hljs.highlightBlock(area);
					if(newf) {
						document.getElementById("headersmall").innerHTML = "";
					} else {
						document.getElementById("ctext").innerHTML = "saved <?=$modate ?>";
					}
					area.style.visibility = "visible";
				};
			area.onkeyup = function() {
				hljs.highlightBlock(area);
			};
		</script>
	</body>
</html>
