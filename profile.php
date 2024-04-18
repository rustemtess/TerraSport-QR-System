<?

require 'common_handler.php';

$closetData = haveAndGetCloset();
if(!$closetData) header('Location: select.php');

if(isset($_POST['free_closet'])) freeCloset();
if(isset($_POST['open_closet'])) {
    $publicIP = file_get_contents("myip.txt");
	$address = $closetData['controller_address'];
	$port = intval($closetData['controller_port']);
	$hex = $closetData['closet_hex'];
	?>
		<script>
			var url = "http://<?=$publicIP?>:25565?address=<?=$address?>&port=<?=$port?>&hex=<?=$hex?>";

			// Создаем новый объект XMLHttpRequest
			var xhr = new XMLHttpRequest();

			// Устанавливаем метод и URL запроса
			xhr.open("GET", url, true);

			// Отправляем запрос
			xhr.send();
		</script>
	<?
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TerraSport</title>
    <link rel="stylesheet" href="./assets/css/main.css" />
</head>
<body>
    <div class="r-body">
        <header class="header" style="position: none;">
            <div>
                <h1 id="header-title">TERRASPORT<br/><p>FINTESS <span>CLUB</span></p></h1>
                <div id="online">
                    <div id="online-share"></div>
                    <p><?=getOnline()?> кл.</p>
                </div>
            </div>
        </header>
        <main class="main">
            <form class="form" method="POST" autocomplete="off">
                <p class="desc" style="font-size: 17px;"><span>*</span>Номер вашего шкафа №<?=$closetData['closet_number']?></p> 
                <button class="btn open" name="open_closet">Открыть</button>
                <button class="btn" name="free_closet">Освободить</button>
            </form>
        </main>
        <footer>
            <p id="protect">Все права защищены © 2023</p>
        </footer>
    </div>
</body>
</html>