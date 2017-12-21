<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/26/17
 * Time: 9:12 PM
 */
session_start();
session_unset();
session_destroy();


header("Location: index.php");
exit;