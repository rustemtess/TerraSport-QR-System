<?

require '../db.php';

if(!isset($_GET['password'])) die('Not wrong password');

$password = $_GET['password'];
if($password == "terradmin") {
    if(isset($_GET['block'])) {
        $closet_id = intval($_GET['block']);
        $db->query("UPDATE closets 
        SET closet_block = CASE 
                             WHEN closet_block = 1 THEN 0 
                             WHEN closet_block = 0 THEN 1 
                           END 
        WHERE closet_id = $closet_id;");
    }
    if(isset($_GET['free'])) {
        $closet_id = intval($_GET['free']);
        $db->query("UPDATE closets SET client_number = null WHERE closet_id = $closet_id");
    }else {
        $closets = $db->query("SELECT 
            closets.closet_id, closets.closet_number, closets.closet_hex, closets.closet_gender,
            closets.client_number, closets.closet_block, closets.closet_iscode, controllers.controller_address,
            controllers.controller_port FROM closets, controllers WHERE closets.server_id = controllers.controller_id ORDER BY closet_number ASC");
        $closets = $closets->fetch_all(MYSQLI_ASSOC);
        echo json_encode($closets);
    }
} 
?>