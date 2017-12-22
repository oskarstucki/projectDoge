<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 10/22/17
 * Time: 12:21 PM
 */
session_start();
require_once("utils.php");


    $stmt = $db->prepare("DELETE FROM Information WHERE id = ".$_POST["id"]);
    $stmt->execute();

    exit;
