<?php

namespace Tests\Unit;

use App\Services\api\v1\AsteroidService;
use PHPUnit\Framework\TestCase;

class AsteroidServiceTest extends TestCase
{
    private AsteroidService $service;

    public function setUp(): void
    {
        $this->service = new AsteroidService();
    }

    /**
     * @dataProvider KeyValueExtractorDataProvider
     */
    public function testKeyValueExtractor(array $given, array $expected)
    {
        $this->assertEquals($expected, $this->service->keyValueExtractor($given));
    }

    public function KeyValueExtractorDataProvider(): array
    {
        return [
            [
                [
                    'car' => 'BMW',
                    ['speed' => 500, 'parameters' => ['weight' => 2, 'length' => 4, 'empty_val' => '']],

                ],
                [
                    "car" => "BMW",
                    "speed" => 500,
                    "weight" => 2,
                    "length" => 4,
                    'empty_val' => 0
                ]
            ]
        ];
    }
}
