<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('api/v1/');
        $response->assertStatus(200);
        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }

    public function testIndexWrongQuery()
    {
        $this->expectException(BadRequestException::class);
        $this->withoutExceptionHandling()->get('api/v1/?ddd=sss');
    }
}
