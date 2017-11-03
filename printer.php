<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/3/17
 * Time: 8:12 AM
 */


$notesList = array();
$db = new PDO('mysql:host=localhost;dbname=www;charset=utf8', 'www', 'asd');
$stmt = $db->prepare("SELECT id, note, timeanddate FROM notes");
$stmt->execute(array(":id"));

//$stmt->debugDumpParams();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($rows);
print(json_encode($rows));
/*echo '<ul id="list">';
foreach ($rows as $i){
    $a = $i["note"];
    $b = $i["id"];
    print("<li>$a<form action ='delete.php' method='get'><input type='hidden' value='$b' name='id'/>
            <input class='deletebutton' type='submit' value='Poista'/></form></li>");
    array_push($notesList, $i["note"]);
}
echo '</ul>';


