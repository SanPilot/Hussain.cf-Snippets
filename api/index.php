<?php
header("Content-type: text/json");
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
				$return['error'] = "There was an error reading the Snippet";
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
			$return['error'] = "Snippet is larger than 1MB";
		}
	} else {
		$return['error'] = "Snippet does not exist";
	}
	echo json_encode($return);
	exit();
}
if(isset($_POST['publish'], $_POST['content']) && $_POST['publish'] != "" && $_POST['content'] != "") {
	$filename = $_POST['publish'];
	$return = array(
		"status" => false,
		"error" => "There was an error publishing the snippet"
	);
	if(length($filename) <= 40) {
		if(length($filename) > 0) {
			if(is_dir("../".$filename) || is_file("../".$filename) || is_file("../files/".$filename)) {
				$return['error'] = "Name is already taken";
			} else {
				$save = file_put_contents("../files/".$filename, $_POST['content']);
				if($save) {
					$return = array(
						"status" => true,
						"error" => ""
					);
				}
			}
		} else {
			$return['error'] = "You must provide a name";
		}
	} else {
		$return['error'] = "Name is longer than 40 characters";
	}
	echo json_encode($return);
	exit();
}
if(isset($_GET['name_available']) && $_GET['name_available'] != "") {
	$filename = $_GET['name_available'];
	if(!preg_match("[^/?*:;{}\\]+", $_GET['name_available'])) {
		$return = array(
			"status" => true,
			"error" => ""
		);
		if(is_dir("../$filename") || is_file("../$filename") || is_file("../files/$filename")) {
			$return = array(
				"status" => false,
				"error" => "Name is already taken"
			);
		}
	} else {
		$return = array(
			"status" => false,
			"error" => "Name $filename is invalid"
		);
	}
	echo json_encode($return);
	exit();
}
if(isset($_GET['download']) && $_GET['download'] != "") {
	$filename = $_GET['download'];
	if(is_file("../files/".$filename)) {
		header("Content-type: application/octet-stream");
		echo file_get_contents("../files/".$filename);
	}
}
?>
