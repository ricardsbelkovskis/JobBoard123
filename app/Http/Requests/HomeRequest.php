<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password' => 'nullable|string|min:8|confirmed',
            'description' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ];
    }
}
