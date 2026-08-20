<?php

namespace App\Clients;

interface IbgeProvincesClientInterface
{
    /**
     * Returns the ISO 3166-2 code of every Brazilian state (e.g. "BR-SP").
     *
     * @return string[]
     */
    public function getProvinceCodes(): array;
}
