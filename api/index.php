<?php
if(isset($_GET['info']) && $_GET["info"] != "") {
	$file = "../files/".$_GET["info"];
	$filename = htmlspecialchars($_GET["info"]);
	$lang = preg_match("/.*\.(\w+)$/", $filename, $res);
	if($res[1] != null) {
		$lang = $res[1];
	} else {
		$lang = false;
	}
	$return = array(
		"status" => false,
		"error" => "",
		"filename" => "",
		"modate" => "",
		"lang" => "",
		"linecount" => 0,
		"content" => ""
	);
	if(is_file($file)) {
		$return['filename'] = $filename;
		$return['modate'] = date("F j, Y", filemtime($file)) . " at " . date("g:i a", filemtime($file));
		$return['lang'] = $lang;
		$return['linecount'] = count(file($file)) + 1;
		if(filesize($file) <= 1048576) {
			if(filesize($file) > 0 && file_get_contents($file) == "") {
				$return['error'] = "There was an error reading the Snippet $filename";
			} else {
				$return = array(
					"status" => true,
					"error" => "",
					"filename" => $filename,
					"modate" => date("F j, Y", filemtime($file)) . " at " . date("g:i a", filemtime($file)),
					"lang" => $lang,
					"linecount" => count(file($file)) + 1,
					"content" => nl2br(htmlspecialchars(file_get_contents($file)), false)
				);
			}
		} else {
			$return['error'] = "Snippet $filename is larger than 1MB";
		}
	} else {
		$return['error'] = "Snippet $filename does not exist";
	}
	echo json_encode($return);
	exit();
}
?>
