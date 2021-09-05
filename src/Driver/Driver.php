<?php

namespace Kelogub\Taxistation\Driver;

abstract class Driver
{
    protected string $name;

    public function __construct(string $name){
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}