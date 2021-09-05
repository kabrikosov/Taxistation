<?php

namespace Kelogub\Taxistation\Observers;

use Kelogub\Taxistation\Car\TaxiCar;

class UsedCarsObserver extends Observable
{
    private array $usedCars;

    public function __construct(){
        $this->usedCars = [];
    }

    public function addCar(Taxicar $car){
        $this->usedCars[] = $car;
    }

    public function reset(){
        $this->usedCars = [];
    }

    public function getUsedCars(): array{
        return $this->usedCars;
    }

}