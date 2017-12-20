<?php
/**
 * Created by PhpStorm.
 * User: oskar
 * Date: 11/19/17
 * Time: 6:06 AM
 */

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'weather' : getWeather($_POST['city']);break;

    }
}

function getWeather($city)
{

    $mem = new Memcached();
    $mem->addServer("127.0.0.1", 11211) or die("Unable to connect");
    $url = "http://api.openweathermap.org/data/2.5/weather?q=".$city."&APPID=97286caea7eb1b543826d25a2f90a9a0";

    $result = $mem->get($city);

    if (!$result) {
        $result = file_get_contents($url);
        if($result !==false){
            $cityID = json_decode($result,true);

            print($result."a");

            $mem->set($cityID['name'], $result, 60*60);

        }else{
            print("error");
        }


    } else {
        print($result);
    }
}
