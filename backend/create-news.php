<?php

include("connection.php");



if (!empty($_POST["title"] and !empty($_POST["text"]))){
    $title = $_POST["title"];
    $text = $_POST["text"];
    $response = createNews($title, $text);
    echo json_encode($response);
}
else{
    echo json_encode(
        ["status" => "Some information is missing!",]);
}

function createNews($title, $text){
    global $mysqli;
    global $response;
    $query = $mysqli -> prepare("INSERT INTO articles (TITLE, TEXT) VALUE (?, ?)");
    $query -> bind_param('ss', $title, $text);
    if ($query -> execute()){$response ["status"]= "Added";}
    else{$response["status"] = "Failed";}
    return $response; 

}