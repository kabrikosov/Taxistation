<?php

use Kelogub\Taxistation\Car\Homba;
use Kelogub\Taxistation\Car\TaxiCar;
use Kelogub\Taxistation\Driver\DefDriver;
use Kelogub\Taxistation\Driver\ProDriver;
use Kelogub\Taxistation\Factory\TaxiCarFactory;
use Kelogub\Taxistation\Factory\TaxiDriverFactory;
use Kelogub\Taxistation\Shift\TaxiShift;

require "vendor/autoload.php";
$defaultJSON = <<<JSON
{
  "park": {"places": 30},
  "drivers": [
    {"type": "professional", "name": "PRO Anastasia"},
    {"type": "professional", "name": "PRO Waldemar"},
    {"type": "default", "name": "Peter"},
    {"type": "default", "name": "August"}
  ],
  "cars": [
    {"km": 13951, "brand": "Homba"},
    {"km": 20512, "brand": "Luda"},
    {"km": 10300, "brand": "Hendai"},
    {"km": 1546, "brand": "Homba"},
    {"km": 11254, "brand": "Luda"},
    {"km": 2356, "brand": "Hendai"}
  ]
}
JSON;

$json = json_decode($_POST['json'] , true)?: json_decode($defaultJSON, true);
$days = $_POST['days'];
$cars = [];
$drivers = [];
$places = $json['park']['places'];
$names = ['Пётр', 'Василий', "Геннадий", "Ибрагим", "Анастасия", "Ирина", "Виталий", "Иван", "София"];
foreach($json['drivers'] as $value){
    $drivers[] = match ($value['type']){
        'professional'=> TaxiDriverFactory::createProDriver($value['name'] ?? $names[array_rand($names)]),
        default => TaxiDriverFactory::createDefDriver($value['name'] ?? $names[array_rand($names)])
    };
}
foreach($json['cars'] as $data){
    $cars[] = match($data['brand']){
        default => TaxiCarFactory::createHomba($data['km']),
        'Luda'=> TaxiCarFactory::createLuda($data['km']),
        'Hendai'=>TaxiCarFactory::createHendai($data['km'])
    };
}
include "view/header.php";
$minus = spl_object_id($cars[0])-1; //нужен чтобы нормализовать индексы
$getCarId = function (TaxiCar $car) use ($minus): int
{
    return spl_object_id($car) - $minus;
};
$shift = new TaxiShift($drivers, $cars);
$summary = ['oil'=>0, 'km'=>0];
for ($i = 1; $i<=$days; $i++) {
    $shift->runShift();
    include "view/taxiShift.php";
    $summary['oil']+=$shift->getUsedOil();
    $summary["km"]+=$shift->getDrovenKm();
    $shift->nextDay();
}
include "view/summary.php";