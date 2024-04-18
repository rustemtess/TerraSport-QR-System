<?

require 'common_handler.php';

checkQR('q', $_GET['q'], 'scan');

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
            </div>
        </header>
        <main class="main">
            <div id="qr">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
                    <path fill="white" d="m4,11h7v-7h-7v7Zm2-5h3v3h-3v-3Zm14-2h-7v7h7v-7Zm-2,5h-3v-3h3v3Zm-14,11h7v-7h-7v7Zm2-5h3v3h-3v-3Zm-3,7h4v2H3c-1.654,0-3-1.346-3-3v-4h2v4c0,.551.449,1,1,1Zm19-5h2v4c0,1.654-1.346,3-3,3h-4v-2h4c.551,0,1-.449,1-1v-4Zm2-14v4h-2V3c0-.551-.449-1-1-1h-4V0h4c1.654,0,3,1.346,3,3ZM2,7H0V3C0,1.346,1.346,0,3,0h4v2H3c-.551,0-1,.449-1,1v4Zm11,10h3v3h-3v-3Zm4-1v-3h3v3h-3Zm-4-3h3v3h-3v-3Z"/>
                </svg>
                <h3 id="qr-text">Для доступа к сайту, пожалуйста, воспользуйтесь сканированием QR-кода</h3>
            </div>
        </main>
        <footer>
            <p id="protect">Все права защищены © 2023</p>
        </footer>
    </div>
</body>
</html>