<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'diy_id' => 'required|exists:diys,id',
            'content' => 'required|string|max:255',
        ];
    }
}
