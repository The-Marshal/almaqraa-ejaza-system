@extends('layouts.mainapp')

@section('content')
<?php
$path = config('constants.path.PATH_FILES'); 
                                   
$course = DB::table(config('constants.tables.TBL_COURSES'))->WHERE('id',$course_id)->first();
                                  
?>
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href     <li class="breadcrumb-item">
                                            <a href="#">
                                                @if($course) 
                                                    {{$course->name}}
                                                @endif
</a>
                                            </li>

                                        
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">




@if(sizeof($allUsers) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <span class="" style="font-size: 1rem;margin-bottom: 13px;display: block;">
                                    <?php
                                    if($course) {
                                        echo $course->name;
                                    }
                                    ?> 
</span>


<form id="allusers" action="" method="post">
    @csrf
    <button type="submit" class="btn btn-warning">
        تحضير الطلاب المحددين
    </button>
    <a href="{{route('course.shaikh.close',['id'=>$course_id])}}" onclick="return confirm('سيتم اغلاق الدورة نهائيا .. هل انت متأكد؟')" class="btn btn-danger float-end">
        اغلاق الدورة  
    </a>    
                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class="selectAll no-sort" scope="col"><input type="checkbox" class="chkbox" id="selectAll" ></th>
                                <th scope="col">اسم الطالب</th>
                                <th scope="col">الدولة</th>
                                <th scope="col">رقم الجوال</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allUsers as $key => $item)
                                    <?php 
                                    $usersName = DB::table(config('constants.tables.TBL_USERS'))->WHERE('id',$item->userid)->first();
                                    $country = DB::table(config('constants.tables.TBL_COUNTRIES'))->get();
                                    
                                    ?>
                            @if($usersName)     
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td><input type="checkbox" class="chkbox users-checkbox" value="{{$item->id}}" name="users_select[]" /></td>                                
                                <td>

                                    <a href="#" class="btn btn-sm ">  
                                    {{$usersName->name}} {{$usersName->lastname}}
                                    </a>

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
</form>                    
                    
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
