<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewDetail extends Model
{
    use HasFactory;

    protected $table = 'interview_details';

    protected $fillable = [
        'enrollment_id',
        'q1_answer',
        'q2_answer',
        'q3_answer',
        'q4_answer',
        'q5_answer',
        'theory_level',
        'recitation_level',
        'hifz_level',
        'decision',
        'interview_date',
        'sheikh_1',
        'sheikh_2',
        'notes',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }
}
