<?

require 'common_handler.php';

$closetData = haveAndGetCloset();

if($closetData) header('Location: profile.php');

$closets = getClosets(1);
$gender = $closets[0]['closet_gender'];
if(count($closets) == 0) $gender = getClient()['client_gender'];
if($gender == 1) $gender = 'мужская';
if($gender == 2) $gender = 'женская';

if(isset($_POST['select'])) {
    $closet_id = intval($_POST['closet_id']);
    selectCloset($closet_id);
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
        <header class="header">
            <div>
                <h1 id="header-title">TERRASPORT<br/><p>FINTESS <span>CLUB</span></p></h1>
                <div id="online">
                    <div id="online-share"></div>
                    <p><?=getOnline()?> кл.</p>
                </div>
            </div>
        </header>
        <main class="main left">
            <h3 id="main-header">Раздевалка: <span><?=$gender?></span></h3>
            <div id="menu">
                <a href="select.php" class="menu-button"><svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24" width="22" height="22"><path fill="#A8CF45" d="M17.921,1.505a1.5,1.5,0,0,1-.44,1.06L9.809,10.237a2.5,2.5,0,0,0,0,3.536l7.662,7.662a1.5,1.5,0,0,1-2.121,2.121L7.688,15.9a5.506,5.506,0,0,1,0-7.779L15.36.444a1.5,1.5,0,0,1,2.561,1.061Z"/></svg>
                Вернуться назад</a>
            </div>
            
            <div id="buttons">
                <?
                if(count($closets) == 0) {
                    ?>
                    <p id="success-closets">На данный момент все шкафы функционируют без сбоев.</p>
                    <?
                }
                foreach($closets as $closet) {
                    ?>
                        <button class="err-closets"><?=$closet['closet_number']?></button>
                    <?
                }
                ?>
            </div>
        </main>
        <footer>
            <p id="protect">Все права защищены © 2023</p>
        </footer>
    </div>
</body>
</html>