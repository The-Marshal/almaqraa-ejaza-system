<?php

namespace App\Http\Controllers;

use Alert;
use ArPHP\I18N\Arabic;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $password =  Hash::make('147852');
        // $check =  Hash::check('147852', $password);
        // return $password ;
        return view('home');
    }

    /** Settings */
    public function settings()
    {
        return view('home');
    }

    /** Statistics */
    public function stats()
    {
        $data = DB::table(config('constants.tables.TBL_STS'))->where('id', 1)->first();

        return view('home', compact('data'));
        // return view('home');
    }

    public function pstats(Request $r)
    {
        // return $r->all();
        $issue = '';
        $validator = Validator::make($r->all(), [
            'st_title1' => 'required',
            'st_num1' => 'required',
            'st_title2' => 'required',
            'st_num2' => 'required',
            'st_title3' => 'required',
            'st_num3' => 'required',
            'st_title4' => 'required',
            'st_num4' => 'required',
        ]);
        $originalPath = config('constants.path.PATH_STS');
        $Dimage = DB::table(config('constants.tables.TBL_STS'))->where('id', 1)->first();

        $image1 = $Dimage->st_image1;
        $image2 = $Dimage->st_image2;
        $image3 = $Dimage->st_image3;
        $image4 = $Dimage->st_image4;

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم التعديل   ');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                if ($r->st_image1) {
                    if (file_exists($originalPath.$Dimage->st_image1)) {
                        @unlink($originalPath.$Dimage->st_image1);
                    }
                    $name = time().rand(1, 50).'.'.$r->st_image1->extension();
                    $image1 = $name;
                    $r->st_image1->move($originalPath.'/', $name);
                }
                if ($r->st_image2) {
                    if (file_exists($originalPath.$Dimage->st_image2)) {
                        @unlink($originalPath.$Dimage->st_image2);
                    }
                    $name = time().rand(1, 50).'.'.$r->st_image2->extension();
                    $image2 = $name;
                    $r->st_image2->move($originalPath.'/', $name);
                }
                if ($r->st_image3) {
                    if (file_exists($originalPath.$Dimage->st_image3)) {
                        @unlink($originalPath.$Dimage->st_image3);
                    }
                    $name = time().rand(1, 50).'.'.$r->st_image3->extension();
                    $image3 = $name;
                    $r->st_image3->move($originalPath.'/', $name);
                }
                if ($r->st_image4) {
                    if (file_exists($originalPath.$Dimage->st_image4)) {
                        @unlink($originalPath.$Dimage->st_image4);
                    }
                    $name = time().rand(1, 50).'.'.$r->st_image4->extension();
                    $image4 = $name;
                    $r->st_image4->move($originalPath.'/', $name);
                }

                $SQL = DB::table(config('constants.tables.TBL_STS'))->where('id', 1)->update([
                    'st_title1' => $r->st_title1,
                    'st_num1' => $r->st_num1,
                    'st_image1' => $image1,
                    'st_title2' => $r->st_title2,
                    'st_num2' => $r->st_num2,
                    'st_image2' => $image2,
                    'st_title3' => $r->st_title3,
                    'st_num3' => $r->st_num3,
                    'st_image3' => $image3,
                    'st_title4' => $r->st_title4,
                    'st_num4' => $r->st_num4,
                    'st_image4' => $image4,
                ]);

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }
        }

        if ($SQL) {
            Alert::success('', 'تم التحديث بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', $issue);

            return redirect()->back();
        }

        // config('constants.tables.TBL_MCONTNT')

    }

    /** Main Content */
    public function mcontnt()
    {
        // config('constants.tables.TBL_MCONTNT')
        $data = DB::table(config('constants.tables.TBL_MCONTNT'))->where('id', 1)->first();

        return view('mcontent', compact('data'));
    }

    public function pmcontnt(Request $r)
    {
        // return $r->all();
        $issue = '';
        $validator = Validator::make($r->all(), [
            'title1' => 'required',
            'desc1' => 'required',
            'title2' => 'required',
            'desc2' => 'required',
            'title3' => 'required',
            'desc3' => 'required',
        ]);
        $originalPath = config('constants.path.PATH_ABOUT');
        $Dimage = DB::table(config('constants.tables.TBL_MCONTNT'))->where('id', 1)->first();

        $image1 = $Dimage->image1;
        $image2 = $Dimage->image2;
        $image3 = $Dimage->image3;

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم التعديل   ');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                if ($r->image1) {
                    if (file_exists($originalPath.$Dimage->image1)) {
                        @unlink($originalPath.$Dimage->image1);
                    }
                    $name = time().rand(1, 50).'.'.$r->image1->extension();
                    $image1 = $name;
                    $r->image1->move($originalPath.'/', $name);
                }
                if ($r->image2) {
                    if (file_exists($originalPath.$Dimage->image2)) {
                        @unlink($originalPath.$Dimage->image2);
                    }
                    $name = time().rand(1, 50).'.'.$r->image2->extension();
                    $image2 = $name;
                    $r->image2->move($originalPath.'/', $name);
                }
                if ($r->image3) {
                    if (file_exists($originalPath.$Dimage->image3)) {
                        @unlink($originalPath.$Dimage->image3);
                    }
                    $name = time().rand(1, 50).'.'.$r->image3->extension();
                    $image3 = $name;
                    $r->image3->move($originalPath.'/', $name);
                }

                $SQL = DB::table(config('constants.tables.TBL_MCONTNT'))->where('id', 1)->update([
                    'title1' => $r->title1,
                    'desc1' => $r->desc1,
                    'image1' => $image1,
                    'title2' => $r->title2,
                    'desc2' => $r->desc2,
                    'image2' => $image2,
                    'title3' => $r->title3,
                    'desc3' => $r->desc3,
                    'image3' => $image3,
                ]);

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }
        }

        if ($SQL) {
            Alert::success('', 'تم التحديث بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', $issue);

            return redirect()->back();
        }

        // config('constants.tables.TBL_MCONTNT')

    }

    /** Contact */
    public function contact()
    {

        // config('constants.tables.TBL_MCONTNT')
        $data = DB::table(config('constants.tables.TBL_CONTACT'))->where('id', 1)->first();

        return view('contact', compact('data'));
    }

    public function pcontact(Request $r)
    {
        // dd($r->all());
        // return $r->all();

        $validator = Validator::make($r->all(), [
            'title_mobile' => 'required',
            'mobile' => 'required',
            'title_email' => 'required',
            'email' => 'required',
            'title_visit' => 'required',
            'visit' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم التعديل   ');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                $SQL = DB::table(config('constants.tables.TBL_CONTACT'))->where('id', 1)->update([
                    'title_mobile' => $r->title_mobile,
                    'mobile' => $r->mobile,
                    'title_email' => $r->title_email,
                    'email' => $r->email,
                    'title_visit' => $r->title_visit,
                    'visit' => $r->visit,
                    'map' => $r->map,
                    'fb' => $r->fb,
                    'x' => $r->x,
                    'yt' => $r->yt,
                    'insta' => $r->insta,
                    'snap' => $r->snap,
                    'whatsapp' => $r->whatsapp,
                    'telegram' => $r->telegram,
                ]);

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }
        }

        if ($SQL) {
            Alert::success('', 'تم التحديث بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', $issue);

            return redirect()->back();
        }

        // config('constants.tables.TBL_MCONTNT')

    }

    // Sections
    public function sections()
    {
        $data = DB::table(config('constants.tables.TBL_SECTIONS'))->get();

        return view('courses.sections', compact('data'));
    }

    public function newsections()
    {
        $data = DB::table(config('constants.tables.TBL_SECTIONS'))->get();

        return view('courses.sections', compact('data'));
    }

    public function storesections(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                $SQL = DB::table(config('constants.tables.TBL_SECTIONS'))->insert([
                    'name' => $r->name,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

        return redirect()->back();
    }

    public function showsections($id)
    {
        $data = DB::table(config('constants.tables.TBL_SECTIONS'))->get();
        $dataById = DB::table(config('constants.tables.TBL_SECTIONS'))->where('id', $id)->first();

        return view('courses.sections', compact('data', 'dataById'));
    }

    public function updatesections(Request $r, $id)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);
        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }
        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                $SQL = DB::table(config('constants.tables.TBL_SECTIONS'))->where('id', $id)->update([
                    'name' => $r->name,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    public function destroysectionss($id)
    {

        $DelType = DB::table(config('constants.tables.TBL_SECTIONS'))->where('id', $id)->delete();
        if ($DelType) {
            Alert::success('', ' تم الحذف  بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', 'فشل الحذف');

            return redirect()->back();
        }

    }

    // Teachers
    public function teachers()
    {
        $data = DB::table(config('constants.tables.TBL_TEACHERS'))->where('level', 'teacher')->get();

        return view('courses.teachers', compact('data'));
    }

    public function newteachers()
    {
        $data = DB::table(config('constants.tables.TBL_TEACHERS'))->get();

        return view('courses.teachers', compact('data'));
    }

    public function storeteachers(Request $r)
    {
        $level = 'teacher';
        $validator = Validator::make($r->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                $SQL = DB::table(config('constants.tables.TBL_TEACHERS'))->insert([
                    'name' => $r->name,
                    'email' => $r->email,
                    'password' => Hash::make($r->password),
                    'level' => $level,
                    'gender' => $r->gender,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

        return redirect()->back();
    }

    public function showteachers($id)
    {
        $data = DB::table(config('constants.tables.TBL_TEACHERS'))->get();
        $dataById = DB::table(config('constants.tables.TBL_TEACHERS'))->where('id', $id)->first();

        return view('courses.teachers', compact('data', 'dataById'));
    }

    public function updateteachers(Request $r, $id)
    {
        $level = 'teacher';
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);
        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }
        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                if ($r->password != '') {
                    $SQL = DB::table(config('constants.tables.TBL_TEACHERS'))->where('id', $id)->update([
                        'name' => $r->name,
                        'email' => $r->email,
                        'password' => Hash::make($r->password),
                        'level' => $level,
                        'gender' => $r->gender,
                        'status' => $status,
                    ]);
                } else {
                    $SQL = DB::table(config('constants.tables.TBL_TEACHERS'))->where('id', $id)->update([
                        'name' => $r->name,
                        'email' => $r->email,
                        'level' => $level,
                        'gender' => $r->gender,
                        'status' => $status,
                    ]);
                }

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    public function destroyteachers($id)
    {

        $DelType = DB::table(config('constants.tables.TBL_TEACHERS'))->where('id', $id)->delete();
        if ($DelType) {
            Alert::success('', ' تم الحذف  بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', 'فشل الحذف');

            return redirect()->back();
        }

    }

    // Courses Appliers

    public function courseNewAppliers()
    {
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();
        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('status', 'WAIT')->get();

        return view('courses.courseappliers', compact('data', 'countriesValue', 'countriesKey', 'teachers'));
    }

    public function courseAppliers()
    {
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();
        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('status', 'ACCEPT')->get();

        return view('courses.courseappliers', compact('data', 'countriesValue', 'countriesKey', 'teachers'));
    }

    public function courseRejectAppliers()
    {
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();
        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('status', 'REJECT')->get();

        return view('courses.courseappliers', compact('data', 'countriesValue', 'countriesKey', 'teachers'));
    }

    public function courseapply()
    {
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();
        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->get();

        return view('courses.courseapply', compact('data', 'countriesValue', 'countriesKey', 'teachers'));
    }

    public function coursesusersacceptreject($id, $status)
    {
        try {
            // NEW', 'WAIT','ACCEPT', 'REJECT'
            if ($status == 'accept') {
                $status = 'ACCEPT';
            } elseif ($status == 'reject') {
                $status = 'REJECT';
            }

            $SQL = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('id', $id)->update([
                'status' => $status,
            ]);

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    public function courseacceptreject(Request $r)
    {
        // dd($r->all());
        $quran_check = $r->quran_check;
        $gaz_check = $r->gaz_check;
        $ejaza_check = $r->ejaza_check;
        $isejaza_check = $r->isejaza_check;
        $apply = $r->apply;
        $course_apply_id = $r->course_apply_id;
        $getCourseData = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('id', $course_apply_id)->first();
        if ($apply == 'accept') {
            if ($quran_check == 'on') {

                $SQLQuran = DB::table(config('constants.tables.TBL_USERS'))->where('id', $getCourseData->userid)->update([
                    'quran' => 'yes',
                    'cerquran' => $getCourseData->cerquran,
                ]);

            }

            if ($gaz_check == 'on') {
                $SQLGaz = DB::table(config('constants.tables.TBL_USERS'))->where('id', $getCourseData->userid)->update([
                    'gaz' => 'yes',
                    'cergaz' => $getCourseData->cergaz,
                ]);
            }

            if ($ejaza_check == 'on') {
                $SQLGaz = DB::table(config('constants.tables.TBL_USERS'))->where('id', $getCourseData->userid)->update([
                    'ejaza' => 'yes',
                    'cerejaza' => $getCourseData->cerejaza,
                ]);
            }

            if ($isejaza_check == 'on') {
                $SQLGaz = DB::table(config('constants.tables.TBL_USERS'))->where('id', $getCourseData->userid)->update([
                    'isejaza' => 'yes',
                    'cerisejaza' => $getCourseData->cerisejaza,
                ]);
            }

            try {
                $SQL = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('id', $course_apply_id)->update([
                    'status' => 'ACCEPT',
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل  بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم التعديل');

                    return redirect()->back();
                }
            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        } elseif ($apply == 'reject') {
            // dd($r->all());
            try {
                $SQL = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('id', $course_apply_id)->update([
                    'status' => 'REJECT',
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل  بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم التعديل');

                    return redirect()->back();
                }
            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }
        }

    }

    // Courses settings
    public function coursesusersteacherassign(Request $r)
    {
        // return $r->user_course_id.' - '.$r->teacher_id;
        try {

            $SQL = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('id', $r->user_course_id)->update([
                'teacher' => $r->teacher_id,
            ]);

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    // Courses
    public function course()
    {
        $data = DB::table(config('constants.tables.TBL_COURSES'))->get();
        $sections = DB::table(config('constants.tables.TBL_SECTIONS'))->get();
        $techers = DB::table(config('constants.tables.TBL_TEACHERS'))->get();

        return view('courses.course', compact('data', 'sections', 'techers'));
    }

    public function newcourse()
    {
        $data = DB::table(config('constants.tables.TBL_COURSES'))->get();
        $sections = DB::table(config('constants.tables.TBL_SECTIONS'))->where('status', 'yes')->get();
        $techers = DB::table(config('constants.tables.TBL_TEACHERS'))->where('status', 'yes')->get();

        return view('courses.course', compact('data', 'sections', 'techers'));
    }

    public function storecourse(Request $r)
    {
        $path = config('constants.path.PATH_COURSES');
        // dd($r->all());
        $validator = Validator::make($r->all(), [
            'section' => 'required',
            'time' => 'required',
            'teacher' => 'required',
            'cstart' => 'required',
            'cend' => 'required',
            'content' => 'required',
            'poster' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:6048',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        // Conditions
        if ($r->quran == 'on') {
            $quran = 'yes';
        } else {
            $quran = 'no';
        }
        if ($r->cerquran == 'on') {
            $cerquran = 'yes';
        } else {
            $cerquran = 'no';
        }
        if ($r->male == 'on') {
            $male = 'yes';
        } else {
            $male = 'no';
        }
        if ($r->female == 'on') {
            $female = 'yes';
        } else {
            $female = 'no';
        }
        if ($r->gaz == 'on') {
            $gaz = 'yes';
        } else {
            $gaz = 'no';
        }
        if ($r->ejaza == 'on') {
            $ejaza = 'yes';
        } else {
            $ejaza = 'no';
        }
        if ($r->isejaza == 'on') {
            $isejaza = 'yes';
        } else {
            $isejaza = 'no';
        }

        $filename = $r->poster;
        $filenameStore = sha1(hexdec(uniqid())).'.'.$filename->getClientOriginalExtension();

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                // Upload image
                if ($filename->getSize() > 2000000) {
                    // Intervention lib uploading
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($filename);

                    $image->toJpg(60);
                    $image->save($path.$filenameStore);
                } else {
                    // Simple uploading
                    $filename->move($path, $filenameStore);
                }

                $SQL = DB::table(config('constants.tables.TBL_COURSES'))->insert([
                    'section' => $r->section,
                    'time' => $r->time,
                    'name' => $r->name,
                    'teacher' => $r->teacher,
                    'cstart' => $r->cstart,
                    'cend' => $r->cend,
                    'content' => $r->content,
                    'objects' => $r->objects,
                    'txtcontent' => $r->content1,
                    'poster' => $filenameStore,
                    'status' => $status,
                    'quran' => $quran,
                    'cerquran' => $cerquran,
                    'male' => $male,
                    'female' => $female,
                    'gaz' => $gaz,
                    'ejaza' => $ejaza,
                    'isejaza' => $isejaza,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

        return redirect()->back();
    }

    public function showcourse($id)
    {
        $data = DB::table(config('constants.tables.TBL_COURSES'))->get();
        $dataById = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->first();

        $sections = DB::table(config('constants.tables.TBL_SECTIONS'))->where('status', 'yes')->get();
        $techers = DB::table(config('constants.tables.TBL_TEACHERS'))->where('status', 'yes')->get();

        return view('courses.course', compact('data', 'dataById', 'sections', 'techers'));
    }

    public function updatecourse(Request $r, $id)
    {
        $path = config('constants.path.PATH_COURSES');
        if ($r->poster) {

            $validator = Validator::make($r->all(), [
                'section' => 'required',
                'time' => 'required',
                'teacher' => 'required',
                'cstart' => 'required',
                'cend' => 'required',
                'content' => 'required',
                'content1' => 'required',
                'objects' => 'required',
                'poster' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:6048',
            ]);

            $filename = $r->poster;
            $filenameStore = sha1(hexdec(uniqid())).'.'.$filename->getClientOriginalExtension();

        } else {
            $validator = Validator::make($r->all(), [
                'section' => 'required',
                'time' => 'required',
                'teacher' => 'required',
                'cstart' => 'required',
                'cend' => 'required',
                'content' => 'required',
                'content1' => 'required',
                'objects' => 'required',
            ]);
        }

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        // Conditions
        if ($r->quran == 'on') {
            $quran = 'yes';
        } else {
            $quran = 'no';
        }
        if ($r->cerquran == 'on') {
            $cerquran = 'yes';
        } else {
            $cerquran = 'no';
        }
        if ($r->male == 'on') {
            $male = 'yes';
        } else {
            $male = 'no';
        }
        if ($r->female == 'on') {
            $female = 'yes';
        } else {
            $female = 'no';
        }
        if ($r->gaz == 'on') {
            $gaz = 'yes';
        } else {
            $gaz = 'no';
        }
        if ($r->ejaza == 'on') {
            $ejaza = 'yes';
        } else {
            $ejaza = 'no';
        }
        if ($r->isejaza == 'on') {
            $isejaza = 'yes';
        } else {
            $isejaza = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                if ($r->poster) {

                    $dataDelete = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->first();
                    if ($dataDelete->poster != null) {
                        if (@file_exists($path.$dataDelete->poster)) {
                            @unlink($path.$dataDelete->poster);
                        }
                    }

                    // Upload image
                    if ($filename->getSize() > 2000000) {
                        // Intervention lib uploading
                        $manager = new ImageManager(Driver::class);
                        $image = $manager->read($filename);

                        $image->toJpg(60);
                        $image->save($path.$filenameStore);
                    } else {
                        // Simple uploading
                        $filename->move($path, $filenameStore);
                    }
                    // quran	cerquran	male	female	gaz	ejaza	isejaza
                    $SQL = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->update([
                        'section' => $r->section,
                        'time' => $r->time,
                        'name' => $r->name,
                        'teacher' => $r->teacher,
                        'cstart' => $r->cstart,
                        'cend' => $r->cend,
                        'content' => $r->content,
                        'objects' => $r->objects,
                        'txtcontent' => $r->content1,
                        'poster' => $filenameStore,
                        'status' => $status,
                        'quran' => $quran,
                        'cerquran' => $cerquran,
                        'male' => $male,
                        'female' => $female,
                        'gaz' => $gaz,
                        'ejaza' => $ejaza,
                        'isejaza' => $isejaza,
                    ]);

                } else {
                    $SQL = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->update([
                        'section' => $r->section,
                        'time' => $r->time,
                        'name' => $r->name,
                        'teacher' => $r->teacher,
                        'cstart' => $r->cstart,
                        'cend' => $r->cend,
                        'content' => $r->content,
                        'objects' => $r->objects,
                        'txtcontent' => $r->content1,
                        'status' => $status,
                        'quran' => $quran,
                        'cerquran' => $cerquran,
                        'male' => $male,
                        'female' => $female,
                        'gaz' => $gaz,
                        'ejaza' => $ejaza,
                        'isejaza' => $isejaza,
                    ]);
                }

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    public function destroycourse($id)
    {
        $path = config('constants.path.PATH_COURSES');
        $dataDelete = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->first();
        if ($dataDelete->poster != null) {
            if (@file_exists($path.$dataDelete->poster)) {
                @unlink($path.$dataDelete->poster);
            }
        }

        $DelType = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->delete();
        if ($DelType) {
            Alert::success('', ' تم الحذف  بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', 'فشل الحذف');

            return redirect()->back();
        }

    }

    // Shaikh
    public function coshyusers()
    {
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('teacher', auth()->user()->id)->where('status', 'WAIT')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('courses.courseapply', compact('data', 'countriesValue', 'countriesKey'));
        // dd($data);
    }

    public function coshyyesusers()
    {
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('teacher', auth()->user()->id)->where('status', 'ACCEPT')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('courses.courseapply', compact('data', 'countriesValue', 'countriesKey'));
    }

    public function coshynousers()
    {
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('teacher', auth()->user()->id)->where('status', 'REJECT')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('courses.courseapply', compact('data', 'countriesValue', 'countriesKey'));
    }

    public function coshynew()
    {
        // courseteacher
        // dd(auth()->user()->id);
        $data = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher', auth()->user()->id)->where('cstatus', 'NEW')->get();

        return view('courses.courseteacher', compact('data'));
    }

    public function coshyactive()
    {
        $data = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher', auth()->user()->id)->where('cstatus', 'ACTIVE')->get();

        return view('courses.courseteacher', compact('data'));
    }

    public function coshycompleted()
    {
        $data = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher', auth()->user()->id)->where('cstatus', 'COMPLETED')->get();

        return view('courses.courseteacher', compact('data'));
    }

    // Course completed degrees
    public function coshyusercompletedgree(Request $r, $id)
    {
        // dd($r->all(), $id);
        // id	course_id	student_id	teacher_id	country	present	telawah	midterm	finalterm	total	grade	created_at	updated_at
        $checkCourseDgree = DB::table(config('constants.tables.TBL_CORSDGRE'))->where('student_id', $r->user_data_id)->where('course_id', $id)->first();

        if ($r->user_data_dgree >= 90 && $r->user_data_dgree <= 100) {
            $user_data_dgree = 'ممتاز';
            $grade_status = 'PASS';
        } elseif ($r->user_data_dgree >= 80 && $r->user_data_dgree <= 89) {
            $user_data_dgree = 'جيد جداً';
            $grade_status = 'PASS';
        } else {

            $user_data_dgree = 'لم ينجح';
            $grade_status = 'FAILED';
        }

        if ($checkCourseDgree) {
            Alert::error('خطأ', 'لايمكن اضافة الدرجات لنفس الطالب مرتين في نفس الدورة   ');

            return redirect()->back();
        } else {
            $SQL = DB::table(config('constants.tables.TBL_CORSDGRE'))->insert([
                'course_id' => $id,
                'student_id' => $r->user_data_id,
                'teacher_id' => auth()->user()->id,
                'country' => $r->user_country,
                'present' => $r->present,
                'telawah' => $r->telawah,
                'midterm' => $r->midterm,
                'finalterm' => $r->finalterm,
                'total' => $r->user_data_dgree,
                'hours' => $r->user_hour,
                'grade' => $user_data_dgree,
                'grade_status' => $grade_status,
                'period_from' => $r->user_from,
                'period_to' => $r->user_to,
            ]);

            if ($SQL) {
                Alert::success('', 'تمت الإضافة بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم اضافة اي بيانات');

                return redirect()->back();
            }

        }

    }

    public function coshypcompletedusers($id)
    {
        // $data = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher',auth()->user()->id)->where('cstatus','COMPLETED')->where('id',$id)->get();
        $data = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('teacher', auth()->user()->id)->where('status', 'ACCEPT')->where('courseid', $id)->get();

        // dd($data);
        return view('courses.coursecompleted', compact('data'));
    }

    // activate course
    public function coshyactivate($id)
    {
        $data = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher', auth()->user()->id)->where('id', $id)->where('cstatus', 'NEW')->first();
        try {
            if ($data) {
                $SQL = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->update([
                    'cstatus' => 'ACTIVE',
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }
            } else {
                Alert::error('خطأ', 'لايمكن تفعيل دورة مفعلة مسبقاً');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }

    }

    // Show and Presents students course
    public function pcoshypresents(Request $r, $id)
    {
        // TBL_CORSAPLYPRSNTS
        $allusers = json_encode($r->users_select);

        try {

            $checkTodayDate = DB::table(config('constants.tables.TBL_CORSAPLYPRSNTS'))->where('course_id', $id)->orderBy('id', 'DESC')->first();
            // dd($checkTodayDate->created_at,Carbon::today()->toDateString());
            if ($checkTodayDate) {
                $chkdate = Carbon::parse($checkTodayDate->created_at);

                // dd($checkTodayDate->created_at,$chkdate->isToday());
                if ($chkdate->isToday()) {
                    Alert::error('خطأ', 'لايمكن تحضير الطلاب مرتين في نفس اليوم');

                    return redirect()->back();
                } else {
                    $SQL = DB::table(config('constants.tables.TBL_CORSAPLYPRSNTS'))->insert([
                        'students_id' => $allusers,
                        'course_id' => $id,
                    ]);

                    if ($SQL) {
                        Alert::success('', 'تمت الإضافة بنجاح');

                        return redirect()->back();
                    } else {
                        Alert::error('خطأ', 'لم يتم اضافة اي بيانات');

                        return redirect()->back();
                    }
                }
            } else {
                $SQL = DB::table(config('constants.tables.TBL_CORSAPLYPRSNTS'))->insert([
                    'students_id' => $allusers,
                    'course_id' => $id,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');

                    return redirect()->back();
                }
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }

        dd($allusers, $id, $r->all());

    }

    public function coshypresents($id)
    {
        // pass it with variables in present page
        $course_id = $id;
        $data = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher', auth()->user()->id)->where('id', $id)->where('cstatus', 'ACTIVE')->first();

        try {
            if ($data) {
                $allUsers = DB::table(config('constants.tables.TBL_CORSAPLY'))->where('teacher', auth()->user()->id)->where('courseid', $id)->where('status', 'ACCEPT')->get();

                $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
                $countriesKey = [];
                $countriesValue = [];
                foreach ($countries as $row) {
                    $countriesKey[] = $row->id;
                    $countriesValue[] = $row->country;
                }

                return view('courses.courseteacherpresent', compact('allUsers', 'course_id', 'countriesValue', 'countriesKey'));

                // dd($allUsers);

            } else {
                Alert::error('خطأ', 'لاتوجد بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }

    }

    // Close course
    public function coshyclose($id)
    {
        $course_id = $id;

        $dataChanged = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher', auth()->user()->id)->where('id', $id)->where('cstatus', 'ACTIVE')->first();
        // return redirect()->back();
        // dd($data,$course_id);
        // COMPLETED

        $data = DB::table(config('constants.tables.TBL_COURSES'))->where('teacher', auth()->user()->id)->where('cstatus', 'ACTIVE')->get();

        try {
            if ($dataChanged) {
                $SQL = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $id)->update([

                    'cstatus' => 'COMPLETED',
                ]);
                if ($SQL) {
                    Alert::success('', 'تمت التعديل بنجاح');

                    return view('courses.courseteacher', compact('data'));
                    // return redirect()->back();
                    // return view('courses.courseteachercompleted', compact('course_id'));
                    // return redirect()->back()->with('course_id', $course_id);
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return view('courses.courseteacher', compact('data'));
                    // return redirect()->back();
                    // return view('courses.courseteachercompleted', compact('course_id'));
                    // return redirect()->back()->with('course_id', $course_id);
                }

                // return view('courses.courseteacherpresent', compact('allUsers','course_id','countriesValue','countriesKey'));

                // dd($allUsers);

            } else {
                Alert::error('خطأ', 'لاتوجد بيانات');

                return view('courses.courseteacher', compact('data'));
                // return redirect()->back();
                // return view('courses.courseteachercompleted', compact('course_id'));
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    // Print Certificates

    protected function convertEnglishNumbersToArabic($text)
    {
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($englishDigits, $arabicDigits, $text);
    }
    // $arabicText = convertEnglishNumbersToArabic($englishText);

    public function certprint($id)
    {
        $checkCourseCert = DB::table(config('constants.tables.TBL_CORSDGRE'))->whereNull('certifcate')->where('grade_status', 'PASS')->first();

        // Vars
        $name = '';
        $country = '';
        $gender = '';
        $course = '';
        $shaikh = '';
        $Dgree = '';
        $DateFrom = '';
        $DateTo = '';
        $Period = '';
        $output = '';

        // ->where('grade_status','PASS')
        if ($checkCourseCert) {
            $courseSQL = DB::table(config('constants.tables.TBL_COURSES'))->where('id', $checkCourseCert->course_id)->first();
            $user = DB::table(config('constants.tables.TBL_USERS'))->where('id', $checkCourseCert->student_id)->first();
            $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->where('id', $checkCourseCert->teacher_id)->first();
            if ($courseSQL) {
                $course = $courseSQL->name;
            }
            if ($teacher) {
                $shaikh = $teacher->name;
            }
            if ($user) {
                $name = $user->name.' '.$user->mdlname.' '.$user->thrdname.' '.$user->lastname;
                $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
                $countriesKey = [];
                $countriesValue = [];
                foreach ($countries as $row) {
                    $countriesKey[] = $row->id;
                    $countriesValue[] = $row->country;
                }

                $country = $countriesValue[array_search($user->country, $countriesKey)];
                $gender = $user->gender;

            }

            $Dgree = $checkCourseCert->grade;
            $DateFrom = $checkCourseCert->period_from;
            $DateTo = $checkCourseCert->period_to;
            $Period = $checkCourseCert->hours;
            // dd($Dgree);
        } else {
            dd('Nothing');
        }

        // Setup the image manager with GD driver (or imagick)
        // $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $manager = new ImageManager(Driver::class);

        // Load your base image PATH_HMLCERTS
        if ($gender == 'female') {
            $image = $manager->read(config('constants.path.PATH_HMLCERTS').'female.jpg');
        } else {
            $image = $manager->read(config('constants.path.PATH_HMLCERTS').'male.jpg');
        }
        // Prepare Arabic reshaper
        // $arabic = new Arabic('Glyphs');
        $arabic = new \I18N_Arabic('Glyphs');

        // Define Arabic texts and positions
        // $name = 'عمار عبدالله محمد السليماني';
        // $country = 'السعودية';
        // $txt3 = 'دورة حفظ وشرح منظومة الجزرية';
        // $course = 'دورة حفظ   ';
        // $shaikh = 'الشيخ عبدالرحمن صفوت';
        // $Dgree = 'ممتاز';

        // Numbers
        // $DateFrom = '1/10/2025';
        // $DateFrom = $this->convertEnglishNumbersToArabic($DateFrom);
        // $DateTo = '20/10/2025';
        // $Period = '15';
        $published = date('d/m/Y');
        $publishedOutpt = date('dmY');
        $output = Str::random(32);

        // $DateTo = $this->convertEnglishNumbersToArabic($DateTo);
        $texts = [
            ['text' => $name, 'x' => 3200, 'y' => 990],
            ['text' => $country, 'x' => 1723, 'y' => 993],
            ['text' => $course, 'x' => 2516, 'y' => 1138],
            ['text' => $shaikh, 'x' => 2152, 'y' => 1273],
            ['text' => $Dgree, 'x' => 2427, 'y' => 1521],
        ];

        $numbers = [
            ['text' => $DateFrom, 'x' => 1707, 'y' => 1404],
            ['text' => $DateTo, 'x' => 1145, 'y' => 1410],
            ['text' => $Period, 'x' => 3235, 'y' => 1521],
        ];

        $numbersWhite = [
            ['text' => $published, 'x' => 3161, 'y' => 2390],
        ];

        // Path to Arabic-supporting font
        $fontPath = config('constants.path.PATH_FONTSCERTS').'Noto.woff2';
        $fontPathNum = config('constants.path.PATH_FONTSCERTS').'Amiri-Regular.ttf';
        // $fontPath = 'https://fonts.gstatic.com/s/notokufiarabic/v27/CSRk4ydQnPyaDxEXLFF6LZVLKrodrOYFFlKp.woff2';

        $fontColor = '#015d52';
        $fontWhiteColor = '#FFF';
        $fontSize = '65';
        // dd($fontPath);

        /*$img->text($shaped, $item['x'], $item['y'], function ($font) use ($text_color) {
            $font->file(public_path('fonts/Roboto-Regular.ttf'));
            $font->size(24);
            $font->color($text_color);
            $font->align('left');
        });*/

        // Loop through and draw each text
        foreach ($numbers as $item) {
            $shaped = $arabic->utf8Glyphs($item['text']);

            $image->text($shaped, $item['x'], $item['y'], function ($font) use ($fontColor, $fontPathNum, $fontSize) {
                $font->file($fontPathNum);
                $font->size($fontSize);
                $font->color($fontColor);
                $font->align('right');  // RTL align
                // $font->valign('top');
            });
        }

        foreach ($numbersWhite as $item) {
            $shaped = $arabic->utf8Glyphs($item['text']);

            $image->text($shaped, $item['x'], $item['y'], function ($font) use ($fontWhiteColor, $fontPathNum, $fontSize) {
                $font->file($fontPathNum);
                $font->size($fontSize);
                $font->color($fontWhiteColor);
                $font->align('right');  // RTL align
                // $font->valign('top');
            });
        }

        foreach ($texts as $item) {
            $shaped = $arabic->utf8Glyphs($item['text']);

            $image->text($shaped, $item['x'], $item['y'], function ($font) use ($fontColor, $fontPath, $fontSize) {
                $font->file($fontPath);
                $font->size($fontSize);
                $font->color($fontColor);
                $font->align('right');  // RTL align
                // $font->valign('top');
            });
        }

        // dd($id,config('constants.path.PATH_FONTSCERTS'),config('constants.path.PATH_HLCERTS').'output.jpg');
        // Save or return the image
        $outputPath = config('constants.path.PATH_HLCERTS').$output.'.jpg';
        $image->save($outputPath);
        // Success
        $SQL = DB::table(config('constants.tables.TBL_CORSDGRE'))->where('id', $checkCourseCert->id)->update([
            'certifcate' => $output.'.jpg',
        ]);

        return response()->file($outputPath);
    }

    // show rejected users
    public function coshyprejectusers($id) {}

    // Courses
    public function slider()
    {
        $data = DB::table(config('constants.tables.TBL_SLIDER'))->get();

        return view('slider', compact('data'));
    }

    public function newslider()
    {
        $data = DB::table(config('constants.tables.TBL_SLIDER'))->get();

        return view('slider', compact('data'));
    }

    public function storeslider(Request $r)
    {
        $path = config('constants.path.PATH_LOCAL_SLIDER');
        // dd($r->all());
        $validator = Validator::make($r->all(), [
            'title' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:6048',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($r->orders != '') {
            $orders = $r->orders;
        } else {
            $orders = '0';
        }

        $filename = $r->image;
        $filenameStore = sha1(hexdec(uniqid())).'.'.$filename->getClientOriginalExtension();

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                // Upload image
                if ($filename->getSize() > 2000000) {
                    // Intervention lib uploading
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($filename);

                    $image->toJpg(60);
                    $image->save($path.$filenameStore);
                } else {
                    // Simple uploading
                    $filename->move($path, $filenameStore);
                }

                $SQL = DB::table(config('constants.tables.TBL_SLIDER'))->insert([
                    'title' => $r->title,
                    'image' => $filenameStore,
                    'status' => $status,
                    'orders' => $orders,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

        return redirect()->back();
    }

    public function showslider($id)
    {
        $dataById = DB::table(config('constants.tables.TBL_SLIDER'))->where('id', $id)->first();

        return view('slider', compact('dataById'));
    }

    public function updateslider(Request $r, $id)
    {
        // dd($r->all());
        $path = config('constants.path.PATH_LOCAL_SLIDER');
        if ($r->image) {

            $validator = Validator::make($r->all(), [
                'title' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:6048',
            ]);

            $filename = $r->image;
            $filenameStore = sha1(hexdec(uniqid())).'.'.$filename->getClientOriginalExtension();

        } else {
            $validator = Validator::make($r->all(), [
                'title' => 'required',
            ]);
        }

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }
        if ($r->orders != '') {
            $orders = $r->orders;
        } else {
            $orders = '0';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم تعديل اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {

            try {
                if ($r->image) {
                    // dd($r->all());
                    $getData = DB::table(config('constants.tables.TBL_SLIDER'))->where('id', $id)->first();
                    if ($getData->image != null) {
                        if (@file_exists($path.$getData->image)) {
                            @unlink($path.$getData->image);
                        }
                    }

                    // Upload image
                    if ($filename->getSize() > 2000000) {
                        // Intervention lib uploading
                        $manager = new ImageManager(Driver::class);
                        $image = $manager->read($filename);

                        $image->toJpg(60);
                        $image->save($path.$filenameStore);
                    } else {
                        // Simple uploading
                        $filename->move($path, $filenameStore);
                    }
                    // quran	cerquran	male	female	gaz	ejaza	isejaza
                    $SQL = DB::table(config('constants.tables.TBL_SLIDER'))->where('id', $id)->update([
                        'title' => $r->title,
                        'image' => $filenameStore,
                        'status' => $status,
                        'orders' => $orders,
                    ]);

                } else {
                    $SQL = DB::table(config('constants.tables.TBL_SLIDER'))->where('id', $id)->update([
                        'title' => $r->title,
                        'status' => $status,
                        'orders' => $orders,
                    ]);
                }

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    public function destroyslider($id)
    {
        $path = config('constants.path.PATH_LOCAL_SLIDER');
        $dataDelete = DB::table(config('constants.tables.TBL_SLIDER'))->where('id', $id)->first();
        if ($dataDelete->image != null) {
            if (@file_exists($path.$dataDelete->image)) {
                @unlink($path.$dataDelete->image);
            }
        }

        $DelType = DB::table(config('constants.tables.TBL_SLIDER'))->where('id', $id)->delete();
        if ($DelType) {
            Alert::success('', ' تم الحذف  بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', 'فشل الحذف');

            return redirect()->back();
        }

    }

    // RIWAYA
    public function riwayat()
    {
        $data = DB::table(config('constants.tables.TBL_RIWAYAT'))->get();

        return view('qeraat.riwayat', compact('data'));
    }

    public function newriwayat()
    {
        $data = DB::table(config('constants.tables.TBL_RIWAYAT'))->get();

        return view('qeraat.riwayat', compact('data'));
    }

    public function storeriwayat(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                $SQL = DB::table(config('constants.tables.TBL_RIWAYAT'))->insert([
                    'name' => $r->name,
                    'orders' => $r->orders,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

        return view('qeraat.riwayat');
    }

    public function showriwayat($id)
    {
        $data = DB::table(config('constants.tables.TBL_RIWAYAT'))->get();
        $dataById = DB::table(config('constants.tables.TBL_RIWAYAT'))->where('id', $id)->first();

        return view('qeraat.riwayat', compact('data', 'dataById'));
    }

    public function updateriwayat(Request $r, $id)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                $SQL = DB::table(config('constants.tables.TBL_RIWAYAT'))->where('id', $id)->update([
                    'name' => $r->name,
                    'orders' => $r->orders,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    public function destroyriwayat($id)
    {

        $DelType = DB::table(config('constants.tables.TBL_RIWAYAT'))->where('id', $id)->delete();
        if ($DelType) {
            Alert::success('', ' تم الحذف  بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', 'فشل الحذف');

            return redirect()->back();
        }

    }

    // QERAAT
    public function qeraat()
    {
        $data = DB::table(config('constants.tables.TBL_QERAAT'))->get();

        return view('qeraat.qeraat', compact('data'));
    }

    public function newqeraat()
    {
        $data = DB::table(config('constants.tables.TBL_QERAAT'))->get();

        return view('qeraat.qeraat', compact('data'));
    }

    public function storeqeraat(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                $SQL = DB::table(config('constants.tables.TBL_QERAAT'))->insert([
                    'name' => $r->name,
                    'orders' => $r->orders,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

        return view('qeraat.qeraat');
    }

    public function showqeraat($id)
    {
        $data = DB::table(config('constants.tables.TBL_QERAAT'))->get();
        $dataById = DB::table(config('constants.tables.TBL_QERAAT'))->where('id', $id)->first();

        return view('qeraat.qeraat', compact('data', 'dataById'));
    }

    public function updateqeraat(Request $r, $id)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                $SQL = DB::table(config('constants.tables.TBL_QERAAT'))->where('id', $id)->update([
                    'name' => $r->name,
                    'orders' => $r->orders,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    public function destroyqeraat($id)
    {

        $DelType = DB::table(config('constants.tables.TBL_QERAAT'))->where('id', $id)->delete();
        if ($DelType) {
            Alert::success('', ' تم الحذف  بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', 'فشل الحذف');

            return redirect()->back();
        }

    }

    // SQERAAT
    public function sqeraat()
    {
        $pdata = DB::table(config('constants.tables.TBL_QERAAT'))->get();
        $data = DB::table(config('constants.tables.TBL_SQERAAT'))->get();

        return view('qeraat.sqeraat', compact('data', 'pdata'));
    }

    public function newsqeraat()
    {
        $pdata = DB::table(config('constants.tables.TBL_QERAAT'))->get();
        $data = DB::table(config('constants.tables.TBL_SQERAAT'))->get();

        return view('qeraat.sqeraat', compact('data', 'pdata'));
    }

    public function storesqeraat(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {
                $SQL = DB::table(config('constants.tables.TBL_SQERAAT'))->insert([
                    'name' => $r->name,
                    'parent' => $r->parent,
                    'orders' => $r->orders,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تمت الإضافة بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم اضافة اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

        return view('qeraat.sqeraat');
    }

    public function showsqeraat($id)
    {
        $pdata = DB::table(config('constants.tables.TBL_QERAAT'))->get();
        $data = DB::table(config('constants.tables.TBL_SQERAAT'))->get();
        $dataById = DB::table(config('constants.tables.TBL_SQERAAT'))->where('id', $id)->first();

        return view('qeraat.sqeraat', compact('data', 'dataById', 'pdata'));
    }

    public function updatesqeraat(Request $r, $id)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required',
        ]);

        if ($r->status == 'on') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم إضافة اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                $SQL = DB::table(config('constants.tables.TBL_QERAAT'))->where('id', $id)->update([
                    'name' => $r->name,
                    'parent' => $r->parent,
                    'orders' => $r->orders,
                    'status' => $status,
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    public function destroysqeraat($id)
    {

        $DelType = DB::table(config('constants.tables.TBL_SQERAAT'))->where('id', $id)->delete();
        if ($DelType) {
            Alert::success('', ' تم الحذف  بنجاح');

            return redirect()->back();
        } else {
            Alert::error('خطأ', 'فشل الحذف');

            return redirect()->back();
        }

    }

    /* == Ejazah Passed Students == */
    public function passedEjaza()
    {
        // dd('PASS');
        $data = DB::table(config('constants.tables.TBL_EJAZAH'))
            ->where('status', '=', 'PASS')
            ->whereNotIn('stage', ['TWO', 'MORSALAT', 'COMPLETED'])
            ->get();

        // dd($data);
        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        return view('qeraat.ejaza.passed.passed', compact('data', 'countriesValue', 'countriesKey', 'teachers'));
    }

    public function unpassedEjaza()
    {

        $TBL_EJAZAH = config('constants.tables.TBL_EJAZAH');
        $data = DB::table($TBL_EJAZAH)
            ->whereIn('status', ['REDIRECT', 'REVIEW', 'UNPASS'])
            ->get();

        // dd($data);
        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        return view('qeraat.ejaza.passed.unpassed', compact('data', 'countriesValue', 'countriesKey', 'teachers'));

    }

    public function continuousEjaza()
    {

        $TBL_EJAZAH = config('constants.tables.TBL_EJAZAH');

        $data = DB::table($TBL_EJAZAH)
            ->where(function ($query) {
                $query->where(function ($subQuery) {
                    // (status = ACCEPT OR status = PASS)
                    $subQuery->where('status', 'ACCEPT');
                    // ->orWhere('status', 'PASS');
                })
                    ->where('status', '!=', 'REJECT');
            })

            ->whereIn('stage', ['ONE', 'TWO', 'THREE', 'FOUR', 'MORSALAT'])
            ->get();

        // dd($data);
        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        return view('qeraat.ejaza.passed.continuous', compact('data', 'countriesValue', 'countriesKey', 'teachers'));
    }

    public function uploadEjazahAttachment(Request $request)
    {
        // 1. التحقق من صحة المدخلات
        $request->validate([
            'student_id' => 'required|integer|exists:'.config('constants.tables.TBL_EJAZAH').',id',
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240', // 10MB كحد أقصى
        ]);

        $studentId = $request->input('student_id');
        $file = $request->file('attachment');

        // 2. إعداد مسار واسم الملف
        // استخدم اسم ملف فريد لتجنب التعارض
        $fileName = time().'_'.$studentId.'.'.$file->getClientOriginalExtension();

        // مسار الحفظ النهائي (المجلد المطلوب في سؤالك)
        $destinationPath = config('constants.path.PATH_LOCAL_EJAZAH_COMP');

        // 3. التحقق من وجود وحذف الملف القديم (اختياري لكن موصى به)
        $student = DB::table(config('constants.tables.TBL_EJAZAH'))
            ->where('id', $studentId)
            ->select('ejazah_file')
            ->first();

        if ($student && $student->ejazah_file) {
            // قم بحذف الملف القديم من المسار المطلوب
            $oldFilePath = $destinationPath.'/'.basename($student->ejazah_file);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }
        }

        try {
            // 4. رفع الملف إلى المسار المطلوب
            $file->move($destinationPath, $fileName);

            // 5. حفظ المسار النسبي في قاعدة البيانات
            // نحفظ فقط اسم الملف (أو المسار الكامل بعد 'public_html' إذا أردت)
            // سنحفظ المسار الكامل لسهولة العرض والتحميل
            $dbPath = config('constants.path.PATH_URL_EJAZAH_COMP').$fileName;

            // 6. تحديث قاعدة البيانات باستخدام Query Builder
            DB::table(config('constants.tables.TBL_EJAZAH'))
                ->where('id', $studentId)
                ->update(['ejazah_file' => $fileName, 'updated_at' => now()]);

            // 7. الرد بنجاح AJAX
            $downloadUrl = $dbPath; // لإنشاء رابط تحميل صحيح

            return response()->json([
                'success' => true,
                'message' => 'تم رفع الملف بنجاح.',
                'file_name' => $fileName,
                'download_url' => $downloadUrl,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في رفع الملف: '.$e->getMessage(),
            ], 500);
        }
    }

    /* == Ejazah Passed Students == */
    public function qeraatEjaza()
    {
        $data = DB::table(config('constants.tables.TBL_CEJAZAH'))->where('id', 1)->first();

        return view('qeraat.conditions', compact('data'));
    }

    public function pqeraatEjaza(Request $r)
    {

        $validator = Validator::make($r->all(), [
            'editor' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('خطأ', 'لم يتم تعديل اي  بيانات');

            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            try {

                $SQL = DB::table(config('constants.tables.TBL_CEJAZAH'))->where('id', 1)->update([
                    'conditions' => $r->editor,
                ]);

                if ($SQL) {
                    Alert::success('', 'تم التعديل بنجاح');

                    return redirect()->back();
                } else {
                    Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                    return redirect()->back();
                }

            } catch (\Exception $e) {
                return $e->getMessage();
                // return 'error';
            }

        }

    }

    // ACCEPTED STUDENTS EJAZA
    public function ejusers()
    {

        $data = DB::table(config('constants.tables.TBL_EJAZAH'))
                ->where('ejaza_type', 'yes')
                ->where('stage', 'START')
                ->where(function ($query) {
                    $query->where('status', 'NEW')
                        ->orWhere('status', 'WAIT');
                })
                ->get();

        // $data = DB::table(config('constants.tables.TBL_EJAZAH'))->where('ejaza_type','yes')->where('status','WAIT')->orWhere('status','NEW')->get();
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('qeraat.ejaza.ejazausers', compact('data', 'teachers', 'countriesValue', 'countriesKey'));
    }

    public function ejusersupdate(Request $r)
    {
        // dd($r->all());

        try {
            if ($r->password == '') {
                $SQL = DB::table(config('constants.tables.TBL_USERS'))->where('id', $r->user_id)->update([
                    'name' => $r->fname,
                    'mdlname' => $r->sname,
                    'thrdname' => $r->tname,
                    'lastname' => $r->lname,
                    'extmobile' => $r->kmobile,
                    'mobile' => $r->mobile,
                    'country' => $r->ctry,
                    'nationality' => $r->nat,
                    'gender' => $r->gender,
                    'email' => $r->email,
                ]);
            } else {
                $SQL = DB::table(config('constants.tables.TBL_USERS'))->where('id', $r->user_id)->update([
                    'name' => $r->fname,
                    'mdlname' => $r->sname,
                    'thrdname' => $r->tname,
                    'lastname' => $r->lname,
                    'extmobile' => $r->kmobile,
                    'mobile' => $r->mobile,
                    'country' => $r->ctry,
                    'nationality' => $r->nat,
                    'gender' => $r->gender,
                    'email' => $r->email,
                    'password' => Hash::make($r->password),
                ]);
            }

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }

    }

    // ACCEPT STUDENTS NOT EJAZA
    public function ejnousers()
    {
        $data = DB::table(config('constants.tables.TBL_EJAZAH'))
            ->where('ejaza_type', 'no')
            ->where('stage', 'START')
            ->where(function ($query) {
                $query->where('status', 'NEW')
                    ->orWhere('status', 'WAIT');
            })
            ->get();
        // $data = DB::table(config('constants.tables.TBL_EJAZAH'))->where('ejaza_type','no')->where('status','WAIT')->orWhere('status','NEW')->get();
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('qeraat.ejaza.ejazausers', compact('data', 'teachers', 'countriesValue', 'countriesKey'));
    }

    // REJECTED USERS
    public function ejRejusers()
    {
        $data = DB::table(config('constants.tables.TBL_EJAZAH'))->where('status', 'REJECT')->get();
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('qeraat.ejaza.ejazausersRej', compact('data', 'teachers', 'countriesValue', 'countriesKey'));
    }

    // redirect to the shaikh
    public function unpassedIdEjaza($id)
    {
        // dd($id);
        try {

            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $id)->update([
                'teacher_re' => 'start',
                'back_to_admin' => 'no',
            ]);

            if ($SQL) {
                Alert::success('', 'تم التحويل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    public function ejusersrestore($id)
    {
        try {
            $status = 'NEW';

            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $id)->update([
                'status' => $status,
            ]);

            if ($SQL) {
                Alert::success('', 'تمت الإستعادة  بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    // // Shaikh Users
    // Ejaza Users for shaikh
    public function shlink()
    {
        return view('qeraat.ejaza.shlink');
    }

    public function shlinkid(Request $r)
    {
        try {
            $url = $r->url;
            $id = $r->id;

            $SQL = DB::table(config('constants.tables.TBL_TEACHERS'))->where('id', $id)->update([
                'url' => $url,
            ]);

            if ($SQL) {
                Alert::success('', 'تم تعديل الرابط بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }

        return view('qeraat.ejaza.shlink');
    }

    public function ejshinterviewusers()
    {
        // return auth()->user()->id;

        $teacherId = auth()->user()->id; // افترض أن هذا هو رقم الطالب

        $data = DB::table(config('constants.tables.TBL_EJAZAH'))->where(function ($query) use ($teacherId) {
            // المجموعة الأولى (التي قبل OR): teacher = studentId AND stage = 'START'
            $query->where('teacher', $teacherId)
                ->where('stage', 'START');
        })
            ->orWhere(function ($query) {
                // المجموعة الثانية (التي بعد OR): (stage = 'REDIRECT' OR stage = 'REVIEW') AND teacher_re = 'start'
                $query->where('teacher_re', 'start')
                    ->where(function ($query) {
                        $query->where('status', 'REDIRECT')
                            ->orWhere('status', 'REVIEW');
                    });
            })
            ->get();

        // $data = DB::table(config('constants.tables.TBL_EJAZAH'))->where('teacher',auth()->user()->id)->where('status','WAIT')->where('stage','START')->get();
        // dd(config('constants.tables.TBL_EJAZAH'),$data);
        // return sizeof($data);
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('qeraat.ejaza.sheikh.interview', compact('data', 'teachers', 'countriesValue', 'countriesKey'));
    }

    public function ejshcontinuoususers()
    {
        // dd($this->getQuranPage(2, 5));
        $teacherId = auth()->user()->id;
        $stages = ['ONE', 'TWO', 'THREE', 'FOUR', 'MORSALAT'];
        $status = ['ACCEPT', 'REDIRECT', 'REVIEW', 'PASS', 'UNPASS'];

        $data = DB::table(config('constants.tables.TBL_EJAZAH'))
            ->where('teacher', $teacherId)
            // ->whereIn('status', 'ACCEPT')
            ->whereIn('status', $status)
            ->whereIn('stage', $stages)
            ->get();
        // dd($data);
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('qeraat.ejaza.sheikh.contusers', compact('data', 'teachers', 'countriesValue', 'countriesKey'));

    }

    protected function getQuranPage($sura, $ayah)
    {
        foreach (config('allquranPages.pages') as $page => $range) {

            $start = $range['start'];
            $end = $range['end'];

            if (
                ($sura > $start['sura'] || ($sura == $start['sura'] && $ayah >= $start['ayah'])) &&
                ($sura < $end['sura'] || ($sura == $end['sura'] && $ayah <= $end['ayah']))
            ) {
                return $page;
            }
        }

        return null;
    }

    public function saveHifz(Request $r)
    {
        // 1. التحقق من صحة البيانات
        $r->validate([
            'student_id' => 'required|integer|exists:ejazah,id', // التأكد من استخدام user_id
            'surah_index' => 'required|integer|min:0|max:113', // الفهرس من 0 إلى 113
            'surah_name' => 'required|string|max:50',
            'ayah_number' => 'required|integer|min:1',
        ]);

        // 2. تعيين المتغيرات
        $studentUserId = $r->student_id; // هذا هو user_id الطالب
        $surahIndex = $r->surah_index;
        $surahNumber = $surahIndex + 1; // رقم السورة الفعلي (1-114)
        $surahName = $r->surah_name;
        $ayahNumber = $r->ayah_number;
        $tableName = config('constants.tables.TBL_EJAZAH');
        $tableNameTRK = config('constants.tables.TBL_EJAZAHTRK');

        $checkSora = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $studentUserId)->first();
        $stage = $checkSora->stage;

        $pageNumber = $this->getQuranPage($surahNumber, $ayahNumber);

        if ($surahIndex >= 113) {
            $stage = 'COMPLETED';
        } elseif ($surahIndex >= 76) {
            $stage = 'MORSALAT';
        } elseif ($surahIndex >= 17) {
            $stage = 'TWO';
        }

        if ($stage == 'MORSALAT' and $checkSora->decision3 == 'D1') {
            $hifz_status_prog = 'مشافهة';
        } else {
            $hifz_status_prog = 'حاليا لايوجد';
        }

        /*
        if($surahNumber >= 17) {
            $stage = 'TWO';
        } elseif($surahNumber >= 76) {
            $stage = 'MORSALAT';
        } elseif($surahNumber >= 113) {
            $stage = 'COMPLETED';
        }*/
        // TBL_EJAZAHTRK

        DB::table($tableNameTRK)->insert([
            'ejazah_id' => $studentUserId,
            'page_number' => $pageNumber,
            'created_at' => Carbon::now(), // يمكنك استخدام now() لتاريخ ووقت الإنشاء
        ]);

        // 3. تنفيذ عملية التحديث
        $updatedRows = DB::table($tableName)
            // الشرط: نبحث باستخدام user_id الذي يطابق student_id المرسل
            ->where('id', $studentUserId)
            ->update([
                // يُفضل تخزين الفهرس (0-113) بدلاً من رقم السورة إذا كان الـ JS يستخدم الفهرس
                'surah_index' => $surahIndex,
                // إذا كان الحقل في DB يخزن رقم السورة الفعلي: 'surah_number' => $surahNumber,
                'stage' => $stage,
                'surah_name' => $surahName,
                'ayah_number' => $ayahNumber,
                'page_number' => $pageNumber,
                'updated_at' => Carbon::now(), // استخدام Carbon لتاريخ أكثر دقة
            ]);

        // 4. إرجاع الاستجابة النهائية بناءً على نتيجة التحديث
        if ($updatedRows > 0) {
            // النجاح: تم التحديث
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث موضع الحفظ بنجاح.',
                'surah_name' => $surahName, // لتحديث صف الطالب في الـ AJAX
                'ayah_number' => $ayahNumber,
                'hifz_status_prog' => $hifz_status_prog,
                'page_number' => $pageNumber, // إرجاع رقم الصفحة للواجهة الأمامية
            ], 200);

        } else {
            // الفشل: لم يتم العثور على سجل للتحديث
            // هذا يحدث عادةً إذا كان السجل غير موجود أو كانت البيانات مطابقة للبيانات القديمة
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على سجل حفظ للطالب لتحديثه أو أن البيانات المدخلة لم تتغير.',
                'student_id' => $studentUserId,
            ], 404);
        }
    }

    public function updateStatus(Request $r, $studentId)
    {
        try {

            $checkFirst = DB::table(config('constants.tables.TBL_EJAZAH'))->WHERE('id', $studentId)->first();
            if (! $checkFirst) {
                Alert::error('خطأ', 'لاتوجد بيانات');

                return redirect()->back();
            }
            // status
            $inputStatus = $r->input('status');

            $newStatusValue = $checkFirst->status;
            $newteacher_reValue = 'stop';
            $message = '';

            if ($inputStatus === 'pass') {
                $newStatusValue = 'PASS';

                $message = 'تم تعيين حالة الطالب كـ "مؤهل" .';
            } elseif ($inputStatus === 'unpass') {

                $message = 'تم تعيين حالة الطالب كـ "غير مؤهل".';
            } else {
                // حالة غير صالحة
                $message = 'قيمة الحالة غير صالحة';
                Alert::error('خطأ', $message);

                return redirect()->back();

            }

            // dd($newStatusValue,$inputStatus,$checkFirst);

            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $studentId)->update([
                'status' => $newStatusValue,
                'teacher_re' => $newteacher_reValue,
            ]);

            if ($SQL) {
                Alert::success('', $message);

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    public function ejshyusers()
    {
        // return auth()->user()->id;
        $data = DB::table(config('constants.tables.TBL_EJAZAH'))->where('teacher', auth()->user()->id)->where('status', 'WAIT')->where('stage', 'START')->where('ejaza_type', 'yes')->get();
        // return sizeof($data);
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        /*
        echo '<pre>';

        print_r($countriesKey);
        print_r($countriesValue);
        echo '</pre>';
        dd();*/
        return view('qeraat.ejaza.ejazashusers', compact('data', 'teachers', 'countriesValue', 'countriesKey'));
    }

    // Not Ejaza Users for shaikh
    public function ejshnusers()
    {
        // return auth()->user()->id;
        $data = DB::table(config('constants.tables.TBL_EJAZAH'))->where('teacher', auth()->user()->id)->where('status', 'PASS')->where('stage', 'START')->get(); // ->where('ejaza_type','no')
        // return sizeof($data);
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status', 'yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }

        return view('qeraat.ejaza.ejazashusers', compact('data', 'teachers', 'countriesValue', 'countriesKey'));
    }

    public function ejusersteacherinterviewstagetwo(Request $r)
    {
        try {
            if ($r->decision2 == 'D1') {
                $decision = 'PASS';
            } elseif ($r->decision2 == 'D2') {
                $decision = 'REDIRECT';
            } elseif ($r->decision2 == 'D3') {
                $decision = 'REVIEW';
            } elseif ($r->decision2 == 'D4') {
                $decision = 'UNPASS';
            }
            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $r->user_ejazah_id)->update([
                'decision2' => $r->decision2,
                'date_s2' => $r->date_s2,
                'status2' => $decision,
            ]);

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    public function ejusersteacherinterviewstagemorsalat(Request $r)
    {
        try {
            if ($r->decision3 == 'D1') {
                $decision = 'PASS';
            } elseif ($r->decision3 == 'D2') {
                $decision = 'REDIRECT';
            } elseif ($r->decision3 == 'D3') {
                $decision = 'REVIEW';
            } elseif ($r->decision3 == 'D4') {
                $decision = 'UNPASS';
            }
            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $r->user_ejazah_id)->update([
                'decision3' => $r->decision3,
                'date_s3' => $r->date_s3,
                'status3' => $decision,
            ]);

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    public function ejusersteacherinterviewstagecompleted(Request $r) {}

    /*== Start Essensial funs==
    //PATHs
    protected $FLOC_EJAZAH     = config('constants.path.PATH_URL_EJAZAH');
    protected $FURL_EJAZAH     = config('constants.path.PATH_LOCAL_EJAZAH');
    protected $FURLCOMP_EJAZAH = config('constants.path.PATH_URL_EJAZAH_COMP');
    protected $FLOCCOMP_EJAZAH = config('constants.path.PATH_LOCAL_EJAZAH_COMP');

    //TBLs
    protected $TBL_EJAZAH      = config('constants.tables.TBL_EJAZAH');
    /*== End Essensial funs==*/

    // upload student Ejaza file
    public function uploadStudentEjazaFile(Request $r)
    {
        // 1. التحقق من صحة الطلب
        $request->validate([
            'student_id' => 'required|exists:'.config('constants.tables.TBL_EJAZAH').',id',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // حد أقصى 5 ميجا
        ]);

        $studentId = $request->input('student_id');
        $file = $request->file('file');

        // 2. معالجة وحفظ الملف
        try {
            // إنشاء اسم ملف فريد
            $fileName = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();

            // المسار الكامل للرفع (باستخدام public_path للوصول إلى public_html/uploads)
            $destinationPath = config('constants.path.PATH_LOCAL_EJAZAH_COMP');

            // التأكد من وجود مجلد الرفع
            if (! File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // نقل الملف
            $file->move($destinationPath, $fileName);

            // مسار الملف لحفظه في قاعدة البيانات (المسار النسبي)
            $filePath = config('constants.path.PATH_URL_EJAZAH_COMP').$fileName;

            // 3. تحديث مسار الملف في قاعدة البيانات باستخدام Query Builder
            $tableName = config('constants.tables.TBL_EJAZAH');
            $updated = DB::table($tableName)
                ->where('id', $studentId)
                ->update(['ejazah_file' => $fileName]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم رفع الملف وتحديث قاعدة البيانات بنجاح.',
                    'file_url' => $filePath,
                    'student_id' => $studentId,
                ]);
            } else {
                // قد يكون تحديث البيانات فشل (مثل عدم وجود صف بهذا ID)
                return response()->json(['success' => false, 'message' => 'فشل في تحديث قاعدة البيانات.'], 500);
            }

        } catch (\Exception $e) {
            // إرجاع استجابة JSON للخطأ
            return response()->json(['success' => false, 'message' => 'فشل في الرفع: '.$e->getMessage()], 500);
        }
    }

    public function ejusersteacherinterview(Request $r)
    {

        // dd($r->all());

        /*
        start_date
        tjweed_q1
        tjweed_q2
        tjweed_q3
        tjweed_q4
        tjweed_q5
        tjweed_level
        telawa_level
        keep_level
        n1_s1
        n2_s1
        n3_s1
        n4_s1
        decision1
        sh1_s1
        sh2_s1
        date_s1
        user_ejazah_id=>id
        */

        try {
            if ($r->decision1 == 'D1') {
                $decision = 'PASS';
            } elseif ($r->decision1 == 'D2') {
                $decision = 'REDIRECT';
            } elseif ($r->decision1 == 'D3') {
                $decision = 'REVIEW';
            } elseif ($r->decision1 == 'D4') {
                $decision = 'UNPASS';
            }
            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $r->user_ejazah_id)->update([
                'stage' => 'ONE',
                // 'start_date'=>$r->start_date,
                'tjweed_q1' => $r->tjweed_q1,
                'tjweed_q2' => $r->tjweed_q2,
                'tjweed_q3' => $r->tjweed_q3,
                'tjweed_q4' => $r->tjweed_q4,
                'tjweed_q5' => $r->tjweed_q5,
                'tjweed_level' => $r->tjweed_level,
                'n1_s1' => $r->n1_s1,
                'n2_s1' => $r->n2_s1,
                'n3_s1' => $r->n3_s1,
                'n4_s1' => $r->n4_s1,
                'decision1' => $r->decision1,
                'sh1_s1' => $r->sh1_s1,
                'sh2_s1' => $r->sh2_s1,
                'date_s1' => $r->date_s1,
                'status' => $decision,
            ]);

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }

    }

    public function ejusersteacherassign(Request $r)
    {
        // return $r->user_ejazah_id.' - '.$r->teacher_id;
        try {

            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $r->user_ejazah_id)->update([
                'teacher' => $r->teacher_id,
            ]);

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    public function ejusersacceptreject($id, $status)
    {
        try {
            // NEW', 'WAIT', 'PASS', 'ACCEPT', 'REJECT'
            if ($status == 'wait') {
                $status = 'WAIT';
            } elseif ($status == 'pass') {
                $status = 'PASS';
            } elseif ($status == 'accept') {
                $status = 'ACCEPT';
            } elseif ($status == 'reject') {
                $status = 'REJECT';
            }

            $SQL = DB::table(config('constants.tables.TBL_EJAZAH'))->where('id', $id)->update([
                'status' => $status,
            ]);

            if ($SQL) {
                Alert::success('', 'تم التعديل بنجاح');

                return redirect()->back();
            } else {
                Alert::error('خطأ', 'لم يتم تعديل اي بيانات');

                return redirect()->back();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
            // return 'error';
        }
    }

    public function ejfusersByEjazah($id)
    {
        return $id;
    }

    public function ejfusersByMujaz($id)
    {
        return $id;
    }

    public function ejfusersByCountry($id)
    {
        return $id;

        $data = DB::table(config('constants.tables.TBL_EJAZAH'))->get();
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status','yes')->get();

        return view('qeraat.ejaza.ejazausers', compact('data','teachers'));
    }

    // Accepted Users
    public function ejazahAceeptedUsers()
    {
        $data = DB::table(config('constants.tables.TBL_EJAZAH'))->WHERE('status','ACCEPT')->get();
        // return sizeof($data);
        // $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status','yes')->get();

        $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
        $countriesKey = [];
        $countriesValue = [];
        foreach ($countries as $row) {
            $countriesKey[] = $row->id;
            $countriesValue[] = $row->country;
        }
        $teachers = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('status','yes')->get();

        return view('qeraat.ejaza.ejazausersACC', compact('data','countriesValue','countriesKey','teachers'));
    }
}
