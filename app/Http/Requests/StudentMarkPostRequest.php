<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentMarkPostRequest extends FormRequest
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
            'mark-stud' => 'required|max:130',
            'mark-term' => 'required',
            'math' => 'required|numeric',
            'sci' => 'required|numeric',
            'hist' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'mark-stud.required' => 'Student is required',
            'mark-term.required' => 'Term is required',
            'math.required' => 'Math marks is required',
            'sci.required' => 'Science marks is required',
            'hist.required' => 'History marks is required',
        ];
    }
}
