<?php

namespace Tests\Unit;

use App\Clients\IbgeProvincesClient;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IbgeProvincesClientTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetProvinceCodesReturnsTheIso3166CodeOfEachState()
    {
        Http::fake([
            'www.geonames.org/*' => Http::response([
                'geonames' => [
                    ['adminCodes1' => ['ISO3166_2' => 'SP']],
                    ['adminCodes1' => ['ISO3166_2' => 'RJ']],
                ],
            ]),
        ]);

        $codes = (new IbgeProvincesClient)->getProvinceCodes();

        $this->assertSame(['SP', 'RJ'], $codes);
    }

    /**
     * @return void
     */
    public function testGetProvinceCodesThrowsWhenGeonamesRespondsWithAnError()
    {
        Http::fake([
            'www.geonames.org/*' => Http::response('unavailable', 503),
        ]);

        $this->expectException(RequestException::class);

        (new IbgeProvincesClient)->getProvinceCodes();
    }
}
