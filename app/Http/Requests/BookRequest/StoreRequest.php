<?php

namespace App\Http\Requests\BookRequest;

use App\Models\user;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    protected $stopOnFirstFailure=true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:50|unique:books',
            'author' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:30|max:255',
            'category' => 'required|string|min:2|max:25',
            'published_at' => 'required|date|after_or_equal:1900-01-01|before_or_equal:today',
        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        throw new HttpResponseException(response()->json(
            [
                'status' => "error",
                'message' => "404",
                'errors' => $validator->errors()
            ]));
    }
    public function messages(){
        return [
            'unique' => ":attribute is used "
        ];
    }
}
