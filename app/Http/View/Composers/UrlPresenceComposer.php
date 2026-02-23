<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UrlPresenceComposer
{
    /**
     * ربط البيانات بالـ view.
     */
    public function compose(View $view)
    {
        $teacherUrl = null; // القيمة الافتراضية

        // 1. التحقق من تسجيل الدخول
        if (Auth::check()) {
            $teacherId = Auth::id();
            $tableName = Config::get('constants.tables.TBL_TEACHERS');

            // 2. استرداد قيمة عمود 'url' فقط لسجل المعلم الحالي
            $record = DB::table($tableName)
                ->where('id', $teacherId)
                ->select('url')
                ->first();

            // 3. تخزين قيمة الرابط إذا كانت موجودة وغير فارغة
            if ($record && ! empty($record->url)) {
                $teacherUrl = $record->url;
            }
        }

        // 4. إرسال الرابط (أو null) إلى الـ view باسم 'teacherUrl'
        $view->with('teacherUrl', $teacherUrl);
    }
}
