<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/12/17
 * Time: 8:52 AM
 */


$db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'www', 'asd');


$stmt = $db->prepare("INSERT INTO CoinGame(playername, score, timeanddate, playerid ) VALUES(:f1, :f2, :f3, :f4)");
$date = new DateTime();
$stamp= date("Y-m-d H:i:s", $date->getTimestamp());

$stmt->execute(array(":f1" => $_POST["name"], ":f2" => $_POST["score"], ":f3" => $stamp, ":f2" => $_POST["playerid"]));

$rows = $stmt->fetchAll();
header("Location: game.php");
exit;
