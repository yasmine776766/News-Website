<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "newsdb";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

include("connection.php");

if (!empty($_POST["title"]) && !empty($_POST["text"])){
    $title = $_POST["title"];
    $text = $_POST["text"];
    $response = createNews($title, $text);
    echo json_encode($response);
}
else{
    echo json_encode(["status" => "Some information is missing!"]);
}

function createNews($title, $text){
    global $mysqli;
    global $response;
    $query = $mysqli->prepare("INSERT INTO articles (TITLE, TEXT) VALUES (?, ?)");
    $query->bind_param('ss', $title, $text);
    if ($query->execute()){
        $response["status"]= "Added";
    }
    else{
        $response["status"] = "Failed";
    }
    return $response;
}
?>
