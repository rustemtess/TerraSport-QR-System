<?

require 'db.php';

$current_date = date("Y-m-d");
$page = basename($_SERVER['PHP_SELF']);
$accountTime = time() + 14400;

function checkQR($params, $getData, $type) {
  global $page, $accountTime;
  switch($type) {
    case 'scan':
      if($getData != '1' & $getData != '2') {
        if($page != "qr.php") header('Location: qr.php');  
      }else {
        setcookie($params, $getData, $accountTime);
        header('Location: /');
      }
      break;
    case 'check':
      if($_COOKIE[$params] != '1' & $_COOKIE[$params] != '2') {
        if($page != "qr.php") header('Location: qr.php');
      }
      break;
  }
}

function getCookie() {
    global $page;
    checkQR('q', null, 'check');
    if(isset($_COOKIE['client_id']) and isset($_COOKIE['cn'])) {
        return array(intval($_COOKIE['client_id']), intval($_COOKIE['cn']));
    } else {
        if($page != "index.php") return false;
    }
}

function clearCookie() {
    setcookie('client_id', '', time() - 3600);
    setcookie('cn', '', time() - 3600);
}

function toBack() {
    global $page;
    if($page != "index.php") header('Location: /');
}

function getClient() {
    global $db, $current_date, $page;
    $client_id = getCookie()[0] | 0;
    $client_number = getCookie()[1] | 0;
    $clientData = $db->query("SELECT clients.client_number, clients.client_gender
    FROM clients
    WHERE clients.client_id = $client_id AND clients.client_date = '$current_date'
      AND (
        SELECT COUNT(*)
        FROM clients
        WHERE clients.client_number = $client_number AND clients.client_date = '$current_date'
      ) > (
        SELECT COUNT(*)
        FROM exit_clients
        WHERE exit_clients.client_number = $client_number AND exit_clients.client_date = '$current_date'
      )
    ORDER BY clients.client_id DESC
    LIMIT 1;
    ");
    $clientData = $clientData->fetch_assoc();
    return ($clientData != null) ? $clientData : false;
}

function haveAndGetCloset() {
    global $db;
    $client = getClient();
    if(!$client) {
        clearCookie();
        return toBack();
    }
    $client_number = $client['client_number'];
    $isCloset = $db->query("SELECT closets.closet_id, 
        closets.closet_number, closets.closet_hex,
        controllers.controller_address, controllers.controller_port 
        FROM closets, controllers 
        WHERE closets.client_number = $client_number AND controllers.controller_id = closets.server_id");
    $isCloset = $isCloset->fetch_assoc();
    return ($isCloset != null) ? $isCloset : false;
}

function getOnline(){
    global $db, $current_date;
    $onlines = $db->query("SELECT 
    client_number, 
    COUNT(*) AS count_clients
  FROM 
    clients
  WHERE 
    client_date = '$current_date'
  GROUP BY 
    client_number
  HAVING 
    count_clients > (
      SELECT 
        COUNT(*) 
      FROM 
        exit_clients 
      WHERE 
        client_date = '$current_date' 
        AND exit_clients.client_number = clients.client_number
    );
  ");
    return mysqli_num_rows($onlines);
}

function auth($number = '0', $authType) {
    global $db, $current_date, $accountTime;
    $number = intval(str_replace('+7', '', $number));
    $currentGender = $_COOKIE['q'];
    if($authType != "faceid") file_get_contents("http://terrasport.choices.kz/p/terrasport/entrance.php?number=7$number&gender=$currentGender");
    $isUser = $db->query("SELECT clients.client_id, clients.client_number
    FROM clients
    WHERE clients.client_number = $number
      AND clients.client_date = '$current_date'
      AND (
        SELECT COUNT(*)
        FROM clients
        WHERE clients.client_number = $number
          AND clients.client_date = '$current_date'
      ) > (
        SELECT COUNT(*)
        FROM exit_clients
        WHERE exit_clients.client_number = $number
          AND exit_clients.client_date = '$current_date'
      )
    ORDER BY clients.client_id DESC;
    ");
    $isUser = $isUser->fetch_assoc();
    if($isUser != null) {
        setcookie('client_id', $isUser['client_id'], $accountTime);
        setcookie('cn', $isUser['client_number'], $accountTime);
    }
    return ($isUser != null) ? true : false;
}

function getClosets($blockType = 0) {
    global $db;
    $client = getClient();
    if(!$client) {
        clearCookie();
        return toBack();
    }
    $client_gender = $client['client_gender'];
    $closets = $db->query("SELECT closet_id, closet_number, closet_gender 
        FROM closets 
        WHERE closet_gender = $client_gender
        AND closet_block = $blockType
        AND client_number IS NULL
        ORDER BY closet_number ASC");
    return $closets->fetch_all(MYSQLI_ASSOC);
}

function selectCloset(int $closet_id = 0) {
    global $db;
    $client = getClient();
    if(!$client) {
        clearCookie();
        return toBack();
    }
    $client_number = $client['client_number'];
    $db->query("UPDATE closets 
    SET client_number = $client_number 
    WHERE closet_id = $closet_id 
      AND NOT EXISTS (
        SELECT 1 
        FROM (SELECT client_number FROM closets) AS subquery 
        WHERE subquery.client_number = $client_number
      );
    ");
    header('Location: profile.php');
}

function freeCloset(){
    global $db;
    $client = getClient();
    if(!$client) {
        clearCookie();
        return toBack();
    }
    $client_number = $client['client_number'];
    $db->query("UPDATE closets SET client_number = NULL WHERE client_number = $client_number");
    header('Location: select.php');
} 

?>