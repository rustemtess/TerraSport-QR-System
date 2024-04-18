<?

require 'common_handler.php';

if(haveAndGetCloset()) header('Location: profile.php');
if(getClient()) header('Location: select.php');

if(isset($_POST['auth'])) {
    $number = $_POST['number'];
	$type = "faceid";
	if(file_get_contents("http://terrasport.choices.kz/faceid.txt") == "off") $type = "number";
    if(strlen($number) == 12) {
		if(auth($number, $type)) header('Location: select.php');
		else {
			echo '<p style="position: absolute; top: 9em; color: white; text-align: center; left: 0; width: 100%; border: 1px solid #c10020; border-width: 1px 0 1px 0; padding: 10px 0; font-family: Montserrat; font-size: 14px; ">Номер не совпадает с FaceID</p>';
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TerraSport</title>
    <link rel="stylesheet" href="./assets/css/main.css"  />
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
                <p class="desc"><span>*</span>Введите номер для входа</p>
                <input class="input" name="number" id="phoneNumber" type="text" value="+7" maxlength="12" autocomplete="false" onfocus="this.removeAttribute('readonly');"  /> 
                <button class="btn" name="auth">Войти</button>
            </form>
        </main>
        <footer>
            <p id="protect">Все права защищены © 2023</p>
        </footer>
    </div>
    <script>
        document.getElementById("phoneNumber").setSelectionRange(inputElement.value.length, inputElement.value.length);
        document.getElementById("phoneNumber").addEventListener('blur', (event) => {
            let currentValue = event.target.value;
            let digitsOnly = currentValue.replace(/\D/g, '');
            if (!digitsOnly.startsWith('7')) {
                digitsOnly = '7' + digitsOnly.slice(1);
            }
            digitsOnly = '+7' + digitsOnly.slice(2);
            event.target.value = digitsOnly;
        })
        document.getElementById("phoneNumber").addEventListener('keydown', (e) => {
            const number = e.target.value
            if (e.key === 'Backspace') {
                if(number === '+7') e.preventDefault();
            }else {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            }
        })
    </script>
</body>
</html>