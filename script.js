"use strict";


function printer(){
    let noteList = $("#list");
    $.getJSON("printer.php", function (data) {
        noteList.empty();
        data.forEach(function (entry) {
                noteList.append("<li class='list' id='"+entry.id+"'>"+entry.text+"<button class='deleteButton' value='Poista'>Poista</button></li>")
            }

        );

    });

}

function gamePrinter(player1Name, player2Name, player2score) {



    let noteList = $(".list");
    $("#scoreboard").before("<h2 id='top5'>TOP 5</h2>");
    $.getJSON("printer.php", function (data) {
        let sorted = [];
        if (typeof player2Name !== 'undefined' && typeof player2score !== 'undefined'){
            sorted.push({place: 0, score: player2score, player: player2Name });
        }



        data.forEach(function (entry) {
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


        for (let i = 0; i < top; i++) {
            noteList.append("<li>" + sorted[i].place + "  Pelaaja: " + sorted[i].player + "<br>" +
                "Pisteet:" + sorted[i].score + "</li>");
        }

    });


}

$(document).ready(function () {

    /* Facebook-kirjautuminen*/

    $.ajaxSetup({ cache: true });
    $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
        FB.init({
            appId: '132934150742997',
            version: 'v2.11' // or v2.1, v2.2, v2.3, ...
        });
        $('#loginbutton,#feedbutton').removeAttr('disabled');
        FB.getLoginStatus(function (response) {
            console.log(response);
            FB.api('/me',function (response) {
                console.log(response);
            });
        });


    });


    /*Muistilista*/

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


    /*Login-palkin script */

    /* Paljastuminen*/

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

    /*Salasanan tarkistus ja hyväksyminen*/






});