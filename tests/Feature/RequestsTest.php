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

        $this->post('v1/requests.json', [
            'service_code' => $service->service_code,
            'description' => $request->description,
            'title' => $request->title,
            'lat' => 25.11,
            'long' => 17.643435,
            'address_string' => $request->address_string,
            'zip_code' => $request->zip_code,
            'email' => $request->email,
            'fist_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'media_url' => $request->media_url,
        ])->assertStatus(200);
    }
}
