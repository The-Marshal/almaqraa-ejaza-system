@extends('layouts.mainapp')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
<style>
    .iti { width: 100%; } /* لضبط حقل الجوال */
    .pagination svg { width: 20px; } /* تصغير أيقونات الترقيم */
</style>
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">إدارة المستخدمين</h6>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">المستخدمين</a></li>
                <li class="breadcrumb-item active">إدارة الحسابات</li>
            </ol>
        </div>
    </div>
</div>
<div class="container-fluid py-4" dir="rtl text-end">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="text-primary mb-0"><i class="fas fa-users"></i> إدارة المستخدمين</h5>
            <button class="btn btn-primary shadow-sm" onclick="openUserModal()">إضافة مستخدم جديد</button>
        </div>
        <div class="card-body">
            <input type="text" id="searchInput" class="form-control w-25 mb-3" placeholder="بحث سريع...">
            <div id="tableContainer"> </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="userForm" class="modal-content border-0 shadow-lg">
            @csrf
            <input type="hidden" name="user_id" id="user_id">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">بيانات الحساب</h5>
            </div>
            <div class="modal-body row g-3 text-start">
                <div class="col-md-3"><label>الاسم الأول</label><input type="text" name="name" id="f_name" class="form-control" required></div>
                <div class="col-md-3"><label>الأب</label><input type="text" name="mdlname" id="f_mdlname" class="form-control" required></div>
                <div class="col-md-3"><label>الجد</label><input type="text" name="thrdname" id="f_thrdname" class="form-control" required></div>
                <div class="col-md-3"><label>العائلة</label><input type="text" name="lastname" id="f_lastname" class="form-control" required></div>
                
                <div class="col-md-6"><label>البريد الإلكتروني</label><input type="email" name="email" id="f_email" class="form-control" dir="ltr" required></div>
                <div class="col-md-6" dir="ltr">
                    <label class="d-block text-end">رقم الجوال</label>
                    <input type="tel" name="mobile" id="f_mobile" class="form-control" required>
                </div>
                
<div class="col-md-6 mb-3">
    <label>بلد الإقامة</label>
    <select name="country" id="f_country" class="form-select select2">
        @foreach($countries as $c) 
            <option value="{{ $c->id }}">{{ $c->country }}</option> 
        @endforeach
    </select>
</div>
<div class="col-md-6 mb-3">
    <label class="form-label">الجنسية</label>
    <select name="nationality" id="f_nationality" class="form-select select2" required>
        <option value="">اختر الجنسية...</option>
        @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->country }}</option>
        @endforeach
    </select>
</div>              
                <div class="col-md-6"><label>الجنس</label>
                    <select name="gender" id="f_gender" class="form-select">
                        <option value="male">ذكر</option><option value="female">أنثى</option>
                    </select>
                </div>
                <div class="col-md-12"><label>كلمة المرور</label><input type="password" name="password" class="form-control"></div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary px-5" id="saveBtn">حفظ البيانات</button></div>
        </form>
    </div>
</div>
@endsection

@section('cssSection')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container { width: 100% !important; }
    .select2-container--default .select2-selection--single { height: 38px; border: 1px solid #dee2e6; }
    /* لضمان ظهور القائمة فوق المودال */
    .select2-dropdown { z-index: 9999; }
</style>
@endsection

@section('scriptSection')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let phoneInput;
$(document).ready(function() {
    
// استيراد ملف المكتبة أولاً
$.getScript('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', function() {
    
    // تفعيل البحث على الحقول
    $('.select2').select2({
        dropdownParent: $('#userModal'), // مهم جداً لكي يعمل البحث داخل المودال
        dir: "rtl",
        language: "ar"
    });

});    
    
    // إعداد حقل الجوال الدولي
    const mobileField = document.querySelector("#f_mobile");
    phoneInput = window.intlTelInput(mobileField, {
        separateDialCode: true,
        initialCountry: "sa",
        preferredCountries: ["sa", "ae", "jo", "kw"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
    });

    loadTable();

    // البحث الفوري
    $('#searchInput').on('keyup', function() { loadTable(1, $(this).val()); });

    // حل مشكلة الصفحة البيضاء في الترقيم
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        loadTable($(this).attr('href').split('page=')[1], $('#searchInput').val());
    });

    // الحفظ الذكي
    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serializeArray();
        
        // دمج مفتاح الدولة مع الرقم تلقائياً
        formData.find(item => item.name === 'mobile').value = phoneInput.getNumber();

        $.ajax({
            url: "{{ route('users.ajax.save') }}",
            method: "POST",
            data: $.param(formData),
            success: function(res) {
                $('#userModal').modal('hide');
                Swal.fire('نجاح', res.message, 'success');
                loadTable();
            },
            error: function(err) {
                Swal.fire('خطأ', err.responseJSON.errors.join('<br>'), 'error');
            }
        });
    });
});

function loadTable(page = 1, search = '') {
    $.get("{{ route('users.ajax.fetch') }}?page=" + page + "&search=" + search, function(data) {
        $('#tableContainer').html(data);
    });
}


function openUserModal(user = null) {
    $('#userForm')[0].reset();
    $('#user_id').val('');

    // تصفير حقول الـ Select2 عند الإضافة لضمان عدم بقاء قيم قديمة
    $('#f_country, #f_nationality').val(null).trigger('change');

    if(user) {
        $('#user_id').val(user.id);
        $('#f_name').val(user.name);
        $('#f_mdlname').val(user.mdlname);
        $('#f_thrdname').val(user.thrdname);
        $('#f_lastname').val(user.lastname);
        $('#f_email').val(user.email);
        
        // هنا التعديل: نضع القيمة ثم نخبر Select2 بالتحديث
        $('#f_country').val(user.country).trigger('change');
        $('#f_nationality').val(user.nationality).trigger('change');
        
        $('#f_gender').val(user.gender);
        phoneInput.setNumber(user.mobile);
    }
    $('#userModal').modal('show');
}

/*
function openUserModal(user = null) {
    $('#userForm')[0].reset();
    $('#user_id').val('');
    if(user) {
        $('#user_id').val(user.id);
        $('#f_name').val(user.name);
        $('#f_mdlname').val(user.mdlname);
        $('#f_thrdname').val(user.thrdname);
        $('#f_lastname').val(user.lastname);
        $('#f_email').val(user.email);
        $('#f_country').val(user.country);
        $('#f_nationality').val(user.nationality);
        $('#f_gender').val(user.gender);
        phoneInput.setNumber(user.mobile); // وضع الرقم القديم في حقل الجوال الذكي
    }
    $('#userModal').modal('show');
}*/
</script>
@endsection