<?php
/**
 * Created by PhpStorm.
 * User: osaka
 * Date: 22.10.2017
 * Time: 1.54
 *
 * File for hmtl parts which are used often. There are functions:
 * main() , weatherWidget() , navigation(), login(), front (), game ()
 */

/**
 * Here we have defined some important variables which are used in many files.
 * Like database information.
 */
define("SALT", "slkfjewlköjrökwqrpoqroipjafalkfjölk");
$host = 'localhost';
$user = 'opstii';
$pass = '';
$db = 'www';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
$db = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$user,$pass);

/**
 * This function is used mainly for loading all scripts and only one header.
 */
function main(){
    session_start();

    ?>
    <!DOCTYPE html>
    <html lang="fi">
    <head>
        <meta charset="UTF-8">
        <title>Oskun nettisivu</title>
        <link rel="stylesheet" href="css/styleMainPage.css">
        <script type="text/javascript" src="scripts/phaser.js"></script>

        <link rel="stylesheet" href="css/weatherStyle.css">
<!--        <link rel="stylesheet" href="stylesheet.css">-->
    </head>
    <body>
    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
    <script src="scripts/script.js"> "use strict" ;</script>

    <h1><a href="index.php"><?php if(isset($_SESSION["firstName"])){echo($_SESSION["firstName"]);}?> oma nettisivu</a></h1>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            let js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=132934150742997';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <?php
}

/**
 * Possible weatherWidget add-in for the site implemented already. Just could't find the right spot for it.
 * This widget tracks down the users location and shows the weather there.
 */
function weatherWidget(){
    ?>
    <a href="https://www.accuweather.com/en/fi/lappeenranta/133330/weather-forecast/133330" class="aw-widget-legal">
<!--
    By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at
    https://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at https://www.accuweather.com/en/privacy.
-->
</a><div id="awcc1513877433907" class="aw-widget-current"  data-locationkey="" data-unit="c" data-language="en-us"
    data-useip="true" data-uid="awcc1513877433907"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>
    <?php
}

/**
 *Function for loading navigation bar html
 *
 */

function navigation(){
    ?>

    <nav>
        <script>
            function openNav() {
                document.getElementById("myNav").style.width = "100%";
            }

            function closeNav() {
                document.getElementById("myNav").style.width = "0%";
            }
        </script>

        <ul>
            <div class="logins">
                <?php
                login();
                ?>

            </div>

            <div class="options">


                <?php
                if(isset($_SESSION["userName"])) {
                    ?>
                    <span class="naviBar" style="cursor:pointer" onclick="openNav()">&#9776; VALIKKO</span>
                    <div id="myNav" class="overlay">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <div class="overlay-content">
                            <a href="notes.php">Muistilista</a>
                            <a href="game.php">Peli</a>
                            <a href="weather.php">Sää</a>
                        </div>
                    </div>

                    <?php
                }else{
                    ?>
                    <li>Kirjaudu sisään tai rekisteröidy, jotta pääset käyttämään sivua</li>
                    <?php
                }
                ?>

            </div>



        </ul>

    </nav>

    <?php
}

/**
 * Differented function for login, register and logout functionality.
 *
 */
function login(){

    if(!isset($_SESSION["firstName"])){
    ?>
    <li id="login">
        <a id="login-trigger" href="#">
            Kirjaudu <span>▼</span>
        </a>
        <div id="login-content" hidden>
            <form action="phpserver/login.php" method="post">
                <fieldset id="inputs">
                    <input id="username" type="email" name="Email" placeholder="Sähköposti" required>
                    <input id="password" type="password" name="Password" placeholder="Salasana" required>
                </fieldset>
                <fieldset id="actions">
                    <input type="submit" id="submitIn" value="Kirjaudu">
                    
                    <!-- 
                        commented out since doesn't work in cloud9
                    <div class="fb-login-button" data-max-rows="1" data-size="medium"
                         data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false"
                         data-use-continue-as="false"></div>
                         
                         --> 
                         
                </fieldset>
            </form>
        </div>
    </li>

    <li id="signup">
        <a id="register-trigger" href="#">
            Rekisteröidy <span>▼</span>
        </a>
        <div id="register-content" hidden>
            <form action="phpserver/register.php" method="post">
                <fieldset id="inputs">
                    <p>Sähköposti</p>
                    <input id="usernameReg" type="email" name="Email" placeholder="Sähköposti/Käyttäjätunnus" required>
                    <p>Käyttäjänimi</p>
                    <input id="userName" name="userName" placeholder="Käyttäjänimi"  required>
                    <p>Etunimi</p>
                    <input id="firstName" name="firstName" placeholder="Etunimi"  required>
                    <p>Sukunimi</p>
                    <input id="lastName" name="lastName" placeholder="Sukunimi" required>
                    <p>Salasana</p>
                    <input id="password" type="password" name="password" placeholder="Salasana" required>
                    <input id="password2" type="password" name="password2" placeholder="Salasana uudestaan" required>
                    <p>Salasana ei saa sisältää erikoismerkkejä</p>
                    <p>Sen pitää olla yli 8 merkkiä pitkä, sisältää numeroita ja iso kirjain</p>

                </fieldset>
                <fieldset id="actions">
                    <input type="submit" id="submitReg" value="Rekisteröidy">
                    
                    <!--
                        Commented out since doesn't work on cloud9 
                      
                      <div class="fb-login-button" data-max-rows="1" data-size="medium"
                      data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false"
                       data-use-continue-as="false"></div>
                    -->
                       
                     

                    
                </fieldset>
            </form>
        </div>
    </li>
    <?php
    }else if(isset($_SESSION["firstName"])){
        ?>
        <li id="signout">
            <a id="logout-trigger" href="#">
                Kirjaudu ulos <span>▼</span>
            </a>
            <div id="logout-content" hidden>
                <form action="phpserver/logout.php" method="post">
                    <fieldset id="inputs">
                        <p><?php echo"Kirjauneena: ". $_SESSION["firstName"]." ". $_SESSION["lastName"] ?> </p>
                    </fieldset>
                    <fieldset id="actions">
                        <input type="submit" id="submitout" value="Kirjaudu ulos">
                    </fieldset>
                </form>
            </div>

        </li>



        <?php

    }
}

/**
 * Function for frontsides amazing content
 */
function front(){
    main();
    navigation();

    ?>
    
    <?php

}

/**
 * function for the game and all its html/javascript content
 */
function game(){
    main();
    navigation();
    $_SESSION["app"]="game";
    ?>
    <link rel="stylesheet" href="css/gameStyle.css">
    <link rel="stylesheet" href="css/noteStyle.css">
    <div class="information">
        <button id="playerChoice1">1 Pelaaja</button> <button id="playerChoice2">2 Pelaajaa</button>

    </div>

    <div id="scoreboard">
        <ul class="list">
        </ul>
    </div>
    <div id="phaser-game">

        <script>
        let player;
        let gravity = 700;
        let score1= 0;
        let score2=0;
        let cursors;
        let scoreText1;
        let scoreText2;
        let lastCoinSpawn;
        let coin;
        let wasd;
        let timer, timerEvent, timeText;
        let player2;


        $(document).ready(function () {
            let playtwo = $('#playerChoice2');
            let playone = $('#playerChoice1');
            let inffo = $('.information');

            gamePrinter("<?php echo $_SESSION["userName"]?>");


            playone.on('click', function () {
                $('.p1').fadeOut().remove();
                $("#gameTime").fadeOut().remove();
                inffo.append('<div class="p1"><input value=<?php echo $_SESSION["userName"] ?> id="playerName" title="playerName" type="text" placeholder="Käyttäjänimi"></div>');
                inffo.append('<div class="p1"><button id="startGame">Pelaa</button></div>');
                $('#startGame').on('click', function () {

                    if ($('#playerName').val() !== "" && $("#gameTime").val() !== "") {
                        game(1, $('#playerName').val());
                        $("#scoreboard").before("<h3 id='fullInfo'>Paina pelistä saadaksesi se koko näytölle</h3>");

                        playone.fadeOut();
                        playtwo.fadeOut();
                        $('.p1').fadeOut().remove();
                        $('.list').empty();
                        $('#top5').fadeOut().remove();
                    }


                });
            });


            playtwo.on('click', function () {
                $('.p1').fadeOut().remove();
                $("#gameTime").fadeOut().remove();
                inffo.append('<div class="p1"><input value=<?php echo $_SESSION["userName"] ?> id="playerName" title="playerName" type="text" placeholder="Käyttäjänimi"></div>');
                inffo.append('<div class="p1"><input placeholder="Käyttäjänimi vierailijalle"id="playerName2" title="playerName" type="text" name="note"></div>');

                inffo.append('<div class="p1"><button id="submit">Pelaa</button></div>');
                $('#submit').on('click', function () {

                    if ($('#playerName').val() !== "" && $('#playerName2').val() !== "" && $('#gameTime').val() !== "") {
                        game(2, $('#playerName').val(), $('#playerName2').val() + " guest");
                        playone.fadeOut();
                        playtwo.fadeOut();
                        inffo.append('<div class="p1"><h2>Paina pelistä saadaksesi se koko näytölle</h2></div>');

                        $('.p1').fadeOut().remove();
                        $('.list').empty();
                        $('#top5').fadeOut().remove();
                    }

                });
            });



            /**
             * function for the game. Choice variable is there to define weather there are
             * one = 1 or two = 2 players.
             */
                function game(choice, player1Name, player2Name) {
                    let gameTime = 60;
                    console.log(player2Name);
                    player2Name = player2Name || 0;
                    let game = new Phaser.Game(1000, 900, Phaser.AUTO, "phaser-game", {
                        preload: preload,
                        create: create,
                        update: update
                    });

                    function preload() {
                        game.load.image("background", "assets/png/BG.png");
                        game.load.atlas("player1", "assets/girl/wut/idle.png", "assets/girl/wut/idle.json");
                        game.load.atlas("player2", "assets/girl/wut/idle.png", "assets/girl/wut/idle.json");
                        game.load.atlas("coin", "assets/girl/coin/coin.png", "assets/girl/coin/coin.json");
                        game.load.image('brick', 'assets/brick.png');


                        cursors = game.input.keyboard.createCursorKeys();
                        wasd = {
                            up: game.input.keyboard.addKey(Phaser.Keyboard.W),
                            down: game.input.keyboard.addKey(Phaser.Keyboard.S),
                            left: game.input.keyboard.addKey(Phaser.Keyboard.A),
                            right: game.input.keyboard.addKey(Phaser.Keyboard.D),
                        };

                    }

                    function gofull() {

                        if (game.scale.isFullScreen)
                        {
                            game.scale.stopFullScreen();
                        }
                        else
                        {
                            game.scale.startFullScreen(false);
                        }

                    }

                    function create() {

                        game.scale.fullScreenScaleMode = Phaser.ScaleManager.EXACT_FIT;

                        game.input.onDown.add(gofull, this);
                        

                        game.physics.startSystem(Phaser.Physics.ARCADE);


                        map = game.add.tileSprite(0, 0, 1000, 900, "background");


                        platforms = game.add.group();

                        platforms.enableBody = true;

                        let ground = platforms.create(0, 880, "brick");
                        ground.scale.setTo(4, 2);
                        ground.body.immovable = true;

                        let ledge = null;

                        ledge = platforms.create(-150, 390, "brick");
                        ledge.body.immovable = true;
                        ledge = platforms.create(170, 550, "brick");
                        ledge.body.immovable = true;
                        ledge = platforms.create(0, 750, "brick");
                        ledge.body.immovable = true;
                        ledge = platforms.create(600, 700, "brick");
                        ledge.body.immovable = true;
                        ledge = platforms.create(800, 500, "brick");
                        ledge.body.immovable = true;


                        player = game.add.sprite(0, 780, 'player1');

                        player.animations.add('kek');
                        player.animations.play('kek', 10, true);
                        player.scale.set(0.2);
                        game.physics.arcade.enable(player);
                        player.body.collideWorldBounds = true;
                        player.body.setSize(260, 505, 145);
                        player.body.bounce.y = 0.15;
                        player.body.gravity.y = gravity;

                        if (choice === 2) {
                            player2 = game.add.sprite(100, 300, 'player2');
                            player2.animations.add('kok');
                            player2.animations.play('kok', 10, true);
                            player2.scale.set(0.2);
                            game.physics.arcade.enable(player2);
                            player2.body.collideWorldBounds = true;
                            player2.body.setSize(260, 505, 145);
                            player2.body.bounce.y = 0.15;
                            player2.body.gravity.y = gravity;
                            scoreText2 = game.add.text(5, 50, "Score " + player2Name + ": 0", {
                                fontsize: "150px;",
                                fill: "#fff"
                            });

                        }


                        coin = game.add.sprite(Math.random() * 900, Math.random() * 800, 'coin');
                        coin.animations.add('spin', Phaser.Animation.generateFrameNames('Coin', 1, 6, '.png'), 10, true, false);
                        coin.animations.play('spin', 10, true);
                        game.physics.arcade.enable(coin);
                        coin.body.gravity.y = gravity;
                        coin.collideWorldBounds = true;
                        coin.body.bounce.y = 0.8;

                        scoreText1 = game.add.text(5, 5, "Score " + player1Name + ": 0", {
                            fontsize: "150px;",
                            fill: "#fff"
                        });


                        timer = game.time.create();

                        timerEvent = timer.add(Phaser.Timer.MINUTE * 1);

                        // Start the timer
                        timer.start();
                        lastCoinSpawn = timer.ms;


                        timeText = game.add.text(game.world.centerX, 10, Math.round((timerEvent.delay - timer.ms) / 1000), {
                            fontsize: "100px",
                            fill: "#ff0"
                        });
                    }

                    function update() {
                        game.physics.arcade.collide(player, platforms);
                        game.physics.arcade.collide(coin, platforms);
                        game.physics.arcade.overlap(coin, player, collectCoin, null, this);

                        if (timer.ms - lastCoinSpawn > 9000) {
                            newCoin(coin);
                        }

                        let accelerationSpeed = 12;
                        let maxVelocity = 300;
                        let slowDownRate = 30;

                        if (choice === 2) {
                            game.physics.arcade.collide(player2, player);
                            game.physics.arcade.collide(player2, platforms);
                            game.physics.arcade.overlap(coin, player2, collectCoin, null, this);
                            if (wasd.left.isDown) {

                                // velocity and acceleration calculated for realism

                                if (player2.body.velocity.x > -maxVelocity) {
                                    player2.body.velocity.x -= accelerationSpeed;
                                }


                            }
                            else if (wasd.right.isDown) {
                                if (player2.body.velocity.x < maxVelocity) {
                                    player2.body.velocity.x += accelerationSpeed;
                                }

                            }
                            else {
                                if (player2.body.velocity.x > 0)
                                    player2.body.velocity.x -= slowDownRate;
                                else if (player2.body.velocity.x < 0)
                                    player2.body.velocity.x += slowDownRate;
                                if (Math.abs(player2.body.velocity.x) < slowDownRate)
                                    player2.body.velocity.x = 0;

                            }

                            if (wasd.up.isDown && player2.body.touching.down) {

                                player2.body.velocity.y = -550
                            }

                        }


                        if (cursors.left.isDown) {
                            if (player.body.velocity.x > -maxVelocity) {
                                player.body.velocity.x -= accelerationSpeed;
                            }


                        }
                        else if (cursors.right.isDown) {
                            if (player.body.velocity.x < maxVelocity) {
                                player.body.velocity.x += accelerationSpeed;
                            }

                        }
                        else {
                            if (player.body.velocity.x > 0)
                                player.body.velocity.x -= slowDownRate;
                            else if (player.body.velocity.x < 0)
                                player.body.velocity.x += slowDownRate;
                            if (Math.abs(player.body.velocity.x) < slowDownRate)
                                player.body.velocity.x = 0;

                        }

                        if (cursors.up.isDown && player.body.touching.down) {

                            player.body.velocity.y = -550
                        }


                        timeText.text = Math.round((timerEvent.delay - timer.ms) / 1000);

                        

                        if (Math.round(timer.ms / 1000) === gameTime) {
                            gameEnd();

                        }

                        /**
                         * Function to "kill the coin and generate new one
                         */
                        function newCoin(coin) {
                            coin.kill();
                            lastCoinSpawn = timer.ms;
                            let y = Math.random() * 800;
                            let x = Math.random() * 900;
                            coin.reset(x, y);
                        }

                        /**
                         * adds players their score
                         */

                        function collectCoin(coin, player) {
                            newCoin(coin);
                            if (player.key === 'player1') {
                                score1 += 1;
                                scoreText1.text = "Score " + player1Name + ": " + score1;
                            } else if (player.key === 'player2') {
                                score2 += 1;
                                scoreText2.text = "Score " + player2Name + ": " + score2;
                            }
                        }


                    }

                    /**
                     * game ends and results are saved to the database
                     */
                    function gameEnd() {
                        game.input.onDown.add(gofull, this);
                        game.destroy();
                        $("#fullInfo").fadeOut().remove();

                        playone.fadeIn();
                        playtwo.fadeIn();
                        $.ajax({
                            type: "POST",
                            url: "phpserver/adder.php",
                            data: {
                                "name": player1Name,
                                "info": score1,
                            }

                        });
                        if (choice === 2) {
                            $.ajax({
                                type: "POST",
                                url: "phpserver/adder.php",
                                data: {
                                    "name": player2Name,
                                    "info": score2,
                                }

                            });
                        }
                        gamePrinter(player1Name, player2Name, score2);
                        score1 = 0;
                        score2 = 0;


                    }
                }




            });




        </script>

    </div>
    <?php
}



