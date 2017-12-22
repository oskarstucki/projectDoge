<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 10/22/17
 * Time: 4:41 AM
 *
 * With this you are able to add user specific information to the table
 * no the matter functionality on the site
 */

    require_once("utils.php");
    session_start();

    if(isset($_POST["name"])){
        $user = $_POST["name"];


    }else{
        $user = $_SESSION["userName"];
    }


    $stmt = $db->prepare("INSERT INTO Information(text, userId,timeanddate, application) VALUES(:f1, :f2, :f3, :f4)");
    $date = new DateTime();
    $stamp= date("Y-m-d H:i:s", $date->getTimestamp());

    $stmt->execute(array(":f1" => $_POST["info"], ":f2"=>$user,":f3" => $stamp, ":f4" => $_SESSION["app"]));

    $rows = $stmt->fetchAll();
    exit;

