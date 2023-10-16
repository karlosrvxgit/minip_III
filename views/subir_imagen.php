<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    var_dump($_FILES);
    $name= $_FILES["imagen"]["name"];
    $tmp_name = $_FILES["imagen"]["tmp_name"];
    $type = $_FILES["imagen"]["type"];

    // $route_db = str_replace("\\", "/", $route);
   $route_db = "/public/perfil/$name";//es mas facil leer etiketas img
   $route = $_SERVER["DOCUMENT_ROOT"] . $route_db;//ruta absoluta
   


    if (move_uploaded_file($tmp_name, $route)) {
        require_once($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");

        $mysqli->query("INSERT INTO users(img_url) VALUES ('$route_db')");

        header("Location: /imagenes.php");
    };

    
}