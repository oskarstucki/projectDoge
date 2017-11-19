<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 10/22/17
 * Time: 12:21 PM
 */

require_once("utils.php");

if(isset($_GET["id"])) {
    $db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'www', 'asd');
    $id = $_GET['id'];
    $stmt = $db->prepare("DELETE FROM notes WHERE id = $id");
    $stmt->execute(array($id));
    header("Location: notes.php");
    exit;
}
else {
    header("Location: notes.php");
    exit;
}