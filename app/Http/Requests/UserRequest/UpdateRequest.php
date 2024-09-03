<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|min:3|max:25',
            'email' => 'string|email|max:55|unique:users',
            'password' => 'string|min:8',
            'role' => 'IN:user,admin',
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
}
