@extends('layouts.mainapp')

@section('cssSection')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* تحسينات بصرية */
    .empty-state { padding: 40px; text-align: center; background: #fff; border-radius: 15px; }
    .empty-state i { font-size: 80px; color: #e3e6f0; margin-bottom: 20px; display: block; }
    .empty-state h5 { color: #858796; font-weight: 600; }
    .modal-header { background: linear-gradient(45deg, #4e73df, #224abe); color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; }
    .btn-close-white { filter: brightness(0) invert(1); }
    .card { border-radius: 15px; overflow: hidden; }
</style>
@endsection

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">إدارة صلاحيات النظام</h6>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">المستخدمين</a></li>
                <li class="breadcrumb-item active">المشرفين والمشرفات</li>
            </ol>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary btn-rounded shadow-sm" onclick="addMod()">
                <i class="fas fa-plus-circle me-1"></i> إضافة مشرف جديد
            </button>
        </div>
    </div>
</div>
<div class="container-fluid py-4 text-end" dir="rtl">
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0" id="modsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3">الاسم الكامل</th>
                            <th>البريد الإلكتروني</th>
                            <th>الرتبة / الجنس</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mods as $mod)
                        <tr id="row_{{ $mod->id }}">
                            <td class="fw-bold text-dark">{{ $mod->name }}</td>
                            <td>{{ $mod->email }}</td>
                            <td>
                                @if($mod->gender == 'M')
                                    <span class="badge bg-info-subtle text-info border border-info px-3">
                                        <i class="fas fa-user-shield me-1"></i> مشرف
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-3">
                                        <i class="fas fa-user-graduate me-1"></i> مشرفة
                                    </span>
                                @endif
                            </td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input status-toggle" 
                                               type="checkbox" 
                                               data-id="{{ $mod->id }}" 
                                               {{ $mod->status == 'yes' ? 'checked' : '' }} 
                                               style="cursor: pointer; width: 40px; height: 20px;">
                                    </div>
                                </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary rounded-circle" onclick="editMod({{ $mod->id }})" title="تعديل">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-circle ms-1" onclick="deleteMod({{ $mod->id }})" title="حذف">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-0">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <h5>لا يوجد مشرفين أو مشرفات حالياً</h5>
                                    <p class="text-muted">يمكنك البدء بإضافة أول مشرف للنظام عبر الزر في الأعلى</p>
                                    <button class="btn btn-outline-primary btn-sm mt-2" onclick="addMod()">إضافة الآن</button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow border-0">
            <form id="modForm">
                @csrf
                <input type="hidden" name="id" id="mod_id">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i> <span id="modalTitle">إضافة مشرف</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">الاسم الكامل</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                            <input type="text" name="name" id="name" class="form-control" placeholder="مثال: أحمد محمد" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">البريد الإلكتروني</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="name@email.com" required>
                        </div>
                    </div>
                    <div class="mb-3" id="pass_div">
                        <label class="form-label fw-bold">كلمة المرور</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-lock text-primary"></i></span>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <small class="text-info" id="pass_note" style="display:none;">* اترك الحقل فارغاً إذا كنت لا تريد تغيير كلمة المرور</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">الجنس</label>
                        <select name="gender" id="gender" class="form-select border-primary-subtle">
                            <option value="M">ذكر (مشرف)</option>
                            <option value="F">أنثى (مشرفة)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary px-4" id="saveBtn">حفظ البيانات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scriptSection')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // 1. تغيير الحالة (تفعيل/تعطيل)
// البحث عن جزء تبديل الحالة وتعديل الرابط (URL)
$(document).on('change', '.status-toggle', function() {
    let checkbox = $(this);
    let id = checkbox.data('id');

    $.ajax({
        // تأكد أن الرابط يبدأ بـ /moderators-management/
        url: `/moderators-management/toggle-status/${id}`, 
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}" // تأكد من إرسال التوكن
        },
        success: function(response) {
            // كود النجاح (Toast)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({ icon: 'success', title: response.message });
        },
        error: function(xhr) {
            // في حال الفشل يظهر لك "تعذر الاتصال"
            checkbox.prop('checked', !checkbox.prop('checked'));
            Swal.fire({ icon: 'error', title: 'خطأ!', text: 'تعذر الاتصال بالسيرفر' });
                
            console.log(xhr.responseText); 
            
        }
    });
});

    // 2. إضافة مشرف
    function addMod() {
        $('#modForm')[0].reset();
        $('#mod_id').val('');
        $('#modalTitle').text('إضافة مشرف جديد');
        $('#pass_note').hide();
        $('#modModal').modal('show');
    }

    // 3. تعديل مشرف (جلب البيانات)
    function editMod(id) {
        $.get(`/moderators-management/edit/${id}`, function(data) {
            $('#mod_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#gender').val(data.gender);
            $('#modalTitle').text('تعديل بيانات المشرف');
            $('#pass_note').show();
            $('#modModal').modal('show');
        });
    }

    // 4. حفظ البيانات (إضافة/تعديل)
    $('#modForm').on('submit', function(e) {
        e.preventDefault();
        let btn = $('#saveBtn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...');

        $.ajax({
            url: "{{ route('mods.ajax.save') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                $('#modModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'تمت العملية', text: res.success, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('حفظ البيانات');
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'حدث خطأ في البيانات';
                Swal.fire('خطأ!', errorMsg, 'error');
            }
        });
    });

    // 5. الحذف
    function deleteMod(id) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف حساب المشرف نهائياً!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/moderators-management/delete/${id}`,
                    method: "DELETE",
                    success: function(res) {
                        $(`#row_${id}`).fadeOut();
                        Swal.fire('تم!', res.success, 'success');
                    }
                });
            }
        });
    }
</script>
@endsection