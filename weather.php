<?php
/**
 * With this you are able to add weather to your site and remove it. Site stores the city in the database.
 * Uses memcached so server doesn't have to fetch the information all the time.
 */

require_once("phpserver/utils.php");


main();
navigation();
$_SESSION["app"]="weather";
?>
<div id = weatherAdd>
    <input id="weatherCity">
    <button id="weatherButton">Lisää</button>
</div>
<div id="weatherInfo">


</div>



<script>

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function formatDate(date) {
        let dateObj = new Date(date);
        let monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];

        let day = dateObj.getDate();
        let monthIndex = dateObj.getMonth();
        let year = dateObj.getFullYear();

        return day + ' ' + monthNames[monthIndex] + ' ' + year;
    }

    function formatTime(date) {
        let dateObj = new Date(date);

        let hours = dateObj.getHours();
        let minutes = dateObj.getMinutes();

        return hours + ':' + minutes;
    }

    function getWeather(city ,id) {
        $.ajax({
            url: "phpserver/functions.php",
            type: 'post',
            data: {action:"weather", city: capitalizeFirstLetter(city)},
            success: function (response) {

                if(response ==='error'){
                    alert("Kaupunkia ei löydy")
                }else {
                    if (response.slice(-1) === 'a') {
                        info = JSON.parse(response.slice(0, -1));
                        source = 'API';

                    } else {
                        info = JSON.parse(response);
                        source = "mem";
                    }
                    let tempInC = Math.round(info.main.temp - 273.15);

                    if ($("#" + info.id).length === 0) {

                        $("#weatherInfo").append("<div class='weatherBlock' id='" + info.id + "'></div>");
                        let date = formatDate(info.dt*1000);
                        let time = formatTime(info.dt*1000);
                        let weatherBlock= $("#" + info.id)


                        if(tempInC<0){
                            weatherBlock.css('background-color', '#1a53ff')
                        }else if(tempInC === 0){
                            weatherBlock.css('background-color', '#4da6ff')
                        }else if(tempInC < 5 && tempInC > 0){
                            weatherBlock.css('background-color', '#80bfff')
                        }else if(tempInC <11 && tempInC > 5){
                            weatherBlock.css('background-color', '#b3d9ff')
                        }else if(tempInC <16 && tempInC > 10){
                            weatherBlock.css('background-color', '#ff9999')
                        }else if(tempInC <21 && tempInC > 15){
                            weatherBlock.css('background-color', '#ff8080')
                        }else if(tempInC <26 && tempInC > 20){
                            weatherBlock.css('background-color', '#ff4d4d')
                        }else if(tempInC <31 && tempInC > 25) {
                            weatherBlock.css('background-color', '#ff531a')
                        }

                        $("#" + info.id).append("<ul class='weather'>" +
                            "<p id='city'>" + info.name + "</p>"+
                            "<li id='weatherState'>Sää: " + info.weather[0].description + "</li>" +
                            "<li id='temp'>Lämpötila: " + tempInC + "°C</li>" +
                            "<li id='windSpeed'>Tuulen nopeus: " + info.wind.speed + " m/s</li>" +
                            "<p id='APMEM'>" + source +"</p>" +
                            "<p id='date'>"+ date +"</p>" +
                            "<p id='time'>"+ time +"</p>" +
                            "<img id='weatherimg' src='http://openweathermap.org/img/w/"+info.weather[0].icon
                            +".png'/>" +
                            "<button id= " + id + " class='deleteButton' value='Poista'>Poista</button></ul>")
                    }



                }

            },
            error: function () {
                alert("Kaupunkia ei löydy")
            }
        });

    }

    $(document).ready(function () {
        let weatherCity = $("#weatherCity");
        let info;
        let source;

        $.getJSON("phpserver/printer.php", function (data) {
            data.forEach(function (entry) {
                getWeather(entry.text, entry.id)

                }

            );

        });

        $("#weatherButton").on("click", function () {

            $.ajax({
                type: "POST",
                url: "phpserver/adder.php",
                data: {"info": capitalizeFirstLetter(weatherCity.val())}

            });

            $.getJSON("phpserver/printer.php", function (data) {
                data.forEach(function (entry) {
                        console.log(entry.id);
                        getWeather(entry.text, entry.id)

                    }

                );

            });



        });

        $("#weatherInfo").on("click", ".deleteButton", function () {
            let buttonId = $(this).attr("id");
            $( this).parent("ul").fadeOut(function(){ $( this ).parent("ul").remove(); });
            $.ajax({
                type: "POST",
                url: "phpserver/delete.php",
                data: {"id": buttonId}
            });
            console.log(buttonId);
        });

    });
</script>
<?php