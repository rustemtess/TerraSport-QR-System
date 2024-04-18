<?

require 'common_handler.php';

$closetData = haveAndGetCloset();

if($closetData) header('Location: profile.php');

$closets = getClosets();
$gender = $closets[0]['closet_gender'];
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
                <a href="err_closets.php" class="menu-button"><svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="22" height="22"><path fill="#EB4C42" d="M11,13V7c0-.55,.45-1,1-1s1,.45,1,1v6c0,.55-.45,1-1,1s-1-.45-1-1Zm1,2c-.83,0-1.5,.67-1.5,1.5s.67,1.5,1.5,1.5,1.5-.67,1.5-1.5-.67-1.5-1.5-1.5Zm11.58,4.88c-.7,1.35-2.17,2.12-4.01,2.12H4.44c-1.85,0-3.31-.77-4.01-2.12-.71-1.36-.51-3.1,.5-4.56L8.97,2.6c.71-1.02,1.83-1.6,3.03-1.6s2.32,.58,3,1.57l8.08,12.77c1.01,1.46,1.2,3.19,.49,4.54Zm-2.15-3.42s-.02-.02-.02-.04L13.34,3.67c-.29-.41-.79-.67-1.34-.67s-1.05,.26-1.36,.71L2.59,16.42c-.62,.88-.76,1.84-.4,2.53,.35,.68,1.15,1.05,2.24,1.05h15.12c1.09,0,1.89-.37,2.24-1.05,.36-.69,.22-1.65-.37-2.49Z"/></svg>
                Посмотреть неисправные шкафы</a>
            </div>
            
            <div id="buttons">
                <?
                foreach($closets as $closet) {
                    ?>
                        <form class="buttons-select" method="POST">
                            <button name="select"><?=$closet['closet_number']?></button>
                            <input hidden name="closet_id" value="<?=$closet['closet_id']?>" />
                        </form>
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