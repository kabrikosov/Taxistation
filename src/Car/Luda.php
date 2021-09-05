<?php

namespace Kelogub\Taxistation\Car;

class Luda extends Hendai
{
    protected function calculateCrashChanse() : float
    {
        return parent::calculateCrashChanse()*3;
    }
}