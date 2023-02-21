<?php

namespace Tests\Feature;

use Tests\TestCase;

class AsteroidControllerTest extends TestCase
{
    public function testFastest()
    {
        $response = $this->get('api/v1/neo/fastest');
        $response->assertStatus(200);
        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    public function testHazardous()
    {
        $response = $this->get('api/v1/neo/hazardous');
        $response->assertStatus(200);
        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    public function testFastestHazardousTrue()
    {
        $response = $this->get('api/v1/neo/fastest?hazardous=true');
        $response->assertStatus(200);
        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    public function testFastestHazardousFalse()
    {
        $response = $this->get('api/v1/neo/fastest?hazardous=false');
        $response->assertStatus(200);
        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    public function testFastestHazardousWrong()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->withoutExceptionHandling()->get('api/v1/neo/fastest?hazardous=asdasdasd');
    }
}
