<?php

namespace Kelogub\Taxistation\Car;

abstract class Car
{
    protected int $mileage;
    protected int $oilRate;
    protected string $brand;

    public function __toString(): string
    {
        return $this->brand;
    }
}