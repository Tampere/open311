<?php

namespace App\Http\Controllers;

use App\Filters\RequestFilters;
use App\Http\Requests\ServiceRequest;
use App\Notifications\ServiceRequestSubmitted;
use App\Request;
use App\Transformers\ServiceRequestTransformer;
use App\User;

class RequestsController extends Controller
{
    /**
     * @param $extension
     * @param RequestFilters $filters
     * @return \Spatie\Fractal\Fractal
     */
    public function index($extension, RequestFilters $filters)
    {
        $this->checkExtension($extension);

        // Providing service_request_id overrides all other parameters
        if(request()->has('service_request_id')) {
            return $this->showMany(request()->get('service_request_id'), $extension);
        }

        $requests = Request::with(['service', 'photos'])
            ->latest();

        // If all lat, long and radii are present, we can calculate distance. Individually each are worthless.
        if(request()->has(['lat', 'long', 'radius'])) {
            $requests->distance(
                request()->get('radius'),
                sprintf("%f,%f",
                    request()->get('lat'),
                    request()->get('long')
                )
            );
        }

        $requests->filter($filters);

        return fractal($requests->get(), new ServiceRequestTransformer);
    }

    /**
     * @param $service_request_id
     * @param $extension
     * @return \Spatie\Fractal\Fractal
     */
    public function show($service_request_id, $extension)
    {
        $this->checkExtension($extension);

        $request = Request::with('photos')
            ->findOrFail($service_request_id);

        return fractal($request, new ServiceRequestTransformer);
    }

    /**
     * @param ServiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ServiceRequest $request)
    {
        $serviceRequest = $request->persist();

        $users = User::all();

        foreach($users as $user) {
            $user->notify(new ServiceRequestSubmitted($serviceRequest));
        }

        return response()->json([
            'service_request_id' => $serviceRequest->service_request_id,
            'service_notice' => '',
        ], 200);
    }

    /**
     * @param $service_request_id
     * @param $extension
     * @return \Spatie\Fractal\Fractal
     */
    private function showMany($service_request_id, $extension)
    {
        if(strpos($service_request_id, ',')) {
            $ids = explode(',', $service_request_id);
        } else {
            $ids = $service_request_id;
        }

        $request = Request::with('photos')
            ->whereIn('service_request_id', $ids)
            ->get();

        return fractal($request, new ServiceRequestTransformer);
    }
}
