<?
$host = 'localhost';
$login = 'p-331522_ts';
$password = 'TERRASPORT2023';
$dbName = 'p-331522_ts';

$db = mysqli_connect($host, $login, $password, $dbName);

if(!$db) {
    echo 'Error '.mysqli_error();
}

?>