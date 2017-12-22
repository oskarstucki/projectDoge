<?php

session_start();
require_once("phpserver/utils.php");
$_SESSION["app"] = "game";
game();




