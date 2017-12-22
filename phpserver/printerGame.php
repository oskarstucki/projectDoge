<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/3/17
 * Time: 8:12 AM
 * Fetches all the scores achieved in the game. That's why it is differed from print.php
 */

require_once("utils.php");
session_start();

$stmt = $db->prepare("SELECT * FROM Information WHERE  application =:app");

$stmt->execute(array(":app" => $_SESSION["app"]));

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo(json_encode($rows));



