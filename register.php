<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/12/17
 * Time: 12:19 PM
 */



        $db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'www', 'asd');

        $password = sha1($_POST["password"] . "slkfjewlköjrökwqrpoqroipjafalkfjölk");


        $stmt = $db->prepare("INSERT INTO users(username, password_hash) VALUES(:f1, :f2)");

        $stmt->execute(array(":f1" => $_POST["username"], ":f2" => $password));


        $rows = $stmt->fetchAll();
