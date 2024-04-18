<?

if(isset($_GET['response'])) {
    $response = $_GET['response'];

    file_put_contents("response.txt", $response);
}

?>