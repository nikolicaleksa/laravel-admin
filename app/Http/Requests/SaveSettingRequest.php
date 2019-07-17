<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SaveSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required_if:type,general|string|max:80',
            'title_short' => 'required_if:type,general|string|max:32',
            'description' => 'required_if:type,general|string|max:160',
            'keywords' => 'required_if:type,general|string|max:80',
            'google_verification_code' => 'sometimes|nullable|string',
            'bing_verification_code' => 'sometimes|nullable|string',
            'yandex_verification_code' => 'sometimes|nullable|string',
            'google_analytics' => 'sometimes|nullable|string',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'response' => trans('messages.invalid.form'),
            'messages' => $validator->errors(),
        ]);

        throw (new ValidationException($validator, $response));
    }
}
