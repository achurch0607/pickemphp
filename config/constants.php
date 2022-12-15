<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
date_default_timezone_set("America/Denver");
$dateTimeZoneCurrent = new DateTimeZone("America/Denver");
$dateTimeZoneEastern = new DateTimeZone("America/New_York");
$dateTimeCurrent = new DateTime("now", $dateTimeZoneCurrent);
$dateTimeEastern = new DateTime("now", $dateTimeZoneEastern);
$offsetCurrent = $dateTimeCurrent->getOffset();
$offsetEastern = $dateTimeEastern->getOffset();
$offsetHours = ($offsetEastern - $offsetCurrent) / 3600;


return [
    'options' => [
        'ALLOW_SIGNUP' => true,
        'SHOW_SIGNUP_LINK' => true,
        'USER_NAMES_DISPLAY' => 3, //1 = real names, 2 = usernames, 3 = usernames w/ real names on hover
        'SEASON_YEAR' => '2022',
        
        'SERVER_TIMEZONE_OFFSET' => $offsetHours
    ]
];

//if you want a specific one
//config('constants.options.SEASON_YEAR');