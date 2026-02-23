@extends('layouts.mainapp')

@section('content')

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>
                                    <ol class="breadcrumb m-0">
                                        @if(Request::segment(1) == 'settings')
                                        <li class="breadcrumb-item active">الإعدادات العامة</li>
                                        @elseif(Request::segment(1) == 'stats')
                                        <li class="breadcrumb-item active">الإحصائيات</li>
                                        @else
                                        <li class="breadcrumb-item active">الرئيسية</li>
                                        @endif
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                           
                            
                            <div class="col-12">

                                        @if(Request::segment(1) == 'settings')
                                        <div class="card">
                                            <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#settings" role="tab">
                                                    <span class="d-none d-md-block">الإعدادات العامة</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#contact" role="tab">
                                                    <span class="d-none d-md-block">تواصل معنا</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content mt-5 ">
                                            <div class="tab-pane active p-3" id="settings" role="tabpanel">
                                                <p class="card-title-desc text-danger">إعدادات عامة للمقرأة</p>

                                                <div class="row mb-3">
                                                    <label for="title" class="col-sm-2 col-form-label">اسم الموقع</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" id="title">
                                                    </div>
                                                </div>
        
                                                <p class="card-title-desc mt-5 text-danger ">إعدادات تدعم محركات البحث</p>


                                                <div class="row mb-3">
                                                    <label for="keywords" class="col-sm-2 col-form-label">الكلمات المفتاحية</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" rows="3" id="keywords"></textarea>
                                                    </div>
                                                </div>
        
                                                <div class="row mb-3">
                                                    <label for="keywords" class="col-sm-2 col-form-label">وصف الموقع</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" rows="3" id="keywords"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light">تعديل</button>
                                                </div>
                                            </div>
                                            <div class="tab-pane p-3" id="contact" role="tabpanel">

                                                <div class="row mb-3">
                                                    <label for="email" class="col-sm-2 col-form-label">البريد الإلكتروني</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text"  id="email">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="title" class="col-sm-2 col-form-label">رقم الجوال </label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" id="mobile">
                                                    </div>
                                                </div>
                                                 
                                                <div class="row mb-3">
                                                    <label for="facebook" class="col-sm-2 col-form-label">الفيس بوك</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" id="facebook">
                                                    </div>
                                                </div>
                                                 
                                                <div class="row mb-3">
                                                    <label for="x" class="col-sm-2 col-form-label">منصة اكس</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" id="x">
                                                    </div>
                                                </div>
                                                 
                                                <div class="row mb-3">
                                                    <label for="youtube" class="col-sm-2 col-form-label">يوتيوب</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" id="youtube">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light">تعديل</button>
                                                </div>

                                            </div>
                                         
                                        </div>
                                    </div>
                                </div>
                                        @elseif(Request::segment(1) == 'stats')
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-6">
                                            <form action="{{route('stats')}}" method="post" enctype='multipart/form-data'>
@csrf
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">الإحصائية الأولى</p>
                                                        <div class="row mb-3">
                                                            <label for="st_title1" class="col-sm-2 col-form-label">العنوان</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_title1; ?>" name="st_title1" id="st_title1">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_num1" class="col-sm-2 col-form-label">رقم الإحصائية</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_num1; ?>" name="st_num1" id="st_num1">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image1" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="file" name="st_image1" id="st_image1">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image1" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <img src="{{config('constants.path.PATH_ON_STS')}}<?= $data->st_image1; ?>" alt="" class="rounded avatar-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">الإحصائية الثانية</p>
                                                        <div class="row mb-3">
                                                            <label for="st_title2" class="col-sm-2 col-form-label">العنوان</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_title2; ?>" name="st_title2" id="st_title2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_num2" class="col-sm-2 col-form-label">رقم الإحصائية</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_num2; ?>" name="st_num2" id="st_num2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image2" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="file" name="st_image2" id="st_image2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image2" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <img src="{{config('constants.path.PATH_ON_STS')}}<?= $data->st_image2; ?>" alt="" class="rounded avatar-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">الإحصائية الثالثة</p>
                                                        <div class="row mb-3">
                                                            <label for="st_title3" class="col-sm-2 col-form-label">العنوان</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_title3; ?>" name="st_title3" id="st_title3">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_num3" class="col-sm-2 col-form-label">رقم الإحصائية</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_num3; ?>" name="st_num3" id="st_num3">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image3" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="file" name="st_image3" id="st_image3">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image3" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <img src="{{config('constants.path.PATH_ON_STS')}}<?= $data->st_image3; ?>" alt="" class="rounded avatar-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">الإحصائية الرابعة</p>
                                                        <div class="row mb-3">
                                                            <label for="st_title4" class="col-sm-2 col-form-label">العنوان</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_title4; ?>" name="st_title4" id="st_title4">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_num4" class="col-sm-2 col-form-label">رقم الإحصائية</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->st_num4; ?>" name="st_num4" id="st_num4">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image4" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="file" name="st_image4" id="st_image4">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="st_image4" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <img src="{{config('constants.path.PATH_ON_STS')}}<?= $data->st_image4; ?>" alt="" class="rounded avatar-sm">
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

</form>
                                        </div>
                                        </div>

                                        @else
                                        <div class="card">
                                            <div class="card-body">
                                                 مرحبا بك
                                            </div>
                                        </div>
                                        @endif

                        </div>
                        <!-- end row -->

@endsection
