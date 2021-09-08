<?php

namespace Kelogub\Taxistation\Driver;

use Kelogub\Taxistation\Car\TaxiCar;
use Kelogub\Taxistation\Observers\Observable;
use Kelogub\Taxistation\Observers\UsedCarsObserver;

abstract class TaxiDriver extends Driver
{
    protected ?TaxiCar $car;
    protected Observable $observer;
    protected Observable $allCarsObserver;
    protected int $drovenKm;
    protected float $usedOil;

    const AVG_DRIVE_LENGTH = 7;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->car = null;
        $this->observer = new UsedCarsObserver();
        $this->allCarsObserver = new UsedCarsObserver();
        $this->usedOil = 0;
        $this->drovenKm = 0;
    }

    public function bindCar(TaxiCar $car)
    {
        $this->car = $car;
        $this->observer->addCar($car);
        $this->allCarsObserver->addCar($car);
    }

    public function getOrderFactor(): float
    {
        return 1;
    }

    public function getOilRateFactor(): float
    {
        return 1;
    }

    /**
     * @throws \Exception
     */
    public function drive(): bool
    {
        if (!isset($this->car)) {
            throw new \Exception("Водителю {$this->name} не назначена машина!");
        }
        $this->usedOil += self::AVG_DRIVE_LENGTH/100 * $this->getOilRateFactor();
        $this->drovenKm += self::AVG_DRIVE_LENGTH;
        return $this->car->ride();
    }

    public function unbindCar()
    {
        unset($this->car);
    }

    public function getCar(): TaxiCar
    {
        return $this->car;
    }

    public function hasCar(): bool
    {
        return isset($this->car);
    }

    public function nextDay()
    {
        $this->observer->reset();
        if ($this->hasCar()) {
            $this->car->nextDay();
            $this->observer->addCar($this->getCar());
        }
    }

    public function getUsedCars(): array{
        return $this->observer->getUsedCars();
    }

    public function getDrovenKm(): int{
        return $this->drovenKm;
    }

    public function getUsedOil(): float{
        return $this->usedOil;
    }

    public function getAllUsedCars(): array{
        return $this->allCarsObserver->getUsedCars();
    }
}