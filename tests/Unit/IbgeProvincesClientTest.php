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
    public function test_get_province_codes_returns_the_iso3166_code_of_each_state()
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
    public function test_get_province_codes_throws_when_geonames_responds_with_an_error()
    {
        Http::fake([
            'www.geonames.org/*' => Http::response('unavailable', 503),
        ]);

        $this->expectException(RequestException::class);

        (new IbgeProvincesClient)->getProvinceCodes();
    }
}
