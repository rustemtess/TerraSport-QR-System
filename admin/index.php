<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<script>
    var correctPassword = "terradmin";
    var cookieName = "p";
    var expirationHours = 1;

    function setCookie(cname, cvalue, exhours) {
        var d = new Date();
        d.setTime(d.getTime() + (exhours * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookies = decodedCookie.split(';');
        
        for(var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();
            if (cookie.indexOf(name) == 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }
        
        return "";
    }

    var storedPassword = getCookie(cookieName);

    if (storedPassword !== correctPassword) {
        var enteredPassword = prompt("Введите пароль:");
        
        if (enteredPassword === correctPassword) {
            setCookie(cookieName, correctPassword, expirationHours);
        } else {
            alert("Неверный пароль. Доступ запрещен.");
            // Дополнительные действия при неверном пароле, например, перенаправление на другую страницу.
        }
    }




</script>

<?

require '../db.php';

function getClosets($number) {
    global $db;
	$number = intval($number);
    $closets = $db->query("SELECT * FROM closets WHERE client_number = $number");
    return $closets->fetch_assoc();
}

function getClients(){
	global $db;
	$users = $db->query("SELECT * FROM clients ORDER BY client_id DESC LIMIT 50");
	$users = $users->fetch_all(MYSQLI_ASSOC);
	return $users;
}

if(isset($_POST['closet_block'])) {
    $closet_id = intval($_POST['closet_id']);
    $db->query("UPDATE closets 
    SET closet_block = CASE 
                         WHEN closet_block = 1 THEN 0 
                         WHEN closet_block = 0 THEN 1 
                       END 
    WHERE closet_id = $closet_id;
    ");
}

//$closets = getClosets();
$clients = getClients();

?>

<style>
    * {
        margin: 0;
        padding: 0;
    }
    .closets {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 1em;
        justify-content: center;
        margin: 1em 0;
    }
    button {
        width: 60px;
        height: 60px;
        background-color: green;
        color: white;
        font-size: 20px;
    }
    h3 {
        font-family: 'Arial';
        margin: 1em;
    }
	td, th {
		padding: 10px;
	}
</style>
<!--<h3>Блокировка шкафов для пользователей предполагает, что клиенты не будут видеть шкафы (В СЛУЧАЕ НЕИСПРАВНОСТИ). Красная кнопка с номером шкафа означает, что он недоступен для использования, а зелёные — доступны. Чтобы заблокировать или разблокировать, просто нажмите на соответствующий номер шкафа.</h3>-->
<div class="closets">
	<table border="1">
		<tr>
			<th>Номер клиента</th>
			<th>Пол</th>
			<th>Номер шкафа</th>
			<th>Время входа</th>
		</tr>
    <?
	$i = 0;
	foreach($clients as $user) {
		$i++;
		$closet = getClosets($user['client_number']);
		
		if($closet == null){
			if(intval($user['client_gender']) == 1) {
				?>
				<tr>
					<td><?=$user['client_number']?></td>
					<td>Мужчина</td>
					<td>Без шкафа</td>
					<td><?=$user['client_time'].", ".$user['client_date']?></td>
				</tr>
				<?
			}else {
				?>
				<tr>
					<td><?=$user['client_number']?></td>
					<td>Женщина</td>
					<td>Без шкафа</td>
					<td><?=$user['client_time'].", ".$user['client_date']?></td>
				</tr>
				<?
			}
		}else {
			if(intval($user['client_gender']) == 1) {
				?>
				<tr>
					<td><?=$user['client_number']?></td>
					<td>Мужчина</td>
					<td>№<?=$closet['closet_number']?></td>
					<td><?=$user['client_time'].", ".$user['client_date']?></td>
				</tr>
				<?
			}else {
				?>
				<tr>
					<td><?=$user['client_number']?></td>
					<td>Женщина</td>
					<td>№<?=$closet['closet_number']?></td>
					<td><?=$user['client_time'].", ".$user['client_date']?></td>
				</tr>
				<?
			}
		}		
	}
	
    /*foreach($closets as $closet) {
        ?>
        <form method="POST">
            <?
            if($closet['closet_block'] == 1){ 
                ?>
                <button style="background-color: red;" name="closet_block"><?=$closet['closet_number']?></button>
                <?
            }else {
                ?>
                <button name="closet_block"><?=$closet['closet_number']?></button>
                <?
            }
            ?>
            <input hidden name="closet_id" value="<?=$closet['closet_id']?>" />
        </form>
        <?
    }*/
    ?>
	</table>
</div>