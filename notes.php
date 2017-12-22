<?php

require_once("phpserver/utils.php");

main();
navigation();
$_SESSION["app"] = "notes";

?>
<link rel="stylesheet" href="css/noteStyle.css">
<div class="notes">
    <h2>uusi asia</h2>
    <!--<form action="adder.php" method="post" id="adder">

    </form>-->
    <div id="noteInput">
        <input class="newThings" title="newThing" type="text" name="note">
        <button id="formBut">send</button>
    </div>
    <ul id="list"></ul>
</div>

<?php


