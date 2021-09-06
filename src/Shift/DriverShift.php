<?php

namespace Kelogub\Taxistation\Shift;

use JetBrains\PhpStorm\Pure;
use Kelogub\Taxistation\Car\TaxiCar;
use Kelogub\Taxistation\Driver\TaxiDriver;

class DriverShift extends AbstractShift
{
    private TaxiDriver $driver;

    public function __construct(TaxiDriver $driver)
    {
        parent::__construct();
        $this->driver = $driver;
    }

    public function runShift(): bool
    {
        $status = $this->driver->drive();
        if (!$status) {
            $this->usedOil += 0.07*$this->driver->getOilRateFactor();
            $this->drovenKm += 7;
        }
        return $status;
    }

    public function bindCar(TaxiCar $car): void
    {
        if (!$car->isOnRepair()) {
            $this->driver->bindCar($car);
        }
    }

    public function nextDay()
    {
        parent::nextDay();
        $this->driver->nextDay();
//        $this->observer->restart();
    }

    #[Pure] public function getDriverName(): string
    {
        return $this->driver->getName();
    }

    #[Pure] public function hasCar(): bool
    {
        return $this->driver->hasCar();
    }

    public function unbindCar(): TaxiCar
    {
        $car = $this->driver->getCar();
        $this->driver->unbindCar();
        return $car;
    }

    public function isOnRepair(): bool
    {
        return $this->driver->hasCar() && $this->driver->getCar()->isOnRepair();
    }
    #[Pure] public function getOrderRateFactor(): float
    {
        return $this->driver->getOrderFactor();
    }

    public function getUsedCars(): array{
        return $this->driver->getUsedCars();
    }
}