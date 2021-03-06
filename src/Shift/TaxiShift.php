<?php

namespace Kelogub\Taxistation\Shift;

use Kelogub\Taxistation\Car\TaxiCar;
use Kelogub\Taxistation\Observers\CrashedCarsObserver;

class TaxiShift extends AbstractShift
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
        parent::__construct();
        $this->drivers = $drivers;
        $this->cars = $cars;
        $this->emptyCars = $cars;
        $this->driverShifts = [];
        $this->crashedCars = [];
        $this->observer = new CrashedCarsObserver();
        $this->createDriverShifts();
    }

    public function runShift()
    {
        $this->checkCrashedCars();
        shuffle($this->driverShifts);
        foreach ($this->driverShifts as $driverShift) {
            /**
             * @var DriverShift $driverShift
             */
            if (!$driverShift->hasCar()) {
                $this->rebind($driverShift);
            }
        }
        shuffle($this->driverShifts);
        foreach ($this->driverShifts as $driverShift){
            $iter = 10 * $driverShift->getOrderRateFactor();
            for ($i = 1; $i <= $iter; $i++) {
                if ($driverShift->hasCar()) {
                    $crash = $driverShift->runShift();
                    if ($crash) {
                        $crashedCar = $driverShift->unbindCar();
                        $this->crashedCars[] = $crashedCar;
                        $this->observer->addBrokenCar($crashedCar);
                        $this->rebind($driverShift);
                    }
                }
            }
            $this->usedOil += $driverShift->getUsedOil();
            $this->drovenKm += $driverShift->getDrovenKm();
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
        $return = $this->driverShifts;
        usort($return, function ($a, $b){
            /**
             * @var DriverShift $a
             * @var DriverShift $b
             */
            return ($b->getDrovenKm() + count($b->getUsedCars())) - ($a->getDrovenKm() - count($b->getUsedCars()));
        });
        return $return;
    }

    public function nextDay(){
        parent::nextDay();
        foreach($this->driverShifts as $driverShift){
            $driverShift->nextDay();
        }
        foreach ($this->crashedCars as $car){
            $car->nextDay();
        }
    }

    public function getBrokenCars(): array{
        return $this->observer->getBrokenCars();
    }
}