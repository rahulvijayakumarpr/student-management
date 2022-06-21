<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentPostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'stud-name' => 'required|max:130',
            'stud-age' => 'required',
            'stud-gender' => 'required',
            'stud-report-teach' => 'required|exists:teachers,id',
        ];
    }

    public function messages()
    {
        return [
            'stud-name.required' => 'Name is required',
            'stud-age.required' => 'Age is required',
            'stud-gender.required' => 'Gender is required',
            'stud-report-teach.required' => 'Teacher is required',
        ];
    }
}
