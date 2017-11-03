"use strict";


function printer(){
    let noteList = $("#list");
    $.getJSON("printer.php", function (data) {
        noteList.empty();
        data.forEach(function (entry) {
                noteList.append("<li id='"+entry.id+"'>"+entry.note+"<button class='deleteButton' value='Poista'>Poista</button></li>")
            }

        );



    });

}

$(document).ready(function () {
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
            type: "GET",
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
            data: {"note": noteVar}

        });
        printer();


    });


});