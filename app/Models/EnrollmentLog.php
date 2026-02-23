<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentLog extends Model
{
    use HasFactory;

    protected $table = 'enrollment_logs';

    protected $fillable = [
        'enrollment_id',
        'user_id',      // يجب أن يكون موجوداً هنا
        'action_status',
        'notes',
    ];

    // السجل يتبع لطلب تسجيل معين
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // من المسؤول الذي كتب هذا السجل؟
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
