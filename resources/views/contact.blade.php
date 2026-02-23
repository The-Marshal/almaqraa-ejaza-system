@extends('layouts.mainapp')

@section('content')
<style>
    .ltr {
        direction: ltr;
    }
</style>
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">بيانات التواصل</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                           
                            
                            <div class="col-12">

<form action="{{route('contact')}}" method="post" enctype='multipart/form-data'>
@csrf
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">تواصل معنا</p>
                                                        <div class="row mb-3">
                                                            <label for="title_mobile" class="col-sm-2 col-form-label">
                                                                عنوان 
اتصل بنا
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->title_mobile ?>" name="title_mobile">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="mobile" class="col-sm-2 col-form-label">
                                                                 
 رقم التواصل
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->mobile ?>" name="mobile">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="title_email" class="col-sm-2 col-form-label">
                                                                عنوان 
 راسلنا
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->title_email ?>" name="title_email">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="email" class="col-sm-2 col-form-label">
                                                                 
 البريد الإلكتروني
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->email ?>" name="email">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="title_visit" class="col-sm-2 col-form-label">
                                                                عنوان 
 زيارتنا
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->title_visit ?>" name="title_visit">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="visit" class="col-sm-2 col-form-label">
                                                                 
 الحي
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->visit ?>" name="visit">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <label for="map" class="col-sm-2 col-form-label">
                                                                 
 رابط الخريطة
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->map ?>" name="map">
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">الشبكات الإجتماعية</p>
<div class="row mb-3">
    <label for="fb" class="col-sm-2 col-form-label">رابط الفيس بوك</label>
    <div class="col-sm-10">
        <input class="form-control ltr" id="fb" type="text" value="<?= $data->fb ?>" name="fb">
    </div>
</div>
<div class="row mb-3">
    <label for="x" class="col-sm-2 col-form-label">رابط X </label>
    <div class="col-sm-10">
        <input class="form-control ltr" id="x" type="text" value="<?= $data->x ?>" name="x">
    </div>
</div>
<div class="row mb-3">
    <label for="yt" class="col-sm-2 col-form-label">رابط اليوتيوب </label>
    <div class="col-sm-10">
        <input class="form-control ltr" id="yt" type="text" value="<?= $data->yt ?>" name="yt">
    </div>
</div>
<div class="row mb-3">
    <label for="insta" class="col-sm-2 col-form-label">رابط الانستغرام </label>
    <div class="col-sm-10">
        <input class="form-control ltr" id="insta" type="text" value="<?= $data->insta ?>" name="insta">
    </div>
</div>
<div class="row mb-3">
    <label for="snap" class="col-sm-2 col-form-label">رابط السناب شات </label>
    <div class="col-sm-10">
        <input class="form-control ltr" id="snap" type="text" value="<?= $data->snap ?>" name="snap">
    </div>
</div>
<div class="row mb-3">
    <label for="whatsapp" class="col-sm-2 col-form-label">رابط الواتس اب </label>
    <div class="col-sm-10">
        <input class="form-control ltr" id="whatsapp" type="text" value="<?= $data->whatsapp ?>" name="whatsapp">
    </div>
</div>
<div class="row mb-3">
    <label for="telegram" class="col-sm-2 col-form-label">رابط التيليجرام </label>
    <div class="col-sm-10">
        <input class="form-control ltr" id="telegram" type="text" value="<?= $data->telegram ?>" name="telegram">
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

                            </div>
                        </div>
                        <!-- end row -->

@endsection
