<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentMarkPatchRequest;
use App\Http\Requests\StudentMarkPostRequest;
use App\Models\Student;
use App\Models\StudentMark;
use Carbon\Carbon;

class StudentMarkController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $marks = StudentMark::select('student_id', 'term')
            ->selectRaw("group_concat(subject_id,'-',marks) as markArr")
            ->selectRaw('sum(marks) as total')
            ->selectRaw('min(created_at) as created_at')
            ->with('student')
            ->groupBy('term', 'student_id')
            ->get();

        $dispArr = $this->prepareArr($marks);
        return view('marks.list', compact('dispArr', 'students'));
    }

    public function save(StudentMarkPostRequest $request)
    {
        return $this->insert($request);
    }

    public function update(StudentMarkPatchRequest $request)
    {
        return $this->insert($request);
    }

    public function insert($request) {
        $mArr = [];
        $subjectCount = 3;
        $mArr['student_id'] = $request["mark-stud"];
        $mArr['term'] =  $request["mark-term"];
        $marks[] = $request['math'];
        $marks[] = $request['sci'];
        $marks[] = $request['hist'];
        for($i = 1; $i<=$subjectCount; $i++) {
            $mArr['subject_id'] = $i;
            $mArr['marks'] = $marks[$i-1];
            StudentMark::updateOrCreate(
                [
                    'student_id' => $request["mark-stud"],
                    'subject_id' => $i,
                    'term' => $request["mark-term"],
                ],$mArr);
        }
        return json_encode(["success" => true]);
    }

    public function get($student_id, $term)
    {
        $marks = StudentMark::select('student_id', 'term')
            ->selectRaw("group_concat(subject_id,'-',marks) as markArr")
            ->selectRaw('sum(marks) as total')
            ->selectRaw('min(created_at) as created_at')
            ->with('student')
            ->groupBy('term', 'student_id')
            ->having('student_id', $student_id)
            ->having('term', $term)
            ->get();

        $dispArr = $this->prepareArr($marks);
        return $dispArr[0];

    }

    public function prepareArr($marks){
        $dispArr = [];
        foreach ($marks as $key => $termStd) {
            $markArr = explode(',',$marks[$key]->markArr);
            $dispTempArr = [];
            $dispTempArr['id'] = $key+1;
            $dispTempArr['stud_id'] = $termStd->student->id;
            $dispTempArr['term_id'] = $termStd->term;
            $dispTempArr['name'] = $termStd->student->name;
            $dispTempArr['math'] =  substr($markArr[0], strpos($markArr[0], "-") + 1);
            $dispTempArr['science'] =  substr($markArr[1], strpos($markArr[1], "-") + 1);
            $dispTempArr['history'] =  substr($markArr[2], strpos($markArr[2], "-") + 1);
            $dispTempArr['term'] = ucfirst($termStd->term);
            $dispTempArr['created'] = Carbon::parse($termStd->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a');
            $dispTempArr['total'] = $termStd->total;
            $dispArr[] = $dispTempArr;
        }
        return $dispArr;
    }

    public function delete($student_id,$term)
    {
        $delEl = StudentMark::where('student_id', $student_id)
            ->where('term', $term)
            ->delete();
        if ($delEl) {
            return json_encode(["success" => true]);
        } else {
            return json_encode(["success" => false]);
        }

    }

}
