<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // حالات الطلاب النشطين (قيد الدراسة)
        $activeDecisions = ['qualified', 'refer_to_teacher', 'review_theory'];

        // 1. إحصائيات الطلاب (ذكور وإناث)
        $stats['male_students'] = User::where('gender', 'male')->count();
        $stats['female_students'] = User::where('gender', 'female')->count();

        // 2. الطلاب قيد الدراسة (نشط ولم يتم الإجازة)
        $stats['in_progress'] = Enrollment::where('is_certified', 0)
            ->whereIn('teacher_decision', $activeDecisions)
            ->count();

        // 3. الطلاب الجدد وغير المؤهلين
        $stats['new_students'] = Enrollment::where('status', 'new')->count();
        $stats['not_qualified'] = Enrollment::where('teacher_decision', 'not_qualified')->count();

        // 4. الطلاب الذين أتموا الدراسة (المجازون)
        $stats['completed'] = Enrollment::where('is_certified', 1)->count();

        // 5. عدد المعلمين (ذكور وإناث) من جدول admin
        $stats['male_teachers'] = DB::table('admin')->where('level', 'teacher')->where('gender', 'M')->count();
        $stats['female_teachers'] = DB::table('admin')->where('level', 'teacher')->where('gender', 'F')->count();

        // 6. عدد الطلاب في كل إجازة ورواية
        $stats['by_path'] = Enrollment::select('requested_path_name', DB::raw('count(*) as total'))
            ->whereNotNull('requested_path_name')
            ->groupBy('requested_path_name')
            ->get();

        // 7. عدد الدول التي ينتمي لها طلاب الإجازة
        $stats['countries_count'] = User::whereHas('enrollments')
            ->distinct('country')
            ->count('country');

        // 8. إجمالي عدد الدورات
        $stats['courses_count'] = DB::table('courses')->count();

        return view('statistics.index', compact('stats'));
    }
}
