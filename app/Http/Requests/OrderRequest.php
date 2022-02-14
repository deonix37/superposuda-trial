<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'fullName' => [
                'required', 'string', 'max:255', 'regex:/^.+\s.+\s.+$/',
            ],
            'customerComment' => ['required', 'string', 'max:255'],
            'article' => ['required', 'string', 'max:255'],
            'manufacturer' => ['required', 'string', 'max:255'],
        ];
    }
}
