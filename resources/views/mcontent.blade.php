@extends('layouts.mainapp')

@section('content')
<?php
$path = 'https://almaqraa.net/uploads/about/';
?>
                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h6 class="page-title">لوحة التحكم</h6>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">محتوى المقرأة</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            
                           
                            
                            <div class="col-12">

<form action="{{route('mcontnt')}}" method="post" enctype='multipart/form-data'>
@csrf
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">المقرأة القرآنية</p>
                                                        <div class="row mb-3">
                                                            <label for="title1" class="col-sm-2 col-form-label">العنوان</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->title1 ?>" name="title1">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="desc1" class="col-sm-2 col-form-label">المحتوى</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" name="desc1" rows="3"><?= $data->desc1 ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="image1" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="file" name="image1" id="image1">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="image1" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <img src="<?= $path.$data->image1 ?>" alt="" class="rounded avatar-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">الدورات القرآنية</p>
                                                        <div class="row mb-3">
                                                            <label for="title2" class="col-sm-2 col-form-label">العنوان</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->title2 ?>" name="title2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="desc2" class="col-sm-2 col-form-label">المحتوى</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" name="desc2" rows="3"><?= $data->desc2 ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="image2" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="file" name="image2" id="image2">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="image2" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <img src="<?= $path.$data->image2 ?>" alt="" class="rounded avatar-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="card-title">برنامج الإجازة القرآنية</p>
                                                        <div class="row mb-3">
                                                            <label for="title3" class="col-sm-2 col-form-label">العنوان</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" value="<?= $data->title3 ?>" name="title3">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="desc3" class="col-sm-2 col-form-label">المحتوى</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" name="desc3" rows="3"><?= $data->desc3 ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="image3" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="file" name="image3" id="image3">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label for="image3" class="col-sm-2 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                <img src="<?= $path.$data->image3 ?>" alt="" class="rounded avatar-sm">
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
