<?php

require_once "./../core/Autoload.php";


use Controller\UserController;
use Controller\CalendarController;
use core\app;
use core\Autoload;

try {


    Autoload::registrate("/var/www/html/src/");
    $app = new App();

    $app->addGetRoute('/login', UserController::class, 'getRegistrateForm');
    $app->addPostRoute('/login', UserController::class, 'login');

    $app->addGetRoute('/registration', UserController::class, 'getRegistrateForm');
    $app->addPostRoute('/registration', UserController::class, 'registrate');

    $app->addGetRoute('/calendar', CalendarController::class, 'getCalendar');



    $app->run();
}
catch (\Throwable $throwable)
{
    echo $throwable->getMessage();
}