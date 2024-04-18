<?php
if(isset($_GET['myip'])) {
	$publicIP = $_GET['myip'];
	$filePath = 'myip.txt';
	file_put_contents($filePath, $publicIP);
}
?>
