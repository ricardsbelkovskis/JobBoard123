<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'purchase_id' => 'required|exists:purchases,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:255',
        ];
    }
}
