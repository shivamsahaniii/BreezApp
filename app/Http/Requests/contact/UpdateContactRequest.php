<?php

namespace App\Http\Requests\contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateContactRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'position' => 'required|string',
            'notes' => 'nullable|string',
            'account_id.*' => 'exists:accounts,id',
            'user_id.*' => 'exists:users,id',

        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'the :attribute is required.',
            'first_name.string' => 'the :attribute should be contain only characters.',
            'last_name.required' => 'the :attribute is required.',
            'last_name.string' => 'the :attribute should be contain only characters.',
            'position.required' => 'the :attribute type is required.',
            'position.string' => 'the :attribute must be in string form.',
            'email.required' => 'the :attribute is required.',
            'email.email' => 'the :attribute should be unique.',
        ];
    }
}
