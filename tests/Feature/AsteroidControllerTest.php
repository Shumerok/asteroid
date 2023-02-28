<?php

namespace Tests\Feature;

use App\Http\Controllers\api\v1\AsteroidController;
use App\Http\Requests\Api\v1\AsteroidRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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

    public function testHazardousWrong()
    {
        $this->expectException(BadRequestException::class);
        $this->withoutExceptionHandling()->get('api/v1/neo/hazardous?ddd=sss');
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
        $this->expectException(BadRequestException::class);
        $this->withoutExceptionHandling()->get('api/v1/neo/fastest?hazardous=asdasdasd');
    }

    public function testFastestHazardousInt()
    {
        $one = 1;
        $this->expectException(BadRequestException::class);
        $this->withoutExceptionHandling()->get('api/v1/neo/fastest?hazardous='.$one);
    }

    public function testFastestHazardousUpperTRUE()
    {
        $this->expectException(BadRequestException::class);
        $this->withoutExceptionHandling()->get('api/v1/neo/fastest?hazardous=TRUE');
    }

    public function testFastestHazardousUpperFALSE()
    {
        $this->expectException(BadRequestException::class);
        $this->withoutExceptionHandling()->get('api/v1/neo/fastest?hazardous=FALSE');
    }

    public function testFastestHazardousAnyParams()
    {
        $this->expectException(BadRequestException::class);
        $this->withoutExceptionHandling()->get('api/v1/neo/fastest?asdasd=asdads&sda=dd');
    }

    public function testIsPublicGetData()
    {
        $mock = $this->createMock(AsteroidController::class);

        $mock->expects($this->once())->method('getData')->willReturn(new JsonResponse(['Data set' => 'Success']));
        $mock->getData();
    }

    public function testIsPublicFastest()
    {
        $mock = $this->createMock(AsteroidController::class);
        $col = new ResourceCollection(['adasd', 'adasd']);
        $mock->expects($this->once())->method('fastest')->willReturn($col);
        $mock->fastest(new AsteroidRequest([''], ['']));
    }

    public function testIsPublicHazardous()
    {
        $mock = $this->createMock(AsteroidController::class);
        $col = new ResourceCollection(['adasd', 'adasd']);
        $mock->expects($this->once())->method('hazardous')->willReturn($col);
        $mock->hazardous();
    }

}
