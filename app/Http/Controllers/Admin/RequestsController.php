<?php

namespace App\Http\Controllers\Admin;

use App\Events\RequestStatusUpdated;
use App\Http\Controllers\Controller;
use App\Request as ServiceRequest;
use App\RequestUpdate;
use App\User;
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
                ->with(['service', 'photos', 'user'])
                ->whereIn('status', ['pending', 'open'])
                ->paginate(10);
        }

        return view('requests.index', ['title' => 'Odottavat ja avoimet palautteet']);
    }

    public function archived()
    {
        if(request()->expectsJson()) {
            return ServiceRequest::latest()
                ->with(['service', 'photos', 'user'])
                ->where('status', 'closed')
                ->paginate(10);
        }

        return view('requests.index', ['title' => 'Suljetut palautteet']);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = ServiceRequest::with(['service', 'photos', 'user'])
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

        if(($field == 'status' && request()->get($field) != 'pending')
            || ($field == 'status_notes' && $request->status != 'pending')) {
                event(new RequestStatusUpdated($request));
        }

        RequestUpdate::create([
            'service_request_id' => $request->service_request_id,
            'old_value' => json_encode([$field => $request->$field]),
            'new_value' => json_encode([$field => request()->get($field)]),
            'user_id' => auth()->id()
        ]);

        $request->update(request()->all());

        return response('Palaute päivitetty', 200);
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
     * @param ServiceRequest|int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceRequest $request)
    {
        $request->delete();

        if(request()->expectsJson()) {
            return response('Palaute poistettu.', 200);
        }

        return redirect('requests')
            ->with('status', 'Palaute poistettu.');
    }

    public function destroyRequests()
    {
        ServiceRequest::destroy(request()->get('ids'));

        if(request()->expectsJson()) {
            return response('Palautteet poistettu.', 200);
        }

        return redirect('requests')
            ->with('status', 'Palautteet poistettu.');
    }

    public function destroyApiUser($id)
    {
        if(!auth()->user()->admin) {
            abort(403);
        }

        User::destroy($id);

        return response('Käyttäjätili suljettu', 200);
    }
}
