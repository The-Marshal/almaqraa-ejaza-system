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
@if(Request::segment(3) == 'completed')
دورات مكتملة
@endif
</span>

@if(Request::segment(3) == 'completed' && Request::segment(3) == 'users')
                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الدورة</th>
                                <th scope="col">تاريخ الدورة</th>
                                <th scope="col">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td>

                                    <a href="#" class="btn btn-sm ">  
                                    {{$item->name}}
                                    </a>

                                    </td>
                                    
                                    <td>
                                      {{$item->created_at}}  
                                    </td>
                                    <td>
                                        @if(Request::segment(3) == 'new')
                                       <a href="{{route('course.shaikh.activate',['id'=>$item->id])}}" class="btn btn-warning">بدء الدورة</a>
                                       @elseif(Request::segment(3) == 'active')
                                       <a href="{{route('course.shaikh.presents',['id'=>$item->id])}}" class="btn btn-warning">عرض الطلاب والتحضير</a>
                                       @elseif(Request::segment(3) == 'completed')
                                       <a href="{{route('course.shaikh.completed.users',['id'=>$item->id])}}" class="btn btn-warning">عرض الطلاب </a>
                                       @endif
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
                                <th scope="col">الدورة</th>
                                <th scope="col">تاريخ الدورة</th>
                                <th scope="col">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td>

                                    <a href="#" class="btn btn-sm ">  
                                    {{$item->name}}
                                    </a>

                                    </td>
                                    
                                    <td>
                                      {{$item->created_at}}  
                                    </td>
                                    <td>
                                        @if(Request::segment(3) == 'new')
                                       <a href="{{route('course.shaikh.activate',['id'=>$item->id])}}" class="btn btn-warning">بدء الدورة</a>
                                       @elseif(Request::segment(3) == 'active')
                                       <a href="{{route('course.shaikh.presents',['id'=>$item->id])}}" class="btn btn-warning">عرض الطلاب والتحضير</a>
                                       @elseif(Request::segment(3) == 'completed')
                                       <a href="{{route('course.shaikh.completed.users',['id'=>$item->id])}}" class="btn btn-warning">عرض الطلاب </a>
                                       @endif
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
