<?php

namespace App\Transformers;

use App\Request;
use League\Fractal\TransformerAbstract;

class ServiceRequestTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Request $request
     * @return array
     */
    public function transform(Request $request)
    {
        $transforms = [
            'service_request_id' => $request->service_request_id,
            'service_code' => $request->service_code,
            'service_name' => $request->service->service_name,
            'status' => $request->status,
            'status_notes' => $request->status_notes,
            'agency_responsible' => $request->agency_responsible,
            'description' => $request->description,
            'title' => $request->title,
            'address_string' => $request->address_string,
            'zip_code' => $request->zip_code,
            'lat' => $request->getLat(),
            'long' => $request->getLong(),
            'media_url' => $request->media_url,
            'requested_datetime' => $request->created_at->toW3cString(),
            'updated_datetime' => $request->updated_at->toW3cString(),
        ];

        if(count($request->photos) > 0) {

            $transforms['extended_attributes'] = [
                'media_urls' => $request->photos->pluck('filename')->map(function($element) {
                    return asset('/storage/' . $element);
                })
            ];
        }

        return $transforms;
    }
}
