<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:64',
            'description' => 'required|string|max:255',
        ];
    }
}