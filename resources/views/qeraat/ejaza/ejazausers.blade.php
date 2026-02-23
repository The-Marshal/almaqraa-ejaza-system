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
@if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'not' AND Request::segment(3) == 'users') 
                                            <a href="{{route('ejazah.not.users')}}">
                                                طلاب غير مجازين    
                                            </a>
@else
<a href="{{route('ejazah.users')}}">طلاب مجازين</a>
@endif

                                            
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
@if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'not' AND Request::segment(3) == 'users') 
    الطلاب الغير مجازين
@else
    الطلاب المجازين
@endif
</span>


@if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'not' AND Request::segment(3) == 'users') 

                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">نوع المشارك</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">الإجازة التي ترغب البدء بها</th>
                                <th scope="col">الحالة</th>
                                <th scope="col"> خيارات الطلب </th>
                                <th scope="col">المرفقات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td @if($item->status == 'ACCEPT') class="bg-success text-white" @elseif($item->status == 'REJECT')  class="bg-danger text-white" @endif>
                                    <?php
                                    $usersName = DB::table('users')->WHERE('id',$item->user_id)->first();
                                    ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-info-{{$item->id}}" class="btn btn-sm @if($item->status == 'ACCEPT' || $item->status == 'REJECT')  text-white @endif">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>
                                    
<!-- Modal -->
<div class="modal fade" id="ejaza-user-info-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabelUser-{{$item->id}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelUser-{{$item->id}}">
            {{$usersName->name}} {{$usersName->lastname}}
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.assign')}}" method="POST">
            @csrf
<table class="table-responsive">
    <tr>
        <th>الاسم</th>
        <td>عمار</td>
    </tr>
</table>
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

                                
                                <td class="ammar2">
                                    @if($item->isqerano == 'yes')
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
                                </td>
                              
                               <td>
                                   @if($item->status == 'NEW')
                                   <b class="text-info">جديد</b>
                                   @elseif($item->status == 'WAIT')
                                   <b class="text-info">في إنتظار المقابلة</b>
                                   @elseif($item->status == 'PASS')
                                   <b class="text-info">إجتاز المقابلة</b>
                                   @elseif($item->status == 'ACCEPT')
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
                                    <b class="text-danger">مرفوض</b>
                                   @else
                                    <b class="text-info">غير معروف</b>
                                   @endif
                               </td>

                                <td>
                                    @if($item->status == 'NEW') 
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'wait'])}}"
                                    class="btn btn-primary btn-sm" onclick="return confirm('هل أنت متأكد للتوجية')">يوجة الى الشيخ</a> -
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @elseif($item->status == 'PASS')
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'accept'])}}"
                                    class="btn btn-primary btn-sm" onclick="return confirm('هل أنت متأكد من القبول')">قبول الطالب </a> -
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @endif  
@if($item->status == 'ACCEPT' || $item->status == 'WAIT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">اختر الشيخ</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            @if($item->status == 'WAIT')
            إختيار الشيخ للمقابلة
            @else
            اختيار الشيخ 
            @endif
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.assign')}}" method="POST">
            @csrf
            <select class="form-select mb-4" name="teacher_id">
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
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
                                    
                                </td>
                                <td>
                                    <a href="<?= $path.$item->nofile ?>" target="_blank">شهادة دورة الجزرية</a>
                                
                                    <br>
                                    <a href="<?= $path.$item->nofile1 ?>" target="_blank">شهادة دراسة أصول القراءة أو دورة التأهيل للإجازة</a>
                                </td>
                            </tr>
                            
                            
                            @endforeach
                        </tbody>
                    </table>
                    
                    
                    
                    

@else

                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">نوع المشارك</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">الإجازة التي حصلت عليها</th>
                                <th scope="col">الإجازة التي ترغب البدء بها</th>
                                <th scope="col">الحالة</th>
                                <th scope="col"> خيارات الطلب </th>
                                <th scope="col">المرفقات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td @if($item->status == 'ACCEPT') class="bg-success text-white" @elseif($item->status == 'REJECT')  class="bg-danger text-white" @endif>
                                    <?php
                                    $usersName = DB::table('users')->WHERE('id',$item->user_id)->first();
                                    ?>
                                    
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-info-{{$item->id}}" class="btn btn-sm @if($item->status == 'ACCEPT' || $item->status == 'REJECT')  text-white @endif">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>
                                    
<!-- Modal -->
<div class="modal fade" id="ejaza-user-info-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabelUser-{{$item->id}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelUser-{{$item->id}}">
          معلومات المستخدم
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.user.update')}}" method="POST">
            @csrf


<div class="p-3">


<div class="row mb-3">
    <label for="fname" class="col-md-2 col-form-label text-md-start text-muted">الاسم الرباعي</label>

    <div class="col-md-10">
        <div class="row">
            <div class="col-xs-12 col-md-3 mb-3">
                <input id="fname" type="text" class="form-control" name="fname" required="" value="{{$usersName->name}}" placeholder="الاسم الاول" autocomplete="fname" autofocus="" />
            </div>
            <div class="col-xs-12 col-md-3 mb-3">
                <input id="sname" type="text" class="form-control" name="sname" required="" value="{{$usersName->mdlname}}" placeholder="الاسم الثاني" autocomplete="sname" />
            </div>
            <div class="col-xs-12 col-md-3 mb-3">
                <input id="tname" type="text" class="form-control" name="tname" required="" value="{{$usersName->thrdname}}" placeholder="الاسم الثالث" autocomplete="tname" />
            </div>
            <div class="col-xs-12 col-md-3 mb-3">
                <input id="lname" type="text" class="form-control" name="lname" required="" value="{{$usersName->lastname}}" placeholder="اللقب" autocomplete="lname" />
            </div>

            <div class="col-xs-12 col-md-12"></div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-7">
        <div class="row">
    <label for="ctry" class="col-md-2 col-form-label text-md-start text-muted">بلد الإقامة
</label>

        <div class="col-md-10">
                <?php 
                    $countries = DB::table(config('constants.tables.TBL_COUNTRIES'))->orderBy('country','asc')->get();
                ?>     
                @if(sizeof($countries) > 0)
            <select class="form-control selectpickerCTRY" name="ctry" data-live-search="true">
                
                @foreach($countries as $ctry)
                <option value="{{$ctry->id}}" @if($ctry->id == $usersName->country) SELECTED @endif>{{$ctry->country}}</option>
                @endforeach
            </select>
            @endif

        </div>
    </div>
    </div>
    <div class="col-md-5">
        <div class="row">
        <label for="nat" class="col-md-2 col-form-label text-md-start text-muted">الجنسية</label>
    
        <div class="col-md-10">
            <input id="nat" type="text" class="form-control " value="{{$usersName->nationality}}" name="nat" required autocomplete="nat">
    
        </div>
        </div>
    </div>
    
</div>



<div class="row mb-3">
    <div class="col-md-7">
        <div class="row">
            <label for="email" class="col-md-3 col-form-label text-md-start text-muted">{{ __('البريد الإلكتروني') }}</label>

        <div class="col-md-9">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required value="{{$usersName->email }}" autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

        </div>
    </div>
    </div>
    <div class="col-md-5">
        <div class="row">
        <label for="password" class="col-md-3 col-form-label text-md-start text-muted">{{ __('كلمة المرور') }}</label>
    
        <div class="col-md-9">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
    
        </div>
        </div>
    </div>
    
</div>




<div class="row mb-3">
    <div class="col-md-4">
        <div class="row">
    <label for="gender" class="col-md-2 col-form-label text-md-start text-muted">{{ __('الجنس') }}</label>

        <div class="col-md-10">
            <div class="form-check form-check-inline" id="gender">
                <input class="form-check-input" type="radio" name="gender" checked id="male" value="male">
                <label class="form-check-label text-muted" for="male">ذكر</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label text-muted" for="female">انثى</label>
              </div>

        </div>
    </div>
    </div>
    <div class="col-md-8">
        <div class="row">
        <label for="mobile" class="col-md-4 col-form-label text-md-end text-muted">{{ __('رقم الجوال واتساب') }}</label>
    
        <div class="col-md-8">
            <div class="row">

                <div class="col-md-9 col-8">
            <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{$usersName->mobile }}" required autocomplete="mobile">
                </div>
                
                <div class="col-md-3 col-4">
            <input id="kmobile" type="text" class="form-control @error('kmobile') is-invalid @enderror" name="kmobile" value="{{$usersName->extmobile }}" required autocomplete="kmobile">
                </div>
            </div>
    
        </div>
        </div>
    </div>
    
</div>




       
            </div>


            <input type="hidden" name="user_id" value="{{$usersName->id}}" />
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
                                        @if($usersName->gender == 'female') 
                                            <span class="badge text-bg-danger">انثى</span>
                                        @else
                                            <span class="badge text-bg-warning">ذكر</span>
                                        @endif
                                    
                                    </td> 
                                    <td><?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                                   
                                    <td>{{$usersName->mobile}}</td>

                                
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
                              
                                <td class="sul ammar">
                                    

                                    @if($item->yesqeraatstart != NULL)
                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->yesqeraatstart)->first();
                                        ?>
                                        @if($qeraat)
                                            {{$qeraat->name}}
                                        @endif
                                    @else
                                        <?php
                                        $riwayah = DB::table(config('constants.tables.TBL_RIWAYAT'))->WHERE('id',$item->yesriwayastart)->first();
                                        ?>
                                        @if($riwayah)
                                        {{$riwayah->name}}
                                        @endif
                                    @endif
                                </td>
    
                               <td>   
                                   <div class="position-relative">
                                   @if($item->status == 'NEW')
                                    <b class="text-info">جديد</b>
                                   @elseif($item->status == 'WAIT')
                                    <b class="text-info">في إنتظار المقابلة</b>
                                   @elseif($item->status == 'PASS')
                                    <b class="text-info">مؤهل </b>
                                   @elseif($item->status == 'REDIRECT')
                                    <b class="text-info">يوجَّه إلى أحد المشايخ لتعديل الملاحظات</b>
                                   @elseif($item->status == 'REVIEW') 
                                    <b class="text-info">مراجعة التجويد النظري</b>
                                   @elseif($item->status == 'UNPASS')
                                    <b class="text-info">غير مؤهل</b>
                                   @elseif($item->status == 'ACCEPT')
                                    <b class="text-success">مقبول</b>
                                   @elseif($item->status == 'REJECT')
                                    <b class="text-danger">مرفوض</b>
                                   @else
                                    <b class="text-info">غير معروف</b>
                                   @endif
                                      @if($item->teacher != 0)
                                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style=" top: 30px !important; right: 50% !important; ">
                                                                        <?php
                                                                        $teacher = DB::table(config('constants.tables.TBL_TEACHERS'))->WHERE('id',$item->teacher)->first();
                                                                        
                                                                        ?>
                                            {{$teacher->name}}
                                      </span>
                                      @endif
                                   </div>
                               </td>

                                <td>
                                    @if($item->status == 'NEW') 
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'wait'])}}"
                                    class="btn btn-primary btn-sm" onclick="return confirm('هل أنت متأكد للتوجية')">يوجة الى الشيخ</a> -
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @elseif($item->status == 'PASS')
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'accept'])}}"
                                    class="btn btn-primary btn-sm" onclick="return confirm('هل أنت متأكد من القبول')">قبول الطالب </a> -
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @endif  
                                      
                                    @if($item->status == 'PASS' || $item->status == 'REDIRECT' || $item->status == 'UNPASS' || $item->status == 'REVIEW')
                                    ESTM
                                    @endif 
@if($item->status == 'ACCEPT' || $item->status == 'WAIT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">اختر الشيخ</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            @if($item->status == 'WAIT')
            إختيار الشيخ للمقابلة
            @else
            اختيار الشيخ 
            @endif
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('ejazah.teacher.assign')}}" method="POST">
            @csrf
            <select class="form-select mb-4" name="teacher_id">
                @foreach($teachers as $row)
                    <option value="{{$row->id}}" @if($item->teacher == $row->id) SELECTED @endif>{{$row->name}}</option>
                @endforeach

            </select>
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
                                    
                                </td>
                                <td>
                                    <a href="<?= $path.$item->yesfile ?>" target="_blank">المرفق</a>
                                </td>
                            </tr>
                            
                            
                            @endforeach
                        </tbody>
                    </table>
                    
                    
                    

@endif

                    
                    
                    
                    
                    
                    
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
