<?php

namespace Kelogub\Taxistation\Car;

class Luda extends TaxiCar
{
    protected function calculateCrashChanse() : float
    {
        return parent::calculateCrashChanse()*3;
    }
}