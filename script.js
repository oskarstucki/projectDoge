"use strict";
$(document).ready(function () {
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

    list.on("click", "button", function () {
        $( this).parent("li").fadeOut(function(){ $( this ).parent("li").remove(); });
    });

    $("#adder").submit(function(e) {

        var url = "adder.php"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: $("#adder").serialize(), // serializes the form's elements.
            success: function(data)
            {
                note(); // show response from the php script.
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });


});