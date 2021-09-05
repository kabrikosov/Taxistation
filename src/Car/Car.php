<?php

namespace Kelogub\Taxistation\Car;

abstract class Car
{
    protected int $mileage;
    protected int $oilRate;

    public function __toString(): string
    {
        $fullClassName = static::class;
        $className = preg_split('/\W/', $fullClassName);
        return array_pop($className);
    }
}