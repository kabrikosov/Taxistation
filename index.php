<?php

use Kelogub\Taxistation\Car\Homba;
use Kelogub\Taxistation\Driver\DefDriver;
use Kelogub\Taxistation\Driver\ProDriver;
use Kelogub\Taxistation\Shift\TaxiShift;

require "vendor/autoload.php";

$cars = [new Homba(rand(1000, 50000)), new Homba(rand(1000, 50000)), new Homba(rand(1000, 5000))];
$drivers = [new ProDriver("Василий"), new DefDriver("Пётр")];

include "View/header.php";
$shift = new TaxiShift($drivers, $cars);
$summary = ['oil'=>0, 'km'=>0];
for ($i = 1; $i<11; $i++) {
    $shift->runShift();
    include "View/TaxiShift.php";
    $summary['oil']+=$shift->getUsedOil();
    $summary["km"]+=$shift->getDrovenKm();
    $shift->nextDay();
}
include "View/Summary.php";