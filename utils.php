<?php
/**
 * Created by PhpStorm.
 * User: osaka
 * Date: 22.10.2017
 * Time: 1.54
 */


function main(){
    ?>
    <!DOCTYPE html>
    <html lang="fi">
    <head>
        <meta charset="UTF-8">
        <title>Oskun nettisivu</title>
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


    <?php
}

function navigation(){
    ?>
    <nav>
        <nav>
            <ul>
                <li><a href="notes.php">Muistilista</a></li>
                <li><a href="game.php">Peli</a></li>
                <li><a href="weather.php">Sää</a></li>
            </ul>
        </nav>
    </nav>

    <?php
}

function front(){
    main();

    ?>
    <h1>Oskarin nettisivu</h1>

    <?php
    navigation();
}

function notes(){
    main();

    ?>
    <h1>Muistilista</h1>
    <?php
    navigation();
    ?>
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

function game(){
    main();
    ?>

    <h1>GAME</h1>

    <?php
    navigation();
    ?>

    <div class="information">
        <button id="playerChoice1">1 Pelaaja</button> <button id="playerChoice2">2 Pelaajaa</button>
        <button id="register">Rekisteröidy</button>



    </div>
    <div id="scoreboard">
        <ul class="list">
        </ul>
    </div>
    <div id="phaser-game">

        <script>
        let player;
            let player1Name, player2Name;
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
                let register = $('#register');
                let inffo = $('.information');

                register.on('click',function () {
                    $('.p1').fadeOut().remove();
                    inffo.append('<div class="p1"><input id="user" title="playerName" type="text" placeholder="käyttäjätunnus"></div>');
                    inffo.append('<div class="p1"><input id="password" title="playerName" type="text" placeholder="salasana"></div>');
                    inffo.append('<div class="p1"><input id="password2" title="playerName" type="text" placeholder="salasana uudelleen"></div>');
                    inffo.append('<div class="p1"><button id="submit">Rekisteröidy</button> </div>');

                    $('#submit').on('click',function () {

                        if($('.user').val() === "" || $('.password').val() === "" || $('.password2').val() === ""){

                        }else{
                            if($('.password').val() ===  $('.password2').val()){
                                $.ajax({
                                    type: "POST",
                                    url: "register.php",
                                    data: {"username": $('#user').val(),
                                        "password": $('#password').val()}

                                });
                                alert("Käyttäjä tehty!");
                                $('.p1').fadeOut().remove();
                            } else {
                                alert("salasanat eivät täsmää!")
                            }



                        }

                    });


                });

                playone.on('click',function () {
                    $('.p1').fadeOut().remove();
                    inffo.append('<div class="p1"><input id="playerName" title="playerName" type="text" placeholder="Käyttäjänimi"></div>');
                    inffo.append('<div class="p1"><input placeholder="salasana" id="password" title="playerName" type="text" name="note"></div>');

                    inffo.append('<div class="p1"><button id="submit">Pelaa</button> </div>')
                    $('#submit').on('click',function () {

                        if($('#playerName').val() === ""){

                        }else{
                            $.post("login.php", {username: $('#playerName').val(), password: $('#password').val()})
                                .done(function(data){

                                game(1,data);
                                playone.fadeOut();
                                playtwo.fadeOut();
                                register.fadeOut();
                                $('.p1').fadeOut().remove();
                                $('.list').empty();


                            },'json');


                            }});



                });



                playtwo.on('click',function () {
                    $('.p1').fadeOut().remove();
                    inffo.append('<div class="p1"><input placeholder="Käyttäjänimi" id="playerName" title="playerName" type="text" name="note"></div>');
                    inffo.append('<div class="p1"><input placeholder="salasana" id="password" title="playerName" type="text" name="note"></div>');

                    inffo.append('<div class="p1"><input placeholder="Käyttäjänimi"id="playerName2" title="playerName" type="text" name="note"></div>');
                    inffo.append('<div class="p1"><input placeholder="salasana" id="password2" title="playerName" type="text" name="note"></div>');

                    inffo.append('<div class="p1"><button id="submit">Pelaa</button> </div>');
                    $('#submit').on('click',function () {
                        if($('#playerName').val() === "" || $('#playerName2').val() === "" || $('#password').val() ===""
                            || $('#password2').val() ===""){

                        }else{
                            player1Name = $('#playerName').val();
                            player2Name = $('#playerName2').val();
                            $.getJSON("login.php", function (data) {


                                game(2, data);
                                playone.fadeOut();
                                playtwo.fadeOut();
                                register.fadeOut();
                                $('.p1').fadeOut().remove();
                                $('.list').empty();


                            });




                        }

                    });
                });


                function game(choice, id1, id2) {
                    id2 = id2 || 0;
                    let game = new Phaser.Game(1000, 900,Phaser.AUTO,"phaser-game",{preload: preload, create: create, update: update});

                    function preload() {
                        game.load.image("background", "assets/png/BG.png");
                        game.load.atlas("player1", "assets/girl/wut/idle.png","assets/girl/wut/idle.json");
                        game.load.atlas("player2", "assets/girl/wut/idle.png", "assets/girl/wut/idle.json");
                        game.load.atlas("coin","assets/girl/coin/coin.png","assets/girl/coin/coin.json" );
                        game.load.image('brick', 'assets/brick.png');


                        cursors = game.input.keyboard.createCursorKeys();
                        wasd = {
                            up: game.input.keyboard.addKey(Phaser.Keyboard.W),
                            down: game.input.keyboard.addKey(Phaser.Keyboard.S),
                            left: game.input.keyboard.addKey(Phaser.Keyboard.A),
                            right: game.input.keyboard.addKey(Phaser.Keyboard.D),
                        };

                    }

                    function create() {

                        game.physics.startSystem(Phaser.Physics.ARCADE);



                        map = game.add.tileSprite(0,0,1000,900,"background");


                        platforms = game.add.group();

                        platforms.enableBody = true;

                        let ground = platforms.create(0, 880, "brick");
                        ground.scale.setTo(4,2);
                        ground.body.immovable = true;

                        let ledge = null;

                        ledge = platforms.create(-150, 390, "brick");
                        ledge.body.immovable =true;
                        ledge = platforms.create(150, 550, "brick");
                        ledge.body.immovable =true;
                        ledge = platforms.create(0, 750, "brick");
                        ledge.body.immovable =true;
                        ledge = platforms.create(600, 700, "brick");
                        ledge.body.immovable =true;
                        ledge = platforms.create(800, 500, "brick");
                        ledge.body.immovable =true;


                        player = game.add.sprite(0,780,'player1');

                        player.animations.add('kek');
                        player.animations.play('kek',10,true);
                        player.scale.set(0.2);
                        game.physics.arcade.enable(player);
                        player.body.collideWorldBounds = true;
                        player.body.setSize(260,505,145);
                        player.body.bounce.y = 0.15;
                        player.body.gravity.y = gravity;

                        if (choice===2){
                            player2 = game.add.sprite(100,300,'player2');
                            player2.animations.add('kok');
                            player2.animations.play('kok',10,true);
                            player2.scale.set(0.2);
                            game.physics.arcade.enable(player2);
                            player2.body.collideWorldBounds = true;
                            player2.body.setSize(260,505,145);
                            player2.body.bounce.y = 0.15;
                            player2.body.gravity.y = gravity;
                            scoreText2 = game.add.text(5,50, "Score "+player2Name+": 0", {fontsize: "150px;", fill: "#fff"});

                        }



                        coin = game.add.sprite(Math.random() * 900,Math.random() * 800,'coin');
                        coin.animations.add('spin',Phaser.Animation.generateFrameNames('Coin',1,6,'.png'),10,true,false);
                        coin.animations.play('spin', 10, true);
                        game.physics.arcade.enable(coin);
                        coin.body.gravity.y = gravity;
                        coin.collideWorldBounds = true;
                        coin.body.bounce.y = 0.8;

                        scoreText1 = game.add.text(5,5, "Score "+player1Name+": 0", {fontsize: "150px;", fill: "#fff"});


                        timer = game.time.create();

                        timerEvent = timer.add(Phaser.Timer.MINUTE * 1);

                        // Start the timer
                        timer.start();
                        lastCoinSpawn = timer.ms;


                        timeText = game.add.text(game.world.centerX,10,Math.round((timerEvent.delay - timer.ms) / 1000),{fontsize: "100px", fill:"#ff0"});
                    }

                    function update() {
                        game.physics.arcade.collide(player, platforms);
                        game.physics.arcade.collide(coin, platforms);
                        game.physics.arcade.overlap(coin, player, collectCoin, null, this);

                        if (timer.ms - lastCoinSpawn > 9000){
                            newCoin(coin);
                        }

                        let accelerationSpeed = 12;
                        let maxVelocity = 300;
                        let slowDownRate = 30;

                        if (choice ===2){
                            game.physics.arcade.collide(player2, player);
                            game.physics.arcade.collide(player2, platforms);
                            game.physics.arcade.overlap(coin, player2, collectCoin, null, this);
                            if(wasd.left.isDown){
                                if (player2.body.velocity.x > -maxVelocity)
                                {player2.body.velocity.x -= accelerationSpeed;}


                            }
                            else if (wasd.right.isDown){
                                if(player2.body.velocity.x < maxVelocity){
                                    player2.body.velocity.x += accelerationSpeed;
                                }

                            }
                            else {
                                if (player2.body.velocity.x > 0)
                                    player2.body.velocity.x -= slowDownRate;
                                else if (player2.body.velocity.x < 0)
                                    player2.body.velocity.x += slowDownRate;
                                if (Math.abs(player2.body.velocity.x)< slowDownRate)
                                    player2.body.velocity.x = 0;

                            }

                            if (wasd.up.isDown && player2.body.touching.down){

                                player2.body.velocity.y=-550
                            }

                        }




                        if(cursors.left.isDown){
                            if (player.body.velocity.x > -maxVelocity)
                            {player.body.velocity.x -= accelerationSpeed;}


                        }
                        else if (cursors.right.isDown){
                            if(player.body.velocity.x < maxVelocity){
                                player.body.velocity.x += accelerationSpeed;
                            }

                        }
                        else {
                            if (player.body.velocity.x > 0)
                                player.body.velocity.x -= slowDownRate;
                            else if (player.body.velocity.x < 0)
                                player.body.velocity.x += slowDownRate;
                            if (Math.abs(player.body.velocity.x)< slowDownRate)
                                player.body.velocity.x = 0;

                        }

                        if (cursors.up.isDown && player.body.touching.down){

                            player.body.velocity.y=-550
                        }



                        timeText.text= Math.round((timerEvent.delay - timer.ms) / 1000);

                        if (Math.round(timer.ms / 1000 ) === 5){
                            gameEnd();

                        }

                        function newCoin(coin){
                            coin.kill();
                            lastCoinSpawn = timer.ms;
                            let y = Math.random() * 800;
                            let x = Math.random() * 900;
                            coin.reset(x, y);
                        }

                        function collectCoin(coin, player) {
                            newCoin(coin);
                            if (player.key === 'player1') {
                                score1 += 1;
                                scoreText1.text = "Score "+player1Name+": "+ score1;
                            } else if (player.key === 'player2') {
                                score2 += 1;
                                scoreText2.text = "Score "+player2Name+": "+ score1;
                            }
                        }



                    }

                    function gameEnd() {
                        game.destroy();
                        playone.fadeIn();
                        playtwo.fadeIn();
                        register.fadeIn();
                        $.ajax({
                            type: "POST",
                            url: "addergame.php",
                            data: {"name": player1Name,
                                    "score": score1,
                                    "playerid": id1}

                        });
                        if(choice === 2){
                            $.ajax({
                                type: "POST",
                                url: "addergame.php",
                                data: {"name": player2Name,
                                    "score": score2}

                            });
                        }
                        printer();




                    }


                    function printer(){

                        let noteList = $(".list");
                        $.getJSON("scoreboard.php", function (data) {
                            sorted = [];

                            data.forEach(function (entry) {
                                sorted.push({place: 0,score: entry.score, player: entry.playername})


                            });

                            sorted.sort(function (a,b) {
                                return b.score-a.score;

                            });
                            let place=1;
                            sorted.forEach(function(entry){
                                entry.place = place;
                                place++;
                            });

                            let top=5;
                            for(let i=0;i < top; i++){
                                noteList.append("<li>"+sorted[i].place+"  Pelaaja: "+sorted[i].player+"<br>" +
                                    "Pisteet:"+ sorted[i].score+"</li>");
                            }
                            sorted.forEach(function (entry) {
                                if (entry.player === player1Name || entry.player === player2Name){
                                    if(entry.place>top){
                                        noteList.append("<li>"+entry.place+"  Pelaaja: "+entry.player+"<br>" +
                                            "Pisteet:"+ entry.score+"</li>");
                                    }
                                }

                            })
                        });


                    }

                }

            });





        </script>

    </div>
    <?php
}


