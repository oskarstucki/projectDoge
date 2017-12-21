<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/12/17
 * Time: 9:06 AM
 */


$notesList = array();
$db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'www', 'asd');
$stmt = $db->prepare("SELECT id, playername,score, timeanddate FROM CoinGame");
$stmt->execute(array(":id"));

//$stmt->debugDumpParams();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($rows);
print(json_encode($rows));