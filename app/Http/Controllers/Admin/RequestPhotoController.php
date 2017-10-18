<?php

namespace App\Http\Controllers\Admin;

use App\RequestPhoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class RequestPhotoController extends Controller
{
    public function destroy(RequestPhoto $photo)
    {
        Storage::delete('public/'.$photo->filename);

        $photo->delete();

        return response('Kuva poistettu.', 200);
    }
}
