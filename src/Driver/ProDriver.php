<?php

namespace Kelogub\Taxistation\Driver;

class ProDriver extends TaxiDriver
{
    public function getOrderFactor() : float{
        return 1.3;
    }
    public function getOilRateFactor() : float{
        return 0.8;
    }
}