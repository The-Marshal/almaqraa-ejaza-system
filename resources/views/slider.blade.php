@extends('layouts.mainapp')

@section('content')

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('slider')}}">السلايدر</a></li>
                                        @if(Request::segment(1) == 'slider' AND request()->route('id'))
                                            <li class="breadcrumb-item active">تعديل دورة </li>
                                        @elseif(Request::is('slider/new'))
                                            <li class="breadcrumb-item active">اضافة سلايدر </li>
                                        @else
                                            <li class="breadcrumb-item active">كل السلايدات</li>
                                        @endif
                                        
                                    </ol>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{route('slider.new')}}" class="btn btn-success">اضافة سلايدر جديد</a>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">



@if(Request::segment(1) == 'slider' AND Request::segment(2) == 'show' AND request()->route('id'))
@if($dataById)

@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<div class="alert alert-info" role="alert">
  الطول: 400 بكسل
  /
  العرض: 1116 بكسل
</div>

<form action="{{route('slider.update', ['id' => request()->route('id')])}}" method="post" enctype='multipart/form-data'>
    @csrf
                                            <div class="row">
 
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="title" class="col-sm-2 col-form-label">عنوان السلايد </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" value="<?= $dataById->title ?>" required id="title" name="title">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    


                                                

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                           
                                                            
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">الصورة  </label>
                                                                <div class="col-sm-8">
                                        <input type="file" class="form-control" name="image">
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <a href="{{config('constants.path.PATH_SLIDER')}}<?= $dataById->image ?>" target="_blank">
                                                                    <img src="{{config('constants.path.PATH_SLIDER')}}<?= $dataById->image ?>"  class="img-fluid rounded" alt="" title=""></a>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="orders" class="col-sm-2 col-form-label">الترتيب</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" value="<?= $dataById->orders ?>" id="orders" name="orders">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="status" class="col-sm-2 col-form-label">الحالة</label>
                                                                <div class="col-sm-10">

                                         <input class="form-check form-switch" type="checkbox" name="status" id="status" @if($dataById->status == 'yes') checked @endif switch="none">
                                            <label class="form-label" for="status" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

    
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل</button>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
     </form>
    
     @else
     <div class="alert alert-danger" role="alert">
         لاتوجد بيانات
     </div>
     @endif

@elseif(Request::is('slider/new'))
@if($errors->any())
    {{ implode('', $errors->all('<div class="alert alert-danger">:message</div>')) }}
@endif
<form action="{{route('slider.store')}}" method="post" enctype='multipart/form-data'>
    @csrf
                                            <div class="row">
                                       
                                                
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="title" class="col-sm-2 col-form-label">العنوان </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" {{ old("title") }} id="title" required name="title">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="objects" class="col-sm-2 col-form-label">الصورة</label>
                                                                <div class="col-sm-10">
                                                                    <input type="file" class="form-control" required name="image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="orders" class="col-sm-2 col-form-label">الترتيب</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" {{ old("orders") }} id="orders" name="orders">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="status" class="col-sm-2 col-form-label">الحالة</label>
                                                                <div class="col-sm-10">

                                         <input class="form-check form-switch" type="checkbox" name="status" id="status" checked switch="none">
                                            <label class="form-label" for="status" data-on-label="مفعل" data-off-label="غير مفعل"></label>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

    
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">اضافة</button>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
     </form>

@else
@if(sizeof($data) > 0)

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">العنوان </th>
                                <th scope="col">الصورة </th>
                                <th scope="col">الترتيب</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{$item->title}}</td>
                                <td>
                                    <a href="{{config('constants.path.PATH_SLIDER')}}<?= $item->image ?>" target="_blank">
                                    <img style="width:200px;" src="{{config('constants.path.PATH_SLIDER')}}<?= $item->image ?>"  class="img-thumbnail" alt="" title=""></a>
                                </td>
                                <td>{{$item->orders}}</td>
                                <td>
                                    @if($item->status == 'yes')
                                    <span class="badge bg-primary">مفعل</span>
                                    @else
                                        <span class="badge bg-danger">غير مفعل</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('slider.show', ['id' => $item->id])}}" class="btn btn-primary btn-sm">تعديل</a> -
                                    <a href="{{route('slider.destroy', ['id' => $item->id])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">حذف</a> 
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

@endif





                            </div>
                        </div>
                        <!-- end row -->

@endsection
