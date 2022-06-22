<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentPostRequest;
use App\Models\Student;
use App\Models\StudentMark;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = Student::with('reportingTeacher')->get();
        $teachers = Teacher::all();

        return view('student.list', compact('students', 'teachers'));
    }

    public function get($id)
    {
        return Student::find($id);
    }

    public function delete($id)
    {
        try{
            $delElStd = Student::destroy($id);
            $delElMrk = StudentMark::where('student_id', $id)
                ->delete();
            if ($delElStd) {
                return json_encode(["success" => true]);
            } else {
                return json_encode(["success" => false]);
            }
        } catch (\Exception $e) {
            return json_encode(["success" => false]);
        }


    }

    public function save(StudentPostRequest $request)
    {
        Student::updateOrCreate(['id' => $request->id], [
            'name' => $request['stud-name'],
            'age' => $request['stud-age'],
            'gender' => $request['stud-gender'],
            'reporting_teacher_id' => $request['stud-report-teach']
        ]);
        return json_encode(["success" => true]);
    }
}
