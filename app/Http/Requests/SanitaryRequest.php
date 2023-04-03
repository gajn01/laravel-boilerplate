<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SanitaryRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {  return [
            'title' => 'required',
            'code' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'code.required' => 'The code field is required.',
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'title' => strip_tags($this->title),
            'code' => strip_tags($this->code),
        ]);
    }
}
