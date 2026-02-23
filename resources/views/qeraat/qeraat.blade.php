@extends('layouts.mainapp')

@section('content')

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title">لوحة التحكم</h6>

                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{URL('/')}}">الرئيسية</a></li>
                                        <li class="breadcrumb-item"><a href="{{URL('/qeraat')}}">كل القراءات</a></li>
                                        @if(Request::segment(1) == 'qeraat' AND request()->route('id'))
                                            <li class="breadcrumb-item active">تعديل القرآءة</li>
                                        @elseif(Request::is('qeraat/new'))
                                            <li class="breadcrumb-item active">اضافة القرآءة</li>
                                        @endif
                                        
                                    </ol>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{route('qeraat.new')}}" class="btn btn-success">اضافة قراءة جديدة</a>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                            <div class="col-12">



@if(Request::segment(1) == 'qeraat' AND Request::segment(2) == 'show' AND request()->route('id'))
@if(sizeof($data) > 0)
<form action="{{route('qeraat.update', ['id' => request()->route('id')])}}" method="post" enctype='multipart/form-data'>
    @csrf
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">القراءة</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" value="<?= $dataById->name ?>" name="name">
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
                                                                    <input class="form-control" type="text" value="<?= $dataById->orders ?>" name="orders">
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

@elseif(Request::is('qeraat/new'))

<form action="{{route('qeraat.store')}}" method="post" enctype='multipart/form-data'>
    @csrf
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">القراءة</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" name="name">
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
                                                                    <input class="form-control" type="text" name="orders">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
    
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-2 col-form-label">تفعيل</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-check form-switch" type="checkbox" id="status" name="status" checked switch="dark">
                                                                    <label class="form-label" for="status" data-on-label="On" data-off-label="Off"></label>
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
                    
                    <table id="tabletheml" class="table table-hover table-striped table-nowrap mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">القراءات</th>
                                <th scope="col">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>
                                    <a href="{{route('qeraat.show', ['id' => $item->id])}}" class="btn btn-primary btn-sm">تعديل</a> -
                                    <a href="{{route('qeraat.destroy', ['id' => $item->id])}}" onclick="return confirm('هل انت متأكد')" class="btn btn-danger btn-sm">حذف</a> 
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
