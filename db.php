<?
$host = 'localhost';
$login = '';
$password = '';
$dbName = '';

$db = mysqli_connect($host, $login, $password, $dbName);

if(!$db) {
    echo 'Error '.mysqli_error();
}

?>