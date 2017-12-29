<?php

namespace App\Http\Requests;

use App\Request;
use App\RequestPhoto;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'service_code' => 'required|exists:services',
            'description' => 'required|min:10|max:5000',
            'title' => 'max:255',
            'lat' => 'min:-90|max:90|required_with:long',
            'long' => 'min:-180|max:180|required_with:lat',
            'address_string' => 'max:255',
            'zip_code' => 'max:255',
            'email' => 'email|max:255',
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'phone' => 'max:255',
            'media_url' => 'max:255'
        ];

        $photos = count($this->input('media'));
        foreach (range(0, $photos) as $index) {
            $rules['media.' . $index] = 'image|mimes:jpeg,bmp,png|max:40000';
        }

        return $rules;
    }

    public function persist()
    {
        $request = Request::create([
            'user_id' => auth()->id(),
            'service_code' => $this->service_code,
            'description' => $this->description,
            'title' => $this->title ?: null,
            'location' => $this->lat ? "{$this->lat},{$this->long}" : null,
            'address_string' => $this->address_string ?: null,
            'zip_code' => $this->zip_code ?: null,
            'email' => $this->email ?: null,
            'first_name' => $this->first_name ?: null,
            'last_name' => $this->last_name ?: null,
            'phone' => $this->phone ?: null,
            'media_url' => $this->media_url ?: null,
            'status' => 'pending'
        ]);

        if($this->media && count($this->media) > 0) {
            foreach ($this->media as $photo) {
                $filename = $photo->store('public');
                preg_match('/public\/(.*)/', $filename, $matches);
                RequestPhoto::create([
                    'service_request_id' => $request->service_request_id,
                    'filename' => $matches[1]
                ]);
            }
        }

        return $request;
    }

    public function response(array $errors)
    {
        return response()->json($errors, 400);
    }
}
