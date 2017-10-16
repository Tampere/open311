<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Request as ServiceRequest;
use App\RequestUpdate;
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
        if(request()->expectsJson()) {
            return ServiceRequest::latest()
                ->with(['service', 'photos'])
                ->whereIn('status', ['pending', 'open'])
                ->paginate(10);
        }

        return view('requests.index', ['title' => 'Pending and open requests']);
    }

    public function archived()
    {
        if(request()->expectsJson()) {
            return ServiceRequest::latest()
                ->with(['service', 'photos'])
                ->where('status', 'closed')
                ->paginate(10);
        }

        return view('requests.index', ['title' => 'Archived requests']);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $formRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request)
    {
        $payload = request()->all();
        $field = array_keys($payload)[0];

        RequestUpdate::create([
            'service_request_id' => $request->service_request_id,
            'old_value' => json_encode([$field => $request->$field]),
            'new_value' => json_encode([$field => request()->get($field)]),
            'user_id' => auth()->id()
        ]);

        $request->update(request()->all());

        return response('Request updated', 200);
    }

    public function activities(ServiceRequest $request)
    {
        return RequestUpdate::latest()
            ->with('user')
            ->where('service_request_id', $request->service_request_id)
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceRequest $id)
    {
        ServiceRequest::destroy($id);

        if(request()->expectsJson()) {
            return response('Service request deleted.', 200);
        }

        return redirect('requests')
            ->with('status', 'Service request deleted.');
    }
}
