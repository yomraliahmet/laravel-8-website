<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;

class Request extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (!$this->ajax() && !$this->wantsJson()) {
            parent::failedValidation($validator);
        }

        $errors = $validator->errors()->getMessages();
        $error = Arr::first($errors);
        $errorMessage = Arr::first($error);

        $error = [
            'code'    => 'validation',
            'title'   => trans('errors.common.error_title'),
            'message' => $errorMessage,
            'data' => $errors
        ];

        $response = response()->json($error, 400);

        throw new HttpResponseException($response);
    }
}
