<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Muistilista</title>
    <link rel="stylesheet" href="stylesheet.css">
    <script type="text/javascript" src="phaser.js"></script>
</head>
<body>
<script
    src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
<script src="script.js"></script>
<h1>GAME</h1>
<div class="game">
    <script>

        let idle;
        let player;
        let cursors;
        let ground;

        let game = new Phaser.Game(1000, 900,Phaser.AUTO,"",{preload: preload, create: create, update: update});

        function preload() {
            game.load.image("background", "assets/png/BG.png");
            game.load.atlas("player_idle", "assets/girl/wut/idle.png","assets/girl/wut/idle.json");
            game.load.atlas("player_run", "assets/girl/wut/move.png", "assets/girl/wut/move.json");
            game.load.atlas("coin","assets/girl/coin/coin.png", "assets/girl/coin/coin.json");
            game.load.image('brick', 'assets/brick.png');

            cursors = game.input.keyboard.createCursorKeys();

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
            ledge = platforms.create(850, 650, "brick");
            ledge.body.immovable =true;
            ledge = platforms.create(600, 750, "brick");
            ledge.body.immovable =true;
            ledge = platforms.create(950, 500, "brick");
            ledge.body.immovable =true;

            player = game.add.sprite(game.world.centerX,300,'player_idle');

            player.animations.add('idle');
            player.animations.play('idle',10,true);
            player.scale.set(0.2);
            game.physics.arcade.enable(player);
            player.body.collideWorldBounds = true;
            player.body.setSize(260,505,145);
            player.body.bounce.y = 0.15;
            player.body.gravity.y = 500;

            coins = game.add.group();
            coins.enableBody = true;

            //  And now we convert all of the Tiled objects with an ID of 34 into sprites within the coins group
            createFromObjects('Object Layer 1', 34, 'coin', 0, true, false, coins);

            //  Add animations to all of the coin sprites
            coins.callAll('animations.add', 'animations', 'spin', [0, 1, 2, 3, 4, 5], 10, true);
            coins.callAll('animations.play', 'animations', 'spin');

            sprite = game.add.sprite(260, 100, 'phaser');
            sprite.anchor.set(0.5);




        }

        function update() {
            game.physics.arcade.collide(player, platforms);
            let accelerationSpeed = 6;
            let maxVelocity = 200;
            let slowDownRate = 20;
            //player.body.velocity.x=0;

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

                player.body.velocity.y=-450
            }
        }




    </script>
</div>

</body>
</html>




