<?php

namespace Tests\Feature;

use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('api/v1/');
        $response->assertStatus(200);
        $this->assertEquals('application/json', $response->headers->get('content-type'));
    }
}
