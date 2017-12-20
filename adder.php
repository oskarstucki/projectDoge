<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 10/22/17
 * Time: 4:41 AM
 */

    require_once ("utils.php");
    main();

    $stmt = $db->prepare("INSERT INTO Information(text, userId,timeanddate, application) VALUES(:f1, :f2, :f3, :f4)");
    $date = new DateTime();
    $stamp= date("Y-m-d H:i:s", $date->getTimestamp());

    $stmt->execute(array(":f1" => $_POST["note"], ":f2"=>$_SESSION["userName"],":f3" => $stamp, ":f4" => $_SESSION["app"]));

    $rows = $stmt->fetchAll();
    header("Location: notes.php");
    exit;

