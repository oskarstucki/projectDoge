<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/12/17
 * Time: 8:52 AM
 */

require_once("utils.php");
session_start();

$stmt = $db->prepare("INSERT INTO Information(text, userId, timeanddate, application ) VALUES(:f1, :f2, :f3, :f4)");
$date = new DateTime();
$stamp= date("Y-m-d H:i:s", $date->getTimestamp());

$stmt->execute(array(":f1" => $_POST["score"], ":f2" =>$_POST["name"] , ":f3" => $stamp, ":f4" => $_SESSION["app"]));

$rows = $stmt->fetchAll();
header("Location: game.php");
exit;
