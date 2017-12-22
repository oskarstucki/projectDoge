<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/12/17
 * Time: 12:19 PM
 */
require_once('utils.php');
session_start();


$stmt = $db->prepare("SELECT username FROM users WHERE username=:username");
$stmt->execute(array(":username" => $_POST["Email"]));


$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($rows) === 1){
    echo "Käyttäjänimi on jo tehty!";
}else {
    if(isset($_POST["fb"])){

        $_SESSION["userName"] = $_POST["userName"];
        $_SESSION["firstName"] = $_POST["firstName"];
        $_SESSION["lastName"] = $_POST["lastName"];
        $_SESSION["email"] = $_POST["Email"];


        $password = sha1($_POST["password"] . SALT);


        $stmt = $db->prepare("INSERT INTO users(email, username, password_hash, firstName, lastName) 
          VALUES(:f1, :f2, :f3, :f4, :f5)");

        $stmt->execute(array(":f1" => $_POST["Email"], ":f2" => $_POST["userName"],":f3" => $password,
            ":f4" => $_POST["firstName"], ":f5" => $_POST["lastName"]));
    }
    else{
        if($_POST["password"] == $_POST["password2"]){
        if(strlen($_POST["password"])> 7){
            if (!preg_match('/[^A-Za-z0-9]/', $_POST["password"]))
            {
                if(preg_match('/[A-Z]/', $_POST["password"]) && preg_match('/[a-z]/', $_POST["password"]) &&
                    preg_match('/[1-9]/', $_POST["password"])){
                    $_SESSION["userName"] = $_POST["userName"];
                    $_SESSION["firstName"] = $_POST["firstName"];
                    $_SESSION["lastName"] = $_POST["lastName"];
                    $_SESSION["email"] = $_POST["Email"];


                    $password = sha1($_POST["password"] . SALT);


                    $stmt = $db->prepare("INSERT INTO users(email, username, password_hash, firstName, lastName) 
          VALUES(:f1, :f2, :f3, :f4, :f5)");

                    $stmt->execute(array(":f1" => $_POST["Email"], ":f2" => $_POST["userName"],":f3" => $password,
                        ":f4" => $_POST["firstName"], ":f5" => $_POST["lastName"]));

                    header("Location: ../index.php");
                    exit;
                }else {
                    echo "Ei isoja kirjaimia, kirjaimia tai numeroita!";
                }
            } else{
                echo "Sisältää muuta kuin kirjaimia ja numeroita";
            }


        }else{
            echo "Salasana liian lyhyt!";
        }


    } else{
        echo "Salasanat eivät täsmää!";
    }}

}






