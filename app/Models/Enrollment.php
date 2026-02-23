<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'admin_id', 'is_certified', 'certification_type',
        'current_reading_name', 'certification_file', 'jazariya_cert',
        'asool_cert', 'requested_path_type', 'requested_path_name',
        'status', 'progress_checkpoint', 'moshafaha_file', 'moshafaha', 'surah_index', 'surah_name', 'ayah_number', 'page_number', 'teacher_decision', 'admin_confirmed', 'ejazah_start', 'ejazah_end', 'admin_notes', 'stage_checkpoint',
    ];

    // الوصول لبيانات الطالب صاحب هذا الطلب
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teacher()
    {
        // ربط الحقل admin_id بجدول admin لجلب بيانات الشيخ
        return $this->belongsTo(\App\Models\Admin::class, 'admin_id');
    }

    // الوصول لبيانات المسؤول المشرف
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function interview()
    {
        return $this->hasOne(InterviewDetail::class, 'enrollment_id');
    }

    // الوصول لجميع سجلات التغيير التي حدثت لهذا الطلب
    public function logs()
    {
        return $this->hasMany(EnrollmentLog::class);
    }
}
