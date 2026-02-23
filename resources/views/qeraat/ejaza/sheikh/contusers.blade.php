@extends('layouts.mainapp')

@section('content')

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item">
    طلاب مستمرين     
                                        </li>
                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">




@if(sizeof($data) > 0)

{{-- 1. تمرير السور إلى JavaScript من ملف config --}}
    <script>
        const csrfToken = '{{ csrf_token() }}';
        const quranSurahs = @json(config('allquran.surahs')); 
    </script>
    
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    
                    <span class="" style="font-size: 1.3rem;margin-bottom: 13px;display: block;">
    طلاب مستمرين     
</span>



                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">القراءة / الرواية</th>
                                <th scope="col">مقدار التلاوة</th>
                                <th scope="col">تحديد السورة والآيات</th>
                                <th scope="col">إجراء مقابلة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
  
@php
    $student_id = $item->id;
    
    // **1. التأكد من تحويل السور والآيات إلى أرقام صحيحة (0 إذا لم توجد قيمة)**
    // استخدم (int) للتحويل الصريح إلى رقم صحيح.
    $default_surah_number = (int)($item->surah_index ?? 0); 
    $default_ayah_number  = (int)($item->ayah_number ?? 0);
    
    // تحويل رقم السورة (1-114) إلى فهرس المصفوفة (0-113)
    $default_surah_index  = ($default_surah_number > 0) ? $default_surah_number - 1 : 0; // نستخدم 0 كقيمة آمنة
@endphp

   
    
                            <tr>
                                <td attr-id="<?= $item->id ?> "><?= $key+1 ?>
                                
                                </td>
                                <td>
                                    <?php
                                    $usersName = DB::table('users')->WHERE('id',$item->user_id)->first();
                                    ?>
                                    
                                    {{$usersName->name}} {{$usersName->lastname}}</td>
                                    <td><?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                                
                                <td> 
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
                              
    


                                <td>
                                    @if($item->page_number != NULL)
                                    <span id="hifz-status-page-{{ $item->id }}" class="text-danger">
                                    {{$item->page_number}} 
                                    صفحة
                                    </span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    
<span id="hifz-status-{{ $item->id }}">
    @if($item->surah_index === 0 OR $item->surah_index != NULL)
    <b class="text-info">
        سورة: {{ $item->surah_name }}، الآية: {{ $item->ayah_number }}
    </b>   
  
    @else
        <b class="text-danger">
        لم يتم الحفظ بعد
        </b>
    @endif
</span>                                    
<br>        

<button type="button" class="btn btn-primary" data-bs-toggle="modal" 
                data-bs-target="#surahAyahModal_{{ $student_id }}" 
                data-student-id="{{ $student_id }}">
            تحديد موضع الحفظ
        </button>      
          
        
<div class="modal fade" id="surahAyahModal_{{ $student_id }}" tabindex="-1" aria-labelledby="modalLabel_{{ $student_id }}" aria-hidden="true"
             data-default-surah="{{ $default_surah_index }}" {{-- القيمة الافتراضية للسورة (الفهرس 0-113) --}}
             data-default-ayah="{{ $default_ayah_number }}"> {{-- القيمة الافتراضية للآية --}}
             
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel_{{ $student_id }}">تحديد السورة والآية للطالب: {{ $usersName->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="student-selection-group" data-student-id="{{ $student_id }}">
                            {{-- ... قوائم الاختيار ... (تأكد من وجود IDs الصحيحة) --}}
                            <label for="surah_select_{{ $student_id }}">اختر السورة:</label>
                            <select id="surah_select_{{ $student_id }}" class="form-select surah_select_per_student mb-3">
                                <option value="">-- اختر سورة --</option>
                            </select>
                            
                            <label for="ayah_select_{{ $student_id }}" id="ayah_label_{{ $student_id }}" style="display: none;">اختر الآية:</label>
                            <select id="ayah_select_{{ $student_id }}" class="form-select ayah_select_per_student" style="display: none;">
                                <option value="">-- اختر آية --</option>
                            </select>

                            <div id="ayahs-output_{{ $student_id }}" class="ayahs-output mt-3">
                                <p id="surah-info_{{ $student_id }}"></p>
                                <p id="ayah-info_{{ $student_id }}"></p>
                            </div>
                        </div>

                    </div>
                    
                    {{-- **3. إعادة إضافة زر الحفظ** --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-success save-selection-btn" data-student-id="{{ $student_id }}">
                            حفظ الاختيار
                        </button>
                    </div>
                    {{-- نهاية Footer --}}

                </div>
            </div>
        </div>

                       
    
                                    
                                </td>
                                <td>

@if($item->stage == 'TWO' AND $item->decision2 != 'D1') 
@if($item->decision2 == 'D2')
<span class="text-warning">
    يوجَّه إلى أحد المشايخ لتعديل الملاحظات
</span>
<br>
@elseif($item->decision2 == 'D3')
<span class="text-warning">
    مراجعة التجويد النظري
</span>
<br>
@elseif($item->decision2 == 'D4')
<span class="text-danger">
    غير مؤهل
</span>
<br>
@endif
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-two-interview-{{$item->id}}" class="btn btn-warning btn-sm">المقابلة الثانية</a>

<!-- Modal -->
<div class="modal fade" id="ejaza-user-two-interview-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">المقابلة الثانية</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.interview.stage.two')}}" method="POST">
            @csrf
<div class="text-start">

    
        

            
        <div class="row">
        
        
            <div class="card border p-3">
                <div class="col-12"><h3> القرار </h3>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision2" id="d1" value="D1" @if($item->decision2 == 'D1') checked @endif>
                  <label class="form-check-label" for="d1">
                    مؤهل لقراءة الإجازة
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision2" id="d2" value="D2" @if($item->decision2 == 'D2') checked @endif>
                  <label class="form-check-label" for="d2">
                    يوجَّه إلى أحد المشايخ لتعديل الملاحظات  
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision2" id="d3" value="D3" @if($item->decision2 == 'D3') checked @endif>
                  <label class="form-check-label" for="d3">
                    مراجعة التجويد النظري    
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="decision2" id="d4" value="D4" @if($item->decision2 == 'D4') checked @endif>
                  <label class="form-check-label" for="d4">
                    غير مؤهل 
                  </label>
                </div>                
            </div>
            <div class="col-12">

            <div class="row">

            <div class="col-12">
                  <label for="date_s2" class="form-label mt-3">
                    التاريخ
                  </label>
                  <input type="date" class="form-control" id="date_s2" name="date_s2" value="<?= date('Y-m-d'); ?>">
            </div>
            </div>


            </div>
            </div>
        </div>        
        
        </div>

</div>



            <input type="hidden" name="user_ejazah_id" value="{{$item->id}}" />
<div class="d-grid gap-2">
  <button class="btn btn-primary" type="submit">تأكيد</button>
</div>


        </form>
        
        
      </div>
      <div class="modal-footer d-none">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
      </div>
      
    </div>
  </div>
</div>    



@elseif($item->stage == 'MORSALAT' AND $item->decision3 != 'D1') 
@if($item->decision3 == 'D2')
<span class="text-warning">
    يوجَّه إلى أحد المشايخ لتعديل الملاحظات
</span>
<br>
@elseif($item->decision3 == 'D3')
<span class="text-warning">
    مراجعة التجويد النظري
</span>
<br>
@elseif($item->decision3 == 'D4')
<span class="text-danger">
    غير مؤهل
</span>
<br>
@endif
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-morsalat-interview-{{$item->id}}" class="btn btn-warning btn-sm">المقابلة الثالثة</a> 

<!-- Modal -->
<div class="modal fade" id="ejaza-user-morsalat-interview-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">المقابلة الثانية</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.interview.stage.morsalat')}}" method="POST">
            @csrf
<div class="text-start">

    
        

            
        <div class="row">
        
        
            <div class="card border p-3">
                <div class="col-12"><h3> القرار </h3>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" @if($item->decision3 == 'D1') checked @endif name="decision3" id="d1" value="D1">
                  <label class="form-check-label" for="d1">
                    مؤهل لقراءة الإجازة
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" @if($item->decision3 == 'D2') checked @endif name="decision3" id="d2" value="D2">
                  <label class="form-check-label" for="d2">
                    يوجَّه إلى أحد المشايخ لتعديل الملاحظات  
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" @if($item->decision3 == 'D3') checked @endif name="decision3" id="d3" value="D3">
                  <label class="form-check-label" for="d3">
                    مراجعة التجويد النظري    
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" @if($item->decision3 == 'D4') checked @endif type="radio" name="decision3" id="d4" value="D4">
                  <label class="form-check-label" for="d4">
                    غير مؤهل 
                  </label>
                </div>                
            </div>
            <div class="col-12">

            <div class="row">

            <div class="col-12">
                  <label for="date_s3" class="form-label mt-3">
                    التاريخ
                  </label>
                  <input type="date" class="form-control" id="date_s3" name="date_s3" value="<?= date('Y-m-d'); ?>">
            </div>
            </div>


            </div>
            </div>
        </div>        
        
        </div>

</div>



            <input type="hidden" name="user_ejazah_id" value="{{$item->id}}" />
<div class="d-grid gap-2">
  <button class="btn btn-primary" type="submit">تأكيد</button>
</div>


        </form>
        
        
      </div>
      <div class="modal-footer d-none">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
      </div>
      
    </div>
  </div>
</div>    

@elseif($item->stage == 'MORSALAT' AND $item->decision3 == 'D1') 
<span class="text-info" id="hifz-status-prog-{{ $item->id }}">
    مشافهة  
</span>
@else
حاليا لايوجد
@endif                                    
                                   
         

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

$(document).ready(function() {
    
    // **1. ملء قائمة السور عند تحميل الصفحة (أو عند فتح الـ Modal)**
    // من الأفضل ملؤها مرة واحدة عند تحميل الصفحة لسرعة الأداء.
    $('.surah_select_per_student').each(function() {
        const $surahSelect = $(this);
        $.each(quranSurahs, function(index, surah) {
            $surahSelect.append(
                $('<option>', {
                    value: index, 
                    text: (index + 1) + '. ' + surah.name
                })
            );
        });
    });

    // **2. معالجة تغيير السورة**
    $('.surah_select_per_student').on('change', function() {
        const $surahSelect = $(this);
        // الحصول على ID الطالب من العنصر الأب (student-selection-group)
        const student_id = $surahSelect.closest('.student-selection-group').data('student-id');
        
        // استهداف العناصر الأخرى باستخدام الـ ID الفريد
        const $ayahSelect = $('#ayah_select_' + student_id);
        const $ayahLabel = $('#ayah_label_' + student_id);
        const $surahInfo = $('#surah-info_' + student_id);
        const $ayahInfo = $('#ayah-info_' + student_id);
        
        const selectedIndex = parseInt($surahSelect.val());
        
        // إعادة تهيئة
        $ayahSelect.empty().append($('<option>', { value: '', text: '-- اختر آية --' })).hide();
        $ayahLabel.hide();
        $surahInfo.empty();
        $ayahInfo.empty();

        if (selectedIndex >= 0) {
            const selectedSurah = quranSurahs[selectedIndex];
            
            $surahInfo.html(`<p><strong>سورة ${selectedSurah.name}</strong> - عدد آياتها: ${selectedSurah.ayahs} آية.</p>`);

            // ملء الآيات
            for (let i = 1; i <= selectedSurah.ayahs; i++) {
                $ayahSelect.append($('<option>', { value: i, text: 'الآية رقم ' + i }));
            }
            
            $ayahSelect.show();
            $ayahLabel.show();
        }
    });

    // **3. معالجة تغيير الآية**
    $('.ayah_select_per_student').on('change', function() {
        const $ayahSelect = $(this);
        const student_id = $ayahSelect.closest('.student-selection-group').data('student-id');
        
        const $surahSelect = $('#surah_select_' + student_id);
        const $ayahInfo = $('#ayah-info_' + student_id);

        const selectedAyah = $ayahSelect.val();
        $ayahInfo.empty();

        if (selectedAyah !== "") {
            const surahIndex = $surahSelect.val();
            const surahName = quranSurahs[surahIndex].name;
            
            //$ayahInfo.html(`<p>لقد اخترت الآية رقم **${selectedAyah}** من سورة **${surahName}**.</p>`);
        }
    });

    // **4. معالجة زر الحفظ (Save Button)**
    $('.save-selection-btn').on('click', function() {
        const student_id = $(this).data('student-id');
        
        // استخراج القيم
        const surahIndex = $('#surah_select_' + student_id).val();
        const selectedAyah = $('#ayah_select_' + student_id).val();
        
        if (surahIndex === "" || selectedAyah === "") {
            alert('الرجاء اختيار السورة والآية أولاً.');
            return;
        }

        const surahName = quranSurahs[surahIndex].name;

        // يمكنك هنا تنفيذ طلب AJAX لإرسال البيانات إلى الخادم
        console.log(`جارٍ حفظ: الطالب ID: ${student_id}, السورة: ${surahName} (رقم ${parseInt(surahIndex) + 1}), الآية: ${selectedAyah}`);
        
        // إغلاق الـ Modal بعد الحفظ بنجاح
        const modalId = '#surahAyahModal_' + student_id;
        $(modalId).modal('hide'); 
    });
});




$(document).ready(function() {
    
    // دالة مساعدة لملء قائمة الآيات وتعيين القيمة المختارة
    function populateAyahsAndSelect(student_id, surahIndex, defaultAyah) {
        const $ayahSelect = $('#ayah_select_' + student_id);
        const $ayahLabel = $('#ayah_label_' + student_id);
        const $surahInfo = $('#surah-info_' + student_id);
        const $ayahInfo = $('#ayah-info_' + student_id);
        
        // إعادة تهيئة العناصر
        $ayahSelect.empty().append($('<option>', { value: '', text: '-- اختر آية --' })).hide();
        $ayahLabel.hide();
        $surahInfo.empty();
        $ayahInfo.empty();

        if (surahIndex !== null && surahIndex >= 0 && quranSurahs[surahIndex]) {
            const selectedSurah = quranSurahs[surahIndex];
            
            $surahInfo.html(`سورة <strong>${selectedSurah.name}</strong> - آياتها: ${selectedSurah.ayahs}.`);

            for (let i = 1; i <= selectedSurah.ayahs; i++) {
                const optionValue = i.toString(); 
                const $option = $('<option>', { value: optionValue, text: 'الآية رقم ' + i });
                
                // **[تعيين صارم]**: إذا كانت هذه هي الآية الافتراضية، نضيف خاصية selected="true"
                if (defaultAyah > 0 && defaultAyah === i) {
                    $option.prop('selected', true);
                }
                
                $ayahSelect.append($option);
            }
            
            $ayahSelect.show();
            $ayahLabel.show();
            
            // تعيين القيمة النهائية باستخدام val() لضمان المطابقة
            if (defaultAyah > 0 && defaultAyah <= selectedSurah.ayahs) {
                 $ayahSelect.val(defaultAyah.toString());
            }

            // تشغيل حدث التغيير
            $ayahSelect.trigger('change');
        }
    }

    // 1. **[لحَل مشكلة التكرار]**: ملء قوائم السور مرة واحدة عند تحميل DOM
    $('.surah_select_per_student').each(function() {
        const $surahSelect = $(this);
        $surahSelect.empty(); 
        
        $surahSelect.append($('<option>', { value: '', text: '-- اختر سورة --'}));

        $.each(quranSurahs, function(index, surah) {
            $surahSelect.append($('<option>', { value: index.toString(), text: (index + 1) + '. ' + surah.name }));
        });
    });
    



// 2. معالجة حدث ظهور الـ Modal (تعيين القيم الافتراضية)
    $('.modal').on('shown.bs.modal', function() {
        const $modal = $(this);
        const student_id = $modal.data('student-id');
        
        // **[الحل الأكيد]**: زيادة التأخير لـ 100 مللي ثانية (لتجاوز أي تعارضات في التوقيت)
        setTimeout(function() {
            
            const default_surah_index_str = $modal.attr('data-default-surah'); // "2"
            const default_ayah_number_str = $modal.attr('data-default-ayah'); // "5"

            const default_surah_index = (default_surah_index_str && default_surah_index_str.trim() !== '') ? parseInt(default_surah_index_str) : null;
            const default_ayah_number = (default_ayah_number_str && default_ayah_number_str.trim() !== '') ? parseInt(default_ayah_number_str) : null;
            
            const $surahSelect = $('#surah_select_' + student_id);

            if (default_surah_index !== null && default_surah_index >= 0) {
                
                const selectedValue = default_surah_index.toString(); // "2"
                
                // 1. تعيين القيمة الصارم (يجب أن يعمل طالما أن <option value="2"> موجود)
                $surahSelect.val(selectedValue); 
                //alert($surahSelect);
                // 2. محاكاة التغيير لضمان التحديث المرئي
                $surahSelect.trigger('change'); 
                
                // 3. ملء الآيات وتعيين الآية الافتراضية
                populateAyahsAndSelect(student_id, default_surah_index, default_ayah_number);

            } else {
                $surahSelect.val(""); 
                populateAyahsAndSelect(student_id, null, null);
            }
        }, 100); // زيادة التأخير إلى 100ms
    });


    // 3. معالجة تغيير السورة (يدوياً)
    $('.surah_select_per_student').on('change', function() {
        const $surahSelect = $(this);
        const student_id = $surahSelect.closest('.student-selection-group').data('student-id'); 
        const selectedIndex = parseInt($surahSelect.val());
        
        if (selectedIndex >= 0) {
            populateAyahsAndSelect(student_id, selectedIndex, null); 
        } else {
            populateAyahsAndSelect(student_id, null, null); 
        }
    });
    
    // 4. معالجة تغيير الآية (لعرض المعلومات)
    $('.ayah_select_per_student').on('change', function() {
        const $ayahSelect = $(this);
        const student_id = $ayahSelect.closest('.student-selection-group').data('student-id');
        const $ayahInfo = $('#ayah-info_' + student_id);
        const selectedAyah = $ayahSelect.val();
        
        $ayahInfo.empty(); 
        
        if (selectedAyah !== "") {
            const surahIndex = $('#surah_select_' + student_id).val();
            const surahName = quranSurahs[surahIndex].name;
            $ayahInfo.html(`اخترت الآية رقم <strong>${selectedAyah}</strong> من سورة <strong>${surahName}</strong>.`);
        }
    });

    // 5. معالجة زر الحفظ (إرسال AJAX) - مع SweetAlert2
    $('.save-selection-btn').on('click', function() {
        const $button = $(this);
        const student_id = $button.data('student-id');
        //
        const surahIndex = $('#surah_select_' + student_id).val();
        const selectedAyah = $('#ayah_select_' + student_id).val();
        
        if (surahIndex === "" || selectedAyah === "") {
            Swal.fire({ icon: 'warning', title: 'تنبيه', text: 'الرجاء اختيار السورة والآية أولاً.' });
            return;
        }

        const surahName = quranSurahs[surahIndex].name;
        //alert('student_id:'+student_id+' surahIndex:'+surahIndex+' surahName:'+surahName+' selectedAyah:'+selectedAyah);
        $button.prop('disabled', true).text('...حفظ'); 
            
        $.ajax({
            url: '{{ route("hifz.save") }}', 
            method: 'POST',
            data: {
                _token: csrfToken,
                student_id: student_id,
                surah_index: surahIndex,      
                surah_name: surahName,
                ayah_number: selectedAyah
            },
            
            
success: function(response) {
    
    // 1. تحديد مكان العرض في صف الطالب
    const $hifzStatusElement = $('#hifz-status-' + student_id);        // للعرض: سورة: كذا، الآية: كذا
    const $hifzPageElement = $('#hifz-status-page-' + student_id);    // للعرض: عدد الصفحات
    const $hifzProgressElement = $('#hifz-status-prog-' + student_id); // للعرض: مشافهة / حاليا لا يوجد <--- العنصر المطلوب

    // تحديث مكان الحفظ (السورة والآية)
    if ($hifzStatusElement.length && response.surah_name && response.ayah_number) {
        $hifzStatusElement.html(`
            <b class="text-info">
                سورة: ${response.surah_name}، الآية: ${response.ayah_number}
            </b>
        `);
    }

    // تحديث مقدار التلاوة (رقم الصفحة)
    if ($hifzPageElement.length && response.page_number) { 
        $hifzPageElement.html(`
            ${response.page_number} 
            صفحة
        `);
        $hifzPageElement.css('color', '#009900'); // تغيير اللون للأخضر
    }
    
    // 🔔 التحديث المطلوب: تحديث حالة التقدم (hifz-status-prog) بالقيمة المرسلة من الخادم
    if ($hifzProgressElement.length && response.hifz_status_prog) {
        // تحديث النص بالقيمة المرسلة من الخادم (مشافهة / حاليا لايوجد)
        $hifzProgressElement.text(response.hifz_status_prog); 
        // بما أن "مشافهة" (D1) هي حالة إيجابية، سنغير لونها للأخضر للتمييز
        if (response.hifz_status_prog === 'مشافهة') {
            $hifzProgressElement.css('color', '#20c997'); // لون أخضر فاتح
        } else {
            $hifzProgressElement.css('color', '#17a2b8'); // لون info/أزرق
        }
    }
    
    // (باقي كود SweetAlert2 وإغلاق الـ Modal)
    Swal.fire({ 
        icon: 'success', 
        title: 'نجاح!', 
        text: response.message || 'تم التحديث بنجاح.', 
        showConfirmButton: false, 
        timer: 1500 
    });
    
    // تحديث data attributes للـ Modal (للملء التلقائي في المرة القادمة)
    const modalId = '#surahAyahModal_' + student_id;
    $(modalId).attr('data-default-surah', surahIndex);
    $(modalId).attr('data-default-ayah', selectedAyah);
    
    $(modalId).modal('hide'); 
},          
            
            
            error: function(xhr) {
                const response = xhr.responseJSON;
                const errorMessage = response && response.message ? response.message : 'حدث خطأ غير معروف في الخادم.';
                Swal.fire({ icon: 'error', title: 'فشل التعديل!', text: errorMessage, footer: 'رمز الخطأ: ' + (xhr.status || 'غير محدد') });
                console.error('AJAX Error:', xhr.responseText);
            },
            complete: function() {
                $button.prop('disabled', false).text('حفظ الاختيار');
            }
        });
    });
});
</script>





@endsection
