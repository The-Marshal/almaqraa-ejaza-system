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
                                            طلاب مرفوضين
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
طلاب مرفوضين
</span>


@if(Request::segment(1) == 'ejazah' AND Request::segment(2) == 'not' AND Request::segment(3) == 'users') 

                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الطالب</th>
                                
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">الإجازة التي ترغب البدء بها</th>
                                <th scope="col">قبول / رفض</th>
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
                                    
                                    {{$usersName->name}} {{$usersName->lastname}}</td>
                                        <td>
                                        @if($usersName->gender == 'female') 
                                            <span class="badge text-bg-danger">انثى</span>
                                        @else
                                            <span class="badge text-bg-warning">ذكر</span>
                                        @endif
                                    
                                    </td>                                    
                                    <td><?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                                    <td>{{$usersName->extmobile}}{{$usersName->mobile}}</td>

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
                                   
                                    

                                   @elseif($item->status == 'NEED')
                                    <b class="text-warning">يحتاج مقابلة</b>
                                   @elseif($item->status == 'REJECT')
                                    <b class="text-danger">مرفوض</b>
                                   @else
                                    <b class="text-info">جديد</b>
                                   @endif
                               </td>
                                
                                <td>
                                    @if($item->isqerano == 'yes')
                                        <?php
                                        $qeraat = DB::table(config('constants.tables.TBL_QERAAT'))->WHERE('id',$item->noqeraat)->first();
                                        ?>
                                        {{$qeraat->name}}
                                    @else
                                        <?php
                                        $riwayah = DB::table(config('constants.tables.TBL_RIWAYAT'))->WHERE('id',$item->yesriwayat)->first();
                                        ?>
                                        {{noriwayah->name}}
                                    @endif
                                </td>
                              
    

                                <td>
                                    @if($item->status == 'NEW') 
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'accept'])}}"
                                    class="btn btn-primary btn-sm">قبول</a> -
                                    <a href="{{route('ejazah.users.accept.reject', ['id'=> $item->id,'status'=> 'reject'])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">رفض</a> 
                                    @endif  
@if($item->status == 'ACCEPT') 
<a href="#" data-bs-toggle="modal" data-bs-target="#ejaza-user-{{$item->id}}" class="btn btn-warning btn-sm">اختر الشيخ</a> 
@endif                                    
         
<!-- Modal -->
<div class="modal fade" id="ejaza-user-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اختيار الشيخ </h5>
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
                                <th scope="col">استعادة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td>
                                    <?php
                                    $usersName = DB::table('users')->WHERE('id',$item->user_id)->first();
                                    ?>
                                    
                                    {{$usersName->name}} {{$usersName->lastname}}</td>
                                        <td>
                                        @if($usersName->gender == 'female') 
                                            <span class="badge text-bg-danger">انثى</span>
                                        @else
                                            <span class="badge text-bg-warning">ذكر</span>
                                        @endif
                                    
                                    </td>                                    
                                    <td><?= $countriesValue[array_search($usersName->country , $countriesKey)]; ?></td>
                                    <td>{{$usersName->extmobile}}{{$usersName->mobile}}</td>

                                <td>

                                    <a href="{{route('ejazah.users.restore', ['id'=> $item->id,'status'=> 'new'])}}"
                                    class="btn btn-primary btn-sm">استعادة</a> 


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
