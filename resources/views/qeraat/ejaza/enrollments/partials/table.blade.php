{{-- resources/views/qeraat/ejaza/enrollments/partials/table.blade.php --}}


@php
    $firstItem = $items->first();
    $isNewTab = ($firstItem && $firstItem->status == 'new');
    // سنحدد ظهور العمود إذا كان التبويب يحتوي على طلاب مؤهلين
    $isContinuousTab = ($firstItem && $firstItem->teacher_decision == 'qualified' && !is_null($firstItem->admin_id));
    
    $isAdmin = in_array(Auth::user()->level, ['admin', 'mod']);
 
    
@endphp
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0 text-center border">
        <thead class="bg-light text-dark fw-bold">
            <tr>
                <th class="py-3 text-start">اسم الطالب</th>
                <th>الإقامة/الجنسية</th>
                <th scope="col">الجنس</th>
                <th>القراءة / الرواية</th>
                @if($isContinuousTab)
                <th>مقدار التلاوة</th>
                @endif

                @if($isAdmin)
                <th class="d-none">الشيخ</th>
                @if($isNewTab)
                    <th>المؤهلات/المرفقات</th>
                @endif
                @endif
                <th>حالة الطالب</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            @php
                $student_id = $item->id;
                $isAssignedTeacher = (Auth::id() == $item->admin_id);
                $current_surah_index = $item->surah_index;
                $current_ayah = $item->ayah_number ?? "";
                
                // تعريف المتغير هنا في بداية الحلقة ليتم التعرف عليه في كل الصفوف والتبويبات
                $isCompleted = ($item->surah_index >= 113 || $item->moshafaha == 'yes' || !empty($item->moshafaha_file));

				$isPendingMushafaha = in_array($item->status, ['mushafaha', 'completed', 'qualified_for_license']) && 
                              $item->surah_index >= 76 && 
                              $item->moshafaha != 'yes' && 
                              empty($item->moshafaha_file);

                // الحالات التي تتطلب تحديث قرار
                $needsDecisionUpdate = in_array($item->teacher_decision, ['refer_to_teacher', 'review_theory']);
                
                // شرط ظهور زر تحديد الموضع
                $canSetPosition = ($item->teacher_decision == 'qualified' && $item->status != 'pending_interview');
            @endphp
            <tr>

<td class="text-start">
    <div class="d-flex flex-column gap-2">
        {{-- 1. اسم الطالب + أيقونة الواتساب الذكية --}}
                    <div class="d-flex align-items-center gap-2">
            <a href="javascript:void(0);" onclick="viewInterviewResult({{ $item->id }})" class="text-primary fw-bold">
            <span class="fw-bold text-dark" style="font-size: 15px;">
                {{ $item->user->full_name ?? ($item->user->name . ' ' . $item->user->lastname) }}
            </span>
            </a>
            
            {{-- أيقونة الواتساب (تفتح المحادثة مباشرة بدون نص مسبق) --}}
            @if(isset($item->user->mobile) && $item->user->mobile)
                @php
                    // تنظيف الرقم من أي رموز زائدة مثل + أو مسافات
                    $phone = preg_replace('/[^0-9]/', '', $item->user->mobile);
                    
                    // معالجة الأرقام المحلية (مثلاً السعودية: تحويل 05 إلى 9665)
                    // إذا كان الرقم يبدأ بـ 0 وطوله 10 أرقام
                    if (str_starts_with($phone, '0') && strlen($phone) == 10) {
                        $phone = '966' . substr($phone, 1);
                    }
                @endphp
                
                <a href="https://wa.me/{{ $phone }}" 
                   target="_blank" 
                   title="تواصل عبر واتساب" 
                   style="color: #25D366; text-decoration: none;"
                   onmouseover="this.style.transform='scale(1.2)'" 
                   onmouseout="this.style.transform='scale(1)'">
                    <i class="fab fa-whatsapp" style="font-size: 18px; transition: transform 0.2s;"></i>
                </a>
            @endif
        </div>


{{-- ميزة تغيير الشيخ الذكية --}}
@if($isAdmin)
    <div class="ms-1 teacher-quick-cell" data-id="{{ $item->id }}" style="position: relative; display: inline-block; vertical-align: middle;">
        <div class="teacher-trigger-icon" style="cursor: pointer;" title="انقر لتعيين أو تغيير الشيخ">
            @if($item->admin_id)
                {{-- الحالة: يوجد شيخ (تصميم أزرق واضح) --}}
                <span class="badge bg-soft-primary text-primary border border-primary-subtle d-inline-flex align-items-center" 
                      style="font-size: 11px; padding: 4px 8px; font-weight: 600;">
                    <i class="fas fa-user-tie me-1"></i>
                    <span class="current-t-name">{{ $item->teacher->name ?? 'شيخ' }}</span>
                </span>
            @else
                {{-- الحالة: لا يوجد شيخ (تصميم رمادي تفاعلي مع نص واضح) --}}
                <span class="badge border border-secondary d-inline-flex align-items-center shadow-sm" 
                      style="font-size: 11px; padding: 4px 8px; font-weight: 700; color: #333; background-color: #f8f9fa; transition: all 0.2s;"
                      onmouseover="this.style.backgroundColor='#e2e6ea'; this.style.borderColor='#adb5bd'" 
                      onmouseout="this.style.backgroundColor='#f8f9fa'; this.style.borderColor='#6c757d'">
                    <i class="fas fa-user-exclamation me-1 text-danger"></i>
                    <span>بانتظار تعيين شيخ</span>
                </span>
            @endif
        </div>

        {{-- القائمة المنسدلة للتبديل السريع --}}
        <select class="form-select form-select-sm quick-teacher-select d-none" 
                style="font-size: 11px; height: 28px; width: 170px; position: absolute; top: 100%; right: 0; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <option value="">-- إلغاء تعيين الشيخ --</option>
            @foreach($teachers as $t)
                <option value="{{$t->id}}" {{ $item->admin_id == $t->id ? 'selected' : '' }}>{{$t->name}}</option>
            @endforeach
        </select>
    </div>
@endif



        {{-- 2. قسم الشيخ (يظهر فقط للمدير) --}}
        @if($isAdmin)
            <div class="d-flex align-items-center gap-2">
                @if($item->admin_id)
                    {{-- وسم بارز يوضح التبعية مع زر تعديل صغير --}}
                    <span class="badge rounded-pill bg-soft-info text-info border border-info px-2 py-1" style="font-size: 11px; font-weight: 600;">
                        <i class="fas fa-graduation-cap me-1"></i>
                        يتعلم لدى : 
                        <span class="text-dark fw-bold">{{ $item->teacher->name ?? 'غير محدد' }}</span>
                    </span>
                    
                    {{-- زر تعديل الشيخ --}}
                    <button class="btn btn-sm btn-outline-secondary py-0 px-2 border-0 d-none" 
                            style="font-size: 10px;" 
                            data-bs-toggle="modal" 
                            data-bs-target="#adminModal{{$item->id}}"
                            title="تعديل الشيخ المخصص">
                        <i class="fas fa-user-edit text-muted"></i>
                    </button>
                @else
                
                    {{-- الشروط الخاصة بظهور زر تحديد الشيخ --}}
                    @php
                        $isExcludedStatus = in_array($item->teacher_decision, ['not_qualified', 'review_theory']);
                    @endphp                
                
                    @if($isNewTab) 
                        <span class="badge bg-soft-danger text-danger border px-2 py-1 small" style="font-size: 10px;">
                            <i class="fas fa-clock me-1"></i> بانتظار قرار المدير
                        </span>
                    @elseif(!$isExcludedStatus)
                        @if($item->status !== 'rejected')
                        <button class="btn btn-xs btn-danger py-0 px-2 rounded-pill" 
                                style="font-size: 10px;" 
                                data-bs-toggle="modal" 
                                data-bs-target="#adminModal{{$item->id}}">
                            <i class="fas fa-user-plus me-1"></i> تحديد شيخ الآن
                        </button>
                        @endif
                    @endif
                @endif
            </div>
        @endif
    </div>
</td>
              
                

<td>
    <div class="d-flex flex-column align-items-center gap-1">
        {{-- بلد الإقامة --}}
        <div title="بلد الإقامة" class="d-flex align-items-center gap-1">
            <i class="fa fa-map-marker-alt text-danger" style="font-size: 12px;"></i>
            <span class="small fw-bold text-dark">
                {{ $countriesMap[$item->user->country] ?? 'غير محدد' }}
            </span>
        </div>

        {{-- الجنسية --}}
        <div title="الجنسية" class="d-flex align-items-center gap-1">
            <i class="fas fa-passport text-info" style="font-size: 11px;"></i>
            <span class="text-muted" style="font-size: 11px;">
                {{ $countriesMap[$item->user->nationality] ?? 'غير محدد' }}
            </span>
        </div>
    </div>
</td>
                
                <td>
                    @if(($item->user->gender ?? '') == 'male')
                        <span class="badge badge-primary text-black">ذكر</span>
                    @elseif(($item->user->gender ?? '') == 'female')
                        <span class="badge badge-danger text-black">أنثى</span>
                    @else
                        <span class="badge badge-secondary">-</span>
                    @endif
                </td>	
<td class="reading-cell" data-id="{{ $item->id }}">
    {{-- العرض يعتمد على requested_path_name --}}
    <span class="reading-text badge border border-primary text-primary px-3 rounded-pill">
        {{ $item->requested_path_name ?? 'غير محدد' }}
    </span>

    @if($isAdmin)
        <i class="fas fa-edit text-primary ms-1 edit-reading-icon" style="cursor: pointer; font-size: 0.8rem;" title="تعديل"></i>
        
        <div class="edit-reading-container d-none mt-1">
            <div class="input-group input-group-sm" style="min-width: 200px;">
                <select class="form-select form-select-sm reading-select">
                    

                    {{-- فحص النوع بناءً على requested_path_type --}}
                    @if($item->requested_path_type == 'narration')
                        <optgroup label="الروايات المتاحة">
                            @foreach($allNarrations as $narration)
                                <option value="{{ $narration->name }}" {{ $item->requested_path_name == $narration->name ? 'selected' : '' }}>
                                    {{ $narration->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @elseif($item->requested_path_type == 'reading')
                        <optgroup label="القراءات المتاحة">
                            @foreach($allReadings as $reading)
                                <option value="{{ $reading->name }}" {{ $item->requested_path_name == $reading->name ? 'selected' : '' }}>
                                    {{ $reading->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @else
                        {{-- في حال كان الحقل فارغاً، نعرض النوعين كحل احتياطي لكي لا تظهر القائمة فارغة --}}
                        <optgroup label="القراءات">
                            @foreach($allReadings as $reading)
                                <option value="{{ $reading->name }}" {{ $item->requested_path_name == $reading->name ? 'selected' : '' }}>
                                    {{ $reading->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="الروايات">
                            @foreach($allNarrations as $narration)
                                <option value="{{ $narration->name }}" {{ $item->requested_path_name == $narration->name ? 'selected' : '' }}>
                                    {{ $narration->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
                <button class="btn btn-success btn-sm save-reading-btn"><i class="fas fa-check"></i></button>
                <button class="btn btn-danger btn-sm cancel-reading-btn"><i class="fas fa-times"></i></button>
            </div>
        </div>
    @endif
</td>
                
                @if($isContinuousTab)            
                <td>
                    <div class="d-flex flex-column align-items-center">
                        @if($canSetPosition)
                            @if($item->surah_name) 
<div class="bg-light border rounded-pill px-3 py-1 small fw-bold d-flex align-items-center justify-content-center">
    {{-- اسم السورة ورقم الآية --}}
    <span class="text-dark">
        {{ $item->surah_name }} ({{ $item->ayah_number }})
    </span>
    
    {{-- رقم الصفحة مع أيقونة توضيحية --}}
    @if($item->page_number)
        <span class="badge bg-danger ms-2 d-inline-flex align-items-center px-2 py-1" style="font-size: 10px;" title="رقم الصفحة">
            <i class="fas fa-file-alt me-1"></i>
            ص {{ $item->page_number }}
        </span>
    @endif

    {{-- زر التعديل --}}
    @if($isAssignedTeacher && !$isPendingMushafaha)
        <a href="javascript:void(0)" class="ms-2 text-primary lh-1" data-bs-toggle="modal" data-bs-target="#surahAyahModal_{{ $student_id }}">
            <i class="fas fa-edit small"></i>
        </a>
    @endif
</div>

                                {{-- عرض التواريخ --}}
                                <div class="mt-1" style="font-size: 10px; line-height: 1.2;">
                                    @if($item->ejazah_start)
                                        <div class="text-muted" title="تاريخ بدأ الإجازة">
                                            <i class="far fa-clock me-1"></i>بدأ: {{ \Carbon\Carbon::parse($item->ejazah_start)->format('Y-m-d') }}
                                        </div>
                                    @endif
                                    
                                    @if($item->ejazah_end)
                                        <div class="text-success fw-bold" title="تاريخ انتهاء الإجازة">
                                            <i class="fas fa-check-double me-1"></i>انتهاء: {{ \Carbon\Carbon::parse($item->ejazah_end)->format('Y-m-d') }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                @if($isAssignedTeacher && !$isPendingMushafaha) 
                                    <button class="btn btn-sm btn-soft-primary py-0 px-2 rounded-pill" style="font-size: 11px;" data-bs-toggle="modal" data-bs-target="#surahAyahModal_{{ $student_id }}">
                                        <i class="fas fa-plus-circle me-1"></i> تحديد الموضع
                                    </button>
                                @else
                                    <span class="text-muted small italic">لم يحدد</span>
                                @endif
                            @endif

                            @if($isAssignedTeacher && !$isAdmin && !empty($item->teacher->url) && !$isPendingMushafaha)
                                <a href="{{ $item->teacher->url }}" target="_blank" 
                                   class="btn btn-sm btn-success rounded-pill mt-2 px-3 shadow-sm" 
                                   title="دخول قاعة المقرأة">
                                    <i class="fas fa-video me-1"></i> دخول القاعة
                                </a>
                            @endif
                        @else
                            <span class="text-muted small italic">غير متاح الآن</span>
                        @endif
                    </div>
                </td>
                @endif

@if($isAdmin)
<td class="d-none">
    <div class="d-flex flex-column align-items-center gap-1">
        @if($item->admin_id) 
            <span class="fw-bold text-primary">{{ $item->teacher->name ?? 'غير محدد' }}</span>
            {{-- زر التعديل يظهر للمدير فقط --}}
            <button class="btn btn-sm btn-outline-secondary py-0 px-2 d-none" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#adminModal{{$item->id}}">
                <i class="fas fa-user-edit"></i> تعديل
            </button>
        @else
            @if($isNewTab) 
                <span class="badge bg-soft-danger text-danger border p-2 small">بانتظار قرار المدير</span>
            @else
            
                <button class="btn btn-sm btn-danger py-1 px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#adminModal{{$item->id}}">
                    تحديد شيخ
                </button>
            @endif
        @endif
    </div>
</td>
@endif

                @if($isAdmin && $isNewTab)
                <td>
                    <div class="d-flex flex-column gap-1">
                        @if($item->is_certified == 1)
                            <span class="badge bg-info text-dark">مجاز سابقاً</span>
                            @if($item->certification_file)
                                <a href="{{ config('constants.path.PATH_FILES') . $item->certification_file }}" target="_blank" class="btn btn-sm btn-outline-primary py-0">
                                    <i class="fas fa-file-pdf"></i> ملف الإجازة السابقة
                                </a>
                            @endif
                        @else
                            <span class="badge bg-secondary">غير مجاز</span>
                            @if($item->jazariya_cert)
                                <a href="{{ config('constants.path.PATH_FILES') . $item->jazariya_cert }}" target="_blank" class="btn btn-sm btn-outline-success py-0">
                                    <i class="fas fa-certificate"></i> شهادة الجزرية
                                </a>
                            @endif
                        @endif

                        @if($item->asool_cert)
                            <a href="{{ config('constants.path.PATH_FILES') . $item->asool_cert }}" target="_blank" class="btn btn-sm btn-outline-warning py-0 text-dark">
                                <i class="fas fa-book"></i> 
                                @if($item->requested_path_type == 'reading')
                                    شهادة أصول القراءة
                                @else
                                    شهادة أصول الرواية
                                @endif
                            </a>
                        @endif
                    </div>
                </td>
                @endif

                <td>
					@if($isPendingMushafaha) {{-- غالباً يكون فارغاً في هذه المرحلة --}}
					
						<span class="badge bg-soft-warning text-warning mt-1" style="font-size: 10px;">
							<i class="fas fa-microphone me-1"></i> قيد المشافهة
						</span>
					@elseif($isCompleted)
                        <span class="badge bg-soft-success text-success mt-1" style="font-size: 10px;">
                            <i class="fas fa-check-circle me-1"></i> تمت الختمة
                        </span>
                    @elseif($item->teacher_decision == 'not_qualified' OR $item->status == 'rejected')
                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle ms-1">غير مؤهل</span>                        
                    @elseif($item->teacher_decision == 'qualified' AND $item->progress_checkpoint == 'kahf' AND $item->stage_checkpoint == 'initial_interview')
                        <span class="badge bg-soft-success text-success border px-2">المقابلة الثانية</span>
                    @elseif($item->teacher_decision == 'qualified' AND $item->progress_checkpoint == 'mursalat')
                        <span class="badge bg-soft-success text-success border px-2">المشافهة</span>
                    @elseif($item->teacher_decision == 'qualified' && ($item->stage_checkpoint == 'second_interview' || $item->status == 'in_progress'))
                        <span class="badge bg-soft-success text-success border px-2">مستمر في قراءة الإجازة</span>
                    @elseif($item->teacher_decision == 'qualified')    
                        <span class="badge bg-soft-success text-success border px-2">مؤهل لقراءة الإجازة</span>
                    @elseif($item->teacher_decision == 'refer_to_teacher')
                        <span class="badge bg-soft-info text-info border px-2">يوجَّه لتعديل الملاحظات</span>
                    @elseif($item->teacher_decision == 'review_theory')
                        <span class="badge bg-soft-warning text-dark border px-2">مراجعة التجويد النظري</span>

                    @else
                        <span class="text-muted small italic">بانتظار التقييم</span>
                    @endif
                </td>

                <td>
                    @if($item->status == 'new' && $isAdmin)
                        <button class="btn btn-sm btn-dark px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#adminModal{{$item->id}}">إجراء المدير</button>
                    @elseif($item->status == 'pending_interview' && $isAssignedTeacher && $needsDecisionUpdate)
                        <button class="btn btn-sm btn-warning px-3 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#updateDecisionModal{{$item->id}}">
                            <i class="fas fa-sync-alt me-1"></i> تحديث القرار
                        </button>
                    @elseif($item->status == 'pending_interview' && $isAssignedTeacher)
                        <button class="btn btn-sm btn-success px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#interviewModal{{$item->id}}">المقابلة</button>
                    @elseif($needsDecisionUpdate && $isAssignedTeacher)
                        <button class="btn btn-sm btn-warning px-3 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#updateDecisionModal{{$item->id}}">
                            <i class="fas fa-sync-alt me-1"></i> تحديث القرار
                        </button>
                    @elseif($item->progress_checkpoint == 'kahf' && $isAssignedTeacher AND $item->stage_checkpoint == 'initial_interview')
                        <button class="btn btn-sm btn-info text-white px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#interviewModal2{{$item->id}}">المقابلة الثانية</button>
                    @elseif($item->moshafaha == 'yes' && $item->moshafaha_file != NULL)
                        @if($isAdmin)
                            <a href="{{ config('constants.path.PATH_FILES').$item->moshafaha_file }}" target="_blank" class="btn btn-sm btn-soft-success px-3 rounded-pill">
                                <i class="fas fa-file-download me-1"></i> عرض ملف المشافهة
                            </a>
                        @else
                            <span class="badge bg-light text-muted border px-3">لا يوجد إجراء</span>
                        @endif					
                    @elseif( ($item->progress_checkpoint == 'completed' OR $item->progress_checkpoint == 'mursalat')&& $item->teacher_decision == 'qualified')
                        <div id="moshafaha_container_{{ $item->id }}">
                            @if($item->moshafaha == 'yes' && $item->moshafaha_file)
                                @if($isAdmin)
                                    <a href="{{ config('constants.path.PATH_FILES').$item->moshafaha_file }}" target="_blank" class="btn btn-sm btn-soft-success px-3 rounded-pill">
                                        <i class="fas fa-file-download me-1"></i> عرض ملف المشافهة
                                    </a>
                                @else
                                    <span class="badge bg-light text-muted border px-3">لا يوجد إجراء</span>
                                @endif
                            @elseif($isAdmin)
                            @if($item->surah_index == 113)
                                <div class="input-group input-group-sm justify-content-center" style="max-width: 210px; margin: 0 auto;">
                                    <input type="file" id="file_input_{{ $item->id }}" class="form-control form-control-sm">
                                    <button type="button" class="btn btn-primary btn-sm upload-moshafaha-btn" data-id="{{ $item->id }}">
                                        <span class="btn-text">رفع</span>
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </div>
                            @else
                                <span class="badge bg-light text-muted border px-3">لم يصل الى سورة الناس</span>
                            @endif
                            
                            @else
                                <span class="badge bg-light text-muted border px-3">لا يوجد إجراء</span>
                            @endif
                        </div>
                    @elseif($item->progress_checkpoint == 'completed')
                        <span class="badge bg-light text-muted border px-3">مكتمل</span>
                    @else
                        <span class="badge bg-light text-muted border px-3">لا يوجد إجراء</span>
                    @endif
                </td>
            </tr>

            {{-- المودالات --}}
            @if($isAdmin && $item->status == 'new')
<div class="modal fade AmmarNew" id="adminModal{{$item->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('enrollments.process-decision', $item->id) }}" method="POST">
            @csrf
            <div class="modal-content text-start" dir="rtl">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title w-100 text-center text-white">توجيه الطلب</h5>
                </div>
                <div class="modal-body p-4">
                    {{-- 1. القائمة المنسدلة للقرار --}}
                    <div class="mb-3">
                        <label class="fw-bold">القرار:</label>
                        {{-- تأكد من إضافة id للقرار ليسهل الوصول إليه --}}
                        <select name="decision_type" id="decision_select_{{$item->id}}" class="form-select" onchange="toggleTeacherField(this, '{{$item->id}}')" required>
                            <option value="">-- اختر القرار --</option>
                            <option value="approve">موافق وتحويل للشيخ</option>
                            <option value="reject">رفض الطلب</option>
                        </select>
                    </div>

                    {{-- 2. قسم اختيار الشيخ - أعطيناه ID للتحكم به --}}
                    <div class="mb-3 d-none" id="teacher_field_container_{{$item->id}}">
                        <label class="fw-bold">اختيار الشيخ:</label>
                        <select name="admin_id" id="teacher_select_{{$item->id}}" class="form-select">
                            <option value="">-- اختر الشيخ --</option>
                            @foreach($teachers as $t)
                                <option value="{{$t->id}}">{{$t->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">تأكيد التوجيه</button>
                </div>
            </div>
        </form>
    </div>
</div>
            @endif

            @if($isAssignedTeacher)
                {{-- مودال تحديد الموضع --}}
                <div class="modal fade" id="surahAyahModal_{{ $student_id }}" tabindex="-1" data-student-id="{{ $student_id }}" data-default-surah="{{ $current_surah_index }}" data-default-ayah="{{ $current_ayah }}">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-start" dir="rtl">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">تحديد الموضع: {{$item->user->full_name }}</h5>            
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="fw-bold mb-1">السورة:</label>
                                    <select id="surah_select_{{ $student_id }}" class="form-select surah_select_per_student"></select>
                                </div>
                                <div class="mb-3 ayah-container" style="display: none;">
                                    <label class="fw-bold mb-1">الآية:</label>
                                    <select id="ayah_select_{{ $student_id }}" class="form-select ayah_select_per_student"></select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary save-selection-btn w-100">حفظ الموضع</button>
                            </div>
                        </div>
                    </div>
                </div>

                @if($item->status == 'pending_interview' && $isAssignedTeacher)
                <div class="modal fade" id="interviewModal{{$item->id}}" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <form action="{{ route('enrollments.save-interview', $item->id) }}" method="POST">
                            @csrf
                            <div class="modal-content text-start" dir="rtl">
                                <div class="modal-header bg-success text-white"><h5 class="modal-title w-100 text-center">مقابلة البدء بالإجازة</h5></div>
                                <div class="modal-body p-4">
                                    <div class="row">
                                        <div class="col-md-7 border-start">
                                            <h6 class="fw-bold text-success mb-3">أسئلة التجويد:</h6>
                                            @for($i=1; $i<=5; $i++)
                                            <div class="mb-3 border-bottom pb-2">
                                                <label class="form-label d-block fw-bold">السؤال {{ $i }}</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="q{{ $i }}_answer" id="q{{ $i }}_true" value="صح">
                                                    <label class="form-check-label" for="q{{ $i }}_true">صح</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="q{{ $i }}_answer" id="q{{ $i }}_false" value="خطأ">
                                                    <label class="form-check-label" for="q{{ $i }}_false">خطأ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="q{{ $i }}_answer" id="q{{ $i }}_none" value="غير محدد" checked>
                                                    <label class="form-check-label" for="q{{ $i }}_none">غير محدد</label>
                                                </div>
                                            </div>
                                            @endfor
                                            <div class="mb-3">
                                                <label for="notes" class="form-label fw-bold">ملاحظات إضافية</label>
                                                <textarea class="form-control" name="notes" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h6 class="fw-bold text-success mb-3">التقييم والقرار:</h6>
                                            <div class="mb-3"><label class="small fw-bold">مستوى التجويد:</label><select name="theory_level" class="form-select"><option value="excellent">ممتاز</option><option value="good" selected>جيد</option><option value="weak">ضعيف</option></select></div>
                                            <div class="mb-3"><label class="small fw-bold">مستوى التلاوة:</label><select name="recitation_level" class="form-select"><option value="excellent">ممتاز</option><option value="good" selected>جيد</option><option value="weak">ضعيف</option></select></div>
                                            <div class="mb-3"><label class="small fw-bold">مستوى الحفظ:</label><select name="hifz_level" class="form-select"><option value="excellent">ممتاز</option><option value="good" selected>جيد</option><option value="weak">ضعيف</option></select></div>
                                            <div class="p-3 bg-light rounded border mb-3">
                                                <label class="fw-bold mb-2">القرار:</label>
                                                <select name="decision" class="form-select" required>
                                                    <option value="qualified">مؤهل لقراءة الإجازة</option>
                                                    <option value="refer_to_teacher">يوجَّه لتعديل الملاحظات</option>
                                                    <option value="review_theory">مراجعة التجويد النظري</option>
                                                    <option value="not_qualified">غير مؤهل</option>
                                                </select>
                                            </div>
                                            <div class="mb-3"><label class="small fw-bold">التاريخ:</label><input type="date" name="interview_date" class="form-control" value="{{ date('Y-m-d') }}"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="submit" class="btn btn-success w-100">حفظ التقييم</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

{{-- مودال المقابلة الثانية --}}
<div class="modal fade" id="interviewModal2{{$item->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('enrollments.save-second-interview', $item->id) }}" method="POST">
            @csrf
            <div class="modal-content text-start" dir="rtl">
                {{-- رأس المودال بلون مميز --}}
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title w-100 text-center fw-bold">
                        <i class="fas fa-clipboard-check me-2"></i> نموذج المقابلة الثانية
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="fw-bold mb-3 text-dark">
                            <i class="fas fa- gavel text-primary me-1"></i> القرار النهائي للمقابلة:
                        </label>
                        
                        <div class="d-flex flex-column gap-2">
                            {{-- الخيار الأول: الاستمرار --}}
                            <div class="form-check custom-option border rounded p-3 bg-light">
                                <input class="form-check-input" type="radio" name="decision" id="continue{{$item->id}}" value="qualified" {{ $item->teacher_decision == 'qualified' ? 'checked' : '' }} required>
                                <label class="form-check-label fw-bold text-success" for="continue{{$item->id}}">
                                    <i class="fas fa-check-circle me-1"></i> الاستمرار في قراءة الإجازة
                                </label>
                            </div>

                            {{-- الخيار الثاني: توجيه الشيخ --}}
                            <div class="form-check custom-option border rounded p-3 bg-light">
                                <input class="form-check-input" type="radio" name="decision" id="guide{{$item->id}}" value="refer_to_teacher" {{ $item->teacher_decision == 'refer_to_teacher' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-warning" for="guide{{$item->id}}">
                                    <i class="fas fa-exclamation-triangle me-1"></i> يوجَّه الشيخ بالملاحظات مع الاستمرار في القراءة
                                </label>
                            </div>

                            {{-- الخيار الثالث: التوقف --}}
                            <div class="form-check custom-option border rounded p-3 bg-light">
                                <input class="form-check-input" type="radio" name="decision" id="stop{{$item->id}}" value="not_qualified" {{ $item->teacher_decision == 'not_qualified' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-danger" for="stop{{$item->id}}">
                                    <i class="fas fa-times-circle me-1"></i> التوقف عن قراءة الإجازة
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- حقل اختياري للملاحظات --}}
                    <div class="mb-3">
                        <label class="fw-bold mb-2">ملاحظات إضافية (إن وجدت):</label>
                        <textarea name="notes" class="form-control border-primary" rows="3" placeholder="اكتب ملاحظاتك هنا..."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                        <i class="fas fa-save me-1"></i> اعتماد وحفظ القرار
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

                @if($needsDecisionUpdate)
                <div class="modal fade" id="updateDecisionModal{{$item->id}}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('enrollments.update-final-decision', $item->id) }}" method="POST">
                            @csrf
                            <div class="modal-content text-start" dir="rtl">
                                <div class="modal-header bg-warning text-dark"><h5 class="modal-title w-100 text-center fw-bold">تحديث القرار الفني</h5></div>
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="fw-bold mb-2">تغيير القرار إلى:</label>
                                        <select name="final_decision" class="form-select border-warning" required>
                                            <option value="qualified">1- مؤهل للإجازة</option>
                                            <option value="not_qualified">2- غير مؤهل</option>
                                            <option value="refer_to_teacher">3- العودة لتعديل الملاحظات</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="submit" class="btn btn-warning w-100 fw-bold">اعتماد القرار</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            @endif

{{-- مودال تخصيص أو تعديل الشيخ - متاح للمدير فقط --}}
@if($isAdmin && $item->status !== 'rejected')
<div class="modal fade ammarAdmin" id="adminModal{{$item->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('enrollments.process-decision-approve', $item->id) }}" method="POST">
            @csrf
            <div class="modal-content text-start" dir="rtl">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title w-100 text-center text-white">
                        {{ $item->admin_id ? 'تعديل الشيخ المخصص' : 'توجيه الطالب وتعيين الشيخ' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="fw-bold">الإجراء:</label>
                        <select name="decision_type" class="form-select" onchange="window.toggleTeacherField(this, '{{$item->id}}')" required>
                            {{-- هذا هو الخيار الوحيد الذي يحمل selected الآن --}}
                            <option value="" selected disabled>-- اختر الإجراء المناسب --</option>
                            <option value="approve">موافق / استمرار (تحويل للشيخ)</option>
                            <option value="reject">رفض الطلب نهائياً</option>
                        </select>
                    </div>

                    {{-- أضفنا d-none هنا لكي تختفي عند فتح المودال لأول مرة --}}
                    <div id="teacher_field_container_{{$item->id}}" class="d-none">
                        <div class="mb-3">
                            <label class="fw-bold">اختيار الشيخ:</label>
                            <select name="admin_id" id="teacher_select_{{$item->id}}" class="form-select">
                                <option value="">-- اختر الشيخ --</option>
                                @foreach($teachers as $t)
                                    <option value="{{$t->id}}" {{ $item->admin_id == $t->id ? 'selected' : '' }}>
                                        {{$t->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i> 
                            سيتمكن الشيخ المختار من رؤية بيانات الطالب ومتابعة ختمته.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_btn_{{$item->id}}" class="btn btn-primary w-100">تأكيد الإجراء</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif



            @empty
            <tr><td colspan="{{ $isAdmin ? 7 : 6 }}" class="py-5 text-muted">لا توجد بيانات</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@section('scriptSection')
<script>
    const quranSurahs = @json(config('allquran.surahs'));
    const csrfToken = '{{ csrf_token() }}';
    const userIsAdmin = {{ $isAdmin ? 'true' : 'false' }};

    $(document).ready(function() {
        function populateAyahs(sid, sIdx, defA = null) {
            const $aSelect = $('#ayah_select_' + sid);
            const $cont = $aSelect.closest('.ayah-container');
            $aSelect.empty().append('<option value="">-- اختر آية --</option>');
            if (sIdx !== "" && quranSurahs[sIdx]) {
                for (let i = 1; i <= quranSurahs[sIdx].ayahs; i++) {
                    let sel = (defA && parseInt(defA) === i) ? 'selected' : '';
                    $aSelect.append(`<option value="${i}" ${sel}>الآية ${i}</option>`);
                }
                $cont.show();
            } else { $cont.hide(); }
        }

        $('.surah_select_per_student').each(function() {
            const $s = $(this);
            const sid = $s.closest('.modal').data('student-id');
            const defS = $s.closest('.modal').attr('data-default-surah');
            const defA = $s.closest('.modal').attr('data-default-ayah');
            $s.append('<option value="">-- اختر السورة --</option>');
            $.each(quranSurahs, function(i, v) {
                let sel = (defS !== "" && parseInt(defS) === i) ? 'selected' : '';
                $s.append(`<option value="${i}" ${sel}>${i+1}. ${v.name}</option>`);
            });
            if (defS !== "") populateAyahs(sid, defS, defA);
        });

        $(document).on('change', '.surah_select_per_student', function() {
            populateAyahs($(this).closest('.modal').data('student-id'), $(this).val());
        });

        $(document).on('click', '.save-selection-btn', function() {
            const btn = $(this);
            const sid = btn.closest('.modal').data('student-id');
            const sI = $('#surah_select_'+sid).val();
            const aN = $('#ayah_select_'+sid).val();
            if (!sI || !aN) return alert('يرجى اختيار السورة والآية');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            $.post('{{ route("hifz.save") }}', {
                _token: csrfToken, 
                student_id: sid, 
                surah_index: parseInt(sI),
                surah_name: quranSurahs[sI].name, 
                ayah_number: aN
            }).done(function() { 
                location.reload(); 
            }).fail(function() { 
                alert('خطأ في الحفظ'); 
                btn.prop('disabled', false).text('حفظ الموضع'); 
            });
        });

        $(document).on('click', '.upload-moshafaha-btn', function() {
            const btn = $(this);
            const studentId = btn.data('id');
            const fileInput = $('#file_input_' + studentId)[0];
            const container = $('#moshafaha_container_' + studentId);

            if (fileInput.files.length === 0) return alert('يرجى اختيار ملف أولاً');

            const formData = new FormData();
            formData.append('moshafaha_file', fileInput.files[0]);
            formData.append('_token', csrfToken);

            btn.prop('disabled', true);
            btn.find('.btn-text').addClass('d-none');
            btn.find('.spinner-border').removeClass('d-none');

            let url = "{{ route('enrollments.uploadMoshafaha', ['id' => ':id']) }}".replace(':id', studentId);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        if (userIsAdmin) {
                            container.html(`
                                <a href="${response.file_url}" target="_blank" class="btn btn-sm btn-soft-success px-3 rounded-pill">
                                    <i class="fas fa-file-download me-1"></i> عرض ملف المشافهة
                                </a>
                            `);
                        } else {
                            container.html('<span class="badge bg-light text-muted border px-3">لا يوجد إجراء</span>');
                        }
                    }
                },
                error: function() {
                    alert('حدث خطأ أثناء الرفع');
                    btn.prop('disabled', false).find('.btn-text').removeClass('d-none');
                    btn.find('.spinner-border').addClass('d-none');
                }
            });
        });
    });
    
    
window.toggleTeacherField = function(el, id) {
    const container = document.getElementById('teacher_field_container_' + id);
    const select = document.getElementById('teacher_select_' + id);
    
    // إذا لم يجد العناصر (مثلاً في تاب المرفوضين) يخرج فوراً
    if (!container || !select) return;

    if (el.value === 'approve') {
        
        document.getElementById('submit_btn_' + id).innerText = "تأكيد التعديل";
        document.getElementById('submit_btn_' + id).classList.replace('btn-danger', 'btn-primary');        
        
        // 1. إظهار الحاوية (الشيخ + الرسالة)
        container.classList.remove('d-none');
        // 2. جعل الحقل مطلوباً
        select.setAttribute('required', 'required');
        
        // 3. إظهار تنبيه يذكر بتحديد الشيخ
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'يرجى تحديد الشيخ لإتمام الموافقة',
                showConfirmButton: false,
                timer: 2000
            });
        }
    } else {
        
        document.getElementById('submit_btn_' + id).innerText = "تأكيد رفض الطلب";
        document.getElementById('submit_btn_' + id).classList.replace('btn-primary', 'btn-danger');        
        
        // 1. إخفاء الحاوية تماماً (الشيخ + الرسالة)
        container.classList.add('d-none');
        // 2. إلغاء خاصية "مطلوب" لتجنب منع الإرسال
        select.removeAttribute('required');
        // 3. تفريغ القيمة
        select.value = "";

        // 4. إظهار تنبيه في حالة الرفض فقط
        if (el.value === 'reject' && typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'تم اختيار رفض الطلب',
                showConfirmButton: false,
                timer: 2000
            });
        }
    }
};

</script>

<script>
$(document).ready(function() {
    // 1. إظهار القائمة المنسدلة عند الضغط على أيقونة التعديل
    $(document).on('click', '.edit-reading-icon', function() {
        let parent = $(this).closest('.reading-cell');
        parent.find('.reading-text, .edit-reading-icon').addClass('d-none');
        parent.find('.edit-reading-container').removeClass('d-none');
    });

    // 2. إلغاء التعديل
    $(document).on('click', '.cancel-reading-btn', function() {
        let parent = $(this).closest('.reading-cell');
        parent.find('.reading-text, .edit-reading-icon').removeClass('d-none');
        parent.find('.edit-reading-container').addClass('d-none');
    });

    // 3. حفظ التعديل عبر AJAX
    $(document).on('click', '.save-reading-btn', function() {
        let parent = $(this).closest('.reading-cell');
        let id = parent.data('id');
        let selectedValue = parent.find('.reading-select').val();
        let btn = $(this);

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: "{{ route('ejaza.enrollments.updateReading') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                reading_name: selectedValue
            },
            success: function(response) {
                if(response.success) {
                    parent.find('.reading-text').text(selectedValue);
                    parent.find('.cancel-reading-btn').click();
                    // تنبيه نجاح (Toast)
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'تم التحديث', showConfirmButton: false, timer: 1500 });
                }
            },
            error: function() {
                alert('حدث خطأ في الاتصال بالسيرفر');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fas fa-check"></i>');
            }
        });
    });
});


function viewInterviewResult(id) {
    // إظهار تنبيه تحميل
    Swal.fire({
        title: 'جاري جلب البيانات...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    $.ajax({
        url: "{{ url('/admin/interview-result') }}/" + id,
        method: "GET",
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: '<span class="text-primary">نتائج مقابلة الطالب</span>',
                    html: response.html,
                    width: '700px',
                    confirmButtonText: 'إغلاق نافذة العرض',
                    confirmButtonColor: '#3085d6',
                    customClass: { popup: 'rounded-4' }
                });
            } else {
                Swal.fire('تنبيه', response.message, 'info');
            }
        },
        error: function() {
            Swal.fire('خطأ', 'تعذر الاتصال بالسيرفر، يرجى المحاولة لاحقاً', 'error');
        }
    });
}

$(document).ready(function() {
    // 1. فتح وإغلاق القائمة عند النقر على الأيقونة
    $(document).on('click', '.teacher-trigger-icon', function(e) {
        e.preventDefault();
        e.stopPropagation();

        let container = $(this).closest('.teacher-quick-cell');
        let select = container.find('.quick-teacher-select');

        // إغلاق أي قوائم مفتوحة أخرى في الجدول
        $('.quick-teacher-select').not(select).addClass('d-none');
        
        // إظهار القائمة الحالية
        select.toggleClass('d-none');
        if (!select.hasClass('d-none')) {
            select.focus();
        }
    });

    // 2. منع انغلاق القائمة عند النقر داخل الـ Select نفسه
    $(document).on('click', '.quick-teacher-select', function(e) {
        e.stopPropagation();
    });

    // 3. إرسال البيانات عند تغيير الخيار
    $(document).on('change', '.quick-teacher-select', function() {
        let select = $(this);
        let enrollmentId = select.closest('.teacher-quick-cell').data('id');
        let teacherId = select.val(); // ستكون قيمة فارغة "" إذا اختار بدون شيخ

        $.ajax({
            url: "{{ route('enrollments.update-teacher') }}", // المسار الذي عرفته أنت
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                enrollment_id: enrollmentId,
                teacher_id: teacherId ? teacherId : null
            },
            beforeSend: function() {
                select.prop('disabled', true); // منع التغيير أثناء المعالجة
            },
            success: function(res) {
                if(res.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message, // الرسالة القادمة من الـ Controller
                        showConfirmButton: false,
                        timer: 1500
                    });
                    
                    // تحديث الصفحة ليعكس التغيير في كل مكان (مثل Badge الحالة السفلية)
                    setTimeout(() => { location.reload(); }, 1200);
                }
            },
            error: function(xhr) {
                select.prop('disabled', false);
                let errorMsg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'حدث خطأ غير متوقع';
                Swal.fire({
                    icon: 'error',
                    title: 'تنبيه',
                    text: errorMsg
                });
            }
        });
    });

    // 4. إغلاق القائمة عند النقر في أي مكان خارجها
    $(document).on('click', function() {
        $('.quick-teacher-select').addClass('d-none');
    });
});

</script>

@endsection