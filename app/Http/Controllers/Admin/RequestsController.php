<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Request as ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = ServiceRequest::latest()
            ->with(['service', 'photos'])
            ->where('status', 'open')
            ->paginate(10);

        return view('requests.index', ['requests' => $requests]);
    }

    public function archived()
    {
        $requests = ServiceRequest::latest()
            ->with(['service', 'photos'])
            ->where('status', 'closed')
            ->paginate(10);

        return view('requests.archived', ['requests' => $requests]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = ServiceRequest::with(['service', 'photos'])
            ->findOrFail($id);

        auth()
            ->user()
            ->notifications
            ->where('data.service_request_id', $id)
            ->each
            ->update(['read_at' => Carbon::now()]);

        return view('requests.show', ['request' => $request]);
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
     * @param  \Illuminate\Http\Request  $formRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $formRequest, $id)
    {
        $request = ServiceRequest::with('service')->findOrFail($id);

        $request->update(['status' => 'closed']);

        return view('requests.show', ['request' => $request, 'status' => 'Service request marked as closed.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServiceRequest::destroy($id);

        return redirect('requests')
            ->with('status', 'Service request deleted.');
    }
}
