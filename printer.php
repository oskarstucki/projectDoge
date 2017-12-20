<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/3/17
 * Time: 8:12 AM
 */

require_once ("utils.php");
main();


$notesList = array();
$stmt = $db->prepare("SELECT id, text, timeanddate FROM Information WHERE userId =:userName 
                                AND application =:app");

$stmt->execute(array(":userName" => $_SESSION["userName"], ":app" => $_SESSION["app"]));

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


print(json_encode($rows));



