@extends('layouts.mainapp')

@section('content')
<?php
$path = config('constants.path.PATH_FILES'); 

?>
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item">
                                            @if(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'new')
                                            <a href="{{route('course.new.users')}}">طلبات جديدة</a>

                                         @elseif(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'accept')   
                                         <a href="{{route('course.users')}}">طلبات مقبولة</a>
                                         @elseif(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'reject')
                                         <a href="{{route('course.not.users')}}">طلبات مرفوضة</a>
                                         
                                         @endif   
                                            </li>
                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">

@if(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'new')

@if(sizeof($data) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <span class="" style="font-size: 1.3rem;margin-bottom: 13px;display: block;">
طلبات الدورات
</span>



                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم المتقدم</th>
                                <th scope="col">نوع المشارك</th>
                                <th scope="col">الدورة</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">المرفقات</th>
                                <th scope="col"> خيارات الطلب </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                    <?php 
                                    $usersName = DB::table(config('constants.tables.TBL_USERS'))->WHERE('id',$item->userid)->first();
                                    $country = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
                                    
                                    ?>
                            @if($usersName)     
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td @if($item->status == 'ACCEPT') class="bg-success text-white" @elseif($item->status == 'REJECT')  class="bg-danger text-white" @endif>

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#course-user-info-{{$item->id}}" class="btn btn-sm  @if($item->status == 'ACCEPT' OR $item->status == 'REJECT') text-white @endif">  
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
                                    <td>
                                    <?php
                                    $course = DB::table(config('constants.tables.TBL_COURSES'))->WHERE('id',$item->courseid)->first();
                                    if($course) {
                                    echo $course->name;
                                    }
                                    ?>
                                    </td>
                                    <td><?= $country[$usersName->country - 1]->country; ?></td>
                                    
                                    <td style="direction:ltr;">
                                        <a href="tel:{{$usersName->mobile}}">{{$usersName->mobile}}</a>
                                    </td>
                                    <td>
@if($item->status == 'ACCEPT')

<div class="position-relative">
  <b class="text-success">مقبول</b>
  @if($item->teacher != 0)
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style=" top: 28px !important; right: 34px !important; ">
                                    <?php
                                    $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('id',$item->teacher)->first();
                                    
                                    ?>
        {{$teacher->name}}
  </span>
  @endif
</div>    
    
    
@elseif($item->status == 'REJECT')
    <span class="badge text-bg-danger">مرفوض</span>
@elseif($item->status == 'WAIT')
<span class="badge text-bg-dark">جديد</span>

@else
    <span class="badge text-bg-warning">غير معروف</span>
@endif  
                                    </td>
                                    <td>
                                        @if($item->cerquran != NULL)
                                       <a class="" target="_blank" href="{{$path.$item->cerquran}}">شهادة حفظ القرآن</a> 
                                       @endif

                                        @if($item->cergaz != NULL)
                                       <a class="text-warning" target="_blank" href="{{$path.$item->cergaz}}">دراسة الجزرية</a> 
                                       @endif
                                       
                                        @if($item->cerejaza != NULL)
                                       <a class="text-danger" target="_blank" href="{{$path.$item->cerejaza}}">تأهيل الإجازة</a> 
                                       @endif
                                       @if($item->cerquran == NULL AND $item->cergaz == NULL AND $item->cerejaza == NULL)
                                        <span>
                                            <b>لاتوجد مرفقات</b>
                                        </span>
                                       @endif

                                    </td>
                                <td>
                                    @if($item->status == 'WAIT') 
                                    <a href="{{route('course.users.accept.reject', ['id'=> $item->id,'status'=> 'accept'])}}"
                                    class="btn btn-primary btn-sm" onclick="return confirm('هل أنت متأكد للتوجية')">يوجة الى الشيخ</a> -
                                    <a href="{{route('course.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @endif  
@if($item->status == 'ACCEPT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">اختر الشيخ</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            @if($item->status == 'WAIT')
            التحويل للشيخ  
            @else
            اختيار الشيخ 
            @endif
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('course.teacher.assign')}}" method="POST" id="checkOptions">
            @csrf
            <select class="form-select mb-4" required name="teacher_id">
                <option value="">اختر الشيخ</option>
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
            <input type="hidden" name="user_course_id" value="{{$item->id}}" />
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

@elseif(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'accept')
@if(sizeof($data) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <span class="" style="font-size: 1.3rem;margin-bottom: 13px;display: block;">
طلبات الدورات
</span>



                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم المتقدم</th>
                                <th scope="col">الدورة</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">المرفقات</th>
                                <th scope="col"> خيارات الطلب </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                    <?php 
                                    $usersName = DB::table(config('constants.tables.TBL_USERS'))->WHERE('id',$item->userid)->first();
                                    $country = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
                                    
                                    ?>
                            @if($usersName)     
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td @if($item->status == 'ACCEPT') class="bg-success text-white" @elseif($item->status == 'REJECT')  class="bg-danger text-white" @endif>

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#course-user-info-{{$item->id}}" class="btn btn-sm  @if($item->status == 'ACCEPT' OR $item->status == 'REJECT') text-white @endif">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>

                                    </td>
                                    <td>
                                    <?php
                                    $course = DB::table(config('constants.tables.TBL_COURSES'))->WHERE('id',$item->courseid)->first();
                                    if($course) {
                                    echo $course->name;
                                    }
                                    ?>
                                    </td>
                                    <td><?= $country[$usersName->country - 1]->country; ?></td>
                                    
                                    <td style="direction:ltr;">
                                        <a href="tel:{{$usersName->mobile}}">{{$usersName->mobile}}</a>
                                    </td>
                                    <td>
@if($item->status == 'ACCEPT')

<div class="position-relative">
  <b class="text-success">مقبول</b>
  @if($item->teacher != 0)
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style=" top: 28px !important; right: 34px !important; ">
                                    <?php
                                    $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('id',$item->teacher)->first();
                                    
                                    ?>
        {{$teacher->name}}
  </span>
  @endif
</div>    
    
    
@elseif($item->status == 'REJECT')
    <span class="badge text-bg-danger">مرفوض</span>
@elseif($item->status == 'WAIT')
<span class="badge text-bg-dark">جديد</span>

@else
    <span class="badge text-bg-warning">غير معروف</span>
@endif  
                                    </td>
                                    <td>
                                        @if($item->cerquran != NULL)
                                       <a class="" target="_blank" href="{{$path.$item->cerquran}}">شهادة حفظ القرآن</a> 
                                       @endif

                                        @if($item->cergaz != NULL)
                                       <a class="text-warning" target="_blank" href="{{$path.$item->cergaz}}">دراسة الجزرية</a> 
                                       @endif
                                       
                                        @if($item->cerejaza != NULL)
                                       <a class="text-danger" target="_blank" href="{{$path.$item->cerejaza}}">تأهيل الإجازة</a> 
                                       @endif
                                       

                                    </td>
                                <td>
                                    @if($item->status == 'WAIT') 
                                    <a href="{{route('course.users.accept.reject', ['id'=> $item->id,'status'=> 'accept'])}}"
                                    class="btn btn-primary btn-sm" onclick="return confirm('هل أنت متأكد للتوجية')">يوجة الى الشيخ</a> -
                                    <a href="{{route('course.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @endif  
@if($item->status == 'ACCEPT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">اختر الشيخ</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            @if($item->status == 'WAIT')
            التحويل للشيخ  
            @else
            اختيار الشيخ 
            @endif
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('course.teacher.assign')}}" method="POST" id="checkOptions">
            @csrf
            <select class="form-select mb-4" required name="teacher_id">
                <option value="">اختر الشيخ</option>
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
            <input type="hidden" name="user_course_id" value="{{$item->id}}" />
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
@elseif(Request::segment(1) == 'course' AND Request::segment(2) == 'appliers' AND Request::segment(3) == 'reject')
@if(sizeof($data) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <span class="" style="font-size: 1.3rem;margin-bottom: 13px;display: block;">
طلبات الدورات
</span>



                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم المتقدم</th>
                                <th scope="col">الدورة</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">المرفقات</th>
                                <th scope="col"> خيارات الطلب </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                    <?php 
                                    $usersName = DB::table(config('constants.tables.TBL_USERS'))->WHERE('id',$item->userid)->first();
                                    $country = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
                                    
                                    ?>
                            @if($usersName)     
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td @if($item->status == 'ACCEPT') class="bg-success text-white" @elseif($item->status == 'REJECT')  class="bg-danger text-white" @endif>

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#course-user-info-{{$item->id}}" class="btn btn-sm  @if($item->status == 'ACCEPT' OR $item->status == 'REJECT') text-white @endif">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>

                                    </td>
                                    <td>
                                    <?php
                                    $course = DB::table(config('constants.tables.TBL_COURSES'))->WHERE('id',$item->courseid)->first();
                                    if($course) {
                                    echo $course->name;
                                    }
                                    ?>
                                    </td>
                                    <td><?= $country[$usersName->country - 1]->country; ?></td>
                                    
                                    <td style="direction:ltr;">
                                        <a href="tel:{{$usersName->mobile}}">{{$usersName->mobile}}</a>
                                    </td>
                                    <td>
@if($item->status == 'ACCEPT')

<div class="position-relative">
  <b class="text-success">مقبول</b>
  @if($item->teacher != 0)
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style=" top: 28px !important; right: 34px !important; ">
                                    <?php
                                    $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('id',$item->teacher)->first();
                                    
                                    ?>
        {{$teacher->name}}
  </span>
  @endif
</div>    
    
    
@elseif($item->status == 'REJECT')
    <span class="badge text-bg-danger">مرفوض</span>
@elseif($item->status == 'WAIT')
<span class="badge text-bg-dark">جديد</span>

@else
    <span class="badge text-bg-warning">غير معروف</span>
@endif  
                                    </td>
                                    <td>
                                        @if($item->cerquran != NULL)
                                       <a class="" target="_blank" href="{{$path.$item->cerquran}}">شهادة حفظ القرآن</a> 
                                       @endif

                                        @if($item->cergaz != NULL)
                                       <a class="text-warning" target="_blank" href="{{$path.$item->cergaz}}">دراسة الجزرية</a> 
                                       @endif
                                       
                                        @if($item->cerejaza != NULL)
                                       <a class="text-danger" target="_blank" href="{{$path.$item->cerejaza}}">تأهيل الإجازة</a> 
                                       @endif
                                       

                                    </td>
                                <td>
                                    @if($item->status == 'WAIT') 
                                    <a href="{{route('course.users.accept.reject', ['id'=> $item->id,'status'=> 'accept'])}}"
                                    class="btn btn-primary btn-sm" onclick="return confirm('هل أنت متأكد للتوجية')">يوجة الى الشيخ</a> -
                                    <a href="{{route('course.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @endif  
@if($item->status == 'ACCEPT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">اختر الشيخ</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            @if($item->status == 'WAIT')
            التحويل للشيخ  
            @else
            اختيار الشيخ 
            @endif
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('course.teacher.assign')}}" method="POST" id="checkOptions">
            @csrf
            <select class="form-select mb-4" required name="teacher_id">
                <option value="">اختر الشيخ</option>
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
            <input type="hidden" name="user_course_id" value="{{$item->id}}" />
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
@endif






                            </div>
                        </div>
                        <!-- end row -->

@endsection
