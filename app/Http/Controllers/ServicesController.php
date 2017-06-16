<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * @param $extension
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index($extension)
    {
        $this->checkExtension($extension);

        return Service::all();
    }

    /**
     * @param $service_code
     * @param $extension
     * @return mixed
     */
    public function show($service_code, $extension)
    {
        $this->checkExtension($extension);

        return Service::findOrFail($service_code);
    }
}
