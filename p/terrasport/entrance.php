<?

require 'db.php';

$requests = ['number', 'gender'];

foreach($requests as $req){
	if(!isset($_GET[$req]) or empty(trim($_GET[$req]))) {
		http_response_code(400);
		die('Неправильный запрос');
	}
}

// Время
$date = date('Y-m-d');
$time = date('H:i:s');

// Данные пользователя
$number = intval($_GET['number']);
$gender = intval($_GET['gender']);

if(strlen($number) == 11) $number = intval(substr($number, 1));
if(strlen($number) == 12) $number = intval(substr($number, 2));

$db->query("INSERT INTO `clients`(`client_number`, `client_gender`, `client_date`, `client_time`) VALUES ($number, $gender,'$date','$time')");

?>