<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentMark extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['student_id', 'subject_id', 'term', 'marks'];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id', 'id');
    }
}
