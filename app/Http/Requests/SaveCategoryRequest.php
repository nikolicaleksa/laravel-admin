<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SaveCategoryRequest extends FormRequest
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
        $categoryId = null;
        $category = $this->route('category', null);

        if ($category) {
            $categoryId = $category->id;
        }

        return [
            'name' => 'required|string|max:64|unique:categories,name,' . $categoryId,
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
