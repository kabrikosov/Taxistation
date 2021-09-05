<?php

use Kelogub\Taxistation\Car\Homba;
use Kelogub\Taxistation\Controller\ShiftsController;
use Kelogub\Taxistation\Driver\DefDriver;
use Kelogub\Taxistation\Driver\ProDriver;

require "vendor/autoload.php";

$cars = [new Homba(rand(1000, 50000)), new Homba(rand(1000, 50000)), new Homba(rand(1000, 5000))];
$drivers = [new ProDriver("Василий"), new DefDriver("Пётр")];

foreach ($cars as $car){
    echo $car . " ".  (spl_object_id($car) - 1 . "; ");
}

include "View/header.php";
$shift = new ShiftsController($drivers, $cars);
for ($i = 1; $i<11; $i++) {
    $shift->runShifts();
    include "View/TaxiShift.php";
    $shift->nextDay();
}