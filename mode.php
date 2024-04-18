<?

if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	if($mode == "on") {
		file_put_contents("faceid.txt", "on");
	}else {
		file_put_contents("faceid.txt", "off");
	}
}

?>