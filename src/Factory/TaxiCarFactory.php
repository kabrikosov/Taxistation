<?php

namespace Kelogub\Taxistation\Factory;

use Kelogub\Taxistation\Car\Hendai;
use Kelogub\Taxistation\Car\Homba;
use Kelogub\Taxistation\Car\Luda;
use Kelogub\Taxistation\Car\TaxiCar;

class TaxiCarFactory
{
    public static function createHendai($mileage): TaxiCar{
        return new Hendai($mileage);
    }

    public static function createHomba($mileage): TaxiCar{
        return new Homba($mileage);
    }

    public static function createLuda($mileage): TaxiCar
    {
        return new Luda($mileage);
    }

}