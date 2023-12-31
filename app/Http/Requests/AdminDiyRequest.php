<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminDiyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:64',
            'description' => 'required|max:255',
        ];
    }
}
