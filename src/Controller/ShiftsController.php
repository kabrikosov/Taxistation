<?php

namespace Kelogub\Taxistation\Controller;

use Kelogub\Taxistation\Car\TaxiCar;
use Kelogub\Taxistation\Shift\DriverShift;

class ShiftsController
{
    private array $drivers;
    private array $cars;
    private array $driverShifts;
    private array $emptyCars;
    private array $crashedCars;

    /**
     * @param array $drivers
     * @param array $cars
     * @param int $days
     */
    public function __construct(array $drivers, array $cars)
    {
        $this->drivers = $drivers;
        $this->cars = $cars;
        $this->emptyCars = $cars;
        $this->driverShifts = [];
        $this->crashedCars = [];
        $this->createDriverShifts();
    }

    public function runShifts()
    {
        $this->checkCrashedCars();
        foreach ($this->driverShifts as $driverShift) {
            /**
             * @var DriverShift $driverShift
             */
            if (!$driverShift->hasCar()) {
                $this->rebind($driverShift);
            }
            $iter = 10 * $driverShift->getOrderRatoFactor();
            for ($i = 1; $i <= $iter; $i++) {
                if ($driverShift->hasCar()) {
                    $crash = $driverShift->runShift();
                    if ($crash) {
                        $this->crashedCars[] = $driverShift->unbindCar();
                        $this->rebind($driverShift);
                    }
                }
            }
        }
    }

    /**
     * @param DriverShift $driverShift
     */
    private function rebind(DriverShift $driverShift)
    {
        if (!$driverShift->hasCar()) {
            $car = array_shift($this->emptyCars);
            if (!is_null($car)) {
                $driverShift->bindCar($car);
            }
        }
    }

    private function checkCrashedCars()
    {
        $readyCars = array_filter($this->crashedCars, function ($a) {
            /**
             * @var TaxiCar $a
             */
            return !$a->isOnRepair();
        });
        if (!empty($readyCars)) {
            $this->emptyCars = array_merge($this->emptyCars, $readyCars);
            $this->crashedCars = array_filter($this->crashedCars, function ($a) {
                /**
                 * @var TaxiCar $a
                 */
                return $a->isOnRepair();
            });
        }
    }

    private function createDriverShifts()
    {
        foreach ($this->drivers as $driver) {
            $this->driverShifts[] = new DriverShift($driver);
        }
        foreach ($this->driverShifts as $driverShift) {
            $car = array_shift($this->emptyCars);
            if (!is_null($car)) {
                $driverShift->bindCar($car);
            } else break;
        }
    }
    public function getDriverShifts(): array{
        return $this->driverShifts;
    }

    public function nextDay(){
        foreach($this->driverShifts as $driverShift){
            $driverShift->nextDay();
        }
        foreach ($this->crashedCars as $car){
            $car->nextDay();
        }
    }
}