<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use App\Models\Admin;
use App\Models\Reading;
use App\Models\Narration;
use App\Models\Country;

class EnrollmentController extends Controller
{

public function cpass()
{
    //
}



public function index(Request $request) 
{
    $user = Auth::user();
    $isAdmin = in_array($user->level, ['admin', 'mod']);
    $userId = $user->id;

    $countriesMap  = Country::pluck('country', 'id')->toArray();
    $teachers      = Admin::where('level', 'teacher')->where('status', 'yes')->get();
    
    $allReadings   = Reading::where('status', 'yes')->get();
    $allNarrations = Narration::where('status', 'yes')->get();

    // بناء خيارات البحث (الأيقونات)
    $searchOptions = [];
    foreach($allReadings as $r) {
        $searchOptions[] = ['label' => '📖 ' . $r->name, 'value' => $r->name];
    }
    foreach($allNarrations as $n) {
        $searchOptions[] = ['label' => '🗣️ ' . $n->name, 'value' => $n->name];
    }

    // 2. منطق تحديد الجنس (Gender) بناءً على جدول admin
    $targetGender = null;
    if (!$isAdmin) {
        // في جدول admin العمود هو gender والقيم M/F
        $targetGender = $user->gender; 
    }

    $query = Enrollment::with(['user', 'teacher', 'interview']);

    // تطبيق فلتر استبعاد المشافهة
    $query->where(function($q) {
        $q->where('moshafaha', '!=', 'yes')->orWhereNull('moshafaha_file');
    });

    $query->when($request->teacher_id, fn($q) => $q->where('admin_id', $request->teacher_id))
          ->when($request->gender ?: $targetGender, function($q) use ($request, $targetGender) {
              $gender = $request->gender ?: $targetGender;
              return $q->whereHas('user', fn($u) => $u->where('gender', $gender));
          })
          ->when($request->reading, function($q) use ($request) {
              // البحث في اسم المسار المطلوب
              return $q->where('requested_path_name', 'like', "%{$request->reading}%");
          })
          ->when($request->country_id, function($q) use ($request) {
              // العمود في جدول users هو country ويخزن ID
              return $q->whereHas('user', fn($u) => $u->where('country', $request->country_id));
          })
          ->when($request->nationality_id, function($q) use ($request) {
              // العمود في جدول users هو nationality ويخزن ID
              return $q->whereHas('user', fn($u) => $u->where('nationality', $request->nationality_id));
          });

    // إذا كان المستخدم معلماً، يرى فقط الطلاب المسندين إليه
    if (!$isAdmin) {
        $query->where('admin_id', $userId);
    }

    $items = $query->latest()->get();

    // توزيع البيانات على التبويبات (Tabs)
    $activeDecisions = ['qualified', 'refer_to_teacher'];

    $data = [
        'items'              => $items,
        'newRequests'        => $isAdmin ? $items->where('status', 'new')->whereNull('admin_id') : collect(),
        'pendingInterview'   => $items->where('status', 'pending_interview'),
        'activeInEjaza'      => $items->whereIn('teacher_decision', $activeDecisions)
                                      ->whereNotNull('admin_id')
                                      ->where('status', '!=', 'mushafaha'),
        'notQualified'       => $items->filter(fn($i) => in_array($i->teacher_decision, ['not_qualified', 'reject']) || $i->status == 'rejected'),
        'inMushafahaProcess' => $items->where('status', 'mushafaha_process'),
        'completedMushafaha' => $items->where('moshafaha', 'yes')->whereNotNull('moshafaha_file'),
        'teachers'           => $teachers,
        'countriesMap'       => $countriesMap,
        'allReadings'        => $allReadings,
        'allNarrations'      => $allNarrations,
        'isAdmin'            => $isAdmin,
        'targetGender'       => $targetGender,
        'searchOptions'      => $searchOptions
    ];

    return view('qeraat.ejaza.enrollments.index', $data);
}

public function updateReading(Request $request)
{
    if (Auth::user()->level !== 'admin') {
        return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
    }

    try {
        $enrollment = Enrollment::findOrFail($request->id);
        
        $enrollment->requested_path_name = $request->reading_name;
        $enrollment->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث المسار بنجاح'
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}



    /**
     * معالجة قرار المدير (تحويل للشيخ أو رفض)
     */
public function processDecision(Request $request, $id)
{
    $enrollment = Enrollment::findOrFail($id);
    $decision = $request->input('decision_type');

    $request->validate([
        'decision_type' => 'required|in:approve,reject',
        'admin_id' => ($decision == 'reject') ? 'nullable' : 'required|exists:admin,id',
    ]);

    if ($decision == 'reject') {
        $enrollment->update([
            'status' => 'rejected', 
            'admin_id' => null
        ]);
        Alert::success('تم الرفض', 'تم رفض الطلب بنجاح');
    } else {
        // حالة approve
        $enrollment->update([
            'status' => 'pending_interview',
            'admin_id' => $request->admin_id
        ]);
        Alert::success('تم التحويل', 'تم تحويل الطلب للشيخ بنجاح');
    }

    return redirect()->back();
} 
 
    
/*Admin accept*/    
    public function processDecisionAdmin(Request $request, $id)
    {
        $request->validate([
            'decision_type' => 'required', 
            'admin_id' => 'required_if:decision_type,approve'
        ]);
        
        $enrollment = Enrollment::findOrFail($id);

        if ($request->decision_type == 'approve') {
            $enrollment->update([
                'admin_id' => $request->admin_id, 
                'status' => 'in_progress'
            ]);
            Alert::success('نجاح', 'تم تحويل الطالب للشيخ بنجاح');
        } else {
            $enrollment->update([
                'status' => 'rejected', 
                'teacher_decision' => 'not_qualified'
            ]);
            Alert::error('تنبيه', 'تم استبعاد الطلب من قبل الإدارة');
        }
        return redirect()->back();
    }    

    /**
     * حفظ نتيجة مقابلة الشيخ (متوافق مع جدول interview_details)
     */
    public function saveInterview(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        
        $request->validate([
            'decision' => 'required|in:qualified,refer_to_teacher,review_theory,not_qualified',
            'interview_date' => 'required|date',
            'theory_level' => 'required|in:excellent,good,weak',
            'recitation_level' => 'required|in:excellent,good,weak',
            'hifz_level' => 'required|in:excellent,good,weak',
        ]);

        $idetails = DB::table('interview_details')->updateOrInsert(
            ['enrollment_id' => $id],
            [
                'q1_answer' => $request->q1_answer, 
                'q2_answer' => $request->q2_answer,
                'q3_answer' => $request->q3_answer,
                'q4_answer' => $request->q4_answer,
                'q5_answer' => $request->q5_answer,
                'theory_level' => $request->theory_level,
                'recitation_level' => $request->recitation_level,
                'hifz_level' => $request->hifz_level,
                'decision' => $request->decision,
                'notes' => $request->notes, 
                'interview_date' => $request->interview_date, 
                'sheikh_1' => Auth::user()->name, 
                'sheikh_2' => $request->sheikh_2,
                'updated_at' => now(),
                'created_at' => now(),                
            ]
        );

        $isQualified = in_array($request->decision, ['qualified', 'refer_to_teacher', 'review_theory']);

$enrollment->update([
        'teacher_decision' => $request->decision,
        'admin_id'         => null, 
        'status'           => 'pending_interview',
        'stage_checkpoint' => 'initial_interview' 
    ]);

        if ($request->decision == 'not_qualified' OR $request->decision == 'review_theory') {
            Alert::info('تم التقييم', 'تم تحويل الطالب إلى قائمة غير المؤهلين');
        } else {
            Alert::success('تم الحفظ', 'تم اعتماد نتيجة المقابلة وتحديث حالة الطالب');
        }

        return redirect()->back();
    }

    /**
     * تحديث القرار النهائي للطالب بعد مرحلة المراجعة أو تعديل الملاحظات
     */
    public function updateFinalDecision(Request $request, $id)
    {
        $request->validate([
            'final_decision' => 'required|in:qualified,not_qualified'
        ]);

        $enrollment = Enrollment::findOrFail($id);

        $enrollment->update([
            'teacher_decision' => $request->final_decision,
            // إذا أصبح مؤهلاً تظل الحالة قيد التنفيذ، إذا لم يتأهل يغلق الطلب
            'status' => ($request->final_decision == 'qualified') ? 'in_progress' : 'completed'
        ]);

        // تحديث القرار أيضاً في جدول تفاصيل المقابلة للمزامنة
        DB::table('interview_details')
            ->where('enrollment_id', $id)
            ->update([
                'decision' => $request->final_decision,
                'updated_at' => now()
            ]);

        if ($request->final_decision == 'qualified') {
            Alert::success('تم التحديث', 'تهانينا، تم قبول الطالب في مسار الإجازة');
        } else {
            Alert::info('تم التحديث', 'تم استبعاد الطالب بناءً على التقييم الأخير');
        }

        return redirect()->back();
    }

    protected function getQuranPage($sura, $ayah)
    {
        foreach (config('allquranPages.pages') as $page => $range) {

            $start = $range['start'];
            $end   = $range['end'];

            if (
                ($sura > $start['sura'] || ($sura == $start['sura'] && $ayah >= $start['ayah'])) &&
                ($sura < $end['sura']   || ($sura == $end['sura']   && $ayah <= $end['ayah']))
            ) {
                return $page;
            }
        }

        return null;
    }
public function saveHifz(Request $r)
{
    $r->validate([
        'student_id'  => 'required|integer', 
        'surah_index' => 'required|integer|min:0|max:113', 
        'surah_name'  => 'required|string',
        'ayah_number' => 'required|integer|min:1',
    ]);

    try {
        $studentId = $r->student_id;
        $surahIndex = (int)$r->surah_index;
        $surahNumber = $surahIndex + 1; 
        $surahName = $r->surah_name;
        $ayahNumber = (int)$r->ayah_number;
        
        $enrollment = Enrollment::findOrFail($studentId);
        $pageNumber = $this->getQuranPage($surahNumber, $ayahNumber);

        // الحفاظ على منطق الحالات السابق
        $progress = $enrollment->progress_checkpoint;
        $status   = $enrollment->status;
        
        if ($surahIndex == 113) {
            $progress = 'completed';
            $status   = 'qualified_for_license';
        } elseif ($surahIndex >= 76 AND $surahIndex <= 112) {
            $progress = 'mursalat';
            $status   = 'mushafaha';
        } elseif ($surahIndex >= 17 AND $surahIndex <= 75) {
            $progress = 'kahf';
        }

        // تسجيل في جدول التتبع (الكود السابق)
        try {
            $tableNameTRK = config('constants.tables.TBL_EJAZAHTRK') ?? 'ejazah_tracking'; 
            DB::table($tableNameTRK)->insert([
                'ejazah_id'   => $studentId,
                'page_number' => $pageNumber,
                'created_at'  => now(),
            ]);
        } catch (\Exception $e) {}

        // تجهيز البيانات للتحديث
        $updateData = [
            'surah_index'         => $surahIndex,
            'progress_checkpoint' => $progress,
            'status'              => $status,
            'surah_name'          => $surahName,
            'ayah_number'         => $ayahNumber,
            'page_number'         => $pageNumber,
        ];

        // القيد المطلوب: إضافة تاريخ البدء إذا كانت هذه هي المرة الأولى
        if (empty($enrollment->ejazah_start)) {
            $updateData['ejazah_start'] = now();
        }

        $enrollment->update($updateData);

        return response()->json([
            'success'          => true,
            'message'          => 'تم التحديث بنجاح',
            'surah_name'       => $surahName,
            'ayah_number'      => $ayahNumber,
            'hifz_status_prog' => ($progress == 'mursalat') ? 'مشافهة' : 'في الدراسة',
            'page_number'      => $pageNumber 
        ]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    /**
     * حفظ نتيجة المقابلة الثانية (عند سورة الكهف)
     */

public function saveSecondInterview(Request $request, $id)
{
    // 1. التحقق من البيانات (تأكد من مطابقة أسماء الحقول مع المودال)
    $request->validate([
        'decision' => 'required|in:qualified,refer_to_teacher,not_qualified',
        'notes' => 'nullable|string|max:1000', // غيرنا الاسم من teacher_notes إلى notes حسب الكود الأخير
    ]);

    $enrollment = Enrollment::findOrFail($id);

    // 2. تحديث القرار والملاحظات
    $enrollment->teacher_decision = $request->decision;
    
    // حفظ الملاحظات في قاعدة البيانات (تأكد أن الحقل موجود في جدول enrollments)
    if ($request->has('notes')) {
        $enrollment->s2admin_notes = $request->notes; // أو الحقل المخصص للملاحظات لديك
    }

    // 3. التحكم في سير العمل (Workflow) بناءً على القرار
    switch ($request->decision) {
        case 'qualified':
            // الحالة: الاستمرار في قراءة الإجازة
            $enrollment->progress_checkpoint = 'kahf';
            $successMsg = 'تم قبول الطالب بنجاح ونقله لمرحلة القراءة.';
            break;

        case 'refer_to_teacher':
            // الحالة: يوجه الشيخ مع الاستمرار (يبقى في مكانه لكن بقرار محدث)
            $successMsg = 'تم تسجيل ملاحظات التوجيه للشيخ بنجاح.';
            break;

        case 'not_qualified':
            // الحالة: التوقف عن القراءة
            // يمكنك هنا تغيير الـ checkpoint أو تركه كما هو مع حالة "غير مؤهل"
            $successMsg = 'تم تسجيل قرار إيقاف الطالب عن قراءة الإجازة.';
            break;

        default:
            $successMsg = 'تم تحديث حالة المقابلة الثانية.';
            break;
    }
    $enrollment->stage_checkpoint = 'second_interview';

    $enrollment->save();
    Alert::success('تم التحديث', 'تهانينا ',$successMsg);
    return redirect()->back();
}	
	
/**
     * رفع ملف المشافهة عبر AJAX للمدير فقط
     */
public function uploadMoshafahaFile(Request $request, $id)
{
    $request->validate([
        'moshafaha_file' => 'required|file|mimes:pdf,jpg,png,jpeg,zip|max:10240',
    ]);

    $enrollment = Enrollment::findOrFail($id);

    if ($enrollment->progress_checkpoint == 'completed' && $enrollment->teacher_decision == 'qualified') {
        if ($request->hasFile('moshafaha_file')) {
            $file = $request->file('moshafaha_file');
            $fileName = 'moshafaha_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $externalPath = config('constants.path.PATH_LOCAL_FILES');
            if (!File::isDirectory($externalPath)) {
                File::makeDirectory($externalPath, 0777, true, true);
            }

            $file->move($externalPath, $fileName);

            // القيد المطلوب: تحديث البيانات وإضافة تاريخ الانتهاء
            $enrollment->update([
                'moshafaha_file' 	  => $fileName,
                'moshafaha'      	  => 'yes',
                'progress_checkpoint' => 'completed',
                'status' 		      => 'completed',
                'ejazah_end'          => now() // تاريخ انتهاء الإجازة
            ]);

            return response()->json([
                'success' => true,
                'file_url' => config('constants.path.PATH_FILES') . $fileName
            ]);
        }
    }
    return response()->json(['success' => false, 'message' => 'الشروط غير مستوفاة'], 400);
}


public function displayMoshafaha($id)
{
    $enrollment = Enrollment::findOrFail($id);
    $path = config('constants.path.PATH_FILES') . $enrollment->moshafaha_file;

    if (!File::exists($path)) {
        abort(404, 'الملف غير موجود في المسار المحدد');
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
}

public function getInterviewResult($id)
{
    // جلب البيانات من جدول المقابلات
    $result = \DB::table('interview_details')->where('enrollment_id', $id)->first();
    
    if (!$result) {
        return response()->json([
            'success' => false, 
            'message' => 'عذراً، لا توجد بيانات مقابلة مسجلة لهذا الطلب.'
        ]);
    }

    // رندر ملف الـ Blade إلى HTML
    $html = view('qeraat.ejaza.enrollments.partials.interview_show', compact('result'))->render();
    
    return response()->json([
        'success' => true, 
        'html' => $html
    ]);
}


public function updateTeacherInline(Request $request)
{
    // تحويل السلسلة الفارغة أو كلمة 'null' إلى قيمة null حقيقية
    if ($request->teacher_id == "" || $request->teacher_id == "null") {
        $request->merge(['teacher_id' => null]);
    }

    if (auth()->user()->level !== 'admin') {
        return response()->json(['success' => false, 'message' => 'عذراً، هذه الصلاحية للمدير فقط'], 403);
    }

    $request->validate([
        'enrollment_id' => 'required|exists:enrollments,id',
        // تأكد أن اسم الجدول هو admin فعلاً وليس admins
        'teacher_id'    => 'nullable|exists:admin,id' 
    ]);

    try {
        \DB::table('enrollments')
            ->where('id', $request->enrollment_id)
            ->update(['admin_id' => $request->teacher_id]);

        return response()->json(['success' => true, 'message' => 'تم تحديث الشيخ بنجاح']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء التحديث'], 500);
    }
}




/*
* تقارير شهرية للمدير عن كل معلم مع الطلاب
*/
public function monthlyReport(Request $request)
{
    $fTeacher = $request->teacher_id;
    $fMonth = $request->month ?: date('m');
    $fYear = $request->year ?: date('Y');

    $pagesFilePath = config_path('allquranPages.php');
    $surahsFilePath = config_path('allquran.php');

    if (!file_exists($pagesFilePath) || !file_exists($surahsFilePath)) {
        return "خطأ: ملفات بيانات القرآن غير موجودة في المجلد config. تأكد من رفعها وتسميتها بشكل صحيح.";
    }

    $pagesData = include($pagesFilePath);
    $quranPages = $pagesData['pages'];
    
    $surahData = include($surahsFilePath);
    $surahs = $surahData['surahs'];

    $teachers = Admin::where('level', 'teacher')->where('status', 'yes')->get();
    $countriesMap = DB::table('countries')->pluck('country', 'id')->toArray();

    $reportData = [];
    if ($fTeacher) {
        $reportData = Enrollment::with(['user'])
            ->where('admin_id', $fTeacher)
            ->get()
            ->map(function($enrollment) use ($fMonth, $fYear, $quranPages, $surahs) {
                
                $logs = DB::table('ejazah_tracking')
                    ->where('ejazah_id', $enrollment->id)
                    ->whereMonth('created_at', $fMonth)
                    ->whereYear('created_at', $fYear)
                    ->get();

                if ($logs->count() > 0) {
                    $uniquePages = $logs->pluck('page_number')->unique();
                    $totalAyahs = 0;

                    foreach ($uniquePages as $pNum) {
                        if (isset($quranPages[$pNum])) {
                            $start = $quranPages[$pNum]['start'];
                            $end = $quranPages[$pNum]['end'];

                            if ($start['sura'] == $end['sura']) {
                                $totalAyahs += ($end['ayah'] - $start['ayah'] + 1);
                            } else {
                                // حساب الآيات إذا كانت الصفحة مشتركة بين سورتين
                                $firstSurahId = $start['sura'];
                                $firstSurahAyahs = $surahs[$firstSurahId - 1]['ayahs'];
                                $totalAyahs += ($firstSurahAyahs - $start['ayah'] + 1) + $end['ayah'];
                            }
                        }
                    }

                    $enrollment->monthly_pages = $uniquePages->count();
                    $enrollment->monthly_ayahs = $totalAyahs;
                    $enrollment->is_active = true;

                    $lastLog = $logs->sortByDesc('created_at')->first();
                    $lastPage = $lastLog->page_number;
                    if(isset($quranPages[$lastPage])){
                        $sId = $quranPages[$lastPage]['end']['sura'];
                        $enrollment->current_surah = $surahs[$sId - 1]['name'];
                        $enrollment->current_ayah = $quranPages[$lastPage]['end']['ayah'];
                    }
                } else {
                    $enrollment->monthly_pages = 0;
                    $enrollment->monthly_ayahs = 0;
                    $enrollment->is_active = false;
                    $enrollment->current_surah = $enrollment->surah_name;
                    $enrollment->current_ayah = $enrollment->ayah_number;
                }

                return $enrollment;
            });
    }

    return view('qeraat.ejaza.enrollments.monthly', compact('teachers', 'reportData', 'fTeacher', 'fMonth', 'fYear', 'countriesMap'));
}

	
}