
<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/19/17
 * Time: 3:51 AM
 * php file to access the game
 */
session_start();
require_once("phpserver/utils.php");
$_SESSION["app"] = "game";
game();




