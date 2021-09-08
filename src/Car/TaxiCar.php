<?php

namespace Kelogub\Taxistation\Car;

class TaxiCar extends Car
{
    protected int $repairingDays;

    public function __construct(int $mileage)
    {
        $this->mileage = $mileage;
        $this->oilRate = 10;
        $this->repairingDays = 0;
        $this->rides = 0;
    }

    public function ride(): bool
    {
        $status = $this->isOnCrash();
        if (!$status){
            $this->rides++;
        }
        return $status;
    }

    public function isOnRepair(): bool
    {
        return $this->repairingDays != 0;
    }

    protected function isOnCrash(): bool
    {
        try {
            $chance = random_int(0, 100);
            if ($chance >= $this->calculateCrashChanse()) {
                $this->mileage += 7;
                return false;
            } else {
                $this->repairingDays = 3;
                return true;
            }
        } catch (\Exception) { //если бросило исключение, вычисляем по старой схеме
            $chance = rand(1, ceil(1 / $this->calculateCrashChanse() * 100));
            if ($chance != 1) {
                $this->mileage += 7;
            } else {
                $this->repairingDays = 3;
            }
            return $chance == 1;
        }
    }

    protected function calculateCrashChanse(): float
    {
        return ($this->mileage / 1000 + 0.5);
    }

    public function nextDay()
    {
        if ($this->repairingDays>0) {
            --$this->repairingDays;
        }
        $this->rides = 0;
    }

    public function getRides(): int {
        return $this->rides;
    }

    public function getRepairingDays(): int{
        return $this->repairingDays;
    }
}