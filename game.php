<?php

session_start();
require_once("utils.php");
$_SESSION["app"] = "game";
game();




