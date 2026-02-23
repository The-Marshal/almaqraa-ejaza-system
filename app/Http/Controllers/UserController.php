<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // جلب أسماء الجداول من ملف constants
    private function getTables()
    {
        return [
            'users' => config('constants.tables.TBL_USERS'),
            'countries' => config('constants.tables.TBL_COUNTRIES'),
        ];
    }

    public function index()
    {
        $tables = $this->getTables();
        $countries = DB::table($tables['countries'])->get();

        return view('users.index', compact('countries'));
    }
    /*
        public function fetch(Request $request) {
            $tables = $this->getTables();
            $search = $request->search;

            $users = DB::table($tables['users'] . ' as u')
                ->leftJoin($tables['countries'] . ' as c', 'u.country', '=', 'c.id')
                ->select('u.*', 'c.country as country_name')
                ->when($search, function($q) use ($search) {
                    return $q->where('u.name', 'like', "%$search%")
                             ->orWhere('u.email', 'like', "%$search%")
                             ->orWhere('u.mobile', 'like', "%$search%");
                })
                ->orderBy('u.id', 'desc')
                ->paginate(10);

            return view('users.partials._table', compact('users'))->render();
        }*/

    public function fetch(Request $request)
    {
        $tables = $this->getTables();
        $search = $request->search;

        // استخدام try-catch لمعرفة الخطأ بدقة
        try {
            $users = DB::table($tables['users'].' as u')
                // ربط بلد الإقامة
                ->leftJoin($tables['countries'].' as c', 'u.country', '=', 'c.id')
                // ربط الجنسية (مع التأكد من استخدام Alias مختلف 'n')
                ->leftJoin($tables['countries'].' as n', 'u.nationality', '=', 'n.id')
                ->select(
                    'u.*',
                    'c.country as country_name',
                    'n.country as nationality_name'
                )
                ->when($search, function ($q) use ($search) {
                    return $q->where(function ($query) use ($search) {
                        $query->where('u.name', 'like', "%$search%")
                            ->orWhere('u.mdlname', 'like', "%$search%")
                            ->orWhere('u.thrdname', 'like', "%$search%")
                            ->orWhere('u.lastname', 'like', "%$search%")
                            ->orWhere('u.email', 'like', "%$search%")
                            ->orWhere('u.mobile', 'like', "%$search%");
                    });
                })
                ->orderBy('u.id', 'desc')
                ->paginate(10);

            return view('users.partials._table', compact('users'))->render();

        } catch (\Exception $e) {
            // في حال استمر الخطأ، سيظهر لك السبب في المتصفح بدلاً من 500
            return "<div class='alert alert-danger'>خطأ في قاعدة البيانات: ".$e->getMessage().'</div>';
        }
    }

    public function save(Request $request)
    {
        $tables = $this->getTables();
        $id = $request->user_id;

        $validator = Validator::make($request->all(), [
            'name' => 'required', 'mdlname' => 'required', 'thrdname' => 'required', 'lastname' => 'required',
            'email' => 'required|email|unique:'.$tables['users'].',email,'.$id,
            'mobile' => 'required', // سيتم استلام الرقم كاملاً مع المفتاح
            'country' => 'required',
            'nationality' => 'required',
            'gender' => 'required',
            'password' => $id ? 'nullable|min:6' : 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()], 422);
        }

        $data = $request->only(['name', 'mdlname', 'thrdname', 'lastname', 'email', 'mobile', 'country', 'nationality', 'gender']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($id) {
            DB::table($tables['users'])->where('id', $id)->update($data);

            return response()->json(['status' => 'success', 'message' => 'تم تحديث البيانات']);
        } else {
            $data['created_at'] = now();
            DB::table($tables['users'])->insert($data);

            return response()->json(['status' => 'success', 'message' => 'تم الحساب بنجاح']);
        }
    }

    public function destroy($id)
    {
        DB::table($this->getTables()['users'])->where('id', $id)->delete();

        return response()->json(['status' => 'success']);
    }

    /* Mods */

    // عرض الصفحة
    public function modIndex()
    {
        if (auth()->user()->level !== 'admin') {
            abort(403);
        } // حماية إضافية للمدير فقط
        $mods = Admin::where('level', 'mod')->orderBy('id', 'desc')->get();

        return view('admins.index', compact('mods'));
    }

    // حفظ (إضافة أو تحديث)
    public function modSave(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'email' => 'required|email|unique:admin,email,'.$request->id,
        ];

        // كلمة المرور مطلوبة فقط عند الإضافة
        if (! $request->id) {
            $rules['password'] = 'required|min:6';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'level' => 'mod', // تعيين الرتبة كمشرف
            'status' => 'yes',
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        Admin::updateOrCreate(['id' => $request->id], $data);

        return response()->json(['success' => 'تم حفظ بيانات المشرف بنجاح!']);
    }

    // جلب بيانات للتعديل
    public function modEdit($id)
    {
        $mod = Admin::findOrFail($id);

        return response()->json($mod);
    }

    // الحذف
    public function modDestroy($id)
    {
        Admin::where('id', $id)->where('level', 'mod')->delete();

        return response()->json(['success' => 'تم حذف المشرف بنجاح!']);
    }

    // التحكم في المشرفين
    public function toggleModStatus(Request $request, $id)
    {
        try {
            // البحث عن المستخدم في جدول admin
            $admin = \App\Models\Admin::findOrFail($id);

            // عكس الحالة الحالية
            $admin->status = ($admin->status == 'yes') ? 'no' : 'yes';
            $admin->save();

            return response()->json([
                'success' => true,
                'new_status' => $admin->status,
                'message' => ($admin->status == 'yes') ? 'تم تفعيل الحساب بنجاح' : 'تم تعطيل الحساب بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء التحديث'], 500);
        }
    }
}
