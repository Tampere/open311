<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index($extension)
    {
        if(!in_array($extension, config('app.supportedExtensions'))) {
            return response()->json(['error' => "Invalid extension '$extension'"], 400);
        }

        return Service::all();
    }
}
