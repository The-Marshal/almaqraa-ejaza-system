@extends('layouts.mainapp')

@section('content')
<?php
$path = config('constants.path.PATH_URL_EJAZAH'); 
?>
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item">
                                            <a href="#">طلبة الإجازة</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="#">المستمرين</a>
                                        </li>
                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">




@if(sizeof($data) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <span class="" style="font-size: 1.3rem;margin-bottom: 13px;display: block;">
المستمرين
</span>


                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">نوع المشارك</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">القراءة / الرواية</th>
                                <th scope="col">حالة التقدم</th>
                                <th scope="col">شهادة الإجازة</th>
                                <th scope="col">الشيخ/ـة</th>
                            </tr>
                        </thead>
                        <tbody>
      
                            
                            @foreach ($data as $key => $item)
                            <tr data-student-id="{{ $item->id }}">
                                <td><?= $key+1 ?></td>
                                <td data-id="{{$item->id}}">
                                    <?php
                                    $usersName = DB::table('users')->WHERE('id',$item->user_id)->first();
                                    ?>
                                    
                                    <a href="#" class="btn btn-sm">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>
                                    
     
                                                                        
                                    
                                    </td>
                                        <td>
                                        @if($usersName->gender == 'female') 
                                            <span class="badge text-bg-danger">انثى</span>
                                        @else
                                            <span class="badge text-bg-warning">ذكر</span>
                                        @endif
                                    
                                    </td>
                                    <td><?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                                    <td>{{$usersName->mobile}}</td>
                              
                                <td class="sul ammar">
                                    

                                    @if($item->ejaza_type == 'yes')
                                        @if($item->yesqeraat != NULL)

                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->yesqeraat)->first();
                                        ?>
                                        @if($qeraat)
                                           {{$qeraat->name}}
                                        @endif  

                                        @else
                                          <?php
                                        $riwayah = DB::table(config('constants.tables.TBL_RIWAYAT'))->WHERE('id',$item->yesriwayat)->first();
                                        ?>
                                        @if($riwayah)
                                        {{$riwayah->name}}
                                        @endif
                                        
                                        
                                        @endif
                                    @else
                                        @if($item->noqeraat != NULL)
                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->noqeraat)->first();
                                        ?>
                                        @if($qeraat)
                                            {{$qeraat->name}}
                                        @endif                                        
                                            
                                        @else
                                      <?php
                                        $riwayah = DB::table(config('constants.tables.TBL_RIWAYAT'))->WHERE('id',$item->noriwayah)->first();
                                        ?>
                                        @if($riwayah)
                                        {{$riwayah->name}}
                                        @endif
                                            
                                        @endif
                                    @endif
                                    
                                </td>

                               <td class="upload-cell">  
                              
                                   @if($item->stage == 'MORSALAT')
                                    <b class="text-danger">المشافهة</b>
                                    <br>
                                    @if (!$item->ejazah_file)
                <form class="attachment-upload-form" data-student-id="{{ $item->id }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $item->id }}">
                    <input type="file" style="width: 80px;margin-top: 10px;" name="attachment" class="file-input" data-student-id="{{ $item->id }}" required>
                    {{-- <button type="submit" class="btn btn-sm btn-primary">رفع</button> --}}
                </form>
                @endif
                                   @elseif($item->surah_index === 0 OR $item->surah_index != NULL)
                                        <b class="text-info">
                                            سورة: {{ $item->surah_name }}، الآية: {{ $item->ayah_number }}
                                        </b>  
                                   @elseif($item->surah_name == 'NULL' OR $item->surah_name == '')
                                    <b class="text-info">
                                        قيد التقدم
                                    </b>
                                   @else
                                    <b class="text-info">غير معروف</b>
                                   @endif                               
                               </td>
            <td class="attachment-status-cell" id="status-{{ $item->id }}">
                @if ($item->ejazah_file)
                    <a href="{{ config('constants.path.PATH_URL_EJAZAH_COMP').'/'.$item->ejazah_file }}" target="_blank" class="download-link">
                        تحميل الملف
                    </a>
                @else
                    <span class="no-attachment">لم يتم الرفع</span>
                @endif
            </td>  
                               <td>   
                                   <div class="position-relative">
                                      @if($item->teacher != 0)
                                      <span class="text-danger">
                                        <?php
                                        $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('id',$item->teacher)->first();
                                                                        
                                                                        ?>
                                            {{$teacher->name}}
                                      </span>
                                      @endif
      
                                                                       
                                      
                                   </div>
                               </td>

                            </tr>
                            
                            
                            @endforeach
                        </tbody>
                    </table>
                    

                    
                    
                </div>
            </div>
        </div>
    </div>

</div>

@else
<div class="alert alert-danger" role="alert">
    لاتوجد بيانات
</div>
@endif





                            </div>
                        </div>
                        <!-- end row -->

@endsection
@section('scriptSection')

<script>
// يوضع هذا الكود أسفل تهيئة DataTables أو في ملف JS منفصل

$(document).ready(function() {
const csrfToken = '{{ csrf_token() }}';
    // الاستماع لحدث تغيير (اختيار ملف) في أي حقل رفع ملف داخل الجدول
    $('#tabletheml').on('change', '.file-input', function(e) {
        
        const $input = $(this);
        const studentId = $input.data('student-id');
        const $form = $input.closest('.attachment-upload-form');
        const $statusCell = $('#status-' + studentId); // الخلية التي ستعرض حالة المرفق
        //alert(studentId);
        // التأكد من اختيار ملف
        if (e.target.files.length === 0) {
            alert('الرجاء اختيار ملف للرفع.');
            return;
        }

        // إنشاء كائن FormData لإرسال الملف عبر AJAX
        const formData = new FormData($form[0]);

        // عرض رسالة "جاري الرفع"
        $statusCell.html('<span class="text-info">جاري الرفع... ⏳</span>');
        $input.prop('disabled', true); // تعطيل الحقل أثناء الرفع لمنع إرسال مزدوج

        // إرسال طلب AJAX
        $.ajax({
            url: "{{ route('passed.upload.attachment') }}", // المسار الذي أنشأناه
            type: 'POST',
            data: formData,
            processData: false, // مهم: لا تقم بمعالجة البيانات
            contentType: false, // مهم: لا تقم بتعيين نوع المحتوى
            headers: {
                'X-CSRF-TOKEN': csrfToken // إذا كان CSRF غير موجود في النموذج
            },
            success: function(response) {
                if (response.success) {
                    $form.hide(); // إخفاء النموذج بالكامل
                    
                    // تحديث خانة المرفقات بالرابط الجديد للتحميل
                    const downloadHtml = `
                        <a href="${response.download_url}" target="_blank" class="download-link text-success">
                            تم الرفع! (تحميل)
                        </a>
                    `;
                    
                    $statusCell.html(downloadHtml);
                    
                    alert(response.message);
                } else {
                    // فشل من جهة الخادم
                    $statusCell.html('<span class="text-danger">فشل الرفع ❌</span>');
                    alert('فشل في الرفع: ' + response.message);
                }
            },
            error: function(xhr) {
                // فشل في الاتصال أو خطأ 4xx/5xx
                let errorMessage = 'حدث خطأ غير متوقع.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // عرض أخطاء التحقق من الصحة
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    errorMessage = "خطأ في التحقق من الصحة: ";
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMessage += value.join(', ') + " ";
                    });
                }

                $statusCell.html('<span class="text-danger">خطأ! ❌</span>');
                alert('فشل الرفع: ' + errorMessage);
            },
            complete: function() {
                
                if (!$form.is(':hidden')) {
                
                // إعادة تفعيل حقل الملف
                $input.prop('disabled', false);
                // (اختياري) مسح قيمة حقل الملف لمنع إرسال نفس الملف مرتين
                $input.val(''); 
                }                

            }
        });
    });

});
</script>
@endsection