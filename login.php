<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/12/17
 * Time: 1:04 PM
 */

$db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'www', 'asd');

$password = sha1($_POST["password"] . "slkfjewlköjrökwqrpoqroipjafalkfjölk");

$stmt = $db->prepare("SELECT id, username FROM users WHERE username=:username AND password_hash=:password");
$stmt->execute(array(":username" => $_POST["username"], ":password" => $password));

//$stmt->debugDumpParams();


$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($rows) === 1){
    $_SESSION["userId"] = $rows[0]["id"];
    $_SESSION["realname"] = $rows[0]["realname"];

    echo $_SESSION["userId"];
}
