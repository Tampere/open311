<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Keyword;
use App\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->wantsJson()) {
            return Service::with('keywords')->get();
        }

        return view('services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'service_code' => 'required|max:255|unique:services',
            'service_name' => 'required|max:255',
            'description' => 'required',
            'group' => 'required',
        ]);

        $service = Service::create($request->only(['service_code', 'service_name', 'description', 'group']));

        if(request()->has('keywords')) {
            $keywords = explode(',', request()->get('keywords'));
            foreach($keywords as $keyword) {
                $key = Keyword::firstOrCreate(['name' => $keyword]);
                $service->keywords()->save($key);
            }
        }

        return $service->load('keywords');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'service_code' => 'required|unique:services,service_code,'.$id.',service_code',
            'service_name' => 'required|max:255',
            'description' => 'required',
            'group' => 'required',
        ]);

        $service = Service::findOrFail($id);

        if(request()->has('keywords')) {
            $keywords = explode(',', request()->get('keywords'));
            foreach($keywords as $keyword) {
                if(strlen(trim($keyword)) == 0) continue;
                $keys[] = Keyword::firstOrCreate(['name' => $keyword])->id;
            }

            $service->keywords()->sync($keys);
        }

        return $service;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::destroy($id);

        return response()->json(['message' => 'Service removed'], 200);
    }
}
