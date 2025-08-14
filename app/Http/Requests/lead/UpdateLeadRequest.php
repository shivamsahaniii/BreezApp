<?php

namespace App\Http\Requests\lead;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'source' => 'required|string|max:255',
            'status' => 'required|in:new,contacted,qualified,lost',
            'message' => 'nullable|string',
            'product_id' => 'nullable|array',
            'product_id.*' => 'exists:products,id',
            'user_id' => 'required|exists:users,id', // single user id validation
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already taken.',
            'phone.required'    => 'Phone number is required.',
            'phone.regex'       => 'Phone number must be exactly 10 digits.',
            'phone.unique'      => 'This phone number is already in use.',
            'source.required'   => 'Lead source is required.',
            'source.in'         => 'Invalid source selected.',
            'status.required'   => 'Status is required.',
            'status.in'         => 'Invalid status selected.',
        ];
    }
}
