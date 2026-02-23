@extends('layouts.mainapp')

@section('content')
<?php
$path = config('constants.path.PATH_FILES'); 
//course/shaikh/completed/users/5
?>
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        
                                        <li class="breadcrumb-item">
                                            <a href="{{route('course.shaikh.completed')}}">
                                                دورات مكتملة </a>
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
طلاب الدورة 
</span>



                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0 ammar1010" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم المتقدم</th>
                                <th scope="col">الدورة</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">الحضور</th>
                                <th scope="col">الشهادة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                    <?php 
                                    $usersName = DB::table(config('constants.tables.TBL_USERS'))->WHERE('id',$item->userid)->first();
                                    $country = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
                                    
                                    $course = DB::table(config('constants.tables.TBL_COURSES'))->WHERE('id',$item->courseid)->first();
$userPresentArr = [];                                    
$checkCourseCert = DB::table(config('constants.tables.TBL_CORSDGRE'))->where('student_id',$usersName->id)->where('course_id',$course->id)->first();

$AllDaysPresents = DB::table(config('constants.tables.TBL_CORSAPLYPRSNTS'))->where('course_id',$item->courseid)->get();
$AllDaysPresentsCount = sizeof($AllDaysPresents);
foreach($AllDaysPresents as $AllDaysPresent) {
    $userPresentArrDB = json_decode($AllDaysPresent->students_id);
    //echo $userPresentArrDB.'<br>';
    if (in_array($usersName->id, $userPresentArrDB)) {
        $userPresentArr[] = 1;
    }
    

}
                                    
                                    ?>
                            @if($usersName)     
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td>

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#user-info-{{$usersName->id}}" class="btn btn-sm ">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>
<!-- Modal -->
<div class="modal fade" id="user-info-{{$usersName->id}}" tabindex="-1" aria-labelledby="exampleModalLabelUser-{{$usersName->id}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelUser-{{$usersName->id}}">
             <?php if($course) { echo 'الدرجة النهـائـية للدورة: '.$course->name; } ?>
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('course.shaikh.user.completed.degree',['id'=> request()->route('id')])}}" class="studForm" method="POST">
            @csrf
<div class="row mb-3">
    <div class="col-md-7">
        <div class="row">
            <label for="name-{{$usersName->id}}" class="col-md-3 col-form-label text-md-start text-muted">{{ __('اسم الدراس') }}</label>

        <div class="col-md-9">
                <input id="name-{{$usersName->id}}" type="text" class="form-control" disabled name="name" value="{{$usersName->name}} {{$usersName->lastname}}">

        </div>
    </div>
    </div>
    <div class="col-md-5">
        <div class="row">
        <label for="country-{{$usersName->id}}" class="col-md-3 col-form-label text-md-start text-muted">{{ __('الدولة') }}</label>
    
        <div class="col-md-9">
            <input id="country-{{$usersName->id}}" type="text" disabled class="form-control" name="country" value="<?= $country[$usersName->country - 1]->country; ?>">
    
        </div>
        </div>
    </div>
    
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="row">
            <label for="user_hour-{{$usersName->id}}" class="col-md-5 col-form-label text-md-start text-muted">{{ __('ساعات الدورة') }}</label>

        <div class="col-md-7">
                <input id="user_hour-{{$usersName->id}}" type="text" class="form-control" name="user_hour" required min="1">

        </div>
    </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="row">
            <label for="present-{{$usersName->id}}" class="col-md-5 col-form-label text-md-start text-muted">{{ __('درجة الحضور (10)') }}</label>

        <div class="col-md-7">
                <input id="present-{{$usersName->id}}" type="number" class="form-control sum-input" name="present" required max="10" min="0">

        </div>
    </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="row">
            <label for="telawah-{{$usersName->id}}" class="col-md-5 col-form-label text-md-start text-muted">{{ __('التلاوة والأداء+ تسميع الأبيات  (50)') }}</label>

        <div class="col-md-7">
                <input id="telawah-{{$usersName->id}}" type="number" class="form-control sum-input" name="telawah" required max="50" min="0">

        </div>
    </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="row">
            <label for="midterm-{{$usersName->id}}" class="col-md-5 col-form-label text-md-start text-muted">{{ __(' الاختبار النصفي (20)') }}</label>

        <div class="col-md-7">
                <input id="midterm-{{$usersName->id}}" type="number" class="form-control sum-input" name="midterm" required max="20" min="0">

        </div>
    </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="row">
            <label for="finalterm-{{$usersName->id}}" class="col-md-5 col-form-label text-md-start text-muted">{{ __(' الاختبار النهائي (20)') }}</label>

        <div class="col-md-7">
                <input id="finalterm-{{$usersName->id}}" type="number" class="form-control sum-input" name="finalterm" required max="20" min="0">

        </div>
    </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="row">
            <label for="total-{{$usersName->id}}" class="col-md-5 col-form-label text-md-start text-muted">{{ __(' المجموع  (100)') }}</label>

        <div class="col-md-7">
                <input id="total-{{$usersName->id}}" type="text" class="form-control" name="total" disabled>

        </div>
    </div>
    </div>
</div>
<?php
$user_from = '';
$user_to   = '';
if($course) {
$user_from = $course->cstart;
$user_to   = $course->cstart;
}
?>
            <input type="hidden" name="user_country" value="<?= $usersName->country; ?>" />
            <input type="hidden" name="user_from" value="{{$user_from}}" />
            <input type="hidden" name="user_to" value="{{$user_to}}" />
            <input type="hidden" name="user_data_dgree" value="" />
            <input type="hidden" name="user_data_id" value="{{$usersName->id}}" />
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
                                    </td>
                                    <td>
                                    <?php if($course) { echo $course->name; } ?>
                                    </td>
                                    <td><?= $country[$usersName->country - 1]->country; ?></td>
                                    
                                    <td style="direction:ltr;">
                                        <a href="tel:{{$usersName->mobile}}">{{$usersName->mobile}}</a>
                                    </td>
                       
                      <td>
                         <?= sizeof($userPresentArr) ?>/<?= $AllDaysPresentsCount ?>
                      </td>
                       <td>
                           <?php
                           if($checkCourseCert) {
                               if($checkCourseCert->grade_status == 'PASS') {
                                   
         
                               if($checkCourseCert->certifcate != NULL) {
                              ?>
                              <a href="https://admin.almaqraa.net/course/cert/<?= $checkCourseCert->student_id ?>" target="_blank" class="d-none">الرابط</a>
                              <a href="<?= config('constants.path.PATH_HCERTS').$checkCourseCert->certifcate ?>" target="_blank">الرابط</a>
                              <?php
                               } else {
                                   ?>
                                   <b class="text-warning">
                                       قيد المعالجة
                                   </b>
                                   <?php
                               }
                               } else {
                                   ?>
                                   <b class="text-danger">
                                       لم ينجح 
                                   </b>
                                   <?php
                               }
                           }
                           ?>
                           
                       </td>
                                    </tr>
                            @endif
                             
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



@section("scriptSection")
<script>

    document.addEventListener('show.bs.modal', function (event) {
      // Get the button that triggered the modal
      const button = event.relatedTarget;

      // Get the ID of the modal being opened
      const modalId = button.getAttribute('data-bs-target');

      //alert(`Modal with ID ${modalId} is about to be opened.`);
      // You can now perform actions based on which modal is being opened
      //telawah  midterm   finalterm
      
        let vname      = modalId+" input[name='present']";
        let vtelawah   = modalId+" input[name='telawah']";
        let vmidterm   = modalId+" input[name='midterm']";
        let vfinalterm = modalId+" input[name='finalterm']";
        let vtotal     = modalId+" input[name='total']";
        let vusdgree   = modalId+" input[name='user_data_dgree']";
        let vSum       = modalId+" .sum-input";
      //alert(modalId+" input[name='present']");  total
      
      
//present Value      
            $(vname).on('change', function() {
                // Get the value of the changed input
                var inputValue = $(this).val();
                var total = $(this).val();

                $(vtotal).text(inputValue);

                // Validate Max and Min value
                var value = parseInt($(this).val(), 10);
                var min = parseInt($(this).attr('min'), 10);
                var max = parseInt($(this).attr('max'), 10);
        
                if (value < min || value > max) {
                    alert('يجب ان يكون الرقم مابين ' + min + ' و ' + max + '.');
                    // Optionally, reset the value or apply a visual indicator
                     $(this).val('0');
                     $(this).addClass('is-invalid');
                } else {
                    // Value is valid
                     $(this).removeClass('is-invalid');
                }
            });     
      
      
//telawah Value      
            $(vtelawah).on('change', function() {
                // Get the value of the changed input
                var inputValue = $(this).val();
                var total = $(this).val();

                $(vtotal).text(inputValue);

                // Validate Max and Min value
                var value = parseInt($(this).val(), 10);
                var min = parseInt($(this).attr('min'), 10);
                var max = parseInt($(this).attr('max'), 10);
        
                if (value < min || value > max) {
                    alert('يجب ان يكون الرقم مابين ' + min + ' و ' + max + '.');
                    // Optionally, reset the value or apply a visual indicator
                     $(this).val('0');
                     $(this).addClass('is-invalid');
                } else {
                    // Value is valid
                     $(this).removeClass('is-invalid');
                }
            });        
      
//midterm Value      
            $(vmidterm).on('change', function() {
                // Get the value of the changed input
                var inputValue = $(this).val();
                var total = $(this).val();

                $(vtotal).text(inputValue);

                // Validate Max and Min value
                var value = parseInt($(this).val(), 10);
                var min = parseInt($(this).attr('min'), 10);
                var max = parseInt($(this).attr('max'), 10);
        
                if (value < min || value > max) {
                    alert('يجب ان يكون الرقم مابين ' + min + ' و ' + max + '.');
                    // Optionally, reset the value or apply a visual indicator
                     $(this).val('0');
                     $(this).addClass('is-invalid');
                } else {
                    // Value is valid
                     $(this).removeClass('is-invalid');
                }
            });       
      
//finalterm Value      
            $(vfinalterm).on('change', function() {
                // Get the value of the changed input
                var inputValue = $(this).val();
                var total = $(this).val();

                $(vtotal).text(inputValue);

                // Validate Max and Min value
                var value = parseInt($(this).val(), 10);
                var min = parseInt($(this).attr('min'), 10);
                var max = parseInt($(this).attr('max'), 10);
        
                if (value < min || value > max) {
                    alert('يجب ان يكون الرقم مابين ' + min + ' و ' + max + '.');
                    // Optionally, reset the value or apply a visual indicator
                     $(this).val('0');
                     $(this).addClass('is-invalid');
                } else {
                    // Value is valid
                     $(this).removeClass('is-invalid');
                }
            });       
      
        function updateSum() {
            let total = 0;
            $(vSum).each(function() {
                // Ensure the value is a number, default to 0 if not
                let roundValVar = $(this).val();
                let roundVal = Math.round(roundValVar * 100) / 100;
                total += roundVal || 0;
                
            });
            $(vtotal).val(total); // Update the text of the total display
            $(vusdgree).val(total); // Update the text of the total display
            // If you want to update an input field instead:
            // $('#total-sum-input').val(total);
        }

        // Attach the change event listener to all inputs with the 'sum-input' class
        $(vSum).on('change', function() {
            updateSum(); // Call the updateSum function whenever an input changes
        });      
      
      
    });


</script>
@endsection

@section("cssSection")
<style>
    
</style>
@endsection
