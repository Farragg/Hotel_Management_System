<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|numeric',
            'room_id' => 'required|numeric',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'total_adults' => 'required|numeric',
            'total_children' => 'required|numeric',
            'roomprice' => 'required',
        ];
    }
}
