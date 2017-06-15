<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServicesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function services_can_be_listed_as_json()
    {
        $service = factory('App\Service')->create();

        $response = $this->get('v1/services.json');

        $response->assertStatus(200)
            ->assertSee($service->service_name);
    }

    /** @test */
    public function a_service_can_be_requested_as_json()
    {
        $service = factory('App\Service')->create();
        $notTheServiceYouAreLookingFor = factory('App\Service')->create();

        $response = $this->get("v1/services/{$service->service_code}.json");

        $response->assertStatus(200)
            ->assertSee($service->service_name)
            ->assertDontSee($notTheServiceYouAreLookingFor->service_name);
    }
}
