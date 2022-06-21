<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['name', 'age', 'gender', 'reporting_teacher_id'];

    public function reportingTeacher()
    {
        return $this->belongsTo(Teacher::class,'reporting_teacher_id', 'id');
    }
}
