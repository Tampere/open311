<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RequestsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_valid_request_gets_persisted()
    {
        $service = factory('App\Service')->create();
        $request = factory('App\Request')->make(['service_code' => $service->service_code]);

        $this->post('requests.json', $request->toArray())
            ->assertStatus(200);
    }
}
