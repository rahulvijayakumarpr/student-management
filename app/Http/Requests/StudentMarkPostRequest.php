<?php

namespace App\Http\Requests;

use App\Models\StudentMark;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StudentMarkPostRequest extends StudentMarkPatchRequest
{
    public function withValidator(Validator $validator) {
        $stid = request('mark-stud');
        $term = request('mark-term');
        $markSize = sizeof(StudentMark::where('student_id',$stid)->where('term', $term)->get());
        $validator->after(function ($validator) use ($markSize) {
            if ($markSize > 0) {
                $validator->errors()->add('mark-term',
                    'Mark for this term already added');
            }
        });

    }
}
