<?php

namespace Kelogub\Taxistation\Car;

class Homba extends TaxiCar
{
    protected string $brand = "Homba";

    public function __construct(int $mileage)
    {
        parent::__construct($mileage);
        $this->oilRate = 7;
    }
}