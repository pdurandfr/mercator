<?php

namespace App\Http\Requests;

use App\Application;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateApplicationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('application_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'          => [
                'min:3',
                'required',
            ],
            'entities.*'    => [
                'integer',
            ],
            'entities'      => [
                'array',
            ],
            'responsible'   => [
                'min:3',
            ],
            'security_need' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}