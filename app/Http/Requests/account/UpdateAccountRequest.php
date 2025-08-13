<?php

namespace App\Http\Requests\account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAccountRequest extends FormRequest
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
            'industry' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
            'user_id' => 'required|exists:users,id', // single user id validation
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'the :attribute is required.',
            'name.string' => 'the :attribute should be contain only characters.',
            'industry.required' => 'the :attribute type is required.',
            'industry.string' => 'the :attribute should be contain only characters.',
            'email.required' => 'the :attribute is required.',
            'email.email' => 'the :attribute should be unique.',
        ];
    }

    // public function attributes()
    // {
    //     return[
    //         'name'=>'UserName',
    //     ];
    // }

    // StoreAccountRequest.php
}
