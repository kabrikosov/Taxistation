<?php

use Kelogub\Taxistation\Car\Homba;
use Kelogub\Taxistation\Driver\DefDriver;
use Kelogub\Taxistation\Driver\ProDriver;
use Kelogub\Taxistation\Factory\TaxiCarFactory;
use Kelogub\Taxistation\Factory\TaxiDriverFactory;
use Kelogub\Taxistation\Shift\TaxiShift;

require "vendor/autoload.php";
$json = json_decode($_POST['json'], true);
$cars = [];
$drivers = [];
$places = $json['park']['places'];
$names = ['Пётр', 'Василий', "Геннадий", "Ибрагим", "Анастасия", "Ирина", "Виталий", "Иван", "София"];
foreach($json['drivers'] as $key => $value){
    $drivers[] = match ($value['type']){
        'professional'=> TaxiDriverFactory::createProDriver($names[array_rand($names)]),
        default => TaxiDriverFactory::createDefDriver($names[array_rand($names)])
    };
}
foreach($json['cars'] as $data){
    $cars[] = match($data['brand']){
        default => TaxiCarFactory::createHomba($data['km']),
        'Luda'=> TaxiCarFactory::createLuda($data['km']),
        'Hendai'=>TaxiCarFactory::createHendai($data['km'])
    };
}
include "View/header.php";
$minus = spl_object_id($cars[0])-1;
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