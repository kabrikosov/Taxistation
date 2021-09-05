<?php

namespace Kelogub\Taxistation\Observers;

use Kelogub\Taxistation\Car\TaxiCar;

class CrashedCarsObserver extends Observable
{
    protected array $brokenCars;
    protected array $carCrushes;

    public function __construct()
    {
        $this->carCrushes = [];
        $this->brokenCars = [];
        $this->carCrushes = [];
    }

    public function addBrokenCar(TaxiCar $car)
    {
        $search = array_search($car, $this->brokenCars);
        if ($search === false){
            $this->brokenCars[] = $car;
            $key = array_key_last($this->brokenCars);
            $this->carCrushes[$key] = 1;
        } else {
            $this->carCrushes[$search]++;
        }
    }

    public function getBrokenCars(): array
    {
        $return = array();
//        $this->brokenCars = array_unique($this->brokenCars, 0);
        foreach ($this->brokenCars as $key => $car){
            array_push($return, ["car" => $car, "crashes" => $this->carCrushes[$key]]);
        }
        return $return;
    }

    public function restart()
    {
        $this->carCrushes = [];
    }
}