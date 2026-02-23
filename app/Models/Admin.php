<?php

namespace App\Models;

// نستخدم هذه الكلاسات لتمكين الأدمن من تسجيل الدخول (لو أردت ذلك لاحقاً)
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';

    /**
     * الحقول المسموح بتعبئتها (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'gender',
        'status',
        'url',
    ];

    /**
     * الحقول المخفية (مثل كلمة المرور عند جلب البيانات)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // --- العلاقات (Relationships) ---

    /**
     * الحصول على كافة طلبات التسجيل التي يشرف عليها هذا الإداري
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'admin_id');
    }

    /**
     * الحصول على كافة سجلات المتابعة التي كتبها هذا الإداري
     */
    public function logs(): HasMany
    {
        return $this->hasMany(EnrollmentLog::class, 'admin_id');
    }
}
