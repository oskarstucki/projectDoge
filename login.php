<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/12/17
 * Time: 1:04 PM
 */
session_start();
require_once ("utils.php");
main();

$password = sha1($_POST["Password"] . SALT);

$stmt = $db->prepare("SELECT id, email, username, lastName, firstName FROM users WHERE username=:username 
                                AND password_hash=:password");
$stmt->execute(array(":username" => $_POST["Email"], ":password" => $password));

//$stmt->debugDumpParams();


$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($rows) === 1){
    $_SESSION["userId"] = $rows[0]["id"];
    $_SESSION["firstName"] = $rows[0]["firstName"];
    $_SESSION["lastName"]=$rows[0]["lastName"];
    $_SESSION["userName"]=$rows[0]["username"];
    $_SESSION["email"] = $rows[0]["email"];
    $_SESSION["logged"]= true;

    //var_dump($rows);
    //echo $_SESSION["userName"];
}

header("Location: index.php");
exit;