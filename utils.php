<?php
/**
 * Created by PhpStorm.
 * User: osaka
 * Date: 22.10.2017
 * Time: 1.54
 */

function site(){
    ?>
    <!DOCTYPE html>
    <html lang="fi">
    <head>
        <meta charset="UTF-8">
        <title>Muistilista</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
    <script
        src="https://code.jquery.com/jquery-3.2.1.js"
        integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
    <script src="script.js"></script>
    <h1>Muistilista</h1>
    <div class="form">
        <h2>uusi asia</h2>
        <!--<form action="adder.php" method="post" id="adder">

        </form>-->
        <div id="form">
            <input class="newThings" title="newThing" type="text" name="note">
            <button id="formBut">send</button>
        </div>
        <ul id="list"></ul>
    </div>

    </body>
    </html>
    <?php
}
