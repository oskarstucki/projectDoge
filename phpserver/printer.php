<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/3/17
 * Time: 8:12 AM
 * Allows you to get user and functionality specific information from the table
 */

require_once("utils.php");
session_start();

$stmt = $db->prepare("SELECT * FROM Information WHERE userId =:userName AND application =:app");

$stmt->execute(array(":userName" => $_SESSION["userName"], ":app" => $_SESSION["app"]));

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo(json_encode($rows));



