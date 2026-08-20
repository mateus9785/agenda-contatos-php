<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;

class IbgeProvincesClient implements IbgeProvincesClientInterface
{
    /**
     * geonameId 3469034 is Brazil. This is the same geonames.org endpoint
     * the code called directly before this class existed.
     */
    private const ENDPOINT = 'http://www.geonames.org/childrenJSON?geonameId=3469034';

    public function getProvinceCodes(): array
    {
        $response = Http::timeout(5)->get(self::ENDPOINT)->throw();

        return array_map(
            fn ($province) => $province['adminCodes1']['ISO3166_2'],
            $response->json('geonames')
        );
    }
}
