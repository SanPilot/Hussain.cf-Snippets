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
		<link rel="stylesheet" href="styles/hljs-styles/default.css">
		<link rel="stylesheet" href="styles/index.css">
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
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
				<select id="styleselect">
					<option id="styledisabled" disabled selected>STYLE</option>
					<option value="default">Default</option>
					<option value="agate">Agate</option>
					<option value="androidstudio">Android Studio</option>
					<option value="arta">Arta</option>
					<option value="ascetic">Ascetic</option>
					<option value="atelier-cave.dark">Atelier-Cave.dark</option>
					<option value="atelier-cave.light">Atelier-Cave.light</option>
					<option value="atelier-dune.dark">Atelier-Dune.dark</option>
					<option value="atelier-dune.light">Atelier-Dune.light</option>
					<option value="atelier-estuary.dark">Atelier-Estuary.dark</option>
					<option value="atelier-estuary.light">Atelier-Estuary.light</option>
					<option value="atelier-forest.dark">Atelier-Forest.dark</option>
					<option value="atelier-forest.light">Atelier-Forest.light</option>
					<option value="atelier-heath.dark">Atelier-Heath.dark</option>
					<option value="atelier-heath.light">Atelier-Heath.light</option>
					<option value="atelier-lakeside.dark">Atelier-Lakeside.dark</option>
					<option value="atelier-lakeside.light">Atelier-Lakeside.light</option>
					<option value="atelier-plateau.dark">Atelier-Plateau.dark</option>
					<option value="atelier-plateau.light">Atelier-Plateau.light</option>
					<option value="atelier-savanna.dark">Atelier-Savanna.dark</option>
					<option value="atelier-savanna.light">Atelier-Savanna.light</option>
					<option value="atelier-seaside.dark">Atelier-Seaside.dark</option>
					<option value="atelier-seaside.light">Atelier-Seaside.light</option>
					<option value="atelier-sulphurpool.dark">Atelier-Sulphurpool.dark</option>
					<option value="atelier-sulphurpool.light">Atelier-Sulphurpool.light</option>
					<option value="brown_paper">Brown Paper</option>
					<option value="codepen-embed">Codepen Embed</option>
					<option value="color-brewer">Color Brewer</option>
					<option value="dark">Dark</option>
					<option value="darkula">Darkula</option>
					<option value="docco">Docco</option>
					<option value="far">Far</option>
					<option value="foundation">Foundation</option>
					<option value="github">GitHub</option>
					<option value="github-gist">GitHub Gist</option>
					<option value="googlecode">Google Code</option>
					<option value="hybrid">Hybrid</option>
					<option value="idea">Idea</option>
					<option value="ir_black">Ir Black</option>
					<option value="kimbie.dark">Kimbie.dark</option>
					<option value="kimbie.light">Kimbie.light</option>
					<option value="magula">Magula</option>
					<option value="mono-blue">Mono Blue</option>
					<option value="monokai">Monokai</option>
					<option value="monokai_sublime">Monokai Sublime</option>
					<option value="obsidian">Obsidian</option>
					<option value="paraiso.dark">Paraiso.dark</option>
					<option value="paraiso.light">Paraiso.light</option>
					<option value="pojoaque">Pojoaque</option>
					<option value="railscasts">Railscasts</option>
					<option value="rainbow">Rainbow</option>
					<option value="school_book">School Book</option>
					<option value="solarized_dark">Solarized Dark</option>
					<option value="solarized_light">Solarized Light</option>
					<option value="sunburst">Sunburst</option>
					<option value="tomorrow">Tomorrow</option>
					<option value="tomorrow-night-blue">Tomorrow Night Blue</option>
					<option value="tomorrow-night-bright">Tomorrow Night Bright</option>
					<option value="tomorrow-night">Tomorrow Night</option>
					<option value="tomorrow-night-eighties">Tomorrow Night Eighties</option>
					<option value="vs">Vs</option>
					<option value="xcode">Xcode</option>
					<option value="zenburn">Zenburn</option>
				</select>
				<a id="publink"><div class="headerbutton" id="fork">FORK THIS SNIPPET</div></a>
				<a href="../snippets/" id="newlink"><div class="headerbutton" id="new">NEW SNIPPET</div></a>
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
		<script type="text/javascript" src="scripts/highlight.pack.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.0.3/js.cookie.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/store.js/1.3.17/store+json2.min.js"></script>
		<script type="text/javascript" src="scripts/main.js"></script>
	</body>
</html>
