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
@if(Request::segment(3) == 'yes')
                                        <li class="breadcrumb-item">
                                            <a href="{{route('course.yes.shaikh.users')}}">
                                                الطلاب المقبولين  </a>
                                            </li>
@elseif(Request::segment(3) == 'not')
                                        <li class="breadcrumb-item">
                                            <a href="{{route('course.not.shaikh.users')}}">
                                                الطلاب الغير مقبولين  </a>
                                            </li>
@else
                                        <li class="breadcrumb-item">
                                            <a href="{{route('course.shaikh.users')}}">
                                                طلبات جديدة</a>
                                            </li>
@endif

                                        
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
                                <td>

                                    <a href="#" class="btn btn-sm ">  
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
