<?php

namespace App\Http\Requests\lead;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLeadRequest extends FormRequest
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
            'email' => 'required|email|unique:leads,email',
            'phone' => 'required|regex:/^[0-9]{10}$/|unique:leads,phone',
            'source' => 'required|string|max:255',
            'status' => 'required|in:new,contacted,qualified,lost',
            'profile' => 'sometimes|mimes:png,jqg,jpeg,webp',
            'message' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|array',
            'product_id.*' => 'exists:products,id',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Lead name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please provide a valid email address.',
            'email.unique'      => 'This email is already associated with another lead.',
            'phone.required'    => 'Phone number is required.',
            'phone.regex'       => 'Phone number must be 10 digits.',
            'phone.unique'      => 'This phone number already exists.',
            'source.required'   => 'Source is required.',
            'status.required'   => 'Status is required.',
            'status.in'         => 'Invalid status selected.',
            'user_id.required'  => 'Assigned user is required.',
            'user_id.uuid'      => 'User ID must be a valid UUID.',
            'user_id.exists'    => 'The selected user does not exist.',
        ];
    }
}
