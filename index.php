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
		<link rel="stylesheet" href="styles/hljs-styles/obsidian.css">
		<link rel="stylesheet" href="styles/index.css">
		<style type="text/css">
			<?php include "../scripts/php/clippings/fonts/PermianSerif.php" ?>
		</style>
		<?php include "../scripts/php/clippings/header.php" ?>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<span id="headerlarge" spellcheck="false"></span><span id="headersmall"><span id="ctext">Loading...</span></span>
				<span class="headerlight highlight"><span id="highlightinr">Highlighting As: </span><span id="highlight-status">unknown</span></span>
				<svg height="19px" version="1.1" viewBox="0 0 14 19" width="14px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="download-button">
					<g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1">
						<title>
							Download this snippet
						</title>
						<g id="Core" transform="translate(-383.000000, -213.000000)">
							<g id="file-download" transform="translate(383.000000, 213.500000)">
								<path d="M14,6 L10,6 L10,0 L4,0 L4,6 L0,6 L7,13 L14,6 L14,6 Z M0,15 L0,17 L14,17 L14,15 L0,15 L0,15 Z" id="Shape"/>
							</g>
						</g>
					</g>
				</svg>
				<iframe id="download-iframe"></iframe>
				<a id="publink"><div class="headerbutton" id="fork">FORK THIS SNIPPET</div></a>
				<a href="../" id="newlink"><div class="headerbutton" id="new">NEW SNIPPET</div></a>
			</div>
			<div id="container-curtain"></div>
			<div id="areacontainer">
				<div id="line-numbers-container">
					<div id="line-numbers">1<br></div>
					<div id="line-back"></div>
				</div>
				<div id="twrap">
					<pre id="area" class="hljs" spellcheck="false"></pre>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			var filename = <?=$filename ?>;
			var newfile = <?=$new ?>;
		</script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="scripts/highlight.pack.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/store.js/1.3.17/store+json2.min.js"></script>
		<script type="text/javascript" src="scripts/main.js">
		</script>
	</body>
</html>
