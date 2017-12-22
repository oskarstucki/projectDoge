"use strict";


/**
 * function used for printing information from the table into a list
 */
function printer(){
    let noteList = $("#list");
    $.getJSON("../phpserver/printer.php", function (data) {
        noteList.empty();
        data.forEach(function (entry) {
                noteList.append("<li class='list' id='"+entry.id+"'>"+entry.text+"<button class='deleteButton' value='Poista'>Poista</button></li>")
            }

        );

    });

}

/**
 * function used for printing information from the table into a list but for the game.
 * Fetches all the game scores and sorts them. Printing only the top 5 and the best score from the
 * user. Takes in :
 * @param player1Name = user
 * @param player2Name = guest
 * @param player2score = guest score
 *
 * adds guests score to be sorted but doesn't necessarily print it if it's not top 5
 */

function gamePrinter(player1Name, player2Name, player2score) {



    let noteList = $(".list");
    $("#scoreboard").before("<h2 id='top5'>TOP 5 sivunlaajuisesti ja oma paras</h2>");
    $.getJSON("phpserver/printerGame.php", function (data) {
        let sorted = [];
        if (typeof player2Name !== 'undefined' && typeof player2score !== 'undefined'){
            sorted.push({place: 0, score: player2score, player: player2Name });
        }



        data.forEach(function (entry) {
            console.log(entry.text);
            sorted.push({place: 0, score: entry.text, player: entry.userId})

        });

        sorted.sort(function (a, b) {
            return b.score - a.score;

        });
        let place = 1;

        sorted.forEach(function (entry) {
            entry.place = place;
            place++;
        });
        let top;
        if (sorted.length > 5){
            top = 5;
        }else{
            top = sorted.length;
        }


        for (let i = 0; i < sorted.length; i++) {
            if(i<top){
                noteList.append("<li>" + sorted[i].place + "  Pelaaja: " + sorted[i].player + "<br>" +
                    "Pisteet:" + sorted[i].score + "</li>");
            }if(i>= top){
                if (sorted[i].player === player1Name) {
                    noteList.append("<li>" + sorted[i].place + "  Pelaaja: " + sorted[i].player + "<br>" +
                        "Pisteet:" + sorted[i].score + "</li>");
                    break;

                }

            }
        }

    });


}

$(document).ready(function () {

    /**
     * Facebook-login
    */

    $.ajaxSetup({ cache: true });


    window.fbAsyncInit = function() {
        // FB JavaScript SDK configuration and setup
        FB.init({
            appId      : '132934150742997', // FB App ID
            cookie     : true,  // enable cookies to allow the server to access the session
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.8' // use graph api version 2.8
        });

        // Check whether the user already logged in
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                //get user data
                getFbUserData();
            }
        });
    };

// Load the JavaScript SDK asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
    function fbLogin() {
        FB.login(function (response) {
            if (response.authResponse) {
                // Get user profile data
                getFbUserData();
            } else {
                document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
            }
        }, {scope: 'email'});
    }

// Fetch the user profile data from facebook and add it to the table for later use

    function getFbUserData(){
        FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
            function (response) {
                $.ajax({
                    type: "POST",
                    url: "phpserver/register.php",
                    data: {"Email": response.email,
                            "userName": response.first_name,
                            "firstName": response.first_name,
                            "lastName": response.last_name,
                            "password": response.id,
                            "fb": true}
                });
            });
    }

// Logout from facebook
    $("#submitout").on("click",function () {
        FB.logout(function(response) {
            window.location.reload();
            console.log(response)

        });
    });


    /*Note list scripts */

    printer();


    let input = $(".newThings");
    let list = $("#list");
    let elementNumber=0;

    $("#append").on("click", function () {
        list.append("<li>"+input.val()+"</li>");
        input.val("")
    });

    list.on("mouseenter","li", function () {
        $(this).addClass("inside")
    });

    list.on("mouseleave","li", function () {
        $(this).removeClass("inside")
    });

    /**
     * used to delete notes
     */
    list.on("click", ".deleteButton", function () {
        let buttonId = $(this).parent("li").attr("id");
        $( this).parent("li").fadeOut(function(){ $( this ).parent("li").remove(); });
        $.ajax({
            type: "POST",
            url: "delete.php",
            data: {"id": buttonId}
        });
        console.log(buttonId);
    });

    /**
     *adds notes
     *
     */

    $("#formBut").click(function(e) {
        let noteVar = $(".newThings").val();


        let url = "adder.php";

        $.ajax({
            type: "POST",
            url: url,
            data: {"info": noteVar}

        });
        printer();


    });


    /**
     * Login scripts so form "comes down"
     */

    $('#login-trigger').click(function(){
        registerDown($(this));
    });

    $('#register-trigger').click(function(){
        registerDown($(this));

    });

    $('#logout-trigger').click(function(){
        registerDown($(this));

    });

    function registerDown(thisObj) {
        if(thisObj.attr('id') === 'register-trigger'){
            thisObj.next('#register-content').slideToggle();
            if ($('#login-content').is(":visible")){
                $('#login-content').slideToggle(200);
            }

        } else if(thisObj.attr('id') === 'login-trigger'){
            thisObj.next('#login-content').slideToggle();
            if ($('#register-content').is(":visible")){
                $('#register-content').slideToggle(200);
            }

        }

        else {
            thisObj.next('#logout-content').slideToggle();

        }

        thisObj.toggleClass('active');

        if (thisObj.hasClass('active')){
            thisObj.find('span').html('&#x25B2;')
        }
        else {
            thisObj.find('span').html('&#x25BC;')
        }

    }







});