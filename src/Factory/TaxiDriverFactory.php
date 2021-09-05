<?php

namespace Kelogub\Taxistation\Factory;

use Kelogub\Taxistation\Driver\DefDriver;
use Kelogub\Taxistation\Driver\ProDriver;

class TaxiDriverFactory
{
    public static function createProDriver($name): ProDriver
    {
        return new ProDriver($name);
    }

    public static function createDefDriver($name): DefDriver
    {
        return new DefDriver($name);
    }
}