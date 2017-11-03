<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 10/22/17
 * Time: 4:41 AM
 */


    $db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'www', 'asd');


    $stmt = $db->prepare("INSERT INTO notes(note, timeanddate) VALUES(:f1, :f2)");
    $date = new DateTime();
    $stamp= date("Y-m-d H:i:s", $date->getTimestamp());

    $stmt->execute(array(":f1" => $_POST["note"], ":f2" => $stamp));

    $rows = $stmt->fetchAll();
    header("Location: index.php");
    exit;

