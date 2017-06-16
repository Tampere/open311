<?php

namespace App\Http\Requests;

use App\Request;
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
        return [
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
            'media_url' => 'max:255',
        ];
    }

    public function persist()
    {
        return Request::create([
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
        ]);
    }

    public function response(array $errors)
    {
        return response()->json($errors, 400);
    }
}
