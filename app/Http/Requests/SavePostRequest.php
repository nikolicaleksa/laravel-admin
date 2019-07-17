<?php

namespace App\Http\Requests;

use App\Post;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SavePostRequest extends FormRequest
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
        $publishOptionsValues = implode(',', Post::PUBLISH_OPTIONS);

        return [
            'title' => 'required|string|max:80',
            'description' => 'required|string|max:160',
            'keywords' => 'required|string|max:80',
            'content' => 'required|string',
            //'image' => 'required|image',
            'category_id' => 'required|integer|exists:categories,id',
            'publish_option' => 'required|string|in:' . $publishOptionsValues,
            'published_at' => 'required_if:publish_option,schedule|nullable|string'
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
