<?php

use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
/*use App\Http\Controllers\HomeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;*/

use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*Route::get('/clear-all-ammar', function() {
    Artisan::call('optimize:clear');
    return "تم مسح كافة الملفات المؤقتة بنجاح!";
});*/

// مسارات إدارة المشرفين
Route::middleware(['auth'])->group(function () {
    // مسارات إدارة المشرفين
    Route::prefix('moderators-management')->group(function () {
        Route::get('/', [UserController::class, 'modIndex'])->name('mods.index');
        Route::post('/save', [UserController::class, 'modSave'])->name('mods.ajax.save');
        Route::get('/edit/{id}', [UserController::class, 'modEdit'])->name('mods.ajax.edit');
        Route::delete('/delete/{id}', [UserController::class, 'modDestroy'])->name('mods.ajax.delete');

        Route::post('/toggle-status/{id}', [UserController::class, 'toggleModStatus'])->name('mods.toggle');

    });

});

// مسار عرض المقابلة
Route::get('/admin/interview-result/{id}', [EnrollmentController::class, 'getInterviewResult'])->name('admin.interview.result');

// مسار مستقل لتغيير الشيخ للمدير فقط
Route::post('/enrollments/update-teacher', [EnrollmentController::class, 'updateTeacherInline'])
    ->name('enrollments.update-teacher')
    ->middleware('auth');

// مسار التقرير الشهري لشيوخ الإقراء
Route::get('/enrollments/monthly-report', [EnrollmentController::class, 'monthlyReport'])->name('enrollments.monthly_report');

// مسارات إدارة المستخدمين
Route::middleware(['auth'])->group(function () {
    // الصفحة الرئيسية لإدارة المستخدمين
    Route::get('users-management', [UserController::class, 'index'])->name('users.index');

    Route::post('/ejaza/enrollments/update-reading', [EnrollmentController::class, 'updateReading'])
            ->name('ejaza.enrollments.updateReading');

    // مسارات AJAX (CRUD)
    Route::prefix('api/users')->group(function () {
        Route::get('/fetch', [UserController::class, 'fetch'])->name('users.ajax.fetch');
        Route::post('/save', [UserController::class, 'save'])->name('users.ajax.save');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.ajax.delete');
    });
});

// مسارات نظام الإجازة - محمية بكلمة مرور (Middleware Auth)
Route::group(['prefix' => 'ejazah', 'middleware' => ['auth']], function () {

    // 1. عرض الصفحة الرئيسية لإدارة الطلبات (التبويبات)
    Route::get('/manage-enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');

    // 2. معالجة قرار المدير الأولي (قبول مبدئي أو رفض)
    Route::post('/process-decision/{id}', [EnrollmentController::class, 'processDecision'])->name('enrollments.process-decision');
    Route::post('/process-decision-approve/{id}', [EnrollmentController::class, 'processDecisionAdmin'])->name('enrollments.process-decision-approve');

    // 3. حفظ نتيجة المقابلة الأولى (بداية المسار)
    Route::post('/save-interview/{id}', [EnrollmentController::class, 'saveInterview'])->name('enrollments.save-interview');

    // 4. حفظ نتيجة المقابلة الثانية (تظهر عند سورة الكهف)
    Route::post('/save-second-interview/{id}', [EnrollmentController::class, 'saveSecondInterview'])->name('enrollments.save-second-interview');

    // 5. تحديث القرار الفني النهائي (مؤهل، غير مؤهل، مراجعة نظري)
    Route::post('/update-final-decision/{id}', [EnrollmentController::class, 'updateFinalDecision'])->name('enrollments.update-final-decision');

    // 6. حفظ تقدم الطالب (السورة والآية) عبر AJAX
    Route::post('/save-student-hifz', [EnrollmentController::class, 'saveHifz'])->name('hifz.save');

    // مسار الرفع (AJAX)
    Route::post('/enrollments/upload-moshafaha/{id}', [EnrollmentController::class, 'uploadMoshafahaFile'])->name('enrollments.uploadMoshafaha');

    // مسار العرض (للملفات خارج الـ public)
    Route::get('/enrollments/display-moshafaha/{id}', [EnrollmentController::class, 'displayMoshafaha'])->name('enrollments.display-moshafaha');
});

Route::get('/ejazah/teachers-report', [EnrollmentController::class, 'teacherReport'])->name('enrollments.teacher-report')->middleware('auth');

Route::get('/general-statistics', [StatisticsController::class, 'index'])->name('stats.index')->middleware('auth');

Auth::routes();
Route::get('/admin/get-encrypt-pass', [EnrollmentController::class, 'cpass'])->name('admin.get.encrypt.pass')->middleware('auth');

/*
Route::get('/clear-cache', function() {
     Artisan::call('optimize:clear');
     Artisan::call('config:clear');
     Artisan::call('cache:clear');
     Artisan::call('route:clear');
      return "Cache cleared successfully";
    // return what you want
});*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [HomeController::class, 'index'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
Route::get('/stats', [HomeController::class, 'stats'])->name('stats');
Route::post('/stats', [HomeController::class, 'pstats'])->name('stats');
Route::get('/main-content', [HomeController::class, 'mcontnt'])->name('mcontnt');
Route::post('/main-content', [HomeController::class, 'pmcontnt'])->name('mcontnt');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'pcontact'])->name('contact');

// Teachers
Route::get('/teachers', [HomeController::class, 'teachers'])->name('teachers');
Route::get('/teachers/new', [HomeController::class, 'newteachers'])->name('teachers.new');
Route::get('/teachers/store/new', [HomeController::class, 'teachers'])->name('teachers.store');
Route::post('/teachers/store/new', [HomeController::class, 'storeteachers'])->name('teachers.store');
Route::get('/teachers/update/{id}', [HomeController::class, 'teachers'])->name('teachers.update');
Route::get('/teachers/show/{id}', [HomeController::class, 'showteachers'])->name('teachers.show');
Route::post('/teachers/update/{id}', [HomeController::class, 'updateteachers'])->name('teachers.update');
Route::get('/teachers/destroy/{id}', [HomeController::class, 'destroyteachers'])->name('teachers.destroy');

// Sections
Route::get('/sections', [HomeController::class, 'sections'])->name('sections');
Route::get('/sections/new', [HomeController::class, 'newsections'])->name('sections.new');
Route::get('/sections/store/new', [HomeController::class, 'sections'])->name('sections.store');
Route::post('/sections/store/new', [HomeController::class, 'storesections'])->name('sections.store');
Route::get('/sections/update/{id}', [HomeController::class, 'sections'])->name('sections.update');
Route::get('/sections/show/{id}', [HomeController::class, 'showsections'])->name('sections.show');
Route::post('/sections/update/{id}', [HomeController::class, 'updatesections'])->name('sections.update');
Route::get('/sections/destroy/{id}', [HomeController::class, 'destroysections'])->name('sections.destroy');

Route::group(['prefix' => 'course'], function () {

    // Requests
    Route::get('/appliers/new', [HomeController::class, 'courseNewAppliers'])->name('course.new.users');
    Route::get('/appliers/accept', [HomeController::class, 'courseAppliers'])->name('course.users');
    Route::get('/appliers/reject', [HomeController::class, 'courseRejectAppliers'])->name('course.not.users');

    // Shaikh students
    Route::get('/shaikh/users', [HomeController::class, 'coshyusers'])->name('course.shaikh.users');
    Route::get('/shaikh/yes/users', [HomeController::class, 'coshyyesusers'])->name('course.yes.shaikh.users');
    Route::get('/shaikh/not/users', [HomeController::class, 'coshynousers'])->name('course.not.shaikh.users');

    Route::get('/shaikh/new', [HomeController::class, 'coshynew'])->name('course.shaikh.new');
    Route::get('/shaikh/active', [HomeController::class, 'coshyactive'])->name('course.shaikh.active');
    Route::get('/shaikh/completed', [HomeController::class, 'coshycompleted'])->name('course.shaikh.completed');
    Route::get('/shaikh/completed/users/{id}', [HomeController::class, 'coshypcompletedusers'])->name('course.shaikh.completed.users');

    // Course completed degrees
    Route::get('/shaikh/completed/degree/{id}', [HomeController::class, 'coshypcompletedusers'])->name('course.shaikh.user.completed.degree');
    Route::post('/shaikh/completed/degree/{id}', [HomeController::class, 'coshyusercompletedgree'])->name('course.shaikh.user.completed.degree');

    Route::get('/shaikh/activate/{id}', [HomeController::class, 'coshyactivate'])->name('course.shaikh.activate');
    Route::get('/shaikh/presents/{id}', [HomeController::class, 'coshypresents'])->name('course.shaikh.presents');
    Route::post('/shaikh/presents/{id}', [HomeController::class, 'pcoshypresents'])->name('course.shaikh.presents');

    Route::get('/shaikh/reject/users/{id}', [HomeController::class, 'coshyprejectusers'])->name('course.shaikh.reject.users');
    Route::get('/shaikh/close/{id}', [HomeController::class, 'coshyclose'])->name('course.shaikh.close');
    Route::get('/cert/{id}', [HomeController::class, 'certprint'])->name('course.cert.create');

    // Course
    Route::get('/', [HomeController::class, 'course'])->name('course');
    Route::get('/new', [HomeController::class, 'newcourse'])->name('course.new');
    Route::get('/store/new', [HomeController::class, 'course'])->name('course.store');
    Route::post('/store/new', [HomeController::class, 'storecourse'])->name('course.store');
    Route::get('/update/{id}', [HomeController::class, 'course'])->name('course.update');
    Route::get('/show/{id}', [HomeController::class, 'showcourse'])->name('course.show');
    Route::post('/update/{id}', [HomeController::class, 'updatecourse'])->name('course.update');
    Route::get('/destroy/{id}', [HomeController::class, 'destroycourse'])->name('course.destroy');

    // Course Apply
    Route::get('/appliers', [HomeController::class, 'courseapply'])->name('course.appliers');
    Route::post('/appliers', [HomeController::class, 'courseacceptreject'])->name('course.accept.reject');

    // course sttings
    Route::get('/users/status/{id}/{status}', [HomeController::class, 'coursesusersacceptreject'])->name('course.users.accept.reject');
    Route::post('/users/teacher/assign', [HomeController::class, 'coursesusersteacherassign'])->name('course.teacher.assign');
});
// Qeraat
Route::get('/qeraat', [HomeController::class, 'qeraat'])->name('qeraat');
Route::get('/qeraat/new', [HomeController::class, 'newqeraat'])->name('qeraat.new');
Route::get('/qeraat/store/new', [HomeController::class, 'qeraat'])->name('qeraat.store');
Route::post('/qeraat/store/new', [HomeController::class, 'storeqeraat'])->name('qeraat.store');
Route::get('/qeraat/update/{id}', [HomeController::class, 'qeraat'])->name('qeraat.update');
Route::get('/qeraat/show/{id}', [HomeController::class, 'showqeraat'])->name('qeraat.show');
Route::post('/qeraat/update/{id}', [HomeController::class, 'updateqeraat'])->name('qeraat.update');
Route::get('/qeraat/destroy/{id}', [HomeController::class, 'destroyqeraat'])->name('qeraat.destroy');

// SQeraat
Route::get('/sqeraat', [HomeController::class, 'sqeraat'])->name('sqeraat');
Route::get('/sqeraat/new', [HomeController::class, 'newsqeraat'])->name('sqeraat.new');
Route::get('/sqeraat/store/new', [HomeController::class, 'sqeraat'])->name('sqeraat.store');
Route::post('/sqeraat/store/new', [HomeController::class, 'storesqeraat'])->name('sqeraat.store');
Route::get('/sqeraat/update/{id}', [HomeController::class, 'sqeraat'])->name('sqeraat.update');
Route::get('/sqeraat/show/{id}', [HomeController::class, 'showsqeraat'])->name('sqeraat.show');
Route::post('/sqeraat/update/{id}', [HomeController::class, 'updatesqeraat'])->name('sqeraat.update');
Route::get('/sqeraat/destroy/{id}', [HomeController::class, 'destroysqeraat'])->name('sqeraat.destroy');

// Slider
Route::group(['prefix' => 'slider'], function () {
    Route::get('/', [HomeController::class, 'slider'])->name('slider');

    Route::get('/new', [HomeController::class, 'newslider'])->name('slider.new');

    Route::get('/store/new', [HomeController::class, 'slider'])->name('slider.store');

    Route::post('/store/new', [HomeController::class, 'storeslider'])->name('slider.store');

    Route::get('/update/{id}', [HomeController::class, 'slider'])->name('slider.update');

    Route::get('/show/{id}', [HomeController::class, 'showslider'])->name('slider.show');

    Route::post('/update/{id}', [HomeController::class, 'updateslider'])->name('slider.update');

    Route::get('/destroy/{id}', [HomeController::class, 'destroyslider'])->name('slider.destroy');

});

// Riwayat
Route::group(['prefix' => 'riwayat'], function () {
    Route::get('/', [HomeController::class, 'riwayat'])->name('riwayat');
    Route::get('/new', [HomeController::class, 'newriwayat'])->name('riwayat.new');
    Route::get('/store/new', [HomeController::class, 'riwayat'])->name('riwayat.store');
    Route::post('/riwayat/store/new', [HomeController::class, 'storeriwayat'])->name('riwayat.store');
    Route::get('/update/{id}', [HomeController::class, 'riwayat'])->name('riwayat.update');
    Route::get('/show/{id}', [HomeController::class, 'showriwayat'])->name('riwayat.show');
    Route::post('/update/{id}', [HomeController::class, 'updateriwayat'])->name('riwayat.update');
    Route::get('/destroy/{id}', [HomeController::class, 'destroyriwayat'])->name('riwayat.destroy');
});

/* Ejaza conditions */

Route::group(['prefix' => 'ejazah'], function () {

    /* == Ejazah Passed Students == */ // uploadStudentEjazaFile
    Route::get('/passed', [HomeController::class, 'passedEjaza'])->name('passed.ejazah');
    Route::get('/unpassed', [HomeController::class, 'unpassedEjaza'])->name('unpassed.ejazah');

    Route::get('/unpassed/{id}', [HomeController::class, 'unpassedIdEjaza'])->name('unpassed.id.ejazah');
    Route::get('/passed/continuous', [HomeController::class, 'continuousEjaza'])->name('continuous.ejazah');

    Route::post('passed/upload-attachment', [HomeController::class, 'uploadEjazahAttachment'])->name('passed.upload.attachment');

    /* == End Ejazah Passed Students == */

    Route::get('/conditions', [HomeController::class, 'qeraatEjaza'])->name('qeraat.ejazah');
    Route::post('/conditions', [HomeController::class, 'pqeraatEjaza'])->name('qeraat.ejazah');

    // Users
    Route::get('/users', [HomeController::class, 'ejusers'])->name('ejazah.users');
    Route::post('/user/update', [HomeController::class, 'ejusersupdate'])->name('ejazah.user.update');
    // Rejects
    Route::get('/reject/users', [HomeController::class, 'ejRejusers'])->name('ejazah.rejects.users');
    Route::get('/users/status/{id}', [HomeController::class, 'ejusersrestore'])->name('ejazah.users.restore');

    Route::get('/not/users', [HomeController::class, 'ejnousers'])->name('ejazah.not.users');

    Route::get('/accepted/users', [HomeController::class, 'ejazahAceeptedUsers'])->name('ejazah.all.accepted.users');

    // Shaikh students
    // Route::get('/shaikh/yes/users', [HomeController::class, 'ejshyusers'])->name('ejazah.shaikh.yes.users');

    Route::get('/shaikh/interview/users', [HomeController::class, 'ejshinterviewusers'])->name('ejazah.shaikh.interview.users');
    Route::get('/shaikh/continuous/users', [HomeController::class, 'ejshcontinuoususers'])->name('ejazah.shaikh.continuous.users');

    Route::post('/shaikh/student/update-status/{studentId}', [HomeController::class, 'updateStatus'])
        ->name('ejazah.shaikh.student.update_status');

    // Route::post('/save-student-hifz', [EnrollmentController::class, 'saveHifz'])->name('hifz.save');
    // مسار حفظ نتائج المقابلة الثانية (سورة الكهف)
    Route::post('/enrollments/{id}/save-second-interview', [EnrollmentController::class, 'saveSecondInterview'])
        ->name('enrollments.save-second-interview');

    Route::get('/shaikh/not/users', [HomeController::class, 'ejshnusers'])->name('ejazah.shaikh.not.users');
    Route::get('/shaikh/url', [HomeController::class, 'shlink'])->name('ejazah.shaikh.link');
    Route::post('/shaikh/url', [HomeController::class, 'shlinkid'])->name('ejazah.shaikh.link.id');

    // Accept/Reject
    Route::get('/users/status/{id}/{status}', [HomeController::class, 'ejusersacceptreject'])->name('ejazah.users.accept.reject');
    Route::post('/users/teacher/assign', [HomeController::class, 'ejusersteacherassign'])->name('ejazah.teacher.assign');
    Route::post('/users/teacher/interview', [HomeController::class, 'ejusersteacherinterview'])->name('ejazah.teacher.interview');

    Route::post('/users/teacher/interview/stage/two', [HomeController::class, 'ejusersteacherinterviewstagetwo'])->name('ejazah.teacher.interview.stage.two');
    Route::post('/users/teacher/interview/stage/morsalat', [HomeController::class, 'ejusersteacherinterviewstagemorsalat'])->name('ejazah.teacher.interview.stage.morsalat');
    Route::post('/users/teacher/interview/stage/completed', [HomeController::class, 'ejusersteacherinterviewstagecompleted'])->name('ejazah.teacher.interview.stage.completed');
    Route::post('/upload-student-ejazah-file', [HomeController::class, 'uploadStudentEjazaFile'])->name('students.ejazah.file.upload');

    // Filter By Country
    Route::get('/users/country/{id}', [HomeController::class, 'ejfusersByCountry'])->name('ejazah.by.country.users');
    Route::get('/users/country/', [HomeController::class, 'ejusers']);

    // Filter By Ejazah
    Route::get('/users/ejazah/{id}', [HomeController::class, 'ejfusersByEjazah'])->name('ejazah.by.ejazah.users');
    Route::get('/users/ejazah/', [HomeController::class, 'ejusers']);

    // Filter By Mujaz
    Route::get('/users/mujaz/{id}', [HomeController::class, 'ejfusersByMujaz'])->name('ejazah.by.mujaz.users');
    Route::get('/users/mujaz/', [HomeController::class, 'ejusers']);

    //

});
