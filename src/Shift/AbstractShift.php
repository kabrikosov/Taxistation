<?php

namespace Kelogub\Taxistation\Shift;

abstract class AbstractShift
{
    protected float $usedOil;
    protected int $drovenKm;
    protected Observable $observer;

    public function __construct()
    {
        $this->usedOil = 0;
        $this->drovenKm = 0;
    }

    abstract public function runShift();

    public function getDrovenKm(): int
    {
        return $this->drovenKm;
    }

    public function getUsedOil(): float
    {
        return $this->usedOil;
    }

    public function nextDay(){
        $this->drovenKm = 0;
        $this->usedOil = 0;
    }
}